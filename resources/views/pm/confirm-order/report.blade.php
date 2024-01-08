@extends('layouts.app')

@section('title', 'User')

@section('page-title')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ใบโอนวัตถุดิบ/วัสดุเพื่อใช้ในการผลิต</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    @if (canEnter('/users'))
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Create
        </a>
    @endif
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="row">
                        <div class="col-lg-8">
                            <h2>Title</h2>
                        </div>
                        <div class="col-lg-4">
                            <a href="{{ route('pm.sample-report.report1-pdf',['number'=> $ptpmHead->request_number]) }}" class="col-lg-2 btn btn-primary" style="float: right">PDF</a>
                            {{-- <a href="{{ route('pm.sample-report.report-vue') }}" class="col-lg-2 btn btn-primary" style="float: right">PDF</a> --}}
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-4"><strong>โปรแกรม :</strong>{{ $ptpmHead->program_code_att13 }}</div>
                        <div class="col-md-4" style="text-align: center"><strong>การยาสูบแห่งประเทศไทย</strong></div>
                        <div class="col-md-4" style="text-align: right"><strong>วันที่ :</strong> {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><strong>สั่งพิมพ์ : </strong>{{ $ptpmHead->user_web_id_att12 }}</div>
                        <div class="col-md-4" style="text-align: center"><strong>ใบโอนวัตถุดิบ/วัสดุเพื่อใช้ในการผลิต</strong></div>
                        <div class="col-md-4" style="text-align: right"><strong>เวลา :</strong> {{ Carbon\Carbon::now()->format('H:i') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><strong>พิมพ์ครั้งที่ :</strong>1</div>
                        <div class="col-md-3"><strong>วันที่ขอเบิก :</strong>{{ Carbon\Carbon::parse($ptpmHead->creation_date)->addYear('543')->format('d/m/Y') }}</div>
                        <div class="col-md-3"><strong>วันที่นำส่ง รยส. :</strong>{{ Carbon\Carbon::parse($ptpmHead->transaction_date)->addYear('543')->format('d/m/Y') }}</div>
                        <div class="col-md-3" style="text-align: right"><strong>หน้า : </strong>1</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><strong>หน่วยงาน : </strong>{{ $ptpmHead->organization_id }}</div>
                        <div class="col-md-6" style="text-align: right"><strong>ใบขอเบิกเลขที :</strong>{{ $ptpmHead->request_number }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="text-align: left"><strong>หน่วยงาน : </strong>{{ $ptpmHead->organization_id }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>รห้สวัตถุดิบ</th>
                                        <th>รายการ</th>
                                        <th>ปริมาณที่เบิก</th>
                                        <th>หน่วยนับ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ptpmItems as $item)
                                        <tr>
                                            <td>{{ $item->inventory_item_id }}</td>
                                            <td>{{ $item->item_segment1 }}</td>
                                            <td>{{ $item->transaction_quantity }}</td>
                                            <td>{{ $item->transaction_uom }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 pb-5" style="text-align: center">จบรายงาน</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" style="text-align: center">
                            <strong>ผู้ขอเบิก</strong><br><br>
                            <strong>ลงชื่อ_________________</strong><br>
                            <strong class="ml-4">(____________________)</strong><br>
                            <strong>ตำแหน่ง_________________</strong><br>
                        </div>
                        <div class="col-md-2" style="text-align: center">
                            <strong>ผู้มีอำนาจอนุมัติ</strong><br><br>
                            <strong>ลงชื่อ_________________</strong><br>
                            <strong class="ml-4">(____________________)</strong><br>
                            <strong>ตำแหน่ง_________________</strong><br>
                        </div>
                        <div class="col-md-2" style="text-align: center">
                            <strong>ผู้จ่ายพัสดุ</strong><br><br>
                            <strong>ลงชื่อ_________________</strong><br>
                            <strong class="ml-4">(____________________)</strong><br>
                            <strong>ตำแหน่ง_________________</strong><br>
                        </div>
                        <div class="col-md-2" style="text-align: center">
                            <strong>ผู้รับพัสดุ</strong><br><br>
                            <strong>ลงชื่อ_________________</strong><br>
                            <strong class="ml-4">(____________________)</strong><br>
                            <strong>ตำแหน่ง_________________</strong><br>
                        </div>
                        <div class="col-md-3" style="text-align: center">
                            <strong>ผู้บันทึกเข้าระบบ</strong><br>
                            <strong>คลังสินค้า</strong><br>
                            <strong>ลงชื่อ_________________</strong><br>
                            <strong class="ml-4">(____________________)</strong><br>
                            <strong>ตำแหน่ง_________________</strong><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
