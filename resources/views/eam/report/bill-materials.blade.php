@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <x-get-page-title menu="" url="/eam/report/bill-materials" />
@stop

@section('content')
@php $checkAttrId = 'billMaterials' @endphp
<div id="eam0017" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
      <form onsubmit="formSaveBtnHide();return false;">
    <div class="row justify-content-center">

        <div class="col-11">
          <div class="text-right">
            <button id="undoBtn"
                    type="button" 
                    class="btn btn-default btn-lg mt-1" 
                    role="button" 
                    aria-pressed="true" 
                    style="width: 140px;">
              <i class="fa fa-undo"></i> ล้างค่า
            </button>
            <button id="createBtn" 
                    type="button" 
                    class="btn btn-success btn-lg mt-1" 
                    style="width: 140px;">
              สร้าง
            </button>
            <button id="saveBtn" 
                    type="button" 
                    class="btn btn-primary btn-lg mt-1" 
                    style="width: 140px;">
              บันทึก
            </button>
            <button id="printBtn" 
                    type="button" 
                    class="btn btn-info btn-lg mt-1" 
                    style="width: 140px;">
              <i class="fa fa-print fa-lg"></i> พิมพ์รายงาน
            </button>
          </div>
        </div>
        <div class="col-11">
          <div class="text-right">
            <button id="completeBtn" 
                    type="button" 
                    class="btn btn-primary btn-lg mt-1" 
                    style="width: 140px;">
              ยืนยันขอเบิกอะไหล่
            </button>
            <button id="cancleBtn" 
                    type="button" 
                    class="btn btn-danger btn-lg mt-1" 
                    style="width: 140px;">
              ยกเลิกขอเบิกอะไหล่
            </button>
          </div>
        </div>

        <div class="col-11 mt-5">
          @include('eam.report._form')
        </div>
        <div class="col-11 mt-4">
          <div class="text-right inline float-right">
            <button id="addTableBtn"
                    type="button" 
                    class="btn btn-success btn-lg mt-1" 
                    style="width: 140px;">
              <i class="fa fa-plus"></i> เพิ่มรายการ
            </button>
            <button id="deleteTableBtn" 
                    type="button" 
                    class="btn btn-danger btn-lg mt-1" 
                    style="width: 140px;">
              <i class="fa fa-times"></i> ลบรายการ
            </button>
          </div>
        </div>
        <div class="col-11 mt-4">
            @include('eam.report._table')
            <button id="saveBtnHide" class="d-none" ></button>
        </div>
    </div>
      </form>
  </div>
  @include('eam.report._modalLov')
</div>
@endsection
@section('scripts')
  @include('eam.commons.scripts.all-date');
  @include('eam.commons.scripts.clear-input');
  @include('eam.commons.scripts.drop-down-request-status');
  @include('eam.commons.scripts.drop-down-locator');
  @include('eam.commons.scripts.drop-down-subinventory');
  @include('eam.commons.scripts.lov-item-code');
  @include('eam.commons.scripts.lov-department');
  @include('eam.commons.scripts.lov-request-status');
  @include('eam.commons.scripts.lov-request-equip-no');
  <script>
    var defaultUser = {!! json_encode($user->toArray(), JSON_HEX_TAG) !!};
    var dataUserDefault = '';
    var department_desc = '';
    dataListItemCode();

    $("#formAll").removeClass('d-none');
    var statusCreate = false
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });

    setDatePicker({ idDate: 'modalReportBillMaterialsDateStart', 
                    nameDate: 'creation_date', 
                    onchange: false, 
                    date: '', 
                    disabled: false, 
                    required: false, 
                    dateEndId: `modalReportBillMaterialsDateStart`});
    setDatePicker({ idDate: 'modalReportBillMaterialsDateEnd', 
                    nameDate: 'creation_date_to', 
                    onchange: false, 
                    date: '', 
                    disabled: false, 
                    required: false});

    $.ajax({
      url: "{{ route('eam.ajax.lov.departments') }}",
      method: 'GET',
      data: {
        'p_department_code': defaultUser.department_code,
        'p_description': ''
      },
      success: function (response) {
        response.data.filter(row => {
          if(row.department_code == defaultUser.department_code) {
            department_desc = row.description
          }
        })

        //Default หน่วยงาน
        dataUserDefault = defaultUser.department_code;
        var newOptionRequestDepartment = new Option(defaultUser.department_code + ' - ' + department_desc, defaultUser.department_code, true, true);
        $('#requestDepartment').append(newOptionRequestDepartment).trigger('change');
        $('#requestDepartment').val(defaultUser.department_code).trigger('change');
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })

    setDefaultTableReport();
    checkDisabledBtnComCan();

    let thead = [
      {
        name: 'รหัสอะไหล่<label class="pl-1 text-danger">*</label>',
        style: 'min-width: 220px;'
      }, {
        name: 'คำอธิบาย',
        style: 'min-width: 270px;'
      }, {
        name: 'จำนวน<label class="pl-1 text-danger">*</label>',
        style: 'min-width: 80px;'
      }, {
        name: 'หน่วยนับ',
        style: 'min-width: 130px;'
      }, {
        name: 'หมายเหตุ',
        style: 'min-width: 250px;'
      }
    ]

    let theadTable  = '';
      theadTable    += `<th class="text-center" style="min-width: 100px;">`
      theadTable    += `<div>
                          <input id="checkboxAllTable" type="checkbox"> เลือกทั้งหมด
                        </div>`
      theadTable    += `</th>`
      thead.filter(row => {
        theadTable  += `<th class="text-center" style="${row.style}">`
        theadTable  += `<div>${row.name}</div>`
        theadTable  += `</th>`
     })
    $("#setTheadTable").html(theadTable);

    $("#undoBtn").click(() => {
      request_equip_h_id = '';
      $("#requestEquipNo").val('').trigger('change');
      $("#requestEquipNo").prop('disabled', false);
      $("#requestEquipNoLovBtn").prop('disabled', false);
      $("#requestDepartment").val(dataUserDefault);
      $("#requestDepartment").prop('disabled', true);
      $("#departmentLovBtn").prop('disabled', true);
      $("#requestStatus").val('').trigger('change');
      $("#requestStatus").prop('disabled', true);
      $("#saveBtn").prop('disabled', false);
      $("#printBtn").prop('disabled', false);
      $("#setTbodyTable").html('').trigger('change');
      $('#setTablePagination').html('').trigger('change');
      $("#subinventory").val('').trigger('change');
      $("#subinventory").prop('disabled', true);
      $("#locator").val('').trigger('change');
      $("#locator").prop('disabled', true);
      statusCreate = false
      setDefaultTableReport();
      checkDisabledBtnComCan();
      triggerSelect2();
      checkDisabledTable(true);
    })

    $("#createBtn").click(() => {
      $("#requestDepartment").prop('disabled', false);
      $("#departmentLovBtn").prop('disabled', false);
      $("#subinventory").prop('disabled', false);
      $("#locator").prop('disabled', false);
      if ($("#requestEquipNo").val() == null) {
        createNew();
        setDefaultTableReport();
        setSelect2InEAM0017();
        triggerSelect2();
        checkDisabledTable(true);
      } else {
        swal({
          title: "ต้องการสร้างข้อมูลใหม่",
          text: "",
          type: "warning",
          showCancelButton: true
        },
        function(){
          createNew();
          setDefaultTableReport();
          setSelect2InEAM0017();
          triggerSelect2();

          checkDisabledTable(false);
        })
      }
    })

    $("#saveBtn").click(() => {
      $("#saveBtnHide").click();
    })

    $("#printBtn").click(() => {
      var data = dataArrRequestEquipNo.find(element => element.request_equip_h_id == request_equip_h_id);
      if(data != null){
        var date1 = parseDate(conVertDate(data.request_date));
        var date2 = parseDate(conVertDate(data.request_date));

        vmDatePicker.modalReportBillMaterialsDateStart.pValue = date1 != null ? date1 : '';
        vmDatePicker.modalReportBillMaterialsDateEnd.pValue = date2 != null ? date2 : '';
      }else{
        vmDatePicker.modalReportBillMaterialsDateStart.pValue = '';
        vmDatePicker.modalReportBillMaterialsDateEnd.pValue = '';
      }
    
      $("#detailReportBillMaterials").modal('show');
      $("#modalReportBillMaterialsNumberStart").val($("#requestEquipNo").val());
      $("#modalReportBillMaterialsNumberEnd").val($("#requestEquipNo").val());
      $("#modalReportBillMaterialsRequestStatus").val('').trigger('change');
      $("#modalReportBillMaterialsRequestStatusDesc").val('');
      $("#modalReportBillMaterialsAgency").val('').trigger('change');
      $("#modalReportBillMaterialsAgencyDesc").val('');
    })

    $("#modalRequestStatusPrint").click(() => {
      $("#printBtnHide").click();
    })

    $("#deleteTableBtn").click(() => {
      let dataSaveCheckAdd = []
      let dataSave = []
      $("#setTbodyTable input[type='checkbox']:checked").each(function() {
        if ($(this).parents('tr').find("td:eq(11) input[type='text']").val() == 'add') {
          dataSaveCheckAdd.push($(this).parents('tr'));
        } else {
          let data = {
            request_equip_l_id:     $(this).parents('tr').find("td:eq(9) input[type='text']").val(),
            inventory_item_id:      $(this).parents('tr').find("td:eq(10) input[type='text']").val(),
            item_code:              $(this).parents('tr').find("td:eq(1) select").val(),
            item_description:       $(this).parents('tr').find("td:eq(2) input[type='text']").val(),
            required_quantity:      $(this).parents('tr').find("td:eq(7) input[type='text']").val(),
            item_primary_uom_code:  $(this).parents('tr').find("td:eq(8) input[type='text']").val(),
            remark:                 $(this).parents('tr').find("td:eq(12) input[type='text']").val(),
            request_equip_h_id:     request_equip_h_id
          }
          dataSave.push(data)
        }
      })
      if (dataSave.length > 0) {
        $.ajax({
          url: "{{ route('eam.ajax.bill-materials.delete-line') }}",
          method: 'DELETE',
          data: JSON.stringify({
            program_code:       "EAM0017",
            request_equip_h_id: request_equip_h_id,
            request_status:     $("#requestStatus").val(),
            department_code:    $("#requestDepartment").val() ? 
                                $("#requestDepartment").val() : '',
            department_desc:    $("#requestDepartment").val() ? 
                                $("#requestDepartment option:selected").text().split(' - ')[1] : '',
            to_subinventory:    $("#subinventory").val(),
            to_locator_code:    $("#locator").val(),
            line: dataSave
          }),
          headers: {
            'Accept':       'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          success: function (response) {
            swal("Success", response.message, "success");
            $("#requestEquipNo").val(response.data.request_equip_no);
            $("#requestStatus").val(response.data.request_status);
            request_equip_h_id = request_equip_h_id
            callApiBillMaterials(response.data.request_equip_h_id)
            checkDisabledBtnComCan();
            $("#checkboxAllTable").prop('checked',false);
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      } else if (dataSaveCheckAdd.length > 0) {
        dataSaveCheckAdd.filter(row => {
          $(row).remove();
        })
        $("#checkboxAllTable").prop('checked',false);
      } else {
        swal("กรุณาเลือกรายการ", "", "warning");
      }
    })

    function formSaveBtnHide() {
      if ($("#requestStatus").val()) {
        let dataSave = []
        $("#setTbodyTable tr").each(function() {
          let data = {
            request_equip_l_id:     $(this).find("td:eq(9) input[type='text']").val(),
            inventory_item_id:      $(this).find("td:eq(10) input[type='text']").val(),
            item_code:              $(this).find("td:eq(1) select").val(),
            item_description:       $(this).find("td:eq(2) input[type='text']").val(),
            from_subinventory:      $(this).find("td:eq(3) select").val(),
            from_locator_code:      $(this).find("td:eq(4) select").val(),
            to_subinventory:        $(this).find("td:eq(5) select").val(),
            to_locator_code:        $(this).find("td:eq(6) select").val(),
            required_quantity:      $(this).find("td:eq(7) input[type='text']").val(),
            item_primary_uom_code:  $(this).find("td:eq(8) input[type='text']").val(),
            remark:                 $(this).find("td:eq(12) input[type='text']").val(),
            request_equip_h_id:     request_equip_h_id
          }
          if (data.item_code != null) {
            dataSave.push(data)
          }
        })
        $.ajax({
          url: "{{ route('eam.ajax.bill-materials.store') }}",
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          data: JSON.stringify({
            program_code:       "EAM0017",
            request_equip_h_id: request_equip_h_id,
            request_status:     $("#requestStatus").val(),
            department_code:    $("#requestDepartment").val() ? 
                                $("#requestDepartment").val() : '',
            department_desc:    $("#requestDepartment").val() ? 
                                $("#requestDepartment option:selected").text().split(' - ')[1] : '',
            to_subinventory:    $("#subinventory").val(),
            to_locator_code:    $("#locator").val(),
            line: dataSave
          }),
          success: function (response) {
            swal("Success", response.message, "success");
            $("#requestDepartment").prop('disabled', true);
            $("#departmentLovBtn").prop('disabled', true);
            $("#subinventory").prop('disabled', true);
            $("#locator").prop('disabled', true);

            //Default เลขที่ใบขอเบิกอะไหล่
            var newOptionRequestEquipNo = new Option(response.data.request_equip_no, response.data.request_equip_no, true, true);
            $('#requestEquipNo').append(newOptionRequestEquipNo).trigger('change');
            $('#requestEquipNo').val(response.data.request_equip_no).trigger('change');

            //Default หน่วยงาน
            var newOptionDepartment = new Option(response.data.department_code + ' - ' + 
                                                 response.data.department_desc, response.data.department_code, true, true);
            $("#requestDepartment").append(newOptionDepartment).trigger('change');
            $("#requestDepartment").val(response.data.department_code).trigger('change');

            $("#requestStatus").val(response.data.request_status);

            request_equip_h_id = response.data.request_equip_h_id
            callApiBillMaterials(response.data.request_equip_h_id)
            checkDisabledBtnComCan();
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }

    function setDefaultTableReport() {
      $("#setTbodyTable").html('')
      let tbodyTableReport  = '';
      let optionActivity    = '';
      let indexCreate       = 0;

      let optionSuvinventoryStart = ''
      optionSuvinventoryStart += `<option value=""></option>`
      for (let data of dataDropDownSubinventory) {
        optionSuvinventoryStart += `<option value="${data.name}">${data.name}</option>`
      }
      let optionLocatorStart = `<option value=""></option>`

      let optionSuvinventoryEnd = ''
      optionSuvinventoryEnd += `<option value=""></option>`
      for (let data of dataDropDownSubinventory) {
        optionSuvinventoryEnd += `<option value="${data.name}">${data.name}</option>`
      }
      let optionLocatorEnd = `<option value=""></option>`

      for (var i = 0; i < 5; i++) {
        tbodyTableReport += `<tr>`
        tbodyTableReport += `<td class="text-center">
                              <input  type="checkbox" 
                                      name="case[]"
                                      onclick="checkSelect()">
                            </td>`
        tbodyTableReport += `<td>
                              <div class="input-group">
                                <select id="itemCodeCreate_`+ i +`"
                                        class="itemCode form-control clearable readonly" 
                                        data-server="/eam/ajax/lov/item-inventory"  
                                        data-id="item_code" 
                                        data-text="item_description"
                                        data-field="select"
                                        ${statusCreate ? '' : 'disabled'}
                                        data-setAjaxItemCode="itemCodeCreate_`+ i +`"
                                        data-setAjaxItemCodeDesc="label_itemCodeCreate_`+ i +`"
                                        data-setAjaxPrimaryUom="primaryUomCreate_`+ i +`"
                                        data-setAjaxInventoryItemId="inventoryItemIdCreate_`+ i +`">
                                </select>
                                <div class="input-group-append">
                                  <span class="input-group-append">
                                    <button onclick=" itemInventory({data1: this, data2: 'td:eq(2)', data3: 'td:eq(8)'})" 
                                                      type="button" 
                                                      class="btn btn-default" 
                                                      ${statusCreate ? '' : 'disabled'}><i class="fa fa-search"></i>
                                    </button>
                                  </span>
                                </div>
                              </div>
                            </td>`
        tbodyTableReport += `<td>
                                <input  type="text" 
                                        class="form-control" 
                                        name="desc" 
                                        value="" 
                                        disabled 
                                        autocomplete="off"
                                        id="label_itemCodeCreate_`+ i +`">
                            </td>`
        tbodyTableReport += `<td class="d-none">
                              <select class="form-control subinventoryTbS" 
                                      ${statusCreate ? '' : 'disabled'}>`+optionSuvinventoryStart+`
                              </select>
                            </td>`
        tbodyTableReport += `<td class="d-none">
                              <select class="form-control" 
                                      ${statusCreate ? '' : 'disabled'}>`+optionLocatorStart+`
                              </select>
                            </td>`
        tbodyTableReport += `<td class="d-none">
                              <select class="form-control subinventoryTbE" 
                                      disabled>`+optionSuvinventoryEnd+`
                              </select>
                            </td>`
        tbodyTableReport += `<td class="d-none">
                              <select class="form-control" 
                                      disabled>`+optionLocatorEnd+`
                              </select>
                            </td>`
        tbodyTableReport += `<td>
                              <input  type="text" 
                                      onkeypress="return /[0-9]/i.test(event.key)" 
                                      class="form-control" 
                                      value="" ${statusCreate ? '' : 'disabled'} 
                                      autocomplete="off">
                            </td>`
        tbodyTableReport += `<td> 
                                <input  class="form-control"
                                        type='text'
                                        disabled
                                        id="primaryUomCreate_`+ i +`">
                                </input>
                              </td>`
        tbodyTableReport += `<td class="d-none">
                                <input  type="text" 
                                        class="form-control" 
                                        value="" 
                                        hidden 
                                        autocomplete="off">
                            </td>`
        tbodyTableReport += `<td class="d-none">
                                <input  type="text" 
                                        class="form-control" 
                                        value="" 
                                        hidden 
                                        autocomplete="off"
                                        id="inventoryItemIdCreate_`+ i +`">
                              </td>`
        tbodyTableReport += `<td class="d-none">
                                <input  type="text" 
                                        class="form-control" 
                                        value="add" 
                                        hidden 
                                        autocomplete="off">
                            </td>`
        tbodyTableReport += `<td>
                                <input  type="text" 
                                        class="form-control" 
                                        value="" ${statusCreate ? '' : 'disabled'} 
                                        autocomplete="off">
                            </td>`
        tbodyTableReport += `</tr>`
      }
      $("#setTbodyTable").append(tbodyTableReport);

      changSubinventory();
    }

    $("#addTableBtn").click(()=>{
      setAddTableReport();
    })

    function setAddTableReport() {
      let indexTb = 0

      if ($("#requestStatus").val() == 'ยังไม่ส่งข้อมูล') {
        statusCreate = true
      } else {
        statusCreate = false
      }
      let tbodyTableReport = '';
      let optionActivity = '';

      let optionSuvinventoryStart = ''
      optionSuvinventoryStart += `<option value=""></option>`
      for (let data of dataDropDownSubinventory) {
        optionSuvinventoryStart += `<option value="${data.name}">${data.name}</option>`
      }
      let optionLocatorStart = `<option value=""></option>`

      let optionSuvinventoryEnd = ''
      optionSuvinventoryEnd += `<option value=""></option>`
      for (let data of dataDropDownSubinventory) {
        optionSuvinventoryEnd += `<option value="${data.name}">${data.name}</option>`
      }
      let optionLocatorEnd = `<option value=""></option>`

      if($("#setTbodyTable tr").length != 0){
        indexTb = parseInt(Math.random()*1000);
      }

      tbodyTableReport += `<tr>`
      tbodyTableReport += `<td class="text-center">
                            <input  type="checkbox" 
                                    name="case[]"
                                    onclick="checkSelect()">
                          </td>`
      tbodyTableReport += `<td>
                              <div class="input-group">
                                <select id="itemCodeAdd_`+ indexTb +`"
                                        class="itemCode form-control clearable readonly" 
                                        data-server="/eam/ajax/lov/item-inventory"  
                                        data-id="item_code" 
                                        data-text="item_description"
                                        data-field="select"
                                        ${statusCreate ? '' : 'disabled'}
                                        required
                                        data-setAjaxItemCode="itemCodeAdd_`+ indexTb +`"
                                        data-setAjaxItemCodeDesc="label_itemCodeAdd_`+ indexTb +`"
                                        data-setAjaxPrimaryUom="primaryUomAdd_`+ indexTb +`"
                                        data-setAjaxInventoryItemId="inventoryItemIdAdd_`+ indexTb +`">
                                </select>
                                <div class="input-group-append">
                                  <span class="input-group-append">
                                    <button onclick=" itemInventory({data1: this, data2: 'td:eq(2)', data3: 'td:eq(8)'})" 
                                                      type="button" 
                                                      class="btn btn-default" 
                                                      ${statusCreate ? '' : 'disabled'}><i class="fa fa-search"></i>
                                    </button>
                                  </span>
                                </div>
                              </div>
                            </td>`
      tbodyTableReport += `<td>
                              <input  type="text" 
                                      class="form-control" 
                                      name="desc" 
                                      value="" 
                                      disabled 
                                      autocomplete="off"
                                      id="label_itemCodeAdd_`+ indexTb +`">
                          </td>`
      tbodyTableReport += `<td class="d-none">
                        <select class="form-control subinventoryTbS" ${statusCreate ? '' : 'disabled'}>`+optionSuvinventoryStart+`</select></td>`
      tbodyTableReport += `<td class="d-none">
                            <select class="form-control" ${statusCreate ? '' : 'disabled'}>`+optionLocatorStart+`</select>
                          </td>`
      tbodyTableReport += `<td class="d-none">
                            <select class="form-control subinventoryTbE" disabled>`+optionSuvinventoryEnd+`</select>
                          </td>`
      tbodyTableReport += `<td class="d-none">
                            <select class="form-control" disabled>`+optionLocatorEnd+`</select>
                          </td>`
      tbodyTableReport += `<td>
                            <input  type="text" 
                                    onkeypress="return /[0-9]/i.test(event.key)" 
                                    class="form-control" 
                                    value="" ${statusCreate ? '' : 'disabled'} 
                                    required autocomplete="off">
                          </td>`
      tbodyTableReport += `<td>
                              <input  class="form-control"
                                      disabled
                                      type='text'
                                      id="primaryUomAdd_`+ indexTb +`">
                              </input>
                          </td>`
      tbodyTableReport += `<td class="d-none">
                            <input  type="text" 
                                    class="form-control" 
                                    value="" 
                                    hidden 
                                    autocomplete="off">
                          </td>`
      tbodyTableReport += `<td class="d-none">
                              <input  type="text" 
                                      class="form-control" 
                                      value="" 
                                      hidden 
                                      autocomplete="off"
                                      id="inventoryItemIdAdd_`+ indexTb +`">
                          </td>`
      tbodyTableReport += `<td class="d-none">
                              <input type="text" class="form-control" value="add" hidden autocomplete="off">
                          </td>`
      tbodyTableReport += `<td>
                              <input type="text" class="form-control" value="" ${statusCreate ? '' : 'disabled'} autocomplete="off">
                          </td>`
      tbodyTableReport += `</tr>`
      $("#setTbodyTable").append(tbodyTableReport);
      
      changSubinventory();
      setSelect2InEAM0017();
      triggerSelect2();

      $('#itemCodeAdd_' + indexTb).on('select2:select', function (e) {
        $(this).select2('data')[0].text = $(this).select2('data')[0].id;
        let value = '';
        let index = '';
        let indexLoop = '';
        value = $(this).val();
        index = $('#itemCodeAdd_' + indexTb).attr('id');

        $.each($("#setTbodyTable tr").find("td:eq(1) select"), function (key, val) {
          if(value == $(this).val()){
            indexLoop = $(this).attr('id');
            if(indexLoop != index){
              $('#itemCodeAdd_' + indexTb).val('').trigger('change');
              $('#label_itemCodeAdd_' + indexTb).val('');
              $('#primaryUomAdd_' + indexTb).empty().trigger('change');
              $('#inventoryItemIdAdd_' + indexTb).val('');
              swal("Error", "ไม่สามารถเลือก Item Code นี้ได้เนื่องจากมีการซ้ำของข้อมูล", "error");
              return;
            }
          }  
        });
      });

      $('#itemCodeAdd_' + indexTb).on('select2:clear', function (e) {
        $('#label_itemCodeAdd_' + indexTb).val('');
        $('#primaryUomAdd_' + indexTb).empty().trigger('change');
      });
    }

    function fnReSC(str) {
      var strNew  = str;
      strNew      = strNew.replace(/\"/g, "''");
      return strNew;
    }

    function setTableReportFn(data) {
      let dataArr = data.data;
      let tbodyTableReport = '';

      if ($("#requestStatus").val() == 'ส่งข้อมูลเรียบร้อย') {
        statusCreate = false;
      } else {
        statusCreate = true;
      }     

      if (data.data.length > 0) {
        data.data.filter((row, index) => {
          let optionSuvinventoryStart = ''
          optionSuvinventoryStart += `<option value=""></option>`
          for (let data of dataDropDownSubinventory) {
            optionSuvinventoryStart += `<option value="${data.name}" 
                                                ${row.from_subinventory == data.name ? 'selected' : ''}>
                                                ${data.name}
                                        </option>`
          }
          let optionLocatorStart = ''
          optionLocatorStart += `<option value=""></option>`
          for (let data of dataDropDownLocator) {
            if (data.subinventory_name == row.from_subinventory) {
              optionLocatorStart += `<option  value="${data.locator_name}" 
                                              ${row.from_locator_code == data.locator_name ? 'selected' : ''}>
                                              ${data.subinventory_name}.${data.locator_name}
                                    </option>`
            }
          }
          let optionSuvinventoryEnd = ''
          optionSuvinventoryEnd += `<option value=""></option>`
          for (let data of dataDropDownSubinventory) {
            optionSuvinventoryEnd += `<option value="${data.name}" 
                                              ${row.to_subinventory == data.name ? 'selected' : ''}>
                                              ${data.name}
                                      </option>`
          }
          let optionLocatorEnd = ''
          optionLocatorEnd += `<option value=""></option>`
          for (let data of dataDropDownLocator) {
            if (data.subinventory_name == row.to_subinventory) {
              optionLocatorEnd += `<option  value="${data.locator_name}" 
                                            ${row.to_locator_code == data.locator_name ? 'selected' : ''}>
                                            ${data.subinventory_name}.${data.locator_name}
                                  </option>`
            }
          }

          tbodyTableReport += `<tr>`
          tbodyTableReport +=   `<td class="text-center">
                                  <input  type="checkbox" 
                                          name="case[]"
                                          onclick="checkSelect()">
                                </td>`
          tbodyTableReport += `<td>
                                <div class="input-group">
                                  <select id="itemCode_`+ index +`"
                                          class="itemCode form-control clearable readonly" 
                                          data-server="/eam/ajax/lov/item-inventory"  
                                          data-id="item_code" 
                                          data-text="item_description"
                                          data-field="select"
                                          ${statusCreate ? '' : 'disabled'} 
                                          required
                                          data-setAjaxItemCode="itemCode_`+ index +`"
                                          data-setAjaxItemCodeDesc="label_itemCode_`+ index +`"
                                          data-setAjaxPrimaryUom="primaryUom_`+ index +`"
                                          data-setAjaxInventoryItemId="inventoryItem_`+ index +`">
                                  </select>
                                  <div class="input-group-append">
                                    <span class="input-group-append">
                                      <button onclick=" itemInventory({data1: this, data2: 'td:eq(2)', data3: 'td:eq(8)'})" 
                                                        type="button" 
                                                        class="btn btn-default" 
                                                        ${statusCreate ? '' : 'disabled'}><i class="fa fa-search"></i>
                                      </button>
                                    </span>
                                  </div>
                                </div>
                              </td>`
          tbodyTableReport += `<td>
                                  <input  type="text" 
                                          class="form-control" 
                                          name="desc" 
                                          disabled 
                                          autocomplete="off"
                                          id="label_itemCode_`+ index +`">
                              </td>`
          tbodyTableReport += `<td class="d-none">
                                  <select class="form-control subinventoryTbS" 
                                          ${statusCreate ? '' : 'disabled'}>`+optionSuvinventoryStart+`
                                  </select>
                                </td>`
          tbodyTableReport += `<td class="d-none">
                                  <select class="form-control" 
                                          ${statusCreate ? '' : 'disabled'}>`+optionLocatorStart+`
                                  </select>
                              </td>`
          tbodyTableReport += `<td class="d-none">
                                  <select class="form-control subinventoryTbE" 
                                          disabled>`+optionSuvinventoryEnd+`
                                  </select>
                              </td>`
          tbodyTableReport += `<td class="d-none">
                                  <select class="form-control" 
                                          disabled>`+optionLocatorEnd+`
                                  </select>
                              </td>`
          tbodyTableReport += `<td>
                                  <input  type="text" 
                                          onkeypress="return /[0-9]/i.test(event.key)" 
                                          class="form-control" 
                                          value="${row.required_quantity ? row.required_quantity : ''}" 
                                          ${statusCreate ? '' : 'disabled'} 
                                          required 
                                          autocomplete="off">
                              </td>`
          tbodyTableReport += `<td>
                                  <input  class="form-control"
                                          disabled
                                          type='text'
                                          id="primaryUom_`+ index +`">
                                  </input>
                              </td>`
          tbodyTableReport += `<td class="d-none">
                                  <input  type="text" 
                                          class="form-control" 
                                          value="${row.request_equip_l_id ? row.request_equip_l_id : ''}" 
                                          hidden 
                                          autocomplete="off">
                              </td>`
          tbodyTableReport += `<td class="d-none">
                                  <input  type="text" 
                                          class="form-control" 
                                          value="${row.inventory_item_id ? row.inventory_item_id : ''}" 
                                          hidden 
                                          autocomplete="off"
                                          id="inventoryItem_`+ index +`">
                              </td>`
          tbodyTableReport += `<td class="d-none">
                                  <input  type="text" 
                                          class="form-control" 
                                          value="" 
                                          hidden 
                                          autocomplete="off">
                              </td>`
          tbodyTableReport += `<td>
                                  <input  type="text" 
                                          class="form-control" 
                                          value="${row.remark ? row.remark : ''}" 
                                          ${statusCreate ? '' : 'disabled'} 
                                          autocomplete="off">
                              </td>`
          tbodyTableReport += `</tr>`
          
        })
      }
      $("#setTbodyTable").html(tbodyTableReport);
      changSubinventory();
      setSelect2InEAM0017();
      triggerSelect2();

      if (data.data.length > 0) {
        let pagination = '<ul class="pagination float-right">';
        $.each(data.links , function( i , link ){
          pagination += `<li  class="footable-page ${link.active ? 'active' : ''}"
                              style="padding-top: 15px;">
                          <a onclick="searchTableReportPagination('` + link.url + `')">${link.label}</a>
                        </li>`
        });
        pagination += '</ul>';
        $('#setTablePagination').html(pagination);
      }

      data.data.filter((row, index) =>{
        //Default รหัสอะไหล่
        var newOptionItemCode = new Option(row.item_code, row.item_code, true, true);
        $('#itemCode_'+ index).append(newOptionItemCode).trigger('change');
        $('#itemCode_'+ index).val(row.item_code).trigger('change');

        //Default คำอธิบาย
        $('#label_itemCode_'+ index).val(row.item_description).trigger('change');

        //Default หน่วยนับ
        $("#primaryUom_"+ index).val(row.item_primary_uom_code).trigger('change');

        $('#itemCode_' + index).on('select2:clear', function (e) {
          $('#label_itemCode_' + index).val('');
          $('#primaryUom_' + index).val('');
          $('#inventoryItem_' + index).val('');
        });

        $('#itemCode_' + index).on('select2:select', function (e) {
          $(this).select2('data')[0].text = $(this).select2('data')[0].id;

          let value = '';
          let indexNow = '';
          let indexLoop = '';
          value = $(this).val();
          indexNow = $(this).attr('id');

          $.each($("#setTbodyTable tr").find("td:eq(1) select"), function (key, val) {
            if(value == $(this).val()){
              indexLoop = $(this).attr('id');
              if(indexLoop != indexNow){
                $('#itemCode_' + index).val('').trigger('change');
                $('#label_itemCode_' + index).val('');
                $('#primaryUom_' + index).empty().trigger('change');
                $('#inventoryItem_' + index).val('');
                swal("Error", "ไม่สามารถเลือก Item Code นี้ได้เนื่องจากมีการซ้ำของข้อมูล", "error");
                return;
              }
            }  
          });

        });
      })
    }

    function searchTableReportPagination(data, statusCreate) {
      if (data != 'null') {
        $.ajax({
          url: data,
          data: {
            request_equip_h_id: request_equip_h_id
          },
          method: 'GET',
          success: function (response) {
            $.when(setTableReportFn(response.data)).then(function() {
              if($("#requestStatus").val() == 'ส่งข้อมูลเรียบร้อย'){
                $("#addTableBtn").prop('disabled', true);
                $("#deleteTableBtn").prop('disabled', true);
                $("#saveBtn").prop('disabled', true);
                $("#checkboxAllTable").prop('disabled', true);
                $('td input:checkbox').prop('disabled', true);
              }else{
                $("#addTableBtn").prop('disabled', false);
                $("#deleteTableBtn").prop('disabled', false);
                $("#saveBtn").prop('disabled', false);
                $("#checkboxAllTable").prop('disabled', false);
                $('td input:checkbox').prop('disabled', false);
              }
            }) 
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }

    $("#checkboxAllTable").click((e) => {
      var table = $(e.target).closest('table');
      if ($("#checkboxAllTable").prop('checked')) {
        $('td input:checkbox:not([disabled])', table).prop('checked', $("#checkboxAllTable").prop('checked'));
      } else {
        $('td input:checkbox', table).prop('checked', $("#checkboxAllTable").prop('checked'));
      }
    })

    function createNew() {
      statusCreate = true;
      request_equip_h_id = '';

      $("#requestEquipNo").val('');
      $("#subinventory").val('').trigger('change');
      $("#locator").val('').trigger('change');

      //Default หน่วยงาน
      dataUserDefault = defaultUser.department_code;
      var newOptionRequestDepartment = new Option(defaultUser.department_code + ' - ' + department_desc, defaultUser.department_code, true, true);
      $('#requestDepartment').append(newOptionRequestDepartment).trigger('change');
      $('#requestDepartment').val(defaultUser.department_code).trigger('change');

      $("#requestStatus").val('ยังไม่ส่งข้อมูล');
      $("#requestEquipNo").prop('disabled', true);
      $("#requestEquipNoLovBtn").prop('disabled', true);
      $("#requestStatus").prop('disabled', true);
      checkDisabledBtnComCan();
      triggerSelect2();

      if($("#requestEquipNo").val() == null){
        checkDisabledTable(true);
      }else{
        checkDisabledTable(false);
      }
    }

    function callApiBillMaterials(data) {
      $.ajax({
        url: "{{ route('eam.ajax.bill-materials.show',['']) }}",
        data: {
          request_equip_h_id: data
        },
        method: 'GET',
        success: function (response) {
          $.when(setTableReportFn(response.data)).then(function() {
            if($("#requestStatus").val() == 'ส่งข้อมูลเรียบร้อย'){
              $("#addTableBtn").prop('disabled', true);
              $("#deleteTableBtn").prop('disabled', true);
              $("#saveBtn").prop('disabled', true);
              $("#checkboxAllTable").prop('disabled', true);
              $('td input:checkbox').prop('disabled', true);
            }else if($("#requestStatus").val() == 'WMS รับข้อมูลเรียบร้อย'){
              $("#saveBtn").prop('disabled', true);
              checkDisabledTable(true);
            }else{
              $("#addTableBtn").prop('disabled', false);
              $("#deleteTableBtn").prop('disabled', false);
              $("#saveBtn").prop('disabled', false);
              $("#checkboxAllTable").prop('disabled', false);
              $('td input:checkbox').prop('disabled', false);
            }
          }) 
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }

    $("#completeBtn").click(() => {
      var url = '{{ route("eam.ajax.bill-materials.confirm", ":id") }}'+'?'+'program_code=EAM0017'
      $.ajax({
        url: url.replace(':id', request_equip_h_id),
        method: 'PUT',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function (response) {
          swal("Success", response.message, "success");
          completeBtnLovRequestEquipNo(response.data.request_equip_no)
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })

    $("#cancleBtn").click(() => {
      var url = '{{ route("eam.ajax.bill-materials.cancel", ":id") }}'+'?'+'program_code=EAM0017'
      $.ajax({
        url: url.replace(':id', request_equip_h_id),
        method: 'PUT',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function (response) {
          swal("Success", response.message, "success");
          completeBtnLovRequestEquipNo(response.data.request_equip_no)
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })

    $("#subinventory").change(() => {
      let optionLocator = ''
      optionLocator += `<option value=""></option>`
      for (let data of dataDropDownLocator) {
        if (data.subinventory_name == $("#subinventory").val()) {
          optionLocator += `<option value="${data.locator_name}">${data.subinventory_name}.${data.locator_name}</option>`
        }
      }
      $('#locator').html(optionLocator)
    })

    function checkDisabledBtnComCan() {
      if ($("#requestStatus").val() == 'ยังไม่ส่งข้อมูล') {
        $("#completeBtn").prop('disabled', false);
        $("#cancleBtn").prop('disabled', true);
      } else if ($("#requestStatus").val() == 'ส่งข้อมูลเรียบร้อย') {
        $("#completeBtn").prop('disabled', true);
        $("#cancleBtn").prop('disabled', false);
      } else {
        $("#completeBtn").prop('disabled', true);
        $("#cancleBtn").prop('disabled', true);
      }
    }

    $('#requestEquipNo').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    $('#requestEquipNo').on('select2:clear', function (e) {
      $('#requestStatus').val('');
    });

    $('#modalReportBillMaterialsRequestStatus').on('select2:clear', function (e) {
      $('#modalReportBillMaterialsRequestStatusDesc').val('');
    });

    $('#modalReportBillMaterialsAgency').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    $('#modalReportBillMaterialsAgency').on('select2:clear', function (e) {
      $('#modalReportBillMaterialsAgencyDesc').val('');
    });

    function checkDisabledTable(value){
      $("#addTableBtn").prop('disabled', value);
      $("#deleteTableBtn").prop('disabled', value);

      $("#setTbodyTable input[type='text']").prop('disabled', value);
      $("#setTbodyTable button[type='button']").prop('disabled', value);
      $("#setTbodyTable select").prop('disabled', value);
      $("#checkboxAllTable").prop('disabled', value);
      $("#checkboxAllTable").prop('checked', false);
      $("#setTbodyTable input[type='checkbox']").prop('disabled', value);
      $("#setTbodyTable input[name='desc']").prop('disabled', true);
    }
    checkDisabledTable(true);

    function checkSelect(){
      if($("#setTbodyTable input[type='checkbox']").length == 0){
        $("#checkboxAllTable").prop('checked',false);
      }else{
        if($("#setTbodyTable input[type='checkbox']:checked").length != 
          $("#setTbodyTable input[type='checkbox']").length){
          $("#checkboxAllTable").prop('checked',false);
        }else{
          $("#checkboxAllTable").prop('checked',true);
        }
      }
    }

  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection
