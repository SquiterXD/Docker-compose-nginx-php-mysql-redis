@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <x-get-page-title menu="" url="/eam/setup/machine" />
@stop

@section('content')
@php $checkAttrId = 'machine' @endphp
<div id="eam0003" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11">
        <div class="text-right">
          <button id="assetVNumberLovBtn" 
                  class="mt-1 btn btn-default btn-lg size-btn">
            <i class="fa fa-search"></i> ค้นหา
          </button>
          <button id="undoBtn" 
                  class="mt-1 btn btn-default btn-lg size-btn">
            <i class="fa fa-undo"></i> ล้างค่า
          </button>
          <button id="createBtn" 
                  class="mt-1 btn btn-success btn-lg size-btn">
            สร้าง
          </button>
          <button id="saveBtn" 
                  class="mt-1 btn btn-primary btn-lg size-btn">
            บันทึก
          </button>          
        </div>
        <div class="text-right">
          <button id="fileBtn" 
                  class="mt-1 btn btn-success btn-lg size-btn"
                  disabled>
            แนบรูปภาพ
          </button>
        </div>
      </div>
      <div class="mt-4 col-11">
        <form onsubmit="formSaveBtnHide();return false;">
          @include('eam.setup._form')
          <button id="saveBtnHide" class="d-none" ></button>
        </form>
      </div>
    </div>
  </div>
  @include('eam.setup._modalLov')
</div>
@endsection
@section('scripts')
  <script>
    var defaultUser       = {!! json_encode($user, JSON_HEX_TAG) !!};
    var assetVNumber      = $(".assetVNumber").html()
    $(".assetVNumber").empty()
    var assetVNumberRead  = $(".assetVNumberRead").html()
  </script>
  @include('eam.commons.scripts.all-date');
  @include('eam.commons.scripts.clear-input');
  @include('eam.commons.scripts.drop-down-production-organization');
  @include('eam.commons.scripts.drop-down-usage-uom');
  @include('eam.commons.scripts.drop-down-resource-asset-locator');
  @include('eam.commons.scripts.drop-down-operation');
  @include('eam.commons.scripts.drop-down-machine-type');
  @include('eam.commons.scripts.drop-down-machine-group');
  @include('eam.commons.scripts.drop-down-status-yn');
  @include('eam.commons.scripts.drop-down-fa-asset');
  @include('eam.commons.scripts.lov-department');
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-resource-asset-number');
  @include('eam.commons.scripts.lov-asset-category');
  @include('eam.commons.scripts.lov-class');
  @include('eam.commons.scripts.lov-area');
  @include('eam.commons.scripts.loader');
  <script>
    $("#formAll").removeClass('d-none');
    var createStatus      = false;
    var webStatus         = 'CREATE';
    var assetId           = '';
    var dataImageFileOld  = '';
    $("#assetVNumber").addClass('readonly');

    readonly()
    loader('hide');
    function readonly () {
      $(".readonly").on("keydown paste focus mousedown", function(e) {
        if(e.keyCode != 9) {
          e.preventDefault();
        }
      });
    }
    setDatePicker({idDate: 'machineInstallDate', nameDate: '', onchange: false, date: '', disabled: true, required: true});

    function searchBtnClick(data) {
      if (data) {
        $.ajax({
          url: "{{ route('eam.ajax.resource-asset.show',['']) }}/" + data,
          method: 'GET',
          success: function (response) {
            setDataLovResourceAssetNumberResponse(response)
            webStatus = 'UPDATE';
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }

    $("#undoBtn").click(() => {
      $("#eamOganization").val('');
      $("#eamOganization").prop('disabled', true);
      $("#assetVNumber").val('').trigger('change');
      $("#assetVNumber").prop('disabled', false);
      $("#assetVNumberLovBtn").prop('disabled', false);
      $("#machineGroup").val('').trigger('change');
      $("#machineGroup").prop('disabled', true);
      $("#assetCategory").val('');
      $("#assetCategory").prop('disabled', true);
      $("#assetCategoryLovBtn").prop('disabled', true);
      $("#notifyingAgency").val('').trigger('change');
      $("#notifyingAgency").prop('disabled', true);
      $("#notifyingAgencyLovBtn").prop('disabled', true);
      $("#assetNumber").val('').trigger('change');
      $("#assetNumber").prop('disabled', true);
      $("#assetNumberLovBtn").prop('disabled', true);
      $("#productionOrganization").val('').trigger('change');
      $("#productionOrganization").prop('disabled', true);
      $("#resource").val('');
      $("#resource").prop('disabled', true);
      $("#usageUOMDropdown").val('').trigger('change');
      $("#usageUOMDropdown").prop('disabled', true);
      $("#usageUOMInput").val('');
      $("#usageUOMInput").prop('disabled', true);
      $("#workProcedure").val('').trigger('change');
      $("#workProcedure").prop('disabled', true);
      $("#machineSpeed").val('');
      $("#machineSpeed").prop('disabled', true);
      $("#wipStepIpDesc").val('');
      $("#wipStepIpDesc").prop('disabled', true);
      $("#active").prop('checked', false);
      $("#active").prop('disabled', true);
      $("#assetDescription").val('');
      $("#assetDescription").prop('disabled', true);
      $("#assetSerialNumber").val('');
      $("#assetSerialNumber").prop('disabled', true);
      $("#class").val('').trigger('change');
      $("#class").prop('disabled', true);
      $("#classLovBtn").prop('disabled', true);
      $("#area").val('').trigger('change');
      $("#area").prop('disabled', true);
      $("#areaLovBtn").prop('disabled', true);
      $("#jpStatus").val('').trigger('change');
      $("#jpStatus").prop('disabled', true);
      $("#description").val('');
      $("#description").prop('disabled', true);
      $("#resourceAssetLocator").val('');
      $("#resourceAssetLocator").prop('disabled', true);
      $("#machineType").val('').trigger('change');
      $("#machineType").prop('disabled', true);
      $("#faNumber").val('');
      $("#faNumber").prop('disabled', true);
      $("#faNumberBtn").prop('disabled', true);
      $("#performancePrecent").val('');
      $("#performancePrecent").prop('disabled', true);
      vmDatePicker.machineInstallDate.pValue = ''
      vmDatePicker.machineInstallDate.disabled = true
      $(".assetVNumberRead").empty()
      $(".assetVNumberRead").html(assetVNumberRead);
      assetId = '';
      readonly()
    })

    $("#createBtn").click(() => {
      if ($("#assetVNumber").val() === '') {
        createNew();
      } else {
        swal({
          title: "ต้องการสร้างข้อมูลใหม่",
          text: "",
          type: "warning",
          showCancelButton: true
        },
        function(){
          createNew(true);
        })
      }
    })

    $("#saveBtn").click(() => {
      $("#saveBtnHide").click();
    })

    function formSaveBtnHide() {
      loader('show');
      $.ajax({
        url: "{{ route('eam.ajax.resource-asset.store') }}",
        type: "POST",
        headers: {
          'Accept':         'application/json',
          'Content-Type':   'application/json',
          'X-CSRF-TOKEN':   "{{ csrf_token() }}"
        },
        data: JSON.stringify({
          'eam_organization':           $("#eamOganization").val(),
          'active_status':              $("#active").prop('checked') ? 'Y' : 'N',
          'asset_number':               $("#assetVNumber").val(),
          'asset_description':          $("#assetDescription").val(),
          'asset_group':                $("#machineGroup").val(),
          'asset_category':             $("#assetCategory").val(),
          'asset_serial_number':        $("#assetSerialNumber").val(),
          'owning_department':          $("#notifyingAgency").val().split(' - ')[0],
          'area':                       $("#area").val(),
          'wip_accounting_class':       $("#class").val(),
          'parent_asset_number':        $("#assetNumber").val(),
          'production_organization':    $("#productionOrganization").val(),
          'jp_status':                  $("#jpStatus").val(),
          'resource_code':              $("#resource").val(),
          'resource_description':       $("#description").val(),
          'usage_uom':                  $("#usageUOMDropdown").val(),
          'usage_uom_desc':             $("#usageUOMInput").val(),
          'locator':                    $("#resourceAssetLocator").val(),
          'work_procedure':             $("#workProcedure").val(),
          'machine_type':               $("#machineType").val(),
          'machine_speed':              $("#machineSpeed").val(),
          'performance_percent':        $("#performancePrecent").val(),
          'machine_installation_date':  $("#machineInstallDate").val(),
          'program_code':               'EAM0003',
          'fa_number':                  $("#faNumber").val() ? $("#faNumber").val().split(' : ')[0] : '',
          'web_status':                 webStatus
        }),
        success: function (response) {
          loader('hide');
          swal("Success", response.message, "success");
          setDataLovResourceAssetNumberResponse(response)
          webStatus = 'UPDATE';
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          loader('hide');
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }

    function createNew(data) {
      createStatus = true
      $(".assetVNumberRead").empty()
      $(".assetVNumberRead").html(assetVNumber);

      $("#machineGroup").prop('disabled', false);
      $("#assetSerialNumber").prop('disabled', false);
      $("#notifyingAgency").prop('disabled', false);
      $("#notifyingAgencyLovBtn").prop('disabled', false);
      $("#faNumber").prop('disabled', false);
      $("#assetDescription").prop('disabled', false);
      $("#assetCategory").prop('disabled', false);
      $("#assetCategoryLovBtn").prop('disabled', false);
      $("#assetCategoryLovBtn").prop('disabled', false);
      $("#class").prop('disabled', false);
      $("#assetNumber").prop('disabled', false);
      $("#area").prop('disabled', false);
      $("#productionOrganization").prop('disabled', false);
      $("#jpStatus").prop('disabled', false);
      $("#workProcedure").prop('disabled', false);
      $("#machineType").prop('disabled', false);
      $("#performancePrecent").prop('disabled', false);
      $("#machineSpeed").prop('disabled', false);
      $("#usageUOMDropdown").prop('disabled', true);
      $("#usageUOMInput").prop('disabled', true);
      $("#active").prop('disabled', false);
      $("#faNumberBtn").prop('disabled', false);
      
      $("#machineGroup").val('').trigger('change');
      $("#notifyingAgency").val('').trigger('change');
      $("#assetDescription").val('').trigger('change');
      $("#assetSerialNumber").val('').trigger('change');
      $("#area").val('').trigger('change');
      $("#jpStatus").val('').trigger('change');
      $("#usageUOMInput").val('').trigger('change');
      $("#assetCategory").val('').trigger('change');
      $("#assetNumber").val('').trigger('change');
      
      $("#productionOrganization").empty();
      $("#usageUOMDropdown").empty();
      $("#usageUOMInput").empty();

      $("#eamOganization").val('A21');
      $("#eamOganization").prop('disabled', true);

      $("#active").prop('checked', true);
      $("#active").val('Y');

      vmDatePicker.machineInstallDate.disabled = false
      vmDatePicker.machineInstallDate.pValue = '';

      changeProductOranizeClear(true)
      
      $("#assetVNumber").blur(() => {
        if ($("#productionOrganization").val()) {
          $("#resource").val($("#assetVNumber").val().replace(/-/g, '').substr(0,16));
        }
      });

      //Default Owning Department
      var newOptionOwningDepartment = new Option(defaultUser.department.display, defaultUser.department_code, true, true);
      $('#notifyingAgency').append(newOptionOwningDepartment).trigger('change');
      $('#notifyingAgency').val(defaultUser.department_code).trigger('change');
      
      dataDropDownProductOrganization.filter(row => {
        if (row.department_code == defaultUser.department_code) {

          //Default Production Organization
          var newOptionProductionOrganization = new Option(row.organization_code + ' - ' +row.name, row.organization_code, true, true);
          $('#productionOrganization').append(newOptionProductionOrganization).trigger('change');
          $('#productionOrganization').val(row.organization_code).trigger('change');

          if ($("#productionOrganization").val() !== '') {
              $("#resource").val($("#assetVNumber").val().replace(/-/g, '').substr(0,16));
            $("#description").val($("#assetDescription").val());
            let optionResourceAssetLocator = ''
            optionResourceAssetLocator += `<option value=""></option>`
            for (let data of dataResourceAssetLocator) {
              if (data.organization_code == $("#productionOrganization").val()) {
                optionResourceAssetLocator += `<option value="${data.locator_name}">${data.locator_name} - ${data.locator_description}</option>`
              }
            }
            $("#resourceAssetLocator").html(optionResourceAssetLocator);
            if ($("#usageUOMDropdown").val() == '') {
              $("#usageUOMDropdown").val('MIN').trigger('change');
            }
            $("#usageUOMInput").val(() => {
              for (const row of dataOptionUomCode) {
                if (row.uom_code == $("#usageUOMDropdown").val()) {
                  $("#usageUOMDropdown").val('MIN').trigger('change');
                  return row.uom_desc
                  break
                }
              }
            })
            changeProductOranizeClear(false)

            let optionOperation = ''
            optionOperation += `<option value=""></option>`
            for (let data of dataOptionOperation) {
              if (data.owner_organization == $("#productionOrganization").val()) {
                optionOperation += `<option value="${data.wip_id}">${data.wip_step} - ${data.wip_step_desc}</option>`
              }
            }
            $("#workProcedure").html(optionOperation);

            if ($("#workProcedure").val() != '') {
              let optionMachineType = ''
              optionMachineType += `<option value=""></option>`
              for (let data of dataOptionMachinType) {
                if (data.attribute1 == $("#workProcedure").val() && data.attribute2 == $("#productionOrganization").val()) {
                  optionMachineType += `<option value="${data.lookup_code}">${data.description}</option>`
                }
              }
              
              for (let data of dataOptionOperation) {
                if (data.wip_id == $("#workProcedure").val()) {
                  $("#wipStepIpDesc").val(data.process_qty_uom +" ("+ data.unit_of_measure + ")");
                }
              }
              $("#wipStepIpDesc").prop('disabled', true);

              $("#machineType").html(optionMachineType);
              $("#machineType").prop('disabled', false);
            } else {
              $("#machineType").html('');
              $("#machineType").prop('disabled', true);

              //bird1.1
              $("#wipStepIpDesc").val('');
              $("#machineType").prop('disabled', true);
            }
          } else {
            $("#resourceAssetLocator").html('');
            changeProductOranizeClear(true)
          }
        }
      })
    }

    function changeProductOranizeClear(data) {
      if (data){
        $("#resource").val('').trigger('change');
        $("#usageUOMDropdown").val('').trigger('change');
        $("#usageUOMInput").val('').trigger('change');
        $("#workProcedure").val('').trigger('change');
        $("#machineSpeed").val('').trigger('change');
        $("#wipStepIpDesc").val('').trigger('change');
        $("#description").val('').trigger('change');
        $("#resourceAssetLocator").val('').trigger('change');
        $("#machineType").val('').trigger('change');
        $("#performancePrecent").val('').trigger('change');
        $("#machineType").prop('disabled', true);
      }

      $("#resource").prop('disabled', $("#productionOrganization").val() ? false : true);
      $("#usageUOMDropdown").prop('disabled', data);
      $("#usageUOMInput").prop('disabled', true);
      $("#workProcedure").prop('disabled', data);
      $("#machineSpeed").prop('disabled', data);
      $("#wipStepIpDesc").prop('disabled', true);
      $("#description").prop('disabled', true);
      $("#resourceAssetLocator").prop('disabled', data);
      $("#performancePrecent").prop('disabled', data);

      if(data){
        document.getElementById("performancePrecent").style.backgroundColor = "#eeeeee";
        document.getElementById("machineSpeed").style.backgroundColor = "#eeeeee";
      }else{
        document.getElementById("performancePrecent").style.backgroundColor = "#ffff";
        document.getElementById("machineSpeed").style.backgroundColor = "#ffff";
      }
    }
    
    $("#productionOrganization").change(() => {
      if ($("#productionOrganization").val() !== '') {
        $("#resource").val($("#assetVNumber").val().replace(/-/g, '').substr(0,16));
        $("#description").val($("#assetDescription").val());
        let optionResourceAssetLocator = ''
        optionResourceAssetLocator += `<option value=""></option>`
        for (let data of dataResourceAssetLocator) {
          if (data.organization_code == $("#productionOrganization").val()) {
            optionResourceAssetLocator += `<option value="${data.locator_name}">${data.locator_name} - ${data.locator_description}</option>`
          }
        }
        $("#resourceAssetLocator").html(optionResourceAssetLocator);

        if ($("#usageUOMDropdown").val() == '') {
          $("#usageUOMDropdown").val('MIN').trigger('change');
        }

        $("#usageUOMInput").val(() => {
          for (const row of dataOptionUomCode) {
            if (row.uom_code == $("#usageUOMDropdown").val()) {
              return row.uom_desc
              break
            }
          }
        })

        changeProductOranizeClear(false)

        let optionOperation = ''
        optionOperation += `<option value=""></option>`
        for (let data of dataOptionOperation) {
          if (data.owner_organization == $("#productionOrganization").val()) {
            optionOperation += `<option value="${data.wip_id}">${data.wip_step} - ${data.wip_step_desc}</option>`
          }
        }
        $("#workProcedure").html(optionOperation);

        if ($("#workProcedure").val() != '') {
          let optionMachineType = ''
          optionMachineType += `<option value=""></option>`
          for (let data of dataOptionMachinType) {
            if (data.attribute1 == $("#workProcedure").val() && data.attribute2 == $("#productionOrganization").val()) {
              optionMachineType += `<option value="${data.lookup_code}">${data.description}</option>`
            }
          }
          for (let data of dataOptionOperation) {
            if (data.wip_id == $("#workProcedure").val()) {
              $("#wipStepIpDesc").val(data.process_qty_uom +" ("+ data.unit_of_measure + ")");
            }
          }
          $("#wipStepIpDesc").prop('disabled', true);

          $("#machineType").html(optionMachineType);
          $("#machineType").prop('disabled', false);
        } else {
          $("#machineType").html('');
          $("#machineType").prop('disabled', true);

          //bird2.2
          $("#wipStepIpDesc").val('');
          $("#wipStepIpDesc").prop('disabled', true);
        }
      } else {
        $("#resourceAssetLocator").html('');
        changeProductOranizeClear(true)
      }

      if($("#productionOrganization").val() == null){
        $("#resourceAssetLocator").html('');
        changeProductOranizeClear(true)
      }
    })

    $("#usageUOMDropdown").focus(() => {
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataOptionUomCode) {
        optionData += `<option value="${data.uom_code}">${data.uom_code} - ${data.uom_desc}</option>`
      }
      $("#usageUOMDropdown").html(optionData);
      $("#usageUOMDropdown").val('')
      $("#usageUOMInput").val('')
    })
    
    $("#usageUOMDropdown").change(() => {
      $("#usageUOMInput").val(() => {
        for (const row of dataOptionUomCode) {
          if (row.uom_code == $("#usageUOMDropdown").val()) {
            return row.uom_desc
            break
          }
        }
      })

      let val = $("#usageUOMDropdown").val()
      let optionData = ''
      optionData += `<option value=""></option>`
      for (let data of dataOptionUomCode) {
        optionData += `<option value="${data.uom_code}">${data.uom_code}</option>`
      }
      $("#usageUOMDropdown").html(optionData);
      $("#usageUOMDropdown").val(val)
      $("#usageUOMDropdown").blur();
    })

    $("#workProcedure").change(() => {
      if ($("#workProcedure").val() != '') {
        let optionMachineType = ''
        optionMachineType += `<option value=""></option>`
        for (let data of dataOptionMachinType) {
          if (data.attribute1 == $("#workProcedure").val() && data.attribute2 == $("#productionOrganization").val()) {
            optionMachineType += `<option value="${data.lookup_code}">${data.description}</option>`
          }
        }
        for (let data of dataOptionOperation) {
          if (data.wip_id == $("#workProcedure").val()) {
            $("#wipStepIpDesc").val(data.process_qty_uom +" ("+ data.unit_of_measure + ")");
          }
        }
        $("#wipStepIpDesc").prop('disabled', true);

        $("#machineType").html(optionMachineType);
        $("#machineType").prop('disabled', false);
      } else {
        $("#machineType").html('');
        $("#machineType").prop('disabled', true);
        
        // bird3.2
        $("#wipStepIpDesc").val('');
        $("#wipStepIpDesc").prop('disabled', true);
      }
    })
    
    function setDataLovResourceAssetNumberResponse(respone) {
      let data = respone.data
      assetId = data.asset_id;
      $("#eamOganization").val(data.eam_organization ? data.eam_organization : '');
      $("#assetVNumber").val(data.asset_number ? data.asset_number : '');
      $("#machineGroup").val(data.asset_group ? data.asset_group : '').trigger('change');
      $("#assetCategory").val(data.asset_category ? data.asset_category : '');
      data.asset_category ? $("#assetCategory").addClass('x') : ''

      //Default Owning Department
      var newOptionNotifyingAgency = new Option(data.owning_department + ' - ' +data.owning_department_desc, data.owning_department, true, true);
      $('#notifyingAgency').append(newOptionNotifyingAgency).trigger('change');
      $('#notifyingAgency').val(data.owning_department).trigger('change');

      //Default Parent Asset Number
      var newOptionParentAssetNumber = new Option(data.parent_asset_number, data.parent_asset_number, true, true);
      $('#assetNumber').append(newOptionParentAssetNumber).trigger('change');
      $('#assetNumber').val(data.parent_asset_number).trigger('change');

      //Default Production Organization
      var newOptionProductionOrganization = new Option((data.production_organization ? data.production_organization : ''), data.production_organization, true, true);
      $('#productionOrganization').append(newOptionProductionOrganization).trigger('change');
      $('#productionOrganization').val(data.production_organization).trigger('change');
      
      $("#resource").val(data.production_organization ? data.asset_number ? data.asset_number.replace(/-/g, '').substr(0,16) : '' : '');

      //Default Production Organization
      var newOptionUsageUOMDropdown = new Option((data.usage_uom ? data.usage_uom : ''), data.usage_uom, true, true);
      $('#usageUOMDropdown').append(newOptionUsageUOMDropdown).trigger('change');
      $('#usageUOMDropdown').val(data.usage_uom).trigger('change');
      
      $("#workProcedure").val(data.work_procedure ? data.work_procedure : '');
      $("#wipStepIpDesc").val(data.wip_process_qty_uom +" ("+ data.wip_unit_of_measure + ")");
      $("#machineSpeed").val(data.machine_speed ? data.machine_speed : '');
      $("#active").prop('checked', data.active_status == 'Y');
      $("#assetDescription").val(data.asset_description ? data.asset_description : '');
      $("#assetSerialNumber").val(data.asset_serial_number ? data.asset_serial_number : '');

      //Default WIP Accounting Class
      var newOptionClass = new Option(data.wip_accounting_class, data.wip_accounting_class, true, true);
      $('#class').append(newOptionClass).trigger('change');
      $('#class').val(data.wip_accounting_class).trigger('change');

      //Default Area
      var newOptionArea = new Option(data.area, data.area, true, true);
      $('#area').append(newOptionArea).trigger('change');
      $('#area').val(data.area ? data.area : '').trigger('change');

      $("#jpStatus").val(data.jp_status ? data.jp_status : '').trigger('change');
      vmDatePicker.machineInstallDate.disabled = false
      vmDatePicker.machineInstallDate.pValue = data.machine_installation_date ? data.machine_installation_date : '';
      $("#description").val(data.resource_description ? data.resource_description : '');
      $("#resourceAssetLocator").val(data.locator ? data.locator : '');
      $("#performancePrecent").val(data.performance_percent ? data.performance_percent : '');
      if (data.fa_number) {
        $.ajax({
          url: "{{ route('eam.ajax.lov.fa-asset') }}",
          method: 'GET',
          data: {
            'search_param': data.fa_number,
          },
          success: function (response) {
            response.data.filter(row => {
              if (row.asset_number == data.fa_number) {
                row.codeLov = row.asset_number
                row.descLov = row.description
                row.codeDescLov = row.asset_number + ' : ' + row.description
                dataDropDownFaAsset.push(row)
                $("#faNumber").val(data.fa_number ? data.fa_number + ' : ' + row.description : '');
              }
            })
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        }) 
      }
      $("input[type='checkbox']").prop('disabled', false);
      $("input[type='text']").prop('disabled', false);
      $("input[type='number']").prop('disabled', false);
      $("button[type='button']").prop('disabled', false);
      $("select").prop('disabled', false);
      $("#eamOganization").prop('disabled', true);
      $("#assetVNumber").prop('disabled', true);
      $("#assetVNumberLovBtn").prop('disabled', false);
      $("#machineGroup").prop('disabled', $("#productionOrganization").val() ? true : false);
      $("#wipStepIpDesc").prop('disabled', true);
      $("#description").prop('disabled', true);
      $("#productionOrganization").prop('disabled', $("#productionOrganization").val() ? true : false);
      $("#resource").prop('disabled', $("#productionOrganization").val() ? false : true);
      $("#usageUOMInput").prop('disabled', true);
      $("#assetSerialNumber").prop('disabled', true);
      data.parent_asset_number ? $("#assetNumber").prop('disabled', true) : ''
      data.parent_asset_number ? $("#assetNumberLovBtn").prop('disabled', true) : ''
      if (data.production_organization) {
        let optionResourceAssetLocator = ''
        optionResourceAssetLocator += `<option value=""></option>`
        for (let dataRe of dataResourceAssetLocator) {
          if (dataRe.organization_code == data.production_organization) {
            optionResourceAssetLocator += `<option value="${dataRe.locator_name}">${dataRe.locator_name} - ${dataRe.locator_description}</option>`
          }
        }
        $("#resourceAssetLocator").html(optionResourceAssetLocator);
        $("#resourceAssetLocator").val(data.locator ? data.locator : '');
      } else {
        changeProductOranizeClear(true)
      }
      if (data.work_procedure) {
        let optionMachineType = ''
        optionMachineType += `<option value=""></option>`
        for (let dataMa of dataOptionMachinType) {
          if (dataMa.attribute1 == data.work_procedure && dataMa.attribute2 == data.production_organization) {
            optionMachineType += `<option value="${dataMa.lookup_code}">${dataMa.description}</option>`
          }
        }
        $("#machineType").html(optionMachineType);
        $("#machineType").val(data.machine_type ? data.machine_type : '');
        $("#machineType").prop('disabled', false);
      } else {
        $("#machineType").html('');
        $("#machineType").prop('disabled', true);
      }

      if($("#assetVNumber").val()){
        $("#fileBtn").prop('disabled', false);
      }

      setTimeout(function(){ this.changeJPStatus(data.jp_status ? data.jp_status : '') }, 500);
    }

    function clearDataLovResourceAssetNumber() {
      if (createStatus) {
        createNew()
      } else {
        $("input[type='checkbox']").prop('checked', false);
        $("input[type='checkbox']").prop('disabled', true);
        $("input[type='text']").val('');
        $("input[type='text']").prop('disabled', true);
        $("input[type='number']").prop('disabled', true);
        $("button[type='button']").prop('disabled', true);
        $("select").val('');
        $("select").prop('disabled', true);
        $("#assetVNumber").prop('disabled', false);
        $("#assetVNumberLovBtn").prop('disabled', false);
      }
    }

    $("#assetDescription").blur(() => {
      if ($("#productionOrganization").val()) {
        $("#description").val($("#assetDescription").val());
      }
    });

    $('#class').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    function changeJPStatus(jpStatus = false) {
      if (!jpStatus) {
        jpStatus = $("#jpStatus").val();
      }

      if (jpStatus == 'Yes') {
        vmDatePicker.machineInstallDate.disabled = true;
        vmDatePicker.machineInstallDate.disabled = true;
        vmDatePicker.machineInstallDate.pValue = '';
      } else {
        vmDatePicker.machineInstallDate.disabled = false;
      }
    }

    $("#detailModalImageAdd").on('hidden.bs.modal', () => {
      $('body').addClass('modal-open')
    })

    $("#detailModalImageView").on('hidden.bs.modal', () => {
      $('body').addClass('modal-open')
    })

    $("#fileBtn").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.setup.images.index',['']) }}/" + assetId,
        method: 'GET',
        success: function (response) {
          $("#detailModalImage").modal('show');
          $("#modalImageSearchAssetNumber").prop('disabled', true);
          $("#modalImageSearchAssetDescription").prop('disabled', true);
          $("#modalImageSearchAssetNumber").val($("#assetVNumber").val());
          $("#modalImageSearchAssetDescription").val($("#assetDescription").val());
          setImageFileNewFn(response.data);
          $("#selectImageDelete").val('')
          // dataImageFile = response.data;
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })

    $("#addImageBtn").click(() => {
      $("#modalFile").val('');
      $('.custom-file-label').html('');
      $("#detailModalImageAdd").modal('show');
    })

    $("#modalModalImageAddBtn").click(() => {
      $('#detailModalImageAddForm').attr('action', "{{ route('eam.ajax.setup.images.upload',['']) }}/" + assetId)
      $("#programCode").val('EAM0003')
      $("#modalModalImageAddBtnHidden").click();
    })

    $('#detailModalImageAddForm').submit(function(evt) {
      evt.preventDefault();
      var formData = new FormData(this);
      if ($('#modalFile')[0].files[0].size > 5242880) {
        Swal.fire("Waring", "ไฟล์รูปภาพที่ท่านเลือกมีขนาดไฟล์เกิน 5 MB.", "error");
        return;
      }
      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {            
          swal({
            title: "Success",
            text: data.message,
            icon: "success",
          });

          $("#detailModalImageAdd").modal('hide');
          $.ajax({
            url: "{{ route('eam.ajax.setup.images.index',['']) }}/" + assetId,
            method: 'GET',
            success: function (response) {
              setImageFileNewFn(response.data);
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      });
    });

    function setImageFileNewFn(data) {
      let theadModalFile = ''
      if (data.length > 0) {
        _.each(data, function(item, index) {
          theadModalFile += `<div id="imageFile${item.attachment_id}" 
                                  class="card" 
                                  style=" display: inline-block; 
                                          width: 120px; 
                                          height: 120px; 
                                          position: relative; 
                                          overflow: hidden; 
                                          margin: 5px;">`
          theadModalFile += `<div style=" position: absolute; 
                                          z-index: 1; 
                                          background: #000; 
                                          top: 0; 
                                          cursor: zoom-in;" 
                                  onClick="setImageFile('` + item.attachment_id + `')">
                                  <img  src="{{route('eam.ajax.setup.images.show',[''])}}/${item.attachment_id}" 
                                        style="width: 100%;" />
                            </div>`
          theadModalFile += `<div style=" position: absolute; 
                                          z-index: 2; 
                                          top: 2px; 
                                          right: 2px;">
                                <button type="button" 
                                        class="btn btn-danger btn-sm deleteImageBtn" 
                                        style="padding: .15rem .3rem;" 
                                        onClick="deleteImageBtn(${item.attachment_id})">
                                  <i class="fa fa-times"></i>
                                </button>
                            </div>`
          theadModalFile += `</div>`
        });
      }
      $("#setModalFileNew").html(theadModalFile);
    }

    function setImageFile(data) {
      if (dataImageFileOld != '') {
        $('#imageFile'+dataImageFileOld).css("background-color", "#FFFFFF");
      }
      $('#imageFile'+data).css("background-color", "#f9f9f9");
      dataImageFileOld = data
      $("#selectImageDelete").val(data);

      $("#setShowImageFileFn").attr('src', `{{route('eam.ajax.setup.images.show',[''])}}/` + $("#selectImageDelete").val());
      $("#detailModalImageView").modal('show');
    }

    function deleteImageBtn(attachment_id) {
      swal({
        title: 'ต้องการลบรายการนี้หรือไม่!',
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
      },function() {
        if (attachment_id != '') {
          $.ajax({
            url: "{{ route('eam.ajax.setup.images.delete',['']) }}/" + attachment_id,
            method: 'DELETE',
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
            success: function (response) {
              swal("Success", response.message, "success");
              $.ajax({
                url: "{{ route('eam.ajax.setup.images.index',['']) }}/" + assetId,
                method: 'GET',
                success: function (response) {
                  dataImageFile = response.data;
                  setImageFileNewFn(response.data);
                  $("#selectImageDelete").val('')
                },
                error: function (jqXHR, textStatus, errorRhrown) {
                  swal("Error", jqXHR.responseJSON.message, "error");
                  $("#selectImageDelete").val('')
                }
              })
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        } else {
          swal("กรุณาเลือกรายการ", "", "warning");
        }
      })
    }
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection