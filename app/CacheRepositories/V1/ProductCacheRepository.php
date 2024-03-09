<?php

declare(strict_types=1);

namespace App\CacheRepositories\V1;

use App\CacheRepositories\CacheRepository;
use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Contracts\Repositories\ProductRepositoryContract;
use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Repositories\V1\CategoryRepository;
use App\Repositories\V1\ProductRepository;
use App\Support\Collection;
use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class ProductCacheRepository extends CacheRepository implements ProductRepositoryContract
{
    protected string $cacheKey = Product::class;

    private ProductRepository $repository;

    public function __construct(CacheContract $cache, ProductRepository $repository)
    {
        $this->cache      = $cache;
        $this->repository = $repository;
    }

    /**
     * @throws ValidationException
     */
    public function findItems(
        array $filters = [],
        int $page = 1,
        ?int $perPage = null,
        ?string $sort = null,
    ): LengthAwarePaginator {
        $key = $this->createKeyFromArgs([
            func_get_args(),
        ], 'findItems');

//        return $this->setTag()->remember($key, function () use ($filters, $page, $perPage, $sort) {
            return $this->repository->findItems($filters, $page, $perPage, $sort);
//        });
    }

    public function getProductsGroupedByCategory(): Collection
    {
        $key = $this->createKeyFromArgs([], 'productsGroupedByCategory');

        return $this->setTag()->remember($key, function () {
            return $this->repository->getProductsGroupedByCategory();
        }, 15);
    }

    public function getProducts(array $filters = [], int $page = 1): LengthAwarePaginator
    {
        $key = $this->createKeyFromArgs([
            func_get_args(),
        ], 'getProducts');

        return $this->setTag()->remember($key, function () use ($filters) {
            return $this->repository->getProducts($filters);
        });
    }

    public function findById(int $id): ?Product
    {
        $key = $this->createKeyFromArgs([
            'id' => $id,
        ], 'item');

        return $this->setTag()->remember($key, function () use ($id) {
            return $this->repository->findById($id);
        });
    }

    public function getProductsList(array $filters = []): Collection
    {
        $key = $this->createKeyFromArgs([
            func_get_args(),
        ], 'getProductsList');

        return $this->setTag()->remember($key, function () use ($filters) {
            return $this->repository->getProductsList($filters);
        });
    }

    public function update(Product $item, array $data): Product
    {
        $key = $this->createKeyFromArgs([
            'id' => $item->getId(),
        ], 'item');

        $this->clearByTag();

        return $this->setTag()->remember($key, function () use ($item, $data) {
            return $this->repository->update($item, $data);
        });
    }

    public function createOrUpdateTranslation(Product $item, array $data): Product
    {
        $key = $this->createKeyFromArgs([
            'id' => $item->getId(),
        ], 'item');

        $this->clearByTag();

        return $this->setTag()->remember($key, function () use ($item, $data) {
            return $this->repository->createOrUpdateTranslation($item, $data);
        });
    }

    public function syncCategories(Product $item, array $ids): Product
    {
        $key = $this->createKeyFromArgs([
            'id' => $item->getId(),
        ], 'item');

        $this->clearByTag();

        return $this->setTag()->remember($key, function () use ($item, $ids) {
            return $this->repository->syncCategories($item, $ids);
        });
    }

    public function syncTags(Product $item, array $ids): Product
    {
        $key = $this->createKeyFromArgs([
            'id' => $item->getId(),
        ], 'item');

        $this->clearByTag();

        return $this->setTag()->remember($key, function () use ($item, $ids) {
            return $this->repository->syncTags($item, $ids);
        });
    }
}
