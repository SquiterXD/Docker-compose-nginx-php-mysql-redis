
<script>
    var dataLovEmployee = []
    var idLovEmployee = ''
    var idLovEmployeeId = ''
    var idLovEmployeeDesc = ''
    var inModalEmp = false
    var locationEmployee = ''

    function lovEmployee() {
      $.ajax({
        url: "{{ route('eam.ajax.lov.employee') }}",
        method: 'GET',
        success: function (response) {
          $("#detailEmployeeLov").modal('show');
          $("#modalEmployeeSearchEmpCode").val('');
          $("#modalEmployeeSearchEmpName").val('');
          dataLovEmployee = response.data;
          setLovEmployeeFn(response);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    function employeeLovBtnTableOnclick(data) {
      $("#nameLovEmployee").html(data.nameEmployeeModal)
      idLovEmployee = data.idEmployeeModal
      idLovEmployeeId = data.idEmployeeModal + 'Id'
      if (data.desc) {
        idLovEmployeeDesc = data.idEmployeeModal + 'Desc'
      } else {
        idLovEmployeeDesc = ''
      }
      inModalEmp = data.inModal
      locationEmployee = data.locationEmployee
      lovEmployee();
    }
    function employeeLovBtnOnclick(data) {
      $("#nameLovEmployee").html(data.nameEmployeeModal)
      idLovEmployee = data.idEmployeeModal
      idLovEmployeeId = data.idEmployeeModal + 'Id'
      if (data.desc) {
        idLovEmployeeDesc = data.idEmployeeModal + 'Desc'
      } else {
        idLovEmployeeDesc = ''
      }
      inModalEmp = data.inModal
      locationEmployee = ''
      lovEmployee();
    }
    $("#modalSearchEmployeeLov").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.lov.employee') }}",
        method: 'GET',
        data: {
          'p_employee_number': $("#modalEmployeeSearchEmpCode").val(),
          'p_full_name': $("#modalEmployeeSearchEmpName").val()
        },
        success: function (response) {
          dataLovEmployee = response.data;
          if (response.data.length < 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setLovEmployee").html('');
            $('#setLovEmployeePagination').html('');
          } else {
            setLovEmployeeFn(response);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })
    function setLovEmployeeFn(data) {
      let theadLovEmployee = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovEmployee += `<tr>`
          theadLovEmployee += `<td class="pointer" onclick="setDataLovEmployee('` + row.employee_number + `')">${row.employee_number ? row.employee_number : ''}</td>`
          theadLovEmployee += `<td class="pointer" onclick="setDataLovEmployee('` + row.employee_number + `')">${row.full_name ? row.full_name : ''}</td>`
          theadLovEmployee += `</tr>`
        })
      }
      $("#setLovEmployee").html(theadLovEmployee);

      let html = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        html += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovEmployeePagination('` + link.url + `')">${link.label}</a></li>`
      });
      html += '</ul>';
      $('#setLovEmployeePagination').html(html);
    }
    function searchLovEmployeePagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          data: {
            'p_employee_number': $("#modalEmployeeSearchEmpCode").val(),
            'p_full_name': $("#modalEmployeeSearchEmpName").val()
          },
          success: function (response) {
            dataLovEmployee = response.data;
            if (response.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovEmployee").html('');
              $('#setLovEmployeePagination').html('');
            } else {
              setLovEmployeeFn(response);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
    function setDataLovEmployee(data) {
      $("#detailEmployeeLov").modal('hide');
      for (const row of dataLovEmployee) {
        if (row.employee_number == data) {
          if (locationEmployee == 'complete') {
            $("#"+idLovEmployee).val(row.employee_number + ' - ' + row.full_name);
          } else {
            if (idLovEmployeeDesc) {
              $("#"+idLovEmployee).val(row.employee_number);
              $("#"+idLovEmployeeDesc).val(row.full_name);
            } else {
              $("#"+idLovEmployee).val(row.employee_number + ' - ' + row.full_name);
            }
          }

          if($("#"+idLovEmployee).is('select')) {
            if ($('#' + idLovEmployee).find("option[value='" + row.employee_number + "']").length) {
              $('#' + idLovEmployee).val(row.employee_number).trigger('change');
            } else { 
              var newOption = new Option(row.employee_number + ' - ' + row.full_name, row.employee_number, true, true);
              $('#' + idLovEmployee).append(newOption).trigger('change');
            } 
            $("#"+idLovEmployee).trigger('change');
          } else {
            $("#"+idLovEmployee).val(row.employee_number);
          }
          
          // if($("#eam0033").attr('id') != 'eam0033' && $("#eam0034").attr('id') != 'eam0034'){
            // console.log(idLovEmployeeId)
            // $("#"+idLovEmployeeId).val(row.person_id);
            // $("#"+idLovEmployee).addClass('x');
          // }
          
          break;
        }
      }
    }
    $("#detailEmployeeLov").on('hidden.bs.modal', () => {
      if (inModalEmp) {
        $('body').addClass('modal-open')
        inModalEmp = false
      }
    })
</script>