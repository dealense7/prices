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
                name: $this->getName($item),
                price: $this->getPrice($item),
                currencyCode: $this->getCurrencyCode($item),
                imageUrl: $this->getImageUrl($item),
                companyName: $this->getCompanyName($item),
                tag: $this->getTag($item),
                tagName: $this->getTagName($item),
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

    public function getCompanyName(array $item): ?string
    {
        preg_match('/"([^"]+)"/', $this->getName($item), $matches);
        return data_get($matches, 1, '');
    }

    public function getTag(array $item): ?string
    {
        preg_match('/(\d+,\d+|\d+)(ლ|მლ|კგ|გრ)/', $this->getName($item), $matches);
        return data_get($matches, 1, '');
    }

    public function getTagName(array $item): ?string
    {
        preg_match('/(\d+,\d+|\d+)(ლ|მლ|კგ|გრ)/', $this->getName($item), $matches);
        return data_get($matches, 2, '');
    }
}
