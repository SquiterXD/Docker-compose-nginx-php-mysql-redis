
<script>
    $.ajax({
      url: "{{ route('eam.ajax.lov.request-status') }}",
      method: 'GET',
      success: function (response) {
        let optionStatus = ''
        optionStatus += `<option value=""></option>`
        for (let data of response.data) {
          optionStatus += `<option value="${data.description}">${data.description}</option>`
        }
        $("#requestStatusDesc").html(optionStatus);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>