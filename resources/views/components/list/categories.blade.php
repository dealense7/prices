<div class="grid grid-cols-10" x-data="{open: '' }">
    <div class="col-span-10">
       <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 font-normal text-sm gap-5">
           @foreach($categories as $category)
               <div
                   x-init="{{ in_array($category->id, $parentCategoryIds) || !empty(array_intersect($categoryIds, $category->children->pluck('id')->toArray())) ? 'open = \'' . $category->slug . '\'' : '' }}"
                   :class="open === '{{$category->slug}}' ? 'font-bold text-gray-900' : ''"
                   class="cursor-pointer col-span-1 flex items-center justify-center bg-white w-full hover:scale-105 transition-all duration-100 h-full p-4 rounded-[4px] shadow-md"
                   x-on:click="open === '{{$category->slug}}' ? open = '' : open = '{{$category->slug}}'"
               >

                   <div class="h-11 w-11 mr-2 flex items-center justify-center relative">
                       <img loading="lazy" class="object-contain absolute h-full w-max" src="storage/{{$category->icon_path}}">
                   </div>
                   @if($category->children->count() > 1)
                       {{$category->name}}
                   @else
                       <a  href="items?filters[parentCategoryIds][]={{$category->id}}">
                           {{str_contains($category->name, 'ხორცი & ნახევარფაბრიკატები') ? 'ხორცი' : $category->name }}
                       </a>
                   @endif
               </div>
           @endforeach
       </div>
    </div>
    @foreach($categories as $category)
        @if($category->children->count() > 1)
            <div x-cloak class="col-span-10 bg-white shadow p-3 rounded-[4px] my-2 flex justify-between"
                 x-show="open === '{{$category->slug}}'"
            >
                <ul class="font-normal grid grid-cols-3 md:grid-cols-5 xl:grid-cols-8  text-xs justify-between w-fit">
                    @foreach($category->children as $child)
                        <li class="mr-4 p-2 font-normal text-xs col-span-1 flex items-center justify-center">
                            <a
                                href="items?filters[categoryIds][]={{$child->id}}"
                                class="p-1 hover:bg-gray-200 rounded-[4px] cursor-pointer {{ in_array($child->id, $categoryIds) ? 'bg-gray-200 p-1' : '' }}"
                            >
                                {{$child->name}}
                            </a>
                        </li>
                    @endforeach

                    <a  href="items?filters[parentCategoryIds][]={{$category->id}}" class="col-span-1 flex items-center justify-center font-normal text-xs hover:bg-gray-200 rounded-[4px] cursor-pointer p-1">ყველა</a>
                </ul>
            </div>
        @endif
    @endforeach
</div>
