<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DataTransferObjects\ProductDto;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SaveFetchedPrices implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly array $items,
        private readonly int $storeId,
        private readonly int $providerId,
    ) {
    }

    public function handle(): void
    {
        $productCodes = Arr::pluck($this->items, 'code');
        $products     = $this->getProductByCode($productCodes);

        // I want to update prices only not deleted items
        $items = collect($this->items)->whereIn('code', $products->pluck('code')->toArray());

        DB::transaction(function () use ($items, $products) {
            $priceTable = (new ProductPrice())->getTable();

            /** @var \App\DataTransferObjects\ProductDto $item */
            foreach ($items as $item) {
                $this->createPrice($item, $products->firstWhere('code', $item->code)->id, $priceTable);
            }
        });
    }

    private function getProductByCode(array $codes): Collection
    {
        return DB::table((new Product())->getTable())
            ->select(['id', 'code', 'deleted_at'])
            ->whereIn('code', $codes)
            ->whereNull('deleted_at')
            ->get();
    }

    private function createPrice(ProductDto $item, int $id, string $priceTable): void
    {

        // If I have a week-old price in DB and that price is not updating I don't care about it anymore
        // maybe that product is already removed from the branch
        DB::table($priceTable)
            ->where('product_id', $id)
            ->where('created_at', '<=', now()->subWeek()->toDateString())
            ->update([
                'active' => false,
            ]);

        // If you have few urls for a store, you may already update price for the product but maybe this time you have fond much chipper price
        // sometimes some online providers have not updated prices
        $price = DB::table($priceTable)->select('price')
            ->where('product_id', $id)
            ->where('store_id', $this->storeId)
            ->whereDate('created_at', today()->toDateString())
            ->first()?->price;

        if (
            $price === null
            ||
            (
                $price !== null &&
                ($price ?? 0) > $item->price
            )
        ) {
            // Remove old price for today if it exists
            DB::table($priceTable)->select('price')
                ->where('product_id', $id)
                ->where('store_id', $this->storeId)
                ->whereDate('created_at', today()->toDateString())
                ->delete();

            // Disable all active prices, active field is necessary to fetch prices on a product much faster, also it makes query much logical
            DB::table($priceTable)
                ->where('product_id', $id)
                ->where('store_id', $this->storeId)
                ->where('active', true)
                ->update([
                    'active' => false,
                ]);

            // Set active to new price
            DB::table($priceTable)->insert([
                'product_id'        => $id,
                'price'             => $item->price,
                'store_id'          => $this->storeId,
                'provider_id'       => $this->providerId,
                'created_at'        => now(),
                'active'            => true,
                'is_sale'           => $item->priceBeforeSale !== null && $item->price < $item->priceBeforeSale,
                'price_before_sale' => $item->priceBeforeSale
            ]);
        }
    }
}
