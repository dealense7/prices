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
        </div>
    </div>

@endsection
