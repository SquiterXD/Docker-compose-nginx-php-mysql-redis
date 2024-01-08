{{-- <div class="modal inmodal fade" id="popUp_{{$programName->program_code}}" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Setup</h4>
            </div>

            {!! Form::open(['route' => ['pd.settings.set-up.update', $programName->program_code] 
                                        , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}

            <form action="{{ route('pd.settings.set-up.update', $programName->program_code) }}" method="POST">
                @csrf
    

                <div class="modal-body">
                    <div class="control-label mb-2" align="left"><strong> {{ $programName->program_code }}: {{ $programName->description }} </strong></div>
                    <div class="row">
                        
                        @foreach ($programColumns->where('program_code',$programName->program_code) as $programColumn)
                            @if($programColumn->column_name == 'ENABLED_FLAG')
                                <div class="col-md-4" style="padding-bottom: 10px;" align="left">
                                    <strong> {{ str_replace('_', ' ', $programColumn->column_name) }} </strong> <span class="text-danger">*</span>
                                    <div class="col-12" align="left" style="padding-top: 10px; padding-left: 0px;">
                                        <input type="checkbox" name="{{ $programColumn->column_name }}" type="checkbox" checked>
                                    </div>
                                </div>
                            @elseif ($programColumn->column_name == 'UOM')
                                <div class="col-md-4" style="padding-bottom: 10px;" align="left">
                                    <strong> {{ str_replace('_', ' ', $programColumn->column_name) }} </strong> <span class="text-danger">*</span>
                                    <input type="number" class="form-control col-12" name="{{ $programColumn->column_name }}">
                                </div>
                            @else
                                <div class="col-md-4" style="padding-bottom: 10px;" align="left">
                                    <strong> {{ str_replace('_', ' ', $programColumn->column_name) }} </strong> <span class="text-danger">*</span>
                                    <input type="text" name="{{ $programColumn->column_name }}" class="form-control" style="width:100%" value="{{ $programColumn->column_prompt }}">
                                </div>
                            @endif    
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div> 
            {!! Form::close() !!}
        </form>
        </div>                  
    </div>
</div>    --}}

<div class="modal inmodal fade" id="popUp_{{$programColumn->column_name}}" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding-top: 10px; padding-bottom: 10px;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Setup</h4>
            </div>    

            <form action="{{ route('set-up.update', [$programColumn->program_code, $programColumn->column_name]) }}" method="POST">
                @csrf    

                <div class="modal-body" style="background-color:white; padding-top: 15px;padding-bottom: 15px;">
                    {{-- <div class="control-label mb-2" align="left"><strong> {{ $programName->program_code }}: {{ $programName->description }} </strong></div> --}}

                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2">
                        <div class="control-label mb-2" align="left"> <strong> Column Prompt </strong> <span class="text-danger">*</span></div>
                        <div class="col-12" align="center">
                            <input type="text" name="column_prompt" class="form-control" style="width:100%" value="{{ $programColumn->column_prompt }}">
                        </div>
                    </div>

                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2">
                        <div class="control-label mb-2" align="left"> <strong> Column Seq Num </strong> <span class="text-danger">*</span></div>
                        <div class="col-12" align="center">
                            <input type="text" name="column_seq_num" class="form-control" style="width:100%" value="{{ $programColumn->column_seq_num }}">
                        </div>
                    </div> 
                    
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2">
                        <div class="control-label mb-2" align="left"> <strong> Input Type </strong> </div>
                        <div class="col-12" align="center">
                            <input type="text" name="input_type" class="form-control" style="width:100%" value="{{ $programColumn->input_type }}">
                        </div>
                    </div>

                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2">
                        <div class="control-label mb-2" align="left"> <strong> Enable Flag </strong> </div>
                        <div class="col-12" align="left" style="padding-left: 18px;">
                            <input type="checkbox" name="enable_flag" style="width: 15px; height: 15px;" {{ $programColumn->enable_flag == 'Y' ? 'checked' : '' }}> 
                        </div>
                    </div>

                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2">
                        <div class="control-label mb-2" align="left"> <strong> Required Flag </strong> </div>
                        <div class="col-12" align="left" style="padding-left: 18px;">
                            <input type="checkbox" name="required_flag" style="width: 15px; height: 15px;" {{ $programColumn->required_flag == 'Y' ? 'checked' : '' }}> 
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i>  บันทึก
                    </button>
                </div> 
            </form>
        </div>                  
    </div>
</div>   