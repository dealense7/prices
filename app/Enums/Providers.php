<?php

declare(strict_types=1);

namespace App\Enums;

enum Providers: int
{
    case Glovo     = 1;
    case OriNabiji = 2;
    case Wolt      = 3;
    case Goodwill  = 4;
    case Spar      = 5;

    public function text(): string
    {
        return match ($this) {
            Providers::Glovo     => 'Glovo',
            Providers::OriNabiji => 'OriNabiji',
            Providers::Wolt      => 'Wolt',
            Providers::Goodwill  => 'Goodwill',
            Providers::Spar      => 'Spar',
        };
    }
}
