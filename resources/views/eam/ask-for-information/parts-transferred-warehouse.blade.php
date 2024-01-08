@extends('layouts.app')

@section('title', 'Main page')

{{-- @section('page-title')
  <h2><x-get-program-code url="/eam/ask-for-information/parts-transferred-warehouse" />: อะไหล่ถูกโอนเข้าคลัง</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>สอบถามข้อมูล</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>อะไหล่ถูกโอนเข้าคลัง</strong>
    </li>
  </ol>
    
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/eam/ask-for-information/parts-transferred-warehouse" />
@stop

@section('content')
@php $checkAttrId = 'partsTransferredWarehouse' @endphp
<div id="eam0002" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row">
      <div class="col-12">
        <div class="text-right">
          <a id="searchBtn" class="btn btn-default btn-lg size-btn" role="button" aria-pressed="true">
            <i class="fa fa-search"></i> ค้นหา
          </a>
        </div>
      </div>
      <div class="col-11 mt-4 ml-5">
        @include('eam.ask-for-information._form')
      </div>
      <div class="col-11 ml-5">
        @include('eam.ask-for-information._table')
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  @include('eam.commons.scripts.all-date');
  <script>
    $("#formAll").removeClass('d-none');
    var defaultUser = {!! json_encode($user->toArray(), JSON_HEX_TAG) !!};

    setDatePicker({idDate: 'date', nameDate: '', onchange: false, date: '', disabled: false, required: false});

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
        $("#agency").val(defaultUser.department_code + ' - ' + department_desc);
        vmDatePicker.date.pValue = getDate();
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })

    let thead = [
      {
        name: 'รหัสอะไหล่',
        style: 'min-width: 140px;'
      }, {
        name: 'คำอธิบาย',
        style: 'min-width: 270px;'
      }, {
        name: 'โอนจากคลัง',
        style: 'min-width: 140px;'
      }, {
        name: 'โอนจากสถานที่จัดเก็บ',
        style: 'min-width: 180px;'
      }, {
        name: 'ไปยังคลัง',
        style: 'min-width: 140px;'
      }, {
        name: 'ไปยังสถานที่จัดเก็บ',
        style: 'min-width: 180px;'
      }, {
        name: 'Lot Number',
        style: 'min-width: 140px;'
      }, {
        name: 'จำนวน',
        style: 'min-width: 120px;'
      }, {
        name: 'หน่วยนับ',
        style: 'min-width: 100px;'
      }, {
        name: 'วันที่โอน',
        style: 'min-width: 100px;'
      }, {
        name: 'เลขที่ใบขอเบิก',
        style: 'min-width: 180px;'
      }, {
        name: 'หน่วยงานที่ขอเบิก',
        style: 'min-width: 240px;'
      }
    ]
    let theadTable = ''
      thead.filter(row => {
        theadTable += `<th class="text-center" style="${row.style}">`
        theadTable += `<div>${row.name}</div>`
        theadTable += `</th>`
     })
    $("#setTheadTable").html(theadTable);

    $("#searchBtn").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.check-transaction.search') }}",
        method: 'get',
        data: {
          'transfer_date': $("#date").val(),
          'transfer_department': $("#agency").val().split(' - ')[0]
        },
        success: function (response) {
          if (response.data.original.data.length > 0) {
            setTableWorkOrderFn(response.data.original);
            window.location.href = '#table'
          } else {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setTbodyTable").html('');
            $("#setTablePagination").html('');
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
          tbodyTable += `<td>${row.item_code ? row.item_code : ''}</td>`
          tbodyTable += `<td>${row.item_description ? row.item_description : ''}</td>`
          tbodyTable += `<td>${row.transfer_from_sub ? row.transfer_from_sub : ''}</td>`
          tbodyTable += `<td>${row.transfer_from_locator ? row.transfer_from_locator : ''}</td>`
          tbodyTable += `<td>${row.transfer_to_sub ? row.transfer_to_sub : ''}</td>`
          tbodyTable += `<td>${row.transfer_to_locator ? row.transfer_to_locator : ''}</td>`
          tbodyTable += `<td>${row.lot_number ? row.lot_number : ''}</td>`
          tbodyTable += `<td>${row.transfer_qty ? row.transfer_qty : ''}</td>`
          tbodyTable += `<td>${row.transfer_uom ? row.transfer_uom : ''}</td>`
          tbodyTable += `<td>${row.transfer_date}</td>`
          tbodyTable += `<td>${row.transfer_number ? row.transfer_number : ''}</td>`
          tbodyTable += `<td>${row.transfer_department ? row.transfer_department : ''} - ${row.transfer_department_desc ? row.transfer_department_desc : ''}</td>`
         tbodyTable += `</tr>`
        })
      }
      $("#setTbodyTable").html(tbodyTable);

      let pagination = '<ul class="pagination float-right">';
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
          'transfer_date': $("#date").val(),
          'transfer_department': $("#agency").val().split(' - ')[0]
          },
          success: function (response) {
            if (response.data.original.data.length > 0) {
              setTableWorkOrderFn(response.data.original);
              window.location.href = '#table'
            } else {
              swal("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setTbodyTable").html('');
              $("#setTablePagination").html('');
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