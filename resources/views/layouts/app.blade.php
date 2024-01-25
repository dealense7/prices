@extends('layouts.base')

@section('body')
    <div class="container px-4 mx-auto">
        <section>
            <nav class="grid grid-cols-3 py-6">
                <a class="flex items-center col-span-1 leading-none " href="/">
                    <div class="h-[41px] rounded-md">
                        <img src="{{ Vite::asset('resources/imgs/logo.png') }}" class="h-full w-full object-contain">
                    </div>
                    <div class="ml-2">
                        <h1 class="font-bolder text-sm text-gray-900">კალათა</h1>
                        <span class="font-normal text-[10px] text-gray-800">სურსათი უკეთეს ფასად</span>
                    </div>
                </a>
                <div class="col-span-1 flex items-center justify-center">
                    <div class="w-4/5 h-[41px] bg-[#e1e1e1] flex items-center rounded-[3px]">
                        <label class="w-full">
                            <input type="text"
                                   class="bg-transparent border-none w-full text-xs focus:ring-0 font-normal"
                                   placeholder="რას ეძებთ?..">
                        </label>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#474747"
                             class="bi bi-search mr-2" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </div>
                </div>
                <div class="justify-end col-span-1 ml-auto font-normal flex items-center gap-7">

                    <div class="flex items-center">
                        <div class="h-6 rounded-md w-full relative">
                            <img src="{{ Vite::asset('resources/imgs/user.png') }}" class="h-full w-full object-contain"
                                 alt="User">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="h-6 rounded-md w-full relative">
                            <img alt="like" src="{{ Vite::asset('resources/imgs/like.png') }}"
                                 class="h-full w-full object-contain">
                            <span
                                class="absolute -right-2 -top-1 bg-[#bde6c6] p-1 text-[10px] font-bolder flex items-center justify-center text-gray-800 rounded-sm h-4 w-4">
                                3
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="h-6 rounded-md w-full relative">
                            <img alt="cart" src="{{ Vite::asset('resources/imgs/cart.png') }}"
                                 class="h-full w-full object-contain">
                            <span
                                class="absolute -right-2 -top-1 bg-[#bde6c6] p-1 text-[10px] font-bolder flex items-center justify-center text-gray-800 rounded-sm h-4 w-4">
                                12
                            </span>
                        </div>
                        <div class="ml-3 font-medium text-xs">
                            <span class="text-gray-700 text-[9px]">ჯამში</span>
                            <pre><h4 class="flex w-full items-center">₾ 145.78</h4></pre>
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
