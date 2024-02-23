@extends('layouts.app')

@section('content')

    <x-list.categories :categories="$categories"/>



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
        }">

            @php
                \Carbon\Carbon::setLocale('ka');
            @endphp
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-7 mt-3 gap-3">

                @foreach($products as $product)
                    <x-list.item :product="$product"/>
                @endforeach
            </div>

            <div class="w-full">
                {{ $products->appends(request()->query())->links() }}
            </div>

            <x-list.modal/>
        </div>
    </div>
@endsection
