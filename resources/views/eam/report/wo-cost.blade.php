@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <h2><x-get-program-code url="/eam/report/wo-cost" />: CT รายงานสรุปค่าใช้จ่ายของใบสั่งซ่อม</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT รายงานสรุปค่าใช้จ่ายของใบสั่งซ่อม</strong>
    </li>
  </ol>
    
@stop

@section('content')
@php $checkAttrId = 'woCost' @endphp
<div id="eam0038" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="woCostBtn" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.drop-down-period');
  @include('eam.commons.scripts.lov-work-receipt-number');
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-department');
  @include('eam.commons.scripts.lov-work-order-number');
  @include('eam.commons.scripts.lov-class');
  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    $("#woCostBtn").click(() => {
      $('#woCostBtnAction').attr('action', "{{ route('eam.ajax.work-order.report.wo-cost') }}")
      $("#woCostBtnHide").click();
    })

    //clear woCostDepartment หน่วยงานที่ซ่อม
    $('#woCostDepartment').on('select2:clear', function (e) {
      $("#woCostDepartmentDesc").val('')
    });

    $('#woCostDepartment').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    //clear woCostOwningDepartment หน่วยงานเจ้าของ
    $('#woCostOwningDepartment').on('select2:clear', function (e) {
      $("#woCostOwningDepartmentDesc").val('')
    });

    $('#woCostOwningDepartment').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection