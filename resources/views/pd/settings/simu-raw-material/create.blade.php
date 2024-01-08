@extends('layouts.app')
@section('title', 'PDS0006')
@section('page-title')
  <x-get-page-title menu="" url="/pd/settings/simu-raw-material" />
  {{-- <h2>PDS0006 : กำหนดวัตถุดิบจำลอง</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>PD</a>
    </li>
    <li class="breadcrumb-item">
        <a>Setting</a>
      </li>
    <li class="breadcrumb-item active">
      <a href="{{ route('pd.settings.simu-raw-material.index') }}"><strong>กำหนดวัตถุดิบจำลอง</strong></a>
    </li>
  </ol> --}}
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดวัตถุดิบจำลอง</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['pd.settings.simu-raw-material.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        
                    <simu-form  :simulation-types="{{ json_encode($simulationTypes) }}" 
                                :uoms="{{ json_encode($uoms) }}"
                                :old="{{ json_encode(Session::getOldInput()) }}"
                                >
                    </simu-form>

                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                <a href="{{ route('pd.settings.simu-raw-material.index') }}" type="button" class="btn btn-sm btn-warning"><i class="fa fa-times"></i> ยกเลิก </a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection