@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <x-get-page-title menu="" url="/eam/work-requests/waiting-approve" />
@stop

@section('content')
@php $checkAttrId = 'formWaitingApprove' @endphp
<div id="eam0008" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11">
        <div class="text-right">
          <button id="undoBtn" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
            <i class="fa fa-undo"></i> ล้างค่า
          </button>
          <button id="searchBtn" class="btn btn-default btn-lg size-btn mt-1" role="button">
            <i class="fa fa-search"></i> ค้นหา
          </button>
        </div>
      </div>
      <div class="col-11 mt-4">
        @include('eam.work-requests._form')
      </div>
      <div class="col-11 mt-4">
        <div class="row">
          <div id="table" class="col-sm-4 text-left inline pt-2">
            <h4>อนุมัติใบสั่งงาน</h4>
          </div>
          <div class="col-sm-8 text-right inline float-right">
            <button id="approvalBtn" class="btn btn-primary btn-lg size-btn mt-1">
              อนุมัติ
            </button>
            <button id="cancleBtn" class="btn btn-danger btn-lg size-btn mt-1">
              ปฏิเสธ
            </button>
          </div>
        </div>
      </div>
      <div class="col-11 mt-4">
        @include('eam.work-requests._table')
      </div>
    </div>
  </div>
  @include('eam.work-requests._modalLov')
