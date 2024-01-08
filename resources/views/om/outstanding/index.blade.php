@extends('layouts.app')

@section('title', 'หนี้ค้างชำระ สำหรับขายในประเทศ')

@section('page-title')
  <h2>OMP0006: หนี้ค้างชำระ สำหรับขายในประเทศ</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>OM</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="{{ route('om.outstanding.index') }}">หนี้ค้างชำระ สำหรับขายในประเทศ</a>
    </li>
  </ol>
@stop

{{-- @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดเงื่อนไขการชำระเงินสำหรับขายในประเทศ</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.terms-domestic._table')
                </div>
            </div>
        </div>
    </div>
@endsection --}}

{{-- @section('content')
    <outstanding-search 
        :customers="{{ json_encode($customers) }}"
        inline-template>
        <div>
            @include('om.outstanding._search')
        </div>
    </outstanding-search>
@endsection --}}


@section('content')
<form action="" method="GET" autocomplete="off">
    <outstanding-search 
        :customers="{{ json_encode($customers) }}"
        :customer="{{ json_encode($customer) }}"
        {{-- :customer-search ="{{ json_encode($customerSearch) }}" --}}
        {{-- :date-search="{{ json_encode($dateSearch) }}" --}}
        :customer-types="{{ json_encode($customerTypes) }}"
        :days="{{ json_encode($days) }}"
        :data-search="{{ json_encode($dataSearch) }}"
        :credit-groups="{{ json_encode($creditGroups) }}"
        inline-template>
        <div>
          @include('om.outstanding._s')
        </div>
    </outstanding-search>
</form>
@if ($dataLists)
  <div class="ibox float-e-margins mb-2 mt-3">
    <div class="ibox-content tw-border-b">
      <div class="col-lg-12">
        <div class="m-t-lg">
          @include('om.outstanding._t')
        </div>
      </div>
    </div>
  </div>
@endif

@endsection


