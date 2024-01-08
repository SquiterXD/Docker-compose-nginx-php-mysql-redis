
<script>
    $.ajax({
      url: "{{ route('eam.ajax.lov.work-request-status') }}",
      method: 'GET',
      success: function (response) {
        let optionWorkOrderStatus = ''
        optionWorkOrderStatus += `<option value=""></option>`
        for (let data of response.data) {
          optionWorkOrderStatus += `<option value="${data.lookup_code}">${data.meaning}</option>`
        }
        $("#workOrderStatus").html(optionWorkOrderStatus);
        $("#modalReportWorkOrderStatus").html(optionWorkOrderStatus);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>