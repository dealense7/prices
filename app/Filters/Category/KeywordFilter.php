<?php

declare(strict_types=1);

namespace App\Filters\Category;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class KeywordFilter
{
    public function handle(array $request, Closure $next): array
    {
        $filter = $request['filter'];
        $query  = $request['query'];
        if (! empty($filter['keyword']) && is_string($filter['keyword'])) {
            $keyword = $filter['keyword'];

            $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhereHas('children', static function (Builder $query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
        }

        return $next($request);
    }
}
