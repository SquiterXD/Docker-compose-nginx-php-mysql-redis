
<script>
  var dataResourceAssetLocator = []
    $.ajax({
      url: "{{ route('eam.ajax.lov.resource-asset-locator') }}",
      method: 'GET',
      success: function (response) {
        dataResourceAssetLocator = response.data
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
</script>