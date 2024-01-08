<div class="modal fade" id="detailReportBillMaterials" role="dialog" data-backdrop="static">
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
          <form action="{{ route('eam.ajax.bill-materials.report') }}" target="_blank" method="GET" class="w-100">
            <div class="col-11 mb-3">
              <h4>Parameter</h4>
            </div>
            <div class="col-lg-12">
              <div class="form-group row justify-content-center">
                <label class="col-sm-3 col-form-label">เลขที่เบิกอะไหล่ ตั้งแต่</label>
                <div class="col-sm-4">
                  <input id="modalReportBillMaterialsNumberStart" name="request_equip_no" type="text" class="form-control" autocomplete="off">
                </div>
                <div class="col-sm-4"></div>
              </div>
              <div class="form-group row justify-content-center">
                <label class="col-sm-3 col-form-label">เลขที่เบิกอะไหล่ ถึง</label>
                <div class="col-sm-4">
                  <input id="modalReportBillMaterialsNumberEnd" name="request_equip_no_to" type="text" class="form-control" autocomplete="off">
                </div>
                <div class="col-sm-4"></div>
              </div>
              <div class="form-group row justify-content-center">
                <label class="col-sm-3 col-form-label">วันที่เบิกอะไหล่ ตั้งแต่</label>
                <div class="col-sm-4">
                  <input id="modalReportBillMaterialsDateStart" type="text" class="form-control" autocomplete="off">
                </div>
                <div class="col-sm-4"></div>
              </div>
              <div class="form-group row justify-content-center">
                <label class="col-sm-3 col-form-label">วันที่เบิกอะไหล่ ถึง</label>
                <div class="col-sm-4">
                  <input id="modalReportBillMaterialsDateEnd" type="text" class="form-control" autocomplete="off">
                </div>
                <div class="col-sm-4"></div>
              </div>
              <div class="form-group row justify-content-center">
                <label class="col-sm-3 col-form-label">สถานะของใบเบิกอะไหล่</label>
                <div class="col-sm-4">
                  <div class="input-group">
                    {{-- <input id="modalReportBillMaterialsRequestStatus" name="request_status" type="text" class="form-control clearable" readonly autocomplete="off"> --}}
                    <select id="modalReportBillMaterialsRequestStatus" 
                            class="form-control clearable" 
                            name="request_status"
                            data-server="/eam/ajax/lov/request-status-list"  
                            data-id="lookup_code" 
                            data-text="description" 
                            data-field="select"        
                            data-setAjaxEAM0017ModalReportBillMaterialsRequestStatus="modalReportBillMaterialsRequestStatus"
                            data-setAjaxEAM0017ModalReportBillMaterialsRequestStatusDesc="modalReportBillMaterialsRequestStatusDesc"
                            data-typeAjaxEAM0017ModalReportBillMaterialsRequestStatus="modalReportBillMaterialsRequestStatus">
                    </select>
                    <div class="input-group-append">
                      <span class="input-group-append">
                        <button onclick="requestStatusLovBtnOnclick({nameModal: 'สถานะของใบเบิกอะไหล่', idModal: 'modalReportBillMaterialsRequestStatus', desc: true, inModal: true})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                      </span>
                    </div>
                  </div>
                </div>
                <label class="col-form-label">&nbsp;</label>
                <div class="col-sm-4">
                  <input id="modalReportBillMaterialsRequestStatusDesc" type="text" class="form-control" disabled autocomplete="off">
                </div>
              </div>
              <div class="form-group row justify-content-center">
                <label class="col-sm-3 col-form-label">หน่วยงานขอเบิก</label>
                <div class="col-sm-4">
                  <div class="input-group">
                    {{-- <input id="modalReportBillMaterialsAgency" name="department_code" type="text" class="form-control clearable" name="work_request_number" readonly autocomplete="off"> --}}
                    <select id="modalReportBillMaterialsAgency" 
                            class="form-control clearable"
                            name="department_code"
                            name="work_request_number"
                            data-server="/eam/ajax/lov/departments"  
                            data-id="department_code" 
                            data-text="description" 
                            data-field="select"
                            data-setAjaxEAM0017ModalReportBillMaterialsAgency="modalReportBillMaterialsAgency"
                            data-setAjaxEAM0017ModalReportBillMaterialsAgencyDesc="modalReportBillMaterialsAgencyDesc"
                            data-typeAjaxEAM0017ModalReportBillMaterialsAgency="modalReportBillMaterialsAgency">
                    </select>
                    <div class="input-group-append">
                      <span class="input-group-append">
                        <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานขอเบิก', idDepartmentModal: 'modalReportBillMaterialsAgency', desc: true, inModal: true})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                      </span>
                    </div>
                  </div>
                </div>
                <label class="col-form-label">&nbsp;</label>
                <div class="col-sm-4">
                  <input id="modalReportBillMaterialsAgencyDesc" type="text" class="form-control" disabled autocomplete="off">
                </div>
              </div>
            </div>
            <button id="printBtnHide" class="d-none" ></button>
          </form>
          <div class="col-lg-11">
            <div class="text-right">
              <button id="modalRequestStatusPrint" class="btn btn-primary btn-lg size-btn mt-1" role="button" aria-pressed="true">
                พิมพ์
              </button>
            </div>
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
              <button id="modalSearchAssetNumberLov" href="#" class="btn btn-primary btn-lg size-btn mt-1" role="button" aria-pressed="true">
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

