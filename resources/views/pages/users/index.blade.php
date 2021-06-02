@extends('pages.layout.app')
@section('content')
<div class="flex-row flex-1">
    <div class="flex flex-row flex-1 mt-1">
        <div class="flex-1 p-10">
            <div class="flex items-center p-2 space-x-1 font-bold text-gray-500 bg-white rounded-md opacity-90">
                <span>
                    Profile User
                </span>
            </div>
            <div class="mt-3">
                <div class="flex flex-wrap flex-1 p-6 bg-white rounded-md opacity-90">
                    <div class="flex-1 p-3 m-2 border-2 shadow-md">
                        <span class="text-2xl font-bold text-blue-900">
                            {{auth()->user()->name}}
                        </span>
                        <div>
                            <x-form-text name='name' label='Name' value='{{auth()->user()->name}}' placeholder='Name'></x-form-text>
                            <x-form-text name='username' label='Username' value='{{auth()->user()->username}}' placeholder='User Name'></x-form-text>
                            <x-form-text name='email' label='E-Mail' value='{{auth()->user()->email}}' placeholder='E-Mail'></x-form-text>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
