
<script>
  var dataOptionUomCode = []
    $.ajax({
      url: "{{ route('eam.ajax.lov.usage-uom') }}",
      method: 'GET',
      success: function (response) {
        dataOptionUomCode = response.data
        let optionUomCode = ''
        optionUomCode += `<option value=""></option>`
        for (let data of response.data) {
          optionUomCode += `<option value="${data.uom_code}">${data.uom_code}</option>`
        }
        $("#usageUOMDropdown").html(optionUomCode);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>