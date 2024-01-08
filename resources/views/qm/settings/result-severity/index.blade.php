@extends('layouts.app')
@section('title', 'QMS0020')
@section('page-title')
  <h2>QMS0020: กำหนดวิธีการป้องกันและกำจัดมอดยาสูบ</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>QM</a>
    </li>
    <li class="breadcrumb-item">
        <a>Setting</a>
      </li>
    <li class="breadcrumb-item active">
      <a href="{{ route('qm.settings.result-severity.index') }}">กำหนดวิธีการป้องกันและกำจัดมอดยาสูบ</a>
    </li>
  </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5> กำหนดวิธีการป้องกันและกำจัดมอดยาสูบ </h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['qm.settings.result-severity.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}                      
                    
                    <div class="row">
                        <div class="col-md-12">
                            <result-severity-form :lookups="{{json_encode($lookups)}}">

                            </result-severity-form>
                            {{-- @include('qm.settings.result-severity._form') --}}
                        </div>
                    </div>
                    

                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                <a href="{{ route('qm.settings.result-severity.index') }}" type="button" class="btn btn-sm btn-warning"><i class="fa fa-times"></i> ยกเลิก </a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection