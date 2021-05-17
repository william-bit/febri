@extends('pages.layout.app')
@section('content')
    <div class="flex flex-col items-center justify-center flex-1 w-full mt-12">
        <div class="flex-col w-1/2 p-10 bg-white rounded-lg">
            <h1 class="mb-3 text-4xl font-bold text-center text-blue-800 uppercase opacity-80">Cart</h1>
            <div class="border-b-4">
                <div class="flex flex-row">
                    <span class="w-1/3 m-2 mt-6 text-xl text-blue-500 border-b-2">Item</span>
                    <span class="w-1/4 m-2 mt-6 text-xl text-blue-500 border-b-2">Price</span>
                    <span class="w-1/3 m-2 mt-6 text-xl text-blue-500 border-b-2">Quantity</span>
                </div>
                @foreach ($products as $product)
                    <div class="flex flex-row">
                        <span class="flex flex-row items-center w-1/3 mx-2 mt-2 space-x-2 text-xl text-blue-900 border-b-2">
                            <img class="w-24 h-24" src="{{ asset('storage/images/'.$product->photo) }}" alt="" title="">
                            <span>{{$product->name}}</span>
                        </span>
                        <span class="flex flex-row items-center w-1/4 mx-2 mt-2 text-xl text-blue-900 border-b-2">
                            <span>
                                Rp.{{number_format($product->price,2)}}
                            </span>
                        </span>
                        <span class="flex items-center w-1/3 mx-2 mt-2 space-x-2 text-xl text-blue-900 border-b-2">
                            <input type="number" name="quanty" value="1" class="w-16 p-1 bg-white border-4 border-gray-200 rounded-lg">
                            <button class="p-1.5 font-bold text-white bg-red-600 rounded-lg hover:bg-red-700">Remove</button>
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex items-center justify-center flex-1 w-full mt-12">
            <form action="{{route('checkout')}}" method="post" class="flex-col w-1/2 p-10 bg-white rounded-lg">
                @csrf
                <h1 class="mb-3 text-4xl font-bold text-center text-blue-800 uppercase opacity-80">Alamat Dan Cara Pembayaran</h1>
                <div class="border-b-4">
                    <span class="mb-3 text-lg font-semibold text-center text-blue-800 uppercase opacity-80">
                        Alamat (+ RP.5,000,00 for transport fee)
                    </span>
                </div>
                @error('location')
                    <div class="text-sm text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                <input type="text" name="location" class="w-full p-2 mb-5 border-b-2 rounded outline-none hover:border-blue-200 focus:border-blue-200">
                <div class="border-b-4">
                    <span class="mb-3 text-lg font-semibold text-center text-blue-800 uppercase opacity-80">
                        Cara Pembayaran
                    </span>
                </div>
                <div class="flex flex-col">
                    @if(auth()->user())
                        <button class="px-3 py-2 mt-12 font-bold text-white bg-green-700 border-2 focus:outline-none rounded-xl hover:bg-green-800">Bayar</button>
                    @else
                        <a href="{{route('login')}}" class="px-3 py-2 mt-12 font-bold text-center text-white bg-green-700 border-2 focus:outline-none rounded-xl hover:bg-green-800">Bayar</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
