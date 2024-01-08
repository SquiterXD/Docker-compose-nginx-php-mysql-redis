
{{-- ################################# --}}
{{-- ##### BUTTON REIM REQUEST ##### --}}
{{-- ################################# --}}

<div class="row m-b-sm">
    <div class="col-md-12 text-right">
        @if($reim->status == 'NEW_REQUEST' && $reim->isNotLock() && canEnter('/ie/reimbursements'))

            {{-- ######### BUTTON RESERVE ENCUMBRANCE ######## --}}

            {!! Form::open(['route' => ['ie.reimbursements.set_status',$reim->reimbursement_id],
                            'method' => 'POST',
                            'id' => 'form-reserve-encumbrace']) !!}

                {!! Form::hidden('activity','RESERVE_ENCUMBRANCE') !!}
                <button type="submit" class="btn btn-primary btn-resize" id="btn-reim-reserve-encumbrace" disabled="disabled">
                    <i class="fa fa-forward"></i> Reserve Encumbrance
                </button>

            {!! Form::close() !!}

        @endif

        @if($reim->status == 'RESERVE_ENCUMBRANCE' && $reim->isNotLock() && canEnter('/ie/reimbursements'))

            {{-- ######### BUTTON UNRESERVE ENCUMBRANCE ######## --}}
            {!! Form::open(['route' => ['ie.reimbursements.set_status',$reim->reimbursement_id],
                            'method' => 'POST',
                            'id' => 'form-unreserve-encumbrace',
                            'class' => 'd-inline-block']) !!}

                {!! Form::hidden('activity','UNRESERVE_ENCUMBRANCE') !!}
                <button type="submit" class="btn btn-warning btn-resize" id="btn-reim-unreserve-encumbrace" disabled="disabled">
                    <i class="fa fa-backward"></i> Unreserve Encumbrance
                </button>

            {!! Form::close() !!}

            {{-- ######### BUTTON SEND REQUEST ######## --}}

            <button class="btn btn-resize btn-primary" data-toggle="modal" href="#modal-send-request" id="btn-modal-send-request">
                <i class="fa fa-rss"></i> Send Request
            </button>

            {{-- {!! Form::open(['route' => ['ie.reimbursements.set_status',$reim->reimbursement_id],
                            'method' => 'POST',
                            'id' => 'form-send-request',
                            'class' => 'd-inline-block']) !!}

                {!! Form::hidden('activity','SEND_REQUEST') !!}
                <button type="submit" class="btn btn-primary btn-resize" id="btn-reim-send-request" disabled="disabled">
                    <i class="fa fa-rss"></i> Send Request
                </button>

            {!! Form::close() !!} --}}
        @endif

        @if($reim->status == 'BLOCKED' && \Auth::user()->isUnblocker() && canEnter('/ie/reimbursements'))

            {{-- ######### BUTTON UNBLOCK ######## --}}
            <button class="btn btn-warning btn-resize" data-toggle="modal" data-target="#modal-unblock">
                <i class="fa fa-unlock"></i> Unblock
            </button>

        @endif


        @if($reim->status == 'APPROVER_DECISION' && $reim->isNextApprover() && canEnter('/ie/reimbursements'))

            {{-- ######### BUTTON APPROVER DECISION ######## --}}
            {{-- <div class="btn-resize">
            {!! Form::open(['route' => ['ie.reimbursements.set_status',$reim->reimbursement_id],
                            'method' => 'POST',
                            'id' => 'form-approver-approve',
                            'style' => 'display: inline;']) !!}

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
    </div>
</div>