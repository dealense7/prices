<?php

declare(strict_types=1);

namespace App\Enums;

enum TagType: int
{
    case Size     = 1;
    case Quantity = 2;
    case Weight   = 3;

    public function text(): array
    {
        return match ($this) {
            TagType::Size => [
                Languages::Georgian->value => 'ზომა',
                Languages::English->value  => 'Size',
            ],
            TagType::Quantity => [
                Languages::Georgian->value => 'რაოდენობა',
                Languages::English->value  => 'Quantity',
            ],
            TagType::Weight => [
                Languages::Georgian->value => 'წონა',
                Languages::English->value  => 'Weight',
            ],
        };
    }
}
