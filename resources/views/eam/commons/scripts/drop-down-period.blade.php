
<script>
    $.ajax({
      url: "{{ route('eam.ajax.lov.period-name') }}",
      method: 'GET',
      success: function (response) {
        let optionPeriod = ''
        optionPeriod += `<option value=""></option>`
        for (let data of response.data) {
          optionPeriod += `<option value="${data.period_name}">${data.period_name}</option>`
        }
        $("#jobAccountDelPeriod").html(optionPeriod);
        $("#jobAccountPeriod").html(optionPeriod);
        $("#laborAccountPeriod").html(optionPeriod);
        $("#woCostPeriod").html(optionPeriod);
        $("#receiptMatPeriod").html(optionPeriod);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>