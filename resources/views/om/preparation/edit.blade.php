@extends('layouts.app')
<style>
    div.dataTables_wrapper div.dataTables_length select{
        width: 75px!important;
    }
</style>

@section('title', 'บันทึกใบเตรียมการขาย')

@section('page-title')
    <h2>บันทึกใบเตรียมการขาย</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>บันทึกใบเตรียมการขาย</strong>
        </li>
    </ol>
@stop

@section('content')

<form action='{{$data->order_header_id}}/submit' method="POST" id='edit_prepare'>
    {{csrf_field()}}

    <div class="ibox">
        <div class="ibox-title">
            <h3>แก้ไขใบเตรียมการขาย - บุหรี่</h3>
        </div>
        <div class="ibox-content"> 
            <div class="row space-50 justify-content-md-center mt-md-4">


                <div class="col-12">
                    <div class="form-header-buttons">
                        <div class="buttons multiple">
                            <button class="btn btn-md btn-success" type="button" onclick='document.getElementById("edit_prepare").submit()'><i class="fa fa-plus"></i> บันทึก</button>
                            {{-- <button class="btn btn-md btn-info" type="button"><i class="fa fa-copy"></i> คัดลอก</button>
                            <button class="btn btn-md btn-white" type="button"><i class="fa fa-search"></i> ค้นหา</button>
                            <!--button class="btn btn-md btn-success w-en" type="button"><i class="fa fa-upload"></i> Attachment</button-->

                            <button class="btn btn-md btn-success" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> แนบไฟล์</span></button>

                            <div class="dropdown">
                                <button class="btn btn-md btn-white m-0" data-toggle="dropdown" type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a href="https://gramickhouse.com/demo/kao/2021/05-mcr/OMP0019.html#">บันทึก</a></li>
                                    <li><a href="https://gramickhouse.com/demo/kao/2021/05-mcr/OMP0019.html#">ยืนยัน</a></li>
                                    <li><a href="https://gramickhouse.com/demo/kao/2021/05-mcr/OMP0019.html#">ยกเลิก</a></li>
                                </ul>
                            </div>
                            <button class="btn btn-md btn-info" type="button"><i class="fa fa-print"></i> พิมพ์ใบเตรียมการขาย</button> --}}
                            <button class="btn btn-md btn-primary" type="button"   onclick='approve()'><i class="fa fa-check"></i> ส่งข้อมูลอนุมัติ</button>
                            @if($data->order_status=='Confirm')<button class="btn btn-md btn-primary" type="button" id='cancel_prepare_order' name='cancel_prepare_order' onclick='cancel()'><i class="fa fa-check"></i> ยกเลิกใบเตรียมการขาย</button>@endif
                        </div>
                    </div><!--form-header-buttons-->

                    <div class="hr-line-dashed"></div>
                </div><!--col-12-->
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">เลขที่ใบเตรียมขาย</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control" disabled="" name="prepare_order_number" placeholder="" value="{{$data->prepare_order_number}}">
                                    <i class="fa fa-search"></i> 
                                </div>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">เลขที่ใบสั่งซื้อ</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="order_no" readonly placeholder="เลขที่ใบสั่งซื้อ" value="{{$data->order_number}}">
                                    <i class="fa fa-search"></i> 
                                </div>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">เลขที่ PO ของลูกค้า</label>
                                <input type="text" class="form-control" name="customer_po" placeholder="เลขที่ PO ของลูกค้า" value="{{$data->cust_po_number}}" name='cust_po_number'  @if($data->order_status=='Confirm') readonly @endif>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">Order Status</label>
                                <div class="row space-5 align-items-center">
                                    <div class="col-md-6">
                                        
                                        <div class="input-icon">
                                            {{-- <input type="text" class="form-control" disabled="" name="" placeholder="" value="Draft">
                                            <i class="fa fa-search"></i>  --}}
                                            <select class="custom-select" id='show_order_status'>
                                                <option @if($data->order_status=='Draft') selected @endif>Draft</option>
                                                <option @if($data->order_status=='Confirm') selected @endif id='status_confirm'>Confirm</option>
                                                <option @if($data->order_status=='Cancel') selected @endif>Cancel</option>
                                                <option @if($data->order_status=='Reject') selected @endif>Reject</option> 
                                            </select>
                                            <input type='hidden' name='order_status' id='order_status'>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2 mt-md-0">
                                        <div class="i-checks f13"><label><div class="icheckbox_square-green disabled"><input type="checkbox" value="option_d1" name="a" disabled="" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>@if($data->pick_release_approve_flag)<span class="nowrap">ยอดส่งได้รับการอนุมัติ</span> @endif</label></div>
                                    </div>
                                </div><!--row-->
                            </div>
                        </div><!--col-->

                        <!--//-->

                        <div class="col-xl-9"> 
                            <div class="form-group">
                                <label class="d-block">รหัสลูกค้า</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-icon">
                                            <select data-placeholder=" " class="custom-select" name="customer_number" id="customer_number">
                                                <option value=""> &nbsp; </option>
                                                @foreach ($customerList as $item)
                                                <option value="{{ $item->customer_number }}" @if($item->customer_number==$data->customer_number) selected @endif>{{ $item->customer_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8 mt-2 mt-md-0">
                                        <input type="text" class="form-control" disabled="" name="customer_name" id='customer_name' placeholder="" value="{{$data->customer_name}}">
                                        <input type="text" class="form-control" hidden name="customer_id" id='customer_id' placeholder="" value="{{$data->customer_id}}">
                                    </div>
                                </div><!--row-->
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3"> 
                            <div class="form-group">
                                <label class="d-block">วิธีการชำระเงิน</label>
                                {{-- <div class="input-icon"> --}}
                                    {{-- <input type="text" class="form-control" name="" placeholder="" value="Direct Debit Siam Commercial Bank"> --}}

                                    <select class="custom-select" name='payment_method'>
                                        @foreach ($payment_method as $type)
                                        <option value='{{$type->lookup_code}}' @if($type->lookup_code==$data->payment_method_code) selected @endif>{{$type->meaning}}</option> 
                                        @endforeach
                                    </select>
                                    {{-- <i class="fa fa-search"></i> 
                                </div> --}}
                            </div>
                        </div><!--col-->

                        <!--//-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">วันครบกำหนดชำระ</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control date" name="due_date" placeholder="" value="">
                                    <i class="fa fa-calendar"></i> 
                                </div>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">สั่งทาง</label>
                                <select class="custom-select" name='source_system'>
                                    <option @if($data->source_system=='E-Commerce') selected @endif>E-Commerce</option>
                                    <option @if($data->source_system=='EDI') selected @endif>EDI</option> 
                                    <option @if($data->source_system=='Email') selected @endif>Email</option> 
                                    <option @if($data->source_system=='Fax') selected @endif>Fax</option> 
                                    <option @if($data->source_system=='Line') selected @endif>Line</option> 
                                    <option @if($data->source_system=='Other') selected @endif>Other</option>   
                                </select>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">หมายเหตุสั่งทาง</label>
                                <input type="text" class="form-control" name="note_system" placeholder="" value="{{$data->remark_source_system}}">   
                            </div>
                        </div><!--col-->

                        <!--//-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group mw-100">
                                <label class="d-block">วันที่สั่ง</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control date" name="order_date" placeholder="" value="{{$data->creation_date}}">
                                    <i class="fa fa-calendar"></i> 
                                </div>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">หนี้ค้างชำระ</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="" placeholder="" value="" disabled>
                                    <i class="fa fa-search"></i> 
                                </div>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">ส่งโดย</label>
                                <select class="custom-select" name='ship_by'>
                                    @foreach($ship_by as $item)
                                        <option value='{{$item->lookup_code}}' @if($type->lookup_code==$data->transport_type_code) selected @endif>{{$item->meaning}}</option>    
                                    @endforeach 
                                </select>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3"></div>

                        <!--//-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">วันที่ส่ง</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control date" name="ship_date" placeholder="" value="{{$data->delivery_date}}">
                                    <i class="fa fa-calendar"></i> 
                                </div>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group mw-100">
                                <label class="d-block">ปีงบ/งวด</label>
                                <div class="row space-5">
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="year" id='year' placeholder="" value="{{$period->budget_year+543}}" readonly>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" name="period" id='period' placeholder="" value="{{$period->period_no}}" readonly>
                                    </div>
                                </div><!--row-->                                        
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">ประเภทการจ่ายเงิน</label>
                                <select class="custom-select" name='payment_type'>
                                    @foreach ($payment_type as $type)
                                    <option value='{{$type->lookup_code}}'  @if($type->lookup_code==$data->payment_type_code) selected @endif>{{$type->meaning}}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group mw-100">
                                <label class="d-block">กลุ่มวงเงินเชื่อ</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="" placeholder="" value="" id='contract_group_input'>

                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#contract_group_modal" id='open_contract_group_modal' hidden>Open Modal</button>

                                    <i class="fa fa-search"></i> 
                                </div>
                            </div>
                        </div><!--col-->

                        <!--//-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">Order Type</label>
                                <div class="input-icon">
                                    <select class="custom-select" name='order_type'>
                                        @foreach ($order_type as $type)
                                        <option value='{{$type->order_type_id}}'  @if($type->order_type_id==$data->order_type_id) selected @endif>{{$type->description}}</option> 
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">Bill To</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control" id='bill_to' placeholder="" value="{{$data->bill_to_site_id}}" readonly>
                                    <input type='hidden' id='bill_to_site_id' name='bill_to'>
                                </div>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">Ship To</label>
                                <div class="input-icon">
                                    <select class="custom-select" name='ship_to' id='ship_to'>
                                        <option value=""> &nbsp; </option>
                                        @foreach ($ship_to as $item)
                                        <option value='{{$item->ship_to_site_id}}'  @if($item->ship_to_site_id==$data->ship_to_site_id) selected @endif>{{$item->ship_to_site_name}}</option> 
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div><!--col-->

                        <div class="col-xl-3 col-md-6"> 
                            <div class="form-group">
                                <label class="d-block">Salesperson</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="" placeholder="" value="{{Auth::user()->name}}" readonly>
                                    <i class="fa fa-search"></i> 
                                </div>
                            </div>
                        </div><!--col-->

                        <!--//-->

                        <div class="col-xl-9"> 
                            <div class="form-group mw-100">
                                <label class="d-block">หมายเหตุรายการ</label>
                                <input type="text" class="form-control" name="note" placeholder="" value="{{$data->remark}}">
                            </div>
                        </div><!--col-->

                    </div><!--row-->                             
                </div><!--col-xl-6-->

                <div class="col-xl-12">
                    <hr class="lg">
                    <div class="form-header-buttons">
                        <div class="buttons multiple">
                            <button class="btn btn-md btn-success" type="button" id='addline' name='addline'><i class="fa fa-plus"></i> สร้าง</button> 
                            {{-- <button class="btn btn-md btn-primary" type="button"><i class="fa fa-save"></i> บันทึก</button> --}}
                        </div>
                    </div><!--form-header-buttons-->

                    <div class="hr-line-dashed"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center table-hover f13 min-1400">
                            <thead>
                                <tr class="align-middle">
                                    <th rowspan="2">รายการที่</th>
                                    <th colspan="2">ยอดส่งครั้งหลังสุด</th>
                                    <th rowspan="2" class="w-130">รหัสสินค้า</th>
                                    <th rowspan="2">ชื่อผลิตภัณฑ์</th>
                                    <th colspan="3">จำนวนที่สั่ง</th>
                                    <th colspan="3">อนุมัติสั่ง</th>
                                    <th rowspan="2">ราคาขาย/<br>พันมวน</th>
                                    <th rowspan="2">จำนวน</th>
                                    <th rowspan="2">โควต้า/งวด<br>(พันมวน)</th>
                                    <th rowspan="2">คงเหลือ/งวด<br>(พันมวน)</th>
                                    <th rowspan="2">คงคลังทั้งหมด<br>(พันมวน)</th>

                                    <th rowspan="2" style="width: 55px">ลบ</th>
                                </tr>
                                <tr class="align-middle">
                                    <!--ยอดส่งครั้งหลังสุด-->
                                    <th class="w-80"><small>วันที่</small></th>
                                    <th class="w-80"><small>พันมวน</small></th>

                                    <!--จำนวนที่สั่ง-->
                                    <th class="w-80"><small>หีบ</small></th>
                                    <th class="w-80"><small>ห่อ</small></th>
                                    <th class="w-80"><small>คิดเป็น<br>พันมวน</small></th>

                                     <!--อนุมัติสั่ง-->
                                    <th class="w-80"><small>หีบ</small></th>
                                    <th class="w-80"><small>ห่อ</small></th>
                                    <th class="w-80"><small>คิดเป็น<br>พันมวน</small></th>
                                </tr>
                            </thead>
                            <tbody id='line' name='line'>

                            </tbody>
                        </table>
                    </div><!--table-responsive-->

                    <div class="panel panel-default mt-4">
                        <div class="d-block m-auto" style="max-width:1000px">
                            <div class="row p-4">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block black">เงินสด</label>
                                        <input type="text" class="form-control text-right" disabled="" name="" placeholder="" value="0.00" id='cash_total'>
                                    </div>
                                </div><!--col-md-4-->

                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block black">เงินเชื่องวดนี้</label>
                                        <input type="text" class="form-control text-right" disabled="" name="" placeholder="" value="0.00" id='contract_total'>
                                    </div>
                                </div><!--col-md-4-->

                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block black">เงินคงเหลือ</label>
                                        <input type="text" class="form-control text-right" disabled="" name="" placeholder="" value="0.00" id='remaining_total'>
                                    </div>
                                </div><!--col-md-4-->

                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block black">จ่ายหนี้และค่าปรับงวดนี้</label>
                                        <input type="text" class="form-control text-right" disabled="" name="" placeholder="" value="0.00" id='debt_total'>
                                    </div>
                                </div><!--col-md-4-->

                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block black">รวมเงินที่ต้องชำระ</label>
                                        <input type="text" class="form-control text-right" disabled="" name="" placeholder="" value="0.00" id='total_price'>
                                    </div>
                                </div><!--col-md-4--> 

                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group mt-md-4 pt-md-3">
                                        {{-- <label class="d-block red"><strong>สินค้ากลุ่มเงินเชื่อ 3 เกินโควต้า 0.00</strong></label>  --}}
                                    </div>
                                </div><!--col-md-4-->

                                
                            </div><!--row-->
                        </div><!--d-block-->
                    </div><!--panel-->
                </div><!--col-xl-12-->
            </div><!--row-->

        </div><!--ibox-content-->
    </div><!--ibox-->

    <!-- Modal -->
    <div id="contract_group_modal" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">เลือกกลุ่มวงเงินเชื่อ</h4>
          </div>
          
          <table class="table table-bordered text-center table-hover f13" style='width:100%'> 
            <thead>
                <tr class="align-middle">
                    <th >เลือกรายการ</th>
                    <th>รายการที่</th>
                </tr>
            </thead>
            <tbody id='contract_group_table' name='contract_group_table'>
                @foreach ($contract_group as $contract)
                <tr>
                    <td><input type="checkbox" value="{{$contract->contract_group_id}}" name="contract_group_checkbox[]" id='contract_group_{{$contract->contract_group_id}}' onclick='toggle_contract_group({{$contract->contract_group_id}})'> </td>
                    <td>{{$contract->description}}</td>   
                </tr> 
                @endforeach
            </tbody>
        </table>
        </div>
    
      </div>
    </div>

</form>

@endsection

@section('scripts')

<script>
    let i = 0
    let line_item = []
    let all_contract_group = []
    let current_contract_group =[]
    let all_quota = []
    $(document).ready(function(){
        
        if('{{$data->order_status}}'=='Confirm') {
            $('#edit_prepare :input ').not("#cancel_prepare_order").not(document.getElementsByName('_token')).prop('disabled',true)
            $('#edit_prepare :select').prop('readonly',true)
            // $('#cancel_prepare_order').prop('disabled', false)
            $('#addline').prop('disabled',true)
            $('.date').prop('disabled',true)
        }
        // i = @json($line_item).length
        i=0;
        all_quota = @json($customer_quota);
        all_contract_group = @json($contract_group);
        @json($line_item).forEach(e=>{
            let html = $('#line').html()
            let onhand = 0
            let remaining = 0
            if (all_quota.find(_e=>_e.quota.find(__e=>__e.item_code==e.item_code))) {
                let _quota = all_quota.find(_e=>_e.quota.find(__e=>__e.item_code==e.item_code)).quota
                _quota = _quota.find(_e=>_e.item_code==e.item_code)
                console.log(_quota)
                remaining = _quota.remaining_quota
                onhand = _quota.onhand
            }
            console.log(e)
            html += `
                                <tr class="align-middle" name='line${i}' id='line${i}'>
                                    <td>${i}</td>
                                    <td>{{$data->creation_date}}</td>
                                    <td>10.00</td>
                                    <td>
                                        <div class="input-icon">
                                            <input type='hidden' name='item[${i}][type]' value='${e.order_line_id}'>
                                            <input type="text" class="form-control" name="item[${i}][code]" id='code${i}' placeholder="" value="${e.item_code}" onchange='line_code_change(${i})'>
                                            <i class="fa fa-search"></i> 
                                        </div>
                                    </td>
                                    <td class="text-left" name='item_name${i}' id='item_name${i}'>${e.item_description ? e.item_description : ''}</td>

                                    <td><input type="text" class="form-control md text-center" value="0" id='order_chest${i}' onchange='line_code_change(${i})'></td>
                                    <td><input type="text" class="form-control md text-center" value="0" id='order_wrap${i}' onchange='line_code_change(${i})'></td>
                                    <td id='show_line_order_amount${i}'>${display_number(e.order_quantity)}</td>

                                    <td><input type="text" class="form-control md text-center" value="0" id='approve_chest${i}' onchange='line_code_change(${i})'></td>
                                    <td><input type="text" class="form-control md text-center" value="0" id='approve_wrap${i}' onchange='line_code_change(${i})'></td>
                                    <td id='show_line_approve_amount${i}'>${display_number(e.approve_quantity)}</td>

                                    <td class="text-right" id='item_price${i}' name='item_price${i}'>${display_number(e.unit_price)}</td>
                                    <td class="text-right" id='item_amount${i}' name='item_amount${i}'>${display_number(e.order_quantity)}</td>
                                    <td class="text-right" id='item_all_quota${i}' name='id='item_all_quota${i}'>${display_number(remaining)}</td>

                                    <td class="text-right" id='item_remaining_quota${i}' name='item_remaining_quota${i}'>${display_number(remaining - e.order_quantity)}</td>

                                    <td class="text-right" id='item_remaining${i}' name='item_remaining${i}'>${display_number(onhand)}</td>

                                    <td><a class="fa fa-times red" onclick='del(${i})'></a></td>
                                    
                                    <input type='hidden' name='item[${i}][line_item_total_price]' id='line_item_total_price${i}' value='0'>
                                    <input type='hidden' name='item[${i}][line_order_amount]' id='line_order_amount${i}' value='0'>
                                    <input type='hidden' name='item[${i}][line_approve_amount]' id='line_approve_amount${i}' value='0'>
                                    <input type='hidden' name='item[${i}][item_id]' id='line_item_id${i}' value='0'>
                                    <input type='hidden' name='item[${i}][item_description]' id='line_item_description${i}' value='0'>
                                    <input type='hidden' name='item[${i}][credit_group]' id='line_credit_group${i}' value='0'>
                                    <input type='hidden' name='item[${i}][unit_price]' id='line_unit_price${i}' value='0'>
                                </tr>`
            $('#line').html(html)
            i++
        })
        $('#order_status').val($('#show_order_status').val()) 
        $('#show_order_status').change(()=>{
            $('#order_status').val($('#show_order_status').val())
        })
        $('.custom-select').chosen({width: "100%"});
        $('#contract_group_input').click(()=>{
            $('#open_contract_group_modal').click()
        })
        

        $('#customer_number').change(function()
        {
            let code = $('#customer_number').val();
            if (code != '') {
                fetch_new_user_info(code);
            }
        });
        // if($('#customer_code').val()!='') fetch_new_user_info($('#customer_code').val())
        $('.date').datepicker();
        // $('#customer_code').change(()=>{
        //     fetch_new_user_info($('#customer_code').val())
        // })
        $('#addline').click(()=>{
            let html = $('#line').html()
            html += `
                                <tr class="align-middle" name='line${i}' id='line${i}'>
                                    <td>3.1</td>
                                    <td>05/06/2563</td>
                                    <td>10.00</td>
                                    <td>
                                        <div class="input-icon">
                                            <input type='hidden' name='item[${i}][type]' value='0'>
                                            <input type="text" class="form-control" name="item[${i}][code]" id='code${i}' placeholder="" value="" onchange='line_code_change(${i})'>
                                            <i class="fa fa-search"></i> 
                                        </div>
                                    </td>
                                    <td class="text-left" name='item_name${i}' id='item_name${i}'>ไม่มีข้อมูล</td>

                                    <td><input type="text" class="form-control md text-center" value="0" id='order_chest${i}' onchange='line_code_change(${i})'></td>
                                    <td><input type="text" class="form-control md text-center" value="0" id='order_wrap${i}' onchange='line_code_change(${i})'></td>
                                    <td id='show_line_order_amount${i}'>0</td>

                                    <td><input type="text" class="form-control md text-center" value="0" id='approve_chest${i}' onchange='line_code_change(${i})'></td>
                                    <td><input type="text" class="form-control md text-center" value="0" id='approve_wrap${i}' onchange='line_code_change(${i})'></td>
                                    <td id='show_line_approve_amount${i}'>0</td>

                                    <td class="text-right" id='item_price${i}' name='item_price${i}'>0</td>
                                    <td class="text-right" id='item_amount${i}' name='item_amount${i}'>0</td>
                                    <td class="text-right" id='item_all_quota${i}' name='id='item_all_quota${i}'>0</td>

                                    <td class="text-right" id='item_remaining_quota${i}' name='item_remaining_quota${i}'>0</td>

                                    <td class="text-right" id='item_remaining${i}' name='item_remaining${i}'>0</td>

                                    <td><a class="fa fa-times red" onclick='del(${i})'></a></td>
                                    
                                    <input type='hidden' name='item[${i}][line_item_total_price]' id='line_item_total_price${i}' value='0'>
                                    <input type='hidden' name='item[${i}][line_order_amount]' id='line_order_amount${i}' value='0'>
                                    <input type='hidden' name='item[${i}][line_approve_amount]' id='line_approve_amount${i}' value='0'>
                                    <input type='hidden' name='item[${i}][item_id]' id='line_item_id${i}' value='0'>
                                    <input type='hidden' name='item[${i}][item_description]' id='line_item_description${i}' value='0'>
                                    <input type='hidden' name='item[${i}][credit_group]' id='line_credit_group${i}' value='0'>
                                    <input type='hidden' name='item[${i}][unit_price]' id='line_unit_price${i}' value='0'>
                                </tr>`

                $('#line').html(html)
                i++
        })
    });
    function del(i) {
        document.getElementById(`line${i}`).innerHTML = ''
    }    

    function line_code_change(i) {
        // $(`#name${i}`).html(line_item.find(e=>e.item_code==document.getElementById(`code${i}`).value).item_description ? line_item.find(e=>e.item_code==document.getElementById(`code${i}`).value).item_description : 'ไม่มีข้อมูล')
        // let item_name = 'ไม่มีข้อมูล'
        // line_item.forEach(e=>{
        //     console.log(e)
        //     if(e.item_code==document.getElementById(`code${i}`).value)
        //         item_name = e.item_description
        // })
        // document.getElementById(`name${i}`).innerHTML = item_name
        $(`#item_name${i}`).html('ไม่มีข้อมูล')
        $(`#item_price${i}`).html('0.00')
        $(`#item_all_quota${i}`).html('0.00')
        $(`#item_remaining_quota${i}`).html('0.00')
        $(`#item_remaining${i}`).html('0.00')
        $(`#line_item_total_price${i}`).val('0')

        $(`#line_order_amount${i}`).val(((parseFloat($(`#order_chest${i}`).val()) * 10000) + (parseFloat($(`#order_wrap${i}`).val()) * 200))/1000)
        $(`#line_approve_amount${i}`).val(((parseFloat($(`#approve_chest${i}`).val()) * 10000) + (parseFloat($(`#approve_wrap${i}`).val()) * 200))/1000)
        $(`#show_line_order_amount${i}`).html(display_number(((parseFloat($(`#order_chest${i}`).val()) * 10000) + (parseFloat($(`#order_wrap${i}`).val()) * 200))/1000))
        $(`#show_line_approve_amount${i}`).html(display_number(((parseFloat($(`#approve_chest${i}`).val()) * 10000) + (parseFloat($(`#approve_wrap${i}`).val()) * 200))/1000))
        
        if (all_quota.find(e=>e.quota.find(_e=>_e.item_code==document.getElementById(`code${i}`).value))) {
            let _quota = all_quota.find(e=>e.quota.find(_e=>_e.item_code==document.getElementById(`code${i}`).value)).quota
            console.log(_quota)
            _quota = _quota.find(e=>e.item_code==document.getElementById(`code${i}`).value)
            $(`#item_name${i}`).html(_quota.item_description)
            $(`#item_price${i}`).html(display_number(_quota.price_unit))
            $(`#item_amount${i}`).html(display_number(((parseFloat($(`#order_chest${i}`).val()) * 10000) + (parseFloat($(`#order_wrap${i}`).val()) * 200))/1000))
            // $(`#item_all_quota${i}`).html(_quota.received_quota)
            $(`#item_all_quota${i}`).html(display_number(_quota.remaining_quota))
            $(`#item_remaining_quota${i}`).html(display_number( _quota.remaining_quota - parseFloat($(`#item_amount${i}`).html())))
            $(`#item_remaining${i}`).html(display_number(_quota.onhand))

            $(`#line_item_total_price${i}`).val(((parseFloat($(`#order_chest${i}`).val()) * 10000) + (parseFloat($(`#order_wrap${i}`).val()) * 200))/1000 * _quota.price_unit)
            $(`#line_item_id${i}`).val(_quota.item_id)
            $(`#line_item_description${i}`).val(_quota.item_description)
            $(`#line_credit_group${i}`).val(_quota.credit_group_code)
            $(`#line_unit_price${i}`).val(_quota.price_unit)
        }
        calculatePrice();
    }

    function fetch_new_user_info (id) {
        swal('กำลังดึงข้อมูลลูกค้า...')
        $.ajax({
            url: "{{ route('om.ajax.order.prepare.fetch.customer') }}",
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                'key' : id
            },
            success: function (response) {
                console.log(response)
                let siteHtml = '<option value=""> &nbsp; </option>'
                let contract_groupHtml = ''
                all_contract_group = []
                current_contract_group = []
                all_quota = []
                response.sites.forEach(e=>{
                    siteHtml += `<option value='${e.ship_to_site_id}' >${e.ship_to_site_name}</option> `
                })
                response.contract_group.forEach(e=>{
                    contract_groupHtml += `<tr>
                        <td><input type="checkbox" value="${e.contract_group_id}" name="contract_group_checkbox[]" id='contract_group_${e.contract_group_id}' onclick='toggle_contract_group(${e.contract_group_id})'> </td>
                        <td>${e.description}</td>   
                        </tr> 
                    `
                })
                all_quota = response.quota
                all_contract_group = response.contract_group
                $('#contract_group_table').html(contract_groupHtml)
                $('#ship_to').html(siteHtml).trigger('chosen:updated');
                // $('#bill_to').html(siteHtml).trigger('chosen:updated');
                $('#bill_to').val(response.customer.bill_to_site_name)
                $('#bill_to_site_id').val(response.customer.bill_to_site_id)
                // $('#bill_to').val('response.customer.bill_to_site_name')
                $('#year').val(parseFloat(response.period.budget_year)+543)
                $('#period').val(response.period.period_no)
                $('#line').html('')
                $('#customer_id').val(response.customer.customer_id)
                $('#customer_name').val(response.customer.customer_name)
                swal("Success", 'สำเร็จ!', "success");
            },
            error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", 'ไม่สามารถเปลี่ยนแปลงข้อมูลได้', "error");
            }
            })
    }

    function toggle_contract_group (id) {
        current_contract_group = []
        console.log(all_contract_group)
        $.each($("input[id^='contract_group_']:checked"), function (K, V) {
            console.log(V.value)
            current_contract_group.push(all_contract_group.find(({contract_group_id})=>contract_group_id==V.value))
        });
        console.log(current_contract_group)
        calculatePrice()
    }

    function calculatePrice () {
        let priceSum = 0
        let sum = 0
        current_contract_group.forEach(e=>{
            sum += parseFloat(e.remaining_amount)
        })
        $.each($('input[id^="line_item_total_price"]'),(K,V)=>{
            priceSum += parseFloat(V.value)
        }) 
        $('#remaining_total').val(display_number(sum-priceSum))
        $('#contract_total').val(display_number(sum))
        $('#cash_total').val(display_number(priceSum-sum))
        $('#total_price').val(display_number(priceSum))
    }
    function display_number (number) {
        if(number <= 0)
            return 0
        else return Intl.NumberFormat().format(number)
    }
    function approve() {
        let is_going_to_end = false
        all_contract_group.forEach(e=>{
            if(parseInt(e.day_amount)<38){
                // alert('กำลังจะหมดเเล้วน้าาา')
                is_going_to_end = true
            }
        })
        if(is_going_to_end) alert('เงินเชื่อกำลังจะหมด')
        $('#order_status').val('Confirm')
        document.getElementById('edit_prepare').submit()
    }
    function cancel () {
        $('#order_status').prop('disabled',false)
        $('#order_status').val('Cancel')

        document.getElementById('edit_prepare').submit()

    }
</script>
