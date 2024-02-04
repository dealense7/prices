<?php

namespace App\Console\Commands;

use App\Enums\Languages;
use App\Enums\Stores;
use App\Jobs\SaveFetchedPrices;
use App\Jobs\SaveFetchedProduct;
use App\Models\Category\Category;
use App\Models\Category\CategoryTranslation;
use App\Models\Product\Product;
use App\Models\Store;
use App\Models\Url;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class FetchData extends Command
{
    protected $signature = 'app:fetch-data';

    protected $description = 'Command description';

    public function handle(): void
    {
        $stores   = $this->getStores();
        $keywords = $this->getKeywords();

        /** @var Store $store */
        foreach ($stores as $store) {
            $start = time();

            /** @var Url $url */
            foreach ($store->urls as $url) {
                $parser = $url->resolveProvider();
                dump($store->getName());

                foreach ($keywords as $word) {
                    $parser->fetchData($word['name']);
                    $fetchedItems = $parser->getItems();

//                    SaveFetchedProduct::dispatch($fetchedItems, $store->getId(), $word['category_id'], $word['parent_category_id']);
                    SaveFetchedPrices::dispatch($fetchedItems, $store->getId(), $url->provider->getId());
                }

            }
            $end = time();
            dump($end - $start);
            dump('sleep for 10 secs');
            sleep(10);

        }
    }

    private function getStores(): Collection
    {
        return Store::query()
            ->where('id', Stores::Nikora->value)
            ->with([
                'urls.provider'
            ])->get();
    }


    private function getKeywords(): array
    {
        $allCategory = Category::query()->whereNotNull('parent_id')->get();
        $items       = CategoryTranslation::query()
            ->where('language_id', Languages::Georgian->value)
            ->whereIn('category_id', $allCategory->pluck('id')->toArray())
            ->get();
        $categories  = [];
        foreach ($items as $item) {
            if (str_contains($item->getName(), '&')) {
                $arr = explode('&', $item->getName());
                foreach ($arr as $k => $v) {
                    $categories[] = [
                        'name'               => trim($v),
                        'category_id'        => $item->category_id,
                        'parent_category_id' => $allCategory->firstWhere('id', $item->category_id)->parent_id,
                    ];
                }
            } else {
                $categories[] = [
                    'name'               => $item->getName(),
                    'category_id'        => $item->category_id,
                    'parent_category_id' => $allCategory->firstWhere('id', $item->category_id)->parent_id,
                ];
            }
        }

        return $categories;
    }
}


//namespace App\Console\Commands;
//
//use App\Enums\Languages;
//use App\Enums\TagType;
//use App\Models\Product\Product;
//use App\Models\Product\ProductTranslation;
//use App\Models\Tag\Tag;
//use App\Models\Tag\TagTranslation;
//use Illuminate\Console\Command;
//use Illuminate\Support\Facades\DB;
//
//class FetchData extends Command
//{
//    protected $signature = 'app:fetch-data';
//
//    protected $description = 'Command description';
//
//    public function handle(): void
//    {
//        $items = ProductTranslation::query()->where('name', 'like', '%ლ%')->get();
//
//        foreach ($items as $item) {
//            $name = $item->name;
//
//            $tagValue = $this->getTag($name);
//            $tagName  = $this->getTagName($name);
//
//            if (in_array($tagName, ['ლ'])) {
//                if (floatval($tagValue) < 1) {
//                    $tagValue = $tagValue * 1000;
//                    $tagName  = 'მლ';
//                }
//
//                $tagId = DB::table((new TagTranslation())->getTable())->where('name',
//                    $tagValue.' '.$tagName)->first()?->tag_id;
//
//                if ($tagId == null) {
//                    $tagId = DB::table((new Tag())->getTable())->insertGetId([
//                        'type'      => TagType::Size,
//                        'parent_id' => TagType::Size->value
//                    ]);
//
//                    DB::table((new TagTranslation())->getTable())
//                        ->insert([
//                            'tag_id'      => $tagId,
//                            'language_id' => Languages::Georgian->value,
//                            'name'        => $tagValue.' '.$tagName,
//                        ]);
//                }
//
//                if (
//                    DB::table((new Product())->tags()->getTable())
//                        ->where('product_id', $item->id)->count() === 0
//                ) {
//                    DB::table((new Product())->tags()->getTable())
//                        ->insert([
//                            'product_id' => $item->id,
//                            'tag_id'     => $tagId
//                        ]);
//                } else {
//                    dump('11');
//                }
//            }
//
//        }
//    }
//
//    public function getTag(string $tag): ?string
//    {
//        preg_match('/(\d+(?:\.\d+)?)\s*(ლ|მლ|კგ|გრ|გ|ც)/', $tag, $matches);
//
//        return data_get($matches, 1, '');
//    }
//
//    public function getTagName(string $tag): ?string
//    {
//        preg_match('/(\d+(?:\.\d+)?)\s*(ლ|მლ|კგ|გრ|გ|ც)/', $tag, $matches);
//
//        return (!empty($matches[2]) ? $matches[2] : data_get($matches, 3));
//    }
//
//}
