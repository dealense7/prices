<?php

declare(strict_types=1);

namespace App\CacheRepositories\V1;

use App\CacheRepositories\CacheRepository;
use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Models\Category\Category;
use App\Repositories\V1\CategoryRepository;
use App\Support\Collection;
use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryCacheRepository extends CacheRepository implements CategoryRepositoryContract
{
    protected string $cacheKey = Category::class;

    private CategoryRepository $repository;

    public function __construct(CacheContract $cache, CategoryRepository $repository)
    {
        $this->cache      = $cache;
        $this->repository = $repository;
    }

    public function findItems(
        array $filters = [],
        int $page = 1,
        ?int $perPage = null,
        ?string $sort = null,
    ): LengthAwarePaginator {
        $key = $this->createKeyFromArgs([
            func_get_args(),
        ], 'findItems');

        return $this->setTag()->remember($key, function () use ($filters, $page, $perPage, $sort) {
            return $this->repository->findItems($filters, $page, $perPage, $sort);
        });
    }

    public function getAllItems(array $filters = []): Collection
    {
        $key = $this->createKeyFromArgs([
            func_get_args(),
        ], 'getAllItems');

        return $this->setTag()->remember($key, function () use ($filters,) {
            return $this->repository->getAllItems($filters);
        });
    }

    public function findById(int $id): ?Category
    {
        $key = $this->createKeyFromArgs([
            'id' => $id,
        ], 'item');

        return $this->setTag()->remember($key, function () use ($id) {
            return $this->repository->findById($id);
        });
    }

    public function create(array $data): Category
    {
        $item = $this->repository->create($data);

        $key = $this->createKeyFromArgs([
            'id' => $item->getId(),
        ], 'item');

        $this->forget($key);

        return $this->setTag()->remember($key, static function () use ($item) {
            return $item;
        });
    }

    public function update(Category $item, array $data): Category
    {
        $key = $this->createKeyFromArgs([
            'id' => $item->getId(),
        ], 'item');

        $this->clearByTag();

        return $this->setTag()->remember($key, function () use ($item, $data) {
            return $this->repository->update($item, $data);
        });
    }

    public function delete(Category $item): void
    {
        $this->repository->delete($item);

        $this->clearByTag();
    }
}
