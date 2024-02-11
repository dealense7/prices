<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Languages;
use App\Models\Category\Category;
use App\Models\Language;
use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;

class CreateCategories extends Command
{
    protected $signature = 'app:fetch-categories';

    protected $description = 'Command description';

    public function handle(): void
    {
        $languages = Language::query()->get();
        /** @var \App\Models\Language $language */

        foreach ($languages as $language) {
            $slug = $language->getId() === Languages::Georgian->value ? 'ge' : 'en';
            $data = Http::withoutVerifying()
                ->get('https://2nabiji.ge/_next/data/13Jh8-z8SgieOuXt1qaRv/' . $slug . '/category/thambaqos-natsarmi-102.json?lang=ge&category-slug=thambaqos-natsarmi-102')
                ->json();

            // Create parents
            foreach (collect($data['pageProps']['categories'])->whereNull('parent') as $parentCategory) {
                /** @var \App\Models\Category\Category $category */
                $category = Category::query()->firstOrCreate(
                    [
                        'foreignId' => $parentCategory['_id'],
                    ],
                    [
                        'foreignId' => $parentCategory['_id'],
                        'slug'      => $parentCategory['nameSlug'],
                    ]
                );

                $category->translations()->create([
                    'language_id' => $language->getId(),
                    'name'        => $parentCategory['name'],
                ]);
            }

            $categories = Category::query()->get();

            foreach (collect($data['pageProps']['categories'])->whereNotNull('parent') as $childCategory) {
                $parentCategoryId = $categories->firstWhere('foreignId', $childCategory['parent']);
                if ($parentCategoryId !== null) {
                    $category = Category::query()->firstOrCreate(
                        [
                            'foreignId' => $childCategory['_id'],
                        ],
                        [
                            'foreignId' => $childCategory['_id'],
                            'slug'      => $childCategory['nameSlug'],
                            'parent_id' => $parentCategoryId->getId(),
                        ]
                    );

                    $category->translations()->create([
                        'language_id' => $language->getId(),
                        'name'        => $childCategory['name'],
                    ]);
                }
            }
        }
    }

    private function getStores(): Collection
    {
        return Store::query()->with([
            'urls.provider',
        ])->get();
    }

    private function getKeywords(): array
    {
        return [
            'ქათამი',
            'ძეხვი',
            'სოსისი',
            'კვერცხი',
            'ლუდი',
            'პური',
            'გაზიანი',
            'პური',
        ];
    }
}
