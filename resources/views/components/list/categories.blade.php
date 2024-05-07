<div>
    <ul class="grid-cols-2 md:grid-cols-1 grid">
        @foreach($categories as $category)

            @php
                // i know this is shitty, but I don't care. danke.
                $parentCategoryId = data_get(data_get(request()->get('filters'), 'parentCategoryIds', []), 0);
                $chosenCategoryId = data_get(data_get(request()->get('filters'), 'categoryIds', []), 0);
                $value = in_array($chosenCategoryId, $category->children->pluck('id')->toArray()) ? true : $parentCategoryId == $category->id;
            @endphp
            <li class="my-4 col-span-1" x-data="{open: '{{$value !== false ? $category->slug : false}}'}">
                <div x-on:click="open = '{{$category->slug}}'" class="flex items-center justify-start cursor-pointer font-medium group hover:font-bold hover:text-gray-950">
                    <img src="{{Vite::asset('resources/imgs/category/'.$category->slug.'.png')}}" class="h-6 w-6 group-hover:hidden object-contain" :class="(open === '{{$category->slug}}') && 'hidden'">
                    <img src="{{Vite::asset('resources/imgs/category/'.$category->slug.'-active.png')}}" class="h-6 w-6  group-hover:block object-contain" x-cloak :class="open === '{{$category->slug}}' ? 'block' : 'hidden'">
                    <span class="text-xs text-gray-700 ml-2" :class="(open === '{{$category->slug}}') && 'font-bold text-gray-950'">{{$category->translation->name}}</span>
                </div>
                <ul class="text-xs font-size ml-8" x-cloak  x-show="open === '{{$category->slug}}'">
                    <li>
                        <a href="items?filters[parentCategoryIds][]={{$category->id}}" :class="'{{$category->id}}' == '{{$parentCategoryId}}' ? 'text-xs text-gray-800 mt-2 font-bolder block' : 'text-xs text-gray-600 mt-2 font-normal hover:font-medium block'">ყველა</a>
                    </li>
                    @foreach($category->children as $child)
                        <li>
                            <a href="items?filters[categoryIds][]={{$child->id}}" :class="'{{$child->id}}' == '{{$chosenCategoryId}}' ? 'text-xs text-gray-800 mt-2 font-bolder block' : 'text-xs text-gray-600 mt-2 font-normal hover:font-medium block'">{{$child->translation->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>
