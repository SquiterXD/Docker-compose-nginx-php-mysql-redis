@extends('layouts.app')

@section('title', 'บันทึก Layout สิ่งพิมพ์')

@section('page-title')
    <h2>PMS0023: บันทึก Layout สิ่งพิมพ์</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>PM</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('pm.settings.save-publication-layout.index') }}">PMS0023: บันทึก Layout สิ่งพิมพ์</a>
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
                <div class="ibox-title">
                    <h5>แก้ไขบันทึก Layout สิ่งพิมพ์</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['pm.settings.save-publication-layout.update'], 
                                    "method" => "put", 
                                    "autocomplete" => "off", 
                                    'class' => 'form-horizontal']) !!}

                    <save-publication-layout-edit   :setup-layout="{{ json_encode($setupLayout) }}"
                                                    :custom-uom-list="{{ json_encode($customUomList) }}"
                                                    :list-date-layout = "{{ json_encode($listDateLayout) }}">
                    </save-publication-layout-edit>

                    <div class="row clearfix text-right">
                        <div class="col" style="margin-top: 15px;">
                            <button class="btn btn-success" type="submit"> 
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก 
                            </button>
                            <a type="button" class="btn btn-danger" href="{{ route('pm.settings.save-publication-layout.index') }}">
                                <i class="fa fa-times" aria-hidden="true" ></i> ยกเลิก
                            </a>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
