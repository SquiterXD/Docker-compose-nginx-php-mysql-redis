@extends('layouts.app')

@section('title', 'Main page')

{{-- @section('page-title')
  <h2><x-get-program-code url="/eam/report/summary-labor" />: CT รายงานสรุปการบันทึกค่าแรงงานซ่อม</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT รายงานสรุปการบันทึกค่าแรงงานซ่อม</strong>
    </li>
  </ol>
    
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/eam/report/summary-labor" />
@stop

@section('content')
@php $checkAttrId = 'summaryLabor' @endphp
<div id="eam0024" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="summaryLaborBtn" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.lov-department');
  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    setDatePicker({idDate: 'summaryLaborDateStart', nameDate: 'p_date', onchange: false, date: '', disabled: false, required: false, dateEndId: `summaryLaborDateEnd`});
    setDatePicker({idDate: 'summaryLaborDateEnd', nameDate: 'p_date_to', onchange: false, date: '', disabled: false, required: false});
    $("#summaryLaborBtn").click(() => {
      $('#summaryLaborBtnAction').attr('action', "{{ route('eam.ajax.work-order.report.summary-labor') }}")
      $("#summaryLaborBtnHide").click();
    })
    $("#summaryLaborType").change(() => {
      $("#summaryLaborTypeHide").val($("#summaryLaborType option:selected").text());
    })

    //clear summaryLaborDepartment หน่วยงานที่ซ่อม
    $('#summaryLaborDepartment').on('select2:clear', function (e) {
        $("#summaryLaborDepartmentDesc").val('')
    });

    $('#summaryLaborDepartment').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
      // $(this).trigger('change')
    });
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection