<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int store_id
 * @property int provider_id
 * @property string url
 * @property Provider provider
 */
class Url extends Model
{
    protected $fillable = [
        'store_id',
        'provider_id',
        'url',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getStoreId(): int
    {
        return $this->store_id;
    }

    public function getProviderId(): int
    {
        return $this->provider_id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
