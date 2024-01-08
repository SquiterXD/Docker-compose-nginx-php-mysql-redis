@extends('layouts.app')
@section('title', 'Customer Domestic Broker')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">

    <style>
    .btn-primary {
        color: #fff !important;
        background-color: #1c84c6 !important;
        border-color: #1c84c6 !important;
    }
    </style>


@stop

@section('page-title')
    <h2><x-get-program-code url="/om/customers/domestics/broker" />	กำหนดรหัสนายหน้า สำหรับขายในประเทศ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/customers/domestics/broker" />	กำหนดรหัสนายหน้า สำหรับขายในประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h3>กำหนดรหัสนายหน้า สำหรับขายในประเทศ</h3>
        </div><!--ibox-title-->
        <div class="ibox-content">


           <div class="row space-50 justify-content-md-center mt-md-4"><!--justify-content-md-center-->
                <div class="col-xl-12">
                    <div class="form-header-buttons">
                        <h3 class="black">กำหนดรหัสนายหน้า สำหรับขายในประเทศ</h3>
                        <div class="buttons">
                            <button class="btn btn-lg btn-primary  w-160" onclick="addInputAgent();" type="button">สร้าง<small>Create</small></button>
                            <button class="btn btn-lg btn-success w-160" onclick="insertAgent();" type="button">บันทึก<small>Save</small></button>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <form id="form-agent" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                    <table class="table table-bordered table-mobile-column text-center">
                        <thead>
                            <tr class="d-none d-md-table-row">
                                <th width="15%">รหัสลูกค้า</th>
                                <th width="25%">ชื่อลูกค้า</th>
                                <th width="20%">รหัสนายหน้า</th>
                                <th width="65%">GL Code</th>
                                <th style="width: 55px">ลบ</th>
                            </tr>
                        </thead>
                        <tbody id="list_agent">

                        </tbody>
                    </table>
                    </form>
                    <div class="alert alert-warning alert-dismissible print-error-msg-agent" id="close-btn-agent" style="display: none;">
                        <button type="button" class="close" onclick="$('#close-btn-agent').hide();">&times;</button>
                        <h5> Warning!</h5>
                        <ul></ul>
                    </div>
                </div><!--col-xl-10-->
            </div><!--row-->
        </div><!--ibox-content-->
    </div><!--ibox-->
@endsection

