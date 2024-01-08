
<script>
  var dataDropDownActivity = []
    $.ajax({
      url: "{{ route('eam.ajax.lov.activity') }}",
      method: 'GET',
      success: function (response) {
        dataDropDownActivity = response.data
        let optionActivity = ''
        optionActivity += `<option value=""></option>`
        for (let data of response.data) {
          optionActivity += `<option value="${data.activity}">${data.activity}</option>`
        }
        $("#activity").html(optionActivity);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>