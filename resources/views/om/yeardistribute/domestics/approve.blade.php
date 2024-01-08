@extends('layouts.app')

@section('title', 'บันทึกประมาณการจำหน่ายรายปี')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">

    <style>
        .table-wrapper { 
            overflow-x:scroll;
            overflow-y:visible;
            width:100%;
        }

        td, th {
            padding: 5px 20px;
            min-width: 220px;
        }

        /* th:first-child {
            position: fixed;
            left: 5px
        } */
    </style>
@stop

@section('page-title')
<x-get-page-title :menu="$menu" url="" />

    {{-- <h2><x-get-program-code url="/om/year-distribute/domestic/approved" /> บันทึกประมาณการจำหน่ายรายปี</h2> --}}
    {{-- <h2>OMP0060 บันทึกประมาณการจำหน่ายรายปี</h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>OMP0060 บันทึกประมาณการจำหน่ายรายปี</strong> --}}
            {{-- <strong><x-get-program-code url="/om/year-distribute/domestic/approved" /> บันทึกประมาณการจำหน่ายรายปี</strong> --}}

        {{-- </li>
    </ol> --}}
@stop

@section('page-title-action')

@stop

@section('content')
<div class="ibox">
    <div class="ibox-title">
        {{-- <h3>บันทึกประมาณการจำหน่ายรายปี</h3> --}}
    </div>
    <div class="ibox-content">
        <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">

            <div class="col-xl-12">
                <div class="form-header-buttons">
                    <div class="buttons">
                        <button class="btn btn-md btn-primary" type="button" id="btn_save" onclick="approveYearly();"><i class="fa fa-save"></i> บันทึก</button>
                        <button class="btn btn-md btn-success" type="button" id="btn_factory" onclick="sendtoFactory();" disabled><i class="fa fa-file-text-o"></i> ส่งข้อมูลให้ฝ่ายผลิต</button>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
            </div>

            <div class="col-xl-6 m-auto">

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="d-block">ปีงบประมาณ <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <input type="text" list="year_list"  class="form-control" autocomplete="off" onchange="version_import();" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');version_import();"   name="budget_year" id="budget_year" placeholder="" value="">
                                <datalist id="year_list">
                                    @foreach ($year_list as $item_year)
                                        <option value="{{ $item_year['year'] }}">{{ $item_year['year'] }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="d-block">ถึง <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <input type="text"  list="year_list_to"  class="form-control" autocomplete="off" onchange="version_import();" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');version_import();"  name="to_year" id="to_year" placeholder="" value="">
                                <datalist id="year_list_to">
                                    @foreach ($year_list as $item_year)
                                        <option value="{{ $item_year['year'] }}">{{ $item_year['year'] }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                    </div><!--row-->
                </div><!--form-group-->

                <div class="form-group">
                    <label class="d-block">ครั้งที่ <span class="text-danger">*</span></label>
                    <div class="input-icon">
                        <input type="text" list="version_list"  class="form-control"  name="version" id="version" autocomplete="off" placeholder="" value="" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');">
                        {{-- <i class="fa fa-search"></i>  --}}
                        <datalist id="version_list">

                        </datalist>
                    </div>
                </div>

                <div class="form-group">
                    <label class="d-block">ระบุวันที่อนุมัติ</label>
                    <div class="input-icon">
                        <datepicker-th
                            style="width: 100%"
                            class="form-control md:tw-mb-0 tw-mb-2 approve_date"
                            name="approve_date"
                            id="approve_date"
                            placeholder="โปรดเลือกวันที่"
                            value=""
                            format="DD/MM/YYYY"
                            >
                        {{-- <input type="text" class="form-control date"  name="" placeholder="" value="06/05/2498"> --}}
                        <i class="fa fa-calendar"></i>
                    </div>
                </div><!--form-group-->

                <div class="form-group">
                    <label class="d-block">บันทึกที่</label>
                    <input type="text" class="form-control"  name="approve_note" id="approve_note" placeholder="" value="">
                </div><!--form-group-->

                <div class="form-group">
                    <label class="d-block">สถานะ</label>
                    <input type="text" class="form-control red" disabled id="approve_status" placeholder="" value="">
                </div><!--form-group-->
                <div class="form-group">
                    <label class="d-block">แสดงผลเป็น</label>
                    <div class="input-icon">
                        <select name="show" id="show" class="custom-select">
                            <option value="quantity">จำนวน</option>
                            <option value="amount">มูลค่า</option>
                        </select>
                    </div>
                </div>

                <div class="form-buttons no-border">
                    <button class="btn btn-lg btn-white" onclick="searchYear();" type="button"><i class="fa fa-search"></i> ค้นหา</button>
                </div>
            </div><!--col-xl-6-->

            <div class="col-xl-12">
                <div class="alert alert-warning alert-dismissible print-error-msg-approve" id="close-btn-approve" style="display: none;">
                    <button type="button" class="close" onclick="$('#close-btn-approve').hide();">&times;</button>
                    <h5> Warning!</h5>
                    <ul></ul>
                </div>
                <hr class="lg">
                <div class="table-responsive">
                    <form id="save_data" autocomplete="off" enctype="multipart/form-data" class="table-wrapper">
                        @csrf
                        <table class="table table-bordered table-hover f13 text-right">
                            <thead id="head_tb">
                            
                            </thead>
                            <tbody id="body_tb">

                            </tbody>
                        </table>
                    </form>
                </div><!--table-responsive-->
            </div>

            <div class="col-xl-6 m-auto">
                <div class="row mt-5 mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-block">ประเภท</label>
                            <input type="text" class="form-control text-dark" disabled  id="type" name="" placeholder="" value="" style="background-color: #999999;">
                        </div><!--form-group-->
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-block">รสชาติ</label>
                            <input type="text" class="form-control text-dark" disabled id="taste"  name="" placeholder="" value="" style="background-color: #999999;">
                        </div><!--form-group-->
                    </div>
                </div><!--row-->
            </div>

        </div><!--row-->

    </div><!--ibox-content-->
</div><!--ibox-->
@endsection
@section('scripts')
<script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>
<script>
    $(document).ready(function(){
        $('.date').datepicker();
    });

    function searchYear()
    {
        var budget_year     = $('#budget_year').val();
        var budget_year_to  = $('#to_year').val();
        var version         = $("#version").val();
        var show            = $("#show").val();

        $('#close-btn-approve').hide();
        loading();
        $.ajax({
            url : '{{ url("om/ajax/year-distribute/searchyear") }}',
            type : 'post',
            data : {
                '_token'            : '{{ csrf_token() }}',
                'budget_year'       : budget_year,
                'budget_year_to'    : budget_year_to,
                'version'           : version
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    $("#approve_status").val(data.data.approve);

                    if(data.data.approve == 'อนุมัติ'){
                        $("#btn_factory").prop('disabled',false);
                        $("#approve_date").prop('disabled',true);
                        $("#btn_save").prop('disabled',true);
                        $("#approve_note").prop('disabled',true);
                        if(data.data.detail != 'false'){
                            deActiveDatePicker(data.data.detail.approve);
                        }
                    }else if(data.data.approve == 'ส่งข้อมูลแล้ว'){
                        $("#btn_save").prop('disabled',true);
                        $("#approve_date").prop('disabled',true);
                        $("#btn_factory").prop('disabled',true);
                        $("#approve_note").prop('disabled',true);
                        if(data.data.detail != 'false'){
                            deActiveDatePicker(data.data.detail.approve);
                        }
                    }else{;
                        $("#btn_factory").prop('disabled',true);
                    }

                    if(data.data.detail != 'false'){
                        $("#approve_note").val(data.data.detail.remark);
                    }

                    $('#approve_status').removeClass('text-warning');
                    $('#approve_status').removeClass('text-success');
                    $('#approve_status').removeClass('text-danger');
                    $('#approve_status').removeClass('text-info');
                    $('#approve_status').addClass(data.data.app_color);


                    var head = ' <tr class="align-middle text-center" >';
                    head    += '<th rowspan="2">ตรา</th>';
                    $.each(data.data.year_header,function(key_head,val_head){
                        head    +=    '<th> ปีงบประมาณ ' + val_head + '</th>';
                    });
                    head    += '</tr>';
                    $("#head_tb").html(head);
                    // head += '    <tr class="align-middle text-center" >';
                    // $.each(data.data.year_header,function(key_head,val_head){
                    //     head    +=    '<th> จำนวน </th>';
                    //     head    +=    '<th> มูลค่า </th>';
                    // });
                    // head    += '</tr>';

              

                    var item = '';
                    $.each(data.data.item,function(key_item,val_item){
                        // if(val_item.approve == 'Y'){
                        //     item +=    '<tr style="background-color:#808080;" onclick="showDetail('+"'"+val_item.taste+"'"+','+"'"+val_item.type+"'"+')" >';
                        // }else{
                        //     item +=    '<tr onclick="showDetail('+"'"+val_item.taste+"'"+','+"'"+val_item.type+"'"+')" >';
                        // }
                        item +=    '<tr onclick="showDetail('+"'"+val_item.taste+"'"+','+"'"+val_item.type+"'"+')" >';
                        item    += '<td class="text-left">'+ val_item.item_description +'</td>';

                        var col_i = 1;
                        $.each(data.data.year_header,function(key_year,val_year){
                            if(show == 'quantity'){  
                                if(data.data.data[val_item.item_code][key_year] != null) {
                                    if(data.data.data[val_item.item_code][key_year].approve == 'Y'){
                                        item    += '<td>';
                                        item    += '<span><input type="text" disabled class="form-control text-right" style="background-color: #1c84c6;color: white;" value="'+data.data.data[val_item.item_code][key_year].quantity+'"></span>';
                                    }else{
                                        item    += '<td>';
                                        // item    += '<span onclick="editData('+data.data.data[val_item.item_code][key_year].yearly_id+','+data.data.data[val_item.item_code][key_year].quantity+');" style="cursor: pointer;" >'+ data.data.data[val_item.item_code][key_year].quantity +'</span>';
                                        item    += '<span> <input type="text" onkeypress="return isNumber(event);"  class="form-control text-right qunti_'+data.data.data[val_item.item_code][key_year].yearly_id+'" data-id="'+data.data.data[val_item.item_code][key_year].yearly_id+'" onkeyup="inputChange('+col_i+')" data-value="'+data.data.data[val_item.item_code][key_year].type+'"  id="input_col_'+col_i+'_e" name="input_col_qunti['+data.data.data[val_item.item_code][key_year].yearly_id+']" value="'+data.data.data[val_item.item_code][key_year].quantity+'" ></span>';
                                    }
                                    item    += '</td>';
                                }else {
                                    console.error(data.data.data[val_item.item_code][key_year]  )
                                }
                               
                            //--------------------------------------------------------------------------------------------
                            }else{
                                if(data.data.data[val_item.item_code][key_year] != null) {
                                    if(data.data.data[val_item.item_code][key_year].approve == 'Y'){
                                        item    += '<td>';
                                        item    += '<span> <input type="text" disabled class="form-control text-right" style="background-color: #1c84c6;color: white;" value="'+data.data.data[val_item.item_code][key_year].amount+'"></span>';
                                    }else{
                                        item    += '<td>';
                                        // item    += '<span onclick="editData('+data.data.data[val_item.item_code][key_year].yearly_id+','+data.data.data[val_item.item_code][key_year].quantity+');" style="cursor: pointer;" >'+ data.data.data[val_item.item_code][key_year].quantity +'</span>';
                                        item    += '<span> <input type="text" onkeypress="return isNumber(event);"  class="form-control text-right amount_'+data.data.data[val_item.item_code][key_year].yearly_id+'" data-id="'+data.data.data[val_item.item_code][key_year].yearly_id+'" onkeyup="inputChangeAmount('+col_i+')" data-value="'+data.data.data[val_item.item_code][key_year].type+'"  id="input_col_amount_'+col_i+'_e" name="input_col_amount['+data.data.data[val_item.item_code][key_year].yearly_id+']" value="'+data.data.data[val_item.item_code][key_year].amount+'" ></span>';
                                    }
                                    item    += '</td>';
                                }
                               
                            }
                            col_i += 1;
                        });
                        item    += '</tr>';
                    });
                    lebalTotal = show=='amount' ? 'มูลค่า' : ''

                    $.each(data.data.producttype,function(key_type,val_type){
                        var total_col_i = 1;
                        item    += '<tr>';
                        item    += '<td class="text-left" style="background-color: #f5f5f5"><strong class="black"> ยอดรวม '+lebalTotal+' '+  val_type.description +'</strong></td>';
                        $.each(data.data.year_header,function(key_year_type,val_year_type){
                            if(show == 'quantity'){
                                if(data.data.total != ''){
                                    if(data.data.total[key_type]){
                                        if(data.data.total[key_type][key_year_type]){
                                            item    += '<td> <input type="text" class="form-control md text-right text-dark" style="background-color: #999999;" disabled id="total_col_'+key_type+'_'+total_col_i+'" data-value="'+key_type+'" value="'+ addCommas(data.data.total[key_type][key_year_type]) +'" ></td>';
                                        }else{
                                            item    += '<td><input type="text" class="form-control md text-right text-dark" style="background-color: #999999;" disabled id="total_col_'+key_type+'_'+total_col_i+'" data-value="'+key_type+'" value="0" ></td>';
                                        }
                                    }else{
                                        item    += '<td><input type="text" class="form-control md text-right text-dark" style="background-color: #999999;" disabled id="total_col_'+key_type+'_'+total_col_i+'" data-value="'+key_type+'" value="0" ></td>';
                                    }
                                }
                            }else{
                                if(data.data.total != ''){
                                    if(data.data.total[key_type]){
                                        if(data.data.total[key_type][key_year_type]){
                                            item    += '<td><input type="text" class="form-control md text-right text-dark" style="background-color: #999999;" disabled id="total_col_am_'+key_type+'_'+total_col_i+'" data-value="'+key_type+'" value="'+ addCommas(data.data.total_amount[key_type][key_year_type]) +'" ></td>';
                                        }else{
                                            item    += '<td><input type="text" class="form-control md text-right text-dark" style="background-color: #999999;" disabled id="total_col_am_'+key_type+'_'+total_col_i+'" data-value="'+key_type+'" value="0" ></td>';
                                        }
                                    }else{
                                        item    += '<td><input type="text" class="form-control md text-right text-dark" style="background-color: #999999;" disabled id="total_col_am_'+key_type+'_'+total_col_i+'" data-value="'+key_type+'" value="0" ></td>';
                                    }
                                }
                            }
                            total_col_i += 1;
                        });
                        item    += '</tr>';
                    });

                    $("#body_tb").html(item);
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgApprove(data.data);
                    }else{
                        AlertToast('แจ้งเตือน','มีบางอย่างผิดพลาดกรุณาลองอีกครั้ง','error');

                    }
                    // $("#btn_factory").hide();
                    $("#approve_date").val('');
                    $("#approve_note").val('');
                    $("#approve_status").val('');
                    $("#head_tb").html('');
                    $("#body_tb").html('');
                    $("#taste").val('');
                    $("#type").val('');
                }
            }
        });
    }

    function approveYearly()
    {
        var budget_year     = $('#budget_year').val();
        var budget_year_to  = $('#to_year').val();
        var approve_date    = $('#approve_date').val();
        var approve_note    = $("#approve_note").val();
        var version         = $("#version").val();
        var show            = $("#show").val();

        const formdata = new FormData(document.getElementById("save_data"));
        formdata.append('budget_year',budget_year);
        formdata.append('budget_year_to',budget_year_to);
        formdata.append('approve_note',approve_note);
        formdata.append('approve_date',approve_date);
        formdata.append('version',version);
        formdata.append('show',show);

        loading();
        $.ajax({
            url         : '{{ url("om/ajax/year-distribute/approved") }}',
            type        : 'post',
            data        : formdata,
            dataType    : 'json',
            cache       : false,
            processData : false,
            contentType : false,
            success : function(rest){
                swal.close();
                var data = rest.data;

                if(data.status){
                    if(approve_date){
                        AlertToast('สำเร็จ','อนุมัติแล้ว','success');
                    }else{
                        AlertToast('สำเร็จ','บันทึกแล้ว','success');
                    }
                    loading();
                    searchYear();
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgApprove(data.data);
                    }else{
                        AlertToast('แจ้งเตือน','มีบางอย่างผิดพลาดกรุณาลองอีกครั้ง','error');

                    }
                }
            }
        });
    }

    function inputChange(col_index)
    {
        var data = [];
        $.each($("input[name^=input_col_qunti][id^=input_col_"+col_index+"_e]"),function(idx,elem){
            var id = $(elem).data('id');
            data[$(elem).data('value')] = 0;
        });

        $.each($("input[name^=input_col_qunti][id^=input_col_"+col_index+"_e]"),function(idx,elem){

            var id = $(elem).data('id');
            var value = $(".qunti_"+id).val().toString().replace(/,/g, '');
            data[$(elem).data('value')] += parseFloat(value);
        });

        var output = [];
        var data_type = [];
        $.each(data,function(key,val){
            if(val){
                $("#total_col_"+key+"_"+col_index).val(addCommas(val));
            }
        });

    }

    function inputChangeAmount(col_index)
    {
        var data = [];
        $.each($("input[name^=input_col_amount][id^=input_col_amount_"+col_index+"_e]"),function(idx,elem){
            var id = $(elem).data('id');
            data[$(elem).data('value')] = 0;
        });

        $.each($("input[name^=input_col_amount][id^=input_col_amount_"+col_index+"_e]"),function(idx,elem){

            var id = $(elem).data('id');
            var value = $(".amount_"+id).val().toString().replace(/,/g, '');
            data[$(elem).data('value')] += parseFloat(value);
        });

        var output = [];
        $.each(data,function(key,val){
            if(val){
                $("#total_col_am_"+key+"_"+col_index).val(addCommas(val));
            }
        });
    }

    function sendtoFactory()
    {
        var budget_year     = $('#budget_year').val();
        var budget_year_to  = $('#to_year').val();
        var version         = $("#version").val();
        loading();
        $.ajax({
            url     : '{{ url("om/ajax/year-distribute/sendfactory") }}',
            type    : 'post',
            data    : {
                '_token'            : '{{ csrf_token() }}',
                'budget_year'       : budget_year,
                'budget_year_to'    : budget_year_to,
                'version'           : version
            },
            success : function(rest){
                swal.close();
                var data = rest.data;

                if(data.status){
                    AlertToast('สำเร็จ','ส่งข้อมูลไปโรงงานเรียบร้อย','success');
                    loading();
                    searchYear();
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgApprove(data.data);
                    }else{
                        AlertToast('แจ้งเตือน','มีบางอย่างผิดพลาดกรุณาลองอีกครั้ง','error');

                    }
                }
            }
        });
    }

    function editData(id,quantity)
    {
        Swal.fire({
            title:  'Change Data',
            html:   '<input type="number" id="swal-input1" class="swal2-input" value="'+ quantity +'">',// add html attribute if you want or remove
            focusConfirm: false,
            showCancelButton: true,
            preConfirm: () => {
                saveEditData(id,$("#swal-input1").val(),$("#swal-input2").val());
            }
        });
    }

    function saveEditData(id,quantity)
    {
        loading();
        $.ajax({
            url : '{{ url("om/ajax/year-distribute/savevalue") }}',
            type : 'post',
            data : {
                "_token"    : "{{ csrf_token() }}",
                id          : id,
                quantity    : quantity
            },
            success : function(rest){
                swal.close();
                if(rest.status){
                    AlertToast('สำเร็จ','บันทึกแล้ว','success');
                    loading();
                    searchYear();
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgApprove(data.data);
                    }else{
                        AlertToast('แจ้งเตือน','มีบางอย่างผิดพลาดกรุณาลองอีกครั้ง','error');

                    }
                }
            }
        });
    }

    function version_import(){
        var year    = $("#budget_year").val();
        var year_to = $("#to_year").val();
        $.ajax({
            url         : '{{ url("om/ajax/year-distribute/versionyear") }}',
            type        : 'post',
            data        : {
                year        : year,
                year_to     : year_to,
                type        : 'DOMESTIC',
                '_token'    : '{{ csrf_token() }}',
            },
            success : function(res)
            {
                var html = ''
                $.each(res['data'],function(key,val){
                    html += '<option value="'+val.version+'" >'+val.version+' ('+val.approve+')</option>'
                });

                $("#version_list").html(html);
            }
        });
    }

    function showDetail(taest,type)
    {
        $("#taste").val(taest);
        $("#type").val(type);
    }

    function loading()
    {
        Swal.fire({
            title: 'Please Wait !',
            html: 'data loading',// add html attribute if you want or remove
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });
    }

    function isNumber(evt){
        // e = e || window.event;
        // var charCode = e.which ? e.which : e.keyCode;
        // return /\d/.test(String.fromCharCode(charCode));
        var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
    }

    function addCommas(nStr)
    {
        nStr  = parseFloat(nStr).toFixed(2);
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function printErrorMsgApprove (msg) {
        $(".print-error-msg-approve").find("ul").html('');
        $(".print-error-msg-approve").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg-approve").find("ul").append('<li>'+value+'</li>');
        });
    }


    function AlertToast(header,detail,type)
    {
        if(type == 'success'){
            toastr.success(header, detail,{
                positionClass : "toast-top-center"
            });
        }else if(type == 'error'){
            toastr.error(header, detail,{
                positionClass : "toast-top-center"
            });
        }
    }

    function deActiveDatePicker(value_date)
    {
        var vue = new Vue({
            data(){
                return {
                    value  : value_date
                }
            },
            template:`
                <datepicker-th
                    disabled=""
                    style="width: 100%"
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data"
                    name="approve_date"
                    id="approve_date"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
            }
        }).$mount(".approve_date");
    }

</script>
@stop
