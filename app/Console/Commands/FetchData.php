<?php

namespace App\Console\Commands;

use App\Enums\Languages;
use App\Enums\Stores;
use App\Jobs\SaveFetchedPrices;
use App\Jobs\SaveFetchedProduct;
use App\Models\Category\Category;
use App\Models\Category\CategoryTranslation;
use App\Models\Product\Product;
use App\Models\Store;
use App\Models\Url;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class FetchData extends Command
{
    protected $signature = 'app:fetch-data';

    protected $description = 'Command description';

    public function handle(): void
    {
        $stores   = $this->getStores();
        $keywords = $this->getKeywords();

        /** @var Store $store */
        foreach ($stores as $store) {
            $start = time();

            /** @var Url $url */
            foreach ($store->urls as $url) {
                $parser = $url->resolveProvider();
                dump($store->getName());

                foreach ($keywords as $word) {
                    $parser->fetchData($word['name']);
                    $fetchedItems = $parser->getItems();

                    SaveFetchedProduct::dispatch($fetchedItems, $store->getId(), $word['category_id'], $word['parent_category_id']);
                    SaveFetchedPrices::dispatch($fetchedItems, $store->getId(), $url->provider->getId());
                }

            }
            $end = time();
            dump($end - $start);

        }
    }

    private function getStores(): Collection
    {
        return Store::query()->with([
            'urls.provider'
        ])->get();
    }


    private function getKeywords(): array
    {
        $allCategory = Category::query()->whereNotNull('parent_id')->get();
        $items       = CategoryTranslation::query()
            ->where('language_id', Languages::Georgian->value)
            ->whereIn('category_id', $allCategory->pluck('id')->toArray())
            ->get();
        $categories  = [];
        foreach ($items as $item) {
            if (str_contains($item->getName(), '&')) {
                $arr = explode('&', $item->getName());
                foreach ($arr as $k => $v) {
                    $categories[] = [
                        'name'               => trim($v),
                        'category_id'        => $item->category_id,
                        'parent_category_id' => $allCategory->firstWhere('id', $item->category_id)->parent_id,
                    ];
                }
            }
        }

        return $categories;
    }
}
