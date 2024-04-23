<?php

namespace App\Enums\Category;

use App\Enums\Languages;

enum SubCategory: int
{
    case BREAD_WHITE           = 1;
    case BREAD_DARK_REY        = 2;
    case FRUIT                 = 3;
    case VEGETABLE             = 4;
    case HERB                  = 5;
    case DAIRY_MILK            = 6;
    case DAIRY_EGG             = 7;
    case DAIRY_CHEESE          = 8;
    case DAIRY_YOGURT          = 9;
    case DAIRY_BUTTER          = 10;
    case DAIRY_SOUR_CREAM      = 11;
    case GROCERY_GRAIN         = 12;
    case GROCERY_SUGAR         = 13;
    case GROCERY_SAUCE         = 14;
    case GROCERY_OIL           = 15;
    case GROCERY_CANNED_FOOD   = 16;
    case GROCERY_PASTA         = 17;
    case GROCERY_HONEY         = 18;
    case GROCERY_SEMI_FINISHED = 19;
    case CHICKEN               = 20;
    case PORK                  = 21;
    case BEEF                  = 22;
    case FISH                  = 23;
    case COLD_DRINK            = 24;
    case JUICE                 = 25;
    case ENERGY_DRINK          = 26;
    case TEA_AND_COFFEE        = 27;
    case WINE                  = 28;
    case BEER                  = 29;
    case VODKA                 = 30;
    case WHISKEY               = 31;
    case OTHER_ALCOHOL         = 32;

    public function getData(): array
    {
        return match ($this) {
            SubCategory::BREAD_WHITE => [
                'parent_id' => Category::BREAD->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'თეთრი პური'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'White Bread'
                ]
            ],
            SubCategory::BREAD_DARK_REY => [
                'parent_id' => Category::BREAD->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'შავი პური'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Dark Rey Bread'
                ]
            ],
            SubCategory::FRUIT => [
                'parent_id' => Category::VEGETABLE_AND_FRUIT->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ხილი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Fruit'
                ]
            ],
            SubCategory::VEGETABLE => [
                'parent_id' => Category::VEGETABLE_AND_FRUIT->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ბოსტნეული'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Vegetable'
                ]
            ],
            SubCategory::HERB => [
                'parent_id' => Category::VEGETABLE_AND_FRUIT->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'მწვანილები'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Herbs'
                ]
            ],
            SubCategory::DAIRY_MILK => [
                'parent_id' => Category::DAIRY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'რძე'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Milk'
                ]
            ],
            SubCategory::DAIRY_EGG => [
                'parent_id' => Category::DAIRY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'კვერცხი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Egg'
                ]
            ],
            SubCategory::DAIRY_CHEESE => [
                'parent_id' => Category::DAIRY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ყველი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Cheese'
                ]
            ],
            SubCategory::DAIRY_YOGURT => [
                'parent_id' => Category::DAIRY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'იოგურტი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Yogurt'
                ]
            ],
            SubCategory::DAIRY_BUTTER => [
                'parent_id' => Category::DAIRY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'კარაქი, მარგარინი, სპრედი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Butter, Margarine, Spread'
                ]
            ],
            SubCategory::DAIRY_SOUR_CREAM => [
                'parent_id' => Category::DAIRY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'მაწონი, არაჟანი, ხაჭო'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Matsoni, Sour Cream, Cottage cheese'
                ]
            ],
            SubCategory::GROCERY_GRAIN => [
                'parent_id' => Category::GROCERY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'მაწონი, არაჟანი, ხაჭო'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Matsoni, Sour Cream, Cottage cheese'
                ]
            ],
            SubCategory::GROCERY_SUGAR => [
                'parent_id' => Category::GROCERY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'შაქარი, მარილი, ფქვილი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Sugar, Salt, Flour'
                ]
            ],
            SubCategory::GROCERY_SAUCE => [
                'parent_id' => Category::GROCERY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'სოუსები'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Sauces'
                ]
            ],
            SubCategory::GROCERY_OIL => [
                'parent_id' => Category::GROCERY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ზეთი, ძმარი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Oil, Vinegar'
                ]
            ],
            SubCategory::GROCERY_CANNED_FOOD => [
                'parent_id' => Category::GROCERY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'კონსერვები'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Canned Food'
                ]
            ],
            SubCategory::GROCERY_PASTA => [
                'parent_id' => Category::GROCERY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'პასტა'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Pasta'
                ]
            ],
            SubCategory::GROCERY_HONEY => [
                'parent_id' => Category::GROCERY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'თაფლი, ჯემი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Honey, Jam'
                ]
            ],
            SubCategory::GROCERY_SEMI_FINISHED => [
                'parent_id' => Category::GROCERY->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ნახევარფაბრიკატები'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Semi Finished'
                ]
            ],
            SubCategory::CHICKEN => [
                'parent_id' => Category::MEAT_AND_FISH->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ქათამი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Chicken'
                ]
            ],
            SubCategory::PORK => [
                'parent_id' => Category::MEAT_AND_FISH->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ღორი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Pork'
                ]
            ],
            SubCategory::BEEF => [
                'parent_id' => Category::MEAT_AND_FISH->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'საქონელი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Beef'
                ]
            ],
            SubCategory::FISH => [
                'parent_id' => Category::MEAT_AND_FISH->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'თევზი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Fish'
                ]
            ],
            SubCategory::COLD_DRINK => [
                'parent_id' => Category::NON_ALCOHOLIC_DRINKS->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ცივი სასმელები'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Cold Drinks'
                ]
            ],
            SubCategory::JUICE => [
                'parent_id' => Category::NON_ALCOHOLIC_DRINKS->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'წვენი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Juice'
                ]
            ],
            SubCategory::ENERGY_DRINK => [
                'parent_id' => Category::NON_ALCOHOLIC_DRINKS->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ენერგეტიკული სასმელები'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Energy Drinks'
                ]
            ],
            SubCategory::TEA_AND_COFFEE => [
                'parent_id' => Category::NON_ALCOHOLIC_DRINKS->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ჩაი და ყავა'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Tea and Coffee'
                ]
            ],
            SubCategory::WINE => [
                'parent_id' => Category::ALCOHOLIC_DRINKS->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ღვინო'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Wine'
                ]
            ],
            SubCategory::BEER => [
                'parent_id' => Category::ALCOHOLIC_DRINKS->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ლუდი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Beer'
                ]
            ],
            SubCategory::VODKA => [
                'parent_id' => Category::ALCOHOLIC_DRINKS->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'არაყი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Vodka'
                ]
            ],
            SubCategory::WHISKEY => [
                'parent_id' => Category::ALCOHOLIC_DRINKS->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ვისკი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Whiskey'
                ]
            ],
            SubCategory::OTHER_ALCOHOL => [
                'parent_id' => Category::ALCOHOLIC_DRINKS->value,
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'სხვა ალკოჰოლი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Other Alcohol'
                ]
            ],
        };
    }
}