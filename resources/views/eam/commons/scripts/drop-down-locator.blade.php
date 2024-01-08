
<script>
    var dataDropDownLocator = []
    $.ajax({
      url: "{{ route('eam.ajax.lov.locatorv') }}",
      method: 'GET',
      success: function (response) {
        dataDropDownLocator = response.data
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
    function apiLocator(params) {
      if (dataDropDownLocator.length < 1) {
        $.ajax({
          url: "{{ route('eam.ajax.lov.locatorv') }}",
          method: 'GET',
          success: function (response) {
            dataDropDownLocator = response.data
          }
        })
      }
    }
    function changLocator() {
      $("#setTbodyTableSavePart .locatorTbMT").change(function() {
        if ($(this).val() != '') {
          let onHand = $(this).parents('tr').find("td:eq(12) input[type='text']")
          let itemCode = $(this).parents('tr').find("td:eq(3) input[type='text']").val()
          $.ajax({
            url: "{{ route('eam.ajax.work-order.itemonhand.get') }}",
            method: 'GET',
            data: {
              'p_subinventory_name': $(this).parents('tr').find("td:eq(10) select").val(),
              'p_locator_name': $(this).parents('tr').find("td:eq(10) select").val()+'.'+$(this).val(),
              // 'p_item_code': $(this).parents('tr').find("td:eq(3) input[type='text']").val()
              'p_item_code': $(this).parents('tr').find("td:eq(3) select").val()
            },
            success: function (response) {
              onHand.val('');
              let total = 0
              response.data.filter((row)=>{
                total += +row.on_hand
              })
              onHand.val(total);
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        } else {
          let onHand = $(this).parents('tr').find("td:eq(12) input[type='text']")
          let itemCode = $(this).parents('tr').find("td:eq(3) input[type='text']").val()
          $.ajax({
            url: "{{ route('eam.ajax.work-order.itemonhand.get') }}",
            method: 'GET',
            data: {
              'p_subinventory_name': $(this).parents('tr').find("td:eq(10) select").val(),
              'p_locator_name': '',
              // 'p_item_code': $(this).parents('tr').find("td:eq(3) input[type='text']").val()
              'p_item_code': $(this).parents('tr').find("td:eq(3) select").val()
            },
            success: function (response) {
              onHand.val('');
              let total = 0
              response.data.filter((row)=>{
                total += +row.on_hand
              })
              onHand.val(total);
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        }
      })
    }
</script>