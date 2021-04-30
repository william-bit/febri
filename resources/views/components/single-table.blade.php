<div class="flex flex-1 mt-3 overflow-auto bg-white rounded shadow-lg">
    <div class="flex-1 p-8">
        <h3 class="text-2xl font-bold text-gray-800">Current Data</h3>
        <div class="rounded-md shadow-md">
            <table class="w-full mt-3 table-auto min-w-max">
                <head>
                    <tr class="text-left text-gray-800 bg-gray-200">
                        <th class="p-2">No</th>
                        @foreach ($table['order'] as $header)
                            <th class="p-2">{{ $header }}</th>
                        @endforeach
                    </tr>
                </head>
                <body>
                    @if($table['data']->count())
                        <tr class="border-b border-gray-200">
                            <td class="p-2">1</td>
                            @foreach ($table['order'] as $name => $header)
                                @if (strpos($name, '.') !== false)
                                    @php [$relationship,$column] = explode('.',$name); @endphp
                                    <td class="p-2">{{ $table['data']->{$relationship}->{$column} }}</td>
                                @else
                                    <td class="p-2">{{ $table['data']->{$name} }}</td>
                                @endif
                            @endforeach
                        </tr>
                    @else
                        <tr>
                            <th colspan="{{count($table['order'])}}">Row Empty</th>
                        </tr>
                    @endif
                </body>
            </table>
        </div>
    </div>
</div>
