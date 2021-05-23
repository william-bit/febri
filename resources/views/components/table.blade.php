@props(['table'])
<div class="flex flex-1 mt-3 overflow-auto bg-white rounded shadow-lg">
    <div class="flex-1 p-8">
        <h3 class="text-2xl font-bold text-gray-800">{{ $table['name'] }}</h3>
        <div class="overflow-auto rounded-md shadow-md">
            <table class="w-full mt-3 table-auto min-w-max">
                <head>
                    <tr class="text-left text-gray-800 bg-gray-200">
                        <th class="p-2">Action</th>
                        <th class="p-2">No</th>
                        @foreach ($table['order'] as $header)
                            <th class="p-2">{{ $header }}</th>
                        @endforeach
                </head>
                <body>
                    @if($table['data']->count())
                        @foreach ($table['data'] as $datum)
                            <tr class="border-b border-gray-200">
                                <td class="flex items-center p-2 space-x-0">
                                    @if(!empty($delete))
                                    <form action="{{ route($delete,$datum->id) }}" method="post" onsubmit="return confirm('Do you really want to delete this data?');">
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
                                    @if(!empty($edit))
                                        <a href="{{ route($edit,$datum->id) }}">
                                            <div class="w-4 mr-2 text-blue-800 transform hover:text-blue-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                            </div>
                                        </a>
                                    @endif
                                    @if(!empty($detail))
                                        <a href="{{ route($detail,$datum->id) }}">
                                            <div class="w-4 mr-2 text-gray-800 transform hover:text-gray-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </div>
                                        </a>
                                    @endif
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
                                        <td class="p-2">{{ $datum->{$name} }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="{{count($table['order']) + 2}}">Row Empty</th>
                        </tr>
                    @endif
                </body>
            </table>
        </div>
        {{ $table['data']->links() }}
    </div>
</div>
