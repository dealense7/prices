<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Model;
use Illuminate\Validation\ValidationException;

/**
 * @mixin Model
 */
trait Paginatable
{
    public function getMaxPerPage(): int
    {
        return $this->maxPerPage;
    }

    /**
     * @throws ValidationException
     */
    public function getValidPerPage(?int $perPage = null): int
    {
        if (empty($perPage)) {
            return $this->getPerPage();
        }

        if ($perPage > $this->getMaxPerPage()) {
            throw ValidationException::withMessages(['perPage' => 'Max items on the page: ' . $this->getMaxPerPage()]);
        }

        return $perPage;
    }
}
