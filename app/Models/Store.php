<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property int id
 * @property string name
 * @property int year
 * @property Collection<Url> urls
 */
class Store extends Model
{
    protected $fillable = [
        'name',
        'year',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function urls(): HasMany
    {
        return $this->hasMany(Url::class, 'store_id');
    }

    public function logo(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
