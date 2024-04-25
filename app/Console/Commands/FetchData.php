<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Stores;
use App\Jobs\ParseStoreProducts;
use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class FetchData extends Command
{
    protected $signature = 'app:fetch-data';

    protected $description = 'Command description';

    public function handle(): void
    {
        $stores    = $this->getStores();
        $providers = [];

        // Generate Urls and group by provider
        // So we can delay 20-30 requests for a provider, that will help us on too many request problem
        /** @var \App\Models\Store $store */
        foreach ($stores as $store) {
            foreach ($store->urls->groupBy('provider_id') as $providerId => $url) {
                $providers[$providerId] = [
                   ...Arr::get($providers, $providerId, []),
                   ...$url->pluck('url')->transform(function ($item) use ($store) {
                       return [
                          'url'      => $item,
                          'store_id' => $store->id
                       ];
                   })
                ];
            }
        }

        // Start Fetching Data and delaying requests
        foreach ($providers as $providerId => $provider) {
            foreach (array_chunk($provider, 20) as $key => $data) {
                dispatch(new ParseStoreProducts($providerId, $data))->delay(now()->addSeconds(80 * $key));
            }
        }
    }

    private function getStores(): Collection
    {
        return Store::query()
            ->where('id', Stores::Carrefour->value)
           ->with([
              'urls.provider',
           ])->get();
    }
}
