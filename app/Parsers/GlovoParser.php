<?php

namespace App\Parsers;

use App\DataTransferObjects\ProductDto;
use Illuminate\Support\Arr;

class GlovoParser extends Parser
{
    public function getItems(): array
    {
        $items  = Arr::get($this->data, 'results.0.products', []);
        $result = [];
        foreach ($items as $item) {
            $code = $this->getCode($item);
            if (empty($code)) {
                continue;
            }

            $result[] = new ProductDto(
                code: $code,
                price: $this->getPrice($item),
            );
        }

        return $result;
    }

    public function getCode(array $item): int
    {
        preg_match('/\b\d{13}\b/', $item['name'], $matches);

        $code = data_get($matches, 0, 0);

        if (
            $code === 0
        ) {
            preg_match('/\b\d{13}\b/', data_get($item, 'imageUrl', ''), $matches);
            $code = data_get($matches, 0, 0);
        }

        if (
            $code === 0
        ) {
            $code = data_get($item, 'externalId', []);
        }

        return $code;
    }


    public function getPrice(array $item): int
    {
        return intval(round($item['priceInfo']['amount'], 3) * 100);
    }

}
