<?php

namespace App\Livewire\Dashboard\List;

use App\Enums\TagType;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ItemTag extends Component
{
    public Collection $tags;
    public Product $product;
    public array $selectedCategories;
    public string $search = '';

    public function mount(
        Collection $tags,
        Product $product
    ): void {
        $this->tags    = $tags;
        $this->product = $product;
    }

    public function render(): View
    {
        return view('livewire.dashboard.list.item-tag');
    }

    public function update(array $items): void
    {

        $categoryIds = [];
        foreach ($items as $item) {
            if (is_int($item['id'])) {
                $categoryIds[] = $item['id'];

            } else {
                $parentCategoryId = DB::table('tags')->select('id')->where('name', TagType::Other->text())->first()->id;
                $categoryIds[]    = DB::table('tags')->insertGetId([
                    'name'      => $item['name'],
                    'parent_id' => $parentCategoryId
                ]);
            }
        }
        $this->product->tags()->sync($categoryIds);

    }
}
