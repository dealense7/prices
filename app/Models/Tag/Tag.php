<?php

namespace App\Models\Tag;


use App\Enums\Languages;
use App\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property int parent_id
 * @property int type
 * @property boolean show
 *
 * @method filterByKeyword(array $filters): Builder
 */
class Tag extends Model
{
    protected $fillable = [
        'show',
        'type',
        'parent_id'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getParentId(): int
    {
        return $this->parent_id;
    }

    public function getType(): int
    {
        return $this->type;
    }


    public function getShow(): bool
    {
        return $this->show;
    }

    public function children(): HasMany
    {
        return $this->hasMany(Tag::class, 'parent_id');
    }

    public function translation(): HasOne
    {
        return $this->hasOne(TagTranslation::class, 'tag_id')->where('language_id', Languages::Georgian->value);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(TagTranslation::class, 'tag_id');
    }

    public function scopeFilterByKeyword(Builder $builder, array $filters): Builder
    {
        return $builder->when(!empty($filters['keyword']), static function (Builder $query) use ($filters) {
            $keyword = $filters['keyword'];
            $query->where('name', 'like', '%'.$keyword.'%');
            $query->orWhereHas('children', static function (Builder $query) use ($keyword) {
                $query->where('name', 'like', '%'.$keyword.'%');
            });
        });
    }
}
