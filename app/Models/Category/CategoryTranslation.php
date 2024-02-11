<?php

declare(strict_types=1);

namespace App\Models\Category;

use App\Models\Model;

/**
 * @property int id
 * @property string name
 * @property int category_id
 * @property int language_id
 */
class CategoryTranslation extends Model
{
    protected $table = 'category_translations';

    protected $fillable = [
        'name',
        'category_id',
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

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function getLanguageId(): int
    {
        return $this->language_id;
    }
}
