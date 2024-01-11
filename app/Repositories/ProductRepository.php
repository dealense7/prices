<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\ProductRepositoryContract;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
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
                'categories',
                'tags',
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
            ->whereHas('products', static function ($query) {
                $query->where('show', true);
            })
            ->withCount('products')
            ->orderByDesc('products_count')
            ->get()
            ->each(function ($item) {
                $item->load([
                    'products' => static function ($query) {
                        $query
                            ->with([
                                'categories',
                                'tags',
                                'company',
                                'prices',
                                'images'
                            ])
                            ->where('show', true)
                            ->orderByRaw('(SELECT MAX(price) - MIN(price) FROM product_prices WHERE product_id = products.id) DESC')
                            ->take(12);
                    }
                ]);
            });

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
