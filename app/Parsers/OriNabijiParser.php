<?php

declare(strict_types=1);

namespace App\Parsers;

use Illuminate\Support\Arr;

class OriNabijiParser extends Parser
{
    public function getItems(): array
    {
        $items = $this->data['data']['products'];

        return $this->generateResult($items);
    }

    public function getCode(array $item): int
    {
        return (int) $item['barCode'];
    }

    public function getName(array $item): string
    {
        return $item['title'];
    }

    public function getPrice(array $item): int
    {
        $promotion = Arr::get($item, 'discount');

        if (!empty($promotion)) {
            return intval(round($promotion['price'], 3) * 100);
        }

        return intval(round($item['stock']['price'], 3) * 100);
    }

    public function getPriceBeforeSale(array $item): ?int
    {
        $promotion = Arr::get($item, 'discount');

        if (!empty($promotion)) {
            return intval(round($item['stock']['price'], 3) * 100);
        }

        return null;
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
