@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <x-get-page-title menu="" url="/eam/work-orders/list-repair-jobs-waiting-close" />
@stop

@section('content')
  @php 
    $checkAttrId = 'listRepairJobWaitingClose' 
  @endphp
  <div id="eam0014" class="ibox eam">
    <div id="formAll" class="ibox-content d-none">
      <div class="row justify-content-center">
        <div class="col-11">
          <div class="text-right">
            <button id="undoBtn" 
                    class="btn btn-default btn-lg size-btn mt-1" 
                    role="button" 
                    aria-pressed="true">
              <i class="fa fa-undo"></i> ล้างค่า
            </button>
            <button id="searchBtn" 
                    class="btn btn-default btn-lg size-btn mt-1" 
                    role="button" 
                    aria-pressed="true">
              <i class="fa fa-search"></i> ค้นหา
            </button>
          </div>
        </div>
        <div class="col-11 mt-4">
          @include('eam.work-orders._form')
        </div>
        <div class="col-11 mt-2">
          <div class="row">
            <div id="table" class="col-sm-4 text-left inline pt-2">
              <h4>ใบรับงาน</h4>
            </div>
            <div class="col-sm-8 text-right inline float-right">
              <button id="approvalBtn" class="btn btn-primary btn-lg size-btn mt-1">
                ปิดงานซ่อม
              </button>
              <button id="cancleBtn" style="width: 135px;" class="btn btn-danger btn-lg size-btn mt-1">
                ยกเลิก Complete
              </button>
            </div>
          </div>
        </div>
        <div class="col-11">
          @include('eam.work-orders._table')
        </div>
      </div>
    </div>
    @include('eam.work-orders._modalLov')
  </div>
