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

@section('content')
    <div>
        <div class="ibox">
            <div class="ibox-content">
                {{-- <form action="{{ route('ir.settings.account-mapping.update', $accountMapping->account_id) }}" method="POST" class="disable-on-submit">
                    @csrf
                    @method('PUT') --}}
                    {{-- <edit-account-mapping :default-value="{{ json_encode($accountMapping) }}"></edit-account-mapping> --}}
                    <account-mapping-component
                        :default-value-set-name="{{ json_encode($defaultValueSetName) }}"
                        :default-value="{{ json_encode($accountMapping) }}"
                        :url-save="{{ json_encode(route('ir.settings.account-mapping.update', $accountMapping->account_id)) }}"
                        :url-reset="{{ json_encode(route('ir.settings.account-mapping.index')) }}"
                        inline-template>
                        <div v-loading="loading">
                            @include('ir.settings.account-mapping._form', ['actionUrl' => route('ir.settings.account-mapping.index')])
                        </div>
                    </account-mapping-component>
                    {{-- <div class="row clearfix m-t-lg text-right">
                        <div class="col-sm-12">
                            <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                            <a href="{{ route('ir.settings.account-mapping.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                        </div>
                    </div>
                </form> --}}
            </div>
        </div>
    </div>
@endsection
