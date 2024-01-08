@extends('layouts.app')


@section('title', 'PD')

@section('page-title')
    <h2>{{ empty($data) ? "" : $data->title }} </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">{{ empty($data) ? "" : $data->description }}</a>
        </li>
    </ol>

@stop

@section('page-title-action')
@stop

@section('content')
    <pd-0015
        :user-profile               = "{{ json_encode($userProfile) }}"
        :trans-date                 = "{{ json_encode(trans('date')) }}"
        :token                      = "{{ json_encode( csrf_token()) }}"
        :trans-btn                  = "{{ json_encode(trans('btn')) }}"
        :types                      = "{{json_encode($types) }}"
        :statuses                   = "{{ json_encode($statuses) }}"
        :headers                    = "{{ json_encode($headers) }}"
        :species                    = "{{json_encode($species) }}"
        :sales-fiscal-year-no-arr   = "{{ json_encode($salesFiscalYearNoArr) }}">
    </pd-0015>
@endsection



