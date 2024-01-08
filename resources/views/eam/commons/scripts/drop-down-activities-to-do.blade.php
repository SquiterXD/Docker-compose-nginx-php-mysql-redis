<script>
    var dataDropDownActivityToDo = []
    $.ajax({
      url: "{{ route('eam.ajax.lov.asset-activity') }}",
      method: 'GET',
      success: function (response) {
        dataDropDownActivityToDo = response.data
        let optionWorkOrderStatus = ''
        optionWorkOrderStatus += `<option value=""></option>`
        for (let data of response.data) {
          optionWorkOrderStatus += `<option value="${data.activity}">${data.activity}</option>`
        }
        $("#activitiesToDo").html(optionWorkOrderStatus);
        $("#mntHistoryActivitiesToDo").html(optionWorkOrderStatus);
        $("#mntHistoryActivitiesToDoTo").html(optionWorkOrderStatus);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
    function changeDropDownActivityToDo(data) {
      if (data.data3 == 'eam0010' || data.data3 == 'eam0006') {
        $("#activitiesToDo").html('');
      } else {
        $(data.data2).parents('tr').find("td:eq(3) select").html('')
      }
      $.ajax({
        url: "{{ route('eam.ajax.lov.asset-activity') }}",
        method: 'GET',
        data: {
          p_asset_number: data.data1
        },
        success: function (response) {
          let optionWorkOrderStatus = ''
          optionWorkOrderStatus += `<option value=""></option>`
          for (let data of response.data) {
            if (data.data3 == 'eam0010') {
              optionWorkOrderStatus += `<option value="${data.activity}">${data.activity}</option>`
            } else {
              optionWorkOrderStatus += `<option value="${data.activity}">${data.description}</option>`
            }
          }
          if (data.data3 == 'eam0010' || data.data3 == 'eam0006') {
            $("#activitiesToDo").html(optionWorkOrderStatus);
            $("#activitiesToDo").val(data.data4);
          } else {
            $(data.data2).parents('tr').find("td:eq(3) select").html(optionWorkOrderStatus);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
</script>