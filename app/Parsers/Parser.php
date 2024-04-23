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

    abstract public function getName(array $item): string;

    // We need barCode to identify same product from different stores
    abstract public function getCode(array $item): int;

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
            $code = $this->getCode($item);
            if (strlen((string) $code) != 13 || empty($this->getPrice($item))) {
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


    private function getKeywords(): array
    {
        $categories = [];

        // Get all child category
        $allCategory = Category::query()->whereNotNull('parent_id')->get();
        $items       = CategoryTranslation::query()
            ->where('language_id', Languages::Georgian->value)
            ->whereIn('category_id', $allCategory->pluck('id')->toArray())
            ->get();

        // If there is a category like this "beer & vodka" I will fetch it separately as "beer" and "vodka"
        foreach ($items as $item) {
            if (str_contains($item->getName(), '&')) {
                $arr = explode('&', $item->getName());
                foreach ($arr as $k => $v) {
                    $categories[] = [
                        'name'               => trim($v),
                        'category_id'        => $item->category_id,
                        'parent_category_id' => $allCategory->firstWhere('id', $item->category_id)->parent_id,
                    ];
                }
            } else {
                $categories[] = [
                    'name'               => $item->getName(),
                    'category_id'        => $item->category_id,
                    'parent_category_id' => $allCategory->firstWhere('id', $item->category_id)->parent_id,
                ];
            }
        }

        return $categories;
    }
}
