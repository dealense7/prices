<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Facades\Http;

class ProductDto
{
    public function __construct(
        public readonly int $code,
        public readonly int $price,
    ) {
    }
}
