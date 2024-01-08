@extends('layouts.app')

@section('title', 'อนุมัติใบเคลมในประเทศ')

@section('page-title')
  <x-get-page-title menu="" url="/om/approval-claim" />
@stop

{{-- @section('page-title-action')
    <a href="{{ route('ir.settings.product-groups.create') }}" class="btn btn-success">
        <i class="fa fa-plus"></i> สร้าง
    </a>
@stop --}}

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h3>อนุมัติใบเคลมในประเทศ</h3>
            </div>
            <div>
                <div class="ibox-content">
                    <div class="row space-50 justify-content-md-center flex-column mt-md-6">
                        <approval-claim-index   :claim-status-list = "{{ json_encode($claimStatusList)}}"
                                                :headers-list = "{{ json_encode($headersList) }}"
                                                :customer-list = "{{ json_encode($customerList) }}"
                                                :btn-trans = "{{ json_encode($btnTrans) }}">
                        </approval-claim-index>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection