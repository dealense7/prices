<?php

declare(strict_types=1);

namespace App\Services\V1;

use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Contracts\Services\CategoryServiceContract;
use App\Exceptions\ItemNotFoundException;
use App\Models\Category\Category;
use App\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService implements CategoryServiceContract
{
    public function __construct(
        private readonly CategoryRepositoryContract $repository,
    ) {
        //
    }

    public function findItems(
        array $filters = [],
        int $page = 1,
        ?int $perPage = null,
        ?string $sort = null,
    ): LengthAwarePaginator {
        return $this->repository->findItems($filters, $page, $perPage, $sort);
    }

    public function getAllItems(array $filters = []): Collection
    {
        return $this->repository->getAllItems($filters);
    }

    public function findById(int $id): ?Category
    {
        $item = $this->repository->findById($id);

        if (empty($item)) {
            return null;
        }

        return $item;
    }

    public function findByIdOrFail(int $id): Category
    {
        $item = $this->findById($id);

        if (!$item) {
            throw new ItemNotFoundException();
        }

        return $item;
    }

    public function create(array $data): Category
    {
        return $this->repository->create($data);
    }

    public function update(Category $item, array $data): Category
    {
        return $this->repository->update($item, $data);
    }

    public function delete(Category $item): void
    {
        $this->repository->delete($item);
    }
}
