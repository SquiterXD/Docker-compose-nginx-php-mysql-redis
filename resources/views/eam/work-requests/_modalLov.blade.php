<div class="modal fade" id="detailReportWorkOrder" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">พิมพ์รายงาน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
<form action="{{ route('eam.ajax.work-requests.report') }}" target="_blank" method="GET" class="w-100">
          <div class="col-11 mb-3">
            <h4>Parameter</h4>
          </div>
          <div class="col-lg-12">
            <div class="form-group row justify-content-center">
              <label class="col-sm-3 col-form-label">เลขที่ใบสั่งงาน ตั้งแต่</label>
              <div class="col-sm-4">
                <input  id="modalWReportWorkOrderWorkOrderNumberStart" 
                        name="p_work_request_number" 
                        type="text" 
                        class="form-control" 
                        autocomplete="off">
              </div>
              <div class="col-sm-4"></div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-sm-3 col-form-label">เลขที่ใบสั่งงาน ถึง</label>
              <div class="col-sm-4">
                <input  id="modalWReportWorkOrderWorkOrderNumberEnd" 
                        name="p_work_request_number_to" 
                        type="text" 
                        class="form-control" 
                        autocomplete="off">
              </div>
              <div class="col-sm-4"></div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-sm-3 col-form-label">วันที่แจ้งซ่อม ตั้งแต่</label>
              <div class="col-sm-4">
                <input  id="modalReportWorkOrderDateStart" 
                        type="text" 
                        class="form-control" 
                        autocomplete="off">
              </div>
              <div class="col-sm-4"></div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-sm-3 col-form-label">วันที่แจ้งซ่อม ถึง</label>
              <div class="col-sm-4">
                <input  id="modalReportWorkOrderDateEnd" type="text" class="form-control" autocomplete="off">
              </div>
              <div class="col-sm-4"></div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-sm-3 col-form-label">Asset Number</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <select id="modalReportWorkOrderAssetNumber" 
                          name="p_asset_number" 
                          class="form-control clearable" 
                          data-server="/eam/ajax/lov/assetnumber"  
                          data-id="asset_number" 
                          data-text="description" 
                          data-field="select">
                  </select>
                  <div class="input-group-append">
                    <span class="input-group-append">
                      <button id="modalReportWorkOrderAssetNumberBtn" 
                              type="button" 
                              class="btn btn-default">
                              <i class="fa fa-search"></i>
                      </button>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-sm-4"></div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-sm-3 col-form-label">สถานะของใบสั่งงาน</label>
              <div class="col-sm-4">
                <select id="modalReportWorkOrderStatus" 
                        name="p_work_request_status_code" 
                        class="form-control">
                </select>
                <input  id="modalReportWorkOrderStatusDesc" 
                        name="p_work_request_status_desc" 
                        class="d-none" 
                        type="text">
              </div>
              <div class="col-sm-4"></div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-sm-3 col-form-label">หน่วยงานผู้แจ้ง</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <select id="modalReportWorkOrderReportingAgency" 
                          name="p_owning_dept_code" 
                          class="form-control clearable" 
                          data-server="/eam/ajax/lov/departments"
                          data-id="department_code" 
                          data-text="description"
                          data-field="select"
                          data-setAjaxModalReportWorkOrderReportingAgencyInEAM0007="modalReportWorkOrderReportingAgency"
                          data-setAjaxModalReportWorkOrderReportingAgencyInEAM0007Desc="modalReportWorkOrderReportingAgencyDesc"
                          data-typeModalReportWorkOrderReportingAgencyInEAM0007="modalReportWorkOrderReportingAgency">
                  </select>
                  <div class="input-group-append">
                    <span class="input-group-append">
                      <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้แจ้ง', idDepartmentModal: 'modalReportWorkOrderReportingAgency', desc: true, inModal: true})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </span>
                  </div>
                </div>
              </div>
              <label class="col-form-label">&nbsp;</label>
              <div class="col-sm-4">
                <input id="modalReportWorkOrderReportingAgencyDesc" type="text" class="form-control" disabled autocomplete="off">
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label class="col-sm-3 col-form-label">หน่วยงานผู้รับแจ้ง</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <select id="modalReportWorkOrderNotifyingAgency" 
                          name="p_receiving_dept_code" 
                          class="form-control clearable" 
                          data-server="/eam/ajax/lov/departments"
                          data-id="department_code" 
                          data-text="description"
                          data-field="select"
                          data-setAjaxModalReportWorkOrderNotifyingAgencyInEAM0007="modalReportWorkOrderNotifyingAgency"
                          data-setAjaxModalReportWorkOrderNotifyingAgencyInEAM0007Desc="modalReportWorkOrderNotifyingAgencyDesc"
                          data-typeModalReportWorkOrderNotifyingAgencyInEAM0007="modalReportWorkOrderNotifyingAgency">
                  </select>
                  <div class="input-group-append">
                    <span class="input-group-append">
                      <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: 'modalReportWorkOrderNotifyingAgency', desc: true, inModal: true})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </span>
                  </div>
                </div>
              </div>
              <label class="col-form-label">&nbsp;</label>
              <div class="col-sm-4">
                <input  id="modalReportWorkOrderNotifyingAgencyDesc" 
                        type="text" 
                        class="form-control" 
                        disabled 
                        autocomplete="off">
              </div>
            </div>
          </div>
          <button id="printBtnHide" 
                  class="d-none"    ></button>
