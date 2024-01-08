@if ($checkAttrId == 'preventiveMaintenancePlan')
<div id="preventiveMaintenancePlan" class="row justify-content-center">
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ปีงบประมาณ<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="yearPlan" class="form-control" required></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะของแผน</label>
      <div class="col-sm-8">
        <input  id="statusPlan" 
                type="text" 
                class="form-control" 
                style="color: #000000; background-color :#eeeeee; font-size: 13px;" 
                autocomplete="off" 
                disabled>
      </div>
    </div>
  </div>
  <div class="col-lg-1"></div>
  <div class="col-lg-5">

    <div class="form-group row mb-1">
      <label class="col-sm-4 col-form-label">Version</label>
      <div class="col-sm-8">
        <select id="versionPlan" class="form-control" disabled ></select>
      </div>
    </div>
    <div class="form-group row ">
      <label class="col-sm-4 col-form-label">Version เดิม</label>
      <div class="col-sm-8">
        <input  id="oldVersionPlan" 
                class="form-control" 
                disabled 
                style="color: #000000; background-color :#eeeeee; font-size: 13px;">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ผู้สร้างแผนซ่อมบำรุง</label>
      <div class="col-sm-8">
        <div class="input-group">
          <input  id="nameCreate" 
                  type="text" 
                  class="form-control" 
                  autocomplete="off" 
                  disabled
                  style="color: #000000; background-color :#eeeeee; font-size: 13px;">
          <button id="nameCreateBtn" type="button" class="button-select-angle" disabled><i class="fa fa-chevron-down"></i></button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-5 mt-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Asset Number</label>
      <div class="col-sm-8">
        <div class="input-group">
          {{-- <input id="assetNumber" type="text" class="form-control clearable readonly" autocomplete="off" disabled> --}}
          <select id="assetNumber" 
                    class="form-control clearable readonly" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select"
                    disabled>
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
      <label class="col-sm-4 col-form-label">กลุ่มเครื่องจักร</label>
      <div class="col-sm-8">
        <select id="machineGroup" class="form-control" disabled></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงานผู้รับแจ้ง</label>
      <div class="col-sm-8">
        <div class="input-group">
          {{-- <input id="notifyingAgency" type="text" class="form-control clearable readonly" autocomplete="off" disabled> --}}
          <select id="notifyingAgency" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"  
                  data-id="department_code" 
                  data-text="description" 
                  data-field="select"
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
      <label class="col-sm-4 col-form-label">วันที่เริ่มซ่อม</label>
      <div class="col-sm-8">
        <input id="repairStartDate" type="text" class="form-control dateTable" autocomplete="off" disabled>
      </div>
    </div>
  </div>
  <div class="col-lg-1"></div>
  <div class="col-lg-5 mt-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">กิจกรรม</label>
      <div class="col-sm-8">
        <select id="activitiesToDo" class="form-control" disabled></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">พื้นที่</label>
      <div class="col-sm-8">
        <div class="input-group">
          {{-- <input id="area" type="text" class="form-control clearable readonly" autocomplete="off" disabled> --}}
          <select id="area" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/area"  
                  data-id="area" 
                  data-text="description" 
                  data-field="select"
                  disabled>
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="areaLovBtn" type="button" class="btn btn-default" disabled><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">สถานะเปิดงานซ่อม</label>
      <div class="col-sm-8">
        <select id="repairOpenStatus" class="form-control statusYN" disabled></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่ซ่อมเสร็จ</label>
      <div class="col-sm-8">
        <input id="repairEndDate" type="text" class="form-control dateTable" autocomplete="off" disabled>
      </div>
    </div>
  </div>
</div>
@endif
