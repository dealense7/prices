<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSaveRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function update(
        int $id,
        ProductSaveRequest $request,
        ProductService $service
    ) {
        $data = $request->validated();

        $item = $service->findOrFailById($id);

        $item = $service->update($item, $data);

        return true;
    }

    public function delete(
        int $id,
        ProductService $service
    ) {
        $item = $service->findOrFailById($id);

        $service->delete($item);

        return true;
    }

    public function getPrices(
        int $id,
        ProductService $service
    ) {
        $item = $service->findOrFailById($id);

        return $service->getPrices($item);
    }
}
