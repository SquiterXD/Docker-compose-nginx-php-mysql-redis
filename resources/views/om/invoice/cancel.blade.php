@extends('layouts.app')

@section('title', 'ยกเลิก Invoice/ใบขน')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <style>

        div.dataTables_wrapper div.dataTables_length select{
            width: 75px!important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single, .select2-container--default.select2-container--focus .select2-selection--multiple,.select2-container .select2-selection--single{
            height: 40px!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered,.select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 40px!important;

        }
        .select2-dropdown,
        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-search--dropdown .select2-search__field{
            border: 1px solid #e5e6e7!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow,.select2-container .select2-selection--single{
            height: 40px!important;
        }

        .mx-datepicker .mx-input-wrapper input{
            height: auto;
        }
    </style>
@stop

@section('page-title')
    <h2>OMP0031: ยกเลิก Invoice/ใบขน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>OMP0031: ยกเลิก Invoice/ใบขน</strong>
        </li>
    </ol>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>OMP0031: ยกเลิก Invoice/ใบขน</h3>
        </div>
        <div class="ibox-content">
            <div class="alert alert-warning alert-dismissible print-error-msg-invoice boxShowErrorForm" style="display: none;">
                <button type="button" class="close" onclick="$('.boxShowErrorForm').hide();">&times;</button>
                <h5> แจ้งเตือน!</h5>
            </div>

             <div class="row space-50 justify-content-md-center flex-column mt-md-4">
            <form action="" method="GET">
                <div class="col-xl-12">
                    <div class="form-header-buttons">
                        <div class="buttons">
                            <button class="btn btn-md btn-white" type="submit"><i class="fa fa-search"></i> ค้นหา</button>
                            <button class="btn btn-md btn-primary" onclick="saveForm();" type="button"><i class="fa fa-save"></i> บันทึก</button>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                </div>
                <div class="col-xl-12">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">วันที่ Invoice/ใบขน</label>
                                {{-- <div class="input-icon">
                                    <input type="text" class="form-control date" name="pick_release_date" value="@if(!empty($pick_release_date)){{ $pick_release_date }}@endif" placeholder="">
                                    <i class="fa fa-calendar"></i>
                                </div> --}}
                                <div id="input_pick_release_date"></div>
                            </div><!--form-group-->
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">เลขที่ Invoice/ใบขน</label>
                                {{-- <div class="input-icon">
                                    <input type="text" class="form-control"  name="pick_release_no" placeholder="" value="@if(!empty($pick_release_no)){{ $pick_release_no }}@endif">
                                    <i class="fa fa-search"></i>
                                </div> --}}
                                <select class="custom-select select2" style="width: 100%;" id="pick_release_no" name="pick_release_no" data-placeholder="โปรดเลือกเลขที่ใบแจ้งหนี้/ใบขน">
                                    <option value=""></option>
                                    @foreach ($selectLists as $item)
                                        <option value="{{ $item->pick_release_no }}" @if(!empty($pick_release_no) && $pick_release_no == $item->pick_release_no){{ 'selected' }}@endif data-prepare="{{ $item->pick_release_no }}" data-customer="{{ $item->customer_id }}">{{ $item->pick_release_no }}</option>
                                    @endforeach
                                </select>
                            </div><!--form-group-->
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">สถานะ</label>
                                {{-- <div class="input-icon">
                                    <input type="text" class="form-control"  name="pick_release_no" placeholder="" value="@if(!empty($pick_release_no)){{ $pick_release_no }}@endif">
                                    <i class="fa fa-search"></i>
                                </div> --}}
                                <select class="custom-select select2" style="width: 100%;" id="pick_release_status" name="pick_release_status" data-placeholder="สถาน">
                                    <option value="ALL">ทั้งหมด</option>
                                    <option value="Confirm" {{ request()->pick_release_status == 'Confirm' ? "selected" : '' }}>Confirm</option>
                                    <option value="Cancelled" {{ request()->pick_release_status == 'Cancelled' ? "selected" : '' }}>Cancelled</option>
                                    
                                </select>
                            </div><!--form-group-->
                        </div>
                    </div><!--row-->

                </div><!--col-xl-6-->
                </form>



                <div class="col-xl-12">
                    <div class="table-responsive">
                        <form id="updateStatus" action="{{ route('om.invoice.canceled-invoice') }}" method="POST">
                        @csrf
                            <table class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr class="align-middle text-center">
                                        <th>เลขที่ Invoice/ใบขน</th>
                                        <th>วันที่ Invoice/ใบขน</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>รวมทั้งสิ้น</th>
                                        <th class="w-130">ยกเลิก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lists as $list)
                                    <tr class="" @if($list->pick_release_status == 'Cancelled') style="background-color:#ccc" @endif id="{{ $list->pick_release_no }}">
                                        <td><a href="{{ route('om.approve-prepare.print',['id'=>$list->order_header_id]) }}" target="_blank">{{ $list->pick_release_no }}</a></td>
                                        <td>@if($list->pick_release_approve_date){{ parseToDateTh($list->pick_release_approve_date) }}@else{{ '' }}@endif</td>
                                        <td class="text-left">{{ $list->customer_name }}</td>
                                        <td class="text-right">{{ number_format($list->grand_total,2) }}</td>
                                        <td class="text-center">
                                            <input type="checkbox" style="height: 20px;" {{$list->pick_release_status == 'Cancelled' ? "disabled" : ''}} value="{{ $list->pick_release_no }}" name="pick_invoice_cancel[]" class="form-control" @if($list->pick_release_no == 'Y') checked readonly @endif>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">ไม่พบข้อมูล (No Result)</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </form>
                    </div><!--table-responsive-->
                </div><!--col-xl-12-->
                <div>
                    @if (!empty($lists))
                        {{ $lists->withQueryString()->links() }}
                    @endif
                </div>
                <br><br>
            </div><!--row-->

        </div><!--ibox-content-->
    </div><!--ibox-->


