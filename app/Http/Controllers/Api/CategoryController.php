<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Contracts\Services\CategoryServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSaveRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function findItems(
        CategoryServiceContract $service,
    ) {
        $filters = $this->getInputFilters();
        $page    = $this->getInputPage();
        $perPage = $this->getInputPerPage();
        $sort    = $this->getInputSort();

        $items = $service->findItems($filters, $page, $perPage, $sort);
        dd($items);

        return true;
    }
    public function update(
        int $id,
        ProductSaveRequest $request,
        ProductService $service,
    ) {
        $data = $request->validated();

        $item = $service->findOrFailById($id);

        $item = $service->update($item, $data);

        return true;
    }

    public function delete(
        int $id,
        ProductService $service,
    ) {
        $item = $service->findOrFailById($id);

        $service->delete($item);

        return true;
    }

    public function getPrice(
        int $id,
        ProductService $service,
    ) {
        $item = $service->findOrFailById($id);

        return $service->getPrice($item);
    }

    public function getProducts(
        Request $request,
        ProductService $service,
    ) {
        $ids = [];
        $requestIds = $request->get('ids', []);
        foreach ($requestIds as $requestId) {
            $id = intval($requestId);
            if ($id) {
                $ids[] = $id;
            }
        }

        return $service->getProductsList($ids);
    }
}
