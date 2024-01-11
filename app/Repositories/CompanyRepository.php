<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\CompanyRepositoryContract;
use App\Models\Company;
use App\Support\Collection;

class CompanyRepository implements CompanyRepositoryContract
{
    public function findItems(array $filters = [], ?string $sort = null): Collection
    {

        $model = $this->getModel();
        $items = $model->filterByKeyword($filters);

        foreach ($model->parseSort($sort) as $column => $direction) {
            $items = $items->orderBy($column, $direction);
        }
        $items = $items->orderBy('id', 'desc');

        return $items->get();
    }

    public function findById(int $id): ?Company
    {
        /** @var Company|null $item */
        $item = $this->getModel()->query()->where('id', $id)->first();

        return $item;
    }

    public function update(Company $item, array $data): Company
    {
        $item->fill($data);

        $item->saveOrFail();

        return $item;
    }

    public function create(array $data): Company
    {
        return $this->update($this->getModel(), $data);
    }

    public function getModel(): Company
    {
        return new Company();
    }
}
