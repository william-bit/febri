@extends('pages.layout.app')
@section('content')
<form action="{{route('checkout')}}" method="post" enctype="multipart/form-data"  class="flex-1">
    <div class="flex flex-col items-center justify-center flex-1 w-full mt-12">
        <div class="flex-col w-1/2 p-10 bg-white rounded-lg">
            <h1 class="mb-3 text-4xl font-bold text-center text-blue-800 uppercase opacity-80">Cart</h1>
            <div class="flex flex-row">
                <span class="w-1/3 m-2 mt-6 text-xl text-blue-500 border-b-2">Item</span>
                <span class="w-1/4 m-2 mt-6 text-xl text-blue-500 border-b-2">Price</span>
                <span class="w-1/3 m-2 mt-6 text-xl text-blue-500 border-b-2">Quantity</span>
            </div>
            <div class="border-b-4 cart-items">
                @php
                    $totalPrice = 0;
                @endphp
                @foreach ($products as $product)
                    @php
                        $totalPrice += $product->price;
                    @endphp
                    <div class="flex flex-row cart-row">
                        <span class="flex flex-row items-center w-1/3 mx-2 mt-2 space-x-2 text-xl text-blue-900 border-b-2">
                            <a href="{{asset('storage/images/'.$product->photo)}}" data-lightbox="{{$product->name}}" data-title="{{$product->name}}">
                                <img class="w-24 h-24" src="{{ asset('storage/images/'.$product->photo) }}" alt="" title="">
                            </a>
                            <span class="max-w-0">{{$product->name}}</span>
                        </span>
                        <span class="flex flex-row items-center w-1/4 mx-2 mt-2 text-xl text-blue-900 border-b-2 cart-price">
                                Rp.{{number_format($product->price,2)}}
                        </span>
                        <span class="flex items-center w-1/3 mx-2 mt-2 space-x-2 text-xl text-blue-900 border-b-2 cart-quantity">
                            <input type="hidden" name="item[id][]" value="{{$product->id}}">
                            <input type="number" name="item[quantity][]" value="1" class="w-16 p-1 bg-white border-4 border-gray-200 rounded-lg cart-quantity-input">
                            <button value="{{$product->id}}" class="p-1.5 font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 remove-button">Remove</button>
                        </span>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-end border-b-4 cart-total">
                <div class="mr-24">
                    <span class="text-lg font-bold">Total</span>
                    <span class="text-lg font-bold cart-total-price">Rp.{{number_format($totalPrice)}}.00</span>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center flex-1 w-full mt-12">
            <div class="flex-col w-1/2 p-10 bg-white rounded-lg">
                @csrf
                <h1 class="mb-3 text-4xl font-bold text-center text-blue-800 uppercase opacity-80">Payment method and shipping address</h1>
                <div class="border-b-4">
                    <span class="mb-3 text-lg font-semibold text-center text-blue-800 uppercase opacity-80">
                        Shipping address (+ RP.5,000,00 for transport fee)
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
                        Payment Method
                    </span>
                </div>
                <p class="my-4 font-semibold text-blue-800">Transfer to this BCA Account : 628135464</p>
                <div class="border-b-4">
                    <span class="mb-3 text-lg font-semibold text-center text-blue-800 uppercase opacity-80">
                        Proof Of payment
                    </span>
                </div>
                <div class="mt-5">
                    <x-form-file value='' label='Picture Proof' placeholder='Bukti Pembayaran' name='photo'></x-form-file>
                </div>
                <div class="flex flex-col">
                    @if(auth()->user())
                        <button class="px-3 py-2 mt-12 font-bold text-white bg-green-700 border-2 focus:outline-none rounded-xl hover:bg-green-800">Bayar</button>
                    @else
                        <a href="{{route('login')}}" class="px-3 py-2 mt-12 font-bold text-center text-white bg-green-700 border-2 focus:outline-none rounded-xl hover:bg-green-800">Bayar</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
