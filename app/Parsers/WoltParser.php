<?php

declare(strict_types=1);

namespace App\Parsers;

use App\Enums\Stores;
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
        $response = Http::withoutVerifying()->get($this->url);

        $this->data = $response->json();
    }

    public function getCategoryId(array $item): ?int
    {
        $mapper = config('custom.category-maper.' . strtolower(Stores::from($this->storeId)->name) . '-wolt');

        return Arr::get($mapper, Arr::get($item, 'category'));
    }

    public function getCode(array $item): int
    {
        $code = data_get($item, 'barcode_gtin', 0);

        if (empty($code)) {
            preg_match('/\b\d{13}\b/', $item['name'], $matches);

            $code = data_get($matches, 0, 0);
        }

        $imgUrl = $this->getImageUrl($item);
        if (empty($code) && ! empty($imgUrl)) {
            $pattern = '/_(\d{13})\.(jpg|png|gif|bmp|tif|tiff|webp)$/';
            preg_match($pattern, $imgUrl, $matches);
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

        if (! empty($promotion)) {
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
