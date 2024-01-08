@extends('layouts.app')

@section('title', 'INV Fuel Gas')
    
@section('page-title')
    <h2>ค้นหาข้อมูลรถยนต์</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Fuel</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ค้นหาข้อมูลรถยนต์</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-content">

            <form action="">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label tw-flex tw-items-center">ทะเบียนรถยนต์</label>
                            <disbursement-fuel-search-car-component       
                                name="car_license_plate"
                                class="col-md-6"
                            ></disbursement-fuel-search-car-component>
                            <button class="btn btn-sm btn-primary px-3">ค้นหา</button>
                            <a href="/inv/disbursement_fuel/show" class="btn btn-sm btn-link tw-flex tw-items-center">ล้างข้อมูล</a>
                        </div>
                    </div>
                </div>
            </form>

            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th>ทะเบียนรถยนต์</th>
                        <th>กลุ่มรถยนต์</th>
                        <th>ยี่ห้อรถยนต์</th>
                        <th>ชนิดน้ำมันที่เติม</th>
                        <th hidden>รหัสพนักงาน</th>
                        <th hidden>ประเภท</th>
                        <th hidden>ตำแหน่ง</th>
                        <th hidden>สังกัด</th>
                        <th>รหัสบัญชี</th>
                        <th>โควต้า / เดือน</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carInfos as $carInfo)
                        <tr>
                            <td>{{ $carInfo->car_license_plate }}</td>
                            <td>{{ $carInfo->car_group_desc ? $carInfo->car_group_desc : "-" }}</td>
                            <td>{{ $carInfo->car_brand_desc ? $carInfo->car_brand_desc : "-" }}</td>
                            <td>{{ $carInfo->item_description ? $carInfo->item_description : "-" }}</td>
                            <td hidden>{{ $carInfo->car_user ? $carInfo->car_user : "-" }}</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td hidden>{{ optional($carInfo->department)->description ? optional($carInfo->department)->description : "-" }}</td>
                            <td>{{ $carInfo->account_code ? $carInfo->account_code : "-" }}</td>
                            <td>{{ $carInfo->quota_per_month ? $carInfo->quota_per_month : "-" }}</td>
                            <td>
                                @if ($carInfo->source_data == 'FA')
                                    <a href="{{ route('inv.disbursement_fuel.edit', [$carInfo->car_license_plate]) }}" class="btn btn-xs btn-warning">แก้ไข</a>
                                @endif
                                @if ($carInfo->source_data == 'NON_FA')
                                    <a href="{{ route('inv.disbursement_fuel.edit-non-fa', [$carInfo->car_license_plate]) }}" class="btn btn-xs btn-warning">แก้ไข</a>
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tw-flex tw-justify-center tw-my-5">
            {{ $carInfos->links() }}
        </div>
    </div>
@endsection