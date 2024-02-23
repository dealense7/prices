<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DataTransferObjects\ProductDto;
use App\Enums\Languages;
use App\Enums\TagType;
use App\Models\Company;
use App\Models\File;
use App\Models\Product\Product;
use App\Models\Product\ProductTranslation;
use App\Models\Tag\Tag;
use App\Models\Tag\TagTranslation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SaveFetchedProduct implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly array $items,
        private readonly int $storeId,
        private readonly int $categoryId,
        private readonly int $parentCategoryId,
        private readonly string $text,
    ) {
    }

    public function handle(): void
    {
        $productCodes = Arr::pluck($this->items, 'code');
        $products     = $this->getProductByCode($productCodes);

        $items = collect($this->items)->whereNotIn('code', $products->pluck('code')->toArray());

        if (count($this->items) === 0) {
            dump($this->text);
        }

        DB::transaction(function () use ($items) {
            /** @var \App\DataTransferObjects\ProductDto $item */
            foreach ($items as $item) {
                $productId = $this->createProduct($item);

                if (!empty($item->imageUrl)) {
                    $this->downloadImage($productId, $item->code, $item->imageUrl);
                }
            }
        });
    }

    private function getProductByCode(array $codes): Collection
    {
        return DB::table((new Product())->getTable())
            ->select(['id', 'code', 'deleted_at'])
            ->whereIn('code', $codes)
            ->get();
    }

    private function createProduct(ProductDto $item): int
    {
        $productId = DB::table((new Product())->getTable())
            ->insertGetId([
                'code' => $item->code,
            ]);

        $this->createTranslations($productId, $item->name);
        $this->createCompany($productId, $item->companyName);
        $this->createCategory($productId);
        $this->createTag($productId, $item->tag, $item->tagName);

        return $productId;
    }

    private function createTranslations(int $productId, string $name): void
    {
        DB::table((new ProductTranslation())->getTable())
            ->insert([
                'product_id'  => $productId,
                'language_id' => Languages::Georgian->value,
                'name'        => $name,
            ]);
    }

    private function createTag(
        int $productId,
        ?string $tag,
        ?string $tagName,
    ): void {

        if (!empty($tag) && !empty($tagName)) {
            if ($tagName === 'გ') {
                $tagName = 'გრ';
            } elseif (in_array($tagName, ['ლ', 'კგ'], true) && floatval($tag) < 1) {
                $tag     = intval($tag * 100);
                $tagName = $tagName === 'ლ' ? 'მლ' : 'გრ';
            }

            /** @var \App\Models\Tag\TagTranslation|null $tagTranslation */
            $tagTranslation = DB::table((new TagTranslation())->getTable())->where('name', $tag.' '.$tagName)->first();
            $tagId          = $tagTranslation?->tag_id;

            if ($tagId === null) {
                $type = TagType::Quantity;

                if (in_array($tagName, ['გრ', 'კგ'])) {
                    $type = TagType::Weight;
                }

                if (in_array($tagName, ['მლ', 'ლ'])) {
                    $type = TagType::Size;
                }

                if (in_array($tagName, ['ც'])) {
                    $type = TagType::Quantity;
                }

                $tagId = DB::table((new Tag())->getTable())->insertGetId([
                    'type'      => $type->value,
                    'parent_id' => $type->value,
                ]);

                DB::table((new TagTranslation())->getTable())
                    ->insert([
                        'tag_id'      => $tagId,
                        'language_id' => Languages::Georgian->value,
                        'name'        => $tag.' '.$tagName,
                    ]);
            }

            DB::table((new Product())->tags()->getTable())
                ->insert([
                    'product_id' => $productId,
                    'tag_id'     => $tagId,
                ]);
        }
    }

    private function createCompany(
        int $productId,
        ?string $companyName = null,
    ): void {
        if ($companyName) {
            $companyId = DB::table((new Company())->getTable())->where('name', $companyName)->first()?->id;

            if ($companyId === null) {
                $companyId = DB::table((new Company())->getTable())->insertGetId(['name' => $companyName]);
            }

            if ($companyId) {
                DB::table((new Product())->getTable())->where('id', $productId)
                    ->update([
                        'company_id' => $companyId,
                    ]);
            }
        }
    }

    private function createCategory(int $productId,): void
    {
        DB::table((new Product())->categories()->getTable())
            ->insert([
                'product_id'         => $productId,
                'category_id'        => $this->categoryId,
                'parent_category_id' => $this->parentCategoryId,
            ]);
    }

    private function downloadImage(
        int $productId,
        int $code,
        string $url,
    ): void {
        if (empty($url)) {
            return;
        }

        $extension = null;
        $urlLower  = strtolower($url);

        if (str_contains($urlLower, 'jpg')) {
            $extension = 'jpg';
        } elseif (str_contains($urlLower, 'jpeg')) {
            $extension = 'jpeg';
        } elseif (str_contains($urlLower, 'png')) {
            $extension = 'png';
        } elseif (str_contains($urlLower, 'webp')) {
            $extension = 'webp';
        }

        if ($extension !== null) {
            try {
                $imageContent = file_get_contents($url);

                if ($imageContent) {
                    $filename = $code.'.'.$extension;

                    Storage::disk('public')->put('products'.'/'.$filename, $imageContent);

                    $diskUrl = Storage::disk('public')->path('products'.'/'.$filename);

                    $data = [
                        'name'          => $filename,
                        'path'          => 'products'.'/'.$filename,
                        'size'          => filesize($diskUrl),
                        'extension'     => $extension,
                        'fileable_id'   => $productId,
                        'fileable_type' => Product::class,
                    ];

                    DB::table((new File())->getTable())->insert($data);
                }
            } catch (Throwable $e) {
            }
        }
    }
}
