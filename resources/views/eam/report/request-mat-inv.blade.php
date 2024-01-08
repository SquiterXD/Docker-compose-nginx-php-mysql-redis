@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <h2><x-get-program-code url="/eam/report/request-mat-inv" />: CT ใบเบิกวัสดุ (Inventory)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT ใบเบิกวัสดุ (Inventory)</strong>
    </li>
  </ol>
    
@stop

@section('content')
@php $checkAttrId = 'RequestMatInv' @endphp
<div id="eam0021" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="modalReportRequestMatInvPrint" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.drop-down-subinventory');
  @include('eam.commons.scripts.drop-down-locator');
  @include('eam.commons.scripts.lov-work-order-number');
  @include('eam.commons.scripts.lov-work-receipt-number');
  @include('eam.commons.scripts.lov-item-code');
  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    $("#modalReportRequestMatInvSubinventory").change(() => {
      changSubinventory()
    })
    setDatePicker({idDate: 'modalReportRequestMatInvDateStart', nameDate: 'create_date_st', onchange: false, date: '', disabled: false, required: false, dateEndId: `modalReportRequestMatInvDateEnd`});
    setDatePicker({idDate: 'modalReportRequestMatInvDateEnd', nameDate: 'create_date_en', onchange: false, date: '', disabled: false, required: false});
    $("#modalReportRequestMatInvPrint").click(() => {
      $('#modalReportRequestMatInvPrintAction').attr('action', "{{ route('eam.ajax.report.request-mat-inv') }}")
      $("#modalReportRequestMatInvPrintHide").click();
    })

    $('#modalReportRequestMatInvItemCode').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });
    
  </script>

  <script script script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection
