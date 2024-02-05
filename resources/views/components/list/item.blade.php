<div class="col-span-1 bg-white p-4 rounded-sm shadow relative cursor-pointer"
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
    <div class="absolute right-0 top-0 text-[8px] font-normal p-1.5 z-10">
        @if ($product->prices->firstWhere('price', $product->prices->min('price'))->created_at->diffInDays(now()) <= 1)
            {{ $product->prices->firstWhere('price', $product->prices->min('price'))->created_at->diffForHumans() }}
        @endif
    </div>
    <div class="h-[200px] relative">
        <img loading="lazy" class="object-contain absolute h-full w-full" src="storage/{{$product->images->first()->path ?? ''}}">
    </div>
    <div class="flex items-center gap-3 my-2">
        @foreach($product->tags as $tag)
            <span class="text-white  text-xs p-0.5 rounded-md font-medium px-1 {{$tag->type === 2 ? 'bg-green-700' : 'bg-gray-800'}}">
                {{$tag->name}} {{$tag->type === 2 ? 'x' : ''}}
            </span>
        @endforeach
    </div>
    <h4 class="font-bold text-sm mb-1 text-gray-900 truncate ">{{$product->name}}</h4>
    <h5 class="font-normal text-xs text-gray-700">
        {{$product->company->name ?? ''}}
        {{$product->id ?? ''}}
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
