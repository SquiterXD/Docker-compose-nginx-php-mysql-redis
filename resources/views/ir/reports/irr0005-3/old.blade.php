<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <title> รายงานรถยนต์สิ้นอายุกรมธรรม์ </title>
    @include('ir.reports.irr0005-3._style')
</head>
<body> 
    @foreach ($data as $group => $lists)
        <div class="row">
            <div>
                {{-- <div style="text-align: left;"> <strong> กลุ่ม : {{ $location ? $location->group_desc : '' }} </strong> </div> --}}
                {{-- <div style="text-align: center;"> เดือน {{ $thaimonths[date('m', strtotime($month))]}}  {{ date('Y', strtotime($month))+543 }}</div> --}}
                {{-- <div style="text-align: right"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></div> --}}
            </div>
            <div class="table-responsive">
                <table class="table table-bordered w-100">
                    <thead>
                        <tr style="background-color: #C7CCC5;">
                            <th class="report_header" style="border-top: #000000 solid 1px;">
                                สถานที่ - ยี่ห้อ
                            </th>
                            <th class="report_header" style="border-top: #000000 solid 1px;">
                                ทะเบียนรถยนต์
                            </th>
                            <th class="report_header" style="border-top: #000000 solid 1px;">
                                ระยะเวลาเอาประกัน ตั้งแต่ - สิ้นสุด
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{dd($data)}} --}}
                        {{-- @foreach ($data as $group => $lists) --}}
                            {{-- @php
                                $cars =  carForReport($month, $list->license_plate, $carInsuranceDesc);
                            @endphp
                            <tr>
                                <td style="font-size: 16px; border: 1px solid #fff;" colspan="3">
                                    <strong>{{ $list->location_description }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 16px; border: 1px solid #fff;" colspan="3">
                                    <strong>{{ $list->vehicle_type_name }}</strong>
                                </td>
                            </tr> --}}
                            {{-- @foreach ($cars as $car)
                                <tr>
                                    @if ($loop->first)
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: center;">
                                            {{ $list->vehicle_brand_name }}
                                        </td>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: center;">
                                            {{ $car->license_plate }}
                                        </td>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: center;">
                                            {{ parseToDateTh(date('d-m-Y', strtotime($car->start_date))) }}
                                        </td>
                                    @else
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: center;">
                                        </td>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: center;">
                                            {{ $car->license_plate }}
                                        </td>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: center;">
                                            {{ carForReport($month, $list->license_plate, $carInsuranceDesc) }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach --}}
                        {{-- @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</body>
</html>
