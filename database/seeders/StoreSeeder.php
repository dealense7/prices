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
                    'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-vake/menu/categories/slug/--131?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                 ],
                 [
                    'provider_id' => Providers::Wolt->value,
                    'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-vake/menu/categories/slug/itemcategory-139?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                 ],
                 [
                    'provider_id' => Providers::Wolt->value,
                    'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-vake/menu/categories/slug/itemcategory-214?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                 ],
                 [
                    'provider_id' => Providers::Wolt->value,
                    'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-vake/menu/categories/slug/itemcategory-73?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                 ],
                 [
                    'provider_id' => Providers::Wolt->value,
                    'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-vake/menu/categories/slug/itemcategory-124?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                 ],
                 [
                    'provider_id' => Providers::Wolt->value,
                    'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-vake/menu/categories/slug/itemcategory-47?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                 ],
                 [
                    'provider_id' => Providers::Wolt->value,
                    'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-vake/menu/categories/slug/itemcategory-272?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                 ],
                 [
                    'provider_id' => Providers::Wolt->value,
                    'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-vake/menu/categories/slug/itemcategory-23?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                 ],
                 [
                    'provider_id' => Providers::Wolt->value,
                    'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-vake/menu/categories/slug/itemcategory-18?unit_prices=true&show_weighted_items=true&show_subcategories=true'
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
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=kvertskhi-da-rdzis-produqtebi-sc.392626886%2Fkaraqi-spredi-da-margarini-c.2269674828'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=kvertskhi-da-rdzis-produqtebi-sc.392626886%2Fkhatcho-da-khatchos-deserti-c.2269678208'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=kvertskhi-da-rdzis-produqtebi-sc.392626886%2Fkveli-c.2269673010'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=kvertskhi-da-rdzis-produqtebi-sc.392626886%2Frdze-naghebi-rdziani-sasmelebi-c.2269674825'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=tevzi-da-zghvis-produqtebi-sc.392626889%2Ftevzis-kerdzebi-c.2269673826'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=tevzi-da-zghvis-produqtebi-sc.392626889%2Fakhali-tevzi-c.2269673018'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=khil-bostneuli-sc.392626887%2Fmtsvanili-c.2269673028'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=khil-bostneuli-sc.392626887%2Fkhili-c.2269673016'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=khil-bostneuli-sc.392626887%2Fbostneuli-c.2269673005'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=alkoholuri-sasmelebi-sc.392626882%2Fromi-jini-tekila-c.2269673025'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=alkoholuri-sasmelebi-sc.392626882%2Fliqiori-vermuti-c.2269674268'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=alkoholuri-sasmelebi-sc.392626882%2Fviski-c.2269673021'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/search?query=ღვინო&312312312'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=alkoholuri-sasmelebi-sc.392626882%2Faraki-da-tchatcha-c.2269673022'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=alkoholuri-sasmelebi-sc.392626882%2Fludi-c.2269675365'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=ualkoholo-sasmelebi-sc.392626880%2Ftsivi-chai-da-tsivi-kava-c.2269673023'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=ualkoholo-sasmelebi-sc.392626880%2Fenergetikuli-da-matonizirebuli-c.2269675367'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=ualkoholo-sasmelebi-sc.392626880%2Fmineraluri-da-sasmeli-tskali-c.2269674277'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=ualkoholo-sasmelebi-sc.392626880%2Ftsveni-da-kompoti-c.2269674272'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=ualkoholo-sasmelebi-sc.392626880%2Fgaziani-sasmelebi-c.2269675373'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=puri-sc.392626893%2Fshavi-puri-c.2269674270'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=puri-sc.392626893%2Ftetri-puri-c.2269674279'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=bakalea-sc.392626878%2Ftaphli-jemi-c.2269673490'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=bakalea-sc.392626878%2Fpasta-c.2269673007'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=bakalea-sc.392626878%2Fkonservi-c.2269674265'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=bakalea-sc.392626878%2Fzeti-da-dzmari-c.2269673014'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=bakalea-sc.392626878%2Fsousebi-c.2269673015'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=bakalea-sc.392626878%2Fshaqari-marili-phqvili-c.2269673020'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=bakalea-sc.392626878%2Fburghuli-c.2269674276'
                 ],
                 [
                    'provider_id' => Providers::Glovo->value,
                    'url'         => 'https://api.glovoapp.com/v3/stores/96349/addresses/183885/content?nodeType=DEEP_LINK&link=promotions-pr&promoListViewWebVariation=CONTROL'
                 ]
              ]
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
