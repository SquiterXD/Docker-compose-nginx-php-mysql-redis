
<script>
  var dataDropDownWoMtLot = []
  dropDownWoMtLot();
  function dropDownWoMtLot() {
    $.ajax({
      url: "{{ route('eam.ajax.lov.wo-mt-lot') }}",
      method: 'GET',
      success: function (response) {
        dataDropDownWoMtLot = response.data
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
  }
</script>