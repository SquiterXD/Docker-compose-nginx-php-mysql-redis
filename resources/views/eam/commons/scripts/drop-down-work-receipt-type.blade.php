
<script>
    $.ajax({
      url: "{{ route('eam.ajax.lov.work-order-type') }}",
      method: 'GET',
      success: function (response) {
        let optionWorkReceiptType = ''
        optionWorkReceiptType += `<option value=""></option>`
        for (let data of response.data) {
          if($("#eam0039").attr('id') === 'eam0039'){
            optionWorkReceiptType += `<option value="${data.meaning}">${data.meaning}</option>`
          }else{
            optionWorkReceiptType += `<option value="${data.lookup_code}">${data.meaning}</option>`
          }          
        }
        $("#workReceiptType").html(optionWorkReceiptType);
        $("#modalReportSummaryMonthType").html(optionWorkReceiptType);
        $("#payableType").html(optionWorkReceiptType);
        $("#reportIssueMatExcelType").html(optionWorkReceiptType);
        $("#maintenanceType").html(optionWorkReceiptType);
        $("#purchaseType").html(optionWorkReceiptType);
        $("#laborType").html(optionWorkReceiptType);
        $("#summaryLaborType").html(optionWorkReceiptType);
        $("#summaryMatStatusType").html(optionWorkReceiptType);
        $("#woComStatusType").html(optionWorkReceiptType);
        
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>