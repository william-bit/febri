<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Log In</title>
</head>
<body class="flex flex-col items-center justify-center h-screen bg-blue-50">
    <div class="flex items-center justify-center flex-1 w-full">
        <div class="flex-col w-1/3 p-10 bg-white rounded-lg">
            <h1 class="mb-3 text-4xl font-bold text-blue-800 opacity-80">Register</h1>
            @error('fail')
                <div class="text-sm text-red-500">
                    {{ $message }}
                </div>
            @enderror
            <form action="{{route('register')}}" method="post" class="flex flex-col">
                @csrf
                <label for="email" class="mt-6 text-blue-500">E-Mail</label>
                <input type="text" name="email" id="email" class="p-2 border-b-2 rounded outline-none hover:border-blue-200 focus:border-blue-200">
                @error('email')
                    <div class="text-sm text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                <label for="name" class="mt-6 text-blue-500">Name</label>
                <input type="text" name="name" id="name" class="p-2 border-b-2 rounded outline-none hover:border-blue-200 focus:border-blue-200">
                @error('name')
                    <div class="text-sm text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                <label for="username" class="mt-6 text-blue-500">Username</label>
                <input type="text" name="username" id="username" class="p-2 border-b-2 rounded outline-none hover:border-blue-200 focus:border-blue-200">
                @error('username')
                    <div class="text-sm text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                <label for="password" class="mt-6 text-blue-500">Password</label>
                <input type="password" name="password" id="password" class="p-2 border-b-2 rounded outline-none hover:border-blue-200 focus:border-blue-200">
                @error('password')
                    <div class="text-sm text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                <label for="password_confirmation" class="mt-6 text-blue-500">Password Confirmation</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="p-2 border-b-2 rounded outline-none hover:border-blue-200 focus:border-blue-200">
                @error('password_confirmation')
                    <div class="text-sm text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                <button class="px-3 py-2 mt-12 font-bold text-white bg-green-700 border-2 focus:outline-none rounded-xl hover:bg-green-800">Register</button>
                <a href="{{route('login')}}" class="px-3 py-2 font-bold text-center text-gray-500 border-2 focus:outline-none rounded-xl hover:text-gray-800">Back</a>
            </form>
        </div>
    </div>
</body>
</html>
