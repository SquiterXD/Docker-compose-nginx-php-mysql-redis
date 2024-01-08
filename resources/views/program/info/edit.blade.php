@extends('layouts.app')

@section('title', 'Program Info')

@section('page-title')
    <h2>Program Info : Edit</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('program.info.index') }}"> Program Info </a>
        </li>
        <li class="breadcrumb-item active">
            <strong> Edit </strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5> Program </h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['program.info.update'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="old_program_code" value="{{ $programInfo->program_code }}">
                        <program-info-component
                            :program-info="{{ json_encode($programInfo) }}"
                            :types="{{ json_encode($programTypes) }}"
                            :module-lists="{{ json_encode($moduleLists) }}"
                            :source-type-lists="{{ json_encode($sourceTypeLists) }}"
                            inline-template>
                            @include('program.info._form')
                        </program-info-component>
                        <div class="col-12 mt-3">
                            <hr>
                            <div class="row clearfix m-t-lg text-right">
                                <div class="col-sm-12">
                                    <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                    <a href="{{ route('program.info.index') }}" type="button" class="btn btn-sm btn-danger">
                                        <i class="fa fa-times"></i> ยกเลิก
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

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
@stop
