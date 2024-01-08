
<script>
    var dataLovWorkReceiptNumber = []
    var idLovWorkReceiptNumber = ''
    var idLovWorkReceiptNumberDesc = ''
    var inModalWorkReceiptNumber = false
    var wip_entity_id = ''
    function lovWorkReceiptNumber() {
      $.ajax({
        url: "{{ route('eam.ajax.lov.work-order-h-id') }}",
        method: 'GET',
        success: function (response) {
          $("#detailWorkReceiptNumberLov").modal('show');
          $("#modalWorkReceiptNumberSearchWorkReceiptNumber").val('');
          dataLovWorkReceiptNumber = response.data.data;
          setLovWorkReceiptNumberFn(response.data);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    $("#workReceiptNumberLovBtn").click(() => {
      idLovWorkReceiptNumber = 'workReceiptNumber'
      lovWorkReceiptNumber();
    })
    function workReceiptNumberLovBtnOnclick(data) {
      $("#nameWorkReceiptNumber").html(data.nameWorkReceiptNumberModal)
      idLovWorkReceiptNumber = data.idWorkReceiptNumberModal
      if (data.desc) {
        idLovWorkReceiptNumberDesc = data.idWorkReceiptNumberModal + 'Desc'
      } else {
        idLovWorkReceiptNumberDesc = ''
      }
      inModalWorkReceiptNumber = data.inModal
      lovWorkReceiptNumber();
    }
    $("#modalSearchWorkReceiptNumberLov").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.lov.work-order-h-id') }}",
        method: 'GET',
        data: {
          'p_wip_entity_name': $("#modalWorkReceiptNumberSearchWorkReceiptNumber").val()
        },
        success: function (response) {
          dataLovWorkReceiptNumber = response.data.data;
          if (response.data.data.length < 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setLovWorkReceiptNumber").html('');
            $('#setLovWorkReceiptNumberPagination').html('');
          } else {
            setLovWorkReceiptNumberFn(response.data);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })
    function setLovWorkReceiptNumberFn(data) {
      let theadLovWorkReceiptNumber = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovWorkReceiptNumber += `<tr>`
          theadLovWorkReceiptNumber += `<td class="pointer" onclick="setDataLovWorkReceiptNumber('` + row.wip_entity_name + `')">${row.wip_entity_name ? row.wip_entity_name : ''}</td>`
          theadLovWorkReceiptNumber += `<td class="pointer" onclick="setDataLovWorkReceiptNumber('` + row.wip_entity_name + `')">${row.work_order_type_desc ? row.work_order_type_desc : ''}</td>`
          theadLovWorkReceiptNumber += `<td class="pointer" onclick="setDataLovWorkReceiptNumber('` + row.wip_entity_name + `')">${row.asset_desc ? row.asset_desc : ''}</td>`
          theadLovWorkReceiptNumber += `<td class="pointer" onclick="setDataLovWorkReceiptNumber('` + row.wip_entity_name + `')">${row.description ? row.description : ''}</td>`
          theadLovWorkReceiptNumber += `<td class="pointer" onclick="setDataLovWorkReceiptNumber('` + row.wip_entity_name + `')">${row.scheduled_start_date ? row.scheduled_start_date : ''}</td>`
          theadLovWorkReceiptNumber += `<td class="pointer" onclick="setDataLovWorkReceiptNumber('` + row.wip_entity_name + `')">${row.scheduled_completion_date ? row.scheduled_completion_date : ''}</td>`
          theadLovWorkReceiptNumber += `<td class="pointer" onclick="setDataLovWorkReceiptNumber('` + row.wip_entity_name + `')">${row.work_request_number ? row.work_request_number : ''}</td>`
          theadLovWorkReceiptNumber += `<td class="pointer text-center" onclick="setDataLovWorkReceiptNumber('` + row.wip_entity_name + `')"><input type="checkbox" style="filter: hue-rotate(270deg)" onClick="this.checked=!this.checked;" ${row.material_flag === 'Y' ? 'checked' : ''}></td>`
          theadLovWorkReceiptNumber += `<td class="pointer text-center" onclick="setDataLovWorkReceiptNumber('` + row.wip_entity_name + `')"><input type="checkbox" style="filter: hue-rotate(270deg)" onClick="this.checked=!this.checked;" ${row.labor_flag === 'Y' ? 'checked' : ''}></td>`
          theadLovWorkReceiptNumber += `<td class="pointer text-center" onclick="setDataLovWorkReceiptNumber('` + row.wip_entity_name + `')"><input type="checkbox" style="filter: hue-rotate(270deg)" onClick="this.checked=!this.checked;" ${row.complete_flag === 'Y' ? 'checked' : ''}></td>`
          theadLovWorkReceiptNumber += `</tr>`
        })
      }
      $("#setLovWorkReceiptNumber").html(theadLovWorkReceiptNumber);

      let html = '<ul class="pagination float-right" style="padding-top: 15px;">';
      $.each(data.links , function( i , link ){
        html += `<li class="footable-page ${link.active ? 'active' : ''}">
                  <a onclick="searchLovWorkReceiptNumberPagination('` + link.url + `')">
                    ${link.label}
                  </a>
                </li>`
      });
      html += '</ul>';
      $('#setLovWorkReceiptNumberPagination').html(html);
    }
    function searchLovWorkReceiptNumberPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          data: {
            'p_wip_entity_name': $("#modalWorkReceiptNumberSearchWorkReceiptNumber").val()
          },
          success: function (response) {
            dataLovWorkReceiptNumber = response.data.data;
            if (response.data.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovWorkReceiptNumber").html('');
              $('#setLovWorkReceiptNumberPagination').html('');
            } else {
              setLovWorkReceiptNumberFn(response.data);
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
    function setDataLovWorkReceiptNumber(data) {
      $("#detailWorkReceiptNumberLov").modal('hide');
      for (const row of dataLovWorkReceiptNumber) {
        if (row.wip_entity_name == data) {
          if ($("#eam0010").attr('id') === 'eam0010' && idLovWorkReceiptNumber == 'workReceiptNumber') {
            $.ajax({
              url: "{{ route('eam.ajax.work-order.head.show',['']) }}/" + data,
              method: 'GET',
              success: function (response) {
                clearAllTable();
                setDataLovWorkReceiptNumberResponse(response)
              },
              error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
              }
            })
            
            if($('#' + idLovWorkReceiptNumber).is('select')) {
              if ($('#' + idLovWorkReceiptNumber).find("option[value='" + row.wip_entity_name + "']").length) {
                  $('#' + idLovWorkReceiptNumber).val(row.wip_entity_name).trigger('change');
              } else { 
                  var newOption = new Option(row.wip_entity_name, row.wip_entity_name, true, true);
                  $('#' + idLovWorkReceiptNumber).append(newOption).trigger('change');
              } 

              $("#"+idLovWorkReceiptNumber).trigger('change');
            } else {
              $("#"+idLovWorkReceiptNumber).val(row.wip_entity_name);
            }

            break
          } else {
            if($('#' + idLovWorkReceiptNumber).is('select')) {
              if ($('#' + idLovWorkReceiptNumber).find("option[value='" + row.wip_entity_name + "']").length) {
                  $('#' + idLovWorkReceiptNumber).val(row.wip_entity_name).trigger('change');
              } else { 
                  var newOption = new Option(row.wip_entity_name, row.wip_entity_name, true, true);
                  $('#' + idLovWorkReceiptNumber).append(newOption).trigger('change');
              } 

              $("#"+idLovWorkReceiptNumber).trigger('change');
            } else {
              $("#"+idLovWorkReceiptNumber).val(row.wip_entity_name);
            }
            
            // $("#"+idLovWorkReceiptNumber).addClass('x');
            wip_entity_id = row.wip_entity_id
            break
          }
        } 
      }
    }
    $("#detailWorkReceiptNumberLov").on('hidden.bs.modal', () => {
      if (inModalWorkReceiptNumber) {
        $('body').addClass('modal-open')
        inModalWorkReceiptNumber = false
      }
    })
</script>