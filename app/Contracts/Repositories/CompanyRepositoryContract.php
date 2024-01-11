<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Company;
use App\Support\Collection;

interface CompanyRepositoryContract
{
    public function findItems(array $filters = [], ?string $sort = null): Collection;

    public function findById(int $id): ?Company;

    public function create(array $data): Company;
}
