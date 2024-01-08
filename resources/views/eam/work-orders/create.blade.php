@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <x-get-page-title menu="" url="/eam/work-orders/create" />
@stop

@section('content')
@php $checkAttrId = 'formCreate' @endphp
<div id="eam0010" class="ibox eam">
  <div id="formAll" class="ibox-content">
    <div class="row">
      <div class="col-12">
        <div class="text-right">
          <button id="undoBtn" 
                  class="mt-1 btn btn-default btn-lg size-btn" 
                  role="button" 
                  aria-pressed="true">
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
          <button id="printBtn" 
                  class="mt-1 btn btn-info btn-lg size-btn">
            <i class="fa fa-print fa-lg"></i> พิมพ์รายงาน
          </button>
          <button id="cancleBtn" 
                  class="mt-1 btn btn-danger btn-lg size-btn" 
                  disabled>
            ยกเลิกปิดงาน
          </button>
        </div>
      </div>
      <div class="col-12">
        <div class="text-right">
          <button id="fileBtn" class="mt-1 btn btn-success btn-lg size-btn" disabled>
            รูปภาพ
          </button>
        </div>
      </div>
      <div class="mt-4 ml-5 col-11">
        <h4>หน้าหลัก</h4>
      </div>
      <div class="mt-4 ml-5 col-11">
        <form onsubmit="formSaveBtnHide();return false;">
          @include('eam.work-orders._form')
          <input type="hidden" id="repairHours">
          <button id="saveBtnHide" class="d-none" ></button>
        </form>
      </div>
<!--  op -->
      <div class="mt-5 ml-5 col-11">
        <h4>บันทึก Operation</h4>
      </div>
      <div id="btnOperation" class="col-12">
        <div class="text-right">
          <button id="saveOperationBtn" class="mt-1 btn btn-primary btn-lg size-btn" disabled>
            บันทึก
          </button>
          <button id="addOperationBtn" class="mt-1 btn btn-success btn-lg size-btn" disabled>
          <i class="fa fa-plus fa-lg"></i> เพิ่มรายการ
          </button>
          <button id="deleteOperationBtn" class="mt-1 btn btn-danger btn-lg size-btn" disabled>
            <i class="fa fa-times fa-lg"></i> ลบรายการ
          </button>
          <button id="resourceOperationBtn" class="mt-1 btn btn-primary btn-lg size-btn" disabled>
            Resource
          </button>
        </div>
      </div>
      <div class="ml-5 col-11" style="overflow-x:scroll;">
        <form onsubmit="formSaveOperationBtnHide();return false;">
          @include('eam.work-orders._tableOperation')
          <button id="saveOperationBtnHide" class="d-none" ></button>
        </form>
      </div>

<!--  re -->
      <div class="mt-5 ml-5 col-11">
        <h4>บันทึกกลุ่มช่าง 
          <i  id="btnHideGroupTechnicians" 
              class="fa fa-caret-down pointer" 
              aria-hidden="true">
          </i>
        </h4>
      </div>
      <div id="tableGroupTechnicians" style="display: none;" class="col-12">
        <div class="text-right">
          <button id="saveGroupTechniciansBtn" 
                  class="mt-1 btn btn-primary btn-lg size-btn" 
                  disabled>
            บันทึก
          </button>
          <button id="addGroupTechniciansBtn" 
                  class="mt-1 btn btn-success btn-lg size-btn" 
                  disabled>
            <i class="fa fa-plus fa-lg"></i> เพิ่มรายการ
          </button>
          <button id="deleteGroupTechniciansBtn" 
                  class="mt-1 btn btn-danger btn-lg size-btn" 
                  disabled>
            <i class="fa fa-times fa-lg"></i> ลบรายการ
          </button>
        </div>
      </div>
      <div  id="hideTbGroupTechnicians" 
            style="display: none; overflow-x:scroll;"
            class="ml-5 col-11">
        <form onsubmit="formSaveGroupTechniciansBtnHide();return false;">
          @include('eam.work-orders._tableGroupTechnicians')
          <button id="saveGroupTechniciansBtnHide" class="d-none" ></button>
        </form>
      </div>

<!--  mt -->
      <div class="mt-5 ml-5 col-11 d-inline">
        <h4>บันทึกอะไหล่</h4>
        <input  id="savePartBtnCheckBox" 
                type="checkbox" 
                style="margin-top: 2px;" 
                class="ml-1 form-check-input">
        <h4 class="ml-4"> ยืนยันการบันทึกอะไหล่เสร็จเรียบร้อย</h4>
      </div>
      <div id="btnSavePart" class="col-12">
        <div class="d-flex align-items-center" style="margin-left: 1.5rem;">
          <div class="ml-3 text-right"><h4 class="ml-4">บันทึกอะไหล่ Inventory Item</h4></div>
          <div class="text-right" style="margin-left: auto;">
            <button id="saveSavePartBtn" class="mt-1 btn btn-primary btn-lg size-btn" disabled>
              บันทึก
            </button>
            <button id="addSavePartBtn" class="mt-1 btn btn-success btn-lg size-btn" disabled>
            <i class="fa fa-plus fa-lg"></i> เพิ่มรายการ
            </button>
            <button id="deleteSavePartBtn" class="mt-1 btn btn-danger btn-lg size-btn" disabled>
              <i class="fa fa-times fa-lg"></i> ลบรายการ
            </button>
            <button id="resourceSavePartBtn" 
                    class="mt-1 btn btn-primary btn-lg size-btn" 
                    disabled>
              ตัดใช้อะไหล่
            </button>
          </div>
        </div>
      </div>
      <div class="ml-5 col-11" style="overflow-x:scroll;">
        <form onsubmit="formSaveSavePartBtnHide();return false;">
          @include('eam.work-orders._tableSavePart')
          <button id="saveSavePartBtnHide" class="d-none" ></button>
        </form>
      </div>

<!--  mt direct-->
      <div id="btnSavePart-non" class="mt-5 col-12">
        <div class="d-flex align-items-center" style="margin-left: 1.5rem;">
          <div class="ml-3 text-right"><h4 class="ml-4">บันทึกอะไหล่ Non-Stock Item</h4></div>
          <div class="text-right" style="margin-left: auto;">
            <button id="saveSavePartNonBtn" class="mt-1 btn btn-primary btn-lg size-btn" disabled>
              บันทึก
            </button>
            <button id="addSavePartNonBtn" class="mt-1 btn btn-success btn-lg size-btn" disabled>
            <i class="fa fa-plus fa-lg"></i> เพิ่มรายการ
            </button>
            <button id="deleteSavePartNonBtn" class="mt-1 btn btn-danger btn-lg size-btn" disabled>
              <i class="fa fa-times fa-lg"></i> ลบรายการ
            </button>
          </div>
        </div>
      </div>
      <div class="ml-5 col-11" style="overflow-x:scroll;">
        <form onsubmit="formSaveSavePartNonBtnHide();return false;">
          @include('eam.work-orders._tableSavePartNon')
          <button id="saveSavePartNonBtnHide" class="d-none" ></button>
        </form>
      </div>


<!--  lb -->
      <div class="mt-5 ml-5 col-11 d-inline">
        <h4>บันทึกค่าแรง</h4>
        <input id="saveCostCheckBox" type="checkbox" style="margin-top: 2px;" class="ml-1 form-check-input">
        <h4 class="ml-4"> ยืนยันการบันทึกค่าแรงเสร็จเรียบร้อย</h4>
      </div>
      <div id="btnSaveCost" class="col-12">
        <div class="d-flex" style="margin-left: 1.5rem;">
          <div class="text-right">
            <button id="sendDataSaveCostBtn" class="mt-1 btn btn-primary btn-lg" disabled>
              ส่งข้อมูลค่าแรงเข้าระบบ
            </button>
            <button id="undoDataSaveCostBtn" class="mt-1 btn btn-primary btn-lg" disabled>
              ยกเลิกข้อมูลค่าแรงเข้าระบบ
            </button>
          </div>
          <div class="text-right" style="margin-left: auto;">
            <button id="saveSaveCostBtn" class="mt-1 btn btn-primary btn-lg size-btn" disabled>
              บันทึก
            </button>
            <button id="addSaveCostBtn" class="mt-1 btn btn-success btn-lg size-btn" disabled>
            <i class="fa fa-plus fa-lg"></i> เพิ่มรายการ
            </button>
            <button id="deleteSaveCostBtn" class="mt-1 btn btn-danger btn-lg size-btn" disabled>
              <i class="fa fa-times fa-lg"></i> ลบรายการ
            </button>
          </div>
        </div>
      </div>
      <div class="ml-5 col-11" style="overflow-x:scroll;">
        <form onsubmit="formSaveSaveCostBtnHide();return false;">
          @include('eam.work-orders._tableSaveCost')
          <button id="saveSaveCostBtnHide" class="d-none" ></button>
        </form>
      </div>


<!--  cp -->
      <div id="btnSaveCost" class="mt-5 ml-4 col-12">
        <button id="viewCompeletBtn" class="mt-1 btn btn-primary btn-lg size-btn" disabled>
          View Cost
        </button>
        <button id="completeWorkOrderBtn" class="mt-1 btn btn-primary btn-lg" disabled>Complete Work Order</button>
      </div>
      <div class="mt-4 ml-5 col-11 d-inline">
        <h4>บันทึก Complete <input disabled id="checkedComplete" style="margin-top: 2px;" type="checkbox" class="ml-2 form-check-input"> <i id="btnHideComplete" style="margin-left: 2rem;" class="fa fa-caret-down pointer" aria-hidden="true"></i></h4>
      </div>
      <div id="btnSaveComplete" style="display: none;" class="col-12">
        <div class="text-right">
          <button id="saveCompleteBtn" class="mt-1 btn btn-primary btn-lg size-btn" disabled>
            บันทึก
          </button>
        </div>
      </div>
      <div id="hideTbComplete" style="display: none; overflow-x:scroll;" class="ml-5 col-11">
        <form onsubmit="formSaveCompleteBtnHide();return false;">
          @include('eam.work-orders._tableComplete')
          <button id="saveCompleteBtnHide" class="d-none" ></button>
        </form>
      </div>
      <div class="mt-5 ml-5 col-11 d-inline">
        <h4>Actual Costs <i id="btnHideViewComplete" class="fa fa-caret-down pointer" aria-hidden="true"></i></h4>
      </div>
      <div id="hideTbViewComplete" style="display: none; overflow-x:scroll;" class="mb-5 ml-5 col-11">
        @include('eam.work-orders._tableViewComplete')
      </div>
    </div>
  </div>
  @include('eam.work-orders._modalLov')
</div>
@endsection
@section('scripts')
<script>
  var wip_entity_id           = '';
  var organization_id         = '';
  var or_wip_entity_id        = '';
  var asset_group_id          = '';
  var owning_department       = '';
  var jp_flag                 = '';
  var statusDisabledOp        = false;
  var statusDisabledRe        = false;
  var statusDisabledMt        = false;
  var statusDisabledLb        = false;
  var statusDisabledPrNumber  = true;
  var statusDisabledBtnLB     = true;
