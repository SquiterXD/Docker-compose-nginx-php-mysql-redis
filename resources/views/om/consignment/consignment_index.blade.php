@extends('layouts.app')

@section('title', 'รายการฝากขายสโมสร')

@section('page-title')
    <h2>รายการฝากขายสโมสร</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>รายการฝากขายสโมสร</strong>
        </li>
    </ol>
@stop

<style>
    .search-selected {
        background-color: #ECECEC;
    }


</style>

@section('content')
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">

        
            <div class="ibox">
            <div id="loading" style="display:none; width:100%; height:100%; background-color: rgba(255, 255, 255, 0.5);  position:absolute; z-index:9; align-items:center;"  class="loading">
                <div class="spinner-border text-secondary" role="status" class="position: absolute;" style="margin-left:auto; margin-right:auto;">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
                <div class="ibox-title">
                    <h3>รายการฝากขายสโมสร</h3>
                </div>
                <div class="ibox-content"> 
                    <div class="row space-50 justify-content-md-center flex-column mt-md-4">

                        <form method="post" action="/om/consignment/save">

                        <div class="col-12">
                            <!-- Start Form -->
                            
                            @csrf
                            <div class="form-header-buttons">
                                <div class="buttons multiple">
                                    <a href="/om/consignment/create"><button class="btn btn-md btn-success" type="button"><i class="fa fa-plus"></i> สร้าง</button> </a>
                                    <button class="btn btn-md btn-white" type="button"  data-toggle="modal" data-target="#searchModal"><i class="fa fa-search"></i> ค้นหา</button>
                                    <button type="submit" formaction="/om/consignment/save/draft" class="btn btn-md btn-primary" ><i class="fa fa-save"></i> บันทึก</button>
                                    <button class="btn btn-md btn-info" type="submit" formaction="/om/consignment/save/confirm"><i class="fa fa-check"></i> ยืนยันข้อมูล</button>
                                    <button class="btn btn-md btn-success" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> ไฟล์แนบ</span></button>
                                    
                                </div>
                            </div><!--form-header-buttons-->

                            <div class="hr-line-dashed"></div>
                        </div><!--col-12-->

                        <div class="col-xl-10 m-auto">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label class="d-block">เลขที่ใบฝากขายสโมสร</label>
                                        <input type="text" class="form-control" readonly="readonly" name="header_consignment_id" id="consignment_id" placeholder="" value="{{ $headerId }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">  
                                        <label class="d-block">วันที่บันทึก</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control date" name="header_date" id="date" placeholder="" value="" required>
                                            <i class="fa fa-calendar"></i> 
                                        </div>
                                    </div><!--form-group-->
                                </div>

                                <input type="hidden" id="header_order_header_id" name="header_order_header_id" style="display:none;" value=""></input>
                                <input type="hidden" id="header_vat_percentage" name="header_vat_percentage" style="display:none;" value=""></input>
                                <input type="hidden" id="lines_count" name="lines_count" style="display:none;" value=""></input>

                                <div class="col-md-4">
                                    <div class="form-group">  
                                        <label class="d-block">Status</label>
                                        <input type="text" class="form-control" readonly="readonly" name="header_status" id="status" placeholder="" value="Draft">
                                    </div><!--form-group-->
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label class="d-block">ใบขนเลขที่</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control" id="search_release_num" name="header_pick_release_id" id="pick_release_id" placeholder="64C000048" value="">
                                            <i class="fa fa-search" id="search_release"></i> 
                                        </div>
                                    </div><!--form-group--> 
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">                                 
                                        <label class="d-block">วันที่ขน</label>
                                        <div class="input-icon">
                                            <input disabled type="text" class="form-control date" readonly="readonly" id="pick_release_date" name="header_pick_release_date" id="pick_release_date" placeholder="" value="">
                                            <i class="fa fa-calendar"></i> 
                                        </div>
                                    </div><!--form-group--> 
                                </div>

                                 <div class="col-md-8">
                                     <div class="form-group"> 
                                        <label class="d-block">รหัสลูกค้า</label>
                                        <div class="row space-5">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" readonly="readonly" id="customer_id" name="header_customer_id" placeholder="000000" value="">
                                            </div>
                                            <div class="col-md-8 mt-2 mt-md-0">
                                                <input type="text" class="form-control" readonly="readonly" id="customer_name" name="header_customer_name" placeholder="ชื่อลูกค้าสโมสร" value="">
                                            </div>
                                        </div><!--row-->
                                    </div><!--form-group-->  
                                 </div><!--form-group--> 
                            </div><!--row-->
                             
                            
                        </div><!--col-xl-6-->

                        <div class="col-md-12">
                            <hr class="lg"> 

                            <div class="table-responsive">
                                <table id="lines_table" class="table table-bordered text-center table-hover min-1000 f13"> 
                                    <thead>
                                        <tr class="align-middle"> 
                                            <th>ลำดับ</th>
                                            <th>รหัสผลิตภัณฑ์</th>
                                            <th>ชื่อผลิตภัณฑ์</th>
                                            <th>หน่วย</th>
                                            <th>จำนวน</th>
                                            <th class="w-160">มูลค่า</th> 
                                            <th>ยอดขายได้</th>
                                            <th>คงเหลือขาย</th>
                                            <th class="w-160">บันทึกยอดขาย</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_lines">
                                    </tbody>
                                        <!-- <tr class="align-middle">
                                            <td>1</td>
                                            <td>2337</td>
                                            <td>SMS(สีแดง)</td> 
                                            <td>U3 พันมวน</td> 
                                            <td class="text-right">120.00</td>
                                            <td class="text-right">333,000.00</td>
                                            <td class="text-right">120.00</td>
                                            <td class="text-right">0.00</td>
                                            <td><input type="text" class="form-control text-right" name="" value="120.00"></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>2</td>
                                            <td>2338</td>
                                            <td>SMS(สีเขียว)</td> 
                                            <td>U3 พันมวน</td> 
                                            <td class="text-right">80.00</td>
                                            <td class="text-right">222,000.00</td>
                                            <td class="text-right">80.00</td>
                                            <td class="text-right">0.00</td>
                                            <td><input type="text" class="form-control text-right" name="" value="80.00"></td>
                                        </tr> -->

                                        <tr class="align-middle">
                                            <td class="text-right" colspan="5"><strong>รวมมูลค่า</strong></td>
                                            <td>
                                                <input type="text" class="form-control text-right" readonly="readonly" id="total_amount" name="header_total_unit_price_amount" placeholder="" value="00.00">
                                            </td> 
                                            <td class="text-right" colspan="2"><strong>รวมยอดขายฝาก</strong></td>
                                            <td>
                                                <input type="text" id="grand_total" class="form-control text-right" readonly="readonly" name="total_quantity" placeholder="" value="00.00">
                                            </td> 
                                        </tr>

                                        <tr class="align-middle"> 
                                            <td class="text-right" colspan="8"><strong>รวมมูลค่าขายฝาก</strong></td>
                                            <td>
                                                <input type="text" class="form-control text-right" id="total_amount_lines" readonly="readonly" name="total_amount_lines" placeholder="" value="00.00">
                                            </td> 
                                        </tr>
 
                                    
                                </table> 
                            </div><!--table-responsive--> 

                        </div><!--col-md-12-->

                        </form>
                    </div><!--row-->
                </div><!--ibox-content-->
            </div><!--ibox-->

