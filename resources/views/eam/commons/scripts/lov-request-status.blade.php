<script>
    var dataLovRequestStatus = []
    var idLovRequestStatus = ''
    var idLovRequestStatusTable = ''
    var idLovRequestStatusDesc = ''
    var thisRequestStatus = ''
    var inModalRequestStatus = false
    function lovRequestStatus() {
      $.ajax({
        url: "{{ route('eam.ajax.lov.request-status-list') }}",
        method: 'GET',
        success: function (response) {
          $("#detailRequestStatusLov").modal('show');
          dataLovRequestStatus = response.data;
          setLovRequestStatusFn(response);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    function requestStatusLovBtnOnclick(data) {
      $("#nameLovRequestStatus").html(data.nameModal)
      idLovRequestStatus = data.idModal
      if (data.desc) {
        idLovRequestStatusDesc = data.idModal + 'Desc'
      } else {
        idLovRequestStatusDesc = ''
      }
      inModalRequestStatus = data.inModal
      idLovRequestStatusTable = ''
      lovRequestStatus();
    }
    function requestStatusLovBtnTableOnclick(data) {
      $("#nameLovRequestStatus").html(data.nameModal)
      idLovRequestStatus = ''
      idLovRequestStatusDesc = ''
      inModalRequestStatus = false
      idLovRequestStatusTable = data.idModal
      lovRequestStatus();
    }
    function setLovRequestStatusFn(data) {
      let theadLovRequestStatus = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovRequestStatus += `<tr>`
          theadLovRequestStatus += `<td class="pointer" onclick="setDataLovRequestStatus('` + row.meaning + `')">${row.meaning ? row.meaning : ''}</td>`
          theadLovRequestStatus += `<td class="pointer" onclick="setDataLovRequestStatus('` + row.meaning + `')">${row.description ? row.description : ''}</td>`
          theadLovRequestStatus += `</tr>`
        })
      }
      $("#setLovRequestStatus").html(theadLovRequestStatus);

      let html = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        html += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovRequestStatusPagination('` + link.url + `')">${link.label}</a></li>`
      });
      html += '</ul>';
      $('#setLovRequestStatusPagination').html(html);
    }
    function searchLovRequestStatusPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          success: function (response) {
            dataLovRequestStatus = response.data;
            if (response.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovRequestStatus").html('');
              $('#setLovRequestStatusPagination').html('');
            } else {
              setLovRequestStatusFn(response);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
    function setDataLovRequestStatus(data) {
      $("#detailRequestStatusLov").modal('hide');
      for (const row of dataLovRequestStatus) {
        if (row.meaning == data) {
          if (idLovRequestStatusTable != '') {
            $(idLovRequestStatusTable).parents('div.input-group').find("input[type='text']").val(row.meaning + ' - ' + row.description);
            $(idLovRequestStatusTable).parents('div.input-group').find("input[type='text']").addClass('x');
            if ($("#statusPlan").val() == 'Confirm' && $("#eam0006").attr('id') === 'eam0006') {
              editConfirm = true
            }
          } else {
            if (idLovRequestStatusDesc) {
              $("#"+idLovRequestStatus).val(row.lookup_code+'.'+row.meaning);
              $("#"+idLovRequestStatusDesc).val(row.description);
            } else {
              $("#"+idLovRequestStatus).val(row.lookup_code+'.'+row.meaning + ' - ' + row.description);
              $("#"+idLovRequestStatusDesc).val(row.description);
            }
            $("#"+idLovRequestStatus).addClass('x');
          }

          if($("#"+idLovRequestStatus).is('select')) {
            if ($('#' + idLovRequestStatus).find("option[value='" + row.lookup_code + "']").length) {
              $('#' + idLovRequestStatus).val(row.lookup_code).trigger('change');
            } else { 
              var newOption = new Option(row.lookup_code + '. ' + row.meaning, row.lookup_code, true, true);
              $('#' + idLovRequestStatus).append(newOption).trigger('change');
            } 
            $("#"+idLovRequestStatus).trigger('change');
          } else {
            $("#"+idLovRequestStatus).val(row.lookup_code);
          }
          break
        }
      }
    }
    $("#detailRequestStatusLov").on('hidden.bs.modal', () => {
      if (inModalRequestStatus) {
        $('body').addClass('modal-open')
        inModalRequestStatus = false
      }
    })
</script>
