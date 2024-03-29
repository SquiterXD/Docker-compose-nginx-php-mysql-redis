
<script>
    $.ajax({
      url: "{{ route('eam.ajax.lov.issue') }}",
      method: 'GET',
      success: function (response) {
        let optionWorkOrderType = ''
        optionWorkOrderType += `<option value=""></option>`
        for (let data of response.data) {
          optionWorkOrderType += `<option value="${data.lookup_code}">${data.description}</option>`
        }
        $("#problemsEncountered").html(optionWorkOrderType);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>