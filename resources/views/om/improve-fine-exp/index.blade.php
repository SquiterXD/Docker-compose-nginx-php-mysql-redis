@extends('layouts.app')

@section('title', 'ปรับปรุงค่าปรับยาสูบ สำหรับขายต่างประเทศ')

@section('page-title')
  <h2>OMP0071: ปรับปรุงค่าปรับยาสูบ สำหรับขายต่างประเทศ</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>OM</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="{{ route('om.improve-fine-exp.index') }}">ปรับปรุงค่าปรับยาสูบ สำหรับขายต่างประเทศ</a>
    </li>
  </ol>
@stop
@section('content')
{{-- <form action="" method="GET" autocomplete="off">
    <improve-fine-exp-form 
      :customers="{{ json_encode($customers) }}"
      :customer="{{ json_encode($customer) }}"
      :invoices="{{ json_encode($invoices) }}"
      :order-numbers="{{ json_encode($orderNumbers) }}"
      :sa-numbers="{{ json_encode($saNumbers) }}"
      :pi-numbers="{{ json_encode($piNumbers) }}"
      :data-search="{{ json_encode($dataSearch) }}"
      inline-template>
        @include('om.improve-fine-exp._form')
    </improve-fine-exp-form>
</form> --}}
<div class="ibox float-e-margins mb-2">
  <div class="ibox-title">
    <div class="row">
        <div class="col-6">
            <h3 class="no-margins"> ปรับปรุงค่าปรับยาสูบ สำหรับขายต่างประเทศ </h3>
        </div>
    </div>
  </div>
  <div class="ibox-content tw-border-b">
    <search-improve-fine-exp
        :search_data="{{ json_encode($searchData) }}"
        :trans_btn="{{ json_encode(trans('btn')) }}"
    />
  </div>
</div>

{{-- {{dd($dataLists)}} --}}
@if (count($dataLists) > 0)
  <div class="ibox float-e-margins mb-2 mt-3">
    <div class="ibox-content tw-border-b">
      <div class="col-lg-12">
        <div class="m-t-lg">
          @include('om.improve-fine-exp._table')
        </div>
      </div>
    </div>
  </div>
@endif

@endsection