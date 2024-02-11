<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Tag\Tag;
use App\Support\Collection;

interface TagRepositoryContract
{
    public function findItems(array $filters = [], ?string $sort = null): Collection;

    public function findById(int $id): ?Tag;
}
