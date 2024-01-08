<div id="modal_create_receipt_line" class="modal fade" role="dialog" >
    <div class="modal-dialog pt-0 modal-lg " role="document" style="">
    {{-- width: 90%; max-width:1200px; --}}
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-left" > 
                    Add New Receipt Line <br/>
                    <small> สร้างรายการใบเสร็จใหม่ </small>
                    <span id="progress_modal_create" class="pull-right d-none">
                        @include('layouts._progress_bar',['size'=>'20'])
                    </span>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div id="modal_content_create_receipt_line">
                    {{-- @include('ie.commons.receipts.lines._form') --}}
                </div>

            </div>
        </div>
    </div>
</div>