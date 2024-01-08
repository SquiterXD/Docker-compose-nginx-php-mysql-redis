@extends('layouts.app')

@section('title', 'ยกเลิกฝากขาย')

@section('custom_css')
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
</style>
@stop

@section('page-title')
    <h2><x-get-program-code url="/om/consignment/cancel" /> ยกเลิกรายการฝากขาย สำหรับขายในประเทศ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/consignment/cancel" /> ยกเลิกรายการฝากขาย สำหรับขายในประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>ยกเลิกรายการฝากขาย สำหรับขายในประเทศ</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mt-md-4">

                <div class="col-xl-12">
                    <div class="form-header-buttons">
                        <div class="d-flex">
                            <button class="btn btn-white" onclick="btnClearForm();"><i class="fa fa-repeat"></i></button>
                        </div>
                        <div class="buttons">
                            <button class="btn btn-md btn-primary" type="button" onclick="saveForm();"><i class="fa fa-save"></i> บันทึก</button>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                </div>
                <form action="" method="GET">
                <div class="col-xl-8 m-auto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">วันที่ฝากขาย</label>
                                <div class="input-icon">
                                    <!-- <input type="text" class="form-control date" name="consignment_date" placeholder="" value="{{ Request::old('consignment_date') }}">
                                    <i class="fa fa-calendar"></i> -->

                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="consignment_date"
                                        id="input_date"
                                        placeholder=""
                                        @if(request()->consignment_date != '') value="{{ request()->consignment_date }}" @endif format="{{ trans('date.js-format') }}">
                                </div>
                            </div><!--form-group-->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">เลขที่ฝากขาย</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="consignment_no" placeholder="" value="{{ request()->consignment_no }}" list="idorders">
                                    <i class="fa fa-search"></i>
                                    <datalist id="idorders">
                                        @foreach($orders as $order)
                                            <option>{{ $order->consignment_no }}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div><!--form-group-->
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="d-block">รหัสลูกค้า </label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-icon">
                                            <select class="form-control select2" name="customer_number" id="customer_number" onchange="getValueCustomerName(this.value);">
                                                <option value=""></option>
                                                @foreach ($customers as $item)
                                                    @if($item->customer_number != null)
                                                        <option value="{{ $item->customer_number }}" @if(request()->customer_number == $item->customer_number) selected @endif>{{ $item->customer_number }} : {{ $item->customer_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-8 mt-2 mt-md-0">
                                        <input type="text" class="form-control" disabled="" name="customer_name" placeholder="" value="{{ request()->customer_names }}">
                                        <input type="hidden" class="form-control" name="customer_names" placeholder="" value="{{ request()->customer_names }}">
                                    </div>
                                </div><!--row-->
                            </div><!--form-group-->
                        </div>
                    </div><!--row-->

                    <div class="form-buttons no-border">
                        <button class="btn btn-lg btn-white" type="submit"><i class="fa fa-search"></i> ค้นหา</button>
                    </div>

                </div><!--col-xl-6-->
            </form>

                <div class="col-xl-12">
                    <hr class="lg">
                    <div class="table-responsive">
                        <form id="updateStatus" action="{{ route('om.canceled-consignment') }}" method="POST">
                            @csrf
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr class="align-middle text-center">
                                    <th>เลขที่ฝากขาย</th>
                                    <th>วันที่ชำระ</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>จำนวนเงิน</th>
                                    <th>ยกเลิก</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lists as $list)
                                <tr>
                                    <td>{{ $list->consignment_no }}</td>
                                    <td>{{ FormatDate::DateThaiNumericWithSplash(date_format(date_create($list->consignment_date), 'Y-m-d')) }}</td>
                                    <td class="text-left">{{ $list->customer_name }}</td>
                                    <td class="text-right">{{ number_format($list->total_amount,2) }}</td>
                                    <td class="text-center">
                                        <input type="checkbox" class="icheckbox_square-green checked" value="{{ $list->consignment_header_id }}" name="consignment_id[]" @if($list->consignment_status == 'Y') checked readonly @endif>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                    </div><!--table-responsive-->
                    <br/>
                    <div class="pull-right">
                        @if(!empty($lists)){{ $lists->links() }}@endif
                    </div>
                </div>


            </div><!--row-->

        </div><!--ibox-content-->
    </div><!--ibox-->


</div>
@endsection

@section('scripts')
<script src="{!! asset('js/lodash.js') !!}" type="text/javascript"></script>

<script>
    let customerlists = {!! json_encode($customers) !!};
    $(document).ready(function(){
        $('.date').datepicker();
        $('.select2').select2();

        $('.select2').select2({
            templateSelection: function (data, container) {
                $(data.element).attr('data-custom-attribute', data.customValue);
                return data.id;
            }
        });

        try {
            $("input").each(function() {
            $(this).attr("autocomplete", "off");
            });
        }
        catch (e)
        {}
    });
    function getValueCustomerName(v){
        if(v != ''){
            var index = _.findIndex(customerlists, function(o) {
                return o.customer_number == v;
            });
            $('input[name="customer_name"]').val(customerlists[index].customer_name);
            $('input[name="customer_names"]').val(customerlists[index].customer_name);
        }else{
            $('input[name="customer_name"]').val('');
            $('input[name="customer_names"]').val('');
        }

    }

    function saveForm(){
        $('#updateStatus').submit();
    }

    function btnClearForm()
    {
        window.location.href = "/om/consignment/cancel";
    }
</script>
@stop
