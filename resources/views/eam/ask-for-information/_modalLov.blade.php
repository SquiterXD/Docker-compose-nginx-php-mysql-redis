<div class="modal fade" id="detailModalImage" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">แนบรูปภาพ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-5"></div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="addImageBtn" class="btn btn-success btn-lg size-btn" role="button">
                <i class="fa fa-plus"></i> เพิ่มรายการ
              </button>
              <!-- <button id="deleteImageBtn" class="btn btn-danger btn-lg size-btn" role="button">
                <i class="fa fa-times"></i> ลบรายการ
              </button>
              <button id="viewImageBtn" class="btn btn-primary btn-lg size-btn" role="button">
                 ดูรูป
              </button> -->
            </div>
          </div>
          <div class="col-lg-7 mt-4">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Item Code</label>
              <div class="col-sm-8">
                <input id="modalImageSearchItemCode" type="text" class="form-control" disabled autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-12">
            <!-- <table class="table mt-4">
              <thead>
                <tr>
                  <th class="text-center" width="10%">
                    <div>ลำดับ</div>
                  </th>
                  <th class="text-center" width="30%">
                    <div>ชื่อไฟล์</div>
                  </th>
                </tr>
              </thead>
              <tbody id="setModalFile"></tbody>
            </table> -->
            <div id="setModalFileNew"></div>
            <input id="selectImageDelete" class="d-none" type="text" autocomplete="off">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="detailModalImageAdd" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เพิ่มรายการ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Select File</label>
              <div class="col-sm-9">
              <form id="detailModalImageAddForm" method="POST" enctype="multipart/form-data"  >  @csrf
                  <div class="input-group">
                    <div class="custom-file">
                      <input id="modalFile" type="file" class="custom-file-input" name="image" required autocomplete="off">
                      <label class="custom-file-label" style="overflow: hidden; height: 34px; display: block; line-height: 23px;" for="modalFile"></label>
                    </div>
                  </div>
                  <input id="programCode" name="program_code" class="d-none" autocomplete="off">
                  <input id="webBatchNo" name="web_batch_no" class="d-none" autocomplete="off">
                  <button id="modalModalImageAddBtnHidden" type="submit" class="btn btn-success" hidden></button>
                  <small id="emailHelp" class="form-text text-muted">ไฟล์รูปภาพต้องไม่เกิดขนาด 5 MB.</small>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="text-right">
              <button id="modalModalImageAddBtn" type="button" class="btn btn-primary btn-lg size-btn">ตกลง</button>
              <button type="button" class="btn btn-danger btn-lg size-btn" data-dismiss="modal">ยกเลิก</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="detailModalImageView" tabindex="-1" role="dialog" data-backdrop="static">
  {{-- <div class="modal-dialog modal-dialog-scrollable" style="height: 100% !important;padding-top: 1% !important; width: 80% !important; max-width: 80% !important;" role="document"> --}}
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ดูรูป</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        <img id='setShowImageFileFn' class="w-100" alt="">
      </div>
    </div>
  </div>
</div>
