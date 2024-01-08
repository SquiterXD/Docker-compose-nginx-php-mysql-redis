@extends('layouts.app')

@section('title', 'ความสัมพันธ์การจ่าย')

@section('page-title')
    <h2><x-get-program-code url="/pm/settings/relation-feeder"/> : ความสัมพันธ์การจ่าย</h2>
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
            <a href="{{ route('pm.settings.relation-feeder.index') }}">
                <x-get-program-code url="/pm/settings/relation-feeder"/> : ความสัมพันธ์การจ่าย
            </a>
        </li>
        <li class="breadcrumb-item">
            <strong><a>แก้ไข</a></strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>แก้ไขรายการความสัมพันธ์การจ่าย</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['pm.settings.relation-feeder.update'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}

                    <relation-feeder-edit   :relation-feeders = "{{ json_encode($relationFeeders) }}"
                                            :feeder-groups = "{{ json_encode($feederGroups) }}">

                    </relation-feeder-edit>

                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="{{ $btnTrans['save']['class'] }}" type="submit"> 
                                    <i class="{{ $btnTrans['save']['icon'] }}" aria-hidden="true"></i> {{ $btnTrans['save']['text'] }} 
                                </button>
                                <a  type="button" 
                                    href="{{ route('pm.settings.relation-feeder.index') }}" 
                                    class="{{ $btnTrans['cancel']['class'] }}"> 
                                    <i class="{{ $btnTrans['cancel']['icon'] }}" aria-hidden="true"></i> {{ $btnTrans['cancel']['text'] }} 
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
