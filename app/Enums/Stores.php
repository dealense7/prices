<?php

declare(strict_types=1);

namespace App\Enums;

enum Stores: int
{
    case Carrefour   = 1;
    case Goodwill    = 2;
    case Nikora      = 3;
    case Spar        = 4;
    case Agrohub     = 5;
    case OriNabiji   = 6;
    case Magniti     = 7;
    case Europroduct = 8;

    public function text(): string
    {
        return match ($this) {
            Stores::Carrefour => 'კარფური',
            Stores::Goodwill => 'გუდვილი',
            Stores::Nikora => 'ნიკორა',
            Stores::Spar => 'სპარი',
            Stores::Agrohub => 'აგროჰაბი',
            Stores::OriNabiji => 'ორი ნაბიჯი',
            Stores::Magniti => 'მაგნიტი',
            Stores::Europroduct => 'ევროპროდუქტი',
        };
    }
}
