@if ($checkAttrId == 'formWaiting')
<div id="formWaiting" class="row justify-content-center">
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
              <button id="reportingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้แจ้ง', idDepartmentModal: 'reportingAgency', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
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
              <button id="notifyingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: 'notifyingAgency', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
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
        <select id="workOrderType" class="form-control" name="work_request_type_id"></select>
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
@elseif ($checkAttrId == 'formCreate')
<div id="formCreate" class="row justify-content-center">
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">เลขที่ใบรับงาน<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="workReceiptNumber" 
                  name="work_request_number" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/workorderhvid"  
                  data-id="wip_entity_name" 
                  data-field="p_wip_entity_name"
                  data-setAjaxEAM0010WorkReceiptNumber="workReceiptNumber"
                  data-typeAjaxEAM0010WorkReceiptNumber="workReceiptNumber"
                  required>
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="workReceiptNumberLovBtn" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
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
                  data-server="/eam/ajax/lov/assetnumber"  
                  data-id="asset_number" 
                  data-text="description" 
                  data-field="select"
                  required
                  disabled
                  data-setAjaxEAM0010AssetNumber="assetNumber"
                  data-typeAjaxEAM0010AssetNumber="assetNumber">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="assetNumberLovBtn" type="button" class="btn btn-default" disabled><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ชื่อเครื่องจักร</label>
      <div class="col-sm-8">
        <input id="machineName" type="text" class="form-control" name="asset_desc"  autocomplete="off" disabled>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">กลุ่มเครื่องจักร</label>
      <div class="col-sm-8">
        <input id="machineGroup" type="text" class="form-control" name="asset_desc"  autocomplete="off" disabled>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">กิจกรรมที่ต้องทำ</label>
      <div class="col-sm-8">
        <select id="activitiesToDo" class="form-control" name="work_request_status_id" disabled></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Class<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="class" 
                  name="owning_dept_code" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/wipclass"  
                  data-id="class_code" 
                  data-text="description" 
                  data-field="select"
                  required
                  disabled>
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="classLovBtn" onclick="wipClassLovBtnOnclick({nameWipClassModal: 'Class', idWipClassModal: 'class', desc: false, inModal: false})" type="button" class="btn btn-default" disabled><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะใบรับงาน</label>
      <div class="col-sm-8">
        <select id="jobReceiptStatus" class="form-control" name="work_request_status_id" disabled></select>
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
                  required
                  disabled>
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="notifyingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: 'notifyingAgency', desc: false, inModal: false})" type="button" class="btn btn-default" disabled><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ผู้รับแจ้ง<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <div class="input-group">
          <input id="notifierId" type="text" class="form-control" hidden name="employee_code" autocomplete="off">
          <select id="notifier" 
                  name="owning_dept_code" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/web-user"  
                  data-department="true"
                  data-id="username" 
                  data-text="name" 
                  data-field="select"
                  required
                  disabled>
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="notifierLovBtn" onclick="employeeWebLovBtnOnclick({nameEmployeeWebModal: 'ผู้รับแจ้ง', idEmployeeWebModal: 'notifier', desc: false, inModal: false, idWebCode: 'notifyingAgency'})" type="button" class="btn btn-default" disabled><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ใบรับงานอ้างอิง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="referenceWorkReceipt" class="form-control"></select>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ติดตามสถานะของงาน<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="jobStatus" 
                class="form-control" 
                name="work_request_status_id" 
                required 
                disabled>
        </select>
      </div>
    </div>
  </div>
  <div class="col-lg-1"></div>
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประเภทใบรับงาน<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="workReceiptType" 
                class="form-control" 
                name="work_request_type_id" 
                required 
                disabled>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">คำอธิบายใบรับงาน<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <textarea id="workReceiptDescription" 
                  class="form-control textArea-3" 
                  name="description" 
                  required 
                  disabled>
        </textarea>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ปัญหาที่พบ</label>
      <div class="col-sm-8">
        <select id="problemsEncountered" 
                class="form-control" 
                name="work_request_priority_id" 
                disabled>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ความสำคัญ<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="importance" 
                class="form-control" 
                name="work_request_priority_id" 
                required 
                disabled>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประมาณวันที่เริ่มซ่อม<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <input  id="repairDateStart" 
                type="text" 
                class="form-control" 
                name="expected_resolution_date" 
                required 
                disabled 
                autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประมาณวันที่ซ่อมเสร็จ<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <input  id="repairDateEnd" 
                type="text" 
                class="form-control" 
                name="expected_resolution_date testDate" 
                required 
                disabled 
                autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หยุดเครื่องจักร<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="stopMachine" 
                class="form-control" 
                name="work_request_type_id" 
                required 
                disabled>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">เลขที่ใบสั่งงาน</label>
      <div class="col-sm-8">
        <input  id="workOrderNumber" 
                type="text" 
                name="work_order_number" 
                class="form-control" 
                disabled 
                autocomplete="off">
      </div>
    </div>
  </div>
  <input type="text" class="form-control d-none" name="program_code" value="EAM00010">
</div>
@elseif ($checkAttrId == 'listAllRepairJob')
<div id="listAllRepairJob" class="row justify-content-center">
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">เลขที่ใบรับงาน</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="workReceiptNumber" 
                  name="" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/workorderhvid"  
                  data-id="wip_entity_name" 
                  data-field="p_wip_entity_name"
                  data-setAjaxSelectEAM0016GetWipEntityId="workReceiptNumber">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'workReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
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
                  name="" 
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
      <label class="col-sm-4 col-form-label">กลุ่มเครื่องจักร</label>
      <div class="col-sm-8">
        <select id="machineGroup" class="form-control" name=""></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงานผู้รับแจ้ง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="notifyingAgency" 
                  name="" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"
                  data-id="department_code" 
                  data-text="description"
                  data-field="select">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="notifyingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: 'notifyingAgency', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ผู้รับแจ้ง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="notifier" 
                  name="" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/web-user"  
                  data-id="username" 
                  data-text="name" 
                  data-field="select"
                  data-setAjaxRepairerId = "notifierId">
          </select>
          <input id="notifierId" type="text" class="form-control" hidden name="employee_code" autocomplete="off">
          <div class="input-group-append">
            <button id="repairerLovBtn" 
              onclick="employeeWebLovBtnOnclick({nameEmployeeWebModal: 'ผู้แจ้งซ่อม', idEmployeeWebModal: 'notifier', desc: false, inModal: false})" type="button" class="btn btn-default" ><i class="fa fa-search"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะใบรับงาน</label>
      <div class="col-sm-8">
        <select id="jobReceiptStatus" class="form-control" name=""></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะการตัดใช้อะไหล่</label>
      <div class="col-sm-8">
        <select id="material" class="form-control statusYN" name=""></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะการบันทึกค่าแรง</label>
      <div class="col-sm-8">
        <select id="labor" class="form-control statusYN" name=""></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะ Complete งาน</label>
      <div class="col-sm-8">
        <select id="complete" class="form-control statusYN" name=""></select>
      </div>
    </div>
  </div>
  <div class="col-lg-1"></div>
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประเภทใบรับงาน</label>
      <div class="col-sm-8">
        <select id="workReceiptType" class="form-control" name=""></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประมาณวันที่เริ่มซ่อม (WO)</label>
      <div class="col-sm-8">
        <input id="dateStartWO" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประมาณวันที่ซ่อมเสร็จ (WO)</label>
      <div class="col-sm-8">
        <input id="dateEndWO" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">เลขที่ใบสั่งงาน</label>
      <div class="col-sm-8">
        <input  id="workOrderNumber" 
                onkeypress="return /[0-9]/i.test(event.key)" 
                type="text" 
                class="form-control" 
                name="" 
                autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงานผู้แจ้ง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="reportingAgency" 
                  name="" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"
                  data-id="department_code" 
                  data-text="description"
                  data-field="select">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="reportingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้แจ้ง', idDepartmentModal: 'reportingAgency', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่แจ้งซ่อม From (WR)</label>
      <div class="col-sm-8">
        <input id="dateStartWR" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่แจ้งซ่อม To (WR)</label>
      <div class="col-sm-8">
        <input id="dateEndWR" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
  </div>
</div>
@elseif ($checkAttrId == 'listRepairJobWaitingClose')
<div id="listRepairJobWaitingClose" class="row justify-content-center">
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">เลขที่ใบรับงาน</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="workReceiptNumber" 
                  name="" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/workorderhvid"  
                  data-id="wip_entity_name" 
                  data-field="p_wip_entity_name"
                  data-setAjaxSelectEAM0014GetWipEntityId="workReceiptNumber">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button onclick="workReceiptNumberLovBtnOnclick({nameWorkReceiptNumberModal: 'เลขที่ใบรับงาน', idWorkReceiptNumberModal: 'workReceiptNumber', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
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
                  name="" 
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
      <label class="col-sm-4 col-form-label">กลุ่มเครื่องจักร</label>
      <div class="col-sm-8">
        <select id="machineGroup" class="form-control" name=""></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงานผู้รับแจ้ง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="notifyingAgency" 
                  name="" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"
                  data-id="department_code" 
                  data-text="description"
                  data-field="select">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="notifyingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: 'notifyingAgency', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ผู้รับแจ้ง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="notifier" 
                  name="employee_code" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/web-user"  
                  data-id="username" 
                  data-text="name" 
                  data-field="select"
                  data-setAjaxNotifierId = "notifierId">
          </select>
          <input id="notifierId" type="text" class="form-control" hidden name="employee_code" autocomplete="off">
          <div class="input-group-append">
            <button id="notifierLovBtn" 
              onclick="employeeWebLovBtnOnclick({nameEmployeeWebModal: 'ผู้รับแจ้ง', idEmployeeWebModal: 'notifier', desc: false, inModal: false})" type="button" class="btn btn-default" ><i class="fa fa-search"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะใบรับงาน</label>
      <div class="col-sm-8">
        <select id="jobReceiptStatus" class="form-control" name="" disabled></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะการตัดใช้อะไหล่</label>
      <div class="col-sm-8">
        <select id="materialStatus" class="form-control statusYN" name="" disabled></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะการบันทึกค่าแรง</label>
      <div class="col-sm-8">
        <select id="laborStatus" class="form-control statusYN" name="" disabled></select>
      </div>
    </div>

  </div>
  <div class="col-lg-1"></div>
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประเภทใบรับงาน</label>
      <div class="col-sm-8">
        <select id="workReceiptType" class="form-control" name=""></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประมาณวันที่เริ่มซ่อม (WO)</label>
      <div class="col-sm-8">
        <input id="dateStartWO" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประมาณวันที่ซ่อมเสร็จ (WO)</label>
      <div class="col-sm-8">
        <input id="dateEndWO" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงานผู้แจ้ง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="reportingAgency" 
                  name="" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"
                  data-id="department_code" 
                  data-text="description"
                  data-field="select">
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="reportingAgencyLovBtn" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">เลขที่ใบสั่งงาน</label>
      <div class="col-sm-8">
        <input  id="workOrderNumber" 
                onkeypress="return /[0-9]/i.test(event.key)" 
                type="text" 
                class="form-control" 
                name="" 
                autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่แจ้งซ่อม From (WR)</label>
      <div class="col-sm-8">
        <input id="dateStartWR" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่แจ้งซ่อม To (WR)</label>
      <div class="col-sm-8">
        <input id="dateEndWR" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
  </div>
</div>
@endif