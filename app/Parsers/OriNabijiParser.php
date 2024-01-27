<?php

namespace App\Parsers;

use App\DataTransferObjects\ProductDto;

class OriNabijiParser extends Parser
{
    public function getItems(): array
    {
        $items  = $this->data['data']['products'];
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
        return (int) $item['barCode'];
    }

    public function getName(array $item): string
    {
        return $item['title'];
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

    public function getPrice(array $item): int
    {
        return intval(round($item['stock']['price'], 3) * 100);
    }

    public function getCurrencyCode(array $item): string
    {
        return 'GEL';
    }

    public function getImageUrl(array $item): string
    {
        return 'https://second.media.2nabiji.ge/api/files/resize/300/300/'.$item['images'][0]['imageId'].'/'.$item['images'][0]['originalName'];
    }
}
