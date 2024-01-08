<script>
    $.ajax({
      url: "{{ route('eam.ajax.lov.get-requestMatNon') }}",
      method: 'GET',
      success: function (response) {
        let optionPRNumber = ''
        optionPRNumber += `<option value=""></option>`
        for (let data of response.data) {
            optionPRNumber += `<option value="${data.pr_number}">${data.pr_number}</option>`
        }
        $("#reportRequestMatNonWorkReceiptPRNumber").html(optionPRNumber);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>