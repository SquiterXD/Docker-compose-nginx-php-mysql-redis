@extends('layouts.app')

@section('title', 'อนุมัติใบคำร้องเพิ่มเพดานการจำหน่าย')
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
    <h2>
        <x-get-page-title menu="" url="/om/addition-quota" />
    </h2>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>อนุมัติใบคำร้องเพิ่มเพดานการจำหน่าย</h3>
        </div>
        <div class="ibox-content">
            <form method="get" autocomplete="off" id="from-srach">
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
                <div class="col-xl-6 m-auto">

                    <div class="form-group">
                        <h3 class="black mb-3">ค้นหารายการที่ต้องการ</h3>
                        <label class="d-block">ชื่อลูกค้า</label>
                            <select class="form-control select2" name="customer_number" id="customer_number" onchange="custchange(this.value);">
                                <option value="" @if(request()->customer_number == '') selected @endif></option>
                                @foreach ($customers as $item)
                                    @if($item['customer_number'] != Null)
                                        <option value="{{ $item['customer_number'] }}" @if(request()->customer_number == $item['customer_number']) selected @endif>{{ $item['customer_number'] }} {{ $item['customer_name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                    </div><!--form-group-->

                    <div class="form-group">
                        <label class="d-block">เลขที่ใบสั่งซื้อ</label>
                        <div class="input-icon">
                            <input type="text" class="form-control" name="order_number" placeholder="" @if(request()->order_number != '') value="{{ request()->order_number }}" @endif list="orders-list">
                            <i class="fa fa-search"></i>
                            <datalist id="orders-list">
                                @foreach ($orders as $item)
                                    <option>{{ $item->order_number }}</option>
                                @endforeach
                            </datalist>
                        </div>
                    </div><!--form-group-->

                    <div class="form-group">
                        <label class="d-block">เพดานการจำหน่ายประจำเดือน</label>
                        <div class="input-icon">
                            <input type="text" class="form-control" name="period_id" placeholder="" @if(request()->period_id != '') value="{{ request()->period_id }}" @endif list="period_id">
                            <i class="fa fa-search"></i>
                            <datalist id="period_id">
                                <option></option>
                                <option>มกราคม</option>
                                <option>กุมภาพันธ์</option>
                                <option>มีนาคม</option>
                                <option>เมษายน</option>
                                <option>พฤษภาคม</option>
                                <option>มิถุนายน</option>
                                <option>กรกฎาคม</option>
                                <option>สิงหาคม</option>
                                <option>กันยายน</option>
                                <option>ตุลาคม</option>
                                <option>พฤษจิกายน</option>
                                <option>ธันวาคม</option>
                            </datalist>
                        </div>
                    </div><!--form-group-->

                    <div class="form-group">
                        <label class="d-block">เพดานการจำหน่ายประจำงวด</label>
                        <div class="input-icon">
                            {{-- <input type="text" class="form-control date" name="period_date" placeholder="" @if(request()->period_date != '') value="{{ request()->period_date }}" @endif> --}}
                            <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="period_date"
                                id="input_date"
                                placeholder=""
                                @if(request()->period_date != '') value="{{ request()->period_date }}" @endif
                                format="{{ trans("date.js-format") }}">

                            {{-- <i class="fa fa-calendar"></i> --}}
                        </div>
                    </div><!--form-group-->

                    <div class="form-group">
                        <label class="d-block">สถานะ</label>
                        <select class="custom-select" name="draft_status" @if($statusforapprove) @if(optional(auth()->user())->username != 'sysadmin') disabled @endif @endif>
                            <option value="" @if(request()->status == '') selected @endif></option>
                            <option value="ขออนุมัติ" @if(request()->status == 'ขออนุมัติ') selected @endif>ขออนุมัติ</option>
                            <option value="รอการอนุมัติ"  @if($statusforapprove) selected @elseif(request()->status == 'รอการอนุมัติ') selected @endif>รอการอนุมัติ</option>
                            <option value="อนุมัติ" @if(request()->status == 'อนุมัติ') selected @endif>อนุมัติ</option>
                            <option value="ไม่อนุมัติ" @if(request()->status == 'ไม่อนุมัติ') selected @endif>ไม่อนุมัติ</option>
                        </select>
                        <input type="hidden" name="status" value="">
                    </div>

                    <div class="form-buttons no-border">
                        <button class="btn btn-lg btn-white" type="button" id="submit-search"><i class="fa fa-search"></i> ค้นหา</button>
                    </div>
                </div><!--col-xl-6-->

                <div class="col-md-12">
                    <hr class="lg">

                    <div class="table-responsive" style="max-height: calc(80vh - 7rem);height: auto;overflow-y: scroll;">
                        <table class="table table-bordered text-center">
                            <tbody>
                                <tr class="align-middle text-center">
                                    <th>สถานะการขอเพิ่ม<br>เพดานโควต้า</th>
                                    <th>เลขที่ใบสั่งซื้อ</th>
                                    <th>เพดานการจำหน่าย<br>ประจำเดือน</th>
                                    <th>เพดานการจำหน่าย<br>ประจำงวด</th>
                                    <th>อนุมัติโดย</th>
                                    <th>ดูรายละเอียด</th>
                                </tr>
                                @foreach($waittings as $w)
                                <?php
                                $int_date = compareDaysTH($w->delivery_date);
                                $period_date = nextDaysOfWeek($int_date);
                                $convert = dateFormatThaiString($period_date);
                                $date = explode(' ',$convert);
                                $valuedate = dayTHcompare($w->delivery_date,$w->order_date);
                                //getDefaultData('/users')->user_id
                                if($w->status_empolyee_approve4 == null){
                                    $step = 4;
                                } elseif ($w->status_empolyee_approve4 == 'A' && $w->employee_approve1 != null && $w->status_empolyee_approve1 == null) {
                                    $step = 1;
                                } elseif (($w->status_empolyee_approve4 == 'A' || $w->status_empolyee_approve1 == 'A') && $w->employee_approve2 != null && $w->status_empolyee_approve2 == null) {
                                    $step = 2;
                                } else {
                                    $step = 3;
                                }
                                ?>
                                @if($w->approve_status == 'รอการอนุมัติ')
                                    @if(optional(auth()->user())->username == 'sysadmin')
                                    <tr class="align-middle">
                                        <td class="green"><strong>{{ $w->approve_status }}</strong></td>
                                        <td class="text-left">
                                            Number : {{ $w->order_number }}<br>
                                            Customer : {{ $w->customer_name }}
                                        </td>
                                        <td>{{ FormatDate::Monthonly($w->delivery_date2) }}</td>
                                        <td>{{ FormatDate::DateThaiNumericWithSplash($w->delivery_date2) }}</td>
                                        <td class="text-left">
                                            @if($w->approve_status == 'อนุมัติ' || $w->approve_status == 'ไม่อนุมัติ')
                                            {{ $w->employee_pos3 }}<br>
                                            {{ FormatDate::DateThaiwithTime($w->approve_date) }}
                                            @endif
                                        </td>
                                        <td><a class="fa fa-search black" href="{{ route('om.addition-quota',[$w->quota_header_id,$step]) }}"></a></td>
                                    </tr>
                                    @else
                                        @if($w->employee_sales_division == null && $w->employee_approve1 == null && $w->employee_approve2 != null && $w->status_empolyee_approve2 == null && getDefaultData('/users')->user_id == returnUserID($w->employee_approve2))
                                            <tr class="align-middle">
                                                <td class="green"><strong>{{ $w->approve_status }}</strong></td>
                                                <td class="text-left">
                                                    Number : {{ $w->order_number }}<br>
                                                    Customer : {{ $w->customer_name }}
                                                </td>
                                                <td>{{ FormatDate::Monthonly($w->delivery_date2) }}</td>
                                                <td>{{ FormatDate::DateThaiNumericWithSplash($w->delivery_date2) }}</td>
                                                <td class="text-left">
                                                    @if($w->approve_status == 'อนุมัติ' || $w->approve_status == 'ไม่อนุมัติ')
                                                    {{ returnUserName($w->employee_approve3) }}<br>
                                                    {{ FormatDate::DateThaiwithTime($w->approve_date) }}
                                                    @endif
                                                </td>
                                                <td><a class="fa fa-search black" href="{{ route('om.addition-quota',[$w->quota_header_id,2]) }}"></a></td>
                                            </tr>
                                        @else
                                            @if($statusforapprove && $w->status_empolyee_approve4 == null && getDefaultData('/users')->user_id == returnUserID($w->employee_sales_division))
                                                <tr class="align-middle">
                                                    <td class="green"><strong>{{ $w->approve_status }}</strong></td>
                                                    <td class="text-left">
                                                        Number : {{ $w->order_number }}<br>
                                                        Customer : {{ $w->customer_name }}
                                                    </td>
                                                    <td>{{ FormatDate::Monthonly($w->delivery_date2) }}</td>
                                                    <td>{{ FormatDate::DateThaiNumericWithSplash($w->delivery_date2) }}</td>
                                                    <td class="text-left">
                                                        @if($w->approve_status == 'อนุมัติ' || $w->approve_status == 'ไม่อนุมัติ')
                                                        {{ returnUserName($w->employee_approve3) }}<br>
                                                        {{ FormatDate::DateThaiwithTime($w->approve_date) }}
                                                        @endif
                                                    </td>
                                                    <td><a class="fa fa-search black" href="{{ route('om.addition-quota',[$w->quota_header_id,4]) }}"></a></td>
                                                </tr>
                                            @elseif($statusforapprove && $w->status_empolyee_approve4 == 'A' && $w->employee_approve1 != null && $w->status_empolyee_approve1 == null && getDefaultData('/users')->user_id == returnUserID($w->employee_approve1))
                                                <tr class="align-middle">
                                                    <td class="green"><strong>{{ $w->approve_status }}</strong></td>
                                                    <td class="text-left">
                                                        Number : {{ $w->order_number }}<br>
                                                        Customer : {{ $w->customer_name }}
                                                    </td>
                                                    <td>{{ FormatDate::Monthonly($w->delivery_date2) }}</td>
                                                    <td>{{ FormatDate::DateThaiNumericWithSplash($w->delivery_date2) }}</td>
                                                    <td class="text-left">
                                                        @if($w->approve_status == 'อนุมัติ' || $w->approve_status == 'ไม่อนุมัติ')
                                                        {{ returnUserName($w->employee_approve3) }}<br>
                                                        {{ FormatDate::DateThaiwithTime($w->approve_date) }}
                                                        @endif
                                                    </td>
                                                    <td><a class="fa fa-search black" href="{{ route('om.addition-quota',[$w->quota_header_id,1]) }}"></a></td>
                                                </tr>
                                            @elseif($statusforapprove && $w->status_empolyee_approve4 == 'A' && $w->employee_approve2 != null && $w->status_empolyee_approve2 == null && getDefaultData('/users')->user_id == returnUserID($w->employee_approve2))
                                                @if(($w->employee_approve1 != null && $w->status_empolyee_approve1 == 'A') || $w->employee_approve1 == null)    
                                                <tr class="align-middle">
                                                    <td class="green"><strong>{{ $w->approve_status }}</strong></td>
                                                    <td class="text-left">
                                                        Number : {{ $w->order_number }}<br>
                                                        Customer : {{ $w->customer_name }}
                                                    </td>
                                                    <td>{{ FormatDate::Monthonly($w->delivery_date2) }}</td>
                                                    <td>{{ FormatDate::DateThaiNumericWithSplash($w->delivery_date2) }}</td>
                                                    <td class="text-left">
                                                        @if($w->approve_status == 'อนุมัติ' || $w->approve_status == 'ไม่อนุมัติ')
                                                        {{ returnUserName($w->employee_approve3) }}<br>
                                                        {{ FormatDate::DateThaiwithTime($w->approve_date) }}
                                                        @endif
                                                    </td>
                                                    <td><a class="fa fa-search black" href="{{ route('om.addition-quota',[$w->quota_header_id,2]) }}"></a></td>
                                                </tr>
                                                @endif
                                            @elseif ($statusforapprove && $w->status_empolyee_approve4 == 'A' && $w->employee_approve3 != null && $w->status_empolyee_approve3 == null && getDefaultData('/users')->user_id == returnUserID($w->employee_approve3))
                                                @if(($w->employee_approve2 != null && $w->status_empolyee_approve2 == 'A') || $w->employee_approve2 == null) 
                                                <tr class="align-middle">
                                                    <td class="green"><strong>{{ $w->approve_status }}</strong></td>
                                                    <td class="text-left">
                                                        Number : {{ $w->order_number }}<br>
                                                        Customer : {{ $w->customer_name }}
                                                    </td>
                                                    <td>{{ FormatDate::Monthonly($w->delivery_date2) }}</td>
                                                    <td>{{ FormatDate::DateThaiNumericWithSplash($w->delivery_date2) }}</td>
                                                    <td class="text-left">
                                                        @if($w->approve_status == 'อนุมัติ' || $w->approve_status == 'ไม่อนุมัติ')
                                                        {{ returnUserName($w->employee_approve3) }}<br>
                                                        {{ FormatDate::DateThaiwithTime($w->approve_date) }}
                                                        @endif
                                                    </td>
                                                    <td><a class="fa fa-search black" href="{{ route('om.addition-quota',[$w->quota_header_id,3]) }}"></a></td>
                                                </tr>
                                                @endif
                                            @elseif(!$statusforapprove)
                                                <tr class="align-middle">
                                                    <td class="green"><strong>{{ $w->approve_status }}</strong></td>
                                                    <td class="text-left">
                                                        Number : {{ $w->order_number }}<br>
                                                        Customer : {{ $w->customer_name }}
                                                    </td>
                                                    <td>{{ FormatDate::Monthonly($w->delivery_date2) }}</td>
                                                    <td>{{ FormatDate::DateThaiNumericWithSplash($w->delivery_date2) }}</td>
                                                    <td class="text-left">
                                                        @if($w->approve_status == 'อนุมัติ' || $w->approve_status == 'ไม่อนุมัติ')
                                                        {{ returnUserName($w->employee_approve3) }}<br>
                                                        {{ FormatDate::DateThaiwithTime($w->approve_date) }}
                                                        @endif
                                                    </td>
                                                    <td><a class="fa fa-search black" href="{{ route('om.addition-quota',[$w->quota_header_id,5]) }}"></a></td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endif
                                @else
                                <tr class="align-middle">
                                    <td @if($w->approve_status == 'อนุมัติ') class="green" @elseif($w->approve_status == 'ไม่อนุมัติ') class="red" @else class="black" @endif><strong>{{ $w->approve_status }}</strong></td>
                                    <td class="text-left">
                                        Number : {{ $w->order_number }}<br>
                                        Customer : {{ $w->customer_name }}
                                    </td>
                                    <td>{{ FormatDate::Monthonly($w->delivery_date2) }}</td>
                                    <td>{{ FormatDate::DateThaiNumericWithSplash($w->delivery_date2) }}</td>
                                    <td class="text-left">
                                        @if($w->approve_status == 'อนุมัติ' || $w->approve_status == 'ไม่อนุมัติ')
                                        {{ returnUserName($w->employee_approve3) }}<br>
                                        {{ FormatDate::DateThaiwithTime($w->approve_date) }}
                                        @endif
                                    </td>
                                    <td><a class="fa fa-search black" href="{{ route('om.addition-quota',[$w->quota_header_id,0]) }}" @if($w->approve_status == 'อนุมัติ' || $w->approve_status == 'ไม่อนุมัติ') target="_blank" @endif></a></td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div><!--table-responsive-->
                </div><!--col-xl-12-->
            </div><!--row-->
            </form>
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
        $("#dataTables-invoice").DataTable();

        $('#submit-search').on('click', function() {
            var option = $('select[name="draft_status"] option:selected').val();
            $('input[name="status"]').val(option);

            $('#from-srach').submit();
        });
    });

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
