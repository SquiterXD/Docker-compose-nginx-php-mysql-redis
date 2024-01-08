<script>
  var statusDefault   = false;
  var costClickStatus = '';

  function workOrderlbAll() {
    $.ajax({
      url: "{{ route('eam.ajax.work-order.lb.all',['']) }}/" + wip_entity_id,
      method: 'GET',
      success: function (response) {
        if (response.data.length > 0) {
          setTableSaveCost(response);
        } else {
          setDefaultTableSaveCost()
        }
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
  }

  function setTableSaveCost(data) {
    let tbodyTableSaveCost = ''
    let sum10 = 0
    let indexShow = 0;
    if (data.data.length > 0) {
      $("#saveCostCheckBox").prop('disabled', false);
      $("#checkboxAllTableSaveCost").prop('disabled', false);
      if ($("#jobReceiptStatus").val() == 4) {
        $("#saveCostCheckBox").prop('disabled', true);
      }
      data.data.filter((row, index) => {
        if (row.transfer_flag != 'Y') {
          $("#saveCostCheckBox").prop('disabled', true);
        }
        let optionWorkOrder = ''
        optionWorkOrder += `<option value=""></option>`
        for (let data of dataDropDownWorkOrder) {
          optionWorkOrder += `<option value="${data.operation_seq_num}"
                                      ${row.operation_seq_num == data.operation_seq_num ? 'selected' : ''}>
                                      ${data.operation_seq_num}
                              </option>`
        }
        let optionTechnicianGroupOrder = ''
        optionTechnicianGroupOrder += `<option value=""></option>`
        for (let data of dataDropdownTechnicianGroupOrder) {
          if (data.operation_seq_num == row.operation_seq_num) {
            optionTechnicianGroupOrder += `<option  value="${data.resource_code}" 
                                                    ${row.resource_code == data.resource_code ? 'selected' : ''}>
                                                    ${data.description}
                                          </option>`
          }
        }
        let optionReson = ''
        optionReson += `<option value=""></option>`
        for (let data of dataDropdownResons) {
          optionReson += `<option value="${data.reason_id}" 
                                  ${row.reason_id == data.reason_id ? 'selected' : ''}>
                                  ${data.reason_name}
                          </option>`
        }
        tbodyTableSaveCost += `<tr>`
        tbodyTableSaveCost += `<td class="text-center">
                                <input  type="checkbox" 
                                        onclick="checkBoxTbLBOnClick()" 
                                        name="case[]"
                                        ${statusDisabledLb ? 'disabled' : ''}>
                              </td>`
        tbodyTableSaveCost += `<td>
                                <input  type="text" 
                                        class="form-control" 
                                        value="${row.transfer_flag_desc ? row.transfer_flag_desc : ''}" 
                                        disabled 
                                        autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td>
                                <select class="form-control workOrderTbLB" 
                                        required 
                                        ${statusDisabledLb || 
                                          row.transfer_flag_desc == 'CANCEL' || 
                                          row.transfer_flag_desc == 'COMPLETE' ? 'disabled' : ''}>`+optionWorkOrder+`
                                </select>
                                <input  type="hidden" 
                                        class="sum10" 
                                        value="${+sum10 + 10}">
                              </td>`
        tbodyTableSaveCost += `<td>
                                <select class="form-control technicianGroupOrderTbLB" 
                                        required 
                                        ${statusDisabledLb || 
                                          row.transfer_flag_desc == 'CANCEL' || 
                                          row.transfer_flag_desc == 'COMPLETE' ? 'disabled' : ''}>`+optionTechnicianGroupOrder+`
                                </select>
                              </td>`
        tbodyTableSaveCost += `<td>
                                <div class="input-group">
                                  <select id="employeeTbLB${+sum10 + 10}"
                                          class="employeeTbLB form-control readonly" 
                                          data-server="/eam/ajax/lov/resource-employee"  
                                          data-id="employee_number" 
                                          data-field="select"
                                          ${row.employee_name && 
                                            !statusDisabledLb && 
                                            row.transfer_flag_desc != 'CANCEL' && 
                                            row.transfer_flag_desc != 'COMPLETE' 
                                            ? 'clearable x' : ''}"                                             
                                          required 
                                          ${statusDisabledLb || 
                                            row.transfer_flag_desc == 'CANCEL' || 
                                            row.transfer_flag_desc == 'COMPLETE' ? 'disabled' : ''}
                                          data-setAjaxDetailEmployeeTbLB="employeeTbLB${+sum10 + 10}"
                                          data-typeAjaxDetailEmployeeTbLB="employeeTbLB${+sum10 + 10}"
                                          data-setAjaxDetailEmployeeTbLBId="employeeTbLB${+sum10 + 10}Id">
                                  </select>
                                  <div class="input-group-append">
                                    <span class="input-group-append">
                                      <button onclick="resourceEmployeeLovBtnTableOnclick({nameEmployeeModal: 'รหัสพนักงาน', idEmployeeModal: 'employeeTbLB${+sum10 + 10}', locationResourceEmployee: 'technicianGroupOrde', desc: false, inModal: false})" 
                                              type="button" 
                                              class="btn btn-default" 
                                              ${statusDisabledLb || 
                                                row.transfer_flag_desc == 'CANCEL' || 
                                                row.transfer_flag_desc == 'COMPLETE' ? 'disabled' : ''}>
                                        <i class="fa fa-search"></i>
                                      </button>
                                    </span>
                                  </div>
                                </div>
                              </td>`
        tbodyTableSaveCost += `<td>
                                <input  type="text" 
                                        class="form-control" 
                                        value="${row.employee_num ? row.employee_num : ''}" 
                                        disabled 
                                        autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td>
                                <input  id="dateTableStartSaveCostFrom${index}" 
                                        type="text" 
                                        class="form-control" 
                                        value="" 
                                        autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td>
                                <input  id="dateTableStartSaveCostTo${index}" 
                                        type="text" 
                                        class="form-control" 
                                        value="" 
                                        autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td class="">
                                <input  type="text" 
                                        class="form-control text-right" 
                                        id="dateTableAttribute4Day-${index}"  
                                        value="${row.attribute4 ? row.attribute4 : ''}" 
                                        disabled="" 
                                        autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td>
                                <select attr-em0007CallDayFn-data='{"index": ${index}, "fm_el_id": "dateTableStartSaveCostFrom${index}", "to_el_id": "dateTableStartSaveCostTo${index}" }' 
                                        class="form-control resonTbLB" 
                                        required 
                                        ${statusDisabledLb || row.transfer_flag_desc == 'CANCEL' || row.transfer_flag_desc == 'COMPLETE' ? 'disabled' : ''}>`+optionReson+`
                                </select>
                              </td>`
        tbodyTableSaveCost += `<td><input type="number"
                                          step="any"
                                          onkeypress="em0007CallDayFn({
                                            index: ${index}, 
                                            fm_el_id: 'dateTableStartSaveCostFrom${index}', 
                                            to_el_id: 'dateTableStartSaveCostTo${index}'
                                          })"
                                          onclick="em0007CallDayFn({
                                            index: ${index}, 
                                            fm_el_id: 'dateTableStartSaveCostFrom${index}', 
                                            to_el_id: 'dateTableStartSaveCostTo${index}'
                                          })"
                                          min="0" 
                                          max="${row.max_operation_duration ? row.max_operation_duration : ''}" 
                                          oninput="if(this.value<0){this.value= this.value * -1}"
                                          id="dateTableWorkingHour-${index}" 
                                          onkeypress="return /[0-9]/i.test(event.key)" 
                                          class="form-control" 
                                          value="${row.operation_duration ? row.operation_duration : ''}" 
                                          ${statusDisabledLb || row.transfer_flag_desc == 'CANCEL' || row.transfer_flag_desc == 'COMPLETE' ? 'disabled' : ''} 
                                          autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td>
                                <input  type="text" 
                                        class="form-control text-right" 
                                        id="dateTableAttribute5Hour-${index}"
                                        value="${row.attribute5 ? row.attribute5 : ''}"
                                        disabled="" 
                                        autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td>
                                <div  class="pointer" 
                                      onclick="addRowTableSaveCost(this)" 
                                      style="margin-top: 8px; ${statusDisabledLb || 
                                                                row.transfer_flag_desc == 'CANCEL' || 
                                                                row.transfer_flag_desc == 'COMPLETE' ? 'pointer-events: none;' : ''}">
                                  <i class="fa fa-plus fa-lg"></i>
                                </div>
                              </td>`
        tbodyTableSaveCost += `<td class="d-none">
                                <input  id="employeeTbLB${+sum10 + 10}Id" 
                                        type="text" 
                                        class="form-control" 
                                        value="${row.employee_id ? row.employee_id : ''}" 
                                        autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td class="d-none">
                                <input  type="text" 
                                        class="form-control" 
                                        value="${row.resource_seq_num ? row.resource_seq_num : ''}" 
                                        autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td class="d-none">
                                <input  type="text" 
                                        class="form-control" 
                                        value="${row.or_transaction_id ? row.or_transaction_id : ''}" 
                                        autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td class="d-none">
                                <input  type="text" 
                                        class="form-control" 
                                        value="${row.line_num ? row.line_num : ''}" 
                                        autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td class="d-none"> 
                                <input  type="text" 
                                        class="form-control" 
                                        value="${row.organization_code ? row.organization_code : ''}" 
                                        autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td class="d-none">
                                <input  type="text" 
                                        class="form-control" 
                                        value="${row.wip_entity_name ? row.wip_entity_name : ''}" 
                                        autocomplete="off">
                              </td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.wip_entity_desc ? row.wip_entity_desc : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.asset_id ? row.asset_id : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.asset_number ? row.asset_number : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.asset_desc ? row.asset_desc : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.working_hour ? row.working_hour : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.uom ? row.uom : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.instance_id ? row.instance_id : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.instance_name ? row.instance_name : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.instance_start_date ? row.instance_start_date : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.reason_id ? row.reason_id : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.reason_name ? row.reason_name : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.reference ? row.reference : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.wage_rate ? row.wage_rate : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.transfer_flag ? row.transfer_flag : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.cancel_flag ? row.cancel_flag : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.transfer_date ? row.transfer_date : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.transfer_by ? row.transfer_by : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.request_id ? row.request_id : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.department_id ? row.department_id : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${row.department_name ? row.department_name : ''}" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
        tbodyTableSaveCost += `<td class="d-none">
                                <input  type="text" 
                                      class="form-control" 
                                      value='${JSON.stringify(row)}' 
                                      attr-web-status="CREATE">
                              </td>`
        tbodyTableSaveCost += `</tr>`
        sum10 += 10
      })
    }

    $("#setTbodyTableSaveCost").html(tbodyTableSaveCost);
    setSelect2InEAM0010TbodyTableSaveCost();
    triggerSelect2InEAM0010();

    data.data.filter((row, index) => {
      console.log('aa', index)
      setDatePicker({
        idDate: `dateTableStartSaveCostFrom${index}`
        ,nameDate: ''
        ,onchange: false
        ,date: row.transaction_date_from ? conVertDate(row.transaction_date_from) : ''
        ,disabled: (statusDisabledLb || row.transfer_flag_desc == 'CANCEL' || row.transfer_flag_desc == 'COMPLETE')
        ,required: true, dateEndId: `dateTableStartSaveCostTo${index}`
        ,em0007CallDay: {
            index: index,
            auto_calculate: true,
            fm_el_id: `dateTableStartSaveCostFrom${index}`,
            to_el_id: `dateTableStartSaveCostTo${index}`,
        }
      });

      setDatePicker({
        idDate: `dateTableStartSaveCostTo${index}`
        ,nameDate: ''
        ,onchange: true
        ,date: row.transaction_date_to ? conVertDate(row.transaction_date_to) : ''
        ,disabled: (statusDisabledLb || row.transfer_flag_desc == 'CANCEL' || row.transfer_flag_desc == 'COMPLETE')
        ,required: true
        ,pDisabled: row.transaction_date_from ? conVertDate(row.transaction_date_from) : ''
        ,em0007CallDay: {
            index: index,
            auto_calculate: true,
            fm_el_id: `dateTableStartSaveCostFrom${index}`,
            to_el_id: `dateTableStartSaveCostTo${index}`,
        }
      });

      //Default ชื่อพนักงาน
      var newOptionEmployee = new Option(row.employee_name, row.employee_num, true, true);
      $(`#employeeTbLB${+indexShow + 10}`).append(newOptionEmployee).trigger('change');
      $(`#employeeTbLB${+indexShow + 10}`).val(row.employee_num? row.employee_num: '').trigger('change');
      indexShow += 10
    })
    readonly();
    changWorkOder();
    changReson();
    changeTechnicianGroupOrder();

    $('.employeeTbLB').on('select2:clear', function (e) {
      $(this).parents('tr').find("td:eq(5) input[type='text']").val('');
    });
  }

  $("#addSaveCostBtn").click(() => {
    setAddTableSaveCost()
  })

  function setDefaultTableSaveCost() {
    statusDefault = true
    $("#saveCostCheckBox").prop('disabled', false);
    $("#checkboxAllTableSaveCost").prop('disabled', false);
    let sum10 = 0
    let tbodyTableSaveCost = ''

    let optionWorkOrder = ''
    let optionWorkOrderSelect = ''
    optionWorkOrder += `<option value=""></option>`
    for (const [i, data] of dataDropDownWorkOrder.entries()) {
      optionWorkOrder += `<option value="${data.operation_seq_num}" ${i == '0' ? 'selected' : ''}>${data.operation_seq_num}</option>`
      if (i == '0') {
        optionWorkOrderSelect = data.operation_seq_num
      }
    }
    let optionTechnicianGroupOrder = ''
    optionTechnicianGroupOrder += `<option value=""></option>`
    for (let data of dataDropdownTechnicianGroupOrder) {
      if (optionWorkOrderSelect == data.operation_seq_num) {
        optionTechnicianGroupOrder += `<option value="${data.resource_code}">${data.description}</option>`
      }
    }
    let optionReson = ''
    optionReson += `<option value=""></option>`
    for (let data of dataDropdownResons) {
      optionReson += `<option value="${data.reason_id}">${data.reason_name}</option>`
    }

    for (i = 0; i < 3; i++) {
      tbodyTableSaveCost += `<tr>`
      tbodyTableSaveCost += `<td class="text-center">
                                <input  type="checkbox" 
                                        onclick="checkBoxTbLBOnClick()" 
                                        name="case[]" 
                                        ${statusDisabledLb ? 'disabled' : ''}>
                            </td>`
      tbodyTableSaveCost += `<td>
                                  <input  type="text" 
                                          class="form-control" 
                                          value="" 
                                          disabled 
                                          autocomplete="off">
                              </td>`
      tbodyTableSaveCost += `<td>
                                  <select class="form-control workOrderTbLB" 
                                          ${i == '0' ? 'required' : ''} 
                                          ${statusDisabledLb ? 'disabled' : ''}>
                                          `+optionWorkOrder+`
                                  </select>
                                  <input type="hidden" class="sum10" value="${+sum10 + 10}"
                              </td>`
      tbodyTableSaveCost += `<td>
                                <select class="form-control technicianGroupOrderTbLB" 
                                        ${i == '0' ? 'required' : ''} 
                                        ${statusDisabledLb ? 'disabled' : ''}>
                                        `+optionTechnicianGroupOrder+`
                                </select>
                            </td>`
      tbodyTableSaveCost += `<td>
                                <div class="input-group">
                                  <select id="employeeTbLB${+sum10 + 10}"
                                          class="employeeTbLB form-control clearable readonly" 
                                          data-server="/eam/ajax/lov/resource-employee"  
                                          data-id="employee_number" 
                                          data-field="select"
                                          data-setAjaxDetailEmployeeTbLB="employeeTbLB${+sum10 + 10}"
                                          data-typeAjaxDetailEmployeeTbLB="employeeTbLB${+sum10 + 10}"
                                          data-setAjaxDetailEmployeeTbLBId="employeeTbLB${+sum10 + 10}Id"
                                          ${i == '0' ? 'required' : ''}
                                          ${statusDisabledLb ? 'disabled' : ''}>
                                  </select>
                                  <div class="input-group-append">
                                    <span class="input-group-append">
                                      <button onclick="resourceEmployeeLovBtnTableOnclick({nameEmployeeModal: 'รหัสพนักงาน', idEmployeeModal: 'employeeTbLB${+sum10 + 10}', locationResourceEmployee: 'technicianGroupOrde', desc: false, inModal: false})" type="button" class="btn btn-default" ${statusDisabledLb ? 'disabled' : ''}><i class="fa fa-search"></i></button>
                                    </span>
                                  </div>
                                </div>
                              </td>`
      tbodyTableSaveCost += `<td>
                              <input  type="text" 
                                      class="form-control" 
                                      value="" 
                                      disabled 
                                      autocomplete="off">
                            </td>`
      tbodyTableSaveCost += `<td>
                                <input  id="dateTableStartSaveCostAdd${i}" 
                                        type="text" 
                                        class="form-control" 
                                        value="" 
                                        autocomplete="off">
                            </td>`
      tbodyTableSaveCost += `<td>
                                <input  id="dateTableStartSaveCostAdd2${i}" 
                                        type="text" 
                                        class="form-control" 
                                        value="" 
                                        autocomplete="off">
                            </td>`
      tbodyTableSaveCost += `<td class="">
                              <input  type="text" 
                                      class="form-control text-right" 
                                      id="dateTableAttribute4Day-${i}"  
                                      value="" 
                                      disabled="" 
                                      autocomplete="off">
                            </td>`
      tbodyTableSaveCost += `<td>
                              <select
                                attr-em0007CallDayFn-data='{"index": ${i}, "fm_el_id": "dateTableStartSaveCostAdd${i}", "to_el_id": "dateTableStartSaveCostAdd2${i}" }'
                                class="form-control resonTbLB" 
                                ${i == '0' ? 'required' : ''} 
                                ${statusDisabledLb ? 'disabled' : ''}>
                                `+optionReson+`
                              </select>
                            </td>`
      tbodyTableSaveCost += `<td><input type="number"
                                        step="any"
                                        onkeypress="em0007CallDayFn({
                                            index: ${i}, 
                                            fm_el_id: 'dateTableStartSaveCostAdd${i}', 
                                            to_el_id: 'dateTableStartSaveCostAdd2${i}'
                                        })"
                                        onclick="em0007CallDayFn({
                                            index: ${i}, 
                                            fm_el_id: 'dateTableStartSaveCostAdd${i}', 
                                            to_el_id: 'dateTableStartSaveCostAdd2${i}'
                                        })"
                                        min="0" 
                                        max="0" 
                                        oninput="if(this.value<0){this.value= this.value * -1}"
                                        id="dateTableWorkingHour-${i}"
                                        onkeypress="return /[0-9]/i.test(event.key)" 
                                        class="form-control" 
                                        value="" 
                                        autocomplete="off">
                              </td>`
      tbodyTableSaveCost += `<td class="">
                                <input  type="text" 
                                        class="form-control text-right" 
                                        id="dateTableAttribute5Hour-${i}"  
                                        value="" 
                                        disabled="" 
                                        autocomplete="off">
                              </td>`
      tbodyTableSaveCost += `<td>
                              <div  class="pointer" 
                                    onclick="addRowTableSaveCost(this)" 
                                    style="margin-top: 8px; 
                                    ${statusDisabledLb ? 'pointer-events: none;' : ''}">
                                    <i class="fa fa-plus fa-lg"></i>
                              </div>
                            </td>`
      tbodyTableSaveCost += `<td>
                              <input  id="employeeTbLB${+sum10 + 10}Id" 
                                      type="text" 
                                      class="form-control" 
                                      value="" 
                                      hidden 
                                      autocomplete="off">
                            </td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
      tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="add" autocomplete="off"></td>`
      tbodyTableSaveCost += `</tr>`

      sum10 += 10
    }
    $("#setTbodyTableSaveCost").html(tbodyTableSaveCost);
    for (i = 0; i < 3; i++) {
      setDatePicker({idDate: `dateTableStartSaveCostAdd${i}`
        , nameDate: ''
        , onchange: false
        , date: $("#repairDateStart").val() ? $("#repairDateStart").val() : ''
        , disabled: statusDisabledLb
        , required: i == '0' ? true : false
        , dateEndId: `dateTableStartSaveCostAdd2${i}`
        , em0007CallDay: {
            index: `${i}`,
            auto_calculate: true,
            fm_el_id: `dateTableStartSaveCostAdd${i}`,
            to_el_id: `dateTableStartSaveCostAdd2${i}`,
        }
      });
      setDatePicker({
        idDate: `dateTableStartSaveCostAdd2${i}`
        , nameDate: ''
        , onchange: true
        , date: $("#repairDateEnd").val() ? $("#repairDateEnd").val() : ''
        , disabled: statusDisabledLb
        , required: i == '0' ? true : false
        , em0007CallDay: {
            index: `${i}`,
            auto_calculate: true,
            fm_el_id: `dateTableStartSaveCostAdd${i}`,
            to_el_id: `dateTableStartSaveCostAdd2${i}`,
        }
      });
    }

    readonly();
    changWorkOder();
    changReson();
    changeTechnicianGroupOrder();
    setSelect2InEAM0010TbodyTableSaveCost();
    triggerSelect2InEAM0010();

    $('.employeeTbLB').on('select2:clear', function (e) {
      $(this).parents('tr').find("td:eq(5) input[type='text']").val('');
    });

    $('.resonTbLB').parents('tr').find("td:eq(9) select").on('select2:clear', function (e) {
      $(this).parents('tr').find("td:eq(8) input[type='text']").val('').trigger('change');
    });
  }

  function setAddTableSaveCost() {
    $("#saveCostCheckBox").prop('disabled', false);
    let sum10     = 0;
    let listData  = [];
    let listData2 = [];
    let maxVal    = 0;

    $("#setTbodyTableSaveCost td .sum10").each(function(index) {
      if ($("#setTbodyTableSaveCost td .sum10").length*10 > maxVal) {
        maxVal = $("#setTbodyTableSaveCost td .sum10").length*10;
      }
      sum10 = ($("#setTbodyTableSaveCost td .sum10").length*10)+10;
      listData.push(parseInt(sum10));
      listData2.push(parseInt(maxVal));
    })

    if (sum10 != maxVal) {
      var result = [];
        listData2.filter((row2)=>{
          const index = listData.indexOf(row2);
          if (index > -1) {
            listData.splice(index, 1);
          }
        })
      sum10 = (listData[0] - 10)
    }

    let tbodyTableSaveCost = ''

    let optionWorkOrder = ''
    let optionWorkOrderSelect = ''
    optionWorkOrder += `<option value=""></option>`
    for (const [i, data] of dataDropDownWorkOrder.entries()) {
      optionWorkOrder += `<option value="${data.operation_seq_num}" ${i == '0' ? 'selected' : ''}>${data.operation_seq_num}</option>`
      if (i == '0') {
        optionWorkOrderSelect = data.operation_seq_num
      }
    }
    let optionTechnicianGroupOrder = ''
    optionTechnicianGroupOrder += `<option value=""></option>`
    for (let data of dataDropdownTechnicianGroupOrder) {
      if (optionWorkOrderSelect == data.operation_seq_num) {
        optionTechnicianGroupOrder += `<option value="${data.resource_code}">${data.description}</option>`
      }
    }
    let optionReson = ''
    optionReson += `<option value=""></option>`
    for (let data of dataDropdownResons) {
      optionReson += `<option value="${data.reason_id}">${data.reason_name}</option>`
    }

    tbodyTableSaveCost += `<tr>`
    tbodyTableSaveCost += `<td class="text-center">
                            <input  type="checkbox" 
                                    onclick="checkBoxTbLBOnClick()" 
                                    name="case[]" 
                                    ${statusDisabledLb ? 'disabled' : ''}>
                          </td>`
    tbodyTableSaveCost += `<td>
                            <input  type="text" 
                                    class="form-control" 
                                    value="" 
                                    disabled 
                                    autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td>
                            <select class="form-control workOrderTbLB" 
                                    required>`+optionWorkOrder+`
                            </select>
                            <input type="hidden" class="sum10" value="${+sum10 + 10}">
                          </td>`
    tbodyTableSaveCost += `<td>
                            <select class="form-control technicianGroupOrderTbLB" 
                                    required>`+optionTechnicianGroupOrder+`
                            </select>
                          </td>`
    tbodyTableSaveCost += `<td>
                            <div class="input-group">
                              <select id="employeeTbLB${+sum10 + 10}"
                                      class="employeeTbLB form-control clearable readonly" 
                                      data-server="/eam/ajax/lov/resource-employee"  
                                      data-id="employee_number" 
                                      data-field="select"
                                      required
                                      data-setAjaxDetailEmployeeTbLB="employeeTbLB${+sum10 + 10}"
                                      data-typeAjaxDetailEmployeeTbLB="employeeTbLB${+sum10 + 10}"
                                      data-setAjaxDetailEmployeeTbLBId="employeeTbLB${+sum10 + 10}Id">
                              </select>
                              <div class="input-group-append">
                                <span class="input-group-append">
                                  <button onclick="resourceEmployeeLovBtnTableOnclick({nameEmployeeModal: 'รหัสพนักงาน', idEmployeeModal: 'employeeTbLB${+sum10 + 10}', locationResourceEmployee: 'technicianGroupOrde', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </span>
                              </div>
                            </div>
                          </td>`
    tbodyTableSaveCost += `<td>
                              <input  type="text" 
                                      class="form-control" 
                                      value="" 
                                      disabled 
                                      autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td>
                              <input  id="dateTableStartSaveCostAdd${+sum10 + 10}" 
                                      type="text" 
                                      class="form-control" 
                                      value="" 
                                      autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td>
                              <input  id="dateTableStartSaveCostAdd2${+sum10 + 10}" 
                                      type="text" 
                                      class="form-control" 
                                      value="" 
                                      autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td class="">
                              <input  type="text" 
                                      class="form-control text-right" 
                                      id="dateTableAttribute4Day-${+sum10 + 10}" 
                                      disabled 
                                      autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td>
                              <select
                                attr-em0007CallDayFn-data='{"index": ${+sum10 + 10}, "fm_el_id": "dateTableStartSaveCostAdd${+sum10 + 10}", "to_el_id": "dateTableStartSaveCostAdd2${+sum10 + 10}" }'
                                class="form-control resonTbLB" required >`+optionReson+`
                              </select>
                          </td>`
    tbodyTableSaveCost += `<td>
                              <input  step="any"
                                      onkeypress="em0007CallDayFn({
                                        index: ${+sum10 + 10}, 
                                        fm_el_id: 'dateTableStartSaveCostAdd${+sum10 + 10}', 
                                        to_el_id: 'dateTableStartSaveCostAdd2${+sum10 + 10}'
                                      })"
                                      onclick="em0007CallDayFn({
                                        index: ${+sum10 + 10}, 
                                        fm_el_id: 'dateTableStartSaveCostAdd${+sum10 + 10}', 
                                        to_el_id: 'dateTableStartSaveCostAdd2${+sum10 + 10}'
                                      })"
                                      min="0" 
                                      max="0" 
                                      oninput="if(this.value<0){this.value= this.value * -1}"
                                      id='dateTableWorkingHour-${+sum10 + 10}'
                                      type="number" 
                                      onkeypress="return /[0-9]/i.test(event.key)" 
                                      class="form-control" 
                                      value="" 
                                      autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td>
                              <input  type="text" 
                                      class="form-control text-right" 
                                      id="dateTableAttribute5Hour-${+sum10 + 10}" 
                                      disabled 
                                      autocomplete="off">
                          </td>`
    tbodyTableSaveCost +=   `<td>
                                <div  class="pointer" 
                                      onclick="addRowTableSaveCost(this)" 
                                      style="margin-top: 8px;">
                                      <i class="fa fa-plus fa-lg"></i>
                                </div>
                              </td>`
    tbodyTableSaveCost +=   `<td>
                              <input  id="employeeTbLB${+sum10 + 10}Id" 
                                      type="text" 
                                      class="form-control" 
                                      value="" 
                                      hidden 
                                      autocomplete="off">
                            </td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="add" autocomplete="off"></td>`
    tbodyTableSaveCost += `</tr>`
    $("#setTbodyTableSaveCost").append(tbodyTableSaveCost);
    setSelect2InEAM0010TbodyTableSaveCost();
    triggerSelect2InEAM0010();

    setDatePicker({
        idDate: `dateTableStartSaveCostAdd${+sum10 + 10}`
        , nameDate: ''
        , onchange: false
        , date: $("#repairDateStart").val() ? $("#repairDateStart").val() : ''
        , disabled: false
        , required: true, dateEndId: `dateTableStartSaveCostAdd2${+sum10 + 10}`
        , em0007CallDay: {
            index: `${+sum10 + 10}`,
            auto_calculate: true,
            fm_el_id: `dateTableStartSaveCostAdd${+sum10 + 10}`,
            to_el_id: `dateTableStartSaveCostAdd2${+sum10 + 10}`,
        }
    });

    setDatePicker({
        idDate: `dateTableStartSaveCostAdd2${+sum10 + 10}`
        , nameDate: ''
        , onchange: true
        , date: $("#repairDateEnd").val() ? $("#repairDateEnd").val() : ''
        , disabled: false
        , required: true
        , em0007CallDay: {
            index: `${+sum10 + 10}`,
            auto_calculate: true,
            fm_el_id: `dateTableStartSaveCostAdd${+sum10 + 10}`,
            to_el_id: `dateTableStartSaveCostAdd2${+sum10 + 10}`,
        }
    });
    readonly();
    changWorkOder();
    changReson();
    changeTechnicianGroupOrder();
  }

  function addRowTableSaveCost(data) {
    if ($(data).parents('tr').find("td:eq(1) input[type='text']").val() == 'ERROR' || 
        $(data).parents('tr').find("td:eq(1) input[type='text']").val() == ''         ) {
      $("#saveCostCheckBox").prop('disabled', true);
    }
    let sum10 = 0
    let listData = []
    let listData2 = []
    let maxVal = 0
    $("#setTbodyTableSaveCost td .sum10").each(function(index) {
      // if ($(this).val() > maxVal) {
      //   maxVal = $(this).val()
      // }
      // sum10 += 10
      // listData.push(parseInt(sum10))
      // listData2.push(parseInt($(this).val()))

      if ($("#setTbodyTableSaveCost td .sum10").length*10 > maxVal) {
        maxVal = $("#setTbodyTableSaveCost td .sum10").length*10;
      }
      sum10 = ($("#setTbodyTableSaveCost td .sum10").length*10)+10;
      listData.push(parseInt(sum10));
      listData2.push(parseInt(maxVal));
    })
    if (sum10 != maxVal) {
      var result = [];
        listData2.filter((row2)=>{
          const index = listData.indexOf(row2);
          if (index > -1) {
            listData.splice(index, 1);
          }
        })
      sum10 = (listData[0] - 10)
    }

    let tbodyTableSaveCost = ''
    let optionWorkOrder = ''
    optionWorkOrder += `<option value=""></option>`
    for (let datas of dataDropDownWorkOrder) {
      optionWorkOrder += `<option value="${datas.operation_seq_num}" ${($(data).parents('tr').find("td:eq(2) select").val() == datas.operation_seq_num) ? 'selected' : ''}>${datas.operation_seq_num}</option>`
    }
    let optionTechnicianGroupOrder = ''
    optionTechnicianGroupOrder += `<option value=""></option>`
    for (let datas of dataDropdownTechnicianGroupOrder) {
      if ($(data).parents('tr').find("td:eq(2) select").val() == datas.operation_seq_num) {
        optionTechnicianGroupOrder += `<option value="${datas.resource_code}" ${($(data).parents('tr').find("td:eq(3) select").val() == datas.resource_code) ? 'selected' : ''}>${datas.description}</option>`
      }
    }
    let optionReson = ''
    optionReson += `<option value=""></option>`
    for (let datas of dataDropdownResons) {
      optionReson += `<option value="${datas.reason_id}" ${($(data).parents('tr').find("td:eq(9) select").val() == datas.reason_id) ? 'selected' : ''}>${datas.reason_name}</option>`
    }
    tbodyTableSaveCost += `<tr>`
    tbodyTableSaveCost += `<td class="text-center">
                            <input  type="checkbox" 
                                    onclick="checkBoxTbLBOnClick()" 
                                    name="case[]" 
                                    ${statusDisabledLb ? 'disabled' : ''}>
                          </td>`
    tbodyTableSaveCost += `<td>
                            <input  type="text" 
                                    class="form-control" 
                                    value="${$(data).parents('tr').find("td:eq(1) input[type='text']").val()}" 
                                    disabled 
                                    autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td>
                            <select class="form-control workOrderTbLB" 
                                    required>`+optionWorkOrder+`
                            </select>
                            <input  type="hidden"
                                    class="sum10" 
                                    value="${+sum10 + 10}">
                          </td>`
    tbodyTableSaveCost += `<td>
                            <select class="form-control technicianGroupOrderTbLB" 
                                    required>`+optionTechnicianGroupOrder+`
                            </select>
                          </td>`
    tbodyTableSaveCost += `<td>
                              <div class="input-group">
                                <select id="employeeTbLBAddRow${+sum10 + 10}"
                                        class="employeeTbLB form-control clearable readonly" 
                                        data-server="/eam/ajax/lov/resource-employee"  
                                        data-id="employee_number" 
                                        data-field="select"
                                        required
                                        data-setAjaxDetailEmployeeTbLB="employeeTbLBAddRow${+sum10 + 10}"
                                        data-typeAjaxDetailEmployeeTbLB="employeeTbLBAddRow${+sum10 + 10}"
                                        data-setAjaxDetailEmployeeTbLBId="employeeTbLBAddRow${+sum10 + 10}Id">
                                </select>
                                <div class="input-group-append">
                                  <span class="input-group-append">
                                    <button onclick="resourceEmployeeLovBtnTableOnclick({nameEmployeeModal: 'รหัสพนักงาน', idEmployeeModal: 'employeeTbLBAddRow${+sum10 + 10}', locationResourceEmployee: 'technicianGroupOrde', desc: false, inModal: false})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                                  </span>
                                </div>
                              </div>
                            </td>`
    tbodyTableSaveCost += `<td>
                            <input  type="text" 
                                    class="form-control" 
                                    value="${$(data).parents('tr').find("td:eq(5) input[type='text']").val()}" 
                                    disabled 
                                    autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td>
                            <input  id="dateTableStartSaveCostAddRow${+sum10 + 10}" 
                                    type="text" 
                                    class="form-control" 
                                    value="" 
                                    autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td>
                            <input  id="dateTableStartSaveCostAddRow2${+sum10 + 10}" 
                                    type="text" 
                                    class="form-control" 
                                    value="" 
                                    required 
                                    autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td class="">
                            <input  type="text" 
                                    class="form-control text-right" 
                                    id="dateTableAttribute4Day-${+sum10 + 10}"
                                    value="${$(data).parents('tr').find("td:eq(8) input[type='text']").val()}" 
                                    disabled="" 
                                    autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td>
                            <select attr-em0007CallDayFn-data='{"index": ${+sum10 + 10}, "fm_el_id": "dateTableStartSaveCostAddRow${+sum10 + 10}", "to_el_id": "dateTableStartSaveCostAddRow2${+sum10 + 10}" }'
                                    class="form-control resonTbLB" 
                                    required>`+optionReson+`
                            </select>
                          </td>`
    tbodyTableSaveCost += `<td>
                            <input  type="number"
                                    step="any"
                                    onkeypress="em0007CallDayFn({
                                      index: ${+sum10 + 10}, 
                                      fm_el_id: 'dateTableStartSaveCostAddRow${+sum10 + 10}', 
                                      to_el_id: 'dateTableStartSaveCostAddRow2${+sum10 + 10}'
                                    })"
                                    min="0" 
                                    max="${$(data).parents('tr').find("td:eq(10) input[type='number']").attr('max')}" 
                                    oninput="if(this.value<0){this.value= this.value * -1}"
                                    id="dateTableWorkingHour-${+sum10 + 10}" 
                                    onkeypress="return /[0-9]/i.test(event.key)" 
                                    class="form-control" 
                                    value="${$(data).parents('tr').find("td:eq(10) input[type='number']").val()}" 
                                    autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td class="">
                            <input  type="text" 
                                    class="form-control text-right" 
                                    id="dateTableAttribute5Hour-${+sum10 + 10}" 
                                    value="${$(data).parents('tr').find("td:eq(11) input[type='text']").val()}" 
                                    disabled="" 
                                    autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td>
                            <div  class="pointer" 
                                  onclick="addRowTableSaveCost(this)"
                                  style="margin-top: 8px;">
                                  <i class="fa fa-plus fa-lg"></i>
                            </div>
                          </td>`
    tbodyTableSaveCost += `<td>
                            <input  id="employeeTbLBAddRow${+sum10 + 10}Id" 
                                    type="text" 
                                    class="form-control" 
                                    value="${$(data).parents('tr').find("td:eq(13) input[type='text']").val()}" 
                                    hidden 
                                    autocomplete="off">
                          </td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(12) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value=""></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(15) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(16) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(17) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(18) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(19) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(20) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(21) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(22) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(23) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(24) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(25) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(26) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(27) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(28) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(29) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(32) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(31) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(32) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(33) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(34) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(35) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="${$(data).parents('tr').find("td:eq(36) input[type='text']").val()}" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none"><input type="text" class="form-control" value="add" autocomplete="off"></td>`
    tbodyTableSaveCost += `<td class="d-none">
                            <input  type="text" 
                                    class="form-control" 
                                    attr-web-status="UPDATE" 
                                    value='${$(data).parents('tr').find("td:last-child input[type='text']").val()}'>
                          </td>`
    tbodyTableSaveCost += `</tr>`
    
    var $tr = $(data).closest($(data).parents('tr'));
    $tr.after(tbodyTableSaveCost);

    setDatePicker({
        idDate: `dateTableStartSaveCostAddRow${+sum10 + 10}`
        , nameDate: ''
        , onchange: false
        , date: $(data).parents('tr').find("td:eq(6) input[type='text']").val()
        , disabled: false
        , required: true
        , dateEndId: `dateTableStartSaveCostAddRow2${+sum10 + 10}`
        , em0007CallDay: {
            index: `${+sum10 + 10}`,
            auto_calculate: true,
            fm_el_id: `dateTableStartSaveCostAddRow${+sum10 + 10}`,
            to_el_id: `dateTableStartSaveCostAddRow2${+sum10 + 10}`,
        }
    });
    setDatePicker({
        idDate: `dateTableStartSaveCostAddRow2${+sum10 + 10}`
        , nameDate: ''
        , onchange: true
        , date: $(data).parents('tr').find("td:eq(7) input[type='text']").val()
        , disabled: false
        , required: true
        , pDisabled: $(data).parents('tr').find("td:eq(6) input[type='text']").val()
        , em0007CallDay: {
            index: `${+sum10 + 10}`,
            auto_calculate: true,
            fm_el_id: `dateTableStartSaveCostAddRow${+sum10 + 10}`,
            to_el_id: `dateTableStartSaveCostAddRow2${+sum10 + 10}`,
        }
    });
    readonly();
    changWorkOder();
    changReson();
    changeTechnicianGroupOrder();
    setSelect2InEAM0010TbodyTableSaveCost();
    triggerSelect2InEAM0010();
    var newOptionEmployee = new Option($(data).parents('tr').find("td:eq(4) select option:selected").text(), $(data).parents('tr').find("td:eq(4) select").val(), true, true);
    $(`#employeeTbLBAddRow${+sum10 + 10}`).append(newOptionEmployee).trigger('change');
    $(`#employeeTbLBAddRow${+sum10 + 10}`).val($(data).parents('tr').find("td:eq(4) select").val() ? $(data).parents('tr').find("td:eq(4) select").val(): '').trigger('change');
  }

  $("#checkboxAllTableSaveCost").click((e) => { 
    var table = $(e.target).closest('table');
    if ($("#checkboxAllTableSaveCost").prop('checked')) {
      $('td input:checkbox:not([disabled])', table).prop('checked', $("#checkboxAllTableSaveCost").prop('checked'));
    } else {
      $('td input:checkbox', table).prop('checked', $("#checkboxAllTableSaveCost").prop('checked'));
    }
    checkBoxTbLBOnClick()
  })

  function checkBoxTbLBOnClick() {
    let numCheckboxChecked = $("#setTbodyTableSaveCost input[type='checkbox']:checked").length;
    let numCheckbox        = $("#setTbodyTableSaveCost input[type='checkbox']").length;

    if (!statusDisabledBtnLB) {
      $("#sendDataSaveCostBtn").prop('disabled', false);
      $("#undoDataSaveCostBtn").prop('disabled', false);
      let checkA = false
      let checkB = false
      $("#setTbodyTableSaveCost input[type='checkbox']:checked").each(function() {
        if ($(this).parents('tr').find("td:eq(1) input[type='text']").val() == 'COMPLETE' || 
            $(this).parents('tr').find("td:eq(1) input[type='text']").val() == 'CANCEL'       ) {
          checkA = true
        } 
        if ($(this).parents('tr').find("td:eq(1) input[type='text']").val() == 'CANCEL' || 
            $(this).parents('tr').find("td:eq(1) input[type='text']").val() == '' || 
            $(this).parents('tr').find("td:eq(32) input[type='text']").val() != 'Y'         ) {
          checkB = true
        }
      })

      if (checkA) {
        $("#sendDataSaveCostBtn").prop('disabled', true);
      }
      if (checkB) {
        $("#undoDataSaveCostBtn").prop('disabled', true);
      }
    }

    if(numCheckbox != numCheckboxChecked){
      $("#checkboxAllTableSaveCost").prop('checked',false);
    }else{
      $("#checkboxAllTableSaveCost").prop('checked',true);
    }
  }

  $("#saveSaveCostBtn").click(() => {
    costClickStatus = 'save'
    
    $('#setTbodyTableSaveCost').find('tr').each(function (key, val) {
      if (statusDefault) {
        if (key == 0) {
          $(this).find("td:eq(2) select").prop('required',true)
          $(this).find("td:eq(3) select").prop('required',true)
          $(this).find("td:eq(4) select").prop('required',true)
          $(this).find("td:eq(6) input[type='text']").prop('required',true)
          $(this).find("td:eq(7) input[type='text']").prop('required',true)
          $(this).find("td:eq(9) input[type='text']").prop('required',true)
        } else {
          $(this).find("td:eq(2) select").prop('required',false)
          $(this).find("td:eq(3) select").prop('required',false)
          $(this).find("td:eq(4) select").prop('required',false)
          $(this).find("td:eq(6) input[type='text']").prop('required',false)
          $(this).find("td:eq(7) input[type='text']").prop('required',false)
          $(this).find("td:eq(9) input[type='text']").prop('required',false)
        }
      } else {
        $(this).find("td:eq(2) select").prop('required',true)
        $(this).find("td:eq(3) select").prop('required',true)
        $(this).find("td:eq(4) select").prop('required',true)
        $(this).find("td:eq(6) input[type='text']").prop('required',true)
        $(this).find("td:eq(7) input[type='text']").prop('required',true)
        $(this).find("td:eq(9) input[type='text']").prop('required',true)
      }
    })

    $("#saveSaveCostBtnHide").click();
  })

  function formSaveSaveCostBtnHide() {
    if (costClickStatus == 'save') {
        // console.log('1 save');
      saveSaveCostFn()
    } else if (costClickStatus == 'submit') {
        // console.log('2 submit');
      saveSubmitFn()
    } else if (costClickStatus == 'cancel') {
        // console.log('3 cancel');
      saveCancelFn()
    }
  }

  function saveSaveCostFn() {
    swal({
        title: `\nคุณแน่ใจไหม?`, // new line is a workaround for icon cover text
        text: 'กรุณายืนยันการบันทึกข้อมูล',
        type: 'warning',
        dangerMode: true,
        showCancelButton: true,
        closeOnCancel: true,
        cancelButtonText: 'ยกเลิก',
        showConfirmButton: true,
        closeOnConfirm: true,
        confirmButtonText: 'ดำเนินการต่อ',
        allowClickOutside: true,
        closeOnClickOutside: true,
      },
    function(){
      let dataSave = []
      $("#setTbodyTableSaveCost tr ").each(function() {
        if ($(this).find("td:eq(2) select").val() != '' && 
            $(this).find("td:eq(3) select").val() != '' && 
            $(this).find("td:eq(4) select").val() != '' && 
            $(this).find("td:eq(6) input[type='text']").val() != '' && 
            $(this).find("td:eq(7) input[type='text']").val() != '' && 
            $(this).find("td:eq(9) input[type='text']").val() != '') {

          let resource_id       = '';
          let resource_seq_num  = '';
          for (let datas of dataDropdownTechnicianGroupOrder) {
            if ($(this).find("td:eq(3) select").val() == datas.resource_code) {
              resource_id = datas.resource_id;
              resource_seq_num = datas.resource_seq_num;
            }
          }

          let reason_id   = '';
          let reason_name = '';
          for (let datas of dataDropdownResons) {
            if ($(this).find("td:eq(9) select").val() == datas.reason_id) {
              reason_id   = datas.reason_id;
              reason_name = datas.reason_name;
            }
          }
          
          let data = {
            transfer_flag:          $(this).find("td:eq(1) input[type='text']").val() == 'COMPLETE' ? 'Y' : 
                                    $(this).find("td:eq(1) input[type='text']").val() == 'ERROR' ? 'N' : null,
            transfer_flag_desc:     $(this).find("td:eq(1) input[type='text']").val(),
            operation_seq_num:      $(this).find("td:eq(2) select").val(),
            reason_id:              reason_id,
            reason_name:            reason_name,
            resource_seq_num:       resource_seq_num,
            or_transaction_id:      $(this).find("td:eq(13) input[type='text']").val(),
            line_num:               $(this).find("td:eq(14) input[type='text']").val(),
            organization_id:        organization_id,
            organization_code:      $(this).find("td:eq(15) input[type='text']").val(),
            wip_entity_name:        $("#workReceiptNumber option:selected").text(),
            wip_entity_desc:        $(this).find("td:eq(17) input[type='text']").val(),
            asset_id:               $(this).find("td:eq(18) input[type='text']").val(),
            asset_number:           $("#assetNumber").val(),
            asset_desc:             $(this).find("td:eq(20) input[type='text']").val(),
            resource_id:            resource_id,
            resource_code:          $(this).find("td:eq(3) select").val(),
            working_hour:           $(this).find("td:eq(21) input[type='text']").val(),
            uom:                    $(this).find("td:eq(22) input[type='text']").val(),
            instance_id:            $(this).find("td:eq(23) input[type='text']").val(),
            instance_name:          $(this).find("td:eq(24) input[type='text']").val(),
            instance_start_date:    $(this).find("td:eq(25) input[type='text']").val(),
            transaction_date_from:  $(this).find("td:eq(6) input[type='text']").val(),
            transaction_date_to:    $(this).find("td:eq(7) input[type='text']").val(),
            operation_duration:     $(this).find("td:eq(10) input[type='number']").val(),
            reference:              $(this).find("td:eq(28) input[type='text']").val(),
            wage_rate:              $(this).find("td:eq(29) input[type='text']").val(),
            cancel_flag:            $(this).find("td:eq(31) input[type='text']").val(),
            transfer_date:          $(this).find("td:eq(32) input[type='text']").val(),
            transfer_by:            $(this).find("td:eq(33) input[type='text']").val(),
            request_id:             $(this).find("td:eq(34) input[type='text']").val(),
            employee_id:            $(this).find("td:eq(13) input[type='text']").val(),
            employee_num:           $(this).find("td:eq(5) input[type='text']").val(),
            employee_name:          $(this).find("td:eq(4) select option:selected").text(),
            department_id:          $(this).find("td:eq(35) input[type='text']").val(),
            department_name:        $(this).find("td:eq(36) input[type='text']").val(),
            program_code:           'EAM0012',
            wip_entity_id:          wip_entity_id
          }

          let dataAll                 = $(this).find("td:last-child input[type='text']").val() ? 
                                        $(this).find("td:last-child input[type='text']").val() : '';
          let webStatus               = $(this).find("td:last-child input[type='text']").attr('attr-web-status');

          data.attribute4             = $(this).find("td:eq(8) input[type='text']").val();
          data.attribute5             = $(this).find("td:eq(11) input[type='text']").val();
          data.or_transaction_id      = '';

          if (dataAll && dataAll != 'add') {
            dataAll                     = JSON.parse(dataAll);
            data.or_transaction_id      = dataAll.or_transaction_id;
            data.line_num               = dataAll.line_num;
            data.organization_code      = dataAll.organization_code;
            data.wip_entity_desc        = dataAll.wip_entity_desc;
            data.asset_id               = dataAll.asset_id;
            data.asset_desc             = dataAll.asset_desc;
            data.working_hour           = dataAll.working_hour;
            data.uom                    = dataAll.uom;
            data.instance_id            = dataAll.instance_id;
            data.instance_name          = dataAll.instance_name;
            data.instance_start_date    = dataAll.instance_start_date;
            data.reference              = dataAll.reference;
            data.wage_rate              = dataAll.wage_rate;
            data.cancel_flag            = dataAll.cancel_flag;
            data.transfer_date          = dataAll.transfer_date;
            data.transfer_by            = dataAll.transfer_by;
            data.request_id             = dataAll.request_id;
            // data.employee_id            = dataAll.employee_id;
            // data.employee_num           = dataAll.employee_num;
            data.department_id          = dataAll.department_id;
            data.department_name        = dataAll.department_name;
            if (webStatus != 'CREATE') {
                data.or_transaction_id  = '';
            }
          }

          dataSave.push(data)
        }
      })

      if (dataSave.length > 0) {
        $.ajax({
          url: "{{ route('eam.ajax.work-order.lb.store') }}",
          type: "POST",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          data: JSON.stringify({data: dataSave}),
          success: function (response) {
            swal("Success", response.message, "success");
            workOrderlbAll();
            $("#checkboxAllTableSaveCost").prop('checked',false);
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            $("#checkboxAllTableSaveCost").prop('checked',false);
            // workOrderlbAll();
            // console.log(jqXHR.responseJSON)
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      } else {
        swal("กรุณาเพิ่มรายการ", "", "warning");
      }

    })
  }

  $("#deleteSaveCostBtn").click(() => {
    let dataSaveCheckAdd  = [];
    let dataSave          = [];

    $("#setTbodyTableSaveCost input[type='checkbox']:checked").each(function() {
      if ($(this).parents('tr').find("td:eq(39) input[type='text']").val() == 'add') {
        dataSaveCheckAdd.push($(this).parents('tr'))
      } else {
        let resource_id       = '';
        let resource_seq_num  = '';
        for (let datas of dataDropdownTechnicianGroupOrder) {
          if ($(this).parents('tr').find("td:eq(3) select").val() == datas.resource_code) {
            resource_id       = datas.resource_id;
            resource_seq_num  = datas.resource_seq_num;
          }
        }
        let reason_id   = '';
        let reason_name = '';
        for (let datas of dataDropdownResons) {
          if ($(this).parents('tr').find("td:eq(9) select").val() == datas.reason_id) {
            reason_id   = datas.reason_id;
            reason_name = datas.reason_name;
          }
        }
        let data = {
          transfer_flag:          $(this).parents('tr').find("td:eq(1) input[type='text']").val() == 'COMPLETE' ? 'Y' : 
                                  $(this).parents('tr').find("td:eq(1) input[type='text']").val() == 'ERROR' ? 'N' : null,
          transfer_flag_desc:     $(this).parents('tr').find("td:eq(1) input[type='text']").val(),
          operation_seq_num:      $(this).parents('tr').find("td:eq(2) select").val(),
          resource_seq_num:       resource_seq_num,
          reason_id:              reason_id,
          reason_name:            reason_name,
          or_transaction_id:      $(this).parents('tr').find("td:eq(13) input[type='text']").val(),
          line_num:               $(this).parents('tr').find("td:eq(14) input[type='text']").val(),
          organization_id:        organization_id,
          organization_code:      $(this).parents('tr').find("td:eq(15) input[type='text']").val(),
          wip_entity_name:        $("#workReceiptNumber option:selected").text(),
          wip_entity_desc:        $(this).parents('tr').find("td:eq(17) input[type='text']").val(),
          asset_id:               $(this).parents('tr').find("td:eq(18) input[type='text']").val(),
          asset_number:           $("#assetNumber").val(),
          asset_desc:             $(this).parents('tr').find("td:eq(20) input[type='text']").val(),
          resource_id:            resource_id,
          resource_code:          $(this).parents('tr').find("td:eq(3) select").val(),
          working_hour:           $(this).parents('tr').find("td:eq(21) input[type='text']").val(),
          uom:                    $(this).parents('tr').find("td:eq(22) input[type='text']").val(),
          instance_id:            $(this).parents('tr').find("td:eq(23) input[type='text']").val(),
          instance_name:          $(this).parents('tr').find("td:eq(24) input[type='text']").val(),
          instance_start_date:    $(this).parents('tr').find("td:eq(25) input[type='text']").val(),
          transaction_date_from:  $(this).parents('tr').find("td:eq(6) input[type='text']").val(),
          transaction_date_to:    $(this).parents('tr').find("td:eq(7) input[type='text']").val(),
          operation_duration:     $(this).parents('tr').find("td:eq(10) input[type='number']").val(),
          reference:              $(this).parents('tr').find("td:eq(28) input[type='text']").val(),
          wage_rate:              $(this).parents('tr').find("td:eq(29) input[type='text']").val(),
          cancel_flag:            $(this).parents('tr').find("td:eq(31) input[type='text']").val(),
          transfer_date:          $(this).parents('tr').find("td:eq(32) input[type='text']").val(),
          transfer_by:            $(this).parents('tr').find("td:eq(33) input[type='text']").val(),
          request_id:             $(this).parents('tr').find("td:eq(34) input[type='text']").val(),
          employee_id:            $(this).parents('tr').find("td:eq(13) input[type='text']").val(),
          employee_num:           $(this).parents('tr').find("td:eq(5) input[type='text']").val(),
          employee_name:          $(this).parents('tr').find("td:eq(4) select option:selected").text(),
          department_id:          $(this).parents('tr').find("td:eq(35) input[type='text']").val(),
          department_name:        $(this).parents('tr').find("td:eq(36) input[type='text']").val(),
          program_code:           'EAM0012',
          wip_entity_id:          wip_entity_id
        }

        let dataAll                 = $(this).parents('tr').find("td:last-child input[type='text']").val() ? 
                                      $(this).parents('tr').find("td:last-child input[type='text']").val() : '';
        let webStatus               = $(this).parents('tr').find("td:last-child input[type='text']").attr('attr-web-status');

        data.attribute4             = $(this).parents('tr').find("td:eq(8) input[type='text']").val();
        data.attribute5             = $(this).parents('tr').find("td:eq(11) input[type='text']").val();
        data.or_transaction_id      = '';
        if (dataAll && dataAll != 'add') {
            dataAll                     = JSON.parse(dataAll);
            data.or_transaction_id      = dataAll.or_transaction_id ;
            data.line_num               = dataAll.line_num ;
            data.organization_code      = dataAll.organization_code ;
            data.wip_entity_desc        = dataAll.wip_entity_desc ;
            data.asset_id               = dataAll.asset_id ;
            data.asset_desc             = dataAll.asset_desc ;
            data.working_hour           = dataAll.working_hour ;
            data.uom                    = dataAll.uom ;
            data.instance_id            = dataAll.instance_id ;
            data.instance_name          = dataAll.instance_name ;
            data.instance_start_date    = dataAll.instance_start_date ;
            data.reference              = dataAll.reference ;
            data.wage_rate              = dataAll.wage_rate ;
            data.cancel_flag            = dataAll.cancel_flag ;
            data.transfer_date          = dataAll.transfer_date ;
            data.transfer_by            = dataAll.transfer_by ;
            data.request_id             = dataAll.request_id ;
            data.employee_id            = dataAll.employee_id ;
            data.employee_num           = dataAll.employee_num ;
            data.department_id          = dataAll.department_id ;
            data.department_name        = dataAll.department_name ;
            if (webStatus != 'CREATE') {
                data.or_transaction_id  = '';
            }
        }
        dataSave.push(data)
      }
    })
    if (dataSave.length > 0) {
      $.ajax({
        url: "{{ route('eam.ajax.work-order.lb.delete') }}",
        type: "POST",
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: JSON.stringify({data: dataSave}),
        success: function (response) {
          swal("Success", response.message, "success");
          workOrderlbAll();
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    } else if (dataSaveCheckAdd.length > 0) {
      dataSaveCheckAdd.filter(row => {
        $(row).remove();
      })
      $("#setTbodyTableSaveCost tr ").each(function() {
        if ($(this).find("td:eq(1) input[type='text']").val() == 'ERROR' || 
            $(this).find("td:eq(1) input[type='text']").val() == ''           ) {
              $("#saveCostCheckBox").prop('disabled', true);
              if($(this).find("td:eq(3) select").val() == '' &&
                 $(this).find("td:eq(4) select").val() == null){
                  $("#saveCostCheckBox").prop('disabled', false);
                 }
        } else {
              $("#saveCostCheckBox").prop('disabled', false);
        }
      })
    } else {
      swal("กรุณาเลือกรายการ", "", "warning");
    }

    if($("#setTbodyTableSaveCost input[type='checkbox']").length == 0){
      $("#checkboxAllTableSaveCost").prop('checked',false);
    }else{
      if($("#setTbodyTableSaveCost input[type='checkbox']:checked") != 
         $("#setTbodyTableSaveCost input[type='checkbox']").length      ){
        $("#checkboxAllTableSaveCost").prop('checked',false);
      }else{
        $("#checkboxAllTableSaveCost").prop('checked',true);
      }
    }

  })

  $("#sendDataSaveCostBtn").click(() => {
    let dataSave = []
    $('#setTbodyTableSaveCost').find('tr').each(function () {   
      if ($(this).find('input[type="checkbox"]').is(':checked')) {
          $(this).find("td:eq(2) select").prop('required',true);
          $(this).find("td:eq(3) select").prop('required',true);
          $(this).find("td:eq(4) select").prop('required',true);
          $(this).find("td:eq(6) input[type='text']").prop('required',true);
          $(this).find("td:eq(7) input[type='text']").prop('required',true);
          $(this).find("td:eq(9) input[type='text']").prop('required',true);
        dataSave.push('required');
      }
      else{
        $(this).find("td:eq(2) select").prop('required',false);
        $(this).find("td:eq(3) select").prop('required',false);
        $(this).find("td:eq(4) select").prop('required',true);
        $(this).find("td:eq(6) input[type='text']").prop('required',false);
        $(this).find("td:eq(7) input[type='text']").prop('required',false);
        $(this).find("td:eq(9) input[type='text']").prop('required',false);
      }
    })
    if (dataSave.length > 0) {
      costClickStatus = 'submit'
      $("#saveSaveCostBtnHide").click();
    } else {
      swal("กรุณาเลือกรายการ", "", "warning");
    }
  })

  function saveSubmitFn() {
    let dataSave = []
    $("#setTbodyTableSaveCost tr").each(function() {
      let resource_id = ''
      let resource_seq_num = ''
      for (let datas of dataDropdownTechnicianGroupOrder) {
        if ($(this).find("td:eq(3) select").val() == datas.resource_code) {
          resource_id = datas.resource_id
          resource_seq_num = datas.resource_seq_num
        }
      }
      let reason_id = ''
      let reason_name = ''
      for (let datas of dataDropdownResons) {
        if ($(this).find("td:eq(9) select").val() == datas.reason_id) {
          reason_id = datas.reason_id
          reason_name = datas.reason_name
        }
      }
      let data = {
        interface_flag:         $(this).find("td:eq(0) input[type='checkbox']").is(":checked") ? 'Y' : '',
        transfer_flag:          $(this).find("td:eq(1) input[type='text']").val() == 'COMPLETE' ? 'Y' : 
                                $(this).find("td:eq(1) input[type='text']").val() == 'ERROR' ? 'N' : null,
        transfer_flag_desc:     $(this).find("td:eq(1) input[type='text']").val(),
        operation_seq_num:      $(this).find("td:eq(2) select").val(),
        resource_seq_num:       resource_seq_num,
        reason_id:              reason_id,
        reason_name:            reason_name,
        or_transaction_id:      $(this).find("td:eq(13) input[type='text']").val(),
        line_num:               $(this).find("td:eq(14) input[type='text']").val(),
        organization_id:        organization_id,
        organization_code:      $(this).find("td:eq(15) input[type='text']").val(),
        wip_entity_name:        $("#workReceiptNumber option:selected").text(),
        wip_entity_desc:        $(this).find("td:eq(17) input[type='text']").val(),
        asset_id:               $(this).find("td:eq(18) input[type='text']").val(),
        asset_number:           $("#assetNumber").val(),
        asset_desc:             $(this).find("td:eq(20) input[type='text']").val(),
        resource_id:            resource_id,
        resource_code:          $(this).find("td:eq(3) select").val(),
        working_hour:           $(this).find("td:eq(21) input[type='text']").val(),
        uom:                    $(this).find("td:eq(22) input[type='text']").val(),
        instance_id:            $(this).find("td:eq(23) input[type='text']").val(),
        instance_name:          $(this).find("td:eq(24) input[type='text']").val(),
        instance_start_date:    $(this).find("td:eq(25) input[type='text']").val(),
        transaction_date_from:  $(this).find("td:eq(6) input[type='text']").val(),
        transaction_date_to:    $(this).find("td:eq(7) input[type='text']").val(),
        operation_duration:     $(this).find("td:eq(10) input[type='number']").val(),
        reference:              $(this).find("td:eq(28) input[type='text']").val(),
        wage_rate:              $(this).find("td:eq(29) input[type='text']").val(),
        cancel_flag:            $(this).find("td:eq(31) input[type='text']").val(),
        transfer_date:          $(this).find("td:eq(32) input[type='text']").val(),
        transfer_by:            $(this).find("td:eq(33) input[type='text']").val(),
        request_id:             $(this).find("td:eq(34) input[type='text']").val(),
        employee_id:            $(this).find("td:eq(13) input[type='text']").val(),
        employee_num:           $(this).find("td:eq(5) input[type='text']").val(),
        employee_name:          $(this).find("td:eq(4) select option:selected").text(),
        department_id:          $(this).find("td:eq(35) input[type='text']").val(),
        department_name:        $(this).find("td:eq(36) input[type='text']").val(),
        program_code:           'EAM0012',
        wip_entity_id:          wip_entity_id
      }

        let dataAll                 = $(this).find("td:last-child input[type='text']").val() ?
                                      $(this).find("td:last-child input[type='text']").val() : '';
        let webStatus               = $(this).find("td:last-child input[type='text']").attr('attr-web-status');

        data.attribute4             = $(this).find("td:eq(8) input[type='text']").val();
        data.attribute5             = $(this).find("td:eq(11) input[type='text']").val();
        data.or_transaction_id      = '';

        if (dataAll && dataAll != 'add') {
            dataAll                     = JSON.parse(dataAll);
            data.or_transaction_id      = dataAll.or_transaction_id ;
            data.line_num               = dataAll.line_num ;
            data.organization_code      = dataAll.organization_code ;
            data.wip_entity_desc        = dataAll.wip_entity_desc ;
            data.asset_id               = dataAll.asset_id ;
            data.asset_desc             = dataAll.asset_desc ;
            data.working_hour           = dataAll.working_hour ;
            data.uom                    = dataAll.uom ;
            data.instance_id            = dataAll.instance_id ;
            data.instance_name          = dataAll.instance_name ;
            data.instance_start_date    = dataAll.instance_start_date ;
            data.reference              = dataAll.reference ;
            data.wage_rate              = dataAll.wage_rate ;
            data.cancel_flag            = dataAll.cancel_flag ;
            data.transfer_date          = dataAll.transfer_date ;
            data.transfer_by            = dataAll.transfer_by ;
            data.request_id             = dataAll.request_id ;
            data.employee_id            = dataAll.employee_id ;
            data.employee_num           = dataAll.employee_num ;
            data.department_id          = dataAll.department_id ;
            data.department_name        = dataAll.department_name ;
            if (webStatus != 'CREATE') {
                data.or_transaction_id  = '';
            }
        }
      dataSave.push(data)
    })
    loader('show');
    $.ajax({
      url: "{{ route('eam.ajax.work-order.lb.submit') }}",
      type: "POST",
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      },
      data: JSON.stringify({data: dataSave}),
      success: function (response) {
        loader('hide');
        swal("Success", response.message, "success");
        workOrderlbAll();
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        loader('hide');
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
  }

  $("#undoDataSaveCostBtn").click(() => {
    let dataSave = []
    $('#setTbodyTableSaveCost').find('tr').each(function () {   
      if ($(this).find('input[type="checkbox"]').is(':checked')) {
          $(this).find("td:eq(2) select").prop('required',true)
          $(this).find("td:eq(3) select").prop('required',true)
          $(this).find("td:eq(4) select").prop('required',true)
          $(this).find("td:eq(6) input[type='text']").prop('required',true)
          $(this).find("td:eq(7) input[type='text']").prop('required',true)
          $(this).find("td:eq(9) input[type='text']").prop('required',true)
        dataSave.push('required')
      }
      else{
          $(this).find("td:eq(2) select").prop('required',false)
          $(this).find("td:eq(3) select").prop('required',false)
          $(this).find("td:eq(4) select").prop('required',true)
          $(this).find("td:eq(6) input[type='text']").prop('required',false)
          $(this).find("td:eq(7) input[type='text']").prop('required',false)
          $(this).find("td:eq(9) input[type='text']").prop('required',false)
      }
    })
    if (dataSave.length > 0) {
      costClickStatus = 'cancel'
      $("#saveSaveCostBtnHide").click();
    } else {
      swal("กรุณาเลือกรายการ", "", "warning");
    }
  })

  function saveCancelFn() {
    let dataSave = []
    $("#setTbodyTableSaveCost tr").each(function() {
      let resource_id = ''
      let resource_seq_num = ''
      for (let datas of dataDropdownTechnicianGroupOrder) {
        if ($(this).find("td:eq(3) select").val() == datas.resource_code) {
          resource_id = datas.resource_id
          resource_seq_num = datas.resource_seq_num
        }
      }
      let reason_id = ''
      let reason_name = ''
      for (let datas of dataDropdownResons) {
        if ($(this).find("td:eq(9) select").val() == datas.reason_id) {
          reason_id = datas.reason_id
          reason_name = datas.reason_name
        }
      }
      let data = {
        interface_flag:         $(this).find("td:eq(0) input[type='checkbox']").is(":checked") ? 'Y' : '',
        transfer_flag:          $(this).find("td:eq(1) input[type='text']").val() == 'COMPLETE' ? 'Y' : 
                                $(this).find("td:eq(1) input[type='text']").val() == 'ERROR' ? 'N' : null,
        transfer_flag_desc:     $(this).find("td:eq(1) input[type='text']").val(),
        operation_seq_num:      $(this).find("td:eq(2) select").val(),
        resource_seq_num:       resource_seq_num,
        reason_id:              reason_id,
        reason_name:            reason_name,
        or_transaction_id:      $(this).find("td:eq(13) input[type='text']").val(),
        line_num:               $(this).find("td:eq(14) input[type='text']").val(),
        organization_id:        organization_id,
        organization_code:      $(this).find("td:eq(15) input[type='text']").val(),
        wip_entity_name:        $("#workReceiptNumber option:selected").text(),
        wip_entity_desc:        $(this).find("td:eq(17) input[type='text']").val(),
        asset_id:               $(this).find("td:eq(18) input[type='text']").val(),
        asset_number:           $("#assetNumber").val(),
        asset_desc:             $(this).find("td:eq(20) input[type='text']").val(),
        resource_id:            resource_id,
        resource_code:          $(this).find("td:eq(3) select").val(),
        working_hour:           $(this).find("td:eq(21) input[type='text']").val(),
        uom:                    $(this).find("td:eq(22) input[type='text']").val(),
        instance_id:            $(this).find("td:eq(23) input[type='text']").val(),
        instance_name:          $(this).find("td:eq(24) input[type='text']").val(),
        instance_start_date:    $(this).find("td:eq(25) input[type='text']").val(),
        transaction_date_from:  $(this).find("td:eq(6) input[type='text']").val(),
        transaction_date_to:    $(this).find("td:eq(7) input[type='text']").val(),
        operation_duration:     $(this).find("td:eq(10) input[type='number']").val(),
        reference:              $(this).find("td:eq(28) input[type='text']").val(),
        wage_rate:              $(this).find("td:eq(29) input[type='text']").val(),
        cancel_flag:            $(this).find("td:eq(31) input[type='text']").val(),
        transfer_date:          $(this).find("td:eq(32) input[type='text']").val(),
        transfer_by:            $(this).find("td:eq(33) input[type='text']").val(),
        request_id:             $(this).find("td:eq(34) input[type='text']").val(),
        employee_id:            $(this).find("td:eq(13) input[type='text']").val(),
        employee_num:           $(this).find("td:eq(5) input[type='text']").val(),
        employee_name:          $(this).find("td:eq(4) select option:selected").text(),
        department_id:          $(this).find("td:eq(35) input[type='text']").val(),
        department_name:        $(this).find("td:eq(36) input[type='text']").val(),
        program_code:           'EAM0012',
        wip_entity_id:          wip_entity_id
      }

        let dataAll                 = $(this).find("td:last-child input[type='text']").val() ? 
                                      $(this).find("td:last-child input[type='text']").val() : '';
        let webStatus               = $(this).find("td:last-child input[type='text']").attr('attr-web-status');

        data.attribute4             = $(this).find("td:eq(8) input[type='text']").val();
        data.attribute5             = $(this).find("td:eq(11) input[type='text']").val();
        data.or_transaction_id      = '';
        
        if (dataAll && dataAll != 'add') {
            dataAll                     = JSON.parse(dataAll);
            data.or_transaction_id      = dataAll.or_transaction_id ;
            data.line_num               = dataAll.line_num ;
            data.organization_code      = dataAll.organization_code ;
            data.wip_entity_desc        = dataAll.wip_entity_desc ;
            data.asset_id               = dataAll.asset_id ;
            data.asset_desc             = dataAll.asset_desc ;
            data.working_hour           = dataAll.working_hour ;
            data.uom                    = dataAll.uom ;
            data.instance_id            = dataAll.instance_id ;
            data.instance_name          = dataAll.instance_name ;
            data.instance_start_date    = dataAll.instance_start_date ;
            data.reference              = dataAll.reference ;
            data.wage_rate              = dataAll.wage_rate ;
            data.cancel_flag            = dataAll.cancel_flag ;
            data.transfer_date          = dataAll.transfer_date ;
            data.transfer_by            = dataAll.transfer_by ;
            data.request_id             = dataAll.request_id ;
            data.employee_id            = dataAll.employee_id ;
            data.employee_num           = dataAll.employee_num ;
            data.department_id          = dataAll.department_id ;
            data.department_name        = dataAll.department_name ;
            if (webStatus != 'CREATE') {
                data.or_transaction_id  = '';
            }
        }
      dataSave.push(data)
    })
    loader('show');
    $.ajax({
      url: "{{ route('eam.ajax.work-order.lb.cancel') }}",
      type: "POST",
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      },
      data: JSON.stringify({data: dataSave}),
      success: function (response) {
        loader('hide');
        swal("Success", response.message, "success");
        workOrderlbAll();
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        loader('hide');
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
  }
  
</script>