@extends('layouts.app')

@section('title', 'RequisitionStationery || Report')
    
@section('page-title')
    <h2>รายงาน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Stationery</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Report</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-content">
            <hr>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-right">
                    ชื่อรายงาน
                </label>
                <div class="col-md-8">
                    <el-input
                        value="รายงานประวัติสั่งซื้อย้อนหลัง" 
                        readonly>
                    </el-input>
                </div>
            </div>
            <hr>

            <form action="{{ route('inv.requisition_stationery.order-history-pdf') }}">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-right">
                        จากวันที่
                    </label>
                    <div class="col-md-4">
                        <date-picker-component 
                            name="start_date"
                        ></date-picker-component>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-right">
                        ถึงวันที่
                    </label>
                    <div class="col-md-4">
                        <date-picker-component
                            name="end_date"
                        ></date-picker-component>
                    </div>
                </div>
                

                <div class="row form-group">
                    <label class="col-md-2 col-form-label"></label>
                    <div class="col-10 offset-col-2">
                        <button class="btn btn-primary">ตกลง</button>
                        <a href="/inv/requisition_stationery/order-history-report" class="btn btn-link">ล้างข้อมูล</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
