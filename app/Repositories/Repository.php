<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

abstract class Repository
{
    abstract public function getModel(): Model;

    public function getFilters(): array
    {
        return [];
    }

    public function getData(array $filters = []): Builder
    {
        return app(Pipeline::class)
            ->send(
                [
                    'query'  => $this->getModel()->query(),
                    'filter' => $filters,
                ]
            )
            ->through($this->getFilters())
            ->thenReturn()['query'];
    }
}
