
<script>
    var dataLovEmployeeDepartment = []
    var idLovEmployeeDepartment = ''
    var idLovEmployeeDepartmentId = ''
    var idLovEmployeeDepartmentDesc = ''
    var inModalEmp = false
    var locationEmployeeDepartment = ''
    var dataDepartmentCode = ''

    function lovEmployeeDepartment() {
      $.ajax({
        url: "{{ route('eam.ajax.lov.department-employee') }}",
        method: 'GET',
        data: {
          'p_employee_number': '',
          'p_full_name': '',
          'p_department_code': dataDepartmentCode
        },
        success: function (response) {
          $("#detailEmployeeDepartmentLov").modal('show');
          $("#modalEmployeeDepartmentSearchEmpCode").val('');
          $("#modalEmployeeDepartmentSearchEmpName").val('');
          dataLovEmployeeDepartment = response.data;
          setLovEmployeeDepartmentFn(response);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    function employeeDepartmentLovBtnOnclick(data) {
      $("#nameLovEmployeeDepartment").html(data.nameEmployeeDepartmentModal)
      idLovEmployeeDepartment = data.idEmployeeDepartmentModal
      idLovEmployeeDepartmentId = data.idEmployeeDepartmentModal + 'Id'
      if (data.desc) {
        idLovEmployeeDepartmentDesc = data.idEmployeeDepartmentModal + 'Desc'
      } else {
        idLovEmployeeDepartmentDesc = ''
      }

      if (data.idDepartmentCode) {
        dataDepartmentCode = $("#"+data.idDepartmentCode).val() ? $("#"+data.idDepartmentCode).val().split(' - ')[0] : ''
      }
      inModalEmp = data.inModal
      locationEmployeeDepartment = ''
      lovEmployeeDepartment();
    }
    $("#modalSearchEmployeeDepartmentLov").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.lov.department-employee') }}",
        method: 'GET',
        data: {
          'p_employee_number': $("#modalEmployeeDepartmentSearchEmpCode").val(),
          'p_full_name': $("#modalEmployeeDepartmentSearchEmpName").val(),
          'p_department_code': dataDepartmentCode
        },
        success: function (response) {
          dataLovEmployeeDepartment = response.data;
          if (response.data.length < 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setLovEmployeeDepartment").html('');
            $('#setLovEmployeeDepartmentPagination').html('');
          } else {
            setLovEmployeeDepartmentFn(response);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })
    function setLovEmployeeDepartmentFn(data) {
      let theadLovEmployeeDepartment = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovEmployeeDepartment += `<tr>`
          theadLovEmployeeDepartment += `<td class="pointer" onclick="setDataLovEmployeeDepartment('` + row.employee_number + `')">${row.employee_number ? row.employee_number : ''}</td>`
          theadLovEmployeeDepartment += `<td class="pointer" onclick="setDataLovEmployeeDepartment('` + row.employee_number + `')">${row.full_name ? row.full_name : ''}</td>`
          theadLovEmployeeDepartment += `</tr>`
        })
      }
      $("#setLovEmployeeDepartment").html(theadLovEmployeeDepartment);

      let html = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        html += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovEmployeeDepartmentPagination('` + link.url + `')">${link.label}</a></li>`
      });
      html += '</ul>';
      $('#setLovEmployeeDepartmentPagination').html(html);
    }
    function searchLovEmployeeDepartmentPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          data: {
            'p_employee_number': $("#modalEmployeeDepartmentSearchEmpCode").val(),
            'p_full_name': $("#modalEmployeeDepartmentSearchEmpName").val(),
            'p_department_code': dataDepartmentCode
          },
          success: function (response) {
            dataLovEmployeeDepartment = response.data;
            if (response.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovEmployeeDepartment").html('');
              $('#setLovEmployeeDepartmentPagination').html('');
            } else {
              setLovEmployeeDepartmentFn(response);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
    function setDataLovEmployeeDepartment(data) {
      $("#detailEmployeeDepartmentLov").modal('hide');
      for (const row of dataLovEmployeeDepartment) {
        if (row.employee_number == data) {
          if (locationEmployeeDepartment == 'complete') {
            $("#"+idLovEmployeeDepartment).val(row.employee_number + ' - ' + row.full_name);
          } else {
            if (idLovEmployeeDepartmentDesc) {
              $("#"+idLovEmployeeDepartment).val(row.employee_number);
              $("#"+idLovEmployeeDepartmentDesc).val(row.full_name);
            } else {
              $("#"+idLovEmployeeDepartment).val(row.employee_number + ' - ' + row.full_name);
            }
          }
          $("#"+idLovEmployeeDepartmentId).val(row.person_id);
          $("#"+idLovEmployeeDepartment).addClass('x');
          break
        }
      }
    }
    $("#detailEmployeeDepartmentLov").on('hidden.bs.modal', () => {
      if (inModalEmp) {
        $('body').addClass('modal-open')
        inModalEmp = false
      }
    })
</script>
