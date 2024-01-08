@extends('layouts.app')

@section('title', 'กำหนดคลังตัดจ่ายวัตถุดิบ/รับผลผลิต')

{{-- @section('page-title')
    <h2><x-get-program-code url="/pm/settings/org-tranfer" /> : บันทึกคลังสินค้าในการรับ-ส่งข้อมูล : สร้าง</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">PM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">Settings</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('pm.settings.org-tranfer.index') }}">บันทึกคลังสินค้าในการรับ-ส่งข้อมูล</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><a href="{{ route('pm.settings.org-tranfer.create') }}">สร้าง</a></strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/pm/settings/org-tranfer" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>สร้าง : บันทึกคลังสินค้าในการรับ-ส่งข้อมูล</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['pm.settings.org-tranfer.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        {{-- <org-tranfer-create     :deprtments = "{{ json_encode($deprtments) }}"
                                                :tobacco-itemcats = "{{ json_encode($tobaccoItemcats) }}"
                                                :transaction-types = "{{ json_encode($transactionTypes) }}"
                                                :parameters = "{{ json_encode($parameters) }}"
                                                :wip-transaction = "{{ json_encode($wipTransaction) }}"
                                                :organization-id = "{{ json_encode($organizationId) }}"
                                                :data-item-types = "{{ json_encode($dataItemTypes) }}"
                                                :org-m12 = "{{ json_encode($orgM12) }}">
                        </org-tranfer-create> --}}
                        <org-tranfer-create     :deprtments = "{{ json_encode($deprtments) }}"
                                                :tobacco-itemcats = "{{ json_encode($tobaccoItemcats) }}"
                                                :transaction-types = "{{ json_encode($transactionTypes) }}"
                                                :parameters = "{{ json_encode($parameters) }}"
                                                :wip-transaction = "{{ json_encode($wipTransaction) }}"
                                                :organization-id = "{{ json_encode($organizationId) }}"
                                                :data-item-types = "{{ json_encode($dataItemTypes) }}">
                        </org-tranfer-create>
                        <div class="col-12 mt-3">
                            <hr>
                            <div class="row clearfix m-t-lg text-right">
                                <div class="col-sm-12">
                                    <button class="btn btn-success" type="submit">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก 
                                    </button>
                                    <a href="{{ route('pm.settings.org-tranfer.index') }}" type="button" class="btn btn-danger"> 
                                        <i class="fa fa-times" aria-hidden="true"></i> ยกเลิก </a>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
