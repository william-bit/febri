@extends('pages.layout.app')
@section('content')
    <div class="flex flex-col items-center justify-center flex-1 w-full mt-12">
        <div class="flex items-center justify-center flex-1 w-full mt-12">
            <div class="flex-col w-1/2 p-10 bg-white rounded-lg">
                <h1 class="mb-3 text-4xl font-bold text-center text-blue-800 uppercase opacity-80">Item that you buy</h1>
                <div class="border-b-4">
                    <div class="flex flex-row">
                        <span class="w-1/3 m-2 mt-6 text-xl text-blue-500 border-b-2">Item</span>
                        <span class="w-1/4 m-2 mt-6 text-xl text-blue-500 border-b-2">Price</span>
                        <span class="w-1/3 m-2 mt-6 text-xl text-blue-500 border-b-2">Quantity</span>
                    </div>

                    <div class="flex flex-row">
                        <span class="flex flex-row items-center w-1/3 mt-2 space-x-2 text-xl text-blue-900 border-b-2">
                            <img class="w-24 h-24" src="{{ asset('storage/images/'.$product->photo) }}" alt="" title="">
                            <span>{{$product->name}}</span>
                        </span>
                        <span class="flex flex-row items-center w-1/4 mt-2 text-xl text-blue-900 border-b-2">
                            <span>
                                {{$product->price}}
                            </span>
                        </span>
                        <span class="flex items-center w-1/3 mt-2 space-x-2 text-xl text-blue-900 border-b-2">
                            <input type="number" name="quanty" value="1" class="w-16 p-1 border-4 border-gray-200 rounded-lg bg-whte">
                            <button class="p-1.5 font-bold text-white bg-red-600 rounded-lg">Remove</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center flex-1 w-full mt-12">
            <div class="flex-col w-1/2 p-10 bg-white rounded-lg">
                <h1 class="mb-3 text-4xl font-bold text-center text-blue-800 uppercase opacity-80">Alamat Dan Cara Pembayaran</h1>
                <div class="border-b-4">
                    <span class="mb-3 text-lg font-semibold text-center text-blue-800 uppercase opacity-80">
                        Alamat
                    </span>
                </div>
                <div class="border-b-4">
                    <span class="mb-3 text-lg font-semibold text-center text-blue-800 uppercase opacity-80">
                        Cara Pembayaran
                    </span>
                </div>
                <form action="{{route('login')}}" method="post" class="flex flex-col">
                    @csrf
                    <button class="px-3 py-2 mt-12 font-bold text-white bg-green-700 border-2 focus:outline-none rounded-xl hover:bg-green-800">Bayar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
