@extends('layouts.app')
@section('title', 'OMS0019')

@section('page-title')
    <h2>OMS0019: ข้อมูลลูกค้า Direct Debit Domestic</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.direct-debit-domestic.index') }}">ข้อมูลลูกค้า Direct Debit Domestic</a>
        </li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>ข้อมูลลูกค้า Direct Debit Domestic</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['om.settings.direct-debit-domestic.update', $directDebitDomestic->direct_debit_id] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                    @method('PUT')
                    <direct-debit-domestic-form 
                        :default-value="{{ json_encode($directDebitDomestic) }}"
                        :customer="{{ json_encode($customer) }}"
                        :customers="{{ json_encode($customers) }}"
                        :bank-account="{{ json_encode($bankAccount) }}"
                        :bank-accounts="{{ json_encode($bankAccounts) }}"
                        :bank-uniques="{{ json_encode($bankUniques) }}"
                        :bank-account-Types="{{ json_encode($bankAccountTypes) }}"
                        :banks="{{ json_encode($banks) }}"
                        :branchs="{{ json_encode($branchs) }}"
                        :old="{{ json_encode(Session::getOldInput()) }}"
                        >
                    </direct-debit-domestic-form>
   
                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                {{-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                <a href="{{ route('om.settings.direct-debit-domestic.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a> --}}

                                <button class="btn btn-sm {{ trans('btn')['save']['class'] }}" type="submit"> 
                                    <i class="{{ trans('btn')['save']['icon'] }}"></i> 
                                    {{ trans('btn')['save']['text'] }} 
                                </button>
                                <a href="{{ route('om.settings.direct-debit-domestic.index') }}" type="button" class="btn btn-sm {{ trans('btn')['cancel']['class'] }}"> 
                                    <i class="{{ trans('btn')['cancel']['icon'] }}"></i> 
                                    {{ trans('btn')['cancel']['text'] }} 
                                </a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
