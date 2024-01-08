{{-- @extends('layouts.app')

@section('content')
    {!! Form::open(['route' => ['pd.settings.set-up.update'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
    @method('PUT')

        <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> <strong> column prompt </strong> <span class="text-danger">*</span></div>
                <div class="col-12" align="center">
                    <input type="text" name="column_prompt" class="form-control" style="width:100%" value="{{ $valueSet->column_prompt }}">
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> <strong> column seq num </strong> <span class="text-danger">*</span></div>
                <div class="col-12" align="center">
                    <input type="text" name="column_seq_num" class="form-control" style="width:100%" value="{{ $valueSet->column_seq_num }}">
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> <strong> enable flag </strong> <span class="text-danger">*</span></div>
                <div class="col-12" align="left" style="padding-left: 18px;">
                    <input type="checkbox" name="enable_flag" style="width: 15px; height: 15px;" {{ $valueSet->enable_flag == 'Y' ? 'checked' : '' }}> 
                </div>
            </div>
        </div>

    {!! Form::close() !!}

@endsection
 --}}
