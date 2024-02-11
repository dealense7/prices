<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\TagRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class TagService
{
    public function __construct(
        private readonly TagRepositoryContract $repository,
    ) {
        //
    }

    public function findItems(array $filters = [], ?string $sort = null): Collection
    {
        return $this->repository->findItems($filters, $sort);
    }
}
