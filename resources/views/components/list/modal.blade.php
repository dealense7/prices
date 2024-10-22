
<div id="static-modal" data-modal-backdrop="static" tabindex="-1" :class="{'hidden' : !open}" x-cloak
     class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full flex"
     aria-modal="true" role="dialog">
    <div class="bg-[#33333378] absolute h-full w-full z-10" x-on:click="open = false">
    </div>

    <div class="relative p-4 w-full max-w-2xl max-h-full z-20">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <div class="font-normal text-[10px]">
                    <h3 class="text-base font-bolder text-gray-900" x-text="title">
                    </h3>
                    <smal x-text="company"></smal>
                </div>
                <button x-on:click="open = false" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="static-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4 max-h-[70vh] overflow-auto">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <div class="col-span-2 max-h-[180px] sm:col-span-1 w-3/4 m-auto h-full sm:w-full relative">
                        <img :src="imgUrl" class="h-full w-full object-contain"/>
                    </div>
                    <div class="col-span-2">
                        <h4 class="font-bold text-sm">სად შეძლებ ყიდვას</h4>
                        <span class="font-normal text-[10px] text-gray-500">პროდუქტის ფასები გადმოტანილია სხვა-და-სხვა ონლაინ პროვაიდერებიდან, ფასი შეიძლება არ იყოს რეალური.</span>
                        <div class="flex flex-col" x-show="!isLoading">
                            <template x-for="price in prices">
                                <div class="flex items-center justify-between py-3">
                                    <div class="flex items-center gap-2">
                                        <img :src='price.companyLogo' class="w-8 object-contain h-8">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-xs" x-text="price.companyName"></span>
                                            <span class="font-normal text-[10px]"x-text="price.companyYear"></span>
                                        </div>
                                    </div>
                                    <div class="grid">
                                        <h5 class="font-bolder text-gray-700 text-base">
                                            <span x-text="price.price"></span> ₾
                                        </h5>
                                        <small class="text-[8px] font-normal"
                                               x-text="price.createdAt"></small>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="flex flex-col" x-show="isLoading">
                            <div class="flex items-center justify-between py-3">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 object-contain h-8 animate-pulse bg-gray-300 rounded-md block"></div>
                                    <div class="flex flex-col">
                                                    <span
                                                        class="font-medium text-xs animate-pulse bg-gray-300 w-[150px] p-1"></span>
                                        <span
                                            class="font-medium text-xs animate-pulse bg-gray-300 w-[80px] p-1 mt-1.5"></span>
                                    </div>
                                </div>
                                <h5 class="font-bolder text-gray-700 text-base flex items-center gap-2">
                                    <span class="block animate-pulse h-7 w-7  bg-gray-300"></span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <canvas id="myChart"></canvas>
            </div>
            <!-- Modal footer -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-t border-gray-200 rounded-b">
                <div class="flex items-center">
                    <button x-on:click="open = false" class="block w-full rounded-md bg-gray-200 px-3 py-2 text-center text-xs font-normal text-gray-700 shadow-sm ">დახურვა</button>
                </div>
                <h5 class="font-normal text-[10px] text-gray-800 mt-1.5" x-text="updated"></h5>
            </div>
        </div>
    </div>
</div>
