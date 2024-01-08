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

    .icheckbox_square-green, .iradio_square-green {
        margin-top: -10px !important;
    }

    .inmodal .modal-header {
        padding: 20px 15px !important;
    }

    .modal-body {
        padding: 20px 30px !important;
    }

    .modal-footer{
        padding: 10px 30px !important;
    }

</style>

@section('title', 'ข้อมูลลูกค้า ในประเทศ')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <h2>
        OMM0005 ข้อมูลลูกค้า ในประเทศ
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ข้อมูลลูกค้า ในประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')

                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="form-header-buttons">
                            <h3> ค้นหาข้อมูลลูกค้า </h3>
                        </div>
                    </div>
                    <div class="ibox-content">
                        {{-- <h3 class="mb-4">Simple Search</h3> --}}
                        <form method="GET" autocomplete="off">

                            <div class="row space-50 justify-content-md-center">

                                <div class="col-xl-5 col-md-6  b-r">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">รหัสลูกค้า</label>
                                                <input type="text" class="form-control" name="customer_number" id="customer_number" value="{{ request()->customer_number }}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">ชื่อลูกค้า</label>
                                                <input type="text" class="form-control" name="customer_name" id="customer_name" value="{{ request()->customer_name }}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">รหัสลูกค้าเดิมในระบบ TM</label>
                                                <input type="text" class="form-control" name="customer_code_tm" id="customer_code_tm" value="{{ request()->customer_code_tm }}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">ประเภทลูกค้า</label>
                                                <select class="data-select" name="customer_type_id" id="customer_type_id" autocomplete="off">
                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($customerType as $type)
                                                    <option {{ request()->customer_type_id == $type->customer_type ? 'selected' : '' }} value="{{ $type->customer_type }}"> {{ $type->meaning }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">เลขประจำตัวผู้เสียภาษี</label>
                                               <input type="text" class="form-control" name="taxpayer_id" id="taxpayer_id" value="{{ request()->taxpayer_id }}" autocomplete="off">
                                           </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">เลขที่ทะเบียนการค้า</label>
                                                <input type="text" class="form-control" name="tax_register_number" id="tax_register_number" value="{{ request()->tax_register_number }}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="d-block">สถานะ</label>
                                                <select class="data-select" name="status" autocomplete="off">
                                                    <option value=""> &nbsp; </option>
                                                    <option value="Draft" {{ request()->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                                    <option value="Active" {{ request()->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                    <option value="Inactive" {{ request()->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>

                                        </div>


                                    </div>

                                    <div class="form-group d-none">
                                        <label class="d-block">ประเภทการขาย</label>
                                        <input type="text" class="form-control" name="sales_classification_code" id="customer_classification_code" value="Domestic" readonly>
                                    </div>

                                </div><!--col-md-6-->

                                <div class="col-xl-5 col-md-6">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">ภูมิภาค</label>
                                                <select class="data-select" name="region_code" id="region_code" autocomplete="off">
                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($regionList as $items)
                                                    <option value="{{ $items['region_thai'] }}">{{ $items['region_thai'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">จังหวัด</label>
                                                <select class="data-select" name="province_code" id="province_code" autocomplete="off">
                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($provinceList as $items)
                                                    <option value="{{ $items['province_id'] }}">{{ $items['province_thai'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">เขต/อำเภอ</label>
                                                <select class="data-select" name="city_code" id="customerCity" autocomplete="off">
                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($cityList as $items)
                                                    <option value="{{ $items['city_code'] }}">{{ $items['city_thai'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">ซอย/ถนน</label>
                                                <input type="text" class="form-control" name="alley" id="alley" value="{{ request()->alley }}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="d-block">ที่อยู่ (ตาม ภพ.20) เลขที่</label>
                                                <input type="text" class="form-control" name="address_line1" id="address_line1" value="{{ request()->address_line1 }}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">วิธีการชำระเงิน</label>
                                                <select class="data-select" name="payment_method_id" id="payment_method_id" autocomplete="off">
                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($paymentMethod as $method)
                                                    <option {{ request()->payment_method_id == $method->lookup_code ? 'selected' : '' }} value="{{ $method->lookup_code }}">{{ $method->meaning }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">วิธีการขนส่ง</label>
                                                <select class="data-select" name="shipment_by_id" id="shipment_by_id" autocomplete="off">
                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($shipmentBy as $shipBy)
                                                    <option {{ request()->shipment_by_id == $shipBy->lookup_code ? 'selected' : '' }} value="{{ $shipBy->lookup_code }}">{{ $shipBy->meaning }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="d-block">ประเภทการจ่ายเงิน</label>
                                                <select class="data-select" name="payment_type_id" autocomplete="off">
                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($paymentType as $item)
                                                    <option value="{{ $item->lookup_code }}" {{ request()->payment_type_id == $item->lookup_code ? 'selected' : '' }}>{{ $item->meaning }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div><!--row-->

                                </div><!--col-md-6-->



                                <div class="col-md-12">
                                    <div class="form-buttons">
                                        <a class="btn btn-lg btn-gray-light w-160" href="{{ url('om/customers/domestics') }}"> <i class="fa fa-refresh"></i> ล้างข้อมูล</a>
                                        <button class="btn btn-lg btn-primary w-160" type="submit" > <i class="fa fa-search"></i> ค้นหา<br></button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

                <div class="ibox ">
                    <div class="ibox-title">
                        <button class="btn btn-lg btn-default btn-outline"> <i class="fa fa-repeat"></i> </button>

                        <div class="buttons float-right">
                            <a href="{{ url('om/customers/domestics/create') }}"><button class="btn btn-md btn-success w-160" type="button"> <i class="fa fa-plus"></i> สร้าง</button></a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th class="text-center"> </th>
                                <th class="text-center">ชื่อลูกค้า</th>
                                <th class="text-center">รหัสลูกค้า</th>
                                <th class="text-center">ประเภทลูกค้า</th>
                                <th class="text-center">ที่อยู่</th>
                                <th class="text-center">จังหวัด</th>
                                <th class="text-center">ดูรายละเอียด</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">ประวัติ</th>
                                {{-- <th class="text-center">Attachment</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($customers))
                                @foreach ($customers as $key => $result)
                                <tr>
                                    <td class="text-center align-middle">
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="" {{ $key == 0 ? 'checked' : '' }} name="a">
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle"> {{ $result->customer_name }} </td>
                                    <td class="text-center align-middle"> {{ $result->customer_number }} </td>
                                    <td class="text-left align-middle"> {{ $result->meaning }} </td>
                                    <td class="text-left align-middle"> {{ $result->address_line1 }} {{ $result->address_line2 }} {{ $result->address_line3 }} {{ $result->alley }} {{ $result->district }} {{ $result->city }} {{ $result->province_thai }} {{ $result->postal_code }} </td>
                                    <td class="text-left align-middle"> {{ $result->province_thai }} </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ url('om/customers/domestics/detail/'.$result->customer_id) }}" class="btn btn-sm"><i class="fa fa-newspaper-o"></i></a>
                                    </td>
                                    <td class="text-center align-middle">{{ $result->status }}</td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#myModal-{{ $result->customer_id }}"><i class="fa fa-history"></i></button>

                                        {{-- MODAL --}}
                                        <div class="modal inmodal fade" id="myModal-{{ $result->customer_id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">ปิด</span></button>
                                                        <h4 class="modal-title"> {{ $result->customer_name }} </h4>
                                                        {{-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> --}}
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered text-center align-middle">
                                                            <tr>
                                                                <td> สร้างโดย </td>
                                                                <td> {{ $result->created_name }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td> วันที่สร้าง </td>
                                                                <td> {{ dateTimeFormatThaiString($result->creation_date) }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td> อัพเดทล่าสุดโดย </td>
                                                                <td> {{ $result->updated_name }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td> อันเดทล่าสุดวันที่ </td>
                                                                <td> {{ dateTimeFormatThaiString($result->last_update_date) }} </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-white" style="margin:0 auto;" data-dismiss="modal">ปิด</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    {{-- <td class="text-center align-middle">
                                        <a href="javascript:void(0);" class="btn btn-sm"><i class="custom-file-input"></i></a>
                                    </td> --}}
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="9"> ไม่พบข้อมูลลูกค้าสำหรับขายในประเทศ </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                        </div>

                    </div>
                </div>

@endsection

@section('scripts')
    <script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
    <!-- Page-Level Scripts -->

    <script>
        $(document).ready(function(){

            if ('{{!empty($customers)}}') {
                $('.dataTables-example').DataTable({
                    order: [ 2, "desc" ],
                    pageLength: 10,
                    responsive: true,
                    searching: false,
                });
            }

            $('.custom-select').chosen({width: "100%"});
            $('.data-select').select2({width: "100%"});

            window.onload = showTerritory();

        });

    </script>

    <script>

        function showTerritory()
        {
            if ('{{!empty(request()->region_code)}}') {
                $('#region_code').val('{{ request()->region_code }}').trigger('chosen:updated');
                $('#region_code').val('{{ request()->region_code }}').trigger('change');
            }
        }

        $('#region_code').change(function()
        {

            var id = $('#region_code').val();

            if (id == '') {
                $('#province_code').html('');
                $('#customerCity').html('');
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/province-list") }}/'+id,
                success : function(res){
                    // PROVINCE
                    province = res.data.data;
                    var html = '';
                    var checkSelect = '';
                    html += '<option value=""> &nbsp; </option>';

                    $.each(province, function(key,val){
                        if(val.province_id == '{{ request()->province_code }}')
                        {
                            checkSelect = 'selected';
                        }
                        else{
                            checkSelect = '';
                        }

                        html += '<option '+checkSelect+' value="'+val.province_id+'">'+val.province_thai+'</option>';
                    });
                    $('#province_code').html(html).trigger('chosen:updated');
                    $('#province_code').html(html).trigger('change');

                    // CITY
                    city = res.data.dataCity;
                    var htmlCity = '';
                    var checkSelect = '';
                    htmlCity += '<option value=""> &nbsp; </option>';

                    $.each(city, function(key,val){
                        if(val.city_code == '{{ request()->city_code }}')
                        {
                            checkSelect = 'selected';
                        }
                        else{
                            checkSelect = '';
                        }

                        htmlCity += '<option '+checkSelect+' value="'+val.city_code+'">'+val.city_thai+'</option>';
                    });
                    $('#customerCity').html(htmlCity).trigger('chosen:updated');
                    $('#customerCity').html(htmlCity).trigger('change');
                }
            });

        });

        $('#province_code').change(function()
        {

            var id      = $('#province_code').val();
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;

            if (id == '') {
                $('#customerCity').html('');
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/city-list") }}/'+id+'/'+shipID,
                success : function(res){
                    city = res.data.data;
                    console.log(city);
                    var html = '';
                    var checkSelect = '';
                    html += '<option value=""> &nbsp; </option>';
                    $.each(city, function(key,val){
                        if(val.city_code == '{{ request()->city_code }}')
                        {
                            checkSelect = 'selected';
                        }
                        else{
                            checkSelect = '';
                        }

                        html += '<option '+checkSelect+' value="'+val.city_code+'">'+val.city_thai+'</option>';
                    });
                    $('#customerCity').html(html).trigger('change');
                    $('#customerCity').html(html).trigger('chosen:updated');
                }
            });

        });
    </script>

@stop
