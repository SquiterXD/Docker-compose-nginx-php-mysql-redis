<div class="modal fade" id="detailAssetNumberLov" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Asset Number</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Asset Number</label>
              <div class="col-sm-8">
                <input id="modalAssetNumberSearchAssetNumber" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Description</label>
              <div class="col-sm-8">
                <input id="modalAssetNumberSearchDescription" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Serial Number</label>
              <div class="col-sm-8">
                <input id="modalAssetNumberSearchSerialNumber" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchAssetNumberLov" href="#" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
                <i class="fa fa-search"></i> ค้นหา
              </button>
            </div>
          </div>
          <div class="col-12">
            <div style="overflow-x:auto;">
              <table class="table mt-4">
                <thead>
                  <tr>
                    <th class="text-center" style="min-width: 250px;">
                      <div>Asset Number</div>
                    </th>
                    <th class="text-center" style="min-width: 300px;">
                      <div>Description</div>
                    </th>
                    <th class="text-center" style="min-width: 200px;">
                      <div>Serial Number</div>
                    </th>
                    <th class="text-center" style="min-width: 150px;">
                      <div>Parent</div>
                    </th>
                    <th class="text-center" style="min-width: 60px;">
                    </th>
                  </tr>
                </thead>
                <tbody id="setLovAssetNumber"></tbody>
              </table>
            </div>
            <table class="float-right">
              <tfoot>
                <tr>
                  <td colspan="10" class="footable-visible" id="setLovAssetNumberPagination">
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detailAssetNumberLovChild" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Asset Number</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <div style="overflow-x:auto;">
              <table class="table mt-4">
                <thead>
                  <tr>
                    <th class="text-center" style="min-width: 250px;">
                      <div>Asset Number</div>
                    </th>
                    <th class="text-center" style="min-width: 300px;">
                      <div>Description</div>
                    </th>
                  </tr>
                </thead>
                <tbody id="setLovAssetNumberChild"></tbody>
              </table>
            </div>
            <table class="float-right">
              <tfoot>
                <tr>
                <td colspan="10" class="footable-visible" id="setLovAssetNumberChildPagination">
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detailDepartmentLov" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="nameLovDepartment" class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">รหัสหน่วยงาน</label>
              <div class="col-sm-8">
                <input id="modalDepartmentSearchCode" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">ชื่อหน่วยงาน</label>
              <div class="col-sm-8">
                <input id="modalDepartmentSearchName" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchDepartmentLov" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
                <i class="fa fa-search"></i> ค้นหา
              </button>
            </div>
          </div>
          <div class="col-12">
            <div style="overflow-x:auto;">
              <table class="table mt-4">
                <thead>
                  <tr>
                    <th class="text-center" style="min-width: 150px;">
                      <div>รหัสหน่วยงาน</div>
                    </th>
                    <th class="text-center" style="min-width: 300px;">
                      <div>ชื่อหน่วยงาน</div>
                    </th>
                  </tr>
                </thead>
                <tbody id="setLovDepartment"></tbody>
              </table>
            </div>
            <table class="float-right">
              <tfoot>
                <tr>
                  <td colspan="10" class="footable-visible" id="setLovDepartmentPagination">
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detailAssetVNumberLov" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Asset Number</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Asset Number</label>
              <div class="col-sm-8">
                <input id="modalAssetVNumberSearchAssetVNumber" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">ชื่อเครื่องจักร/ชื่ออะไหล่</label>
              <div class="col-sm-8">
                <input id="modalAssetVNumberSearchDescription" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Serial Number</label>
              <div class="col-sm-8">
                <input id="modalAssetVNumberSearchSerialNumber" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchAssetVNumberLov" href="#" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
                <i class="fa fa-search"></i> ค้นหา
              </button>
            </div>
          </div>
          <div class="col-12">
            <div style="overflow-x:auto;">
              <table class="table mt-4">
                <thead>
                  <tr>
                    <th class="text-center" style="min-width: 250px;">
                      <div>Asset Number</div>
                    </th>
                    <th class="text-center" style="min-width: 300px;">
                      <div>Description</div>
                    </th>
                    <th class="text-center" style="min-width: 200px;">
                      <div>Serial Number</div>
                    </th>
                    <th class="text-center" style="min-width: 150px;">
                      <div>Parent</div>
                    </th>
                    <th class="text-center" style="min-width: 60px;">
                    </th>
                  </tr>
                </thead>
                <tbody id="setLovAssetVNumber"></tbody>
              </table>
            </div>
            <table class="float-right">
              <tfoot>
                <tr>
                  <td colspan="10" class="footable-visible" id="setLovAssetVNumberPagination">
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detailClassLov" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="nameWipClass" class="modal-title">Class</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Class Code</label>
              <div class="col-sm-8">
                <input id="modalClassSearchClassCode" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Description</label>
              <div class="col-sm-8">
                <input id="modalClassSearchClassName" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchClassLov" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
                <i class="fa fa-search"></i> ค้นหา
              </button>
            </div>
          </div>
          <div class="col-12">
            <div style="overflow-x:auto;">
              <table class="table mt-4">
                <thead>
                  <tr>
                    <th class="text-center" style="min-width: 150px;">
                      <div>Class Code</div>
                    </th>
                    <th class="text-center" style="min-width: 300px;">
                      <div>Description</div>
                    </th>
                  </tr>
                </thead>
                <tbody id="setLovClass"></tbody>
              </table>
            </div>
            <table class="float-right">
              <tfoot>
                <tr>
                  <td colspan="10" class="footable-visible" id="setLovClassPagination">
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detailAssetCategoryLov" data-backdrop="static" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Asset Category</h5>
        <button type="button" class="close" onclick="detailAssetCategoryLovCancle()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
          <form onsubmit="formDetailAssetCategoryLovConfirmHide();return false;">
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Asset Group<label class="pl-1 text-danger">*</label></label>
                <div class="col-sm-4">
                  <select id="detailAssetCategoryLovAssetGroup" class="form-control" required></select>
                </div>
                <div class="col-sm-4">
                  <input id="detailAssetCategoryLovAssetGroupDesc" type="text" class="form-control" autocomplete="off" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Asset Sub Group<label class="pl-1 text-danger">*</label></label>
                <div class="col-sm-4">
                  <select id="detailAssetCategoryLovAssetSubGroup" class="form-control" disabled required></select>
                </div>
                <div class="col-sm-4">
                  <input id="detailAssetCategoryLovAssetSubGroupDesc" type="text" class="form-control" autocomplete="off" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Brand<label class="pl-1 text-danger">*</label></label>
                <div class="col-sm-4">
                  <select id="detailAssetCategoryLovBrand" class="form-control" required></select>
                </div>
                <div class="col-sm-4">
                  <input id="detailAssetCategoryLovBrandDesc" type="text" class="form-control" autocomplete="off" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Machine Type<label class="pl-1 text-danger">*</label></label>
                <div class="col-sm-4">
                  <select id="detailAssetCategoryLovMachineType" class="form-control" required></select>
                </div>
                <div class="col-sm-4">
                  <input id="detailAssetCategoryLovMachineTypeDesc" type="text" class="form-control" autocomplete="off" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Series<label class="pl-1 text-danger">*</label></label>
                <div class="col-sm-4">
                  <select id="detailAssetCategoryLovSeries" class="form-control" required></select>
                </div>
                <div class="col-sm-4">
                  <input id="detailAssetCategoryLovSeriesDesc" type="text" class="form-control" autocomplete="off" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Sub Machine Type<label class="pl-1 text-danger">*</label></label>
                <div class="col-sm-4">
                  <select id="detailAssetCategoryLovSubMachineType" class="form-control" disabled required></select>
                </div>
                <div class="col-sm-4">
                  <input id="detailAssetCategoryLovSubMachineTypeDesc" type="text" class="form-control" autocomplete="off" disabled>
                </div>
              </div>
              <button id="detailAssetCategoryLovConfirmHide" class="d-none" ></button>
            </form>
          </div>
          <div class="col-lg-12">
            <div class="text-right">
              <button id="detailAssetCategoryLovConfirm" class="btn btn-primary btn-lg size-btn" role="button">
                ตกลง
              </button>
              <button onclick="detailAssetCategoryLovCancle()" class="btn btn-danger btn-lg size-btn" role="button">
                ยกเลิก
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detailAreaLov" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Area</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">code</label>
              <div class="col-sm-8">
                <input id="modalAreaSearchAreaCode" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">description</label>
              <div class="col-sm-8">
                <input id="modalAreaSearchAreaName" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchAreaLov" class="btn btn-default btn-lg size-btn" role="button" aria-pressed="true">
                <i class="fa fa-search"></i> ค้นหา
              </button>
            </div>
          </div>
          <div class="col-12">
            <div style="overflow-x:auto;">
              <table class="table mt-4">
                <thead>
                  <tr>
                    <th class="text-center" style="min-width: 150px;">
                      <div>code</div>
                    </th>
                    <th class="text-center" style="min-width: 300px;">
                      <div>description</div>
                    </th>
                  </tr>
                </thead>
                <tbody id="setLovArea"></tbody>
              </table>
            </div>
            <table class="float-right">
              <tfoot>
                <tr>
                  <td colspan="10" class="footable-visible" id="setLovAreaPagination">
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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
            </div>
          </div>
          <div class="col-lg-7 mt-4">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Asset Number</label>
              <div class="col-sm-8">
                <input  id="modalImageSearchAssetNumber" 
                        type="text" 
                        class="form-control" 
                        autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7 mt-4">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Asset Description</label>
              <div class="col-sm-8">
                <input  id="modalImageSearchAssetDescription" 
                        type="text" 
                        class="form-control"                      
                        autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-12">
            <table class="table mt-4">
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
            </table>
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
              <form id="detailModalImageAddForm" method="POST" enctype="multipart/form-data">  @csrf
                  <div class="input-group">
                    <div class="custom-file">
                      <input  id="modalFile" 
                              type="file" 
                              class="custom-file-input" 
                              name="image" 
                              required 
                              autocomplete="off">
                      <label  class="custom-file-label" 
                              style="overflow: hidden; height: 34px; display: block; line-height: 23px;" 
                              for="modalFile">
                      </label>
                    </div>
                  </div>
                  <input  id="programCode" 
                          name="program_code" 
                          class="d-none" 
                          autocomplete="off">
                  <input  id="webBatchNo" 
                          name="web_batch_no" 
                          class="d-none" 
                          autocomplete="off">
                  <button id="modalModalImageAddBtnHidden" 
                          type="submit" 
                          class="btn btn-success" 
                          hidden></button>
                  <small  id="emailHelp" 
                          class="form-text text-muted">ไฟล์รูปภาพต้องไม่เกิดขนาด 5 MB.</small>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="text-right">
              <button id="modalModalImageAddBtn" 
                      type="button" 
                      class="btn btn-primary btn-lg size-btn">ตกลง</button>
              <button type="button" 
                      class="btn btn-danger btn-lg size-btn" 
                      data-dismiss="modal">ยกเลิก</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detailModalImageView" tabindex="-1" role="dialog" data-backdrop="static">
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

