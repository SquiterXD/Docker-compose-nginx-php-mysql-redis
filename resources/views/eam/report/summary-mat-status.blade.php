@extends('layouts.app')

@section('title', 'Main page')

{{-- @section('page-title')
  <h2><x-get-program-code url="/eam/report/summary-mat-status" />: CT รายงานสรุปสถานะการของการจัดหาอะไหล่รวมทั้งการเบิกจ่ายอะไหล่เข้าใบสั่งซ่อม</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT รายงานสรุปสถานะการของการจัดหาอะไหล่รวมทั้งการเบิกจ่ายอะไหล่เข้าใบสั่งซ่อม</strong>
    </li>
  </ol>
    
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/eam/report/summary-mat-status" />
@stop

@section('content')
@php $checkAttrId = 'summaryMatStatus' @endphp
<div id="eam0041" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="summaryMatStatusBtn" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.drop-down-work-receipt-type');
  @include('eam.commons.scripts.lov-work-receipt-number');
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-department');
  @include('eam.commons.scripts.lov-work-order-number');
  @include('eam.commons.scripts.drop-down-organization');
  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    $("#summaryMatStatusBtn").click(() => {
      $('#summaryMatStatusBtnAction').attr('action', "{{ route('eam.ajax.report.summary-mat-status') }}")
      $("#summaryMatStatusBtnHide").click();
    })
    $("#summaryMatStatusType").change(() => {
      $("#summaryMatStatusTypeHide").val($("#summaryMatStatusType option:selected").text());
    })

    //clear summaryMatStatusDepartment หน่วยงานเจ้าของ
    $('#summaryMatStatusDepartment').on('select2:clear', function (e) {
      $("#summaryMatStatusDepartmentDesc").val('')
    });

    $('#summaryMatStatusDepartment').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });
  </script>
  
  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection