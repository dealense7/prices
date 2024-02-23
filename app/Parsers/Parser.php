<?php

declare(strict_types=1);

namespace App\Parsers;

use App\DataTransferObjects\ProductDto;
use Illuminate\Support\Facades\Http;
use Throwable;

abstract class Parser
{
    public array $data = [];

    public function __construct(
        public string $url,
    ) {
    }

    abstract public function getItems(): array;

    // We need bar code to identify product from different stores
    abstract public function getCode(array $item): int;

    abstract public function getPrice(array $item): int;

    abstract public function getPriceBeforeSale(array $item): ?int;

    abstract public function getCurrencyCode(array $item): string;

    abstract public function getImageUrl(array $item): ?string;

    public function fetchData(string $keyword): void
    {
        try {
            $this->data = Http::withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                ])
                ->get($this->url.urlencode($keyword))->json();
        } catch (Throwable $e) {
            dump('URL: '.$this->url.urlencode($keyword));
            dump($e->getMessage());
        }
    }

    public function generateResult(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            // If we don't find the code we don't need product like that, because we can not identify it from different stores
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
                priceBeforeSale: $this->getPriceBeforeSale($item),
            );
        }

        return $result;
    }

    // There Methods (down) can be overridden if you can get tag or company name from a product

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

    public function getCompanyName(array $item): ?string
    {
        preg_match('/"([^"]+)"/', $this->getName($item), $matches);

        return data_get($matches, 1, '');
    }
}
