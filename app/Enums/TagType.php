<?php

namespace App\Enums;

enum TagType: int
{
    case Size     = 1;
    case Quantity = 2;
    case Weight   = 3;
    case Other    = 4;


    public function text(): string
    {
        return match ($this) {
            TagType::Size => 'ზომა',
            TagType::Quantity => 'რაოდენობა',
            TagType::Weight => 'წონა',
            TagType::Other => 'სხვა',
        };
    }
}
