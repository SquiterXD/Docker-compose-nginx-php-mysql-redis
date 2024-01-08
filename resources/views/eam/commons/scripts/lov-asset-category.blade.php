
<script>
    var dataLovAssetCategory = {
      assetGroup: [],
      brand: [],
      machineType: [],
      series: []
    }
    var dataLovAssetSubGroup = []
    var dataLovSubMachineType = []
    var idLovAssetCategory = ''
    function lovAssetCategory() {
      $.ajax({
        url: "{{ route('eam.ajax.resource-asset.asset-category') }}",
        method: 'GET',
        success: function (response) {
          dataLovAssetCategory = response.data;
          setLovAssetCategoryFn(response.data);
          if ($("#assetCategory").val()) {
            let dataAssetCat = $("#assetCategory").val().split('.');
            $.ajax({
              url: "{{ route('eam.ajax.resource-asset.asset-category-subgroup') }}",
              method: 'GET',
              data: {
                p_parent_flex_value: dataAssetCat[0]
              },
              success: function (response) {
                dataLovAssetSubGroup = response.data
                let optionAssetSubGroup = ''
                optionAssetSubGroup += `<option value=""></option>`
                for (let data of response.data) {
                  optionAssetSubGroup += `<option value="${data.flex_value}">${data.flex_value}</option>`
                }
                $("#detailAssetCategoryLovAssetSubGroup").html(optionAssetSubGroup);
                $("#detailAssetCategoryLovAssetSubGroup").prop('disabled', false);
                checkValAssetCategory();
              },
              error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
              }
            })
            $.ajax({
              url: "{{ route('eam.ajax.resource-asset.asset-category-submachine') }}",
              method: 'GET',
              data: {
                p_parent_flex_value: dataAssetCat[3]
              },
              success: function (response) {
                dataLovSubMachineType = response.data
                let optionSubMachineType = ''
                optionSubMachineType += `<option value=""></option>`
                for (let data of response.data) {
                  optionSubMachineType += `<option value="${data.flex_value}">${data.flex_value}</option>`
                }
                $("#detailAssetCategoryLovSubMachineType").html(optionSubMachineType);
                $("#detailAssetCategoryLovSubMachineType").prop('disabled', false);
                checkValAssetCategory();
              },
              error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
              }
            })
          } else {
            checkValAssetCategory();
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    $("#assetCategoryLovBtn").click(() => {
      idLovAssetCategory = 'assetCategory'
      lovAssetCategory();
    })
    
    function checkValAssetCategory() {
      if ($("#assetCategory").val() != '') {
        let data = $("#assetCategory").val().split('.');
        $("#detailAssetCategoryLovAssetGroup").val(data[0]);
        $("#detailAssetCategoryLovAssetSubGroup").val(data[1]);
        $("#detailAssetCategoryLovBrand").val(data[2]);
        $("#detailAssetCategoryLovMachineType").val(data[3]);
        $("#detailAssetCategoryLovSeries").val(data[4]);
        $("#detailAssetCategoryLovSubMachineType").val(data[5]);
        dataLovAssetCategory.assetGroup.filter(row => {
          if (row.flex_value == $("#detailAssetCategoryLovAssetGroup").val()) {
            $("#detailAssetCategoryLovAssetGroupDesc").val(row.description);
          }
        })
        dataLovAssetCategory.brand.filter(row => {
          if (row.flex_value == $("#detailAssetCategoryLovBrand").val()) {
            $("#detailAssetCategoryLovBrandDesc").val(row.description);
          }
        })
        dataLovAssetCategory.machineType.filter(row => {
          if (row.flex_value == $("#detailAssetCategoryLovMachineType").val()) {
            $("#detailAssetCategoryLovMachineTypeDesc").val(row.description);
          }
        })
        dataLovAssetCategory.series.filter(row => {
          if (row.flex_value == $("#detailAssetCategoryLovSeries").val()) {
            $("#detailAssetCategoryLovSeriesDesc").val(row.description);
          }
        })
        dataLovAssetSubGroup.filter(row => {
          if (row.flex_value == $("#detailAssetCategoryLovAssetSubGroup").val()) {
            $("#detailAssetCategoryLovAssetSubGroupDesc").val(row.description);
          }
        })
        dataLovSubMachineType.filter(row => {
          if (row.flex_value == $("#detailAssetCategoryLovSubMachineType").val()) {
            $("#detailAssetCategoryLovSubMachineTypeDesc").val(row.description);
          }
        })
        $("#detailAssetCategoryLovAssetSubGroup").prop('disabled', false);
        $("#detailAssetCategoryLovSubMachineType").prop('disabled', false);
      } else {
        $("#detailAssetCategoryLovAssetSubGroup").prop('disabled', true);
        $("#detailAssetCategoryLovSubMachineType").prop('disabled', true);
        $("#detailAssetCategoryLovAssetGroupDesc").val('');
        $("#detailAssetCategoryLovBrandDesc").val('');
        $("#detailAssetCategoryLovMachineTypeDesc").val('');
        $("#detailAssetCategoryLovSeriesDesc").val('');
        $("#detailAssetCategoryLovAssetSubGroupDesc").val('');
        $("#detailAssetCategoryLovSubMachineTypeDesc").val('');
        $("#detailAssetCategoryLovAssetGroup").val('');
        $("#detailAssetCategoryLovAssetSubGroup").val('');
        $("#detailAssetCategoryLovBrand").val('');
        $("#detailAssetCategoryLovMachineType").val('');
        $("#detailAssetCategoryLovSeries").val('');
        $("#detailAssetCategoryLovSubMachineType").val('');
      }
      $("#detailAssetCategoryLovAssetGroupDesc").prop('disabled', true);
      $("#detailAssetCategoryLovAssetSubGroupDesc").prop('disabled', true);
      $("#detailAssetCategoryLovBrandDesc").prop('disabled', true);
      $("#detailAssetCategoryLovMachineTypeDesc").prop('disabled', true);
      $("#detailAssetCategoryLovSeriesDesc").prop('disabled', true);
      $("#detailAssetCategoryLovSubMachineTypeDesc").prop('disabled', true);
      $("#detailAssetCategoryLov").modal('show');
      setSelect2InEAM0003DetailAssetCategoryLov();
    }
    function setLovAssetCategoryFn(response) {
      let optionAssetGroup = ''
      optionAssetGroup += `<option value=""></option>`
      for (let data of response.assetGroup) {
        optionAssetGroup += `<option value="${data.flex_value}">${data.flex_value}</option>`
      }
      $("#detailAssetCategoryLovAssetGroup").html(optionAssetGroup);

      let optionBrand = ''
      optionBrand += `<option value=""></option>`
      for (let data of response.brand) {
        optionBrand += `<option value="${data.flex_value}">${data.flex_value}</option>`
      }
      $("#detailAssetCategoryLovBrand").html(optionBrand);

      let optionMachineType = ''
      optionMachineType += `<option value=""></option>`
      for (let data of response.machineType) {
        optionMachineType += `<option value="${data.flex_value}">${data.flex_value}</option>`
      }
      $("#detailAssetCategoryLovMachineType").html(optionMachineType);

      let optionSeries = ''
      optionSeries += `<option value=""></option>`
      for (let data of response.series) {
        optionSeries += `<option value="${data.flex_value}">${data.flex_value}</option>`
      }
      $("#detailAssetCategoryLovSeries").html(optionSeries);
    }

    $("#detailAssetCategoryLovAssetGroup").focus(() => {
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataLovAssetCategory.assetGroup) {
        optionData += `<option value="${data.flex_value}">${data.flex_value} - ${data.description}</option>`
      }
      $("#detailAssetCategoryLovAssetGroup").html(optionData);
      $("#detailAssetCategoryLovAssetGroup").val('')
      $("#detailAssetCategoryLovAssetGroupDesc").val('');
      $("#detailAssetCategoryLovAssetSubGroup").val('')
      $("#detailAssetCategoryLovAssetSubGroupDesc").val('');
      $("#detailAssetCategoryLovAssetSubGroup").prop('disabled', true);
    })
    $("#detailAssetCategoryLovAssetGroup").change(function() {
      if ($("#detailAssetCategoryLovAssetGroup").val() != '') {
        dataLovAssetCategory.assetGroup.filter(row => {
          if (row.flex_value == $("#detailAssetCategoryLovAssetGroup").val()) {
            $("#detailAssetCategoryLovAssetGroupDesc").val(row.description);
          }
        })
        $("#detailAssetCategoryLovAssetSubGroup").val('')
        $("#detailAssetCategoryLovAssetSubGroup").html('')
        $("#detailAssetCategoryLovAssetSubGroup").prop('disabled', true);
        $.ajax({
          url: "{{ route('eam.ajax.resource-asset.asset-category-subgroup') }}",
          method: 'GET',
          data: {
            p_parent_flex_value: $("#detailAssetCategoryLovAssetGroup").val()
          },
          success: function (response) {
            dataLovAssetSubGroup = response.data
            let optionAssetSubGroup = ''
            optionAssetSubGroup += `<option value=""></option>`
            for (let data of response.data) {
              optionAssetSubGroup += `<option value="${data.flex_value}">${data.flex_value} - ${data.description}</option>`
            }
            $("#detailAssetCategoryLovAssetSubGroup").html(optionAssetSubGroup);
            $("#detailAssetCategoryLovAssetSubGroup").prop('disabled', false);
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      } else {
        $("#detailAssetCategoryLovAssetSubGroup").val('')
        $("#detailAssetCategoryLovAssetGroupDesc").val('');
        $("#detailAssetCategoryLovAssetSubGroup").prop('disabled', true);
      }
      $("#detailAssetCategoryLovAssetSubGroupDesc").val('');

      let val = $("#detailAssetCategoryLovAssetGroup").val()
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataLovAssetCategory.assetGroup) {
        optionData += `<option value="${data.flex_value}">${data.flex_value}</option>`
      }
      $("#detailAssetCategoryLovAssetGroup").html(optionData);
      $("#detailAssetCategoryLovAssetGroup").val(val)
      $("#detailAssetCategoryLovAssetGroup").blur();
    })

    $("#detailAssetCategoryLovMachineType").focus(() => {
      let val = $("#detailAssetCategoryLovMachineType").val()
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataLovAssetCategory.machineType) {
        optionData += `<option value="${data.flex_value}">${data.flex_value} - ${data.description}</option>`
      }
      $("#detailAssetCategoryLovMachineType").html(optionData);
      $("#detailAssetCategoryLovMachineType").val('')
      $("#detailAssetCategoryLovMachineTypeDesc").val('');
      $("#detailAssetCategoryLovSubMachineType").val('')
      $("#detailAssetCategoryLovSubMachineTypeDesc").val('');
      $("#detailAssetCategoryLovSubMachineType").prop('disabled', true);
    })
    $("#detailAssetCategoryLovMachineType").change(function() {
      if ($("#detailAssetCategoryLovMachineType").val() != '') {
        let label = $(this).find("option:selected")[0].label;
        $($(this).find("option:selected")[0]).attr("label", label.substring(0, label.indexOf(' - ')));
        dataLovAssetCategory.machineType.filter(row => {
          if (row.flex_value == $("#detailAssetCategoryLovMachineType").val()) {
            $("#detailAssetCategoryLovMachineTypeDesc").val(row.description);
          }
        })
        $("#detailAssetCategoryLovSubMachineType").val('');
        $("#detailAssetCategoryLovSubMachineType").html('');
        $("#detailAssetCategoryLovSubMachineType").prop('disabled', true);
        $.ajax({
          url: "{{ route('eam.ajax.resource-asset.asset-category-submachine') }}",
          method: 'GET',
          data: {
            p_parent_flex_value: $("#detailAssetCategoryLovMachineType").val()
          },
          success: function (response) {
            dataLovSubMachineType = response.data
            let optionSubMachineType = ''
            optionSubMachineType += `<option value=""></option>`
            for (let data of response.data) {
              optionSubMachineType += `<option value="${data.flex_value}">${data.flex_value} - ${data.description}</option>`
            }
            $("#detailAssetCategoryLovSubMachineType").html(optionSubMachineType);
            $("#detailAssetCategoryLovSubMachineType").prop('disabled', false);
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      } else {
        $("#detailAssetCategoryLovSubMachineType").val('');
        $("#detailAssetCategoryLovMachineTypeDesc").val('');
        $("#detailAssetCategoryLovSubMachineType").prop('disabled', true);
      }
      $("#detailAssetCategoryLovSubMachineTypeDesc").val('')
    })

    $("#detailAssetCategoryLovBrand").focus(() => {
      let val = $("#detailAssetCategoryLovBrand").val()
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataLovAssetCategory.brand) {
        optionData += `<option value="${data.flex_value}">${data.flex_value} - ${data.description}</option>`
      }
      $("#detailAssetCategoryLovBrand").html(optionData);
      $("#detailAssetCategoryLovBrand").val('')
      $("#detailAssetCategoryLovBrandDesc").val('')
    })
    $("#detailAssetCategoryLovBrand").change(function() {
      if ($("#detailAssetCategoryLovBrand").val() != '') {
        let label = $(this).find("option:selected")[0].label;
        $($(this).find("option:selected")[0]).attr("label", label.substring(0, label.indexOf(' - ')));
        dataLovAssetCategory.brand.filter(row => {
          if (row.flex_value == $("#detailAssetCategoryLovBrand").val()) {
            $("#detailAssetCategoryLovBrandDesc").val(row.description);
          }
        })
      } else {
        $("#detailAssetCategoryLovBrandDesc").val('');
      }

      let val = $("#detailAssetCategoryLovBrand").val()
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataLovAssetCategory.brand) {
        optionData += `<option value="${data.flex_value}">${data.flex_value}</option>`
      }
      $("#detailAssetCategoryLovBrand").html(optionData);
      $("#detailAssetCategoryLovBrand").val(val)
      $("#detailAssetCategoryLovBrand").blur();
    })

    $("#detailAssetCategoryLovSeries").focus(() => {
      let val = $("#detailAssetCategoryLovSeries").val()
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataLovAssetCategory.series) {
        optionData += `<option value="${data.flex_value}">${data.flex_value} - ${data.description}</option>`
      }
      $("#detailAssetCategoryLovSeries").html(optionData);
      $("#detailAssetCategoryLovSeries").val('')
      $("#detailAssetCategoryLovSeriesDesc").val('')
    })
    $("#detailAssetCategoryLovSeries").change(function() {
      if ($("#detailAssetCategoryLovSeries").val() != '') {
        let label = $(this).find("option:selected")[0].label;
        $($(this).find("option:selected")[0]).attr("label", label.substring(0, label.indexOf(' - ')));
        dataLovAssetCategory.series.filter(row => {
          if (row.flex_value == $("#detailAssetCategoryLovSeries").val()) {
            $("#detailAssetCategoryLovSeriesDesc").val(row.description);
          }
        })
      } else {
        $("#detailAssetCategoryLovSeriesDesc").val('');
      }

      let val = $("#detailAssetCategoryLovSeries").val()
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataLovAssetCategory.series) {
        optionData += `<option value="${data.flex_value}">${data.flex_value}</option>`
      }
      $("#detailAssetCategoryLovSeries").html(optionData);
      $("#detailAssetCategoryLovSeries").val(val)
      $("#detailAssetCategoryLovSeries").blur();
    })

    $("#detailAssetCategoryLovAssetSubGroup").focus(() => {
      let val = $("#detailAssetCategoryLovAssetSubGroup").val()
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataLovAssetSubGroup) {
        optionData += `<option value="${data.flex_value}">${data.flex_value} - ${data.description}</option>`
      }
      $("#detailAssetCategoryLovAssetSubGroup").html(optionData);
      $("#detailAssetCategoryLovAssetSubGroup").val('')
      $("#detailAssetCategoryLovAssetSubGroupDesc").val('')
    })
    $("#detailAssetCategoryLovAssetSubGroup").change(function() {
      if ($("#detailAssetCategoryLovAssetSubGroup").val() != '') {
        let label = $(this).find("option:selected")[0].label;
        $($(this).find("option:selected")[0]).attr("label", label.substring(0, label.indexOf(' - ')));
        dataLovAssetSubGroup.filter(row => {
          if (row.flex_value == $("#detailAssetCategoryLovAssetSubGroup").val()) {
            $("#detailAssetCategoryLovAssetSubGroupDesc").val(row.description);
          }
        })
      } else {
        $("#detailAssetCategoryLovAssetSubGroupDesc").val('');
      }

      let val = $("#detailAssetCategoryLovAssetSubGroup").val()
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataLovAssetSubGroup) {
        optionData += `<option value="${data.flex_value}">${data.flex_value}</option>`
      }
      $("#detailAssetCategoryLovAssetSubGroup").html(optionData);
      $("#detailAssetCategoryLovAssetSubGroup").val(val)
      $("#detailAssetCategoryLovAssetSubGroup").blur();
    })

    $("#detailAssetCategoryLovSubMachineType").focus(() => {
      let val = $("#detailAssetCategoryLovSubMachineType").val()
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataLovSubMachineType) {
        optionData += `<option value="${data.flex_value}">${data.flex_value} - ${data.description}</option>`
      }
      $("#detailAssetCategoryLovSubMachineType").html(optionData);
      $("#detailAssetCategoryLovSubMachineType").val('')
      $("#detailAssetCategoryLovSubMachineTypeDesc").val('')
    })
    $("#detailAssetCategoryLovSubMachineType").change(function() {
      if ($("#detailAssetCategoryLovSubMachineType").val() != '') {
        let label = $(this).find("option:selected")[0].label;
        $($(this).find("option:selected")[0]).attr("label", label.substring(0, label.indexOf(' - ')));
        dataLovSubMachineType.filter(row => {
          if (row.flex_value == $("#detailAssetCategoryLovSubMachineType").val()) {
            $("#detailAssetCategoryLovSubMachineTypeDesc").val(row.description);
          }
        })
      } else {
        $("#detailAssetCategoryLovSubMachineTypeDesc").val('');
      }

      let val = $("#detailAssetCategoryLovSubMachineType").val()
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataLovSubMachineType) {
        optionData += `<option value="${data.flex_value}">${data.flex_value}</option>`
      }
      $("#detailAssetCategoryLovSubMachineType").html(optionData);
      $("#detailAssetCategoryLovSubMachineType").val(val)
      $("#detailAssetCategoryLovSubMachineType").blur();
    })
    $("#detailAssetCategoryLovConfirm").click(() => {
      $("#detailAssetCategoryLovConfirmHide").click();
    })
    function formDetailAssetCategoryLovConfirmHide() {
      $("#"+idLovAssetCategory).addClass('x');
      $("#"+idLovAssetCategory).val($("#detailAssetCategoryLovAssetGroup").val() + '.' + $("#detailAssetCategoryLovAssetSubGroup").val() + '.' + $("#detailAssetCategoryLovBrand").val() + '.' + $("#detailAssetCategoryLovMachineType").val() + '.' + $("#detailAssetCategoryLovSeries").val() + '.' + $("#detailAssetCategoryLovSubMachineType").val());
      $("#detailAssetCategoryLov").modal('hide');
    }
    function detailAssetCategoryLovCancle() {
      $("#detailAssetCategoryLovAssetGroup").val('');
      $("#detailAssetCategoryLovAssetGroupDesc").val('');
      $("#detailAssetCategoryLovAssetSubGroup").val('');
      $("#detailAssetCategoryLovAssetSubGroupDesc").val('');
      $("#detailAssetCategoryLovBrand").val('');
      $("#detailAssetCategoryLovBrandDesc").val('');
      $("#detailAssetCategoryLovMachineType").val('');
      $("#detailAssetCategoryLovMachineTypeDesc").val('');
      $("#detailAssetCategoryLovSeries").val('');
      $("#detailAssetCategoryLovSeriesDesc").val('');
      $("#detailAssetCategoryLovSubMachineType").val('');
      $("#detailAssetCategoryLovSubMachineTypeDesc").val('');
      $("#detailAssetCategoryLov").modal('hide');
    }
</script>

