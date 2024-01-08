@extends('layouts.app')

@section('title', 'OMS0017')

@section('page-title')
    <h2>OMS0017: กำหนด Account Aliases</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>OM</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('om.settings.account-mapping.index') }}">OMS0017: กำหนด Account Aliases</a>
        </li>
    </ol>
@stop

@section('content')
    <div>
        <div class="ibox">
            <div class="ibox-content">
                <form action="{{ route('om.settings.account-mapping.update', $accountMapping->account_id) }}" method="POST" class="disable-on-submit">
                    @csrf
                    @method('PUT')
                    <account-mapping-form
                        :default-value="{{ json_encode($accountMapping)}}"
                        :companies="{{ json_encode($companies) }}"
                        :evms="{{ json_encode($evms) }}"
                        :departments="{{ json_encode($departments) }}"
                        :budget-years="{{ json_encode($budgetYears) }}"
                        :budget-types="{{ json_encode($budgetTypes) }}"
                        :budget-reasons="{{ json_encode($budgetReasons) }}"
                        :main-accounts="{{ json_encode($mainAccounts) }}"
                        :reserveds1="{{ json_encode($reserveds1) }}"
                        :reserveds2="{{ json_encode($reserveds2) }}"
                        :value-set-name="{{ json_encode(getPrefixValueSetName()) }}">

                    </account-mapping-form>

                    {{-- <edit-account-mapping :default-value="{{ json_encode($accountMapping) }}"></edit-account-mapping> --}}
                    <div class="row clearfix m-t-lg text-right">
                        <div class="col-sm-12">
                            {{-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                            <a href="{{ route('om.settings.account-mapping.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a> --}}

                            <button class="btn btn-sm {{ trans('btn')['save']['class'] }}" type="submit"> 
                                <i class="{{ trans('btn')['save']['icon'] }}"></i> 
                                {{ trans('btn')['save']['text'] }} 
                            </button>
                            <a href="{{ route('om.settings.account-mapping.index') }}" type="button" class="btn btn-sm {{ trans('btn')['cancel']['class'] }}"> 
                                <i class="{{ trans('btn')['cancel']['icon'] }}"></i> 
                                {{ trans('btn')['cancel']['text'] }} 
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
