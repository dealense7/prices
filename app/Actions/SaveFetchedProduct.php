<?php

declare(strict_types=1);

namespace App\Actions;

use App\DataTransferObjects\ProductDto;
use App\Enums\Category\SubCategory;
use App\Enums\Languages;
use App\Enums\TagType;
use App\Models\Company;
use App\Models\File;
use App\Models\Product\BarCode;
use App\Models\Product\Product;
use App\Models\Product\ProductTranslation;
use App\Models\Tag\Tag;
use App\Models\Tag\TagTranslation;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SaveFetchedProduct
{
    public static function process(array $items, int $storeId): void
    {
        // Fetch products that I have saved with same barCode
        // So I can prevent duplicate products in my DB
        $productCodes = Arr::pluck($items, 'code');
        $products     = self::getProductByCode($productCodes);

        // Generate list for process, so here will be only new products that I don't have in my DB
        $items = collect($items)->whereNotIn('code', $products->pluck('codes.*.code')->flatten()->toArray());

        DB::transaction(static function () use ($items) {
            /** @var \App\DataTransferObjects\ProductDto $item */
            foreach ($items as $item) {
                $productId = self::createProduct($item);

                if (! empty($item->imageUrl)) {
                    self::downloadImage($productId, $item->code, $item->imageUrl);
                }
            }
        });
    }

    private static function getProductByCode(array $codes): Collection
    {
        return Product::withTrashed()
            ->select(['id', 'deleted_at'])
            ->with([
                'codes' => static function ($query) use ($codes) {
                    $query->whereIn('code', $codes);
                },
            ])->whereHas('codes', static function (Builder $query) use ($codes) {
                $query->whereIn('code', $codes);
            })
            ->get();
    }

    private static function createProduct(ProductDto $item): int
    {
        $productId = DB::table((new Product())->getTable())
            ->insertGetId([]);

        DB::table((new BarCode())->getTable())
            ->insert([
                'product_id' => $productId,
                'code'       => $item->code,
            ]);

        self::createTranslations($productId, $item->name);
        self::createCompany($productId, $item->companyName);
        self::createTag($productId, $item->tag, $item->tagName);
        self::createCategory($productId, $item->categoryId);

        return $productId;
    }

    private static function createCategory(int $productId, ?int $categoryId): void
    {
        if ($categoryId) {
            $category = SubCategory::from($categoryId);
            DB::table((new Product())->categories()->getTable())
                ->insert([
                    'product_id'         => $productId,
                    'category_id'        => $categoryId,
                    'parent_category_id' => $category->getData()['parent_id'],
                ]);
        }
    }

    private static function createTranslations(int $productId, string $name): void
    {
        // At this time I don't care about translations I will edit this little late
        DB::table((new ProductTranslation())->getTable())
            ->insert([
                'product_id'  => $productId,
                'language_id' => Languages::Georgian->value,
                'name'        => $name,
            ]);
    }

    private static function createTag(
        int $productId,
        ?string $tag,
        ?string $tagName,
    ): void {

        if (! empty($tag) && ! empty($tagName)) {
            if ($tagName === 'გ') {
                $tagName = 'გრ';
            } elseif (in_array($tagName, ['ლ', 'კგ'], true) && floatval($tag) < 1) {
                $tag     = intval($tag * 100);
                $tagName = $tagName === 'ლ' ? 'მლ' : 'გრ';
            }

            /** @var \App\Models\Tag\TagTranslation|null $tagTranslation */
            $tagTranslation = DB::table((new TagTranslation())->getTable())->where('name', $tag . ' ' . $tagName)->first();
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
                        'name'        => $tag . ' ' . $tagName,
                    ]);
            }

            DB::table((new Product())->tags()->getTable())
                ->insert([
                    'product_id' => $productId,
                    'tag_id'     => $tagId,
                ]);
        }
    }

    private static function createCompany(
        int $productId,
        ?string $companyName = null,
    ): void {
        // I will create company with any random name to save time while validate data
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

    private static function downloadImage(
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
                    $filename = $code . '.' . $extension;

                    Storage::disk('public')->put('products' . '/' . $filename, $imageContent);

                    $diskUrl = Storage::disk('public')->path('products' . '/' . $filename);

                    $data = [
                        'name'          => $filename,
                        'path'          => 'products' . '/' . $filename,
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
