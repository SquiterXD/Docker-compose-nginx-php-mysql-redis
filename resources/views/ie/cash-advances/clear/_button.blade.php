
{{-- ################################### --}}
{{-- ##### BUTTON CLEARING REQUEST ##### --}}
{{-- ################################### --}}
<div class="row m-b-sm">
    <div class="col-md-12 text-right">
        @if($cashAdvance->status == 'CLEARING_REQUEST' && $cashAdvance->isNotLock() && canEnter('/ie/cash-advances') )
            
            {{-- ######### BUTTON CLEARING REQUEST ######## --}}

            {{-- @if(!count($pendingRequestLists))
            
                {!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id], 
                                'method' => 'POST',
                                'id' => 'form-clear-send-request']) !!}
                    
                    {!! Form::hidden('type','CLEARING') !!}
                    {!! Form::hidden('activity','CLEARING_SEND_REQUEST') !!}
                    {!! Form::hidden('reason',null) !!}
                    <button type="submit" class="btn btn-primary btn-resize" id="btn-cl-send-request" disabled="disabled">
                        <i class="fa fa-rss"></i> Send Request
                    </button>

                {!! Form::close() !!}
            
            @else

                <button class="btn btn-resize btn-primary" data-toggle="modal" href="#enter-record-number-data">
                    <i class="fa fa-rss"></i> Send Request
                </button>

            @endif --}}

            <button class="btn btn-resize btn-primary" data-toggle="modal" href="#modal-send-request" id="btn-modal-send-request">
                <i class="fa fa-rss"></i> Send Request
            </button>

        @endif


        @if($cashAdvance->status == 'CLEARING_APPROVER_DECISION' && $cashAdvance->isNextClearingApprover() && canEnter('/ie/cash-advances'))
            
            {{-- ######### BUTTON CLEARING APPROVER_DECISION ######## --}}
            {{-- <div class="btn-resize">
            {!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id], 
                            'method' => 'POST',
                            'id' => 'form-clear-approver-approve',
                            'style' => 'display: inline;']) !!}

                {!! Form::hidden('type','CLEARING') !!}
                {!! Form::hidden('activity','CLEARING_APPROVER_APPROVE') !!}
                <button type="submit" class="btn btn-primary btn-resize" disabled="disabled">
                    <i class="fa fa-check-square-o"></i> Approve
                </button>

            {!! Form::close() !!}
            </div> --}}

            <button class="btn btn-primary btn-resize" data-toggle="modal" data-target="#clear-approve">
                <i class="fa fa-check-square-o"></i> Approve
            </button>

            <button class="btn btn-warning btn-resize" data-toggle="modal" data-target="#clear-send-back">
                <i class="fa fa-reply"></i> Send Back
            </button>

        @endif


        @if($cashAdvance->status == 'CLEARING_FINANCE_PROCESS' && \Auth::user()->isFinance() && canEnter('/ie/cash-advances'))
            
            {{-- ######### BUTTON CLEARING FINANCE PROCESS ######## --}}
            {{-- <div class="btn-resize">
            {!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id], 
                            'method' => 'POST',
                            'id' => 'form-clear-finance-approve',
                            'style' => 'display: inline;']) !!}

                {!! Form::hidden('type','CLEARING') !!}
                {!! Form::hidden('activity','CLEARING_FINANCE_APPROVE') !!}
                <button type="submit" class="btn btn-primary btn-resize" disabled="disabled">
                    <i class="fa fa-check-square-o"></i> Approve
                </button>

            {!! Form::close() !!}
            </div> --}}
            
            <button class="btn btn-primary btn-resize" data-toggle="modal" data-target="#clear-finance-approve">
                <i class="fa fa-check-square-o"></i> Approve
            </button>

            <button class="btn btn-warning btn-resize" data-toggle="modal" data-target="#clear-finance-send-back">
                <i class="fa fa-reply"></i> Send Back
            </button>

        @endif
    </div>
</div>
