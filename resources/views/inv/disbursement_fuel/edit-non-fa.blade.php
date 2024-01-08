@extends('layouts.app')

@section('title', 'DisbursementFuel || Create')

@section('page-title')
<h2>ข้อมูลทะเบียนรถยนต์โรงงานยาสูบที่ขอสิทธิ์เติมน้ำมัน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Fuel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('inv.disbursement_fuel.show') }}">ข้อมูลทะเบียนรถยนต์โรงงานยาสูบที่ขอสิทธิ์เติมน้ำมัน</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>แก้ไข</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <disbursement-fuel-add-non-fa-component
                        :car-info="{{json_encode($carInfo)}}" >
                    </disbursement-fuel-add-non-fa-component>
                </div>
            </div>
        </div>
    </div>
@endsection
