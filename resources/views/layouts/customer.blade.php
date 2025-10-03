<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giftoria</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div class="font-bold text-xl"><a href="{{ route('home') }}">Giftoria</a></div>
        <div class="flex gap-4">
            <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
            <a href="{{ route('products') }}" class="hover:text-blue-600">Products</a>
            @auth
                <a href="{{ route('cart') }}" class="hover:text-blue-600">Cart</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:text-blue-600">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-blue-600">Login</a>
            @endauth
        </div>
    </nav>

    <main class="py-6 px-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow mt-8 p-4 text-center">
        &copy; {{ date('Y') }} Giftoria. All rights reserved.
    </footer>

    @livewireScripts
</body>
</html>
