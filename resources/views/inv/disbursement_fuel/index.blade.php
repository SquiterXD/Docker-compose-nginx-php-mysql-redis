@extends('layouts.app')

@section('title', 'INV Fuel Gas')
    
@section('page-title')
    <h2>สรุปรายการเบิกจ่ายน้ำมันเชื้อเพลิง</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Fuel</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>สรุปรายการเบิกจ่ายน้ำมันเชื้อเพลิง</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">

                    <form action="">
                        <div class="card">
                            <div class="card-body">
                                 <div class="col-12">

                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label">วันที่เติมน้ำมัน</label>
                                        <div class="col-md-4">
                                            <date-range-picker-component
                                                :start-date="{{ json_encode(request()->start_date)}}"
                                                :end-date="{{ json_encode(request()->end_date)}}"
                                            ></date-range-picker-component>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label">ค้นหาตามหน่วยงาน</label>
                                        <div class="col-md-4">
                                            <select name="department_code" class="form-control">
                                                <option value="{{$departmentUser->department_code}}" 
                                                    {{  request()->department_code == null
                                                        && request()->organization_id == null
                                                        && request()->subinventory_code == null
                                                        && request()->start_date == null
                                                        && request()->end_date == null
                                                        && request()->car_fuel == null
                                                        && request()->show == null
                                                        && request()->car_license_plate == null
                                                        ? 'selected' 
                                                        : null }} >
                                                            {{$departmentUser->department_code}} - {{$departmentUser->description}}
                                                    </option>
                                                <option value="" {{ !empty(request()->all()) ? 'selected' : null}}></option>
                                                @foreach ($coaDeptCodeVs as $deptCode)
                                                    <option value="{{$deptCode->department_code}}" {{ request()->department_code == $deptCode->department_code ? 'selected' : null}}>
                                                        {{$deptCode->department_code}} - {{ $deptCode->description}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label">ค้นหาตาม Organization</label>
                                        <div class="col-md-4">
                                            <select name="organization_id" class="form-control">
                                                <option value="" selected></option>
                                                @foreach ($organizationUnits as $organizationUnit)
                                                    <option value="{{$organizationUnit->organization_id}}" {{ request()->organization_id  == $organizationUnit->organization_id ? 'selected' : null }}>
                                                        {{$organizationUnit->parameters->first()->organization_code}} - {{ $organizationUnit->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label">ค้นหาตาม Subinventory</label>
                                        <div class="col-md-4">
                                            <select name="subinventory_code" class="form-control">
                                                <option value="" selected></option>
                                                @foreach ($subInventories as $subInventory)
                                                    <option value="{{$subInventory->secondary_inventory_name}}" {{ request()->subinventory_code  == $subInventory->secondary_inventory_name ? 'selected' : null }}>
                                                        {{$subInventory->secondary_inventory_name}} - {{ $subInventory->description }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label">ค้นหาตามประเภทน้ำมัน</label>
                                        <div class="col-md-4">
                                            <select name="car_fuel" class="form-control">
                                                <option value="" selected></option>
                                                @foreach ($carFuels as $carFuel)
                                                    <option value="{{$carFuel->segment1}}" {{ request()->car_fuel  == $carFuel->segment1 ? 'selected' : null }}>
                                                        {{$carFuel->description}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label">การแสดง</label>
                                        <div class="col-md-4">
                                            <select name="show" class="form-control">
                                                <option value="" selected></option>
                                                <option value="active" {{ request()->show  == 'active' ? 'selected' : null }}>ไม่แสดงรายการยกเลิก</option>
                                                <option value="all" {{ request()->show  == 'all' ? 'selected' : null }}>แสดงรายการทั้งหมด</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label">ค้นหาตามทะเบียนรถ</label>
                                        <div class="col-md-4">
                                            <disbursement-fuel-search-car-component       
                                                name="car_license_plate"
                                                default="{{request()->car_license_plate}}"
                                            ></disbursement-fuel-search-car-component>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label"></label>
                                        <div class="col-10 offset-col-2">
                                            <button class="btn btn-primary">ค้นหา</button>
                                            <a href="/inv/disbursement_fuel" class="btn btn-link">ล้างข้อมูล</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr>
                    <div class="table-responsive-xl tw-overflow-x-auto tw-overflow-y-auto" style="height: 45rem;">
                        <table class="table table-bordered table-sm">
                            <thead class="tw-sticky tw-top-0">
                                <tr class="tw-text-center tw-min-w-full">
                                    <th class="tw-whitespace-nowrap">วันที่เติมน้ำมัน</th>
                                    <th class="tw-whitespace-nowrap">เลขที่ใบเสร็จ</th>
                                    <th>เลขที่เอกสาร</th>
                                    <th class="tw-whitespace-nowrap">ทะเบียนรถที่นำมาเติม</th>
                                    <th>ประเภทรถ</th>
                                    <th>หน่วยงานของเจ้าของรถ</th>
                                    <th class="tw-whitespace-nowrap">คลังสินค้าย่อย</th>
                                    <th>ตำแหน่ง</th>
                                    <th class="tw-whitespace-nowrap">ประเภทน้ำมัน</th>
                                    <th hidden>ราคาน้ำมัน</th>
                                    <th class="tw-whitespace-nowrap">จำนวนที่เติม</th>
                                    <th hidden>ราคารวม</th>
                                    <th>Lot Number</th>
                                    <th class="tw-whitespace-nowrap">วันที่ทำรายการ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($webFuelOils as $webFuelOil)
                                    @php
                                        $currentTransactionId = null
                                    @endphp

                                    @foreach ($webFuelOil->webFuelDists as $webFuelDist)
                                        <tr class="tw-text-xs">
                                            @if ($webFuelDist->transaction_id != $currentTransactionId)
                                                <td rowspan="{{ count($webFuelOil->webFuelDists) }}">
                                                    {{ parseToDateTh($webFuelOil->gl_date) }}
                                                </td>
                                                <td rowspan="{{ count($webFuelOil->webFuelDists) }}">
                                                    {{ $webFuelOil->receipt_number }}
                                                </td>
                                                <td class="tw-whitespace-nowrap" rowspan="{{ count($webFuelOil->webFuelDists) }}">
                                                    {{ $webFuelOil->document_number }}
                                                </td>
                                                <td rowspan="{{ count($webFuelOil->webFuelDists) }}">
                                                    {{ $webFuelOil->car_license_plate }}
                                                </td>
                                                <td class="tw-whitespace-nowrap" rowspan="{{ count($webFuelOil->webFuelDists) }}">
                                                    {{ optional($webFuelOil->carInfos)->car_group_desc }}
                                                </td>
                                                <td class="tw-whitespace-nowrap" rowspan="{{ count($webFuelOil->webFuelDists) }}">
                                                    {{ optional(optional($webFuelOil->carInfos)->department)->department_code }} - {{ optional(optional($webFuelOil->carInfos)->department)->description }}
                                                </td>
                                                <td rowspan="{{ count($webFuelOil->webFuelDists) }}">
                                                    {{ $webFuelDist->subinventory_code }}
                                                </td>
                                                <td rowspan="{{ count($webFuelOil->webFuelDists) }}">
                                                    {{ $webFuelDist->locator }}
                                                </td>
                                                <td class="tw-whitespace-nowrap" rowspan="{{ count($webFuelOil->webFuelDists) }}">
                                                    {{ optional($webFuelOil->carInfos)->item_description }}
                                                </td>
                                            @endif

                                            <td hidden>
                                                {{ number_format($webFuelDist->unit_price, 2) }} บาท
                                            </td>
                                            <td>
                                                {{ $webFuelDist->quantity }} ลิตร
                                            </td>
                                            <td hidden>
                                                {{ number_format($webFuelDist->total_amount, 2) }} บาท
                                            </td>
                                            <td class="tw-whitespace-nowrap">
                                                {{ $webFuelDist->lot_number }}
                                            </td>

                                            @if ($webFuelDist->transaction_id != $currentTransactionId)
                                                <td rowspan="{{ count($webFuelOil->webFuelDists) }}">
                                                    {{ parseToDateTh($webFuelOil->transaction_date) }}
                                                </td>
                                                <td class="tw-whitespace-nowrap" rowspan="{{ count($webFuelOil->webFuelDists) }}">
                                                    @if ($webFuelOil->deleted_at == null)
                                                        <disbursement-fuel-cancel-component
                                                            :cancelled="false"
                                                            :web-fuel-oil="{{json_encode($webFuelOil)}}"
                                                        ></disbursement-fuel-cancel-component>
                                                    @elseif ($webFuelOil->deleted_at)
                                                        <disbursement-fuel-cancel-component
                                                            :cancelled="true"
                                                            :web-fuel-oil="{{json_encode($webFuelOil)}}"
                                                        ></disbursement-fuel-cancel-component>
                                                    @endif
                                                    
                                                </td>
                                            @endif
                                            
                                            @php
                                                $currentTransactionId = $webFuelDist->transaction_id == $currentTransactionId 
                                                    ? $currentTransactionId 
                                                    : $webFuelDist->transaction_id;
                                            @endphp
                                        </tr>
                                    @endforeach

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="tw-flex tw-justify-center tw-my-5">
                        {{ $webFuelOils->appends(Request::all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
