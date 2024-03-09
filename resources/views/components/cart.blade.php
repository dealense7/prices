
<div id="static-modal" data-modal-backdrop="static" tabindex="-1"
     :class="{'hidden' : !open}" x-cloak
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
                <div class="font-normal text-[12px]">
                    <h3 class="text-base font-bolder text-gray-900">
                        კალათა
                    </h3>
                    <small id="totalProducts"></small>
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
            <div class="p-4 md:p-5 space-y-4">
                <div class="grid grid-cols-3 gap-4">
                    <ul class="col-span-3">
                        <template x-for="item in items">
                            <li class="flex w-full items-center">
                                <div class="relative w-[100px] h-[100px] bg-white">
                                    <img :src="'storage/' + item.images[0].path" class="min-w-[100px] rounded-md object-contain w-full h-full">
                                </div>
                                <div class="flex-col block lg:flex w-full lg:flex-row items-center justify-start lg:justify-between">
                                    <div class="flex w-full items-center">
                                        <div class="ml-2">
                                            <h4 class="font-bold text-sm mb-1 text-gray-900 truncate" x-text="item.translation.name"></h4>
                                            <h5 class="font-normal text-xs text-gray-700" x-text="item.company.name"></h5>
                                        </div>
                                    </div>
                                    <div class="justify-end ">
                                        <div class="flex items-center w-max mr-5">
                                            <span class="font-bold w-max flex text-right"> <span class="mx-2" x-text="(Math.min(...item.prices.map(val => val.price))/100).toFixed(2)"></span> ₾</span>
                                            <button type="button" class="flex items-center ml-2"x-on:click="removeProduct(item.id);getItems()">
                                            <span class="bg-gray-200 hover:bg-red-400 p-1 rounded-[3px] w-max">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                  <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                                </svg>
                                            </span>
                                            </button>
                                        </div>
                                        <div class="flex items-center text-xs font-normal ">
                                            <img  class="w-7 object-contain h-7"
                                                  :src="'storage/' + item.prices.reduce((minPriceObj, currentObj) => {
                                                    return currentObj.price < minPriceObj.price ? currentObj : minPriceObj;
                                                }, item.prices[0]).store.logo.path"
                                            >
                                            <span class="ml-2" x-text="item.prices.reduce((minPriceObj, currentObj) => {
                                                    return currentObj.price < minPriceObj.price ? currentObj : minPriceObj;
                                                }, item.prices[0]).store.name">

                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
            <!-- Modal footer -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-t border-gray-200 rounded-b">
                <h5 class="font-normal text-[12px] text-gray-800 mt-1.5" >ჯამში: <span class="font-bold text-gray-900" id="totalPriceCartModal"></span> ₾</h5>
                <h5 class="font-normal text-[12px] text-gray-800 mt-1.5" >დაზოგე: <span class="font-bold text-green-700" id="totalSavedCartModal"></span> </h5>
            </div>
        </div>
    </div>
</div>
