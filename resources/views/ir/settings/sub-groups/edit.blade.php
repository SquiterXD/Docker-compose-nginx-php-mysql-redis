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
            <strong>แก้ไข</strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/ir/settings/sub-groups" />
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12" style="">
            <div class="ibox">
                <div class="ibox-content">
                    {!! Form::open(['route' => ['ir.settings.sub-groups.update'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        <sub-groups-edit-component 
                                                    :policy-sets = "{{ json_encode($policySets) }}"
                                                    :header = "{{ json_encode($header) }}"
                                                    :sub-lines = "{{ json_encode($lines) }}"
                                                    :btn-trans = "{{ json_encode($btnTrans) }}">
                        </sub-groups-edit-component>

                        <div class="row clearfix text-right">
                            <div class="col" style="margin-top: 15px;">
                                <button class="{{ $btnTrans['save']['class'].' btn-sm' }}" 
                                        type="submit"> 
                                    <i class="{{ $btnTrans['save']['icon'] }}" aria-hidden="true"></i>
                                    {{ $btnTrans['save']['text'] }} 
                                </button>
                                <a  type="button" 
                                    class="{{ $btnTrans['cancel']['class'].' btn-sm' }}" 
                                    href="{{ route('ir.settings.sub-groups.index') }}">
                                    <i class="{{ $btnTrans['cancel']['icon'] }}" aria-hidden="true" ></i> 
                                    {{ $btnTrans['cancel']['text'] }}
                                </a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection