<?php

namespace App\Models\Product;


use App\Models\Model;
use App\Models\Store;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int product_id
 * @property int store_id
 * @property int provider_id
 * @property int price
 */
class ProductPrice extends Model
{
    protected $fillable = [
        'product_id',
        'store_id',
        'provider_id',
        'price',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getStoreId(): int
    {
        return $this->store_id;
    }

    public function getProviderId(): int
    {
        return $this->provider_id;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
