@extends('layouts.app')
@section('title', 'PMS0028')
@section('page-title')
  <h2>PMS0028: ความสัมพันธ์ของชุดเครื่องจักร</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>PM</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('pm.settings.machine-relation.index') }}">ความสัมพันธ์ของชุดเครื่องจักร</a>
    </li>
  </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>ความสัมพันธ์ของชุดเครื่องจักร</h5>
                </div>
                <div class="ibox-content">
                    {{-- {!! Form::open(['route' => ['pm.settings.machine-relation.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!} --}}
                    
                    <machine-relation-form 
                        :machine-groups="{{ json_encode($machineGroups) }}"
                        :old="{{ json_encode(Session::getOldInput()) }}"
                        :organization-code="{{ json_encode($organizationCode) }}"
                        :org="{{ json_encode($org) }}"
                        :url-save="{{ json_encode(route('pm.settings.machine-relation.store')) }}"
                        :url-reset="{{ json_encode(route('pm.settings.machine-relation.index')) }}"> 
                    </machine-relation-form>
   
                    {{-- <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                <a href="{{ route('pm.settings.machine-relation.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
