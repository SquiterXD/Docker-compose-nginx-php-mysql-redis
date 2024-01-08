{{-- @if (count($pendingRequestLists)) --}}

    {{-- MODAL ENTER DUE DATE --}}
    <div class="modal fade" id="modal-send-request" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog pt-0 modal-md" role="document">

            {!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id],
                'method' => 'POST',
                'id' => 'form-clear-send-request',
                'class' => 'form-horizontal']) !!}
            {!! Form::hidden('type','CLEARING') !!}
            {!! Form::hidden('activity','CLEARING_SEND_REQUEST') !!}
            {!! Form::hidden('reason',null) !!}

            <div class="modal-content" id="content-modal-send-request">

            </div>
            {!! Form::close() !!}
        </div>
    </div>

{{-- @endif --}}