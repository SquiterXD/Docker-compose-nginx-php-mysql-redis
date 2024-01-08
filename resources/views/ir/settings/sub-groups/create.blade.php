@extends('layouts.app')

@section('title', 'Sub-Group')

{{-- @section('page-title')
    <h2>IRM0009: ข้อมูลกลุ่มย่อย (Sub-Group)</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>IR</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('ir.settings.sub-groups.index') }}">IRM0009: ข้อมูลกลุ่มย่อย (Sub-Group)</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>สร้าง</strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/ir/settings/sub-groups" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>IRM0009: ข้อมูลกลุ่มย่อย (Sub-Group)</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['ir.settings.sub-groups.store'] , "method" => "POST" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        <sub-groups-create-component    :policy-set-headers = "{{ json_encode($policySetHeaders) }}"
                                                        :old-input = "{{ json_encode(Session::getOldInput()) }}"
                                                        :url = "{{ json_encode(route('ir.settings.sub-groups.index')) }}"
                                                        :btn-trans = "{{ json_encode($btnTrans) }}">
                        </sub-groups-create-component>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection