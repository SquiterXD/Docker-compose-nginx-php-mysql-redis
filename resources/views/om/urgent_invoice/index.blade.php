@extends('layouts.app')
<style>
    div.dataTables_wrapper div.dataTables_length select{
        width: 75px!important;
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #e5e6e7 !important;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        margin-top: 2px !important;
    }

    .form-control:disabled, .form-control[readonly] {
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }

    table.dataTable {
        font-size: 0.9rem;
    }

    .datepicker table {
        font-size: 0.9rem !important;
    }

    /* DATA DATE */
    .mx-datepicker .mx-input-wrapper input {
        height: auto !important;
    }

    .mx-datepicker .mx-input-wrapper .mx-icon-calendar, .mx-datepicker .mx-input-wrapper .mx-icon-clear {
        right: -15px !important;
    }

    .mx-icon-calendar {
        margin-top: 0px !important;
        font-size: 18px !important;
    }

    .i-checks.disabled {
        opacity: 0.5;
    }

    .table {
        color: #000 !important;
}

    /* SCROLL TABLE */
    .table-responsive{
        overflow-y: auto;
        max-height: 575px;
    }

    .table-responsive thead {
        top: 0;
        position: sticky;
        z-index: 999;
    }

    .table .tr-pink td{background-color:#ff66ff;}
    .table .td-pink {background-color:#ff66ff;}
    .table .tr-text-pink td{color: #ff66ff;}

    .table .tr-blue-new td{background-color:#60a5fa;}
    .table .td-blue-new {background-color:#60a5fa;}
    .table .tr-text-blue-new td{color: #60a5fa;}

    .table .tr-green-new td{background-color:#00ff00;}
    .table .td-green-new {background-color:#00ff00;}
    .table .tr-text-green-new td{color: #00ff00;}

    .table .text-status-y{color:#ff0000 !important;}
    .table .text-status-n{color:#000000 !important;}

    .modal-custom{max-width: 80% !important;}

    .i-checks label .icheckbox_square-red, .i-checks label .iradio_square-red {
        position: absolute;
        left: 0;
    }
    .icheckbox_square-red.checked {
        background-position: -48px 0;
    }
    .icheckbox_square-red, .iradio_square-red {
        display: inline-block;
        *display: inline;
        vertical-align: middle;
        margin: 0;
        padding: 0;
        width: 22px;
        height: 22px;
        background: url(/css/patterns/red.png) no-repeat;
        border: none;
        cursor: pointer;
    }

    #page-wrapper {
        width: calc(100% - 220px) !important;
    }

</style>


@section('title', 'อนุมัติใบเตรียมการขาย/ใบสั่งซื้อ')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <style>
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            top: 38% !important;
        }
    </style>
@stop


@section('page-title')
    <x-get-page-title :menu="$menu" url="" />
@stop

@section('content')

    <div class="ibox">
        <div class="ibox-title">
            {{-- <h3>{{ !empty($menu->menu_title) ? $menu->menu_title : '' }}</h3> --}}
        </div>
        <div class="ibox-content">
            <form id="formApprovePrepareOrder" autocomplete="none" enctype="multipart/form-data">
                @if((boolean)request()->_faster == true)
                    <input type="hidden" name="_faster" value="true">
                @endif
                <div class="row justify-content-md-center flex-column mw-xl-1000 mt-md-4"> {{-- space-50 --}}
                    <div class="col-xl-6 m-auto">
                        <div class="form-group">
                            <h3 class="black mb-3">ค้นหารายการที่ต้องการxxx</h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="d-block">วันที่ส่ง</label>
                                    <div class="input-icon">
                                        <datepicker-th
                                            style="width: 100%"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            name="delivery_start_date"
                                            id="delivery_start_date"
                                            placeholder=""
                                            value="{{ $defaultDate }}"
                                            format="{{ trans("date.js-format") }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="d-block">ถึงวันที่</label>
                                    <div class="input-icon">
                                        <datepicker-th
                                            style="width: 100%"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            name="delivery_end_date"
                                            id="delivery_end_date"
                                            placeholder=""
                                            value="{{ $defaultDate }}"
                                            format="{{ trans("date.js-format") }}">
                                    </div>
                                </div>
                            </div><!--row-->
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">เลขที่ใบเตรียมขาย</label>
                            
                            <div class="input-icon">
                                <select class="custom-select" name="prepare_order_number" id="prepare_order_number">
                                    <option value=""> &nbsp; </option>
                                </select>
                                <i class="fa fa-search" style="padding-right:15px"></i>
                            </div>
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">ลูกค้า</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-icon">
                                        <select class="custom-select" name="customer_number" id="customer_number">
                                            <option value=""> &nbsp; </option>
                                        </select>
                                        <i class="fa fa-search" style="padding-right:15px"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <input type="hidden" name="customer_id" id="customer_id" value="">
                                    <input type="text" class="form-control" readonly name="customer_name" id="customer_name" placeholder="" value="" autocomplete="off">
                                </div>
                            </div><!--row-->
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">สถานะการอนุมัติ</label>
                            <select class="custom-select" name="pick_release_approve_flag" id="pick_release_approve_flag">
                                <option value=""> &nbsp; </option>
                                <option value="Y">อนุมัติ</option>
                                <option value="N">ยังไม่ได้อนุมัติ</option>
                            </select>
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">เลขที่ Invoice/ใบขน</label>
                            <div class="input-icon">
                                <select class="pick_release_no" name="pick_release_no" id="pick_release_no">
                                    <option value=""> &nbsp; </option>
                                </select>
                                <i class="fa fa-search" style="padding-right:15px"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="d-block">สถานะ Invoice/ใบขน</label>
                            <select class="custom-select" name="pick_release_status" id="pick_release_status">
                                <option value=""> &nbsp; </option>
                                <option value="Confirm">Confirm</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="d-block">พิมพ์แล้ว (กองคลัง)</label>
                            <select class="custom-select" name="pick_release_print_flag" id="pick_release_print_flag">
                                <option value=""> &nbsp; </option>
                                <option value="Y">พิมพ์แล้ว</option>
                                <option value="N">ยังไม่ได้พิมพ์</option>
                            </select>
                        </div>


                        <div class="form-buttons no-border">
                            <button class="btn btn-lg btn-white" 
                                    type="button" 
                                    onclick="searchApprovePrepare()">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                            <button class="btn btn-lg btn-default" 
                                    type="button"
                                    id="undoBtn">
                                <i class="fa fa-undo"></i> ล้างค่า
                            </button>
                        </div>

                    </div><!--col-xl-6-->

                    <div class="col-md-12">
                        <hr class="lg">

                        <div class="form-header-buttons flex-md-row-reverse">
                            <div class="buttons d-flex">
                                <button class="btn btn-md btn-primary" type="button" id="buttonApprove" onclick="managePrepareOrder('Confirm')"><i class="fa fa-check"></i> อนุมัติ</button>
                                <a id="reportAll" class="btn btn-md btn-primary" type="button" target="_blank" style="padding-top: 10px; color: white;"><i class="fa fa-print"></i> พิมพ์ทั้งหมด</a>
                            </div><!--buttons-->

                            <button class="btn btn-md btn-white has-checkbox mt-2 mt-md-0" type="button">
                                <div class="i-checks"><label><input type="checkbox" value="option_0" name="a" id="checkAll"><span> เลือกทั้งหมด</span></label></div>
                            </button>
                        </div><!--form-header-buttons-->

                        <div class="hr-line-dashed"></div>

                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-hover f13"> {{-- min-1800 --}}
                                <thead>
                                    <tr class="align-middle">
                                        <th width="1%">เลือก<br>รายการ</th>
                                        <th width="1%">ยกเลิก</th>
                                        <th width="1%">รายการที่</th>
                                        <th width="2%">เลขที่<br>ใบเตรียมขาย</th>
                                        <th width="2%">วันที่ส่ง</th>
                                        <th width="3%">ชื่อลูกค้า</th>
                                        <th width="1%">จำนวนเงิน</th>
                                        <th width="1%">หนี้ค้างชำระ</th>
                                        <th width="1%">อนุมัติ</th>
                                        <th width="8%">ผู้อนุมัติ</th>
                                        <th width="2%">เลขที่ <br>Invoice/ใบขน</th>
                                        <th width="2%">สถานะ <br>Invoice/ใบขน</th>
                                        <th width="1%">พิมพ์แล้ว<br>(กองคลัง)</th>
                                    </tr>
                                </thead>
                                <tbody id="dataSearchResult">


                                </tbody>
                            </table>
                        </div><!--table-responsive-->

                        <div class="d-flex mt-4 mb-5">
                            <div class="d-flex ml-auto mr-4">สั่งซื้อปกติ <span class="box-label" style="background-color: #000000"></span></div>
                            <div class="d-flex">สั่งซื้อเกินโควต้า <span class="box-label" style="background-color:red"></span></div>
                        </div><!--d-flex-->
                    </div>
                </div><!--row-->
            </form>
        </div><!--ibox-content-->
    </div><!--ibox-->
    <div class="modal" tabindex="-1" id="modal-price" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">จำนวนเงิน</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>
                เงินเชื่อ : <span id="modal-credit_amount">0.00</span><br>
                เงินสด : <span id="modal-cash_amount">0.00</span><br>
                จำนวนเงิน : <span id="modal-grand_total">0.00</span><br>
              </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
          </div>
        </div>
      </div>
    {{-- MODAL --}}
    <div id="group-modal-popup"></div>

@endsection

@section('scripts')
    <script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
    <!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.date').datepicker();
    });

    $('.custom-select').select2({width: "100%"});

    
    $('#pick_release_no').select2({
        width: "100%",
        ajax: {
            url: '',
            dataType: 'json',
            data: function(params) {
                var query = {
                val: params.term,
                is_ajax: true,
                get: 'pick_release_no'
            }
            return query;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.pick_release_no,
                            id: item.pick_release_no
                        }
                    })
                };
            },
        }
  });
    $('#prepare_order_number').select2({
        width: "100%",
        ajax: {
            url: '',
            dataType: 'json',
            data: function(params) {
                var query = {
                val: params.term,
                is_ajax: true,
                get: 'prepare_order_number'
            }
            return query;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.prepare_order_number,
                            id: item.prepare_order_number
                        }
                    })
                };
            },
        }
  });
  function formatRepo (repo) {
    if (repo.loading) {
        return repo.text;
    }
    var $container = $(
        "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'>"+ repo.id +"</div>" +
        "<div class='select2-result-repository__avatar'>"+ repo.text +"</div>" +
        "</div>"
    );

  return $container;
}
function formatRepoSelection (repo) {
    $('#customer_name').val(repo.text)
    $('#customer_id').val(repo.customer_id)
    return repo.id;
}
  $('#customer_number').select2({
        width: "100%",
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
        ajax: {
            url: '',
            dataType: 'json',
            data: function(params) {
                var query = {
                val: params.term,
                is_ajax: true,
                get: 'customerList'
            }
            return query;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.customer_name_format,
                            id: item.customer_number,
                            customer_id: item.customer_id,
                            data: item
                        }
                    })
                };
            },
        }
  });
