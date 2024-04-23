<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Actions\SaveFetchedProduct;
use App\Enums\Providers;
use App\Parsers\Parser;
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
            /** @var Parser $parser */
            $parser = resolve($provider->getClass(), ['url' => $url['url']]);

            $fetchedItems = $parser->processData();

            SaveFetchedProduct::process($fetchedItems, $url['store_id']);

            SaveFetchedPrices::process($fetchedItems, $url['store_id'], $this->providerId);
        }
    }
}
