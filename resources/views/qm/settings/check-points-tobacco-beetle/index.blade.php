@extends('layouts.app')

@section('title', 'กำหนดจุดตรวจสอบมอดยาสูบ')

@section('page-title')
  <x-get-page-title menu="" url="/qm/settings/check-points-tobacco-beetle" />
@stop

{{-- @section('page-title')
    <h2><x-get-program-code url="/qm/settings/check-points-tobacco-beetle"/> : กำหนดจุดตรวจสอบมอดยาสูบ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">QM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">Settings</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>
                <a href="{{ route('qm.settings.check-points-tobacco-beetle.index') }}">
                    <x-get-program-code url="/qm/settings/check-points-tobacco-beetle"/> : กำหนดจุดตรวจสอบมอดยาสูบ
                </a>
            </strong>
        </li>
    </ol>
@stop --}}

@section('page-title-action')
    <a  href="{{ route('qm.settings.check-points-tobacco-beetle.create') }}" 
        class="{{$btnTrans['create']['class']}}">
        <i class="{{$btnTrans['create']['icon']}}"></i> {{$btnTrans['create']['text']}}
    </a>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <h1 class="tw-mt-0"></h1>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['qm.settings.check-points-tobacco-beetle.index'] , "method" => "get" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        <check-points-tobacco-beetle-search     :search = "{{ json_encode($search) }}"
                                                                :list-search-build-name = "{{ json_encode($listSearchBuildName) }}"
                                                                :list-search-department-name = "{{ json_encode($listSearchDepartmentName) }}"
                                                                :list-search-locator-desc = "{{ json_encode($listSearchLocatorDesc) }}"
                                                                :list-search-location-desc = "{{ json_encode($listSearchLocationDesc) }}">
            
                        </check-points-tobacco-beetle-search>
                        <div class="text-right">
                            <div class="text-right" style="padding-top: 15px;">
                                <button class="{{$btnTrans['search']['class']}}" type="submit">
                                    <i class="{{$btnTrans['search']['icon']}}" aria-hidden="true"></i> {{$btnTrans['search']['text']}}
                                </button>
                                <a  type="button" 
                                    href="{{ route('qm.settings.check-points-tobacco-beetle.index') }}" 
                                    class="{{$btnTrans['cancel']['class']}}">
                                    ล้าง
                                </a>
                            </div>
                        </div>                       
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="text-center m-t-lg">
                <div class="ibox-title" style="text-align:left;">
                    <h5>กำหนดจุดตรวจสอบด้านมอดยาสูบ</h5>
                </div>
                <div class="ibox-content">
                    {{-- @include('qm.settings.check-points-tobacco-beetle._table') --}}
                    <check-points-tobacco-beetle-table  :check-points = "{{ json_encode($checkPoints) }}"
                                                        :profile = "{{ json_encode($profile) }}">

                    </check-points-tobacco-beetle-table>
                    {{-- <div class="d-flex justify-content-end md:tw-my-0 tw-my-2 lg:tw-px-0 tw-px-2" style="padding-top: 15px;">
                        {!! $checkPoints->links('shared._pagination') !!}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection