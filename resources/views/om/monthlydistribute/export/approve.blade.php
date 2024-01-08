@extends('layouts.app')

@section('title', 'บันทึกประมาณการจำหน่ายรายเดือน')

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
            min-width: 160px;
        }

        /* th:first-child {
            position: fixed;
            left: 5px
        } */
    </style>
@stop

@section('page-title')
    {{-- <h2> <x-get-program-code url="/om/monthly-distribute/domestic/approved" /> บันทึกประมาณการจำหน่ายรายเดือน</h2> --}}
    <h2> OMP0097 บันทึกประมาณการจำหน่ายรายเดือน สำหรับขายต่างประเทศ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong> OMP0097 บันทึกประมาณการจำหน่ายรายเดือน สำหรับขายต่างประเทศ</strong>
            {{-- <strong> <x-get-program-code url="/om/monthly-distribute/domestic/approved" /> บันทึกประมาณการจำหน่ายรายเดือน</strong> --}}
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h5>บันทึกประมาณการจำหน่ายรายเดือน สำหรับขายต่างประเทศ</h5>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4"><!--justify-content-md-center-->
                <div class="col-xl-12">
                    <div class="form-header-buttons">
                        <div class="buttons">
                            <button class="btn btn-md btn-primary" type="button" id="btn_save" onclick="approveMonthly();"><i class="fa fa-save"></i> บันทึก</button>
                            <button class="btn btn-md btn-success" type="button" id="btn_factory" onclick="sendtoFactory();" disabled><i class="fa fa-file-text-o"></i> ส่งข้อมูลให้ฝ่ายผลิต</button>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </div>
                <div class="col-xl-6 m-auto">
                    <form id="approv_form" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="d-block">ปีงบประมาณ <span class="text-danger">*</span></label>
                                <div class="input-icon">
                                    <input type="text" list="year_list" class="form-control"  name="budget_year" id="budget_year" onkeyup="version_import(this.value);" onchange="version_import(this.value);" placeholder="">
                                    <datalist id="year_list">
                                        @foreach ($year_list as $item_year)
                                            <option value="{{ $item_year['year'] }}">{{ $item_year['year'] }}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">ครั้งที่ <span class="text-danger">*</span></label>
                                <div class="input-icon">
                                    <input type="text" list="version_list" class="form-control"  name="version" id="version"  placeholder="">
                                    <datalist id="version_list">

                                    </datalist>
                                    {{-- <i class="fa fa-search"></i> --}}
                                </div>
                            </div>
                        </div><!--row-->
                    </div><!--form-group-->
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
                                onchange="searchMonthly();"
                                >
                            {{-- <input type="text" class="form-control date"  name="approve_date" id="approve_date" placeholder=""> --}}
                            <i class="fa fa-calendar"></i>
                        </div>
                    </div><!--form-group-->
                    <div class="form-group">
                        <label class="d-block">บันทึกที่</label>
                        <input type="text" class="form-control"  name="approve_note" id="approve_note" placeholder="" value="">
                    </div><!--form-group-->
                    <div class="form-group">
                        <label class="d-block">สถานะ</label>
                        <input type="text" class="form-control red" disabled id="approve_status" name="" placeholder="" value="">
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
                        <button class="btn btn-lg btn-white" onclick="searchMonthly();" type="button"><i class="fa fa-search"></i> ค้นหา</button>
                    </div>
                </form>
                </div><!--col-xl-6-->
                <div class="col-xl-12">
                    <div class="alert alert-warning alert-dismissible print-error-msg-approve" id="close-btn-approve" style="display: none;">
                        <button type="button" class="close" onclick="$('#close-btn-approve').hide();">&times;</button>
                        <h5> Warning!</h5>
                        <ul></ul>
                    </div>
                    <hr class="lg">
                    <div class="table-responsive outer">
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
                                <input type="text" class="form-control text-dark" disabled id="type" name="" placeholder="" value=""  style="background-color: #999999;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">รสชาติ</label>
                                <input type="text" class="form-control text-dark" disabled id="taste" name="" placeholder="" value=""  style="background-color: #999999;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>
<script>
    $(document).ready(function(){
        $('.date').datepicker();
    });

    function searchMonthly()
    {
        var budget_year     = $('#budget_year').val();
        var version         = $('#version').val();
        var approve_date    = $('#approve_date').val();
        var show            = $("#show").val();
        $('#close-btn-approve').hide();
        loading();
        $.ajax({
            url : '{{ url("om/ajax/monthly-distribute-export/searchmonthly") }}',
            type : 'post',
            data : {
                '_token'            : '{{ csrf_token() }}',
                'budget_year'       : budget_year,
                'version'           : version,
                'approve_date'      : approve_date,
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    $("#approve_status").val(data.data.approve);
                    if(data.data.approve == 'อนุมัติ'){
                        $("#btn_factory").removeAttr('disabled');
                        $("#approve_date").prop('disabled',true);
                        $("#btn_save").prop('disabled',true);
                        $("#approve_note").prop('disabled',true);
                        $("#budget_year").prop('disabled',true);
                        $("#version").prop('disabled',true);
                        deActiveDatePicker(data.data.detail.approve);
                    }else if(data.data.approve == 'ส่งข้อมูลแล้ว'){
                        $("#btn_save").prop('disabled',true);
                        $("#approve_date").prop('disabled',true);
                        $("#btn_factory").prop('disabled',true);
                        $("#approve_note").prop('disabled',true);
                        $("#budget_year").prop('disabled',true);
                        $("#version").prop('disabled',true);
                        deActiveDatePicker(data.data.detail.approve);
                    }else{
                        $("#btn_factory").attr('disabled','disabled');

                    }

                    $('#approve_status').removeClass('text-warning');
                    $('#approve_status').removeClass('text-success');
                    $('#approve_status').removeClass('text-danger');
                    $('#approve_status').removeClass('text-info');
                    $('#approve_status').addClass(data.data.app_color);


                    if(data.data.detail.approve != ''){
                        // deActiveDatePicker(data.data.detail.approve);
                        $('#approve_date').val(data.data.detail.approve);
                    }

                    $("#approve_note").val(data.data.detail.remark);
                    $('#approve_date').val(data.data.detail.approve);
                    var head = '<tr class="align-middle text-center" >';
                    head    += '<th class="fix" rowspan="2">ตรา</th>';
                    $.each(data.data.month_header_sort,function(key_head,val_head){
                        $.each(val_head,function(key_hnaem,val_hname){
                            head    +=    '<th>' + val_hname+ '</th>';
                        });
                    });
                    head += '<th>รวม</th> ';
                    head += '</tr> ';

                    // head += '<tr class="align-middle text-center" >';
                    //     $.each(data.data.month_header_sort,function(key_head,val_head){
                    //         $.each(val_head,function(key_hnaem,val_hname){
                    //             head    +=    '<th> จำนวน </th>';
                    //             head    +=    '<th> มูลค่า </th>';
                    //         });
                    //     });
                    //     head += '<th>จำนวน</th> ';
                    //     head += '<th>มูลค่า</th> ';
                    // head += '</tr> ';
                    $("#head_tb").html(head);

                    var item = '';
                    var item_roll = 1;
                    $.each(data.data.item,function(key_item,val_item){
                        // if(val_item.approve == 'Y'){
                        //     item    += '<tr onclick="showDetail('+"'"+val_item.taste+"'"+','+"'"+val_item.type+"'"+')" >';
                        // }else{
                            item +=    '<tr onclick="showDetail('+"'"+val_item.taste+"'"+','+"'"+val_item.type+"'"+')" >';
                        // }
                        item    += '<td class="text-left fix">'+ val_item.item_description +'</td>';
                        var col_i = 1;
                        $.each(data.data.month_header_sort,function(val_head_key,val_head_list){
                            $.each(val_head_list,function(key_month,val_month){
                                if(show == 'quantity'){  
                                    item    += '<td>';
                                    if(data.data.approve == 'อนุมัติ' || data.data.approve == 'ส่งข้อมูลแล้ว'){
                                        if(data.data.data[val_item.item_code][key_month]){
                                            item    += '<span><input type="text" disabled class="form-control" value="'+data.data.data[val_item.item_code][key_month].quantity+'"></span>';
                                        }else{
                                            item    += '<span> 0 </span>';
                                        }
                                    }else{
                                        if(data.data.data[val_item.item_code][key_month]){
                                            item    += '    <span> <input type="text" onkeypress="return isNumber(event);" class="form-control qunti_'+data.data.data[val_item.item_code][key_month].monthly_id+'" data-id="'+data.data.data[val_item.item_code][key_month].monthly_id+'" data-roll="'+item_roll+'" onkeyup="inputChange('+col_i+')" data-value="'+data.data.data[val_item.item_code][key_month].type+'"  id="input_col_'+col_i+'_e" name="input_col_qunti['+data.data.data[val_item.item_code][key_month].monthly_id+']" value="'+data.data.data[val_item.item_code][key_month].quantity+'" ></span>';
                                            // item    += '<span onclick="editData('+data.data.data[val_item.item_code][key_month].monthly_id+','+data.data.data[val_item.item_code][key_month].quantity+');" style="cursor: pointer;" >'+ data.data.data[val_item.item_code][key_month].quantity +'</span>';
                                        }else{
                                            item    += '<span> 0 </span>';
                                        }
                                    }
                                    item    += '</td>';
                                // ---------------------------------------------------------------------------------------------------
                                }else{
                                
                                    item    += '<td>';
                                    if(data.data.approve == 'อนุมัติ' || data.data.approve == 'ส่งข้อมูลแล้ว'){
                                        if(data.data.data[val_item.item_code][key_month]){
                                            item    += '<span><input type="text" disabled class="form-control" value="'+data.data.data[val_item.item_code][key_month].amount+'"></span>';
                                        }else{
                                            item    += '<span> 0 </span>';
                                        }
                                    }else{
                                        if(data.data.data[val_item.item_code][key_month]){
                                            item    += '    <span> <input type="text" onkeypress="return isNumber(event);" class="form-control amount_'+data.data.data[val_item.item_code][key_month].monthly_id+'" data-id="'+data.data.data[val_item.item_code][key_month].monthly_id+'" data-roll="'+item_roll+'" onkeyup="inputChangeAmount('+col_i+')" data-value="'+data.data.data[val_item.item_code][key_month].type+'"  id="input_col_amount_'+col_i+'_e" name="input_col_amount['+data.data.data[val_item.item_code][key_month].monthly_id+']" value="'+data.data.data[val_item.item_code][key_month].amount+'" ></span>';

                                            // item    += '<span onclick="editData('+data.data.data[val_item.item_code][key_month].monthly_id+','+data.data.data[val_item.item_code][key_month].quantity+');" style="cursor: pointer;" >'+ data.data.data[val_item.item_code][key_month].quantity +'</span>';
                                        }else{
                                            item    += '<span> 0 </span>';
                                        }
                                    }
                                    item    += '</td>';

                                }
                                col_i += 1;
                            });
                        });
                        // item    += '<td><span id="total_roll_q_'+item_roll+'">'+ data.data.total_item[val_item.item_code] +'</span></td><td><span id="total_roll_a_'+item_roll+'">'+ data.data.total_item_amount[val_item.item_code] +'</span></td>';
                        if(show == 'quantity'){  
                            item    += '<td><span id="total_roll_q_'+item_roll+'">'+ addCommas(data.data.total_item[val_item.item_code]) +'</span></td>';
                        }else{
                            item    += '<td><span id="total_roll_a_'+item_roll+'">'+ addCommas(data.data.total_item_amount[val_item.item_code]) +'</span></td>';
                        }
                        item    += '</tr>';

                        item_roll += 1;
                    });
                    lebalTotal = show=='amount' ? 'มูลค่า' : ''
                    $.each(data.data.producttype,function(key_type,val_type){
                        var total_col_i = 1;
                        var all_total = 0;
                        var all_amount = 0;
                        item    += '<tr>';
                        item    += '<td class="text-center" colspan="1" style="background-color: #f5f5f5"><strong class="black"> ยอดรวม '+lebalTotal+' '+ val_type.description +'</strong></td>';
                        $.each(data.data.month_header_sort,function(key_month_key,val_month_list){
                            $.each(val_month_list,function(key_month_type,val_month_type){
                                
                                if(data.data.total != ''){
                                    if(show == 'quantity'){ 
                                        if(data.data.total[key_type]){
                                            if(data.data.total[key_type][key_month_type]){
                                                all_total   += data.data.total[key_type][key_month_type];
                                                item    += '<td><input type="text" class="form-control md text-right text-dark" style="background-color: #999999;"  id="total_col_'+key_type+'_'+total_col_i+'" data-index="'+total_col_i+'" data-value="'+key_type+'" disabled="" value="'+ addCommas(data.data.total[key_type][key_month_type]) +'" name="sum_col_qu['+key_type+']"></td>';
                                            }else{
                                                item    += '<td><input type="text" class="form-control md text-right text-dark" style="background-color: #999999;"  id="total_col_'+key_type+'_'+total_col_i+'" data-index="'+total_col_i+'" data-value="'+key_type+'" disabled="" value="0" name="sum_col_qu['+key_type+']"></td>';
                                            }
                                        }else{
                                            item    += '<td><input type="text" class="form-control md text-right text-dark" style="background-color: #999999;"  id="total_col_'+key_type+'_'+total_col_i+'" data-index="'+total_col_i+'" data-value="'+key_type+'" disabled="" value="0" name="sum_col_qu['+key_type+']"></td>';
                                        }
                                    }else{
                                        if(data.data.total_amount[key_type]){
                                            if(data.data.total_amount[key_type][key_month_type]){
                                                all_amount  += data.data.total_amount[key_type][key_month_type];
                                                item    += '<td><input type="text" class="form-control md text-right  text-dark" style="background-color: #999999;"  id="total_col_am_'+key_type+'_'+total_col_i+'" data-index="'+total_col_i+'" data-value="'+key_type+'" disabled="" value="'+ addCommas(data.data.total_amount[key_type][key_month_type]) +'" name="sum_col_am['+key_type+']"></td>';
                                            }else{
                                                item    += '<td><input type="text" class="form-control md text-right text-dark" style="background-color: #999999;"  id="total_col_am_'+key_type+'_'+total_col_i+'" data-index="'+total_col_i+'" data-value="'+key_type+'" disabled="" value="0" name="sum_col_am['+key_type+']"></td>';
                                            }
                                        }else{
                                            item    += '<td><input type="text" class="form-control md text-right text-dark" style="background-color: #999999;"  id="total_col_am_'+key_type+'_'+total_col_i+'" data-index="'+total_col_i+'" data-value="'+key_type+'" disabled="" value="0" name="sum_col_am['+key_type+']"></td>';
                                        }
                                    }
                                }
                                total_col_i += 1;
                            });
                        });
                        // item    += '<td><span id="total_'+key_type+'">'+all_total+'</span></td> <td><span id="total_amount_'+key_type+'">'+all_amount+'</span></td>';
                        if(show == 'quantity'){ 
                            item    += '<td><span id="total_'+key_type+'">'+addCommas(all_total)+'</span></td>';
                        }else{
                            item    += '<td><span id="total_amount_'+key_type+'">'+addCommas(all_amount)+'</span></td>';
                        }
                        item    += '</tr>';
                    });
                    $("#body_tb").html(item);
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgApprove(data.data);
                    }else{
                        AlertToast('Waring','Someting Wrong please try again','error');
                    }
                    // $("#btn_factory").hide();
                    $("#btn_factory").attr('disabled','disabled');
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

    function approveMonthly()
    {
        var budget_year     = $('#budget_year').val();
        var version         = $('#version').val();
        var approve_date    = $('#approve_date').val();
        var approve_note    = $('#approve_note').val();
        var show            = $("#show").val();

        const formdata = new FormData(document.getElementById("save_data"));
        formdata.append('budget_year',budget_year);
        formdata.append('version',version);
        formdata.append('approve_note',approve_note);
        formdata.append('approve_date',approve_date);
        formdata.append('show',show);

        loading();
        $.ajax({
            url         : '{{ url("om/ajax/monthly-distribute-export/approved") }}',
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
                        AlertToast('Success','Approve Complete','success');
                    }else{
                        AlertToast('Success','Save Complete','success');
                    }
                    loading();
                    searchMonthly();
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgApprove(data.data);
                    }else{
                        AlertToast('Waring','Someting Wrong please try again','error');
                    }
                }
            }
        });
    }

    function inputChange(col_index)
    {
        var data = [];
        var roll = $("#input_col_"+col_index).data('roll');
        $.each($("input[name^=input_col_qunti][id^=input_col_"+col_index+"_e]"),function(idx,elem){
            var id = $(elem).data('id');
            data[$(elem).data('value')] = 0;
        });

        var q_totalroll = 0;
        $.each($("input[name^=input_col_qunti][data-roll^="+roll+"]"),function(idx,elem){
          var value_r = $(elem).val().toString().replace(/,/g, '');
           q_totalroll += parseFloat(value_r);
        });

        $("#total_roll_q_"+roll).html(addCommas(q_totalroll));

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
                var total_all = 0;
                $.each($("input[name^=sum_col_qu][data-value="+key+"]"),function(idx,elem){
                    var value_c = $(elem).val().toString().replace(/,/g, '');
                    total_all += parseFloat(value_c);
                });
                $("#total_"+key).html(addCommas(total_all));
            }
        });

    }

    function inputChangeAmount(col_index)
    {
        var data = [];
        var roll = $("#input_col_"+col_index).data('roll');
        $.each($("input[name^=input_col_amount][id^=input_col_amount_"+col_index+"_e]"),function(idx,elem){
            var id = $(elem).data('id');
            data[$(elem).data('value')] = 0;
        });

        var a_totalroll = 0;
        $.each($("input[name^=input_col_amount][data-roll^="+roll+"]"),function(idx,elem){
            var value_r = $(elem).val().toString().replace(/,/g, '');
           a_totalroll += parseFloat(value_r);
        });

        $("#total_roll_a_"+roll).html(addCommas(a_totalroll));

        $.each($("input[name^=input_col_amount][id^=input_col_amount_"+col_index+"_e]"),function(idx,elem){

            var id = $(elem).data('id');
            var value = $(".amount_"+id).val().toString().replace(/,/g, '');
            data[$(elem).data('value')] += parseFloat(value);
        });

        var output = [];
        $.each(data,function(key,val){
            if(val){
                $("#total_col_am_"+key+"_"+col_index).val(addCommas(val));
                var total_all = 0;
                $.each($("input[name^=sum_col_am][data-value="+key+"]"),function(idx,elem){
                    var value_c = $(elem).val().toString().replace(/,/g, '');
                    total_all += parseFloat(value_c);
                });
                $("#total_amount_"+key).html(addCommas(total_all));
            }
        });
    }

    function sendtoFactory()
    {
        var budget_year     = $('#budget_year').val();
        var version         = $('#version').val();
        var approve_date    = $('#approve_date').val();

        loading()
        $.ajax({
            url     : '{{ url("om/ajax/monthly-distribute-export/sendfactory") }}',
            type    : 'post',
            data    : {
                '_token'            : '{{ csrf_token() }}',
                'budget_year'       : budget_year,
                'version'           : version,
                'approve_date'      : approve_date,
            },
            success : function(rest){
                swal.close();
                var data = rest.data;

                if(data.status){
                    AlertToast('Success','Approve Complete','success');
                    loading();
                    searchMonthly();
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgApprove(data.data);
                    }else{
                        AlertToast('Waring','Someting Wrong please try again','error');
                    }
                }
            }
        });
    }

    function editData(id,quantity)
    {
        Swal.fire({
            title:  'Change Data',
            html:   '<input id="swal-input1" class="swal2-input" value="'+ quantity +'">',// add html attribute if you want or remove
            focusConfirm: false,
            showCancelButton: true,
            preConfirm: () => {
                saveEditData(id,$("#swal-input1").val());
            }
        });
    }

    function saveEditData(id,quantity)
    {
        if(quantity == ''){
            AlertToast('Waring','Plese enter input quantity','error');
            return false;
        }
        loading();
        $.ajax({
            url : '{{ url("om/ajax/monthly-distribute-export/savevalue") }}',
            type : 'post',
            data : {
                "_token"    : "{{ csrf_token() }}",
                id          : id,
                quantity    : quantity,
            },
            success : function(rest){
                swal.close();
                if(rest.status){
                    AlertToast('Success','Data Chagne Complete','success');
                    loading();
                    searchMonthly();
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgApprove(data.data);
                    }else{
                        AlertToast('Waring','Someting Wrong please try again','error');
                    }
                }
            }
        });
    }

    function version_import(year){
        $.ajax({
            url         : '{{ url("om/ajax/monthly-distribute-export/versionmonthly") }}',
            type        : 'post',
            data        : {
                year        : year,
                '_token'    : '{{ csrf_token() }}',
            },
            success : function(res)
            {
                var html = ''
                $.each(res['data'],function(key,val){
                    html += '<option value="'+val.version+'" >'+val.version+'  ('+val.approve+')</option>'
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

    function addCommas(number)
    {
        number  = parseFloat(number).toFixed(2);
        number  += '';
        x       = number.split('.');
        x1      = x[0];
        x2      = x.length > 1 ? '.' + x[1] : '';
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
