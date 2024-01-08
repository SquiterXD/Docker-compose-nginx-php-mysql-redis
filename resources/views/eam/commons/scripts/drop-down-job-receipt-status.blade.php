
<script>
  var dataLovWorkOrderStatus = []
    $.ajax({
      url: "{{ route('eam.ajax.lov.work-order-status') }}",
      method: 'GET',
      success: function (response) {
        let optionWorkOrderStatus = ''
        optionWorkOrderStatus += `<option value=""></option>`
        for (let data of response.data) {
          if ($("#eam0010").attr('id') === 'eam0010') {
            if (data.code == '17' || 
                data.code == '1' || 
                data.code == '3' || 
                data.code == '6' || 
                data.code == '7'    ) {
              optionWorkOrderStatus += `<option value="${data.code}">${data.description}</option>`
            }

            if(data.code == '15'){
              optionWorkOrderStatus += `<option value="${data.code}" disabled>${data.description}</option>`
            }
          } else {
            optionWorkOrderStatus += `<option value="${data.code}">${data.description}</option>`
          }
        }
        dataLovWorkOrderStatus = optionWorkOrderStatus
        $("#jobReceiptStatus").html(optionWorkOrderStatus);
        $("#modalReportWorkReceiptStatus").html(optionWorkOrderStatus);
        $("#modalReportSummaryMonthStatus").html(optionWorkOrderStatus);
        $("#mntHistoryWorkReceiptStatus").html(optionWorkOrderStatus);
        if ($("#eam0014").attr('id') === 'eam0014') {
          $("#jobReceiptStatus").val('4');
        }
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>