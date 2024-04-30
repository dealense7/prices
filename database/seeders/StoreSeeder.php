<?php

namespace Database\Seeders;

use App\Enums\Category\SubCategory;
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
                        'url'         => 'https://restaurant-api.wolt.com/v4/venues/slug/carrefour-vake/menu/categories/slug/itemcategory-73?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                    ],
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
                        'provider_id' => Providers::Goodwill->value,
                        'url'         => 'https://api.goodwill.ge/v1/Products/v3?ShopId=1&CategoryId=32&Page=1&Limit=1000'
                    ],
                    [
                        'provider_id' => Providers::Goodwill->value,
                        'url'         => 'https://api.goodwill.ge/v1/Products/v3?ShopId=1&CategoryId=29&Page=1&Limit=1000'
                    ],
                    [
                        'provider_id' => Providers::Goodwill->value,
                        'url'         => 'https://api.goodwill.ge/v1/Products/v3?ShopId=1&CategoryId=34&Page=1&Limit=1000'
                    ],
                    [
                        'provider_id' => Providers::Goodwill->value,
                        'url'         => 'https://api.goodwill.ge/v1/Products/v3?ShopId=1&CategoryId=38&Page=1&Limit=1000'
                    ],
                    [
                        'provider_id' => Providers::Goodwill->value,
                        'url'         => 'https://api.goodwill.ge/v1/Products/v3?ShopId=1&CategoryId=12&Page=1&Limit=1000'
                    ],
                    [
                        'provider_id' => Providers::Goodwill->value,
                        'url'         => 'https://api.goodwill.ge/v1/Products/v3?ShopId=1&CategoryId=30&Page=1&Limit=100'
                    ],
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
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=bakalea-sc.393435411%2Fburghuli-c.2274361938&categoryId='.SubCategory::GROCERY_GRAIN->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=bakalea-sc.393435411%2Fmakaroni-c.2274361957&categoryId='.SubCategory::GROCERY_PASTA->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=bakalea-sc.393435411%2Fsousi-da-topingi-c.2274361675&categoryId='.SubCategory::GROCERY_SAUCE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=bakalea-sc.393435411%2Fshaqari-marili-da-suneli-c.2274361908&categoryId='.SubCategory::GROCERY_SUGAR->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=bakalea-sc.393435411%2Fzeti-da-dzmari-c.2274361681&categoryId='.SubCategory::GROCERY_OIL->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=bakalea-sc.393435411%2Fphqvili-da-satskhobi-sashualebebi-c.2274361759&categoryId='.SubCategory::GROCERY_SUGAR->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=rdzis-produqtebi-kvertskhi-sc.393435425%2Fkvertskhi-da-maionezi-c.2274361894&categoryId='.SubCategory::DAIRY_EGG->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=rdzis-produqtebi-kvertskhi-sc.393435425%2Frdze-da-naghebi-c.2274361876&categoryId='.SubCategory::DAIRY_MILK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=rdzis-produqtebi-kvertskhi-sc.393435425%2Fiogurti-da-deserti-c.2274361897&categoryId='.SubCategory::DAIRY_YOGURT->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=ualkoholo-sasmeli-sc.393435430%2Fmineraluri-da-sasmeli-tskali-c.2274361956&categoryId='.SubCategory::WATER->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=ualkoholo-sasmeli-sc.393435430%2Fgamagrilebeli-gaziani-da-matonizirebeli-sasmeli-c.2274361924&categoryId='.SubCategory::COLD_DRINK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=ualkoholo-sasmeli-sc.393435430%2Ftsveni-da-kompoti-c.2274361909&categoryId='.SubCategory::JUICE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=ualkoholo-sasmeli-sc.393435430%2Ftsivi-kava-da-chai-c.2274362213&categoryId='.SubCategory::TEA_AND_COFFEE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/169869/addresses/595140/content?nodeType=DEEP_LINK&link=alkoholuri-sasmeli-sc.393435415%2Fludi-c.2274361671&categoryId='.SubCategory::BEER->value
                    ],
                ]
            ],
            [
                'id'   => Stores::Europroduct->value,
                'name' => Stores::Europroduct->text(),
                'year' => 2015,
                'img'  => 'europroduct.png',
                'urls' => [
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=kvertskhi-da-rdzis-produqtebi-sc.393906525%2Fkvertskhi-da-kveli-c.2277012522&categoryId='.SubCategory::DAIRY_EGG->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=kvertskhi-da-rdzis-produqtebi-sc.393906525%2Frdzis-produqtebi-c.2277012535&categoryId='.SubCategory::DAIRY_MILK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=sasmelebi-sc.393906526%2Fgaziani-sasmelebi-c.2277012571&categoryId='.SubCategory::COLD_DRINK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=sasmelebi-sc.393906526%2Ftsveni-tsivi-kava-tsivi-chai-c.2277012581&categoryId='.SubCategory::JUICE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=sasmelebi-sc.393906526%2Fmineraluri-da-sasmeli-tskali-c.2277012593&categoryId='.SubCategory::WATER->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=sasmelebi-sc.393906526%2Fludi-c.2277012608&categoryId='.SubCategory::BEER->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=sasmelebi-sc.393906526%2Fghvino-c.2277012607&categoryId='.SubCategory::WINE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=sasmelebi-sc.393906526%2Fskhva-alkoholuri-sasmelebi-c.2277012631&categoryId='.SubCategory::OTHER_ALCOHOL->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=puri-tsomeuli-sc.393906527%2Fpuri-c.2277012669&categoryId='.SubCategory::BREAD_DARK_REY->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=sursati-sc.393906532%2Fzeti-da-dzmari-c.2277012952&categoryId='.SubCategory::GROCERY_OIL->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=sursati-sc.393906532%2Fsousebi-c.2277012978&categoryId='.SubCategory::GROCERY_SAUCE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=sursati-sc.393906532%2Fsaneleblebi-da-satskhobi-masala-c.2277012993&categoryId='.SubCategory::GROCERY_GRAIN->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=sursati-sc.393906532%2Fpasta-makaroni-martsvleuli-c.2277013033&categoryId='.SubCategory::GROCERY_PASTA->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=sursati-sc.393906532%2Fkhilisa-da-bostneulis-konservi-c.2277013055&categoryId='.SubCategory::GROCERY_CANNED_FOOD->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/95869/addresses/181642/content?nodeType=DEEP_LINK&link=gakinuli-produqtsia-sc.393906533%2Fgakinuli-khortsi-da-tevzi-c.2277013077&categoryId='.SubCategory::FISH->value
                    ],
                ]
            ],
            [
                'id'   => Stores::Fresco->value,
                'name' => Stores::Fresco->text(),
                'year' => 2015,
                'img'  => 'fresco.png',
                'urls' => [
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=sursati-bakalea-sc.376767295%2Fshaqari-marili-c.2178370906&categoryId='.SubCategory::GROCERY_SUGAR->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=sursati-bakalea-sc.376767295%2Fkonservatsia-c.2178370878&categoryId='.SubCategory::GROCERY_CANNED_FOOD->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=sursati-bakalea-sc.376767295%2Fzeti-da-dzmari-c.2178370876&categoryId='.SubCategory::GROCERY_OIL->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=rdzis-natsarmi-da-kvertskhi-sc.376767304%2Frdze-naghebi-c.2178370871&categoryId='.SubCategory::DAIRY_MILK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=rdzis-natsarmi-da-kvertskhi-sc.376767304%2Fkaraqi-margarini-c.2178371086&categoryId='.SubCategory::DAIRY_BUTTER->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=rdzis-natsarmi-da-kvertskhi-sc.376767304%2Fkhatcho-arazhani-c.2178370909&categoryId='.SubCategory::DAIRY_SOUR_CREAM->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=rdzis-natsarmi-da-kvertskhi-sc.376767304%2Fkvertskhi-maionezi-c.2178370894&categoryId='.SubCategory::DAIRY_EGG->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=rdzis-natsarmi-da-kvertskhi-sc.376767304%2Fiogurti-deserti-c.2178370903&categoryId='.SubCategory::DAIRY_YOGURT->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=sasmelebi-sc.376767298%2Fgaziani-sasmeli-c.2178370896&categoryId='.SubCategory::COLD_DRINK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=sasmelebi-sc.376767298%2Fmineraluri-tskali-c.2178370866&categoryId='.SubCategory::WATER->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=sasmelebi-sc.376767298%2Ftsveni-c.2178370877&categoryId='.SubCategory::JUICE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=sasmelebi-sc.376767298%2Fenergetikuli-sasmeli-c.2178370984&categoryId='.SubCategory::ENERGY_DRINK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=sasmelebi-sc.376767298%2Fludi-c.2178370861&categoryId='.SubCategory::BEER->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=khorts-produqtebi-tevzi-qatami-sc.376767299%2Ftevzi-khizilala-c.2178370891&categoryId='.SubCategory::FISH->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=gakinuli-produqtsia-sc.376767303%2Fgakinuli-tevzi-da-zghvis-produqtebi-c.2178371093&categoryId='.SubCategory::FISH->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=gakinuli-produqtsia-sc.376767303%2Fgakinuli-khortsi-da-qatmi-c.2178371264&categoryId='.SubCategory::CHICKEN->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=gakinuli-produqtsia-sc.376767303%2Fnakhevarphabrikatebi-c.2178370915&categoryId='.SubCategory::GROCERY_SEMI_FINISHED->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=pur-phuntusheuli-sc.376767301%2Fshavi-puri-c.2178371239&categoryId='.SubCategory::BREAD_DARK_REY->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url'         => 'https://api.glovoapp.com/v3/stores/168002/addresses/286868/content?nodeType=DEEP_LINK&link=khil-bostani-sc.376767306%2Fbostneuli-c.2178370975&categoryId='.SubCategory::VEGETABLE->value
                    ],
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
                        'url'         => '60224d2ba8e27e0010eaffb7,60224d43a8e27e0010eaffb8,60224d5ec51f2700106a9431'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6220d81b241c1900112990c4,6220d9df241c1900112990ce,6220da07241c1900112990cf,6220da8d241c1900112990d1'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6220d84f241c1900112990c6,6221c6ca241c1900112990f7,6221c6e1241c1900112990f8,6221c6f8241c1900112990f9'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6220d8a7241c1900112990c8,6221c724241c1900112990fa,6221c73d241c1900112990fb,6221c760241c1900112990fc,6221c7aa241c1900112990fd'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6220d8df241c1900112990c9,6221c7dc241c1900112990fe,6221c8a8241c1900112990ff'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6220d906241c1900112990ca,6221c8cd241c190011299100,6221c8ea241c190011299101'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6220d944241c1900112990cb,62823152344af000159dd75a,6221c906241c190011299102,6221c921241c190011299103,6221c93d241c190011299104'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6220d974241c1900112990cc,6221c96d241c190011299106,6221c99d241c190011299107,6220d9b7241c1900112990cd'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6221fc8b241c190011299152,60227d9cc51f2700106a943a,6022873ca8e27e0010eaffe2,60228755a8e27e0010eaffe3,6022876dc51f2700106a9452'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6221fca4241c190011299153,6221fcc2241c190011299154,62220406241c190011299169'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6221fcf6241c190011299155,62a7464cf6d4b9001477a549,6222023d241c19001129915d,62220258241c19001129915e'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6222015c241c19001129915b,622204a4241c19001129916c,622204c1241c19001129916d,622204e1241c19001129916e,6222050e241c190011299170,62220533241c190011299171,6222054d241c190011299172'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6220cc56241c19001129908d,6220cc7f241c19001129908e,6220cca3241c190011299090'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '62220921241c190011299189,62220968241c19001129918c,62220984241c19001129918d,622209d2241c19001129918e,622209ec241c19001129918f,62220a06241c190011299190,62220a1f241c190011299191'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '602289bba8e27e0010eaffec,60228a04a8e27e0010eaffed,60228b4aa8e27e0010eaffee,60228b65a8e27e0010eaffef,60228b76c51f2700106a945f,60228bb2c51f2700106a9460'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6222088f241c190011299185,62220937241c19001129918a,6222094e241c19001129918b,60227ec6c51f2700106a943c,62220b13241c190011299195,6222896d241c1900112991a9'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '60227bd6c51f2700106a9435,60227beca8e27e0010eaffc1,6221cb96241c19001129910e,6221cbb7241c19001129910f,6221cbd4241c190011299110,6221cc0f241c190011299113'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '60227c00c51f2700106a9436,602283a9a8e27e0010eaffdd,602283bdc51f2700106a944c,6221cd3a241c190011299114,60227c17a8e27e0010eaffc2'
                    ],
                    [
                        'provider_id' => Providers::OriNabiji->value,
                        'url'         => '6221ca60241c190011299108,6221ca7c241c190011299109,6221cb28241c19001129910b,623c678be0a53f001638960d,6221cb63241c19001129910d,623c6899e0a53f0016389617'
                    ],
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
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=khil-bostneuli-sc.393829344%2Fkhili-c.2276569312&categoryId='.SubCategory::FRUIT->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=khil-bostneuli-sc.393829344%2Fmtsvanili-c.2276570084&categoryId='.SubCategory::HERB->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=rdzis-natsarmi-da-kvertskhi-sc.393829340%2Ftraditsiuli-rdzemzhava-c.2276569365&categoryId='.SubCategory::DAIRY_SOUR_CREAM->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=rdzis-natsarmi-da-kvertskhi-sc.393829340%2Frdze-kephiri-airani-c.2276569815&categoryId='.SubCategory::DAIRY_MILK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=rdzis-natsarmi-da-kvertskhi-sc.393829340%2Fkveli-c.2276569306&categoryId='.SubCategory::DAIRY_CHEESE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=rdzis-natsarmi-da-kvertskhi-sc.393829340%2Fiogurti-deserti-c.2276569557&categoryId='.SubCategory::DAIRY_YOGURT->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=rdzis-natsarmi-da-kvertskhi-sc.393829340%2Fkaraqi-spredi-c.2276569414&categoryId='.SubCategory::DAIRY_BUTTER->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=rdzis-natsarmi-da-kvertskhi-sc.393829340%2Fkvertskhi-maionezi-c.2276569644&categoryId='.SubCategory::DAIRY_EGG->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=ualkoholo-sasmelebi-sc.393829351%2Fgaziani-sasmeli-c.2276569645&categoryId='.SubCategory::COLD_DRINK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=ualkoholo-sasmelebi-sc.393829351%2Fgaziani-sasmeli-c.2276569645&categoryId='.SubCategory::COLD_DRINK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=ualkoholo-sasmelebi-sc.393829351%2Fmineraluri-da-sasmeli-tskali-c.2276569649&categoryId='.SubCategory::WATER->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=ualkoholo-sasmelebi-sc.393829351%2Ftsveni-c.2276569353&categoryId='.SubCategory::JUICE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=ualkoholo-sasmelebi-sc.393829351%2Ftsivi-chai-tsivi-kava-rdziani-koqteili-c.2276570065&categoryId='.SubCategory::TEA_AND_COFFEE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=ualkoholo-sasmelebi-sc.393829351%2Fenergetikuli-da-matonizirebuli-sasmeli-c.2276569910&categoryId='.SubCategory::ENERGY_DRINK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=gakinuli-produqtsia-sc.393829348%2Fkhinkali-da-pelmeni-c.2276569363&categoryId='.SubCategory::GROCERY_SEMI_FINISHED->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=khortsi-da-tevzi-sc.393829347%2Ftevzis-konservatsia-c.2276569548&categoryId='.SubCategory::FISH->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=alkoholuri-sasmelebi-sc.393829336%2Fghvino-da-shushkhuna-ghvino-c.2276570048&categoryId='.SubCategory::WINE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=alkoholuri-sasmelebi-sc.393829336%2Fludi-c.2276569295&categoryId='.SubCategory::BEER->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=alkoholuri-sasmelebi-sc.393829336%2Fviski-c.2276569302&categoryId='.SubCategory::WHISKEY->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=alkoholuri-sasmelebi-sc.393829336%2Faraki-c.2276569818&categoryId='.SubCategory::VODKA->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=alkoholuri-sasmelebi-sc.393829336%2Fromi-tekila-vermuti-c.2276570100&categoryId='.SubCategory::OTHER_ALCOHOL->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=stsraphi-momzadeba-sc.393829333%2Fmarili-da-shaqari-c.2276569359&categoryId='.SubCategory::GROCERY_SUGAR->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=stsraphi-momzadeba-sc.393829333%2Fzeti-da-salatebis-sousebi-c.2276569648&categoryId='.SubCategory::GROCERY_OIL->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=stsraphi-momzadeba-sc.393829333%2Fmakaroni-spageti-da-sousi-c.2276569814&categoryId='.SubCategory::GROCERY_PASTA->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=stsraphi-momzadeba-sc.393829333%2Fkonservatsia-c.2276569354&categoryId='.SubCategory::GROCERY_CANNED_FOOD->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/37350/addresses/174372/content?nodeType=DEEP_LINK&link=stsraphi-momzadeba-sc.393829333%2Fsousebi-c.2276569310&categoryId='.SubCategory::GROCERY_SAUCE->value
                    ],
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
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=pur-phuntusheuli-sc.394021102%2Fpuri-c.2277648242&categoryId='.SubCategory::BREAD_WHITE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=alkoholuri-sasmeli-sc.394021095%2Faraki-da-tchatcha-c.2277647356&categoryId='.SubCategory::VODKA->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=alkoholuri-sasmeli-sc.394021095%2Fviski-koniaki-da-brendi-c.2277647378&categoryId='.SubCategory::WHISKEY->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=alkoholuri-sasmeli-sc.394021095%2Fviski-koniaki-da-brendi-c.2277647378&categoryId='.SubCategory::WHISKEY->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=alkoholuri-sasmeli-sc.394021095%2Fliqiori-da-vermuti-c.2277647377&categoryId='.SubCategory::OTHER_ALCOHOL->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=alkoholuri-sasmeli-sc.394021095%2Fludi-da-saideri-c.2277647287&categoryId='.SubCategory::BEER->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=alkoholuri-sasmeli-sc.394021095%2Fghvino-da-tsqriala-ghvino-c.2277647357&categoryId='.SubCategory::WINE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=ualkoholo-sasmeli-sc.394021097%2Fgaziani-sasmeli-c.2277647388&categoryId='.SubCategory::COLD_DRINK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=ualkoholo-sasmeli-sc.394021097%2Fenergetikuli-da-matonizirebeli-c.2277647406&categoryId='.SubCategory::ENERGY_DRINK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=ualkoholo-sasmeli-sc.394021097%2Ftsveni-da-kompoti-c.2277647405&categoryId='.SubCategory::JUICE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=ualkoholo-sasmeli-sc.394021097%2Ftskali-da-mineraluri-c.2277647448&categoryId='.SubCategory::WATER->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=kvertskhi-da-rdzis-produqtebi-sc.394021094%2Ftraditsiuli-rdzis-produqti-c.2277647285&categoryId='.SubCategory::DAIRY_MILK->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=kvertskhi-da-rdzis-produqtebi-sc.394021094%2Fkvertskhi-c.2277647286&categoryId='.SubCategory::DAIRY_EGG->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=kvertskhi-da-rdzis-produqtebi-sc.394021094%2Fkaraqi-spredi-da-margarini-c.2277647275&categoryId='.SubCategory::DAIRY_BUTTER->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=kvertskhi-da-rdzis-produqtebi-sc.394021094%2Fkveli-c.2277647273&categoryId='.SubCategory::DAIRY_CHEESE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=kvertskhi-da-rdzis-produqtebi-sc.394021094%2Fiogurti-da-deserti-c.2277647274&categoryId='.SubCategory::DAIRY_YOGURT->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=sursati-sc.394021100%2Fzeti-da-dzmari-c.2277648116&categoryId='.SubCategory::GROCERY_OIL->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=sursati-sc.394021100%2Fkonservi-c.2277648052&categoryId='.SubCategory::GROCERY_CANNED_FOOD->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=sursati-sc.394021100%2Fmaionezi-sousi-da-satsebeli-c.2277648053&categoryId='.SubCategory::GROCERY_SAUCE->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=sursati-sc.394021100%2Fmakaroni-c.2277648124&categoryId='.SubCategory::GROCERY_PASTA->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=sursati-sc.394021100%2Fmartsvleuli-da-burghuli-c.2277648117&categoryId='.SubCategory::GROCERY_GRAIN->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=gakinuli-produqtsia-sc.394021105%2Fgakinuli-khortsi-da-tevzi-c.2277648485&categoryId='.SubCategory::CHICKEN->value
                    ],
                    [
                        'provider_id' => Providers::Glovo->value,
                        'url' => 'https://api.glovoapp.com/v3/stores/26609/addresses/369777/content?nodeType=DEEP_LINK&link=gakinuli-produqtsia-sc.394021105%2Fnakhevarphabrikatebi-c.2277648451&categoryId='.SubCategory::GROCERY_SEMI_FINISHED->value
                    ],
                ]
            ],
            [
                'id'   => Stores::Magniti->value,
                'name' => Stores::Magniti->text(),
                'year' => 2015,
                'img'  => 'magniti.png',
                'urls' => [
                    [
                        'provider_id' => Providers::Wolt->value,
                        'url' => 'https://restaurant-api.wolt.com/v4/venues/slug/magniti-shrosha/menu/categories/slug/itemcategory-23?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                    ],
                    [
                        'provider_id' => Providers::Wolt->value,
                        'url' => 'https://restaurant-api.wolt.com/v4/venues/slug/magniti-shrosha/menu/categories/slug/itemcategory-7?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                    ],
                    [
                        'provider_id' => Providers::Wolt->value,
                        'url' => 'https://restaurant-api.wolt.com/v4/venues/slug/magniti-shrosha/menu/categories/slug/itemcategory-11?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                    ],
                    [
                        'provider_id' => Providers::Wolt->value,
                        'url' => 'https://restaurant-api.wolt.com/v4/venues/slug/magniti-shrosha/menu/categories/slug/itemcategory-4?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                    ],
                    [
                        'provider_id' => Providers::Wolt->value,
                        'url' => 'https://restaurant-api.wolt.com/v4/venues/slug/magniti-shrosha/menu/categories/slug/--24?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                    ],
                    [
                        'provider_id' => Providers::Wolt->value,
                        'url' => 'https://restaurant-api.wolt.com/v4/venues/slug/magniti-shrosha/menu/categories/slug/itemcategory-22?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                    ],
                    [
                        'provider_id' => Providers::Wolt->value,
                        'url' => 'https://restaurant-api.wolt.com/v4/venues/slug/magniti-shrosha/menu/categories/slug/--21?unit_prices=true&show_weighted_items=true&show_subcategories=true'
                    ],
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
