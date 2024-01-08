
{{-- ###################################### --}}
{{-- ####### MODAL CLEARING REQUEST ####### --}}
{{-- ###################################### --}}



    @if($cashAdvance->status == 'CLEARING_REQUEST')

        {{-- CLEARING SEND REQUET WITH REASON --}}
        <div class="modal fade" id="modal-clear-send-request-with-reason" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog pt-0 modal-md" role="document">
                <div class="modal-content">
                    <div class="ibox-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Send Clearing Request</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-primary" disabled="disabled">Send Request</button>
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    @endif

    @if($cashAdvance->status == 'CLEARING_APPROVER_DECISION'  && $cashAdvance->isNextClearingApprover())
        {{-- MODAL APPROVER APPROVE --}}
        <div class="modal fade" id="clear-approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog pt-0 modal-md" role="document">

                <div class="modal-content">
                    <div class="ibox-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        {!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id], 
                            'method' => 'POST',
                            'id' => 'form-clear-approver-approve',
                            'class' => 'form-horizontal']) !!}

                            {!! Form::hidden('type','CLEARING') !!}
                            {!! Form::hidden('activity','CLEARING_APPROVER_APPROVE') !!}

                            <div class="modal-body">
                                <div class="clearfix m-b-sm text-center">
                                    <h1>Approve Request ?</h1>
                                    <h2><span style="font-size: 18px">Are you sure to approve request ?</span></h2>
                                </div>
                                @if ($cashAdvance->isLastApprover())
                                    <div class="clearfix mb-2">
                                        <label>Apply Date (วันที่เคลียร์เงิน) </label>
                                        {!! Form::text('prepay_apply_date', $cashAdvance->clearing_gl_date, ["class" => 'form-control', "autocomplete" => "off", 'id'=>'txt_prepay_apply_date']) !!}
                                    </div>
                                @endif
                                <div class="clearfix">
                                    <label>Remark (หมายเหตุ) </label>
                                    {!! Form::textArea('reason', null , ["class" => 'form-control', "autocomplete" => "off", "style" => "height:60px;"]) !!}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-primary">Approve</button>
                                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL APPROVER SENDBACK  --}}
        <div class="modal fade" id="clear-send-back" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog pt-0 modal-md" role="document">

                <div class="modal-content">
                    <div class="ibox-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        {!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id], 
                            'method' => 'POST',
                            'id' => 'form-clear-approver-send-back',
                            'class' => 'form-horizontal']) !!}

                            {!! Form::hidden('type','CLEARING') !!}
                            {!! Form::hidden('activity','CLEARING_APPROVER_SENDBACK') !!}

                            <div class="modal-body">
                                <div class="clearfix m-b-sm text-center">
                                    <h1>Send Back Request ?</h1>
                                    <h2><span style="font-size: 18px">Please enter reason to send back request.</span></h2>
                                </div>
                                <div class="clearfix">
                                    <label>Reason (เหตุผลประกอบ)<span class="text-danger">*</span></label>
                                    {!! Form::textArea('reason', null , ["class" => 'form-control', "autocomplete" => "off", "style" => "height:100px;"]) !!}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-primary">Send Back</button>
                                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        
    @endif

    @if($cashAdvance->status == 'CLEARING_FINANCE_PROCESS' && \Auth::user()->isFinance())
        {{-- MODAL FINANCE APPROVE  --}}
        <div class="modal fade" id="clear-finance-approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog pt-0 modal-md" role="document">

                <div class="modal-content">
                    <div class="ibox-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        {!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id], 
                            'method' => 'POST',
                            'id' => 'form-clear-finance-approve',
                            'class' => 'form-horizontal']) !!}

                            {!! Form::hidden('type','CLEARING') !!}
                            {!! Form::hidden('activity','CLEARING_FINANCE_APPROVE') !!}

                            <div class="modal-body">
                                <div class="clearfix m-b-sm text-center">
                                    <h1>Approve Request ?</h1>
                                    <h2><span style="font-size: 18px">Are you sure to approve request ?</span></h2>
                                </div>
                                <div class="clearfix">
                                    <label>Remark (หมายเหตุ) </label>
                                    {!! Form::textArea('reason', null , ["class" => 'form-control', "autocomplete" => "off", "style" => "height:60px;"]) !!}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-primary">Approve</button>
                                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL FINANCE SENDBACK  --}}
        <div class="modal fade" id="clear-finance-send-back" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog pt-0 modal-md" role="document">
                <div class="modal-content">
                    <div class="ibox-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
                        </div>
                        {!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id], 
                            'method' => 'POST',
                            'id' => 'form-clear-finance-send-back',
                            'class' => 'form-horizontal']) !!}

                            {!! Form::hidden('type','CLEARING') !!}
                            {!! Form::hidden('activity','CLEARING_FINANCE_SENDBACK') !!}

                            <div class="modal-body">
                                <div class="clearfix m-b-sm text-center">
                                    <h1>Send Back Request ?</h1>
                                    <h2><span style="font-size: 18px">Please enter reason to send back request.</span></h2>
                                </div>
                                <div class="clearfix">
                                    <label>Reason (เหตุผลประกอบ)<span class="text-danger">*</span></label>
                                    {!! Form::textArea('reason', null , ["class" => 'form-control', "autocomplete" => "off", "style" => "height:100px;"]) !!}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-primary">Send Back</button>
                                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

    @endif