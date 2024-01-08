<script>
  var dataDropdownTechnicianGroupOrder = []
  function apiTechnicianGroupOrder(data) {
    if (dataDropdownTechnicianGroupOrder.length < 1) {
      $.ajax({
        url: "{{ route('eam.ajax.lov.work-order-re-resource') }}",
        data: {p_wip_entity_id: wip_entity_id},
        method: 'GET',
        success: function (response) {
          dataDropdownTechnicianGroupOrder = response.data
          let optionTechnicianGroupOrder = ''
          optionTechnicianGroupOrder += `<option value=""></option>`
          for (let data of response.data) {
            optionTechnicianGroupOrder += `<option value="${data.resource_code}">${data.description}</option>`
          }
          $('.technicianGroupOrderTbLB').html(optionTechnicianGroupOrder)

          if (data == 'setTableSaveCost') {
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
        }
      })
    } else {
      if (data == 'setTableSaveCost') {
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
    }
  }
  function apiTechnicianGroupOrderRef(data) {
    $.ajax({
      url: "{{ route('eam.ajax.lov.work-order-re-resource') }}",
      data: {p_wip_entity_id: wip_entity_id},
      method: 'GET',
      success: function (response) {
        dataDropdownTechnicianGroupOrder = response.data
        let optionTechnicianGroupOrder = ''
        optionTechnicianGroupOrder += `<option value=""></option>`
        for (let data of response.data) {
          optionTechnicianGroupOrder += `<option value="${data.resource_code}">${data.description}</option>`
        }
        $('.technicianGroupOrderTbLB').html(optionTechnicianGroupOrder)
      }
    })
  }
  function changeTechnicianGroupOrder() {
    $("#setTbodyTableSaveCost .technicianGroupOrderTbLB").change(function() {
      $(this).parents('tr').find("td:eq(4) select").val('').trigger('change');
      $(this).parents('tr').find("td:eq(5) input[type='text']");
    })
  }
  function setDropdownTechnicianGroupOrder(data) {
    let operation_seq_num = data.find("td:eq(2) select").val();
    let optionTechnicianGroupOrder = '';
    data.find("td:eq(4) select").val('').trigger('change');
    data.find("td:eq(5) input[type='text']").val('');
    data.find("td:eq(8) input[type='text']").val('');
    optionTechnicianGroupOrder += `<option value=""></option>`
    for (let data of dataDropdownTechnicianGroupOrder) {
      if (data.operation_seq_num == operation_seq_num) {
        optionTechnicianGroupOrder += `<option value="${data.resource_code}">${data.description}</option>`
      }
    }
    data.find("td:eq(3) select").html(optionTechnicianGroupOrder);
  }
</script>