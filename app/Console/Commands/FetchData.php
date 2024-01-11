<?php

namespace App\Console\Commands;

use App\Jobs\SaveFetchedProduct;
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
            /** @var Url $url */
            foreach ($store->urls as $url) {
                $parser = $url->resolveProvider();

                foreach ($keywords as $words) {
                    $parser->fetchData($words);
                    SaveFetchedProduct::dispatch($parser->getItems(), $store->getId(), $url->provider->getId());
                }
            }
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
        return [
            'ქათამი',
            'ძეხვი',
            'სოსისი',
            'კვერცხი',
            'ლუდი',
            'პური',
            'გაზიანი',
            'პური',
        ];
    }
}
