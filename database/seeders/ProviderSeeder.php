<?php

namespace Database\Seeders;

use App\Enums\Providers;
use App\Models\Provider;
use App\Parsers\GlovoParser;
use App\Parsers\OriNabijiParser;
use App\Parsers\WoltParser;
use Illuminate\Database\Seeder;
use function Laravel\Prompts\text;

class ProviderSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'id'    => Providers::Glovo->value,
                'name'  => Providers::Glovo->text(),
                'class' => GlovoParser::class
            ],
            [
                'id'    => Providers::OriNabiji->value,
                'name'  => Providers::OriNabiji->text(),
                'class' => OriNabijiParser::class
            ],
            [
                'id'    => Providers::Wolt->value,
                'name'  => Providers::Wolt->text(),
                'class' => WoltParser::class
            ]
        ];

        foreach ($items as $data) {
            Provider::query()->withTrashed()->updateOrCreate(
                [
                    'id' => $data['id']
                ],
                $data
            );
        }

    }
}