<!-- <div class="modal modal-600 fade" id="attachmentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button> 

            <div class="modal-header">
                <h3>Upload File</h3>
            </div>
            <div class="modal-body pt-4 pb-4">
                <div class="attachment-box">
                    <div class="form-group d-flex"> 
                        <div class="custom-file">
                            <input id="logo" type="file" class="custom-file-input">
                            <label for="logo" class="custom-file-label">Choose file...</label>
                        </div>
                        <div class="button">
                            <button class="btn btn-success">Submit</button>
                            <button class="btn btn-warning">Clear</button>
                        </div>
                    </div>  

                    <ul class="nav files">
                        <li>
                            <code><a href="https://gramickhouse.com/demo/kao/2021/05-mcr/OMP0038.html#"><i class="fa fa-file-pdf-o"></i>  เอกสาร1.pdf</a></code>
                            <button class="btn btn-remove"><i class="fa fa-times"></i></button>
                        </li>
                        <li>
                            <code><a href="https://gramickhouse.com/demo/kao/2021/05-mcr/OMP0038.html#"><i class="fa fa-file-pdf-o"></i>  เอกสาร2.pdf</a></code>
                            <button class="btn btn-remove"><i class="fa fa-times"></i></button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="modal-footer center mt-4">
                <button class="btn btn-gray btn-lg" type="button" data-dismiss="modal">
                    ปิด
                </button>
                <button class="btn btn-primary btn-lg" type="button" data-dismiss="modal">
                    ยืนยัน
                </button>
            </div>

        </div>
    </div>
</div> MOdal -->

