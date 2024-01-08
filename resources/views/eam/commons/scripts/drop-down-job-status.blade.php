
<script>
  var dataDropDownJobStatus = []
    $.ajax({
      url: "{{ route('eam.ajax.lov.job-status') }}",
      method: 'GET',
      success: function (response) {
        dataDropDownJobStatus = response.data
        let optionJobStatus = ''
        optionJobStatus += `<option value=""></option>`
        for (let data of response.data) {
          optionJobStatus += `<option value="${data.description}">${data.description}</option>`
        }
        $("#jobStatus").html(optionJobStatus);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>