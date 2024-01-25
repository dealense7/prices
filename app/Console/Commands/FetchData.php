<?php

namespace App\Console\Commands;

use App\Enums\Languages;
use App\Jobs\SaveFetchedProduct;
use App\Models\Category\Category;
use App\Models\Category\CategoryTranslation;
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
            $fetchedItems = [];
            /** @var Url $url */
            foreach ($store->urls as $url) {
                $parser = $url->resolveProvider();

                dd($keywords);
                foreach ($keywords as $words) {
                    $parser->fetchData($words);
                    $fetchedItems = [
                        ...$fetchedItems,
                        ...$parser->getItems()
                    ];
                }
            }
            dd(count($fetchedItems));

//            SaveFetchedProduct::dispatch($parser->getItems(), $store->getId(), $url->provider->getId());

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
        $items = CategoryTranslation::query()
            ->where('language_id', Languages::Georgian->value)
            ->whereIn('category_id', Category::query()->whereNotNull('parent_id')->pluck('id')->toArray())
            ->get()->pluck('name')->toArray();
        foreach ($items as $key => $item){
            if (str_contains($item, '&')){
                $arr = explode('&', $item);
                foreach ($arr as $k => $v)
                {
                    if ($k === 0){
                        $items[$key] = $v;
                    }else{
                        $items[] = $v;
                    }
                }
            }
        }

        return $items;
    }
}
