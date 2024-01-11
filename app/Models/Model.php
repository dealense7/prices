<?php

namespace App\Models;

use App\Support\Collection;
use App\Traits\Paginatable;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Paginatable;
    use Sortable;

    protected $perPage = 25;
    protected int $maxPerPage = 100;

    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }
}