</form>
          <div class="col-lg-11">
            <div class="text-right">
              <button id="modalReportWorkOrderPrint" class="btn btn-primary btn-lg size-btn mt-1" role="button" aria-pressed="true">
                พิมพ์
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detailWorkOrderNumberLov" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เลขที่ใบสั่งงาน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">เลขที่ใบสั่งงาน</label>
              <div class="col-sm-8">
                <input  id="modalWorkOrderNumberSearchWorkOrderNumber" 
                        type="text" 
                        class="form-control" 
                        autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchWorkOrderNumberLov" 
                      class="btn btn-default btn-lg size-btn mt-1" 
                      role="button">
                <i class="fa fa-search"></i> ค้นหา
              </button>
            </div>
          </div>
          <div class="col-12">
            <div style="overflow-x:auto;">
              <table class="table mt-4">
                <thead>
                  <tr>
                    <th class="text-center" style="min-width: 130px;">
                      <div>เลขที่ใบสั่งงาน</div>
                    </th>
                    <th class="text-center" style="min-width: 150px;">
                      <div>ประเภทของใบสั่งงาน</div>
                    </th>
                    <th class="text-center" style="min-width: 200px;">
                      <div>สถานะใบสั่งงาน</div>
                    </th>
                    <th class="text-center" style="min-width: 250px;">
                      <div>ชื่อเครื่องจักร</div>
                    </th>
                    <th class="text-center" style="min-width: 300px;">
                      <div>คำอธิบายใบสั่งงาน</div>
                    </th>
                    <th class="text-center" style="min-width: 130px;">
                      <div>วันที่แจ้งซ่อม</div>
                    </th>
                    <th class="text-center" style="min-width: 200px;">
                      <div>ผู้แจ้งซ่อม</div>
                    </th>
                    <th class="text-center" style="min-width: 250px;">
                      <div>หน่วยงานผู้แจ้ง</div>
                    </th>
                    <th class="text-center" style="min-width: 130px;">
                      <div>เลขที่ใบรับงาน</div>
                    </th>
                  </tr>
                </thead>
                <tbody id="setLovWorkOrderNumber"></tbody>
              </table>
            </div>
            <table class="float-right">
              <tfoot>
                <tr>
                  <td colspan="10" class="footable-visible" id="setLovWorkOrderNumberPagination">
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

<div class="modal fade" id="detailAssetNumberLov" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Asset Number</h5>
        <button type="button" 
                class="close" 
                data-dismiss="modal" 
                aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Asset Number</label>
              <div class="col-sm-8">
                <input  id="modalAssetNumberSearchAssetNumber" 
                        type="text" 
                        class="form-control" 
                        autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Description</label>
              <div class="col-sm-8">
                <input  id="modalAssetNumberSearchDescription" 
                        type="text" 
                        class="form-control" 
                        autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Serial Number</label>
              <div class="col-sm-8">
                <input  id="modalAssetNumberSearchSerialNumber" 
                        type="text" 
                        class="form-control" 
                        autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchAssetNumberLov" 
                      href="#" 
                      class="btn btn-default btn-lg size-btn mt-1" 
                      attr-filter-dept-by-auth="1" 
                      role="button" 
                      aria-pressed="true">
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
                <input  id="modalDepartmentSearchCode" 
                        type="text" 
                        class="form-control" 
                        autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">ชื่อหน่วยงาน</label>
              <div class="col-sm-8">
                <input  id="modalDepartmentSearchName" 
                        type="text" 
                        class="form-control" 
                        autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchDepartmentLov"
                      class="btn btn-default btn-lg size-btn mt-1" 
                      role="button" 
                      aria-pressed="true">
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

{{-- <div class="modal fade" id="detailEmployeeLov" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="nameLovEmployee" class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">รหัสพนักงาน</label>
              <div class="col-sm-8">
                <input  id="modalEmployeeSearchEmpCode" 
                        type="text" 
                        class="form-control" 
                        autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">ชื่อพนักงาน</label>
              <div class="col-sm-8">
                <input  id="modalEmployeeSearchEmpName" 
                        type="text" 
                        class="form-control" 
                        autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchEmployeeLov" 
                      class="btn btn-default btn-lg size-btn mt-1" 
                      role="button" 
                      aria-pressed="true">
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
                      <div>รหัสพนักงาน</div>
                    </th>
                    <th class="text-center" style="min-width: 300px;">
                      <div>ชื่อพนักงาน</div>
                    </th>
                  </tr>
                </thead>
                <tbody id="setLovEmployee"></tbody>
              </table>
            </div>
            <table class="float-right">
              <tfoot>
                <tr>
                  <td colspan="10" class="footable-visible" id="setLovEmployeePagination">
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> --}}

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
              <button id="addImageBtn" class="btn btn-success btn-lg size-btn mt-1" role="button">
                <i class="fa fa-plus"></i> เพิ่มรายการ
            </div>
          </div>
          <div class="col-lg-7 mt-4">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">เลขที่ใบสั่งงาน</label>
              <div class="col-sm-8">
                <input id="modalImageSearchWorkOrderNumber" type="text" class="form-control" disabled autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-12">
            <div style="overflow-x:auto;">
              <div id="setModalFileNew"></div>
            </div>
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
                      <input  id="modalFile" 
                              type="file" 
                              class="custom-file-input" 
                              multiple name="image" 
                              required 
                              autocomplete="off">
                      <label  class="custom-file-label" 
                              style="overflow: hidden; height: 34px; display: block; line-height: 23px;" 
                              for="modalFile">
                      </label>
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
              <button id="modalModalImageAddBtn" type="button" class="btn btn-primary btn-lg size-btn mt-1">ตกลง</button>
              <button type="button" class="btn btn-danger btn-lg size-btn mt-1" data-dismiss="modal">ยกเลิก</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detailModalImageView" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
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

<div class="modal fade" id="detailEmployeeWebLov" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="nameLovEmployeeWeb" class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">ชื่อพนักงาน</label>
              <div class="col-sm-8">
                <input id="modalEmployeeWebSearchEmpName" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchEmployeeWebLov" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
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
                      <div>รหัสพนักงาน</div>
                    </th>
                    <th class="text-center" style="min-width: 300px;">
                      <div>ชื่อพนักงาน</div>
                    </th>
                  </tr>
                </thead>
                <tbody id="setLovEmployeeWeb"></tbody>
              </table>
            </div>
            <table class="float-right">
              <tfoot>
                <tr>
                  <td colspan="10" class="footable-visible" id="setLovEmployeeWebPagination">
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
