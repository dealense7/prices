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

    public function handle(): void
    {
        /** @var \App\Models\Url $url */
        foreach ($this->store->urls->sortByDesc('provider_id') as $url) {
            $parser = $url->resolveProvider();

            $fetchedItems = $parser->processData();

            SaveFetchedProduct::dispatch($fetchedItems, $this->store->getId());

            SaveFetchedPrices::dispatch($fetchedItems, $this->store->getId(), $url->provider->getId());
        }
    }
}
