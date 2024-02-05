<?php

namespace App\Jobs;

use App\Enums\Languages;
use App\Models\Category\Category;
use App\Models\Category\CategoryTranslation;
use App\Models\Store;
use App\Models\Url;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseStoreProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Store $store)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $keywords   = $this->getKeywords();
        $totalItems = 0;


        /** @var Url $url */
        foreach ($this->store->urls as $url) {
            $parser = $url->resolveProvider();

            foreach ($keywords as $word) {
                $parser->fetchData($word['name']);
                $fetchedItems = $parser->getItems();
                $totalItems += count($fetchedItems);

                SaveFetchedPrices::dispatch($fetchedItems, $this->store->getId(), $url->provider->getId());
            }
        }

        dump($this->store->name.' items:'.$totalItems);
        sleep(20);
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
