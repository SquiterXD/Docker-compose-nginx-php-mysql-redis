@extends('layouts.app')

@section('title', 'อนุมัติเพดานการจำหน่าย/สำหรับผู้อนุมัติ')

@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
<h2><x-get-program-code url="/om/addition-quota/approve/step" /> อนุมัติเพดานการจำหน่าย/สำหรับผู้อนุมัติ</h2>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/">หน้าแรก</a>
    </li>
    <li class="breadcrumb-item active">
        <strong>อนุมัติเพดานการจำหน่าย/สำหรับผู้อนุมัติ</strong>
    </li>
</ol>
@stop

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
                <h2 class="paper-title">ขออนุมัติเพิ่มเพดานการจำหน่าย</h2>
                <form method="POST" action="{{ route('om.addition-quota-update') }}" id="stepone">
                    @csrf
                    <input type="hidden" name="addition_id" value="{{ $addtion->quota_header_id }}" >
                    <input type="hidden" name="step" value="{{ $step }}" >
                <div class="row">

                    @if($addtion->approve_status == 'รอการอนุมัติ' && $step != 5)
                    <div class="col-md-12">
                        <div class="form-header-buttons">
                            <div class="buttons">
                                <button class="btn btn-md btn-primary w-en" type="submit" name="status_approve" value="อนุมัติ"><i class="fa fa-check"></i> อนุมัติ</button>
                                <button class="btn btn-md btn-danger w-en" type="submit" name="status_approve" value="ไม่อนุมัติ"><i class="fa fa-times"></i> ปฏิเสธ</button>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                    </div>
                    @endif

                    <div class="col-md-12">
                        <div class="paper-row p-0">
                            <table class="table-infos">
                                <tbody><tr>
                                    <td class="pr-3">From</td>
                                    <td>{{ $sqluserfrom[0]->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-3">To</td>
                                    <td>{{ $sqluserto[0]->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-3">Sent</td>
                                    <td>{{ $dbsql[0]->last_update_date ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-3">ID</td>
                                    <td>{{ $addtion->quota_header_id }}</td>
                                </tr>
                            </tbody></table>
                        </div>

                        <div class="paper-row pt-4">
                            <strong>เรียน</strong> ผู้ว่าการ<br>
                        </div>
                    </div><!--col-md-12-->

                     <div class="col-md-12">
                        <div class="paper-row pl-5 pt-3 pb-0">
                            <div class="item">
                                <!-- ร้าน {{ $customer[0]->customer_name }} {{ $customer[0]->province_thai }} ขออนุมัติเพิ่มเพดานการจำหน่าย ประจำงวด {{ FormatDate::DateThai(dayTHcompare($customer[0]->delivery_date,$order_dates[0]->order_date)) }} -->
                                ร้าน {{ $customer[0]->customer_name }} {{ $customer[0]->province_thai }} ขออนุมัติเพิ่มเพดานการจำหน่าย ประจำงวด {{ FormatDate::DateThai($order_dates[0]->delivery_date) }}
                            </div>
                        </div>

                        <div class="paper-row ">
                            <div class="item">
                                เนื่องจาก {{ $addtion->reason }} <br>
                                ดังนี้
                            </div>
                        </div>
                    </div><!--col-md-12-->


                    <div class="col-xl-12 pt-2">
                        <!--div class="table-unit-label">หน่วย : หีบ</div-->
                        <div class="table-responsive-xl">
                            <table class="table table-bordered text-center" id="table_approve">
                                <thead>
                                    <tr class="align-middle text-center">
                                        <th>กลุ่ม</th>
                                        <th>เพดาน</th>
                                        <th>อนุมัติก่อนหน้า <br>(ในสัปดาห์)</th>
                                        <th>ขอเพิ่ม</th>
                                        <th>รวมทั้งหมด</th>
                                        <th>ยอดซื้อ<br>(งวดล่าสุด)</th>
                                        <th>จำนวนอนุมัติ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($meaning as $key => $mean)
                                    <input type="hidden" name="lookupcodes_hidden[]" value="{{ $lookupcodes[$key] ?? '' }}">
                                    <input type="hidden" name="headers_hidden[]" value="{{ $headers[$key] ?? '' }}">
                                    <input type="hidden" name="line_id[]" value="{{ $line_id[$key] ?? '' }}">
                                    <tr class="align-middle">
                                        <td class="text-left">{{ $key +1 }}. {{ $mean }}</td>
                                        <td>{{ $received_quota[$key]/10 }}</td>
                                        <td>@if($orderB[$key] != '-') {{ $orderB[$key] }} @else - @endif</td>
                                        <td><input type="hidden" name="order_quantity_hidden[]" value="{{ number_format($order_quantity[$key],2) }}">{{ number_format($order_quantity[$key],2) }}</td>
                                        <td>{{ (($received_quota[$key]/10) + $order_quantity[$key]) }}</td>
                                        <td>@if($before_quantity[$key] == 0) - @else {{ $before_quantity[$key]/10 }} @endif</td>
                                        <td><input type="text" onchange="replacenumbertoformat(this,this.value);" class="form-control text-center" name="approve_quantity[]" value="{{ number_format($order_approve[$key],2) }}" required @if($step == 5) readonly @endif></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!--table-responsive-md-->

                        <div class="paper-row">
                            <div class="item mt-2 mb-2">จึงเรียนมาเพื่อโปรดพิจารณา</div>
                        </div>
                    </div><!--col-xl-12-->

                    <div class="col-md-12 pt-4">
                        <div class="paper-row">
                            <div class="signature">
                                <div class="item"><span class="line"></span></div>
                                <div class="item"><span class="name">({{ $dataOwner[0]->prefix ?? '' }} {{ $dataOwner[0]->owner_first_name ?? '' }}  {{ $dataOwner[0]->owner_last_name ?? '' }})</span></div>
                                <div class="item">ผู้ทรงสิทธิ์</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="hr-line-dashed"></div>

                        <p>ไฟล์แนบ</p>
                        @if(!empty($files))
                        @foreach($files as $keyfile => $file)
                            <p><code><a href="{{ route('om.addition-download',$file->attachment_id) }}" target="_blank"><i class="fa fa-file-pdf-o"></i> {{ $file->file_name }}</a></code></p>
                        @endforeach
                        @endif
                        @if($addtion->approve_status == 'รอการอนุมัติ')
                        <div class="form-group">
                            <label class="d-block">หมายเหตุจากผู้อนุมัติ</label>
                            <textarea class="form-control" name="approvecomment" @if($step == 5) readonly @endif></textarea>
                        </div>
                        @endif

                        @if($step != 4)
                        <p>Approver</p>

                        <div class="table-responsive-md">
                            <table class="table table-bordered text-center" id="approvenumber">
                                <thead>
                                    <tr>
                                        <th style="width: 80px">ลำดับที่</th>
                                        <th>จากผู้อนุมัติ</th>
                                        <th>ถึงผู้อนุมัติ</th>
                                        <th>สถานะ</th>
                                        <th>หมายเหตุจากผู้อนุมัติ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    @if($approvers[0]->employee_sales_division != null)
                                    <tr>
                                        {{-- <td>1</td> --}}
                                        <td></td>
                                            <td>{{ returnUserName($approvers[0]->employee_sales_division) }}</td>
                                            @if($approvers[0]->status_empolyee_approve4 == 'A')
                                                @if($approvers[0]->employee_approve1 != null)
                                                    <td>{{ returnUserName($approvers[0]->employee_approve1) }}</td>
                                                @elseif($approvers[0]->employee_approve2 != null)
                                                    <td>{{ returnUserName($approvers[0]->employee_approve2) }}</td>
                                                @else
                                                    <td>{{ returnUserName($approvers[0]->employee_approve3) }}</td>
                                                @endif
                                                @if($approvers[0]->status_empolyee_approve4)
                                                    <td style="background-color:#00FF00">{{ $approvers[0]->status_empolyee_approve4 == 'A' ? 'อนุมัติ' : 'ไม่อนุมัติ' }}</td>
                                                @else
                                                    <td style="background-color:#FF0000">{{ $approvers[0]->status_empolyee_approve4 == 'A' ? 'อนุมัติ' : 'ไม่อนุมัติ' }}</td>
                                                @endif
                                            @else
                                                <td></td>
                                                <td style="background-color: #FFFF00;">รอการอนุมัติ</td>
                                            @endif
                                        <td>{{ $approvers[0]->comment_sales }}</td>
                                    </tr>
                                    @endif


                                    @if($approvers[0]->employee_approve1 != null)
                                    <tr>
                                        {{-- <td>@if($approvers[0]->employee_sales_division != null) 2 @else 1 @endif</td> --}}
                                        <td></td>
                                        <td>{{ returnUserName($approvers[0]->employee_approve1) }}</td>
                                        @if($approvers[0]->status_empolyee_approve1 == 'A')
                                            @if($approvers[0]->employee_approve2 != null)
                                                <td>{{ returnUserName($approvers[0]->employee_approve2) }}</td>
                                            @else
                                                <td>{{ returnUserName($approvers[0]->employee_approve3) }}</td>
                                            @endif
                                            @if($approvers[0]->status_empolyee_approve1)
                                                    <td style="background-color:#00FF00">{{ $approvers[0]->status_empolyee_approve1 == 'A' ? 'อนุมัติ' : 'ไม่อนุมัติ' }}</td>
                                                @else
                                                    <td style="background-color:#FF0000">{{ $approvers[0]->status_empolyee_approve1 == 'A' ? 'อนุมัติ' : 'ไม่อนุมัติ' }}</td>
                                                @endif
                                        @else
                                            <td></td>
                                            <td style="background-color: #FFFF00;">รอการอนุมัติ</td>
                                        @endif
                                        <td>{{ $approvers[0]->comment_employee1 }}</td>
                                    </tr>
                                    @endif


                                    @if($approvers[0]->employee_approve2 != null)
                                    <tr>
                                        {{-- <td>@if($approvers[0]->employee_approve1 != null) 3 @else @if($approvers[0]->employee_sales_division != null) 2 @else 1 @endif @endif</td> --}}
                                        <td></td>
                                        <td>{{ returnUserName($approvers[0]->employee_approve2) }}</td>
                                        @if($approvers[0]->status_empolyee_approve2 == 'A')
                                            @if($approvers[0]->employee_approve3 != null)
                                                <td>{{ returnUserName($approvers[0]->employee_approve3) }}</td>
                                            @endif
                                            @if($approvers[0]->status_empolyee_approve2)
                                                    <td style="background-color:#00FF00">{{ $approvers[0]->status_empolyee_approve2 == 'A' ? 'อนุมัติ' : 'ไม่อนุมัติ' }}</td>
                                                @else
                                                    <td style="background-color:#FF0000">{{ $approvers[0]->status_empolyee_approve2 == 'A' ? 'อนุมัติ' : 'ไม่อนุมัติ' }}</td>
                                                @endif
                                        @else
                                            <td></td>
                                            <td style="background-color: #FFFF00;">รอการอนุมัติ</td>
                                        @endif
                                        <td>{{ $approvers[0]->comment_employee2 }}</td>
                                    </tr>
                                    @endif


                                    @if($approvers[0]->employee_approve3 != null)
                                    <tr>
                                        {{-- <td>@if($approvers[0]->employee_approve1 == null && $approvers[0]->employee_approve2 == null) 2 @else @if($approvers[0]->employee_sales_division == null) 2 @else @if($approvers[0]->employee_approve1 == null || $approvers[0]->employee_approve2 == null) 3 @else 4 @endif @endif @endif</td> --}}
                                        <td></td>
                                        <td>{{ returnUserName($approvers[0]->employee_approve3) }}</td>
                                        <td></td>
                                        @if($approvers[0]->status_empolyee_approve3 == 'A')
                                        @if($approvers[0]->status_empolyee_approve3)
                                                    <td style="background-color:#00FF00">{{ $approvers[0]->status_empolyee_approve3 == 'A' ? 'อนุมัติ' : 'ไม่อนุมัติ' }}</td>
                                                @else
                                                    <td style="background-color:#FF0000">{{ $approvers[0]->status_empolyee_approve3 == 'A' ? 'อนุมัติ' : 'ไม่อนุมัติ' }}</td>
                                                @endif
                                        @else
                                        <td style="background-color: #FFFF00;">รอการอนุมัติ</td>
                                        @endif
                                        <td>{{ $approvers[0]->comment_employee3 }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div><!--table-responsive-md-->
                        @endif
                    </div>
                </div><!--row-->
            </form>
            </div><!--paper-content-->
        </div><!--ibox-content-->
    </div><!--ibox-->


</div>
@endsection

@section('scripts')
<script src="{!! asset('js/number.js') !!}"></script>
<script>
    $(document).ready(function() {
        $('#approvenumber >tbody >tr').each(function(a, b) {
            $(b).find('td:first').text(a+1)
        })
    });
    function replacenumbertoformat(v,l){
        if ((v.which != 46 || l.indexOf('.') != -1 || l.indexOf(',') != -1) && (v.which < 48 || v.which > 57 || v.whitch === 188 || v.which === 110)) {
            v.preventDefault();
        } else {
            var rowjQuery = $(v).closest("tr");
            var index = rowjQuery[0].rowIndex - 1;
            if(v == ''){
                console.log('2');
                $('#table_approve tbody tr:eq(' + index + ')').find('input[name="approve_quantity[]"]').val('0.00');
            } else {
                console.log('3');
                $('#table_approve tbody tr:eq(' + index + ')').find('input[name="approve_quantity[]"]').val($.number(l,2));
            }
        }
    }
</script>
@endsection
