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
            <strong>Datsse</strong>
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
                            ex: Tagssss
                        </label>
                        <div class="col text-center">
                            <code> &lt;datepicker-th style="width: 100%" class="form-control md:tw-mb-0 tw-mb-2" name="input_date" id="input_date" placeholder="โปรดเลือกวันที่" value="{{ old('sample_date') }}" format="{{ trans('date.js-format') }}"&gt;</code>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-4 text-right col-form-label">
                            ex: วันที่ปีไทย
                        </label>

                        <div class="col-lg-3">
                            <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="input_date"
                                id="input_date"
                                placeholder="โปรดเลือกวันที่"
                                value="{{ old("input_date") }}"
                                format="{{ trans("date.js-format") }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 text-right col-form-label">
                            ex: วันที่ปีไทย (not-before & not-after)
                        </label>
                        <div class="col-lg-3">
                            <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="input_date_disable"
                                id="input_date_disable"
                                placeholder="โปรดเลือกวันที่"
                                not-before-date="09/05/2564"
                                not-after-date="15/05/2564"
                                value="{{ old("input_date") }}"
                                format="{{ trans("date.js-format") }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 text-right col-form-label">
                            ex: วันที่ปีไทย (JavaScript Build)
                        </label>
                        <div class="col-lg-3">
                            <div id="input_date_js"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 text-right col-form-label">
                            ex: Datetime ปีไทย
                        </label>
                        <div class="col-lg-3">
                            <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="input_datetime"
                                id="input_datetime"
                                placeholder="โปรดเลือกวันที่"
                                p-type="datetime"
                                value="{{ old("input_date") }}"
                                format="{{ trans("date.js-datatime-format") }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 text-right col-form-label">
                            ex: Time
                        </label>
                        <div class="col-lg-3">
                            <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="input_time"
                                id="input_time"
                                placeholder="โปรดเลือกวันที่"
                                p-type="time"
                                value="{{ old("input_date") }}"
                                format="{{ trans("date.js-time-format") }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 text-right col-form-label">
                            ex: Month
                        </label>

                        <div class="col-lg-3">
                            <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="input_date2"
                                id="input_date2"
                                p-type="month"
                                placeholder="โปรดเลือกวันที่"
                                value="{{ old("input_date") }}"
                                format="{{ trans("date.js-month-format") }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 text-right col-form-label">
                            ex: Year
                        </label>

                        <div class="col-lg-3">
                            <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="input_date3"
                                id="input_date3"
                                p-type="year"
                                placeholder="โปรดเลือกวันที่"
                                value="{{ old("input_date") }}"
                                format="{{ trans("date.js-year-format") }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 text-right col-form-label">
                            &nbsp;
                        </label>
                        <div class="col-lg-6">
                            <div>
                                Date Input: <span id="input_date_value"></span>
                            </div>
                            <button class="btn btn-primary" id="btnShowDate">ดึงค่าวันที่</button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 text-right col-form-label">
                            &nbsp;
                        </label>
                        <div class="col-lg-6">
                            <div>
                                Date Input: <span id="input_time_value"></span>
                            </div>
                            <button class="btn btn-primary" id="btnShowTime">ดึงค่า Time</button>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        $( "#btnShowDate" ).click(function() {
            let dateData = $('#input_datetime').val();
            $('#input_date_value').html(dateData);
        });

        $( "#btnShowTime" ).click(function() {
            let dateData = $('#input_time').val();
            $('#input_time_value').html(dateData);
        });

        showDate();
        async function showDate() {
            var date1 = await helperDate.convertDate('25/03/2021', '{{ trans('date.js-format') }}');
            var date2 = await helperDate.parseToDateTh('25/03/2021', '{{ trans('date.js-format') }}');
            // console.log('date1 ', date1.toString()); // Thu Mar 25 2021 00:00:00 GMT+0700 (เวลาอินโดจีน)
            // console.log('date2 ', date2.toString()); // Sun Mar 25 2564 00:00:00 GMT+0700 (เวลาอินโดจีน)
        }

        var value = '27/04/2564';
        var dateFormat = '{{ trans('date.js-format') }}';
        var disabled = false;

        var vm = new Vue({
            data() {
                return {
                    pValue: value,
                    pFormat: dateFormat,
                    disabled: disabled,
                    notBeforeDate: '15/04/2564',
                    notAfterDate: '28/04/2564'
                }
            },
            template: `<datepicker-th
                            style="width: 100%"
                            class="form-control md:tw-mb-0 tw-mb-2"
                            name="input_date"
                            id="input_date"
                            placeholder="โปรดเลือกวันที่"
                            :not-before-date=notBeforeDate
                            :not-after-date=notAfterDate
                            :disabled="disabled"
                            @dateWasSelected='onchangeDate(...arguments)'
                            :value=pValue
                            :format=pFormat />`,
            methods: {
                onchangeDate (date) {
                    alert('onchange: '+ date.toString())
                    vm.pValue = date;
                }
            },
            watch: {
                pValue : async function (value, oldValue) {
                    console.log('xxx', value, oldValue);
                }
            },
        }).$mount('#input_date_js')


        setTimeout(function(){
            vm.notBeforeDate="21/04/2564"
            vm.notAfterDate="29/04/2564"

            vm.pValue = '22/04/2564'
            vm.disabled = false
        }, 3000);

    </script>
@endsection

