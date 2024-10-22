<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\CompanyRepositoryContract;
use App\Contracts\Repositories\ProductRepositoryContract;
use App\Enums\Languages;
use App\Exceptions\ItemNotFoundException;
use App\Models\Product\Product;
use App\Support\Collection;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(
        private readonly ProductRepositoryContract $repository,
        private readonly CompanyRepositoryContract $companyRepository,
    ) {
    }

    public function findItems(
        array $filters = [],
        int $page = 1,
        ?int $perPage = null,
        ?string $sort = null,
    ): LengthAwarePaginator {
        return $this->repository->findItems($filters, $page, $perPage, $sort);
    }

    public function getProductsGroupedByCategory(): Collection
    {
        return $this->repository->getProductsGroupedByCategory();
    }

    public function getProducts(array $filters = [], int $page = 1): LengthAwarePaginator
    {
        return $this->repository->getProducts($filters, $page);
    }

    public function findById(int $id): ?Product
    {
        return $this->repository->findById($id);
    }

    public function findOrFailById(int $id): Product
    {
        $item = $this->findById($id);

        if (! $item) {
            throw new ItemNotFoundException();
        }

        return $item;
    }

    public function getPrice(Product $product): array
    {
        Carbon::setLocale('ka');

        return $product
            ->prices
            ->transform(static function ($item) {
                return [
                    'price'       => number_format($item->price / 100, 2),
                    'companyLogo' => 'storage/' . $item->store->logo->path,
                    'companyName' => $item->store->name,
                    'companyYear' => $item->store->year,
                    'createdAt'   => $item->created_at->diffForHumans(),
                ];
            })
            ->toArray();
    }

    public function getProductsList(array $ids): Collection
    {
        return $this->repository->getProductsList(['ids' => $ids]);
    }

    public function getPriceHistory(Product $item): array
    {
        $prices = $this->repository->getPriceHistory($item);

        $weeks     = [];
        $minPrices = [];
        $maxPrices = [];

        foreach ($prices as $price) {
            $week = (string) $price->week;
            $weeks[]     = substr($week, 0, 4) . '/' . substr($week, 4);;
            $minPrices[] = number_format($price->min_price/100, 2);
            $maxPrices[] = number_format($price->max_price/100, 2);
        }

        return [
            'weeks'      => $weeks,
            'min_prices' => $minPrices,
            'max_prices' => $maxPrices,
        ];
    }

    public function update(Product $item, array $data): Product
    {
        if (
            ! empty($data['show'])
        ) {
            $this->repository->update($item, [
                'show' => data_get($data, 'show', $item->getShow()),
            ]);
        }
        if (
            ! empty($data['name'])
        ) {
            $this->repository->createOrUpdateTranslation(
                $item,
                [
                    'name'        => data_get($data, 'name', $item->translation->getName()),
                    'language_id' => Languages::Georgian->value,
                ]
            );
        }

        if (isset($data['categories'])) {
            $this->repository->syncCategories($item, $data['categories']);
        }

        if (isset($data['tags'])) {
            $this->repository->syncTags($item, $data['tags']);
        }

        if (! empty($data['company'])) {
            if (intval($data['company']['id']) !== 0) {
                $company = $this->companyRepository->findById((int) $data['company']['id']);
            } else {
                $company = $this->companyRepository->create(['name' => $data['company']['name']]);
            }
            $this->repository->update($item, [
                'company_id' => $company->getId(),
            ]);
        }

        return $item;
    }

    public function delete(Product $item): void
    {
        $item->delete();
    }
}
