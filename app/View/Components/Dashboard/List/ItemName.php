<?php

declare(strict_types=1);

namespace App\View\Components\Dashboard\List;

use App\Models\Product\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ItemName extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Product $product,
    ) {
        //
    }

    public function myMethod()
    {
        dd('da');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.dashboard.list.item-name');
    }
}
