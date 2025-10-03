<div>
    @foreach($categories as $category)
        <h2 class="text-xl font-semibold mt-6">{{ $category->category_name }}</h2>
        <div class="grid grid-cols-4 gap-4">
            @foreach($category->gifts as $gift)
            <div class="border p-2 rounded flex flex-col items-center w-32">
                <div class="w-24 h-24 overflow-hidden rounded">
                    <img src="{{ asset('storage/'.$gift->image) }}" 
                         class="w-full h-full object-cover object-center">
                </div>
                <h4 class="font-semibold mt-1 text-center text-sm">{{ $gift->name }}</h4>
                <p class="text-center text-sm">Rs {{ $gift->price }}</p>
                <a href="{{ route('products.show',$gift->id) }}" 
                   class="bg-blue-500 text-white px-2 py-1 rounded mt-1 text-xs inline-block text-center">
                   View
                </a>
            </div>
            @endforeach
        </div>
    @endforeach
</div>
