<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\CategoryRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryContract $repository,
    ) {
        //
    }

    public function findItems(array $filters = [], ?string $sort = null): Collection
    {
        return $this->repository->findItems($filters, $sort);
    }
}
