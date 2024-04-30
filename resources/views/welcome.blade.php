@extends('layouts.app')

@section('content')

    <div class="grid grid-cols-10">
        <div class="col-span-2">
            <x-list.categories :categories="$categories" />
        </div>
        <div class="col-span-8">

            <div class="flex items-center justify-between w-full mt-3">
                <div>
                    <h2 class="font-bolder text-base text-gray-800">პროდუქტები</h2>
                    <span class="text-xs font-normal text-gray-700">შეადარეთ სუპერმარკეტის ფასები</span>
                </div>
                <div class="w-[300px] lg:col-span-1 flex items-center justify-center ">
                    <a class="items-center col-span-1 leading-none lg:hidden flex" href="/">
                        <div class="h-[41px] rounded-md">
                            <img src="{{ Vite::asset('resources/imgs/logo.png') }}" class="h-full w-full object-contain">
                        </div>
                    </a>
                    <form action="/items" class="flex items-center w-full h-[41px] bg-[#e1e1e1]  rounded-[3px]" method="get">
                        <label class="w-full">
                            <input type="text"
                                   name="filters[keyword]"
                                   value="{{data_get(request()->get('filters', []), 'keyword', '')}}"
                                   class="bg-transparent border-none w-full text-xs focus:ring-0 font-normal"
                                   placeholder="რას ეძებთ?..">
                        </label>
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#474747"
                                 class="bi bi-search mr-2" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

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
                    @php
                        \Carbon\Carbon::setLocale('ka');
                    @endphp
                    @foreach($products as $category)
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-7 mt-3 gap-3">

                            <div class="sm:col-span-2 md:col-span-3 lg:col-span-5 xl:col-span-7 flex items-center justify-between">
                                <h3 class="font-bold text-xl">{{$category->name}}</h3>
                                <a href="items?filters[parentCategoryIds][]={{$category->id}}"
                                   class="flex flex-col items-end font-normal text-xs">
                                    <small>ყველას ნახვა</small>
                                    <small class="text-[9px]">სულ: {{$category->all_products_count}}</small>
                                </a>
                            </div>

                            @foreach($category->allProducts as $product)
                                <x-list.item :product="$product"/>
                            @endforeach
                        </div>
                    @endforeach
                    <x-list.modal/>
                </div>
            </div>
        </div>
    </div>

@endsection

