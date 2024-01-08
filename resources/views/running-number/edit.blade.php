@extends('layouts.app')

@section('title', 'Running number')

@section('page-title')
    <h2>Running Number</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Running Number</a>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form method="post" action="{{ route('running-number.update', $header->doc_seq_header_id) }}">
                        @csrf
                        @method('PUT')
                        <running-number :programs="{{json_encode($programs)}}"
                                        :modules="{{json_encode($modules)}}"
                                        :group-formats="{{json_encode($groupFormats)}}"
                                        :reset-ats="{{json_encode($resetAts)}}"
                                        :date-formats="{{json_encode($dateFormats)}}"
                                        :year-types="{{json_encode($yearTypes)}}"
                                        :default-form-value="{{json_encode($header)}}"
                                        :get-assignments="{{json_encode($getAssignments)}}"
                                        :num-documents="{{json_encode($numDocuments)}}"
                                        :headers="{{json_encode($headers)}}"
                                        :old="{{ json_encode(Session::getOldInput()) }}">
                        </running-number>

                        <div class="text-right mt-3">
                            <button class='btn btn-sm btn-primary'><i class="fa fa-save"></i> บันทึก </button>
                            <a href="{{ route('running-number.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
