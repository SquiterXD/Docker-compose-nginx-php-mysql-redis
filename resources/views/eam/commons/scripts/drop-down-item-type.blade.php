
<script>
    var dataDropDownItemType = []
    $.ajax({
      url: "{{ route('eam.ajax.lov.material-type') }}",
      method: 'GET',
      success: function (response) {
        dataDropDownItemType = response.data
        let optionItemType = ''
        optionItemType += `<option value=""></option>`
        for (let data of response.data) {
          optionItemType += `<option value="${data.lookup_code}">${data.meaning}</option>`
        }
        $('.itemTypeTbMT').html(optionItemType)
      }
    })
    function apiItemType(params) {
      if (dataDropDownItemType.length < 1) {
        $.ajax({
          url: "{{ route('eam.ajax.lov.material-type') }}",
          method: 'GET',
          success: function (response) {
            dataDropDownItemType = response.data
            let optionItemType = ''
            optionItemType += `<option value=""></option>`
            for (let data of response.data) {
              optionItemType += `<option value="${data.lookup_code}">${data.meaning}</option>`
            }
            $('.itemTypeTbMT').html(optionItemType)
          }
        })
      } else {
        let optionItemType = ''
        optionItemType += `<option value=""></option>`
        for (let data of dataDropDownItemType) {
          optionItemType += `<option value="${data.lookup_code}">${data.meaning}</option>`
        }
        $('.itemTypeTbMT').html(optionItemType)
      }
    }
    function changItemType() {
      $("#setTbodyTableSavePart .itemTypeTbMT").change(function() {
        if ($(this).val() === '0') {
          $(this).parents('tr').find("td:eq(4) input[type='text']").prop('disabled', true);
          $(this).parents('tr').find("td:eq(9) input[type='text']").prop('disabled', true);
          $(this).parents('tr').find("td:eq(10) select").prop('disabled', false);
          $(this).parents('tr').find("td:eq(11) select").prop('disabled', false);
          $(this).parents('tr').find("td:eq(16) button").prop('disabled', false);
          $(this).parents('tr').find("td:eq(16)").removeClass('d-none');
        } else {
          $(this).parents('tr').find("td:eq(4) input[type='text']").prop('disabled', false);
          $(this).parents('tr').find("td:eq(9) input[type='text']").prop('disabled', false);
          $(this).parents('tr').find("td:eq(10) select").prop('disabled', true);
          $(this).parents('tr').find("td:eq(11) select").prop('disabled', true);
          $(this).parents('tr').find("td:eq(16) button").prop('disabled', true);
          $(this).parents('tr').find("td:eq(16)").addClass('d-none');
        }
        checkBoxOnClick();
      })
    }
</script>