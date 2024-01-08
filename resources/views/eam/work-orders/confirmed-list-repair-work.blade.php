@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <h2><x-get-program-code url="/eam/work-orders/confirmed-list-repair-work" />: รายการงานซ่อมคอยยืนยัน</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>งานซ่อม</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>รายการงานซ่อมคอยยืนยัน</strong>
    </li>
  </ol>
    
@stop

@section('content')
<div id="eam0015" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11">
        <div class="text-right">
          <a id="searchBtn" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
            <i class="fa fa-search"></i> ค้นหา
          </a>
        </div>
      </div>
      <div class="col-11">
        <div id="table" class="text-left inline pt-2">
          <h4>ใบสั่งงาน</h4>
        </div>
      </div>
      <div class="col-11">
        @include('eam.work-orders._table')
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  @include('eam.commons.scripts.all-date');
  <script>
    $("#formAll").removeClass('d-none');
    let thead = [{
      name: 'เลขที่ใบรับงาน',
      style: 'min-width: 120px;'
    }, {
      name: 'เหตุผลในการยกเลิก Complete',
      style: 'min-width: 200px;'
    }, {
      name: 'ประเภทของใบรับงาน',
      style: 'min-width: 140px;'
    }, {
      name: 'ชื่อเครื่องจักร (Number)',
      style: 'min-width: 200px;'
    }, {
      name: 'คำอธิบายใบสั่งงาน',
      style: 'min-width: 200px;'
    }, {
      name: 'ประมาณวันที่เริ่มซ่อม',
      style: 'min-width: 140px;'
    }, {
      name: 'ประมาณวันที่ซ่อมเสร็จ',
      style: 'min-width: 140px;'
    }, {
      name: 'เลขที่ใบสั่งงาน',
      style: 'min-width: 120px;'
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

    $("#searchBtn").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.work-order.head.waiting-confirm') }}",
        method: 'get',
        success: function (response) {
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
          tbodyTable += `<td>${row.reason ? row.reason : ''}</td>`
          tbodyTable += `<td>${row.work_order_type_desc ? row.work_order_type_desc : ''}</td>`
          tbodyTable += `<td>${row.asset_desc ? row.asset_desc : ''}</td>`
          tbodyTable += `<td>${row.description ? row.description : ''}</td>`
          tbodyTable += `<td>${row.scheduled_start_date ? row.scheduled_start_date : ''}</td>`
          tbodyTable += `<td>${row.scheduled_completion_date ? row.scheduled_completion_date : ''}</td>`
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
          success: function (response) {
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
            swal("Error", jqXHR.responseText.message, "error");
          }
        });
      }
    }
  </script>
@endsection