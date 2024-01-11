<?php

namespace App\Services;

use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;

class StoreService
{
    public function findItems(): Collection
    {
        return Store::query()
            ->with('logo')
            ->get();
    }
}
