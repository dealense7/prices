<?php

namespace App\Models\Product;

use App\Models\Model;

/**
 * @property int id
 * @property int product_id
 * @property string code
 */
class BarCode extends Model
{
    protected $fillable = [
       'product_id',
       'code',
    ];

    protected $casts = [
       'show' => 'boolean'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
