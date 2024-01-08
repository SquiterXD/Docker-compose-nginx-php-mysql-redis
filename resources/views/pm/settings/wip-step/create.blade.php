@extends('layouts.app')
@section('title', 'PMS0004')
@section('page-title')
  <h2>PMS0004: ขั้นตอนการทำงาน</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>PM</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('pm.settings.wip-step.index') }}">ขั้นตอนการทำงาน</a>
    </li>
  </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>ขั้นตอนการทำงาน</h5>
                </div>
                <div class="ibox-content">
                    {{-- {!! Form::open(['route' => ['pm.settings.wip-step.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!} --}}
                    
                    <wip-form 
                        :organizations="{{ json_encode($organizations) }}"
                        :org="{{ json_encode($org) }}"
                        :uoms="{{ json_encode($uoms) }}"
                        :open-class="{{ json_encode($openClass) }}"
                        :old="{{ json_encode(Session::getOldInput()) }}"
                        :url-save="{{ json_encode(route('pm.settings.wip-step.store')) }}"
                        :url-reset="{{ json_encode(route('pm.settings.wip-step.index')) }}"> 
                    </wip-form>
   
                    {{-- <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                <a href="{{ route('pm.settings.wip-step.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                            </div>
                        </div>
                    </div> --}}
                    {{-- {!! Form::close() !!} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