<div class="modal fade" id="detailRequestEquipNoLov" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เลขที่ใบขอเบิกอะไหล่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">เลขที่ใบเบิก</label>
              <div class="col-sm-8">
                <input id="modalRequestEquipNoSearchCode" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchRequestEquipNoLov" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
                <i class="fa fa-search"></i> ค้นหา
              </button>
            </div>
          </div>
          <div class="col-12">
            <div style="overflow-x:auto;">
              <table class="table mt-4">
                <thead>
                  <tr>
                    <th class="text-center" style="min-width: 200px;">
                      <div>เลขที่ใบเบิก</div>
                    </th>
                    <th class="text-center" style="min-width: 200px;">
                      <div>สถานะ</div>
                    </th>
                  </tr>
                </thead>
                <tbody id="setLovRequestEquipNo"></tbody>
              </table>
            </div>
            <table class="float-right">
              <tfoot>
                <tr>
                  <td colspan="10" class="footable-visible" id="setLovRequestEquipNoPagination">
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

<div class="modal fade" id="detailRequestStatusLov" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
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
          <div class="col-12">
            <div style="overflow-x:auto;">
              <table class="table mt-4">
                <thead>
                  <tr>
                    <th class="text-center" style="min-width: 150px;">
                      <div>รหัสสถานะ</div>
                    </th>
                    <th class="text-center" style="min-width: 300px;">
                      <div>สถานะ</div>
                    </th>
                  </tr>
                </thead>
                <tbody id="setLovRequestStatus"></tbody>
              </table>
            </div>
            <table class="float-right">
              <tfoot>
                <tr>
                  <td colspan="10" class="footable-visible" id="setLovRequestStatusPagination">
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

<div class="modal fade" id="detailWorkReceiptNumberLov" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="nameWorkReceiptNumber" class="modal-title">เลขที่ใบรับงาน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">ใบรับงาน</label>
              <div class="col-sm-8">
                <input id="modalWorkReceiptNumberSearchWorkReceiptNumber" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchWorkReceiptNumberLov" class="btn btn-default btn-lg size-btn" role="button">
                <i class="fa fa-search"></i> ค้นหา
              </button>
            </div>
          </div>
          <div class="col-12" style="overflow-x:scroll;">
            <table class="table mt-4" >
              <thead>
                <tr>
                  <th class="text-center" style="min-width: 150px;" width="150px">
                    <div>เลขที่ใบรับงาน</div>
                  </th>
                  <th class="text-center" style="min-width: 150px;"  width="150px">
                    <div>ประเภทของใบรับงาน</div>
                  </th>
                  <th class="text-center" style="min-width: 160px;"  width="160px">
                    <div>ชื่อเครื่องจักร (Number)</div>
                  </th>
                  <th class="text-center" style="min-width: 150px;"  width="150px">
                    <div>คำอธิบายใบสั่งงาน</div>
                  </th>
                  <th class="text-center" style="min-width: 150px;"  width="150px">
                    <div>ประมาณวันที่เริ่มซ่อม</div>
                  </th>
                  <th class="text-center" style="min-width: 150px;"  width="150px">
                    <div>ประมาณวันที่ซ่อมเสร็จ</div>
                  </th>
                  <th class="text-center" style="min-width: 150px;"  width="150px">
                    <div>เลขที่ใบสั่งงาน</div>
                  </th>
                  <th class="text-center"  style="min-width: 150px;" width="150px">
                    <div>สถานะการตัดใช้อะไหล่</div>
                  </th>
                  <th class="text-center" style="min-width: 150px;"  width="150px">
                    <div>สถานะการบันทึกค่าแรง</div>
                  </th>
                  <th class="text-center" style="min-width: 165px;"  width="165px">
                    <div>สถานะการ Complete งาน</div>
                  </th>
                </tr>
              </thead>
              <tbody id="setLovWorkReceiptNumber"></tbody>
            </table>
          </div>
          <div class="col-12">
            <table class="float-right">
              <tfoot>
                <tr>
                  <td colspan="10" class="footable-visible" id="setLovWorkReceiptNumberPagination">
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

<div class="modal fade" id="detailWorkOrderNumberLov" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="nameWorkOrderNumber" class="modal-title"></h5>
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
                <input id="modalWorkOrderNumberSearchWorkOrderNumber" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchWorkOrderNumberLov" class="btn btn-default btn-lg size-btn mt-1" role="button">
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

<div class="modal fade" id="detailEmployeeLov" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
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
                <input id="modalEmployeeSearchEmpCode" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">ชื่อพนักงาน</label>
              <div class="col-sm-8">
                <input id="modalEmployeeSearchEmpName" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchEmployeeLov" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
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
</div>

<div class="modal fade" id="detailItemCodeLov" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="nameLovItemCode" class="modal-title">Item Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Item Code</label>
              <div class="col-sm-8">
                <input id="modalItemCodeSearchItemCode" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Item Description</label>
              <div class="col-sm-8">
                <input id="modalItemCodeSearchItemDescription" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Part Number</label>
              <div class="col-sm-8">
                <input id="modalItemCodeSearchItemPartNumber" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Old Item Number</label>
              <div class="col-sm-8">
                <input id="modalItemCodeSearchOldItemNumber" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Part Number Old</label>
              <div class="col-sm-8">
                <input id="modalItemCodeSearchPartNumberOld" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Machine 01</label>
              <div class="col-sm-8">
                <input id="modalItemCodeSearchMachine01" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Machine 02</label>
              <div class="col-sm-8">
                <input id="modalItemCodeSearchMachine02" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="text-right">
              <button id="modalSearchItemCodeLov" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
                <i class="fa fa-search"></i> ค้นหา
              </button>
            </div>
          </div>
          <div class="col-12"><h4>Item Master</h4></div>
          <div class="col-12">
            <div style="overflow-x:auto;">
              <table class="table mt-4">
                <thead>
                  <tr>
                    <th class="text-center" style="min-width: 150px;">
                      <div>Item Code</div>
                    </th>
                    <th class="text-center" style="min-width: 250px;">
                      <div>Item Description</div>
                    </th>
                    <th class="text-center" style="min-width: 150px;">
                      <div>Part Number</div>
                    </th>
                    <th class="text-center" style="min-width: 150px;">
                      <div>Old Item Number</div>
                    </th>
                    <th class="text-center" style="min-width: 150px;">
                      <div>Part Number Old</div>
                    </th>
                    <th class="text-center" style="min-width: 150px;">
                      <div>Machine 01</div>
                    </th>
                    <th class="text-center" style="min-width: 150px;">
                      <div>Machine 02</div>
                    </th>
                  </tr>
                </thead>
                <tbody id="setLovItemCode"></tbody>
              </table>
            </div>
            <table class="float-right">
              <tfoot>
                <tr>
                  <td colspan="10" class="footable-visible" id="setLovItemCodePagination">
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

<div class="modal fade" id="detailEmployeeWebLov" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
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
                        <!-- <div class="form-group row">
              <label class="col-sm-4 col-form-label">รหัสพนักงาน</label>
              <div class="col-sm-8">
                <input id="modalEmployeeWebSearchEmpCode" type="text" class="form-control" autocomplete="off">
              </div>
            </div> -->
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">ชื่อพนักงาน</label>
                            <div class="col-sm-8">
                                <input id="modalEmployeeWebSearchEmpName" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="text-right">
                            <button id="modalSearchEmployeeWebLov" class="btn btn-default btn-lg size-btn mt-1"
                                role="button" aria-pressed="true">
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

