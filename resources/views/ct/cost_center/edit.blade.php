@extends('layouts.app')

@section('title', 'แก้ไขกำหนดศูนย์ต้นทุน')

@section('page-title')
    <h2>กำหนดศูนย์ต้นทุน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item">
            กำหนดศูนย์ต้นทุน
        </li>
        <li class="breadcrumb-item active">
          <strong>แก้ไข</strong>
      </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                  <cost-center-new-create-component 
                    :is-edit="{{json_encode($is_edit)}}"
                    :cost-center="{{json_encode($cost_center)}}">
                  </cost-center-new-create-component>
                  {{-- <cost-center-create-component 
                  :is-edit="{{json_encode($is_edit)}}" 
                  :cost-center="{{json_encode($cost_center)}}"
                  :cost-center-org="{{json_encode($cost_center_org)}}"
                  :product-group="{{json_encode($product_group)}}"
                  >
                </cost-center-create-component> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
