@extends('layouts.app')

@section('title', 'Export Costomer')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <style>
        #page-wrapper {
            width: calc(100% - 220px) !important;
        }
    </style>
@stop

@section('page-title')
    <h2>
         {{-- <x-get-program-code url="/om/customers/exports" />  --}}
        OMM0004 : ค้นหาลูกค้า สำหรับขายต่างประเทศ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.html">หน้าหลัก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>
                 {{-- <x-get-program-code url="/om/customers/exports" />   --}}
                OMM0004 : ค้นหาลูกค้า สำหรับขายต่างประเทศ</strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h3>Export Customer Search</h3>
        </div><!--ibox-title-->
        <div class="ibox-content">
            <h3 class="mb-4">Simple Search</h3>
            <form id="form-search" autocomplete="false" enctype="multipart/form-data" >
            <div class="row space-50 justify-content-md-center">
                <div class="col-xl-5 col-md-6  b-r">
                    <div class="form-group">
                        <label class="d-block">Customer</label>
                        <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="" autocomplete="none">
                    </div>

                    <div class="form-group">
                         <label class="d-block">Request Number</label>
                        <input type="text" class="form-control" name="request_number" id="request_number" placeholder="" autocomplete="none">
                    </div>

                    <div class="form-group">
                         <label class="d-block">Customer Number</label>
                        <input type="text" class="form-control" name="customer_number" id="customer_number" placeholder="" autocomplete="none">
                    </div>

                    <div class="form-group">
                        <label class="d-block">รหัสลูกค้าเดิมในระบบ TM</label>
                        <input type="text" class="form-control" name="customer_code_tm" id="customer_code_tm" placeholder="" autocomplete="none">
                    </div>

                    <div class="form-group">
                         <label class="d-block">Commercial Registration Certificate</label>
                        <input type="text" class="form-control" name="tax_register_number" id="tax_register_number" placeholder="" autocomplete="none">
                    </div>

                    <div class="form-group">
                         <label class="d-block">Taxpayer ID</label>
                        <input type="text" class="form-control" name="taxpayer_id" id="taxpayer_id" placeholder="" autocomplete="none">
                    </div>

                    <div class="form-group">
                        <label class="d-block">Customer Type</label>
                        <select class="custom-select select2" name="customer_type_id" id="customer_type_id" >
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="d-block">Classification</label>
                        <input type="text" class="form-control" readonly name="sales_classification_code" id="sales_classification_code" value="Export" autocomplete="none">
                    </div>
                </div><!--col-md-6-->

                <div class="col-xl-5 col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">Contact First Name</label>
                                <input type="text" class="form-control" name="contact_first_name" id="contact_first_name" placeholder="" autocomplete="none">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">Contact Last Name</label>
                                <input type="text" class="form-control" name="contact_last_name" id="contact_last_name" placeholder="" autocomplete="none">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="d-block">Contact Phone Number</label>
                                <input type="text" class="form-control" name="contact_phone" id="contact_phone" placeholder="" autocomplete="none">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="d-block">Country</label>
                                <select class="custom-select select2" name="country_code" id="country_code" onchange="thaiOrNot(this.value);">
                                    <option></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="d-block">Address Line 1</label>
                                <input type="text" class="form-control" name="address_line1" id="address_line1" placeholder="" autocomplete="none">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="d-block">Address Line 2</label>
                                <input type="text" class="form-control" name="address_line2" id="address_line2" placeholder="" autocomplete="none">
                            </div>
                        </div>

                        <div class="col-md-6 notthai">
                            <div class="form-group">
                                <label class="d-block">Province</label>
                                <input type="text" class="form-control" name="province_code" id="province_code" placeholder="" autocomplete="none">
                            </div>
                        </div>

                        <div class="col-md-6 notthai">
                            <div class="form-group">
                                <label class="d-block">State</label>
                                <input type="text" class="form-control" name="state" id="state" placeholder="" autocomplete="none">
                            </div>
                        </div>

                        <div class="col-md-6 notthai">
                            <div class="form-group">
                                <label class="d-block">City</label>
                                <input type="text" class="form-control" name="city" id="city" placeholder="" autocomplete="none">
                            </div>
                        </div>

                        <div class="col-md-6 notthai">
                            <div class="form-group">
                                <label class="d-block">Postal Code</label>
                                <input type="text" class="form-control" name="postal_code" id="postal_code" placeholder="" autocomplete="none">
                            </div>
                        </div>

                        <div class="col-md-6 thai" style="display: none;">
                            <div class="form-group">
                                <label class="d-block">Province</label>
                                <select class="custom-select select2" name="province_code" id="province_code_th" style="width: 100%;" onchange="selectProvince(this.value);">
                                    <option></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 thai" style="display: none;">
                            <div class="form-group">
                                <label class="d-block">City</label>
                                {{-- <input type="text" class="form-control" name="state" id="state" placeholder=""> --}}
                                <select class="custom-select select2" name="city_code" id="city_code_th" style="width: 100%;" onchange="selectDistrict(this.value);" >
                                    <option></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 thai" style="display: none;">
                            <div class="form-group">
                                <label class="d-block">Sub District</label>
                                {{-- <input type="text" class="form-control" name="city" id="city" placeholder=""> --}}
                                <select class="custom-select select2" name="district_code" id="district_code_th" style="width: 100%;" onchange="selectPostcode(this.value);">
                                    <option></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 thai" style="display: none;">
                            <div class="form-group">
                                <label class="d-block">Postal Code</label>
                                {{-- <input type="text" class="form-control" name="postal_code" id="postal_code_th" placeholder=""> --}}
                                <select class="custom-select select2" name="postal_code" id="postal_code_th" style="width: 100%;">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">Region</label>
                                <select class="custom-select" name="region_code" id="region_code">
                                    <option></option>
                                </select>
                            </div>
                        </div> --}}

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="d-block">Status</label>
                                <select class="custom-select select2" name="status" id="status">
                                    <option value=""></option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Draft">Draft</option>
                                </select>
                            </div>

                        </div>

                    </div><!--row-->

                </div><!--col-md-6-->
                <div class="col-md-12">
                    <div class="form-buttons">
                        <button class="btn btn-lg btn-gray-light w-160" type="button" onclick="btnClearForm();">ล้างข้อมูล<br><small></small></button>
                        <button class="btn btn-lg btn-primary w-160" type="button" onclick="getCustomerList();">ค้นหา<br><small></small></button>
                    </div>
                </div>
            </div><!--row-->
        </form>
        </div><!--ibox-content-->
    </div><!--ibox-->

    <!--//-->

    <div class="ibox">
        <div class="ibox-title">
            <div class="d-flex">
                <button class="btn btn-white" onclick="btnClearForm();"><i class="fa fa-repeat"></i></button>
            </div>
        </div><!--ibox-title-->
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-customer">
                    <thead class="text-center">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Name</th>
                            <th>Request Number</th>
                            <th>Customer Number</th>
                            <th>Customer Type</th>
                            <th>Address</th>
                            <th>Country</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Record History</th>
                        </tr>
                    </thead>
                    <tbody class="text-center" id="list_customer">

                    </tbody>
                </table>
            </div><!--table-responsive-->
            <div id="modal-show-history" class="modal fade" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h3 class="m-t-none m-b">History</h3>
                            <div class="row">
                                <table class="table">
                                    <tr>
                                        <th>Create By</th>
                                        <td id="create_by"></td>
                                    </tr>
                                    <tr>
                                        <th>Create Date</th>
                                        <td id="create_date"></td>
                                    </tr>
                                    <tr>
                                        <th>Last Update By</th>
                                        <td id="last_update_by"></td>
                                    </tr>
                                    <tr>
                                        <th>Last Update Date</th>
                                        <td id="last_update_date"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--ibox-content-->
    </div><!--ibox-->
