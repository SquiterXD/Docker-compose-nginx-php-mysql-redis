<div id="modal-edit-show-all-users" class="modal fade" aria-hidden="true">
    <div class="modal-dialog pt-0 modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="modal-body-edit-show-all-users">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>
                    <div>Select Show All Users</div>
                    <div><small>เลือกผู้มีสิทธิ์ดูข้อมูลทั้งหมด</small></div>
                </h4>
                <div class="row">
                    <div class="col-sm-12 mini-scroll-bar" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                        {!! Form::select('show_all[]', $userLists, $showAllUsers, ["class" => 'form-control select2', "id" => 'txt_show_all', "autocomplete" => "off", "multiple" => "multiple"]) !!}
                    </div>
                </div>
                <div class="text-right mt-2">
                    <button id="btn_save_edit_show_all_users"
                            class="btn btn-sm btn-primary" type="submit">
                        Save
                    </button>
                    <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
