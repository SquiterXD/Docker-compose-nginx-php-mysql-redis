@extends('layouts.app')

@section('title', 'ปรับปรุงค่าปรับยาสูบ สำหรับขายในประเทศ')

@section('page-title')
  <h2>OMP0023: ปรับปรุงค่าปรับยาสูบ สำหรับขายในประเทศ</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>OM</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="{{ route('om.improve-fine.index') }}">ปรับปรุงค่าปรับยาสูบ สำหรับขายในประเทศ</a>
    </li>
  </ol>
@stop
@section('content')
<form action="" method="GET" autocomplete="off">
    <improve-fine-form 
      :customers="{{ json_encode($customers) }}"
      :customer="{{ json_encode($customer) }}"
      :invoices="{{ json_encode($invoices) }}"
      :customer-search="{{ json_encode($customerSearch) }}"
      :due-date-search="{{ json_encode($dueDateSearch) }}"
      :invoice-no-search="{{ json_encode($invoiceNoSearch) }}"
      :fine-flag-search="{{ json_encode($fineFlag) }}"
      :total-fine-due-search="{{ json_encode($totalFineDue) }}"
      :invoice-date-search="{{ json_encode($invoiceDate) }}"
      inline-template>
        @include('om.improve-fine._form')
    </improve-fine-form>
</form>
@if (count($dataLists) > 0)
  <div class="ibox float-e-margins mb-2 mt-3">
    <div class="ibox-content tw-border-b">
      <div class="col-lg-12">
        <div class="m-t-lg">
          @include('om.improve-fine._table')
        </div>
      </div>
    </div>
  </div>
@endif

@endsection