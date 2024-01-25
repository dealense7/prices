<?php

namespace App\Models\Product;


use App\Models\Model;

/**
 * @property int id
 * @property string name
 * @property int product_id
 * @property int language_id
 */
class ProductTranslation extends Model
{
    protected $table = 'product_translations';

    protected $fillable = [
        'name',
        'product_id',
        'language_id'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getLanguageId(): int
    {
        return $this->language_id;
    }
}
