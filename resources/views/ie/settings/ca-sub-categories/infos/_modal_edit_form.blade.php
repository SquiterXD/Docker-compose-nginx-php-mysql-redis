{!! Form::model($ca_sub_category_info, ['route' => ['ie.settings.ca-sub-categories.infos.update', $ca_category->ca_category_id, $ca_sub_category->ca_sub_category_id, $ca_sub_category_info->casub_cate_info_id], 'class' => 'form-horizontal', 'method' => 'patch'] ) !!}
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 class="m-b-md">
        <div>Edit CA Sub-Category Infomation</div>
        <div><small>แก้ไขข้อมูลรายละเอียดของประเภทการเบิกเงินทดรองย่อย</small></div>
        <span id="progress_modal" class="pull-right d-none">
            @include('layouts._progress_bar',['size'=>'20'])
        </span>
    </h3>
    <hr class="m-b-xs">
    <div class="row clearfix">
        <div class="col-sm-12">
                <div class="row m-t-sm">
                    <div class="col-sm-6">
                        <label>
                            <div>Attribute Name <span class="text-danger">*</span></div>
                            <div><small>ชื่อแอตทริบิวต์</small></div>
                        </label>
                        {!! Form::text('attribute_name', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                    </div>
                    <div class="col-sm-6">
                        <label>
                            <div>Form Type <span class="text-danger">*</span> </div>
                            <div><small>ประเภทข้อมูล</small></div>
                        </label>
                        {!! Form::select('form_type', $listFormTypes , null , ["id"=>"ddl_form_type_edit","class" => 'form-control', "autocomplete" => "off"]) !!}
                    </div>
                </div>
                <div class="row m-t-sm">
                    <div class="col-sm-12">
                        <div>
                            <label> 
                                <div>Form Value</div>
                                <div><small>ข้อมูล</small></div>
                            </label>
                            <span class="text-info pull-right"
                                data-toggle="tooltip" 
                                data-html="true" 
                                title="@include('ie.settings.ca-sub-categories.infos._tooltip_form_value')">
                                <i class="fa fa-question-circle"></i>
                            </span>
                        </div>
                        <div id="div_txt_form_value_edit">
                            @include('ie.settings.ca-sub-categories.infos._input_form_value')
                        </div>
                    </div>
                </div>
                <div class="row m-t-sm">
                    <div class="col-sm-12">
                        <label>
                            <div>Purpose</div>
                            <div><small>จุดประสงค์</small></div>
                        </label>
                        {!! Form::text('purpose', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                    </div>
                </div>
                <div class="row m-t-sm">
                    <div class="col-sm-12">
                        <div><label>
                            {!! Form::checkbox('required', true, null ) !!} required (บังคับกรอก) ?
                        </label></div>
                    </div>
                </div>
            
        </div>
    </div>
    <div class="row clearfix text-right">
        <div class="col-sm-12">
            <button id="btn_edit" class="btn btn-sm btn-primary" type="submit">
                Save
            </button>
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
{!! Form::close()!!}
