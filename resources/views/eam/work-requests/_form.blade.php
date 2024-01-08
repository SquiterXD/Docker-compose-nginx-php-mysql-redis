@if ($checkAttrId == 'formCreate')
<div class="row justify-content-center">
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">เลขที่ใบสั่งงาน</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="workOrderNumber" 
                  name="work_request_number" 
                  class="form-control clearable" 
                  data-server="/eam/ajax/lov/work-request-number"  
                  data-id="work_request_number" 
                  data-field="select"
                  data-setAjaxWorkOrderNumberInEAM0007="workOrderNumber"
                  data-typeWorkOrderNumberInEAM0007="lovWorkOrderNumber">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="workOrderNumberLovBtn" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Asset Number<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="assetNumber" 
                  name="asset_number" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/assetnumber?p_attr_filter_dept_by_auth=1"  
                  data-id="asset_number" 
                  data-text="description" 
                  data-field="select"
                  data-setAjaxWorkAssetNumberInEAM0007="assetNumber"
                  data-typeWorkAssetNumberInEAM0007="assetNumber">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="assetNumberLovBtn" attr-filter-dept-by-auth="1" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div id="machineNameHide" class="form-group row">
      <label class="col-sm-4 col-form-label">ชื่อเครื่องจักร</label>
      <div class="col-sm-8">
        <input id="machineName" type="text" class="form-control" name="asset_desc" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงานผู้แจ้ง<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="reportingAgency" 
                  name="owning_dept_code" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"
                  data-id="department_code" 
                  data-text="description"
                  data-field="select"
                  data-setAjaxReportingAgencyInEAM0007="reportingAgency"
                  data-typeReportingAgencyInEAM0007="reportingAgency">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="reportingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้แจ้ง', idDepartmentModal: 'reportingAgency', desc: false, inModal: false})" type="button" class="btn btn-default" ><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะใบสั่งงาน<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="workOrderStatus" class="form-control" name="work_request_status_id" required></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงานผู้รับแจ้ง<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="notifyingAgency" 
                  name="receiving_dept_code" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"
                  data-id="department_code" 
                  data-text="description"
                  data-field="select"
                  data-setAjaxNotifyingAgencyInEAM0007="notifyingAgency"
                  data-typeNotifyingAgencyInEAM0007="notifyingAgency">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="notifyingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: 'notifyingAgency', desc: false, inModal: false})" type="button" class="btn btn-default" ><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ผู้แจ้งซ่อม<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="repairer" 
                  name="employee_code" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/web-user"  
                  data-department="true"
                  data-id="username" 
                  data-text="name" 
                  data-field="select"
                  data-setAjaxRepairerId = "repairerId">
          </select>
          <input id="repairerId" type="text" class="form-control" hidden name="employee_code" autocomplete="off">
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="repairerLovBtn" onclick="employeeWebLovBtnOnclick({nameEmployeeWebModal: 'ผู้แจ้งซ่อม', idEmployeeWebModal: 'repairer', desc: false, inModal: false, idWebCode: 'reportingAgency'})" type="button" class="btn btn-default" ><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ใบรับงานอ้างอิง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="referenceWorkReceipt" class="form-control" name="work_request_status_id"></select>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-1"></div>
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประเภทใบสั่งงาน<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="workOrderType" class="form-control" name="work_request_type_id" required></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">คำอธิบายใบสั่งงาน<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <textarea id="workOrderDescription" class="form-control textArea-3" name="description" required></textarea>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ความสำคัญ<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="importance" class="form-control" name="work_request_priority_id" required></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่แจ้งซ่อม<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <input id="repairNotificationDate" type="text" class="form-control" name="expected_resolution_date" autocomplete="off">
      </div>
    </div>
    <div id="workReceiptNumberHide" class="form-group row">
      <label class="col-sm-4 col-form-label">เลขที่ใบรับงาน</label>
      <div class="col-sm-8">
        <input id="workReceiptNumber" type="text" name="work_order_number" class="form-control" autocomplete="off">
      </div>
    </div>
    <div id="quantityOfPartsProducedhide" class="form-group row">
      <label class="col-sm-4 col-form-label">ปริมาณอะไหล่ที่ผลิต<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <input  id="quantityOfPartsProduced" 
                type="text" 
                onkeypress="return /[0-9]/i.test(event.key)" 
                class="form-control" 
                name="jp_qty" 
                min="0" 
                autocomplete="off" 
                required>
      </div>
    </div>
  </div>
  <div id="approvalHide" class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ผู้อนุมัติ</label>
      <div class="col-sm-8">
        <input id="approval" type="text" class="form-control" name="approver_desc" autocomplete="off">
      </div>
    </div>
  </div>
  <div class="col-lg-1"></div>
  <div class="col-lg-5 mb-5">
    <div id="approvalDateHide" class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่อนุมัติ</label>
      <div class="col-sm-8">
        <input id="approvalDate" type="text" class="form-control" name="approved_date" autocomplete="off">
      </div>
    </div>
  </div>
  <input type="text" class="form-control d-none" name="program_code" value="EAM0007">
  <div class="col-lg-12 text-right">
    <button type="button" id="awaitingWorkOrderWorkRequestStatusDesc" class="btn btn-primary btn-lg" style="width: 130px;">
      อนุมัติ
    </button>
    <button type="button" id="rejectedWorkRequestStatusDesc" class="btn btn-danger btn-lg" style="width: 130px;">
      ปฏิเสธ
    </button>
  </div>
</div>
@elseif ($checkAttrId == 'formIndex')
<div class="row justify-content-center">
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">เลขที่ใบสั่งงาน</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="workOrderNumber" 
                  name="work_request_number" 
                  class="form-control clearable" 
                  data-server="/eam/ajax/lov/work-request-number"  
                  data-id="work_request_number" 
                  data-field="select">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="workOrderNumberLovBtn" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Asset Number</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="assetNumber" 
                  name="asset_number" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/assetnumber"  
                  data-id="asset_number" 
                  data-text="description" 
                  data-field="select">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="assetNumberLovBtn" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงานผู้แจ้ง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="reportingAgency" 
                  name="owning_dept_code" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"
                  data-id="department_code" 
                  data-text="description"
                  data-field="select">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="reportingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้แจ้ง', idDepartmentModal: 'reportingAgency', desc: false, inModal: false})" type="button" class="btn btn-default" ><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะใบสั่งงาน</label>
      <div class="col-sm-8">
        <select id="workOrderStatus" class="form-control" name="work_request_status_id" ></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงานผู้รับแจ้ง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="notifyingAgency" 
                  name="receiving_dept_code" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"
                  data-id="department_code" 
                  data-text="description"
                  data-field="select">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="notifyingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: 'notifyingAgency', desc: false, inModal: false})" type="button" class="btn btn-default" ><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ผู้แจ้งซ่อม</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="repairer" 
                  name="employee_code" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/web-user"  
                  data-id="username" 
                  data-text="name" 
                  data-field="select"
                  data-setAjaxRepairerId = "repairerId">
          </select>
          <input id="repairerId" type="text" class="form-control" hidden name="employee_code" autocomplete="off">
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="repairerLovBtn" 
                onclick="employeeWebLovBtnOnclick({nameEmployeeWebModal: 'ผู้แจ้งซ่อม', idEmployeeWebModal: 'repairer', desc: false, inModal: false})" type="button" class="btn btn-default" ><i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-1"></div>
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประเภทใบสั่งงาน</label>
      <div class="col-sm-8">
        <select id="workOrderType" class="form-control" name="work_request_type_id"  ></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ความสำคัญ</label>
      <div class="col-sm-8">
        <select id="importance" class="form-control" name="work_request_priority_id"></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่แจ้งซ่อม ตั้งแต่</label>
      <div class="col-sm-8">
        <input id="repairNotificationDateSt" type="text" class="form-control" name="expected_resolution_date" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่แจ้งซ่อม ถึง</label>
      <div class="col-sm-8">
        <input id="repairNotificationDateEn" type="text" class="form-control" name="expected_resolution_date" autocomplete="off">
      </div>
    </div>
    <div id="workReceiptNumberHide" class="form-group row">
      <label class="col-sm-4 col-form-label">เลขที่ใบรับงาน</label>
      <div class="col-sm-8">
        <input id="workReceiptNumber" type="text" name="work_order_number" class="form-control" autocomplete="off">
      </div>
    </div>
  </div>
</div>
@elseif ($checkAttrId == 'formWaitingApprove')
<div class="row justify-content-center">
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">เลขที่ใบสั่งงาน</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="workOrderNumber" 
                  name="work_request_number" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/work-request-number"  
                  data-id="work_request_number" 
                  data-field="select">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="workOrderNumberLovBtn" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Asset Number</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="assetNumber" 
                  name="asset_number" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/assetnumber"  
                  data-id="asset_number" 
                  data-text="description" 
                  data-field="select">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="assetNumberLovBtn" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงานผู้แจ้ง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="reportingAgency" 
                  name="owning_dept_code" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"
                  data-id="department_code" 
                  data-text="description"
                  data-field="select"
                  disabled>
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="reportingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้แจ้ง', idDepartmentModal: 'reportingAgency', desc: false, inModal: false})" type="button" class="btn btn-default" disabled><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะใบสั่งงาน</label>
      <div class="col-sm-8">
        <select id="workOrderStatus" class="form-control" name="work_request_status_id" disabled></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงานผู้รับแจ้ง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="notifyingAgency" 
                  name="receiving_dept_code" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"
                  data-id="department_code" 
                  data-text="description"
                  data-field="select">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="notifyingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: 'notifyingAgency', desc: false, inModal: false})" type="button" class="btn btn-default" ><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ผู้แจ้งซ่อม</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="repairer" 
                  name="employee_code" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/web-user"  
                  data-id="username" 
                  data-text="name" 
                  data-field="select"
                  data-setAjaxRepairerId = "repairerId">
          </select>
          <input id="repairerId" type="text" class="form-control" hidden name="employee_code" autocomplete="off">
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="repairerLovBtn" 
                onclick="employeeWebLovBtnOnclick({nameEmployeeWebModal: 'ผู้แจ้งซ่อม', idEmployeeWebModal: 'repairer', desc: false, inModal: false})" type="button" class="btn btn-default" ><i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-1"></div>
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประเภทใบสั่งงาน</label>
      <div class="col-sm-8">
        <select id="workOrderType" class="form-control" name="work_request_type_id"  ></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ความสำคัญ</label>
      <div class="col-sm-8">
        <select id="importance" class="form-control" name="work_request_priority_id"></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่แจ้งซ่อม ตั้งแต่</label>
      <div class="col-sm-8">
        <input id="repairNotificationDateSt" type="text" class="form-control" name="expected_resolution_date_st" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่แจ้งซ่อม ถึง</label>
      <div class="col-sm-8">
        <input id="repairNotificationDateEn" type="text" class="form-control" name="expected_resolution_date_en" autocomplete="off">
      </div>
    </div>
  </div>
</div>
@endif
