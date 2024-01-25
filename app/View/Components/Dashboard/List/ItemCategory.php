<?php

namespace App\View\Components\Dashboard\List;

use App\Models\Product\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ItemCategory extends Component
{
    public function __construct(
        public Collection $categories,
        public Product $product
    )
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.dashboard.list.item-category');
    }
}
