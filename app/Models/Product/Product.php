<?php

namespace App\Models\Product;


use App\Enums\Languages;
use App\Enums\TagType;
use App\Models\Category\Category;
use App\Models\Company;
use App\Models\File;
use App\Models\Model;
use App\Models\Tag\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property int company_id
 * @property string name
 * @property string code
 * @property boolean show
 *
 * @property Collection prices
 * @property Collection images
 *
 * @method filterByKeyword(array $filters): Builder
 * @method filterByCategory(array $filters): Builder
 */
class Product extends Model
{
    protected $fillable = [
        'code',
        'show',
        'company_id'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getNameAttribute(): string
    {
        return $this->translation->name;
    }

    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    public function getShow(): bool
    {
        return $this->show;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getQuantityAttribute(): string
    {
        $tag = $this->tags->first();
        return match ($tag->type) {
            TagType::Size->value => $this->calculateSize($tag),
            TagType::Weight->value => $this->calculateWeight($tag),
            TagType::Quantity->value => intval($tag->name)
        };
    }

    public function getSizeAttribute(): string
    {
        $tag = $this->tags->first();
        return match ($tag->type) {
            TagType::Size->value => 'მლ',
            TagType::Weight->value => 'გრ',
            TagType::Quantity->value => 'ერთ'
        };
    }

    private function calculateSize($tag): string
    {
        $size = floatval($tag->name);

        if (str_contains($tag->name, ' ლ')) {
            $size *= 1000;
        }

        return $size;
    }

    private function calculateWeight($tag): string
    {
        $size = floatval($tag->name);

        if (str_contains($tag->name, 'კგ')) {
            $size *= 1000;
        }

        return $size;
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class, 'product_id')->where('active', true)->orderBy('price');
    }

    public function translation(): HasOne
    {
        return $this->hasOne(ProductTranslation::class, 'product_id')->where('language_id', Languages::Georgian->value);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class, 'product_id');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_to_categories');
    }

    public function parentCategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_to_categories', 'product_id', 'parent_category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tags_to_products');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function scopeFilterByKeyword(Builder $builder, array $filters): Builder
    {
        return $builder->when(!empty($filters['keyword']), static function (Builder $query) use ($filters) {
            $keyword = $filters['keyword'];
            $query->where('name', 'like', '%'.$keyword.'%');
        });
    }

    public function scopeFilterByCategories(Builder $builder, array $filters): Builder
    {
        return $builder->when(!empty($filters['categoryIds']), static function (Builder $query) use ($filters) {
            $categoryIds = $filters['categoryIds'];
            $query->whereHas('categories', static function (Builder $query) use ($categoryIds) {
                $query->whereIn('id', $categoryIds);
            });
        });
    }

    public function scopeFilterByParentCategories(Builder $builder, array $filters): Builder
    {
        return $builder->when(!empty($filters['parentCategoryIds']), static function (Builder $query) use ($filters) {
            $categoryIds = $filters['parentCategoryIds'];
            $query->whereHas('parentCategories', static function (Builder $query) use ($categoryIds) {
                $query->whereIn('id', $categoryIds);
            });
        });
    }
}


