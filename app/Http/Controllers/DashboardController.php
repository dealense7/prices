<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\CompanyService;
use App\Services\ProductService;
use App\Services\StoreService;
use App\Services\TagService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(
        StoreService $storeService,
        ProductService $productService,
        CategoryService $categoryService,
        CompanyService $companyService,
        TagService $tagService,
    ): View {
        $filters = $this->getInputFilters();
        $page = $this->getInputPage();
        $perPage = $this->getInputPerPage();
        $sort = $this->getInputSort();

        $stores     = $storeService->findItems();
        $products   = $productService->findItems($filters, $page, $perPage, $sort);
        $categories = $categoryService->findItems();
        $tags       = $tagService->findItems();
        $companies  = $companyService->findItems();

        return view('dashboard')->with([
            'stores'     => $stores,
            'products'   => $products,
            'categories' => $categories,
            'tags'       => $tags,
            'companies'  => $companies,
        ]);
    }
}
