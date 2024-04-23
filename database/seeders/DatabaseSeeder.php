<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
           LanguageSeeder::class,
           ProviderSeeder::class,
           StoreSeeder::class,
           CategorySeeder::class,
            //            TagSeeder::class
            //            TagSeeder::class,
        ]);
    }
}
