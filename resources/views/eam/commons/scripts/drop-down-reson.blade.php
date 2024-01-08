
<script>
  var dataDropdownResons = []
    $.ajax({
      url: "{{ route('eam.ajax.lov.reasons') }}",
      method: 'GET',
      success: function (response) {
        dataDropdownResons = response.data
        // let optionReson = ''
        // optionReson += `<option value=""></option>`
        // for (let data of response.data) {
        //   optionReson += `<option value="${data.reason_id}">${data.reason_name}</option>`
        // }
        // $("#stopMachine").html(optionReson);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
    function changReson() {
      $("#setTbodyTableSaveCost .resonTbLB").change(function() {
        for (const row of dataDropdownResons) {
          if (row.reason_id == $(this).val()) {
            $(this).parents('tr').find("td:eq(10) input[type='number']").val(row.operation_duration)
            $(this).parents('tr').find("td:eq(10) input[type='number']").attr("max", row.operation_duration);
            break
          } else {
            $(this).parents('tr').find("td:eq(10) input[type='number']").val('')
            $(this).parents('tr').find("td:eq(10) input[type='number']").attr("max", 0);
          }
        }

        let attrEm0007CallDayFnData = $(this).attr('attr-em0007CallDayFn-data');
        if (attrEm0007CallDayFnData) {
          em0007CallDayFn( JSON.parse(attrEm0007CallDayFnData.replaceAll(' ', '')) )
        }
      })
    }
</script>