@endsection
@section('scripts')
  @include('eam.commons.scripts.all-date');
  @include('eam.commons.scripts.clear-input');
  @include('eam.commons.scripts.drop-down-work-receipt-type');
  @include('eam.commons.scripts.drop-down-status-yn');
  @include('eam.commons.scripts.drop-down-job-receipt-status');
  @include('eam.commons.scripts.drop-down-machine-group');
  @include('eam.commons.scripts.drop-down-subinventory');
  @include('eam.commons.scripts.drop-down-locator');
  @include('eam.commons.scripts.lov-work-receipt-number');
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-department');
  {{-- @include('eam.commons.scripts.lov-employee'); --}}
  @include('eam.commons.scripts.lov-employee-web-user');
  @include('eam.commons.scripts.loader');
  <script>
    $("#formAll").removeClass('d-none');
    var defaultUser = {!! json_encode($user->toArray(), JSON_HEX_TAG) !!};
    var defaultWipEntityName = {!! json_encode($wipEntityName) !!};
    var defaultWipEntityId = {!! json_encode($wipEntityId) !!};
    var dataTable = []
    var dataCancle = {}
    var dataCancle2 = {}

    setDatePicker({idDate: 'dateStartWO', nameDate: '', onchange: false, date: '', disabled: false, required: false, dateEndId: `dateEndWO`});
    setDatePicker({idDate: 'dateEndWO', nameDate: '', onchange: false, date: '', disabled: false, required: false});
    setDatePicker({idDate: 'dateStartWR', nameDate: '', onchange: false, date: '', disabled: false, required: false, dateEndId: `dateEndWR`});
    setDatePicker({idDate: 'dateEndWR', nameDate: '', onchange: false, date: '', disabled: false, required: false});

    loader('hide');
    
    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    
    $.ajax({
      url: "{{ route('eam.ajax.lov.departments') }}",
      method: 'GET',
      data: {
          'p_department_code': defaultUser.department_code,
          'p_description': ''
        },
      success: function (response) {
        let department_desc = ''
        response.data.filter(row => {
          if(row.department_code == defaultUser.department_code) {
            department_desc = row.description
          }
        })

        if(defaultWipEntityName && defaultWipEntityId){
          $('#reportingAgency').val('').trigger('change');
          $('#searchBtn').click();
        }else{
          //Default หน่วยงานผู้รับแจ้ง
          var newOptionReportingAgency = new Option(defaultUser.department_code + ' - ' + department_desc, defaultUser.department_code, true, true);
          $('#reportingAgency').append(newOptionReportingAgency).trigger('change');
          $('#reportingAgency').val(defaultUser.department_code).trigger('change');
        }
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        if (jqXHR.responseJSON.message) {
          swal("Error", jqXHR.responseJSON.message, "error");
        } else {
          swal("Error", jqXHR.responseText.message, "error");
        }
      }
    })

    let thead = [{
      name: 'เลขที่ใบรับงาน',
      style: 'min-width: 150px;'
    }, {
      name: 'ประเภทของใบรับงาน',
      style: 'min-width: 140px;'
    }, {
      name: 'ชื่อเครื่องจักร (Number)',
      style: 'min-width: 230px;'
    }, {
      name: 'คำอธิบายใบสั่งงาน',
      style: 'min-width: 150px;'
    }, {
      name: 'ประมาณวันที่เริ่มซ่อม',
      style: 'min-width: 140px;'
    }, {
      name: 'ประมาณวันที่ซ่อมเสร็จ',
      style: 'min-width: 140px;'
    }, {
      name: 'เลขที่ใบสั่งงาน',
      style: 'min-width: 130px;'
    }, {
      name: 'สถานะการตัดใช้อะไหล่',
      style: 'min-width: 150px;'
    }, {
      name: 'สถานะการบันทึกค่าแรง',
      style: 'min-width: 150px;'
    }, {
      name: 'สถานะการ Complete งาน',
      style: 'min-width: 165px;'
    }]

    let theadTable = ''
      theadTable += `<th class="text-center" style="min-width: 100px;">`
      theadTable += `<div>
                      <input id="checkboxAllTable" type="checkbox"> เลือกทั้งหมด
                    </div>`
      theadTable += `</th>`
      thead.filter(row => {
        theadTable += `<th class="text-center" style="${row.style}">`
        theadTable += `<div>${row.name}</div>`
        theadTable += `</th>`
     })
    $("#setTheadTable").html(theadTable);

    $("#undoBtn").click(() => {
      $(".clearable").removeClass('x onX');
      $("#workReceiptNumber").val('').trigger('change');
      $("#workReceiptNumber").prop('disabled', false);
      $("#assetNumber").val('').trigger('change');
      $("#assetNumber").prop('disabled', false);
      $("#assetNumberLovBtn").prop('disabled', false);
      $("#machineGroup").val('').trigger('change');
      $("#machineGroup").prop('disabled', false);
      $("#notifyingAgency").val('').trigger('change');
      $("#notifyingAgency").prop('disabled', false);
      $("#notifyingAgencyLovBtn").prop('disabled', false);
      $("#notifier").val('').trigger('change');
      $("#notifierId").val('').trigger('change');
      $("#notifier").prop('disabled', false);
      $("#notifierLovBtn").prop('disabled', false);
      $("#workReceiptType").val('').trigger('change');
      $("#workReceiptType").prop('disabled', false);
      $("#workOrderNumber").val('').trigger('change');
      $("#workOrderNumber").prop('disabled', false);
      vmDatePicker.dateStartWO.pValue = ''
      vmDatePicker.dateStartWO.disabled = false
      vmDatePicker.dateEndWO.pValue = ''
      vmDatePicker.dateEndWO.disabled = false
      vmDatePicker.dateStartWR.pValue = ''
      vmDatePicker.dateStartWR.disabled = false
      vmDatePicker.dateEndWR.pValue = ''
      vmDatePicker.dateEndWR.disabled = false
      $("#checkboxAllTable").prop('checked', false);
      $("#setTbodyTable").html('');
      $('#setTablePagination').html('');
      wip_entity_id = '';
    })

    $("#searchBtn").click(() => {
      searchAll(false);
    })

    function searchAll(data) {
      $.ajax({
        url: "{{ route('eam.ajax.work-order.head.index') }}",
        method: 'get',
        data: {
          'wip_entity_id':              wip_entity_id,
          'asset_number':               $("#assetNumber").val(),
          'asset_group_id':             $("#machineGroup option:selected").val(),
          'asset_group_desc':           $("#machineGroup option:selected").text(),
          'owning_department_code':     $("#notifyingAgency").val(),
          'employee_code':              $("#notifier").val(),
          'status_type':                $("#jobReceiptStatus").val(),
          'material_flag':              $("#materialStatus").val(),
          'labor_flag':                 $("#laborStatus").val(),
          'work_order_type_id':         $("#workReceiptType").val(),
          'actual_start_date':          $("#dateStartWO").val(),
          'actual_end_date':            $("#dateEndWO").val(),
          'work_request_number':        $("#workOrderNumber").val(),
          'inform_dept_code':           $("#reportingAgency").val(),
          'creation_date_st':           $("#dateStartWR").val(),
          'creation_date_en':           $("#dateEndWR").val()
        },
        success: function (response) {
          dataTable = response.data.data
          if (response.data.data.length > 0) {
            setTableWorkOrderFn(response.data);
            window.location.href = '#table'
          } else {
            if (!data) {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            }
            $("#setTbodyTable").html('');
            $('#setTablePagination').html('');
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          if (jqXHR.responseJSON.message) {
            swal("Error", jqXHR.responseJSON.message, "error");
          } else {
            swal("Error", jqXHR.responseText.message, "error");
          }
        }
      });
    }

    function setTableWorkOrderFn(data) {
      let tbodyTable = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          tbodyTable += `<tr>`
          tbodyTable += `<td class="text-center">
                          <input  onclick="checkSelect(this)" 
                                  id="${row.wip_entity_name}" 
                                  type="checkbox" 
                                  name="case[]">
                        </td>`
          tbodyTable += `<td>
                          <a href="{{ route('eam.work-orders.create', ['']) }}?workOrderId=${row.wip_entity_name}">
                            <u>${row.wip_entity_name ? row.wip_entity_name : ''}</u>
                          </a>
                        </td>`
          tbodyTable += `<td>
                          ${row.work_order_type_desc ? row.work_order_type_desc : ''}
                        </td>`
          tbodyTable += `<td>
                          ${row.asset_desc ? row.asset_desc : ''}
                        </td>`
          tbodyTable += `<td>
                          ${row.description ? row.description : ''}
                        </td>`
          tbodyTable += `<td>${row.actual_start_date ? row.actual_start_date : ''}</td>`
          tbodyTable += `<td>${row.actual_end_date ? row.actual_end_date : ''}</td>`
          tbodyTable += `<td>
                            <a href="{{ route('eam.work-requests.create', ['']) }}?id=${row.work_request_number}">
                              <u>${row.work_request_number ? row.work_request_number : ''}</u>
                            </a>
                        </td>`
          tbodyTable += `<td class="text-center">
                          <input  type="checkbox" 
                                  style="filter: hue-rotate(270deg)" 
                                  onClick="this.checked=!this.checked;" 
                                  ${row.material_flag === 'Y' ? 'checked' : ''}>
                        </td>`
          tbodyTable += `<td class="text-center">
                          <input  type="checkbox" 
                                  style="filter: hue-rotate(270deg)" 
                                  onClick="this.checked=!this.checked;" 
                                  ${row.labor_flag === 'Y' ? 'checked' : ''}>
                        </td>`
          tbodyTable += `<td class="text-center">
                          <input  type="checkbox" 
                                  style="filter: hue-rotate(270deg)" 
                                  onClick="this.checked=!this.checked;" 
                                  ${row.complete_flag === 'Y' ? 'checked' : ''}>
                        </td>`
         tbodyTable += `</tr>`
        })
      }
      $("#setTbodyTable").html(tbodyTable);

      let pagination = '<ul class="pagination float-right" style="padding-top: 15px;">';
      $.each(data.links , function( i , link ){
        pagination += `<li class="footable-page ${link.active ? 'active' : ''}">
                          <a onclick="searchTableWorkOrderPagination('` + link.url + `')">${link.label}</a>
                        </li>`
      });
      pagination += '</ul>';
      $('#setTablePagination').html(pagination);
    }

    function searchTableWorkOrderPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'get',
          data: {
            'wip_entity_id':              wip_entity_id,
            'asset_number':               $("#assetNumber").val(),
            'asset_group_id':             $("#machineGroup option:selected").val(),
            'asset_group_desc':           $("#machineGroup option:selected").text(),
            'owning_department_code':     $("#notifyingAgency").val(),
            'employee_code':              $("#notifier").val(),
            'status_type':                $("#jobReceiptStatus").val(),
            'material_flag':              $("#materialStatus").val(),
            'labor_flag':                 $("#laborStatus").val(),
            'work_order_type_id':         $("#workReceiptType").val(),
            'actual_start_date':          $("#dateStartWO").val(),
            'actual_end_date':            $("#dateEndWO").val(),
            'work_request_number':        $("#workOrderNumber").val(),
            'inform_dept_code':           $("#reportingAgency").val(),
            'creation_date_st':           $("#dateStartWR").val(),
            'creation_date_en':           $("#dateEndWR").val()
          },
          success: function (response) {
            dataTable = response.data.data
            if (response.data.data.length > 0) {
              setTableWorkOrderFn(response.data);
              window.location.href = '#table'
            } else {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setTbodyTable").html('');
              $('#setTablePagination').html('');
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.responseJSON.message) {
              swal("Error", jqXHR.responseJSON.message, "error");
            } else {
              swal("Error", jqXHR.responseText.message, "error");
            }
          }
        });
      }
    }

    function checkSelect(data) {     
      if($("#setTbodyTable input[type='checkbox']").length == 0){
        $("#checkboxAllTable").prop('checked',false);
      }else{
        if($("#setTbodyTable input[type='checkbox']:checked").length != 
          $("#setTbodyTable input[type='checkbox']").length){
          $("#checkboxAllTable").prop('checked',false);
        }else{
          $("#checkboxAllTable").prop('checked',true);
        }
      }
       
      if ($(data).parents('tr').find("td:eq(2)").text() == 'JP') {
        if ($(data).prop('checked')) {
          $('#setTbodyTable input[name="case[]"]').prop('checked', false);
          $(data).prop('checked', true);
          if ($("#checkboxAllTable").prop('checked')) {
            $("#checkboxAllTable").prop('checked', false)
          }
        } else {
          $(data).prop('checked', false);
        }
      }      
    }

    $("#checkboxAllTable").click((e) => { 
      var table = $(e.target).closest('table');
      $('#setTbodyTable input[name="case[]"]', table).prop('checked', $("#checkboxAllTable").prop('checked'));
    })

    $("#approvalBtn").click(() => {
      save('3');
    })

    $("#cancleBtn").click(() => {
      save('5');
    })

    function save(data) {
      let dataSave = []
      let checkJP = false
      $.each($("input[name='case[]']:checked"),
      function () {
        var checkBox = $(this).parents('tr:eq(0)');
        if ($(checkBox).find('td:eq(2)').text() == 'JP') {
          checkJP = true
        }
        dataTable.filter(row => {
          if (row.wip_entity_name == $(checkBox).find('td:eq(1)').text().replace(/\s/g, '')) {
            dataSave.push(row)
          }
        })
      })
      if (dataSave.length > 0) {
        if (data == '5') {
          if (dataSave.length > 1) {
            swal("ปุ่มยกเลิก Complete สามารถเลือกได้ทีละรายการ", "", "warning");
          } else {
            dataCancle = dataSave[0]
            $("#detailCancelCloseJob").modal('show');
          }
        } else {
          dataCancle = dataSave[0]
          if (dataSave[0].work_order_type_desc == 'JP' && dataSave.length == '1') {
            let optionSuvinventory = ''
            optionSuvinventory += `<option value=""></option>`
            for (let data of dataDropDownSubinventory) {
              optionSuvinventory += `<option  value="${data.name}" 
                                              ${'ENGROJ01' == data.name ? 'selected' : ''}>
                                              ${data.name}
                                    </option>`
            }
            let optionLocator = ''
              optionLocator += `<option value=""></option>`
            for (let data of dataDropDownLocator) {
              if (data.subinventory_name == 'ENGROJ01') {
                optionLocator += `<option value="${data.locator_name}" 
                                          ${'RECEIVE' == data.locator_name ? 'selected' : ''}>
                                          ${data.subinventory_name}.${data.locator_name}
                                  </option>`
              }
            }
            $.ajax({
              url: "{{ route('eam.ajax.work-order.head.close-jp',['']) }}/" + dataSave[0].wip_entity_name,
              method: 'get',
              success: function (response) {
                if (response.data.length > 0) {
                  dataCancle2 = response.data[0]
                  let theadTable = ''
                  theadTable += `<tr>`
                  theadTable += `<td>Organization Code</td>`
                  theadTable += `<td style="word-wrap: break-word; max-width: 550px;">${response.data[0].organization_id ? response.data[0].organization_id : ''}</td>`
                  theadTable += `</tr>`
                  theadTable += `<tr>`
                  theadTable += `<td>ใบสั่งผลิตชิ้นส่วนอะไหล่</td>`
                  theadTable += `<td style="word-wrap: break-word; max-width: 550px;">${response.data[0].wip_entity_name ? response.data[0].wip_entity_name : ''}</td>`
                  theadTable += `</tr>`
                  theadTable += `<tr>`
                  theadTable += `<td>คำอธิบายใบรับงาน</td>`
                  theadTable += `<td style="word-wrap: break-word; max-width: 550px;">${response.data[0].description ? response.data[0].description : ''}</td>`
                  theadTable += `</tr>`
                  theadTable += `<tr>`
                  theadTable += `<td>รหัสอะไหล่</td>`
                  theadTable += `<td style="word-wrap: break-word; max-width: 550px;">${response.data[0].asset_number ? response.data[0].asset_number : ''}</td>`
                  theadTable += `</tr>`
                  theadTable += `<tr>`
                  theadTable += `<td>คำอธิบายอะไหล่</td>`
                  theadTable += `<td style="word-wrap: break-word; max-width: 550px;">${response.data[0].asset_desc ? response.data[0].asset_desc : ''}</td>`
                  theadTable += `</tr>`
                  theadTable += `<tr>`
                  theadTable += `<td>หน่วยนับ</td>`
                  theadTable += `<td style="word-wrap: break-word; max-width: 550px;">${response.data[0].uom_code ? response.data[0].uom_code : ''}</td>`
                  theadTable += `</tr>`
                  theadTable += `<tr>`
                  theadTable += `<td>ปริมาณที่สั่งผลิต</td>`
                  theadTable += `<td style="word-wrap: break-word; max-width: 550px;">${response.data[0].quantity_ordered ? response.data[0].quantity_ordered : ''}</td>`
                  theadTable += `</tr>`
                  theadTable += `<tr>`
                  theadTable += `<td>ปริมาณที่ผลิตได้</td>`
                  theadTable += `<td style="word-wrap: break-word; max-width: 550px;">${response.data[0].producable_quantity ? response.data[0].producable_quantity : ''}</td>`
                  theadTable += `</tr>`
                  theadTable += `<tr>`
                  theadTable += `<td>ต้นทุน</td>`
                  theadTable += `<td style="word-wrap: break-word; max-width: 550px;">${response.data[0].cost ? response.data[0].cost : ''}</td>`
                  theadTable += `</tr>`
                  theadTable += `<tr>`
                  theadTable += `<td>คลังจัดเก็บ<label class="pl-1 text-danger">*</label></td>`
                  theadTable += `<td><select class="form-control" id="subinventory" required>`+optionSuvinventory+`</select></td>`
                  theadTable += `</tr>`
                  theadTable += `<tr>`
                  theadTable += `<td>สถานที่จัดเก็บ<label class="pl-1 text-danger">*</label></td>`
                  theadTable += `<td><select class="form-control" id="locator" required>`+optionLocator+`</select></td>`
                  theadTable += `</tr>`
                  theadTable += `<tr>`
                  theadTable += `<td>Lot Number<label class="pl-1 text-danger">*</label></td>`
                  theadTable += `<td><input id="closeRepairWorkNumber" type="text" maxlength="50" required class="form-control" autocomplete="off"> </td>`
                  theadTable += `</tr>`
                  theadTable += `<tr>`
                  theadTable += `<td>Transaction Date<label class="pl-1 text-danger">*</label></td>`
                  theadTable += `<td><input id="closeRepairWorkDate" type="text" required class="form-control" autocomplete="off"> </td>`
                  theadTable += `</tr>`
                  $("#setCloseRepairWork").html(theadTable);
                  setDateTimePickerAll({idDate: `closeRepairWorkDate`, nameDate: '', onchange: false, date: '', disabled: false, required: true});
                  vmDateTimePickerAll.closeRepairWorkDate.pValue = getDateTime();
                  $("#detailCloseRepairWork").modal('show');
                  changSubinventory();
                } else {
                  swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                }
              },
              error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.responseJSON.message) {
                  swal("Error", jqXHR.responseJSON.message, "error");
                } else {
                  swal("Error", jqXHR.responseText.message, "error");
                }
              }
            });
          } else {
            if (checkJP) {
              swal("ประเภทใบรับงานประเภท JP สามารถเลือกได้ทีละรายการ", "", "warning")
            } else {
              loader('show');
              $.ajax({
                url: "{{ route('eam.ajax.work-order.head.update-status') }}",
                method: 'put',
                headers: {
                  'Accept':         'application/json',
                  'Content-Type':   'application/json',
                  'X-CSRF-TOKEN':   "{{ csrf_token() }}"
                },
                data: JSON.stringify({
                  program_code:   'EAM0014',
                  data:           dataSave,
                  status: {
                    code:         '12',
                    meaning:      'Closed'
                  },
                  jp_data: {}
                }),
                success: function (response) {
                  loader('hide');
                  swal("Success", response.message, "success");
                  searchAll(true);
                },
                error: function (jqXHR, textStatus, errorRhrown) {
                  loader('hide');
                  swal("Error", jqXHR.responseJSON.message, "error");
                }
              })
            }
          }
        }
      } else {
        swal("กรุณาเลือกรายการ", "", "warning");
      }
    }

    function changSubinventory() {
      $("#subinventory").change(function() {
        if ($(this).val() == '') {
          $("#locator").html('')
        } else {
          let optionLocator = ''
            optionLocator += `<option value=""></option>`
          for (let data of dataDropDownLocator) {
            if (data.subinventory_name == $(this).val()) {
              optionLocator += `<option value="${data.locator_name}">${data.subinventory_name}.${data.locator_name}</option>`
            }
          }
          $("#locator").html(optionLocator)
        }
      })
    }

    $("#modalCancelCloseJobSaveBtn").click(()=>{
      $.ajax({
        url: "{{ route('eam.ajax.work-order.head.update-status') }}",
        method: 'put',
        headers: {
          'Accept':         'application/json',
          'Content-Type':   'application/json',
          'X-CSRF-TOKEN':   "{{ csrf_token() }}"
        },
        data: JSON.stringify({
          program_code:               'EAM0014',
          data: [
            {
              wip_entity_id:          dataCancle.wip_entity_id,
              wip_entity_name:        dataCancle.wip_entity_name,
              reason:                 $("#cancelCloseJobText").val(),
              work_order_type_desc:   dataCancle.work_order_type_desc
            }
          ],
          status: {
            code:                     '3',
            meaning:                  'Released'
          },
          jp_data:                    dataCancle
        }),
        success: function (response) {
          swal("Success", response.message, "success");
          searchAll(true);
          $("#detailCancelCloseJob").modal('hide');
        },
        error: function (jqXHR, textStatus, errorThrown) {
          if (jqXHR.responseJSON.message) {
            swal("Error", jqXHR.responseJSON.message, "error");
          } else {
            swal("Error", jqXHR.responseText.message, "error");
          }
        }
      });
    })

    $("#modalCloseRepairWorkSaveBtn").click(()=>{
      $("#modalCloseRepairWorkSaveBtnHide").click();
    })

    function modalCloseRepairWorkSaveBtnFn() {
      loader('show');
      $.ajax({
        url: "{{ route('eam.ajax.work-order.head.update-status') }}",
        method: 'put',
        headers: {
          'Accept':         'application/json',
          'Content-Type':   'application/json',
          'X-CSRF-TOKEN':   "{{ csrf_token() }}"
        },
        data: JSON.stringify({
          program_code:               'EAM0014',
          data: [
            {
              wip_entity_id:          dataCancle.wip_entity_id,
              wip_entity_name:        dataCancle.wip_entity_name,
              reason:                 '',
              work_order_type_desc:   dataCancle.work_order_type_desc
            }
          ],
          status: {
            code:                     '12',
            meaning:                  'Closed'
          },
          jp_data: {
            "organization_id":        dataCancle2.organization_id,
            "wip_entity_name":        dataCancle2.wip_entity_name,
            "description":            dataCancle2.description,
            "asset_number":           dataCancle2.asset_number,
            "asset_desc":             dataCancle2.asset_desc,
            "uom_code":               dataCancle2.uom_code,
            "quantity_ordered":       dataCancle2.quantity_ordered,
            "producable_quantity":    dataCancle2.producable_quantity,
            "cost":                   dataCancle2.cost,
            "supply_subinventory":    $("#subinventory").val(),
            "storage_location":       $("#locator").val(),
            "lot_number":             $("#closeRepairWorkNumber").val(),
            "transaction_date":       $("#closeRepairWorkDate").val()
          }
        }),
        success: function (response) {
          loader('hide');
          swal("Success", response.message, "success");
          searchAll(true);
          $("#detailCloseRepairWork").modal('hide');
        },
        error: function (jqXHR, textStatus, errorThrown) {
          loader('hide');
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      });
    }

    $('#workReceiptNumber').on('select2:clear', function (e) {
      wip_entity_id = '';
    });

    if(defaultWipEntityName && defaultWipEntityId){
      var newOption = new Option(defaultWipEntityName, defaultWipEntityName, true, true);
      $('#workReceiptNumber').append(newOption).trigger('change');
      $('#workReceiptNumber').val(defaultWipEntityName).trigger('change');
      wip_entity_id = defaultWipEntityId;      
    }
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection