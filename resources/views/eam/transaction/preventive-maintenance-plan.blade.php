@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <x-get-page-title menu="" url="/eam/transaction/preventive-maintenance-plan" />
@stop

@section('content')
@php $checkAttrId = 'preventiveMaintenancePlan' @endphp
<div id="eam0006" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11">
        <div class="text-right">
          <button id="createBtn" class="btn btn-success btn-lg size-btn mt-1 testxxx">
              สร้าง
            </button>
            <button id="searchBtn" class="btn btn-default btn-lg size-btn mt-1" role="button">
              <i class="fa fa-search"></i> ค้นหา
            </button>
            <button id="saveBtn" class="btn btn-primary btn-lg size-btn mt-1" disabled>
              บันทึก
            </button>
            <button id="printBtn" class="btn btn-info btn-lg size-btn mt-1">
              <i class="fa fa-print fa-lg"></i> พิมพ์รายงาน
            </button>
        </div>
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="undoBtn" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
            <i class="fa fa-undo"></i> ล้างค่า
          </button>
          <button id="approvalBtn" class="btn btn-primary btn-lg size-btn mt-1" disabled>
            ยืนยันแผน
          </button>
          <button id="fileBtn" class="btn btn-success btn-lg size-btn mt-1" disabled>
            Upload
          </button>
          <button id="openRepairWorkBtn" class="btn btn-primary btn-lg size-btn mt-1" disabled>
            เปิดงานซ่อม
          </button>
        </div>
      </div>
      <div class="col-11 mt-4">
        <form onsubmit="formSaveBtnHide('','');return false;">
          @include('eam.transaction._form')
          <button id="saveBtnHide" class="d-none" ></button>
        </form>
      </div>
      <div class="col-11 mt-4">
        <div class="row">
          <div id="table" class="col-sm-4 text-left inline pt-2">
            <h4>รายการซ่อมบำรุงเชิงป้องกัน</h4>
          </div>
          <div class="col-sm-8 text-right inline float-right">
            <button id="addTableBtn" class="btn btn-success btn-lg size-btn mt-1" disabled>
              <i class="fa fa-plus"></i> เพิ่มรายการ
            </button>
            <button id="deleteTableBtn" class="btn btn-danger btn-lg size-btn mt-1" disabled>
              <i class="fa fa-times"></i> ลบรายการ
            </button>
          </div>
        </div>
      </div>
      <div class="col-11 mt-4">
        <form onsubmit="formSaveTableBtnHide();return false;">
          @include('eam.transaction._table')
          <button id="saveTableBtnHide" class="d-none" ></button>
        </form>
      </div>
    </div>
  </div>
  @include('eam.transaction._modalLov')
</div>
@endsection
@section('scripts')
  @include('eam.commons.scripts.drop-down-year-plan');
  @include('eam.commons.scripts.drop-down-activities-to-do');
  @include('eam.commons.scripts.drop-down-status-yn');
  @include('eam.commons.scripts.drop-down-machine-group');
  @include('eam.commons.scripts.drop-down-ptw-users');
  @include('eam.commons.scripts.all-date');
  @include('eam.commons.scripts.clear-input');
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-department');
  @include('eam.commons.scripts.lov-area');
  @include('eam.commons.scripts.loader');

  <script>
    var defaultUser = {!! json_encode($user->toArray(), JSON_HEX_TAG) !!};
    var versionNotification = {!! json_encode($version) !!};
    $("#formAll").removeClass('d-none');
    var statusBtn = ''
    var statusCreate = ''
    var planId = ''
    var editConfirm = false
    var versionPlanOfYear = ''
    var userIdPtwUser = ''

    readonly();
    loader('hide');
    function readonly() {
      $(".readonly").on("keydown paste focus mousedown", function(e) {
        if(e.keyCode != 9) {
          e.preventDefault();
        }
      });
    }

    setDatePicker({idDate: 'repairStartDate', nameDate: '', onchange: false, date: '', disabled: true, required: false, dateEndId: `repairEndDate`});
    setDatePicker({idDate: 'repairEndDate', nameDate: '', onchange: false, date: '', disabled: true, required: false});

    let thead = [{
      name: 'รหัสเครื่องจักร<label class="pl-1 text-danger">*</label>',
      style: 'min-width: 250px;'
    }, {
      name: 'ชื่อเครื่องจักร',
      style: 'min-width: 350px;'
    }, {
      name: 'กิจกรรม',
      style: 'min-width: 200px;'
    }, {
      name: 'หน่วยงานผู้รับแจ้ง<label class="pl-1 text-danger">*</label>',
      style: 'min-width: 220px;'
    }, {
      name: 'พื้นที่',
      style: 'min-width: 200px;'
    }, {
      name: 'วันที่เริ่มซ่อม<label class="pl-1 text-danger">*</label>',
      style: 'min-width: 150px;'
    }, {
      name: 'วันที่ซ่อมเสร็จ<label class="pl-1 text-danger">*</label>',
      style: 'min-width: 150px;'
    }, {
      name: 'เลขที่ใบรับงาน',
      style: 'min-width: 150px;'
    }, {
      name: 'สถานะใบรับงาน',
      style: 'min-width: 140px;'
    }]

    let theadTable = ''
      theadTable += `<th class="text-center" style="min-width: 100px;">`
      theadTable += `<div><input id="checkboxAllTable" type="checkbox"> เลือกทั้งหมด</div>`
      theadTable += `</th>`
      thead.filter(row => {
        theadTable += `<th class="text-center" style="${row.style}">`
        theadTable += `<div>${row.name}</div>`
        theadTable += `</th>`
      })
    $("#setTheadTable").html(theadTable);

    $("#undoBtn").click(() => {
      $(".clearable").removeClass('x onX');
      $("#yearPlan").val('').trigger('change');
      $("#yearPlan").prop('disabled', false);
      $("#statusPlan").val('').trigger('change');
      $("#statusPlan").prop('disabled', true);
      $("#versionPlan").val('').trigger('change');
      $("#versionPlan").prop('disabled', true);
      $("#assetNumber").val('').trigger('change');
      $("#assetNumber").prop('disabled', true);
      $("#assetNumberLovBtn").prop('disabled', true);
      $("#machineGroup").val('').trigger('change');
      $("#machineGroup").prop('disabled', true);
      $("#notifyingAgency").val('').trigger('change');
      $("#notifyingAgency").prop('disabled', true);
      $("#notifyingAgencyLovBtn").prop('disabled', true);
      $("#activitiesToDo").val('').trigger('change');
      $("#activitiesToDo").prop('disabled', true);
      $("#area").val('').trigger('change');
      $("#area").prop('disabled', true);
      $("#areaLovBtn").prop('disabled', true);
      $("#repairOpenStatus").val('').trigger('change');
      $("#repairOpenStatus").prop('disabled', true);
      vmDatePicker.repairStartDate.pValue = ''
      vmDatePicker.repairStartDate.disabled = true
      vmDatePicker.repairEndDate.pValue = ''
      vmDatePicker.repairEndDate.disabled = true
      $("#checkboxAllTable").prop('checked', false);
      $("#setTbodyTable").html('');
      $('#setTablePagination').html('');
      $("#createBtn").prop('disabled', false);
      $("#searchBtn").prop('disabled', false);
      $("#saveBtn").prop('disabled', true);
      $("#printBtn").prop('disabled', false);
      $("#approvalBtn").prop('disabled', true);
      $("#fileBtn").prop('disabled', true);
      $("#openRepairWorkBtn").prop('disabled', true);
      $("#addTableBtn").prop('disabled', true);
      $("#deleteTableBtn").prop('disabled', true);
      $("#nameCreate").val('').trigger('change');
      $("#nameCreate").prop('disabled', true);
      $("#nameCreateBtn").prop('disabled', true);
      statusCreate = ''
      $("#oldVersionPlan").val('').trigger('change');
    })

    $("#yearPlan").change(() => {
      clearDetail()
      $("#statusPlan").val('');
      $("#versionPlan").html('')
      $("#versionPlan").prop('disabled', true);
      if ($("#yearPlan").val() != '' && statusCreate != 'create') {
        $.ajax({
          url: "{{ route('eam.ajax.plan.version-plan',['']) }}/" + $("#yearPlan").val(),
          method: 'GET',
          success: function (response) {
            if (response.data.length > 0) {
              versionPlanOfYear = +(Math.max.apply(Math, response.data.map(function(o) { return o.version_plan; }))) + 1;
            } else {
              versionPlanOfYear = 1
            }
            $("#versionPlan").prop('disabled', false);
            let optionVersionPlan = ''
            optionVersionPlan += `<option value=""></option>`
            for (let data of response.data) {
              if (data.version_plan) {
                optionVersionPlan += `<option oldVer="${data.old_version_plan}" value="${data.status_plan}">${data.version_plan}</option>`
              }
              if(versionNotification && yearNotification){     
                optionVersionPlan +=  `<option oldVer="${data.old_version_plan}" 
                                              value="${data.status_plan}"
                                              ${versionNotification == data.version_plan ? 'selected' : ''}>
                                              ${data.version_plan}
                                      </option>`
              }
            }
            $("#versionPlan").html(optionVersionPlan);

            if(versionNotification && yearNotification){
              $('#searchBtn').click();
            }

            if($("#statusPlan").val() == 'Draft'){
              $("#saveBtn").prop('disabled', false);

              if($("#setTbodyTable input[type='checkbox']").length > 0){
                $("#approvalBtn").prop('disabled', false);
              }else{
                $("#approvalBtn").prop('disabled', true);
              }  
            }            
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      } else {
        if ($("#yearPlan").val() != '') {
          $.ajax({
            url: "{{ route('eam.ajax.plan.version-plan',['']) }}/" + $("#yearPlan").val(),
            method: 'GET',
            success: function (response) {
              if (response.data.length > 0) {
                versionPlanOfYear = +(Math.max.apply(Math, response.data.map(function(o) { return o.version_plan; }))) + 1;
                swal({
                  title: `ต้องการสร้าง ครั้งที่ ${versionPlanOfYear} หรือไม่`,
                  text: "",
                  type: "warning",
                  showCancelButton: true
                },
                function(){                  
                  $.ajax({
                    url: "{{ route('eam.ajax.plan.reservation-version') }}",
                    method: 'POST',
                    headers: {
                      'Accept': 'application/json',
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },    
                    data: JSON.stringify({
                      year_plan: $("#yearPlan").val(),
                      version_plan: versionPlanOfYear,
                      program_code: "EAM0006",
                      created_by_id: userIdPtwUser
                    }),            
                    success: function (response) {
                      if(response.status == 'duplicate'){
                        swal({
                          title: `ไม่สามารถสร้าง ครั้งที่ ${versionPlanOfYear} นี้ได้ เนื่องจากมีข้อมูลครั้งที่ซ้ำในระบบ  
                                  ดังนั้นข้อมูลจึงจะถูกปรับเปลี่ยนเป็นครั้งที่ ${response.data.version_plan} แทน`,
                          text: "",
                          type: "warning",
                          showCancelButton: true
                        },
                        function(){
                          $("#versionPlan").html(`<option value="${response.data.version_plan}">${response.data.version_plan}</option>`);
                          $("#statusPlan").val('Draft');
                          if($("#statusPlan").val() == 'Draft'){
                            $("#saveBtn").prop('disabled', false);
                            $("#addTableBtn").prop('disabled', false);
                            $("#deleteTableBtn").prop('disabled', false);

                            if($("#setTbodyTable input[type='checkbox']").length > 0){
                              $("#approvalBtn").prop('disabled', false);
                            }else{
                              $("#approvalBtn").prop('disabled', true);
                            }  
                          }
                        })
                      }else{
                        $("#versionPlan").html(`<option value="${response.data.version_plan}">${response.data.version_plan}</option>`);
                        $("#statusPlan").val('Draft');
                        if($("#statusPlan").val() == 'Draft'){
                          $("#saveBtn").prop('disabled', false);
                          $("#addTableBtn").prop('disabled', false);
                          $("#deleteTableBtn").prop('disabled', false);

                          if($("#setTbodyTable input[type='checkbox']").length > 0){
                            $("#approvalBtn").prop('disabled', false);
                          }else{
                            $("#approvalBtn").prop('disabled', true);
                          }  
                        }
                      }
                    },
                    error: function (jqXHR, textStatus, errorRhrown) {
                      swal("Error", jqXHR.responseJSON.message, "error");
                    }
                  })
                })
              } else {
                $("#versionPlan").html(`<option value="1">1</option>`);
                $("#statusPlan").val('Draft');
                if($("#statusPlan").val() == 'Draft'){
                  $("#saveBtn").prop('disabled', false);

                  if($("#setTbodyTable input[type='checkbox']").length > 0){
                    $("#approvalBtn").prop('disabled', false);
                  }else{
                    $("#approvalBtn").prop('disabled', true);
                  }  
                }
              }
              disabledBtn()
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        }
      }
    })
    $("#versionPlan").change(() => {
      clearDetail()
      $("#statusPlan").val($("#versionPlan").val());
      let oldVer = $("#versionPlan option:selected").attr("oldVer");
      $("#oldVersionPlan").val((oldVer != null && oldVer != 'null' && oldVer != '' && oldVer != undefined) ? oldVer : '' );
      disabledBtn();
    })

    $("#createBtn").click(() => {
      statusCreate = 'create'
      if ($("#yearPlan").val() === '') {
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

    $("#searchBtn").click(() => {
      statusBtn = 'search'
      $("#saveBtnHide").click();
    })

    $("#saveBtn").click(() => {
      statusBtn = 'save'
      if ($("#versionPlan").val() == '' || 
          $("#statusPlan").val() == '' || 
          $("#yearPlan").val() == ''        ) {
        $("#saveBtnHide").click();
      } else {
        $("#saveTableBtnHide").click();
      }
    })

    $("#approvalBtn").click(() => {
      let valueVersionPlan = $("#versionPlan option:selected").text();
      swal({
          title: `ต้องการยืนยันแผน ครั้งที่ ${valueVersionPlan} หรือไม่`,
          text: "",
          type: "warning",
          showCancelButton: true
      },
      function(){
        loader('show');
        $.ajax({
          url: "{{ route('eam.ajax.plan.confirm',['']) }}/" + planId,
          method: 'PUT',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          success: function (response) {
            $("#statusPlan").val(response.data.status_plan)
            if (response.data.status_plan == 'Confirm') {
              loader('show');
              $.ajax({
                url: "{{ route('eam.ajax.plan.version-plan',['']) }}/" + $("#yearPlan").val(),
                method: 'GET',
                success: function (response) {
                  if (response.data.length > 0) {
                    versionPlanOfYear = +(Math.max.apply(Math, response.data.map(function(o) { return o.version_plan; }))) + 1;                  
                  } else {
                    versionPlanOfYear = 1
                  }
                  loader('hide');
                },
                error: function (jqXHR, textStatus, errorRhrown) {
                  swal("Error", jqXHR.responseJSON.message, "error");
                  loader('hide');
                }
              })
              $("#openRepairWorkBtn").prop('disabled', false);
              $("#saveBtn").prop('disabled', false);  
              $("#approvalBtn").prop('disabled', true);
              $("#deleteTableBtn").prop('disabled', false);  
              $("#checkboxAllTable").prop('checked', false)
            } else {
              $("#openRepairWorkBtn").prop('disabled', true);
              $("#approvalBtn").prop('disabled', false);
            }
            loader('hide');
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
            loader('hide');
          }
        })
      })
    })

    $("#openRepairWorkBtn").click(() => {
      let dataSave = []
      $("#setTbodyTable input[type='checkbox']:checked").each(function() {
        let data = {
          asset_number:               $(this).find("td:eq(1) select").val(),
          asset_activity:             $(this).parents('tr').find("td:eq(3) select").val(),
          receiving_department_code:  $(this).find("td:eq(4) select").val() ? $(this).find("td:eq(4) select").val() : '',
          area:                       $(this).parents('tr').find("td:eq(5) input[type='text']").val(),
          scheduled_start_date:       $(this).parents('tr').find("td:eq(6) input[type='text']").val(),
          scheduled_completion_date:  $(this).parents('tr').find("td:eq(7) input[type='text']").val(),
          organization_id:            $(this).parents('tr').find("td:eq(11) input[type='text']").val(),
          op_wo_status:               $(this).parents('tr').find("td:eq(10) input[type='text']").val(),
          plan_line_id:               $(this).parents('tr').find("td:eq(12) input[type='text']").val()
        }
        dataSave.push(data)
      })
      if (dataSave.length > 0) {
        $.ajax({
            url: "{{ route('eam.ajax.plan.open-work-order',['']) }}",
            method: 'POST',
            data: JSON.stringify({
              program_code: "EAM0006",
              plan_id: planId,
              lines: dataSave
            }),
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
            success: function (response) {
              swal("Success", response.message, "success");
              $('#searchBtn').click();
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })

      } else {
        swal("กรุณาเลือกรายการ", "", "warning");
      }
    })

    $("#deleteTableBtn").click(() => {
      let dataSaveCheckAdd = []
      let dataSaveCheck = []
      let dataSave = []
      let dataHaveable = []
      $("#setTbodyTable input[type='checkbox']:checked").each(function() {
        if ($(this).parents('tr').find("td:eq(10) input[type='text']").val() != 'Y' && 
            $(this).parents('tr').find("td:eq(13) input[type='text']").val() != 'add') {
          let data = {
            asset_number:               $(this).find("td:eq(1) select").val(),
            asset_activity:             $(this).parents('tr').find("td:eq(3) select").val(),
            receiving_department_code:  $(this).find("td:eq(4) select").val() ? $(this).find("td:eq(4) select").val() : '',
            area:                       $(this).parents('tr').find("td:eq(5) input[type='text']").val(),
            scheduled_start_date:       $(this).parents('tr').find("td:eq(6) input[type='text']").val(),
            scheduled_completion_date:  $(this).parents('tr').find("td:eq(7) input[type='text']").val(),
            organization_id:            $(this).parents('tr').find("td:eq(11) input[type='text']").val(),
            op_wo_status:               $(this).parents('tr').find("td:eq(10) input[type='text']").val(),
            plan_line_id:               $(this).parents('tr').find("td:eq(12) input[type='text']").val()
          }
          dataSave.push(data);
        }
        dataSaveCheck.push('true');
        if ($(this).parents('tr').find("td:eq(13) input[type='text']").val() == 'add') {
          dataSaveCheckAdd.push($(this).parents('tr'));
        }else{
          dataHaveable.push($(this).parents('tr'));
        }
      })

      if (dataSaveCheck.length > 0) {
        if($("#statusPlan").val() == 'Draft'){
          if (dataSave.length > 0) {
            $.ajax({
              url: "{{ route('eam.ajax.plan.delete-line',['']) }}/" + planId,
              method: 'DELETE',
              data: JSON.stringify({
                program_code: "EAM0006",
                line: dataSave
              }),
              headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
              success: function (response) {
                swal("Success", response.message, "success");
                $('#searchBtn').click();
              },
              error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
              }
            })
          } else if (dataSaveCheckAdd.length != 0) {
            dataSaveCheckAdd.filter(row => {
              $(row).remove();
            })
            $("#checkboxAllTable").prop('checked', false);
          } else {
            swal("มีข้อมูล เลขที่ใบรับงาน และ สถานะการเปิดงานซ่อมเป็น Y จะไม่สามารถลบได้", "", "warning");
          }
        }else if($("#statusPlan").val() == 'Confirm') {
          if(dataHaveable.length != 0){
            $.ajax({
              url: "{{ route('eam.ajax.plan.version-plan',['']) }}/" + $("#yearPlan").val(),
              method: 'GET',
              success: function (response) {
                if (response.data.length > 0) {
                  versionPlanOfYear = +(Math.max.apply(Math, response.data.map(function(o) { return o.version_plan; }))) + 1;
                } else {
                  versionPlanOfYear = 1
                }
                $("#versionPlan").prop('disabled', false);
                let optionVersionPlan = ''
                optionVersionPlan += `<option value=""></option>`
                for (let data of response.data) {
                  if (data.version_plan) {
                    optionVersionPlan += `<option oldVer="${data.old_version_plan}" value="${data.status_plan}">${data.version_plan}</option>`
                  }
                }
                $("#versionPlan").html(optionVersionPlan);
                if($("#statusPlan").val() == 'Draft'){
                  $("#saveBtn").prop('disabled', false);
                  
                  if($("#setTbodyTable input[type='checkbox']").length > 0){
                    $("#approvalBtn").prop('disabled', false);
                  }else{
                    $("#approvalBtn").prop('disabled', true);
                  }  
                }

                swal({
                  title: `ต้องการสร้าง ครั้งที่ ${versionPlanOfYear} หรือไม่`,
                  text: "",
                  type: "warning",
                  showCancelButton: true
                },
                function(){
                  let dataSave = []
                  $("#setTbodyTable tr input[type='checkbox']:not(:checked)").each(function() {
                    let data = {
                      asset_number:               $(this).parents('tr').find("td:eq(1) select").val(),
                      asset_activity:             $(this).parents('tr').find("td:eq(3) select").val(),
                      receiving_department_code:  $(this).parents('tr').find("td:eq(4) select").val() ? 
                                                  $(this).parents('tr').find("td:eq(4) select").val() : '',
                      area:                       $(this).parents('tr').find("td:eq(5) input[type='text']").val(),
                      scheduled_start_date:       $(this).parents('tr').find("td:eq(6) input[type='text']").val(),
                      scheduled_completion_date:  $(this).parents('tr').find("td:eq(7) input[type='text']").val(),
                      organization_id:            $(this).parents('tr').find("td:eq(11) input[type='text']").val(),
                      op_wo_status:               $(this).parents('tr').find("td:eq(10) input[type='text']").val(),
                      plan_line_id:               $(this).parents('tr').find("td:eq(12) input[type='text']").val()
                    }
                    dataSave.push(data)                              
                  })

                  userIdPtwUser = ''
                  dataDropDownPtwUsers.filter(row => {
                    if (row.codeDescLov == $("#nameCreate").val()) {
                      userIdPtwUser = row.idLov
                    }
                  })

                  $.ajax({
                    url: "{{ route('eam.ajax.plan.reservation-version') }}",
                    method: 'POST',
                    headers: {
                      'Accept': 'application/json',
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: JSON.stringify({
                      year_plan: $("#yearPlan").val(),
                      version_plan: versionPlanOfYear,
                      status_plan: 'Draft',
                      program_code: "EAM0006",
                      line: dataSave,
                      created_by_id: userIdPtwUser,
                      current_version: $("#versionPlan option:selected").text()
                    }),
                    success: function (response) {                   
                      if(response.status == 'duplicate'){
                        swal({
                          title: `ไม่สามารถสร้าง ครั้งที่ ${versionPlanOfYear} นี้ได้ เนื่องจากมีข้อมูลครั้งที่ซ้ำในระบบ  
                                  ดังนั้นข้อมูลจึงจะถูกปรับเปลี่ยนเป็นครั้งที่ ${response.data.version_plan} แทน`,
                          text: "",
                          type: "warning",
                          showCancelButton: true
                        },
                        function(){
                          planId = response.data.plan_id
                          editConfirm = false
                          statusCreate = ''
                          $("#versionPlan").html(`<option value="${response.data.version_plan}">${response.data.version_plan}</option>`);
                          $("#statusPlan").val('Draft');
                          swal("Success", response.message, "success");
                          $("#addTableBtn").prop('disabled', false)
                          $("#deleteTableBtn").prop('disabled', false)
                          $("#nameCreate").prop('disabled', true)
                          $("#nameCreateBtn").prop('disabled', true);
                          if ($("#statusPlan").val() == 'Confirm') {
                            $("#openRepairWorkBtn").prop('disabled', false);
                            $("#saveBtn").prop('disabled', false);  
                            $("#approvalBtn").prop('disabled', true);
                          } else if ($("#statusPlan").val() == 'Draft') {
                            $("#saveBtn").prop('disabled', false);

                            if($("#setTbodyTable input[type='checkbox']").length > 0){
                              $("#approvalBtn").prop('disabled', false);
                            }else{
                              $("#approvalBtn").prop('disabled', true);
                            }  
                          } else {
                            $("#openRepairWorkBtn").prop('disabled', true);
                            $("#approvalBtn").prop('disabled', false);
                          }
                          $('#searchBtn').click();
                        })
                      }else{
                        planId = response.data.plan_id
                        editConfirm = false
                        statusCreate = ''
                        $("#versionPlan").html(`<option value="${response.data.version_plan}">${response.data.version_plan}</option>`);
                        $("#statusPlan").val('Draft');
                        swal("Success", response.message, "success");
                        $("#addTableBtn").prop('disabled', false)
                        $("#deleteTableBtn").prop('disabled', false)
                        $("#nameCreate").prop('disabled', true)
                        $("#nameCreateBtn").prop('disabled', true);
                        if ($("#statusPlan").val() == 'Confirm') {
                          $("#openRepairWorkBtn").prop('disabled', false);
                          $("#saveBtn").prop('disabled', false);  
                          $("#approvalBtn").prop('disabled', true);
                        } else if ($("#statusPlan").val() == 'Draft') {
                          $("#saveBtn").prop('disabled', false);

                          if($("#setTbodyTable input[type='checkbox']").length > 0){
                            $("#approvalBtn").prop('disabled', false);
                          }else{
                            $("#approvalBtn").prop('disabled', true);
                          }  
                        } else {
                          $("#openRepairWorkBtn").prop('disabled', true);
                          $("#approvalBtn").prop('disabled', false);
                        }
                        $('#searchBtn').click();
                      }
                    },
                    error: function (jqXHR, textStatus, errorRhrown) {
                      swal("Error", jqXHR.responseJSON.message, "error");
                    }
                  })
                })
              },
              error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
              }
            })
          }
          
          if (dataSaveCheckAdd.length != 0){
            dataSaveCheckAdd.filter(row => {
              $(row).remove();
            })
            $("#checkboxAllTable").prop('checked', false);
          }          
        }else if($("#statusPlan").val() == ''){
          if (dataSaveCheckAdd.length != 0){
            dataSaveCheckAdd.filter(row => {
              $(row).remove();
            })
            $("#checkboxAllTable").prop('checked', false);
          }    
        }
      }else {
        swal("กรุณาเลือกรายการ", "", "warning");
      }
    })

    function formSaveBtnHide(cur,last) {
      if ( statusBtn == 'search' && $("#yearPlan").val() != '' && statusCreate != 'create') {
        if( last > 1 && cur == last){  $('#p'+ cur).parent('li').addClass('active');  }
        let version =  $("#versionPlan option:selected").text() ||'version';
        let page = cur || 1;

        loader('show');
        $.ajax({
          url: "{{ route('eam.ajax.plan.search',['','/']) }}/" + $("#yearPlan").val() + '/' + version,
          method: 'GET',
          data: {
            'asset_number':               $("#assetNumber").val(),
            'asset_group_id':             $("#machineGroup").val(),
            'asset_activity':             $("#activitiesToDo").val(),
            'receiving_department_code':  $("#notifyingAgency").val() ? $("#notifyingAgency").val() : '',
            'area':                       $("#area").val(),
            'scheduled_start_date':       $("#repairStartDate").val(),
            'scheduled_completion_date':  $("#repairEndDate").val(),
            'op_wo_status':               $("#repairOpenStatus").val(),
            'page' :                      page
          },
          success: function (response) {
            planId = response.data.head.plan_id
            editConfirm = false
            statusCreate = ''
            setTablePreventiveFn(response.data.pages.data)
            $("#versionPlan").prop('disabled', true)
            $("#assetNumber").prop('disabled', false)
            $("#machineGroup").prop('disabled', false)
            $("#notifyingAgency").prop('disabled', false)
            $("#activitiesToDo").prop('disabled', false)
            $("#area").prop('disabled', false)
            $("#areaLovBtn").prop('disabled', false)
            $("#repairOpenStatus").prop('disabled', false)
            $("#repairStartDate").prop('disabled', false)
            $("#repairEndDate").prop('disabled', false)
            vmDatePicker.repairStartDate.disabled = false
            vmDatePicker.repairEndDate.disabled = false
            $("#assetNumberLovBtn").prop('disabled', false)
            $("#notifyingAgencyLovBtn").prop('disabled', false)
            $("#addTableBtn").prop('disabled', false)
            $("#deleteTableBtn").prop('disabled', false)
            $("#checkboxAllTable").prop('checked', false)
            disabledBtn()
            $("#oldVersionPlan").val(response.data.head.old_version_plan);
            if (response.data.head.user_name) {
              $.ajax({
                url: "{{ route('eam.ajax.lov.ptw-user') }}",
                method: 'GET',
                data: {
                  'search_param': response.data.head.user_name,
                },
                success: function (response2) {
                  response2.data.filter(row => {
                    if (row.name == response.data.head.user_name) {
                      row.idLov = row.user_id
                      row.codeLov = row.username
                      row.descLov = row.name
                      row.codeDescLov = row.username + ' : ' + row.name
                      dataDropDownPtwUsers.push(row)
                      $("#nameCreate").val(row.username ? row.username + ' : ' + row.name : '');
                    }
                  })
                },
                error: function (jqXHR, textStatus, errorRhrown) {
                  swal("Error", jqXHR.responseJSON.message, "error");
                }
              })
            }

            genpage(response.data.pages.current_page,response.data.pages.last_page,response.data.pages.total)
            
            if(versionNotification && yearNotification){
              $("#statusPlan").val(response.data.head.status_plan);
            }

            if( !$("#versionPlan option:selected").val()  && 
                 $("#yearPlan").val()                          ){
              $("#approvalBtn").prop('disabled', true);
              $("#fileBtn").prop('disabled', true);
              $("#saveBtn").prop('disabled', true);
            }else{
              if ($("#statusPlan").val() == 'Confirm') {
                $("#openRepairWorkBtn").prop('disabled', false);
                $("#saveBtn").prop('disabled', false);  
                $("#approvalBtn").prop('disabled', true);
              } else if ($("#statusPlan").val() == 'Cancelled'){
                $("#approvalBtn").prop('disabled', true);
              } else if ($("#statusPlan").val() == 'Draft') {
                $("#saveBtn").prop('disabled', false);
                
                if($("#setTbodyTable input[type='checkbox']").length > 0){
                  $("#approvalBtn").prop('disabled', false);
                }else{
                  $("#approvalBtn").prop('disabled', true);
                }                                    
              } else {
                $("#openRepairWorkBtn").prop('disabled', true);
                $("#approvalBtn").prop('disabled', false);
                $("#saveBtn").prop('disabled', false);
              }
              $("#fileBtn").prop('disabled', false);
            }
            triggerSelect2();
            loader('hide');
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
            loader('hide');
          }
        })
      }  else if (statusBtn == 'upload') {
        $('#detailModalExcelForm').attr('action', "{{ route('eam.ajax.plan.file-import') }}")
        $("#modalModalExcelBtnHidden").click();
      }
    }

    function genpage(cur,last,total){
      let paginateTemp="";
      let page_text="";
      let curr=cur;
      let lastp=last;
      let s_page=0;
      let e_page=0;

      if(lastp <=5) {
        s_page=1;
        e_page=lastp;
      } else if (lastp >=6){
          if(curr<=3){
            s_page=1;
            e_page=5;
          }
          else if(curr >=4 && curr+2 <= lastp){
            s_page=curr-2;
            e_page=curr+2;
          } else {
            s_page=curr-2;
            e_page=lastp;
          }
      }
          for(let s = s_page; s <= e_page; s++){
            page_text += `<li class="page-item"><a class="page-link" id="p`+s+`" >`+ s +`</a></li>
                                  `;
          }
          paginateTemp += `<nav aria-label="Page navigation example" id="nav-tran">
                            <ul class="pagination">
                              <li class="page-item"><a class="page-link" >First Page</a></li>
                          `;
          paginateTemp += page_text;
          paginateTemp += `<li class="page-item"><a class="page-link" >Last Page</a></li>
                            </ul>
                          </nav>`;

          if(lastp<=1){
              $('#setTablePagination').html('');
          } else {
              $('#setTablePagination').html(paginateTemp);
          }

          $('#p'+ cur).parent('li').addClass('active');

          $('#nav-tran li a').click(function(){
            if($(this).text()=="First Page"){
              $('#nav-tran li.active').removeClass('active')
              $('#p1').parent('li').addClass('active')
              curr=1;

            } else if ($(this).text()=="Last Page"){
              $('#nav-tran li.active').removeClass('active')
              curr=last;

            } else {
              $('#nav-tran li.active').removeClass('active')
              $(this).parent('li').addClass('active')
              curr=$(this).text();

            }
            formSaveBtnHide(curr,last)
          })
    }

    function formSaveTableBtnHide() {
      if (editConfirm) {
        swal({
          title: `ต้องการสร้าง ครั้งที่ ${versionPlanOfYear} หรือไม่`,
          text: "",
          type: "warning",
          showCancelButton: true
        },
        function(){
          let dataSave = []
          $("#setTbodyTable tr ").each(function() {
            let data = {
              asset_number:               $(this).find("td:eq(1) select").val(),
              asset_activity:             $(this).find("td:eq(3) select").val(),
              receiving_department_code:  $(this).find("td:eq(4) select").val() ? 
                                          $(this).find("td:eq(4) select").val() : '',
              area:                       $(this).find("td:eq(5) input[type='text']").val(),
              scheduled_start_date:       $(this).find("td:eq(6) input[type='text']").val(),
              scheduled_completion_date:  $(this).find("td:eq(7) input[type='text']").val(),
              organization_id:            $(this).find("td:eq(11) input[type='text']").val(),
              op_wo_status:               $(this).find("td:eq(10) input[type='text']").val(),
              plan_line_id:               $(this).find("td:eq(12) input[type='text']").val()
            }
            dataSave.push(data)
          })
          userIdPtwUser = ''
          dataDropDownPtwUsers.filter(row => {
            if (row.codeDescLov == $("#nameCreate").val()) {
              userIdPtwUser = row.idLov
            }
          })
          $.ajax({
            url: "{{ route('eam.ajax.plan.store') }}",
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: JSON.stringify({
              year_plan:            $("#yearPlan").val(),
              version_plan:         versionPlanOfYear,
              status_plan:          'Draft',
              program_code:         "EAM0006",
              line:                 dataSave,
              created_by_id:        userIdPtwUser,
              current_status_plan:  $("#statusPlan").val(),
              current_version:      $("#versionPlan option:selected").text()
            }),
            success: function (response) {
              if(response.data.original.status == "duplicate"){
                swal({
                      title: `ไม่สามารถสร้าง ครั้งที่ ${versionPlanOfYear} นี้ได้ เนื่องจากมีข้อมูลครั้งที่ซ้ำในระบบ  
                              ดังนั้นข้อมูลจึงจะถูกปรับเปลี่ยนเป็นครั้งที่ ${response.data.original.data.version_plan} แทน`,
                      text: "",
                      type: "warning",
                      showCancelButton: true
                    },
                    function(){
                      planId = response.data.original.data.plan_id
                      editConfirm = false
                      statusCreate = ''
                      $("#versionPlan").html(`<option value="${response.data.original.data.version_plan}">${response.data.original.data.version_plan}</option>`);
                      $("#statusPlan").val('Draft');
                      $("#addTableBtn").prop('disabled', false)
                      $("#deleteTableBtn").prop('disabled', false)
                      $("#nameCreate").prop('disabled', true)
                      $("#nameCreateBtn").prop('disabled', true);
                      if ($("#statusPlan").val() == 'Confirm') {
                        $("#openRepairWorkBtn").prop('disabled', false);
                        $("#saveBtn").prop('disabled', false);  
                        $("#approvalBtn").prop('disabled', true);
                      } else if ($("#statusPlan").val() == 'Draft') {
                        $("#saveBtn").prop('disabled', false);

                        if($("#setTbodyTable input[type='checkbox']").length > 0){
                          $("#approvalBtn").prop('disabled', false);
                        }else{
                          $("#approvalBtn").prop('disabled', true);
                        }  
                      } else {
                        $("#openRepairWorkBtn").prop('disabled', true);
                        $("#approvalBtn").prop('disabled', false);
                      }
                      $('#searchBtn').click();
                    })
              }else{
                planId = response.data.plan_id
                editConfirm = false
                statusCreate = ''
                $("#versionPlan").html(`<option value="${versionPlanOfYear}">${versionPlanOfYear}</option>`);
                $("#statusPlan").val('Draft');
                swal("Success", response.message, "success");
                $("#addTableBtn").prop('disabled', false)
                $("#deleteTableBtn").prop('disabled', false)
                $("#nameCreate").prop('disabled', true)
                $("#nameCreateBtn").prop('disabled', true);
                if ($("#statusPlan").val() == 'Confirm') {
                  $("#openRepairWorkBtn").prop('disabled', false);
                  $("#saveBtn").prop('disabled', false);  
                  $("#approvalBtn").prop('disabled', true);
                } else if ($("#statusPlan").val() == 'Draft') {
                  $("#saveBtn").prop('disabled', false);

                  if($("#setTbodyTable input[type='checkbox']").length > 0){
                    $("#approvalBtn").prop('disabled', false);
                  }else{
                    $("#approvalBtn").prop('disabled', true);
                  }  
                } else {
                  $("#openRepairWorkBtn").prop('disabled', true);
                  $("#approvalBtn").prop('disabled', false);
                }
                $('#searchBtn').click();
              }              
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        })
      } else {
        if (statusBtn == 'save') {
          let dataSave = []
          $("#setTbodyTable tr ").each(function() {
            let data = {
              asset_number:               $(this).find("td:eq(1) select").val(),
              asset_activity:             $(this).find("td:eq(3) select").val(),
              receiving_department_code:  $(this).find("td:eq(4) select").val() ? $(this).find("td:eq(4) select").val() : '',
              area:                       $(this).find("td:eq(5) input[type='text']").val() ? 
                                          $(this).find("td:eq(5) input[type='text']").val() : '',
              scheduled_start_date:       $(this).find("td:eq(6) input[type='text']").val(),
              scheduled_completion_date:  $(this).find("td:eq(7) input[type='text']").val(),
              organization_id:            $(this).find("td:eq(11) input[type='text']").val(),
              op_wo_status:               $(this).find("td:eq(10) input[type='text']").val(),
              plan_line_id:               $(this).find("td:eq(12) input[type='text']").val()
            }
            dataSave.push(data)
          })
          userIdPtwUser = ''
          dataDropDownPtwUsers.filter(row => {
            if (row.codeDescLov == $("#nameCreate").val()) {
              userIdPtwUser = row.idLov
            }
          })
          $.ajax({
            url: "{{ route('eam.ajax.plan.store') }}",
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: JSON.stringify({
              year_plan:        $("#yearPlan").val(),
              version_plan:     $("#versionPlan option:selected").text(),
              status_plan:      $("#statusPlan").val(),
              program_code:     "EAM0006",
              line:             dataSave,
              created_by_id:    userIdPtwUser
            }),
            success: function (response) {
              planId = response.data.plan_id
              editConfirm = false
              statusCreate = ''
              swal("Success", response.message, "success");
              $("#addTableBtn").prop('disabled', false)
              $("#deleteTableBtn").prop('disabled', false)
              $("#nameCreate").prop('disabled', true)
              $("#nameCreateBtn").prop('disabled', true);
              if ($("#statusPlan").val() == 'Confirm') {
                $("#openRepairWorkBtn").prop('disabled', false);
                $("#saveBtn").prop('disabled', false);  
                $("#approvalBtn").prop('disabled', true);
              } else {
                $("#openRepairWorkBtn").prop('disabled', true);
                $("#approvalBtn").prop('disabled', false);
              }
              $('#searchBtn').click();
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        }
      }
    }

    $("#PMreportBtn").click(function(){
      let y = $("#PMreportYear option:selected").val();
      let u = $("#PMreportUser option:selected").val();

      let o = '';
      if($("#PMreportDepOwner option:selected").val()){ o = $("#PMreportDepOwner option:selected").val(); }

      let r = '';
      if($("#PMreportDepResponse option:selected").val()){ r = $("#PMreportDepResponse option:selected").val(); }

      if(!y){
        swal("Error", "กรุณาใส่ข้อมูล ปีงบประมาณ", "error");
      } else {
        location.replace( "/eam/emp0003-excel/?year="+y+"&user="+u+"&owner="+o+"&response="+r );
      }
    });

    $("#printBtn").click(() => {
      $("#PMreportModal").modal('show');

      $("#PMreportDepOwner").val('');
      $("#PMreportDepResponse").val('');

      $('#PMreportUser').append('<option value='+defaultUser.user_id+'>'+ defaultUser.username + ' - ' + defaultUser.name + '</option>');
      $('#PMreportUser').val(defaultUser.user_id).trigger('change');
      $('#PMreportUser').select2({
        dropdownParent: $('#PMreportModal'),
        ajax: {
            url: '/eam/LovPMreportUser',
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                search_param :  params.term,
                p_limit :       20
              };
            },
            processResults: function (data) {
              return {
                results:  $.map(data.data, function (item) {
                  return {
                    text: item.username + " - " + item.name,
                    id: item.user_id
                  }
                })
              };
            },
          cache: true
        }
      });
      let y = new Date().getFullYear() + 543;
      $('#PMreportYear').append('<option value='+y+'>'+y+'</option>');
      $('#PMreportYear').val(y).trigger('change');
      $('#PMreportYear').select2({
        dropdownParent: $('#PMreportModal'),
        ajax: {
            url: '/eam/LovPMreportYear',
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                search_param : params.term
              };
            },
            processResults: function (data) {
              return {
                results:  $.map(data.data, function (item) {
                  return {
                    text: item.year_thai,
                    id: item.year_thai
                  }
                })
              };
            },
            cache: true
        }
      });

      $("#PMreportDepOwnerReset").hide();
      $("#PMreportDepResponseReset").hide();

      $('#PMreportDepOwner').select2({
        dropdownParent: $('#PMreportModal'),
        ajax: {
            url: '/eam/LovPMreportDep',
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                search_param : params.term
              };
            },
            processResults: function (data) {
              $("#PMreportDepOwnerReset").show();
              return {
                results:  $.map(data.data, function (item) {                  
                  return {
                    text: item.department_code + ' - ' + item.description,
                    id: item.department_code
                  }
                })
              };
            },
            cache: true
        }
      });

      var newOptionPMreportDepOwner = new Option(defaultUser.department_code + ' - ' + defaultUser.department.description, defaultUser.department_code, true, true);
      $('#PMreportDepOwner').append(newOptionPMreportDepOwner).trigger('change');
      $('#PMreportDepOwner').val(defaultUser.department_code).trigger('change');

      $("#PMreportDepOwnerReset").click(() => {
        $('#PMreportDepOwner').val(null).trigger('change');
        $("#PMreportDepOwnerReset").hide();
      });

      $('#PMreportDepResponse').select2({
        dropdownParent: $('#PMreportModal'),
        ajax: {
            url: '/eam/LovPMreportDep',
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                search_param : params.term
              };
            },
            processResults: function (data) {
              $("#PMreportDepResponseReset").show();
              return {
                results:  $.map(data.data, function (item) {
                  return {
                    text: item.department_code + ' - ' + item.description,
                    id: item.department_code
                  }
                })
              };
            },
            cache: true
        }
      });

      $("#PMreportDepResponseReset").click(() => {
        $('#PMreportDepResponse').val(null).trigger('change');
        $("#PMreportDepResponseReset").hide();
      });

    })

    $("#fileBtn").click(() => {
      $("#modalFile").val('');
      $('.custom-file-label').html('');
      $("#detailModalExcel").modal('show');
      if($("#statusPlan").val() == 'Confirm'){
        editConfirm = true;
      }
    })

    $('#modalFile').on('change',function(){
      var fileName = $(this).val();
      $(this).next('.custom-file-label').html(fileName);
    })

    $("#modalModalImageAddBtn").click(() => {
      $('#detailModalExcelForm').attr('action', "{{ route('eam.ajax.plan.file-import') }}")
      $("#modalModalExcelBtnHidden").click();
    })

    $('#detailModalExcelForm').submit(function(evt) {      
      evt.preventDefault();
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(response) {
          swal({
            title: "Success",
            text: response.message,
            type: "success"
          },
          function(){
            setTablePreventiveExcelFn(response.data)
            $("#detailModalExcel").modal('hide');
          })
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      });
    });

    $("#addTableBtn").click(()=>{
      setAddTablePreventive();
    })
    function setAddTablePreventive() {
      let indexTb = 0
      $("#setTbodyTable tr").each(function(index) {
        indexTb = $(this).find("td:eq(6) input[type='text']").attr('id')
      })
      if (indexTb != 0) {
        if (isNaN(+indexTb.split('dateTableStart')[1])) {
          indexTb = +indexTb.split('dateTableStartAdd')[1] + 1
        } else {
          indexTb = +indexTb.split('dateTableStart')[1] + 1
        }
      }
      let tbodyTablePreventive = ''
      let optionActivity = ''
      optionActivity += `<option value=""></option>`
      tbodyTablePreventive += `<tr>`
      tbodyTablePreventive += `<td class="text-center">
                                <input  type="checkbox" 
                                        name="case[]"
                                        onclick="checkValueCheckBox()">
                              </td>`
      tbodyTablePreventive += `<td>
                                <div class="input-group">
                                  <select   id="assetNumber_`+ indexTb +`" 
                                            class="assetNumber form-control clearable readonly" 
                                            data-server="/eam/ajax/lov/assetnumber"  
                                            data-id="asset_number" 
                                            data-text="description" 
                                            data-field="select"                                            
                                            required
                                            data-selectEAM0006AssetNumber="assetNumber_`+ indexTb +`"
                                            data-typeEAM0006AssetNumber="lovAssetNumber_`+ indexTb +`">
                                  </select>
                                  <div class="input-group-append">
                                    <span class="input-group-append">
                                      <button onclick="assetNumberLovBtnDesc({data1: this, data2: 'td:eq(2)', data3: 'td:eq(5)', data4: 'td:eq(4)'})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </span>
                                  </div>
                                </div>
                              </td>`
      tbodyTablePreventive += `<td><input type="text" 
                                          class="form-control" 
                                          value="" 
                                          disabled 
                                          autocomplete="off"
                                          id="label_assetNumber_`+ indexTb +`"
                                          style="color: #000000; background-color :#eeeeee; font-size: 13px;"></td>`
      tbodyTablePreventive += `<td><select class="activityToDo form-control" >`+optionActivity+`</select></td>`
      tbodyTablePreventive += `<td>
                                <div class="input-group">
                                  <select id="department_`+ indexTb +`"
                                          class="form-control clearable readonly" 
                                          data-server="/eam/ajax/lov/departments"  
                                          data-id="department_code" 
                                          data-text="description" 
                                          data-field="select"
                                          required>
                                  </select>
                                  <div class="input-group-append">
                                    <span class="input-group-append">
                                      <button onclick="departmentLovBtnTableOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: this})" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </span>
                                  </div>
                                </div>
                              </td>`
      tbodyTablePreventive += `<td><input type="text" 
                                          class="form-control" 
                                          value="" 
                                          disabled 
                                          autocomplete="off"
                                          id="area_`+ indexTb +`"
                                          style="color: #000000; background-color :#eeeeee; font-size: 13px;"></td>`
      tbodyTablePreventive += `<td><input id="dateTableStartAdd${indexTb}" type="text" class="form-control" autocomplete="off"></td>`
      tbodyTablePreventive += `<td><input id="dateTableEndAdd${indexTb}" type="text" class="form-control" autocomplete="off"></td>`
      tbodyTablePreventive += `<td><input type="text" 
                                          class="form-control" 
                                          value="" 
                                          disabled 
                                          autocomplete="off"
                                          style="color: #000000; background-color :#eeeeee; font-size: 13px;"></td>`
      tbodyTablePreventive += `<td><input type="text" 
                                          class="form-control" 
                                          value="" 
                                          disabled 
                                          autocomplete="off"
                                          style="color: #000000; background-color :#eeeeee; font-size: 13px;"></td>`
      tbodyTablePreventive += `<td class="d-none"><input type="text" class="for-control" value="" hidden autocomplete="off"></td>`
      tbodyTablePreventive += `<td class="d-none"><input type="text" class="form-control" value="" hidden autocomplete="off"></td>`
      tbodyTablePreventive += `<td class="d-none"><input type="text" class="form-control" value="" hidden autocomplete="off"></td>`
      tbodyTablePreventive += `<td class="d-none"><input type="text" class="form-control" value="add" hidden autocomplete="off"></td>`
      tbodyTablePreventive += `</tr>`
      $("#setTbodyTable").append(tbodyTablePreventive);
      setSelect2InEAM0006();
      triggerSelect2();

      setDatePicker({idDate: `dateTableStartAdd${indexTb}`, nameDate: '', onchange: true, date: '', disabled: false, required: true, dateEndId: `dateTableEndAdd${indexTb}`});
      setDatePicker({idDate: `dateTableEndAdd${indexTb}`, nameDate: '', onchange: true, date: '', disabled: false, required: true});

      $('#assetNumber_' + indexTb).on('select2:select', function (e) {
        $(this).select2('data')[0].text = $(this).select2('data')[0].id;
      });

      $('#assetNumber_' + indexTb).on('select2:clear', function (e) {
        $('#label_assetNumber_'+ indexTb).val('');
        $('#department_'+ indexTb).val('').trigger('change');
        $('#area_'+ indexTb).val('');
        $('#depadateTableStartAddrtment'+ indexTb).val('').trigger('change');
        $('#dateTableEndAdd'+ indexTb).val('').trigger('change');
      });

      if ($("#statusPlan").val() == 'Confirm') {
        editConfirm = true
        $("#openRepairWorkBtn").prop('disabled', false);
        $("#saveBtn").prop('disabled', false);  
        $("#approvalBtn").prop('disabled', true);
      }
      readonly();
      changeActivityToDo();      
    }
    function setTablePreventiveFn(data) {
      let tbodyTablePreventive = ''
      if (data.length > 0) {
        data.filter((row, index) => {                 
          let optionActivity = ''
          optionActivity += `<option value=""></option>`
          for (let data of dataDropDownActivityToDo) {
            if (data.asset_number == row.asset_number)
            optionActivity += `<option value="${data.activity}" ${row.asset_activity == data.activity ? 'selected' : ''}>${data.description}</option>`
          }
          let wipEntityName = ''
          let disabledBtn = (row.op_wo_status == 'Y' || row.is_cancelled);
          if (row.organization_id) {
            wipEntityName = `<a href='${row.preventive_default_url}'">
                                <u>
                                  <input  type="text" 
                                          class="form-control pointer" 
                                          value="${row.wip_entity_name ? row.wip_entity_name : ''}" 
                                          disabled 
                                          autocomplete="off"
                                          style="color: #000000; background-color :#eeeeee; font-size: 13px;">
                                </u>
                              </a>`
          } else {
            wipEntityName = `<input type="text" 
                                    class="form-control" 
                                    value="" 
                                    disabled 
                                    autocomplete="off"
                                    style="color: #000000; background-color :#eeeeee; font-size: 13px;">`
          }

          tbodyTablePreventive += `<tr>`
          tbodyTablePreventive += `<td class="text-center">
                                    <input  ${disabledBtn ? 'disabled' : ''} 
                                            type="checkbox" 
                                            name="case[]"
                                            onclick="checkValueCheckBox()">
                                  </td>`
          tbodyTablePreventive += `<td>
                                    <div class="input-group">
                                      <select id="assetNumberShow_`+ index +`" 
                                              class="assetNumber form-control clearable readonly" 
                                              data-server="/eam/ajax/lov/assetnumber"  
                                              data-id="asset_number" 
                                              data-text="description" 
                                              data-field="select"
                                              required
                                              ${disabledBtn ? 'disabled' : ''}
                                              data-selectEAM0006AssetNumber="assetNumberShow_`+ index +`"
                                              data-typeEAM0006AssetNumber="lovAssetNumberShow_`+ index +`">
                                      </select>
                                      <div class="input-group-append">
                                        <span class="input-group-append">
                                          <button onclick="assetNumberLovBtnDesc({data1: this, data2: 'td:eq(2)', data3: 'td:eq(5)', data4: 'td:eq(4)'})" 
                                                  type="button" 
                                                  class="btn btn-default" ${disabledBtn ? 'disabled' : ''}><i class="fa fa-search"></i></button>
                                        </span>
                                      </div>
                                    </div>
                                  </td>`
          tbodyTablePreventive += `<td><input type="text" 
                                              class="form-control" 
                                              value="${row.asset_desc ? row.asset_desc : ''}" 
                                              disabled 
                                              autocomplete="off"
                                              id="label_assetNumberShow_`+ index +`"
                                              style="color: #000000; background-color :#eeeeee; font-size: 13px;">
                                    </td>`
          tbodyTablePreventive += `<td><select class="activityToDo form-control" ${disabledBtn ? 'disabled' : ''} >`+optionActivity+`</select></td>`
          tbodyTablePreventive += `<td>
                                    <div class="input-group">
                                      <select id="departmentShow_`+ index +`"
                                              class="form-control clearable readonly" 
                                              data-server="/eam/ajax/lov/departments"  
                                              data-id="department_code" 
                                              data-text="description" 
                                              data-field="select"
                                              required
                                              ${disabledBtn ? 'disabled' : ''}>
                                      </select>
                                      <div class="input-group-append">
                                        <span class="input-group-append">
                                          <button onclick="departmentLovBtnTableOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: this})" type="button" class="btn btn-default" ${disabledBtn ? 'disabled' : ''}><i class="fa fa-search"></i></button>
                                        </span>
                                      </div>
                                    </div>
                                  </td>`
          tbodyTablePreventive += `<td><input id="areaShow_`+ index +`"
                                              type="text" 
                                              class="form-control" 
                                              value="${row.area ? row.area : ''}" 
                                              disabled 
                                              autocomplete="off"
                                              style="color: #000000; background-color :#eeeeee; font-size: 13px;"></td>`
          tbodyTablePreventive += `<td><input id="dateTableStart${index}" type="text" class="form-control" autocomplete="off"></td>`
          tbodyTablePreventive += `<td><input id="dateTableEnd${index}" type="text" class="form-control" autocomplete="off"></td>`
          tbodyTablePreventive += `<td>`+wipEntityName+`</td>`
          tbodyTablePreventive += `<td><input type="text" 
                                              class="form-control" 
                                              value="${row.status_desc ? row.status_desc : ''}" 
                                              disabled 
                                              autocomplete="off"
                                              style="color: #000000; background-color :#eeeeee; font-size: 13px;"></td>`
          tbodyTablePreventive += `<td class="d-none"><input type="text" class="form-control" value="${row.op_wo_status ? row.op_wo_status : ''}" hidden autocomplete="off"></td>`
          tbodyTablePreventive += `<td class="d-none"><input type="text" class="form-control" value="${row.organization_id ? row.organization_id : ''}" hidden autocomplete="off"></td>`
          tbodyTablePreventive += `<td class="d-none"><input type="text" class="form-control" value="${row.plan_line_id ? row.plan_line_id : ''}" hidden autocomplete="off"></td>`
          tbodyTablePreventive += `<td class="d-none"><input type="text" class="form-control" value="" hidden autocomplete="off"></td>`
          tbodyTablePreventive += `</tr>` 
        })
      }
      $("#setTbodyTable").html(tbodyTablePreventive);

      data.filter((row, index) => {
        //Default รหัสเครื่องจักร
        var newOptionAssetNumber = new Option(row.asset_number, row.asset_number, true, true);
        $('#assetNumberShow_'+ index).append(newOptionAssetNumber).trigger('change');
        $('#assetNumberShow_'+ index).val(row.asset_number).trigger('change');

        $('#assetNumberShow_' + index).on('select2:select', function (e) {
          $(this).select2('data')[0].text = $(this).select2('data')[0].id;
        });

        $('#assetNumberShow_' + index).on('select2:clear', function (e) {
          $('#label_assetNumberShow_'+ index).val('');
          $('#departmentShow_'+ index).val('').trigger('change');
          $('#areaShow_'+ index).val('');

          triggerSelect2();
        });

        //Default หน่วยงานผู้รับแจ้ง
        var newOptionDepartment = new Option(row.receiving_department_code + ' - ' +row.receiving_department_desc, row.receiving_department_code, true, true);
        $('#departmentShow_'+ index).append(newOptionDepartment).trigger('change');
        $('#departmentShow_'+ index).val(row.receiving_department_code).trigger('change');
          
        setDatePicker({idDate: `dateTableStart${index}`, nameDate: '', onchange: true, date: `${row.scheduled_start_date ? row.scheduled_start_date : ''}`, disabled: row.is_cancelled, required: true, dateEndId: `dateTableEnd${index}`});
        setDatePicker({idDate: `dateTableEnd${index}`, nameDate: '', onchange: true, date: `${row.scheduled_completion_date ? row.scheduled_completion_date : ''}`, disabled: row.is_cancelled, required: true});
        vmDatePicker[`dateTableEnd${index}`].pDisabled = row.scheduled_start_date;
      })

      readonly();
      changeActivityToDo();
      setSelect2InEAM0006();
    }
    function setTablePreventiveExcelFn(data) {
      if (data.length > 0) {
        let sum = 0
        loader('show');
        data.filter((row, index) => {
          $.ajax({
            url: "{{ route('eam.ajax.lov.asset-number') }}",
            method: 'GET',
            data: {
              'p_asset_number': row.asset_number,
              'p_description': '',
              'p_serial_number': '',
              'p_department': ''
            },
            success: function (response) {
              if (response.data.length > 0) {
                row.area = response.data[0].area_code
                row.asset_desc = response.data[0].description
              }
              sum += 1
              if (sum == data.length) {
                setTablePreventiveExcelFn2(data)
              }
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              sum += 1
              if (sum == data.length) {
                setTablePreventiveExcelFn2(data)
              }
            }
          })
        })
      }
    }
    function setTablePreventiveExcelFn2(data) {
      if (data.length > 0) {
        let sum = 0
        data.filter((row, index) => {
          $.ajax({
            url: "{{ route('eam.ajax.lov.departments') }}",
            method: 'GET',
            data: {
              'p_department_code': row.receiving_department_code,
              'p_description': '',
            },
            success: function (response) {
              if (response.data.length > 0) {
                row.receiving_department_desc = response.data[0].description
              }
              sum += 1
              if (sum == data.length) {
                setTablePreventiveExcelFn3(data)
              }
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              sum += 1
              if (sum == data.length) {
                setTablePreventiveExcelFn3(data)
              }
            }
          })
        })
      }
    }
    function setTablePreventiveExcelFn3(data) {
      let indexTb = 0
      let indexTbExcel = 0
      $("#setTbodyTable tr ").each(function() {
        if ($(this).find("td:eq(6) input[type='text']").attr('id').substring(0, 19) ==  'dateTableStartExcel') {
          $(this).remove();
        }
      })

      $("#setTbodyTable tr").each(function(index) {
        indexTb = index
        indexTbExcel = index
      })
      indexTb += 1
      indexTbExcel += 1

      let tbodyTablePreventive = ''
      if (data.length > 0) {

        data.filter((row, index) => {
          let optionActivity = ''
          optionActivity += `<option value=""></option>`
          for (let data of dataDropDownActivityToDo) {
            if (data.asset_number == row.asset_number)
            optionActivity += `<option value="${data.activity}" ${row.asset_activity == data.activity ? 'selected' : ''}>${data.description}</option>`
          }
          let wipEntityName = ''
          if (row.organization_id) {
            wipEntityName = `<a href='${row.preventive_default_url}'">
                                <u>
                                  <input  type="text" 
                                          class="form-control pointer" 
                                          value="${row.wip_entity_name ? row.wip_entity_name : ''}" 
                                          disabled 
                                          autocomplete="off"
                                          style="color: #000000; background-color :#eeeeee; font-size: 13px;">
                                </u>
                              </a>`
          } else {
            wipEntityName = `<input type="text" class="form-control" value="" disabled autocomplete="off">`
          }
          tbodyTablePreventive += `<tr>`
          tbodyTablePreventive += `<td class="text-center">
                                    <input ${row.op_wo_status == 'Y' ? 'disabled' : ''} 
                                            type="checkbox" 
                                            name="case[]"
                                            onclick="checkValueCheckBox()">
                                  </td>`
          tbodyTablePreventive += `<td>
                                    <div class="input-group">
                                      <select id="assetNumberExcel_`+ index +`" 
                                              class="assetNumber form-control readonly" 
                                              data-server="/eam/ajax/lov/assetnumber"  
                                              data-id="asset_number" 
                                              data-text="description" 
                                              data-field="select"
                                              required
                                              ${row.op_wo_status == 'Y' ? 'disabled' : ''}
                                              data-selectEAM0006AssetNumber="assetNumberExcel_`+ index +`"
                                              data-typeEAM0006AssetNumber="lovAssetNumberExcel_`+ index +`">
                                      </select>
                                      <div class="input-group-append">
                                        <span class="input-group-append">
                                          <button onclick="assetNumberLovBtnDesc({data1: this, data2: 'td:eq(2)', data3: 'td:eq(5)', data4: 'td:eq(4)'})" 
                                                  type="button" 
                                                  class="btn btn-default" ${row.op_wo_status == 'Y' ? 'disabled' : ''} >
                                                  <i class="fa fa-search"></i>
                                          </button>
                                        </span>
                                      </div>
                                    </div>
                                  </td>`
          tbodyTablePreventive += `<td><input type="text" 
                                              class="form-control" 
                                              value="${row.asset_desc ? row.asset_desc : ''}" 
                                              disabled 
                                              autocomplete="off"
                                              id="label_assetNumberExcel_`+ index +`"
                                              style="color: #000000; background-color :#eeeeee; font-size: 13px;">
                                    </td>`
          tbodyTablePreventive += `<td><select  id="activityToDoExcel_`+ index +`"
                                                class="activityToDo form-control" 
                                                ${row.op_wo_status == 'Y' ? 'disabled' : ''} >`+optionActivity+`>
                                        </select>
                                  </td>`
          tbodyTablePreventive += `<td>
                                    <div class="input-group">
                                      <select id="departmentExcel_`+ index +`"
                                              class="form-control clearable readonly" 
                                              data-server="/eam/ajax/lov/departments"  
                                              data-id="department_code" 
                                              data-text="description" 
                                              data-field="select"
                                              required
                                              ${row.op_wo_status == 'Y' ? 'disabled' : ''}>
                                      </select>
                                      <div class="input-group-append">
                                        <span class="input-group-append">
                                          <button onclick="departmentLovBtnTableOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: this})" type="button" class="btn btn-default" ${row.op_wo_status == 'Y' ? 'disabled' : ''}><i class="fa fa-search"></i></button>
                                        </span>
                                      </div>
                                    </div>
                                  </td>`
          tbodyTablePreventive += `<td><input type="text" 
                                              class="form-control" 
                                              value="${row.area ? row.area : ''}" 
                                              disabled 
                                              autocomplete="off"
                                              id="areaExcel_`+ index +`"
                                              style="color: #000000; background-color :#eeeeee; font-size: 13px;"></td>`
          tbodyTablePreventive += `<td><input id="dateTableStartExcel${indexTb}" type="text" class="form-control" autocomplete="off"></td>`
          tbodyTablePreventive += `<td><input id="dateTableEndExcel${indexTb}" type="text" class="form-control" autocomplete="off"></td>`
          tbodyTablePreventive += `<td>`+wipEntityName+`</td>`
          tbodyTablePreventive += `<td><input type="text" 
                                              class="form-control" 
                                              value="${row.status_type ? row.status_type : ''}" 
                                              disabled 
                                              autocomplete="off"
                                              style="color: #000000; background-color :#eeeeee; font-size: 13px;"></td>`
          tbodyTablePreventive += `<td class="d-none"><input type="text" class="form-control" value="${row.op_wo_status ? row.op_wo_status : ''}" hidden autocomplete="off"></td>`
          tbodyTablePreventive += `<td class="d-none"><input type="text" class="form-control" value="${row.organization_id ? row.organization_id : ''}" hidden autocomplete="off"></td>`
          tbodyTablePreventive += `<td class="d-none"><input type="text" class="form-control" value="${row.plan_line_id ? row.plan_line_id : ''}" hidden autocomplete="off"></td>`
          tbodyTablePreventive += `<td class="d-none"><input type="text" class="form-control" value="add" hidden autocomplete="off"></td>`
          tbodyTablePreventive += `</tr>`
          indexTb += 1
        })
      }
      $("#setTbodyTable").append(tbodyTablePreventive);

      data.filter((row, index) => {
        let dateSt = row.scheduled_start_date.toString().indexOf('/') > 0 ? row.scheduled_start_date.split('/').length > 2 ? row.scheduled_start_date : '' : ''
        let dateCom = row.scheduled_completion_date.toString().indexOf('/') > 0 ? row.scheduled_completion_date.split('/').length > 2 ? row.scheduled_completion_date : '' : ''
        setDatePicker({idDate: `dateTableStartExcel${indexTbExcel}`, nameDate: '', onchange: true, date: dateSt, disabled: false, required: true, dateEndId: `dateTableEndExcel${indexTbExcel}`});
        setDatePicker({idDate: `dateTableEndExcel${indexTbExcel}`, nameDate: '', onchange: true, date: dateCom, disabled: false, required: true});
        vmDatePicker[`dateTableEndExcel${indexTbExcel}`].pDisabled = dateSt;

        //Default รหัสเครื่องจักร
        var newOptionAssetNumber = new Option(row.asset_number, row.asset_number, true, true);
        $('#assetNumberExcel_'+ index).append(newOptionAssetNumber).trigger('change');
        $('#assetNumberExcel_'+ index).val(row.asset_number).trigger('change');

        $('#assetNumberExcel_' + index).on('select2:select', function (e) {
          $(this).select2('data')[0].text = $(this).select2('data')[0].id;
        });

        $('#assetNumberExcel_' + index).on('select2:clear', function (e) {
          $('#label_assetNumberExcel_'+ index).val('');
          $('#departmentExcel_'+ index).val('').trigger('change');
          $('#areaExcel_'+ index).val('');
          $('#activityToDoExcel_'+ index).val('').trigger('change');
        });

        //Default หน่วยงานผู้รับแจ้ง
        var newOptionDepartment = new Option(row.receiving_department_code + ' - ' +row.receiving_department_desc, row.receiving_department_code, true, true);
        $('#departmentExcel_'+ index).append(newOptionDepartment).trigger('change');
        $('#departmentExcel_'+ index).val(row.receiving_department_code).trigger('change');

        indexTbExcel += 1
      })
      readonly();
      changeActivityToDo();
      setSelect2InEAM0006();
      triggerSelect2();
      loader('hide');
    }
    function changeActivityToDo() {
      $(".activityToDo").change(()=>{
        if ($("#statusPlan").val() == 'Confirm' && $("#eam0006").attr('id') === 'eam0006') {
          editConfirm = true
          $("#openRepairWorkBtn").prop('disabled', false);
          $("#saveBtn").prop('disabled', false);  
          $("#approvalBtn").prop('disabled', true);
        }
      })
    }
    $("#checkboxAllTable").click((e) => {
      var table = $(e.target).closest('table');
      if ($("#checkboxAllTable").prop('checked')) {
        $('td input:checkbox:not([disabled])', table).prop('checked', $("#checkboxAllTable").prop('checked'));
      } else {
        $('td input:checkbox', table).prop('checked', $("#checkboxAllTable").prop('checked'));
      }
    })

    function checkValueCheckBox(params) {
      var numCheckboxDisabled = $("#setTbodyTable input[type='checkbox']:disabled").length;
      var numCheckboxData = $("#setTbodyTable input[type='checkbox']").length;
      var numCheckboxChecked = $("#setTbodyTable input[type='checkbox']:checked").length;
      var totalNumData = numCheckboxData - numCheckboxDisabled;
      if(numCheckboxData == numCheckboxChecked || numCheckboxChecked == totalNumData){
        $("#checkboxAllTable").prop('checked', true)
      }else{
        $("#checkboxAllTable").prop('checked', false)
      }
    }

    function createNew() {
      $("#yearPlan").val('').trigger('change');
      $("#versionPlan").val('').trigger('change');
      $("#statusPlan").val('').trigger('change');
      $("#versionPlan").prop('disabled', true);
      dataDropDownPtwUsers.push({
        idLov: defaultUser.user_id,
        codeLov: defaultUser.username,
        descLov: defaultUser.name,
        codeDescLov: defaultUser.username + ' : ' + defaultUser.name
      })
      userIdPtwUser = defaultUser.user_id
      $("#nameCreate").val(defaultUser.username + ' : ' + defaultUser.name).trigger('change');
      $("#nameCreate").prop('disabled', false);
      $("#nameCreateBtn").prop('disabled', false);
      document.getElementById("nameCreate").style.backgroundColor = "#fff";
      clearDetail();
    }

    function clearDetail() {
      $("#assetNumber").val('').trigger('change');
      $("#machineGroup").val('').trigger('change');
      $("#notifyingAgency").val('');
      $("#repairer").val('');
      $("#repairStartDate").val('');
      $("#activitiesToDo").val('').trigger('change');
      $("#area").val('').trigger('change');
      $("#repairOpenStatus").val('').trigger('change');
      $("#repairEndDate").val('');
      $("#assetNumber").prop('disabled', true);
      $("#machineGroup").prop('disabled', true);
      $("#notifyingAgency").prop('disabled', true);
      $("#repairer").prop('disabled', true);
      $("#activitiesToDo").prop('disabled', true);
      $("#area").prop('disabled', true);
      $("#areaLovBtn").prop('disabled', true);
      $("#repairOpenStatus").prop('disabled', true);
      $("#repairStartDate").prop('disabled', true);
      $("#repairEndDate").prop('disabled', true);
      vmDatePicker.repairStartDate.disabled = true
      vmDatePicker.repairEndDate.disabled = true
      $("#assetNumberLovBtn").prop('disabled', true);
      $("#notifyingAgencyLovBtn").prop('disabled', true);
      $("#repairerLovBtn").prop('disabled', true);
      $("#approvalBtn").prop('disabled', true);
      $("#addTableBtn").prop('disabled', true)
      $("#deleteTableBtn").prop('disabled', true)
      $("#setTbodyTable").html('');
      $('#setTablePagination').html('');
      $("#oldVersionPlan").val('');
    }

    function disabledBtn() {
      if ($("#versionPlan").val() == 'Cancelled') {
          $("#saveBtn").prop('disabled', true);
          $("#approvalBtn").prop('disabled', true);
          $("#openRepairWorkBtn").prop('disabled', true);
          $("#addTableBtn").prop('disabled', true);
          $("#deleteTableBtn").prop('disabled', true);
          $("#fileBtn").prop('disabled', true);
      }
    }
    
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection