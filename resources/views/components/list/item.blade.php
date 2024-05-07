<div
    class="col-span-1 grid relative"
>
    {{-- add to cart --}}
    <div class="absolute right-0 top-2 text-[8px] font-normal p-1.5 z-10">
            <span class="bg-gray-200 hover:bg-green-400 p-1 block rounded-[3px] cursor-pointer" id="addProductToCart{{$product->id}}" onclick="toggleProduct({{$product->id}})">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#333" class="bi bi-cart" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
            </span>
    </div>

    {{-- Image --}}
    <div
        x-on:click="
             title = `{{$product->name}}`;
             open = true;
             company = '{{$product->company->name ?? ''}}';
             imgUrl = 'storage/{{$product->images->first()->path ?? ''}}';
             updated = '{{ $product->prices->count() > 0 ? $product->prices->firstWhere('price', $product->prices->min('price'))->created_at->diffForHumans() : '' }}';
             fetchPrices({{$product->id}});
             isLoading = true
         "
        class="h-[180px] cursor-pointer shadow flex items-center justify-center relative bg-white rounded-[7px]">
        <img loading="lazy" class="object-contain absolute h-[80%] w-max" src="storage/{{$product->images->first()->path ?? ''}}">

        {{-- Percentage --}}
        @php $product->prices->count() > 0 ? $sale = number_format(100 - $product->prices->min('price') / $product->prices->max('price') * 100, 2) : $sale = 0 @endphp
        @if($sale > 0)
            <div
                class="absolute top-3 left-3 text-[10px] p-0.5 px-1 rounded-md font-bold bg-gray-200 text-gray-700">
                {{ $sale }} %
            </div>
        @endif

        {{-- TAG --}}
        <div class="flex items-center gap-3 my-2 absolute bottom-1 left-3">
            @foreach($product->tags as $tag)
                <span class="text-white  text-[11px] p-0.5 rounded-md font-normal px-1 {{$tag->type === 2 ? 'bg-[#41a549]' : 'bg-gray-700'}}">
                    {{$tag->name}} {{$tag->type === 2 ? 'x' : ''}}
                </span>
            @endforeach
        </div>

        {{-- last update date --}}
        <div class="absolute right-0 bottom-2 text-[8px] font-normal p-1.5 z-10">
            @if ($product->prices->count() > 0  && $product->prices->firstWhere('price', $product->prices->min('price'))->created_at->diffInDays(now()) <= 1)
                {{ $product->prices->firstWhere('price', $product->prices->min('price'))->created_at->diffForHumans() }}
            @endif
        </div>
    </div>

    {{--  product and company name  --}}
    <h4 class="font-bold text-[12px] mt-1.5 mb-0.5 text-[#141f22] whitespace-nowrap truncate w-full">{{$product->name}}</h4>
    <h5 class="font-normal text-[9px] text-gray-700">
        {{$product->company->name ?? ''}}
    </h5>

    <div class="flex  justify-between">
        <span class="font-bolder">
            {{number_format(($product->prices->min('price') / 100), 2)}} ₾
        </span>

        @if($product->prices->max('price') - $product->prices->min('price') > 0)
            <small class="font-medium text-[10px] text-green-600 flex items-center">
                დაზოგე {{number_format(($product->prices->max('price') - $product->prices->min('price'))/100, 2)}} ₾
            </small>
        @endif
    </div>
</div>
