
<script>
    var dataDropDownWorkOrder = []
    function apiWorkerOrder(params) {
      if (dataDropDownWorkOrder.length < 1) {
        $.ajax({
          url: "{{ route('eam.ajax.lov.work-order-op-numseq') }}",
          data: {p_wip_entity_id: wip_entity_id},
          method: 'GET',
          success: function (response) {
            dataDropDownWorkOrder = response.data
            let optionWorkOrder = ''
            optionWorkOrder += `<option value=""></option>`
            for (let data of response.data) {
              optionWorkOrder += `<option value="${data.operation_seq_num}"  ${'10' == data.operation_seq_num ? 'selected' : ''}>${data.operation_seq_num}</option>`
            }
            $('.workOrderTbMT').html(optionWorkOrder)
            $('.workOrderTbLB').html(optionWorkOrder)
            workOrderReAll()
          }
        })
      } else {
        let optionWorkOrder = ''
        optionWorkOrder += `<option value=""></option>`
        for (let data of dataDropDownWorkOrder) {
          optionWorkOrder += `<option value="${data.operation_seq_num}"  ${'10' == data.operation_seq_num ? 'selected' : ''}>${data.operation_seq_num}</option>`
        }
        $('.workOrderTbMT').html(optionWorkOrder)
        $('.workOrderTbLB').html(optionWorkOrder)
        workOrderReAll()
      }
    }
    function updateDataDropDownWorkOrder() {
      $.ajax({
        url: "{{ route('eam.ajax.lov.work-order-op-numseq') }}",
        data: {p_wip_entity_id: wip_entity_id},
        method: 'GET',
        success: function (response) {
          dataDropDownWorkOrder = response.data
          $("#setTbodyTableGroupTechnicians td .workOrder").each(function() {
            let optionWorkOrder = ''
            optionWorkOrder += `<option value=""></option>`
            for (const [i, data] of response.data.entries()) {
              optionWorkOrder += `<option value="${data.operation_seq_num}" ${$(this).val() == data.operation_seq_num ? 'selected' : ''}>${data.operation_seq_num}</option>`
            }
            $(this).html(optionWorkOrder)
          })
          $("#setTbodyTableSavePart td .workOrderTbMT").each(function() {
            let optionWorkOrder = ''
            optionWorkOrder += `<option value=""></option>`
            for (const [i, data] of response.data.entries()) {
              if ($(this).parents('tr').find("td:eq(19) input[type='text']").val() == 'add') {
                optionWorkOrder += `<option value="${data.operation_seq_num}" ${i == '0' ? 'selected' : ''}>${data.operation_seq_num}</option>`
              } else {
                if ($(this).val() == data.operation_seq_num) {
                  optionWorkOrder += `<option value="${data.operation_seq_num}" ${$(this).val() == data.operation_seq_num ? 'selected' : ''}>${data.operation_seq_num}</option>`
                } else {
                  optionWorkOrder += `<option value="${data.operation_seq_num}" ${i == '0' ? 'selected' : ''}>${data.operation_seq_num}</option>`
                }
              }
            }
            $(this).html(optionWorkOrder)
          })
          $("#setTbodyTableSavePartNon td .workOrderTbMT").each(function() {
            let optionWorkOrder = ''
            optionWorkOrder += `<option value=""></option>`
            for (const [i, data] of response.data.entries()) {
              if ($(this).parents('tr').find("td:eq(27) input[type='text']").val() == 'add') {
                optionWorkOrder += `<option value="${data.operation_seq_num}" ${i == '0' ? 'selected' : ''}>${data.operation_seq_num}</option>`
              } else {
                if ($(this).val() == data.operation_seq_num) {
                  optionWorkOrder += `<option value="${data.operation_seq_num}" ${$(this).val() == data.operation_seq_num ? 'selected' : ''}>${data.operation_seq_num}</option>`
                } else {
                  optionWorkOrder += `<option value="${data.operation_seq_num}" ${i == '0' ? 'selected' : ''}>${data.operation_seq_num}</option>`
                }
              }
            }
            $(this).html(optionWorkOrder)
          })
          $("#setTbodyTableSaveCost td .workOrderTbLB").each(function() {
            let optionWorkOrder = ''
            optionWorkOrder += `<option value=""></option>`
            for (const [i, data] of response.data.entries()) {
              if ($(this).parents('tr').find("td:eq(35) input[type='text']").val() == 'add') {
                optionWorkOrder += `<option value="${data.operation_seq_num}" ${i == '0' ? 'selected' : ''}>${data.operation_seq_num}</option>`
              } else {
                if ($(this).val() == data.operation_seq_num) {
                  optionWorkOrder += `<option value="${data.operation_seq_num}" ${$(this).val() == data.operation_seq_num ? 'selected' : ''}>${data.operation_seq_num}</option>`
                } else {
                  optionWorkOrder += `<option value="${data.operation_seq_num}" ${i == '0' ? 'selected' : ''}>${data.operation_seq_num}</option>`
                }
              }
            }
            $(this).html(optionWorkOrder)
          })
        }
      })
    }
    function changWorkOder() {
      $("#setTbodyTableGroupTechnicians .workOrder").change(function() {
        for (const row of dataDropDownWorkOrder) {
          if (row.operation_seq_num == $(this).val()) {
            var newOptionDepartment = new Option((row.department_code ? row.department_code : '')+ ' - ' + 
                                                 (row.department_description ? row.department_description : ''), row.department_code, true, true);
            $(this).parents('tr').find("td:eq(2) select").append(newOptionDepartment).trigger('change');
            $(this).parents('tr').find("td:eq(2) select").val(row.department_code ? row.department_code : '').trigger('change');

            setDropdownTechnicianGroup($(this).parents('tr'))
            break
          } else {
            $(this).parents('tr').find("td:eq(2) select").val('');
            setDropdownTechnicianGroup($(this).parents('tr'));
          }
        }
      })
      
      $("#setTbodyTableSaveCost .workOrderTbLB").change(function() {
        for (const row of dataDropdownTechnicianGroupOrder) {
          if (row.operation_seq_num == $(this).val()) {
            setDropdownTechnicianGroupOrder($(this).parents('tr'));
            break;
          } else {
            $(this).parents('tr').find("td:eq(2) input[type='text']").val('');
            setDropdownTechnicianGroupOrder($(this).parents('tr'));
          }
        }
      })
    }
    
</script>