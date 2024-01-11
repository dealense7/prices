<?php

namespace App\Enums;

enum Stores: int
{
    case Carrefour = 1;
    case Goodwill  = 2;
    case Nikora    = 3;
    case Spar      = 4;
    case Agrohub   = 5;

    public function text(): string
    {
        return match ($this) {
            Stores::Carrefour => 'Carrefour',
            Stores::Goodwill => 'Goodwill',
            Stores::Nikora => 'Nikora',
            Stores::Spar => 'Spar',
            Stores::Agrohub => 'Agrohub',
        };
    }
}
