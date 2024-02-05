@extends('layouts.app')

@section('content')

    <x-home.slider/>

    <x-list.Categories :categories="$categories" />


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

            @foreach($products as $category)
                <div class="grid grid-cols-7 mt-3 gap-3">

                    <div class="col-span-7 flex items-center justify-between">
                        <h3 class="font-bold text-xl">{{$category->name}}</h3>
                        <a href="items?filters[parentCategoryIds][]={{$category->id}}" class="flex flex-col items-end font-normal text-xs">
                            <small>ყველას ნახვა</small>
                            <small class="text-[9px]">სულ: {{$category->all_products_count}}</small>
                        </a>
                    </div>
                    @php
                        \Carbon\Carbon::setLocale('ka');
                    @endphp
                    @foreach($category->allProducts as $product)
                        <x-list.Item :product="$product" />
                    @endforeach
                </div>
            @endforeach

                <x-list.Modal />
        </div>
    </div>
@endsection
