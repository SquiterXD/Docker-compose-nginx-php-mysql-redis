@extends('layouts.app')

@section('title', 'Main page')

{{-- @section('page-title')
  <h2><x-get-program-code url="/eam/report/payable" />: CT รายงานข้อมูลระบบเจ้าหนี้เข้าระบบบำรุงรักษาเครื่องจักร</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT รายงานข้อมูลระบบเจ้าหนี้เข้าระบบบำรุงรักษาเครื่องจักร</strong>
    </li>
  </ol>
    
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/eam/report/payable" />
@stop

@section('content')
@php $checkAttrId = 'payable' @endphp
<div id="eam0026" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="payablePrint" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.drop-down-work-receipt-type');
  @include('eam.commons.scripts.lov-work-receipt-number');
  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    setDatePicker({idDate: 'payableDateStart', nameDate: 'p_date', onchange: false, date: '', disabled: false, required: true, dateEndId: `payableDateEnd`});
    setDatePicker({idDate: 'payableDateEnd', nameDate: 'p_date_to', onchange: false, date: '', disabled: false, required: true});
    $("#payablePrint").click(() => {
      $('#payablePrintAction').attr('action', "{{ route('eam.ajax.work-order.report.payable') }}")
      $("#payablePrintHide").click();
    })
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection
