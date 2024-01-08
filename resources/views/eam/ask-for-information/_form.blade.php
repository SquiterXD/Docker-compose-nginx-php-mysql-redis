@if ($checkAttrId == 'checkSparePartsInventory')
<div id="checkSparePartsInventory" class="row">
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Item Code</label>
      <div class="col-sm-8">
        <input id="itemCode" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Item Description</label>
      <div class="col-sm-8">
        <input id="itemDescription" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Part Number</label>
      <div class="col-sm-8">
        <input id="partNumber" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Old Item Number</label>
      <div class="col-sm-8">
        <input id="oldOtemNumber" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Part Number Old</label>
      <div class="col-sm-8">
        <input id="partNumberOld" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
  </div>
  <div class="col-lg-1"></div>
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">machine 01</label>
      <div class="col-sm-8">
        {{-- <input id="machine01" type="text" class="form-control" name="" autocomplete="off"> --}}
        <select id="machine01" class="form-control" name="" autocomplete="off"></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">machine 02</label>
      <div class="col-sm-8">
        {{-- <input id="machine02" type="text" class="form-control" name="" autocomplete="off"> --}}
        <select id="machine02" class="form-control" name="" autocomplete="off"></select>

      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Subinventory</label>
      <div class="col-sm-8">
        <select id="subinventory" class="form-control" name="work_request_priority_id"></select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">Locator</label>
      <div class="col-sm-8">
        <select id="locator" class="form-control" name="work_request_priority_id"></select>
      </div>
    </div>
  </div>
</div>
@elseif ($checkAttrId == 'partsTransferredWarehouse')
<div id="partsTransferredWarehouse" class="row">
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">วันที่</label>
      <div class="col-sm-8">
        <input id="date" type="text" class="form-control dateTable" name="" autocomplete="off">
      </div>
    </div>
  </div>
  <div class="col-lg-1"></div>
  <div class="col-lg-5">
    <div class="form-group row">
      <label class="col-sm-4 col-form-label">หน่วยงานที่ขอเบิก</label>
      <div class="col-sm-8">
        <input id="agency" type="text" class="form-control" name="" disabled autocomplete="off">
      </div>
    </div>
  </div>
</div>
@endif
