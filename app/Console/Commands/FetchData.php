<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\ParseStoreProducts;
use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class FetchData extends Command
{
    protected $signature = 'app:fetch-data';

    protected $description = 'Command description';

    public function handle(): void
    {
        $stores = $this->getStores();

        // Start fetching data from the stores
        /** @var \App\Models\Store $store */
        foreach ($stores as $store) {
            dispatch(new ParseStoreProducts($store));
        }
    }

    private function getStores(): Collection
    {
        return Store::query()
            ->with([
                'urls.provider',
            ])->get();
    }
}
