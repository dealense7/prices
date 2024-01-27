<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\ProductRepositoryContract;
use App\Models\Category\Category;
use App\Models\File;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class ProductRepository implements ProductRepositoryContract
{
    /**
     * @throws ValidationException
     */
    public function findItems(
        array $filters = [],
        int $page = 1,
        ?int $perPage = null,
        ?string $sort = null
    ): LengthAwarePaginator {
        $model             = $this->getModel();
        $productPriceModel = $this->getProductPriceModel();
        $productPriceTable = $this->getProductPriceModel()->getTable();

        $products = $productPriceModel->query()
            ->selectRaw($productPriceTable.'.product_id, COUNT('.$productPriceTable.'.product_id) AS count')
            ->join((new File())->getTable(), $productPriceTable.'.product_id', '=', 'files.fileable_id')
            ->join((new Product())->getTable(), $productPriceTable.'.product_id', '=', 'products.id')
            ->whereNull('products.deleted_at')
            ->where('files.fileable_type', Product::class)
            ->groupBy($productPriceTable.'.product_id')
            ->having('count', '>', 1)
            ->paginate($model->getValidPerPage($perPage), ['*'], 'page', $page);

        $productIds = collect($products->items())->pluck('product_id')->toArray();

        $items = $model
            ->filterByKeyword($filters)
            ->with([
                'categories.translation',
                'tags.translation',
                'images'
            ])
            ->whereIn('id', $productIds);

        foreach ($model->parseSort($sort) as $column => $direction) {
            $items = $items->orderBy($column, $direction);
        }
        $items = $items->orderBy('id', 'desc')->get();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $products->total(),
            $products->perPage(),
            $products->currentPage(),
            ['path' => 'dashboard']
        );
    }


    public function getProductsGroupedByCategory(): Collection
    {

        $items = Category::query()
//            ->whereHas('products', static function ($query) {
//                $query->where('show', true);
//            })
            ->whereNull('parent_id')
            ->withCount('allProducts')
//            ->orderByDesc('all_products_count')
            ->limit(4)
            ->has('allProducts', '>=', 12)
            ->get()
            ->each(function ($item) {
                $item->load([
                    'allProducts' => static function ($query) {
                        $query
                            ->select('id')
//                            ->where('show', true)
//                            ->orderByRaw('(SELECT MAX(price) - MIN(price) FROM product_prices WHERE product_id = products.id AND created_at > "'.now()->subDay()->toDateString().'") DESC')
                            ->take(12);
                    }
                ]);
            });

        $products = Product::query()
            ->with([
                'categories',
                'tags',
                'company',
                'prices',
                'images'
            ])
            ->whereIn('id', $items->pluck('allProducts.*.id')->flatten()->toArray())
            ->get();

        /** @var Category $item */
        foreach ($items as $item) {
            $categoryId = $item->id;

            $item->setRelation('allProducts', $products->filter(function ($product) use ($categoryId) {
                return $product->categories->pluck('parent_id')->contains($categoryId);
            }));
        }

        return $items;
    }

    public function findById(int $id): ?Product
    {
        /** @var Product|null $item */
        $item = $this->getModel()
            ->query()
            ->with([
                'prices.store.logo'
            ])
            ->where('id', $id)->first();

        return $item;
    }

    public function update(Product $item, array $data): Product
    {
        $item->fill($data);
        $item->saveOrFail();

        $item->load([
            'categories',
            'tags',
            'images'
        ]);

        return $item;
    }

    public function syncCategories(Product $item, array $ids): Product
    {
        $item->categories()->sync($ids);

        $item->load([
            'categories',
            'tags',
            'images'
        ]);

        return $item;
    }

    public function syncTags(Product $item, array $ids): Product
    {
        $item->tags()->sync($ids);

        $item->load([
            'categories',
            'tags',
            'images'
        ]);

        return $item;
    }

    public function getModel(): Product
    {
        return new Product();
    }

    public function getProductPriceModel(): ProductPrice
    {
        return new ProductPrice();
    }
}


