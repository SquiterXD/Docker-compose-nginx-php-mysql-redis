@extends('layouts.app')

@section('title', 'IRM0006')

@section('page-title')
    <h2>IRM0006: ข้อมูลรหัสบัญชี (Account Mapping)</h2>
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
            <a href="{{ route('ir.settings.account-mapping.index') }}">IRM0006: ข้อมูลรหัสบัญชี (Account Mapping)</a>
        </li>
    </ol>
@stop

@section('page-title-action')
    {{-- <a href="{{ route('ir.settings.account-mapping.create') }}" class="btn btn-success">
        <i class="fa fa-plus"></i> สร้าง
    </a> --}}

    <a href="{{ route('ir.settings.account-mapping.create') }}" class="{{ trans('btn.create.class') }}">
        <i class="{{ trans('btn.create.icon') }}"></i> {{ trans('btn.create.text') }}
    </a>
@stop

@section('content')
{{-- <inquiry-component
        :default-value-set-name="{{ json_encode($defaultValueSetName) }}"
        inline-template>
        <div v-loading="loading">
            @include('ir.settings.account-mapping.test-account._search', ['actionUrl' => route('ir.settings.account-mapping.index')])
        </div>
</inquiry-component> --}}
    {{-- <a class="btn btn-secondary btn-sm mb-2 text-right" href="#" data-toggle="modal" data-target="#modal-flexfield"
        title="Edit"><i class="far fa-edit"></i>
    </a>
    @include('ir.settings.account-mapping._account') --}}
    <div>
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                       <form action="" method="GET" autocomplete="off">
                            <search-account :accounts="{{ json_encode($accounts) }}"
                                            :action-url="{{ json_encode(route('ir.settings.account-mapping.index')) }}">
                            </search-account>
                        </form>                    
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="m-t-lg">
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                        {{-- <table-account-mapping  :account-alls="{{ json_encode($paginations) }}" inline-template>
                            @include('ir.settings.account-mapping._t')
                        </table-account-mapping> --}}
                        @include('ir.settings.account-mapping._table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

