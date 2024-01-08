@extends('layouts.app')

@section('title', 'Main page')

@section('page-title')
  <x-get-page-title menu="" url="/eam/work-requests/create" />
@stop

@section('content')
@php $checkAttrId = 'formCreate' @endphp
<div id="eam0007" class="ibox eam">
  <div id="formAll" class="ibox-content d-none">
    <div class="row justify-content-center">
      <div class="col-11">
        <div class="text-right">
          <button id="undoBtn" class="btn btn-default btn-lg mt-1" style="width: 130px;">
            <i class="fa fa-undo"></i> ล้างค่า
          </button>
          <button id="createBtn" class="btn btn-success btn-lg mt-1" style="width: 130px;">
            สร้าง
          </button>
          <button id="saveBtn" class="btn btn-primary btn-lg mt-1" style="width: 130px;">
            บันทึก
          </button>
          <button id="printBtn" class="btn btn-info btn-lg mt-1" style="width: 130px;">
            <i class="fa fa-print fa-lg"></i> พิมพ์รายงาน
          </button>
        </div>
      </div>
      <div class="col-11">
        <div class="text-right">
          <button id="fileBtn" class="btn btn-success btn-lg mt-1" style="width: 130px;" disabled>
            แนบรูปภาพ
          </button>
          <button id="approvalBtn" class="btn btn-primary btn-lg mt-1" style="width: 130px;" disabled>
            ส่งอนุมัติ
          </button>
          <button id="cancelApprove" class="btn btn-primary btn-lg mt-1" style="width: 130px;">
            ยกเลิกอนุมัติ
          </button>
          <button id="cancelWork" class="btn btn-danger btn-lg mt-1" style="width: 130px;">
            ยกเลิกใบแจ้งซ่อม
          </button>
          <button id="openRepairWorkBtn" class="btn btn-primary btn-lg mt-1" style="width: 130px; padding: 0; line-height: 15px; height: 37px; font-size: 12px;" disabled>
            เปิดงานซ่อม <br> (Work Order)
          </button>
        </div>
      </div>

      <div class="col-11 mt-4">
      <form onsubmit="formSaveBtnHide();return false;">
        @include('eam.work-requests._form')
        <input type="hidden" id="permissionHidden" />
        <button id="saveBtnHide" class="d-none" ></button>
      </form>
      </div>
    </div>
  </div>
  @include('eam.work-requests._modalLov')
  @include('eam.work-requests._modalReason')