<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-xl" >
        <div class="modal-content">
            <div id="loading-modal" style="display:none; width:100%; height:100%; background-color: rgba(255, 255, 255, 0.5);  position:absolute; z-index:9; align-items:center;"  class="loading">
                <div class="spinner-border text-secondary" role="status" class="position: absolute;" style="margin-left:auto; margin-right:auto;">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>


            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button> 

            <div class="modal-header">
                <h3>ค้นหา</h3>
            </div>
            <div class="modal-body pt-4 pb-4">
                
            <!-- Body Content -->

            <div class="col-xl-10 m-auto">
                <div class="row" style="margin:10px;"> 
                    <div class="col-3" style="display:flex; align-content:center; align-items:center;">
                        <label class="d-block" style="margin-left:auto;">เลขที่ใบฝากขายสโมสร</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="header_consignment_id" id="search_consignment_id" placeholder="" value="">
                    </div>
                </div>

                <div class="row" style="margin:10px;">
                    <div class="col-3" style="display:flex; align-content:center; align-items:center;">
                        <label class="d-block" style="margin-left:auto;">วันที่บันทึก</label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-icon">
                            <input type="text" class="form-control date" name="header_date" id="search_consignment_date" placeholder="" value="">
                            <i class="fa fa-calendar"></i> 
                        </div>
                    </div>
                </div>

                <div class="row" style="margin:10px;">
                    <div class="col-3" style="display:flex; align-content:center; align-items:center;">
                        <label class="d-block" style="margin-left:auto;">เลขที่ใบขน</label>
                    </div>
                    <div class="col-md-4">       
                        <div class="input-icon">
                            <input type="text" class="form-control" name="header_pick_release_id" id="search_pick_release_id" placeholder="64C000048" value="">
                        </div>
                    </div>
                </div>

                    <!-- <input type="hidden" id="header_order_header_id" name="header_order_header_id" style="display:none;" value=""></input>
                    <input type="hidden" id="header_vat_percentage" name="header_vat_percentage" style="display:none;" value=""></input>
                    <input type="hidden" id="lines_count" name="lines_count" style="display:none;" value=""></input> -->

                <div class="row" style="margin:10px;">
                    <div class="col-3" style="display:flex; align-content:center; align-items:center;">                       
                        <label class="d-block" style="margin-left:auto;">วันที่ขน</label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-icon">
                            <input type="text" class="form-control date" id="search_pick_release_date" name="header_pick_release_date" id="pick_release_date" placeholder="" value="">
                            <i class="fa fa-calendar"></i> 
                        </div>
                    </div>
                </div>
                <div class="row" style="margin:10px;">
                    <div class="col-3" style="display:flex; align-content:center; align-items:center;">
                        <label class="d-block" style="margin-left:auto;">รหัสลูกค้า</label>
                    </div>
                    <div class="col-md-8" style="display:flex;">
                            <div class="col-4" style="padding-left:0;">
                                <input type="text" class="form-control" id="search_customer_id" name="header_customer_id" placeholder="รหัสลูกค้าสโมสร" value="">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control"  id="search_customer_name" name="header_customer_name" placeholder="ชื่อลูกค้าสโมสร" value="">
                            </div>
                    </div>
                </div>

                <div class="row" style="margin:10px;">
                    <div class="col-3" style="display:flex; align-content:center; align-items:center;">
                        <label class="d-block" style="margin-left:auto;">Status</label>
                    </div>
                    <div class="col-md-4">
                        <select  name="search_status" id="search_status" class="custom-select">
                           <option value="Draft" selected>Draft</option>
                        </select>
                    </div>
                </div>

                <div class="row" style="margin:10px; margin-top:20px;">
                    <div class="col-3" style="display:flex; align-content:center; align-items:center;">
                        <div style="width:100%; opacity:0;">ค้นหา</div>
                    </div>
                    <div class="col-md-8" style="display:flex;">
                        <button class="btn btn-md btn-white" type="button" id="search_modal"><i class="fa fa-search"></i> ค้นหา</button>
                    </div>
                </div>
                    
                
            </div><!--col-xl-6-->

            <div class="m-auto" style="padding:0; margin:0; align-content:center;">
                <div class="table-responsive">
                    <table id="search_table" class="table table-bordered text-center table-hover min-1000 f13"> 
                        <thead>
                            <tr class="align-middle"> 
                                <th class="w-150">เลขที่ใบฝากขาย</th>
                                <th class="w-150">วันที่บันทึก</th>
                                <th class="w-150">เลขที่ใบขน</th>
                                <th class="w-150">วันที่ขน</th>
                                <th class="w-150">รหัสลูกค้า</th>
                                <th>ชื่อลูกค้า</th>
                            </tr>
                        </thead>
                        <tbody id="search_tbody">
                            <!-- <tr class="align-middle" id="testclick"> 
                                <td class="w-150">เลขที่ใบฝากขาย</td>
                                <td class="w-150">วันที่บันทึก</td>
                                <td class="w-150">เลขที่ใบขน</td>
                                <td class="w-150">วันที่ขน</td>
                                <td class="w-150">รหัสลูกค้า</td>
                                <td>ชื่อลูกค้า</td>
                            </tr> -->
                            <!--<tr class="align-middle search-selected" > 
                                <td class="w-150">เลขที่ใบฝากขาย</td>
                                <td class="w-150">วันที่บันทึก</td>
                                <td class="w-150">เลขที่ใบขน</td>
                                <td class="w-150">วันที่ขน</td>
                                <td class="w-150">รหัสลูกค้า</td>
                                <td>ชื่อลูกค้า</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- /Body Content -->

            </div><!--modal-body-->  

            <div class="modal-footer mt-4" style="display:inline-block;">
                <button class="btn btn-outline-danger" type="button" data-dismiss="modal" style="left:0;">
                    ยกเลิก
                </button>
                <button class="btn btn-primary" type="button" id="searchModalButton" data-dismiss="modal" style="float:right;">
                    ตกลง
                </button>
            </div>

        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal-->

