<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Alvin Wijaya Web</title>
</head>
<body class="flex flex-col bg-blue-100">
    <div class="sticky top-0 flex flex-col flex-1">
        <div class="flex items-center justify-between px-4 py-2 bg-blue-700">
            <div class="flex items-center space-x-6 font-bold text-blue-50">
                <a class="text-3xl font-extrabold tracking-widest cursor-default">ORIENTAL</a>
                <div class="">
                    <input type="text" name="search" placeholder=" Search your item" class="p-1 text-blue-900 border-2 rounded-lg outline-none bg-blue-50 w-96">
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a class="flex px-3 py-2 space-x-2 text-white bg-green-500 rounded-md cursor-pointer hover:bg-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>
                        0 items in cart
                    </span>
                </a>
                @if(auth()->user())
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button class="px-2 text-lg font-bold text-white rounded-lg cursor-pointer hover:text-red-400">Log Out</button>
                    </form>
                @else
                    <a href={{ route('login') }} class="px-2 text-lg font-bold text-green-300 rounded-lg cursor-pointer hover:text-green-100">Sign In</a>
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
</html>
