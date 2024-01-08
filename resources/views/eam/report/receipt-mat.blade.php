@extends('layouts.app')

@section('title', 'Main page')

{{-- @section('page-title')
  <h2><x-get-program-code url="/eam/report/receipt-mat" />: CT รายงานส่งข้อมูลอะไหล่เข้าระบบสินค้าคงคลัง</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT รายงานส่งข้อมูลอะไหล่เข้าระบบสินค้าคงคลัง</strong>
    </li>
  </ol>
    
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/eam/report/receipt-mat" />
@stop

@section('content')
@php $checkAttrId = 'receiptMat' @endphp
<div id="eam0032" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="receiptMatBtn" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
            พิมพ์
          </button>
        </div>
      </div>
    </div>
  </div>
  @include('eam.report._modalLov')
</div>
@endsection
@section('scripts')
  @include('eam.commons.scripts.clear-input');
  @include('eam.commons.scripts.all-date');
  @include('eam.commons.scripts.drop-down-period');
  @include('eam.commons.scripts.lov-work-receipt-number');
  @include('eam.commons.scripts.lov-department');
  {{-- @include('eam.commons.scripts.lov-employee'); --}}
  @include('eam.commons.scripts.lov-employee-web-user');
  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    setDatePicker({idDate: 'receiptMatDateStart', nameDate: 'p_date', onchange: false, date: '', disabled: false, required: false, dateEndId: `receiptMatDateEnd`});
    setDatePicker({idDate: 'receiptMatDateEnd', nameDate: 'p_date_to', onchange: false, date: '', disabled: false, required: false});
    $("#receiptMatBtn").click(() => {
      $('#receiptMatBtnAction').attr('action', "{{ route('eam.ajax.work-order.report.receipt-mat') }}")
      $("#receiptMatBtnHide").click();
    })
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection