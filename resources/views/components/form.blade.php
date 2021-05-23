@props(['forms','action','submit'])
<div class="flex flex-1 overflow-auto bg-white rounded shadow-lg">
    <div class="w-2/3 p-8">
        <h3 class="text-2xl font-bold text-gray-800">{{ $forms['name'] }}</h3>
        <form action="{{ $action }}" method="post" enctype="multipart/form-data" class="flex flex-col" >
            @foreach ($forms['data'] as $name => ['type' => $type,'value'=> $value,'label' => $label,'placeholder' => $placeholder])
                @switch($type)
                    @case('text')
                        <x-form-text :value='$value' :label='$label' :placeholder='$placeholder' :name='$name'></x-form-text>
                    @break
                    @case('number')
                        <x-form-number :value='$value' :label='$label' :placeholder='$placeholder' :name='$name'></x-form-number>
                    @break
                    @case('textarea')
                        <x-form-textarea :value='$value' :label='$label' :placeholder='$placeholder' :name='$name'></x-form-textarea>
                    @break
                    @case('file')
                        <x-form-file :value='$value' :label='$label' :placeholder='$placeholder' :name='$name'></x-form-file>
                    @break
                    @case('dropdown')
                        <x-form-dropdown :value='$value' :label='$label' :placeholder='$placeholder' :name='$name'></x-form-dropdown>
                    @break

                    @default
                @endswitch
            @endforeach
            <div class="flex justify-end mt-2 space-x-2">
                @switch($forms['type'])
                    @case('add')
                        <button type="reset" class="px-3 py-2 font-bold text-yellow-400 hover:text-yellow-500 focus:outline-none" value="Cancel">Cancel</button>
                        <button type="submit" class="px-3 py-2 font-bold text-green-600 hover:text-green-700 focus:outline-none">{{ $submit }}</button>
                    @break
                    @case('edit')
                        <button type="reset" class="px-3 py-2 font-bold text-gray-400 hover:text-gray-500 focus:outline-none" value="Cancel">Cancel</button>
                        <button type="submit" class="px-2 py-0.5 font-bold text-yellow-600 rounded-xl hover:text-yellow-700 focus:outline-none">{{ $submit }}</button>
                    @break
                    @default
                @endswitch
            </div>
        </form>
    </div>
</div>
