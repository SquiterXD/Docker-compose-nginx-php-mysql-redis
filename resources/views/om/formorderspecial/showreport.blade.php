<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOAT - อนุมัติแบบฟอร์มการขออนุมัติสั่งซื้อกรณีพิเศษ </title>

    <meta name="csrf-param" content="_token">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />
    @show

</head>
<body>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-content">
            <div class="paper-content">
                <div class="paper-logo">
                    <img class="logo" src="img/logo.png" alt="">
                    <div class="infos">
                        <p>การยาสูบแห่งประเทศไทย</p>
                        <p>Tobacco Authority Of Thailand</p>
                    </div>
                </div><!--paper-logo-->
                <h2 class="paper-title">ใบขออนุมัติสั่งซื้อกรณีพิเศษ <br>อนุมัติครั้งที่ {{$countFromHeaderId}}/{{ FormatDate::Yearonly($getBudgetYear) }}</h2>
                <form action="{{ url('om/form-order/approve') }}" method="POST">
                    @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="paper-row text-right">
                            <div class="item">
                                {{ $info->customer_name }}<br>
                                {{ $info->address_line1 }} {{ $info->address_line2 }} {{ $info->address_line3 }} {{ $info->alley }} {{ $info->district }}<br>
                                {{ $info->city }} {{ $info->province }} {{ $info->postal_code }}

                            </div>
                        </div>
                    </div><!--col-md-12-->

                    <div class="col-md-12 pt-3">
                        <div class="paper-row text-right">
                            <div class="item">วันที่ <span class="highlight">{{ FormatDate::Dayonly($info->creation_date) }}</span></div>
                            <div class="item">เดือน <span class="highlight">{{ FormatDate::Monthonly($info->creation_date) }}</span></div>
                            <div class="item">พ.ศ. <span class="highlight">{{ FormatDate::Yearonly($info->creation_date) }}</span></div>
                        </div>
                    </div><!--col-md-12-->

                    <div class="col-md-12">
                        <div class="paper-row">
                            เรียน ผู้อำนวยการฝ่ายขาย
                        </div>
                    </div><!--col-md-12-->

                    <div class="col-md-12">
                        <div class="paper-row pl-md d-xl-flex align-items-center">
                            <div class="item">
                                ด้วย <span class="highlight">{{ $info->customer_name }}</span>
                            </div>
                            <div class="item d-md-flex">
                                ขออนุมัติสั่งซื้อกรณีพิเศษ (วันที่/งวด)
                                <span class="highlight pr-2">{{ FormatDate::DateThai($info->to_period_date) }}</span>
                                ดังนี้
                            </div>
                        </div>
                    </div><!--col-md-12-->

                    <div class="col-xl-12 pt-2">
                        <div class="table-unit-label">หน่วย : หีบ</div>
                        <div class="table-responsive-xl">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr class="align-middle text-center">
                                        <th class="w-90">ลำดับ</th>
                                        <th class="min-150">กลุ่ม</th>
                                        <th class="w-90">ขอเพิ่ม</th>
                                        <th class="w-90">จำนวนอนุมัติ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0;$totalapp = 0; ?>
                                    @foreach($quotas as $quota)
                                    <tr class="align-middle">
                                        <input type="hidden" value="{{ $quota->form_line_id }}" name="form_line_id[]" id="form_line_id">
                                        <td class="w-90">{{ $quota->form_number }}</td>
                                        <td class="text-left min-150">{{ $quota->item_description }} </td>
                                        <td class="red w-90">{{ $quota->quantity }}</td>
                                        <td class="w-90"><input type="text" class="form-control text-center" readonly name="approve_quantity[]" id="approve_quantity" value="@if($info->approve_status == 'อนุมัติ') {{ $quota->approve_quantity }} @endif" @if($info->approve_status == 'อนุมัติ') readonly @endif></td>
                                    </tr>
                                    <?php $total += $quota->quantity;$totalapp += $quota->approve_quantity; ?>
                                    @endforeach
                                    <tr class="align-middle">
                                        <td colspan="2">รวม</td>
                                        <td>{{ $total }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--table-responsive-md-->

                        <div class="paper-row">
                            <div class="item mb-2">จึงเรียนมาเพื่อโปรดพิจารณา</div>
                        </div>
                    </div><!--col-xl-12-->

                    <div class="col-md-12 pt-2">
                        <div class="paper-row">
                            <div class="signature">
                                <div class="item">ขอแสดงความนับถือ</div>
                                <div class="item">ลงชื่อ <span class="name">({{ $act->prefix }} {{ $act->owner_first_name }} {{ $act->owner_last_name }})</span></div>
                                <div class="item">ผู้ทรงสิทธิ์</div>
                            </div>
                        </div>
                    </div><!--col-md-12-->
                </div><!--row-->
            </form>
            </div><!--paper-content-->
        </div><!--ibox-content-->
    </div><!--ibox-->

</div>
<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/vendor/app.js') !!}" type="text/javascript"></script>

</body>
</html>
