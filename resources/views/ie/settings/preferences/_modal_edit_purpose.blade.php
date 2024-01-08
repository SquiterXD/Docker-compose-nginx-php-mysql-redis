<div id="modal-edit-purpose" class="modal fade" aria-hidden="true">
    <div class="modal-dialog pt-0 modal-lg">
        {!! Form::open(['route' => ['ie.settings.preferences.update_purpose'],
                    'method' => 'POST',
        ]) !!}
        <div class="modal-content">
            <div class="modal-body" id="modal-body-edit-purpose">
                <button type="button" class="close" id="btn_close_change_purpose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>
                    <div>Purpose</div>
                    {{-- <div><small>ตั้งค่าใบแจ้งหนี้</small></div> --}}
                </h4>
                <div class="row">
                    <div class="col-sm-12 mini-scroll-bar" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                        <div id="form-purpose">
                            
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-success mb-2 w-100" id="btn_add_purpose"> + </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button id="btn_save_edit_purpose"
                            class="btn btn-sm btn-primary" type="submit">
                        Save
                    </button>
                    <button type="button" id="btn_cancel_change_purpose" class="btn btn-sm btn-white" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
        {!! Form::close()!!}
    </div>
</div>
