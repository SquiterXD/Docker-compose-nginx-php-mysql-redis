@extends('layouts.app')
<style>
    div.dataTables_wrapper div.dataTables_length select{
        width: 75px!important;
    }
</style>

@section('title', 'ข้อมูลลูกค้า สำหรับขายต่างประเทศ')

@section('page-title')
    <h2>อนุมัติใบเตรียมการขาย/ใบสั่งซื้อ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>อนุมัติใบเตรียมการขาย/ใบสั่งซื้อ</strong>
        </li>
    </ol>
@stop

@section('content')

    <div class="ibox">
        <div class="ibox-title">
            <h3>อนุมัติใบเตรียมการขาย/ใบสั่งซื้อ</h3>
        </div>
        <div class="ibox-content"> 
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
                <div class="col-xl-6 m-auto">
                        
                    <div class="form-group">
                        <h3 class="black mb-3">ค้นหารายการที่ต้องการ</h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="d-block">วันที่ส่ง</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control date" name="startdate" id='startdate' placeholder="" value="">
                                    <i class="fa fa-calendar"></i> 
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="d-block">ถึงวันที่</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control date" name="enddate" id='enddate' placeholder="" value="">
                                    <i class="fa fa-calendar"></i> 
                                </div>
                            </div>
                        </div><!--row-->
                    </div><!--form-group--> 

                    <div class="form-group"> 
                        <label class="d-block">เลขที่ใบเตรียมขาย</label>
                        <div class="input-icon">
                            <input type="text" class="form-control" name="prep" id='prep' placeholder="" value="">
                            <i class="fa fa-search"></i> 
                        </div>
                    </div><!--form-group--> 

                    <div class="form-group"> 
                        <label class="d-block">ลูกค้า</label> <div class='row space-50 justify-content-md-center' id='loading'></div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-icon">
                                    <select data-placeholder=" " class="custom-select" name="customer_number" id="customer_number">
                                        <option value=""> &nbsp; </option>
                                        @foreach ($customerList as $item)
                                        <option value="{{ $item->customer_number }}">{{ $item->customer_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <input type="text" class="form-control" hidden name="customer_id" id='customer_id' placeholder="" value="">
                                <input type="text" class="form-control" disabled id="customer_name" name="customer_name" placeholder="" value="">
                            </div>
                        </div><!--row-->
                    </div><!--form-group--> 

                    <div class="form-group">                                    
                            <label class="d-block">สถานะการอนุมัติ</label>
                            <select class="custom-select" name='order_status' id='order_status'>
                                <option>อนุมัติ</option>
                                <option>ยังไม่ได้อนุมัติ</option>
                            </select>
                        </div><!--form-group-->

                    <div class="form-group">
                        <label class="d-block">เลขที่ Invoice/ใบขน</label>
                        <div class="input-icon">
                            <input type="text" class="form-control" name="invoice_number" placeholder="" value="">
                            <i class="fa fa-search"></i> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="d-block">สถานะ Invoice/ใบขน</label>
                        <select class="custom-select" name='invoice_status' id='invoice_status'>
                            <option>Confirm</option>
                            <option>Cancel</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="d-block">พิมพ์แล้ว (กองคลัง)</label>
                        <select class="custom-select" name='kang' id='kang'>
                            <option>พิมพ์แล้ว</option>
                            <option>ยังไม่ได้พิมพ์</option>
                        </select>
                    </div>

                    
                    <div class="form-buttons no-border">  
                        <button class="btn btn-lg btn-white" type="button" id='searchItem' name='searchItem'><i class="fa fa-search"></i> ค้นหา</button>
                    </div>
                </div><!--col-xl-6-->

                <div class="col-md-12">
                    <hr class="lg">

                    <div class="form-header-buttons flex-md-row-reverse">
                        <div class="buttons d-flex"> 
                            <button class="btn btn-md btn-primary" type="button" id='approve' name='approve'><i class="fa fa-check"></i> อนุมัติ</button>
                            <button class="btn btn-md btn-danger" type="button" id='cancel' name='cancel'><i class="fa fa-times"></i> ยกเลิก</button>
                        </div><!--buttons--> 

                        <button class="btn btn-md btn-white has-checkbox mt-2 mt-md-0" type="button">
                            <div class="checkall">
                            </div>
                        </button>
                    </div><!--form-header-buttons-->

                    <div class="hr-line-dashed"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center table-hover min-1600 f13"> 
                            <thead>
                                <tr class="align-middle">
                                    <th class="w-90">เลือกรายการ</th>
                                    <th>รายการที่</th>
                                    <th>เลขที่ใบเตรียมขาย</th>
                                    <th>วันที่ส่ง</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>เงินเชื่อ</th>
                                    <th>เงินสด</th>
                                    <th>จำนวนเงิน</th>
                                    <th class="w-150">สถานะการ<br>รับชำระเงิน</th>
                                    <th class="w-150">เลขที่ใบเสร็จรับเงิน</th>
                                    <th class="w-90">อนุมัติ</th>
                                    <th class="w-170">ผู้อนุมัติ</th>
                                    <th>เลขที่ Invoice/<br>ใบขน</th>
                                    <th>สถานะ Invoice/<br>ใบขน</th>
                                    <th class="w-90">พิมพ์แล้ว<br>(กองคลัง)</th> 
                                </tr>
                            </thead>
                            <tbody id='tablebody' name='tablebody'>


                                 
                            </tbody>
                        </table>
                    </div><!--table-responsive-->
                    <div class="d-flex mt-4 mb-5">
                        <div class="d-flex ml-auto mr-4">สั่งซื้อปกติ <span class="box-label" style="background-color: #1c84c6"></span></div>
                        <div class="d-flex">สั่งซื้อเกินโควต้า <span class="box-label" style="background-color:red"></span></div>
                    </div><!--d-flex-->
                </div>
            </div><!--row-->
        </div><!--ibox-content-->
    </div><!--ibox-->

@endsection

@section('scripts')
<script>
    let selectAll = false
    function changeapprover (id) {
        let ii = 0
        while(ii<@json($approver).length) {
            if(@json($approver)[ii].approver_order_id==$(`#approver${id}`).val() && @json($approver)[ii].approver_name=='ผู้อำนวยการฝ่ายขาย'){
                $.each($("input[name='orderselect']"), function (K, V) {
                    if(V.value==id) {
                        $(this).prop('disabled',false)
                    }
                });
            }
            ii++
        }
    }
    $(document).ready(function(){ 

        $('.custom-select').chosen({width: "100%"});
        $(".checkall").html(
            `<div class="icheckbox_square-green"><input type="checkbox" id="select_all" value="option_0" name="a"><ins class="iCheck-helper" ></ins>
            </div><span> เลือกทั้งหมด</span>`
        );
        $(".checkall").not('input[name="orderselect"]').click(function() {
            selectAll = !selectAll;
            // $("#select_all").prop("checked", selectAll);
            $('input:checkbox').not("#isapprover1").prop('checked',selectAll)
            // alert('adasd')
        });
        
        let body = ``
        let index = 0
        while(index<@json($order).length) {
            const order_header_id = @json($order)[index].order_header_id
            const prepare_order_number = @json($order)[index].prepare_order_number != null ? @json($order)[index].prepare_order_number : 'ไม่มีข้อมูล'
            const order_date = @json($order)[index].order_date != null ? @json($order)[index].order_date : 'ไม่มีข้อมูล'
            const customer_name = @json($order)[index].customer_name != null ? @json($order)[index].customer_name : 'ไม่มีข้อมูล'
            const credit_amount = @json($order)[index].credit_amount != null ? @json($order)[index].credit_amount : 'ไม่มีข้อมูล'
            const cash_amount = @json($order)[index].cash_amount != null ? @json($order)[index].cash_amount : 'ไม่มีข้อมูล'
            const grand_total = @json($order)[index].grand_total != null ? @json($order)[index].grand_total : 'ไม่มีข้อมูล'
            const isapprove = @json($order)[index].pick_release_approve_flag != null ? true : false
            const isprint = @json($order)[index].pick_release_print_flag != null ? true : false
            const pick_release_no =@json($order)[index].pick_release_no != null ? @json($order)[index].pick_release_no : 'ไม่มีข้อมูล'
            const pick_release_status = @json($order)[index].pick_release_status != null ? @json($order)[index].pick_release_status : 'ไม่มีข้อมูล'
            let approveby = @json($order)[index].pick_release_approve_by != null ? @json($order)[index].approver_name : ''
            const is_over_quota = @json($order)[index].is_over_quota
            const invoice = @json($order)[index].invoice
            
            let statusAmount =  @json($order)[index].statusAmount == null ? '<td>-</td>' :  @json($order)[index]
                            .statusAmount ==
                            2 ?
                            '<td class="td-green">รับชำระเงินแล้ว</td>' + `<td class='td-green'>${invoice}</td>` :  @json($order)[index].statusAmount == 1 ?
                            '<td class="td-orange" colspan="2">ยังไม่ได้ชำระเงิน</td>' :
                            '<td class="td-yellow" colspan="2">ยังไม่ถึงกำหนดชำระเงิน</td>';

            let checkEnabled  = (@json($order)[index].statusAmount == 2 && !isapprove) || (@json($order)[index].statusAmount != 2 && isapprove) ? '' : 'disabled' 
            if( @json($order)[index].pick_release_approve_by == null) {
                let apbody = ``
                let ii = 0
                while(ii<@json($approver).length) {
                    apbody += `<option value='${@json($approver)[ii].approver_order_id}'>${@json($approver)[ii].approver_name}</option>`
                    ii++
                }
                approveby = `<select class="custom-select" id='approver${order_header_id}' onchange='changeapprover("${order_header_id}")'>${apbody}</select>`
            }
             index++
                        body += `
                                <tr class="align-middle ${is_over_quota ? 'red' : ''}">
                                    <td>
                                        <input type="checkbox" value="${order_header_id}" name="orderselect" id='orderselect' ${checkEnabled}>    
                                    </td>
                                    <td>${index}</td>
                                    <td>${prepare_order_number}</td>
                                    <td>${order_date}</td>
                                    <td class="text-left">${customer_name}</td>
                                    <td class="text-right">${cash_amount}</td>
                                    <td class="text-right">${credit_amount}</td>
                                    <td class="text-right">${grand_total}</td>
                                    ${statusAmount} 
                                    <td>
                                        <input type="checkbox" value="option_b2" name="isapprover${order_header_id}" id='isapprover1' ${isapprove ? 'checked' : ''} disabled> 
                                    </td>
                                    <td class="text-right">${approveby}</td>
                                    
                                    <td>${pick_release_no}</td>
                                    <td>${pick_release_status}</td>
                                    <td>
                                        <input type="checkbox" value="option_b2" name="b" ${isprint ? 'checked' : ''} >
                                    </td>
                                </tr>`
        }
        $('#tablebody').html(body)

        $('.date').datepicker();
        $('#searchItem').click(()=>{
            $('#tablebody').html('')
            swal("", 'กำลังโหลดข้อมูล', "");
            let data = {
                "_token": "{{ csrf_token() }}",
                startdate : $('#search').val(),
                enddate : $('#search').val(),
                preparation : $('#prep').val(),
                customer_id : $('#customer_id').val(),
                order_status : $('#order_status').val(),
                invoice_number : $('#invoice_number').val(),
                invoice_status : $('#invoice_status').val(),
                kang : $('#kang').val()
            }
            $.ajax({
            url: "{{ route('om.ajax.order.approve.search.item') }}",
            method: 'post',
            data: data,
            success: function (response) {
                if(response.status=="success"){
                    swal('สำเร็จ!', 'ค้นหาข้อมูลสำเร็จ', 'success')
                    let body = ``
                    let i = 0
                    response.result.forEach(e=>{
                        i++
                        const isapprove = e.pick_release_approve_flag != null ? true : false
                        const isprint = e.pick_release_print_flag != null ? true : false
                        let approveby = e.pick_release_approve_flag == 'Y' ? e.approver_name : ''

                        const order_header_id = e.order_header_id != null ? e.order_header_id : 'ไม่มีข้อมูล'
                        const prepare_order_number = e.prepare_order_number != null ? e.prepare_order_number : 'ไม่มีข้อมูล'
                        const order_date = e.order_date != null ? e.order_date : 'ไม่มีข้อมูล'
                        const customer_name = e.customer_name != null ? e.customer_name : 'ไม่มีข้อมูล'
                        const cash_amount = e.cash_amount != null ? e.cash_amount : 'ไม่มีข้อมูล'
                        const credit_amount = e.credit_amount != null ? e.credit_amount : 'ไม่มีข้อมูล'
                        const grand_total = e.grand_total != null ? e.grand_total : 'ไม่มีข้อมูล'
                        const pick_release_no = e.pick_release_no != null ? e.pick_release_no : 'ไม่มีข้อมูล'
                        const pick_release_status = e.pick_release_status != null ? e.pick_release_status : 'ไม่มีข้อมูล'
                        const is_over_quota = e.is_over_quota

                        const invoice = e.invoice
            
                        let statusAmount =  e.statusAmount == null ? '<td>-</td>' :  e
                                        .statusAmount ==
                                        2 ?
                                        '<td class="td-green">รับชำระเงินแล้ว</td>' + `<td class='td-green'>${invoice}</td>` :  e.statusAmount == 1 ?
                                        '<td class="td-orange" colspan="2">ยังไม่ได้ชำระเงิน</td>' :
                                        '<td class="td-yellow" colspan="2">ยังไม่ถึงกำหนดชำระเงิน</td>';

                        let checkEnabled  = (e.statusAmount == 2 && !isapprove) || (e.statusAmount != 2 && isapprove)  ? '' : 'disabled' 

                        if( e.pick_release_approve_flag != 'Y') {
                            let apbody = ``
                            let ii = 0
                            while(ii<@json($approver).length) {
                                apbody += `<option value='${@json($approver)[ii].approver_order_id}'>${@json($approver)[ii].approver_name}</option>`
                                ii++
                            }
                            approveby = `<select class="custom-select" id='approver${e.order_header_id}' name='approver${e.order_header_id}' style='width:194px' onchange='changeapprover("${order_header_id}")'>${apbody}</select>`
                        }
                        body += `
                                <tr class="align-middle ${is_over_quota ? 'red' : ''}">
                                    <td>
                                        <input type="checkbox" value="${order_header_id}" name="orderselect" id='orderselect' ${checkEnabled}>
                                    </td>
                                    <td>${i}</td>
                                    <td>${prepare_order_number}</td>
                                    <td>${order_date}</td>
                                    <td class="text-left">${customer_name}</td>
                                    <td class="text-right">${cash_amount}</td>
                                    <td class="text-right">${credit_amount}</td>
                                    <td class="text-right">${grand_total}</td>
                                    ${statusAmount}
                                    <td>
                                        <input type="checkbox" value="option_b2" name="isapprove${order_header_id}" id='isapprove${order_header_id}' ${isapprove ? 'checked' : ''} disabled > 
                                    </td>
                                    <td class="text-right">${approveby}</td>
                                    
                                    <td>${pick_release_no}</td>
                                    <td>${pick_release_status}</td>
                                    <td>
                                        <input type="checkbox" value="option_b2" name="b" ${isprint ? 'checked' : ''} >
                                    </td>
                                </tr>`
                    })
                    $('#tablebody').html(body)
                }
            },
            error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", 'ไม่สามารถค้นหาได้', "error");
            }
            })
        })
        // $('#search').change(()=>{
        //     $('#loading').html('กำลังค้นหา...')
        //     $.ajax({
        //     url: "{{ route('om.ajax.order.prepare.search.customer') }}",
        //     method: 'get',
        //     data: {
        //         // "_token": "{{ csrf_token() }}",
        //         'key' : $('#search').val()
        //     },
        //     success: function (response) {
        //         $('#loading').html('')
        //         if(response.status=="success"){
        //             $('#customer_name').val(response.result)
        //             $('#customer_id').val(response.id)
        //         }
        //     },
        //     error: function (jqXHR, textStatus, errorRhrown) {
        //         swal("Error", 'ไม่สามารถค้นหาได้', "error");
        //     }
        //     })
        // })
        $('#customer_number').change(()=>{
            // console.log( @json($customerList).find(({customer_number})=>{customer_number==$('#customer_number').val()}))
            @json($customerList).forEach(e=>{
                if(e.customer_number==$('#customer_number').val()){
                    $('#customer_name').val(e.customer_name)
                    $('#customer_id').val(e.customer_id)
                }
            })
        })

        $('#approve').click(()=>{
            order_update(1)
        })
        $('#cancel').click(()=>{
            order_update(2)
        })
        function order_update (type) {
            let url = ''
            if(type==1) {
                url = "{{ route('om.ajax.order.approve.submit') }}"
            }
            else {
                url = "{{ route('om.ajax.order.approve.cancel') }}"
            }
            let order_header = [];
            swal("", 'กำลังโหลดข้อมูล', "");
            $.each($("input[name='orderselect']:checked"), function (K, V) {
                const order = {
                    order_header : V.value,
                    approver_id : $(`#approver${V.value}`).val(),
                }
                order_header.push(order)
            });
            $.ajax({
            url: url,
            method: 'post',
            data: {

                "_token": "{{ csrf_token() }}",
                data : order_header
            },
            success: function (response) {
                swal("Success", 'สำเร็จ!', "success");
                
                if(response.status=="success"){
                    swal('สำเร็จ!', 'ค้นหาข้อมูลสำเร็จ', 'success')
                    let body = ``
                    let i = 0
                    response.result.forEach(e=>{
                        i++
                        const isapprove = e.pick_release_approve_flag != null ? true : false
                        const isprint = e.pick_release_print_flag != null ? true : false
                        let approveby = e.pick_release_approve_flag == 'Y' ? e.approver_name : ''

                        const order_header_id = e.order_header_id != null ? e.order_header_id : 'ไม่มีข้อมูล'
                        const prepare_order_number = e.prepare_order_number != null ? e.prepare_order_number : 'ไม่มีข้อมูล'
                        const order_date = e.order_date != null ? e.order_date : 'ไม่มีข้อมูล'
                        const customer_name = e.customer_name != null ? e.customer_name : 'ไม่มีข้อมูล'
                        const cash_amount = e.cash_amount != null ? e.cash_amount : 'ไม่มีข้อมูล'
                        const credit_amount = e.credit_amount != null ? e.credit_amount : 'ไม่มีข้อมูล'
                        const grand_total = e.grand_total != null ? e.grand_total : 'ไม่มีข้อมูล'
                        const pick_release_no = e.pick_release_no != null ? e.pick_release_no : 'ไม่มีข้อมูล'
                        const pick_release_status = e.pick_release_status != null ? e.pick_release_status : 'ไม่มีข้อมูล'
                        const is_over_quota = e.is_over_quota

                        const invoice = e.invoice
            
                        let statusAmount =  e.statusAmount == null ? '<td>-</td>' :  e
                                        .statusAmount ==
                                        2 ?
                                        '<td class="td-green">รับชำระเงินแล้ว</td>' + `<td class='td-green'>${invoice}</td>` :  e.statusAmount == 1 ?
                                        '<td class="td-orange" colspan="2">ยังไม่ได้ชำระเงิน</td>' :
                                        '<td class="td-yellow" colspan="2">ยังไม่ถึงกำหนดชำระเงิน</td>';

                        let checkEnabled  = (e.statusAmount == 2 && !isapprove) || (e.statusAmount != 2 && isapprove)  ? '' : 'disabled' 

                        if( e.pick_release_approve_flag != 'Y') {
                            let apbody = ``
                            let ii = 0
                            while(ii<@json($approver).length) {
                                apbody += `<option value='${@json($approver)[ii].approver_order_id}'>${@json($approver)[ii].approver_name}</option>`
                                ii++
                            }
                            approveby = `<select class="custom-select" id='approver${e.order_header_id}' name='approver${e.order_header_id}' style='width:194px' onchange='changeapprover("${order_header_id}")'>${apbody}</select>`
                        }
                        body += `
                                <tr class="align-middle ${is_over_quota ? 'red' : ''}">
                                    <td>
                                        <input type="checkbox" value="${order_header_id}" name="orderselect" id='orderselect' ${checkEnabled}>
                                    </td>
                                    <td>${i}</td>
                                    <td>${prepare_order_number}</td>
                                    <td>${order_date}</td>
                                    <td class="text-left">${customer_name}</td>
                                    <td class="text-right">${cash_amount}</td>
                                    <td class="text-right">${credit_amount}</td>
                                    <td class="text-right">${grand_total}</td>
                                    ${statusAmount}
                                    <td>
                                        <input type="checkbox" value="option_b2" name="isapprove${order_header_id}" id='isapprove${order_header_id}' ${isapprove ? 'checked' : ''} disabled > 
                                    </td>
                                    <td class="text-right">${approveby}</td>
                                    
                                    <td>${pick_release_no}</td>
                                    <td>${pick_release_status}</td>
                                    <td>
                                        <input type="checkbox" value="option_b2" name="b" ${isprint ? 'checked' : ''} >
                                    </td>
                                </tr>`
                    })
                    $('#tablebody').html(body)
                }
            },
            error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", 'ไม่สามารถค้นหาได้', "error");
            }
            })

        }
    });
</script>

@endsection