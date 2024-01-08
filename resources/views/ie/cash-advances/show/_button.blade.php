
{{-- ################################# --}}
{{-- ##### BUTTON CA REQUEST ##### --}}
{{-- ################################# --}}

<div class="row m-b-sm">
    <div class="col-md-12 text-right">
        @if($cashAdvance->status == 'NEW_REQUEST' && $cashAdvance->isNotLock() && canEnter('/ie/cash-advances'))

            {{-- @if (!count($pendingRequestLists))

                {!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id], 
                                'method' => 'POST',
                                'id' => 'form-send-request']) !!}
                    
                    {!! Form::hidden('type','CASH-ADVANCE') !!}
                    {!! Form::hidden('activity','SEND_REQUEST') !!}
                    {!! Form::hidden('reason',null) !!}
                    <button type="submit" class="btn btn-primary btn-resize" id="btn-ca-send-request" disabled="disabled">
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

        @if($cashAdvance->status == 'BLOCKED' && \Auth::user()->isUnblocker() && canEnter('/ie/cash-advances'))

            {{-- ######### BUTTON UNBLOCK ######## --}}
            <button class="btn btn-warning btn-resize" data-toggle="modal" data-target="#modal-unblock">
                <i class="fa fa-unlock"></i> Unblock
            </button>

        @endif


        @if($cashAdvance->status == 'APPROVER_DECISION'  && $cashAdvance->isNextApprover() && canEnter('/ie/cash-advances'))

            {{-- ######### BUTTON APPROVER DECISION ######## --}}
            {{-- <div class="btn-resize">
            {!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id], 
                            'method' => 'POST',
                            'id' => 'form-approver-approve',
                            'style' => 'display: inline;']) !!}

                {!! Form::hidden('type','CASH-ADVANCE') !!}
                {!! Form::hidden('activity','APPROVER_APPROVE') !!}
                <button type="submit" class="btn btn-primary btn-resize" disabled="disabled">
                    <i class="fa fa-check-square-o"></i> Approve
                </button>

            {!! Form::close() !!}
            </div> --}}

            <button class="btn btn-primary btn-resize" data-toggle="modal" data-target="#approve">
                <i class="fa fa-check-square-o"></i> Approve
            </button>

            <button class="btn btn-warning btn-resize" data-toggle="modal" data-target="#send-back">
                <i class="fa fa-reply"></i> Send Back
            </button>

            <button class="btn btn-danger btn-resize" data-toggle="modal" data-target="#reject">
                <i class="fa fa-times"></i> Reject
            </button>

        @endif


        @if($cashAdvance->status == 'FINANCE_PROCESS' && \Auth::user()->isFinance() && canEnter('/ie/cash-advances'))

            {{-- ######### BUTTON FINANCE PROCESS ######## --}}
            @if($cashAdvance->due_date)

                {{-- <div class="btn-resize">
                {!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id], 
                                'method' => 'POST',
                                'id' => 'form-finance-approve',
                                'style' => 'display: inline;']) !!}

                    {!! Form::hidden('type','CASH-ADVANCE') !!}
                    {!! Form::hidden('activity','FINANCE_APPROVE') !!}
                    <button type="submit" class="btn btn-primary btn-resize" disabled="disabled">
                        <i class="fa fa-check-square-o"></i> Approve
                    </button>

                {!! Form::close() !!}
                </div> --}}

                <button class="btn btn-primary btn-resize" data-toggle="modal" data-target="#finance-approve">
                    <i class="fa fa-check-square-o"></i> Approve
                </button>

            @endif

            <button class="btn btn-warning btn-resize" data-toggle="modal" data-target="#finance-send-back">
                <i class="fa fa-reply"></i> Send Back
            </button>

            <button class="btn btn-danger btn-resize" data-toggle="modal" data-target="#finance-reject">
                <i class="fa fa-times"></i> Reject
            </button>

        @endif
    </div>
</div>

