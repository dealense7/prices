<?php

declare(strict_types=1);

namespace App\Enums;

enum Providers: int
{
    case Glovo     = 1;
    case OriNabiji = 2;

    public function text(): string
    {
        return match ($this) {
            Providers::Glovo => 'Glovo',
            Providers::OriNabiji => 'OriNabiji',
        };
    }
}
