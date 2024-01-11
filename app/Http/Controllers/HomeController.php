<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\StoreService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(
        ProductService $productService,
        StoreService $storeService,
    ): View {
        $stores     = $storeService->findItems();
        $categories = $productService->getProductsGroupedByCategory();

        return view('welcome')->with([
            'categories' => $categories,
            'stores'     => $stores,
        ]);
    }
}
