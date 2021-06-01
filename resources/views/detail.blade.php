@extends('pages.layout.app')
@section('content')
<div class="flex-row flex-1">
    <div class="flex flex-row flex-1 mt-1">
        <div class="flex-1 p-10">
            <div class="flex items-center p-2 space-x-1 font-bold text-gray-500 bg-white rounded-md opacity-90">
                <span>
                    Detail Barang
                </span>
            </div>
            <div class="mt-3">
                <div class="flex flex-wrap flex-1 p-6 bg-white rounded-md opacity-90">
                    <div class="flex flex-col m-2 border-2 rounded-lg shadow-lg ">
                        <a href="{{ route('home.detail',$product->id) }}" class="flex flex-col items-center flex-shrink-0 bg-white cursor-pointer hover:bg-gray-200">
                            <div class="p-2 rounded-t-lg">
                                <img class="w-44 h-44" src="{{ asset('storage/images/'.$product->photo) }}" alt="" title="">
                            </div>
                            <div class="flex justify-center flex-1 w-full p-2 pt-2 text-xl font-bold text-blue-900 ">
                                <span> {{ $product->name }} </span>
                            </div>
                        </a>
                    </div>
                    <div class="flex-1 p-3 m-2 border-2 shadow-md">
                        <span class="text-2xl font-bold text-blue-900">
                            Detail Barang
                        </span>
                        <p style="white-space: pre-line" class="mt-2 text-blue-800">
                            {{$product->description}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
