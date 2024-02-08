<?php

namespace App\Jobs;

use App\DataTransferObjects\ProductDto;
use App\Enums\Languages;
use App\Enums\TagType;
use App\Models\Category\Category;
use App\Models\Company;
use App\Models\File;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductTranslation;
use App\Models\Tag\Tag;
use App\Models\Tag\TagTranslation;
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

class SaveFetchedPrices implements ShouldQueue
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

        $items = collect($this->items)->whereIn('code', $products->pluck('code')->toArray());


        DB::transaction(function () use ($items, $products) {
            $priceTable = (new ProductPrice())->getTable();

            /** @var ProductDto $item */
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
        DB::table($priceTable)
            ->where('product_id', $id)
            ->where('store_id', $this->storeId)
            ->where('created_at', '<=', now()->subWeek()->toDateString())
            ->update([
                'active' => false,
            ]);

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
            DB::table($priceTable)->select('price')
                ->where('product_id', $id)
                ->where('store_id', $this->storeId)
                ->whereDate('created_at', today()->toDateString())
                ->delete();

            DB::table($priceTable)
                ->where('product_id', $id)
                ->where('store_id', $this->storeId)
                ->where('active', true)
                ->update([
                    'active' => false,
                ]);

            DB::table($priceTable)->insert([
                'product_id'  => $id,
                'price'       => $item->price,
                'store_id'    => $this->storeId,
                'provider_id' => $this->providerId,
                'created_at'  => now(),
                'active'      => true
            ]);
        }
    }
}
