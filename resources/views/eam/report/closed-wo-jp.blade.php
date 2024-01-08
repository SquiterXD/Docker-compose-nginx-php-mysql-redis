@extends('layouts.app')

@section('title', 'Main page')

{{-- @section('page-title')
  <h2><x-get-program-code url="/eam/report/closed-wo-jp" />: CT ใบปิดงานผลิตชิ้นส่วนอะไหล่อุปกรณ์</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT ใบปิดงานผลิตชิ้นส่วนอะไหล่อุปกรณ์</strong>
    </li>
  </ol>
    
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/eam/report/closed-wo-jp" />
@stop

@section('content')
@php $checkAttrId = 'closedWoJp' @endphp
<div id="eam0029" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="closedWoJpBtn" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
    setDatePicker({idDate: 'closedWoJpScheduledStartDateStart', nameDate: 'p_scheduled_start_date', onchange: false, date: '', disabled: false, required: false, dateEndId: `closedWoJpScheduledStartDateEnd`});
    setDatePicker({idDate: 'closedWoJpScheduledStartDateEnd', nameDate: 'p_scheduled_start_date_to', onchange: false, date: '', disabled: false, required: false});
    setDatePicker({idDate: 'closedWoJpActualStartDateStart', nameDate: 'p_actual_start_date', onchange: false, date: '', disabled: false, required: false, dateEndId: `closedWoJpActualStartDateEnd`});
    setDatePicker({idDate: 'closedWoJpActualStartDateEnd', nameDate: 'p_actual_start_date_to', onchange: false, date: '', disabled: false, required: false});
    setDatePicker({idDate: 'closedWoJpScheduledEndDateStart', nameDate: 'p_scheduled_completion_date', onchange: false, date: '', disabled: false, required: false, dateEndId: `closedWoJpScheduledEndDateEnd`});
    setDatePicker({idDate: 'closedWoJpScheduledEndDateEnd', nameDate: 'p_scheduled_completion_date_to', onchange: false, date: '', disabled: false, required: false});
    setDatePicker({idDate: 'closedWoJpActualEndDateStart', nameDate: 'p_actual_end_date', onchange: false, date: '', disabled: false, required: false, dateEndId: `closedWoJpActualEndDateEnd`});
    setDatePicker({idDate: 'closedWoJpActualEndDateEnd', nameDate: 'p_actual_end_date_to', onchange: false, date: '', disabled: false, required: false});
    $("#closedWoJpBtn").click(() => {
      $('#closedWoJpBtnAction').attr('action', "{{ route('eam.ajax.work-order.report.close-wo-jp') }}")
      $("#closedWoJpBtnHide").click();
    })
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection
