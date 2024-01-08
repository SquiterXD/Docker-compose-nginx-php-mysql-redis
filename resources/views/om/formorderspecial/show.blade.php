@extends('layouts.app')

@section('title', 'อนุมัติแบบฟอร์มการขออนุมัติสั่งซื้อกรณีพิเศษ')

@section('page-title')
    <h2>อนุมัติแบบฟอร์มการขออนุมัติสั่งซื้อกรณีพิเศษ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>อนุมัติแบบฟอร์มการขออนุมัติสั่งซื้อกรณีพิเศษ</strong>
        </li>
    </ol>
@stop

<style>
    .paper-content {font-size: 1rem;}
</style>

@section('content')
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
                                    @foreach($quotas as $key => $quota)
                                    <tr class="align-middle">
                                        <input type="hidden" value="{{ $quota->form_line_id }}" name="form_line_id[]" id="form_line_id">
                                        <td class="w-90">{{ $quota->form_number }}</td>
                                        <td class="text-left min-150">{{ $quota->item_description }} </td>
                                        <td class="red w-90">{{ $quota->quantity }}</td>
                                        <td class="w-90"><input type="text" class="form-control text-center" name="approve_quantity[]" id="approve_quantity" @if($info->approve_status == 'อนุมัติ') value="{{ $quota->approve_quantity }}" @else value="{{ old('approve_quantity.'.$key) }}" @endif @if($info->approve_status == 'อนุมัติ') readonly @endif></td>
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
                    <input type="hidden" name="id" value="{{ $info->form_header_id }}">
                    @if($info->approve_status == 'รอการอนุมัติ')
                    <div class="col-md-12">
                        <div class="form-buttons">
                            <button class="btn btn-lg btn-danger w-160" type="submit" id="disapproved" name="updateStatus" value="ไม่อนุมัติ"><i class="fa fa-fw fa-times"></i> ไม่อนุมัติ</button>
                            <button class="btn btn-lg btn-primary w-160" type="submit" id="approve" name="updateStatus" value="อนุมัติ"><i class="fa fa-fw fa-check"></i> อนุมัติ</button>
                        </div>

                         <hr class="lg">
                    </div>
                    @endif


                </div><!--row-->

                @if($info->approve_status == 'รอการอนุมัติ')
                <div class="row space-50 justify-content-md-center mw-xl-1000">
                    <div class="col-xl-8 m-auto">

                        <div class="form-group">
                            <h3 class="black mb-3">โปรดเลือกผู้ทำการ</h3>

                            <label class="d-block">กองบริหารการขาย</label>
                            <div class="row space-100 justify-content-md-center mw-xl-1000">
                                <div class="col-6">
                                {{-- <select class="custom-select" name="employee_approve1">
                                    <option value=""></option>
                                    @foreach($emps as $emp)
                                        <option value="{{ $emp->authority_id }}" @if($info->approve_status == 'อนุมัติ' && $info->employee_approve1 == $emp->authority_id) selected @endif >{{ $emp->employee_name }}</option>
                                    @endforeach
                                </select> --}}
                                    <select class="custom-select" name="employee_approve1">
                                        <option value=""></option>
                                        @foreach($emps as $emp)
                                            <option value="{{ $emp->authority_id }}" @if($info->approve_status == 'อนุมัติ' && $info->employee_approve1 == $emp->authority_id) selected @endif >{{ $emp->employee_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select class="custom-select" name="acting_position_approve1">
                                        <option value=""></option>
                                        @foreach($actingDropdown as $acting)
                                            <option value="{{ $acting->meaning }}" >{{ $acting->meaning }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">เรียนโปรดพิจารณา</label>
                            <div class="row space-100 justify-content-md-center mw-xl-1000">
                                <div class="col-6">
                                    <select class="custom-select" name="employee_approve2">
                                        <option value=""></option>
                                        @foreach($emps as $emp)
                                            <option value="{{ $emp->authority_id }}" @if($info->approve_status == 'อนุมัติ' && $info->employee_approve2 == $emp->authority_id) selected @endif>{{ $emp->employee_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select class="custom-select" name="acting_position_approve2">
                                        <option value=""></option>
                                        @foreach($actingDropdown as $acting)
                                            <option value="{{ $acting->meaning }}" >{{ $acting->meaning }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">ผู้อนุมัติ</label>
                            <div class="row space-100 justify-content-md-center mw-xl-1000">
                                <div class="col-6">
                                    <select class="custom-select" name="employee_approve3">
                                        <option value=""></option>
                                        @foreach($emps as $emp)
                                            <option value="{{ $emp->authority_id }}" @if($info->approve_status == 'อนุมัติ' && $info->employee_approve3 == $emp->authority_id) selected @endif>{{ $emp->employee_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select class="custom-select" name="acting_position_approve3">
                                        <option value=""></option>
                                        @foreach($actingDropdown as $acting)
                                            <option value="{{ $acting->meaning }}" >{{ $acting->meaning }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div><!--form-group-->

                        <div class="form-buttons">
                            <button class="btn btn-lg btn-info w-160" type="button" onclick="window.open('{{ url('om/form-order/report/'.$info->form_header_id) }}','_blank')"><i class="fa fa-print"></i> พิมพ์ใบคำร้อง</ิ>
                        </div>

                    </div>
                </div><!--row-->
                @endif

                {{-- fix comment 25/07/2021 --}}
                @if($info->approve_status == 'อนุมัติ' || $info->approve_status == 'ไม่อนุมัติ')
                    <div class="justify-content-md-center mw-xl-1000">
                        <div class="col-xl-6 py-12 mx-auto text-center mt-5 mb-5">
                            <span>สถานะ : @if($info->approve_status == 'อนุมัติ')<span class="green">{{ $info->approve_status }}</span>@else<span class="red">{{ $info->approve_status }}</span>@endif</span>
                        </div>
                    </div>
                @endif
                {{-- fix comment 25/07/2021 --}}
            </form>
            </div><!--paper-content-->
        </div><!--ibox-content-->
    </div><!--ibox-->

</div>
@endsection
