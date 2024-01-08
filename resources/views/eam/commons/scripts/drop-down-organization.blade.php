<script>
    var dataOptionOrganization = []
      $.ajax({
        url: "{{ route('eam.ajax.lov.get-organization') }}",
        method: 'GET',
        success: function (response) {
          dataOptionOrganization = response.data
          let optionOrganization = ''
          optionOrganization += `<option value=""></option>`
          for (let data of response.data) {
            optionOrganization += `<option value="${data.organization_id}">${data.organization_code}</option>`
          }
          $("#summaryMatStatusOrganization").html(optionOrganization);
          $("#summaryMatStatusOrganization").val(response.defaultOrg.organization_id);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
  </script>