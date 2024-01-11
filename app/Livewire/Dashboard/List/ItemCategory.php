<?php

namespace App\Livewire\Dashboard\List;

use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class ItemCategory extends Component
{
    public Collection $categories;
    public Product $product;
    public array $selectedCategories;
    public string $search = '';

    public function mount(
        Collection $categories,
        Product $product
    ): void {
        $this->categories = $categories;
        $this->product    = $product;
    }

    // TODO:: Must be optimized
    public function render(): View
    {
        return view('livewire.dashboard.list.item-category');
    }


    public function update(array $items): void
    {

        $categoryIds = [];
        foreach ($items as $item) {
            if (is_int($item['id'])) {
                $categoryIds[] = $item['id'];

            } else {
                $parentCategoryId = DB::table('categories')->select('id')->where('name', 'სხვა')->first()->id;
                $categoryIds[]    = DB::table('categories')->insertGetId([
                    'name'      => $item['name'],
                    'parent_id' => $parentCategoryId
                ]);
            }
        }
        $this->product->categories()->sync($categoryIds);

    }
}
