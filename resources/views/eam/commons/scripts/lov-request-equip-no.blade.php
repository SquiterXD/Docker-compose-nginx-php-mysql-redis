
<script>
    var dataLovRequestEquipNo = []
    var idLovRequestEquipNo = ''
    var request_equip_h_id = ''
    $("#requestEquipNoLovBtn").click(() => {
      idLovRequestEquipNo = 'requestEquipNo'
      $.ajax({
        url: "{{ route('eam.ajax.lov.request-equip-no') }}",
        method: 'GET',
        success: function (response) {
          $("#detailRequestEquipNoLov").modal('show');
          $("#modalRequestEquipNoSearchCode").val('');
          dataLovRequestEquipNo = response.data.data;
          setLovRequestEquipNoFn(response.data);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })
    $("#modalSearchRequestEquipNoLov").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.lov.request-equip-no') }}",
        method: 'GET',
        data: {
          'p_request_equip_no': $("#modalRequestEquipNoSearchCode").val(),
        },
        success: function (response) {
          dataLovRequestEquipNo = response.data.data;
          if (response.data.data.length < 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setLovRequestEquipNo").html('');
            $('#setLovRequestEquipNoPagination').html('');
          } else {
            setLovRequestEquipNoFn(response.data);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })
    function setLovRequestEquipNoFn(data) {
      let theadLovRequestEquipNo = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovRequestEquipNo += `<tr>`
          theadLovRequestEquipNo += `<td class="pointer" onclick="setDataLovRequestEquipNo('` + row.request_equip_no + `')">${row.request_equip_no ? row.request_equip_no : ''}</td>`
          theadLovRequestEquipNo += `<td class="pointer" onclick="setDataLovRequestEquipNo('` + row.request_equip_no + `')">${row.request_status ? row.request_status : ''}</td>`
          theadLovRequestEquipNo += `</tr>`
        })
      }
      $("#setLovRequestEquipNo").html(theadLovRequestEquipNo);

      let html = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        html += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovRequestEquipNoPagination('` + link.url + `')">${link.label}</a></li>`
      });
      html += '</ul>';
      $('#setLovRequestEquipNoPagination').html(html);
    }
    function searchLovRequestEquipNoPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          data: {
            'p_request_equip_no': $("#modalRequestEquipNoSearchCode").val(),
          },
          success: function (response) {
            dataLovRequestEquipNo = response.data.data;
            if (response.data.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovRequestEquipNo").html('');
              $('#setLovRequestEquipNoPagination').html('');
            } else {
              setLovRequestEquipNoFn(response.data);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
    function setDataLovRequestEquipNo(data) {
      $("#detailRequestEquipNoLov").modal('hide');
      for (const row of dataLovRequestEquipNo) {
        if (row.request_equip_no == data) {
          if ($("#eam0017").attr('id') === 'eam0017' && idLovRequestEquipNo == 'requestEquipNo') {

            $("#"+idLovRequestEquipNo).val(row.request_equip_no);
            request_equip_h_id = row.request_equip_h_id
            $("#"+idLovRequestEquipNo).prop('disabled', true)
            $("#"+idLovRequestEquipNo+"LovBtn").prop('disabled', true)
            $("#requestStatus").prop('disabled', true)
            $("#requestStatus").val(row.request_status);
            $("#subinventory").val(row.to_subinventory);
            $("#saveBtn").prop('disabled', true)

            if (row.request_status) {
              $("#saveBtn").prop('disabled', false)
            }

            if (row.to_subinventory) {
              let optionLocator = ''
              optionLocator += `<option value=""></option>`
              for (let data of dataDropDownLocator) {
                if (data.subinventory_name == row.to_subinventory) {
                  optionLocator += `<option value="${data.locator_name}">${data.subinventory_name}.${data.locator_name}</option>`

                  //Default โอนไปยังคลัง
                  var newOptionSubinventory = new Option(row.to_subinventory, row.to_subinventory, true, true);
                  $('#subinventory').append(newOptionSubinventory).trigger('change');
                  $('#subinventory').val(row.to_subinventory).trigger('change');
                }
              }
              $('#locator').html(optionLocator)
              $("#locator").val(row.to_locator_code);
            } else {
              $('#locator').html('')
              $("#locator").val('');
            }

            //Default หน่วยงาน
            var newOptionRequestDepartment = new Option(row.department_code + ' - ' + row.department_desc, row.department_code, true, true);
            $('#requestDepartment').append(newOptionRequestDepartment).trigger('change');
            $('#requestDepartment').val(row.department_code).trigger('change');

            checkDisabledBtnComCan();

            if( $("#"+idLovRequestEquipNo).is('select')) {
              if ($('#' + idLovRequestEquipNo).find("option[value='" + row.request_equip_no + "']").length) {
                $('#' + idLovRequestEquipNo).val(row.request_equip_no).trigger('change');
              } else { 
                var newOption = new Option(row.request_equip_no , row.request_equip_no, true, true);
                $('#' + idLovRequestEquipNo).append(newOption).trigger('change');
              } 
              $("#"+idLovRequestEquipNo).trigger('change');
            } else {
              $("#"+idLovRequestEquipNo).val(row.request_equip_no);
            }

            callApiBillMaterials(row.request_equip_h_id)
            break;
          }
        }
      }
    }
    function completeBtnLovRequestEquipNo(data) {
      if (data != 'null' && data) {
        $.ajax({
          url: "{{ route('eam.ajax.lov.request-equip-no') }}",
          method: 'GET',
          data: {
            'p_request_equip_no': data,
          },
          success: function (response) {
            dataLovRequestEquipNo = response.data.data;
            idLovRequestEquipNo = 'requestEquipNo'
            setDataLovRequestEquipNo(data);
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
</script>

