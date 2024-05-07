<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\Providers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class ParseStoreProducts implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public int $providerId,
        public array $data,
    ) {
        //
    }

    public function handle(): void
    {
        $provider = Providers::from($this->providerId);

        foreach ($this->data as $url) {
            try {
                /** @var \App\Parsers\Parser $parser */
                $parser = resolve($provider->getClass(), ['url' => $url['url'], 'storeId' => $url['store_id']]);

                $fetchedItems = $parser->processData();
// I don't want to add more products so that;s why I comment this part
//            SaveFetchedProduct::process($fetchedItems, $url['store_id']);

                SaveFetchedPrices::process($fetchedItems, $url['store_id'], $this->providerId);
            } catch (Throwable $exception) {
                Log::error($exception->getMessage());
            }
        }
    }
}
