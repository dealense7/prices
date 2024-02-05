<?php

namespace App\View\Components\list;

use App\Support\Collection;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Categories extends Component
{
    public function __construct(public Collection $categories)
    {
        //
    }

    public function render(): View|Closure|string
    {
        $filters = request()->query('filters', []);

        $parentCategoryIds = Arr::get($filters, 'parentCategoryIds', []);
        $categoryIds       = Arr::get($filters, 'categoryIds', []);

        return view('components.list.categories', [
            'parentCategoryIds' => $parentCategoryIds,
            'categoryIds'       => $categoryIds,
        ]);
    }
}
