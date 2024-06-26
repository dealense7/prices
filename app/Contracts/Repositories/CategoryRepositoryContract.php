<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Category\Category;
use App\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoryRepositoryContract
{
    public function findItems(
        array $filters = [],
        int $page = 1,
        ?int $perPage = null,
        ?string $sort = null,
    ): LengthAwarePaginator;

    public function getAllItems(array $filters = []): Collection;

    public function findById(int $id): ?Category;

    public function create(array $data): Category;

    public function update(Category $item, array $data): Category;

    public function delete(Category $item): void;
}
