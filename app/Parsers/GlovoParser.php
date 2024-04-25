<?php

declare(strict_types=1);

namespace App\Parsers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class GlovoParser extends Parser
{
    public function getItems(): array
    {
        $items = Arr::get($this->data, 'data.body.0.data.elements', []);

        return $this->generateResult($items);
    }

    public function fetchData(): void
    {
        $response = Http::withHeaders([
            'accept'                            => 'application/json',
            'accept-language'                   => 'en-GB,en-US;q=0.9,en;q=0.8,ka;q=0.7',
            'dnt'                               => '1',
            'glovo-api-version'                 => '14',
            'glovo-app-development-state'       => 'Production',
            'glovo-app-platform'                => 'web',
            'glovo-app-type'                    => 'customer',
            'glovo-app-version'                 => '7',
            'glovo-client-info'                 => 'web-customer-web/7 project:customer-web',
            'glovo-delivery-location-accuracy'  => '0',
            'glovo-delivery-location-latitude'  => '41.7235999',
            'glovo-delivery-location-longitude' => '44.741394',
            'glovo-delivery-location-timestamp' => '1713898857736',
            'glovo-device-urn'                  => 'glv:device:afe36703-2bd3-4941-b826-a13929edd493',
            'glovo-dynamic-session-id'          => 'c9562878-d015-4291-933c-b876057306f1',
            'glovo-language-code'               => 'en',
            'glovo-location-city-code'          => 'TBI',
            'glovo-request-id'                  => '7f8fdccb-9028-4509-bbba-9e51d7b58b12',
            'origin'                            => 'https://glovoapp.com',
            'priority'                          => 'u=1, i',
            'referer'                           => 'https://glovoapp.com/',
            'sec-ch-ua'                         => '"Chromium";v="124", "Google Chrome";v="124", "Not-A.Brand";v="99"',
            'sec-ch-ua-mobile'                  => '?0',
            'sec-ch-ua-platform'                => '"Windows"',
            'sec-fetch-dest'                    => 'empty',
            'sec-fetch-mode'                    => 'cors',
            'sec-fetch-site'                    => 'same-site',
            'user-agent'                        => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
        ])->withoutVerifying()->get($this->url);

        $this->data = $response->json();
    }

    public function getCategoryId(array $item): ?int
    {
        preg_match('/(\d+)$/', $this->url, $matches);
        $lastNumber = end($matches);
    }

    public function getCode(array $item): int
    {
        $code = data_get($item['data'], 'externalId', 0);


        if (
            $code === 0
        ) {
            preg_match('/\b\d{13}\b/', $this->getName($item), $matches);

            $code = data_get($matches, 0, 0);
        }

        if (
            $code === 0
        ) {
            preg_match('/\b\d{13}\b/', data_get($item, 'imageUrl'), $matches);
            $code = data_get($matches, 0, 0);
        }

        return (int) $code;
    }

    public function getName(array $item): string
    {
        return $item['data']['name'];
    }

    public function getTag(array $item): ?string
    {
        preg_match('/(\d+(?:\.\d+)?)\s*(ლ|მლ|კგ|გრ|გ|ც)/', $this->getName($item), $matches);

        return data_get($matches, 1, '');
    }

    public function getTagName(array $item): ?string
    {
        preg_match('/(\d+(?:\.\d+)?)\s*(ლ|მლ|კგ|გრ|გ|ც)/', $this->getName($item), $matches);

        return !empty($matches[2]) ? $matches[2] : data_get($matches, 3);
    }

    public function getPrice(array $item): int
    {
        $promotion = Arr::get($item, 'data.promotion');
        if (!empty($promotion)) {
            return intval(round($promotion['price'], 3) * 100);
        }

        return intval(round($item['priceInfo']['amount'], 3) * 100);
    }

    public function getPriceBeforeSale(array $item): ?int
    {
        $promotion = Arr::get($item, 'promotion');

        if (!empty($promotion)) {
            return intval(round($item['data']['priceInfo']['amount'], 3) * 100);
        }

        return null;
    }

    public function getCurrencyCode(array $item): string
    {
        return $item['data']['priceInfo']['currencyCode'];
    }

    public function getImageUrl(array $item): ?string
    {
        return data_get($item['data'], 'imageUrl');
    }
}
