@extends('layouts.app')

@section('page-title')
    <h2>กำหนดงวดการสั่งซื้อ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.order-period.index') }}">กำหนดงวดการสั่งซื้อ</a>
        </li>
    </ol>
@stop

{{-- @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดงวดการสั่งซื้อ</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['om.settings.order-period.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                    
                    <order-period-form></order-period-form>
   
                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                <a href="{{ route('om.settings.order-period.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection --}}


@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="ibox">
                    {{-- <div class="ibox-title">
                        <h5>กำหนดงวดการสั่งซื้อ</h5>
                    </div> --}}
                    <div>
                        <h1 class="tw-mt-0"></h1>
                        <div class="ibox-content">
                            <h4>กำหนดงวดการสั่งซื้อ</h4>
                            <form action="" method="GET" autocomplete="off">
                                <order-period-form inline-template
                                    :url-return="{{ json_encode(route('om.settings.order-period.index')) }}">
                                    <div v-loading="loading">
                                        @include('om.settings.order-period._form', ['actionUrl' => route('om.settings.order-period.index')])
                                        <div v-if="periodLists.length">
                                            <div class="mt-3">
                                                <h4>งวดการสั่งซื้อ</h4>
                                            </div>
                                            <div class="ibox float-e-margins">
                                                <div class="ibox-content">
                                                    @include('om.settings.order-period._table_create', ['actionUrl' => route('om.settings.order-period.index')])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </order-period-form>
                            </form>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection