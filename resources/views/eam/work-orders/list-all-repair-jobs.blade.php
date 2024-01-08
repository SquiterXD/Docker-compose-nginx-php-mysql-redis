@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <x-get-page-title menu="" url="/eam/work-orders/list-all-repair-jobs" />
@stop

@section('content')
@php $checkAttrId = 'listAllRepairJob' @endphp
<div id="eam0016" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11">
        <div class="text-right">
          <button id="undoBtn" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
            <i class="fa fa-undo"></i> ล้างค่า
          </button>
          <button id="searchBtn" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
            <i class="fa fa-search"></i> ค้นหา
          </button>
        </div>
      </div>
      <div class="col-11 mt-4">
        @include('eam.work-orders._form')
      </div>
      <div class="col-11">
        <div id="table" class="text-left inline pt-2 ml-5">
          <h4>ใบรับงาน</h4>
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
  @include('eam.commons.scripts.lov-work-receipt-number');
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-department');
  {{-- @include('eam.commons.scripts.lov-employee'); --}}
  @include('eam.commons.scripts.lov-employee-web-user');

  <script>
    $("#formAll").removeClass('d-none');
    var defaultUser = {!! json_encode($user->toArray(), JSON_HEX_TAG) !!};
    var dataUserDefault = ''

    setDatePicker({idDate: 'dateStartWO', nameDate: '', onchange: false, date: '', disabled: false, required: false, dateEndId: `dateEndWO`});
    setDatePicker({idDate: 'dateEndWO', nameDate: '', onchange: false, date: '', disabled: false, required: false});
    setDatePicker({idDate: 'dateStartWR', nameDate: '', onchange: false, date: '', disabled: false, required: false, dateEndId: `dateEndWR`});
    setDatePicker({idDate: 'dateEndWR', nameDate: '', onchange: false, date: '', disabled: false, required: false});

    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });

    $.ajax({
      url: "{{ route('eam.ajax.lov.departments') }}",
      method: 'get',
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

        //Default หน่วยงานผู้แจ้ง
        dataUserDefault = defaultUser.department_code;
        var newOptionReportingAgency = new Option(defaultUser.department_code + ' - ' + department_desc, defaultUser.department_code, true, true);
        $('#reportingAgency').append(newOptionReportingAgency).trigger('change');
        $('#reportingAgency').val(defaultUser.department_code).trigger('change');
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
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
      style: 'min-width: 230px;'
    }, {
      name: 'ประมาณวันที่เริ่มซ่อม',
      style: 'min-width: 140px;'
    }, {
      name: 'ประมาณวันที่ซ่อมเสร็จ',
      style: 'min-width: 140px;'
    }, {
      name: 'สถานะใบรับงาน',
      style: 'min-width: 140px;'
    }, {
      name: 'ติดตามสถานะของงาน',
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
      thead.filter(row => {
        theadTable += `<th class="text-center" style="${row.style}">`
        theadTable += `<div>${row.name}</div>`
        theadTable += `</th>`
     })
    $("#setTheadTable").html(theadTable);

    $("#undoBtn").click(() => {
      // $(".clearable").removeClass('x onX');
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
      $("#jobReceiptStatus").val('').trigger('change');
      $("#jobReceiptStatus").prop('disabled', false);
      $("#material").val('').trigger('change');
      $("#material").prop('disabled', false);
      $("#labor").val('').trigger('change');
      $("#labor").prop('disabled', false);
      $("#complete").val('').trigger('change');
      $("#complete").prop('disabled', false);
      $("#workReceiptType").val('').trigger('change');
      $("#workReceiptType").prop('disabled', false);
      $("#workOrderNumber").val('').trigger('change');
      $("#workOrderNumber").prop('disabled', false);
      $("#reportingAgency").val(dataUserDefault).trigger('change');
      $("#reportingAgency").prop('disabled', false);
      $("#reportingAgencyLovBtn").prop('disabled', false);
      vmDatePicker.dateStartWO.pValue = ''
      vmDatePicker.dateStartWO.disabled = false
      vmDatePicker.dateEndWO.pValue = ''
      vmDatePicker.dateEndWO.disabled = false
      vmDatePicker.dateStartWR.pValue = ''
      vmDatePicker.dateStartWR.disabled = false
      vmDatePicker.dateEndWR.pValue = ''
      vmDatePicker.dateEndWR.disabled = false
      $("#setTbodyTable").html('');
      $('#setTablePagination').html('');
      wip_entity_id = '';
    })

    $("#searchBtn").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.work-order.head.index') }}",
        method: 'get',
        data: {
          'wip_entity_id':              wip_entity_id,
          'asset_number':               $("#assetNumber").val(),
          'asset_group_desc':           $("#machineGroup").val(),
          'owning_department_code':     $("#notifyingAgency").val(),
          'employee_code':              $("#notifier").val(),
          'status_type':                $("#jobReceiptStatus").val(),
          'material_flag':              $("#material").val(),
          'labor_flag':                 $("#labor").val(),
          'complete_flag':              $("#complete").val(),
          'work_order_type_id':         $("#workReceiptType").val(),
          'scheduled_start_date':       $("#dateStartWO").val(),
          'scheduled_completion_date':  $("#dateEndWO").val(),
          'work_request_number':        $("#workOrderNumber").val(),
          'inform_dept_code':           $("#reportingAgency").val(),
          'creation_date_st':           $("#dateStartWR").val(),
          'creation_date_en':           $("#dateEndWR").val()
        },
        success: function (response) {
          if (response.data.data.length > 0) {
            setTableWorkOrderFn(response.data);
            window.location.href = '#table'
          } else {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $('#setTablePagination').html('');
            $("#setTbodyTable").html('');
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          swal("Error", jqXHR.responseText.message, "error");
        }
      });
    })

    function setTableWorkOrderFn(data) {
      let tbodyTable = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          tbodyTable += `<tr>`
          tbodyTable += `<td><a href="{{ route('eam.work-orders.create', ['']) }}?workOrderId=${row.wip_entity_name}"><u>${row.wip_entity_name ? row.wip_entity_name : ''}</u></a></td>`
          tbodyTable += `<td>${row.work_order_type_desc ? row.work_order_type_desc : ''}</td>`
          tbodyTable += `<td>${row.asset_desc ? row.asset_desc : ''}</td>`
          tbodyTable += `<td>${row.description ? row.description : ''}</td>`
          tbodyTable += `<td>${row.scheduled_start_date ? row.scheduled_start_date : ''}</td>`
          tbodyTable += `<td>${row.scheduled_completion_date ? row.scheduled_completion_date : ''}</td>`
          tbodyTable += `<td class="text-center">${row.status_desc ? row.status_desc : ''}</td>`
          tbodyTable += `<td class="text-center">${row.attribute8 ? row.attribute8 : ''}</td>`
          tbodyTable += `<td><a href="{{ route('eam.work-requests.create', ['']) }}?id=${row.work_request_number}"><u>${row.work_request_number ? row.work_request_number : ''}</u></a></td>`
          tbodyTable += `<td class="text-center"><input type="checkbox" style="filter: hue-rotate(270deg)" onClick="this.checked=!this.checked;" ${row.material_flag === 'Y' ? 'checked' : ''}></td>`
          tbodyTable += `<td class="text-center"><input type="checkbox" style="filter: hue-rotate(270deg)" onClick="this.checked=!this.checked;" ${row.labor_flag === 'Y' ? 'checked' : ''}></td>`
          tbodyTable += `<td class="text-center"><input type="checkbox" style="filter: hue-rotate(270deg)" onClick="this.checked=!this.checked;" ${row.complete_flag === 'Y' ? 'checked' : ''}></td>`
         tbodyTable += `</tr>`
        })
      }
      $("#setTbodyTable").html(tbodyTable);

      let pagination = '<ul class="pagination float-right" style="padding-top: 15px;">';
      $.each(data.links , function( i , link ){
        pagination += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchTableWorkOrderPagination('` + link.url + `')">${link.label}</a></li>`
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
            'asset_group_desc':           $("#machineGroup").val(),
            'owning_department_code':     $("#notifyingAgency").val(),
            'employee_code':              $("#notifier").val(),
            'status_type':                $("#jobReceiptStatus").val(),
            'material_flag':              $("#material").val(),
            'labor_flag':                 $("#labor").val(),
            'complete_flag':              $("#complete").val(),
            'work_order_type_id':         $("#workReceiptType").val(),
            'scheduled_start_date':       $("#dateStartWO").val(),
            'scheduled_completion_date':  $("#dateEndWO").val(),
            'work_request_number':        $("#workOrderNumber").val(),
            'inform_dept_code:':          $("#reportingAgency").val(),
            'creation_date_st':           $("#dateStartWR").val(),
            'creation_date_en':           $("#dateEndWR").val()
          },
          success: function (response) {
            if (response.data.data.length > 0) {
              setTableWorkOrderFn(response.data);
              window.location.href = '#table'
            } else {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $('#setTablePagination').html('');
              $("#setTbodyTable").html('');
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            swal("Error", jqXHR.responseText.message, "error");
          }
        });
      }
    }

    $('#workReceiptNumber').on('select2:clear', function (e) {
      wip_entity_id = '';
    });
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection