<?php

declare(strict_types=1);

namespace App\Parsers;

use Illuminate\Support\Arr;

class GlovoParser extends Parser
{
    public function getItems(): array
    {
        $items = Arr::get($this->data, 'results.0.products', []);

        return $this->generateResult($items);
    }

    public function getCode(array $item): int
    {
        preg_match('/\b\d{13}\b/', $item['name'], $matches);

        $code = data_get($matches, 0, 0);

        if (
            $code === 0
        ) {
            $code = data_get($item, 'externalId', []);
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
        return explode('/', $item['name'])[0];
    }

    public function getTag(array $item): ?string
    {
        preg_match('/(\d+(?:\.\d+)?)\s*(ლ|მლ|კგ|გრ|გ|ც)/', $item['sellType'], $matches);

        return data_get($matches, 1, '');
    }

    public function getTagName(array $item): ?string
    {
        preg_match('/(\d+(?:\.\d+)?)\s*(ლ|მლ|კგ|გრ|გ|ც)/', $item['sellType'], $matches);

        return !empty($matches[2]) ? $matches[2] : data_get($matches, 3);
    }

    public function getPrice(array $item): int
    {
        $promotion = Arr::get($item, 'promotion');
        if (!empty($promotion)) {
            return intval(round($promotion['price'], 3) * 100);
        }

        return intval(round($item['priceInfo']['amount'], 3) * 100);
    }

    public function getPriceBeforeSale(array $item): ?int
    {
        $promotion = Arr::get($item, 'promotion');

        if (!empty($promotion)) {
            return intval(round($item['priceInfo']['amount'], 3) * 100);
        }

        return null;
    }

    public function getCurrencyCode(array $item): string
    {
        return $item['priceInfo']['currencyCode'];
    }

    public function getImageUrl(array $item): ?string
    {
        return data_get($item, 'imageUrl');
    }
}
