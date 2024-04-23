<?php

declare(strict_types=1);

namespace App\Parsers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class WoltParser extends Parser
{
    public function getItems(): array
    {
        $items = Arr::get($this->data, 'items');

        return $this->generateResult($items);
    }

    public function fetchData(): void
    {
        $response = Http::get($this->url);

        $this->data = $response->json();
    }


    public function getCode(array $item): int
    {
        $code = data_get($item, 'barcode_gtin', 0);

        if ($code === 0) {
            preg_match('/\b\d{13}\b/', $item['name'], $matches);

            $code = data_get($matches, 0, 0);
        }

        if (
           $code === 0
        ) {
            $url = data_get($item, 'image');

            $pattern = "/(\d{13})\.[a-zA-Z]+$/"; // 13 digits before any file extension
            preg_match($pattern, $url ?? '', $matches);

            $code = data_get($matches, 1, 0);
        }

        return strlen((string) $code) === 13 ? (int) $code : 0;
    }

    public function getName(array $item): string
    {
        return $item['name'];
    }

    public function getPrice(array $item): int
    {
        return $item['baseprice'];
    }

    public function getPriceBeforeSale(array $item): ?int
    {
        $promotion = Arr::get($item, 'original_price');

        if ( ! empty($promotion)) {
            return $promotion;
        }

        return null;
    }

    public function getCurrencyCode(array $item): string
    {
        return 'GEL';
    }

    public function getImageUrl(array $item): ?string
    {
        return data_get($item, 'image');
    }
}
