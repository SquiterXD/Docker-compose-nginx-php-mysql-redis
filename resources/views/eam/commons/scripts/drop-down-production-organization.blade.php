
<script>
  var dataDropDownProductOrganization = []
    $.ajax({
      url: "{{ route('eam.ajax.lov.organization') }}",
      method: 'GET',
      success: function (response) {
        dataDropDownProductOrganization = response.data
        let optionOrganization = ''
        optionOrganization+= `<option value=""></option>`
        for (let data of response.data) {
          if ($("#eam0003").attr('id') === 'eam0003') {
            optionOrganization += `<option value="${data.organization_code}">${data.organization_code} - ${data.name}</option>`
          } else {
            optionOrganization += `<option value="${data.organization_code}">${data.organization_code}</option>`
          }
        }
        $("#productionOrganization").html(optionOrganization);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>