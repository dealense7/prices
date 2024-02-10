<?php

namespace App\Jobs;

use App\Enums\Languages;
use App\Models\Category\Category;
use App\Models\Category\CategoryTranslation;
use App\Models\Store;
use App\Models\Url;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseStoreProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Store $store)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // as I checked it's much easy to send search request on a site then parse their categories and do requests or something like that
        // So keywords are words of my categories, but you can change logic and get more words for a category.
        // print keywords if you want to know what it looks like.
        $keywords   = $this->getKeywords();
        $totalItems = 0;


        /** @var Url $url */
        foreach ($this->store->urls as $url) {
            $parser = $url->resolveProvider();

            foreach ($keywords as $word) {
                // Fetch Items
                $parser->fetchData($word['name']);

                // Parse items
                $fetchedItems = $parser->getItems();
                $totalItems   += count($fetchedItems);

                // I don't want to fetch more products, that's why I commented this line.
//                SaveFetchedProduct::dispatch($fetchedItems, $this->store->getId(), $word['category_id'], $word['parent_category_id']);

                SaveFetchedPrices::dispatch($fetchedItems, $this->store->getId(), $url->provider->getId());
            }
            // this is necessary to don't get blocked for many requests, if you have crazy amounts of keywords it's recommended to send max 50-60 request in about 10 seconds, depends on site.
            sleep(20);
        }

        // Total fetched items from a store
        dump($this->store->name.' items:'.$totalItems);
    }

    private function getKeywords(): array
    {
        $categories  = [];

        // Get all child category
        $allCategory = Category::query()->whereNotNull('parent_id')->get();
        $items       = CategoryTranslation::query()
            ->where('language_id', Languages::Georgian->value)
            ->whereIn('category_id', $allCategory->pluck('id')->toArray())
            ->get();

        // If there is a category like this "beer & vodka" I will fetch it separately as "beer" and "vodka"
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
            } else {
                $categories[] = [
                    'name'               => $item->getName(),
                    'category_id'        => $item->category_id,
                    'parent_category_id' => $allCategory->firstWhere('id', $item->category_id)->parent_id,
                ];
            }
        }

        return $categories;
    }

}
