
<script>
    $.ajax({
      url: "{{ route('eam.ajax.lov.status-yn') }}",
      method: 'GET',
      success: function (response) {
        let optionStatus = ''
        optionStatus += `<option value=""></option>`
        for (let data of response.data) {
          if ($("#eam0003").attr('id') === 'eam0003') {
            optionStatus += `<option value="${data.description}">${data.description}</option>`
          } else if ($("#eam0014").attr('id') === 'eam0014') {
            optionStatus += `<option value="${data.flex_value}">${data.description}</option>`
          } else {
            optionStatus += `<option value="${data.flex_value}">${data.flex_value_meaning}</option>`
          }
        }
        $(".statusYN").html(optionStatus);
        if ($("#eam0014").attr('id') === 'eam0014') {
          $(".statusYN").val('Y')
        }
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>