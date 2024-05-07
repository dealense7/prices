<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected function getInputFilters(): array
    {
        return (array) $this->getRequest()->input('filters');
    }

    protected function getInputPage(): int
    {
        return (int) $this->getRequest()->input('page', 1);
    }

    protected function getInputPerPage(): ?int
    {
        $perPage = (int) $this->getRequest()->input('perPage');

        return $perPage ?: null;
    }

    protected function getInputSort(): string
    {
        return (string) $this->getRequest()->input('sort');
    }

    protected function getRequest(): Request
    {
        return app(Request::class);
    }
}
