<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int id
 * @property string name
 * @property string path
 * @property int size
 * @property string extension
 * @property string fileable_id
 * @property string fileable_type
 */
class File extends Model
{
    protected $fillable = [
        'name',
        'path',
        'size',
        'extension',
        'fileable_id',
        'fileable_type',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getFileableId(): string
    {
        return $this->fileable_id;
    }

    public function getFileableType(): string
    {
        return $this->fileable_type;
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
