@extends('layouts.app')

@section('title', 'IRM0010')

@section('page-title')
    <h2>IRM0010: ข้อมูล Email สำหรับแจ้งเคลมประกัน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>IR</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('ir.settings.email.index') }}">IRM0010: ข้อมูล Email สำหรับแจ้งเคลมประกัน</a>
        </li>
    </ol>
@stop

@section('content')
    <div>
        <div class="ibox">
            <div class='ibox-title'>
                <h5>ข้อมูล Email สำหรับแจ้งเคลมประกันภัย</h5>
            </div>
            <div class="ibox-content">
                <form-email
                    :companies="{{ json_encode($companies) }}"
                    :departments="{{ json_encode($departments) }}"
                    :employees="{{ json_encode($employees) }}"
                    :url-save="{{ json_encode(route('ir.settings.email.store')) }}"
                    :url-reset="{{ json_encode(route('ir.settings.email.index')) }}"
                   >
                </form-email>
            </div>
        </div>
    </div>
@endsection
