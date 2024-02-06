<div class="grid grid-cols-10" x-data="{open: '' }">
    <div class="col-span-10 bg-white shadow p-3 rounded-[4px]">
        <ul class="font-normal  text-xs flex items-center text-gray-700 justify-between">
            @foreach($categories as $category)
                <li
                    x-init="{{ in_array($category->id, $parentCategoryIds) || !empty(array_intersect($categoryIds, $category->children->pluck('id')->toArray())) ? 'open = \'' . $category->slug . '\'' : '' }}"
                    :class="open === '{{$category->slug}}' ? 'font-bold text-gray-900' : ''"
                    class="cursor-pointer"
                    x-on:click="open === '{{$category->slug}}' ? open = '' : open = '{{$category->slug}}'"
                >

                    {{$category->name}}
                </li>
            @endforeach
        </ul>
    </div>
    @foreach($categories as $category)
        <div x-cloak class="col-span-10 bg-white shadow p-3 rounded-[4px] my-2 flex justify-between"
             x-show="open === '{{$category->slug}}'"
        >
            <ul class="font-normal text-xs flex items-center justify-start">
                @foreach($category->children as $child)
                    <li class="mr-4 font-normal text-xs">
                        <a
                            href="items?filters[categoryIds][]={{$child->id}}"
                            class="p-1 hover:bg-gray-200 rounded-[4px] cursor-pointer {{ in_array($child->id, $categoryIds) ? 'bg-gray-200 p-1' : '' }}"
                        >
                            {{$child->name}}
                        </a>
                    </li>
                @endforeach
            </ul>
            <a  href="items?filters[parentCategoryIds][]={{$category->id}}" class="font-normal text-xs hover:bg-gray-200 rounded-[4px] cursor-pointer p-1">ყველა</a>
        </div>
    @endforeach
</div>
