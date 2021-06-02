@extends('admin.layouts.app',['tilte'=>$title])
@section('content')
    <div class="flex-1 p-5 overflow-auto">
        <x-breadcrumb :title='$title' :breadcrumb='$breadcrumb'></x-breadcrumb>
        <x-form :forms='$forms' :action='$action' submit='Update Client'></x-form>
        <x-single-table :table='$table'></x-single-table>
    </div>
@endsection
