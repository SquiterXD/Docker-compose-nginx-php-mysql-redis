@extends('layouts.app')

@section('title', 'INV Fuel Gas')
    
@section('page-title')
    <h2>ข้อมูลทะเบียนรถยนต์โรงงานยาสูบที่ขอสิทธิ์เติมน้ำมัน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Fuel</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ข้อมูลทะเบียนรถยนต์โรงงานยาสูบที่ขอสิทธิ์เติมน้ำมัน</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form action="" method="post">
                        @csrf
                        <disbursement-fuel-add-component></disbursement-fuel-add-component> 
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
