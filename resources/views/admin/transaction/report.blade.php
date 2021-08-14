<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{$title}}</title>
        <style>
            .table-style {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            .mr-4 {
                margin-right: 2rem/* 16px */;
            }
            .w-full {
                width: 100%;
            }
            .td-s {
                word-wrap: break-word;
            }
            .table-style td, .table-style th {
                border: 1px solid #ddd;
            }

            .table-style tr:nth-child(even){background-color: #f2f2f2;}

            .table-style tr:hover {background-color: #ddd;}

            .table-style th {
                padding: 5px;
                text-align: left;
                background-color: #044caa;
                color: white;
            }
            .inline-block{
                display: inline-block;
            }
            .float-right{
                float: right;
            }
            .h-24{
                height: 6rem;
            }
            .w-full{
                width: 100%;
            }
            .border {
                border-width: 1px;
                border-style: solid;
            }
            .border-8 {
                border-width: 3px;
                border-style: solid;
            }
            .border-black {
                --tw-border-opacity: 1;
                border-color: rgba(0, 0, 0, var(--tw-border-opacity));
            }
            .mt-1 {
                margin-top: 0.25rem/* 4px */;
            }
            .mt-2 {
                margin-top: 0.5rem/* 4px */;
            }
            .mt-8 {
                margin-top: 100px/* 4px */;
            }
            .underline {
                text-decoration: underline;
            }
            .relative {
                position: relative;
            }
        </style>
    </head>
    <body>
        <div>
            <img class="inline-block h-24" src="{{ asset('storage/asset/logo.jpg') }}" alt="" tie="">
            <div class="inline-block float-right">
                <div>{{asset('storage/asset/logo.jpg') }}</div>
                <div><b>PT. ORIENTAL UNTUK INDONESIA</b></div>
                <div>Jalan Raya Curug Wetan, Kp. Tegal RT 002/RW 05</div>
                <div>Kec. Curug, Kel. Curug Wetan, Kab. Tangerang</div>
                <div>Telp : 081212269327</div>
                <a style="color: blue;" class="underline">orientaljuice01@gmail.com</a>
            </div>
        </div>
        <div style="margin-top: 10px">
            <div class="block mt-1 border border-black w-border"> </div>
            <div class="block mt-8 border-8 border-black w-border"> </div>
        </div>
        <div style="margin-top: 10px">
            <h1>Report Transaction</h1>
            <table class="w-full table-style">
                <thead>
                    <tr>
                        <th>No</th>
                        @foreach ($table['order'] as $name => $header)
                            <th class="border">{{$header}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if($table['data']->count())
                        @foreach ($table['data'] as $datum)
                            <tr class="border-b border-gray-200">
                                <td class="td-w">{{ (isset($no))?$no+=1:($no = 1 + $table['data']->perpage() * ($table['data']->currentpage() - 1)) }}</td>
                                @foreach ($table['order'] as $name => $header)
                                    @if (strpos($name, '.') !== false)
                                        @php [$relationship,$column] = explode('.',$name); @endphp
                                        @if (isset($table['concat']))
                                            @if (in_array($table['concat'],$name))
                                                <td class="td-s">{{ implode(',',array_column($datum->{$relationship}->toArray(),$column)) }}</td>
                                            @else
                                                <td class="td-s">{{ $datum->{$relationship}->{$column} }}</td>
                                            @endif
                                        @else
                                            <td class="td-s">{{ $datum->{$relationship}->{$column} }}</td>
                                        @endif
                                    @elseif (!empty($table['valueConvert'][$name]))
                                        <td class="td-s">{{ $table['valueConvert'][$name][array_search($datum->{$name},array_column($table['valueConvert'][$name],'id'))]['value'] }}</td>
                                    @else
                                    @php
                                        $custom = false;
                                    @endphp
                                        @if(!empty($table['json']))
                                            @if(in_array($name,$table['json']))
                                                @php
                                                    $custom = true;
                                                @endphp
                                                <td class="p-2">
                                                    <table border="1" class="w-full border-collapse border-black border-solid border-1">
                                                        <tr class="">
                                                            <td class="w-6">No</td>
                                                            <td class="td-s max-s"> Name </td>
                                                            <td class="w-2/3"> Qty </td>
                                                            <td class="pl-2"> Price</td>
                                                            <td class="pl-2"> SubTotal </td>
                                                        </tr>
                                                        @foreach (json_decode($datum->{$name},true) as $jsonKey => $jsonValue)
                                                            <tr class="">
                                                                <td class="w-6"> {{ $jsonKey+1 }}. </td>
                                                                <td class="td-s max-s"> {{ $jsonValue['name'] }} </td>
                                                                <td class="w-2/3"> {{ (!empty($jsonValue['quantity']))?$jsonValue['quantity']:''}} </td>
                                                                <td class="pl-2"> Rp.{{ number_format($jsonValue['price'] )}} </td>
                                                                <td class="pl-2"> Rp.{{ number_format($jsonValue['price']*$jsonValue['quantity'] )}} </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                            @endif
                                        @endif

                                        @if(!empty($table['photo']))
                                            @if(in_array($name,$table['photo']))
                                                @php
                                                    $custom = true;
                                                @endphp
                                                <td class="p-2">
                                                    <a href="{{asset('storage/images/'.$datum->{$name})}}" data-lightbox="{{($datum->{$name})}}" data-title="{{($datum->{$name})}}">
                                                        <img class="w-24 h-24 rounded" src="{{ asset('storage/images/'.$datum->{$name}) }}" alt="" title="">
                                                    </a>
                                                </td>
                                            @endif
                                        @endif


                                        @if(!empty($table['currency']))
                                            @if(in_array($name,$table['currency']))
                                                @php
                                                    $custom = true;
                                                @endphp
                                                <td class="p-2">RP.{{ number_format($datum->{$name})}}</td>
                                            @endif
                                        @endif

                                        @if(!$custom)
                                            <td style="white-space: pre-line" class="td-s">{{ $datum->{$name} }}</td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="{{count($table['order']) + 2}}">Row Empty</th>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="relative">
                <div class="mt-2" style="text-align: right">
                    <div class="mr-4">Tangerang, 28 Juni 2021 </div>
                    <div>
                        <img class="inline-block h-24" src="{{ asset('storage/asset/ttd.jpg') }}" alt="" tie="">
                    </div>
                    <div class="mr-4">Arizal Rio Siawang</div>
                    <div class="mr-4">Direktur Utama</div>
                </div>
            </div>
        </div>
    </body>
</html>