</script>
  @include('eam.commons.scripts.lov-work-receipt-number');
  @include('eam.commons.scripts.all-date');
  @include('eam.commons.scripts.all-time');
  @include('eam.commons.scripts.clear-input');
  @include('eam.commons.scripts.drop-down-activities-to-do');
  @include('eam.commons.scripts.drop-down-importance');
  @include('eam.commons.scripts.drop-down-work-receipt-type');
  @include('eam.commons.scripts.drop-down-job-receipt-status');
  @include('eam.commons.scripts.drop-down-problems-encountered');
  @include('eam.commons.scripts.drop-down-stop-machine');
  @include('eam.commons.scripts.drop-down-work-order');
  @include('eam.commons.scripts.drop-down-item-type');
  @include('eam.commons.scripts.drop-down-locator');
  @include('eam.commons.scripts.drop-down-subinventory');
  @include('eam.commons.scripts.drop-down-technician-group-code');
  @include('eam.commons.scripts.drop-down-technician-group-order');
  @include('eam.commons.scripts.drop-down-wo-mt-lot');
  @include('eam.commons.scripts.drop-down-job-status');
  @include('eam.commons.scripts.drop-down-reson');
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-area');
  @include('eam.commons.scripts.lov-department');
  @include('eam.commons.scripts.lov-class');
  @include('eam.commons.scripts.lov-item-code');
  @include('eam.commons.scripts.lov-employee');
  @include('eam.commons.scripts.lov-resource-employee');
  @include('eam.commons.scripts.lov-department');
  @include('eam.commons.scripts.lov-employee-web-user');
  @include('eam.work-orders.work-order-op-t');
  @include('eam.work-orders.work-order-re-t');
  @include('eam.work-orders.work-order-mt-t');
  @include('eam.work-orders.work-order-mt-t-direct');
  @include('eam.work-orders.work-order-lb-t');
  @include('eam.work-orders.work-order-cp-t');
  @include('eam.work-orders.work-order-cost-v');
  @include('eam.commons.scripts.loader');

  <script>
    var dataIdWorkOrderID = {!! json_encode($workOrderId, JSON_HEX_TAG) !!};
    var dataDefault       = {!! json_encode($default, JSON_HEX_TAG) !!};
    var defaultUser       = {!! json_encode($user->toArray(), JSON_HEX_TAG) !!};
    var fnName            = {!! json_encode($fn, JSON_HEX_TAG) !!};

    function repairHours(timeStart, timeEnd) {
      if (typeof timeStart.getTime !== 'undefined' && typeof timeEnd.getTime !== 'undefined') {
        let diffInMilliseconds = (timeEnd.getTime() - timeStart.getTime()) / 1000;
        diffInMilliseconds /= (60 * 60)
        $("#repairHours").val(Math.abs(Math.round(diffInMilliseconds)));
      }
    }

    setDateTimePickerAll({idDate: 'repairDateStart', nameDate: '', onchange: false, ontrigger: function(date) {
      let repairDateStart = new Date(date);
      repairDateStart = (Number(repairDateStart.getFullYear())-543)+'/'+(`${repairDateStart.getMonth()+1}`.padStart(2, '0'))+'/'+`${repairDateStart.getDate()}`.padStart(2, '0')+' '+`${repairDateStart.getHours()}`.padStart(2, '0')+':'+`${repairDateStart.getMinutes()}`.padStart(2, '0')+':'+`${repairDateStart.getSeconds()}`.padStart(2, '0');

      const scheduled_completion_date = $("#repairDateEnd").val();
      const value_scheduled_completion_date_time = scheduled_completion_date.split(' ');
      const value_scheduled_completion_date = value_scheduled_completion_date_time[0].split('/');
      const value_scheduled_completion_time = value_scheduled_completion_date_time[1];
      const timeStart = new Date(repairDateStart);
      const timeEnd = new Date((parseInt(value_scheduled_completion_date[2])-543)+'/'+value_scheduled_completion_date[1]+'/'+value_scheduled_completion_date[0]+' '+value_scheduled_completion_time);

      repairHours(timeStart, timeEnd);

      const repairHoursVal = (Number($("#repairHours").val()) / $("#setTbodyTableGroupTechnicians tr").length).toFixed(2);
      $("#setTbodyTableGroupTechnicians tr").each(function() {
        $(this).find("td:eq(6) input[type='text']").val(repairHoursVal)
        $(this).find("td:eq(7) input[type='text']").val(1/repairHoursVal);
      });

    }, date: '', disabled: true, required: true, dateEndId: 'repairDateEnd'});

    setDateTimePickerAll({idDate: 'repairDateEnd', nameDate: '', onchange: false, ontrigger: function(date) {
      let repairDateEnd = new Date(date);
      repairDateEnd = (Number(repairDateEnd.getFullYear())-543)+'/'+(`${repairDateEnd.getMonth()+1}`.padStart(2, '0'))+'/'+`${repairDateEnd.getDate()}`.padStart(2, '0')+' '+`${repairDateEnd.getHours()}`.padStart(2, '0')+':'+`${repairDateEnd.getMinutes()}`.padStart(2, '0')+':'+`${repairDateEnd.getSeconds()}`.padStart(2, '0');

      const scheduled_start_date = $("#repairDateStart").val();
      const value_scheduled_start_date_time = scheduled_start_date.split(' ');
      const value_scheduled_start_date = value_scheduled_start_date_time[0].split('/');
      const value_scheduled_start_time = value_scheduled_start_date_time[1];
      const timeStart = new Date((parseInt(value_scheduled_start_date[2])-543)+'/'+value_scheduled_start_date[1]+'/'+value_scheduled_start_date[0]+' '+value_scheduled_start_time);
      const timeEnd = new Date(repairDateEnd);

      repairHours(timeStart, timeEnd);

      const repairHoursVal = (Number($("#repairHours").val()) / $("#setTbodyTableGroupTechnicians tr").length).toFixed(2);
      $("#setTbodyTableGroupTechnicians tr").each(function() {
        $(this).find("td:eq(6) input[type='text']").val(repairHoursVal)
        $(this).find("td:eq(7) input[type='text']").val(1/repairHoursVal);
      });
    }, date: '', disabled: true, required: true});

    setValueInput();
    loader('hide');

    $("#btnHideGroupTechnicians").click(function(){
      $("#tableGroupTechnicians").toggle(500);
      $("#hideTbGroupTechnicians").toggle(500);
      $("#btnHideGroupTechnicians").toggleClass("fa fa-caret-up fa fa-caret-down");
    });

    $("#btnHideComplete").click(function(){
      $("#hideTbComplete").toggle(500);
      $("#btnSaveComplete").toggle(500);
      $("#btnHideComplete").toggleClass("fa fa-caret-up fa fa-caret-down");
    });
    
    $("#btnHideViewComplete").click(function(){
      $("#hideTbViewComplete").toggle(500);
      $("#btnHideViewComplete").toggleClass("fa fa-caret-up fa fa-caret-down");
    });

    function setValueInput() {
      $("#workReceiptNumber").val('').trigger('change');
      $("#assetNumber").val('').trigger('change');
      $("#machineName").val('').trigger('change');
      $("#machineGroup").val('').trigger('change');
      $("#activitiesToDo").val('').trigger('change');
      $("#class").val('').trigger('change');
      $("#jobReceiptStatus").val('').trigger('change');
      $("#jobStatus").val('').trigger('change');
      $("#notifyingAgency").val('').trigger('change');
      $("#notifier").val('').trigger('change');
      $("#notifierId").val('').trigger('change');
      $("#referenceWorkReceipt").val(null).trigger('change');
      $("#workReceiptType").val('').trigger('change');
      $("#workReceiptDescription").val('').trigger('change');
      $("#problemsEncountered").val('').trigger('change');
      $("#importance").val('').trigger('change');
      vmDateTimePickerAll.repairDateStart.pValue = '';
      vmDateTimePickerAll.repairDateEnd.pValue = '';
      $("#stopMachine").val('').trigger('change');
      $("#workOrderNumber").val('').trigger('change');
      $("#savePartBtnCheckBox").prop('disabled', true);
      $("#checkboxAllTable").prop('disabled', true);
      $("#checkboxAllTableNon").prop('disabled', true);
      $("#saveCostCheckBox").prop('disabled', true);
      $("#checkboxAllTableSaveCost").prop('disabled', true);
    }

    readonly();
    function readonly() {
      $(".readonly").on("keydown paste focus mousedown", function(e) {
        if(e.keyCode != 9) {
          e.preventDefault();
        }
      });
    }

    $('#referenceWorkReceipt').select2({
      placeholder: '',
      theme: 'bootstrap4',
      minimumInputLength: 1,
      allowClear: true,
      ajax: {
        url: '/eam/ajax/lov/work-receipt-status',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          var query = {
            p_search: params.term
          }
          return query;
        },
        processResults: function (data) {
          var results = [];
          $.each(data.data, function (index, item) {
            results.push({
              id: item.wip_entity_name,
              text: item.name
            });
          });

          return {
          "results":results
          };
        },
        cache: true
      }
    });

    $("#undoBtn").click(() => {
      dataDropDownWorkOrder = [];
      $("#workReceiptNumber").val('').trigger('change');
      $("#workReceiptNumber").prop('disabled', false);
      $("#workReceiptNumberLovBtn").prop('disabled', false);
      $("#assetNumber").val('').trigger('change');
      $("#assetNumber").prop('disabled', true);
      $("#assetNumberLovBtn").prop('disabled', true);
      $("#machineName").val('').trigger('change');
      $("#machineName").prop('disabled', true);
      $("#machineGroup").val('').trigger('change');
      $("#machineGroup").prop('disabled', true);
      $("#activitiesToDo").val('').trigger('change');
      $("#activitiesToDo").prop('disabled', true);
      $("#class").val('').trigger('change');
      $("#class").prop('disabled', true);
      $("#classLovBtn").prop('disabled', true);
      $("#jobReceiptStatus").val('').trigger('change');
      $("#jobReceiptStatus").prop('disabled', true);
      $("#jobStatus").val('').trigger('change');
      $("#jobStatus").prop('disabled', true);
      $("#notifyingAgency").val('').trigger('change');
      $("#notifyingAgency").prop('disabled', true);
      $("#notifyingAgencyLovBtn").prop('disabled', true);
      $("#notifier").val('').trigger('change');
      $("#notifierId").val('').trigger('change');
      $("#notifier").prop('disabled', true);
      $("#notifierLovBtn").prop('disabled', true);
      $("#referenceWorkReceipt").val(null).trigger('change');
      $("#referenceWorkReceipt").prop('disabled', true);
      $("#workReceiptType").val('').trigger('change');
      $("#workReceiptType").prop('disabled', true);
      $("#workReceiptDescription").val('').trigger('change');
      $("#workReceiptDescription").prop('disabled', true);
      $("#problemsEncountered").val('').trigger('change');
      $("#problemsEncountered").prop('disabled', true);
      $("#importance").val('').trigger('change');
      $("#importance").prop('disabled', true);
      $("#stopMachine").val('').trigger('change');
      $("#stopMachine").prop('disabled', true);
      $("#workOrderNumber").val('').trigger('change');
      $("#workOrderNumber").prop('disabled', true);
      $("#fileBtn").prop('disabled', true);
      vmDateTimePickerAll.repairDateStart.pValue = ''
      vmDateTimePickerAll.repairDateStart.disabled = true
      vmDateTimePickerAll.repairDateEnd.pValue = ''
      vmDateTimePickerAll.repairDateEnd.disabled = true
      $("#checkboxAllTable").prop('checked', false);
      $("#savePartBtnCheckBox").prop('checked', false);
      $("#saveCostCheckBox").prop('checked', false);
      $("#checkedComplete").prop('checked', false);
      $("#createBtn").prop('disabled', false);
      $("#saveBtn").prop('disabled', false);
      $("#printBtn").prop('disabled', false);
      $("#cancleBtn").prop('disabled', true);
      $("#saveOperationBtn").prop('disabled', true);
      $("#addOperationBtn").prop('disabled', true);
      $("#deleteOperationBtn").prop('disabled', true);
      $("#resourceOperationBtn").prop('disabled', true);
      $("#saveGroupTechniciansBtn").prop('disabled', true);
      $("#addGroupTechniciansBtn").prop('disabled', true);
      $("#deleteGroupTechniciansBtn").prop('disabled', true);
      $("#saveSavePartBtn").prop('disabled', true);
      $("#saveSavePartNonBtn").prop('disabled', true);
      $("#addSavePartBtn").prop('disabled', true);
      $("#addSavePartNonBtn").prop('disabled', true);
      $("#deleteSavePartBtn").prop('disabled', true);
      $("#deleteSavePartNonBtn").prop('disabled', true);
      $("#resourceSavePartBtn").prop('disabled', true);
      $("#saveSaveCostBtn").prop('disabled', true);
      $("#addSaveCostBtn").prop('disabled', true);
      $("#deleteSaveCostBtn").prop('disabled', true);
      $("#viewCompeletBtn").prop('disabled', true);
      $("#completeWorkOrderBtn").prop('disabled', true);
      $("#saveCompleteBtn").prop('disabled', true);
      $("#setTbodyTableGroupTechnicians").html('').trigger('change');
      $("#setTbodyTableOperation").html('').trigger('change');
      $("#setTbodyTableSavePart").html('').trigger('change');
      $("#setTbodyTableSavePartNon").html('').trigger('change');
      $("#setTbodyTableSaveCost").html('').trigger('change');
      $("#setTbodyTableComplete").html('').trigger('change');
      $("#setTbodyTableViewComplete").html('').trigger('change');
      $("#completeWorkOrderBtn").text('Complete Work Order')
      $("#sendDataSaveCostBtn").prop('disabled', true);
      $("#undoDataSaveCostBtn").prop('disabled', true);
    })

    $("#modalReportWorkReceiptStatus").change(() => {
      $("#modalReportWorkReceiptStatusDesc").val($("#modalReportWorkReceiptStatus option:selected").text());
    })

    $("#modalReportWorkReceiptDateStart").change(() => {
      $("#modalReportWorkReceiptDateStartHide").val($("#modalReportWorkReceiptDateStart").val());
    })

    $("#modalReportWorkReceiptDateEnd").change(() => {
      $("#modalReportWorkReceiptDateEndHide").val($("#modalReportWorkReceiptDateEnd").val());
    })

    if (dataDefault) {
      if (fnName == 'request') {
        $.ajax({
          url: "{{ route('eam.ajax.work-requests.show',['']) }}/" + dataDefault,
          method: 'GET',
          success: function (response) {
            if (response.data.length < 1) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#workReceiptNumber").val('')
              clearDataLovWorkReceiptNumber()
            } else {
              clearDataLovWorkReceiptNumber()
              setDataWorkRequest(response.data)

              var classCode = $("#class").attr("name", "owning_dept_code");
              if (classCode.length) {
                var assetNumberVal = $("#assetNumber").val();
                var notifyingAgencyVal = $("#notifyingAgency").val();
                if (typeof assetNumberVal === 'string' && typeof notifyingAgencyVal === 'string') {
                  $.ajax({
                    url: "{{ route('eam.ajax.work-order.auto-class-EMP0007') }}",
                    method: 'GET',
                    data: {
                      'assetNumber': assetNumberVal,
                      'departmentCode': notifyingAgencyVal
                    },
                    success: function (response) {
                      //Default class
                      var newOptionClass = new Option(response.data.v_class_code, response.data.v_class_code, true, true);
                      $('#class').append(newOptionClass).trigger('change');
                      $("#class").val(response.data.v_class_code).trigger('change');
                    }
                  })
                }
              }
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      } else if (fnName == 'preventive') {
        $.ajax({
          url: "{{ route('eam.ajax.plan.search',['','/']) }}/" + dataDefault.split('/')[1] + '/' + dataDefault.split('/')[2],
          method: 'GET',
          data: {
            'asset_number':               $("#assetNumber").val(),
            'asset_group_id':             $("#machineGroup").val(),
            'asset_activity':             $("#activitiesToDo").val(),
            'owning_department_code':     $("#notifyingAgency").val() ? 
                                          $("#notifyingAgency").val() : '',
            'area':                       $("#area").val(),
            'scheduled_start_date':       $("#repairStartDate").val(),
            'scheduled_completion_date':  $("#repairEndDate").val(),
            'op_wo_status':               $("#repairOpenStatus").val()
          },
          success: function (response) {
            let data = response.data.lines.filter((row) => {
              if (row.wip_entity_name == dataDefault.split('/')[0]) {
                return row
              }
            })
            $.ajax({
              url: "{{ route('eam.ajax.work-order.head.show',['']) }}/" + dataDefault.split('/')[0],
              method: 'GET',
              success: function (response2) {
                setDataPlan(data[0],response2.data)
              },
              error: function (jqXHR, textStatus, errorThrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
              }
            })
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    } else {
      if (dataIdWorkOrderID) {
        $.ajax({
          url: "{{ route('eam.ajax.work-order.head.show',['']) }}/" + dataIdWorkOrderID,
          method: 'GET',
          success: function (response) {
            $(".clearable").removeClass('x onX');
            clearAllTable();
            setDataLovWorkReceiptNumberResponse(response)
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }

    $("#createBtn").click(() => {
      if ($("#workReceiptNumber").val() == '' && 
          $("#assetNumber").val() == '' && 
          $("#machineName").val() == '' && 
          $("#machineGroup").val() == '' && 
          $("#activitiesToDo").val() == '' && 
          $("#class").val() == '' && 
          $("#jobReceiptStatus").val() == '' && 
          $("#jobStatus").val() == '' && 
          $("#notifyingAgency").val() == '' && 
          $("#notifier").val() == '' && 
          $("#referenceWorkReceipt").val() == '' && 
          $("#workReceiptType").val() == '' && 
          $("#workReceiptDescription").val() == '' && 
          $("#problemsEncountered").val() == '' && 
          $("#importance").val() == '' && 
          $("#repairDateStart").val() == '' && 
          $("#repairDateEnd").val() == '' && 
          $("#stopMachine").val() == '' && 
          $("#workOrderNumber").val() == '') {
        createNew();
      } else {
        swal({
          title: "ต้องการสร้างข้อมูลใหม่",
          text: "",
          type: "warning",
          showCancelButton: true
        },
        function(){
          createNew();
        })
      }
    })

    $("#saveBtn").click(() => {
      $("#saveBtnHide").click();
    })

    function formSaveBtnHide() {
      swal({
        title: `\nคุณแน่ใจไหม?`, // new line is a workaround for icon cover text
        text: 'กรุณายืนยันการบันทึกข้อมูล',
        type: 'warning',
        dangerMode: true,
        showCancelButton: true,
        closeOnCancel: true,
        cancelButtonText: 'ยกเลิก',
        showConfirmButton: true,
        closeOnConfirm: true,
        confirmButtonText: 'ดำเนินการต่อ',
        allowClickOutside: true,
        closeOnClickOutside: true,
      },
      function(){
        $.ajax({
          url: "{{ route('eam.ajax.work-order.head.store') }}",
          type: "POST",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          data: JSON.stringify({
            'wip_entity_id':                wip_entity_id ? wip_entity_id : '',
            'wip_entity_name':              $("#workReceiptNumber option:selected").text() != '' ? 
                                            $("#workReceiptNumber option:selected").text() : '',
            'organization_id':              organization_id,
            'asset_number':                 $("#assetNumber").val(),
            'asset_desc':                   $("#machineName").val(),
            'asset_group_id':               asset_group_id,
            'asset_group_desc':             $("#machineGroup").val(),
            'asset_activity':               $("#activitiesToDo").val(),
            'class_code':                   $("#class").val(),
            'status_type':                  $("#jobReceiptStatus").val(),
            'status_desc':                  $("#jobReceiptStatus option:selected").text(),
            'attribute8':                   $("#jobStatus option:selected").text(),
            'owning_department':            owning_department,
            'owning_department_code':       $("#notifyingAgency").val().split(' - ')[0],
            'owning_department_desc':       $("#notifyingAgency option:selected").text().split(' - ')[1],
            'employee_id':                  $("#notifierId").val(),
            'employee_code':                $("#notifier").val().split(' - ')[0],
            'employee_desc':                $("#notifier option:selected").text().split(' - ')[1],
            'wo_reference':                 $("#referenceWorkReceipt").val() !== '' ? 
                                            $("#referenceWorkReceipt").val() : '',
            'work_order_type_id':           $("#workReceiptType").val(),
            'work_order_type_desc':         $("#workReceiptType option:selected").text(),
            'description':                  $("#workReceiptDescription").val(),
            'issue_id':                     $("#problemsEncountered").val(),
            'issue_desc':                   $("#problemsEncountered option:selected").text(),
            'work_request_priority_id':     $("#importance").val(),
            'work_request_priority_desc':   $("#importance option:selected").text(),
            'scheduled_start_date':         $("#repairDateStart").val(),
            'scheduled_completion_date':    $("#repairDateEnd").val(),
            'shutdown_type':                $("#stopMachine").val(),
            'shutdown_desc':                $("#stopMachine option:selected").text(),
            'work_request_number':          $("#workOrderNumber").val(),
            'program_code':                 'EAM0010',
            'material_flag':                $("#savePartBtnCheckBox").prop('checked') ? 'Y' : 'N',
            'labor_flag':                   $("#saveCostCheckBox").prop('checked') ? 'Y' : 'N',
            'complete_flag':                $("#checkedComplete").prop('checked') ? 'Y' : 'N',
            'jp_flag':                      jp_flag
          }),
          success: function (response) {
            swal("Success", response.message, "success");
            clearAllTable();
            setDataLovWorkReceiptNumberResponse(response);
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      })
    }

    function apiAllTable(params) {
      apiWorkerOrder();
      apiItemType();
      apiSubinventory();
      apiLocator();
      apiOperation();
      apiTechnicianGroupOrder('setTableSaveCost');
      workOrderMtAll(true);
      workOrderMtAllNon(true);
    }

    async function checkConfirmMt() {
      await $.ajax({
        url: "{{ route('eam.ajax.work-order.check-confirm-mt', ['']) }}/" + $("#workReceiptNumber").val(),
        method: 'GET',
        success: function (response) {
          if (response.data.is_material_flag) {
            $("#savePartBtnCheckBox").prop('checked', true).prop('disabled', false);
          } else {
            if(response.data.confirm_mt_success){
              $("#savePartBtnCheckBox").prop('disabled', true);
            }else{
              $("#savePartBtnCheckBox").prop('checked', false).prop('disabled', false);
            }
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }

    $("#printBtn").click(() => {
      $("#detailReportWorkReceipt").modal('show');
      $("#modalWReportWorkReceiptWorkReceiptStart").val($("#workReceiptNumber option:selected").text());
      $("#modalWReportWorkReceiptWorkReceiptEnd").val($("#workReceiptNumber option:selected").text());
      $("#modalReportWorkReceiptDateStart").val('');
      $("#modalReportWorkReceiptDateEnd").val('');
      $("#modalReportWorkReceiptAreaS").val('');
      $("#modalReportWorkReceiptAreaE").val('');
      $("#modalReportWorkReceiptAssetNumber").val('');
      $("#modalReportWorkReceiptStatus").val('');
      $("#modalReportWorkReceiptNotifyingAgency").val('');
      $("#modalReportWorkReceiptNotifyingAgencyDesc").val('');
      setSelect2InEAM0010Modal();
      triggerSelect2();
    })

    $("#modalReportWorkReceiptPrint").click(() => {
      if ($("#workReceiptType").val() == '300') {
        $('#detailReportWorkReceiptAction').attr('action', "{{ route('eam.ajax.work-order.report.part') }}")
      } else {
        $('#detailReportWorkReceiptAction').attr('action', "{{ route('eam.ajax.work-order.report') }}")
      }
      $("#printBtnHide").click();
    })

    $("#cancleBtn").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.work-order.head.unclose') }}",
        type: "POST",
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: JSON.stringify({
          'wip_entity_id':                wip_entity_id ? wip_entity_id : '',
          'wip_entity_name':              $("#workReceiptNumber option:selected").text() != '' ? $("#workReceiptNumber option:selected").text() : '',
          'organization_id':              organization_id,
          'asset_number':                 $("#assetNumber").val(),
          'asset_desc':                   $("#machineName").val(),
          'asset_group_id':               asset_group_id,
          'asset_group_desc':             $("#machineGroup").val(),
          'asset_activity':               $("#activitiesToDo").val(),
          'class_code':                   $("#class").val(),
          'status_type':                  $("#jobReceiptStatus").val(),
          'status_desc':                  $("#jobReceiptStatus option:selected").text(),
          'attribute8':                   $("#jobStatus option:selected").text(),
          'owning_department':            owning_department,
          'owning_department_code':       $("#notifyingAgency").val().split(' - ')[0],
          'owning_department_desc':       $("#notifyingAgency").val().split(' - ')[1],
          'employee_id':                  $("#notifierId").val(),
          'employee_code':                $("#notifier").val().split(' - ')[0],
          'employee_desc':                $("#notifier").val().split(' - ')[1],
          'wo_reference':                 $("#referenceWorkReceipt").val() !== '' ? 
                                          $("#referenceWorkReceipt").val() : '',
          'work_order_type_id':           $("#workReceiptType").val(),
          'work_order_type_desc':         $("#workReceiptType option:selected").text(),
          'description':                  $("#workReceiptDescription").val(),
          'issue_id':                     $("#problemsEncountered").val(),
          'issue_desc':                   $("#problemsEncountered option:selected").text(),
          'work_request_priority_id':     $("#importance").val(),
          'work_request_priority_desc':   $("#importance option:selected").text(),
          'scheduled_start_date':         $("#repairDateStart").val(),
          'scheduled_completion_date':    $("#repairDateEnd").val(),
          'shutdown_type':                $("#stopMachine").val(),
          'shutdown_desc':                $("#stopMachine option:selected").text(),
          'work_request_number':          $("#workOrderNumber").val(),
          'program_code':                 'EAM0010',
          'material_flag':                $("#savePartBtnCheckBox").prop('checked') ? 'Y' : 'N',
          'labor_flag':                   $("#saveCostCheckBox").prop('checked') ? 'Y' : 'N',
          'complete_flag':                $("#checkedComplete").prop('checked') ? 'Y' : 'N',
          'jp_flag':                      jp_flag
        }),
        success: function (response) {
          swal("Success", response.message, "success");
          $.ajax({
            url: "{{ route('eam.ajax.work-order.head.show',['']) }}/" + $("#workReceiptNumber").val(),
            method: 'GET',
            success: function (response2) {
              $(".clearable").removeClass('x onX');
              clearAllTable();
              setDataLovWorkReceiptNumberResponse(response2)
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })

    function createNew() {
      setValueInput();
      wip_entity_id               = '';
      wip_entity_id               = '';
      organization_id             = '';
      or_wip_entity_id            = '';
      asset_group_id              = '';
      owning_department           = '';
      departmentCodeInAssetNumber = '';
      jp_flag                     = '';
      $(".clearable").removeClass('x onX');
      $("#workReceiptNumber").attr('disabled', true);
      $("#workReceiptNumberLovBtn").attr('disabled', true);
      $("#assetNumber").attr('disabled', false);
      $("#assetNumberLovBtn").attr('disabled', false);
      $("#machineName").attr('disabled', true);
      $("#machineGroup").attr('disabled', true);
      $("#activitiesToDo").attr('disabled', false);
      $("#class").attr('disabled', false);
      $("#classLovBtn").attr('disabled', false);
      $("#jobReceiptStatus").attr('disabled', false);
      $("#jobReceiptStatus").html(dataLovWorkOrderStatus)
      $("#jobStatus").attr('disabled', false);
      $("#notifyingAgency").attr('disabled', false);
      $("#notifyingAgencyLovBtn").attr('disabled', false);
      $("#notifier").attr('disabled', false);
      $("#notifierLovBtn").attr('disabled', false);
      $("#referenceWorkReceipt").prop('disabled', false);
      $("#workReceiptType").attr('disabled', false);
      $("#workReceiptDescription").attr('disabled', false);
      $("#problemsEncountered").attr('disabled', false);
      $("#importance").attr('disabled', false);
      $("#stopMachine").attr('disabled', false);
      $("#workOrderNumber").attr('disabled', false);
      vmDateTimePickerAll.repairDateStart.disabled = false
      vmDateTimePickerAll.repairDateEnd.disabled = false
      vmDateTimePickerAll.repairDateStart.pDisabled = '';
      vmDateTimePickerAll.repairDateEnd.pDisabled = '';
      $("#undoBtn").attr('disabled', false);
      $("#saveBtn").attr('disabled', false);
      $("#printBtn").attr('disabled', false);
      $("#cancleBtn").attr('disabled', true);
      $("#fileBtn").prop('disabled', true);
      $("#sendDataSaveCostBtn").prop('disabled', true);
      $("#undoDataSaveCostBtn").prop('disabled', true);
      setDefault()
      clearAllTable();
    }
    
    function setDefault(params) {
      $("#jobReceiptStatus").val('1').trigger('change');
      $("#jobStatus").val('เปิดใบรับงาน').trigger('change');
      $("#importance").val('2').trigger('change');
      //Default ผู้รับแจ้ง
      var newOptionNotifier = new Option(defaultUser.username + ' - ' + defaultUser.name, defaultUser.username, true, true);
      $('#notifier').append(newOptionNotifier).trigger('change');
      $('#notifier').val(defaultUser.username).trigger('change');
      $("#notifierId").val(defaultUser.user_id);
    }

    function clearDataLovWorkReceiptNumber() {
      setValueInput();
      wip_entity_id = ''
      wip_entity_id = ''
      organization_id = ''
      or_wip_entity_id = ''
      asset_group_id = ''
      owning_department = ''
      departmentCodeInAssetNumber = ''
      jp_flag = ''
      $(".clearable").removeClass('x onX');
      $("#workReceiptNumber").attr('disabled', false);
      $("#workReceiptNumberLovBtn").attr('disabled', false);
      $("#assetNumber").attr('disabled', true);
      $("#assetNumberLovBtn").attr('disabled', true);
      $("#machineName").attr('disabled', true);
      $("#machineGroup").attr('disabled', true);
      $("#activitiesToDo").attr('disabled', true);
      $("#class").attr('disabled', true);
      $("#classLovBtn").attr('disabled', true);
      $("#jobReceiptStatus").html(dataLovWorkOrderStatus)
      $("#jobReceiptStatus").attr('disabled', true);
      $("#jobStatus").attr('disabled', true);
      $("#notifyingAgency").attr('disabled', true);
      $("#notifyingAgencyLovBtn").attr('disabled', true);
      $("#notifier").attr('disabled', true);
      $("#notifierLovBtn").attr('disabled', true);
      $("#referenceWorkReceipt").attr('disabled', true);
      $("#workReceiptType").attr('disabled', true);
      $("#workReceiptDescription").attr('disabled', true);
      $("#problemsEncountered").attr('disabled', true);
      $("#importance").attr('disabled', true);
      vmDateTimePickerAll.repairDateStart.disabled = true
      vmDateTimePickerAll.repairDateEnd.disabled = true
      $("#stopMachine").attr('disabled', true);
      $("#workOrderNumber").attr('disabled', true);
      $("#fileBtn").prop('disabled', true);
      $("#setTbodyTableOperation").html('');
      $("#setTbodyTableGroupTechnicians").html('');
      $("#setTbodyTableSavePart").html('');
      $("#setTbodyTableSavePartNon").html('');
      $("#setTbodyTableSaveCost").html('');
      $("#setTbodyTableViewComplete").html('');
      $("#setTbodyTableComplete").html('');
      $("#saveBtn").attr('disabled', false);
      $("#cancleBtn").attr('disabled', true);
      $("#saveOperationBtn").attr('disabled', true);
      $("#addOperationBtn").attr('disabled', true);
      $("#deleteOperationBtn").attr('disabled', true);
      $("#resourceOperationBtn").attr('disabled', true);
      $("#saveGroupTechniciansBtn").attr('disabled', true);
      $("#addGroupTechniciansBtn").attr('disabled', true);
      $("#saveSavePartBtn").attr('disabled', true);
      $("#saveSavePartNonBtn").attr('disabled', true);
      $("#addSavePartBtn").attr('disabled', true);
      $("#addSavePartNonBtn").attr('disabled', true);
      $("#deleteSavePartBtn").attr('disabled', true);
      $("#deleteSavePartNonBtn").attr('disabled', true);
      $("#resourceSavePartBtn").attr('disabled', true);
      $("#saveSaveCostBtn").attr('disabled', true);
      $("#addSaveCostBtn").attr('disabled', true);
      $("#deleteSaveCostBtn").attr('disabled', true);
      $("#viewCompeletBtn").attr('disabled', true);
      $("#completeWorkOrderBtn").attr('disabled', true);
      $("#saveCompleteBtn").attr('disabled', true);
      clearAllTable();
    }

    function setDataLovWorkReceiptNumberResponse(response) {
      if(response.data){
        changeDropDownActivityToDo({
          data1: response.data.asset_number, 
          data2: '', 
          data3: 'eam0010', 
          data4: response.data.asset_activity
        })
        statusDisabledMt = response.data.material_flag == 'N' ? false : true

        if (response.data.status_type == 7||
            response.data.status_type == 98||
            response.data.status_type == 99||
            response.data.status_type == 4||
            response.data.status_type == 5||
            response.data.status_type == 12) {
          statusDisabledMt = true
          $("#savePartBtnCheckBox").prop('disabled', true);
        }

        statusDisabledBtnLB = response.data.labor_flag == 'N' ? false : true
        $("#sendDataSaveCostBtn").prop('disabled', response.data.labor_flag == 'N' ? false : true);
        $("#undoDataSaveCostBtn").prop('disabled', response.data.labor_flag == 'N' ? false : true);

        wip_entity_id = response.data.wip_entity_id;
        organization_id = response.data.organization_id;
        or_wip_entity_id = response.data.or_wip_entity_id;
        asset_group_id = response.data.asset_group_id;
        owning_department = response.data.owning_department;
        departmentCodeInAssetNumber = response.data.department;
        jp_flag= response.data.jp_flag;

        //Default เลขที่ใบรับงาน
        var newOptionWorkReceiptNumber = new Option(response.data.wip_entity_name, response.data.wip_entity_id, true, true);
        $('#workReceiptNumber').append(newOptionWorkReceiptNumber).trigger('change');
        $('#workReceiptNumber').val(response.data.wip_entity_id ? response.data.wip_entity_id : '').trigger('change');

        //Default Asset Number
        var newOptionAssetNumber = new Option(response.data.asset_number, response.data.asset_number, true, true);
        $('#assetNumber').append(newOptionAssetNumber).trigger('change');
        $('#assetNumber').val(response.data.asset_number ? response.data.asset_number : '').trigger('change');

        $("#machineName").val(response.data.asset_desc ? response.data.asset_desc : '');
        $("#machineGroup").val(response.data.asset_group_desc ? response.data.asset_group_desc : '');

        //Default กิจกรรมที่ต้องทำ
        var newOptionActivitiesToDo = new Option(response.data.asset_activity, response.data.asset_activity, true, true);
        $('#activitiesToDo').append(newOptionActivitiesToDo).trigger('change');
        $('#activitiesToDo').val(response.data.asset_activity ? response.data.asset_activity : '').trigger('change');

        //Default class
        var newOptionClass = new Option(response.data.class_code, response.data.class_code, true, true);
        $('#class').append(newOptionClass).trigger('change');
        $('#class').val(response.data.class_code ? response.data.class_code : '').trigger('change');

        //Default หน่วยงานผู้รับแจ้ง
        var newOptionNotifyingAgency = new Option((response.data.owning_department_code ? response.data.owning_department_code + ' - ' : '') + 
                                                  (response.data.owning_department_desc ? response.data.owning_department_desc : ''), 
                                                   response.data.owning_department_code, true, true);
        $('#notifyingAgency').append(newOptionNotifyingAgency).trigger('change');
        $('#notifyingAgency').val(response.data.owning_department_code ? response.data.owning_department_code : '').trigger('change');

        //Default ผู้รับแจ้ง
        $("#notifierId").val(response.data.employee_id);
        var newOptionNotifier = new Option( (response.data.employee_code ? response.data.employee_code + ' - ' : '') + 
                                            (response.data.employee_desc ? response.data.employee_desc : ''), 
                                             response.data.employee_code, true, true);
        $('#notifier').append(newOptionNotifier).trigger('change');
        $('#notifier').val(response.data.employee_code ? response.data.employee_code : '').trigger('change');
        
        $("#referenceWorkReceipt").val('');
        $("#referenceWorkReceipt").val(null).trigger('change');
        var data = {
            id: response.data.wo_reference? response.data.wo_reference : '',
            text: response.data.wo_reference_name? response.data.wo_reference_name : ''
        };

        var $newOption = $("<option selected='selected'></option>").val(data.id).text(data.text)
        $("#referenceWorkReceipt").append($newOption).trigger('change');
        
        $("#workReceiptType").val(response.data.work_order_type_id == '0' ? '000' : response.data.work_order_type_id).trigger('change');
        $("#workReceiptDescription").val(response.data.description ? response.data.description : '');
        $("#problemsEncountered").val(response.data.issue_id ? response.data.issue_id : '').trigger('change');
        $("#importance").val(response.data.work_request_priority_id ? response.data.work_request_priority_id : '').trigger('change');
        vmDateTimePickerAll.repairDateStart.pValue = response.data.scheduled_start_date;
        vmDateTimePickerAll.repairDateEnd.pValue = response.data.scheduled_completion_date;
        vmDateTimePickerAll.repairDateEnd.pDisabled = response.data.scheduled_start_date;
        $("#stopMachine").val(response.data.shutdown_type ? response.data.shutdown_type : '').trigger('change');
        $("#workOrderNumber").val(response.data.work_request_number ? response.data.work_request_number : '').trigger('change');
        $("#jobReceiptStatus").html(dataLovWorkOrderStatus)
        $("#jobReceiptStatus").val(response.data.status_type ? response.data.status_type : '');
        $("#jobStatus").val(response.data.attribute8 ? response.data.attribute8 : '').trigger('change');
        $("#savePartBtnCheckBox").prop('checked', response.data.material_flag == 'Y');
        $("#saveCostCheckBox").prop('checked', response.data.labor_flag == 'Y');
        $("#checkedComplete").prop('checked', response.data.complete_flag == 'Y');

        const scheduled_start_date = response.data.scheduled_start_date;
        const value_scheduled_start_date_time = scheduled_start_date.split(' ');
        const value_scheduled_start_date = value_scheduled_start_date_time[0].split('/');
        const value_scheduled_start_time = value_scheduled_start_date_time[1];
        const scheduled_completion_date = response.data.scheduled_completion_date;
        const value_scheduled_completion_date_time = scheduled_completion_date.split(' ');
        const value_scheduled_completion_date = value_scheduled_completion_date_time[0].split('/');
        const value_scheduled_completion_time = value_scheduled_completion_date_time[1];
        const timeStart = new Date((parseInt(value_scheduled_start_date[2])-543)+'/'+value_scheduled_start_date[1]+'/'+value_scheduled_start_date[0]+' '+value_scheduled_start_time);
        const timeEnd = new Date((parseInt(value_scheduled_completion_date[2])-543)+'/'+value_scheduled_completion_date[1]+'/'+value_scheduled_completion_date[0]+' '+value_scheduled_completion_time);
        repairHours(timeStart, timeEnd);

        if ('1' == response.data.status_type || '17' == response.data.status_type) {
          $("#assetNumber").attr('disabled', false);
          $("#assetNumberLovBtn").attr('disabled', false);
          $("#activitiesToDo").attr('disabled', false);
          $("#class").attr('disabled', false);
          $("#classLovBtn").attr('disabled', false);
          $("#jobReceiptStatus").attr('disabled', false);
          $("#jobStatus").attr('disabled', false);
          $("#notifyingAgency").attr('disabled', false);
          $("#notifyingAgencyLovBtn").attr('disabled', false);
          $("#notifier").attr('disabled', false);
          $("#notifierLovBtn").attr('disabled', false);
          $("#referenceWorkReceipt").attr('disabled', false);
          $("#workReceiptType").attr('disabled', false);
          $("#workReceiptDescription").attr('disabled', false);
          $("#problemsEncountered").attr('disabled', false);
          $("#importance").attr('disabled', false);
          vmDateTimePickerAll.repairDateStart.disabled = false
          vmDateTimePickerAll.repairDateEnd.disabled = false
          $("#stopMachine").attr('disabled', false);
          response.data.asset_number ? $("#assetNumber").addClass('x') : ''
          response.data.class_code ? $("#class").addClass('x') : ''
          response.data.owning_department_code ? $("#notifyingAgency").addClass('x') : ''
          response.data.employee_code ? $("#notifier").addClass('x') : ''
        } else if ('3' == response.data.status_type || '6' == response.data.status_type) {
          $("#jobReceiptStatus").attr('disabled', false);
          $("#jobStatus").attr('disabled', false);
          $("#notifyingAgency").attr('disabled', false);
          $("#notifyingAgencyLovBtn").attr('disabled', false);
          $("#notifier").attr('disabled', false);
          $("#notifierLovBtn").attr('disabled', false);
          $("#referenceWorkReceipt").attr('disabled', false);
          $("#workReceiptType").attr('disabled', false);
          $("#workReceiptDescription").attr('disabled', false);
          $("#problemsEncountered").attr('disabled', false);
          $("#importance").attr('disabled', false);
          vmDateTimePickerAll.repairDateStart.disabled = false
          vmDateTimePickerAll.repairDateEnd.disabled = false
          $("#stopMachine").attr('disabled', false);
        } else {
          $("#jobReceiptStatus").html(`<option value="${response.data.status_type}">${response.data.status_desc}</option>`)
          $("#jobReceiptStatus").val(response.data.status_type ? response.data.status_type : '');
          $("#assetNumber").attr('disabled', true);
          $("#assetNumberLovBtn").attr('disabled', true);
          $("#activitiesToDo").attr('disabled', true);
          $("#class").attr('disabled', true);
          $("#classLovBtn").attr('disabled', true);
          $("#jobReceiptStatus").attr('disabled', true);
          $("#jobStatus").attr('disabled', true);
          $("#notifyingAgency").attr('disabled', true);
          $("#notifyingAgencyLovBtn").attr('disabled', true);
          $("#notifier").attr('disabled', true);
          $("#notifierLovBtn").attr('disabled', true);
          $("#referenceWorkReceipt").attr('disabled', true);
          $("#workReceiptType").attr('disabled', true);
          $("#workReceiptDescription").attr('disabled', true);
          $("#problemsEncountered").attr('disabled', true);
          $("#importance").attr('disabled', true);
          vmDateTimePickerAll.repairDateStart.disabled = true
          vmDateTimePickerAll.repairDateEnd.disabled = true
          $("#stopMachine").attr('disabled', true);

          if('15' == response.data.status_type){
            $("#jobReceiptStatus").attr('disabled', false);
            $("#jobReceiptStatus").html(dataLovWorkOrderStatus);
            $("#jobReceiptStatus").val(response.data.status_type ? response.data.status_type : '');

            $("#saveBtn").attr('disabled', false);
          }
        }

        if (response.data.status_desc.split(' ')[0] == 'Complete' || response.data.status_type == '4') {
          $("#completeWorkOrderBtn").text('Uncomplete Work Order')
          $('#checkedComplete').prop('checked', true);
        } else {
          $("#completeWorkOrderBtn").text('Complete Work Order')
          $('#checkedComplete').prop('checked', false);
        }
        
        if (dataIdWorkOrderID) {
          $("#workReceiptNumber").attr('disabled', true);
          $("#workReceiptNumber").removeClass('x');
          $("#workReceiptNumberLovBtn").attr('disabled', true);
        } else {
          $("#workReceiptNumber").attr('disabled', false);
          $("#workReceiptNumberLovBtn").attr('disabled', false);
        }

        if ('12' == response.data.status_type) {
          $("#cancleBtn").attr('disabled', false);
        } else {
          $("#cancleBtn").attr('disabled', true);
        }

        $("#machineName").attr('disabled', true);
        $("#machineGroup").attr('disabled', true);
        $("#workOrderNumber").attr('disabled', true);
        $("#saveCompleteBtn").attr('disabled', false);
        $("#viewCompeletBtn").attr('disabled', false);
        $("#fileBtn").prop('disabled', response.data.work_request_number ? false : true);
        checkStatusType();
      } else {
        createNew();
      }
    }

    function checkStatusType() {
      if ($("#jobReceiptStatus").val()  == '1') {
        $("#createBtn").attr('disabled', false);
        $("#saveBtn").attr('disabled', false);
        $("#printBtn").attr('disabled', false);
        $("#saveOperationBtn").attr('disabled', false);
        $("#addOperationBtn").attr('disabled', false);
        $("#deleteOperationBtn").attr('disabled', false);
        $("#resourceOperationBtn").attr('disabled', false);
        $("#saveGroupTechniciansBtn").attr('disabled', false);
        $("#addGroupTechniciansBtn").attr('disabled', false);
        $("#deleteGroupTechniciansBtn").attr('disabled', false);
        $("#saveSavePartBtn").attr('disabled', false);
        $("#saveSavePartNonBtn").attr('disabled', false);
        $("#addSavePartBtn").attr('disabled', false);
        $("#addSavePartNonBtn").attr('disabled', false);
        $("#deleteSavePartBtn").attr('disabled', false);
        $("#deleteSavePartNonBtn").attr('disabled', false);
        $("#resourceSavePartBtn").attr('disabled', true);
        $("#saveSaveCostBtn").attr('disabled', false);
        $("#addSaveCostBtn").attr('disabled', false);
        $("#deleteSaveCostBtn").attr('disabled', false);
        $("#completeWorkOrderBtn").attr('disabled', true);
        $("#saveCompleteBtn").prop('disabled', true);
        $("#saveCostCheckBox").prop('disabled', false);
        statusDisabledOp = false
        statusDisabledRe = false
        statusDisabledLb = false
        statusDisabledPrNumber = true
      } else if ($("#jobReceiptStatus").val()  == '17') {
        $("#createBtn").attr('disabled', false);
        $("#saveBtn").attr('disabled', false);
        $("#printBtn").attr('disabled', false);
        $("#saveOperationBtn").attr('disabled', false);
        $("#addOperationBtn").attr('disabled', false);
        $("#deleteOperationBtn").attr('disabled', false);
        $("#resourceOperationBtn").attr('disabled', false);
        $("#saveGroupTechniciansBtn").attr('disabled', false);
        $("#addGroupTechniciansBtn").attr('disabled', false);
        $("#deleteGroupTechniciansBtn").attr('disabled', false);
        $("#saveSavePartBtn").attr('disabled', false);
        $("#saveSavePartNonBtn").attr('disabled', false);
        $("#addSavePartBtn").attr('disabled', false);
        $("#addSavePartNonBtn").attr('disabled', false);
        $("#deleteSavePartBtn").attr('disabled', false);
        $("#deleteSavePartNonBtn").attr('disabled', false);
        $("#resourceSavePartBtn").attr('disabled', true);
        $("#saveSaveCostBtn").attr('disabled', false);
        $("#addSaveCostBtn").attr('disabled', false);
        $("#deleteSaveCostBtn").attr('disabled', false);
        $("#completeWorkOrderBtn").attr('disabled', true);
        $("#saveCompleteBtn").prop('disabled', true);
        $("#saveCostCheckBox").prop('disabled', false);
        statusDisabledOp = false
        statusDisabledRe = false
        statusDisabledLb = false
        statusDisabledPrNumber = true
      } else if ($("#jobReceiptStatus").val()  == '3') {
        $("#createBtn").attr('disabled', false);
        $("#saveBtn").attr('disabled', false);
        $("#printBtn").attr('disabled', false);
        $("#saveOperationBtn").attr('disabled', false);
        $("#addOperationBtn").attr('disabled', false);
        $("#deleteOperationBtn").attr('disabled', false);
        $("#resourceOperationBtn").attr('disabled', false);
        $("#saveGroupTechniciansBtn").attr('disabled', false);
        $("#addGroupTechniciansBtn").attr('disabled', false);
        $("#deleteGroupTechniciansBtn").attr('disabled', false);
        $("#saveSavePartBtn").attr('disabled', false);
        $("#saveSavePartNonBtn").attr('disabled', false);
        $("#addSavePartBtn").attr('disabled', false);
        $("#addSavePartNonBtn").attr('disabled', false);
        $("#deleteSavePartBtn").attr('disabled', false);
        $("#deleteSavePartNonBtn").attr('disabled', false);
        $("#resourceSavePartBtn").attr('disabled', true);       
        $("#saveSaveCostBtn").attr('disabled', false);
        $("#addSaveCostBtn").attr('disabled', false);
        $("#deleteSaveCostBtn").attr('disabled', false);
        $("#completeWorkOrderBtn").attr('disabled', false);
        $("#saveCompleteBtn").prop('disabled', false);
        $("#saveCostCheckBox").prop('disabled', false);
        statusDisabledOp = false
        statusDisabledRe = false
        statusDisabledLb = false
        statusDisabledPrNumber = false
        if ($("#saveCostCheckBox").prop('checked')) {
          statusDisabledLb = true
          $("#saveCostCheckBox").prop('disabled', true);
        }
      } else if ($("#jobReceiptStatus").val()  == '6') {
        $("#createBtn").attr('disabled', false);
        $("#saveBtn").attr('disabled', false);
        $("#printBtn").attr('disabled', false);
        $("#saveOperationBtn").attr('disabled', false);
        $("#addOperationBtn").attr('disabled', false);
        $("#deleteOperationBtn").attr('disabled', false);
        $("#resourceOperationBtn").attr('disabled', false);
        $("#saveGroupTechniciansBtn").attr('disabled', false);
        $("#addGroupTechniciansBtn").attr('disabled', false);
        $("#deleteGroupTechniciansBtn").attr('disabled', false);
        $("#saveSavePartBtn").attr('disabled', false);
        $("#saveSavePartNonBtn").attr('disabled', false);
        $("#addSavePartBtn").attr('disabled', false);
        $("#addSavePartNonBtn").attr('disabled', false);
        $("#deleteSavePartBtn").attr('disabled', false);
        $("#deleteSavePartNonBtn").attr('disabled', false);
        $("#resourceSavePartBtn").attr('disabled', true);
        $("#saveSaveCostBtn").attr('disabled', true);
        $("#addSaveCostBtn").attr('disabled', true);
        $("#deleteSaveCostBtn").attr('disabled', true);
        $("#completeWorkOrderBtn").attr('disabled', true);
        $("#saveCompleteBtn").prop('disabled', true);
        $("#saveCostCheckBox").prop('disabled', false);
        statusDisabledOp = false
        statusDisabledRe = false
        statusDisabledLb = true
        statusDisabledPrNumber = true
      } else if ($("#jobReceiptStatus option:selected").text().split(' ')[0] == 'Complete') {
        $("#createBtn").attr('disabled', false);
        $("#saveBtn").attr('disabled', true);
        $("#printBtn").attr('disabled', false);
        $("#saveOperationBtn").attr('disabled', true);
        $("#addOperationBtn").attr('disabled', true);
        $("#deleteOperationBtn").attr('disabled', true);
        $("#resourceOperationBtn").attr('disabled', true);
        $("#saveGroupTechniciansBtn").attr('disabled', true);
        $("#addGroupTechniciansBtn").attr('disabled', true);
        $("#deleteGroupTechniciansBtn").attr('disabled', true);
        $("#saveSavePartBtn").attr('disabled', true);
        $("#saveSavePartNonBtn").attr('disabled', true);
        $("#addSavePartBtn").attr('disabled', true);
        $("#addSavePartNonBtn").attr('disabled', true);
        $("#deleteSavePartBtn").attr('disabled', true);
        $("#deleteSavePartNonBtn").attr('disabled', true);
        $("#resourceSavePartBtn").attr('disabled', true);
        $("#saveSaveCostBtn").attr('disabled', true);
        $("#addSaveCostBtn").attr('disabled', true);
        $("#deleteSaveCostBtn").attr('disabled', true);
        $("#completeWorkOrderBtn").attr('disabled', false);
        $("#saveCompleteBtn").prop('disabled', false);
        $("#saveCostCheckBox").prop('disabled', true);
        statusDisabledOp = true
        statusDisabledRe = true
        statusDisabledLb = true
        statusDisabledPrNumber = true
      } else {
        $("#createBtn").attr('disabled', false);
        $("#saveBtn").attr('disabled', true);
        $("#printBtn").attr('disabled', false);
        $("#saveOperationBtn").attr('disabled', true);
        $("#addOperationBtn").attr('disabled', true);
        $("#deleteOperationBtn").attr('disabled', true);
        $("#resourceOperationBtn").attr('disabled', true);
        $("#saveGroupTechniciansBtn").attr('disabled', true);
        $("#addGroupTechniciansBtn").attr('disabled', true);
        $("#deleteGroupTechniciansBtn").attr('disabled', true);
        $("#saveSavePartBtn").attr('disabled', true);
        $("#saveSavePartNonBtn").attr('disabled', true);
        $("#addSavePartBtn").attr('disabled', true);
        $("#addSavePartNonBtn").attr('disabled', true);
        $("#deleteSavePartBtn").attr('disabled', true);
        $("#deleteSavePartNonBtn").attr('disabled', true);
        $("#resourceSavePartBtn").attr('disabled', true);
        $("#saveSaveCostBtn").attr('disabled', true);
        $("#addSaveCostBtn").attr('disabled', true);
        $("#deleteSaveCostBtn").attr('disabled', true);
        $("#completeWorkOrderBtn").attr('disabled', true);
        $("#saveCompleteBtn").prop('disabled', true);
        $("#saveCostCheckBox").prop('disabled', false);
        statusDisabledOp = true
        statusDisabledRe = true
        statusDisabledLb = true
        statusDisabledPrNumber = true
        $("#setTbodyTableSaveCost tr ").each(function() {
          if ($(this).find("td:eq(1) input[type='text']").val() == 'Error' || 
              $(this).find("td:eq(1) input[type='text']").val() == '') {
            $("#saveCostCheckBox").prop('disabled', true);
          }
        })

        if($("#jobReceiptStatus option:selected").text() == 'Failed Close'){
          $("#saveBtn").attr('disabled', false);
        }
      }
      if (wip_entity_id) {
        apiAllTable();
      }
    }

    function setDataWorkRequest(data) {
      changeDropDownActivityToDo({data1: data.asset_number, data2: '', data3: 'eam0010', data4: ''});
      if (!data.class_code) {
        $.ajax({
          url: "{{ route('eam.ajax.lov.wip-class') }}",
          data: {
            'department_code': data.department
          },
          method: 'GET',
          success: function (response) {
            if (response.data.data.length > 0 && data.department) {
              $("#class").val(response.data.data[0].class_code);
            } else {
              $("#class").val('');
            }
          }
        })
      } else {
        //Default class
        var newOptionClass = new Option((data.class_code ? data.class_code : ''), data.class_code, true, true);
        $('#class').append(newOptionClass).trigger('change');
        $("#class").val(data.class_code ? data.class_code  : '').trigger('change');
      }
      wip_entity_id               = data.wip_entity_id;
      organization_id             = data.organization_id;
      or_wip_entity_id            = data.or_wip_entity_id;
      asset_group_id              = data.asset_group_id;
      owning_department           = data.owning_department;
      departmentCodeInAssetNumber = data.department;
      jp_flag                     = data.jp_flag;      

      //Default workReceiptNumber
      var newOptionWorkReceiptNumber = new Option((data.work_order_number ? data.work_order_number : ''), data.work_order_number, true, true);
      $('#workReceiptNumber').append(newOptionWorkReceiptNumber).trigger('change');
      $("#workReceiptNumber").val(data.work_order_number ? data.work_order_number : '').trigger('change');

      //Default assetNumber
      var newOptionAssetNumber = new Option((data.asset_number ? data.asset_number : ''), data.asset_number, true, true);
      $('#assetNumber').append(newOptionAssetNumber).trigger('change');
      $("#assetNumber").val(data.asset_number ? data.asset_number : data.asset_number).trigger('change');
      $("#machineName").val(data.asset_desc ? data.asset_desc : data.asset_desc);
      $("#machineGroup").val(data.asset_group_desc ? data.asset_group_desc : '');

      $("#jobReceiptStatus").val('1').trigger('change');
      $("#jobStatus").val('เปิดใบรับงาน').trigger('change');

      //Default หน่วยงานผู้รับแจ้ง
      var newOptionWorkReceiptNumber = new Option((data.receiving_dept_code ? data.receiving_dept_code : '') + ' - ' +
                                                  (data.receiving_dept_desc ? data.receiving_dept_desc : ''), data.receiving_dept_code, true, true);
      $('#notifyingAgency').append(newOptionWorkReceiptNumber).trigger('change');
      $("#notifyingAgency").val(data.receiving_dept_code ? data.receiving_dept_code : '').trigger('change');

      $("#workReceiptDescription").val(data.description ? data.description : '');
      $("#importance").val(data.work_request_priority_id ? data.work_request_priority_id : '2').trigger('change');
      vmDateTimePickerAll.repairDateStart.pValue = getDateTime();
      vmDateTimePickerAll.repairDateEnd.pValue = getDateTime();
      vmDateTimePickerAll.repairDateEnd.pDisabled = getDateTime();
      $("#workOrderNumber").val(data.work_request_number);

      $("#fileBtn").prop('disabled', data.work_request_number ? false : true);
      if (data.work_request_type_id) {
        $("#workReceiptType").val(data.work_request_type_id == '2700' ? '300' : '100').trigger('change');
        vmDateTimePickerAll.repairDateStart.pValue = data.approved_date;
        vmDateTimePickerAll.repairDateEnd.pDisabled = data.approved_date;
      } else {
        $("#workReceiptType").val(data.jp_flag == "Yes" ? '300' : '100').trigger('change');
      }
      if (data.work_request_type_desc == 'JP' || data.work_request_type_desc == 'JR') {
        vmDateTimePickerAll.repairDateStart.pValue = data.approved_date;
        vmDateTimePickerAll.repairDateEnd.pDisabled = data.approved_date;
      }

      $("#activitiesToDo").val('');

      //Default ผู้รับแจ้ง
      $("#notifierId").val(defaultUser.user_id)
      var newOptionNotifier = new Option((defaultUser.username ? defaultUser.username : '') + ' - ' +
                                         (defaultUser.name ? defaultUser.name : ''), defaultUser.username, true, true);
      $('#notifier').append(newOptionNotifier).trigger('change');
      $("#notifier").val(defaultUser.username ? defaultUser.username : '').trigger('change');

      $("#problemsEncountered").val('');
      $("#stopMachine").val('');
      $("#workReceiptNumber").attr('disabled', true);
      $("#workReceiptNumberLovBtn").attr('disabled', true);
      $("#assetNumber").attr('disabled', false);
      $("#assetNumberLovBtn").attr('disabled', false);
      $("#machineName").attr('disabled', true);
      $("#machineGroup").attr('disabled', true);
      $("#activitiesToDo").attr('disabled', false);
      $("#class").attr('disabled', false);
      $("#classLovBtn").attr('disabled', false);
      $("#jobReceiptStatus").attr('disabled', false);
      $("#jobStatus").attr('disabled', false);
      $("#notifyingAgency").attr('disabled', false);
      $("#notifyingAgencyLovBtn").attr('disabled', false);
      $("#notifier").attr('disabled', false);
      $("#notifierLovBtn").attr('disabled', false);
      $("#referenceWorkReceipt").attr('disabled', false);
      $("#workReceiptType").attr('disabled', false);
      $("#workReceiptDescription").attr('disabled', false);
      $("#problemsEncountered").attr('disabled', false);
      $("#importance").attr('disabled', false);
      vmDateTimePickerAll.repairDateStart.disabled = false;
      vmDateTimePickerAll.repairDateEnd.disabled = false;
      $("#stopMachine").attr('disabled', false);
      $("#workOrderNumber").attr('disabled',true);

      $("#referenceWorkReceipt").val('');
      $("#referenceWorkReceipt").val(null).trigger('change');
      var data = {
          id: data.wo_reference? data.wo_reference : '',
          text: data.wo_reference_name? data.wo_reference_name : ''
      };

      var $newOption = $("<option selected='selected'></option>").val(data.id).text(data.text)
      $("#referenceWorkReceipt").append($newOption).trigger('change');
    }

    function setDataPlan(data, data2) {
      $.ajax({
        url: "{{ route('eam.ajax.resource-asset.show',['']) }}/" + data.asset_number,
        method: 'GET',
        success: function (response) {
          changeDropDownActivityToDo({data1: data.asset_number, data2: '', data3: 'eam0010', data4: data.asset_activity});
          $.ajax({
            url: "{{ route('eam.ajax.lov.wip-class') }}",
            data: {
              'department_code': response.data.owning_department
            },
            method: 'GET',
            success: function (response2) {
              if (response2.data.data.length > 0 && response.data.owning_department) {
                //Default class
                var newOptionClass = new Option((response2.data.data[0].class_code ? response2.data.data[0].class_code : ''), response2.data.data[0].class_code, true, true);
                $('#class').append(newOptionClass).trigger('change');
                $("#class").val(response2.data.data[0].class_code).trigger('change');
                if (dataDefault && fnName) {
                    newOptionClass = new Option((data2.class_code), data2.class_code, true, true);
                    $('#class').append(newOptionClass).trigger('change');
                    $("#class").val(data2.class_code).trigger('change');
                }
              } else {
                $("#class").val('');
              }
              wip_entity_id               = data.wip_entity_id;
              organization_id             = data.organization_id;
              or_wip_entity_id            = data.or_wip_entity_id;
              asset_group_id              = data.asset_group_id;
              owning_department           = data.owning_department;
              departmentCodeInAssetNumber = response.data.owning_department;
              jp_flag                     = data.asset_information.jp_flag

              //Default เลขที่ใบรับงาน
              var newOptionWorkReceiptNumber = new Option((data.wip_entity_name ? data.wip_entity_name : ''), data.wip_entity_name, true, true);
              $('#workReceiptNumber').append(newOptionWorkReceiptNumber).trigger('change');
              $("#workReceiptNumber").val(data.wip_entity_name).trigger('change');

              //Default Asset Number
              var newOptionAssetNumber = new Option((data.asset_number ? data.asset_number : ''), data.asset_number, true, true);
              $('#assetNumber').append(newOptionAssetNumber).trigger('change');
              $("#assetNumber").val(data.asset_number ? data.asset_number : data.asset_number).trigger('change');
              $("#machineName").val(data.asset_desc ? data.asset_desc : data.asset_desc);
              $("#machineGroup").val(response.data.asset_group ? response.data.asset_group : '');

              //Default หน่วยงานผู้รับแจ้ง
              var newOptionAssetNumber = new Option((data.receiving_department_code ? data.receiving_department_code : '') + ' - ' +
                                                    (data.receiving_department_desc ? data.receiving_department_desc : '') , 
                                                     data.receiving_department_code, true, true);
              $('#notifyingAgency').append(newOptionAssetNumber).trigger('change');
              $("#notifyingAgency").val(data.receiving_department_code ? data.receiving_department_code : data.receiving_department_code).trigger('change');

              $("#importance").val(data2.work_request_priority_id ? data2.work_request_priority_id : '3').trigger('change');
              vmDateTimePickerAll.repairDateStart.pValue = data2.scheduled_start_date + ' ' + getTime();
              vmDateTimePickerAll.repairDateEnd.pValue = data2.scheduled_completion_date + ' ' + getTime();
              vmDateTimePickerAll.repairDateEnd.pDisabled = data2.scheduled_start_date + ' ' +getTime();
              $("#stopMachine").val('2').trigger('change');
              $("#workReceiptDescription").val('ดำเนินการซ่อม-บำรุงเครื่องจักรตามแผน PM').trigger('change');
              $("#workOrderNumber").val('').trigger('change');
              $("#fileBtn").prop('disabled', data.work_request_number ? false : true).trigger('change');
              $("#workReceiptType").val(response.data.jp_status == 'Yes' ? '200' : '200').trigger('change');

              //Default ผู้รับแจ้ง
              var newOptionNotifier = new Option((defaultUser.username ? defaultUser.username : '') + ' - ' +
                                                     (defaultUser.name ? defaultUser.name : '') , 
                                                      defaultUser.username, true, true);
              $('#notifier').append(newOptionNotifier).trigger('change');
              $("#notifier").val(defaultUser.username).trigger('change');
              $("#notifierId").val(defaultUser.user_id)

              $("#referenceWorkReceipt").val(null).trigger('change');
              $("#problemsEncountered").val('');
              $("#jobReceiptStatus").html(dataLovWorkOrderStatus).trigger('change');
              $("#jobReceiptStatus").val(data.status_type ? data.status_type : '').trigger('change');
              $("#jobStatus").val('เปิดใบรับงาน').trigger('change');

              if ($("#workReceiptType").val() == '200') {
                if (data2.scheduled_start_date.toString().indexOf(' ') > 0) {
                  vmDateTimePickerAll.repairDateStart.pValue = data2.scheduled_start_date.split(' ')[0] + ' 07:30:00';
                  vmDateTimePickerAll.repairDateEnd.pValue = data2.scheduled_completion_date.split(' ')[0] + ' 16:30:00';
                  vmDateTimePickerAll.repairDateEnd.pDisabled = data2.scheduled_start_date.split(' ')[0] + ' 07:30:00';
                } else {
                  vmDateTimePickerAll.repairDateStart.pValue = data2.scheduled_start_date + ' 07:30:00';
                  vmDateTimePickerAll.repairDateEnd.pValue = data2.scheduled_completion_date + ' 16:30:00';
                  vmDateTimePickerAll.repairDateEnd.pDisabled = data2.scheduled_start_date + ' 07:30:00';
                }
              }

              if ('1' == data.status_type || 
                  '17' == data.status_type || 
                  '3' == data.status_type) {
                $("#assetNumber").attr('disabled', false);
                $("#assetNumberLovBtn").attr('disabled', false);
                $("#activitiesToDo").attr('disabled', false);
                $("#class").attr('disabled', false);
                $("#classLovBtn").attr('disabled', false);
                $("#jobReceiptStatus").attr('disabled', false);
                $("#jobStatus").attr('disabled', false);
                $("#notifyingAgency").attr('disabled', false);
                $("#notifyingAgencyLovBtn").attr('disabled', false);
                $("#notifier").attr('disabled', false);
                $("#notifierLovBtn").attr('disabled', false);
                $("#referenceWorkReceipt").attr('disabled', false);
                $("#workReceiptType").attr('disabled', false);
                $("#workReceiptDescription").attr('disabled', false);
                $("#problemsEncountered").attr('disabled', false);
                $("#importance").attr('disabled', false);
                vmDateTimePickerAll.repairDateStart.disabled = false;
                vmDateTimePickerAll.repairDateEnd.disabled = false;
                $("#stopMachine").attr('disabled', false);
                $("#saveBtn").attr('disabled', false);

                apiAllTable();
                $("#saveOperationBtn").attr('disabled', false);
                $("#addOperationBtn").attr('disabled', false);
                $("#deleteOperationBtn").attr('disabled', false);

                $("#saveGroupTechniciansBtn").attr('disabled', false);
                $("#addGroupTechniciansBtn").attr('disabled', false);
                $("#deleteGroupTechniciansBtn").attr('disabled', false);

                $("#saveSavePartBtn").attr('disabled', false);
                $("#addSavePartBtn").attr('disabled', false);
                $("#deleteSavePartBtn").attr('disabled', false);
                $("#resourceSavePartBtn").attr('disabled', false);

                $("#saveSavePartNonBtn").attr('disabled', false);
                $("#addSavePartNonBtn").attr('disabled', false);
                $("#deleteSavePartNonBtn").attr('disabled', false);

                $("#saveSaveCostBtn").attr('disabled', false);
                $("#addSaveCostBtn").attr('disabled', false);
                $("#deleteSaveCostBtn").attr('disabled', false);
                $("#sendDataSaveCostBtn").attr('disabled', false);
                $("#undoDataSaveCostBtn").attr('disabled', false);

                $("#viewCompeletBtn").attr('disabled', false);
              } else {
                $("#jobReceiptStatus").html(`<option value="${response.data.status_type}">${response.data.status_desc}</option>`);
                $("#jobReceiptStatus").val(response.data.status_type ? response.data.status_type : '');
                $("#assetNumber").attr('disabled', true);
                $("#assetNumberLovBtn").attr('disabled', true);
                $("#activitiesToDo").attr('disabled', true);
                $("#class").attr('disabled', true);
                $("#classLovBtn").attr('disabled', true);
                $("#jobReceiptStatus").attr('disabled', true);
                $("#jobStatus").attr('disabled', true);
                $("#notifyingAgency").attr('disabled', true);
                $("#notifyingAgencyLovBtn").attr('disabled', true);
                $("#notifier").attr('disabled', true);
                $("#notifierLovBtn").attr('disabled', true);
                $("#referenceWorkReceipt").attr('disabled', true);
                $("#workReceiptType").attr('disabled', true);
                $("#workReceiptDescription").attr('disabled', true);
                $("#problemsEncountered").attr('disabled', true);
                $("#importance").attr('disabled', true);
                vmDateTimePickerAll.repairDateStart.disabled = true;
                vmDateTimePickerAll.repairDateEnd.disabled = true;
                $("#stopMachine").attr('disabled', true);
                $("#assetNumber").removeClass('x');
                $("#class").removeClass('x');
                $("#notifyingAgency").removeClass('x');
                $("#notifier").removeClass('x');
                $("#saveBtn").attr('disabled', true);
                $("#saveOperationBtn").attr('disabled', true);
                $("#addOperationBtn").attr('disabled', true);
                $("#deleteOperationBtn").attr('disabled', true);
              }
            $("#workReceiptNumber").attr('disabled', true);
              $("#workReceiptNumberLovBtn").attr('disabled', true);
              $("#machineName").attr('disabled', true);
              $("#machineGroup").attr('disabled', true);
              $("#workOrderNumber").attr('disabled',true);
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })

        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }

    function selectTableRow(data) {
      $(data).toggleClass("bg-select-table")
    }

    function clearAllTable() {
      $("#setTbodyTableGroupTechnicians").html('').trigger('change');
      $("#setTbodyTableOperation").html('').trigger('change');
      $("#setTbodyTableSavePart").html('').trigger('change');
      $("#setTbodyTableSavePartNon").html('').trigger('change');
      $("#setSavePartBtnChild").html('').trigger('change');
      $("#setTbodyTableSaveCost").html('').trigger('change');
      $("#setTbodyTableComplete").html('').trigger('change');
      $("#setTbodyTableViewComplete").html('').trigger('change');

      $("#btnOperation").removeClass('d-none');
      $("#tableOperation").removeClass('d-none');
      $("#saveGroupTechniciansBtn").attr('disabled', true);
      $("#addGroupTechniciansBtn").attr('disabled', true);
      $("#deleteGroupTechniciansBtn").attr('disabled', true);
      $("#saveSavePartBtn").attr('disabled', true);
      $("#saveSavePartNonBtn").attr('disabled', true);
      $("#addSavePartBtn").attr('disabled', true);
      $("#addSavePartNonBtn").attr('disabled', true);
      $("#deleteSavePartBtn").attr('disabled', true);
      $("#deleteSavePartNonBtn").attr('disabled', true);
      $("#resourceSavePartBtn").attr('disabled', true);
      $("#saveSaveCostBtn").attr('disabled', true);
      $("#addSaveCostBtn").attr('disabled', true);
      $("#deleteSaveCostBtn").attr('disabled', true);
      $("#saveCompleteBtn").attr('disabled', true);
      $("#saveOperationBtn").attr('disabled', true);
      $("#addOperationBtn").attr('disabled', true);
      $("#deleteOperationBtn").attr('disabled', true);
      $("#resourceOperationBtn").attr('disabled', true);
      $("#viewCompeletBtn").attr('disabled', true);
      $("#completeWorkOrderBtn").attr('disabled', true);
    }

    $("#fileBtn").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.work-requests.images.index',['']) }}/" + $("#workOrderNumber").val(),
        method: 'GET',
        success: function (response) {
          $("#detailModalImage").modal('show');
          $("#modalImageSearchWorkOrderNumber").val($("#workOrderNumber").val());
          $("#selectImageDelete").val('')
          dataImageFile = response.data;
          setImageFileNewFn(response.data);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })

    function setImageFileFn(data) {
      let theadModalFile = ''
      if (data.length > 0) {
        data.filter((row, index) => {
          theadModalFile += `<tr id="imageFile${row.attachment_id}" onClick="setImageFile('` + row.attachment_id + `')">`
          theadModalFile += `<td class="pointer">${index+1}</td>`
          theadModalFile += `<td class="pointer">${row.original_name}</td>`
          theadModalFile += `</tr>`
        })
      }
      $("#setModalFile").html(theadModalFile);
    }

    function setImageFileNewFn(data) {
      let theadModalFile = ''
      if (data.length > 0) {
        data.filter(row => {
          theadModalFile += `<div id="imageFile${row.attachment_id}" class="card" style="display: inline-block; width: 120px; height: 120px; position: relative; overflow: hidden; margin: 5px;">`
          theadModalFile += `<div style="position: absolute; z-index: 1; background: #000; top: 0; cursor: zoom-in;" onClick="setImageFile('` + row.attachment_id + `')"><img src="{{route('eam.ajax.work-requests.images.show',[''])}}/${row.attachment_id}" style="width: 100%;" /></div>`
          theadModalFile += `</div>`
        })
      }
      $("#setModalFileNew").html(theadModalFile);
    }

    var dataImageFileOld = ''
    function setImageFile(data) {
      if (dataImageFileOld != '') {
        $('#imageFile'+dataImageFileOld).css("background-color", "#FFFFFF");
      }
      $('#imageFile'+data).css("background-color", "#f9f9f9");
      dataImageFileOld = data
      $("#selectImageDelete").val(data);

      $("#setShowImageFileFn").attr('src', `{{route('eam.ajax.work-requests.images.show',[''])}}/` + $("#selectImageDelete").val());
        $("#detailModalImageView").modal('show');
    }
    $("#detailModalImageView").on('hidden.bs.modal', () => {
      $('body').addClass('modal-open')
    })

    async function em0007CallDayFn(data) {
      setTimeout(await function() {
        let fmDate = $("#" + data.fm_el_id).val();
        let toDate = $("#" + data.to_el_id).val();

        let workingHourElId = '#dateTableWorkingHour-'+ data.index;
        let dayElId         = '#dateTableAttribute4Day-'+ data.index;
        let hourElId        = '#dateTableAttribute5Hour-'+ data.index;

        let maxWorkingHour  = $(workingHourElId).attr('max');
            maxWorkingHour  = maxWorkingHour ? maxWorkingHour : 0;
        let workingHour     = $(workingHourElId).val() ? $(workingHourElId).val() : 0;
            workingHour     = parseFloat(workingHour);

        if (workingHour > parseFloat(maxWorkingHour) ) {
            workingHour = parseFloat(maxWorkingHour);
            $(workingHourElId).val(workingHour);
        }
        $(dayElId).val('');
        $(hourElId).val('');

        if (
            (fmDate != '' || fmDate != null || fmDate != undefined || !isNaN(fmDate) ) &&
            (toDate != '' || toDate != null || toDate != undefined || !isNaN(toDate) )
        ) {
            fmDate = fmDate.split('/');
            toDate = toDate.split('/');

            fmDate = new Date(parseInt(fmDate[2]) - 543, fmDate[1], fmDate[0]);
            toDate = new Date(parseInt(toDate[2]) - 543, toDate[1], toDate[0]);

            let diffTime = 0;
            let diffDays = 1;
            if (fmDate != toDate) {
                diffTime = Math.abs(toDate - fmDate);
                diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            }

            if (!isNaN(fmDate) && !isNaN(toDate)) {
                $(dayElId).val(diffDays);
                $(hourElId).val(diffDays * parseFloat(workingHour));
            }
        }
      }, 100)
    }

    $('#workReceiptNumber').on('select2:clear', function (e) {
      $("#undoBtn").click();
    });

    $('#modalReportWorkReceiptNotifyingAgency').on('select2:select', function (e) {
      $("#modalReportWorkReceiptNotifyingAgencyDesc").val($(this).select2('data')[0].text.split(' - ')[1]).trigger('change');
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    $('#modalReportWorkReceiptNotifyingAgency').on('select2:clear', function (e) {
      $("#modalReportWorkReceiptNotifyingAgencyDesc").val('');
    });

    function conVertDate(dataInPut) {
      if (dataInPut) {
        let d1    = new Date(Date.parse(dataInPut));
        yr        = d1.getFullYear()+ 543,
        month     = (d1.getMonth()+1) < 10 ? '0' + (d1.getMonth()+1) : (d1.getMonth()+1),
        day       = d1.getDate()  < 10 ? '0' + d1.getDate()  : d1.getDate(),
        newDate   = day + '/' + month + '/' + yr;
        let time  = d1.getHours() + ":" + d1.getMinutes() + ":" + d1.getSeconds();
        return newDate+' '+time;
      } else {
        return '';
      }
    }
  </script>

  <script script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection
