@extends('layouts.app')

@section('title', 'Main page')

{{-- @section('page-title')
  <h2><x-get-program-code url="/eam/report/maintenance" />: CT ข้อมูลการซ่อมบำรุงเครื่องจักร (Excel)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT ข้อมูลการซ่อมบำรุงเครื่องจักร (Excel)</strong>
    </li>
  </ol>
    
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/eam/report/maintenance" />
@stop

@section('content')
@php $checkAttrId = 'maintenance' @endphp
<div id="eam0034" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="maintenanceBtn" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.lov-department');
  @include('eam.commons.scripts.lov-employee');

  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    setDatePicker({idDate: 'maintenanceStartDateStart', nameDate: 'p_date', onchange: false, date: '', disabled: false, required: false, dateEndId: `maintenanceStartDateStartTo`});
    setDatePicker({idDate: 'maintenanceStartDateStartTo', nameDate: 'p_date_to', onchange: false, date: '', disabled: false, required: false});
    $("#maintenanceBtn").click(() => {
      $('#maintenanceBtnAction').attr('action', "{{ route('eam.ajax.work-order.report.maintenance-excel') }}")
      $("#maintenanceBtnHide").click();
    })
    $("#maintenanceType").change(() => {
      $("#maintenanceTypeHide").val($("#maintenanceType option:selected").text());
    })

    //clear maintenanceDepartment หน่วยงานที่ซ่อม
    $('#maintenanceDepartment').on('select2:clear', function (e) {
      $("#maintenanceDepartmentDesc").val('')
    });

    $('#maintenanceDepartment').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    //clear maintenanceOwningDepartment หน่วยงานเจ้าของ
    $('#maintenanceOwningDepartment').on('select2:clear', function (e) {
      $("#maintenanceOwningDepartmentDesc").val('')
    });

    $('#maintenanceOwningDepartment').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    //clear maintenanceEmployee หน่วยงานเจ้าของ
    $('#maintenanceEmployee').on('select2:clear', function (e) {
      $("#maintenanceEmployeeDesc").val('')
    });

    // $('#maintenanceEmployee').on('select2:select', function (e) {
    //   $(this).select2('data')[0].text = $(this).select2('data')[0].id; 
    //   // $(this).trigger('change')
    // });
    
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection
