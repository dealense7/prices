<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Actions\SaveFetchedProduct;
use App\Models\Category\Category;
use App\Models\Language;
use App\Parsers\OriNabijiParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FetchProducts extends Command
{
    protected $signature = 'app:fetch-products';

    protected $description = 'Command description';

    public function handle(): void
    {
        $languages  = Language::query()->get();
        $categories = Category::query()->with('children')->whereNull('parent_id')->get();
        foreach ($categories as $category) {
            $data = Http::withoutVerifying()
                ->post(
                    'https://catalog-api.orinabiji.ge/catalog/api/products/search?lang=ge&sortField=isInStock&sortDirection=-1',
                    [
                        'categoryIds' => $category->children->pluck('foreignId')->toArray(),
                        'limit'       => 10000,
                        'skip'        => 0,
                    ]
                )->json();

            DB::transaction(static function () use ($data, $category, $languages) {
                SaveFetchedProduct::dispatch((new OriNabijiParser())->getItems($data), $category->children, $languages);
            });
        }
    }
}
