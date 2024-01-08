@extends('layouts.app')

@section('title', 'Ex: Vue')

@section('page-title')
    <h2>Example: Vue</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Example</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Vue</strong>
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
                    <div class="text-center m-t-lg">
                        <ex-user-component></ex-user-component>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <ex-user-component person-id="5" inline-template>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header text-center">Example ssssVue (inline-template)aaa</div>
                                    <div class="card-body">
                                        <div class="form-group  row">
                                            <label class="col-sm-4 col-form-label text-right">Normal</label>
                                            <div class="col-sm-8">
                                                <input type="hidden" name="person_id" :value="person_id" autocomplete="off">
                                                <el-select
                                                    v-model="person_id"
                                                    filterable
                                                    style="width: 100%"
                                                    remote
                                                    :disabled="disabled"
                                                    placeholder="ชื่อ หรือ นามสกุล"
                                                    :remote-method="remoteMethod"
                                                    :loading="loading"
                                                >
                                                    <el-option
                                                        v-for="empolyee in employees"
                                                        :key="empolyee.person_id"
                                                        :label="empolyee.full_name"
                                                        :value="empolyee.person_id"
                                                    ></el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </ex-user-component>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <label class="col-lg-2 text-right col-form-label">วันที่</label>

                        <div class="col-lg-3">
                            <datepicker-th style="width: 100%" class="form-control md:tw-mb-0 tw-mb-2" name="sample_date" id="input_sample_date" placeholder="โปรดเลือกวันที่" value="{{ old('sample_date') }}" format="{{ trans('date.js-format') }}">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <label class="col-lg-2 text-right col-form-label"> Upload </label>
                    <form action="/test/upload" method="post">
                        @csrf
                        <div class="form-group row">
                            <ex-upload-component> </ex-upload-component>
                        </div>
                        <div class="form-group col-md-10 text-right">
                            <button type="submit" class="btn btn-md btn-primary"> บันทึก </button>
                        </div>
                    </form>

                    <div class="hr-line-dashed"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        showDate();
        async function showDate() {
            var date1 = await helperDate.convertDate('25/03/2021', '{{ trans('date.js-format') }}');
            var date2 = await helperDate.parseToDateTh('25/03/2021', '{{ trans('date.js-format') }}');
            // console.log('date1 ', date1.toString());
            // console.log('date2 ', date2.toString());
        }

        $(document).ready(function(){

            $('.datepicker').datepicker({
                format: "{{ trans('date.js-format') }}",
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });
        });
    </script>
@endsection



