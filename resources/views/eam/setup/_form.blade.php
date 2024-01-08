@if ($checkAttrId == 'machine')
<div id="machine" class="row justify-content-center">
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">EAM Organization<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <input  id="eamOganization" 
                type="text" 
                class="form-control" 
                autocomplete="off" 
                style="color: #000000; background-color :#eeeeee; font-size: 13px;"
                disabled 
                required>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Asset Number<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <div class="input-group assetVNumberRead">
          <input  id="assetVNumber" 
                  type="text" 
                  class="form-control clearable readonly" 
                  autocomplete="off" 
                  required
                  disabled>
        </div>
        <div class="input-group assetVNumber">
          <input id="assetVNumber" type="text" class="form-control clearable" autocomplete="off" required>
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Asset Group<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="machineGroup" class="form-control" disabled required></select>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Asset Category
      </label>
      <div class="col-sm-8">
        <div class="input-group">
          <input id="assetCategory" type="text" class="form-control clearable readonly"  autocomplete="off" disabled>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="assetCategoryLovBtn" type="button" class="btn btn-default" disabled><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Owning Department<label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <div class="input-group" style="flex-wrap: nowrap;">
          <select id="notifyingAgency" 
                  class="form-control clearable readonly" 
                  data-server="/eam/ajax/lov/departments"  
                  data-id="department_code" 
                  data-text="description" 
                  data-field="select"
                  disabled
                  required>
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="notifyingAgencyLovBtn" onclick="departmentLovBtnOnclick({nameDepartmentModal: 'Owning Department', idDepartmentModal: 'notifyingAgency', desc: false, inModal: false})" type="button" class="btn btn-default" disabled><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Parent Asset Number</label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="assetNumber" 
                    class="form-control clearable readonly" 
                    data-server="/eam/ajax/lov/assetnumber"  
                    data-id="asset_number" 
                    data-text="description" 
                    data-field="select"
                    data-department="true"
                    disabled>
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="assetNumberOwLovBtn" type="button" class="btn btn-default" disabled><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Production Organization</label>
      <div class="col-sm-8">
        <select id="productionOrganization" class="form-control" disabled></select>
      </div>
    </div>

    <input id="resource" type="hidden" class="form-control"  maxlength="16" autocomplete="off" disabled required>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Usage UOM <label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-3">
        <select id="usageUOMDropdown" class="form-control" disabled required></select>
      </div>
      <div class="col-sm-3">
        <input  id="usageUOMInput" 
                type="text" 
                class="form-control" 
                style="color: #000000; background-color :#eeeeee; font-size: 13px;"
                autocomplete="off" 
                disabled>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ขั้นตอนการทำงาน <label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="workProcedure" class="form-control" disabled required></select>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">
        <span style="margin-top: -7px;display: block;">หน่วยนับ</span>
        <br>
        <span style="margin-top: -22px;display: block;">ขั้นตอนการทำงาน</span>
      </label>
      <div class="col-sm-8">
        <input  id="wipStepIpDesc" 
                type="text" 
                class="form-control" 
                style="color: #000000; background-color :#eeeeee; font-size: 13px;"
                disabled 
                autocomplete="off">
      </div>
    </div>

  </div>

  <div class="col-lg-1"></div>

  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Active</label>
      <div class="col-sm-8" style="padding-left: 35px; padding-bottom: 35px;">
        <input  id="active" 
                type="checkbox" 
                class="form-check-input" 
                disabled 
                autocomplete="off"
                onclick="$(this).val(this.checked ? 'Y' : 'N')">
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">FA Number</label>
      <div class="col-sm-8">
        <div class="input-group">
          <input id="faNumber" type="text" class="form-control" autocomplete="off" disabled>
          <button id="faNumberBtn" type="button" class="button-select-angle" disabled><i class="fa fa-chevron-down"></i></button>
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Asset Description <label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <input id="assetDescription" type="text" class="form-control" autocomplete="off" disabled required>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Asset Serial Number <label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <input id="assetSerialNumber" type="text" class="form-control" autocomplete="off" disabled required>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">
        WIP Accounting Class
      </label>
      <div class="col-sm-8">
        <div class="input-group">
          <select id="class" 
                  name="owning_dept_code" 
                  class="form-control clearable" 
                  data-server="/eam/ajax/lov/wipclass"  
                  data-id="class_code" 
                  data-text="description" 
                  data-field="select"
                  disabled>
          </select>
          <div class="input-group-append">
            <span class="input-group-append">
              <button id="classLovBtn" onclick="wipClassLovBtnOnclick({nameWipClassModal: 'WIP Accounting Class', idWipClassModal: 'class', desc: false, inModal: false})" type="button" class="btn btn-default" disabled><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Area</label>
      <div class="col-sm-8">
        <div class="input-group">
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
      <label class="col-sm-4 col-form-label">เป็น JP หรือไม่ <label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="jpStatus" onchange="changeJPStatus()" class="form-control statusYN" disabled required></select>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่ติดตั้งเครื่องจักร <label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <input id="machineInstallDate" type="text" class="form-control dateTable" autocomplete="off" disabled required>
      </div>
    </div>

    <input id="description" type="hidden" class="form-control" autocomplete="off" disabled>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ประเภทเครื่องจักร <label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <select id="machineType" class="form-control" disabled required></select>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">% ประสิทธิภาพ <label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <input  id="performancePrecent" 
                type="number" 
                pattern="\d*" 
                class="form-control" 
                style="color: #000000; background-color :#eeeeee; font-size: 13px;"
                autocomplete="off" 
                disabled 
                required>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-4 col-form-label">ความเร็วเครื่องจักร <label class="pl-1 text-danger">*</label></label>
      <div class="col-sm-8">
        <input  id="machineSpeed" 
                type="number" 
                pattern="\d*" 
                class="form-control" 
                style="color: #000000; background-color :#eeeeee; font-size: 13px;"
                disabled 
                required 
                autocomplete="off">
      </div>
    </div>
  </div>
</div>
@endif