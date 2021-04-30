<div class="flex items-center justify-between">
    @csrf
    <label for="{{ $name }}" class="w-1/4 font-semibold tracking-wide text-gray-500">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}" class="w-1/2 h-24 px-3 py-1 my-2 bg-gray-100 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-200">{{$value}}</textarea>

</div>
@error($name)
    <div class="text-sm text-red-500">
        {{ $message }}
    </div>
@enderror
