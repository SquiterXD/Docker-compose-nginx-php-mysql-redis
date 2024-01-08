@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'Report Info')

@section('page-title')
  <h2><x-get-program-code url="/ir/settings/report-info" /></h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/">Home</a>
    </li>
    {{-- <li class="breadcrumb-item">
        <a>IR</a>
    </li> --}}
    <li class="breadcrumb-item">
        <a>Settings</a>
    </li>
    <li class="breadcrumb-item">
        <a>ข้อมูลรายงาน</a>
    </li>
    <li class="breadcrumb-item active">
        <strong><x-get-program-code url="/ir/settings/report-info" />:</strong>
    </li>
  </ol>
@stop

@section('page-title-action')

@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-content">

                    <setting-ir-report
                        :program="{{ json_encode($program) }}"
                        :infos="{{ json_encode($infos) }}"
                        :list-form-types="{{ json_encode($listFormTypes) }}"
                        :url="{{ json_encode($url) }}"
                        :token="{{json_encode(csrf_token()) }}"
                        :trans-date="{{ json_encode(trans('date')) }}"
                        :sys-date="{{ json_encode(now()) }}"
                        :csrf="{{ json_encode(csrf_token()) }}"
                        :func="{{ json_encode($func)}}"
                        :list-infos="{{ json_encode($listInfos) }}">
                    </setting-ir-report>
                </div>
            </div>
        </div>
    </div>
@endsection
