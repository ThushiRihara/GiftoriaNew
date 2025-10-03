<nav class="bg-white shadow p-4 flex justify-between items-center">
    <!-- Logo -->
    <div class="text-xl font-bold">
        <a href="{{ route('home') }}">Giftoria</a>
    </div>

    <!-- Main Links -->
    <div class="flex space-x-4">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <a href="{{ route('products') }}" class="hover:text-blue-600">Products</a>
        <a href="#" class="hover:text-blue-600">Reviews</a>
    </div>

    <!-- Right Side: Cart & Auth Links -->
    <div class="flex space-x-4 items-center">
        <!-- Cart -->
        <a href="{{ route('cart') }}" class="relative">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4"></path>
                <circle cx="7" cy="21" r="1"></circle>
                <circle cx="17" cy="21" r="1"></circle>
            </svg>
            @if(session()->has('cart') && count(session('cart')) > 0)
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-1">
                    {{ count(session('cart')) }}
                </span>
            @endif
        </a>

        <!-- Auth Links -->
        @auth
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Profile</a>
        @else
            <a href="{{ route('login') }}" class="hover:text-blue-600">Login</a>
        @endauth
    </div>
</nav>