</div>
@endsection
@section('scripts')
  @include('eam.commons.scripts.all-date');
  @include('eam.commons.scripts.clear-input');
  @include('eam.commons.scripts.drop-down-work-order-type');
  @include('eam.commons.scripts.drop-down-importance');
  @include('eam.commons.scripts.lov-work-order-number');
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-department');
  {{-- @include('eam.commons.scripts.lov-employee'); --}}
  @include('eam.commons.scripts.lov-employee-web-user');
  @include('eam.commons.scripts.loader');
  <script>
    loader('hide');
    var defaultUser = {!! json_encode($user->toArray(), JSON_HEX_TAG) !!};
    var dataTableReleaseWorkOrder = []
    $("#workOrderNumber").val('');
    $("#assetNumber").val('');
    $("#machineName").val('');
    $("#notifyingAgency").val('');
    $("#repairer").val('');
    $("#workOrderType").val('');
    $("#importance").val('');
    $("#repairNotificationDateSt").val('');
    $("#repairNotificationDateEn").val('');

    $("#formAll").removeClass('d-none');

    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });

    setDatePicker({idDate: 'repairNotificationDateSt', nameDate: '', onchange: false, date: '', disabled: false, required: false, dateEndId: `repairNotificationDateEn`});
    setDatePicker({idDate: 'repairNotificationDateEn', nameDate: '', onchange: false, date: '', disabled: false, required: false});

    let thead = [{
      name: 'เลขที่ใบสั่งงาน',
      style: 'min-width: 120px;'
    }, {
      name: 'ประเภทของใบสั่งงาน',
      style: 'min-width: 140px;'
    }, {
      name: 'สถานะใบสั่งงาน',
      style: 'min-width: 180px;'
    }, {
      name: 'ชื่อเครื่องจักร',
      style: 'min-width: 200px;'
    }, 
    // {
    //   name: 'คำอธิบายใบสั่งงาน',
    //   style: 'min-width: 200px;'
    // }, 
    {
      name: 'วันที่แจ้งซ่อม',
      style: 'min-width: 120px;'
    }, {
      name: 'ผู้แจ้งซ่อม',
      style: 'min-width: 170px;'
    }, {
      name: 'หน่วยงานผู้แจ้ง',
      style: 'min-width: 220px;'
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

        //Default หน่วยงานผู้แจ้ง
        var newOptionReportingAgency = new Option(defaultUser.department_code + ' - ' + department_desc, defaultUser.department_code, true, true);
        $('#reportingAgency').append(newOptionReportingAgency).trigger('change');
        $('#reportingAgency').val(defaultUser.department_code).trigger('change');

        $("#workOrderStatus").html(`<option value="8">Waiting for Approve</option>`);
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })

    $("#undoBtn").click(() => {
      $(".clearable").removeClass('x onX');
      $("#workOrderNumber").val('').trigger('change');
      $("#workOrderNumber").prop('disabled', false);
      $("#workOrderNumberLovBtn").prop('disabled', false);
      $("#assetNumber").val('').trigger('change');
      $("#assetNumber").prop('disabled', false);
      $("#assetNumberLovBtn").prop('disabled', false);
      $("#notifyingAgency").val('').trigger('change');
      $("#notifyingAgency").prop('disabled', false);
      $("#notifyingAgencyLovBtn").prop('disabled', false);
      $("#repairer").val('').trigger('change');
      $("#repairerId").val('').trigger('change');
      $("#repairer").prop('disabled', false);
      $("#repairerLovBtn").prop('disabled', false);
      $("#workOrderType").val('').trigger('change');
      $("#workOrderType").prop('disabled', false);
      $("#importance").val('').trigger('change');
      $("#importance").prop('disabled', false);
      vmDatePicker.repairNotificationDateSt.pValue = ''
      vmDatePicker.repairNotificationDateSt.disabled = false
      vmDatePicker.repairNotificationDateEn.pValue = ''
      vmDatePicker.repairNotificationDateEn.disabled = false
      vmDatePicker.repairNotificationDateEn.pDisabled = ''
      $("#checkboxAllTable").prop('checked', false);
      $("#setTbodyTable").html('');
      $('#setTablePagination').html('');
    })

    $("#searchBtn").click(() => {
      search(false);
    })

    function search(data) {
      loader('show');
      $.ajax({
        url: "{{ route('eam.ajax.work-requests.search-hierarchy') }}",
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: JSON.stringify({
          'work_request_number':        $("#workOrderNumber").val(),
          'asset_number':               $("#assetNumber").val(),
          'asset_desc':                 $("#assetNumber option:selected").text().split(' - ')[1],
          'owning_dept_code':           $("#reportingAgency").val(),
          'work_request_status_desc':   $("#workOrderStatus option:selected").text(),
          'receiving_dept_code':        $("#notifyingAgency").val(),
          'employee_desc':              $("#repairer").val() ? 
                                        $("#repairer option:selected").text().split(' - ')[1] : '',
          'work_request_type_desc':     $("#workOrderType option:selected").text(),
          'work_request_priority_desc': $("#importance option:selected").text(),
          'creation_date_st':           $("#repairNotificationDateSt").val(),
          'creation_date_en':           $("#repairNotificationDateEn").val(),
          'work_order_number':          $("#workReceiptNumber").val()
        }),
        success: function (response) {
          dataTableReleaseWorkOrder = response.data.original.data;
          if (response.data.original.data.length > 0 || data) {
            setTableReleaseWorkOrderFn(response.data.original);
            window.location.href = '#table'
          } else {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setTbodyTable").html('');
            $('#setTablePagination').html('');
          }
          loader('hide');
        },
        error: function (jqXHR, textStatus, errorThrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
          loader('hide');
        }
      });
    }

    $("#checkboxAllTable").click((e) => { 
      var table = $(e.target).closest('table');
      $('td input:checkbox', table).prop('checked', $("#checkboxAllTable").prop('checked'));

    })

    function setTableReleaseWorkOrderFn(data) {
      let tbodyTable = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          tbodyTable += `<tr>`
          tbodyTable += `<td class="text-center"><input id="${row.work_request_number}" type="checkbox" name="case[]"></td>`
          tbodyTable += `<td><a href="{{ route('eam.work-requests.create', ['']) }}?id=${row.work_request_number}"><u>${row.work_request_number ? row.work_request_number : ''}</u></a></td>`
          tbodyTable += `<td>${row.work_request_type_desc ? row.work_request_type_desc : ''}</td>`
          tbodyTable += `<td>${row.work_request_status_desc ? row.work_request_status_desc : ''}</td>`
          tbodyTable += `<td>${row.asset_desc ? row.asset_desc : ''}</td>`
          tbodyTable += `<td class="text-center">${row.expected_start_date ? row.expected_start_date : ''}</td>`
          tbodyTable += `<td class="text-center">${row.employee_desc ? row.employee_desc : ''}</td>`
          tbodyTable += `<td>${row.owning_dept_code ? row.owning_dept_code : ''} - ${row.owning_dept_desc ? row.owning_dept_desc : ''}</td>`
          tbodyTable += `</tr>`
        })
      }
      $("#setTbodyTable").html(tbodyTable);

      let pagination = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        pagination += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchTableReleaseWorkOrderPagination('` + link.url + `')">${link.label}</a></li>`
      });
      pagination += '</ul>';
      $('#setTablePagination').html(pagination);
    }

    function searchTableReleaseWorkOrderPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          data: JSON.stringify({
            'work_request_number':        $("#workOrderNumber").val(),
            'asset_number':               $("#assetNumber").val(),
            'asset_desc':                 $("#assetNumber option:selected").text().split(' - ')[1],
            'owning_dept_code':           $("#reportingAgency").val(),
            'work_request_status_desc':   $("#workOrderStatus option:selected").text(),
            'receiving_dept_code':        $("#notifyingAgency").val(),
            'employee_desc':              $("#repairer").val() ? 
                                          $("#repairer option:selected").text().split(' - ')[1] : '',
            'work_request_type_desc':     $("#workOrderType option:selected").text(),
            'work_request_priority_desc': $("#importance option:selected").text(),
            'creation_date_st':           $("#repairNotificationDateSt").val(),
            'creation_date_en':           $("#repairNotificationDateEn").val(),
            'work_order_number':          $("#workReceiptNumber").val()
          }),
          success: function (response) {
            dataTableReleaseWorkOrder = response.data.original.data;
            if (response.data.original.data.length > 0) {
              setTableReleaseWorkOrderFn(response.data.original);
              window.location.href = '#table'
            } else {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setTbodyTable").html('');
              $('#setTablePagination').html('');
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        });
      }
    }
    
    $("#approvalBtn").click(() => {
      save('3');
    })

    $("#cancleBtn").click(() => {
      save('5');
    })
    
    function save(data) {
      let dataSave = []
      $.each($("input[name='case[]']:checked"),
      function () {
        var checkBox = $(this).parents('tr:eq(0)');
        dataTableReleaseWorkOrder.filter( row => {
          if (row.work_request_number == $(checkBox).find('td:eq(1)').text()) {
            dataSave.push(row)
          }
        })
      })
      if (dataSave.length > 0) {
        $.ajax({
          url: "{{ route('eam.ajax.work-requests.update-status') }}",
          method: 'put',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          data: JSON.stringify({
            'work_request_status_id': data,
            'data': dataSave
          }),
          success: function (response) {
            if (data == '3') {
              swal("Success", response.message, "success")
              search(true);
            } else {
              swal("Success", response.message, "success")
              search(true);
            }
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      } else {
        swal("กรุณาเลือกรายการ", "", "warning");
      }
    }
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection