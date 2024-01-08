@extends('layouts.app')

@section('title', 'Main page')

{{-- @section('page-title')
  <h2><x-get-program-code url="/eam/report/labor" />: CT ข้อมูลการบันทึกค่าแรง (Excel)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT ข้อมูลการบันทึกค่าแรง (Excel)</strong>
    </li>
  </ol>
    
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/eam/report/labor" />
@stop

@section('content')
@php $checkAttrId = 'labor' @endphp
<div id="eam0025" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="laborBtn" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.lov-asset-number');
  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    setDatePicker({idDate: 'laborDateStart', nameDate: 'p_date', onchange: false, date: '', disabled: false, required: false, dateEndId: `laborDateEnd`});
    setDatePicker({idDate: 'laborDateEnd', nameDate: 'p_date_to', onchange: false, date: '', disabled: false, required: false});
    $("#laborBtn").click(() => {
      $('#laborBtnAction').attr('action', "{{ route('eam.ajax.work-order.report.labor-excel') }}")
      $("#laborBtnHide").click();
    })
    $("#laborType").change(() => {
      $("#laborTypeHide").val($("#laborType option:selected").text());
    })
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection