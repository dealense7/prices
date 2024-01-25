<?php

namespace Database\Seeders;

use App\Enums\Providers;
use App\Enums\Stores;
use App\Models\File;
use App\Models\Provider;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/70098/addresses/136826/search?query='
                    ]
                ]
            ],
            [
                'id'   => Stores::Goodwill->value,
                'name' => Stores::Goodwill->text(),
                'year' => 2004,
                'img'  => 'goodwill.png',
                'urls' => [
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/182498/search?query='
                    ]
                ]
            ],
            [
                'id'   => Stores::Nikora->value,
                'name' => Stores::Nikora->text(),
                'img'  => 'nikora.jpg',
                'year' => 1998,
                'urls' => [
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/37350/addresses/79560/search?query='
                    ]
                ]
            ],
            [
                'id'   => Stores::Spar->value,
                'name' => Stores::Spar->text(),
                'img'  => 'spar.png',
                'year' => 1932,
                'urls' => [
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/26609/addresses/162083/search?query='
                    ]
                ]
            ],
            [
                'id'   => Stores::Agrohub->value,
                'name' => Stores::Agrohub->text(),
                'year' => 2016,
                'img'  => 'agrohub.png',
                'urls' => [
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/289571/search?query='
                    ]
                ]
            ],
            [
                'id'   => Stores::Agrohub->value,
                'name' => Stores::Agrohub->text(),
                'year' => 2016,
                'img'  => 'agrohub.png',
                'urls' => [
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/289571/search?query='
                    ]
                ]
            ],
            [
                'id'   => Stores::OriNabiji->value,
                'name' => Stores::OriNabiji->text(),
                'year' => 2010,
                'img'  => 'orinabiji.png',
                'urls' => [
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => 'https://catalog-api.orinabiji.ge/catalog/api/products/suggestions?lang=ge&limit=100&sortField=isInStock&sortDirection=-1&searchText='
                    ]
                ]
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

            foreach ($data['urls'] as $urlData) {
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
