<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\Languages;
use App\Models\Category\Category;
use App\Models\Category\CategoryTranslation;
use App\Models\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseStoreProducts implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

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


        /** @var \App\Models\Url $url */
        foreach ($this->store->urls->sortByDesc('provider_id') as $url) {
            $parser = $url->resolveProvider();

            foreach ($keywords as $key => $word) {

                // Fetch Items
                $parser->fetchData($word['name']);

                // Parse items
                $fetchedItems = $parser->getItems();
                $totalItems   += count($fetchedItems);

                $text = 'Provider: ' . $url->provider->name . '; Store: ' . $this->store->name. ' Word: ' . $word['name'];
                // I don't want to fetch more products, that's why I commented this line.
                SaveFetchedProduct::dispatch($fetchedItems, $this->store->getId(), $word['category_id'], $word['parent_category_id'], $text);

                SaveFetchedPrices::dispatch($fetchedItems, $this->store->getId(), $url->provider->getId());
            }
            sleep(30);

        }
        // Total fetched items from a store
        dump($this->store->name . ' items:' . $totalItems);
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
