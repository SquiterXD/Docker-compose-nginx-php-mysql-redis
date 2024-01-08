
<script>
    var dataLovEmployeeWeb = []
    var idLovEmployeeWeb = ''
    var idLovEmployeeWebId = ''
    var idLovEmployeeWebDesc = ''
    var inModalEmp = false
    var locationEmployeeWeb = ''
    var dataWebCode = ''

    function lovEmployeeWeb() {
      $.ajax({
        url: "{{ route('eam.ajax.lov.web-user') }}",
        method: 'GET',
        data: {
          'p_user_id': '',
          // 'p_username': '',
          'p_name': '',
          'p_department_code': dataWebCode
        },
        success: function (response) {
          $("#detailEmployeeWebLov").modal('show');
          $("#modalEmployeeWebSearchEmpCode").val('');
          $("#modalEmployeeWebSearchEmpName").val('');
          dataLovEmployeeWeb = response.data;
          setLovEmployeeWebFn(response);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }

    function employeeWebLovBtnOnclick(data) {
      $("#nameLovEmployeeWeb").html(data.nameEmployeeWebModal)
      idLovEmployeeWeb = data.idEmployeeWebModal
      idLovEmployeeWebId = data.idEmployeeWebModal + 'Id'
      if (data.desc) {
        idLovEmployeeWebDesc = data.idEmployeeWebModal + 'Desc'
      } else {
        idLovEmployeeWebDesc = ''
      }

      if (data.idWebCode) {
        if($("#eam0007").attr('id') === 'eam0007'){
          dataWebCode = $("#"+data.idWebCode).val() ? $("#"+data.idWebCode).val() : ''
        }else{
          dataWebCode = $("#"+data.idWebCode).val() ? $("#"+data.idWebCode).val().split(' - ')[0] : ''
        }
      }
      inModalEmp = data.inModal
      locationEmployeeWeb = ''
      lovEmployeeWeb();
    }

    $("#modalSearchEmployeeWebLov").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.lov.web-user') }}",
        method: 'GET',
        data: {
          'p_user_id': '',
          'p_name': $("#modalEmployeeWebSearchEmpName").val(),
          'p_department_code': dataWebCode
        },
        success: function (response) {
          dataLovEmployeeWeb = response.data;
          if (response.data.length < 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setLovEmployeeWeb").html('');
            $('#setLovEmployeeWebPagination').html('');
          } else {
            setLovEmployeeWebFn(response);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })

    function setLovEmployeeWebFn(data) {
      let theadLovEmployeeWeb = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovEmployeeWeb += `<tr>`
          theadLovEmployeeWeb += `<td class="pointer" onclick="setDataLovEmployeeWeb('` + row.username + `')">${row.username ? row.username : ''}</td>`
          theadLovEmployeeWeb += `<td class="pointer" onclick="setDataLovEmployeeWeb('` + row.username + `')">${row.name ? row.name : ''}</td>`
          theadLovEmployeeWeb += `</tr>`
        })
      }
      $("#setLovEmployeeWeb").html(theadLovEmployeeWeb);

      let html = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        html += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovEmployeeWebPagination('` + link.url + `')">${link.label}</a></li>`
      });
      html += '</ul>';
      $('#setLovEmployeeWebPagination').html(html);
    }
    
    function searchLovEmployeeWebPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          data: {
            // 'p_username': $("#modalEmployeeWebSearchEmpCode").val(),
            'p_user_id': '',
            'p_name': $("#modalEmployeeWebSearchEmpName").val(),
            'p_department_code': dataWebCode
          },
          success: function (response) {
            dataLovEmployeeWeb = response.data;
            if (response.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovEmployeeWeb").html('');
              $('#setLovEmployeeWebPagination').html('');
            } else {
              setLovEmployeeWebFn(response);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }

    function setDataLovEmployeeWeb(data) {
      $("#detailEmployeeWebLov").modal('hide');
      for (const row of dataLovEmployeeWeb) {
        if (row.username == data) {
          if (locationEmployeeWeb == 'complete') {
            $("#"+idLovEmployeeWeb).val(row.username + ' - ' + row.name);
          } else {
            if (idLovEmployeeWebDesc) {
              $("#"+idLovEmployeeWeb).val(row.username);
              $("#"+idLovEmployeeWebDesc).val(row.name);
            } else {
              $("#"+idLovEmployeeWeb).val(row.username + ' - ' + row.name);
            }
          }
          $("#"+idLovEmployeeWebId).val(row.user_id);
          $("#"+idLovEmployeeWeb).addClass('x');
          
          if($("#"+idLovEmployeeWeb).is('select')) {
            if ($('#' + idLovEmployeeWeb).find("option[value='" + row.username + "']").length) {
              $('#' + idLovEmployeeWeb).val(row.username).trigger('change');
            } else { 
              var newOption = new Option(row.username + ' - ' + row.name, row.username, true, true);
              $('#' + idLovEmployeeWeb).append(newOption).trigger('change');
            } 
            $("#"+idLovEmployeeWeb).trigger('change');
          } else {
            $("#"+idLovEmployeeWeb).val(row.username + ' - ' + row.name);
          }

          break
        }
      }
    }

    $("#detailEmployeeWebLov").on('hidden.bs.modal', () => {
      if (inModalEmp) {
        conso.log('aa')
        $('body').addClass('modal-open')
        inModalEmp = false
      }
    })
</script>