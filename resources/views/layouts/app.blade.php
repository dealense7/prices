@extends('layouts.base')

@section('body')
    <div class="container px-4 mx-auto">
        <section>
            <nav class="flex justify-between items-center py-6">
                <a class="items-center col-span-1 leading-none hidden lg:flex" href="/">
                    <div class="h-[41px] rounded-md">
                        <img src="{{ Vite::asset('resources/imgs/logo.png') }}" class="h-full w-full object-contain">
                    </div>
                    <div class="ml-2">
                        <div class="flex items-center"><h1 class="font-bolder text-sm text-gray-900">ფასები</h1><span class="bg-green-500 p-1 rounded text-white font-normal text-[9px] ml-2">BETA</span></div>
                        <span class="font-normal text-[10px] text-gray-800">სურსათი უკეთეს ფასად</span>
                    </div>
                </a>

                <div class="justify-end col-span-1 ml-auto font-normal flex items-center gap-7">

                    <div class="items-center hidden lg:flex">
                        <div class="h-6 rounded-md w-full relative">
                            <img src="{{ Vite::asset('resources/imgs/user.png') }}" class="h-full w-full object-contain"
                                 alt="User">
                        </div>
                    </div>

                    <div class="items-center hidden lg:flex">
                        <div class="h-6 rounded-md w-full relative">
                            <img alt="like" src="{{ Vite::asset('resources/imgs/like.png') }}"
                                 class="h-full w-full object-contain">
{{--                            <span--}}
{{--                                class="absolute -right-2 -top-1 bg-[#bde6c6] p-1 text-[10px] font-bolder flex items-center justify-center text-gray-800 rounded-sm h-4 w-4">--}}
{{--                                3--}}
{{--                            </span>--}}
                        </div>
                    </div>

                    <div  x-data="{open:false}">
                        <div x-data="cartItems()" >
                            <div class="flex items-center" x-init="getItems()" x-on:click="getItems();open = true">
                                <div class="h-6 rounded-md w-full relative cursor-pointer  hidden lg:flex" >
                                    <img alt="cart" src="{{ Vite::asset('resources/imgs/cart.png') }}" class="h-full w-full object-contain">
                                    <span id="cartItemsCount" class="absolute hidden -right-2 -top-1 bg-[#bde6c6] p-1 text-[10px] font-bolder flex items-center justify-center text-gray-800 rounded-sm h-4 w-4">0</span>
                                </div>
                                <div class="ml-3 font-medium text-xs w-fill cursor-pointer" >
                                    <span class="text-gray-700 text-[10px] flex">ჯამში <span class="ml-1 w-max text-green-700 hidden" id="totalSavedPriceCart">- 1050.78 ₾</span></span>
                                    <pre><h4 class="flex w-full items-center">₾ <span id="totalPriceCart">0.00</span> </h4></pre>
                                </div>
                            </div>
                            <x-cart/>
                        </div>


                    </div>
                </div>
            </nav>
        </section>
        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>

@endsection
