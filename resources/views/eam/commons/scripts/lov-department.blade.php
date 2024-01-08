<script>
    var dataLovDepartment = []
    var idLovDepartment = ''
    var idLovDepartmentTable = ''
    var idLovDepartmentDesc = ''
    var thisDepartment = ''
    var inModalDepartment = false
    function lovDepartment() {
      $.ajax({
        url: "{{ route('eam.ajax.lov.departments') }}",
        method: 'GET',
        success: function (response) {
          $("#detailDepartmentLov").modal('show');
          $("#modalDepartmentSearchCode").val('');
          $("#modalDepartmentSearchName").val('');
          dataLovDepartment = response.data;
          setLovDepartmentFn(response);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    function departmentLovBtnOnclick(data) {
      $("#nameLovDepartment").html(data.nameDepartmentModal)
      idLovDepartment = data.idDepartmentModal
      if (data.desc) {
        idLovDepartmentDesc = data.idDepartmentModal + 'Desc'
      } else {
        idLovDepartmentDesc = ''
      }
      inModalDepartment = data.inModal
      idLovDepartmentTable = ''
      lovDepartment();
    }
    function departmentLovBtnTableOnclick(data) {
      $("#nameLovDepartment").html(data.nameDepartmentModal)
      idLovDepartment = ''
      idLovDepartmentDesc = ''
      inModalDepartment = false
      idLovDepartmentTable = data.idDepartmentModal
      lovDepartment();
    }
    $("#modalSearchDepartmentLov").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.lov.departments') }}",
        method: 'GET',
        data: {
          'p_department_code': $("#modalDepartmentSearchCode").val(),
          'p_description': $("#modalDepartmentSearchName").val()
        },
        success: function (response) {
          dataLovDepartment = response.data;
          if (response.data.length < 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setLovDepartment").html('');
            $('#setLovDepartmentPagination').html('');
          } else {
            setLovDepartmentFn(response);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })
    function setLovDepartmentFn(data) {
      let theadLovDepartment = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovDepartment += `<tr>`
          theadLovDepartment += `<td class="pointer" onclick="setDataLovDepartment('` + row.department_code + `')">${row.department_code ? row.department_code : ''}</td>`
          theadLovDepartment += `<td class="pointer" onclick="setDataLovDepartment('` + row.department_code + `')">${row.description ? row.description : ''}</td>`
          theadLovDepartment += `</tr>`
        })
      }
      $("#setLovDepartment").html(theadLovDepartment);

      let html = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        html += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovDepartmentPagination('` + link.url + `')">${link.label}</a></li>`
      });
      html += '</ul>';
      $('#setLovDepartmentPagination').html(html);
    }
    function searchLovDepartmentPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          data: {
            'p_department_code': $("#modalDepartmentSearchCode").val(),
            'p_description': $("#modalDepartmentSearchName").val()
          },
          success: function (response) {
            dataLovDepartment = response.data;
            if (response.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovDepartment").html('');
              $('#setLovDepartmentPagination').html('');
            } else {
              setLovDepartmentFn(response);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
    function setDataLovDepartment(data) {
      $("#detailDepartmentLov").modal('hide');
      for (const row of dataLovDepartment) {
        if (row.department_code == data) {
          if (idLovDepartmentTable != '') {
            $(idLovDepartmentTable).parents('div.input-group').find("input[type='text']").val(row.department_code + ' - ' + row.description);
            $(idLovDepartmentTable).parents('div.input-group').find("input[type='text']").addClass('x');
            if ($("#statusPlan").val() == 'Confirm' && $("#eam0006").attr('id') === 'eam0006') {
              editConfirm = true
            }

            if ($(idLovDepartmentTable).parents('div.input-group').find("select").find("option[value='" + row.department_code + "']").length) {
              $(idLovDepartmentTable).parents('div.input-group').find("select").trigger('change');
            } else { 
              var newOption = new Option(row.department_code + ' - ' + row.description, row.department_code, true, true);
              $(idLovDepartmentTable).parents('div.input-group').find("select").append(newOption).trigger('change');
            } 
            $(idLovDepartmentTable).parents('div.input-group').find("select").trigger('change');
          } else {
            if($("#eam0006").attr('id') != 'eam0006' && 
               $("#eam0014").attr('id') != 'eam0014'      ){
              if (idLovDepartmentDesc) {
                $("#"+idLovDepartmentDesc).val(row.description);
              } else {
                if($("#"+idLovDepartment).is('select')) {
                  if ($('#' + idLovDepartment).find("option[value='" + row.department_code + "']").length) {
                    $('#' + idLovDepartment).val(row.department_code).trigger('change');
                  } else { 
                    var newOption = new Option(row.department_code + ' - ' + row.description, row.department_code, true, true);
                    $('#' + idLovDepartment).append(newOption).trigger('change');
                    $('#' + idLovDepartment).val(row.department_code).trigger('change');
                  } 
                  $("#"+idLovDepartment).trigger('change');
                } else {
                  $("#"+idLovDepartment).val(row.department_code).trigger('change');
                }
              }
              $("#"+idLovDepartment).addClass('x');
            }   
            
            var reportingAgency = $("#reportingAgency").val();
            if (typeof reportingAgency === 'string') {
              if($("#reportingAgency").val() != $("#notifyingAgency").val()) {
                $("#repairNotificationDate").prop('style', 'background-color:#E4E7EB');
                $("#repairNotificationDate").prop("disabled", true);
                if (typeof vmDatePicker.repairNotificationDate != "undefined") {
                  vmDatePicker.repairNotificationDate.disabled = true;
                }
              } else {
                $("#repairNotificationDate").prop('style', 'background-color:none');
                $("#repairNotificationDate").prop("disabled", false);
                if (typeof vmDatePicker.repairNotificationDate != "undefined") {
                  vmDatePicker.repairNotificationDate.disabled = true;
                }
              }
            }

            var classCode = $("#class").attr("name", "owning_dept_code");
            if (classCode.length) {
              var assetNumberVal = $("#assetNumber").val();
              var notifyingAgencyVal = $("#notifyingAgency").val();
              if (typeof assetNumberVal === 'string' && typeof notifyingAgencyVal === 'string') {
                $.ajax({
                  url: "{{ route('eam.ajax.work-order.auto-class-EMP0007') }}",
                  method: 'GET',
                  data: {
                    'assetNumber': assetNumberVal,
                    'departmentCode': notifyingAgencyVal.split(' - ')[0]
                  },
                  success: function (response) {
                    $("#class").val(response.data.v_class_code);
                  }
                })
              }
            }

            if($("#"+idLovDepartment).is('select')) {
              if ($('#' + idLovDepartment).find("option[value='" + row.department_code + "']").length) {
                $('#' + idLovDepartment).val(row.department_code).trigger('change');
              } else { 
                if( ($("#eam0017").attr('id') == 'eam0017' && 
                     $('#' + idLovDepartment).attr('id') == 'modalReportBillMaterialsAgency') ||
                    ($("#eam0007").attr('id') == 'eam0007' && 
                     $('#' + idLovDepartment).attr('id') == 'modalReportWorkOrderReportingAgency') ||
                    ($("#eam0007").attr('id') == 'eam0007' && 
                     $('#' + idLovDepartment).attr('id') == 'modalReportWorkOrderNotifyingAgency')
                  ){
                  var newOption = new Option(row.department_code, row.department_code, true, true);
                  $('#' + idLovDepartment).append(newOption).trigger('change');
                  $('#' + idLovDepartment).val(row.department_code).trigger('change');
                }

                var newOption = new Option(row.department_code + ' - ' + row.description, row.department_code, true, true);
                $('#' + idLovDepartment).append(newOption).trigger('change');
                $('#' + idLovDepartment).val(row.department_code).trigger('change');
              } 
              $("#"+idLovDepartment).trigger('change');
            } else {
              $("#"+idLovDepartment).val(row.department_code).trigger('change');
            }
          }
          break
        }
      }

      if($("#eam0010").attr('id') === 'eam0010' && idLovDepartment == 'modalReportWorkReceiptNotifyingAgency'){
        if($('#eam0010 #modalReportWorkReceiptNotifyingAgency').val() != null) {
            $('#eam0010 #modalReportWorkReceiptNotifyingAgency').select2('data')[0].text = $('#eam0010 #modalReportWorkReceiptNotifyingAgency').select2('data')[0].id;
        }
      }
    }
    $("#detailDepartmentLov").on('hidden.bs.modal', () => {
      if (inModalDepartment) {
        $('body').addClass('modal-open')
        inModalDepartment = false
      }
    })
</script>
