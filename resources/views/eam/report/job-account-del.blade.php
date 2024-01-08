@extends('layouts.app')

@section('title', 'Main page')

{{-- @section('page-title')
  <h2><x-get-program-code url="/eam/report/job-account-del" />: CT รายงานบัญชีงานระหว่างประกอบ (แยกรายละเอียด) ประเภท JOB สั่งผลิต</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>รายงาน</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>CT รายงานบัญชีงานระหว่างประกอบ (แยกรายละเอียด) ประเภท JOB สั่งผลิต</strong>
    </li>
  </ol>
    
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/eam/report/job-account-del" />
@stop

@section('content')
@php $checkAttrId = 'jobAccountDel' @endphp
<div id="eam0036" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11 mt-5">
        @include('eam.report._form')
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="jobAccountDelBtn" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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
  @include('eam.commons.scripts.drop-down-period');
  @include('eam.commons.scripts.lov-work-receipt-number');
  <script>
    $("#formAll").removeClass('d-none');
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    setDatePicker({idDate: 'jobAccountDelDateStart', nameDate: 'transaction_date_st', onchange: false, date: '', disabled: false, required: false, dateEndId: `jobAccountDelDateEnd`});
    setDatePicker({idDate: 'jobAccountDelDateEnd', nameDate: 'transaction_date_en', onchange: false, date: '', disabled: false, required: false});
    $("#jobAccountDelBtn").click(() => {
      $('#jobAccountDelBtnAction').attr('action', "{{ route('eam.ajax.report.job-account-del') }}")
      $("#jobAccountDelBtnHide").click();
    })
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection