{!! Form::open(['route' => ['ie.cash-advances.set_status',$cashAdvance->cash_advance_id], 
    'method' => 'POST',
    'enctype' => 'multipart/form-data',
    'id' => 'form-clear-send-request-with-reason',
    'class' => 'form-horizontal']) !!}

    {!! Form::hidden('type','CLEARING') !!}
    {!! Form::hidden('activity','CLEARING_SEND_REQUEST') !!}

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send Clearing Request</h4>
    </div>
    <div class="modal-body">
        <div class="clearfix m-b-sm">
            <div class="row">
                <div class="col-sm-8">    
                    <h3 class="text-warning">
                        <i class="fa fa-exclamation-triangle"></i> {{ $title }}
                    </h3>
                </div>
                <div class="col-sm-4">
                    <div class="text-right" style="font-size: 12px">
                        <span id="attachmentDescSendRequest" class="d-none">
                            <span id="attachmentDescTextSendRequest" class="m-r-xs"></span>
                            <span id="btnCancelFileSendRequest" class="btn btn-xs btn-danger btn-outline"
                                style="font-size: 12px">
                                <i class="fa fa-times"></i>
                            </span>
                        </span>
                        <span id="btnAddFileSendRequest" 
                            class="fileUpload btn btn-xs btn-primary btn-outline"
                            style="font-size: 12px">
                            <i class="fa fa-plus"></i> Attach File 
                            <input id="inputAttachmentSendRequest" name="file" type="file" class="upload" />
                        </span>
                    </div>
                </div>
            </div>
            @if($headingText)
            <div class="row m-t-sm">
                <div class="col-sm-12">
                    <p class="text-danger"><strong>{{ $headingText }}</strong></p>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-mute">&emsp;&emsp;{!! $text !!}</p>
                </div>
            </div>
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

<script type="text/javascript">
    $(document).ready(function(){
        // ADD ATTACHMENT
        $("#inputAttachmentSendRequest").change(function(){
            if(this.value){
                let filename = $(this).val().replace(/C:\\fakepath\\/i, '');
                $("#attachmentDescTextSendRequest").text(filename);
                $("#attachmentDescSendRequest").removeClass("d-none");
                $("#btnAddFileSendRequest").addClass("d-none");
            }else{
                $("#attachmentDescTextSendRequest").text("");
                $("#attachmentDescSendRequest").addClass("d-none");
                $("#btnAddFileSendRequest").removeClass("d-none");
            }
        });

        // CANCEL ATTACHMENT
        $("#btnCancelFileSendRequest").click(function(){
            $("#inputAttachmentSendRequest").val('');
            $("#attachmentDescTextSendRequest").text("");
            $("#attachmentDescSendRequest").addClass("d-none");
            $("#btnAddFileSendRequest").removeClass("d-none");
        });

    });
</script>