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
                <account-mapping-component
                    :default-value-set-name="{{ json_encode($defaultValueSetName) }}"
                    :url-save="{{ json_encode(route('ir.settings.account-mapping.store')) }}"
                    :url-reset="{{ json_encode(route('ir.settings.account-mapping.index')) }}"
                    inline-template>
                    <div v-loading="loading">
                        @include('ir.settings.account-mapping._form', ['actionUrl' => route('ir.settings.account-mapping.index')])
                    </div>
                </account-mapping-component>

                {{-- <el-validate :btn-trans="{{ json_encode($btnTrans) }}"
                            :url-save="{{ json_encode(route('ir.settings.account-mapping.store')) }}">
                </el-validate> --}}
            </div>
        </div>
    </div>
@endsection
