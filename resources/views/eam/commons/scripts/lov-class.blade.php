
<script>
    var dataLovClass = []
    var idLovWipClass = ''
    var idLovWipClassDesc = ''
    var inModalClass = false
    var idLovWipClassTable = ''
    function lovWipClass() {
      $.ajax({
        url: "{{ route('eam.ajax.lov.wip-class') }}",
        data: {
          'department_code': departmentCodeInAssetNumber
        },
        method: 'GET',
        success: function (response) {
          $("#detailClassLov").modal('show');
          $("#modalClassSearchClassCode").val('');
          $("#modalClassSearchClassName").val('');
          dataLovClass = response.data.data;
          if ($("#eam0010").attr('id') === 'eam0010') {
            if (departmentCodeInAssetNumber) {
              setLovClassFn(response.data);
            } else {
              setLovClassFn({data: []});
            }
          } else {
            setLovClassFn(response.data);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    function wipClassLovBtnOnclick(data) {
      $("#nameWipClass").html(data.nameWipClassModal)
      idLovWipClass = data.idWipClassModal
      if (data.desc) {
        idLovWipClassDesc = data.idWipClassModal + 'Desc'
      } else {
        idLovWipClassDesc = ''
      }
      inModalClass = data.inModal
      idLovWipClassTable = ''
      lovWipClass();
    }
    $("#modalSearchClassLov").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.lov.wip-class') }}",
        method: 'GET',
        data: {
          'class_code': $("#modalClassSearchClassCode").val(),
          'description': $("#modalClassSearchClassName").val(),
          'department_code': departmentCodeInAssetNumber
        },
        success: function (response) {
          dataLovClass = response.data.data;
          if (response.data.data.length < 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setLovClass").html('');
            $('#setLovClassPagination').html('');
          } else {
            setLovClassFn(response.data);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })
    function setLovClassFn(data) {
      let theadLovClass = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovClass += `<tr>`
          theadLovClass += `<td class="pointer" onclick="setDataLovClass('` + row.class_code + `')">${row.class_code ? row.class_code : ''}</td>`
          theadLovClass += `<td class="pointer" onclick="setDataLovClass('` + row.class_code + `')">${row.description ? row.description : ''}</td>`
          theadLovClass += `</tr>`
        })
      }
      $("#setLovClass").html(theadLovClass);

      let html = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        html += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovClassPagination('` + link.url + `')">${link.label}</a></li>`
      });
      html += '</ul>';
      $('#setLovClassPagination').html(html);
    }
    function searchLovClassPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          data: {
            'class_code': $("#modalClassSearchClassCode").val(),
            'description': $("#modalClassSearchClassName").val()
          },
          success: function (response) {
            dataLovClass = response.data.data;
            if (response.data.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovClass").html('');
              $('#setLovClassPagination').html('');
            } else {
              setLovClassFn(response.data);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
    function setDataLovClass(data) {
      $("#detailClassLov").modal('hide');
      for (const row of dataLovClass) {
        if (row.class_code == data) {
          $("#"+idLovWipClass).val(row.class_code);
          $("#"+idLovWipClass).addClass('x');

          if($("#"+idLovWipClass).is('select')) {
            if ($('#' + idLovWipClass).find("option[value='" + row.class_code + "']").length) {
              $('#' + idLovWipClass).val(row.class_code).trigger('change');
            } else { 
              var newOption = new Option(row.class_code, row.class_code, true, true);
              $('#' + idLovWipClass).append(newOption).trigger('change');
            } 
            $("#"+idLovWipClass).trigger('change');
          } else {
            $("#"+idLovWipClass).val(row.class_code);
          }
          break
        }
      }
    }
    $("#detailClassLov").on('hidden.bs.modal', () => {
      if (inModalClass) {
        $('body').addClass('modal-open')
        inModalClass = false
      }
    })
</script>