
<script>
  var dataOptionOperation = []
    $.ajax({
      url: "{{ route('eam.ajax.lov.operation') }}",
      method: 'GET',
      success: function (response) {
        dataOptionOperation = response.data
        let optionOperation = ''
        optionOperation += `<option value=""></option>`
        for (let data of response.data) {
          if ($("#eam0003").attr('id') === 'eam0003') {
            optionOperation += `<option value="${data.wip_id}">${data.wip_step} - ${data.wip_step_desc}</option>`
          } else {
            optionOperation += `<option value="${data.wip_step_desc}">${data.wip_step_desc}</option>`
          }
        }
        $("#workProcedure").html(optionOperation);
        
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>