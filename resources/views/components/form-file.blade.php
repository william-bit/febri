<div class="flex items-center justify-between">
    @csrf
    <label for="{{ $name }}" class="w-1/4 font-semibold tracking-wide text-gray-500">{{ $label }}</label>
    <div class="relative flex items-center justify-center w-1/2 h-32 bg-gray-100 border-2 border-gray-300 border-dotted rounded-lg">
        <div class="absolute">
            <div class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span class="block font-normal text-gray-400" id="{{ $name }}_filename">Attach you files here</span>
            </div>
        </div>
        <input type="file" value="{{ $value }}" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}" onchange="document.getElementById('{{ $name }}_filename').innerHTML = this.files[0].name" class="w-full h-full opacity-0 cursor-pointer">
    </div>
</div>
@error($name)
    <div class="text-sm text-red-500">
        {{ $message }}
    </div>
@enderror