@endsection
@section('scripts')
<script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>

<script>
    $('.select2').select2();
    var zipcode             = [];
    getCostomerTypeList();
    getCountryList();
    // getCustomerList();
    getTerritiryList();

    function getCostomerTypeList()
    {
        $.ajax({
            url : '{{ url("om/ajax/customers/exports/type") }}',
            success:function(res){
                var data = res.data;
                var html  = '<option value=""></option>';
                $.each(data,function(key,val){
                    html  += '<option value="'+val.id+'">'+val.name+' ('+ val.meaning +') </option>'
                });
                $("#customer_type_id").html(html);
            }
        });
    }

    function getCountryList()
    {
        $.ajax({
            url : '{{ url("om/ajax/customers/exports/country") }}',
            success:function(res){
                var data = res.data;
                var html  = '<option value=""></option>';
                $.each(data,function(key,val){
                    html  += '<option value="'+val.id+'">'+val.geography_name+'</option>'
                });
                $("#country_code").html(html);
            }
        });
    }

    function thaiOrNot(county)
    {
        if(county == 'TH'){
            $(".notthai").hide();
            $(".thai").show();
            console.log('1');
        }else{
            $(".thai").hide();
            $(".notthai").show();
            console.log('2');
        }
    }

    function getTerritiryList()
    {
        $.ajax({
            url : '{{ url("om/ajax/customers/exports/province") }}',
            success:function(res){
                var data = res.data;
                var html  = '<option value=""></option>';
                $.each(data,function(key,val){
                    html  += '<option value="'+val.id+'">'+val.name_en+'</option>'
                });
                $("#province_code_th").html(html);
            }
        });
    }

    function selectProvince(province)
    {
        $("#city_code_th").val('');
        $("#district_code_th").val('');
        $("#postal_code_th").val('');
        $.ajax({
            url : '{{ url("om/ajax/customers/exports/district?id=") }}'+province,
            success:function(res){
                var data = res.data;
                var html  = '<option value=""></option>';
                $.each(data,function(key,val){
                    html  += '<option value="'+val.id+'">'+val.name_en+'</option>'
                });
                $("#city_code_th").html(html);
            }
        });
    }

    function selectDistrict(district)
    {
        $("#district_code_th").val('');
        $("#postal_code_th").val('');

        $.ajax({
            url : '{{ url("om/ajax/customers/exports/tambon?id=") }}'+district,
            success:function(res){
                var data = res.data;
                var html  = '<option value=""></option>';
                $.each(data.tumbon,function(key,val){
                    html  += '<option value="'+val.id+'">'+val.name_en+'</option>'
                });
                $("#district_code_th").html(html);
                zipcode = data.postcode;
            }
        });
    }

    function selectPostcode(tumbon)
    {
        $("#postal_code_th").val('');
        var html  = '<option value=""></option>';
        $.each(zipcode[tumbon],function(key,val){
            if(zipcode[tumbon].length == 1){
                html  += '<option value="'+val+'" selected>'+val+'</option>'
            }else{
                html  += '<option value="'+val+'">'+val+'</option>'
            }
        });
        $("#postal_code_th").html(html);
    }

    function getCustomerList()
    {
        loading();
        const formdata = new FormData(document.getElementById("form-search"));
        formdata.append('_token','{{ csrf_token() }}');

        $.ajax({
            url         : '{{ url("om/ajax/customers/exports/list") }}',
            type        : 'POST',
            cache       : false,
            processData : false,
            contentType : false,
            data        : formdata
        })
        .done(function (res){
            Swal.close();
            var table = $('#dataTables-customer').DataTable({
                pageLength: 10,
                responsive: true,
                data : res.data,
                destroy : true,
                "columns" : [
                    { 'data' : 'radio' },
                    { 'data' : 'name' },
                    { 'data' : 'request_number' },
                    { 'data' : 'customer_number' },
                    { 'data' : 'customer_type' },
                    { 'data' : 'address' },
                    { 'data' : 'contry' },
                    { 'data' : 'btn_detail' },
                    { 'data' : 'status' },
                    { 'data' : 'history' }
                ]
            });
        });
    }

    function showHistoryCustomer(create_by,create_date,last_by,last_date)
    {
        $("#create_by").html(create_by);
        $("#create_date").html(create_date);
        $("#last_update_by").html(last_by);
        $("#last_update_date").html(last_date);
        $('#modal-show-history').modal();
    }

    function btnClearForm()
    {
        $("#form-search")[0].reset();
        $("select").val('').change();
        var table = $('#dataTables-customer').DataTable({
            pageLength: 10,
            responsive: true,
            data : [],
            destroy : true
        });
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
</script>
@stop
