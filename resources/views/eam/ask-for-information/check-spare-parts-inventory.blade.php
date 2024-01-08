@extends('layouts.app')

@section('title', 'Main page')

@section('custom_css')
  <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
@stop

{{-- @section('page-title')
  <h2><x-get-program-code url="/eam/ask-for-informationcheck-on-hand/check-spare-parts-inventory" />: ตรวจสอบอะไหล่คงคลัง</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>สอบถามข้อมูล</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>ตรวจสอบอะไหล่คงคลัง</strong>
    </li>
  </ol>

@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/eam/ask-for-information/check-spare-parts-inventory" />
@stop

@section('content')
@php $checkAttrId = 'checkSparePartsInventory' @endphp
<div id="eam0001" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row">
      <div class="col-12">
        <div class="text-right">
          <button id="undoBtn" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
            <i class="fa fa-undo"></i> ล้างค่า
          </button>
          <button id="searchBtn" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
            <i class="fa fa-search"></i> ค้นหา
          </button>
        </div>
      </div>
      <div class="col-11 mt-4 ml-5">
        @include('eam.ask-for-information._form')
      </div>
      <div id="table" class="text-left inline pt-2 ml-5">
        <h4>Item Master</h4>
      </div>
      <div class="col-11 ml-5">
        @include('eam.ask-for-information._table')
      </div>
    </div>
  </div>
  @include('eam.ask-for-information._modalLov')
</div>
@endsection
@section('scripts')
  <script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
  @include('eam.commons.scripts.drop-down-locator');
  @include('eam.commons.scripts.drop-down-subinventory');
  @include('eam.commons.scripts.drop-down-checkOnHandMachine01');
  @include('eam.commons.scripts.drop-down-checkOnHandMachine02');
  <script>
    $("#formAll").removeClass('d-none');
    let thead = [
      {
        name: '',
        style: 'min-width: 75px;'
      },
      {
        name: 'Item Code',
        style: 'min-width: 120px;'
      }, {
        name: 'Item Description',
        style: 'min-width: 250px;'
      }, {
        name: 'Part Number',
        style: 'min-width: 140px;'
      }, {
        name: 'On Hand',
        style: 'min-width: 100px;'
      }, {
        name: 'Subinventory',
        style: 'min-width: 120px;'
      }, {
        name: 'Locator',
        style: 'min-width: 150px;'
      }, {
        name: 'Lot Number',
        style: 'min-width: 150px;'
      }, {
        name: 'Old Item Number',
        style: 'min-width: 140px;'
      }, {
        name: 'Part Number Old',
        style: 'min-width: 140px;'
      }, {
        name: 'machine 01',
        style: 'min-width: 120px;'
      }, {
        name: 'machine 02',
        style: 'min-width: 120px;'
      }
    ]
    let theadTable = ''
      thead.filter(row => {
        theadTable += `<th class="text-center" style="${row.style}">`
        theadTable += `<div>${row.name}</div>`
        theadTable += `</th>`
     })
    $("#setTheadTable").html(theadTable);

    $("#undoBtn").click(() => {
      $("#itemCode").val('');
      $("#itemDescription").val('');
      $("#partNumber").val('');
      $("#oldOtemNumber").val('');
      $("#partNumberOld").val('');
      $("#machine01").val('').trigger('change');
      $("#machine02").val('').trigger('change');
      $("#subinventory").val('').trigger('change');
      $("#locator").val('');
      $("#locator").html('');
      $("#setTbodyTable").html('');
      $('#setTablePagination').html('');
    })

    $("#searchBtn").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.check-on-hand.search') }}",
        method: 'get',
        data: {
          'item_code': $("#itemCode").val(),
          'item_description': $("#itemDescription").val(),
          'part_number': $("#partNumber").val(),
          'old_item_number': $("#oldOtemNumber").val(),
          'part_number_old': $("#partNumberOld").val(),
          'machine_01': $("#machine01").val(),
          'machine_02': $("#machine02").val(),
          'subinventory': $("#subinventory").val(),
          'locator_name': $("#locator").val()
        },
        success: function (response) {
          if (response.data.original.data.length > 0) {
            setTableAskForInformationFn(response.data.original);
            window.location.href = '#table'
          } else {
            Swal.fire("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#setTbodyTable").html('');
            $("#setTablePagination").html('');
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          Swal.fire("Error", jqXHR.responseText.message, "error");
        }
      });
    })
    function setTableAskForInformationFn(data) {
      let tbodyTable = ''
      if (data.data.length > 0) {
        data.data.filter(row => {
          tbodyTable += `<tr>`
          tbodyTable += `<td><button onclick="imgDetail('` + row.item_code + `')"  type="button" class="btn btn-success btn-sm">Picture </button></td>`
          tbodyTable += `<td>${row.item_code ? row.item_code : ''}</td>`
          tbodyTable += `<td>${row.item_description ? row.item_description : ''}</td>`
          tbodyTable += `<td>${row.part_number ? row.part_number : ''}</td>`
          tbodyTable += `<td>${row.on_hand ? row.on_hand : ''}</td>`
          tbodyTable += `<td>${row.subinventory ? row.subinventory : ''}</td>`
          tbodyTable += `<td>${row.locator_name ? row.locator_name : ''}</td>`
          tbodyTable += `<td>${row.lot_number ? row.lot_number : ''}</td>`
          tbodyTable += `<td>${row.old_item_number ? row.old_item_number : ''}</td>`
          tbodyTable += `<td>${row.part_number_old ? row.part_number_old : ''}</td>`
          tbodyTable += `<td>${row.machine_01 ? row.machine_01 : ''}</td>`
          tbodyTable += `<td>${row.machine_02 ? row.machine_02 : ''}</td>`
          tbodyTable += `</tr>`
        })
      }
      $("#setTbodyTable").html(tbodyTable);

      let pagination = '<ul class="pagination float-right">';
      $.each(data.links , function( i , link ){
        pagination += `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchTableAskForInformationPagination('` + link.url + `')">${link.label}</a></li>`
      });
      pagination += '</ul>';
      $('#setTablePagination').html(pagination);
    }
    function searchTableAskForInformationPagination(data) {
      if (data != 'null') {
        $.ajax({
          url: data,
          method: 'get',
          data: {
            'item_code': $("#itemCode").val(),
            'item_description': $("#itemDescription").val(),
            'part_number': $("#partNumber").val(),
            'old_item_number': $("#oldOtemNumber").val(),
            'part_number_old': $("#partNumberOld").val(),
            'machine_01': $("#machine01").val(),
            'machine_02': $("#machine02").val(),
            'subinventory': $("#subinventory").val(),
            'locator_name': $("#locator").val()
          },
          success: function (response) {

            if (response.data.original.data.length > 0) {
              setTableAskForInformationFn(response.data.original);
              window.location.href = '#table'
            } else {
              Swal.fire("ค้นหาข้อมูลไม่พบ", "", "warning");
              $("#setTbodyTable").html('');
              $("#setTablePagination").html('');
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire("Error", jqXHR.responseText.message, "error");
          }
        });
      }
    }
    $("#subinventory").change(() => {
      changSubinventory()
    })
    function imgDetail(data) {
      $.ajax({
        url: "{{ route('eam.ajax.check-on-hand.images',['']) }}/" + data,
        method: 'GET',
        success: function (response) {
          $("#detailModalImage").modal('show');
          $("#modalImageSearchItemCode").val(data);
          setImageFileNewFn(response.data);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          Swal.fire("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
    var dataImageFileOld = ''
    function setImageFileFn(data) {
      let theadModalFile = ''
      if (data.length > 0) {
        data.filter(row => {
          theadModalFile += `<tr id="imageFile${row.attachment_id}" onClick="setImageFile('` + row.attachment_id + `')">`
          theadModalFile += `<td class="pointer">${row.attachment_id}</td>`
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
          theadModalFile += `<div style="position: absolute; z-index: 1; background: #000; top: 0; cursor: zoom-in;" onClick="setImageFile('` + row.attachment_id + `')"><img src="{{route('eam.ajax.check-on-hand.image.show',[''])}}/${row.attachment_id}" style="width: 100%;" /></div>`
          theadModalFile += `<div style="position: absolute; z-index: 2; top: 2px; right: 2px;"><button type="button" class="btn btn-danger btn-sm" style="padding: .15rem .3rem;" onClick="deleteImageBtn(${row.attachment_id})"><i class="fa fa-times"></i></button></div>`
          theadModalFile += `</div>`
        })
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

      $("#setShowImageFileFn").attr('src', `{{route('eam.ajax.check-on-hand.image.show',[''])}}/` + $("#selectImageDelete").val());
      $("#detailModalImageView").modal('show');
    }
    $("#addImageBtn").click(() => {
      $("#modalFile").val('');
      $('.custom-file-label').html('');
      $("#detailModalImageAdd").modal('show');
    })
    $("#deleteImageBtn").click(() => {
      if ($("#selectImageDelete").val() != '') {
        $.ajax({
          url: "{{ route('eam.ajax.check-on-hand.image.delete',['']) }}/" + $("#selectImageDelete").val(),
          method: 'DELETE',
          headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
          success: function (response) {
            $.ajax({
              url: "{{ route('eam.ajax.check-on-hand.images',['']) }}/" + $("#modalImageSearchItemCode").val(),
              method: 'GET',
              success: function (response) {
                Swal.fire("Success", response.message, "success");
                // setImageFileFn(response.data);
                setImageFileNewFn(response.data);
                $("#selectImageDelete").val('')
              },
              error: function (jqXHR, textStatus, errorRhrown) {
                Swal.fire("Error", jqXHR.responseJSON.message, "error");
                $("#selectImageDelete").val('')
              }
            })
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            Swal.fire("Error", jqXHR.responseJSON.message, "error");
          }
        })
      } else {
        Swal.fire("กรุณาเลือกรายการ", "", "warning");
      }
    })
    $("#viewImageBtn").click(() => {
      if ($("#selectImageDelete").val() != '') {
        $("#setShowImageFileFn").attr('src', `{{route('eam.ajax.check-on-hand.image.show',[''])}}/` + $("#selectImageDelete").val());
        $("#detailModalImageView").modal('show');
      } else {
        Swal.fire("กรุณาเลือกรายการ", "", "warning");
      }
    })

    $("#modalModalImageAddBtn").click(() => {
      $('#detailModalImageAddForm').attr('action', "{{ route('eam.ajax.check-on-hand.image.upload',['']) }}/" + $("#modalImageSearchItemCode").val())
      $("#programCode").val('EAM0001')
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
          Swal.fire({
            title: "Success",
            text: data.message,
            icon: "success"
          }).then(() => $("#detailModalImageAdd").modal('hide'))
          $.ajax({
            url: "{{ route('eam.ajax.check-on-hand.images',['']) }}/" + $("#modalImageSearchItemCode").val(),
            method: 'GET',
            success: function (response) {
              // setImageFileFn(response.data);
              setImageFileNewFn(response.data);
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              Swal.fire("Error", jqXHR.responseJSON.message, "error");
            }
          })
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          Swal.fire("Error", jqXHR.responseJSON.message, "error");
        }
      });
    });
    $("#detailModalImageAdd").on('hidden.bs.modal', () => {
      $('body').addClass('modal-open')
    })
    $("#detailModalImageView").on('hidden.bs.modal', () => {
      $('body').addClass('modal-open')
    })
    $('#modalFile').on('change',function(){
      var fileName = $(this).val();
      $(this).next('.custom-file-label').html(fileName);
    })

    function deleteImageBtn(attachment_id) {
      Swal.fire({
        title: 'ต้องการลบรายการนี้หรือไม่!',
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
      }).then( async (result) => {
        if (result.isConfirmed) {
          if (attachment_id != '') {
            $.ajax({
              url: "{{ route('eam.ajax.check-on-hand.image.delete',['']) }}/" + attachment_id,
              method: 'DELETE',
              headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
              success: function (response) {
                $.ajax({
                  url: "{{ route('eam.ajax.check-on-hand.images',['']) }}/" + $("#modalImageSearchItemCode").val(),
                  method: 'GET',
                  success: function (response) {
                    Swal.fire("Success", response.message, "success");
                    // setImageFileFn(response.data);
                    setImageFileNewFn(response.data);
                    $("#selectImageDelete").val('')
                  },
                  error: function (jqXHR, textStatus, errorRhrown) {
                    Swal.fire("Error", jqXHR.responseJSON.message, "error");
                    $("#selectImageDelete").val('')
                  }
                })
              },
              error: function (jqXHR, textStatus, errorRhrown) {
                Swal.fire("Error", jqXHR.responseJSON.message, "error");
              }
            })
          } else {
            Swal.fire("กรุณาเลือกรายการ", "", "warning");
          }
        }
      });
    }
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection
