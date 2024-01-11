<?php

namespace App\Enums;

enum Providers: int
{
    case Glovo = 1;

    public function text(): string
    {
        return match ($this) {
            Providers::Glovo => 'Glovo',
        };
    }
}
