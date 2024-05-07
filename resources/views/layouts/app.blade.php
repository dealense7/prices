@extends('layouts.base')

@section('body')
    <div class="container px-4 mx-auto">
        <section>
            <nav class="flex justify-between items-center py-6">
                <a class="items-center col-span-1 leading-none flex" href="/">
                    <div class="h-[41px] rounded-md">
                        <img src="{{ Vite::asset('resources/imgs/logo.png') }}" class="h-full w-full object-contain">
                    </div>
                    <div class="ml-2">
                        <div class="flex items-center"><h1 class="font-bolder text-sm text-gray-900  hidden md:flex">ფასები</h1><span class="bg-green-500 p-1 rounded text-white font-normal text-[9px] ml-2">BETA</span></div>
                        <span class="font-normal text-[10px] text-gray-800 hidden md:flex">სურსათი უკეთეს ფასად</span>
                    </div>
                </a>

                <div class="justify-end col-span-1 ml-auto font-normal flex items-center gap-7">

                    <div class="items-center flex">
                        <a href="https://github.com/dealense7/prices" target="_blank" class="h-6 rounded-md w-full relative">
                            <svg xmlns="http://www.w3.org/2000/svg"  fill="#333" class="bi h-6 w-7 bi-github" viewBox="0 0 16 16">
                                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                            </svg>
                        </a>
                    </div>

                    <div class="items-center flex">
                        <a href="https://www.linkedin.com/in/gurami-kutivadze/" target="_blank" class="h-6 rounded-md w-full relative">
                            <svg xmlns="http://www.w3.org/2000/svg"  fill="#333" class="h-6 w-7 bi bi-linkedin" viewBox="0 0 16 16">
                                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
                            </svg>
                        </a>
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
