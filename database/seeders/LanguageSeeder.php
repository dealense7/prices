<?php

namespace Database\Seeders;

use App\Enums\Languages;
use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            Languages::Georgian,
            Languages::English,
        ];

        /** @var Languages $data */
        foreach ($items as $data) {
            Language::query()->firstOrCreate(
                [
                    'id' => $data->value,
                ],
                [
                    'id' => $data->value,
                    ...$data->data()
                ]);
        }

    }
}
