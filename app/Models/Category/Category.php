<?php

namespace App\Models\Category;

use App\Enums\Languages;
use App\Models\Model;
use App\Models\Product\Product;
use App\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property int parent_id
 * @property string slug
 * @property boolean show
 *
 * @property Collection translations
 *
 * @method filterByKeyword(array $filters): Builder
 */
class Category extends Model
{
    protected $fillable = [
        'slug',
        'show',
        'parent_id',
        'foreignId'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getNameAttribute(): string
    {
        return $this->translation->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getParentId(): int
    {
        return $this->parent_id;
    }

    public function getShow(): bool
    {
        return $this->show;
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function translation(): HasOne
    {
        return $this->hasOne(CategoryTranslation::class, 'category_id')->where('language_id', Languages::Georgian->value);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_to_categories');
    }

    public function allProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_to_categories', 'parent_category_id');
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
