<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Facades\Http;

class ProductDto
{
    public function __construct(
        public readonly int $code,
        public readonly string $name,
        public readonly int $price,
        public readonly string $currencyCode,
        public readonly ?string $imageUrl = null,
        public readonly ?string $companyName = null,
        public readonly ?string $categoryId = null,
        public readonly ?string $tag = null,
        public readonly ?string $tagName = null,
    ) {
    }
}
