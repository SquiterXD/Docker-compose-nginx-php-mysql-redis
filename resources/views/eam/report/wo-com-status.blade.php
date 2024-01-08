@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <h2><x-get-program-code url="/eam/report/wo-com-status" />: CT รายงานสรุปสถานะใบสั่งซ่อมที่ส่งมอบเสร็จสิ้นแต่ยังไม่ปิดค่าใช้จ่าย</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT รายงานสรุปสถานะใบสั่งซ่อมที่ส่งมอบเสร็จสิ้นแต่ยังไม่ปิดค่าใช้จ่าย</strong>
    </li>
  </ol>
    
@stop

@section('content')
@php $checkAttrId = 'woComStatus' @endphp
<div id="eam0039" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="woComStatusBtn" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.lov-work-receipt-number');
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-department');
  @include('eam.commons.scripts.all-date');
  @include('eam.commons.scripts.lov-work-order-number');
  @include('eam.commons.scripts.drop-down-work-receipt-type');
  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    setDatePicker({idDate: 'woComStatusDateStart', nameDate: 'p_actual_end_date_st', onchange: false, date: '', disabled: false, required: false, dateEndId: `woComStatusDateEnd`});
    setDatePicker({idDate: 'woComStatusDateEnd', nameDate: 'p_actual_end_date_en', onchange: false, date: '', disabled: false, required: false});
    $("#woComStatusBtn").click(() => {
      $('#woComStatusBtnAction').attr('action', "{{ route('eam.ajax.report.wo-com-status') }}")
      $("#woComStatusBtnHide").click();
    })

    //clear woComStatusDepartment หน่วยงานที่ซ่อม
    $('#woComStatusDepartment').on('select2:clear', function (e) {
      $("#woComStatusDepartmentDesc").val('')
    });

    $('#woComStatusDepartment').on('select2:select', function (e) {
      // $("#woComStatusDepartmentDesc").val($(this).select2('data')[0].text.split(' - ')[1]).trigger('change');
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    //clear woComStatusOwningDepartment หน่วยงานเจ้าของ
    $('#woComStatusOwningDepartment').on('select2:clear', function (e) {
      $("#woComStatusOwningDepartmentDesc").val('')
    });

    $('#woComStatusOwningDepartment').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection