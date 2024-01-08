@if ($checkAttrId == 'billMaterials')
<div id="billMaterials" class="row justify-content-center">
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">เลขที่ใบขอเบิกอะไหล่</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="requestEquipNo" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/request-equip-no"  
                  data-id="request_equip_no" 
                  data-field="select"
                  required
                  data-setAjaxEAM0017RequestEquipNo="requestEquipNo"
                  data-typeAjaxEAM0017RequestEquipNo="requestEquipNo">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="requestEquipNoLovBtn" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงาน<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="requestDepartment" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"  
                  data-id="department_code" 
                  data-text="description" 
                  data-field="select"
                  required
                  disabled>
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานแจ้งซ่อม', idDepartmentModal: 'requestDepartment', desc: false, inModal: false})" 
                      type="button" 
                      class="btn btn-default"
                      id="departmentLovBtn"
                      disabled>
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">โอนไปยังคลัง<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="subinventory" class="form-control" required disabled></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">โอนไปยังสถานที่จัดเก็บ<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="locator" class="form-control" required disabled></select>
      </div>
    </div>
  </div>
  <div class="col-lg-1"></div>
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะใบเบิกอะไหล่<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <input type="text" id="requestStatus" class="form-control" required disabled>
      </div>
    </div>
  </div>
</div>
@elseif ($checkAttrId == 'summaryMonth')
<div id="summaryMonth" class="row justify-content-center">
  <form id="modalReportSummaryMonthPrintAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่เริ่มซ่อมตั้งแต่</label>
        <div class="col-sm-4">
          <input id="modalReportSummaryMonthDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่เริ่มซ่อมถึง</label>
        <div class="col-sm-4">
          <input id="modalReportSummaryMonthDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานแจ้งซ่อม</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="modalReportSummaryMonthInformDept" 
                    name="inform_dept_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select"
                    data-setAjaxReportSummaryMonthInformDeptDesc="modalReportSummaryMonthInformDeptDesc"
                    data-setAjaxReportSummaryMonthInformDept="modalReportSummaryMonthInformDept"
                    data-typeAjaxReportSummaryMonthInformDept="modalReportSummaryMonthInformDept">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานแจ้งซ่อม', idDepartmentModal: 'modalReportSummaryMonthInformDept', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
          <input id="modalReportSummaryMonthInformDeptDesc" type="text" class="form-control" name="p_owning_department_desc" disabled autocomplete="off">
        </div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานรับงานซ่อม</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="modalReportSummaryMonthOwningDepartment" 
                    name="owning_department_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select"
                    data-setAjaxReportSummaryMonthOwningDepartmentDesc="modalReportSummaryMonthOwningDepartmentDesc"
                    data-setAjaxReportSummaryMonthOwningDepartment="modalReportSummaryMonthOwningDepartment"
                    data-typeAjaxReportSummaryMonthOwningDepartment="modalReportSummaryMonthOwningDepartment">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานรับงานซ่อม', idDepartmentModal: 'modalReportSummaryMonthOwningDepartment', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
          <input id="modalReportSummaryMonthOwningDepartmentDesc" type="text" class="form-control" name="p_owning_department_desc" disabled autocomplete="off">
        </div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">สถานะใบรับงาน</label>
        <div class="col-sm-4">
          <select id="modalReportSummaryMonthStatus"  class="form-control" name="status_type" ></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ประเภทใบรับงาน</label>
        <div class="col-sm-4">
          <select id="modalReportSummaryMonthType"  class="form-control" name="work_order_type_id" ></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ผู้รับงาน</label>
        <div class="col-sm-4">
          <div class="input-group">
            <input  id="modalReportSummaryEmployeeDesc" 
                    type="text" 
                    hidden 
                    class="form-control" 
                    name="employee_desc" 
                    autocomplete="off">
            <select id="modalReportSummaryEmployee" 
                    name="employee_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/web-user"  
                    data-id="username" 
                    data-text="name" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button id="modalReportSummaryEmployeeBtn" 
                        onclick="employeeWebLovBtnOnclick({nameEmployeeWebModal: 'ผู้รับแจ้ง', idEmployeeWebModal: 'modalReportSummaryEmployee', desc: false, inModal: false, idWebCode: 'notifyingAgency'})" 
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
    </div>
    <button id="modalReportSummaryMonthPrintHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'issueMatExcel')
<div id="issueMatExcel" class="row">
  <form id="reportIssueMatExcelAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงาน ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="reportIssueMatExcelWorkReceiptNumber" 
                    name="job_no_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'reportIssueMatExcelWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
             </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงาน ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="reportIssueMatExcelWorkReceiptNumberTo" 
                    name="job_no_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'reportIssueMatExcelWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
             </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ประเภทใบรับงาน</label>
        <div class="col-sm-4">
          <select id="reportIssueMatExcelType"  class="form-control" name="" ></select>
          <input id="reportIssueMatExcelTypeHide" type="text" hidden class="form-control" name="work_order_type_desc" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ทำรายการ ตั้งแต่</label>
        <div class="col-sm-4">
          <input id="reportIssueMatExcelDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ทำรายการ ถึง</label>
        <div class="col-sm-4">
          <input id="reportIssueMatExcelDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="reportIssueMatExcelAssetNumber" 
                    name="asset_no_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'reportIssueMatExcelAssetNumber'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="reportIssueMatExcelAssetNumberTo" 
                    name="asset_no_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'reportIssueMatExcelAssetNumberTo'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="reportIssueMatExcelHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'payable')
<div id="payable" class="row justify-content-center">
  <form id="payablePrintAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ตั้งแต่วันที่<label class="pl-1 text-danger">*</label></label>
        <div class="col-sm-4">
          <input id="payableDateStart" type="text" class="form-control dateTable" required autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ถึงวันที่<label class="pl-1 text-danger">*</label></label>
        <div class="col-sm-4">
          <input id="payableDateEnd" type="text" class="form-control dateTable" required autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อมตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="payableWorkReceiptNumber" 
                    name="p_wip_entity_name" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'payableWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
             </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ถึงเลขที่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="payableWorkReceiptNumberTo" 
                    name="p_wip_entity_name_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'payableWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
             </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ประเภทใบรับงาน<label class="pl-1 text-danger">*</label></label>
        <div class="col-sm-4">
          <select id="payableType"  class="form-control" name="p_work_order_type" required></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="payablePrintHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'closedWo')
<div id="closedWo" class="row">
  <form id="closedWoBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงาน ตั้งแต่<label class="pl-1 text-danger">*</label></label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="closedWoWorkReceiptNumber" 
                    name="wip_entity_name_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'closedWoWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงาน ถึง<label class="pl-1 text-danger">*</label></label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="closedWoWorkReceiptNumberTo" 
                    name="wip_entity_name_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'closedWoWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">กลุ่มเครื่องจักร</label>
        <div class="col-sm-4">
          <select id="machineGroup" class="form-control"  name="asset_group_desc"></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="closedWoAssetNumber" 
                    name="asset_number" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'closedWoAssetNumber'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่คาดว่าจะเริ่มซ่อม ตั้งแต่</label>
        <div class="col-sm-4">
          <input id="closedWoScheduledStartDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่คาดว่าจะเริ่มซ่อม ถึง</label>
        <div class="col-sm-4">
          <input id="closedWoScheduledStartDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่เริ่มซ่อมจริง ตั้งแต่</label>
        <div class="col-sm-4">
          <input id="closedWoActualStartDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่เริ่มซ่อมจริง ถึง</label>
        <div class="col-sm-4">
          <input id="closedWoActualStartDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่คาดว่าจะซ่อมเสร็จ ตั้งแต่</label>
        <div class="col-sm-4">
          <input id="closedWoScheduledEndDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่คาดว่าจะซ่อมเสร็จ ถึง</label>
        <div class="col-sm-4">
          <input id="closedWoScheduledEndDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ซ่อมเสร็จจริง ตั้งแต่</label>
        <div class="col-sm-4">
          <input id="closedWoActualEndDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ซ่อมเสร็จจริง ถึง</label>
        <div class="col-sm-4">
          <input id="closedWoActualEndDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานผู้รับแจ้ง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="closedWoNotifyingAgency" 
                    name="owning_department_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: 'closedWoNotifyingAgency', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="closedWoBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'closedWoJp')
<div id="closedWoJp" class="row">
  <form id="closedWoJpBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงาน ตั้งแต่<label class="pl-1 text-danger">*</label></label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="closedWoJpWorkReceiptNumber" 
                    name="p_wip_entity_name" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'closedWoJpWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
             </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงาน ถึง<label class="pl-1 text-danger">*</label></label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="closedWoJpWorkReceiptNumberTo" 
                    name="p_wip_entity_name_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'closedWoJpWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">กลุ่มเครื่องจักร</label>
        <div class="col-sm-4">
          <select id="machineGroup" class="form-control"  name="p_asset_group_desc"></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="closedWoJpAssetNumber" 
                    name="p_asset_number" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'closedWoJpAssetNumber'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่คาดว่าจะเริ่มซ่อม ตั้งแต่</label>
        <div class="col-sm-4">
          <input id="closedWoJpScheduledStartDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่คาดว่าจะเริ่มซ่อม ถึง</label>
        <div class="col-sm-4">
          <input id="closedWoJpScheduledStartDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่เริ่มซ่อมจริง ตั้งแต่</label>
        <div class="col-sm-4">
          <input id="closedWoJpActualStartDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่เริ่มซ่อมจริง ถึง</label>
        <div class="col-sm-4">
          <input id="closedWoJpActualStartDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่คาดว่าจะซ่อมเสร็จ ตั้งแต่</label>
        <div class="col-sm-4">
          <input id="closedWoJpScheduledEndDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่คาดว่าจะซ่อมเสร็จ ถึง</label>
        <div class="col-sm-4">
          <input id="closedWoJpScheduledEndDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ซ่อมเสร็จจริง ตั้งแต่</label>
        <div class="col-sm-4">
          <input id="closedWoJpActualEndDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ซ่อมเสร็จจริง ถึง</label>
        <div class="col-sm-4">
          <input id="closedWoJpActualEndDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานผู้รับแจ้ง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="closedWoJpNotifyingAgency" 
                    name="p_owning_department_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
              <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: 'closedWoJpNotifyingAgency', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="closedWoJpBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'mntHistory')
<div id="mntHistory" class="row">
  <form id="mntHistoryBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อมตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="mntHistoryWorkReceiptNumber" 
                    name="p_wip_entity_name" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'mntHistoryWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
             </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อมถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="mntHistoryWorkReceiptNumberTo" 
                    name="p_wip_entity_name_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'mntHistoryWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="mntHistoryAssetNumber" 
                    name="p_asset_number" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'mntHistoryAssetNumber'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="mntHistoryAssetNumberTo" 
                    name="p_asset_number_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'mntHistoryAssetNumberTo'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Activity Number ตั้งแต่</label>
        <div class="col-sm-4">
          <select id="mntHistoryActivitiesToDo" class="form-control"  name="p_activity_number"></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Activity Number ถึง</label>
        <div class="col-sm-4">
          <select id="mntHistoryActivitiesToDoTo" class="form-control"  name="p_activity_number_to"></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">สถานะของใบสั่ง</label>
        <div class="col-sm-4">
          <select id="mntHistoryWorkReceiptStatus" class="form-control"></select>
          <input id="mntHistoryWorkReceiptStatusHide" name="p_status_desc" class="d-none" type="text">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานที่ซ่อม</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="mntHistoryDepartment" 
                    name="p_department_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select"
                    data-setAjaxMNTHistoryDepartment="mntHistoryDepartment"
                    data-setAjaxMNTHistoryDepartmentDesc="mntHistoryDepartmentDesc"
                    data-typeAjaxMNTHistoryDepartment="mntHistoryDepartment">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานที่ซ่อม', idDepartmentModal: 'mntHistoryDepartment', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
          <input id="mntHistoryDepartmentDesc" type="text" class="form-control" disabled autocomplete="off">
        </div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานเจ้าของ</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="mntHistoryOwningDepartment" 
                    name="p_owning_department_desc" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select"
                    data-setAjaxMNTHistoryOwningDepartment="mntHistoryOwningDepartment"
                    data-setAjaxMNTHistoryOwningDepartmentDesc="mntHistoryOwningDepartmentDesc"
                    data-typeAjaxMNTHistoryOwningDepartment="mntHistoryOwningDepartment">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานเจ้าของ', idDepartmentModal: 'mntHistoryOwningDepartment', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
          <input id="mntHistoryOwningDepartmentDesc" type="text" class="form-control" disabled autocomplete="off">
        </div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ระบุวันที่ จาก</label>
        <div class="col-sm-4">
          <input id="mntHistoryStartDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ระบุวันที่ ถึง</label>
        <div class="col-sm-4">
          <input id="mntHistoryStartDateStartTo" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขทีใบขอซ่อม ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="mntHistoryWorkOrderNumber" 
                    name="p_work_request_number" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/work-request-number"  
                    data-id="work_request_number" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
              <button onclick="workOrderNumberBtnReportOnclick({nameWorkOrderNumberModal: 'เลขทีใบขอซ่อม', idWorkOrderNumberModal: 'mntHistoryWorkOrderNumber'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขทีใบขอซ่อม ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="mntHistoryWorkOrderNumberTo" 
                    name="p_work_request_number_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/work-request-number"  
                    data-id="work_request_number" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workOrderNumberBtnReportOnclick({nameWorkOrderNumberModal: 'เลขทีใบขอซ่อม', idWorkOrderNumberModal: 'mntHistoryWorkOrderNumberTo'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ผู้รับงาน</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="mntHistoryEmployee" 
                    name="employee_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/web-user"  
                    data-id="username" 
                    data-text="name" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button id="modalMNTHistoryEmployeeLovBtn" 
                        onclick="employeeWebLovBtnOnclick({nameEmployeeWebModal: 'ผู้รับแจ้ง', idEmployeeWebModal: 'mntHistoryEmployee', desc: false, inModal: false, idWebCode: 'notifyingAgency'})" 
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
    </div>
    <button id="mntHistoryBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'maintenance')
<div id="maintenance" class="row">
  <form id="maintenanceBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อมตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="maintenanceWorkReceiptNumber" 
                    name="p_wip_entity_name" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'maintenanceWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
             </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อมถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="maintenanceWorkReceiptNumberTo" 
                    name="p_wip_entity_name_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'maintenanceWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
             </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ประเภทใบรับงาน</label>
        <div class="col-sm-4">
          <select id="maintenanceType"  class="form-control" name=""></select>
          <input id="maintenanceTypeHide" type="text" hidden class="form-control" name="p_work_order_type" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ระบุวันที่ จาก</label>
        <div class="col-sm-4">
          <input id="maintenanceStartDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ระบุวันที่ ถึง</label>
        <div class="col-sm-4">
          <input id="maintenanceStartDateStartTo" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="maintenanceAssetNumber" 
                    name="p_asset_number" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'maintenanceAssetNumber'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="maintenanceAssetNumberTo" 
                    name="p_asset_number_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'maintenanceAssetNumberTo'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานที่ซ่อม</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="maintenanceDepartment" 
                    name="p_assign_department_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select"
                    data-setAjaxMaintenanceDepartment="maintenanceDepartment"
                    data-setAjaxMaintenanceDepartmentDesc="maintenanceDepartmentDesc"
                    data-typeAjaxMaintenanceDepartment="maintenanceDepartment">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานที่ซ่อม', idDepartmentModal: 'maintenanceDepartment', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
          <input id="maintenanceDepartmentDesc" type="text" class="form-control" disabled autocomplete="off">
        </div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานเจ้าของ</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="maintenanceOwningDepartment" 
                    name="p_own_department_desc" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select"
                    data-setAjaxMaintenanceOwningDepartment="maintenanceOwningDepartment"
                    data-setAjaxMaintenanceOwningDepartmentDesc="maintenanceOwningDepartmentDesc"
                    data-typeAjaxMaintenanceOwningDepartment="maintenanceOwningDepartment">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานเจ้าของ', idDepartmentModal: 'maintenanceOwningDepartment', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
          <input id="maintenanceOwningDepartmentDesc" type="text" class="form-control" disabled autocomplete="off">
        </div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ผู้รับงาน</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="maintenanceEmployee" 
                    name="employee_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/web-user"  
                    data-id="username" 
                    data-text="name" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button id="modalMaintenanceEmployeeLovBtn" 
                        onclick="employeeWebLovBtnOnclick({nameEmployeeWebModal: 'ผู้รับแจ้ง', idEmployeeWebModal: 'maintenanceEmployee', desc: false, inModal: false, idWebCode: 'notifyingAgency'})" 
                        type="button" 
                        class="btn btn-default">
                        <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
        </div>
      </div>
    </div>
    <button id="maintenanceBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'jobAccountDel')
<div id="jobAccountDel" class="row">
  <form id="jobAccountDelBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงาน ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="jobAccountDelWorkReceiptNumber" 
                    name="job_no_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'jobAccountDelWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
             </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงาน ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="jobAccountDelWorkReceiptNumberTo" 
                    name="job_no_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'jobAccountDelWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ทำรายการตั้งแต่</label>
        <div class="col-sm-4">
          <input id="jobAccountDelDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ทำรายการถึง</label>
        <div class="col-sm-4">
          <input id="jobAccountDelDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Period</label>
        <div class="col-sm-4">
          <select id="jobAccountDelPeriod" class="form-control" name="period_name"></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="jobAccountDelBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'purchase')
<div id="purchase" class="row">
  <form id="purchaseBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อมตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="purchaseWorkReceiptNumber" 
                    name="p_wip_entity_name" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'purchaseWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อมถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="purchaseWorkReceiptNumberTo" 
                    name="p_wip_entity_name_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'purchaseWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
             </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ประเภทใบรับงาน</label>
        <div class="col-sm-4">
          <select id="purchaseType" class="form-control" name="p_work_order_type"></select>
          {{-- <input id="purchaseTypeHide" type="text" hidden class="form-control" name="p_work_order_type_hide" autocomplete="off"> --}}
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ทำรายการตั้งแต่</label>
        <div class="col-sm-4">
          <input id="purchaseStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ทำรายการถึง</label>
        <div class="col-sm-4">
          <input id="purchaseStartTo" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="purchaseAssetNumber" 
                    name="p_asset_number" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'purchaseAssetNumber'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="purchaseAssetNumberTo" 
                    name="p_asset_number_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'purchaseAssetNumberTo'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="purchaseBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'RequestMatInv')
<div id="RequestMatInv" class="row justify-content-center">
  <form id="modalReportRequestMatInvPrintAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งงานตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="reportRequestMatInvWorkOrderNumber" 
                    name="work_request_number_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/work-request-number"  
                    data-id="work_request_number" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workOrderNumberLovBtnOnclick({nameWorkOrderNumberModal: 'เลขที่ใบสั่งงาน', idWorkOrderNumberModal: 'reportRequestMatInvWorkOrderNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งงานถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="reportRequestMatInvWorkOrderNumberTo" 
                    name="work_request_number_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/work-request-number"  
                    data-id="work_request_number" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workOrderNumberLovBtnOnclick({nameWorkOrderNumberModal: 'เลขที่ใบสั่งงาน', idWorkOrderNumberModal: 'reportRequestMatInvWorkOrderNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ต้องการตั้งแต่</label>
        <div class="col-sm-4">
          <input id="modalReportRequestMatInvDateStart" type="text" class="form-control" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ต้องการถึง</label>
        <div class="col-sm-4">
          <input id="modalReportRequestMatInvDateEnd" type="text" class="form-control" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Subinventory</label>
        <div class="col-sm-4">
          <select id="modalReportRequestMatInvSubinventory"  class="form-control" name="subinventory" ></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Locator</label>
        <div class="col-sm-4">
          <select id="modalReportRequestMatInvLocator"  class="form-control" name="locator" ></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงานตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="reportRequestMatInvWorkReceiptNumber" 
                    name="wip_entity_name_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'reportRequestMatInvWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงานถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="reportRequestMatInvWorkReceiptNumberTo" 
                    name="wip_entity_name_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'reportRequestMatInvWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">รายการสิ่งของ</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="modalReportRequestMatInvItemCode" 
                    name="item_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/item-inventory"  
                    data-id="item_code" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="itemCodeLovBtnOnclick({nameItemCodeModal: 'รายการสิ่งของ', idItemCodeModal: 'modalReportRequestMatInvItemCode', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="modalReportRequestMatInvPrintHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'RequestMatNon')
<div id="RequestMatNon" class="row justify-content-center">
  <form id="modalReportRequestMatNonPrintAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งงานตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="reportRequestMatNonWorkOrderNumber" 
                    name="work_request_number_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/work-request-number"  
                    data-id="work_request_number" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workOrderNumberLovBtnOnclick({nameWorkOrderNumberModal: 'เลขที่ใบสั่งงาน', idWorkOrderNumberModal: 'reportRequestMatNonWorkOrderNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งงานถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="reportRequestMatNonWorkOrderNumberTo" 
                    name="work_request_number_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/work-request-number"  
                    data-id="work_request_number" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workOrderNumberLovBtnOnclick({nameWorkOrderNumberModal: 'เลขที่ใบสั่งงาน', idWorkOrderNumberModal: 'reportRequestMatNonWorkOrderNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ต้องการตั้งแต่</label>
        <div class="col-sm-4">
          <input id="modalReportRequestMatNonDateStart" type="text" class="form-control" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ต้องการถึง</label>
        <div class="col-sm-4">
          <input id="modalReportRequestMatNonDateEnd" type="text" class="form-control" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงานตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="reportRequestMatNonWorkReceiptNumber" 
                    name="wip_entity_name_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'reportRequestMatNonWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงานถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="reportRequestMatNonWorkReceiptNumberTo" 
                    name="wip_entity_name_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'reportRequestMatNonWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">รายการสิ่งของ</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="modalReportRequestMatNonItemCode" 
                    name="item_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/item-inventory"  
                    data-id="item_code" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="itemCodeNonStockLovBtnOnclick({nameItemCodeModal: 'รายการสิ่งของ', idItemCodeModal: 'modalReportRequestMatNonItemCode', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบขอซื้อ (PR Number)</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select class="form-control clearable"
                    id="reportRequestMatNonWorkReceiptPRNumber"
                    name="pr_number">
            </select>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="modalReportRequestMatNonPrintHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'jobAccount')
<div id="jobAccount" class="row">
  <form id="jobAccountBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงานตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="jobAccountWorkReceiptNumber" 
                    name="p_wip_entity_name" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'jobAccountWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงานถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="jobAccountWorkReceiptNumberTo" 
                    name="p_wip_entity_name_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'jobAccountWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Period<label class="pl-1 text-danger">*</label></label>
        <div class="col-sm-4">
          <select id="jobAccountPeriod" class="form-control" name="p_period" required></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="jobAccountBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'laborAccount')
<div id="laborAccount" class="row">
  <form id="laborAccountBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อม ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="laborAccountWorkReceiptNumber" 
                    name="p_wip_entity_name" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'laborAccountWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อม ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="laborAccountWorkReceiptNumberTo" 
                    name="p_wip_entity_name_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'laborAccountWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Period<label class="pl-1 text-danger">*</label></label>
        <div class="col-sm-4">
          <select id="laborAccountPeriod" class="form-control" name="p_period" required></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="laborAccountBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'labor')
<div id="labor" class="row">
  <form id="laborBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงาน ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="laborWorkReceiptNumber" 
                    name="p_wip_entity_name" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'laborWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบรับงาน ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="laborWorkReceiptNumberTo" 
                    name="p_wip_entity_name_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'laborWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ประเภทใบรับงาน</label>
        <div class="col-sm-4">
          <select id="laborType"  class="form-control"></select>
          <input id="laborTypeHide" type="text" class="form-control" name="p_work_order_type" hidden autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่เริ่มต้น</label>
        <div class="col-sm-4">
          <input id="laborDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่สิ้นสุด</label>
        <div class="col-sm-4">
          <input id="laborDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="laborAssetNumber" 
                    name="p_asset_number" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'laborAssetNumber'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="laborAssetNumberTo" 
                    name="p_asset_number_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'laborAssetNumberTo'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="laborBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'woCost')
<div id="woCost" class="row">
  <form id="woCostBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อม ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woCostWorkReceiptNumber" 
                    name="p_wip_entity_name" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'woCostWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อม ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woCostWorkReceiptNumberTo" 
                    name="p_wip_entity_name_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'woCostWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woCostExcelAssetNumber" 
                    name="p_asset_number" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'woCostExcelAssetNumber'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woCostExcelAssetNumberTo" 
                    name="p_asset_number_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'woCostExcelAssetNumberTo'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานที่ซ่อม</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woCostDepartment" 
                    name="p_assigned_department" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select"
                    data-typeAjaxWOCostDepartment="woCostDepartment"
                    data-setAjaxWOCostDepartmentDesc="woCostDepartmentDesc"
                    data-setAjaxWOCostDepartment="woCostDepartment">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานที่ซ่อม', idDepartmentModal: 'woCostDepartment', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
          <input id="woCostDepartmentDesc" type="text" class="form-control" disabled autocomplete="off">
        </div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานเจ้าของ</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woCostOwningDepartment" 
                    name="p_owning_department_desc" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select"
                    data-setAjaxWOCostOwningDepartment="woCostOwningDepartment"
                    data-setAjaxWOCostOwningDepartmentDesc="woCostOwningDepartmentDesc"
                    data-typeAjaxWOCostOwningDepartment="woCostOwningDepartment">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานเจ้าของ', idDepartmentModal: 'woCostOwningDepartment', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
          <input id="woCostOwningDepartmentDesc" type="text" class="form-control" disabled autocomplete="off">
        </div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ค่าใช้จ่ายรวมมากกว่า</label>
        <div class="col-sm-4">
          <input id="woCostDate" type="test" class="form-control" name="p_h1_sum_actual_total_cost" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">งบประมาณ</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woCostClass" 
                    name="p_class_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/wipclass"  
                    data-id="class_code" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
              <button onclick="wipClassLovBtnOnclick({nameWipClassModal: 'งบประมาณ', idWipClassModal: 'woCostClass', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบขอซ่อม ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woCostWorkOrderNumber" 
                    name="p_work_request_number" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/work-request-number"  
                    data-id="work_request_number" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workOrderNumberLovBtnOnclick({nameWorkOrderNumberModal: 'เลขที่ใบขอซ่อม', idWorkOrderNumberModal: 'woCostWorkOrderNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบขอซ่อม ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woCostWorkOrderNumberTo" 
                    name="p_work_request_number_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/work-request-number"  
                    data-id="work_request_number" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workOrderNumberLovBtnOnclick({nameWorkOrderNumberModal: 'เลขที่ใบขอซ่อม', idWorkOrderNumberModal: 'woCostWorkOrderNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Period</label>
        <div class="col-sm-4">
          <select id="woCostPeriod" class="form-control" name="p_h1_period_name"></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="woCostBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'summaryLabor')
<div id="summaryLabor" class="row">
  <form id="summaryLaborBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อม ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="summaryLaborWorkReceiptNumber" 
                    name="p_wip_entity_name" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'summaryLaborWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อม ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="summaryLaborWorkReceiptNumberTo" 
                    name="p_wip_entity_name_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'summaryLaborWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ทำรายการ ตั้งแต่</label>
        <div class="col-sm-4">
          <input id="summaryLaborDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ทำรายการ ถึง</label>
        <div class="col-sm-4">
          <input id="summaryLaborDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานที่ซ่อม</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="summaryLaborDepartment" 
                    name="p_department_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select"
                    data-typeAjaxSummaryLaborDepartmentDesc="summaryLaborDepartment"
                    data-setAjaxSummaryLaborDepartmentDesc="summaryLaborDepartmentDesc"
                    data-setAjaxSummaryLaborDepartment="summaryLaborDepartment">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานที่ซ่อม', idDepartmentModal: 'summaryLaborDepartment', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
          <input id="summaryLaborDepartmentDesc" type="text" class="form-control" disabled autocomplete="off">
        </div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ประเภทใบสั่งซ่อม</label>
        <div class="col-sm-4">
          <select id="summaryLaborType"  class="form-control"></select>
          <input id="summaryLaborTypeHide" type="text" class="form-control" name="p_work_order_type" hidden autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="summaryLaborBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'receiptMat')
<div id="receiptMat" class="row">
  <form id="receiptMatBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อม ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="receiptMatWorkReceiptNumber" 
                    name="p_wip_entity_name" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'receiptMatWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อม ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="receiptMatWorkReceiptNumberTo" 
                    name="p_wip_entity_name_to" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'receiptMatWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ทำรายการ ตั้งแต่</label>
        <div class="col-sm-4">
          <input id="receiptMatDateStart" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">วันที่ทำรายการ ถึง</label>
        <div class="col-sm-4">
          <input id="receiptMatDateEnd" type="text" class="form-control dateTable" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Period</label>
        <div class="col-sm-4">
          <select id="receiptMatPeriod" class="form-control" name="p_period"></select>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ผู้รับงาน</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="receiptMatEmployee" 
                    name="p_employee" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/web-user"  
                    data-id="username" 
                    data-text="name" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button id="modalReceiptMatEmployeeLovBtn" 
                        onclick="employeeWebLovBtnOnclick({nameEmployeeWebModal: 'ผู้รับแจ้ง', idEmployeeWebModal: 'receiptMatEmployee', desc: false, inModal: false, idWebCode: 'notifyingAgency'})" 
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
    </div>
    <button id="receiptMatBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'woComStatus')
<div id="woComStatus" class="row">
  <form id="woComStatusBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อม ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woComStatusWorkReceiptNumber" 
                    name="p_wip_entity_name_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'woComStatusWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อม ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woComStatusWorkReceiptNumberTo" 
                    name="p_wip_entity_name_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'woComStatusWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ประเภทของใบรับงาน</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woComStatusType"  
                    class="form-control"
                    name="h1_work_order_type_disp">
            </select>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woComStatusExcelAssetNumber" 
                    name="p_asset_number_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'woComStatusExcelAssetNumber'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woComStatusExcelAssetNumberTo" 
                    name="p_asset_number_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'woComStatusExcelAssetNumberTo'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานที่ซ่อม</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woComStatusDepartment" 
                    name="p_assigned_department" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select"
                    data-typeAjaxWOComStatusDepartment="woComStatusDepartment"
                    data-setAjaxWOComStatusDepartmentDesc="woComStatusDepartmentDesc"
                    data-setAjaxWOComStatusDepartment="woComStatusDepartment">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานที่ซ่อม', idDepartmentModal: 'woComStatusDepartment', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
          <input id="woComStatusDepartmentDesc" type="text" class="form-control" name="p_assigned_department_decs" disabled autocomplete="off">
        </div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานเจ้าของ</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woComStatusOwningDepartment" 
                    name="p_owning_department" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select"
                    data-typeAjaxWOComStatusOwningDepartment="woComStatusOwningDepartment"
                    data-setAjaxWOComStatusOwningDepartmentDesc="woComStatusOwningDepartmentDesc"
                    data-setAjaxWOComStatusOwningDepartment="woComStatusOwningDepartment">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานเจ้าของ', idDepartmentModal: 'woComStatusOwningDepartment', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
          <input id="woComStatusOwningDepartmentDesc" type="text" class="form-control" name="p_owning_department_decs" disabled autocomplete="off">
        </div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ส่งมอบงานซ่อมมาแล้วมากกว่า(วัน)</label>
        <div class="col-sm-4">
          <input  id="woComStatusDate" 
                  type="text" 
                  onkeypress="return /[0-9]/i.test(event.key)" 
                  class="form-control" 
                  name="p_day" 
                  autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ส่งมอบงาน จากวันที่</label>
        <div class="col-sm-4">
          <input id="woComStatusDateStart" type="text" class="form-control" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ส่งมอบงาน ถึงวันที่</label>
        <div class="col-sm-4">
          <input id="woComStatusDateEnd" type="text" class="form-control" autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบขอซ่อม ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woComStatusWorkOrderNumber" 
                    name="p_work_request_number_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/work-request-number"  
                    data-id="work_request_number" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workOrderNumberLovBtnOnclick({nameWorkOrderNumberModal: 'เลขที่ใบขอซ่อม', idWorkOrderNumberModal: 'woComStatusWorkOrderNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบขอซ่อม ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="woComStatusWorkOrderNumberTo" 
                    name="p_work_request_number_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/work-request-number"  
                    data-id="work_request_number" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workOrderNumberLovBtnOnclick({nameWorkOrderNumberModal: 'เลขที่ใบขอซ่อม', idWorkOrderNumberModal: 'woComStatusWorkOrderNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="woComStatusBtnHide" class="d-none" ></button>
  </form>
</div>
@elseif ($checkAttrId == 'summaryMatStatus')
<div id="summaryMatStatus" class="row">
  <form id="summaryMatStatusBtnAction" target="_blank" method="GET" class="w-100">
    <div class="col-11 mb-3">
      <h4>Parameter</h4>
    </div>
    <div class="col-lg-12">
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อม ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="summaryMatStatusWorkReceiptNumber" 
                    name="wip_entity_name_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'summaryMatStatusWorkReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบสั่งซ่อม ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="summaryMatStatusWorkReceiptNumberTo" 
                    name="wip_entity_name_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/workorderhvid"  
                    data-id="wip_entity_name" 
                    data-field="p_wip_entity_name">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบสั่งซ่อม', idWorkReceiptNumberModal: 'summaryMatStatusWorkReceiptNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="summaryMatStatusAssetNumber" 
                    name="asset_number_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'summaryMatStatusAssetNumber'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Asset Number ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="summaryMatStatusAssetNumberTo" 
                    name="asset_number_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="assetNumberBtnOnclick({data1: 'summaryMatStatusAssetNumberTo'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">หน่วยงานที่ซ่อม</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="summaryMatStatusDepartment" 
                    name="p_department_code" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/departments"  
                    data-id="department_code" 
                    data-text="description" 
                    data-field="select"
                    data-typeAjaxSummaryMatStatusDepartment="summaryMatStatusDepartment"
                    data-setAjaxSummaryMatStatusDepartmentDesc="summaryMatStatusDepartmentDesc"
                    data-setAjaxSummaryMatStatusDepartment="summaryMatStatusDepartment">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานที่ซ่อม', idDepartmentModal: 'summaryMatStatusDepartment', desc: true, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <label class="col-form-label">&nbsp;</label>
        <div class="col-sm-4">
          <input id="summaryMatStatusDepartmentDesc" type="text" class="form-control" name="h1_owning_department_desc" disabled autocomplete="off">
        </div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">ประเภทใบสั่งซ่อม</label>
        <div class="col-sm-4">
          <select id="summaryMatStatusType"  class="form-control"></select>
          <input id="summaryMatStatusTypeHide" type="text" class="form-control" name="h1_work_order_type_disp" hidden autocomplete="off">
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบขอซ่อม ตั้งแต่</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="summaryMatStatusWorkOrderNumber" 
                    name="work_request_number_st" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/work-request-number"  
                    data-id="work_request_number" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workOrderNumberLovBtnOnclick({nameWorkOrderNumberModal: 'เลขที่ใบขอซ่อม', idWorkOrderNumberModal: 'summaryMatStatusWorkOrderNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">เลขที่ใบขอซ่อม ถึง</label>
        <div class="col-sm-4">
          <div class="input-group">
            <select id="summaryMatStatusWorkOrderNumberTo" 
                    name="work_request_number_en" 
                    class="form-control clearable" 
                    data-server="/eam/ajax/lov/work-request-number"  
                    data-id="work_request_number" 
                    data-field="select">
            </select>
            <div class="input-group-append">
              <span class="input-group-append">
                <button onclick="workOrderNumberLovBtnOnclick({nameWorkOrderNumberModal: 'เลขที่ใบขอซ่อม', idWorkOrderNumberModal: 'summaryMatStatusWorkOrderNumberTo', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="form-group row justify-content-center">
        <label class="col-sm-3 col-form-label">Organization<label class="pl-1 text-danger">*</label></label>
        <div class="col-sm-4">
          <select id="summaryMatStatusOrganization" 
                  class="form-control"
                  name="h1_organization_id"
                  required
                  autocomplete="off">
          </select>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <button id="summaryMatStatusBtnHide" class="d-none" ></button>
  </form>
</div>
@endif
