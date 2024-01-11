<?php

namespace App\Jobs;

use App\DataTransferObjects\ProductDto;
use App\Models\File;
use App\Models\Product;
use App\Models\ProductPrice;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SaveFetchedProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly array $items,
        private readonly int $storeId,
        private readonly int $providerId
    ) {
    }


    public function handle(): void
    {
        $productCodes = Arr::pluck($this->items, 'code');
        $products     = $this->getProductByCode($productCodes);
        $now          = now();

        /** @var ProductDto $item */
        foreach ($this->items as $item) {
            $foundProduct = $products->firstWhere('code', $item->code);
            if (empty($foundProduct->deleted_at)){
                $productId = $products->firstWhere('code', $item->code)?->id;
                if ($productId == null) {
                    $productId = $this->createProduct($item);
                }

                if (
                    DB::table((new ProductPrice())->getTable())
                        ->select('store_id')
                        ->where('product_id', $productId)
                        ->groupBy('store_id')
                        ->get()->count() > 1
                    && DB::table((new File())->getTable())
                        ->where('files.fileable_type', Product::class)
                        ->where('files.fileable_id', $productId)
                        ->count() < 1
                ) {

                    $this->downloadImage($productId, $item->imageUrl);
                }

                if (
                    DB::table((new ProductPrice())->getTable())
                        ->where('product_id', $productId)
                        ->whereDate('created_at', $now->format('Y-m-d'))
                        ->where('price', $item->price)
                        ->where('store_id', $this->storeId)
                        ->first() === null
                ) {
                    DB::table((new ProductPrice())->getTable())
                        ->where('product_id', $productId)
                        ->where('store_id', $this->storeId)
                        ->where('active', '=', true)
                        ->update(['active' => false]);

                    DB::table((new ProductPrice())->getTable())->insert([
                        'product_id'  => $productId,
                        'store_id'    => $this->storeId,
                        'provider_id' => $this->providerId,
                        'price'       => $item->price,
                        'created_at'  => $now,
                        'active'      => true,
                    ]);
                }
            }
        }
    }

    private function getProductByCode(array $codes): Collection
    {
        return DB::table((new Product())->getTable())
            ->select(['id', 'code', 'deleted_at'])
            ->whereIn('code', $codes)
            ->get();
    }

    private function createProduct(ProductDto $item): int
    {
        $productId = DB::table((new Product())->getTable())
            ->insertGetId([
                'name' => $item->name,
                'code' => $item->code
            ]);

        return $productId;
    }

    private function downloadImage(int $productId, string $url): void
    {
        $extension = null;

        if (str_contains(strtolower($url), 'jpg')){
            $extension = 'jpg';
        }

        if (str_contains(strtolower($url), 'jpeg')){
            $extension = 'jpeg';
        }

        if (str_contains(strtolower($url), 'png')){
            $extension = 'png';
        }

        if ($extension !== null) {

            try {
                $imageContent = file_get_contents($url);

                if ($imageContent) {
                    $filename = uniqid().'.'.$extension;

                    Storage::disk('public')->put('products'.'/'.$filename, $imageContent);

                    $diskUrl = Storage::disk('public')->path('products'.'/'.$filename);


                    DB::table((new File())->getTable())->insert([
                        'name'          => $filename,
                        'path'          => 'products'.'/'.$filename,
                        'size'          => filesize($diskUrl),
                        'extension'     => $extension,
                        'fileable_id'   => $productId,
                        'fileable_type' => Product::class,
                    ]);
                }
            } catch (\Exception $e) {

            }
        }
    }
}
