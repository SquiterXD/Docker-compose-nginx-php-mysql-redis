@extends('layouts.app')

@section('title', 'Calculate Insurance')

@section('page-title')
    <h2><x-get-program-code url='/ir/calculate-insurance'/> : คำนวณค่าเบี้ยประกันที่แท้จริง</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>IR</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url='/ir/calculate-insurance'/>คำนวณค่าเบี้ยประกันที่แท้จริง</strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>คำนวณค่าเบี้ยประกันที่แท้จริง</h5>
                </div>
                <div class="ibox-content">
                    @include('ir.calculate-insurance._table')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
  @include('ir.scripts.datepicker.locales.bootstrap-datepicker-th')
  @include('ir.scripts.datepicker.bootstrap-datepicker-thai')
@stop
