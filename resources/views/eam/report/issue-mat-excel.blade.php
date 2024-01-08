@extends('layouts.app')

@section('title', 'Main page')

{{-- @section('page-title')
  <h2><x-get-program-code url="/eam/report/issue-mat-excel" />: CT ข้อมูลการตัดจ่ายอะไหล่จากคลัง (Excel)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT ข้อมูลการตัดจ่ายอะไหล่จากคลัง (Excel)</strong>
    </li>
  </ol>
    
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/eam/report/issue-mat-excel" />
@stop

@section('content')
@php $checkAttrId = 'issueMatExcel' @endphp
<div id="eam0023" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="reportIssueMatExcel" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-work-receipt-number');
  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    setDatePicker({idDate: 'reportIssueMatExcelDateStart', nameDate: 'transaction_date_st', onchange: false, date: '', disabled: false, required: false, dateEndId: `reportIssueMatExcelDateEnd`});
    setDatePicker({idDate: 'reportIssueMatExcelDateEnd', nameDate: 'transaction_date_en', onchange: false, date: '', disabled: false, required: false});
    $("#reportIssueMatExcel").click(() => {
      $('#reportIssueMatExcelAction').attr('action', "{{ route('eam.ajax.report.issue-mat-excel') }}")
      $("#reportIssueMatExcelHide").click();
    })
    $("#reportIssueMatExcelType").change(() => {
      $("#reportIssueMatExcelTypeHide").val($("#reportIssueMatExcelType option:selected").text());
    })
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection

