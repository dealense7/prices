<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\StoreService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(
        CategoryService $categoryService,
        ProductService $productService,
//        StoreService $storeService,
    ): View
    {
        $categories = $categoryService->findItems();
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
        $filters    = $request->get('filters', []);
        $categories = $categoryService->findItems();
        $products   = $productService->getProducts($filters);

        return view('items')->with([
            'categories' => $categories,
            'products'   => $products,
        ]);
    }
}
