<div>
    <div class="grid grid-cols-5 gap-3">
        @foreach($stores as $store)
            <div class="col-span-1 w-full h-full bg-white shadow p-14 rounded-md flex items-center justify-center">
                <img alt="logo-{{$store->name}}" src="storage/{{$store->logo->path}}" class="h-8 object-contain">
                <div class="ml-2 grid">
                    <h4 class="font-medium m-0">{{$store->name}}</h4>
                    <span class="font-normal text-xs">{{$store->year}}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
