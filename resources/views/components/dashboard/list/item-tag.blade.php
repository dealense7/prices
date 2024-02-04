<div class="relative h-full flex items-center" x-data="{
                update: false,
                options: {{$tags->toJson()}},
                selectedOptions: {{$product->tags->toJson()}},
                open: false,
                filter: ''
                }">
    <div
        class="relative w-full bg-white font-normal"
        @keydown.escape.window="open = false"
        @click.outside="open = false"
    >
        <!-- Show Selected Elements -->
        <div class="border w-full border-gray-500 p-1.5 rounded-[4px] flex items-center justify-between gap-1 h-[40px]">
            <div class="w-full overflow-hidden flex items-center gap-1">
                <template x-if="selectedOptions">
                    <template x-for="selected in selectedOptions">
                                <span :key="selected.id" class="text-xs bg-gray-200 p-1 text-gray-700 flex items-center w-max" >
                                    <span x-text="selected.translation.name"></span>
                                    <button type="button" x-on:click="update = true; selectedOptions = selectedOptions.filter(item => item.id !== selected.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#333" stroke="#333" stroke-width="0.5" class="bi bi-x" viewBox="0 0 16 16">
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                                </span>
                    </template>
                </template>

                <div class="text-xs text-gray-500 cursor-pointer w-full" x-show="selectedOptions.length == 0" x-on:click="open = !open">
                    აირჩიეთ თაგი
                </div>
            </div>
            <button type="button" class="p-1 bg-gray-200 rounded-[4px]" @click="open = !open">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
        </div>
        <!-- END | Show Selected Elements -->

        <!-- Dropdown Start -->
        <div
            x-cloak
            class="p-3 z-10 h-[270px] overflow-auto rounded-[4px] flex gap-3 w-full border border-gray-500 shadow-lg x-50 absolute flex-col bg-white mt-1"
            x-show="open"
            x-transition:enter=" ease-[cubic-bezier(.3,2.3,.6,1)] duration-200"
            x-transition:enter-start="!opacity-0 !mt-0"
            x-transition:enter-end="!opacity-1 !mt-2"
            x-transition:leave=" ease-out duration-200"
            x-transition:leave-start="!opacity-1 !mt-2"
            x-transition:leave-end="!opacity-0 !mt-0"
        >
            <input
                type="text"
                autofocus
                id="tagfilter{{$product->id}}"
{{--                x-on:keydown.enter="update = true; selectedOptions = [...selectedOptions, {id: Math.random().toString(16).slice(2), name: $event.target.value}]; $event.target.value = ''; filter = '';"--}}
                x-model="filter"
                class="w-full text-xs font-normal p-1 border-b outline-none"
                placeholder="Filter.."
            >
            <!-- Paint Elements -->
            <template x-for="option in options" :key="option.id">
                <ul x-show="filter !== '' ? option.children.some(item => item.translation.name.includes(filter)) : true">
                    <li class="text-xs text-gray-500 font-bold" x-text="option.translation.name"></li>
                    <ul class="ml-1 mt-1">
                        <!-- Print Group Elements -->
                        <template x-for="choice in option.children">
                            <li
                                x-show="filter !== '' ? choice.translation.name.includes(filter) : true"
                                :class="{'bg-gray-200' : selectedOptions.some(item =>  item.id === choice.id)}"
                                x-on:click="update = true; selectedOptions.some(item =>  item.id === choice.id) ? selectedOptions = selectedOptions.filter(item => item.id !== choice.id) : selectedOptions = [...selectedOptions, choice]"
                                class="text-sm cursor-pointer text-gray-800 font-normal p-1.5 w-full hover:bg-gray-200"
                                x-text="choice.translation.name"
                            >
                            </li>
                        </template>
                        <!-- END +Print Group Elements -->
                    </ul>
                </ul>
            </template>
        </div>
        <!-- END | Dropdown -->
    </div>
    <button
        :class="{'bg-blue-600 text-white' : update}"
        x-on:click="() => {
                fetch(
                    'api/product/{{$product->id}}',
                    {
                     method: 'PUT',
                     headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                     },
                     body: JSON.stringify({ tags: selectedOptions.map(obj => obj.id) }) // Fix the syntax error here
                    }
                )
                .then(response => response.json())
            }; update = false"
        class="ml-1 px-2 h-full rounded-md" >
        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5"/>
        </svg>
    </button>
</div>
