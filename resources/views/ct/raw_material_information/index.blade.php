@extends('layouts.app')

@section('title', 'สอบถามข้อมูลการเบิกใช้วัตถุดิบ')

@section('page-title')
    <x-get-page-title menu="" url="/ct/raw_material_information" />
    {{-- <h2>CTP0002 : สอบถามข้อมูลการเบิกใช้วัตถุดิบ </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong> สอบถามข้อมูลการเบิกใช้วัตถุดิบ </strong>
        </li>
    </ol> --}}
@stop
@section('content')
    {{-- <div class="row">
        <div class="col-lg-12">         --}}
            <raw-material-information-index-component
                :trans_btn="{{ json_encode(trans('btn')) }}"
                :costs="{{ json_encode($costs) }}"
                :departments="{{ json_encode($departments) }}"
            />
        {{-- </div>
    </div> --}}
@endsection
