
<script>
    $.ajax({
      url: "{{ route('eam.ajax.lov.asset-group') }}",
      method: 'GET',
      success: function (response) {
        let optionStatus = ''
        optionStatus += `<option value=""></option>`
        for (let data of response.data) {
          if ($("#eam0006").attr('id') === 'eam0006' || $("#eam0014").attr('id') === 'eam0014') {
            optionStatus += `<option value="${data.asset_group_id}">${data.asset_group}</option>`
          } else {
            optionStatus += `<option value="${data.asset_group}">${data.asset_group}</option>`
          }
        }
        $("#machineGroup").html(optionStatus);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>