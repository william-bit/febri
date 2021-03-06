@extends('pages.layout.app')
@section('content')
<div class="flex-row flex-1">
    <div class="flex flex-row flex-1 mt-1">
        <div class="flex-1 p-10">
            <div class="flex items-center p-2 mt-3 space-x-1 font-bold text-gray-500 bg-white rounded-md opacity-90">
                <span>
                    Purchase list
                </span>
            </div>
            <div class="flex flex-col flex-wrap flex-1 p-6 mt-3 bg-white rounded-md opacity-90">
                @foreach ($transactions as $transaction)
                    <div class="flex flex-col flex-1 p-3 m-2 border-2 shadow-md">
                        <span class="text-2xl font-bold text-blue-900">
                            Purchase list
                        </span>
                        <span class="text-xl font-bold text-blue-900 border-b rounded">
                            purchase date = {{ $transaction->updated_at }}
                        </span>
                        <span class="text-xl font-bold text-blue-900 border-b rounded">
                            @switch($transaction->status)
                                @case(0)
                                    Payment progress = (Payment verification)
                                    @break
                                @case(1)
                                    Payment progress = (Product on destination to customer)
                                    @break
                                @case(4)
                                    Payment progress = (Rejected)
                                    @break
                                @case(2)
                                    Payment progress = (Finish)
                                    @break
                                @default
                            @endswitch
                        </span>
                        <div>
                            @foreach (json_decode($transaction->product) as $product)
                                <div class="flex flex-row justify-between">
                                    <span class="flex flex-row items-center w-1/3 mx-2 mt-2 space-x-2 text-xl text-blue-900 border-b-2">
                                        <a href="{{asset('storage/images/'.$product->photo)}}" data-lightbox="{{$product->name}}" data-title="{{$product->name}}">
                                            <img class="w-24 h-24" src="{{ asset('storage/images/'.$product->photo) }}" alt="" title="">
                                        </a>
                                        <span class="max-w-0">{{$product->name}}</span>
                                    </span>
                                    <span class="flex flex-row items-center w-1/4 mx-2 mt-2 text-xl text-blue-900 border-b-2">
                                        <span>
                                            {{$product->quantity}} Pcs
                                        </span>
                                    </span>
                                    <span class="flex flex-row items-center w-1/4 mx-2 mt-2 text-xl text-blue-900 border-b-2">
                                        <span>
                                            Rp.{{number_format($product->price,2)}}
                                        </span>
                                    </span>
                                    <span class="flex flex-row items-center w-1/4 mx-2 mt-2 text-xl text-blue-900 border-b-2">
                                        <span>
                                            Rp.{{number_format($product->price * $product->quantity,2)}}
                                        </span>
                                    </span>
                                </div>
                            @endforeach
                            <div class="flex flex-row items-center justify-end mx-2 mt-2 text-xl text-blue-900 border-b-2">
                                <span class="mr-10">
                                    Total = Rp.{{number_format($transaction->total,2)}}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
