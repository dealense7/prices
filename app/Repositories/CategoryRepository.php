<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Models\Category\Category;
use App\Support\Collection;

class CategoryRepository implements CategoryRepositoryContract
{
    public function findItems(array $filters = [], ?string $sort = null): Collection
    {

        $model = $this->getModel();
        $items = $model->filterByKeyword($filters)
            ->with([
                'translation',
                'children.translation'
            ])
            ->whereNull('parent_id');

        foreach ($model->parseSort($sort) as $column => $direction) {
            $items = $items->orderBy($column, $direction);
        }
        $items = $items->orderBy('id', 'desc');

        return $items->get();
    }

    public function findById(int $id): ?Category
    {
        /** @var Category|null $item */
        $item = $this->getModel()->query()->where('id', $id)->first();

        return $item;
    }

    public function getModel(): Category
    {
        return new Category();
    }
}
