<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\Services\CategoryServiceContract;
use App\Services\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(
        CategoryServiceContract $categoryService,
        ProductService $productService,
        //        StoreService $storeService,
    ): View {
        $categories = $categoryService->getAllItems();
        $products   = $productService->getProductsGroupedByCategory();

        return view('welcome')->with([
            'categories' => $categories,
            'products'   => $products,
        ]);
    }

    public function items(
        Request $request,
        CategoryServiceContract $categoryService,
        ProductService $productService,
    ): View {
        $filters = $this->getInputFilters();
        $page = $this->getInputPage();

        $categories = $categoryService->getAllItems();
        $products   = $productService->getProducts($filters, $page);

        return view('items')->with([
            'categories' => $categories,
            'products'   => $products,
        ]);
    }
}
