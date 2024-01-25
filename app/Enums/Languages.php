<?php

namespace App\Enums;

enum Languages: int
{
    case Georgian = 1;
    case English  = 2;

    public function data(): array
    {
        return match ($this) {
            Languages::Georgian => [
                'name'       => 'ქართული',
                'slug'       => 'ka',
                'is_default' => true
            ],
            Languages::English => [
                'name'       => 'English',
                'slug'       => 'en',
                'is_default' => false
            ],
        };
    }
}
