<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Contracts\Repositories\CompanyRepositoryContract;
use App\Contracts\Repositories\ProductRepositoryContract;
use App\Contracts\Repositories\TagRepositoryContract;
use App\Repositories\CategoryRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    private const REPOSITORIES = [
        CompanyRepositoryContract::class  => [
            CompanyRepository::class,
        ],
        TagRepositoryContract::class      => [
            TagRepository::class,
        ],
        CategoryRepositoryContract::class => [
            CategoryRepository::class,
        ],
        ProductRepositoryContract::class  => [
            ProductRepository::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        $cacheServices = config('project.general.cache_services');
        foreach (self::REPOSITORIES as $abstract => $repositories) {
            $concrete = $cacheServices ? ($repositories[1] ?? $repositories[0]) : $repositories[0];
            $this->app->bind($abstract, $concrete);
        }
    }
}
