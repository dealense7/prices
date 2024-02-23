
<div id="static-modal" data-modal-backdrop="static" tabindex="-1" :class="{'hidden' : !open}" x-cloak
     class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full flex"
     aria-modal="true" role="dialog">
    <div class="bg-[#33333378] absolute h-full w-full z-10" x-on:click="open = false">
    </div>

    <div class="relative p-4 w-full max-w-2xl max-h-full z-20">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <div class="font-normal text-[10px]">
                    <h3 class="text-base font-bolder text-gray-900 dark:text-white">
                        გზამკვლევი
                    </h3>
                </div>
                <button x-on:click="open = false" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
                <ul>
                    <li class="p-2 text-xs font-normal my-1 w-full border rounded-[3px]">
                        <span class="bg-green-400 p-1 text-[9px] text-gray-700 rounded-[3px]">
                            შესრულებულია
                        </span>
                        <h4 class="my-2 font-medium">Alpha ვერსია</h4>
                        <p class="text-gray-500">
                            პროგრამული უზრუნველყოფის ნაწილის ვერსია, რომელიც ხელმისაწვდომია ტესტირებისთვის, როგორც წესი, კომპანიის თანამშრომლების მიერ, რომელიც ამუშავებს მას, მის საერთო გამოშვებამდე.
                        </p>
                    </li>
                    <li class="p-2 text-xs font-normal my-1 w-full border rounded-[3px]">
                        <span class="bg-yellow-400 p-1 text-[9px] text-gray-700 rounded-[3px]">
                            პროგრესშია
                        </span>
                        <h4 class="my-2 font-medium">პროდუქტების დამატება</h4>
                        <p class="text-gray-500">
                            საიტზე ჯერ ჯერობით მხოლოდ 1000 ზე მეტი პროდუქტის ფასის ნახვააა შესაძლებელი, თუმცა 5000 ზე მეტი ჯერ ისევ ელოდება კატეგორიების და კომპანიების მინიჭებას.
                        </p>
                    </li>
                    <li class="p-2 text-xs font-normal my-1 w-full border rounded-[3px]">
                        <span class="bg-yellow-400 p-1 text-[9px] text-gray-700 rounded-[3px]">
                            პროგრესშია
                        </span>
                        <h4 class="my-2 font-medium">კალათა</h4>
                        <p class="text-gray-500">
                            შეგეძლებათ კალათაში დაამატოთ პროდუქტი და ნახოთ ყველაზე იაფად რომელ მაღაზებში, ან ჯამურად ყველაზე იაფი სად იქენბა.
                        </p>
                    </li>
                    <li class="p-2 text-xs font-normal my-1 w-full border rounded-[3px]">
                        <span class="bg-gray-300 p-1 text-[9px] text-gray-700 rounded-[3px]">
                            არ დაწყებულა
                        </span>
                        <h4 class="my-2 font-medium">დამატებითი ფუნქციონალი</h4>
                        <p class="text-gray-500">
                            დიზაინის მორგება მობილურისთვის და პლანშეტისთვის, სლაიდერის ამუშავება, მეტი ფილტრის და სტატისტიკის დამატება...
                        </p>
                    </li>
                </ul>
            </div>
            <!-- Modal footer -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <div class="flex items-center">
                </div>
            </div>
        </div>
    </div>
</div>
