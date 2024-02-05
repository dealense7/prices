<div class="bg-red-400 p-8 my-4" style="background: url({{ Vite::asset('resources/imgs/bg-pattern.jpg')}}); background-size: 40%;">

    <div class="grid-cols-11 grid gap-10">
        <div class="col-span-1"></div>
        <div class="col-span-6 bg-gray-100 h-[280px] flex items-center justify-between relative">
            <div class="ml-4">
                <h2 class="font-bolder text-xl text-gray-800">შეადარეთ სუპერმარკეტის ფასები</h2>
                <p class="mt-2 font-normal text-xs text-gray-700">
                    შეადარეთ 100-ზე მეტი პროდუქტი სუპერმარკეტებსა და მაღაზიებში.
                </p>
                <button class="text-gray-800 font-medium text-xs mt-10 bg-white p-2 px-3">ყველა პროდუქტი</button>
            </div>
            <div class="h-[240px] absolute right-0 bottom-0">
                <img src="{{ Vite::asset('resources/imgs/banner1.png') }}" class="h-full w-full object-contain">
            </div>
            <div class="top-3 z-10 absolute right-3 flex items-center gap-2">
                <div class="bg-[#bde6c6] p-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#333"
                         class="bi bi-chevron-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                    </svg>
                </div>
                <div class="bg-[#bde6c6] p-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#333"
                         class="bi bi-chevron-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="col-span-3 bg-[#fad071] relative flex items-center justify-between">
            <div class="ml-3 grid">
                <div class="flex items-baseline mt-2">
                    <h5 class="font-bolder text-xl">3.75 ₾</h5>
                    <span class="font-bold text-[10px] text-gray-700 line-through ml-3">5.00 ₾</span>
                </div>

                <div class="my-2 grid">
                    <span class="font-bolder text-sm">ვაშლის წვენი</span>
                    <span class="font-normal text-[10px]">კამპა</span>
                </div>
                <button class="text-gray-800 font-medium text-xs mt-10 bg-white p-2 px-3">კალათაში ჩამატება</button>

            </div>
            <div class="h-[240px] absolute right-0 bottom-0">
                <img src="{{ Vite::asset('resources/imgs/banner2.png') }}" class="h-full w-full object-contain">
            </div>
        </div>

        <div class="col-span-1"></div>
    </div>

</div>
