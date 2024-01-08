@extends('layouts.app')

@section('title', 'Main page')

{{-- @section('page-title')
  <h2><x-get-program-code url="/eam/report/summary-month-excel" />: CT รายงานสรุปใบรับงานประจำเดือน (EXPORT)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT รายงานสรุปใบรับงานประจำเดือน (EXPORT)</strong>
    </li>
  </ol>
    
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/eam/report/summary-month-excel" />
@stop

@section('content')
@php $checkAttrId = 'summaryMonth' @endphp
<div id="eam0031" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="modalReportSummaryMonthPrint" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.drop-down-job-receipt-status');
  @include('eam.commons.scripts.drop-down-work-receipt-type');
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
    setDatePicker({idDate: 'modalReportSummaryMonthDateStart', nameDate: 'scheduled_start_date_st', onchange: false, date: '', disabled: false, required: false, dateEndId: `modalReportSummaryMonthDateEnd`});
    setDatePicker({idDate: 'modalReportSummaryMonthDateEnd', nameDate: 'scheduled_start_date_en', onchange: false, date: '', disabled: false, required: false});
    $("#modalReportSummaryMonthPrint").click(() => {
      $('#modalReportSummaryMonthPrintAction').attr('action', "{{ route('eam.ajax.work-order.report.summary-month-excel') }}")
      $("#modalReportSummaryMonthPrintHide").click();
    })

    //clear modalReportSummaryMonthInformDept หน่วยงานแจ้งซ่อม
    $('#modalReportSummaryMonthInformDept').on('select2:clear', function (e) {
        $("#modalReportSummaryMonthInformDeptDesc").val('')
    });

    $('#modalReportSummaryMonthInformDept').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    //clear modalReportSummaryMonthOwningDepartment หน่วยงานรับงานซ่อม
    $('#modalReportSummaryMonthOwningDepartment').on('select2:clear', function (e) {
        $("#modalReportSummaryMonthOwningDepartmentDesc").val('')
    });

    $('#modalReportSummaryMonthOwningDepartment').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });
  </script>

  <script script script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection