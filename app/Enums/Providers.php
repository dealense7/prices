<?php

declare(strict_types=1);

namespace App\Enums;

enum Providers: int
{
    case Glovo     = 1;
    case OriNabiji = 2;
    case Wolt = 3;

    public function text(): string
    {
        return match ($this) {
            Providers::Glovo => 'Glovo',
            Providers::OriNabiji => 'OriNabiji',
            Providers::Wolt => 'Wolt',
        };
    }
}
