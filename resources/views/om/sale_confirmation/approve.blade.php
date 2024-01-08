@extends('layouts.app')
<style>
    .form-control:disabled, .form-control[readonly] {
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }

    .chosen-container-single .chosen-single {
        min-height: 40px !important;
        background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right .75rem center/8px 10px !important;
        font-size: 0.9rem !important;
    }

    table.dataTable {
        font-size: 0.9rem;
    }

    .datepicker table {
        font-size: 0.9rem !important;
    }

</style>

@section('title', 'อนุมัติใบสั่งซื้อเพื่อสร้างใบ Sale Confirmation')

@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <h2>Customer Search</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.html">หน้าหลัก</a>
        </li> 
        <li class="breadcrumb-item active">
            <strong>ข้อมูลลูกค้า สำหรับขายต่างประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')

    <div class="ibox">
        <div class="ibox-title">
            <h3>อนุมัติใบสั่งซื้อเพื่อสร้างใบ Sale Confirmation</h3>
        </div>
        <div class="ibox-content"> 
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
                <div class="col-xl-6 m-auto">
                        
                    <div class="form-group">
                        <h3 class="black mb-3">ค้นหารายการที่ต้องการ</h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="d-block">วันที่ส่ง</label>
                                <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="approve_date"
                                id="approve_date"
                                placeholder="โปรดเลือกวันที่"
                                value=""
                                format="DD/MM/YYYY"
                                >
                            </div>

                            <div class="col-md-6">
                                <label class="d-block">ถึงวันที่</label>
                                <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="approve_date"
                                id="approve_date"
                                placeholder="โปรดเลือกวันที่"
                                value=""
                                format="DD/MM/YYYY"
                                >
                            </div>
                        </div><!--row-->
                    </div><!--form-group--> 

                    <div class="form-group"> 
                        <label class="d-block">เลขที่ใบสั่งซื้อ</label>
                        <div class="input-icon">
                            <input type="text" class="form-control" name="order_number" placeholder="" value="" autocomplete="off">
                            <i class="fa fa-search"></i> 
                        </div>
                    </div><!--form-group--> 

                    <div class="form-group">
                        <label class="d-block">Customer Number</label>
                        <div class="input-icon">
                            <input type="text" class="form-control" name="customer_number" id="customer_number" placeholder="" value="{{ (request()) ? request()->customer_number : '' }}" list="customer-list" onchange="custchange(this.value);">
                            <i class="fa fa-search"></i>
                            <datalist id="customer-list">
                                @foreach ($customers as $item)
                                    @if ($item['customer_number'] != '')
                                    <option value="{{ $item['customer_number'] }}">{{ $item['customer_name'] }}</option>
                                    @endif
                                @endforeach
                            </datalist>
                        </div>
                    </div><!--form-group-->

                    <div class="form-group">
                        <label class="d-block">Customer Name</label>
                        <input type="text" class="form-control" readonly id="customer_name" name="customer_name" placeholder="" value="{{ (request()) ? request()->customer_name : '' }}">
                    </div><!--form-group-->

                    <div class="form-group">
                        <label class="d-block">สถานะการอนุมัติ</label>
                        <select class="custom-select">
                            <option>อนุมัติ</option>
                            <option>ยังไม่ได้อนุมัติ</option>
                        </select>
                    </div>

                    <div class="form-buttons no-border">  
                        <button class="btn btn-lg btn-white" type="button"><i class="fa fa-search"></i> ค้นหา</button>
                    </div>
                </div><!--col-xl-6-->

                <div class="col-md-12">
                    <hr class="lg">

                    <div class="form-header-buttons flex-md-row-reverse">
                        <div class="buttons d-flex"> 
                            <button class="btn btn-md btn-primary" type="button"><i class="fa fa-save"></i> บันทึก</button>
                            <button class="btn btn-md btn-danger" type="button"><i class="fa fa-times"></i> ยกเลิก</button>
                        </div><!--buttons--> 

                        <button class="btn btn-md btn-white has-checkbox mt-2 mt-md-0" type="button">
                            <div class="i-checks"><label><input type="checkbox" value="option_0" name="a"><span> เลือกทั้งหมด</span></label></div>
                        </button>
                    </div><!--form-header-buttons-->

                    <div class="hr-line-dashed"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center table-hover f13 min-1600"> 
                            <thead>
                                <tr class="align-middle">
                                    <th>Select</th>
                                    <th>รายการที่</th>
                                    <th>เลขที่ใบสั่งซื้อ</th>
                                    <th>วันที่ใบสั่งซื้อ</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>เงินเชื่อ</th>
                                    <th>เงินสด</th>
                                    <th>จำนวนเงิน</th>
                                    <th>อนุมัติ</th>
                                    <th class="w-160">วันที่ขออนุมัติ</th>
                                    <th class="w-160">เลขที่บันทึกขออนุมัติหลักการขาย</th>
                                    <th>แนบไฟล์</th>
                                    <th class="w-130">ผู้อนุมัติ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="align-middle">
                                    <td>
                                        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" value="option_1" name="a"></label></div>
                                    </td>
                                    <td>1</td>
                                    <td>PO1907001</td>
                                    <td>18-Jul-2019</td>
                                    <td class="text-left">ร่านมณฑาพาณิช (กทม.)</td>
                                    <td class="text-right">1,215,500.00</td>
                                    <td class="text-right">0.00</td>
                                    <td class="text-right">1,215,500.00</td>
                                    <td>
                                        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" value="option_b1" name="b"></label></div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control md f13" name="" placeholder="" value="">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control md f13" name="" placeholder="" value="">
                                    </td>
                                    <td>
                                        <button class="btn btn-md btn-success" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> แนบไฟล์</span></button>
                                    </td>
                                    <td>
                                        <select class="custom-select">
                                            <option></option>
                                        </select>
                                    </td>
                                </tr>

                                <tr class="align-middle">
                                    <td>
                                        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" value="option_2" name="a"></label></div>
                                    </td>
                                    <td>2</td>
                                    <td>PO1907002</td>
                                    <td>18-Jul-2019</td>
                                    <td class="text-left">A Co.,ltd</td>
                                    <td class="text-right">0.00</td>
                                    <td class="text-right">2,070,345.00</td>
                                    <td class="text-right">2,070,345.00</td>
                                    <td>
                                        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" value="option_b2" name="b"></label></div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control md f13" name="" placeholder="" value="">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control md f13" name="" placeholder="" value="">
                                    </td>
                                    <td>
                                        <button class="btn btn-md btn-success" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> แนบไฟล์</span></button>
                                    </td>
                                    <td>
                                        <select class="custom-select">
                                            <option></option>
                                        </select>
                                    </td>
                                </tr>

                                <tr class="align-middle">
                                    <td>
                                        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" value="option_3" name="a"></label></div>
                                    </td>
                                    <td>3</td>
                                    <td>PO1907002</td>
                                    <td>18-Jul-2019</td>
                                    <td class="text-left">B Co.,ltd</td>
                                    <td class="text-right">0.00</td>
                                    <td class="text-right">1,170,455.00</td>
                                    <td class="text-right">1,170,455.00</td>
                                    <td>
                                        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" value="option_b3" name="b" checked=""></label></div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control md f13" name="" placeholder="" value="19-Jul-2019">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control md f13" name="" placeholder="" value="ฝตล.100102/109">
                                    </td> 
                                    <td>
                                        <button class="btn btn-md btn-success" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> แนบไฟล์</span></button>
                                    </td>
                                    <td>
                                        <select class="custom-select">
                                            <option></option>
                                        </select>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div><!--table-responsive-->

                    
                </div>
            </div><!--row-->
        </div><!--ibox-content-->
    </div><!--ibox-->

@endsection

@section('scripts')
    <script>
        let customerlists = {!! json_encode($customers) !!};

        function custchange(v){
            if(v != ''){
                var index = _.findIndex(customerlists, function(o) {return o['customer_number'] == v;});
                if(index != -1){
                    $('#customer_name').val(customerlists[index]['customer_name']);
                }
            }else{
                $('#customer_name').val('');
            }
        }
    </script>
@endsection