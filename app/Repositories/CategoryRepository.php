<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Models\Category\Category;
use App\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryRepository extends Repository implements CategoryRepositoryContract
{
    public function findItems(
        array $filters = [],
        int $page = 1,
        ?int $perPage = null,
        ?string $sort = null,
    ): LengthAwarePaginator {

        $model = $this->getModel();

        $items = $this->getData($filters)
            ->with([
                'translation',
                'children.translation',
            ])
            ->whereNull('parent_id');

        foreach ($model->parseSort($sort) as $column => $direction) {
            $items = $items->orderBy($column, $direction);
        }
        $items = $items->orderBy('id', 'desc');

        return $items->paginate($model->getValidPerPage($perPage), ['*'], 'page', $page);
    }

    public function getAllItems(array $filters = []): Collection
    {
        /** @var Collection $items */
        $items = $this->getData($filters)
            ->with([
                'translation',
                'children.translation',
            ])
            ->whereNull('parent_id')->get();

        return $items;
    }

    public function findById(int $id): ?Category
    {
        /** @var \App\Models\Category\Category|null $item */
        $item = $this->getModel()->query()
            ->with([
                'translation',
                'children.translation',
            ])
            ->where('id', $id)->first();

        return $item;
    }

    public function create(array $data): Category
    {
        return $this->update($this->getModel(), $data);
    }

    public function update(Category $item, array $data): Category
    {
        $item->fill($data);
        $item->saveOrFail();

        $item->load([
            'translation',
            'children.translation',
        ]);

        return $item;
    }

    public function delete(Category $item): void
    {
        $item->translations()->delete();
        $item->products()->detach();
        $item->allProducts()->detach();

        foreach ($item->children as $child) {
            $child->translations()->delete();
            $child->products()->detach();
        }

        $item->children()->delete();

        $item->delete();
    }

    public function getModel(): Category
    {
        return new Category();
    }
}
