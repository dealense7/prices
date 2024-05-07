<?php

declare(strict_types=1);

namespace App\Traits;

/**
 * @mixin \App\Models\Model
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
