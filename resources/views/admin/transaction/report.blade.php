<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{$title}}</title>
        <style>
            h1 {

            }
            .w-full {
                width: 100%;
            }
            .border {
                border-width: 1px;
            }
            .border-solid {
                border-style: solid;
            }
            .border-black {
                border-color: black;
            }
            .border-collapse {
                border-collapse: collapse;
            }
            }
        </style>
    </head>
    <body>
        <h1>Report Penjualan</h1>
        <table border="1" class="w-full border-collapse border-black border-solid border-1">
            <thead>
                <tr>
                    <th class="p-2">No</th>
                    @foreach ($table['order'] as $name => $header)
                        <th class="border">{{$header}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @if($table['data']->count())
                    @foreach ($table['data'] as $datum)
                        <tr class="border-b border-gray-200">
                            <td class="p-2">{{ (isset($no))?$no+=1:($no = 1 + $table['data']->perpage() * ($table['data']->currentpage() - 1)) }}</td>
                            @foreach ($table['order'] as $name => $header)
                                @if (strpos($name, '.') !== false)
                                    @php [$relationship,$column] = explode('.',$name); @endphp
                                    @if (isset($table['concat']))
                                        @if (in_array($table['concat'],$name))
                                            <td class="p-2">{{ implode(',',array_column($datum->{$relationship}->toArray(),$column)) }}</td>
                                        @else
                                            <td class="p-2">{{ $datum->{$relationship}->{$column} }}</td>
                                        @endif
                                    @else
                                        <td class="p-2">{{ $datum->{$relationship}->{$column} }}</td>
                                    @endif
                                @elseif (!empty($table['valueConvert'][$name]))
                                    <td class="p-2">{{ $table['valueConvert'][$name][array_search($datum->{$name},array_column($table['valueConvert'][$name],'id'))]['value'] }}</td>
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
                                                    <tr class="bg-gray-100 border-b-2">
                                                        <td class="w-6">No</td>
                                                        <td class="w-2/3"> Nama </td>
                                                        <td class="w-2/3"> Qty </td>
                                                        <td class="pl-2"> Price</td>
                                                        <td class="pl-2"> SubTotal </td>
                                                    </tr>
                                                    @foreach (json_decode($datum->{$name},true) as $jsonKey => $jsonValue)
                                                        <tr class="border-b-2">
                                                            <td class="w-6"> {{ $jsonKey+1 }}. </td>
                                                            <td class="w-2/3"> {{ $jsonValue['name'] }} </td>
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
                                        <td style="white-space: pre-line" class="p-2">{{ $datum->{$name} }}</td>
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
    </body>
</html>