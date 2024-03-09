<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\V1\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(
        CategoryService $categoryService,
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
        CategoryService $categoryService,
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
