@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <h2><x-get-program-code url="/eam/report/closed-wo2" />: CT ใบปิดงานซ่อม (โรงพิมพ์)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT ใบปิดงานซ่อม (โรงพิมพ์)</strong>
    </li>
  </ol>
    
@stop

@section('content')
@php $checkAttrId = 'closedWo' @endphp
<div id="eam0028" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="closedWoBtn" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.drop-down-machine-group');
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-work-receipt-number');
  @include('eam.commons.scripts.lov-department');
  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    setDatePicker({idDate: 'closedWoScheduledStartDateStart', nameDate: 'scheduled_start_date_st', onchange: false, date: '', disabled: false, required: false, dateEndId: `closedWoScheduledStartDateEnd`});
    setDatePicker({idDate: 'closedWoScheduledStartDateEnd', nameDate: 'scheduled_start_date_en', onchange: false, date: '', disabled: false, required: false});
    setDatePicker({idDate: 'closedWoActualStartDateStart', nameDate: 'actual_start_date_st', onchange: false, date: '', disabled: false, required: false, dateEndId: `closedWoActualStartDateEnd`});
    setDatePicker({idDate: 'closedWoActualStartDateEnd', nameDate: 'actual_start_date_en', onchange: false, date: '', disabled: false, required: false});
    setDatePicker({idDate: 'closedWoScheduledEndDateStart', nameDate: 'scheduled_completion_date_st', onchange: false, date: '', disabled: false, required: false, dateEndId: `closedWoScheduledEndDateEnd`});
    setDatePicker({idDate: 'closedWoScheduledEndDateEnd', nameDate: 'scheduled_completion_date_en', onchange: false, date: '', disabled: false, required: false});
    setDatePicker({idDate: 'closedWoActualEndDateStart', nameDate: 'actual_end_date_st', onchange: false, date: '', disabled: false, required: false, dateEndId: `closedWoActualEndDateEnd`});
    setDatePicker({idDate: 'closedWoActualEndDateEnd', nameDate: 'actual_end_date_en', onchange: false, date: '', disabled: false, required: false});
    $("#closedWoBtn").click(() => {
      $('#closedWoBtnAction').attr('action', "{{ route('eam.ajax.report.closed-wo2') }}")
      $("#closedWoBtnHide").click();
    })
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection
