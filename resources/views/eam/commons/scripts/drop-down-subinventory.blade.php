
<script>
  dataDropDownSubinventory = []
  $.ajax({
    url: "{{ route('eam.ajax.lov.suvinventory') }}",
    method: 'GET',
    success: function (response) {
      dataDropDownSubinventory = response.data
      let optionSuvinventory = ''
      optionSuvinventory += `<option value=""></option>`
      for (let data of response.data) {
        optionSuvinventory += `<option value="${data.name}">${data.name}</option>`
      }
      $('#subinventory').html(optionSuvinventory)
      $('#modalReportRequestMatInvSubinventory').html(optionSuvinventory)
      $('#modalReportRequestMatNonSubinventory').html(optionSuvinventory)
      $('.subinventoryTbS').html(optionSuvinventory)
      $('.subinventoryTbE').html(optionSuvinventory)
    },
    error: function (jqXHR, textStatus, errorRhrown) {
      swal("Error", jqXHR.responseJSON.message, "error");
    }
  })
  function apiSubinventory(params) {
    // if (dataDropDownSubinventory.length < 1) {
    //   $.ajax({
    //     url: "{{ route('eam.ajax.lov.suvinventory') }}",
    //     method: 'GET',
    //     success: function (response) {
    //       dataDropDownSubinventory = response.data
    //       let optionSuvinventory = ''
    //       optionSuvinventory += `<option value=""></option>`
    //       for (let data of response.data) {
    //         optionSuvinventory += `<option value="${data.name}">${data.name}</option>`
    //       }
    //       $('.subinventoryTbMT').html(optionSuvinventory)
    //     }
    //   })
    // } else {
    //   let optionSuvinventory = ''
    //   optionSuvinventory += `<option value=""></option>`
    //   for (let data of dataDropDownSubinventory) {
    //     optionSuvinventory += `<option value="${data.name}">${data.name}</option>`
    //   }
    //   $('.subinventoryTbMT').html(optionSuvinventory)
    // }
    $.ajax({
        url: "{{ route('eam.ajax.lov.subinventory-workorder') }}",
        method: 'GET',
        success: function (response) {
          dataDropDownSubinventory = response.data
          let optionSuvinventory = ''
          optionSuvinventory += `<option value=""></option>`
          for (let data of response.data) {
            optionSuvinventory += `<option value="${data.name}">${data.name}</option>`
          }
          $('.subinventoryTbMT').html(optionSuvinventory)
        }
    })
  }
  function changSubinventory() {
    if ($("#eam0001").attr('id') === 'eam0001') {
      if ($('#subinventory').val() == '') {
        $('#locator').html('')
      } else {
        let optionLocator = ''
        optionLocator += `<option value=""></option>`
        dataDropDownLocator.filter(data => {
          if (data.subinventory_name == $("#subinventory").val()) {
            optionLocator += `<option value="${data.subinventory_name}.${data.locator_name}">${data.subinventory_name}.${data.locator_name}</option>`
          }
        })
        $('#locator').html(optionLocator);
      }
    } else if ($("#eam0021").attr('id') === 'eam0021') {
      if ($('#modalReportRequestMatInvSubinventory').val() == '') {
        $('#modalReportRequestMatInvLocator').html('')
      } else {
        let optionLocator = ''
        optionLocator += `<option value=""></option>`
        dataDropDownLocator.filter(data => {
          if (data.subinventory_name == $("#modalReportRequestMatInvSubinventory").val()) {
            optionLocator += `<option value="${data.locator_name}">${data.subinventory_name}.${data.locator_name}</option>`
          }
        })
        $('#modalReportRequestMatInvLocator').html(optionLocator);
      }
    } else if ($("#eam0022").attr('id') === 'eam0022') {
      if ($('#modalReportRequestMatNonSubinventory').val() == '') {
        $('#modalReportRequestMatNonLocator').html('')
      } else {
        let optionLocator = ''
        optionLocator += `<option value=""></option>`
        dataDropDownLocator.filter(data => {
          if (data.subinventory_name == $("#modalReportRequestMatNonSubinventory").val()) {
            optionLocator += `<option value="${data.locator_name}">${data.subinventory_name}.${data.locator_name}</option>`
          }
        })
        $('#modalReportRequestMatNonLocator').html(optionLocator);
      }
    } else {
      $("#setTbodyTableSavePart .subinventoryTbMT").change(function() {
        if ($(this).val() == '') {
          $(this).parents('tr').find("td:eq(12) select").html(`<option value=""></option>`);
          $(this).parents('tr').find("td:eq(13) input[type='text']").val('');
        } else {
          let onHand = $(this).parents('tr').find("td:eq(13) input[type='text']")
          let itemCode = $(this).parents('tr').find("td:eq(3) input[type='text']").val()
          $.ajax({
            url: "{{ route('eam.ajax.work-order.itemonhand.get') }}",
            method: 'GET',
            data: {
              'p_subinventory_name': $(this).parents('tr').find("td:eq(11) select").val(),
              'p_locator_name': '',
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

          let optionLocator = ''
          optionLocator += `<option value=""></option>`
          dataDropDownLocator.filter(data => {
            if (data.subinventory_name == $(this).val()) {
              optionLocator += `<option value="${data.locator_name}">${data.subinventory_name}.${data.locator_name}</option>`
            }
          })
          $(this).parents('tr').find("td:eq(12) select").html(optionLocator);
        }
      })
      $("#setTbodyTable .subinventoryTbS").change(function() {
        if ($(this).val() == '') {
          $(this).parents('tr').find("td:eq(4) select").html(`<option value=""></option>`);
          $(this).parents('tr').find("td:eq(3) input[type='text']").val('');
        } else {
          let optionLocator = ''
          optionLocator += `<option value=""></option>`
          dataDropDownLocator.filter(data => {
            if (data.subinventory_name == $(this).val()) {
              optionLocator += `<option value="${data.locator_name}">${data.subinventory_name}.${data.locator_name}</option>`
            }
          })
          $(this).parents('tr').find("td:eq(4) select").html(optionLocator);
        }
      })
      $("#setTbodyTable .subinventoryTbE").change(function() {
        if ($(this).val() == '') {
          $(this).parents('tr').find("td:eq(6) select").html(`<option value=""></option>`);
          $(this).parents('tr').find("td:eq(5) input[type='text']").val('');
        } else {
          let optionLocator = ''
          optionLocator += `<option value=""></option>`
          dataDropDownLocator.filter(data => {
            if (data.subinventory_name == $(this).val()) {
              optionLocator += `<option value="${data.locator_name}">${data.subinventory_name}.${data.locator_name}</option>`
            }
          })
          $(this).parents('tr').find("td:eq(6) select").html(optionLocator);
        }
      })
    }
  }
</script>