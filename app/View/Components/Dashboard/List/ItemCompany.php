<?php

declare(strict_types=1);

namespace App\View\Components\Dashboard\List;

use App\Models\Product\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ItemCompany extends Component
{
    public function __construct(
        public Collection $companies,
        public Product $product,
    ) {
        //
    }

    public function render(): View
    {
        return view('components.dashboard.list.item-company');
    }
}
