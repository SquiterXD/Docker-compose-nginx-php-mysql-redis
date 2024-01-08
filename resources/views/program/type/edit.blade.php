@extends('layouts.app')

@section('title', 'Program Type')

@section('page-title')
    <h2>Program Type: Edit</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('program.type.index') }}">Program Type</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Edit</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5> Program Type </h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['program.type.update'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="old_program_type" value="{{ $programType->program_type_name }}">
                        <program-type-component
                            :program-type="{{ json_encode($programType) }}"
                            :type-lists="{{ json_encode($typeLists) }}"
                            inline-template
                        >
                            @include('program.type._form')
                        </program-type-component>

                        <div class="col-12 mt-3">
                            <hr>
                            <div class="row clearfix text-right">
                                <div class="col-sm-12">
                                    <button class="btn btn-sm btn-primary" type="submit"> Save </button>
                                    <a href="{{ route('program.type.index') }}" type="button" class="btn btn-sm btn-white"> Cancel </a>
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
