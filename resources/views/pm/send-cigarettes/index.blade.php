
@extends('layouts.app')

@section('title', 'แจ้งยอดประมาณการจัดเก็บบุหรี่')

@section('page-title')
    <h2><x-get-program-code url="/pm/send-cigarettes"/> แจ้งยอดประมาณการจัดเก็บบุหรี่</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">PM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">Settings</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><a href="{{ url('/pm/send-cigarettes') }}">แจ้งยอดประมาณการจัดเก็บบุหรี่</a></strong>
        </li>
    </ol>
@stop
@section('page-title-action')
    {{-- <button class="btn btn-primary btn-sm p-1" data-toggle="modal" data-target="#modal-create" data-backdrop="static" data-keyboard="false">
        <i class="fa fa-plus"></i> สร้าง
    </button> --}}
@stop

@section('content')
    <pm-send-cigarettes-index :p-url="{{ json_encode($url) }}"/>
@endsection
@section('scripts')

@stop