</div>
@endsection
@section('scripts')
  @include('eam.commons.scripts.all-date');
  @include('eam.commons.scripts.clear-input');
  @include('eam.commons.scripts.drop-down-work-order-status');
  @include('eam.commons.scripts.drop-down-work-order-type');
  @include('eam.commons.scripts.drop-down-importance');
  @include('eam.commons.scripts.lov-work-order-number');
  @include('eam.commons.scripts.lov-asset-number');
  @include('eam.commons.scripts.lov-department');
  @include('eam.commons.scripts.lov-employee-web-user');

  <script>
    var department_code = null;
    var dataIdWorkRequestNumber = {!! json_encode($workRequestNumber, JSON_HEX_TAG) !!};
    var defaultUser = {!! json_encode($user->toArray(), JSON_HEX_TAG) !!};
    var webBatchNo = ''
    var workRequestNumber = ''
    var dataImageFile = []
    var statusApprove = false
    var workRequestOwningDept = ''
    var jpFlag = false

    $("#awaitingWorkOrderWorkRequestStatusDesc").hide();
    $("#rejectedWorkRequestStatusDesc").hide();

    $(".readonly").on("keydown paste focus mousedown", function(e) {
      if(e.keyCode != 9) {
        e.preventDefault();
      }
    });
    
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

    setDatePicker({idDate: 'repairNotificationDate', nameDate: '', onchange: false, date: '', disabled: true, required: true, pDisabled: getDateLocal({month: -1})});
    setDateTimePickerAll({idDate: 'approvalDate', nameDate: '', onchange: false, date: '', disabled: true, required: false});
    setDatePicker({idDate: 'modalReportWorkOrderDateStart', nameDate: 'p_expected_resolution_date', onchange: false, date: '', disabled: false, required: false, dateEndId: `modalReportWorkOrderDateEnd`});
    setDatePicker({idDate: 'modalReportWorkOrderDateEnd', nameDate: 'p_expected_resolution_date_to', onchange: false, date: '', disabled: false, required: false});

    $.ajax({
      url: "{{ route('eam.ajax.work-requests.permission-approve') }}",
      method: 'GET',
      success: function (response) {
        $("#permissionHidden").val(response.data.permission)
        if (response.data.permission == 'N' || response.data.permission == '') {
          $("#cancelApprove").hide();
          $("#cancelWork").hide();
          $("#formAll").removeClass('d-none');
        } else {
          $("#formAll").removeClass('d-none');
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })

    setValueInput();
    function setValueInput() {
      workRequestNumber = ''
      $("#workOrderNumber").val('').trigger('change');
      $("#assetNumber").val('').trigger('change');
      $("#machineName").val('').trigger('change');
      $("#reportingAgency").val('').trigger('change');
      $("#workOrderStatus").val('').trigger('change');
      $("#notifyingAgency").val('').trigger('change');
      $("#repairer").val('').trigger('change');
      $("#workOrderType").val('').trigger('change');
      $("#workOrderDescription").val('').trigger('change');
      $("#importance").val('').trigger('change');
      $("#workReceiptNumber").val('').trigger('change');
      $("#quantityOfPartsProduced").val('').trigger('change');
      $("#approval").val('').trigger('change');
      $("#referenceWorkReceipt").val(null).trigger('change');
      $("#cancelApprove").prop('disabled', true);
      $("#cancelWork").prop('disabled', true);
      vmDatePicker.repairNotificationDate.pValue = ''
      vmDateTimePickerAll.approvalDate.pValue = ''
    }

    function clearForm() {
      $("#workOrderNumber").val('').trigger('change');
      $("#workOrderNumber").prop('disabled', false);
      $("#workOrderNumberLovBtn").prop('disabled', false);
      $("#assetNumber").val('').trigger('change');
      $("#assetNumber").prop('disabled', true);
      $("#assetNumberLovBtn").prop('disabled', true);
      $("#machineName").val('').trigger('change');
      $("#machineName").prop('disabled', true);
      $("#reportingAgency").val('').trigger('change');
      $("#reportingAgency").prop('disabled', true);
      $("#reportingAgencyLovBtn").prop('disabled', true);
      $("#workOrderStatus").val('').trigger('change');
      $("#workOrderStatus").prop('disabled', true);
      $("#notifyingAgency").val('').trigger('change');
      $("#notifyingAgency").prop('disabled', true);
      $("#notifyingAgencyLovBtn").prop('disabled', true);
      $("#repairer").val('').trigger('change');
      $("#repairerId").val('');
      $("#repairer").prop('disabled', true);
      $("#repairerLovBtn").prop('disabled', true);
      $("#workOrderType").val('').trigger('change');
      $("#workOrderType").prop('disabled', true);
      $("#workOrderDescription").val('');
      $("#workOrderDescription").prop('disabled', true);
      $("#importance").val('').trigger('change');
      $("#importance").prop('disabled', true);
      $("#workReceiptNumber").val('');
      $("#workReceiptNumber").prop('disabled', true);
      $("#quantityOfPartsProduced").val('');
      $("#quantityOfPartsProduced").prop('disabled', true);
      $("#approval").val('');
      $("#approval").prop('disabled', true);
      $("#referenceWorkReceipt").val(null).trigger('change');
      $("#referenceWorkReceipt").prop('disabled', true);
      vmDatePicker.repairNotificationDate.pValue = ''
      vmDatePicker.repairNotificationDate.disabled = true
      vmDateTimePickerAll.approvalDate.pValue = ''
      vmDateTimePickerAll.approvalDate.disabled = true
      $("#createBtn").prop('disabled', false);
      $("#saveBtn").prop('disabled', false);
      $("#printBtn").prop('disabled', false);
      $("#fileBtn").prop('disabled', true);
      $("#approvalBtn").prop('disabled', true);
      $("#openRepairWorkBtn").prop('disabled', true);
      $("#awaitingWorkOrderWorkRequestStatusDesc").hide();
      $("#rejectedWorkRequestStatusDesc").hide();
    }

    $("#undoBtn").click(() => {
      clearForm();
    })

    clearDataLovWorkOrderNumber()

    if (dataIdWorkRequestNumber) {
      $.ajax({
        url: "{{ route('eam.ajax.lov.work-request-number') }}",
        method: 'GET',
        data: {
          'p_work_request_number': dataIdWorkRequestNumber
        },
        success: function (response) {
          dataLovWorkOrderNumber = response.data;
          if (response.data.length != 1) {
            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
            $("#workOrderNumber").val('')
            clearDataLovWorkOrderNumber()
          } else {
            idLovWorkOrderNumber = 'workOrderNumber'
            setDataLovWorkOrderNumber(response.data[0].work_request_number)
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }

    $("#modalReportWorkOrderStatus").change(() => {
      $("#modalReportWorkOrderStatusDesc").val($("#modalReportWorkOrderStatus option:selected").text())
    })

    $("#workOrderStatus").change(() => {
      if (  ($("#workOrderStatus").val() == '1' || 
             $("#workOrderStatus").val() == '2' || 
             $("#workOrderStatus").val() == '5') && 
             $("#workOrderNumber").val() != ''        ){
        if($("#workOrderNumber").val() === null){
          $("#approvalBtn").prop('disabled', true);
        }else{
          $("#approvalBtn").prop('disabled', false);
        }
        $("#addImageBtn").prop('disabled', false);
        $("#deleteImageBtn").prop('disabled', false);
        $(".deleteImageBtn").prop('disabled', false);

        $("#repairNotificationDate").prop('style', 'background-color:#E4E7EB');
        vmDatePicker.repairNotificationDate.disabled = true;
        $("#repairNotificationDate").prop("disabled", true);
      } else {
        $("#approvalBtn").prop('disabled', true);
        $("#addImageBtn").prop('disabled', true);
        $("#deleteImageBtn").prop('disabled', true);
        $(".deleteImageBtn").prop('disabled', true);

        $("#repairNotificationDate").prop('style', 'background-color:none');
        vmDatePicker.repairNotificationDate.disabled = false;
        $("#repairNotificationDate").prop("disabled", false);
      }
      
      if ($("#workOrderStatus").val() == '3' && 
          $("#workOrderNumber").val() != '') {
        $("#openRepairWorkBtn").prop('disabled', false);
      } else {
        $("#openRepairWorkBtn").prop('disabled', true);
      }

      if(!$("#workOrderNumber").val()){
        $("#fileBtn").prop('disabled', true);
      }else{
        $("#fileBtn").prop('disabled', false);
      }
    })

    $("#createBtn").click(() => {
      swal({
        title: "ต้องการสร้างใบแจ้งซ่อมหรือไม่",
        text: "",
        type: "warning",
        showCancelButton: true
      },function() {
        createNew();
      })
    })

    $("#saveBtn").click(() => {
      statusApprove = false
      $("#saveBtnHide").click();
    })

    function formSaveBtnHide() {
      if ($("#assetNumber").val() !== null) {
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
          closeOnClickOutside: true
        }, function(isConfirm){
          if(isConfirm){
            $.ajax({
              url: "{{ route('eam.ajax.work-requests.store') }}",
              type: "POST",
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
              },
              data: JSON.stringify({
                'work_request_number':          $("#workOrderNumber").val(),
                'asset_number':                 $("#assetNumber").val(),
                'asset_desc':                   $("#machineName").val(),
                'work_request_owning_dept':     workRequestOwningDept,
                'owning_dept_code':             $("#reportingAgency").val(),
                'owning_dept_desc':             $("#reportingAgency option:selected").text().split(' - ')[1],
                'work_request_status_id':       $("#workOrderStatus").val(),
                'work_request_status_desc':     $("#workOrderStatus option:selected").text(),
                'receiving_dept_code':          $("#notifyingAgency").val(),
                'receiving_dept_desc':          $("#notifyingAgency option:selected").text().split(' - ')[1],
                'employee_id':                  $("#repairerId").val(),
                'employee_code':                $("#repairer").val(),
                'employee_desc':                $("#repairer option:selected").text().split(' - ')[1],
                'approver_desc':                $("#approval").val(),
                'work_request_type_id':         $("#workOrderType").val(),
                'work_request_type_desc':       $("#workOrderType option:selected").text(),
                'description':                  $("#workOrderDescription").val(),
                'work_request_priority_id':     $("#importance").val(),
                'work_request_priority_desc':   $("#importance option:selected").text(),
                'expected_start_date':          $("#repairNotificationDate").val(),
                'wip_entity_id':                $("#workReceiptNumber").val(),
                'work_order_number':            $("#workReceiptNumber").val(),
                'jp_qty':                       $("#quantityOfPartsProduced").val() !== '' ? 
                                                $("#quantityOfPartsProduced").val() : '0',
                'approved_date':                $("#approvalDate").val(),
                'wo_reference':                 $("#referenceWorkReceipt").val() !== '' ? 
                                                $("#referenceWorkReceipt").val() : '',
                'program_code':                 'EAM0007'
              }),
              success: function (response) {
                if (statusApprove) {
                  approveHide(response.data.work_request_id)
                } else {
                  swal("Success", response.message, "success");
                  $.ajax({
                    url: "{{ route('eam.ajax.work-requests.show',['']) }}/" + response.data.work_request_number,
                    method: 'GET',
                    success: function (response) {
                      setDataLovWorkOrderNumberResponse(response)
                      if ($("#workOrderStatus").val() == '8') {
                        if ($("#permissionHidden").val() == 'Y') {
                          $("#awaitingWorkOrderWorkRequestStatusDesc").show();
                          $("#rejectedWorkRequestStatusDesc").show();
                        } else {
                          $("#awaitingWorkOrderWorkRequestStatusDesc").hide();
                          $("#rejectedWorkRequestStatusDesc").hide();
                        }
                      } else {
                        $("#awaitingWorkOrderWorkRequestStatusDesc").hide();
                        $("#rejectedWorkRequestStatusDesc").hide();
                      }

                      if($("#reportingAgency").val() != $("#notifyingAgency").val()) {
                        $("#repairNotificationDate").prop('style', 'background-color:#E4E7EB');
                        vmDatePicker.repairNotificationDate.disabled = true;
                        $("#repairNotificationDate").prop("disabled", true);
                      } else {
                        $("#repairNotificationDate").prop('style', 'background-color:none');
                        vmDatePicker.repairNotificationDate.disabled = false;
                        $("#repairNotificationDate").prop("disabled", false);
                      }

                    },
                    error: function (jqXHR, textStatus, errorRhrown) {
                      swal("Error", jqXHR.responseJSON.message, "error");
                    }
                  })
                }
              },
              error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
              }
            })
          }
        })
      }
    }

    $("#printBtn").click(() => {
      $("#detailReportWorkOrder").modal('show');
      $("#modalWReportWorkOrderWorkOrderNumberStart").val($("#workOrderNumber").val())
      $("#modalWReportWorkOrderWorkOrderNumberEnd").val($("#workOrderNumber").val())
      vmDatePicker.modalReportWorkOrderDateStart.pValue = ''
      vmDatePicker.modalReportWorkOrderDateEnd.pValue = ''
      $("#modalReportWorkOrderAssetNumber").val('')
      $("#modalReportWorkOrderStatus").val('')
      $("#modalReportWorkOrderReportingAgency").val('')
      $("#modalReportWorkOrderNotifyingAgency").val('')
      $("#modalReportWorkOrderReportingAgencyDesc").val('')
      $("#modalReportWorkOrderNotifyingAgencyDesc").val('')
      $("#modalReportWorkOrderAssetNumber").removeClass('x onX');
      $("#modalReportWorkOrderReportingAgency").removeClass('x onX');
      $("#modalReportWorkOrderNotifyingAgency").removeClass('x onX');

      setSelect2InEAM0007();
    })

    $("#modalReportWorkOrderPrint").click(() => {
      $("#printBtnHide").click();
    })

    $("#fileBtn").click(() => {
      $.ajax({
        url: "{{ route('eam.ajax.work-requests.images.index',['']) }}/" + workRequestNumber,
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

    $("#addImageBtn").click(() => {
      $("#modalFile").val('');
      $('.custom-file-label').html('');
      $("#detailModalImageAdd").modal('show');
    })

    $("#deleteImageBtn").click(() => {
      if ($("#selectImageDelete").val() != '') {
        $.ajax({
          url: "{{ route('eam.ajax.work-requests.images.delete',['']) }}/" + $("#selectImageDelete").val(),
          method: 'DELETE',
          headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
          success: function (response) {
            swal("Success", response.message, "success");
            $.ajax({
              url: "{{ route('eam.ajax.work-requests.images.index',['']) }}/" + workRequestNumber,
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

    function deleteImageBtn(attachment_id) {
      swal({
        title: 'ต้องการลบรายการนี้หรือไม่!',
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
      },function() {
        if (attachment_id != '') {
          $.ajax({
            url: "{{ route('eam.ajax.work-requests.images.delete',['']) }}/" + attachment_id,
            method: 'DELETE',
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
            success: function (response) {
              swal("Success", response.message, "success");
              $.ajax({
                url: "{{ route('eam.ajax.work-requests.images.index',['']) }}/" + workRequestNumber,
                method: 'GET',
                success: function (response) {
                  dataImageFile = response.data;
                  // setImageFileFn(response.data);
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

    $("#viewImageBtn").click(() => {
      if ($("#selectImageDelete").val() != '') {
        $("#setShowImageFileFn").attr('src', `{{route('eam.ajax.work-requests.images.show',[''])}}/` + $("#selectImageDelete").val());
        $("#detailModalImageView").modal('show');
      } else {
        swal("กรุณาเลือกรายการ", "", "warning");
      }
    })

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

    $("#modalModalImageAddBtn").click(() => {
      $('#detailModalImageAddForm').attr('action', "{{ route('eam.ajax.work-requests.images.upload',['']) }}/" + workRequestNumber)
      $("#programCode").val('EAM0007')
      $("#webBatchNo").val(webBatchNo)
      $("#modalModalImageAddBtnHidden").click();
    })

    $('#detailModalImageAddForm').submit(function(evt) {
      evt.preventDefault();
      var formData = new FormData(this);
      if ($('#modalFile')[0].files[0].size > 5242880) {
        swal("Waring", "ไฟล์รูปภาพที่ท่านเลือกมีขนาดไฟล์เกิน 5 MB.", "error");
        return;
      }
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
            icon: "success"
          },function() {
            $("#detailModalImageAdd").modal('hide')
          })
          $.ajax({
            url: "{{ route('eam.ajax.work-requests.images.index',['']) }}/" + workRequestNumber,
            method: 'GET',
            success: function (response) {

              $("#modalImageSearchWorkOrderNumber").val($("#workOrderNumber").val());
              dataImageFile = response.data;
              // setImageFileFn(response.data);
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

    $("#approvalBtn").click(() => {
      statusApprove = true
      $("#saveBtnHide").click();
    })

    function approveHide(data) {
      $.ajax({
        url: "{{ route('eam.ajax.work-requests.send-approve',['']) }}/" + data,
        method: 'GET',
        success: function (response) {
          swal("Success", response.message, "success");
          $.ajax({
            url: "{{ route('eam.ajax.work-requests.show',['']) }}/" + response.data.work_request_number,
            method: 'GET',
            success: function (response) {
              setDataLovWorkOrderNumberResponse(response)
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

    $("#workOrderType").change(() => {
      if ($("#workOrderType").val() == '2700' && jpFlag == 'Yes') {
        $("#quantityOfPartsProduced").prop('disabled', false);
      } else {
        $("#quantityOfPartsProduced").prop('disabled', true);
      }
    })
    
    $("#openRepairWorkBtn").click(() => {
      window.location.href = "{{ route('eam.work-orders.create', ['']) }}?fn=" + 'request' + '&default=' + $("#workOrderNumber").val();
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
          theadModalFile += `<div style="position: absolute; z-index: 2; top: 2px; right: 2px;"><button type="button" class="btn btn-danger btn-sm deleteImageBtn" style="padding: .15rem .3rem;" onClick="deleteImageBtn(${row.attachment_id})"><i class="fa fa-times"></i></button></div>`
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

    function createNew() {
      setValueInput();
      statusApprove = false
      $("#fileBtn").prop('disabled', true);
      $("#openRepairWorkBtn").prop('disabled', true);
      $("#workOrderNumber").prop('disabled', true);
      $("#workOrderNumberLovBtn").prop('disabled', true);
      $("#assetNumber").prop('disabled', false);
      $("#assetNumberLovBtn").prop('disabled', false);
      $("#machineName").prop('disabled', true);
      $("#reportingAgency").prop('disabled', false);
      $("#reportingAgencyLovBtn").prop('disabled', false);
      $("#workOrderStatus").prop('disabled', true);
      $("#notifyingAgency").prop('disabled', false);
      $("#notifyingAgencyLovBtn").prop('disabled', false);
      $("#repairer").prop('disabled', false);
      $("#repairerLovBtn").prop('disabled', false);
      $("#workOrderType").prop('disabled', false);
      $("#workOrderDescription").prop('disabled', false);
      $("#importance").prop('disabled', false);
      $("#workReceiptNumber").prop('disabled', true);
      $("#quantityOfPartsProduced").prop('disabled', true);
      $("#approval").prop('disabled', true);
      $("#referenceWorkReceipt").prop('disabled', false);
      vmDateTimePickerAll.approvalDate.disabled = true
      setDefault()
      webBatchNo = ''
    }

    function setDefault() {
      let dataDepart = []
      if (dataDepart.length > 0) {
        let department_desc = ''
        dataDepart.filter(row => {
          if(row.department_code == defaultUser.department_code) {
            department_desc = row.description
          }
        })
        $("#reportingAgency").val(defaultUser.department_code + ' - ' + department_desc);
        $("#notifyingAgency").val(defaultUser.department_code + ' - ' + department_desc);
        $("#repairer").val(defaultUser.username + ' - ' + defaultUser.name)
        $("#repairerId").val(defaultUser.user_id)
        $("#workOrderStatus").val('1');
        $("#importance").val('3');
        vmDatePicker.repairNotificationDate.disabled = false
        vmDatePicker.repairNotificationDate.pValue = getDate()
      } else {
        $.ajax({
          url: "{{ route('eam.ajax.lov.departments') }}",
          method: 'GET',
          data: {
            'p_department_code':  defaultUser.department_code,
            'p_description':      ''
          },
          success: function (response) {
            dataDepart = response.data
            let department_desc = ''
            response.data.filter(row => {
              if(row.department_code == defaultUser.department_code) {
                department_desc = row.description
              }
            })

            //Default หน่วยงานผู้แจ้ง
            var newOptionReportingAgency = new Option(defaultUser.department_code + ' - ' +department_desc, defaultUser.department_code, true, true);
            $('#reportingAgency').append(newOptionReportingAgency).trigger('change');
            $('#reportingAgency').val(defaultUser.department_code).trigger('change');

            //Default หน่วยงานผู้รับแจ้ง
            var newOptionNotifyingAgency = new Option(defaultUser.department_code + ' - ' +department_desc, defaultUser.department_code, true, true);
            $('#notifyingAgency').append(newOptionNotifyingAgency).trigger('change');
            $('#notifyingAgency').val(defaultUser.department_code).trigger('change');

            //Default ผู้แจ้งซ่อม
            $("#repairerId").val(defaultUser.user_id)
            var newOptionRepairer = new Option(defaultUser.username + ' - ' +defaultUser.name, defaultUser.username, true, true);
            $('#repairer').append(newOptionRepairer).trigger('change');
            $('#repairer').val(defaultUser.username).trigger('change');

            $("#workOrderStatus").val('1').trigger('change');
            $("#importance").val('3').trigger('change');
            vmDatePicker.repairNotificationDate.disabled = false
            vmDatePicker.repairNotificationDate.pValue = getDate()
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    }

    function clearDataLovWorkOrderNumber() {
      setValueInput();
      statusApprove = false
      $("#fileBtn").prop('disabled', true);
      $("#approvalBtn").prop('disabled', true);
      $("#openRepairWorkBtn").prop('disabled', true);
      $("#workOrderNumber").prop('disabled', false);
      $("#workOrderNumberLovBtn").prop('disabled', false);
      $("#assetNumber").prop('disabled', true);
      $("#assetNumberLovBtn").prop('disabled', true);
      $("#machineName").prop('disabled', true);
      $("#reportingAgency").prop('disabled', true);
      $("#reportingAgencyLovBtn").prop('disabled', true);
      $("#workOrderStatus").prop('disabled', true);
      $("#notifyingAgency").prop('disabled', true);
      $("#notifyingAgencyLovBtn").prop('disabled', true);
      $("#repairer").prop('disabled', true);
      $("#repairerLovBtn").prop('disabled', true);
      $("#workOrderType").prop('disabled', true);
      $("#workOrderDescription").prop('disabled', true);
      $("#importance").prop('disabled', true);
      vmDatePicker.repairNotificationDate.disabled = true
      $("#workReceiptNumber").prop('disabled', true);
      $("#quantityOfPartsProduced").prop('disabled', true);
      $("#approval").prop('disabled', true);
      $("#referenceWorkReceipt").prop('disabled', true);
      vmDateTimePickerAll.approvalDate.disabled = true
      $("#awaitingWorkOrderWorkRequestStatusDesc").hide();
      $("#rejectedWorkRequestStatusDesc").hide();
    }

    function setDataLovWorkOrderNumberResponse(response) {
      if(response.data){
        $("#cancelWorkModal").modal('hide');
        statusApprove         = false
        workRequestOwningDept = response.data.work_request_owning_dept ? 
                                response.data.work_request_owning_dept : '';
        workRequestNumber     = response.data.work_request_number ? 
                                response.data.work_request_number : '';       
        $("#machineName").val(response.data.asset_desc ? response.data.asset_desc : '').trigger('change');

        //Default เลขที่ใบสั่งงาน
        var newOptionWorkOrderNumber = new Option(( response.data.work_request_number ? 
                                                    response.data.work_request_number : ''),
                                                    response.data.work_request_number, true, true);
        $('#workOrderNumber').append(newOptionWorkOrderNumber).trigger('change');
        $('#workOrderNumber').val(response.data.work_request_number).trigger('change');

        //Default Asset Number
        var newOptionAssetNumber = new Option((response.data.asset_number ? 
                                               response.data.asset_number : ''), 
                                               response.data.asset_number, true, true);
        $('#assetNumber').append(newOptionAssetNumber).trigger('change');
        $('#assetNumber').val(response.data.asset_number).trigger('change');

        //Default หน่วยงานผู้แจ้ง
        var newOptionReportingAgency = new Option((response.data.owning_dept_code ? response.data.owning_dept_code : '') 
                                                  + ' - ' + 
                                                  (response.data.owning_dept_desc ? response.data.owning_dept_desc : ''), 
                                                   response.data.owning_dept_code, true, true);
        $('#reportingAgency').append(newOptionReportingAgency).trigger('change');
        $('#reportingAgency').val(response.data.owning_dept_code).trigger('change');

        //Default หน่วยงานผู้รับแจ้ง
        var newOptionNotifyingAgency = new Option((response.data.receiving_dept_code ? 
                                                   response.data.receiving_dept_code : '')
                                                  + ' - ' + 
                                                  (response.data.receiving_dept_desc ? 
                                                   response.data.receiving_dept_desc : ''), 
                                                   response.data.receiving_dept_code, true, true);
        $('#notifyingAgency').append(newOptionNotifyingAgency).trigger('change');
        $('#notifyingAgency').val(response.data.receiving_dept_code).trigger('change');
        
        //Default ผู้แจ้งซ่อม
        $("#repairerId").val(response.data.employee_id ? response.data.employee_id : '');
        var newOptionRepairer = new Option((response.data.employee_code ? response.data.employee_code : '') 
                                            + ' - ' +
                                           (response.data.employee_desc ? response.data.employee_desc : ''), 
                                            response.data.employee_code, true, true);
        $('#repairer').append(newOptionRepairer).trigger('change');
        $('#repairer').val(response.data.employee_code).trigger('change');

        $("#workOrderStatus").val(response.data.work_request_status_id ?
                                  response.data.work_request_status_id : '1').trigger('change');
        $("#workOrderType").val (response.data.work_request_type_id ? 
                                (response.data.work_request_type_id == '0' ? 
                                 '000' : 
                                 response.data.work_request_type_id) : '').trigger('change');
        $("#workOrderDescription").val(response.data.description ? response.data.description : '');

        $("#importance").val(response.data.work_request_priority_id ? 
                             response.data.work_request_priority_id : '').trigger('change');
        $("#workReceiptNumber").val(response.data.work_order_number ? 
                                    response.data.work_order_number : '');
        $("#referenceWorkReceipt").val('');
        $("#referenceWorkReceipt").val(null).trigger('change');

        vmDatePicker.repairNotificationDate.pValue = response.data.expected_start_date ? 
                                                     response.data.expected_start_date : '';

        var data = {
          id: response.data.wo_reference? response.data.wo_reference : '',
          text: response.data.wo_reference_name? response.data.wo_reference_name : ''
        };

        var $newOption = $("<option selected='selected'></option>").val(data.id).text(data.text)

        $("#referenceWorkReceipt").append($newOption).trigger('change');
        $("#quantityOfPartsProduced").val(response.data.jp_qty ? response.data.jp_qty : '');
        $("#approval").val(response.data.approver_desc ? response.data.approver_desc : '').trigger('change');
        vmDateTimePickerAll.approvalDate.pValue = response.data.approved_date ? response.data.approved_date : '';
        webBatchNo = response.data.web_batch_no ? response.data.web_batch_no : ''
        
        if ('1' == response.data.work_request_status_id || 
            '2' == response.data.work_request_status_id || 
            '5' == response.data.work_request_status_id     ) {
          $("#approvalBtn").prop('disabled', false);
          $("#assetNumber").prop('disabled', false);
          $("#assetNumberLovBtn").prop('disabled', false);
          $("#reportingAgency").prop('disabled', false);
          $("#reportingAgencyLovBtn").prop('disabled', false);
          $("#workOrderStatus").prop('disabled', true);
          $("#notifyingAgency").prop('disabled', false);
          $("#notifyingAgencyLovBtn").prop('disabled', false);
          $("#repairer").prop('disabled', false);
          $("#repairerLovBtn").prop('disabled', false);
          $("#workOrderType").prop('disabled', false);
          $("#workOrderDescription").prop('disabled', false);
          $("#importance").prop('disabled', false);
          // vmDatePicker.repairNotificationDate.disabled = false
          // $("#repairNotificationDate").prop('disabled', false);
          $("#addImageBtn").prop('disabled', false);
          $("#deleteImageBtn").prop('disabled', false);
          $(".deleteImageBtn").prop('disabled', false);
          $("#referenceWorkReceipt").prop('disabled', false);
          if ($("#workOrderType").val() == '2700') {
            $("#quantityOfPartsProduced").prop('disabled', false);
          } else {
            $("#quantityOfPartsProduced").prop('disabled', true);
          }

          $("#repairNotificationDate").prop('style', 'background-color:#E4E7EB');
          vmDatePicker.repairNotificationDate.disabled = true;
          $("#repairNotificationDate").prop("disabled", true);
        } else {
          $("#approvalBtn").prop('disabled', true);
          $("#assetNumber").prop('disabled', true);
          $("#assetNumberLovBtn").prop('disabled', true);
          $("#reportingAgency").prop('disabled', true);
          $("#reportingAgencyLovBtn").prop('disabled', true);
          $("#workOrderStatus").prop('disabled', true);
          $("#notifyingAgency").prop('disabled', true);
          $("#notifyingAgencyLovBtn").prop('disabled', true);
          $("#repairer").prop('disabled', true);
          $("#repairerLovBtn").prop('disabled', true);
          $("#workOrderType").prop('disabled', true);
          $("#workOrderDescription").prop('disabled', true);
          $("#importance").prop('disabled', true);
          // vmDatePicker.repairNotificationDate.disabled = true
          $("#quantityOfPartsProduced").prop('disabled', true);
          $("#addImageBtn").prop('disabled', true);
          $("#deleteImageBtn").prop('disabled', true);
          $(".deleteImageBtn").prop('disabled', true);
          $("#referenceWorkReceipt").prop('disabled', true);

          $("#repairNotificationDate").prop('style', 'background-color:none');
          vmDatePicker.repairNotificationDate.disabled = false;
          $("#repairNotificationDate").prop("disabled", false);
        }

        if (response.data.work_request_status_id == '3') {
          $("#openRepairWorkBtn").prop('disabled', false);
          $("#cancelApprove").prop('disabled', false);
        } else {
          $("#openRepairWorkBtn").prop('disabled', true);
          $("#cancelApprove").prop('disabled', true);
        }

        if (response.data.work_request_status_id == '1' || 
            response.data.work_request_status_id == '2' || 
            response.data.work_request_status_id == '3' || 
            response.data.work_request_status_id == '5' || 
            response.data.work_request_status_id == '8'     ) {
          $("#cancelWork").prop('disabled', false);
        } else {
          $("#cancelWork").prop('disabled', true);
        }

        if(response.data.work_request_status_id == '8' && 
           $("#permissionHidden").val() == ''             ){
          if($("#repairer").val() == defaultUser.username){
            $("#permissionHidden").val('N');
            $("#awaitingWorkOrderWorkRequestStatusDesc").hide();
            $("#rejectedWorkRequestStatusDesc").hide();
          }else{
            $("#permissionHidden").val('Y');
            $("#awaitingWorkOrderWorkRequestStatusDesc").show();
            $("#rejectedWorkRequestStatusDesc").show();
          }
        }

        $("#workOrderNumber").prop('disabled', false);
        $("#workOrderNumberLovBtn").prop('disabled', false);
        $("#machineName").prop('disabled', true);
        $("#workReceiptNumber").prop('disabled', true);
        $("#approval").prop('disabled', true);
        vmDateTimePickerAll.approvalDate.disabled = true

        if(!$("#workOrderNumber").val()){
          $("#fileBtn").prop('disabled', true);
        }else{
          $("#fileBtn").prop('disabled', false);
        }
      } else {
        createNew();
      }
    }

    $("#cancelApprove").click(() => {
      swal({
        title: "ยืนยันการยกเลิกอนุมัติหรือไม่",
        text: "",
        type: "warning",
        showCancelButton: true
      }, function(){
        if ($("#workOrderNumber").val() != '') {
          $.ajax({
            url: "{{ route('eam.ajax.work-requests.cancel-approval',['']) }}/" + $("#workOrderNumber").val(),
            method: 'GET',
            data: {
              'program_code': 'EAM0007'
            },
            success: function (response) {
              $.ajax({
                url: "{{ route('eam.ajax.work-requests.show',['']) }}/" + $("#workOrderNumber").val(),
                method: 'GET',
                success: function (response) {
                  setDataLovWorkOrderNumberResponse(response)

                  // if($("#reportingAgency").val().split(' - ')[0] != $("#notifyingAgency").val().split(' - ')[0]) {
                  if($("#reportingAgency").val() != $("#notifyingAgency").val()) {
                    $("#repairNotificationDate").prop('style', 'background-color:#E4E7EB');
                    vmDatePicker.repairNotificationDate.disabled = true;
                    $("#repairNotificationDate").prop("disabled", true);
                  } else {
                    $("#repairNotificationDate").prop('style', 'background-color:none');
                    vmDatePicker.repairNotificationDate.disabled = false;
                    $("#repairNotificationDate").prop("disabled", false);
                  }
                },
                error: function (jqXHR, textStatus, errorRhrown) {
                  swal("Error", jqXHR.responseJSON.message, "error");
                }
              })
            },
            error: function (jqXHR, textStatus, errorThrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        }
      })
    })

    $("#cancelWork").click(() => {
      $("#cancelWorkModalText").val('')
      $("#cancelWorkModal").modal('show');
    })

    $("#cancelWorkModalCancelBtn").click(() => {
      $("#cancelWorkModalText").val('')
    })

    $("#cancelWorkModalSaveBtn").click(() => {
      swal({
        title: "ยืนยันการยกเลิกใบแจ้งซ่อมหรือไม่",
        text: "",
        type: "warning",
        showCancelButton: true
      }, function(){
        if ($("#workOrderNumber").val() != '') {
          $.ajax({
            url: "{{ route('eam.ajax.work-requests.cancel',['']) }}/" + $("#workOrderNumber").val(),
            method: 'GET',
            data: {
              'program_code': 'EAM0007',
              'reason': $("#cancelWorkModalText").val()
            },
            success: function (response) {
              $.ajax({
                url: "{{ route('eam.ajax.work-requests.show',['']) }}/" + $("#workOrderNumber").val(),
                method: 'GET',
                success: function (response) {
                  // $(".clearable").removeClass('x onX');
                  $("#cancelWorkModal").modal('hide');
                  setDataLovWorkOrderNumberResponse(response)
                },
                error: function (jqXHR, textStatus, errorRhrown) {
                  swal("Error", jqXHR.responseJSON.message, "error");
                  $("#cancelWorkModal").modal('hide');
                }
              })
            },
            error: function (jqXHR, textStatus, errorThrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
              $("#cancelWorkModal").modal('hide');
            }
          })
        }
        $("#cancelWorkModal").modal('hide');
      })
    })

    $('#quantityOfPartsProduced').bind('keypress', function(e) {
      let charCode = e.keyCode
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        return false;
      } else {
        return true;
      }
    });

    $("#awaitingWorkOrderWorkRequestStatusDesc").click(() => {
      swal({
        title: "ยืนยันการอนุมัติงานหรือไม่",
        text: "",
        type: "warning",
        showCancelButton: true
      }, function(){
        if ($("#workOrderNumber").val() != '') {
          $.ajax({
            url: "{{ route('eam.ajax.work-requests.awaiting-work-order',['']) }}/" + $("#workOrderNumber").val(),
            method: 'GET',
            data: {
              'program_code': 'EAM0007'
            },
            success: function (response) {
              $("#awaitingWorkOrderWorkRequestStatusDesc").hide();
              $("#rejectedWorkRequestStatusDesc").hide();
              clearForm();
              swal("Success", "บันทึกสำเร็จ", "success");
            },
            error: function (jqXHR, textStatus, errorThrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        }
      })
    })

    $("#rejectedWorkRequestStatusDesc").click(() => {
      swal({
        title: "ยืนยันการปฏิเสธใบแจ้งซ่อมหรือไม่",
        text: "",
        type: "warning",
        showCancelButton: true
      }, function(){
        if ($("#workOrderNumber").val() != '') {
          $.ajax({
            url: "{{ route('eam.ajax.work-requests.rejected',['']) }}/" + $("#workOrderNumber").val(),
            method: 'GET',
            data: {
              'program_code': 'EAM0007'
            },
            success: function (response) {
              $("#awaitingWorkOrderWorkRequestStatusDesc").hide();
              $("#rejectedWorkRequestStatusDesc").hide();
              clearForm();
              swal("Success", "บันทึกสำเร็จ", "success");
            },
            error: function (jqXHR, textStatus, errorThrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        }
      })
    })

    $('#assetNumber').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    $('#assetNumber').on('select2:clear', function (e) {
      $('#machineName').val('').trigger('change');
    });

    $('#detailReportWorkOrder').on('shown.bs.modal', function (e) {
      triggerSelect2()
    })

    $('#modalReportWorkOrderAssetNumber').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    $('#modalReportWorkOrderNotifyingAgency').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    $('#modalReportWorkOrderNotifyingAgency').on('select2:clear', function (e) {
      $('#modalReportWorkOrderNotifyingAgencyDesc').val('').trigger('change');
    });

    $('#modalReportWorkOrderReportingAgency').on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
      
    });

    $("#reportingAgency").on('change', function( ){
      department_code = $(this).val()
    })

    $('#modalReportWorkOrderReportingAgency').on('select2:clear', function (e) {
      $('#modalReportWorkOrderReportingAgencyDesc').val('').trigger('change');
    });
  </script>

  <script src="/js/eam-selected.js"></script>
  <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection
