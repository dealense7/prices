<?php

namespace Database\Seeders;

use App\Enums\TagType;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name'     => TagType::Size->text(),
                'type'     => TagType::Size->value,
                'children' => [
                    '200 მლ',
                    '250 მლ',
                    '300 მლ',
                    '330 მლ',
                    '375 მლ',
                    '355 მლ',
                    '400 მლ',
                    '440 მლ',
                    '450 მლ',
                    '500 მლ',
                    '550 მლ',
                    '660 მლ',
                    '750 მლ',
                    '1 ლ',
                    '1.5 ლ',
                    '2 ლ',
                    '2.35 ლ',
                    '2.5 ლ',
                    '3 ლ',
                    '3.5 ლ',
                    '4 ლ',
                    '4.5 ლ',
                    '5 ლ',
                ]
            ],
            [
                'name'     => TagType::Quantity->text(),
                'type'     => TagType::Quantity->value,
                'children' => [
                    '1',
                    '2',
                    '3',
                    '4',
                    '5',
                    '6',
                    '7',
                    '8',
                    '9',
                    '10',
                    '11',
                    '12',
                    '13',
                    '14',
                    '15',
                ]
            ],
            [
                'name'     => TagType::Weight->text(),
                'type'     => TagType::Weight->value,
                'children' => [
                    '65 გრ',
                    '80 გრ',
                    '100 გრ',
                    '150 გრ',
                    '200 გრ',
                    '250 გრ',
                    '400 გრ',
                    '300 გრ',
                    '330 გრ',
                    '350 გრ',
                    '380 გრ',
                    '420 გრ',
                    '450 გრ',
                    '470 გრ',
                    '500 გრ',
                    '530 გრ',
                    '560 გრ',
                    '590 გრ',
                    '750 გრ',
                    '780 გრ',
                    '800 გრ',
                    '900 გრ',
                    '1 კგ',
                    '1.5 კგ',
                    '2 კგ',
                    '2.5 კგ',
                    '3 კგ',
                    '3.5 კგ',
                    '4 კგ',
                    '4.5 კგ',
                    '5 კგ',
                ]
            ],
            [
                'name'     => TagType::Other->text(),
                'type'     => TagType::Other->value,
                'children' => []
            ],
        ];

        foreach ($items as $item) {
            /** @var Tag $category */
            $category = Tag::query()->firstOrCreate(
                [
                    'name' => $item['name'],
                ], [
                    'type' => $item['type'],
                    'name' => $item['name']
                ]
            );

            foreach ($item['children'] as $childItem) {
                Tag::query()->firstOrCreate(
                    [
                        'name' => $childItem,
                    ], [
                        'type'      => $item['type'],
                        'name'      => $childItem,
                        'parent_id' => $category->getId()
                    ]
                );
            }
        }
    }
}
