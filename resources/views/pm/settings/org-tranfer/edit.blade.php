@extends('layouts.app')

@section('title', 'กำหนดคลังตัดจ่ายวัตถุดิบ/รับผลผลิต')

{{-- @section('page-title')
    <h2>
        <x-get-program-code url="/pm/settings/org-tranfer" /> : บันทึกคลังสินค้าในการรับ-ส่งข้อมูล
    </h2>
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
            <strong><a href="{{ route('pm.settings.org-tranfer.edit', $dataSetup->id) }}">แก้ไข</a></strong>
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
                    <h5>แก้ไข : บันทึกคลังสินค้าในการรับ-ส่งข้อมูล</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['pm.settings.org-tranfer.update'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                    {{-- <org-tranfer-edit   :data-setup = "{{ json_encode($dataSetup) }}"
                                        :wip-transaction = "{{ json_encode($wipTransaction) }}"
                                        :tobacco-itemcats = "{{ json_encode($tobaccoItemcats) }}"
                                        :transaction-types = "{{ json_encode($transactionTypes) }}"
                                        :parameters = "{{ json_encode($parameters) }}"
                                        :organization-id = "{{ json_encode($organizationId) }}"
                                        :data-item-types = "{{ json_encode($dataItemTypes) }}"
                                        :org-m12 = "{{ json_encode($orgM12) }}">

                    </org-tranfer-edit> --}}
                    <org-tranfer-edit   :data-setup = "{{ json_encode($dataSetup) }}"
                                        :wip-transaction = "{{ json_encode($wipTransaction) }}"
                                        :tobacco-itemcats = "{{ json_encode($tobaccoItemcats) }}"
                                        :transaction-types = "{{ json_encode($transactionTypes) }}"
                                        :parameters = "{{ json_encode($parameters) }}"
                                        :organization-id = "{{ json_encode($organizationId) }}"
                                        :data-item-types = "{{ json_encode($dataItemTypes) }}">

                    </org-tranfer-edit>
                    <div class="row clearfix text-right">
                        <div class="col" style="margin-top: 15px;">
                            <button class="btn btn-success" type="submit"> 
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก 
                            </button>
                            <a type="button" class="btn btn-danger" href="{{ route('pm.settings.org-tranfer.index') }}">
                                <i class="fa fa-times" aria-hidden="true" ></i> ยกเลิก
                            </a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
