<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Category;
use App\Support\Collection;

interface CategoryRepositoryContract
{
    public function findItems(array $filters = [], ?string $sort = null): Collection;

    public function findById(int $id): ?Category;
}
