
<script>
    var dataOptionMachinType = []
    $.ajax({
      url: "{{ route('eam.ajax.lov.machine-type') }}",
      method: 'GET',
      success: function (response) {
        dataOptionMachinType = response.data
        let optionMachineType = ''
        optionMachineType += `<option value=""></option>`
        for (let data of response.data) {
          if ($("#eam0003").attr('id') === 'eam0003') {
            optionMachineType += `<option value="${data.lookup_code}">${data.description}</option>`
          } else {
            optionMachineType += `<option value="${data.lookup_code}">${data.lookup_code}</option>`
          }
        }
        $("#machineType").html(optionMachineType);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>