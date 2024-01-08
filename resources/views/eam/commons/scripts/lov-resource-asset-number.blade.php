
<script>
    var dataLovAssetVNumber = []
    var idLovAssetVNumber = ''
    var reportAssetVNumber = true
    function lovAssetVNumber() {
      loader('show');
      $.ajax({
        url: "{{ route('eam.ajax.lov.asset-v-asset-number') }}",
        method: 'GET',
        success: function (response) {
          loader('hide');
          $("#detailAssetVNumberLov").modal('show');
          $("#modalAssetVNumberSearchAssetVNumber").val('');
          $("#modalAssetVNumberSearchDescription").val('');
          $("#modalAssetVNumberSearchSerialNumber").val('');
          dataLovAssetVNumber = response.data;
          setLovAssetVNumberFn(response);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          loader('hide');
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    $("#assetVNumberLovBtn").click(() => {
      idLovAssetVNumber = 'assetVNumber'
      reportAssetVNumber = true
      lovAssetVNumber()
    })
    $("#modalSearchAssetVNumberLov").click(() => {
      modalSearchAssetVNumberLovClick()
    })
    function modalSearchAssetVNumberLovClick() {
      loader('show');
      $.ajax({
        url: "{{ route('eam.ajax.lov.asset-v-asset-number') }}",
        method: 'GET',
        data: {
          'p_asset_number': $("#modalAssetVNumberSearchAssetVNumber").val(),
          'p_asset_description': $("#modalAssetVNumberSearchDescription").val(),
          'p_asset_serial_number': $("#modalAssetVNumberSearchSerialNumber").val()
        },
        success: function (response) {
          loader('hide');
          dataLovAssetVNumber = response.data;
          if (response.data.length < 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setLovAssetVNumber").html('');
            $('#setLovAssetVNumberPagination').html('');
          } else {
            setLovAssetVNumberFn(response);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          loader('hide');
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    function setLovAssetVNumberFn(data) {
      let theadLovAssetVNumber = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          theadLovAssetVNumber += `<tr>`
          theadLovAssetVNumber += `<td class="pointer" onclick="setDataLovAssetVNumber('` + row.asset_number + `')">${row.asset_number ? row.asset_number : ''}</td>`
          theadLovAssetVNumber += `<td class="pointer" onclick="setDataLovAssetVNumber('` + row.asset_number + `')">${row.asset_description ? row.asset_description : ''}</td>`
          theadLovAssetVNumber += `<td class="pointer" onclick="setDataLovAssetVNumber('` + row.asset_number + `')">${row.asset_serial_number ? row.asset_serial_number : ''}</td>`
          theadLovAssetVNumber += `<td class="pointer" onclick="setDataLovAssetVNumber('` + row.asset_number + `')">${row.parent_asset_number ? row.parent_asset_number : ''}</td>`
          theadLovAssetVNumber += `</tr>`
        })
      }
      $("#setLovAssetVNumber").html(theadLovAssetVNumber);

      let html = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        html += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovAssetVNumberPagination('` + link.url + `')">${link.label}</a></li>`
      });
      html += '</ul>';
      $('#setLovAssetVNumberPagination').html(html);
    }
    function searchLovAssetVNumberPagination(data) {
      if (data != 'null') {
        loader('show');
        $.ajax({
          url: data,
          method: 'GET',
          data: {
            'p_asset_number': $("#modalAssetVNumberSearchAssetVNumber").val(),
            'p_asset_description': $("#modalAssetVNumberSearchDescription").val(),
            'p_asset_serial_number': $("#modalAssetVNumberSearchSerialNumber").val()
          },
          success: function (response) {
            loader('hide');
            dataLovAssetVNumber = response.data;
            if (response.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setLovAssetVNumber").html('');
              $('#setLovAssetVNumberPagination').html('');
            } else {
              setLovAssetVNumberFn(response);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            loader('hide');
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }

    function setDataLovAssetVNumber(data) {
      $("#detailAssetVNumberLov").modal('hide');
      for (const row of dataLovAssetVNumber) {
        if (row.asset_number == data) {
          if ($("#eam0003").attr('id') === 'eam0003') {
            $("#assetVNumber").val(data);
            $("#fileBtn").prop('disabled', false);
            searchBtnClick(data)
            break
          }
        }
      }
    }

    $("#modalAssetVNumberSearchAssetVNumber").on('keypress',function(e) {
      if(e.which == 13) {
        modalSearchAssetVNumberLovClick()
      }
    });
    $("#modalAssetVNumberSearchDescription").on('keypress',function(e) {
      if(e.which == 13) {
        modalSearchAssetVNumberLovClick()
      }
    });
    $("#modalAssetVNumberSearchSerialNumber").on('keypress',function(e) {
      if(e.which == 13) {
        modalSearchAssetVNumberLovClick()
      }
    });
</script>
