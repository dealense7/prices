<?php

namespace App\Enums\Category;

use App\Enums\Languages;

enum Category: int
{
    case VEGETABLE_AND_FRUIT  = 1;
    case MEAT_AND_FISH        = 2;
    case DAIRY                = 3;
    case GROCERY              = 4;
    case BREAD                = 5;
    case ALCOHOLIC_DRINKS     = 6;
    case NON_ALCOHOLIC_DRINKS = 7;

    public function getData(): array
    {
        return match ($this) {
            Category::BREAD => [
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'პური'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Bread'
                ]
            ],
            Category::VEGETABLE_AND_FRUIT => [
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ბოსტნეული და ხილი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Vegetable and Fruit'
                ]
            ],
            Category::DAIRY => [
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'რძის ნაწარმი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Dairy'
                ]
            ],
            Category::GROCERY => [
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ბაკალეა'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Grocery'
                ]
            ],
            Category::MEAT_AND_FISH => [
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ხორცი და თევზი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Meat and Fish'
                ]
            ],
            Category::ALCOHOLIC_DRINKS => [
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'ალკოჰოლი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Alcoholic Drink'
                ]
            ],
            Category::NON_ALCOHOLIC_DRINKS => [
                [
                    'language_id' => Languages::Georgian->value,
                    'name'        => 'უალკოჰოლო სასმელი'
                ],
                [
                    'language_id' => Languages::English->value,
                    'name'        => 'Non Alcoholic Drinks'
                ]
            ],
        };
    }
}
