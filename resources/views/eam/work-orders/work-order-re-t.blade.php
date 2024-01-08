<script>
  function workOrderReAll() {
    $.ajax({
      url: "{{ route('eam.ajax.work-order.re.all',['']) }}/" + wip_entity_id,
      method: 'GET',
      success: function (response) {
        if (response.data.length > 0) {
          $("#resourceOperationBtn").attr('disabled', true);
        } else if ( $("#jobReceiptStatus").val() == '1' || 
                    $("#jobReceiptStatus").val() == '17' || 
                    $("#jobReceiptStatus").val() == '3' || 
                    $("#jobReceiptStatus").val() == '6') {
          $("#resourceOperationBtn").attr('disabled', false);
        } else {
          $("#resourceOperationBtn").attr('disabled', true);
        }
        setTableGroupTechniciansFn(response);
        $('#tableGroupTechnicians').css('display', '')
        $('#hideTbGroupTechnicians').css('display', '')
        $("#btnHideGroupTechnicians").removeClass("pointer fa fa-caret-down");
        $("#btnHideGroupTechnicians").addClass("pointer fa-caret-up fa");
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
  }
  $("#addGroupTechniciansBtn").click(() => {
    setAddTableGroupTechniciansFn()
  })
  function setAddTableGroupTechniciansFn() {
    $("#resourceOperationBtn").attr('disabled', true);
    let sum10 = '';
    let listData = [];
    let listData2 = [];
    let maxVal = 0;
    let index = $("#setTbodyTableGroupTechnicians td .sum10").length - 1;
    // $("#setTbodyTableGroupTechnicians td .sum10").each(function() {
    //   if ($(this).val() > maxVal) {
    //     maxVal = $(this).val()
    //     console.log(maxVal)
    //   }
    //   // sum10 += 10
    //   // listData.push(parseInt(sum10))
    //   // listData2.push(parseInt($(this).val()))
    // })
    // if (sum10 != maxVal) {
    //   var result = [];
    //     listData2.filter((row2)=>{
    //       const index = listData.indexOf(row2);
    //       if (index > -1) {
    //         listData.splice(index, 1);
    //       }
    //     })
    //   sum10 = (listData[0] - 10)
    // }
    let optionWorkOrder = '';
    optionWorkOrder += `<option value=""></option>`
    for (let data of dataDropDownWorkOrder) {
      optionWorkOrder += `<option value="${data.operation_seq_num}">${data.operation_seq_num}</option>`
    }
    let optionTechnicianGroupCode = ''
      optionTechnicianGroupCode += `<option value=""></option>`
    for (let data of dataDropdownTechnicianGroupCode) {
      optionTechnicianGroupCode += `<option value="${data.resource_id}">${data.resource_code}</option>`
    }
    let tbodyTableOperlation = ''
    tbodyTableOperlation += `<tr onclick="selectTableRow(this)">`
    tbodyTableOperlation += `<td><select  class="form-control workOrder" 
                                          required>`+optionWorkOrder+`
                                </select>
                            </td>`
    tbodyTableOperlation += `<td><input type="text" 
                                        class="form-control sum10" 
                                        value="${+sum10}" 
                                        disabled  
                                        autocomplete="off">
                            </td>`
    tbodyTableOperlation += `<td>
                              <div class="input-group">
                                <select id="departmentTableGroupTechniciansAdd${+index}"
                                        class="form-control readonly" 
                                        data-server="/eam/ajax/lov/departments"  
                                        data-id="department_code" 
                                        data-text="description" 
                                        data-field="select"
                                        disabled>
                                </select>
                                <div class="input-group-append">
                                  <span class="input-group-append">
                                    <button onclick="departmentLovBtnTableOnclick({nameDepartmentModal: 'หน่วยงานผู้ซ่อม/ผู้ผลิต', idDepartmentModal: this})" type="button" class="btn btn-default" disabled><i class="fa fa-search"></i></button>
                                  </span>
                                </div>
                              </div>
                            </td>`
    tbodyTableOperlation += `<td><select  class="form-control technicianGroupCode" 
                                          required >`+optionTechnicianGroupCode+`
                                </select>
                            </td>`
    tbodyTableOperlation += `<td><input type="text" 
                                        class="form-control" 
                                        value="" 
                                        disabled 
                                        autocomplete="off">
                            </td>`
    tbodyTableOperlation += `<td><select  class="form-control" 
                                          value="" 
                                          disabled>
                                    <option value="1">Item</option>
                                  </select>
                              </td>`
    tbodyTableOperlation += `<td><input type="text" 
                                        class="form-control hour" 
                                        value="" 
                                        required 
                                        autocomplete="off">
                            </td>`
    tbodyTableOperlation += `<td><input type="text" 
                                        class="form-control" 
                                        value="" 
                                        disabled 
                                        autocomplete="off">
                            </td>`
    tbodyTableOperlation += `<td class="d-none">
                                <input  type="text" 
                                        class="form-control" 
                                        value="add" 
                                        hidden 
                                        autocomplete="off">
                            </td>`
    tbodyTableOperlation += `</tr>`
    $("#setTbodyTableGroupTechnicians").append(tbodyTableOperlation);
    changWorkOder()
    changTechnicianGroupCode()
    changHour()
    triggerSelect2InEAM0010();
    setSelect2InEAM0010TbodyTableGroupTechnicians();    
  }
  function setTableGroupTechniciansFn(data) {
    let tbodyTableOperlation = ''
    if (data.data.length > 0) {
      data.data.filter((row, index) => {
        let optionWorkOrder = '';
        optionWorkOrder += `<option value=""></option>`
        for (let data of dataDropDownWorkOrder) {
          optionWorkOrder += `<option value="${data.operation_seq_num}" ${row.operation_seq_num == data.operation_seq_num ? 'selected' : ''}>${data.operation_seq_num}</option>`
        }
        let optionTechnicianGroupCode = ''
          optionTechnicianGroupCode += `<option value=""></option>`
        for (let data of dataDropdownTechnicianGroupCode) {
          if (data.department_code == row.department_code) {
            optionTechnicianGroupCode += `<option value="${data.resource_id}" ${row.resource_id == data.resource_id ? 'selected' : ''}>${data.resource_code}</option>`
          }
        }
        tbodyTableOperlation += `<tr  onclick="selectTableRow(this)" 
                                      style="${statusDisabledRe ? 
                                      'pointer-events: none;' : ''}">`
        tbodyTableOperlation += `<td><select  class="form-control workOrder" 
                                              disabled 
                                              required >`+optionWorkOrder+`</select>
                                  </td>`
        tbodyTableOperlation += `<td><input type="text" 
                                            class="form-control sum10" 
                                            value="${row.resource_seq_num ? row.resource_seq_num : ''}" 
                                            disabled  
                                            autocomplete="off">
                                  </td>`
        tbodyTableOperlation += `<td>
                                  <div class="input-group">
                                    <select id="departmentTableGroupTechniciansFn${index}"
                                            class="form-control readonly" 
                                            data-server="/eam/ajax/lov/departments"  
                                            data-id="department_code" 
                                            data-text="description" 
                                            data-field="select"
                                            disabled>
                                    </select>
                                    <div class="input-group-append">
                                      <span class="input-group-append">
                                        <button onclick="departmentLovBtnTableOnclick({nameDepartmentModal: 'หน่วยงานผู้ซ่อม/ผู้ผลิต', idDepartmentModal: this})" type="button" disabled class="btn btn-default"><i class="fa fa-search"></i></button>
                                      </span>
                                    </div>
                                  </div>
                                </td>`
        tbodyTableOperlation += `<td><select  class="form-control technicianGroupCode" 
                                              required ${statusDisabledRe ? 'disabled' : ''}>`+optionTechnicianGroupCode+`
                                              style="width: 180px;"
                                      </select>
                                </td>`
        tbodyTableOperlation += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="${row.resource_desc ? row.resource_desc : ''}" 
                                            disabled 
                                            autocomplete="off">
                                </td>`
        tbodyTableOperlation += `<td> <select class="form-control" disabled style="width: 130px;">
                                      <option value="${row.basis_type ? row.basis_type : ''}">${row.basis_desc ? row.basis_desc : ''}</option>
                                      </select>
                                </td>`
        tbodyTableOperlation += `<td><input type="text" class="form-control hour" value="${row.usage_rate_or_amount ? row.usage_rate_or_amount : ''}" required autocomplete="off" ${statusDisabledRe ? 'disabled' : ''}></td>`
        tbodyTableOperlation += `<td><input type="text" class="form-control" value="${row.inverse ? row.inverse : ''}" disabled autocomplete="off"></td>`
        tbodyTableOperlation += `<td class="d-none"><input type="text" class="form-control" value="" hidden autocomplete="off"></td>`
        tbodyTableOperlation += `</tr>`
      })
    }
    $("#setTbodyTableGroupTechnicians").html(tbodyTableOperlation);
    changWorkOder();
    changTechnicianGroupCode();
    changHour();
    readonly();
    triggerSelect2InEAM0010();
    setSelect2InEAM0010TbodyTableGroupTechnicians();

    data.data.filter((row, index) => {
      //Default หน่วยงานผู้ซ่อม/ผู้ผลิต
      var newOptionDepartment = new Option((row.department_code ? row.department_code : '')+ ' - ' + 
                                           (row.department_desc ? row.department_desc : ''), row.department_code, true, true);
      $('#departmentTableGroupTechniciansFn'+ index).append(newOptionDepartment).trigger('change');
      $('#departmentTableGroupTechniciansFn'+ index).val(row.department_code ? row.department_code : '').trigger('change');
    })
  }
  function setResourceTableGroupTechniciansFn(data) {
    let response = data.response.data;
    let operationSeqNum = data.operation_seq_num;
    let operationSeqNumPreviou = operationSeqNum - 10;
    let tbodyTableOperlation = '';
    let sum10 = 10;
    let seqGroupTechnic = 10;
    let length = (response.length*10);

    if (response.length > 0) {
      const repairHours = (Number($("#repairHours").val()) / response.length).toFixed(2);
        $("#setTbodyTableGroupTechnicians td .sum10").each(function() {
          seqGroupTechnic = Number($(this).val());
          sum10 = 10;
        })
      response.filter((row, index) => {
        let optionWorkOrder = '';
        optionWorkOrder += `<option value=""></option>`
        for (let data of dataDropDownWorkOrder) {
          optionWorkOrder += `<option value="${data.operation_seq_num}" 
                                      ${data.operation_seq_num == operationSeqNum ? 'selected' : ''}>
                                      ${data.operation_seq_num}
                              </option>`
        }
        let optionTechnicianGroupCode = ''
        optionTechnicianGroupCode += `<option value=""></option>`
        for (let data of dataDropdownTechnicianGroupCode) {
          if (data.department_code == row.department_code) {
            optionTechnicianGroupCode += `<option value="${data.resource_id}" 
                                                  ${row.resource_id == data.resource_id ? 'selected' : ''}>
                                                  ${data.resource_code}
                                          </option>`
          }
        }
        tbodyTableOperlation += `<tr  onclick="selectTableRow(this)">`
        tbodyTableOperlation += `<td>
                                      <select class="form-control workOrder" 
                                        value="${sum10}" 
                                        required >`+optionWorkOrder+`
                                      </select>
                                </td>`
        tbodyTableOperlation += `<td>
                                  <input  type="text" 
                                          class="form-control sum10" 
                                          value="${sum10}" 
                                          disabled  
                                          autocomplete="off">
                                </td>`
        tbodyTableOperlation += `<td>
                                  <div class="input-group">
                                    <div class="input-group">
                                    <select id="resourceDepartmentTableGroupTechniciansFn${+operationSeqNum}${+sum10}"
                                            class="form-control readonly" 
                                            data-server="/eam/ajax/lov/departments"  
                                            data-id="department_code" 
                                            data-text="description" 
                                            data-field="select"
                                            disabled>
                                    </select>
                                    <div class="input-group-append">
                                      <span class="input-group-append">
                                        <button onclick="departmentLovBtnTableOnclick({nameDepartmentModal: 'หน่วยงานผู้ซ่อม/ผู้ผลิต', idDepartmentModal: this})" 
                                                type="button" 
                                                disabled 
                                                class="btn btn-default">
                                          <i class="fa fa-search"></i>
                                        </button>
                                      </span>
                                    </div>
                                  </div>
                                </td>`
        tbodyTableOperlation += `<td>
                                    <select class="form-control technicianGroupCode" 
                                            required >`+optionTechnicianGroupCode+`
                                    </select>
                                </td>`
        tbodyTableOperlation += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="${row.resource_desc ? row.resource_desc : ''}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
        tbodyTableOperlation += `<td>
                                    <select class="form-control" 
                                            value="" 
                                            disabled>
                                      <option value="1">Item</option>
                                    </select>
                                </td>`
        tbodyTableOperlation += `<td>
                                    <input  type="text" 
                                            class="form-control hour" 
                                            value="${repairHours || 1}" 
                                            required 
                                            autocomplete="off">
                                </td>`
        tbodyTableOperlation += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="1" 
                                            disabled 
                                            autocomplete="off">
                                </td>`
        tbodyTableOperlation += `<td class="d-none">
                                    <input  type="text" 
                                            class="form-control" 
                                            value="add" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableOperlation += `</tr>`
        seqGroupTechnic += 10;
        sum10 += 10;
      })
          
    }

    $("#setTbodyTableGroupTechnicians").append(tbodyTableOperlation);
    changWorkOder();
    changTechnicianGroupCode();
    changHour();
    changHourDefault();
    readonly();
    triggerSelect2InEAM0010();
    setSelect2InEAM0010TbodyTableGroupTechnicians();

    if (response.length > 0) {
      $("#resourceOperationBtn").attr('disabled', true);
    } else {
      $("#resourceOperationBtn").attr('disabled', false);
    }

    let round = 10;
    response.filter((row, index) => {
      //Default หน่วยงานผู้ซ่อม/ผู้ผลิต
      var newOptionDepartment = new Option((row.department_code ? row.department_code : '')+ ' - ' + 
                                            (row.department_desc ? row.department_desc : ''), row.department_code, true, true);
      $('#resourceDepartmentTableGroupTechniciansFn'+ data.operation_seq_num + round).append(newOptionDepartment).trigger('change');
      $('#resourceDepartmentTableGroupTechniciansFn'+ data.operation_seq_num + round).val(row.department_code ? row.department_code : '').trigger('change');
      round += 10;
    })
  }
  $("#saveGroupTechniciansBtn").click(() => {
    $("#saveGroupTechniciansBtnHide").click();
  })
  function formSaveGroupTechniciansBtnHide() {
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
        $("#setTbodyTableGroupTechnicians tr ").each(function() {
          let data = {
            operation_seq_num: Number($(this).find("td:eq(0) select").val()),
            resource_seq_num: Number($(this).find("td:eq(1) input[type='text']").val()),
            department_id: '',
            // department_code: $(this).find("td:eq(2) input[type='text']").val().split(' - ')[0],
            department_code: $(this).find("td:eq(2) select").val(),
            resource_id: $(this).find("td:eq(3) option:selected").val(),
            resource_code: $(this).find("td:eq(3) option:selected").text(),
            resource_desc: $(this).find("td:eq(4) input[type='text']").val(),
            basis_type: Number($(this).find("td:eq(5) select").val()),
            basis_desc: $(this).find("td:eq(5) option:selected").text(),
            usage_rate_or_amount: Number($(this).find("td:eq(6) input[type='text']").val()),
            inverse: Number($(this).find("td:eq(7) input[type='text']").val()),
            program_code: 'EAM0010',
            wip_entity_id: Number(wip_entity_id),
            organization_id: Number(organization_id),
            or_wip_entity_id: Number(or_wip_entity_id)
          }
          dataSave.push(data)
        })
        if (dataSave.length > 0) {
          $.ajax({
            url: "{{ route('eam.ajax.work-order.re.store') }}",
            type: "POST",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: JSON.stringify({data: dataSave}),
            success: function (response) {
              swal("Success", response.message, "success");
              apiTechnicianGroupOrderRef('setTableSaveCost');
              apiWorkOrderHeadShowRe();
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        } else {
          swal("กรุณาเพิ่มรายการ", "", "warning");
        }
     }
    )
  }
  $("#deleteGroupTechniciansBtn").click(() => {
    let dataSaveCheckAdd = []
    let dataSave = []
    $("#setTbodyTableGroupTechnicians .bg-select-table").each(function() {
      if ($(this).find("td:eq(8) input[type='text']").val() == 'add') {
        dataSaveCheckAdd.push($(this));
      } else {
        let data = {
          operation_seq_num:      Number($(this).find("td:eq(0) select").val()),
          resource_seq_num:       Number($(this).find("td:eq(1) input[type='text']").val()),
          department_id:          '',
          department_code:        $(this).find("td:eq(2) select").val(),
          resource_id:            $(this).find("td:eq(3) option:selected").val(),
          resource_code:          $(this).find("td:eq(3) option:selected").text(),
          resource_desc:          $(this).find("td:eq(4) input[type='text']").val(),
          basis_type:             Number($(this).find("td:eq(5) select").val()),
          basis_desc:             $(this).find("td:eq(5) option:selected").text(),
          usage_rate_or_amount:   Number($(this).find("td:eq(6) input[type='text']").val()),
          inverse:                Number($(this).find("td:eq(7) input[type='text']").val()),
          program_code:           'EAM0010',
          wip_entity_id:          Number(wip_entity_id),
          organization_id:        Number(organization_id),
          or_wip_entity_id:       Number(or_wip_entity_id)
        }
        dataSave.push(data)
      }
    })
    if (dataSave.length > 0) {
      $.ajax({
        url: "{{ route('eam.ajax.work-order.re.delete') }}",
        type: "POST",
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: JSON.stringify({data: dataSave}),
        success: function (response) {
          swal("Success", response.message, "success");
          apiTechnicianGroupOrderRef('setTableSaveCost');
          apiWorkOrderHeadShowRe();
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    } else if (dataSaveCheckAdd.length > 0) {
      dataSaveCheckAdd.filter(row => {
        $(row).remove();
      })
      $("#setTbodyTableGroupTechnicians tr").length == '0' ? $("#resourceOperationBtn").attr('disabled', false) : $("#resourceOperationBtn").attr('disabled', true)
    } else {
      swal("กรุณาเลือกรายการ", "", "warning");
    }
  })
  function changHour() {
    $("#setTbodyTableGroupTechnicians .hour").keyup(function() {
      if ($(this).val() != '') {
        $(this).parents('tr').find("td:eq(7) input[type='text']").val(1/$(this).val())
      } else {
        $(this).parents('tr').find("td:eq(7) input[type='text']").val('')
      }
    })
  }
  function changHourDefault() {
    $("#setTbodyTableGroupTechnicians tr").each(function() {
      $(this).find("td:eq(7) input[type='text']").val(1/Number($(this).find("td:eq(6) input[type='text']").val()));
    });
  }
  function apiWorkOrderHeadShowRe() {
    $.ajax({
      url: "{{ route('eam.ajax.work-order.head.show',['']) }}/" + $("#workReceiptNumber").val(),
      method: 'GET',
      success: function (response) {
        $(".clearable").removeClass('x onX');
        clearAllTable();
        setDataLovWorkReceiptNumberResponse(response)
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
  }

  
</script>
