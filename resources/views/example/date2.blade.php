@extends('layouts.app')

@section('title', 'Ex: Date')

@section('page-title')
    <h2>Example: Date</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Example</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Date</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="#" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="form-group row">
                        <label class="col-lg-4 text-right col-form-label">
                            ex v2: วันที่ปีไทย
                        </label>

                        <div class="col-lg-3">
                            <ex-date2-component p-fm-date="{{ date('Y-m-d') }}" :p-date-format="{{ json_encode(trans('date')) }}" />
                            {{-- <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="input_date"
                                id="input_date"
                                placeholder="โปรดเลือกวันที่"
                                value="{{ old("input_date") }}"
                                format="{{ trans("date.js-format") }}"> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
    </script>
@endsection



