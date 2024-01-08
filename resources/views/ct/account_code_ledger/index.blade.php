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
@section('page-title-action')
    <a href="{{ route('ct.account_code_ledger.create') }}" class="{{ trans('btn.create.class') }} btn-sm">
        <i class="{{ trans('btn.create.icon') }}"></i> {{ trans('btn.create.text') }}
    </a>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            {{-- <div class="ibox">
                <div class="ibox-content"> --}}
                    <account-code-ledger-index-component
                        :search_data="{{ json_encode($searchData) }}"
                        {{-- :search_url="{{ json_encode(route('ct.account_code_ledger.index')) }}" --}}
                        :headers="{{ json_encode($headers) }}"
                        :trans_btn="{{ json_encode(trans('btn')) }}"
                        :lines="{{ json_encode($lines) }}"
                        :accounts="{{ json_encode($accounts) }}"
                        :alls="{{ json_encode($alls) }}"
                    />
                    {{-- <account-code-ledger-index-component :headers="{{json_encode($headers)}}"></account-code-ledger-index-component> --}}
                    {{-- <account-code-ledger-create-component :segment="{{json_encode($segment_data)}}"></account-code-ledger-create-component> --}}
                {{-- </div>
            </div> --}}
        </div>
    </div>
@endsection