@section('scripts')
<script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>
<script>
    var customer_list = [];
    var roll = 1;

    findCustomerList();

    function findCustomerList(){
        loading();
        $.ajax({
            url : '{{ url("om/ajax/customers/domestics/list") }}',
            type : 'post',
            data : {
                '_token'    : '{{ csrf_token() }}',
            },
            success:function(res){
                swal.close();
                var data = res.data
                customer_list = data;
                // var html = '';
                // html += '<option></option>';
                // $.each(data,function(key,val){
                //     html += '<option value="'+val.number+'">'+val.number+' '+val.name+'</option>';
                // });
                // $(".customer_list").html(html);
                $.each(customer_list,function(key,val){
                    if(val.agent_id){
                        addInputAgent(val.number);
                    }
                });
                // addInputAgent();
            }
        });
    }

    function addInputAgent(number)
    {
        var html = '';
        html += '<tr id="roll_'+roll+'" class="del_all">';
        html += '    <td>';
        html += '        <div class="form-group">';
        html += '            <label class="d-block d-md-none text-left">รหัสลูกค้า</label>';
        html += '            <div class="input-icon">';
        // html += '                <select class="form-control select2 input_form" width="100%" onchange="selectCustomer(this.value,'+roll+');"  id="input_customer_number_'+roll+'" placeholder="" value=""> ';
        // html += '                   <option value="" >--เลือก--</option>';
        // $.each(customer_list,function(key,val){
        //     html += '               <option value="'+val.number+'">'+val.number+' '+val.name+'</option>';
        // });
        // html += '                </select>';
        html += '                <input type="text" list="list_input_customer_number_'+roll+'" class="form-control input_form" width="100%" onkeyup="selectCustomer(this.value,'+roll+');" onchange="selectCustomer(this.value,'+roll+');"  id="input_customer_number_'+roll+'" placeholder="" value=""> ';
        html += '                <datalist id="list_input_customer_number_'+roll+'"> ';
        html += '                   <option value="" >--เลือก--</option>';
        $.each(customer_list,function(key,val){
            html += '               <option value="'+val.number+'">'+val.number+' '+val.name+'</option>';
        });
        html += '                </datalist>';
        html += '            </div>';
        html += '        </div>';
        html += '    </td>';
        html += '    <td>';
        html += '        <div class="form-group">';
        html += '            <label class="d-block d-md-none text-left">ชื่อลูกค้า</label>';
        html += '            <input type="text" class="form-control" disabled id="customer_name_'+roll+'" placeholder="" value="">';
        html += '            <input type="hidden" id="customer_id_'+roll+'" name="customer_id['+roll+']" >';
        html += '            <input type="hidden" id="agent_id_'+roll+'" name="agent_id['+roll+']" >';
        html += '        </div>';
        html += '    </td>';
        html += '    <td>';
        html += '        <div class="form-group">';
        html += '            <label class="d-block d-md-none text-left">รหัสนายหน้า</label>';
        html += '            <input type="text" list="list_agent_code_'+roll+'" class="form-control" width="100%" id="agent_code_'+roll+'_show" onkeyup="selectbk(this.value,'+roll+');" onchange="selectbk(this.value,'+roll+');" >';
        html += '            <datalist id="list_agent_code_'+roll+'"> ';
        html += '               <option value="">--เลือก--</option>';
        html += '               @foreach ($agentvendor as $vendor_item)';
        html += '                   <option value="{{ $vendor_item->vendor_code }}" data-value="{{ $vendor_item->vendor_id }}" >{{ $vendor_item->vendor_name }}</option>';
        html += '               @endforeach';
        html += '            </datalist>';
        html += '            <input type="hidden" id="agent_code_'+roll+'" name="agent_code['+roll+']" >';
        html += '        </div>';
        html += '    </td>';
        html += '    <td>';
        html += '        <div class="form-group">';
        html += '            <label class="d-block d-md-none text-left">GL Code</label>';
        html += '            <div class="input-icon text-left">';
        html += '               <select class="form-control select2 account_map_'+roll+'" width="100%" onchange="select_account(this.value,'+roll+');"  name="account_id['+roll+']" id="gl_code_'+roll+'"> ';
        html += '                  <option value=""> --เลือก-- </option>';
        html += '                      @foreach ($taxaccount as $item_taxaccount)';
        html += '                          <option class="option_{{ $item_taxaccount->account_id }}" value="{{ $item_taxaccount->account_id }}" data-value="{{$item_taxaccount->account_code}}" data-combine="{{ $item_taxaccount->account_code }}" data-combine_desc="{{ $item_taxaccount->description }}">{{$item_taxaccount->account_code}} {{$item_taxaccount->description}}</option>';
        html += '                      @endforeach'
        html += '               </select>';
        html += '                <input type="hidden" name="account_code['+roll+']" id="account_code_'+roll+'" >';
        html += '               <small class="text-left" id="combine_'+roll+'"></small>';
        html += '               <small class="text-left" id="combine_desc_'+roll+'"></small>';
        html += '            </div>';
        html += '        </div>';
        html += '    </td>';
        html += '    <td class="text-center"><a class="fa fa-times red" onclick="deleteAgent('+roll+');" href="javascript:(0);"></a></td>';
        html += '</tr>';

        $("#list_agent").append(html);
        $(".select2").select2();
        // findCustomerList();
        if(number){
            $('#input_customer_number_'+roll).val(customer_list[number].number).trigger('change');
            $(".input_form").prop('disabled',true);
        }
        roll +=1;
    }

    function selectCustomer(id,index)
    {
        if(id == ''){
            $("#customer_id_"+index).val('');
            $("#agent_id_"+index).val('');
            $("#customer_name_"+index).val('');
            $("#agent_code_"+index).val('').trigger('change');
            $("#account_id_"+index).val('');
            $("#gl_code_"+index).val('').trigger('change');
            $("#account_code_"+index).val('');
            $("#combine_"+index).html('');
            $("#combine_desc_"+index).html('');
            return false;
        }
        var data = customer_list[id];
        var sel  = true;
        $.each($('input[name^=customer_id]'),function(idx,elem){
            if($(elem).val() == data.id){
                $('#input_customer_number_'+index).val('').trigger('change');
                AlertToast('Waring','ลูกค้าถูกเลือกไปแล้ว','error');
                sel = false;
                return false;
            }
        });

        setTimeout(function(){
            if(data && sel){
                $("#customer_id_"+index).val(data.id);
                $("#agent_id_"+index).val(data.agent_id);
                $("#customer_name_"+index).val(data.name);
                $("#agent_code_"+index).val(data.agent_code);
                $("#agent_code_"+index+'_show').val(data.agent_code_lb).trigger('change');
                $("#account_id_"+index).val(data.acc_id);
                $("#gl_code_"+index).val(data.acc_id).trigger('change');
            }else{
                $("#customer_id_"+index).val('');
                $("#agent_id_"+index).val('');
                $("#customer_name_"+index).val('');
                $("#agent_code_"+index).val('').trigger('change');
                $("#account_id_"+index).val('');
                $("#gl_code_"+index).val('').trigger('change');
                $("#account_code_"+index).val('');
                $("#combine_"+index).html('');
                $("#combine_desc_"+index).html('');
            }
        },500);
    }

    function selectbk(value,index)
    {
        var bk_id = $('#list_agent_code_'+index+' option').filter(function() {
                return this.value == value;
            }).data('value');

        $("#agent_code_"+index).val(bk_id);
    }

    function select_account(id,index)
    {
        var datacode        = $(".option_"+id).data('value');
        var combine         = $(".option_"+id).data('combine');
        var combine_desc    = $(".option_"+id).data('combine_desc');

        $("#account_code_"+index).val(datacode);
        $("#combine_"+index).html(combine);
        $("#combine_desc_"+index).html(combine_desc);
    }

    function insertAgent()
    {
        loading();

        const formdata = new FormData(document.getElementById("form-agent"));

        $.ajax({
            url : '{{ url("om/ajax/customers/domestics/insertagent") }}',
            type : 'post',
            data : formdata,
            cache       : false,
            processData : false,
            contentType : false,
            success:function(res){
                swal.close();
                var data = res.data;
                if(res.status){
                    // location.reload();
                    $(".del_all").remove();
                    roll = 1;
                    findCustomerList();
                    $(".input_form").prop('disabled',true);
                    AlertToast('Success','Save Complete','success');
                }else{
                    if(res.type == 'validate'){
                        printErrorMsgAgent(data);
                    }else{
                        AlertToast('Waring','Someting Wrong please try again','error');
                    }
                }
            }
        });
    }

    function deleteAgent(index)
    {
        var id = $('#agent_id_'+index).val();
        if(id == ''){
            $("#roll_"+index).remove();
        }else{
            Swal.fire({
                title: 'คุณต้องการลบข้อมูล ?',
                showCancelButton: true,
                confirmButtonText: `ยืนยัน`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    loading();
                    $.ajax({
                        url : '{{ url("om/ajax/customers/domestics/remove") }}',
                        type : 'post',
                        data : {
                            '_token'    : '{{ csrf_token() }}',
                            id          : id
                        },
                        success:function(rest){
                            swal.close();
                            var data = rest.data;
                            if(data.status){
                                // $("#roll_"+index).remove();
                                $(".del_all").remove();
                                AlertToast('Success','Delete Complete','success');
                                roll = 1;
                                findCustomerList();
                            }else{
                                AlertToast('Waring','Someting Wrong please try again','error');
                            }
                        }
                    });
                }
            });
        }
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

    function printErrorMsgAgent(msg){
            $(".print-error-msg-agent").find("ul").html('');
            $(".print-error-msg-agent").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg-agent").find("ul").append('<li>'+value+'</li>');
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