@endsection

@section('scripts')
<script>
    $(document).ready(function(){ 

        $('#searchModal').modal({
            show : true
        });

        var lines_count=0;
        var total_amount = 0;

        $('.date').datepicker();

        $("#search_release").click(function(){
        //console.log("search");

        $('#loading').css('display', 'flex');

        var release_number = $("#search_release_num").val();
        //console.log(release_number);
        fetch('/om/consignment/searchPickRelease/'+release_number)
            .then(function (response) {
                return response.json() 
            })
            .then(function (data) {

                var total_count=0;   // count_total_quantity
                var order_header_id;

                //console.log(data); 
                //console.log(data['header'][0]); 

                    $('#date').val(data['consignment-date']);

                for(var i in data['header']){
                    //console.log("ลูกค้า"+data['header'][i].customer_id);
                    $('#customer_id').val(data['header'][i].customer_id);
                    $('#customer_name').val(data['header'][i].customer_name);
                    $('#header_order_header_id').val(data['header'][i].order_header_id);

                    order_header_id=data['header'][i].order_header_id;

                    fetch('/om/consignment/vatAmount/'+data['header'][i].customer_id)
                        .then(function(response){
                            return response.json() 
                        })
                        .then(function(vat){
                            
                            $('#header_vat_percentage').val(vat);
                            
                        });
                    
                    //customer_data

                    var pick_release_date_show = data['header'][i].pick_release_approve_date.substring(0, 9); 
                    //console.log("ttt="+pick_release_date_show)
                    $('#pick_release_date').val(pick_release_date_show);
                }

                $('.line').remove();
                
                for(var j in data['lines']){
                    
                    var amount = parseFloat(data['lines'][j].amount);
                    var order_quantity = parseFloat(data['lines'][j].order_quantity);

                    var prev_quan = data['prev_data'][j][0].previous_quantity;
                    if(prev_quan==null) prev_quan=order_quantity;

                    $('#lines_table>#tbody_lines').append(
                        '<tr class="line"><td>' + (parseInt(j, 10)+1) +
                        '</td><td>' + data['lines'][j].item_id  +
                        '</td><td>' + data['lines'][j].item_description +
                        '</td><td>' + data['lines'][j].uom +
                        '</td><td class="text-right">' + order_quantity.toLocaleString(undefined, {minimumFractionDigits: 2})  +
                        '</td><td class="text-right">' + amount.toLocaleString(undefined, {minimumFractionDigits: 2}) +
                        '</td><td class="text-right" id="text_prev_quantity_'+j+'" value="'+prev_quan+'">' + prev_quan +
                        '</td><td class="text-right" id="remain_quantity_'+j+'">' + '0.00' +
                        '</td><td>' + '<input type="text" name="sell_number[]" id="sell_number_'+j+'" class="form-control count-num form-control text-right" value="0" min="0" max="'+prev_quan+'" required></td></tr>' +

                            '<input style="display:none;" type="hidden" name="prev_quantity[]" id="prev_quantity_'+j+'" value="'+prev_quan+'"></input>'+
                            '<input style="display:none;" type="hidden" name="remain[]" id="remain_'+j+'" value="0"></input>'+
                            '<input style="display:none;" type="hidden" name="order_line_id[]" id="order_line_id_'+j+'" value="'+data['lines'][j].order_line_id+'"></input>'+
                            '<input style="display:none;" type="hidden" name="order_quantity[]" id="order_quantity_'+j+'" value="'+order_quantity+'"></input>'+
                            '<input style="display:none;" type="hidden" name="unit_price[]" id="unit_price_'+j+'" value="'+data['lines'][j].unit_price+'"></input>'+
                            '<input style="display:none;" type="hidden" name="item_id[]" id="item_id_'+j+'" value="'+data['lines'][j].item_id+'"></input>'+
                            '<input style="display:none;" type="hidden" name="item_description[]" id="item_description_'+j+'" value="'+data['lines'][j].item_description+'"></input>'+
                            '<input style="display:none;" type="hidden" name="item_code[]" id="item_code_'+j+'" value="'+data['lines'][j].item_code+'"></input>'+
                            '<input style="display:none;" type="hidden" name="order_line_id[]" id="order_line_id_'+j+'" value="'+data['lines'][j].order_line_id+'"></input>'
                    )
                        total_amount += amount;
                        lines_count++;

                }
                $('#loading').css('display', 'none');


                $(document).ready(function(){

                    var total_amount_each_lines=0;
                    
                    $(".count-num").change(function(){
                        //console.log('keyup');


                        $('.count-num').each(function(){
                            if(!isNaN($(this).val())){
                                total_count += parseInt($(this).val()); 
                                //console.log("total="+total_count);

                                var text_id = $(this).attr('id');
                                var id = text_id.replace('sell_number_', '')
                                
                                //console.log("id to change = "+id);
                                

                                var prev_val = $('#prev_quantity_'+id).val();
                                //console.log("test="+prev_val);
                                var remain_item = parseInt(prev_val) - parseInt($(this).val());
                                //console.log("remain= "+remain_item);

                                
                                $('#remain_quantity_'+id).html(remain_item);
                                $('#remain_'+id).val(remain_item);
                                //console.log("#remain_quantity_"+id+"="+remain_item);

                            }
                        });

                        
                        for(var n in data['lines']){
                            //console.log("koonPrice="+$("#sell_number_"+n).val());
                            //console.log("UnitPrice"+n+"="+$("#unit_price_"+n).val());
                            total_amount_each_lines += parseFloat($("#sell_number_"+n).val())*parseFloat($("#unit_price_"+n).val());
                        }

                        if((total_count)) {
                            $('#grand_total').val(total_count.toLocaleString(undefined, {minimumFractionDigits: 2}));
                            
                            $('#total_amount_lines').val(total_amount_each_lines.toLocaleString(undefined, {minimumFractionDigits: 2}));

                            
                            total_count=0;
                            total_amount_each_lines=0;
                        }
                        else {
                            $('#grand_total').val("00.00".toLocaleString(undefined, {minimumFractionDigits: 2}));
                            
                            $('#total_amount_lines').val("00.00".toLocaleString(undefined, {minimumFractionDigits: 2}));
                        }
                    });

                });

                $("#total_amount").val(total_amount.toLocaleString(undefined, {minimumFractionDigits: 2}));
                $("#lines_count").val(lines_count);
                total_amount=0;
                lines_count=0;
                
            });
        });

        
        $('#search_modal').click(function(){
            $('#loading-modal').css('display', 'flex');
            console.log('search'); 
            
            
            var search_consignment_id = $('#search_consignment_id').val();
            if(search_consignment_id=="") search_consignment_id=0;

            var search_pick_release_id = $('#search_pick_release_id').val();
            console.log("pick_no="+search_pick_release_id);
            if(search_pick_release_id=="") {
                console.log("NULL NA");
                search_pick_release_id=0;
            }
            var search_consignment_date = $('#search_consignment_date').val();
            if(search_consignment_date=="") search_consignment_date=0;
            else search_consignment_date = search_consignment_date.replace(/\//g, "-");
            
            var search_pick_release_date = $('#search_pick_release_date').val();
            if(search_pick_release_date=="") search_pick_release_date=0;
            else search_pick_release_date = search_pick_release_date.replace(/\//g, "-");

            var search_customer_id = $('#search_customer_id').val();
            if(search_customer_id=="") search_customer_id=0;

            var search_customer_name = $('#search_customer_name').val();
            if(search_customer_name=="") search_customer_name=0;

            var search_status = $('#search_status').val();
            if(search_status=="") search_status=0;

            console.log(search_consignment_id+'-'+search_pick_release_id+'-'+search_consignment_date+'-'+search_pick_release_date+'-'+search_customer_id+'-'+search_customer_name+'-'+search_status);

            fetch('/om/consignment/searchConsignmentData/'+search_consignment_id+'/'+search_consignment_date+'/'+search_pick_release_id+'/'+search_pick_release_date+'/'+search_customer_id+'/'+encodeURI(search_customer_name)+'/'+search_status,{
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(function (response) {
                return response.json() 
            })
            .then(function(searchData){
                console.log(searchData);
                $('.searchLine').remove();
                
                for(var s in searchData){
                    $('#search_table>#search_tbody').append(
                        '<tr class="align-middle searchLine">'+
                            '<td class="w-150" id="s_consignment_no">'+searchData[s].consignment_no+'</td>'+
                            '<td class="w-150" id="s_consignment_date">'+searchData[s].consignment_date.substring(0, 10)+'</td>'+
                            '<td class="w-150" id="s_pick_release_num">'+searchData[s].pick_release_num+'</td>'+
                            '<td class="w-150" id="s_pick_release_date">'+searchData[s].pick_release_date.substring(0, 10)+'</td>'+
                            '<td class="w-150" id="s_customer_id">'+searchData[s].customer_id+'</td>'+
                            '<td id="s_customer_name">'+searchData[s].customer_name+'</td>'+
                        '</tr>'
                    )
                }
            
                bindTrClick();
                bindTrDoubleClick();
                $('#loading-modal').css('display', 'none');
            })

            
        });
    
    // $('#searchModal').click(function(){
    //     fillFromSearch({
    //         "Test":"Yes"
    //     })
    // });
      
    
    //main ready function
    });
    var consignment_id_search;
    var consignment_date_search;
    var pick_number_search;
    var pick_date_search;
    var customer_id_search;
    var customer_name_search;
    var status_search;

    function bindTrClick(){
        $('.searchLine').click(function(){
            $('.search-selected').removeClass('search-selected');
            $(this).addClass("search-selected");
        });
    } 

    function bindTrDoubleClick(){
        $('.searchLine').dblclick(function(){

        //$('#loading-modal').css('display', 'none');


        $('#searchModal').modal('toggle');


        console.log("clicked");
        consignment_id_search = $('.search-selected>#s_consignment_no').html();
        consignment_date_search = $('.search-selected>#s_consignment_date').html();
        pick_number_search = $('.search-selected>#s_pick_release_num').html();
        pick_date_search = $('.search-selected>#s_pick_release_date').html();
        customer_id_search = $('.search-selected>#s_customer_id').html();
        customer_name_search = $('.search-selected>#s_customer_name').html();
        status_search = "Draft";

        $('#consignment_id').val(consignment_id_search);
        $('#date').val(consignment_date_search);
        $('#status').val(status_search);
        $('#search_release_num').val(pick_number_search);
        $('#pick_release_date').val(pick_date_search);
        $('#customer_id').val(customer_id_search);
        $('#customer_name').val(customer_name_search);

        $('#loading').css('display', 'flex');

        var release_number = pick_number_search;
        //console.log(release_number);
        fetch('/om/consignment/searchPickRelease/'+release_number)
            .then(function (response) {
                return response.json() 
            })
            .then(function (data) {

                var total_count=0;   // count_total_quantity
                var order_header_id;

                //console.log(data); 
                //console.log(data['header'][0]); 

                for(var i in data['header']){
                    //console.log("ลูกค้า"+data['header'][i].customer_id);
                    $('#customer_id').val(data['header'][i].customer_id);
                    $('#customer_name').val(data['header'][i].customer_name);
                    $('#header_order_header_id').val(data['header'][i].order_header_id);

                    order_header_id=data['header'][i].order_header_id;

                    fetch('/om/consignment/vatAmount/'+data['header'][i].customer_id)
                        .then(function(response){
                            return response.json() 
                        })
                        .then(function(vat){
                            
                            $('#header_vat_percentage').val(vat);
                            
                        });
                    
                    //customer_data

                    var pick_release_date_show = data['header'][i].pick_release_approve_date.substring(0, 9); 
                    //console.log("ttt="+pick_release_date_show)
                    $('#pick_release_date').val(pick_release_date_show);
                }

                $('.line').remove();
                
                for(var j in data['lines']){
                    
                    var amount = parseFloat(data['lines'][j].amount);
                    var order_quantity = parseFloat(data['lines'][j].order_quantity);

                    var prev_quan = data['prev_data'][j][0].previous_quantity;
                    if(prev_quan==null) prev_quan=order_quantity;

                    $('#lines_table>#tbody_lines').append(
                        '<tr class="line"><td>' + (parseInt(j, 10)+1) +
                        '</td><td>' + data['lines'][j].item_id  +
                        '</td><td>' + data['lines'][j].item_description +
                        '</td><td>' + data['lines'][j].uom +
                        '</td><td class="text-right">' + order_quantity.toLocaleString(undefined, {minimumFractionDigits: 2})  +
                        '</td><td class="text-right">' + amount.toLocaleString(undefined, {minimumFractionDigits: 2}) +
                        '</td><td class="text-right" id="text_prev_quantity_'+j+'" value="'+prev_quan+'">' + prev_quan +
                        '</td><td class="text-right" id="remain_quantity_'+j+'">' + '0.00' +
                        '</td><td>' + '<input type="text" name="sell_number[]" id="sell_number_'+j+'" class="count-num form-control text-right" value="0"></td></tr>' +

                            '<input style="display:none;" type="hidden" name="prev_quantity[]" id="prev_quantity_'+j+'" value="'+prev_quan+'"></input>'+
                            '<input style="display:none;" type="hidden" name="remain[]" id="remain_'+j+'" value="0"></input>'+
                            '<input style="display:none;" type="hidden" name="order_line_id[]" id="order_line_id_'+j+'" value="'+data['lines'][j].order_line_id+'"></input>'+
                            '<input style="display:none;" type="hidden" name="order_quantity[]" id="order_quantity_'+j+'" value="'+order_quantity+'"></input>'+
                            '<input style="display:none;" type="hidden" name="unit_price[]" id="unit_price_'+j+'" value="'+data['lines'][j].unit_price+'"></input>'+
                            '<input style="display:none;" type="hidden" name="item_id[]" id="item_id_'+j+'" value="'+data['lines'][j].item_id+'"></input>'+
                            '<input style="display:none;" type="hidden" name="item_description[]" id="item_description_'+j+'" value="'+data['lines'][j].item_description+'"></input>'+
                            '<input style="display:none;" type="hidden" name="item_code[]" id="item_code_'+j+'" value="'+data['lines'][j].item_code+'"></input>'+
                            '<input style="display:none;" type="hidden" name="order_line_id[]" id="order_line_id_'+j+'" value="'+data['lines'][j].order_line_id+'"></input>'
                    )
                        total_amount += amount;
                        lines_count++;

                }
                $('#loading').css('display', 'none');


                $(document).ready(function(){

                    var total_amount_each_lines=0;
                    
                    $(".count-num").change(function(){
                        //console.log('keyup');


                        $('.count-num').each(function(){
                            if(!isNaN($(this).val())){
                                total_count += parseInt($(this).val()); 
                                //console.log("total="+total_count);

                                var text_id = $(this).attr('id');
                                var id = text_id.replace('sell_number_', '')
                                
                                //console.log("id to change = "+id);
                                

                                var prev_val = $('#prev_quantity_'+id).val();
                                //console.log("test="+prev_val);
                                var remain_item = parseInt(prev_val) - parseInt($(this).val());
                                //console.log("remain= "+remain_item);

                                
                                $('#remain_quantity_'+id).html(remain_item);
                                $('#remain_'+id).val(remain_item);
                                //console.log("#remain_quantity_"+id+"="+remain_item);

                            }
                        });

                        
                        for(var n in data['lines']){
                            //console.log("koonPrice="+$("#sell_number_"+n).val());
                            //console.log("UnitPrice"+n+"="+$("#unit_price_"+n).val());
                            total_amount_each_lines += parseFloat($("#sell_number_"+n).val())*parseFloat($("#unit_price_"+n).val());
                        }

                        if((total_count)) {
                            $('#grand_total').val(total_count.toLocaleString(undefined, {minimumFractionDigits: 2}));
                            
                            $('#total_amount_lines').val(total_amount_each_lines.toLocaleString(undefined, {minimumFractionDigits: 2}));

                            
                            total_count=0;
                            total_amount_each_lines=0;
                        }
                        else {
                            $('#grand_total').val("00.00".toLocaleString(undefined, {minimumFractionDigits: 2}));
                            
                            $('#total_amount_lines').val("00.00".toLocaleString(undefined, {minimumFractionDigits: 2}));
                        }
                    });

                });

                $("#total_amount").val(total_amount.toLocaleString(undefined, {minimumFractionDigits: 2}));
                $("#lines_count").val(lines_count);
                total_amount=0;
                lines_count=0;

            });
        });
    } 

   

    
    $('#searchModalButton').click(function(){
        
        consignment_id_search = $('.search-selected>#s_consignment_no').html();
        consignment_date_search = $('.search-selected>#s_consignment_date').html();
        pick_number_search = $('.search-selected>#s_pick_release_num').html();
        pick_date_search = $('.search-selected>#s_pick_release_date').html();
        customer_id_search = $('.search-selected>#s_customer_id').html();
        customer_name_search = $('.search-selected>#s_customer_name').html();
        status_search = "Draft";

        $('#consignment_id').val(consignment_id_search);
        $('#date').val(consignment_date_search);
        $('#status').val(status_search);
        $('#search_release_num').val(pick_number_search);
        $('#pick_release_date').val(pick_date_search);
        $('#customer_id').val(customer_id_search);
        $('#customer_name').val(customer_name_search);

        $('#loading').css('display', 'flex');

        var release_number = pick_number_search;
        //console.log(release_number);
        fetch('/om/consignment/searchPickRelease/'+release_number)
            .then(function (response) {
                return response.json() 
            })
            .then(function (data) {

                var total_count=0;   // count_total_quantity
                var order_header_id;

                //console.log(data); 
                //console.log(data['header'][0]); 

                for(var i in data['header']){
                    //console.log("ลูกค้า"+data['header'][i].customer_id);
                    $('#customer_id').val(data['header'][i].customer_id);
                    $('#customer_name').val(data['header'][i].customer_name);
                    $('#header_order_header_id').val(data['header'][i].order_header_id);

                    order_header_id=data['header'][i].order_header_id;

                    fetch('/om/consignment/vatAmount/'+data['header'][i].customer_id)
                        .then(function(response){
                            return response.json() 
                        })
                        .then(function(vat){
                            
                            $('#header_vat_percentage').val(vat);
                            
                        });
                    
                    //customer_data

                    var pick_release_date_show = data['header'][i].pick_release_approve_date.substring(0, 9); 
                    //console.log("ttt="+pick_release_date_show)
                    $('#pick_release_date').val(pick_release_date_show);
                }

                $('.line').remove();
                
                for(var j in data['lines']){
                    
                    var amount = parseFloat(data['lines'][j].amount);
                    var order_quantity = parseFloat(data['lines'][j].order_quantity);

                    var prev_quan = data['prev_data'][j][0].previous_quantity;
                    if(prev_quan==null) prev_quan=order_quantity;

                    $('#lines_table>#tbody_lines').append(
                        '<tr class="line"><td>' + (parseInt(j, 10)+1) +
                        '</td><td>' + data['lines'][j].item_id  +
                        '</td><td>' + data['lines'][j].item_description +
                        '</td><td>' + data['lines'][j].uom +
                        '</td><td class="text-right">' + order_quantity.toLocaleString(undefined, {minimumFractionDigits: 2})  +
                        '</td><td class="text-right">' + amount.toLocaleString(undefined, {minimumFractionDigits: 2}) +
                        '</td><td class="text-right" id="text_prev_quantity_'+j+'" value="'+prev_quan+'">' + prev_quan +
                        '</td><td class="text-right" id="remain_quantity_'+j+'">' + '0.00' +
                        '</td><td>' + '<input type="text" name="sell_number[]" id="sell_number_'+j+'" class="count-num form-control text-right" value="0"></td></tr>' +

                            '<input style="display:none;" type="hidden" name="prev_quantity[]" id="prev_quantity_'+j+'" value="'+prev_quan+'"></input>'+
                            '<input style="display:none;" type="hidden" name="remain[]" id="remain_'+j+'" value="0"></input>'+
                            '<input style="display:none;" type="hidden" name="order_line_id[]" id="order_line_id_'+j+'" value="'+data['lines'][j].order_line_id+'"></input>'+
                            '<input style="display:none;" type="hidden" name="order_quantity[]" id="order_quantity_'+j+'" value="'+order_quantity+'"></input>'+
                            '<input style="display:none;" type="hidden" name="unit_price[]" id="unit_price_'+j+'" value="'+data['lines'][j].unit_price+'"></input>'+
                            '<input style="display:none;" type="hidden" name="item_id[]" id="item_id_'+j+'" value="'+data['lines'][j].item_id+'"></input>'+
                            '<input style="display:none;" type="hidden" name="item_description[]" id="item_description_'+j+'" value="'+data['lines'][j].item_description+'"></input>'+
                            '<input style="display:none;" type="hidden" name="item_code[]" id="item_code_'+j+'" value="'+data['lines'][j].item_code+'"></input>'+
                            '<input style="display:none;" type="hidden" name="order_line_id[]" id="order_line_id_'+j+'" value="'+data['lines'][j].order_line_id+'"></input>'
                    )
                        total_amount += amount;
                        lines_count++;

                }
                $('#loading').css('display', 'none');


                $(document).ready(function(){

                    var total_amount_each_lines=0;
                    
                    $(".count-num").change(function(){
                        //console.log('keyup');


                        $('.count-num').each(function(){
                            if(!isNaN($(this).val())){
                                total_count += parseInt($(this).val()); 
                                //console.log("total="+total_count);

                                var text_id = $(this).attr('id');
                                var id = text_id.replace('sell_number_', '')
                                
                                //console.log("id to change = "+id);
                                

                                var prev_val = $('#prev_quantity_'+id).val();
                                //console.log("test="+prev_val);
                                var remain_item = parseInt(prev_val) - parseInt($(this).val());
                                //console.log("remain= "+remain_item);

                                
                                $('#remain_quantity_'+id).html(remain_item);
                                $('#remain_'+id).val(remain_item);
                                //console.log("#remain_quantity_"+id+"="+remain_item);

                            }
                        });

                        
                        for(var n in data['lines']){
                            //console.log("koonPrice="+$("#sell_number_"+n).val());
                            //console.log("UnitPrice"+n+"="+$("#unit_price_"+n).val());
                            total_amount_each_lines += parseFloat($("#sell_number_"+n).val())*parseFloat($("#unit_price_"+n).val());
                        }

                        if((total_count)) {
                            $('#grand_total').val(total_count.toLocaleString(undefined, {minimumFractionDigits: 2}));
                            
                            $('#total_amount_lines').val(total_amount_each_lines.toLocaleString(undefined, {minimumFractionDigits: 2}));

                            
                            total_count=0;
                            total_amount_each_lines=0;
                        }
                        else {
                            $('#grand_total').val("00.00".toLocaleString(undefined, {minimumFractionDigits: 2}));
                            
                            $('#total_amount_lines').val("00.00".toLocaleString(undefined, {minimumFractionDigits: 2}));
                        }
                    });

                });

                $("#total_amount").val(total_amount.toLocaleString(undefined, {minimumFractionDigits: 2}));
                $("#lines_count").val(lines_count);
                total_amount=0;
                lines_count=0;

            });

    });
    

    // function fillFromSearch (data = {}){
    //     fetch('/om/consignment/fillData', {
    //         method: 'POST', 
    //         headers: {
    //             'Content-Type': 'application/json',
    //         },
    //         body: JSON.stringify(data),
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         console.log('Success:', data);
    //     })
    //     .catch((error) => {
    //         console.error('Error:', error);
    //     });
    // }


    
</script>
 
@endsection
