@extends('layouts.app')

@section('title', 'OMS0013')

@section('page-title')
  <h2>OMS0013: Price List (สำหรับขายต่างประเทศ)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>OM</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="{{ route('om.settings.price-list-export.index') }}">กำหนด Price List</a>
    </li>
  </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดรายการราคาสินค้า</h5>
                </div>
                <div class="ibox-content">
                    {{-- {!! Form::open(['route' => ['om.settings.price-list-export.update', $header->list_header_id] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                    @method('PUT') --}}
                    <price-list-export-form 
                            :default-value="{{ json_encode($header)}}"
                            :currencies="{{json_encode($currencies)}}"
                            :items="{{json_encode($items)}}"
                            :uoms="{{json_encode($uoms)}}"
                            :old="{{ json_encode(Session::getOldInput()) }}"
                            :url-save="{{ json_encode(route('om.settings.price-list-export.update', $header->list_header_id)) }}"
                            :url-reset="{{ json_encode(route('om.settings.price-list-export.index')) }}"
                            :btn-trans="{{ json_encode(trans('btn')) }}"
                            :item-alls="{{json_encode($itemAlls)}}">
                    </price-list-export-form>
   
                    {{-- <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                <a href="{{ route('om.settings.price-list-export.index') }}" type="button" class="btn btn-sm btn-warning"> ยกเลิก </a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!} --}}
                </div>
            </div>
        </div>
    </div>
@endsection