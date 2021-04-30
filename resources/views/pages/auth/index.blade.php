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
            <h1 class="mb-3 text-4xl font-bold text-blue-800 opacity-80">Login</h1>
            @error('fail')
                <div class="text-sm text-red-500">
                    {{ $message }}
                </div>
            @enderror
            <form action="{{route('login')}}" method="post" class="flex flex-col">
                @csrf
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
                <button class="px-3 py-2 mt-12 font-bold text-white bg-blue-700 border-2 focus:outline-none rounded-xl hover:bg-blue-800">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
