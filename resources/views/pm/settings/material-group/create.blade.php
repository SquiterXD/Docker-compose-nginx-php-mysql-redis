@extends('layouts.app')

@section('title', 'กลุ่มวัตถุดิบ')

@section('page-title')
    <h2>PMS0020 : กลุ่มวัตถุดิบ (Material Group)</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">PM</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('pm.settings.material-group.index') }}">กลุ่มวัตถุดิบ</a>
        </li>
        <li class="breadcrumb-item">
            <strong><a href="/">สร้าง</a></strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>สร้างรายการกลุ่มวัตถุดิบ</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['pm.settings.material-group.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}

                    <material-group :departments = "{{ json_encode($departments) }}" 
                                    :material-groups = "{{ json_encode($materialGroups) }}">
                    </material-group>

                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-primary" type="submit"> 
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i>  บันทึก 
                                </button>
                                <a type="button" href="{{ route('pm.settings.material-group.index') }}" class="btn btn-danger">
                                    <i class="fa fa-times" aria-hidden="true"></i> ยกเลิก 
                                </a>
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
