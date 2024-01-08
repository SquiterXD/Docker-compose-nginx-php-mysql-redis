
<script>
    var dataLovAssetNumber            = [];
    var dataLovAssetNumberChild       = [];
    var idLovAssetNumber              = '';
    var reportAssetNumber             = true;
    var thisLovAssetNumber            = '';
    var thisLovAssetNumberDesc        = '';
    var thisLovAssetNumberArea        = '';
    var thisLovAssetNumberDepartment  = '';
    var departmentCodeInAssetNumber   = '';
    var inModalAsset                  = true;
    var dataOwningDepartment          = '';
    function lovAssetNumber(parameters = {}) {
        let paramDept = {'p_department': dataOwningDepartment};
        let paramData = {...paramDept, ...parameters};
      $.ajax({
        url: "{{ route('eam.ajax.lov.asset-number') }}",
        method: 'GET',
        data: paramData,
        success: function (response) {
          $("#detailAssetNumberLov").modal('show');
          $("#modalAssetNumberSearchAssetNumber").val('');
          $("#modalAssetNumberSearchDescription").val('');
          $("#modalAssetNumberSearchSerialNumber").val('');
          dataLovAssetNumber = response.data;
          setLovAssetNumberFn(response);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    function assetNumberBtnReportOnclick(data) {
      idLovAssetNumber    = data;
      inModalAsset        = false;
      reportAssetNumber   = false;
      lovAssetNumber();
    }
    function assetNumberBtnOnclick(data) {
      idLovAssetNumber    = data.data1;
      inModalAsset        = true;
      reportAssetNumber   = false;
      lovAssetNumber();
    }
    function assetNumberLovBtnDesc(data) {
      thisLovAssetNumber            = data.data1;
      thisLovAssetNumberDesc        = data.data2;
      thisLovAssetNumberArea        = data.data3;
      thisLovAssetNumberDepartment  = data.data4;
      inModalAsset                  = true;
      lovAssetNumber();
    }
    $("#assetNumberLovBtn").click(() => {
      let attrFilterDeptByAuth      = $("#assetNumberLovBtn").attr('attr-filter-dept-by-auth');
          attrFilterDeptByAuth      = attrFilterDeptByAuth ? attrFilterDeptByAuth : 0;
      idLovAssetNumber              = 'assetNumber';
      thisLovAssetNumber            = '';
      thisLovAssetNumberDesc        = '';
      thisLovAssetNumberArea        = '';
      thisLovAssetNumberDepartment  = '';
      reportAssetNumber             = true;
      if (attrFilterDeptByAuth) {
        lovAssetNumber({'p_attr_filter_dept_by_auth': attrFilterDeptByAuth});
      } else {
        lovAssetNumber();
      }
      inModalAsset = true;
    })
    $("#assetNumberOpenJobLovBtn").click(() => {
      let attrFilterDeptByAuth      = $("#assetNumberOpenJobLovBtn").attr('attr-filter-dept-by-auth');
          attrFilterDeptByAuth      = attrFilterDeptByAuth ? attrFilterDeptByAuth : 0;
      idLovAssetNumber              = 'assetNumberOpenJob';
      thisLovAssetNumber            = '';
      thisLovAssetNumberDesc        = '';
      thisLovAssetNumberArea        = '';
      thisLovAssetNumberDepartment  = '';
      reportAssetNumber             = true;
      if (attrFilterDeptByAuth) {
        lovAssetNumber({'p_attr_filter_dept_by_auth': attrFilterDeptByAuth});
      } else {
        lovAssetNumber();
      }
      inModalAsset = true;
    })
    $("#assetNumberCloseJobLovBtn").click(() => {
      let attrFilterDeptByAuth      = $("#assetNumberCloseJobLovBtn").attr('attr-filter-dept-by-auth');
          attrFilterDeptByAuth      = attrFilterDeptByAuth ? attrFilterDeptByAuth : 0;
      idLovAssetNumber              = 'assetNumberCloseJob';
      thisLovAssetNumber            = '';
      thisLovAssetNumberDesc        = '';
      thisLovAssetNumberArea        = '';
      thisLovAssetNumberDepartment  = '';
      reportAssetNumber             = true;
      if (attrFilterDeptByAuth) {
        lovAssetNumber({'p_attr_filter_dept_by_auth': attrFilterDeptByAuth});
      } else {
        lovAssetNumber();
      }
      inModalAsset = true;
    })

    $("#assetNumberOwLovBtn").click(() => {
      idLovAssetNumber              = 'assetNumber';
      thisLovAssetNumber            = '';
      thisLovAssetNumberDesc        = '';
      thisLovAssetNumberArea        = '';
      thisLovAssetNumberDepartment  = '';
      reportAssetNumber             = true;
      inModalAsset                  = true;
      if ($("#notifyingAgency").val()) {
        dataOwningDepartment = $("#notifyingAgency").val().split(' - ')[0];
      } else {
        dataOwningDepartment = '';
      }
      lovAssetNumber();
    })

    $("#modalReportWorkOrderAssetNumberBtn").click(() => {
      idLovAssetNumber  = 'modalReportWorkOrderAssetNumber';
      inModalAsset      = false;
      reportAssetNumber = false;
      lovAssetNumber();
    })

    $("#modalReportWorkReceiptAssetNumberBtn").click(() => {
      idLovAssetNumber  = 'modalReportWorkReceiptAssetNumber';
      inModalAsset      = false;
      reportAssetNumber = false;
      lovAssetNumber();
    })

    $("#modalSearchAssetNumberLov").click(() => {
      modalSearchAssetNumberLovClick();
    })

    function modalSearchAssetNumberLovClick() {
        let paramData = {
          'p_asset_number':   $("#modalAssetNumberSearchAssetNumber").val(),
          'p_description':    $("#modalAssetNumberSearchDescription").val(),
          'p_serial_number':  $("#modalAssetNumberSearchSerialNumber").val(),
          'p_department':     dataOwningDepartment
        };

        let attrFilterDeptByAuth = $("#modalSearchAssetNumberLov").attr('attr-filter-dept-by-auth');
            attrFilterDeptByAuth = attrFilterDeptByAuth ? attrFilterDeptByAuth : 0;
        if (attrFilterDeptByAuth) {
            paramData.p_attr_filter_dept_by_auth = attrFilterDeptByAuth;
        }
      $.ajax({
        url: "{{ route('eam.ajax.lov.asset-number') }}",
        method: 'GET',
        data: paramData,
        success: function (response) {
          dataLovAssetNumber = response.data;
          if (response.data.length < 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setLovAssetNumber").html('');
            $('#setLovAssetNumberPagination').html('');
          } else {
            setLovAssetNumberFn(response);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }

    function setLovAssetNumberFn(data) {
      let theadLovAssetNumber = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovAssetNumber += `<tr>`
          theadLovAssetNumber += `<td class="pointer" onclick="setDataLovAssetNumber('` + row.asset_number + `')">${row.asset_number ? row.asset_number : ''}</td>`
          theadLovAssetNumber += `<td class="pointer" onclick="setDataLovAssetNumber('` + row.asset_number + `')">${row.description ? row.description : ''}</td>`
          theadLovAssetNumber += `<td class="pointer" onclick="setDataLovAssetNumber('` + row.asset_number + `')">${row.serial_number ? row.serial_number : ''}</td>`
          theadLovAssetNumber += `<td class="pointer" onclick="setDataLovAssetNumber('` + row.asset_number + `')">${row.parent ? row.parent : ''}</td>`
          theadLovAssetNumber += row.parent ? `<td><button onclick="setDataLovAssetNumberChildBtn('` + row.parent + `')"  type="button" class="btn btn-secondary btn-xs">Child </button></td>` : ''
          theadLovAssetNumber += `</tr>`
        })
      }
      $("#setLovAssetNumber").html(theadLovAssetNumber);

      let html = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        html += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovAssetNumberPaginationNotAppends('` + link.url + `')">${link.label}</a></li>`
      });
      html += '</ul>';
      $('#setLovAssetNumberPagination').html(html);
    }

    function searchLovAssetNumberPaginationNotAppends(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          success: function (response) {
            dataLovAssetNumber = response.data;
            if (response.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovAssetNumber").html('');
              $('#setLovAssetNumberPagination').html('');
            } else {
              setLovAssetNumberFn(response);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }

    function searchLovAssetNumberPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          data: {
            'p_asset_number':   $("#modalAssetNumberSearchAssetNumber").val(),
            'p_description':    $("#modalAssetNumberSearchDescription").val(),
            'p_serial_number':  $("#modalAssetNumberSearchSerialNumber").val(),
            'p_department':     dataOwningDepartment
          },
          success: function (response) {
            dataLovAssetNumber = response.data;
            if (response.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovAssetNumber").html('');
              $('#setLovAssetNumberPagination').html('');
            } else {
              setLovAssetNumberFn(response);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
    function setDataLovAssetNumber(data) {
      $("#detailAssetNumberLov").modal('hide');
      for (const row of dataLovAssetNumber) {
        if (row.asset_number == data) {
          if (thisLovAssetNumber != '') {
            if ($(thisLovAssetNumber).parents('div.input-group').find("select").find("option[value='" + row.asset_number + "']").length) {
              var newOptionAssetNumber = new Option(row.asset_number, row.asset_number, true, true);
              $(thisLovAssetNumber).parents('div.input-group').find("select").append(newOptionAssetNumber).trigger('change');
              $(thisLovAssetNumber).parents('div.input-group').find("select").val(row.asset_number).trigger('change');
            } else { 
              var newOption = new Option(row.asset_number, row.asset_number, true, true);
              $(thisLovAssetNumber).parents('div.input-group').find("select").append(newOption).trigger('change');
            } 
            $(thisLovAssetNumber).parents('div.input-group').find("select").trigger('change');
            $(thisLovAssetNumber).parents('div.input-group').find("select").val(row.asset_number);

            if (thisLovAssetNumberDesc == 'td:eq(2)') {
              $(thisLovAssetNumber).parents('tr').find("td:eq(2) input[type='text']").val(row.description);
            }
            if (thisLovAssetNumberArea == 'td:eq(5)') {
              $(thisLovAssetNumber).parents('tr').find("td:eq(5) input[type='text']").val(row.area_code);
            }
            if (thisLovAssetNumberDepartment == 'td:eq(4)') {
              var newOptionDepartment = new Option(row.department + ' - ' + row.department_description, row.department, true, true);
              $(thisLovAssetNumber).parents('tr').find("td:eq(4) select").append(newOptionDepartment).trigger('change');
              $(thisLovAssetNumber).parents('tr').find("td:eq(4) select").val(row.department).trigger('change');
            }
            changeDropDownActivityToDo({data1: row.asset_number, data2: thisLovAssetNumber})
            if ($("#statusPlan").val() == 'Confirm' && $("#eam0006").attr('id') === 'eam0006') {
              editConfirm = true
            }
          } else {
            if( $("#"+idLovAssetNumber).is('select')) {
              if ($('#' + idLovAssetNumber).find("option[value='" + row.asset_number + "']").length) {
                $('#' + idLovAssetNumber).val(row.asset_number).trigger('change');
              } else { 
                var newOption = new Option(row.asset_number + " : " + row.description , row.asset_number, true, true);
                $('#' + idLovAssetNumber).append(newOption).trigger('change');
              } 
              $("#"+idLovAssetNumber).trigger('change');
            } else {
            $("#"+idLovAssetNumber).val(row.asset_number);
            }
  
            if (reportAssetNumber) {
              $("#machineName").val(row.description)
              if ($("#eam0006").attr('id') != 'eam0006' && $("#eam0014").attr('id') != 'eam0014' && $("#eam0016").attr('id') != 'eam0016') {
                $("#machineGroup").val(row.asset_group_desc);
                asset_group_id = row.asset_group_id
              }
            }
            $("#"+idLovAssetNumber).addClass('x');

            if ($("#eam0007").attr('id') === 'eam0007' && idLovAssetNumber == 'assetNumber') {
              var newOptionReportingAgency = new Option(row.department + ' - ' + row.department_description, row.department, true, true);
              $('#reportingAgency').append(newOptionReportingAgency).trigger('change');
              $('#reportingAgency').val(row.department).trigger('change');

              var newOptionNotifyingAgency = new Option(row.department + ' - ' + row.department_description, row.department, true, true);
              $('#notifyingAgency').append(newOptionNotifyingAgency).trigger('change');
              $('#notifyingAgency').val(row.department).trigger('change');

              jpFlag = row.jp_flag
              if (row.jp_flag === 'Yes') {
                $("#workOrderType").val('2700').trigger('change');
                $("#quantityOfPartsProduced").attr('disabled', false);

                $.ajax({
                  url: "{{ route('eam.ajax.lov.departments') }}",
                  method: 'GET',
                  data: {
                    p_set_default: 'default'
                  },
                  success: function (response) {
                    if (response.data.length) {
                      dataLovDepartment = response.data[0];
                      var newOptionNotifyingAgency = new Option(dataLovDepartment.department_code + ' - ' + dataLovDepartment.description, 
                                                                dataLovDepartment.department_code, true, true);
                      $('#notifyingAgency').append(newOptionNotifyingAgency).trigger('change');
                      $('#notifyingAgency').val(dataLovDepartment.department_code).trigger('change');
                    }
                  }
                });
              } else if (row.jp_flag === 'No') {
                $("#workOrderType").val('2600').trigger('change');
                $("#quantityOfPartsProduced").attr('disabled', true);
              } else {
                if ($("#workOrderType").val() == '2700') {
                  $("#quantityOfPartsProduced").attr('disabled', false);
                } else {
                  $("#quantityOfPartsProduced").attr('disabled', true);
                }
              }

              if ($("#reportingAgency").val() != $("#notifyingAgency").val()) {
                $("#repairNotificationDate").prop('style', 'background-color:#d4d4d4')
                vmDatePicker.repairNotificationDate.disabled = true
              } else {
                $("#repairNotificationDate").prop('style', 'background-color:none')
                vmDatePicker.repairNotificationDate.disabled = false
              }
            } else if ($("#eam0010").attr('id') === 'eam0010' && idLovAssetNumber == 'assetNumber') {
              departmentCodeInAssetNumber = row.department
              $.ajax({
                url: "{{ route('eam.ajax.lov.wip-class') }}",
                data: {
                  'department_code': departmentCodeInAssetNumber
                },
                method: 'GET',
                success: function (response) {
                  if (response.data.data.length > 0) {
                    //Default class                  
                    var newOptionClass = new Option(response.data.data[0].class_code, response.data.data[0].class_code, true, true);
                    $('#class').append(newOptionClass).trigger('change');
                    $('#class').val(response.data.data[0].class_code).trigger('change');
                  } else {
                    $("#class").val('').trigger('change');
                  }
                },
                error: function (jqXHR, textStatus, errorRhrown) {
                  swal("Error", jqXHR.responseJSON.message, "error");
                }
              })
              if (row.jp_status === 'Yes') {
                jp_flag = 'Yes'
                $("#workReceiptType").val('300').trigger('change');
              } else if (row.jp_status === 'No') {
                jp_flag = 'No'
                $("#workReceiptType").val('100').trigger('change');
              } else {
                jp_flag = 'No'
              }
              changeDropDownActivityToDo({data1: row.asset_number, data2: thisLovAssetNumber, data3: 'eam0010'})
            } else if ($("#eam0006").attr('id') === 'eam0006' && idLovAssetNumber == 'assetNumber') {
              changeDropDownActivityToDo({data1: row.asset_number, data2: thisLovAssetNumber, data3: 'eam0006'})
            }
          }
          break
        }
      }
    }
    function setDataLovAssetNumberChildBtn(data) {
      $.ajax({
        url: "{{ route('eam.ajax.lov.child-asset-number',['']) }}/" + data,
        method: 'GET',
        success: function (response) {
          dataLovAssetNumberChild = response.data.data
          setLovAssetNumberFnChild(response.data);
       },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    function setLovAssetNumberFnChild(data) {
      $("#detailAssetNumberLovChild").modal('show');
      let theadLovAssetNumberChild = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovAssetNumberChild += `<tr>`
          theadLovAssetNumberChild += `<td style="cursor: pointer;" onclick="setDataLovAssetNumberChild('` + row.asset_number + `')">${row.asset_number ? row.asset_number : ''}</td>`
          theadLovAssetNumberChild += `<td style="cursor: pointer;" onclick="setDataLovAssetNumberChild('` + row.asset_number + `')">${row.description ? row.description : ''}</td>`
          theadLovAssetNumberChild += `</tr>`
        })
      }
      $("#setLovAssetNumberChild").html(theadLovAssetNumberChild);

      let html = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        html += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovAssetNumberChildPagination('` + link.url + `')">${link.label}</a></li>`
      });
      html += '</ul>';
      $('#setLovAssetNumberChildPagination').html(html);
    }
    function searchLovAssetNumberChildPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          success: function (response) {
            dataLovAssetNumberChild = response.data.data
            setLovAssetNumberFnChild(response.data);
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
    function setDataLovAssetNumberChild(data) {      
      $("#detailAssetNumberLov").modal('hide');
      $("#detailAssetNumberLovChild").modal('hide');
      for (const row of dataLovAssetNumberChild) {
        if (row.asset_number == data) {
          if (thisLovAssetNumber != '') {
            $(thisLovAssetNumber).parents('div.input-group').find("input[type='text']").val(row.asset_number);
            $(thisLovAssetNumber).parents('div.input-group').find("input[type='text']").addClass('x');
            if (thisLovAssetNumberDesc == 'td:eq(2)') {
              $(thisLovAssetNumber).parents('tr').find("td:eq(2) input[type='text']").val(row.description);
            }
            if (thisLovAssetNumberArea == 'td:eq(5)') {
              $(thisLovAssetNumber).parents('tr').find("td:eq(5) input[type='text']").val(row.area_code);
            }
            changeDropDownActivityToDo({data1: row.asset_number, data2: thisLovAssetNumber})
            if ($("#statusPlan").val() == 'Confirm' && $("#eam0006").attr('id') === 'eam0006') {
              editConfirm = true
            }
          } else {
            $("#"+idLovAssetNumber).val(row.asset_number);
            if (reportAssetNumber) {
              $("#machineName").val(row.description)
              if ($("#eam0006").attr('id') != 'eam0006' && $("#eam0014").attr('id') != 'eam0014' && $("#eam0016").attr('id') != 'eam0016') {
                $("#machineGroup").val(row.asset_group_desc);
                asset_group_id = row.asset_group_id
              }
            }
            $("#"+idLovAssetNumber).addClass('x');
            if ($("#eam0007").attr('id') === 'eam0007' && idLovAssetNumber == 'assetNumber') {
              $("#reportingAgency").val(row.department + ' - ' + row.department_description);
              $("#reportingAgency").addClass('x');
              $("#notifyingAgency").val(row.department + ' - ' + row.department_description);
              $("#notifyingAgency").addClass('x');
              jpFlag = row.jp_flag
              if (row.jp_flag === 'Yes') {
                $("#workOrderType").val('2700').trigger('change');
                $("#quantityOfPartsProduced").attr('disabled', false);
              } else if (row.jp_flag === 'No') {
                $("#workOrderType").val('2600');
                $("#quantityOfPartsProduced").attr('disabled', true);
              } else {
                if ($("#workOrderType").val() == '2700') {
                  $("#quantityOfPartsProduced").attr('disabled', false);
                } else {
                  $("#quantityOfPartsProduced").attr('disabled', true);
                }
              }
            } else if ($("#eam0010").attr('id') === 'eam0010' && idLovAssetNumber == 'assetNumber') {
              departmentCodeInAssetNumber = row.department
              $.ajax({
                url: "{{ route('eam.ajax.lov.wip-class') }}",
                data: {
                  'department_code': departmentCodeInAssetNumber
                },
                method: 'GET',
                success: function (response) {
                  if (response.data.data.length > 0) {
                    $("#class").val(response.data.data[0].class_code);
                    $("#class").addClass('x');
                  } else {
                    $("#class").val('');
                    $("#class").removeClass('x');
                  }
                },
                error: function (jqXHR, textStatus, errorRhrown) {
                  swal("Error", jqXHR.responseJSON.message, "error");
                }
              })
              if (row.jp_status === 'Yes') {
                jp_flag = 'Yes'
                $("#workReceiptType").val('300');
              } else if (row.jp_status === 'No') {
                jp_flag = 'No'
                $("#workReceiptType").val('100');
              } else {
                jp_flag = 'No'
              }
              changeDropDownActivityToDo({data1: row.asset_number, data2: thisLovAssetNumber, data3: 'eam0010'})
            } else if ($("#eam0006").attr('id') === 'eam0006' && idLovAssetNumber == 'assetNumber') {
              changeDropDownActivityToDo({data1: row.asset_number, data2: thisLovAssetNumber, data3: 'eam0006'})
            }
          }
          break
        }
      }
    }
    $("#detailAssetNumberLov").on('hidden.bs.modal', () => {
      if (!inModalAsset) {
        $('body').addClass('modal-open')
        inModalAsset = true
      }
    })
    $("#detailAssetNumberLovChild").on('hidden.bs.modal', () => {
      $('body').addClass('modal-open')
    })
    function clearDescAssetNumber(data) {
      data.parents('tr').find("td:eq(2) input[type='text']").val('');
      data.parents('tr').find("td:eq(3) select").html('')
      data.parents('tr').find("td:eq(5) input[type='text']").val('');
    }

    $("#modalAssetNumberSearchAssetNumber").on('keypress',function(e) {
      if(e.which == 13) {
        modalSearchAssetNumberLovClick()
      }
    });
    $("#modalAssetNumberSearchDescription").on('keypress',function(e) {
      if(e.which == 13) {
        modalSearchAssetNumberLovClick()
      }
    });
    $("#modalAssetNumberSearchSerialNumber").on('keypress',function(e) {
      if(e.which == 13) {
        modalSearchAssetNumberLovClick()
      }
    });

</script>
