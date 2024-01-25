<?php

namespace Database\Seeders;

use App\Enums\TagType;
use App\Models\Tag\Tag;
use App\Models\Tag\TagTranslation;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            TagType::Size,
            TagType::Quantity,
            TagType::Weight,
        ];

        $tags = Tag::query()->get();

        /** @var TagType $item */
        foreach ($items as $item) {

            if ($tags->firstWhere('id', $item->value) === null) {
                $tagId = Tag::query()->firstOrCreate(
                    [
                        'id'   => $item->value,
                        'type' => $item->value
                    ]
                );

                foreach ($item->text() as $languageId => $translation) {
                    TagTranslation::query()->create([
                        'tag_id'      => $tagId,
                        'language_id' => $languageId,
                        'name'        => $translation
                    ]);
                }
            }

        }
    }
}
