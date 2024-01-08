@extends('layouts.app')
<style>
    .form-control:readonly, .form-control[readonly] {
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }

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

    table.dataTable {
        font-size: 0.9rem;
    }

    .datepicker table {
        font-size: 0.9rem !important;
    }

    .swal2-select {
        font-size: 1em !important;
        border-radius: 5px;
    }

    .swal2-container {
        z-index: 2060 !important;
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

    #orderLines .active {
        color: #212529;
        background-color: rgba(200, 231, 234, 0.5);
    }

</style>

@section('title', 'คืนสินค้า (RMA)')

@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <h2>
        OMP0084 คืนสินค้า (RMA)
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>คืนสินค้า (RMA)</strong>
        </li>
    </ol>
@stop

@section('content')

    <form id="formTaxInvoice" autocomplete="none" enctype="multipart/form-data">
        <div class="ibox">
            <div class="ibox-title">
                <h3>คืนสินค้า (RMA)</h3>
            </div>
            <div class="ibox-content">
                <div class="row space-50 justify-content-md-center flex-column mt-md-4">
                    <div class="col-12">
                        <div class="form-header-buttons">
                            <div class="d-flex">
                                <button class="btn btn-md btn-white" onclick="clearRMA()"><i class="fa fa-repeat"></i></button>
                            </div>
                            <div class="buttons multiple">
                                <button class="btn btn-md btn-success" type="button"><i class="fa fa-plus"></i> สร้าง</button>
                                <button class="btn btn-md btn-white" type="button"><i class="fa fa-search"></i> ค้นหา</button>
                                <button class="btn btn-md btn-primary" type="button"><i class="fa fa-save"></i> บันทึก</button>
                            </div>
                        </div><!--form-header-buttons-->

                        <div class="hr-line-dashed"></div>
                    </div><!--col-12-->

                    <div class="col-xl-12 m-auto">
                        <div class="row">

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">เลขที่คืนสินค้า</label>
                                    <input type="text" class="form-control" disabled name="" placeholder="" value="RMA19020202">
                                </div><!--form-group-->
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">วันที่คืนสินค้า</label>
                                    <input type="text" class="form-control" disabled name="" placeholder="" value="19-Sep-2019">
                                </div><!--form-group-->
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">อ้างอิง Invoice เลขที่</label>
                                    <div class="input-icon">
                                        <input type="text" class="form-control"  name="" placeholder="" value="IV19020202">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div><!--form-group-->
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">วันที่ Invoice</label>
                                    <input type="text" class="form-control" disabled name="" placeholder="" value="19-Sep-2019">
                                </div><!--form-group-->
                            </div>


                            <!--//-->
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="d-block">รหัสลูกค้า</label>
                                    <div class="row space-5">
                                        <div class="col-md-4">
                                            <div class="input-icon">
                                                <input type="text" class="form-control"  name="" placeholder="" value="11010121">
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mt-2 mt-md-0">
                                            <input type="text" class="form-control" disabled name="" placeholder="" value="King Power Duty Free Co.,ltd">
                                        </div>
                                    </div><!--row-->
                                </div>
                            </div><!--col-->

                             <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="d-block">ประเทศ</label>
                                    <input type="text" class="form-control" disabled name="" placeholder="" value="Thailand">
                                </div><!--form-group-->
                            </div>

                            <div class="col-12"></div>

                            <div class="col-xl-3 col-md-4">
                                <div class="form-group">
                                    <label class="d-block">สั่งทาง</label>
                                    <input type="text" class="form-control" disabled name="" placeholder="" value="E-Commerce">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-4">
                                <div class="form-group">
                                    <label class="d-block">หมายเหตุสั่งทาง</label>
                                    <input type="text" class="form-control" disabled name="" placeholder="" value="">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-4">
                                <div class="form-group">
                                    <label class="d-block">สถานที่สั่ง</label>
                                    <input type="text" class="form-control" disabled name="" placeholder="" value="Chiang Mai Airport">
                                </div>
                            </div>

                            <div class="col-12"></div>

                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="d-block">สาเหตุ</label>
                                    <textarea class="form-control">สั่งสินค้าผิดตรา</textarea>
                                </div>
                            </div>

                        </div><!--row-->
                    </div><!--col-xl-12-->

                    <div class="col-xl-12">
                        <hr class="lg">

                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-hover f13">
                                <thead>
                                    <tr class="align-middle">
                                        <th rowspan="2">รายการที่</th>
                                        <th rowspan="2">รหัสสินค้า</th>
                                        <th rowspan="2">ชื่อผลิตภัณฑ์</th>
                                        <th colspan="2">จำนวนที่ซื้อ</th>
                                        <th colspan="2">จำนวนที่คืน</th>
                                    </tr>
                                    <tr class="align-middle">
                                        <!--จำนวนที่ซื้อ-->
                                        <th class="w-250">UOM Code</th>
                                        <th class="w-120">จำนวน</th>

                                        <!--จำนวนที่คืน-->
                                        <th class="w-250">UOM Code</th>
                                        <th class="w-120">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="align-middle">
                                        <td>1.1</td>
                                        <td>AW01</td>
                                        <td class="text-left">กรองทิพย์ 90</td>
                                        <td class="text-left">U4 Cardboard Box</td>
                                        <td>10.00</td>
                                        <td class="text-left">
                                            <div class="form-group m-0">
                                                <div class="row space-5">
                                                    <div class="col-md-4">
                                                        <div class="input-icon">
                                                            <input type="text" class="form-control"  name="" placeholder="" value="U4">
                                                            <i class="fa fa-search"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 mt-2 mt-md-0">
                                                        <input type="text" class="form-control" disabled name="" placeholder="" value="Cardboard Box">
                                                    </div>
                                                </div><!--row-->
                                            </div>
                                        </td>
                                        <td>10.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--table-responsive-->

                    </div><!--col-xl-12-->

                </div><!--row-->
            </div><!--ibox-content-->
        </div><!--ibox-->


    </form>

@endsection

@section('scripts')

    <script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
    <!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.date').datepicker();

        $('.custom-select').select2({width: "100%"});
    });

</script>

<script>

    function clearRMA(){

    }

</script>
@stop
