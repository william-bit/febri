@extends('pages.layout.app')
@section('content')
<div class="flex-row flex-1">
    <div class="flex flex-col">
        <div class="flex-1 text-white bg-black">
            <div class="px-3 py-2 text-4xl font-bold tracking-wider">
                Top Pick
            </div>
        </div>
        <div class="flex flex-row items-center justify-center flex-1 w-screen p-4 overflow-auto bg-white shadow-lg">
            @foreach ($top as $product)
                <div class="flex flex-col mx-2 shadow-lg">
                    <a href="{{ route('home.detail',$product->id) }}" class="flex flex-col items-center flex-shrink-0 rounded-lg cursor-pointer hover:bg-gray-100">
                        <div class="p-2 border-t-2 border-l-2 border-r-2 rounded-t-lg">
                            <img class="w-56 h-56" src="{{ asset('storage/images/'.$product->photo) }}" alt="" title="">
                        </div>
                        <div class="flex justify-center flex-1 w-full pt-2 text-xl font-bold text-blue-900 border-l-2 border-r-2">
                            <span> {{ $product->name }} </span>
                        </div>
                        <span class="w-full pb-2 text-sm font-semibold text-center text-blue-900 border-b-2 border-l-2 border-r-2 focus:outline-none">
                            Rp.{{ number_format($product->price,2)}}
                        </span>
                    </a>
                    <button value="{{ $product->id }}" class="w-full p-2 text-xl font-bold text-blue-900 transition border-b-2 border-l-2 border-r-2 rounded-b-lg active:delay-150 active:bg-gray-300 checkout-button focus:outline-none hover:bg-gray-100">
                        Add To Cart
                    </button>
                    <a href="{{ route('buy',$product->id) }}" class="w-full p-2 text-xl font-bold text-center text-blue-900 border-b-2 border-l-2 border-r-2 rounded-b-lg buynow-button focus:outline-none hover:bg-gray-100">
                         Buy Now
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div class="flex flex-row flex-1 mt-1 bg-white shadow-lg">
        <div class="p-10">
            <div class="flex items-center space-x-1 font-bold text-blue-800">
                <span>
                    Filter
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
            </div>
            <div class="flex-1 w-full px-16 pt-2 pb-12 mt-5 bg-white border rounded-lg shadow-lg">
                <form action="{{ route('home.category')}}" method="post">
                    @csrf
                    <nav class="flex flex-col">
                        <h2 class="my-3 text-lg font-bold">Category</h2>
                        <button type="submit" name="category" value="all" class="my-2 font-semibold text-left whitespace-nowrap hover:text-blue-600"">All</button>
                        @foreach ($categories as $category)
                            <button type="submit" name="category" value="{{$category->id}}" class="my-2 font-semibold text-left whitespace-nowrap hover:text-blue-600"">{{ $category->name }}</button>
                        @endforeach
                    </nav>
                </form>
            </div>
        </div>
        <div class="flex-1 p-10">
            <div class="flex items-center space-x-1 font-bold text-blue-800">
                <span>
                    Product
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <div class="mt-3">
                <div class="flex flex-wrap items-center flex-1">
                    @foreach ($products as $product)
                        <div class="flex flex-col m-2 rounded-lg shadow-lg">
                            <a href="{{ route('home.detail',$product->id) }}" class="flex flex-col items-center flex-shrink-0 bg-white cursor-pointer hover:bg-gray-200">
                                <div class="p-2 border-t-2 border-l-2 border-r-2 rounded-t-lg">
                                    <img class="w-44 h-44" src="{{ asset('storage/images/'.$product->photo) }}" alt="" title="">
                                </div>
                                <div class="flex justify-center flex-1 w-full pt-2 text-xl font-bold text-blue-900 border-l-2 border-r-2">
                                    <span> {{ $product->name }} </span>
                                </div>
                                <span class="w-full pb-2 text-sm font-semibold text-center text-blue-900 border-b-2 border-l-2 border-r-2 focus:outline-none">
                                    Rp.{{ number_format($product->price,2)}}
                                </span>
                            </a>
                            <button value="{{ $product->id }}" class="w-full p-2 text-xl font-bold text-blue-900 transition border-b-2 border-l-2 border-r-2 active:delay-150 checkout-button focus:outline-none hover:bg-gray-100 active:bg-gray-300">
                                Add To Cart
                            </button>
                            <a href="{{ route('buy',$product->id) }}" class="w-full p-2 text-xl font-bold text-center text-blue-900 border-b-2 border-l-2 border-r-2 rounded-b-lg buynow-button focus:outline-none hover:bg-gray-100">
                                Buy Now
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
