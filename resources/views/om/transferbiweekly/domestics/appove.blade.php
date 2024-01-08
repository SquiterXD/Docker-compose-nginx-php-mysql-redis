@extends('layouts.app')

@section('title', 'บันทึกประมาณการจำหน่ายรายปักษ์')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
<x-get-page-title :menu="$menu" url="" />
    {{-- <h2> <x-get-program-code url="/om/transfer-bi-weekly/domestic/approved" /> บันทึกประมาณการจำหน่ายรายปักษ์</h2> --}}
    {{-- <h2> OMP0056 บันทึกประมาณการจำหน่ายรายปักษ์</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active"> --}}
            {{-- <strong><x-get-program-code url="/om/transfer-bi-weekly/domestic/approved" /> บันทึกประมาณการจำหน่ายรายปักษ์</strong> --}}
            {{-- <strong>OMP0056 บันทึกประมาณการจำหน่ายรายปักษ์</strong>
        </li>
    </ol> --}}
@stop

@section('page-title-action')

@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            {{-- <h5>บันทึกประมาณการจำหน่ายรายปักษ์</h5> --}}
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4"><!--justify-content-md-center-->
                <div class="col-xl-12">
                    <div class="form-header-buttons">
                        <div class="buttons">
                            <button class="btn btn-md btn-primary" type="button" id="btn_save" onclick="approveBiWeek();"><i class="fa fa-save"></i> บันทึก</button>
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
                                    <input type="text" list="year_list" class="form-control"  name="budget_year" id="budget_year" onkeyup="year_import(this.value);version_import(this.value);" onchange="year_import(this.value);version_import(this.value);" placeholder="Ex: 2563">
                                    <datalist id="year_list">
                                        @foreach ($year_list as $item_year)
                                            <option value="{{ $item_year['year'] }}">{{ $item_year['year'] }}</option>
                                        @endforeach
                                    </datalist>
                                    {{-- <i class="fa fa-search"></i> --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">ครั้งที่  <span class="text-danger">*</span></label>
                                <div class="input-icon">
                                    <input type="text" list="version_list" class="form-control"  name="version" id="version" placeholder="Ex: 1" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');">
                                    <datalist id="version_list">

                                    </datalist>
                                </div>
                            </div>
                        </div><!--row-->
                    </div><!--form-group-->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="d-block">ปักษ์ <span class="text-danger">*</span></label>
                                <div class="input-icon">
                                    <input type="text" list="biweek" class="form-control"  name="biweekly_no" id="biweekly_no" placeholder="Ex: 1" value="1" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');">
                                    <datalist id="biweek" >

                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">ถึง <span class="text-danger">*</span></label>
                                <div class="input-icon">
                                    <input type="text" list="biweek_to" class="form-control"  name="biweekly_to" id="biweekly_to" placeholder="Ex: 24" value="24" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');">
                                    <datalist id="biweek_to" >

                                    </datalist>
                                </div>
                            </div>
                        </div><!--row-->
                    </div><!--form-group-->
                    <div class="form-group">
                        <label class="d-block">ระบุวันที่อนุมัติ <span class="text-danger">*</span></label>
                        <div class="input-icon">
                            <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="approve_date"
                                id="approve_date"
                                placeholder="โปรดเลือกวันที่"
                                value=""
                                format="DD/MM/YYYY"
                                >
                            {{-- <input type="text" class="form-control date"  name="approve_date" id="approve_date" placeholder=""> --}}
                            <i class="fa fa-calendar"></i>
                        </div>
                    </div><!--form-group-->
                    <div class="form-group">
                        <label class="d-block">สถานะ</label>
                        <input type="text" class="form-control" disabled id="approve_status" name="" placeholder="" value="">
                    </div><!--form-group-->
                    <div class="form-buttons no-border">
                        <button class="btn btn-lg btn-white" onclick="searchBiWeekly();" type="button"><i class="fa fa-search"></i> ค้นหา</button>
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
                    <div class="table-responsive">
                        <form id="save_data" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <table class="table table-bordered table-hover text-right">
                                <thead>
                                    <tr class="align-middle text-center" id="header">

                                    </tr>
                                </thead>
                                <tbody id="item_data">

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
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">รสชาติ</label>
                                <input type="text" class="form-control text-dark" disabled  id="taste" name="" placeholder="" value="" style="background-color: #999999;">
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

    function searchBiWeekly()
    {
        var budget_year     = $('#budget_year').val();
        var version         = $('#version').val();
        var biweekly_no     = $('#biweekly_no').val();
        var biweekly_to     = $('#biweekly_to').val();
        $('#close-btn-approve').hide();
        loading();
        $.ajax({
           url : '{{ url("om/ajax/transfer-bi-weekly/searchbiweekly") }}',
           type : 'post',
           data : {
                '_token'            : '{{ csrf_token() }}',
                'budget_year'       : budget_year,
                'version'           : version,
                'biweekly_no'       : biweekly_no,
                'biweekly_to'       : biweekly_to,
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
                    }else if(data.data.approve == 'ส่งข้อมูลแล้ว'){
                        $("#btn_save").prop('disabled',true);
                        $("#approve_date").prop('disabled',true);
                        $("#btn_factory").prop('disabled',true);
                    }else{
                        $("#btn_factory").prop('disabled',true);
                    }

                    if(data.data.detail.approve != ''){
                        $('#approve_date').val(data.data.detail.approve);
                    }

                    $('#approve_status').removeClass('text-warning');
                    $('#approve_status').removeClass('text-success');
                    $('#approve_status').removeClass('text-danger');
                    $('#approve_status').removeClass('text-info');
                    $('#approve_status').addClass(data.data.app_color);

                    var head = '<th>ตราหลัก/ตรารอง</th> <th class="w-201">ตรา</th>';
                    $.each(data.data.biweekly,function(key,val){
                         head +=    '<th>';
                         head +=    '    ปักษ์ '+key+'<br>';
                         head +=    '    ('+data.data.biweeklist[key]['date']+'/'+data.data.biweeklist[key]['mount']+'/'+data.data.biweeklist[key]['year']+')<br>';
                         head +=    '    '+data.data.biweeklist[key]['dayfotsale']+' วันขาย';
                         head +=    '    <input type="hidden" name="biweeky['+key+']" value="'+key+'">'
                         head +=    '</th>';
                    });

                    $("#header").html(head);

                     var item = '';
                    $.each(data.data.item,function(key_sort,val_sort){
                        $.each(val_sort,function(key_item,val_item){
                            // if(val_item.approve == 'Y'){
                            //     item +=    '<tr style="background-color:#808080;" onclick="showDetail('+"'"+val_item.taste+"'"+','+"'"+val_item.type_item+"'"+')" >';
                            // }else{
                                item +=    '<tr onclick="showDetail('+"'"+val_item.taste+"'"+','+"'"+val_item.type_item+"'"+')" >';
                            // }
                            item +=    '    <td class="text-center">'+val_item.type+'</td>';
                            item +=    '    <td class="text-left">'+val_item.item_description+'</td>';
                            var col_i = 1;
                            $.each(data.data.biweekly,function(key_biw,val_biw){
                                // if(val_biw[val_item.item_code].approve == 'Y'){
                                //     item    += '<td style="background-color:#808080;">';
                                // }else{
                                //     item    += '<td>';
                                // }
                                if(val_biw[val_item.item_code]){
                                    item    += '<td>';
                                        console.log(val_biw[val_item.item_code])
                                    if(val_biw[val_item.item_code].approve == 'Y'){
                                        // item    += '    <span onclick="showApprove('+"'"+val_biw[val_item.item_code].approve_date+"'"+')">'+val_biw[val_item.item_code].quantity+'</span>';
                                        item    += '<span onclick="showApprove('+"'"+val_biw[val_item.item_code].approve_date+"'"+')"> <input type="text" disabled class="form-control text-right" style="background-color: #1c84c6;color: white;" value="'+val_biw[val_item.item_code].quantity+'"></span>';
                                    }else{
                                        item    += '    <span> <input type="text" onkeypress="return isNumber(event);" class="form-control text-right qunti_'+val_biw[val_item.item_code].sales_forecast_id+'" data-id="'+val_biw[val_item.item_code].sales_forecast_id+'" onkeyup="inputChange('+col_i+')" data-value="'+val_biw[val_item.item_code].type+'"  id="input_col_'+col_i+'" name="input_col['+val_biw[val_item.item_code].sales_forecast_id+']" value="'+val_biw[val_item.item_code].quantity+'" ></span>';
                                        // item    += '    <span onclick="editData('+val_biw[val_item.item_code].sales_forecast_id+','+val_biw[val_item.item_code].quantity_change+')" style="cursor: pointer;">'+val_biw[val_item.item_code].quantity+'</span>';
                                    }
                                    item    += '</td>';
                                    col_i += 1;
                                }else{
                                    item    += '<td> 0.00 ';
                                    item    += '</td>';
                                }
                            });
                            item +=    '</tr>';
                        });
                    });

                    $.each(data.data.producttype,function(key_type,val_type){
                        item +=    '<tr>';
                        item +=    '    <td class="text-left" colspan="2" style="background-color: #f5f5f5"><strong class="black">ยอดรวม '+val_type.description+'</strong></td>';
                        if(data.data.total[key_type]){
                            var total_col_i = 1;
                            $.each(data.data.total[key_type],function(key_total_data,val_total_data){
                                item +=    '    <td id="total_col_'+key_type+'_'+total_col_i+'" data-value="'+key_type+'" >'+addCommas(val_total_data)+'</td>';
                                total_col_i += 1;
                            });
                        }else{
                            var total_col_i = 1;
                            $.each(data.data.biweekly,function(key,val){
                                item +=    '    <td id="total_col_'+key_type+'_'+total_col_i+'" data-value="'+key_type+'" >'+addCommas("0.00")+'</td>';
                                total_col_i += 1;
                            });
                        }

                        item +=    '</tr>';
                    });

                    $("#item_data").html(item);
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgApprove(data.data);
                    }else{
                        AlertToast('แจ้งเตือน','มีบางอย่างผิดพลาดกรุณาลองอีกครั้ง','error');
                    }
                    // $("#btn_factory").hide();
                    $("#approve_date").val('');
                    $("#approve_status").val('');
                    $("#header").html('');
                    $("#item_data").html('');
                    $("#taste").val('');
                    $("#type").val('');
                }
           }
        });
    }

    function approveBiWeek()
    {
        var budget_year     = $('#budget_year').val();
        var version         = $('#version').val();
        var biweekly_no     = $('#biweekly_no').val();
        var biweekly_to     = $('#biweekly_to').val();
        var approve_date    = $('#approve_date').val();

        const formdata = new FormData(document.getElementById("save_data"));
        formdata.append('budget_year',budget_year);
        formdata.append('version',version);
        formdata.append('biweekly_no',biweekly_no);
        formdata.append('biweekly_to',biweekly_to);
        formdata.append('approve_date',approve_date);

        // console.log(...formdata);

        loading();
        $.ajax({
            url         : '{{ url("om/ajax/transfer-bi-weekly/approved") }}',
            type        : 'post',
            data        : formdata,
            dataType    : 'json',
            cache       : false,
            processData : false,
            contentType : false,
            success : function(res){
                swal.close();
                var data = res.data;
                if(data.status){
                    if(approve_date){
                        AlertToast('สำเร็จ','อนุมัติแล้ว','success');
                    }else{
                        AlertToast('สำเร็จ','บันทึกแล้ว','success');
                    }
                    loading();
                    searchBiWeekly();
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

    function sendtoFactory()
    {
        var budget_year     = $('#budget_year').val();
        var version         = $('#version').val();
        var biweekly_no     = $('#biweekly_no').val();
        var biweekly_to     = $('#biweekly_to').val();

        const formdata = new FormData(document.getElementById("save_data"));
        formdata.append('budget_year',budget_year);
        formdata.append('version',version);
        formdata.append('biweekly_no',biweekly_no);
        formdata.append('biweekly_to',biweekly_to);


        loading()
        $.ajax({
            url         : '{{ url("om/ajax/transfer-bi-weekly/sendfactory") }}',
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
                    AlertToast('สำเร็จ','ส่งข้อมูลไปโรงงานเรียบร้อย','success');
                    loading();
                    searchBiWeekly();
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
        $.each($("input[name^=input_col][id^=input_col_"+col_index+"]"),function(idx,elem){
            var id = $(elem).data('id');
            data[$(elem).data('value')] = 0;
        });

        $.each($("input[name^=input_col][id^=input_col_"+col_index+"]"),function(idx,elem){
            var id = $(elem).data('id');
            var value = $(".qunti_"+id).val().toString().replace(/,/g, '');
            data[$(elem).data('value')] += parseFloat(value);
        });
        var output = [];
        $.each(data,function(key,val){
            if(val){
                $("#total_col_"+key+"_"+col_index).html(addCommas(val));
            }
        });
    }

    function showApprove(date)
    {
        Swal.fire({
            title: 'สถานะ : อนุมัติ',
            html: 'วันที่: '+date,// add html attribute if you want or remove
            allowOutsideClick: true,
            showCancelButton: false,
            showConfirmButton: true,
        });
    }

    function editData(id,quantity)
    {
        Swal.fire({
            title:  'เปลียนแปลงข้อมูล',
            html:   '<input type="number" id="swal-input1" class="swal2-input" value="'+ quantity +'">',// add html attribute if you want or remove
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
            AlertToast('แจ้งเตือน','กรุณากรอกจำนวน','error');
            return false;
        }
        loading();
        $.ajax({
            url : '{{ url("om/ajax/transfer-bi-weekly/savevalue") }}',
            type : 'post',
            data : {
                "_token"    : "{{ csrf_token() }}",
                id          : id,
                quantity    : quantity,
            },
            success : function(rest){
                swal.close();
                if(rest.status){
                    AlertToast('แจ้งเตือน','เปลียนแปลงสำเร็จ','success');
                    loading();
                    searchBiWeekly();
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

    function version_import(year){
        $.ajax({
            url         : '{{ url("om/ajax/transfer-bi-weekly/versionbiweek") }}',
            type        : 'post',
            data        : {
                year        : year,
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

    function year_import(year){
        $.ajax({
            url         : '{{ url("om/ajax/transfer-bi-weekly/yearbiweek") }}',
            type        : 'post',
            data        : {
                year        : year,
                type        : 'DOMESTIC',
                '_token'    : '{{ csrf_token() }}',
            },
            success : function(res)
            {
                var html = ''
                $.each(res['data'],function(key,val){
                    html += '<option value="'+val.biweekly_no+'" >'+val.budget_year+'</option>'
                });

                $("#biweek").html(html);
                $("#biweek_to").html(html);
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
            if (charCode > 31 && (charCode != 46 &&(charCode < 48 && charCode != 44 || charCode > 57)))
             return false;

          return true;
    }

    function addCommas(number)
    {
        // nStr += '';
        // x = nStr.split('.');
        // x1 = x[0];
        // x2 = x.length > 1 ? '.' + x[1] : '';
        // var rgx = /(\d+)(\d{3})/;
        // while (rgx.test(x1)) {
        //     x1 = x1.replace(rgx, '$1' + ',' + '$2');
        // }
        // return x1 + x2;
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


</script>
@stop
