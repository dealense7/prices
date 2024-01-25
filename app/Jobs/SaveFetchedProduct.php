<?php

namespace App\Jobs;

use App\DataTransferObjects\ProductDto;
use App\Enums\Languages;
use App\Enums\TagType;
use App\Models\Category\Category;
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

class SaveFetchedProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly array $items,
        private readonly int $storeId,
        private readonly int $providerId
    ) {
    }


    public function handle(): void
    {
        $productCodes = Arr::pluck($this->items, 'code');
        $products     = $this->getProductByCode($productCodes);

        DB::transaction(function () use ($products) {
            /** @var ProductDto $item */
            foreach ($this->items as $item) {
                if ($products->firstWhere('code', $item->code) === null) {
                    try {
                        $productId = $this->createProduct($item);
                        $this->downloadImage($productId, $item->imageUrl);
                    } catch (\Exception $e) {
                        dump($e->getMessage());
                        dd($item);
                    }
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
        $this->createTag($productId, $item->tag, $item->tagName);
        $this->createCompany($productId, $item->companyName);

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

    private
    function createTag(
        int $productId,
        ?string $tag,
        ?string $tagName
    ): void {
        $tagId = TagType::Quantity;

        if (!empty($tag) && !empty($tagName)) {
            /** @var TagTranslation|null $tagTranslation */
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

                $tagId = DB::table((new Tag())->getTable())->insertGetId([
                    'type'      => $type->value,
                    'parent_id' => $type->value
                ]);

                DB::table((new TagTranslation())->getTable())
                    ->insert([
                        'tag_id'      => $tagId,
                        'language_id' => Languages::Georgian->value,
                        'name'        => $tag.' '.$tagName,
                    ]);
            }
        }

        DB::table((new Product())->tags()->getTable())
            ->insert([
                'product_id' => $productId,
                'tag_id'     => $tagId
            ]);
    }

    private
    function createCompany(
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
                        'id'         => $productId,
                        'company_id' => $companyId
                    ]);
            }

        }
    }

    private
    function downloadImage(
        int $productId,
        string $url
    ): void {
        if (empty($url)){
            return;
        }
        $extension = null;

        if (str_contains(strtolower($url), 'jpg')) {
            $extension = 'jpg';
        }

        if (str_contains(strtolower($url), 'jpeg')) {
            $extension = 'jpeg';
        }

        if (str_contains(strtolower($url), 'png')) {
            $extension = 'png';
        }

        if (str_contains(strtolower($url), 'webp')) {
            $extension = 'webp';
        }

        if ($extension !== null) {

            try {
                $imageContent = file_get_contents($url);

                if ($imageContent) {
                    $filename = uniqid().'.'.$extension;

                    Storage::disk('public')->put('products'.'/'.$filename, $imageContent);

                    $diskUrl = Storage::disk('public')->path('products'.'/'.$filename);


                    DB::table((new File())->getTable())->insert([
                        'name'          => $filename,
                        'path'          => 'products'.'/'.$filename,
                        'size'          => filesize($diskUrl),
                        'extension'     => $extension,
                        'fileable_id'   => $productId,
                        'fileable_type' => Product::class,
                    ]);
                }
            } catch (\Exception $e) {

            }
        }
    }
}
