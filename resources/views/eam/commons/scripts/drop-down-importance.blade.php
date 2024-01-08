
<script>
    $.ajax({
      url: "{{ route('eam.ajax.lov.activity-priority') }}",
      method: 'GET',
      success: function (response) {
        let optionImportance = ''
          optionImportance += `<option value=""></option>`
        for (let data of response.data) {
          optionImportance += `<option value="${data.lookup_code}">${data.meaning}</option>`
        }
        $("#importance").html(optionImportance);
        $("#importancessss").html(optionImportance);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>