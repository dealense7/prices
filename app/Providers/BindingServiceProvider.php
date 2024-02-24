<?php

declare(strict_types=1);

namespace App\Providers;

use App\CacheRepositories\V1\CategoryCacheRepository;
use App\CacheRepositories\V1\ProductCacheRepository;
use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Contracts\Repositories\CompanyRepositoryContract;
use App\Contracts\Repositories\ProductRepositoryContract;
use App\Contracts\Repositories\TagRepositoryContract;
use App\Contracts\Services\CategoryServiceContract;
use App\Repositories\V1\CategoryRepository;
use App\Repositories\V1\CompanyRepository;
use App\Repositories\V1\ProductRepository;
use App\Repositories\V1\TagRepository;
use App\Services\V1\CategoryService;
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
            CategoryCacheRepository::class
        ],
        ProductRepositoryContract::class  => [
            ProductRepository::class,
            ProductCacheRepository::class,
        ],
    ];
    private const SERVICES     = [
        CategoryServiceContract::class => [
            'v1' => [
                CategoryService::class
            ],
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        $defaultVersion = 'v1';
        $apiVersion     = strtolower($this->app['request']->header('X-Api-Version', $defaultVersion));

        $cacheServices = config('custom.constants.cache_services');
        $classes       = [
            ...self::SERVICES
        ];

        foreach ($classes as $abstract => $versions) {
            $chosenVersion = $versions[$apiVersion] ?? last($versions);

            $concrete = $cacheServices && isset($chosenVersion[1]) ? $chosenVersion[1] : $chosenVersion[0];
            $this->app->bind($abstract, $concrete);
        }

        foreach (self::REPOSITORIES as $abstract => $repositories) {
            $concrete = $cacheServices ? ($repositories[1] ?? $repositories[0]) : $repositories[0];
            $this->app->bind($abstract, $concrete);
        }
    }
}
