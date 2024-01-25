<?php

namespace App\Parsers;

use App\DataTransferObjects\ProductDto;

class OriNabijiParser
{
    public function getItems($items): array
    {
        $items  = $items['data']['products'];
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
        return (int) $item['barCode'];
    }

    public function getPrice(array $item): int
    {
        return intval(collect($item['stocks'])->min('price') * 100);
    }
}
