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

        /** @var TagType $item */
        foreach ($items as $item) {

            Tag::query()->create(
               [
                  'id'   => $item->value,
                  'type' => $item->value
               ]
            );

            foreach ($item->text() as $languageId => $translation) {
                TagTranslation::query()->create([
                   'tag_id'      => $item->value,
                   'language_id' => $languageId,
                   'name'        => $translation
                ]);
            }
        }
    }
}
