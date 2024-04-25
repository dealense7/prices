<?php

namespace Database\Seeders;

use App\Enums\Category\SubCategory;
use App\Enums\Category\Category;
use Illuminate\Database\Seeder;
use \App\Models\Category\Category as CategoryModel;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {

        $categories = [
            Category::BREAD,
            Category::VEGETABLE_AND_FRUIT,
            Category::DAIRY,
            Category::GROCERY,
            Category::MEAT_AND_FISH,
            Category::ALCOHOLIC_DRINKS,
            Category::NON_ALCOHOLIC_DRINKS,
        ];

        $subCategory = [
            SubCategory::BREAD_WHITE,
            SubCategory::BREAD_DARK_REY,
            SubCategory::FRUIT,
            SubCategory::VEGETABLE,
            SubCategory::HERB,
            SubCategory::DAIRY_MILK,
            SubCategory::DAIRY_EGG,
            SubCategory::DAIRY_CHEESE,
            SubCategory::DAIRY_YOGURT,
            SubCategory::DAIRY_BUTTER,
            SubCategory::DAIRY_SOUR_CREAM,
            SubCategory::GROCERY_GRAIN,
            SubCategory::GROCERY_SUGAR,
            SubCategory::GROCERY_SAUCE,
            SubCategory::GROCERY_OIL,
            SubCategory::GROCERY_CANNED_FOOD,
            SubCategory::GROCERY_PASTA,
            SubCategory::GROCERY_HONEY,
            SubCategory::GROCERY_SEMI_FINISHED,
            SubCategory::CHICKEN,
            SubCategory::PORK,
            SubCategory::BEEF,
            SubCategory::FISH,
            SubCategory::COLD_DRINK,
            SubCategory::JUICE,
            SubCategory::WATER,
            SubCategory::ENERGY_DRINK,
            SubCategory::TEA_AND_COFFEE,
            SubCategory::WINE,
            SubCategory::BEER,
            SubCategory::VODKA,
            SubCategory::WHISKEY,
            SubCategory::OTHER_ALCOHOL
        ];

        /** @var Category $category */
        foreach ($categories as $category) {
            /** @var CategoryModel $item */
            $item = CategoryModel::query()->firstOrCreate(
                [
                    'id'   => $category->value,
                    'slug' => Str::slug($category->name)
                ]
            );

            foreach ($category->getData() as $translations) {
                $item->translations()->updateOrCreate($translations);
            }
        }

        /** @var SubCategory $category */
        foreach ($subCategory as $category) {
            /** @var CategoryModel $item */
            $item = CategoryModel::query()->firstOrCreate(
                [
                    'id'        => $category->value,
                    'parent_id' => $category->getData()['parent_id'],
                    'slug'      => Str::slug($category->name)
                ]
            );

            $translations = $category->getData();
            unset($translations['parent_id']);
            foreach ($translations as $translation) {
                $item->translations()->updateOrCreate($translation);
            }
        }
    }
}


ბეილისი ლიქიორი 0.7 ლ
შერიდანი ლიქიორი 0.7 ლ
კამპარი ლიქიორი 12წ 1ლ
GOMI ლიქიორი ბლის 0.5ლ
ჯეკ დანიელსის თაფლის ლიქიორი 0.7 ლ 35% Vol





