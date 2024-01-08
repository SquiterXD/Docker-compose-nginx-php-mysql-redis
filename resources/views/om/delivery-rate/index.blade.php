@extends('layouts.app')

@section('title', 'ปรับอัตราค่าขนส่ง')

@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@endsection

@section('page-title')
<h2><x-get-page-title menu="" url="/om/delivery-rate" /></h2>
{{-- <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/">หน้าแรก</a>
    </li>
    <li class="breadcrumb-item active">
        <strong>ปรับอัตราค่าขนส่ง</strong>
    </li>
</ol> --}}
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>ปรับอัตราค่าขนส่ง</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mt-md-4">
                <form action="{{ route('om.delivery-rate-store') }}" method="POST">
                    @csrf
                <input type="hidden" name="delivery_rate_id" value="{{ $last_rate->delivery_rate_id ?? '' }}">
                <input type="hidden" name="new_oil" value="{{ $priceB7 }}">
                <input type="hidden" name="old_oil" value="{{ $last_rate->oil_price ?? 0 }}">
                <div class="col-xl-8 m-auto">
                    <div class="row space-30 align-items-end">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">ใช้อัตราน้ำมันวันที่</label>
                                <div class="input-icon">
                                    <!-- <input type="text" class="form-control date" name="price_date" placeholder=""
                                        value="{{ $priceDate }}">
                                    <i class="fa fa-calendar"></i> -->
                                    <div id="input_date_js"></div>
                                    <!-- <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="price_date"
                                        id="input_date"
                                        placeholder=""
                                        value="{{ FormatDate::DateThaiNumericWithSplash($priceDate) }}" 
                                        format="{{ trans('date.js-format') }}"> -->
                                </div>
                            </div>
                            <!--form-group-->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">ราคาน้ำมัน</label>
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control" id="oil_price" placeholder=""
                                        value="{{ number_format($priceB7,4) }}" oninput="validity.valid||(value='');" name="oil_price">
                                    <span class="d-block pl-3" style="width:200px;">บาทต่อลิตร</span>
                                </div>
                            </div>
                            <!--form-group-->
                        </div>

                        <div class="col-12"></div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">อัตราค่าขนส่งบุหรี่ใหม่ต่อหีบ</label>
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control" id="cigarette_delivery_rates" placeholder=""
                                        @if($oil_price == 0) value="" @else value="{{ $pricenewold }}" @endif onchange="countCigarette();" oninput="validity.valid||(value='');">
                                    <input type="hidden" name="cigarette_delivery_rates" value="">
                                    <span class="d-block pl-4"> บาท</span>
                                    <input type="hidden" id="cigarette_delivery_rates_value" value="{{ $last_rate->cigarette_delivery_rates ?? '' }}">
                                </div>
                                <label class="d-block" id="changebath">@if($oil_price != 0)<font color="red">อัตราค่าขนส่งบุหรี่ใหม่ต่อห่อ {{ number_format($pricenewold/50,4) }} บาท</font>@endif</label>
                            </div>
                            <!--form-group-->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">เพิ่มขึ้น/ลดลง</label>
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control" disabled=""
                                        name="cigarette_delivery_rates_number" placeholder="" value="">
                                    <span class="d-block pl-4"> บาท</span>
                                </div>
                            </div>
                            <!--form-group-->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">อัตราค่าขนส่งยาเส้นใหม่ต่อหีบ</label>
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control" name="leaf_delivery_rates" placeholder=""
                                        value="{{ $last_rate->leaf_delivery_rates ?? '' }}" onchange="countLeaf();" oninput="validity.valid||(value='');">
                                    <span class="d-block pl-4"> บาท</span>
                                </div>
                            </div>
                            <!--form-group-->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">เพิ่มขึ้น/ลดลง</label>
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control" disabled=""
                                        name="leaf_delivery_rates_number" placeholder="" value="">
                                    <span class="d-block pl-4"> บาท</span>
                                </div>
                            </div>
                            <!--form-group-->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">อัตราค่าขนส่งอื่นๆใหม่ต่อหีบ</label>
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control" name="other_delivery_rates" placeholder=""
                                        value="{{ $last_rate->other_delivery_rates ?? '' }}" onchange="countOther();" oninput="validity.valid||(value='');">
                                    <span class="d-block pl-4"> บาท</span>
                                </div>
                            </div>
                            <!--form-group-->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">เพิ่มขึ้น/ลดลง</label>
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control" disabled=""
                                        name="other_delivery_rates_number" placeholder="" value="">
                                    <span class="d-block pl-4"> บาท</span>
                                </div>
                            </div>
                            <!--form-group-->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">วันที่อนุมัติเริ่มใช้อัตราใหม่</label>
                                <div class="input-icon">
                                    <!-- <input type="text" class="form-control date" name="rate_start_date" placeholder="" value="">
                                    <i class="fa fa-calendar"></i> -->
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="rate_start_date"
                                        id="input_date"
                                        placeholder=""
                                        value="" 
                                        format="{{ trans('date.js-format') }}">
                                </div>
                            </div>
                            <!--form-group-->
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="d-block">รายการ</label>
                                <input type="text" class="form-control" name="delivery_rate_name" placeholder="" value="">
                            </div>
                            <!--form-group-->
                        </div>

                        <div class="col-md-12">
                            <div class="form-buttons no-border">
                                <button class="btn btn-lg btn-success" type="submit"><i class="fa fa-check"></i>
                                    ยืนยันการปรับราคา</button>
                            </div>
                        </div>
                    </div>
                    <!--row-->

                </div>
                <!--col-xl-6-->

                <div class="col-xl-12">
                    <hr class="lg">
                    <div class="table-responsive" style="max-height: calc(80vh - 7rem);height: auto;overflow-y: scroll;">
                        <table class="table table-bordered table-hover text-center f13">
                            <thead>
                                <tr class="align-middle text-center">
                                    <th>รายการ</th>
                                    <th>วันที่เริ่มใช้</th>
                                    <th>วันที่สิ้นสุด</th>
                                    <th class="w-160">อัตราค่าขนส่งบุหรี่(หีบ)</th>
                                    <th class="w-160">อัตราค่าขนส่งบุหรี่(ห่อ)</th>
                                    <th class="w-160">อัตราค่าขนส่งยาเส้น(หีบ)</th>
                                    <th class="w-160">อัตราค่าขนส่งอื่นๆ(หีบ)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rates as $rate)
                                <tr>
                                    <td class="text-left">{{ $rate->delivery_rate_name }}</td>
                                    <td>{{ FormatDate::DateThaiNumericWithSplash($rate->rate_start_date) }}</td>
                                    <td>{{ FormatDate::DateThaiNumericWithSplash($rate->rate_end_date) }}</td>
                                    <td class="text-right">{{ number_format($rate->cigarette_delivery_rates,4) }}</td>
                                    <td class="text-right">{{ number_format($rate->cigarette_delivery_rates/50,4) }}</td>
                                    <td class="text-right">{{ number_format($rate->leaf_delivery_rates,4) }}</td>
                                    <td class="text-right">{{ number_format($rate->other_delivery_rates,4) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--table-responsive-->
                </div>
                <!--col-xl-12-->
            </div>
            <!--row-->
        </form>
        </div>
        <!--ibox-content-->
    </div>
    <!--ibox-->


</div>
@endsection

@section('scripts')
<script>
    let data_last = {!! json_encode($last_rate) !!};
    let old_price = "{{ $last_rate->cigarette_delivery_rates ?? '' }}";

    $(document).ready(function () {
        $('.date').datepicker();
        if($('input[name="old_oil"]').val() != 0){
            countCigarette();
        }
        countLeaf();
        countOther();
        try {
            $("input").each(function() {
                $(this).attr("autocomplete", "off");
            });
        } catch (e)
        {};


        var value = '27/04/2564';
        var dateFormat = "{{ trans('date.js-format') }}";
        var disabled = false;

        var vm = new Vue({
            data() {
                return {
                    pValue: "{{ FormatDate::DateThaiNumericWithSplash($priceDate) }}",
                    pFormat: dateFormat,
                }
            },
            template: `<datepicker-th
                            style="width: 100%"
                            class="form-control md:tw-mb-0 tw-mb-2"
                            name="price_date"
                            id="input_date"
                            placeholder="โปรดเลือกวันที่"
                            @dateWasSelected='onchangeDate(...arguments)'
                            :value=pValue
                            :format=pFormat />`,
            methods: {
                onchangeDate (date) {
                    vm.pValue = date;
                }
            },
            watch: {
                pValue : async function (value, oldValue) {
                    onchangeoildateprice(value);
                    console.log(value);
                }
            },
        }).$mount('#input_date_js')
    });

    function onchangeoildateprice(value){
        if(value == '' || value == null){
            return false;
        } else {
        $.ajax({
                    url: "{{ route('om.delivery-rate-getnewoil') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "params": value,
                    },
                    cache: false,
                    beforeSend: function() {
                        swal({
                            title: 'กำลังดึงราคาน้ำมันจาก PTT กรุณารอสักครู่',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    success: function(res) {
                        if(res.s == 'success'){
                            $('input[name="oil_price"]').val(res.g);
                            $('input[name="new_oil"]').val(res.g);
                            countnewtransfer();
                        } else {
                            swal({
                                title: 'เกิดข้อผิดพลาด',
                                type: 'error'
                            });
                        }
                    },
                    error: function(error) {
                        swal({
                            title: error.responseText,
                            type: 'error'
                        });
                    }
                });
        }
    }

    function countnewtransfer() {
        var olds = $('input[name="old_oil"]').val();
        if(olds != 0){
            var news = $('input[name="new_oil"]').val();
            var cigarette_delivery_rates = $('#cigarette_delivery_rates_value').val();
            console.log(olds);
            console.log(news);
            console.log(cigarette_delivery_rates);
                $.ajax({
                    url: "{{ route('om.delivery-rate-price-new') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "oil_price": parseFloat(olds),
                        "priceB7": parseFloat(news),
                        "price": parseFloat(cigarette_delivery_rates),
                    },
                    cache: false,
                    beforeSend: function() {
                        swal({
                            title: 'ดำเนินการคำนวณค่าขนส่งใหม่',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    success: function(res) {
                        console.log(res);
                        if(res.status == 'success'){
                            $('#cigarette_delivery_rates').val(res.data);
                            $('input[name="cigarette_delivery_rates"]').val(res.data);
                            countCigarette();
                            swal.close();
                        } else {
                            swal({
                                title: 'เกิดข้อผิดพลาด',
                                type: 'error'
                            });
                        }
                    },
                    error: function(error) {
                        swal({
                            title: error.responseText,
                            type: 'error'
                        });
                    }
                });
        } else {
            swal.close();
        }
    }

    function countCigarette() {
        if ($('#cigarette_delivery_rates').val() != '') {
            var value = parseFloat($('#cigarette_delivery_rates').val()).toFixed(4);
            $('#cigarette_delivery_rates').val(value);
            $('input[name="cigarette_delivery_rates"]').val(value);
            if (data_last == null) {
                $('input[name="cigarette_delivery_rates_number"]').val('+' + value);
            } else {
                if (data_last['cigarette_delivery_rates'] <= value) {
                    var x = parseFloat(value - data_last['cigarette_delivery_rates']).toFixed(4);
                    $('input[name="cigarette_delivery_rates_number"]').val('+' + x);
                } else {
                    var x = parseFloat(data_last['cigarette_delivery_rates'] - value).toFixed(4);
                    $('input[name="cigarette_delivery_rates_number"]').val('-' + x);
                }
            }
        }
    }

    function countLeaf(){
        if($('input[name="leaf_delivery_rates"]').val() != ''){
            var value = parseFloat($('input[name="leaf_delivery_rates"]').val()).toFixed(4);
            $('input[name="leaf_delivery_rates"]').val(value);
            if (data_last == null) {
                $('input[name="leaf_delivery_rates_number"]').val('+' + value);
            } else {
                if (data_last['leaf_delivery_rates'] <= value) {
                    var x = parseFloat(value - data_last['leaf_delivery_rates']).toFixed(4);
                    $('input[name="leaf_delivery_rates_number"]').val('+' + x);
                } else {
                    var x = parseFloat(data_last['leaf_delivery_rates'] - value).toFixed(4);
                    $('input[name="leaf_delivery_rates_number"]').val('-' + x);
                }
            }
        }
    }

    function countOther(){
        if($('input[name="other_delivery_rates"]').val() != ''){
            var value = parseFloat($('input[name="other_delivery_rates"]').val()).toFixed(4);
            $('input[name="other_delivery_rates"]').val(value);
            if (data_last == null) {
                $('input[name="other_delivery_rates_number"]').val('+' + value);
            } else {
                if (data_last['other_delivery_rates'] <= value) {
                    var x = parseFloat(value - data_last['other_delivery_rates']).toFixed(4);
                    $('input[name="other_delivery_rates_number"]').val('+' + x);
                } else {
                    var x = parseFloat(data_last['other_delivery_rates'] - value).toFixed(4);
                    $('input[name="other_delivery_rates_number"]').val('-' + x);
                }
            }
        }
    }

</script>
@endsection
