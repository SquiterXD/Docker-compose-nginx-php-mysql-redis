
<script>
  var dataDropdownTechnicianGroupCode = []
  $.ajax({
    url: "{{ route('eam.ajax.lov.dep-resource') }}",
    method: 'GET',
    success: function (response) {
      dataDropdownTechnicianGroupCode = response.data
    },
    error: function (jqXHR, textStatus, errorRhrown) {
      swal("Error", jqXHR.responseJSON.message, "error");
    }
  })
  function setDropdownTechnicianGroup(data) {
    let departmentCodeOp = data.find("td:eq(2) select").val();
    let optionTechnicianGroupCode = ''
    optionTechnicianGroupCode += `<option value=""></option>`
    for (let data of dataDropdownTechnicianGroupCode) {
      if (data.department_code == departmentCodeOp) {
        optionTechnicianGroupCode += `<option value="${data.resource_id}">${data.resource_code}</option>`
      }
    }
    data.find("td:eq(3) select").html(optionTechnicianGroupCode);
    data.find("td:eq(4) input[type='text']").val('');

    let count = 0;
    $("#setTbodyTableGroupTechnicians .workOrder").each(function () {
      let vm = $(this)
      if(vm.parents('tr').find("td:eq(0) select").val() == data.find("td:eq(0) option:selected").text()){
        count += vm.length;
        data.find(".sum10").val(count*10).trigger('change');
      }
    })        
  }
  function changTechnicianGroupCode() {
    $("#setTbodyTableGroupTechnicians .technicianGroupCode").change(function() {
      for (const row of dataDropdownTechnicianGroupCode) {
        if (row.resource_id == $(this).val()) {
          $(this).parents('tr').find("td:eq(4) input[type='text']").val(row.resource_desc)
          break
        } else {
          $(this).parents('tr').find("td:eq(4) input[type='text']").val('')
        }
      }
    })
  }
</script>