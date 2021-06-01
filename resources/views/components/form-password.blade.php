<div class="flex items-center justify-between">
    <label for="password" class="w-1/4 font-semibold tracking-wide text-gray-500">Password</label>
    <input type="password" value="" name="password" id="password" class="w-1/2 px-3 py-1 my-2 bg-gray-100 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-200">
    @error('password')
        <div class="text-sm text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="flex items-center justify-between">
    <label for="password_confirmation" class="w-1/4 font-semibold tracking-wide text-gray-500">Password Confirmation</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="w-1/2 px-3 py-1 my-2 bg-gray-100 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-200">
    @error('password_confirmation')
        <div class="text-sm text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>
