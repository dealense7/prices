<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            CategorySeeder::class,
//            TagSeeder::class,
//            ProviderSeeder::class,
//            StoreSeeder::class,
//            TagSeeder::class
        ]);
    }
}
