@extends('layouts.app')

@section('content')

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
        }">

            <div class="grid grid-cols-7 mt-3 gap-3">
                @php
                    \Carbon\Carbon::setLocale('ka');
                @endphp

                @foreach($products as $product)
                    <x-list.Item :product="$product" />
                @endforeach
                <div class="col-span-7">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>

            <x-list.Modal />
        </div>
    </div>
@endsection
