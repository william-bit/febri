@extends('admin.layouts.app',['tilte'=>$title])
@section('content')
    <div class="flex-1 p-5 overflow-auto">
        <x-breadcrumb :title='$title' :breadcrumb='$breadcrumb'></x-breadcrumb>
        <x-table :table='$table'></x-table>
    </div>
@endsection
