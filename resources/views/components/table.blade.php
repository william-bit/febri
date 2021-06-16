@props(['table'])
<div class="flex flex-1 mt-3 overflow-auto bg-white rounded shadow-lg">
    <div class="flex-1 p-8">
        <h3 class="text-2xl font-bold text-gray-800">{{ $table['name'] }}</h3>
        @if(!empty($table['btn']))
            <div class="flex mt-2 space-x-2">
                @foreach ($table['btn'] as $btn => $value)
                    <a href="{{$value['link']}}" target="_blank" class="rounded-lg font-bold px-2 py-1 text-white bg-{{$value['color']}}-500 hover:bg-{{$value['color']}}-600">{{$value['title']}}</a>
                @endforeach
            </div>
        @endif
        <div class="overflow-auto rounded-md shadow-md">
            <table class="w-full mt-3 table-auto min-w-max">
                <thead>
                    <tr class="text-left text-gray-800 bg-gray-200">
                        <th class="p-2">Action</th>
                        <th class="p-2">No</th>
                        @foreach ($table['order'] as $header)
                            <th class="p-2">{{ $header }}</th>
                        @endforeach
                </thead>
                <tbody>
                    @if($table['data']->count())
                        @foreach ($table['data'] as $datum)
                            <tr class="border-b border-gray-200">
                                <td style="white-space: pre-line" class="flex">
                                    <div class="flex items-center justify-center flex-1 space-x-0">
                                        @if(!empty($table['delete']))
                                        <form action="{{ route($table['delete']['link'],$datum->id) }}" method="post" onsubmit="return confirm('Do you really want to delete this data?');" class="flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">
                                                <div class="w-4 mr-2 text-red-800 transform hover:text-red-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </div>
                                            </button>
                                        </form>
                                        @endif
                                        @if(!empty($table['edit']))
                                            <a href="{{ route($table['edit']['link'],$datum->id) }}">
                                                <div class="w-4 mr-2 text-blue-800 transform hover:text-blue-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                    </svg>
                                                </div>
                                            </a>
                                        @endif
                                        @if(!empty($table['confirm']))
                                            @if($datum->{'status'} == 0)
                                            <form action="{{ $table['confirm']['link'] }}" method="post" class="flex text-center">
                                                @csrf
                                                <button type="submit" name="confirm" value="{{$datum->id}}" class="flex px-2 py-1 m-1 font-medium text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                    <span>Confirm Payment</span>
                                                </button>
                                            </form>
                                            @endif
                                        @endif
                                        @if(!empty($table['detail']))
                                            <a href="{{ route($table['detail']['link'],$datum->id) }}">
                                                <div class="w-4 mr-2 text-gray-800 transform hover:text-gray-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                </td>
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
                                                    <table class="w-full">
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
        </div>
        {{ $table['data']->links() }}
    </div>
</div>
