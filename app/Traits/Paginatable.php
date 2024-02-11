<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Model;

/**
 * @mixin Model
 */
trait Paginatable
{
    public function getMaxPerPage(): int
    {
        return $this->maxPerPage;
    }

    public function getValidPerPage(?int $perPage = null): int
    {
        if ($perPage === null || $perPage > $this->getMaxPerPage()) {
            return $this->getPerPage();
        }

        return $perPage;
    }
}