</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/moment@2.26.0/moment.js"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>
<script>
    $('.select2').select2({allowClear: true});
    $(document).ready(function(){
        // getLists();
        $('input.date').datepicker();
        try {
            $("input").each(function() {
            $(this).attr("autocomplete", "off");
            });
        }
        catch (e)
        {}
    });

    // function getLists() {
    //     $.ajax({
    //             url         : '{{ route('om.invoice.getlist-cancel-invoice') }}',
    //             type        : 'GET',
    //             cache       : false,
    //             processData : false,
    //             contentType : false,
    //             success     : function(res){
    //                 var data = res.data;
    //                 console.log(data);
    //             }
    //         });
    // }
    function saveForm(){
        const formdata = new FormData(document.getElementById("updateStatus"));
        formdata.append('_token','{{ csrf_token() }}');
        Swal.fire({
            title: 'คุณต้องการยกเลิกใช่หรือไม่',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
        if (result.isConfirmed) {
            console.log(formdata);
            loading();
            $.ajax({
                url         : '{{ route('om.invoice.canceled-invoice') }}',
                type        : 'POST',
                cache       : false,
                processData : false,
                contentType : false,
                data        : formdata,
                success     : function(res){
                    swal.close();
                    var data = res.data;
                    console.log(data);
                    if(data.status == 'SUCCESS'){
                        // $('.boxShowSuccessForm').show();
                        Success(data.message);
                        var d = data.lists;
                        $.each(d, function(index,value){
                            console.log(value);
                            $('#'+value).remove();
                        });
                        // data.lists.forEach(element => {
                        //     console.log(element);
                        //     $('#'+element).remove();
                        // });
                    }else if(data.status == 'ERR01'){
                        errorCase(data.message);
                    }else if(data.status == 'EMPTY'){
                        errorCase('กรุณาเลือกรายการที่ต้องการยกเลิก');
                    }
                }
            });
        }
        });


    }

    function loading()
    {
        Swal.fire({
            title: ' ',
            html: 'กรุณารอสักครู่',
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading()
            },
        });
    }

    function Success(name)
    {
        // Swal.fire('สำเร็จ',name,'success')
        Swal.fire({
            icon: 'success',
            title: ' ',
            html: 'สำเร็จ',
            showCancelButton: false,
            confirmButtonText: 'ตกลง'
        })
    }
    function errorCase(message)
    {
        Swal.fire({
            icon: 'error',
            title: 'ผิดพลาด',
            html: message,
            showCancelButton: false,
            confirmButtonText: 'ตกลง'
        })
    }

    var vm = new Vue();
    @if(!empty($pick_release_date))
        var pick_release_date = '{!! parseToDateTh($pick_release_date) !!}';
    @else
        var pick_release_date = '';
    @endif
    var dateFormat = '{{ trans('date.js-format') }}';
    var disabled = false;

    var vm = new Vue({
        data() {
            return {
                pValue: pick_release_date,
                pFormat: dateFormat,
                disabled: disabled
            }
        },
        template: `<datepicker-th
                        style="width: 100%;height:auto;"
                        class="form-control md:tw-mb-0 tw-mb-2"
                        name="pick_release_date"
                        id="pick_release_date"
                        placeholder="โปรดเลือกวันที่"
                        :disabled="disabled"
                        @dateWasSelected='onchangeDate(...arguments)'
                        :value=pValue
                        :format=pFormat />`,
        methods: {
            async onchangeDate (date) {
                vm.pValue = date;
                var newDate = moment(date).format("DD/MM/YYYY")
                console.log(newDate)
                // setDayAmount(newDate)
            }
        },
        watch: {
            pValue : async function (value, oldValue) {
                // console.log('xxx', value, oldValue);
            }
        },
    }).$mount('#input_pick_release_date')
</script>
@stop
