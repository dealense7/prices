<?php

namespace Database\Seeders;

use App\Models\Category\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'პური'            => [
                'თეთრი პური',
                'შავი პური',
            ],
            'სასმელები'       => [
                'გაზიანი სასმელები',
                'ლუდი'
            ],
            'ხორცი და ქათამი' => [
                'ქათამი',
                'კვერცხი',
            ],
            'ძეხვეული'        => [
                'სოსისი',
                'ძეხვი',
            ],
        ];

        foreach ($items as $name => $children) {
            /** @var Category $category */
            $category = Category::query()->firstOrCreate(
                [
                    'name' => $name
                ], [
                    'name' => $name
                ]
            );

            foreach ($children as $childName) {
                Category::query()->firstOrCreate(
                    [
                        'name' => $childName
                    ], [
                        'name'      => $childName,
                        'parent_id' => $category->getId()
                    ]
                );
            }
        }
    }
}
