<div class="modal fade" id="cancelWorkModal" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ยกเลิกใบแจ้งซ่อม</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <label class="col-form-label">ระบุเหตุผล</label>
            <textarea id="cancelWorkModalText" class="form-control textArea-2" name="description"></textarea>
          </div>
          <div class="col-12 mt-4">
            <div class="text-center">
              <button id="cancelWorkModalSaveBtn" type="button" class="btn btn-primary btn-lg size-btn mt-1">บันทึก</button>
              <button id="cancelWorkModalCancelBtn" type="button" class="btn btn-danger btn-lg size-btn mt-1" data-dismiss="modal">ยกเลิก</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>