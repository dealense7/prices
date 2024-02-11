<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Product\Product;
use App\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryContract
{
    public function findItems(
        array $filters = [],
        int $page = 1,
        ?int $perPage = null,
        ?string $sort = null,
    ): LengthAwarePaginator;

    public function getProductsGroupedByCategory(): Collection;

    public function getProducts(array $filters = []): LengthAwarePaginator;

    public function findById(int $id): ?Product;

    public function getProductsList(array $filters = []): Collection;

    public function update(Product $item, array $data): Product;

    public function createOrUpdateTranslation(Product $item, array $data): Product;

    public function syncCategories(Product $item, array $ids): Product;

    public function syncTags(Product $item, array $ids): Product;
}
