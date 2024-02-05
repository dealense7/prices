<?php

namespace App\Console\Commands;

use App\Enums\Stores;
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

        /** @var Store $store */
        foreach ($stores as $store) {
            dispatch(new ParseStoreProducts($store));
        }
    }

    private function getStores(): Collection
    {
        return Store::query()
            ->with([
                'urls.provider'
            ])->get();
    }
}
