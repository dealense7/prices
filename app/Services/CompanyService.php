<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\CompanyRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class CompanyService
{
    public function __construct(
        private readonly CompanyRepositoryContract $repository,
    ) {
        //
    }

    public function findItems(array $filters = [], ?string $sort = null): Collection
    {
        return $this->repository->findItems($filters, $sort);
    }
}
