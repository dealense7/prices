<?php

namespace App\Livewire\Dashboard\List;

use App\Models\Product\Product;
use Illuminate\View\View;
use Livewire\Component;

class ItemName extends Component
{
    public Product $product;

    public function mount(
        Product $product
    ): void {
        $this->product = $product;
    }

    public function render(): View
    {
        return view('livewire.dashboard.list.item-name');
    }
}
