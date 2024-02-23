<div class="col-span-1 grid bg-white p-4 rounded-[7px] shadow relative">
    <div
        class="w-full h-full cursor-pointer z-10 absolute left-0 top-0"
         x-on:click="
             title = '{{$product->name}}';
             open = true;
             company = '{{$product->company->name ?? ''}}';
             imgUrl = 'storage/{{$product->images->first()->path ?? ''}}';
             updated = '{{ $product->prices->firstWhere('price', $product->prices->min('price'))->created_at->diffForHumans() }}';
             fetchPrices({{$product->id}});
             isLoading = true
         "
    >
    </div>

    <div class="absolute left-0 top-0 text-[8px] font-normal p-1.5 z-10">
        <span class="bg-gray-200 hover:bg-green-400 p-1 block rounded-[3px] cursor-pointer" id="addProductToCart{{$product->id}}" onclick="toggleProduct({{$product->id}})">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#333" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
        </span>
    </div>

    <div class="absolute right-0 top-0 text-[8px] font-normal p-1.5 z-10">
        @if ($product->prices->firstWhere('price', $product->prices->min('price'))->created_at->diffInDays(now()) <= 1)
            {{ $product->prices->firstWhere('price', $product->prices->min('price'))->created_at->diffForHumans() }}
        @endif
    </div>

    <div class="h-[200px] flex items-center justify-center relative">
        <img loading="lazy" class="object-contain absolute h-full w-max" src="storage/{{$product->images->first()->path ?? ''}}">
    </div>

    <div class="flex items-center gap-3 my-2">
        @foreach($product->tags as $tag)
            <span class="text-white  text-xs p-0.5 rounded-md font-medium px-1 {{$tag->type === 2 ? 'bg-green-700' : 'bg-gray-800'}}">
                {{$tag->name}} {{$tag->type === 2 ? 'x' : ''}}
            </span>
        @endforeach
    </div>

    <h4 class="font-bold text-[12px] mb-1 text-gray-900 whitespace-nowrap truncate w-full">{{$product->name}}</h4>
    <h5 class="font-normal text-xs text-gray-700">
        {{$product->company->name ?? ''}}
        {{$product->id ?? '     '}}
        {{'s: ' . $product->categories->first()->id}}
        {{'s: ' . $product->categories->first()->parent_id}}
    </h5>

    <div class="flex  justify-between">
        <div>
            <div class="flex items-center gap-1 mt-1">
                <span class="font-bolder">
                    {{number_format(($product->prices->min('price') / 100), 2)}} ₾
                </span>
            </div>

            @if($product->size !== 'ერთ')
                <span class="text-[9px] font-normal flex items-center">
                    100 {{$product->size}} - {{number_format(($product->prices->min('price') / $product->quantity), 2)}} ₾
                </span>
            @else
                <span class="text-[9px] font-normal flex items-center">
                    1 {{$product->size}} - {{number_format(($product->prices->min('price') / $product->quantity) / 100, 2)}} ₾
                </span>
            @endif
        </div>
        @if($product->prices->max('price') - $product->prices->min('price') > 0)
            <small class="font-medium text-[10px] text-green-600 flex items-center">
                დაზოგე {{number_format(($product->prices->max('price') - $product->prices->min('price'))/100, 2)}} ₾
            </small>
        @endif
    </div>
</div>