</script>

<script>

    let customerList    = {!! json_encode($customerList) !!};
    let approverList    = {!! json_encode($approverList) !!};
    let specialUsers    = {!! json_encode($special_users) !!}
    let defaultDate     = {!! json_encode($defaultDate) !!}

    function selectCustomer()
    {
        var number = $("#customer_number").val();

        if(number != ''){

            var itemID = '';
            var itemName = '';
            $.each(customerList, function(key,val){
                if (val.customer_number == number) {
                    itemID = val.customer_id;
                    itemName = val.customer_name_format;
                }
            });

            $("#customer_id").val(itemID);
            $("#customer_name").val(itemName);
        }else{
            $("#customer_id").val('');
            $("#customer_name").val('');
        }
    }

    function searchApprovePrepare()
    {
        console.log('############## searchApprovePrepare')
        const formData = new FormData(document.getElementById("formApprovePrepareOrder"));
        formData.append('_token','{{ csrf_token() }}');

        Swal.fire({
            title:"",
            text:"กำลังค้นหาข้อมูล...",
            showConfirmButton: false,
            allowOutsideClick: false,
            //icon: "success"
        });

        $.ajax({
            url         : '{{ url("om/ajax/approve-prepare-order/search") }}',
            type        : 'post',
            data        : formData,
            cache       : false,
            processData : false,
            contentType : false,
            success     : function(res){
                console.log(res);
                var data = res.data;
                var html = '';
                var htmlPayment = '';
                var orderList = data.data;
                var urlReport = data.redirect_page;

                if(data.status == 'success'){

                    $('#reportAll').attr("href", urlReport);

                    var roll = 1;
                    $.each(orderList, function(key,val){
                        const isapprove = val.pick_release_approve_flag != null ? true : false;
                        const isprint = val.pick_release_print_flag != null ? true : false;
                        let approveby = val.pick_release_approve_flag == 'Y' ? val.approver_name : '';

                        var addition_approve_status = val.addition_approve_status == 'Y' ? 'text-status-y' : 'text-status-n';

                        var buttonHtml = '<button type="button" class="btn btn-default" name="btnShowDetail" class="btnShowDetail" onclick="showModalPayment('+val.order_header_id+', '+val.customer_id+', `'+val.prepare_order_number+'`)"><i class="fa fa-file-text-o"></i> </button>';

                        let statusAmount = '';
                        if (val.program_code == 'OMP0020') {
                            statusAmount =  val.statusAmount == null ? '<td>-</td>' :
                                            // val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="td-green-new '+addition_approve_status+'">'+$.trim(val.invoice_no)+'</td>' :
                                            val.statusAmount == 2 ? '<td class="td-green-new d-none '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                            val.statusAmount == 1 ? '<td class="td-green-new d-none '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                            '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>';
                        }else{
                            if (val.program_code == 'OMP0019' && (val.customer_type_id == 30 || val.customer_type_id == 40)) {
                                statusAmount =  val.statusAmount == null ? '<td>-</td>' :
                                                // val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="td-green-new '+addition_approve_status+'">'+$.trim(val.invoice_no)+'</td>' :
                                                val.statusAmount == 2 ? '<td class="td-green-new d-none '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                val.statusAmount == 1 ? '<td class="td-orange d-none '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                '<td class="td-orange '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>';
                            }else{
                                statusAmount =  val.statusAmount == null ? '<td>-</td>' :
                                                // val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="td-green-new '+addition_approve_status+'">'+$.trim(val.invoice_no)+'</td>' :
                                                val.statusAmount == 2 ? '<td class="td-green-new d-none '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                val.statusAmount == 1 ? '<td class="td-orange d-none '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                '<td class="td-orange d-none'+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>';
                            }
                        }
                        if(val.set_color == 1 || ( ($.trim(val.pick_release_status) == 'Confirm' ||  $.trim(val.pick_release_status) == 'Cancelled' || $.trim(val.pick_release_status) == 'Cancel') )) {
                            statusAmount = '<td class="td-green-new d-none '+addition_approve_status+'" data-case="customer_type 80 &check case 1& case 2"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>';
                        } else {
                                // statusAmount = '<td class="td-green-new '+addition_approve_status+'" date-case="pick_release_status confirm"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>';
                                statusAmount = '<td class="td-orange d-none '+addition_approve_status+'" data-case="check case 1& case 2"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>';
                        }
                        let checkEnabled        = (val.statusAmount == 2 && !isapprove) || (val.statusAmount != 2 && isapprove)  ? '' : 'disabled';
                        let checkApprove        = val.pick_release_approve_flag == 'Y' ? 'checked' : '';
                        let checkPrint          = val.pick_release_print_flag   == 'Y' ? 'checked' : '';
                        var selectApprover      = '';
                        var disabledApprover    = '';

                        html += '<tr class="align-middle">';
                        html += '    <td class="ch-order">';
                        // if (val.program_code == 'OMP0020' || specialUsers == 1) {
                        //     if ($.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') {
                        //         html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                        //     }else{
                        //         html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                        //     }
                        // }else{
                        //     if((val.customer_type_id == 30 || val.customer_type_id == 40) && $.trim(val.pick_release_status) != 'Confirm' && val.product_type_code == 10 && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel'){
                        //         html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                        //     }else{
                        //         if ((val.statusAmount == 2 || val.statusAmount == 0) && $.trim(val.pick_release_status) != 'Confirm' && $.trim(val.payment_before_status) == 'Y' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') {
                        //             html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                        //         }else{
                        //             if ($.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel' && val.statusAmount != 1) {
                        //                 html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                        //             }else{
                        //                 html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                        //             }
                        //         }
                        //     }
                        // }
                        specialUsers =1;
                        if(specialUsers == 1) {
                            html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                        } else{
                            if (val.set_color == 1) {
                                if ($.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') { 
                                    html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                }else {
                                    html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                }
                            }else{
                                html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                            }
                        }
                        
                        
                        html += '    <input type="hidden" name="status_amount['+val.order_header_id+']" id="status_amount_'+val.order_header_id+'" value="'+val.statusAmount+'" ></td>';
                        html += '    <td class="text-danger" style="font-weight:bold; font-size:16px;" onclick="cancelPrepareOrder('+ val.order_header_id +', `'+$.trim(val.pick_release_no)+'`, `'+$.trim(val.pick_release_status)+'`)"> X </td>';
                        html += '    <td>'+roll+'<input type="hidden" name="order_header_id['+val.order_header_id+']" value="'+val.order_header_id+'" ></td>';
                        html += '    <td><a target="_blank" href="/om/order/prepare/report_preparation?prepare_order_number='+val.prepare_order_number+'">'+val.prepare_order_number+'</a> <input type="hidden"  name="product_type_code['+val.order_header_id+']" value="'+val.product_type_code+'"></td>';
                        html += '    <td>'+val.delivery_date+' <input type="hidden" name="customer_type_id['+val.order_header_id+']" value="'+val.customer_type_id+'" ></td>';
                        html += '    <td class="text-left">'+val.customer_name+'</td>';

                        
                        html += '    <td class="text-right"><button type="button" data-grand_total="'+val.grand_total+'" data-credit_amount="' + val.credit_amount +'" data-cash_amount="'+val.cash_amount+'" class="btn btn-default show-modal-amount" name="btnShowDetail" id="" onclick=""><i class="fa fa-file-text-o"></i> </button></td>';
                        // html += '    <td class="text-right">'+val.credit_amount+'</td>';
                        // html += '    <td class="text-right">'+val.cash_amount+'</td>';
                        // html += '    <td class="text-right">'+val.grand_total+'</td>';
                        html += '    '+statusAmount+'';
                        html += '    <td>';
                        html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="option_b1" name="isapprove['+val.order_header_id+']" '+checkApprove+'></label></div>';
                        html += '    </td>';

                        if (val.program_code == 'OMP0020' || specialUsers == 1) {
                            if ($.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') {
                                disabledApprover = '';
                            }else{
                                disabledApprover = 'readonly';
                            }
                        }else{
                            if((val.customer_type_id == 30 || val.customer_type_id == 40) && $.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel'){
                                disabledApprover = '';
                            }else{
                                if ((val.statusAmount == 2 || val.statusAmount == 0) && $.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') {
                                    disabledApprover = '';
                                }else{
                                    disabledApprover = 'readonly';
                                }
                            }
                        }


                        html += '    <td>';
                        html += '        <select class="custom-select" name="approver_id['+val.order_header_id+']" id="approver_id_'+val.order_header_id+'" '+disabledApprover+'>';
                        html += '            <option value=""> &nbsp; </option>';
                        $.each(approverList, function(key,valApprover){

                            if (val.pick_release_approve_by == valApprover.approver_order_id) {
                                selectApprover = 'selected';
                            }else if(valApprover.default_flag == 'Y'){
                                selectApprover = 'selected';
                            }else{
                                selectApprover = '';
                            }

                            html += '            <option '+selectApprover+' value="'+valApprover.approver_order_id+'">'+valApprover.approver_name+'</option>';
                        });
                        html += '        </select>';
                        html += '    </td>';
                        html += '    <td class="d-none"> <input type="text" class="form-control" name="remark['+val.order_header_id+']" id="remark_'+val.order_header_id+'" value="'+$.trim(val.attribute1)+'" '+disabledApprover+' > </td>';

                        if ($.trim(val.pick_release_no) == '') {
                            html += '    <td>'+val.pick_release_no+'</td>';
                        }else if ($.trim(val.print_invoice_flag) == 'Y') {
                            html += '    <td><a style="color: green" href="{{ url("om/print-invoice/report?invoice=") }}'+val.order_header_id+'" target="_blank" id="product_type_code['+val.order_header_id+']"> <i class="fa fa-check-circle"></i> &nbsp;'+val.pick_release_no+'</a></td>';
                        }else{
                            html += '    <td><a href="{{ url("om/print-invoice/report?invoice=") }}'+val.order_header_id+'" target="_blank" id="product_type_code['+val.order_header_id+']" onclick="changeAction('+ val.order_header_id +', `'+$.trim(val.pick_release_no)+'`)">'+val.pick_release_no+'</a></td>';
                        }

                        html += '    <td>'+val.pick_release_status+'</td>';
                        html += '    <td>';
                        html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub-red" value="option_c1" name="pick_release_print_flag_check['+val.order_header_id+']" '+checkPrint+'></label></div>';
                        html += '    </td>';
                        html += '</tr>';

                        roll++;
                    });

                    $('#dataSearchResult').html(html);

                    $('.text-status-n, .text-status-y').each(function(k, i){
                        if( $(i).attr('class') === "td-green-new d-none text-status-n" ||  $(i).attr('class') === "td-green-new d-none text-status-y") {
                            console.log($(i).parents('tr').find('.i-checks').first().attr('class'))
                            if($(i).parents('tr').find('.i-checks').first().attr('class') == 'i-checks wihtout-text m-auto disabled') {
                                $(i).css('background-color', 'rgb(229,229,229)').parents('tr').css('background-color','rgb(229,229,229)').hover(function(){
                                    $(this).css("background","rgb(195,195,195)");
                                }, function(){
                                    $(this).css("background","rgb(229,229,229)");
                                });
                            } else {

                                $(i).css('background-color', '#d5ffca').parents('tr').find('.ch-order').css('background-color','#d5ffca').hover(function(){
                                    $(this).css("background","#d5ffca");
                                }, function() {
                                    $(this).css("background","#d5ffca");
                                });
                            }
                        } 

                        if( $(i).attr('class') === "td-orange d-none text-status-n" ||  $(i).attr('class') === "td-orange d-none text-status-y") {
                            // $(i).css('background-color', '#FFFF54').parents('tr').css('background-color','#FFFF54');
                        }

                    })
                    $('.check-payment-cls').iCheck({
                        checkboxClass: 'icheckbox_square-green'
                    });

                    $('.check').iCheck({
                        checkboxClass: 'icheckbox_square-green'
                    });

                    $('.checksub').iCheck({
                        checkboxClass: 'icheckbox_square-green'
                    });

                    $('.checksub-red').iCheck({
                        checkboxClass: 'icheckbox_square-red'
                    });

                    // Add set class color for over quota
                    $('.table .text-status-y').parents('tr').css('color', 'red');

                    Swal.close();
                }else{

                    Swal.fire({
                        title: 'ผิดพลาด',
                        text: "ไม่สามารถค้นหาใบเตรียมการขาย/ใบสั่งซื้อได้",
                        icon: 'error',
                        timer: 2500
                    });
                }
            }
        })
        .fail(function() {
            Swal.fire({
                        title: 'ผิดพลาด',
                        text: "ไม่สามารถค้นหาใบเตรียมการขาย/ใบสั่งซื้อได้",
                        icon: 'error',
                        timer: 2500
                    });
            Swal.close();
        });
    }

    function managePrepareOrder(event)
    {
        console.log('############## managePrepareOrder')

        if($('.check-line').filter(':checked').length <= 0){
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกอย่างน้อย 1 รายการ!'
            });
            return false;
        }else{

            Swal.fire({
                title:"",
                text:"กำลังประมวลผล กรุณารอสักครู่...",
                buttons: false,
                showConfirmButton: false,
                allowOutsideClick: false,
                //icon: "success"
            });

            var checkedApprove = [];
            $("input[name='select_order[]']:checked").each(function ()
            {
                if (event == 'Confirm') {
                    var approveID = parseInt($(this).val());
                    var selectApprover = $('#approver_id_'+approveID).val();
                    var remark = $('#remark_'+approveID).val();

                    var statusAmount = $('#status_amount_'+approveID).val();

                    if(selectApprover == 0 || selectApprover == ""){
                        Swal.fire({
                            icon: 'warning',
                            text: 'กรุณาเลือกผู้อนุมัติ'
                        });
                        checkedApprove.push(false);
                        return false;
                    }else{
                        checkedApprove.push(true);
                    }
                }else{
                    checkedApprove.push(true);
                }
            });

            // console.log('success');
            // return false;

            if(jQuery.inArray(false, checkedApprove) !== -1){
                return false;
            }else{

                $('#buttonApprove').attr('disabled', true);
                $('#buttonCancel').attr('disabled', true);

                const formData = new FormData(document.getElementById("formApprovePrepareOrder"));
                formData.append('_token','{{ csrf_token() }}');
                formData.append('event', event);

                $.ajax({
                    url         : '{{ url("om/ajax/approve-prepare-order/manage") }}?_faster=true',
                    type        : 'post',
                    data        : formData,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    success     : function(res){
                        console.log(res);
                        var data = res.data;
                        var html = '';
                        var orderList = data.data;
                        if(data.status == 'success'){

                            var roll = 1;
                            $.each(orderList, function(key,val){

                                const isapprove = val.pick_release_approve_flag != null ? true : false;
                                const isprint = val.pick_release_print_flag != null ? true : false;
                                let approveby = val.pick_release_approve_flag == 'Y' ? val.approver_name : '';

                                var addition_approve_status = val.addition_approve_status == 'Y' ? 'text-status-y' : 'text-status-n';

                                var buttonHtml = '<button type="button" class="btn btn-default" name="btnShowDetail" class="btnShowDetail" onclick="showModalPayment('+val.order_header_id+', '+val.customer_id+', `'+val.prepare_order_number+'`)"><i class="fa fa-file-text-o"></i> รายละเอียด</button>';

                                let statusAmount = '';
                                if (val.program_code == 'OMP0020') {
                                    statusAmount =  val.statusAmount == null ? '<td>-</td>' :
                                                    // val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="td-green-new '+addition_approve_status+'">'+$.trim(val.invoice_no)+'</td>' :
                                                    val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                    val.statusAmount == 1 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                    '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>';
                                }else{
                                    if (val.program_code == 'OMP0019' && (val.customer_type_id == 30 || val.customer_type_id == 40)) {
                                        statusAmount =  val.statusAmount == null ? '<td>-</td>' :
                                                        // val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="td-green-new '+addition_approve_status+'">'+$.trim(val.invoice_no)+'</td>' :
                                                        val.statusAmount == 2 && val.standing_debt_status == 'Y' ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                        val.statusAmount == 1 && val.standing_debt_status == 'Y' ? '<td class="td-orange '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                        val.standing_debt_status != 'W' ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                        '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>';
                                    }else{
                                        statusAmount =  val.statusAmount == null ? '<td>-</td>' :
                                                        // val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="td-green-new '+addition_approve_status+'">'+$.trim(val.invoice_no)+'</td>' :
                                                        val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                        val.statusAmount == 1 ? '<td class="td-orange '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                        '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>';
                                    }
                                }

                                let checkEnabled        = (val.statusAmount == 2 && !isapprove) || (val.statusAmount != 2 && isapprove)  ? '' : 'disabled';
                                let checkApprove        = val.pick_release_approve_flag == 'Y' ? 'checked' : '';
                                let checkPrint          = val.pick_release_print_flag   == 'Y' ? 'checked' : '';
                                var selectApprover      = '';
                                var disabledApprover    = '';

                                html += '<tr class="align-middle">';
                                html += '    <td>';
                                
                                if (val.program_code == 'OMP0020' || specialUsers == 1) {
                                    if ($.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') {
                                        html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                    }else{
                                        html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                    }
                                }else{
                                    if((val.customer_type_id == 30 || val.customer_type_id == 40) && $.trim(val.pick_release_status) != 'Confirm' && val.product_type_code == 10 && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel'){
                                        html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                    }else{
                                        if ((val.statusAmount == 2 || val.statusAmount == 0) && $.trim(val.pick_release_status) != 'Confirm' && $.trim(val.payment_before_status) == 'Y' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') {
                                            html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                        }else{
                                            if ($.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel' && val.statusAmount != 1) {
                                                html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                            }else{
                                                html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                            }
                                        }
                                    }
                                }
                                html += '    <input type="hidden" name="status_amount['+val.order_header_id+']" id="status_amount_'+val.order_header_id+'" value="'+val.statusAmount+'" ></td>';
                                html += '    <td class="text-danger" style="font-weight:bold; font-size:16px;" onclick="cancelPrepareOrder('+ val.order_header_id +', `'+$.trim(val.pick_release_no)+'`, `'+$.trim(val.pick_release_status)+'`)"> X </td>';
                                html += '    <td>'+roll+'<input type="hidden" name="order_header_id['+val.order_header_id+']" value="'+val.order_header_id+'" ></td></td>';
                                html += '    <td>'+val.prepare_order_number+' <input type="hidden" name="product_type_code['+val.order_header_id+']" value="'+val.product_type_code+'" ></td>';
                                html += '    <td>'+val.delivery_date+' <input type="hidden" name="customer_type_id['+val.order_header_id+']" value="'+val.customer_type_id+'" ></td>';
                                html += '    <td class="text-left">'+val.customer_name+'</td>';
                                html += '    <td class="text-right">'+val.credit_amount+'</td>';
                                html += '    <td class="text-right">'+val.cash_amount+'</td>';
                                html += '    <td class="text-right">'+val.grand_total+'</td>';
                                html += '    '+statusAmount+'';
                                html += '    <td>';
                                html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="option_b1" name="isapprove['+val.order_header_id+']" '+checkApprove+'></label></div>';
                                html += '    </td>';

                                if (val.program_code == 'OMP0020' || specialUsers == 1) {
                                    if ($.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') {
                                        disabledApprover = '';
                                    }else{
                                        disabledApprover = 'disabled';
                                    }
                                }else{
                                    if((val.customer_type_id == 30 || val.customer_type_id == 40) && $.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel'){
                                        disabledApprover = '';
                                    }else{
                                        if ((val.statusAmount == 2 || val.statusAmount == 0) && $.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') {
                                            disabledApprover = '';
                                        }else{
                                            disabledApprover = 'disabled';
                                        }
                                    }
                                }

                                html += '    <td>';
                                html += '        <select class="custom-select" name="approver_id['+val.order_header_id+']" id="approver_id_'+val.order_header_id+'" '+disabledApprover+' >';
                                html += '            <option value=""> &nbsp; </option>';
                                $.each(approverList, function(key,valApprover){
                                    if (val.pick_release_approve_by == valApprover.approver_order_id) {
                                        selectApprover = 'selected';
                                    }else if(valApprover.default_flag == 'Y'){
                                        selectApprover = 'selected';
                                    }else{
                                        selectApprover = '';
                                    }

                                    html += '            <option '+selectApprover+' value="'+valApprover.approver_order_id+'">'+valApprover.approver_name+'</option>';
                                });
                                html += '        </select>';
                                html += '    </td>';
                                html += '    <td> <input type="text" class="form-control" name="remark['+val.order_header_id+']" id="remark_'+val.order_header_id+'" value="'+$.trim(val.attribute1)+'" '+disabledApprover+' > </td>';

                                if ($.trim(val.pick_release_no) == '') {
                                    html += '    <td>'+val.pick_release_no+'</td>';
                                }else if ($.trim(val.print_invoice_flag) == 'Y') {
                                    html += '    <td><a style="color: green" href="{{ url("om/print-invoice/report?invoice=") }}'+val.order_header_id+'" target="_blank" id="product_type_code['+val.order_header_id+']"> <i class="fa fa-check-circle"></i> &nbsp;'+val.pick_release_no+'</a></td>';
                                }else{
                                    html += '    <td><a href="{{ url("om/print-invoice/report?invoice=") }}'+val.order_header_id+'" target="_blank" id="product_type_code['+val.order_header_id+']" onclick="changeAction('+ val.order_header_id +', `'+$.trim(val.pick_release_no)+'`)">'+val.pick_release_no+'</a></td>';
                                }

                                html += '    <td>'+val.pick_release_status+'</td>';
                                html += '    <td>';
                                html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="option_c1" name="pick_release_print_flag_check['+val.order_header_id+']" '+checkPrint+'></label></div>';
                                html += '    </td>';
                                html += '</tr>';

                                roll++;
                            });

                            // $('#dataSearchResult').html(html);
                            
                            searchApprovePrepare();

                            $('.check').iCheck({
                                checkboxClass: 'icheckbox_square-green'
                            });

                            $('.checksub').iCheck({
                                checkboxClass: 'icheckbox_square-green'
                            });

                            $('#buttonApprove').attr('disabled', false);
                            $('#buttonCancel').attr('disabled', false);

                            if (event == 'Confirm') {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: "อนุมัติใบเตรียมการขาย/ใบสั่งซื้อ เรียบร้อยแล้ว",
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2500
                                });
                            }else{
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: "ยกเลิกใบเตรียมการขาย/ใบสั่งซื้อ เรียบร้อยแล้ว",
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2500
                                });
                            }

                        }else{

                            if (event == 'Confirm') {
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: "ไม่สามารถอนุมัติใบเตรียมการขาย/ใบสั่งซื้อได้ กรุณาลองอีกครั้ง",
                                    icon: 'error',
                                    timer: 2500
                                });
                            }else{
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: "ไม่สามารถยกเลิกได้ เนื่องจากออก Invoice/ใบขนแล้ว",
                                    icon: 'error',
                                    timer: 2500
                                });
                            }
                        }
                        Swal.close();
                    }
                });

            }
        }
    }

    function cancelPrepareOrder(orderHeaderID, pickReleaseNo, pickReleaseStatus)
    {
        console.log('############## cancelPrepareOrder')

        if($.trim(pickReleaseNo) != '' && pickReleaseStatus == 'Confirm'){
            Swal.fire({
                title: '',
                text: "ไม่สามารถยกเลิกได้ เนื่องจากออก Invoice/ใบขนแล้ว",
                icon: 'warning',
                timer: 2500
            });
        }else{
            Swal.fire({
                title: '',
                text: "ต้องการยกเลิกหรือไม่!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#ed4859',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {

                    const formData = new FormData(document.getElementById("formApprovePrepareOrder"));
                    formData.append('_token','{{ csrf_token() }}');
                    formData.append('cancel_header_id', orderHeaderID);

                    $.ajax({
                        url         : '{{ url("om/ajax/approve-prepare-order/cancel") }}',
                        type        : 'post',
                        data        : formData,
                        cache       : false,
                        processData : false,
                        contentType : false,
                        success     : function(res){

                            var data = res.data;
                            var html = '';
                            var orderList = data.data;
                            if(data.status == 'success'){

                                var roll = 1;
                                $.each(orderList, function(key,val){

                                    const isapprove = val.pick_release_approve_flag != null ? true : false;
                                    const isprint = val.pick_release_print_flag != null ? true : false;
                                    let approveby = val.pick_release_approve_flag == 'Y' ? val.approver_name : '';

                                    var addition_approve_status = val.addition_approve_status == 'Y' ? 'text-status-y' : 'text-status-n';

                                    var buttonHtml = '<button type="button" class="btn btn-default" name="btnShowDetail" id="btnShowDetail" onclick="showModalPayment('+val.order_header_id+', '+val.customer_id+', `'+val.prepare_order_number+'`)"><i class="fa fa-file-text-o"></i> รายละเอียด</button>';

                                    let statusAmount = '';
                                    if (val.program_code == 'OMP0020') {
                                        statusAmount =  val.statusAmount == null ? '<td>-</td>' :
                                                        // val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="td-green-new '+addition_approve_status+'">'+$.trim(val.invoice_no)+'</td>' :
                                                        val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                        val.statusAmount == 1 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                        '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>';
                                    }else{
                                        if (val.program_code == 'OMP0019' && (val.customer_type_id == 30 || val.customer_type_id == 40)) {
                                            statusAmount =  val.statusAmount == null ? '<td>-</td>' :
                                                            // val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="td-green-new '+addition_approve_status+'">'+$.trim(val.invoice_no)+'</td>' :
                                                            val.statusAmount == 2 && val.standing_debt_status == 'Y' ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                            val.statusAmount == 1 && val.standing_debt_status == 'Y' ? '<td class="td-orange '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                            val.standing_debt_status != 'W' ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                            '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>';
                                        }else{
                                            statusAmount =  val.statusAmount == null ? '<td>-</td>' :
                                                            // val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="td-green-new '+addition_approve_status+'">'+$.trim(val.invoice_no)+'</td>' :
                                                            val.statusAmount == 2 ? '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                            val.statusAmount == 1 ? '<td class="td-orange '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>' :
                                                            '<td class="td-green-new '+addition_approve_status+'"></td>' + '<td class="'+addition_approve_status+'">'+buttonHtml+'</td>';
                                        }
                                    }

                                    let checkEnabled        = (val.statusAmount == 2 && !isapprove) || (val.statusAmount != 2 && isapprove)  ? '' : 'disabled';
                                    let checkApprove        = val.pick_release_approve_flag == 'Y' ? 'checked' : '';
                                    let checkPrint          = val.pick_release_print_flag   == 'Y' ? 'checked' : '';
                                    var selectApprover      = '';
                                    var disabledApprover    = '';

                                    html += '<tr class="align-middle">';
                                    html += '    <td>';
                                    if (val.program_code == 'OMP0020' || specialUsers == 1) {
                                        if ($.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') {
                                            html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                        }else{
                                            html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                        }
                                    }else{
                                        if((val.customer_type_id == 30 || val.customer_type_id == 40) && $.trim(val.pick_release_status) != 'Confirm' && val.product_type_code == 10 && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel'){
                                            html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                        }else{
                                            if ((val.statusAmount == 2 || val.statusAmount == 0) && $.trim(val.pick_release_status) != 'Confirm' && $.trim(val.payment_before_status) == 'Y' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') {
                                                html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                            }else{
                                                if ($.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel' && val.statusAmount != 1) {
                                                    html += '        <div class="i-checks wihtout-text m-auto checkMark"><label><input type="checkbox" class="check check-line" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                                }else{
                                                    html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="'+val.order_header_id+'" name="select_order[]"></label></div>';
                                                }
                                            }
                                        }
                                    }
                                    html += '    <input type="hidden" name="status_amount['+val.order_header_id+']" id="status_amount_'+val.order_header_id+'" value="'+val.statusAmount+'" ></td>';
                                    html += '    <td class="text-danger" style="font-weight:bold; font-size:16px;" onclick="cancelPrepareOrder('+ val.order_header_id +', `'+$.trim(val.pick_release_no)+'`, `'+$.trim(val.pick_release_status)+'`)"> X </td>';
                                    html += '    <td>'+roll+'<input type="hidden" name="order_header_id['+val.order_header_id+']" value="'+val.order_header_id+'" ></td></td>';
                                    html += '    <td>'+val.prepare_order_number+' <input type="hidden" name="product_type_code['+val.order_header_id+']" value="'+val.product_type_code+'" ></td>';
                                    html += '    <td>'+val.delivery_date+' <input type="hidden" name="customer_type_id['+val.order_header_id+']" value="'+val.customer_type_id+'" ></td>';
                                    html += '    <td class="text-left">'+val.customer_name+'</td>';
                                    html += '    <td class="text-right">'+val.credit_amount+'</td>';
                                    html += '    <td class="text-right">'+val.cash_amount+'</td>';
                                    html += '    <td class="text-right">'+val.grand_total+'</td>';
                                    html += '    '+statusAmount+'';
                                    html += '    <td>';
                                    html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="option_b1" name="isapprove['+val.order_header_id+']" '+checkApprove+'></label></div>';
                                    html += '    </td>';

                                    if (val.program_code == 'OMP0020' || specialUsers == 1) {
                                        if ($.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') {
                                            disabledApprover = '';
                                        }else{
                                            disabledApprover = 'disabled';
                                        }
                                    }else{
                                        if((val.customer_type_id == 30 || val.customer_type_id == 40) && $.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel'){
                                            disabledApprover = '';
                                        }else{
                                            if ((val.statusAmount == 2 || val.statusAmount == 0) && $.trim(val.pick_release_status) != 'Confirm' && $.trim(val.pick_release_status) != 'Cancelled' && $.trim(val.pick_release_status) != 'Cancel') {
                                                disabledApprover = '';
                                            }else{
                                                disabledApprover = 'disabled';
                                            }
                                        }
                                    }

                                    html += '    <td>';
                                    html += '        <select class="custom-select" name="approver_id['+val.order_header_id+']" id="approver_id_'+val.order_header_id+'" '+disabledApprover+' >';
                                    html += '            <option value=""> &nbsp; </option>';
                                    $.each(approverList, function(key,valApprover){
                                        if (val.pick_release_approve_by == valApprover.approver_order_id) {
                                            selectApprover = 'selected';
                                        }else if(valApprover.default_flag == 'Y'){
                                            selectApprover = 'selected';
                                        }else{
                                            selectApprover = '';
                                        }

                                        html += '            <option '+selectApprover+' value="'+valApprover.approver_order_id+'">'+valApprover.approver_name+'</option>';
                                    });
                                    html += '        </select>';
                                    html += '    </td>';
                                    html += '    <td> <input type="text" class="form-control" name="remark['+val.order_header_id+']" id="remark_'+val.order_header_id+'" value="'+$.trim(val.attribute1)+'" '+disabledApprover+' > </td>';

                                    if ($.trim(val.pick_release_no) == '') {
                                        html += '    <td>'+val.pick_release_no+'</td>';
                                    }else if ($.trim(val.print_invoice_flag) == 'Y') {
                                        html += '    <td><a style="color: green" href="{{ url("om/print-invoice/report?invoice=") }}'+val.order_header_id+'" target="_blank" id="product_type_code['+val.order_header_id+']"> <i class="fa fa-check-circle"></i> &nbsp;'+val.pick_release_no+'</a></td>';
                                    }else{
                                        html += '    <td><a href="{{ url("om/print-invoice/report?invoice=") }}'+val.order_header_id+'" target="_blank" id="product_type_code['+val.order_header_id+']" onclick="changeAction('+ val.order_header_id +', `'+$.trim(val.pick_release_no)+'`)">'+val.pick_release_no+'</a></td>';
                                    }

                                    html += '    <td>'+val.pick_release_status+'</td>';
                                    html += '    <td>';
                                    html += '        <div class="i-checks wihtout-text m-auto disabled"><label><input type="checkbox" class="checksub" value="option_c1" name="pick_release_print_flag_check['+val.order_header_id+']" '+checkPrint+'></label></div>';
                                    html += '    </td>';
                                    html += '</tr>';

                                    roll++;
                                });

                                $('#dataSearchResult').html(html);

                                $('.check').iCheck({
                                    checkboxClass: 'icheckbox_square-green'
                                });

                                $('.checksub').iCheck({
                                    checkboxClass: 'icheckbox_square-green'
                                });

                                $('#buttonApprove').attr('disabled', false);
                                $('#buttonCancel').attr('disabled', false);

                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: "ยกเลิก Invoice/ใบขนเรียบร้อยแล้ว",
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2500
                                });
                            }else{
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: "ไม่สามารถยกเลิกได้ เนื่องจากออก Invoice/ใบขนแล้ว",
                                    icon: 'error',
                                    timer: 2500
                                });
                            }
                        }
                    });
                }else{
                    Swal.close();
                }
            });
        }
    }

    var triggeredByChild = false;

    $('#checkAll').on('ifChecked', function (event) {
        $('.check').iCheck('check');
        triggeredByChild = false;
    });

    $('#checkAll').on('ifUnchecked', function (event) {
        if (!triggeredByChild) {
            $('.check').iCheck('uncheck');
        }
        triggeredByChild = false;
    });

    // Removed the checked state from "All" if any checkbox is unchecked
    $('.checkMark').on('ifUnchecked', function (event) {
        triggeredByChild = true;
        $('#checkAll').iCheck('uncheck');
    });

    $('.checkMark').on('ifChecked', function (event) {
        if ($('.check').filter(':checked').length == $('.check').length) {
            $('#checkAll').iCheck('check');
        }
    });

    $(function(){
        $(document).on('click', '.show-modal-amount', function() {
            $('#modal-price').modal('show');
            try {
                $("#modal-credit_amount").html($(this).attr('data-credit_amount'))
                $("#modal-cash_amount").html($(this).attr('data-cash_amount'))
                $("#modal-grand_total").html($(this).attr('data-grand_total'))
            } catch (error) {
                $("#modal-credit_amount").html('0.00')
                $("#modal-cash_amount").html('0.00')
                $("#modal-grand_total").html('0.00')
            }
        })
    })

    function showModalPayment(orderID, customerID, prepareOrderNumber)
    {
        console.log('############## showModalPayment')

        Swal.fire({
            title:"",
            text:"กำลังประมวลผล...",
            showConfirmButton: false,
            allowOutsideClick: false,
            //icon: "success"
        });

        $.ajax({
            url : '{{ url("om/ajax/approve-prepare-order/get-payment-state") }}/'+customerID+'/'+orderID,
            success : function(res){
                var data = res.data.data;

                console.log(data);

                var htmlPayment = '';

                htmlPayment += '<div class="modal fade" id="myModal-'+orderID+'" tabindex="-1" role="dialog"  aria-hidden="true">';
                htmlPayment += '    <div class="modal-dialog modal-lg modal-custom">';
                htmlPayment += '        <div class="modal-content">';
                htmlPayment += '            <div class="modal-header">';
                htmlPayment += '                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                htmlPayment += '                <h3 class="modal-title"> หนี้ค้างชำระ </h3>';
                htmlPayment += '                {{-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> --}}';
                htmlPayment += '            </div>';
                htmlPayment += '            <div class="modal-body">';
                htmlPayment += '                <table class="table table-bordered text-center align-middle">';
                htmlPayment += '                        <tr>';
                // htmlPayment += '                            <th> เลือก </th>';
                htmlPayment += '                            <th> เลขที่ใบเตรียมขาย </th>';
                htmlPayment += '                            <th> เลขที่ Invoice </th>';
                htmlPayment += '                            <th> กลุ่มวงเงิน </th>';
                htmlPayment += '                            <th> จำนวนเงิน </th>';
                // htmlPayment += '                            <th> ค่าปรับ </th>';
                htmlPayment += '                            <th> วันครบกำหนดชำระ </th>';
                htmlPayment += '                            <th> เลขที่ใบเสร็จรับเงิน / <br /> ใบลดหนี้เงินโอนไร่ </th>';
                htmlPayment += '                            <th> วันที่รับชำระเงิน / <br /> วันที่ลดหนี้ </th>';
                htmlPayment += '                            <th> จำนวนเงินที่รับชำระ </th>';
                htmlPayment += '                            <th> จำนวนเงินลดหนี้ </th>';
                htmlPayment += '                        </tr>';

                if (data != null) {
                    var total = 0;
                    $.each(data, function(key,items){

                        if (items.status_due_date == 'check') {
                            var statusCheck = 'checked';
                        }else{
                            var statusCheck = '';
                        }

                        console.log(items);
                        if (items.payment_amount != 0) {

                            if(items.count_payment_dom > 0){

                                $.each(items.payment_dom_data, function(keySub, itemSub){

                                    // Add Cal total 20230127 Piyawut A.
                                    total += itemSub.payment_amount_num? parseFloat(itemSub.payment_amount_num): 0;

                                    htmlPayment += '<tr>';
                                    if (keySub == 0) {
                                        htmlPayment += '    <td style="vertical-align:top !important" rowspan="'+$.trim(items.count_payment_dom)+'"> '+$.trim(items.payment_prepare_num)+' </td>';
                                        htmlPayment += '    <td style="vertical-align:top !important" rowspan="'+$.trim(items.count_payment_dom)+'"> '+$.trim(items.payment_release_no)+' </td>';
                                        htmlPayment += '    <td style="vertical-align:top !important" rowspan="'+$.trim(items.count_payment_dom)+'"> '+$.trim(items.payment_credit_group)+' </td>';
                                        htmlPayment += '    <td style="vertical-align:top !important" rowspan="'+$.trim(items.count_payment_dom)+'"> '+$.trim(items.payment_amount)+' </td>';
                                        htmlPayment += '    <td style="vertical-align:top !important" rowspan="'+$.trim(items.count_payment_dom)+'"> '+$.trim(items.payment_due_date)+' </td>';
                                    }
                                        htmlPayment += '    <td> '+$.trim(itemSub.payment_number)+' </td>';
                                        htmlPayment += '    <td> '+$.trim(itemSub.payment_date)+' </td>';
                                        htmlPayment += '    <td> '+$.trim(itemSub.payment_amount)+' </td>';

                                    if (keySub == 0) {
                                        htmlPayment += '    <td style="vertical-align:top !important" rowspan="'+$.trim(items.count_payment_dom)+'"> '+numberFormat($.trim(items.cn_amount))+' </td>';
                                    }

                                    htmlPayment += '</tr>';
                                });
                            }else{

                                htmlPayment += '<tr>';
                                htmlPayment += '    <td> '+$.trim(items.payment_prepare_num)+' </td>';
                                htmlPayment += '    <td> '+$.trim(items.payment_release_no)+' </td>';
                                htmlPayment += '    <td> '+$.trim(items.payment_credit_group)+' </td>';
                                htmlPayment += '    <td> '+$.trim(items.payment_amount)+' </td>';
                                htmlPayment += '    <td> '+$.trim(items.payment_due_date)+' </td>';
                                htmlPayment += '    <td> </td>';
                                htmlPayment += '    <td> </td>';
                                htmlPayment += '    <td> </td>';
                                htmlPayment += '    <td> '+numberFormat($.trim(items.cn_amount))+' </td>';
                                htmlPayment += '</tr>';

                            }
                        }
                    });
                    htmlPayment += '<tr>';
                    htmlPayment += '    <td colspan="7" class="text-right"> <strong>รวมจำนวนเงินที่รับชำระ</strong> </td>';
                    htmlPayment += '    <td> <strong>'+numberFormat(total)+'</strong> </td>';
                    htmlPayment += '    <td> <strong>-</strong> </td>';
                    htmlPayment += '</tr>';
                }

                htmlPayment += '                </table>';
                htmlPayment += '            </div>';
                htmlPayment += '        </div>';
                htmlPayment += '    </div>';
                htmlPayment += '</div>';

                $('#group-modal-popup').html(htmlPayment);
                Swal.close();

                $('#myModal-'+orderID).modal();
            }
        });
    }

    function numberFormat(nStr)
    {
        nStr = parseFloat(nStr).toFixed(2);
        nStr = Math.round(nStr * 1000) / 1000;
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '.00';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }

        x2 = x2.length == 2 ? x2.toString()+'0' : x2;
        return x1 + x2;
    }

    function changeAction(order_header_id, pick_release_no)
    {  
        document.getElementById('product_type_code['+order_header_id+']').style.color = 'green';
        document.getElementById('product_type_code['+order_header_id+']').innerHTML = '<i class="fa fa-check-circle"></i> &nbsp;'+pick_release_no;
    }

    $("#undoBtn").click(() => {
      $("#delivery_start_date").val(defaultDate).trigger('change');
      $("#delivery_end_date").val(defaultDate).trigger('change');
      $("#prepare_order_number").val('').trigger('change');
      $("#customer_number").val('').trigger('change');
      $("#customer_name").val('').trigger('change');
      $("#pick_release_approve_flag").val('').trigger('change');
      $("#pick_release_no").val('').trigger('change');
      $("#pick_release_status").val('').trigger('change');
      $("#pick_release_print_flag").val('').trigger('change');
      $("#dataSearchResult").html('');
    })

</script>
@stop
