<?php

namespace Database\Seeders;

use App\Enums\Providers;
use App\Models\Provider;
use App\Parsers\GlovoParser;
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
