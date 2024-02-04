<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\TagRepositoryContract;
use App\Models\Tag\Tag;
use App\Support\Collection;

class TagRepository implements TagRepositoryContract
{
    public function findItems(array $filters = [], ?string $sort = null): Collection
    {
        $model = $this->getModel();
        $items = $model->filterByKeyword($filters)
            ->with([
                'children.translation',
                'translation'
            ])
            ->whereNull('parent_id');

        foreach ($model->parseSort($sort) as $column => $direction) {
            $items = $items->orderBy($column, $direction);
        }
        $items = $items->orderBy('id', 'desc');

        return $items->get();
    }

    public function findById(int $id): ?Tag
    {
        /** @var Tag|null $item */
        $item = $this->getModel()->query()->where('id', $id)->first();

        return $item;
    }

    public function getModel(): Tag
    {
        return new Tag();
    }
}
