
<script>
    var dataLovResourceEmployee = []
    var idLovResourceEmployee = ''
    var idLovResourceEmployeeId = ''
    var idLovResourceEmployeeDesc = ''
    var inModalResourceEmp = false
    var locationResourceEmployee = ''
    var pResourceCode = ''

    function lovResourceEmployee() {
      $.ajax({
        url: "{{ route('eam.ajax.lov.resource-employee') }}",
        method: 'GET',
        data: {
          'p_employee_number': '',
          'p_full_name': '',
          'p_resource_code': pResourceCode
        },
        success: function (response) {
          $("#detailResourceEmployee").modal('show');
          $("#modalResourceEmployeeSearchEmpCode").val('');
          $("#modalResourceEmployeeSearchEmpName").val('');
          dataLovResourceEmployee = response.data.data;
          setLovResourceEmployeeFn(response.data);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    function resourceEmployeeLovBtnTableOnclick(data) {
      $("#nameLovResourceEmployee").html(data.nameEmployeeModal)
      idLovResourceEmployee = data.idEmployeeModal
      idLovResourceEmployeeId = data.idEmployeeModal + 'Id'
      if (data.desc) {
        idLovResourceEmployeeDesc = data.idEmployeeModal + 'Desc'
      } else {
        idLovResourceEmployeeDesc = ''
      }
      inModalResourceEmp = data.inModal
      locationResourceEmployee = data.locationResourceEmployee
      pResourceCode = $("#"+data.idEmployeeModal).parents('tr').find("td:eq(3) select").val()
      lovResourceEmployee();
    }
    $("#modalSearchResourceEmployeeLov").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.lov.resource-employee') }}",
        method: 'GET',
        data: {
          'p_employee_number': $("#modalResourceEmployeeSearchEmpCode").val(),
          'p_full_name': $("#modalResourceEmployeeSearchEmpName").val(),
          'p_resource_code': pResourceCode
        },
        success: function (response) {
          dataLovResourceEmployee = response.data.data;
          if (response.data.data.length < 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setLovResourceEmployee").html('');
            $('#setLovResourceEmployeePagination').html('');
          } else {
            setLovResourceEmployeeFn(response.data);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })
    function setLovResourceEmployeeFn(data) {
      let theadLovResourceEmployee = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovResourceEmployee += `<tr>`
          theadLovResourceEmployee += `<td class="pointer" onclick="setDataLovResourceEmployee('` + row.employee_number + `')">${row.employee_number ? row.employee_number : ''}</td>`
          theadLovResourceEmployee += `<td class="pointer" onclick="setDataLovResourceEmployee('` + row.employee_number + `')">${row.full_name ? row.full_name : ''}</td>`
          theadLovResourceEmployee += `</tr>`
        })
      }
      $("#setLovResourceEmployee").html(theadLovResourceEmployee);
      if (data.data.length > 0) {
        let html = '<ul class="pagination float-right">';
        $.each(data.links , function( i , link ){
          html += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovResourceEmployeePagination('` + link.url + `')">${link.label}</a></li>`
        });
        html += '</ul>';
        $('#setLovResourceEmployeePagination').html(html);
      } else {
        $('#setLovResourceEmployeePagination').html('');
      }
    }
    function searchLovResourceEmployeePagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          data: {
            'p_employee_number': $("#modalResourceEmployeeSearchEmpCode").val(),
            'p_full_name': $("#modalResourceEmployeeSearchEmpName").val(),
            'p_resource_code': pResourceCode
          },
          success: function (response) {
            dataLovResourceEmployee = response.data.data;
            if (response.data.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovResourceEmployee").html('');
              $('#setLovResourceEmployeePagination').html('');
            } else {
              setLovResourceEmployeeFn(response.data);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
    function setDataLovResourceEmployee(data) {
      $("#detailResourceEmployee").modal('hide');
      for (const row of dataLovResourceEmployee) {
        if (row.employee_number == data) {
          if (locationResourceEmployee == 'technicianGroupOrde') {   
            $("#"+idLovResourceEmployee).parents('tr').find("td:eq(5) input[type='text']").val(row.employee_number);
            if($("#"+idLovResourceEmployee).is('select')) {
                if ($('#' + idLovResourceEmployee).find("option[value='" + row.full_name + "']").length) {
                  $('#' + idLovResourceEmployee).val(row.full_name).trigger('change');
                } else { 
                  var newOption = new Option(row.full_name, row.full_name, true, true);
                  $('#' + idLovResourceEmployee).append(newOption).trigger('change');
                } 
                  $("#"+idLovResourceEmployee).trigger('change');
            } else {
                $("#"+idLovResourceEmployee).val(row.full_name);
            }
          } else {
            if (idLovResourceEmployeeDesc) {
              $("#"+idLovResourceEmployee).val(row.employee_number);
              $("#"+idLovResourceEmployeeDesc).val(row.full_name);
            } else {
              $("#"+idLovResourceEmployee).val(row.employee_number + ' - ' + row.full_name);
            }
          }
          $("#"+idLovResourceEmployeeId).val(row.employee_id).trigger('change');
          break
        }
      }
    }
    function clearDescEmployeeTbLB(data) {
      data.parents('tr').find("td:eq(5) input[type='text']").val('');
    }
    $("#detailResourceEmployee").on('hidden.bs.modal', () => {
      if (inModalResourceEmp) {
        $('body').addClass('modal-open')
        inModalResourceEmp = false
      }
    })
</script>
