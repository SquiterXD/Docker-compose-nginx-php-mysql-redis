{!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id], 
    'method' => 'POST',
    'id' => 'form-send-request-with-reason',
    'class' => 'form-horizontal']) !!}

    {!! Form::hidden('type','CASH-ADVANCE') !!}
    {!! Form::hidden('activity','SEND_REQUEST') !!}

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send Request</h4>
    </div>
    <div class="modal-body">
        <div class="clearfix m-b-sm">
            <h3 class="text-warning">
                <i class="fa fa-exclamation-triangle"></i> {{ $title }}
            </h3>
            <p class="text-mute">&emsp;&emsp;{!! $text !!}</p>
        </div>
        <div class="clearfix">
            <label>Reason (เหตุผลประกอบ) <span class="text-danger">*</span></label>
            {!! Form::textArea('reason', null , ["class" => 'form-control', "autocomplete" => "off", "style" => "height:100px;"]) !!}
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary">Send Request</button>
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
    </div>
{!! Form::close() !!}