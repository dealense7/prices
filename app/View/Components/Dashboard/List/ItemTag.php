<?php

declare(strict_types=1);

namespace App\View\Components\Dashboard\List;

use App\Models\Product\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ItemTag extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Collection $tags,
        public Product $product,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.dashboard.list.item-tag');
    }
}
