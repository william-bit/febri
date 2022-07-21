<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">
    <title>Febri Ramdani</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body class="flex flex-col bg-blue-100">
    <div class="sticky top-0 z-10 flex flex-col flex-1">
        <div class="flex items-center justify-between px-4 py-2 bg-blue-700">
            <div class="flex items-center space-x-6 font-bold text-blue-50">
                <a href="{{ route('home') }}"
                    class="flex items-center text-3xl font-extrabold tracking-widest cursor-pointer hover:text-blue-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>

                </a>
                <form action="{{ route('home.selection') }}" class="flex-1">
                    @csrf
                    <div class="relative w-full " id="search-box">
                        <input type="text" name="search" placeholder=" Search your item"
                            class="p-1 text-blue-900 border-2 rounded-lg outline-none bg-blue-50 w-96">
                        <ul class="absolute z-10 hidden w-full p-1 text-gray-600 bg-white border-b-2 border-l-2 border-r-2 rounded-lg"
                            id='suggest-box'> </ul>
                    </div>
                </form>
            </div>
            <div class="flex items-center space-x-2">
                @if (auth()->user())
                    <a href="{{ route('checkout') }}"
                        class="flex px-3 py-2 space-x-2 text-white bg-green-500 rounded-md cursor-pointer hover:bg-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span
                            id="checkOutBag">{{ is_array(session('productCheckout')) ? count(session('productCheckout')) : 0 }}</span>
                        <span>
                            items in cart
                        </span>
                    </a>
                    <div class="dropdown">
                        <button
                            class="w-10 h-10 text-xl font-bold text-center bg-white rounded-full dropdown-button hover:bg-gray-200">
                            {{ Str::upper(substr(auth()->user()->name, 0, 1)) }}</button>
                        <div
                            class="absolute z-20 flex-col hidden w-48 p-2 mt-3 text-sm bg-white border rounded dropdown-list right-4">
                            @if (auth()->user())
                                @if (auth()->user()->role_id === 1)
                                    <a href="{{ route('dashboard') }}"
                                        class="px-2 py-1 text-lg rounded hover:bg-blue-200">Go to Admin Panel</a>
                                @endif
                            @endif
                            <a class="px-2 py-1 text-lg rounded hover:bg-blue-200"
                                href="{{ route('purchase_list') }}">Purchase list</a>
                            <a class="px-2 py-1 text-lg rounded hover:bg-blue-200"
                                href="{{ route('user') }}">Profile</a>
                            <form action="{{ route('logout') }}" method="post"
                                class="px-2 py-1 rounded hover:bg-blue-200">
                                @csrf
                                <button class="w-full text-left">Log Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="flex px-3 py-2 space-x-2 text-white bg-green-500 rounded-md cursor-pointer hover:bg-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span
                            id="checkOutBag">{{ is_array(session('productCheckout')) ? count(session('productCheckout')) : 0 }}</span>
                        <span>
                            items in cart
                        </span>
                    </a>
                    <a href={{ route('login') }}
                        class="px-2 text-lg font-bold text-white rounded-lg cursor-pointer hover:text-gray-100">Sign
                        In</a>
                @endif
            </div>
        </div>
        <div class="sticky p-1 bg-black"></div>
        <div class="p-0.5 bg-gray-400"></div>
    </div>
    <div class="flex flex-row flex-1">
        @yield('content')
    </div>
</body>
<script>
    const APP_URL = '{!! URL::to('/') !!}';
</script>
<script>
    function selectSuggest(element) {
        let selectUserData = element.textContent;
        let searchBox = document.getElementById('search-box');
        searchBox.querySelector('input').value = selectUserData;
    }
</script>
<script src="{{ asset('js/lightbox.js') }}"></script>
<script src="{{ asset('js/app.js') }}" async></script>

</html>
