<?php

declare(strict_types=1);

namespace App\Models;

/**
 * @property int id
 * @property string name
 * @property string class
 */
class Provider extends Model
{
    protected $fillable = [
        'name',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getClass(): string
    {
        return $this->class;
    }
}
