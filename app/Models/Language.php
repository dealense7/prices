<?php

namespace App\Models;

/**
 * @property int id
 * @property string name
 * @property string slug
 * @property bool active
 * @property bool is_default
 */
class Language extends Model
{
    protected $table = 'languages';

    protected $fillable = [
        'name',
        'active',
        'slug',
        'is_default',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function getIsActive(): bool
    {
        return $this->is_default;
    }
}
