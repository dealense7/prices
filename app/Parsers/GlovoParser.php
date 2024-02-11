<?php

declare(strict_types=1);

namespace App\Parsers;

use Illuminate\Support\Arr;

class GlovoParser extends Parser
{
    public function getItems(): array
    {
        $items  = Arr::get($this->data, 'results.0.products', []);

        return $this->generateResult($items);
    }

    public function getCode(array $item): int
    {
        preg_match('/\b\d{13}\b/', $item['name'], $matches);

        $code = data_get($matches, 0, 0);

        if (
            $code === 0
        ) {
            preg_match('/\b\d{13}\b/', data_get($item, 'imageUrl'), $matches);
            $code = data_get($matches, 0, 0);
        }

        if (
            $code === 0
        ) {
            $code = data_get($item, 'externalId', []);
        }

        return $code;
    }

    public function getName(array $item): string
    {
        return explode('/', $item['name'])[0];
    }

    public function getPrice(array $item): int
    {
        $promotion = Arr::get($item, 'promotion');
        if ($promotion !== null) {
            return intval(round($promotion['price'], 3) * 100);
        }

        return intval(round($item['priceInfo']['amount'], 3) * 100);
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
