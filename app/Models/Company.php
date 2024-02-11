<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property int id
 * @property string name
 * @property boolean show
 *
 * @method filterByKeyword(array $filters): Builder
 */
class Company extends Model
{
    protected $fillable = [
        'name',
        'show',
        'parent_id',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getShow(): bool
    {
        return $this->show;
    }

    public function scopeFilterByKeyword(Builder $builder, array $filters): Builder
    {
        return $builder->when(! empty($filters['keyword']), static function (Builder $query) use ($filters) {
            $keyword = $filters['keyword'];
            $query->where('name', 'like', '%' . $keyword . '%');
        });
    }
}
