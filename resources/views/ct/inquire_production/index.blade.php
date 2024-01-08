@extends('layouts.app')

@section('title', 'สอบถามการบันทึกผลผลิต')

@section('page-title')
    <x-get-page-title menu="" url="/ct/inquire_production" />
    {{-- <h2>CTP0003 : สอบถามการบันทึกผลผลิต </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong> สอบถามการบันทึกผลผลิต </strong>
        </li>
    </ol> --}}
@stop
@section('content')
    <inquire-production-index-component
        :trans_btn="{{ json_encode(trans('btn')) }}"
        :periods="{{ json_encode($periods) }}"
        :costs="{{ json_encode($costs) }}"
    />
@endsection
