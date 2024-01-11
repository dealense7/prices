<?php

namespace App\Models;


use App\Enums\TagType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 */
class Product extends Model
{
    protected $fillable = [
        'name',
        'code',
        'show',
        'company_id'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function images(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_to_categories');
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
}
