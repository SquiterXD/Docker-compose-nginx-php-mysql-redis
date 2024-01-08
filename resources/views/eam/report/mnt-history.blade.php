@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <h2><x-get-program-code url="/eam/report/mnt-history" />: CT รายงานประวัติการซ่อมบำรุงเครื่องจักร (NEW)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT รายงานประวัติการซ่อมบำรุงเครื่องจักร (NEW)</strong>
    </li>
  </ol>
    
@stop

@section('content')
@php $checkAttrId = 'mntHistory' @endphp
<div id="eam0033" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="mntHistoryBtn" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.drop-down-activities-to-do');
  @include('eam.commons.scripts.drop-down-job-receipt-status');
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-work-receipt-number');
  @include('eam.commons.scripts.lov-department');
  {{-- @include('eam.commons.scripts.lov-employee'); --}}
  @include('eam.commons.scripts.lov-work-order-number');
  @include('eam.commons.scripts.lov-employee-web-user');

  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    setDatePicker({idDate: 'mntHistoryStartDateStart', nameDate: 'p_transaction_date', onchange: false, date: '', disabled: false, required: false, dateEndId: `mntHistoryStartDateStartTo`});
    setDatePicker({idDate: 'mntHistoryStartDateStartTo', nameDate: 'p_transaction_date_to', onchange: false, date: '', disabled: false, required: false});
    $("#mntHistoryBtn").click(() => {
      $('#mntHistoryBtnAction').attr('action', "{{ route('eam.ajax.work-order.report.mnt-history') }}")
      $("#mntHistoryBtnHide").click();
    })
    $("#mntHistoryWorkReceiptStatus").change(() => {
      $("#mntHistoryWorkReceiptStatusHide").val($("#mntHistoryWorkReceiptStatus option:selected").text());
    })

    //clear mntHistoryDepartment หน่วยงานที่ซ่อม
    $('#mntHistoryDepartment').on('select2:clear', function (e) {
        $("#mntHistoryDepartmentDesc").val('')
    });

    $('#mntHistoryDepartment').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    //clear mntHistoryOwningDepartment หน่วยงานเจ้าของ
    $('#mntHistoryOwningDepartment').on('select2:clear', function (e) {
        $("#mntHistoryOwningDepartmentDesc").val('')
    });

    $('#mntHistoryOwningDepartment').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    //clear mntHistoryEmployee ผู้รับงาน
    $('#mntHistoryEmployee').on('select2:clear', function (e) {
        $("#mntHistoryEmployeeDesc").val('')
    });

    // $('#mntHistoryEmployee').on('select2:select', function (e) {
    //   $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    // });
  </script>

  <script script script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection

