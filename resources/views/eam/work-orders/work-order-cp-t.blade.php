<script>
  $("#completeWorkOrderBtn").click(() => {
    apiComplete();
  })

  function apiComplete() {
    $.ajax({
      url: "{{ route('eam.ajax.work-order.cp.all',['']) }}/" + wip_entity_id,
      method: 'GET',
      success: function (response) {
        setTableCompleteFn(response);
        $('#hideTbComplete').css('display', '');
        $('#btnSaveComplete').css('display', '');
        $("#btnHideComplete").removeClass("pointer fa fa-caret-down");
        $("#btnHideComplete").addClass("pointer fa-caret-up fa");
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
  }

  function setTableCompleteFn(data) {
    let tbodyTableComplete = ''
    let sum10 = 0
    let indexShow = 0
    if (data.data.length > 0) {
      if ($("#stopMachine").val() == '2') {
        $("#dateTimeStopMachineSt").text('*')
        $("#dateTimeStopMachineSum").text('*')
        $("#dateTimeStopMachineEn").text('*')
      } else {
        $("#dateTimeStopMachineSt").text('')
        $("#dateTimeStopMachineSum").text('')
        $("#dateTimeStopMachineEn").text('')
      }
      data.data.filter((row, index) => {
        tbodyTableComplete += `<tr>`
        tbodyTableComplete += `<td><input type="text" class="form-control" value="${row.completion_status ? row.completion_status : ''}" disabled autocomplete="off"></td>`
        tbodyTableComplete += `<td><input id="dateTableStartCompleteStart${index}" type="text" class="form-control" value=""  autocomplete="off"></td>`
        tbodyTableComplete += `<td>
                                <input  type="number" 
                                        class="form-control" 
                                        value="${row.actual_duration ? row.actual_duration : ''}" 
                                        required 
                                        ${$("#completeWorkOrderBtn").text() == 'Uncomplete Work Order' ? 'disabled': ''} 
                                        autocomplete="off"
                                        step="any">
                                </td>`
        tbodyTableComplete += `<td><input id="dateTableEndCompleteStart${index}" type="text" class="form-control" value="" autocomplete="off"></td>`
        tbodyTableComplete += `<td><input id="dateTableStartCompleteStop${index}" type="text" class="form-control" value="" autocomplete="off"></td>`
        tbodyTableComplete += `<td>
                                <input  type="number" 
                                        class="form-control" 
                                        step="any" 
                                        value="${row.shutdown_duration ? row.shutdown_duration : ''}" 
                                        ${$("#completeWorkOrderBtn").text() == 'Uncomplete Work Order' ? 'disabled': ''} 
                                        ${$("#stopMachine").val() == '2' ? 'required' : ''}
                                        autocomplete="off">
                              </td>`
        tbodyTableComplete += `<td><input id="dateTableEndCompleteStop${index}" type="text" class="form-control" value="" autocomplete="off"></td>`
        tbodyTableComplete += `<td>
                                <div class="input-group">
                                  <select id="completeTbCP${+sum10 + 10}" 
                                          class="completeTbCP form-control clearable readonly ${$("#notifier").val() && $("#completeWorkOrderBtn").text() != 'Uncomplete Work Order' ? 'x' : ''}"" 
                                          data-server="/eam/ajax/lov/employee"  
                                          data-id="employee_number" 
                                          data-text="full_name" 
                                          data-field="select"
                                          required 
                                          ${$("#completeWorkOrderBtn").text() == 'Uncomplete Work Order' ? 'disabled': ''}>
                                  </select>
                                  <div class="input-group-append">
                                    <span class="input-group-append">
                                      <button onclick="employeeLovBtnTableOnclick({nameEmployeeModal: 'ผู้ปิดงาน', idEmployeeModal: 'completeTbCP${+sum10 + 10}', locationEmployee: 'complete', desc: false, inModal: false})" type="button" class="btn btn-default" ${$("#completeWorkOrderBtn").text() == 'Uncomplete Work Order' ? 'disabled': ''}><i class="fa fa-search"></i></button>
                                    </span>
                                  </div>
                                </div>
                              </td>`
        tbodyTableComplete += `<td>
                                <input  type="text" 
                                        class="form-control" 
                                        value="${row.jp_flag == 'Yes' ? 'ใช่' : 'ไม่ใช่'}" 
                                        disabled 
                                        autocomplete="off">
                              </td>`
        tbodyTableComplete += `<td>
                                <input  onkeypress="return /[0-9]/i.test(event.key)" 
                                        type="text" 
                                        class="form-control" 
                                        value="${row.jp_qty ? row.jp_qty : ''}" 
                                        ${row.jp_flag == 'Yes' ? 'required' : ''} 
                                        ${$("#completeWorkOrderBtn").text() == 'Uncomplete Work Order' ? 'disabled': ''} 
                                        autocomplete="off">
                              </td>`
        tbodyTableComplete += `<td class="d-none">
                                <input  id="completeTbCP${+sum10 + 10}Id" 
                                        type="text" 
                                        class="form-control" 
                                        value="${$("#notifierId").val()}" 
                                        hidden 
                                        autocomplete="off">
                              </td>`
        tbodyTableComplete += `<td class="d-none">
                                <input  type="text" 
                                        class="form-control"
                                        value="${row.completion_id ? row.completion_id : ''}" 
                                        hidden 
                                        autocomplete="off">
                                </td>`
        tbodyTableComplete += `</tr>`
        sum10 += 10
        row.jp_flag == 'Yes' ? $("#quantityOfSpare").text('*') : $("#quantityOfSpare").text('')
      })
    }
    $("#setTbodyTableComplete").html(tbodyTableComplete);
    triggerSelect2InEAM0010()

    data.data.filter((row, index) => {
      setDateTimePicker({idDate: `dateTableStartCompleteStart${index}`, nameDate: '', onchange: true, date: `${row.actual_start_date ? row.actual_start_date : $("#repairDateStart").val()}`, disabled: $("#completeWorkOrderBtn").text() == 'Uncomplete Work Order' ? true : false, required: true, dateEndId: `dateTableEndCompleteStart${index}`});
      setDateTimePicker({idDate: `dateTableEndCompleteStart${index}`, nameDate: '', onchange: true, date: `${row.actual_end_date ? row.actual_end_date : $("#repairDateEnd").val()}`, disabled: $("#completeWorkOrderBtn").text() == 'Uncomplete Work Order' ? true : false, required: true});
      setDateTimePicker({idDate: `dateTableStartCompleteStop${index}`, nameDate: '', onchange: true, date: `${row.shutdown_start_date ? row.shutdown_start_date : $("#stopMachine").val() == '2' ? $("#repairDateStart").val() : ''}`, disabled: $("#completeWorkOrderBtn").text() == 'Uncomplete Work Order' ? true : false, required: $("#stopMachine").val() == '2', dateEndId: `dateTableEndCompleteStop${index}`});
      setDateTimePicker({idDate: `dateTableEndCompleteStop${index}`, nameDate: '', onchange: true, date: `${row.shutdown_end_date ? row.shutdown_end_date : $("#stopMachine").val() == '2' ? $("#repairDateEnd").val() : ''}`, disabled: $("#completeWorkOrderBtn").text() == 'Uncomplete Work Order' ? true : false, required: $("#stopMachine").val() == '2'});
      vmDateTimePicker[`dateTableEndCompleteStart${index}`].pDisabled = row.actual_start_date ? row.actual_start_date : $("#repairDateStart").val();
      vmDateTimePicker[`dateTableEndCompleteStop${index}`].pDisabled = row.shutdown_start_date ? row.shutdown_start_date : $("#stopMachine").val() == '2' ? $("#repairDateStart").val() : '';
      
      if ($(`#dateTableStartCompleteStart${index}`).val() != '' && $(`#dateTableEndCompleteStart${index}`).val() != '') {
        let StartTime = $(`#dateTableStartCompleteStart${index}`).parents('tr').find("td:eq(1) input[type='text']").val() != '' ? $(`#dateTableStartCompleteStart${index}`).parents('tr').find("td:eq(1) input[type='text']").val().split(' ')[1] : ''
        let StartDate = parseDate($(`#dateTableStartCompleteStart${index}`).parents('tr').find("td:eq(1) input[type='text']").val() != '' ? $(`#dateTableStartCompleteStart${index}`).parents('tr').find("td:eq(1) input[type='text']").val().split(' ')[0] : '')
        let EndTime = $(`#dateTableStartCompleteStart${index}`).parents('tr').find("td:eq(3) input[type='text']").val() != '' ? $(`#dateTableStartCompleteStart${index}`).parents('tr').find("td:eq(3) input[type='text']").val().split(' ')[1] : ''
        let EndDate = parseDate($(`#dateTableStartCompleteStart${index}`).parents('tr').find("td:eq(3) input[type='text']").val() != '' ? $(`#dateTableStartCompleteStart${index}`).parents('tr').find("td:eq(3) input[type='text']").val().split(' ')[0] : '')
        $(`#dateTableStartCompleteStart${index}`).parents('tr').find("td:eq(2) input[type='number']").val(checkStEnDateTime(StartDate, EndDate, dateTimeConvert(parseDateTime(EndTime), parseDateTime(StartTime))))
        $(`#dateTableStartCompleteStart${index}`).parents('tr').find("td:eq(2) input[type='number']").val() == '' ? 
        $(`#dateTableStartCompleteStart${index}`).parents('tr').find("td:eq(2) input[type='number']").val(0) : ''
      }
      if ($(`#dateTableStartCompleteStop${index}`).val() != '' && $(`#dateTableEndCompleteStop${index}`).val() != '') {
        let StartTime = $(`#dateTableStartCompleteStop${index}`).parents('tr').find("td:eq(4) input[type='text']").val() != '' ? $(`#dateTableStartCompleteStop${index}`).parents('tr').find("td:eq(4) input[type='text']").val().split(' ')[1] : ''
        let StartDate = parseDate($(`#dateTableStartCompleteStop${index}`).parents('tr').find("td:eq(4) input[type='text']").val() != '' ? $(`#dateTableStartCompleteStop${index}`).parents('tr').find("td:eq(4) input[type='text']").val().split(' ')[0] : '')
        let EndTime = $(`#dateTableStartCompleteStop${index}`).parents('tr').find("td:eq(6) input[type='text']").val() != '' ? $(`#dateTableStartCompleteStop${index}`).parents('tr').find("td:eq(6) input[type='text']").val().split(' ')[1] : ''
        let EndDate = parseDate($(`#dateTableStartCompleteStop${index}`).parents('tr').find("td:eq(6) input[type='text']").val() != '' ? $(`#dateTableStartCompleteStop${index}`).parents('tr').find("td:eq(6) input[type='text']").val().split(' ')[0] : '')
        $(`#dateTableStartCompleteStop${index}`).parents('tr').find("td:eq(5) input[type='number']").val(checkStEnDateTime(StartDate, EndDate, dateTimeConvert(parseDateTime(EndTime), parseDateTime(StartTime))))
        $(`#dateTableStartCompleteStop${index}`).parents('tr').find("td:eq(5) input[type='number']").val() == '' ? $(`#dateTableStartCompleteStop${index}`).parents('tr').find("td:eq(5) input[type='number']").val(0) : ''
      }

      //Default ผู้ปิดงาน 
      var newOptionEmployee = new Option(row.employee_code + ' - ' + row.employee_desc, row.employee_code, true, true);
      $(`#completeTbCP${+indexShow + 10}`).append(newOptionEmployee).trigger('change');
      $(`#completeTbCP${+indexShow + 10}`).val(row.employee_code ? row.employee_code : '').trigger('change');
    })
  }
  $("#saveCompleteBtn").click(() => {
    $("#saveCompleteBtnHide").click();
  })
  function formSaveCompleteBtnHide() {   
    let dataSave = []
    $("#setTbodyTableComplete tr").each(function() {
      let data = {
        completion_id: $(this).find("td:eq(11) input[type='text']").val(),
        organization_id: organization_id,
        completion_status: $(this).find("td:eq(0) input[type='text']").val(),
        actual_start_date: $(this).find("td:eq(1) input[type='text']").val(),
        actual_end_date: $(this).find("td:eq(3) input[type='text']").val(),
        actual_duration: $(this).find("td:eq(2) input[type='number']").val(),
        shutdown_start_date: $(this).find("td:eq(4) input[type='text']").val(),
        shutdown_end_date: $(this).find("td:eq(6) input[type='text']").val(),
        shutdown_duration: $(this).find("td:eq(5) input[type='number']").val(),
        employee_id: $(this).find("td:eq(10) input[type='text']").val(),
        employee_code: $(this).find("td:eq(7) select").val(),
        employee_desc: $(this).find("td:eq(7) select").val().split(' - ')[1],
        jp_flag: $(this).find("td:eq(8) input[type='text']").val() == 'ใช่' ? 'Y' : 'N',
        jp_qty: $(this).find("td:eq(9) input[type='text']").val(),
        program_code: 'EAM0010',
        wip_entity_id: wip_entity_id,
        or_wip_entity_id: or_wip_entity_id,
        web_status: $("#completeWorkOrderBtn").text() == 'Uncomplete Work Order' ? 'UNCOMPLETE' : 'COMPLETE'
      }
      dataSave.push(data)
    })
    if (dataSave.length > 0) {
      if ($("#completeWorkOrderBtn").text() == 'Uncomplete Work Order') {
        swal({
          title: "ต้องการ Uncomplete Work Order หรือไม่",
          text: "",
          type: "warning",
          showCancelButton: true
        },
        function(){
          $.ajax({
            url: "{{ route('eam.ajax.work-order.cp.store') }}",
            type: "POST",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: JSON.stringify({data: dataSave}),
            success: function (response) {
              swal("Success", response.message, "success");
              $("#completeWorkOrderBtn").text('Complete Work Order')
              $('#checkedComplete').prop('checked', false);
              apiWorkOrderHeadShow();
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        })
      } else {
        $.ajax({
          url: "{{ route('eam.ajax.work-order.cp.store') }}",
          type: "POST",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          data: JSON.stringify({data: dataSave}),
          success: function (response) {
            swal("Success", response.message, "success");
            $("#completeWorkOrderBtn").text('Uncomplete Work Order')
            $('#checkedComplete').prop('checked', true);
            apiWorkOrderHeadShow();
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    } else {
      swal("กรุณาเลือกรายการ", "", "warning");
    }
  }
  function apiWorkOrderHeadShow() {
    $.ajax({
      url: "{{ route('eam.ajax.work-order.head.show',['']) }}/" + $("#workReceiptNumber").val(),
      method: 'GET',
      success: function (response) {
        $(".clearable").removeClass('x onX');
        clearAllTable();
        setDataLovWorkReceiptNumberResponse(response)
        apiComplete();
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
  }
</script>