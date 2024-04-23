<div>
    <ul>
        @foreach($categories as $category)
            <li class="my-4" x-data="{isOpen: false}">
                <div x-on:click="isOpen = !isOpen" class="flex items-center justify-start cursor-pointer font-medium group hover:font-bold hover:text-gray-950">
                    <img src="{{Vite::asset('resources/imgs/category/'.$category->slug.'.png')}}" class="h-6 w-6 group-hover:hidden object-contain" :class="isOpen && 'hidden'">
                    <img src="{{Vite::asset('resources/imgs/category/'.$category->slug.'-active.png')}}" class="h-6 w-6  group-hover:block object-contain" x-cloak :class="isOpen ? 'block' : 'hidden'">
                    <span class="text-xs text-gray-700 ml-2" :class="isOpen && 'font-bold text-gray-950'">{{$category->translation->name}}</span>
                </div>
                <ul class="text-xs font-size ml-8" x-cloak x-show="isOpen">
                    @foreach($category->children as $child)
                        <li>
                            <a href="#" class="text-xs text-gray-700 mt-2 font-normal hover:font-medium block">{{$child->translation->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>
