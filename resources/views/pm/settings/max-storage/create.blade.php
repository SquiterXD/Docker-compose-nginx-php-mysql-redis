@extends('layouts.app')
@section('title', 'PMS0030')
@section('page-title')
  <h2>PMS0030: กำหนดพื้นที่วางของหน้าเครื่องจักร</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>PM</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('pm.settings.max-storage.index') }}">กำหนดพื้นที่วางของหน้าเครื่องจักร</a>
    </li>
  </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดพื้นที่วางของหน้าเครื่องจักร</h5>
                </div>
                <div class="ibox-content">
                    {{-- {!! Form::open(['route' => ['pm.settings.max-storage.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!} --}}
                    
                    <max-storage-form 
                        :item-groups="{{ json_encode($itemGroups) }}"
                        :old="{{ json_encode(Session::getOldInput()) }}"
                        :url-save="{{ json_encode(route('pm.settings.max-storage.store')) }}"
                        :url-reset="{{ json_encode(route('pm.settings.max-storage.index')) }}"> 
                    </max-storage-form>
   
                    {{-- <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                <a href="{{ route('pm.settings.max-storage.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                            </div>
                        </div>
                    </div> --}}
                    {{-- {!! Form::close() !!} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
