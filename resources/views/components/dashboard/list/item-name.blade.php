<div
    x-data="{
        text: '{{$product->name}}',
        isTextUpdated: false,
    }"
     class="font-normal text-sm flex items-center gap-2 h-full"
>
    @if($product->images->first()->path ?? false)
        <div class="relative h-[70px] w-[70px] bg-white">
                <img alt="logo-{{$product->name}}" src="storage/{{$product->images->first()->path ?? ''}}" class="rounded-md object-cover w-full h-full">
        </div>
    @endif


    <input class="w-full bg-white p-1.5 rounded-[4px] border-gray-500  text-xs h-[40px] " type="text" value="{{$product->name}}" x-model="text" @input="isTextUpdated = true">
    <button :class="{'bg-blue-600 text-white' : isTextUpdated}"
            x-on:click="() => {
                fetch(
                    'api/product/{{$product->id}}',
                    {
                     method: 'PUT',
                     headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                     },
                     body: JSON.stringify({ name: text }) // Fix the syntax error here
                    }
                )
                .then(response => response.json())
            }; isTextUpdated = false"
            class="ml-1 px-2 h-full rounded-md" >
        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5"/>
        </svg>
    </button>
    <small class="text-[8px]">{{$product->code}}</small>
</div>
