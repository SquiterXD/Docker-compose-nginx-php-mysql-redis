@extends('layouts.app')

@section('title', 'กำหนดรหัสบัญชีเพื่อการเชื่อมโยงไประบบบัญชีแยกประเภททั่วไป')

@section('page-title')
    <h2>กำหนดรหัสบัญชีเพื่อการเชื่อมโยงไประบบบัญชีแยกประเภททั่วไป</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>กำหนดรหัสบัญชีเพื่อการเชื่อมโยงไประบบบัญชีแยกประเภททั่วไป</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <account-code-ledger-form-component 
                        :segment="{{json_encode($segment_data)}}"
                        :detail="{{json_encode($detail)}}"
                        :header="{{json_encode($header)}}"
                        :organizations="{{json_encode($organizations)}}"
                        :trans_btn="{{ json_encode(trans('btn')) }}">
                    </account-code-ledger-form-component>
                    {{-- <account-code-ledger-create-component :segment="{{json_encode($segment_data)}}"></account-code-ledger-create-component> --}}
                </div>
            </div>
        </div>
    </div>
@endsection