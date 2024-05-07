<?php

declare(strict_types=1);

namespace App\Parsers;

use App\DataTransferObjects\ProductDto;

abstract class Parser
{
    public array $data = [];

    public function __construct(
        public string $url,
        public int $storeId,
    ) {
    }

    abstract public function getItems(): array;

    abstract public function getName(array $item): string;

    // We need barCode to identify same product from different stores
    abstract public function getCode(array $item): int;

    abstract public function getCategoryId(array $item): ?int;

    abstract public function getPrice(array $item): int;

    abstract public function getPriceBeforeSale(array $item): ?int;

    abstract public function getCurrencyCode(array $item): string;

    abstract public function getImageUrl(array $item): ?string;

    abstract public function fetchData(): void;

    public function processData(): array
    {
        $this->fetchData();

        return $this->getItems();
    }

    public function generateResult(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            // we don't need to save product if it does not have EAN standard (13 digits in bar code)
            // we don't need to save product if we don't know its price
            $code       = $this->getCode($item);
            $categoryId = $this->getCategoryId($item);
            if (! in_array(strlen((string) $code), [13, 7]) || empty($this->getPrice($item)) || $categoryId === null) {
                continue;
            }

            $result[] = new ProductDto(
                code: $code,
                name: $this->getName($item),
                price: $this->getPrice($item),
                currencyCode: $this->getCurrencyCode($item),
                imageUrl: $this->getImageUrl($item),
                companyName: $this->getCompanyName($item),
                categoryId: $categoryId,
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

        return ! empty($matches[2]) ? $matches[2] : data_get($matches, 3);
    }

    public function getCompanyName(array $item): ?string
    {
        preg_match('/"([^"]+)"/', $this->getName($item), $matches);

        return data_get($matches, 1, '');
    }
}
