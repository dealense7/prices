<?php

declare(strict_types=1);

namespace App\Models\Tag;

use App\Models\Model;

/**
 * @property int id
 * @property string name
 * @property int tag_id
 * @property int language_id
 */
class TagTranslation extends Model
{
    protected $table = 'tag_translations';

    protected $fillable = [
        'name',
        'tag_id',
        'language_id',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTagId(): int
    {
        return $this->tag_id;
    }

    public function getLanguageId(): int
    {
        return $this->language_id;
    }
}
