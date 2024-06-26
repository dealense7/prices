<?php

declare(strict_types=1);

namespace App\Enums;

use App\Parsers\GlovoParser;
use App\Parsers\GoodwillParser;
use App\Parsers\OriNabijiParser;
use App\Parsers\WoltParser;

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

    public function getClass(): string
    {
        return match ($this) {
            Providers::Glovo     => GlovoParser::class,
            Providers::OriNabiji => OriNabijiParser::class,
            Providers::Wolt      => WoltParser::class,
            Providers::Goodwill  => GoodwillParser::class,
            Providers::Spar      => 'Spar',
        };
    }
}
