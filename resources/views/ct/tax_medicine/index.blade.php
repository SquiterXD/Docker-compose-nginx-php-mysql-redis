@extends('layouts.app')

@section('title', 'กำหนดรหัสภาษีใบยา')

@section('page-title')
    <h2>กำหนดรหัสภาษีใบยา</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>กำหนดรหัสภาษีใบยา</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('ct.tax_medicine.create') }}" class="btn btn-primary">
        สร้างรายการ
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                  <tax-medicine-list-component></tax-medicine-list-component>
                </div>
            </div>
        </div>
    </div>
@endsection
