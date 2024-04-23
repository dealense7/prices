<?php

namespace Database\Seeders;

use App\Enums\Providers;
use App\Enums\Stores;
use App\Models\File;
use App\Models\Provider;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
           [
              'id'   => Stores::Carrefour->value,
              'name' => Stores::Carrefour->text(),
              'year' => 1963,
              'img'  => 'carrefour.png',
              'urls' => [
                 [
                    'provider_id' => Providers::Wolt->value,
                    'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-saburtalo/menu/categories/slug/--131?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                 ]
              ]
           ],
           [
              'id'   => Stores::Goodwill->value,
              'name' => Stores::Goodwill->text(),
              'year' => 2004,
              'img'  => 'goodwill.png',
//              'urls' => [
//                 [
//                    'provider_id' => Providers::Wolt->value,
//                    'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-saburtalo/menu/categories/slug/--131?unit_prices=true&show_weighted_items=true&show_subcategories=true'
//                 ]
//              ]
           ],
           [
              'id'   => Stores::Nikora->value,
              'name' => Stores::Nikora->text(),
              'img'  => 'nikora.jpg',
              'year' => 1998,
//              'urls' => [
//                 [
//                    'provider_id' => Providers::Glovo->value,
//                    'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-saburtalo/menu/categories/slug/--131?unit_prices=true&show_weighted_items=true&show_subcategories=true'
//                 ]
//              ]
           ],
           [
              'id'   => Stores::Spar->value,
              'name' => Stores::Spar->text(),
              'img'  => 'spar.png',
              'year' => 1932,
           ],
           [
              'id'   => Stores::Agrohub->value,
              'name' => Stores::Agrohub->text(),
              'year' => 2016,
              'img'  => 'agrohub.png',
           ],
           [
              'id'   => Stores::Magniti->value,
              'name' => Stores::Magniti->text(),
              'year' => 2015,
              'img'  => 'magniti.png',
           ],
           [
              'id'   => Stores::Europroduct->value,
              'name' => Stores::Europroduct->text(),
              'year' => 2015,
              'img'  => 'europroduct.png',
           ],
           [
              'id'   => Stores::OriNabiji->value,
              'name' => Stores::OriNabiji->text(),
              'year' => 2010,
              'img'  => 'orinabiji.png',
//              'urls' => [
//                 [
//                    'provider_id' => Providers::OriNabiji->value,
//                    'url'         => 'https://catalog-api.orinabiji.ge/catalog/api/products/suggestions?lang=ge&limit=100&sortField=isInStock&sortDirection=-1&searchText='
//                 ]
//              ]
           ],
        ];

        foreach ($items as $data) {
            $imgPath = storage_path('logos/'.$data['img']);

            /** @var Store $store */
            $store = Store::query()->updateOrCreate(
               [
                  'id' => $data['id']
               ],
               [
                  'id'   => $data['id'],
                  'name' => $data['name'],
                  'year' => $data['year']
               ]
            );

            if ($store->logo()->first() === null) {
                $this->saveLogo($store->getId(), $imgPath);
            }

            $store->urls()->forceDelete();

            foreach (Arr::get($data, 'urls', []) as $urlData) {
                $store->urls()->create($urlData);
            }

        }
    }


    private function saveLogo(int $storeId, string $url): void
    {
        $imageContent = file_get_contents($url);

        $extension = pathinfo($url, PATHINFO_EXTENSION);

        $filename = uniqid().'.'.$extension;

        Storage::disk('public')->put('products'.'/'.$filename, $imageContent);

        $diskUrl = Storage::disk('public')->path('products'.'/'.$filename);

        DB::table((new File())->getTable())->insert([
           'name'          => $filename,
           'path'          => 'products'.'/'.$filename,
           'size'          => filesize($diskUrl),
           'extension'     => $extension,
           'fileable_id'   => $storeId,
           'fileable_type' => Store::class,
        ]);
    }
}
