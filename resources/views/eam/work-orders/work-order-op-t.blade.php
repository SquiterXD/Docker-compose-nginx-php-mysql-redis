<script>
  function apiOperation() {
    $.ajax({
      url: "{{ route('eam.ajax.work-order.op.all',['']) }}/" + wip_entity_id,
      method: 'GET',
      success: function (response) {
        setTableOperationFn(response);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
  }
  function setTableOperationFn(data) {
    let tbodyTableOperlation = ''
    if (data.data.length > 0) {
      data.data.filter((row, index) => {
        tbodyTableOperlation += `<tr  onclick="selectTableRow(this)" 
                                      style="${statusDisabledOp ? 'pointer-events: none;' : ''}">`
        tbodyTableOperlation += `<td>
                                  <input  type="text" 
                                          class="form-control sum10" 
                                          name="" 
                                          value="${row.operation_seq_num ? row.operation_seq_num : ''}" 
                                          disabled  
                                          autocomplete="off">
                                </td>`
        tbodyTableOperlation += `<td>
                                  <div class="input-group">
                                    <select id="departmentOperationFn_`+ index +`"
                                            class="form-control 
                                                   ${row.department_code && !statusDisabledOp ? 'clearable' : ''} 
                                                   readonly" 
                                            data-server="/eam/ajax/lov/departments"  
                                            data-id="department_code" 
                                            data-text="description" 
                                            data-field="select"
                                            ${statusDisabledOp ? 'disabled' : ''}  
                                            required
                                            style="width: 400px;">
                                    </select>
                                    <div class="input-group-append">
                                      <span class="input-group-append">
                                        <button onclick="departmentLovBtnTableOnclick({nameDepartmentModal: 'หน่วยงานผู้ซ่อม/ผู้ผลิต', idDepartmentModal: this})" type="button" class="btn btn-default" ${statusDisabledOp ? 'disabled' : ''}><i class="fa fa-search"></i></button>
                                      </span>
                                    </div>
                                  </div>
                                </td>`
        tbodyTableOperlation += `<td>
                                    <input  id="dateTableStartOperlation${index}" 
                                            type="text" 
                                            class="form-control" 
                                            name="" 
                                            value="" 
                                            autocomplete="off">
                                </td>`
        tbodyTableOperlation += `<td>
                                    <input  id="dateTableEndOperlation${index}" 
                                            type="text" 
                                            class="form-control" 
                                            name="" 
                                            value="" 
                                            autocomplete="off">
                                </td>`
        tbodyTableOperlation += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            name="" 
                                            value="${row.long_description ? row.long_description : ''}" 
                                            autocomplete="off" 
                                            ${statusDisabledOp ? 'disabled' : ''}>
                                </td>`
        tbodyTableOperlation += `<td class="d-none">
                                    <input  type="text" 
                                            class="form-control" 
                                            value="" 
                                            hidden 
                                            autocomplete="off">
                                </td>`
        tbodyTableOperlation += `</tr>`
      })
    }
    $("#setTbodyTableOperation").html(tbodyTableOperlation);
    triggerSelect2InEAM0010();

    data.data.filter((row, index) => {
      setDateTimePickerAll({idDate: `dateTableStartOperlation${index}`, nameDate: '', onchange: false, date: row.first_unit_start_date ? row.first_unit_start_date : '', disabled: statusDisabledOp, required: true, dateEndId: `dateTableEndOperlation${index}`});
      setDateTimePickerAll({idDate: `dateTableEndOperlation${index}`, nameDate: '', onchange: false, date: row.last_unit_completion_date ? row.last_unit_completion_date : '', disabled: statusDisabledOp, required: true});
      vmDateTimePickerAll[`dateTableEndOperlation${index}`].pDisabled = row.first_unit_start_date;

      //Default หน่วยงานผู้ซ่อม/ผู้ผลิต
      var newOptionDepartment = new Option((row.department_code ? row.department_code : '')+ ' - ' + 
                                           (row.department_description ? row.department_description : ''), row.department_code, true, true);
      $('#departmentOperationFn_'+ index).append(newOptionDepartment).trigger('change');
      $('#departmentOperationFn_'+ index).val(row.department_code ? row.department_code : '').trigger('change');
    })

    readonly();
  }
  $("#addOperationBtn").click(() => {
    let sum10 = 0
    let listData = []
    let listData2 = []
    let maxVal = 0
    $("#setTbodyTableOperation td .sum10").each(function(index) {
      if ($(this).val() > maxVal) {
        maxVal = $(this).val()
      }
      sum10 += 10
      listData.push(parseInt(sum10))
      listData2.push(parseInt($(this).val()))
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

    let tbodyTableOperlation = ''
    tbodyTableOperlation += `<tr onclick="selectTableRow(this)">`
    tbodyTableOperlation += `<td><input type="text" class="form-control sum10" value="${+sum10 + 10}" disabled autocomplete="off"></td>`
    tbodyTableOperlation += `<td>
                              <div class="input-group">
                                <select id="departmentOperationAdd${+sum10 + 10}"
                                        class="form-control ${$("#notifyingAgency").val() ? 'x clearable' : ''} readonly" 
                                        data-server="/eam/ajax/lov/departments"  
                                        data-id="department_code" 
                                        data-text="description" 
                                        data-field="select"
                                        required
                                        style="width: 400px;">
                                </select>
                                <div class="input-group-append">
                                  <span class="input-group-append">
                                    <button onclick="departmentLovBtnTableOnclick({nameDepartmentModal: 'หน่วยงานผู้ซ่อม/ผู้ผลิต', idDepartmentModal: this})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                                  </span>
                                </div>
                              </div>
                            </td>`
    tbodyTableOperlation += `<td><input id="dateTableStartOperlationAdd${+sum10 + 10}" type="text" class="form-control" name="" value="" autocomplete="off"></td>`
    tbodyTableOperlation += `<td><input id="dateTableEndOperlationAdd${+sum10 + 10}" type="text" class="form-control" name="" value="" autocomplete="off"></td>`
    tbodyTableOperlation += `<td><input type="text" class="form-control" name="" autocomplete="off"></td>`
    tbodyTableOperlation += `<td class="d-none"><input type="text" class="form-control" value="add" hidden autocomplete="off"></td>`
    tbodyTableOperlation += `</tr>`
    $("#setTbodyTableOperation").append(tbodyTableOperlation);
    triggerSelect2InEAM0010();

    setDateTimePickerAll({idDate: `dateTableStartOperlationAdd${+sum10 + 10}`, nameDate: '', onchange: false, date: $("#repairDateStart").val(), disabled: false, required: true, dateEndId: `dateTableEndOperlationAdd${+sum10 + 10}`});
    setDateTimePickerAll({idDate: `dateTableEndOperlationAdd${+sum10 + 10}`, nameDate: '', onchange: false, date: $("#repairDateEnd").val(), disabled: false, required: true});
    vmDateTimePickerAll[`dateTableEndOperlationAdd${+sum10 + 10}`].pDisabled = $("#repairDateStart").val();

    //Default หน่วยงานผู้ซ่อม/ผู้ผลิต
    var newOptionDepartment = new Option($("#notifyingAgency option:selected")[0].label, $("#notifyingAgency").val(), true, true);
    $(`#departmentOperationAdd${+sum10 + 10}`).append(newOptionDepartment).trigger('change');
    $(`#departmentOperationAdd${+sum10 + 10}`).val($("#notifyingAgency").val() ? $("#notifyingAgency").val() : '').trigger('change');
    
    if ($("#notifyingAgency").val() != '') {
      $("#repairerAgency"+(+sum10 + 10)).addClass('x');
    }
    readonly();
  })
  $("#saveOperationBtn").click(() => {
    $("#saveOperationBtnHide").click();
  })
  function formSaveOperationBtnHide() {   
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
      $("#setTbodyTableOperation tr ").each(function() {
        let data = {
          operation_seq_num: $(this).find("td:eq(0) input[type='text']").val(),
          department_id: $(this).find("td:eq(1) select").val(),
          department_description: $(this).find("td:eq(1) select option:selected").text().split(' - ')[1],
          first_unit_start_date: $(this).find("td:eq(2) input[type='text']").val(),
          last_unit_completion_date: $(this).find("td:eq(3) input[type='text']").val(),
          long_description: $(this).find("td:eq(4) input[type='text']").val(),
          program_code: 'EAM0010',
          wip_entity_id: wip_entity_id,
          organization_id: organization_id
        }
        dataSave.push(data)
      })
      if (dataSave.length > 0) {
        $.ajax({
          url: "{{ route('eam.ajax.work-order.op.store') }}",
          type: "POST",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          data: JSON.stringify({data: dataSave}),
          success: function (response) {
            swal("Success", response.message, "success");
            apiOperation();
            updateDataDropDownWorkOrder();
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      } else  {
        swal("กรุณาเพิ่มรายการ", "", "warning");
      }
    })
  }
  $("#deleteOperationBtn").click(() => {
    let dataSaveCheckAdd = []
    let dataSave = []
    $("#setTbodyTableOperation .bg-select-table").each(function() {
      if ($(this).find("td:eq(5) input[type='text']").val() == 'add') {
        dataSaveCheckAdd.push($(this));
      } else {
        let data = {
          operation_seq_num: $(this).find("td:eq(0) input[type='text']").val(),
          wip_entity_id: wip_entity_id
        }
        dataSave.push(data)
      }
    })
    if (dataSave.length > 0) {
      $.ajax({
        url: "{{ route('eam.ajax.work-order.op.delete') }}",
        type: "POST",
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: JSON.stringify({data: dataSave}),
        success: function (response) {
          swal("Success", response.message, "success");
          apiOperation();
          updateDataDropDownWorkOrder();
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    } else if (dataSaveCheckAdd.length > 0) {
      dataSaveCheckAdd.filter(row => {
        $(row).remove();
      })
    } else {
      swal("กรุณาเลือกรายการ", "", "warning");
    }
  })
  $("#resourceOperationBtn").click(() => {
    $("#btnHideGroupTechnicians").removeClass("pointer fa fa-caret-down");
    $("#btnHideGroupTechnicians").addClass("pointer fa-caret-up fa");
    if ($("#tableGroupTechnicians").css('display') == 'none') {
      $("#tableGroupTechnicians").toggle(500);
      $("#hideTbGroupTechnicians").toggle(500);
    }
    $("#setTbodyTableOperation tr").each(function() {
      if($(this).find("td:eq(1) select").val()){
        let operation_seq_num = $(this).find("td:eq(0) input[type='text']").val()
        $.ajax({
          url: "{{ route('eam.ajax.lov.dep-resource') }}",
          method: 'GET',
          data: {department_code: $(this).find("td:eq(1) select").val()},
          success: function (response) {
            setResourceTableGroupTechniciansFn({response: response, operation_seq_num: operation_seq_num})
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    })
  })
</script>