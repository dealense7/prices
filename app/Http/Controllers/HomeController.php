<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\StoreService;
use Illuminate\Contracts\View\View;

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
}
