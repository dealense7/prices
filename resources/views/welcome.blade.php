@extends('layouts.app')

@section('content')
    <x-home.stores :stores="$stores"/>
    <div x-data="{
            open:false,
            title: '',
            company: '',
            imgUrl: '',
            updated: '',
            prices: [],
            isLoading: true,
        }"
    >
        <div x-data="{
            fetchPrices: (id) => {
             fetch(
             'api/product/' + id + '/prices',
             {
                 method: 'GET',
                 headers: {
                     'Accept': 'application/json',
                     'Content-Type': 'application/json'
                 }
             })
             .then(response => response.json())
             .then(data => {prices = data; isLoading = false})
            }
        }"
        >

            @foreach($categories as $category)
                <div class="grid grid-cols-6 mt-3 gap-3">

                    <div class="col-span-6 flex items-center justify-between">
                        <h3 class="font-bold text-xl">{{$category->name}}</h3>
                        <a href="#" class="flex flex-col items-end font-normal text-xs">
                            <small>ყველას ნახვა</small>
                            <small class="text-[9px]">სულ: {{$category->products_count}}</small>
                        </a>
                    </div>
                    @php
                        \Carbon\Carbon::setLocale('ka');
                    @endphp
                    @foreach($category->products as $product)
                        <div class="col-span-1 bg-white p-4 rounded-sm shadow relative cursor-pointer"
                             x-on:click="
                             title = '{{$product->name}}';
                             open = true;
                             company = '{{$product->company->name ?? ''}}';
                             imgUrl = 'storage/{{$product->images->first()->path ?? ''}}';
                              updated = '{{ $product->prices->firstWhere('price', $product->prices->min('price'))->created_at->diffForHumans() }}';
                              fetchPrices({{$product->id}});
                              isLoading = true"
                        >
                            <div class="absolute right-0 top-0 text-[8px] font-normal p-1.5 z-10">
                                @if ($product->prices->firstWhere('price', $product->prices->min('price'))->created_at->diffInDays(now()) <= 1)
                                    {{ $product->prices->firstWhere('price', $product->prices->min('price'))->created_at->diffForHumans() }}
                                @endif
                            </div>
                            <div class="h-[200px] relative">
                                <img loading="lazy" class="object-contain absolute h-full w-full"
                                     src="storage/{{$product->images->first()->path ?? ''}}">
                            </div>
                            <div class="flex items-center gap-3 my-2">
                                @foreach($product->tags as $tag)
                                    <span
                                        class="text-white  text-xs p-0.5 rounded-md font-medium px-1 {{$tag->type === 2 ? 'bg-green-700' : 'bg-gray-800'}}">{{$tag->name}} {{$tag->type === 2 ? 'x' : ''}}</span>
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
                                        დაზოგე
                                        {{number_format(($product->prices->max('price') - $product->prices->min('price'))/100, 2)}}
                                        ₾
                                    </small>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div id="static-modal" data-modal-backdrop="static" tabindex="-1" :class="{'hidden' : !open}" x-cloak
                 class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full flex"
                 aria-modal="true" role="dialog">
                <div class="bg-[#33333378] absolute h-full w-full z-10" x-on:click="open = false">
                </div>

                <div class="relative p-4 w-full max-w-2xl max-h-full z-20">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <div class="font-normal text-[10px]">
                                <h3 class="text-base font-bolder text-gray-900 dark:text-white" x-text="title">
                                </h3>
                                <smal x-text="company"></smal>
                            </div>
                            <button x-on:click="open = false" type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="static-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    <img :src="imgUrl"/>
                                </div>
                                <div class="col-span-2">
                                    <h4 class="font-bold text-sm">სად შეძლებ ყიდვას</h4>
                                    <span class="font-normal text-[10px] text-gray-500">პროდუქტის ფასები გადმოტანილია სხვა-და-სხვა ონლაინ პროვაიდერებიდან, ფასი შეიძლება არ იყოს რეალური.</span>
                                    <div class="flex flex-col" x-show="!isLoading">
                                        <template x-for="price in prices">
                                            <div class="flex items-center justify-between py-3">
                                                <div class="flex items-center gap-2">
                                                    <img :src='price.companyLogo' class="w-8 object-contain h-8">
                                                    <div class="flex flex-col">
                                                        <span class="font-medium text-xs"
                                                              x-text="price.companyName"></span>
                                                        <span class="font-normal text-[10px]"
                                                              x-text="price.companyYear"></span>
                                                    </div>
                                                </div>
                                                <h5 class="font-bolder text-gray-700 text-base">
                                                    <span x-text="price.price"></span> ₾
                                                </h5>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="flex flex-col" x-show="isLoading">
                                            <div class="flex items-center justify-between py-3">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-8 object-contain h-8 animate-pulse bg-gray-300 rounded-md block"></div>
                                                    <div class="flex flex-col">
                                                        <span class="font-medium text-xs animate-pulse bg-gray-300 w-[150px] p-1"></span>
                                                        <span class="font-medium text-xs animate-pulse bg-gray-300 w-[80px] p-1 mt-1.5"></span>
                                                    </div>
                                                </div>
                                                <h5 class="font-bolder text-gray-700 text-base flex items-center gap-2">
                                                    <span class="block animate-pulse h-7 w-7  bg-gray-300"></span>
                                                </h5>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <div class="flex items-center">
                            </div>
                            <h5 class="font-normal text-[10px] text-gray-800 mt-1.5" x-text="updated"></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
