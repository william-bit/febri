<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Admin Service</title>
</head>
<body class="overflow-hidden">
    <div class="flex h-screen bg-gray-100">
        <div class="w-64 px-4 bg-white border-r-2">
            <div class="sticky top-0 px-4 py-3">
                <a href="{{ route('dashboard') }}" class="mb-3 text-2xl font-bold text-gray-800 uppercase">Admin Oriental</a>
                <nav class="flex flex-col mt-8 space-y-3">
                    <a href="{{ route('dashboard') }}" class="w-full p-2 rounded-lg font-semibold {{ request()->is('admin') ? 'bg-gray-200 rounded-lg shadow-sm' : 'hover:bg-gray-200'}}">Dashboard</a>
                    @auth
                        <a href="{{ route('product') }}" class="w-full p-2 font-semibold rounded-lg {{ request()->is('admin/product') ? 'bg-gray-200 rounded-lg shadow-sm' : 'hover:bg-gray-200'}}">List Product</a>
                        <a href="{{ route('category') }}" class="w-full p-2 font-semibold rounded-lg {{ request()->is('admin/category') ? 'bg-gray-200 rounded-lg shadow-sm' : 'hover:bg-gray-200'}}">List Category</a>
                        <a href="{{ route('member') }}" class="w-full p-2 font-semibold rounded-lg {{ request()->is('admin/member') ? 'bg-gray-200 rounded-lg shadow-sm' : 'hover:bg-gray-200'}}">List Member</a>
                        <a href="{{ route('transaction') }}" class="w-full p-2 font-semibold rounded-lg {{ request()->is('admin/transaction') ? 'bg-gray-200 rounded-lg shadow-sm' : 'hover:bg-gray-200'}}">Report Transaction</a>
                    @endauth
                </nav>
            </div>
        </div>
        <div class="flex flex-col flex-1">
            <div class="sticky top-0 flex items-center justify-between px-3 py-3 bg-white border-b-2">
                <ul class="px-3 font-medium text-gray-800">
                    <li class="uppercase">{{ $title }}</li>
                </ul>
                <ul class="flex px-3 space-x-3">
                    @if(auth()->user())
                        <li>
                            <a href="{{route('home')}}" class="font-bold text-gray-300 hover:text-gray-400 text-md">Go To Home</a>
                        </li>
                        <li>
                            <a href="" class="font-bold text-md">{{ auth()->user()->name }}</a>
                        </li>
                        <li>
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <button class="px-4 py-1 text-sm font-semibold text-center text-red-500 rounded-3xl hover:text-red-600">Log Out</button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a class="font-semibold" href="">Guest</a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="px-4 py-1 text-sm font-medium text-center text-white bg-blue-500 rounded-3xl hover:bg-blue-600">Log In</a>
                        </li>
                    @endif
                </ul>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>
