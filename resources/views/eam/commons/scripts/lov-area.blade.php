
<script>
    var dataLovArea = []
    var idLovArea = ''
    var inModalArea = true
    function apiArea() {
      $.ajax({
        url: "{{ route('eam.ajax.lov.area') }}",
        method: 'GET',
        success: function (response) {
          $("#detailAreaLov").modal('show');
          $("#modalAreaSearchAreaCode").val('');
          $("#modalAreaSearchAreaName").val('');
          dataLovArea = response.data;
          setLovAreaFn(response);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    $("#areaLovBtn").click(() => {
      idLovArea = 'area'
      apiArea();
    })

    function areaBtnReportOnclick(data) {
      idLovArea = data
      inModalArea = false
      apiArea();
    }

    $("#modalSearchAreaLov").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.lov.area') }}",
        method: 'GET',
        data: {
          'p_code': $("#modalAreaSearchAreaCode").val(),
          'p_description': $("#modalAreaSearchAreaName").val()
        },
        success: function (response) {
          dataLovArea = response.data;
          if (response.data.length < 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setLovArea").html('');
            $('#setLovAreaPagination').html('');
          } else {
            setLovAreaFn(response);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })
    function setLovAreaFn(data) {
      let theadLovArea = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovArea += `<tr>`
          theadLovArea += `<td class="pointer" onclick="setDataLovArea('` + row.area + `')">${row.area ? row.area : ''}</td>`
          theadLovArea += `<td class="pointer" onclick="setDataLovArea('` + row.area + `')">${row.description ? row.description : ''}</td>`
          theadLovArea += `</tr>`
        })
      }
      $("#setLovArea").html(theadLovArea);

      let html = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        html += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovAreaPagination('` + link.url + `')">${link.label}</a></li>`
      });
      html += '</ul>';
      $('#setLovAreaPagination').html(html);
    }
    function searchLovAreaPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'GET',
          data: {
            'p_code': $("#modalAreaSearchAreaCode").val(),
            'p_description': $("#modalAreaSearchAreaName").val()
          },
          success: function (response) {
            dataLovArea = response.data;
            if (response.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovArea").html('');
              $('#setLovAreaPagination').html('');
            } else {
              setLovAreaFn(response);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }
    function setDataLovArea(data) {
      $("#detailAreaLov").modal('hide');
      for (const row of dataLovArea) {
        if (row.area == data) {
          $("#"+idLovArea).val(row.area);
          $("#"+idLovArea).addClass('x');

          if( $("#"+idLovArea).is('select')) {
            if ($('#' + idLovArea).find("option[value='" + row.area + "']").length) {
              $('#' + idLovArea).val(row.area).trigger('change');
            } else { 
                var newOption = new Option(row.area, row.area, true, true);
                $('#' + idLovArea).append(newOption).trigger('change');
            } 
            $("#"+idLovArea).trigger('change');
          } else {
            $("#"+idLovArea).val(row.area);
          }

          break
        }
      }
    }
    $("#detailAreaLov").on('hidden.bs.modal', () => {
      if (!inModalArea) {
        $('body').addClass('modal-open')
        inModalArea = true
      }
    })
</script>
