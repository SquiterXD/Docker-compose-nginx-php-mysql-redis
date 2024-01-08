<div id="modal-export-cash-advances" class="modal fade" aria-hidden="true">
    <div class="modal-dialog pt-0 modal-md">
        <div class="modal-content">
            <div class="modal-body" id="modal-body-export-cash-advances">
                <div class="m-l-xs m-r-lg">
                    {!! Form::open(['route' => ['ie.cash-advances.export'], 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'form-export-cash-advance'] ) !!}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="m-b-sm">Export Cash Advance</h3>
                    <hr class="m-t-xs m-b-md">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group clearfix">
                                <label for="" class="col-md-4 control-label no-padding">
                                    <div>Type</div>
                                    <div class="m-r-sm">ประเภท</div>
                                </label>
                                <div class="col-md-8">
                                    {!! Form::select('type',[
                                            'CASH-ADVANCE'  =>  'CASH-ADVANCE',
                                            'CLEARING'      =>  'CLEARING'
                                        ]
                                        ,null
                                        ,["class" => 'form-control', "autocomplete" => "off"])
                                    !!}
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label for="" class="col-md-4 control-label no-padding">
                                    <div>Document #</div>
                                    <div class="m-r-sm">หมายเลขเอกสาร</div>
                                </label>
                                <div class="col-md-8">
                                   {!! Form::text('document_no', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label for="" class="col-md-4 control-label no-padding">
                                    <div>Date</div>
                                    <div class="m-r-sm">ช่วงวันที่</div>
                                </label>
                                <div class="col-md-4">
                                   {!! Form::text('date_from', null , ["class" => 'form-control date-picker', "autocomplete" => "off"]) !!}
                                </div>
                                <div class="col-md-4">
                                   {!! Form::text('date_to', null , ["class" => 'form-control date-picker', "autocomplete" => "off"]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="m-t-sm m-b-sm">
                    <div class="row clearfix">
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary btn-outline" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Exporting ...">
                                Export
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>
