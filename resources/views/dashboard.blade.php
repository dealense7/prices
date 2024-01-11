@extends('layouts.app')

@section('content')
    <x-home.stores :stores="$stores"/>
    <div class="flex flex-col [&>*:nth-child(even)]:bg-gray-200">
        @foreach($products as $product)
            <div class="grid grid-cols-4 gap-3 p-3 rounded-sm w-full">
                {{-- Title and Image --}}
                <div class="col-span-1 ">
                    <div class="w-full h-[40px]">
                        <x-dashboard.list.item-name :product="$product" />
                    </div>
                </div>
                {{-- Tag --}}
                <div class="col-span-1">
                    <div class="w-full h-[40px]">
                        <x-dashboard.list.item-tag :tags="$tags" :product="$product"  />
                    </div>
                </div>
                {{-- Category --}}
                <div class="col-span-1">
                    <div class="w-full h-[40px]">
                        <x-dashboard.list.item-category :categories="$categories" :product="$product"  />
                    </div>
                </div>
                {{-- Company --}}
                <div class="col-span-1 flex items-center gap-3">
                    <div class="w-full h-[40px]">
                        <x-dashboard.list.item-company :companies="$companies" :product="$product"  />
                    </div>
                    <div x-data="{show:{{$product->show}}}" class="flex items-center gap-2">
                        <div
                            :class="!show ? 'bg-red-400' : 'bg-green-400'" class="p-2 rounded-md cursor-pointer"
                             x-on:click="() => {
                                fetch(
                                    'api/product/{{$product->id}}',
                                    {
                                     method: 'PUT',
                                     headers: {
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                     },
                                     body: JSON.stringify({ show: show }) // Fix the syntax error here
                                    }
                                )
                                .then(response => response.json())
                            }; show = !show"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                            </svg>
                        </div>

                        <div class="p-2 rounded-md cursor-pointer bg-red-400"
                            x-on:click="() => {
                                fetch(
                                    'api/product/{{$product->id}}',
                                    {
                                     method: 'DELETE',
                                     headers: {
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                     },
                                     body: JSON.stringify({ show: show }) // Fix the syntax error here
                                    }
                                )
                                .then(response => response.json())
                            }"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{$products->links()}}
    </div>
{{--    <div class="grid grid-cols-6 mt-3 gap-3">--}}
{{--        --}}{{--Header--}}
{{--        <div class="col-span-6">--}}
{{--            <h3 class="font-bold text-xl">ღვინოები</h3>--}}
{{--        </div>--}}
{{--        --}}{{--Products--}}
{{--        <div class="col-span-1 bg-white p-4 rounded-sm shadow">--}}
{{--            <div class="h-[200px] relative">--}}
{{--                <img class="object-contain absolute h-full w-full" src="https://glovo.goodwill.ge/erpimages/E3779DBFB6/4860117330164(1).jpg" >--}}
{{--            </div>--}}
{{--            <div class="flex items-center gap-3 my-2">--}}
{{--                <span class="text-white bg-gray-800 text-xs p-0.5 rounded-md font-medium px-1">750 გ</span>--}}
{{--            </div>--}}
{{--            <h4 class="font-medium text-base mb-1 text-gray-900">RTVELISI</h4>--}}
{{--            <h5 class="font-normal text-xs text-gray-700">--}}
{{--                ღვინო ქისი, თეთრი მშრალი--}}
{{--            </h5>--}}
{{--            <div class="flex items-center gap-1 mt-1">--}}
{{--                 <span class="font-bolder">--}}
{{--                    14.55--}}
{{--                </span>--}}
{{--                <img src="{{ Vite::asset('resources/imgs/lari.svg') }}" class="h-4">--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
