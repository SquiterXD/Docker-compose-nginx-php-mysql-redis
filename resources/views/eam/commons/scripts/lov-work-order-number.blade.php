
<script>
    var dataLovWorkOrderNumber = []
    var idLovWorkOrderNumber = ''
    var inModalWorlOrderNumber = false

    function lovWorkOrderNumber() {
      $.ajax({
        url: "{{ route('eam.ajax.lov.work-request-number') }}",
        method: 'GET',
        success: function (response) {
          $("#detailWorkOrderNumberLov").modal('show');
          $("#modalWorkOrderNumberSearchWorkOrderNumber").val('');
          dataLovWorkOrderNumber = response.data;
          setLovWorkOrderNumberFn(response);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    $("#workOrderNumberLovBtn").click(() => {
      idLovWorkOrderNumber = 'workOrderNumber'
      inModalWorlOrderNumber = false
      lovWorkOrderNumber()
    })
    function workOrderNumberBtnReportOnclick(data) {
      $("#nameWorkOrderNumber").html(data.nameWorkOrderNumberModal)
      idLovWorkOrderNumber = data.idWorkOrderNumberModal
      inModalWorlOrderNumber = false
      lovWorkOrderNumber()
    }
    function workOrderNumberLovBtnOnclick(data) {
      $("#nameWorkOrderNumber").html(data.nameWorkOrderNumberModal)
      idLovWorkOrderNumber = data.idWorkOrderNumberModal
      if (data.desc) {
        idLovWorkOrderNumberDesc = data.idWorkOrderNumberModal + 'Desc'
      } else {
        idLovWorkOrderNumberDesc = ''
      }
      inModalWorlOrderNumber = data.inModal
      idLovWorkOrderNumberTable = ''
      lovWorkOrderNumber();
    }
    $("#modalSearchWorkOrderNumberLov").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.lov.work-request-number') }}",
        method: 'GET',
        data: {
          'p_work_request_number': $("#modalWorkOrderNumberSearchWorkOrderNumber").val()
        },
        success: function (response) {
          dataLovWorkOrderNumber = response.data;
          if (response.data.length < 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setLovWorkOrderNumber").html('');
            $('#setLovWorkOrderNumberPagination').html('');
          } else {
            setLovWorkOrderNumberFn(response);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })
    function setLovWorkOrderNumberFn(data) {
      let theadLovWorkOrderNumber = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovWorkOrderNumber += `<tr>`
          theadLovWorkOrderNumber += `<td class="pointer" onclick="setDataLovWorkOrderNumber('` + row.work_request_number + `')">${row.work_request_number ? row.work_request_number : ''}</td>`
          theadLovWorkOrderNumber += `<td class="pointer" onclick="setDataLovWorkOrderNumber('` + row.work_request_number + `')">${row.work_request_type_desc ? row.work_request_type_desc : ''}</td>`
          theadLovWorkOrderNumber += `<td class="pointer" onclick="setDataLovWorkOrderNumber('` + row.work_request_number + `')">${row.work_request_status_desc ? row.work_request_status_desc : ''}</td>`
          theadLovWorkOrderNumber += `<td class="pointer" onclick="setDataLovWorkOrderNumber('` + row.work_request_number + `')">${row.asset_desc ? row.asset_desc : ''}</td>`
          theadLovWorkOrderNumber += `<td class="pointer" onclick="setDataLovWorkOrderNumber('` + row.work_request_number + `')">${row.description ? row.description : ''}</td>`
          theadLovWorkOrderNumber += `<td class="pointer" onclick="setDataLovWorkOrderNumber('` + row.work_request_number + `')">${row.creation_date ? row.creation_date : ''}</td>`
          theadLovWorkOrderNumber += `<td class="pointer" onclick="setDataLovWorkOrderNumber('` + row.work_request_number + `')">${row.employee_desc ? row.employee_desc : ''}</td>`
          theadLovWorkOrderNumber += `<td class="pointer" onclick="setDataLovWorkOrderNumber('` + row.work_request_number + `')">${row.owning_dept_desc ? row.owning_dept_desc : ''}</td>`
          theadLovWorkOrderNumber += `<td class="pointer" onclick="setDataLovWorkOrderNumber('` + row.work_request_number + `')">${row.work_order_number ? row.work_order_number : ''}</td>`
          theadLovWorkOrderNumber += `</tr>`
        })
      }
      $("#setLovWorkOrderNumber").html(theadLovWorkOrderNumber);

      let html = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        html += `<li  class="footable-page ${link.active ? 'active' : ''}" 
                      style="padding-top: 15px;">
                  <a onclick="searchLovWorkOrderNumberPagination('` + link.url + `')">${link.label}</a>
                </li>`
      });
      html += '</ul>';
      $('#setLovWorkOrderNumberPagination').html(html);
    }
    function searchLovWorkOrderNumberPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          data: {
            'p_work_request_number': $("#modalWorkOrderNumberSearchWorkOrderNumber").val()
          },
          success: function (response) {
            dataLovWorkOrderNumber = response.data;
            if (response.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovWorkOrderNumber").html('');
              $('#setLovWorkOrderNumberPagination').html('');
            } else {
              setLovWorkOrderNumberFn(response);
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
    function setDataLovWorkOrderNumber(data) {
      $("#detailWorkOrderNumberLov").modal('hide');
      for (const row of dataLovWorkOrderNumber) {
        if (row.work_request_number == data) {
          if ($("#eam0007").attr('id') === 'eam0007' && 
              idLovWorkOrderNumber == 'workOrderNumber') {
            $.ajax({
              url: "{{ route('eam.ajax.work-requests.show',['']) }}/" + data,
              method: 'GET',
              success: function (response) {
                setDataLovWorkOrderNumberResponse(response);
                if ($("#workOrderStatus").val() == '8') {
                  if ($("#permissionHidden").val() == 'Y') {
                    $("#awaitingWorkOrderWorkRequestStatusDesc").show();
                    $("#rejectedWorkRequestStatusDesc").show();
                  } else {
                    $("#awaitingWorkOrderWorkRequestStatusDesc").hide();
                    $("#rejectedWorkRequestStatusDesc").hide();
                  }
                } else {
                  $("#awaitingWorkOrderWorkRequestStatusDesc").hide();
                  $("#rejectedWorkRequestStatusDesc").hide();
                }

                if($("#reportingAgency").val().split(' - ')[0] != $("#notifyingAgency").val().split(' - ')[0]) {
                  $("#repairNotificationDate").prop('style', 'background-color:#E4E7EB');
                  vmDatePicker.repairNotificationDate.disabled = true;
                  $("#repairNotificationDate").prop("disabled", true);
                } else {
                  $("#repairNotificationDate").prop('style', 'background-color:none');
                  vmDatePicker.repairNotificationDate.disabled = false;
                  $("#repairNotificationDate").prop("disabled", false);
                }

                if($("#"+idLovWorkOrderNumber).is('select')) {
                  if ($('#' + idLovWorkOrderNumber).find("option[value='" + row.work_request_number + "']").length) {
                    $('#' + idLovWorkOrderNumber).val(row.work_request_number).trigger('change');
                  } else { 
                    var newOption = new Option(row.work_request_number, row.work_request_number, true, true);
                    $('#' + idLovWorkOrderNumber).append(newOption).trigger('change');
                  } 
                  $("#"+idLovWorkOrderNumber).trigger('change');
                } else {
                  $("#"+idLovWorkOrderNumber).val(row.work_request_number);
                }
              },
              error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
              }
            })
            break
          } else {
            if($("#"+idLovWorkOrderNumber).is('select')) {
              if ($('#' + idLovWorkOrderNumber).find("option[value='" + row.work_request_number + "']").length) {
                $('#' + idLovWorkOrderNumber).val(row.work_request_number).trigger('change');
              } else { 
                var newOption = new Option(row.work_request_number, row.work_request_number, true, true);
                $('#' + idLovWorkOrderNumber).append(newOption).trigger('change');
              } 
              $("#"+idLovWorkOrderNumber).trigger('change');
            } else {
              $("#"+idLovWorkOrderNumber).val(row.work_request_number);
            }
            break
          }
        }
      }
    }
    $("#detailWorkOrderNumberLov").on('hidden.bs.modal', () => {
      if (inModalWorlOrderNumber) {
        $('body').addClass('modal-open')
        inModalWorlOrderNumber = false
      }
    })
</script>
