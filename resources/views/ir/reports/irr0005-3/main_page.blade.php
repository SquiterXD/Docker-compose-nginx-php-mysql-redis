<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <title> รายงานรถยนต์สิ้นอายุกรมธรรม์ </title>
    @include('ir.reports.irr0005-3._style')
</head>
<body> 
    @foreach ($data as $group => $groupLists)
        <div class="row">
            <div class="col-md-12" style="page-break-inside:avoid; page-break-after:auto;">
                @if (isset($carInsurance[$group]))
                    @foreach ($carInsurance[$group] as $insuranceDesc => $locationLists)
                        <div style="{{$loop->first ? 'margin-top: 20px;' : ''}}"> <strong> กลุ่ม : </strong> {{ $group }} </div>
                        <div> <strong> ประเภทการต่ออายุ : </strong> {{ $insuranceDesc }} </div>
                        <div style="margin-top: 10px; margin-bottom: 20px;">
                            <table class="table table-test">
                                <thead>
                                    <tr style="background-color: #dcdfdb;">
                                        <th  style="width: 300px;">
                                            สถานที่ - ยี่ห้อ
                                        </th>
                                        <th  style="width: 100px;">
                                            ทะเบียนรถยนต์
                                        </th>
                                        <th >
                                            ระยะเวลาเอาประกัน ตั้งแต่ - สิ้นสุด
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                        $len = count($locationLists);
                                    @endphp
                                    @foreach ($locationLists as $location => $carLists)
                                    @php
                                        $i++;
                                    @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $location }}</strong>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @foreach ($carLists as $car => $lists)
                                            <tr>
                                                <td>
                                                    <div style="margin-left: 10px;"><u>{{ $car }}</u></div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @foreach ($lists as $list)
                                                @php
                                                    $cars = carForReport($month, $list, $insuranceDesc);
                                                    $countCar = count($cars);
                                                @endphp
                                                @if ($cars->isNotEmpty())
                                                    @foreach ($cars as $car)
                                                        <tr>
                                                            <td style="{{ $i == $len && $loop->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                                <div style="margin-left: 10px;">{{ $loop->parent->iteration . '. ' . $list->vehicle_brand_name }}</div>
                                                            </td>
                                                            <td style="text-align: center; {{ $i == $len && $loop->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                                {{ $list->license_plate }}
                                                            </td>
                                                            <td style="text-align: center; {{ $i == $len && $loop->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                                {{ date('d', strtotime($car->start_date)) }} {{ $thaimonths[date('m', strtotime($car->start_date))] }} {{ date('Y', strtotime($car->start_date))+543 }} 
                                                                - 
                                                                {{ date('d', strtotime($car->end_date)) }} {{ $thaimonths[date('m', strtotime($car->end_date))] }} {{ date('Y', strtotime($car->end_date))+543 }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td style="{{ $loop->parent->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                            <div style="margin-left: 10px;">{{ $loop->iteration . '. ' . $list->vehicle_brand_name }}</div>
                                                        </td>
                                                        <td style="text-align: center; {{ $loop->parent->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                            {{ $list->license_plate }}
                                                        </td>
                                                        <td style="text-align: center; {{ $loop->parent->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}"></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @endif

                @if (isset($carAct[$group]))
                    @foreach ($carAct[$group] as $carActDesc => $locationLists)
                        <div style="{{$loop->first ? 'margin-top: 20px;' : ''}}"> <strong> กลุ่ม : </strong> {{ $group }} </div>
                        <div> <strong> ประเภทการต่ออายุ : </strong> {{ $carActDesc }} </div>
                        <div class="table-responsive" style="margin-top: 10px; margin-bottom: 20px;">
                            <table class="table table-test">
                                <thead>
                                    <tr style="background-color: #dcdfdb;">
                                        <th  style="width: 300px;">
                                            สถานที่ - ยี่ห้อ
                                        </th>
                                        <th  style="width: 100px;">
                                            ทะเบียนรถยนต์
                                        </th>
                                        <th >
                                            ระยะเวลาเอาประกัน ตั้งแต่ - สิ้นสุด
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                        $len = count($locationLists);
                                    @endphp
                                    @foreach ($locationLists as $location => $carLists)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $location }}</strong>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @foreach ($carLists as $car => $lists)
                                            <tr>
                                                <td>
                                                    <div style="margin-left: 10px;"><u>{{ $car }}</u></div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @foreach ($lists as $list)
                                                @php
                                                    $cars = carForReport($month, $list, $carActDesc);
                                                    $countCar = count($cars);
                                                @endphp
                                                @if ($cars->isNotEmpty())
                                                    @foreach ($cars as $car)
                                                        <tr>
                                                            <td style="{{ $i == $len && $loop->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                                <div style="margin-left: 10px;">{{ $loop->parent->iteration . '. ' . $list->vehicle_brand_name }}</div>
                                                            </td>
                                                            <td style="text-align: center; {{ $i == $len && $loop->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                                {{ $list->license_plate }}
                                                            </td>
                                                            <td style="text-align: center; {{ $i == $len && $loop->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                                {{ date('d', strtotime($car->start_date)) }} {{ $thaimonths[date('m', strtotime($car->start_date))] }} {{ date('Y', strtotime($car->start_date))+543 }} 
                                                                - 
                                                                {{ date('d', strtotime($car->end_date)) }} {{ $thaimonths[date('m', strtotime($car->end_date))] }} {{ date('Y', strtotime($car->end_date))+543 }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td style="{{ $loop->parent->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                            <div style="margin-left: 10px;">{{ $loop->iteration . '. ' . $list->vehicle_brand_name }}</div>
                                                        </td>
                                                        <td style="text-align: center; {{ $loop->parent->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                            {{ $list->license_plate }}
                                                        </td>
                                                        <td style="text-align: center; {{ $loop->parent->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}"></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @endif

                @if (isset($carLicense[$group]))
                    @foreach ($carLicense[$group] as $carLicenseDesc => $locationLists)
                        <div style="{{$loop->first ? 'margin-top: 20px;' : ''}}"> <strong> กลุ่ม : </strong> {{ $group }} </div>
                        <div> <strong> ประเภทการต่ออายุ : </strong> {{ $carLicenseDesc }} </div>
                        <div class="table-responsive" style="margin-top: 10px; margin-bottom: 20px;">
                            <table class="table table-test">
                                <thead>
                                    <tr style="background-color: #dcdfdb;">
                                        <th style="width: 300px;">
                                            สถานที่ - ยี่ห้อ
                                        </th>
                                        <th style="width: 100px;">
                                            ทะเบียนรถยนต์
                                        </th>
                                        <th>
                                            ระยะเวลาเอาประกัน ตั้งแต่ - สิ้นสุด
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                        $len = count($locationLists);
                                    @endphp
                                    @foreach ($locationLists as $location => $carLists)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $location }}</strong>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @foreach ($carLists as $car => $lists)
                                            <tr>
                                                <td>
                                                    <div style="margin-left: 10px;"><u>{{ $car }}</u></div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @foreach ($lists as $list)
                                                @php
                                                    $cars = carForReport($month, $list, $carLicenseDesc);
                                                    $countCar = count($cars);
                                                @endphp
                                                @if ($cars->isNotEmpty())
                                                    @foreach ($cars as $car)
                                                        <tr>
                                                            <td style="{{ $i == $len && $loop->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                                <div style="margin-left: 10px;">{{ $loop->parent->iteration . '. ' . $list->vehicle_brand_name }}</div>
                                                            </td>
                                                            <td style="text-align: center; {{ $i == $len && $loop->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                                {{ $list->license_plate }}
                                                            </td>
                                                            <td style="text-align: center; {{ $i == $len && $loop->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                                {{ date('d', strtotime($car->start_date)) }} {{ $thaimonths[date('m', strtotime($car->start_date))] }} {{ date('Y', strtotime($car->start_date))+543 }} 
                                                                - 
                                                                {{ date('d', strtotime($car->end_date)) }} {{ $thaimonths[date('m', strtotime($car->end_date))] }} {{ date('Y', strtotime($car->end_date))+543 }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td style="{{ $loop->parent->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                            <div style="margin-left: 10px;">{{ $loop->iteration . '. ' . $list->vehicle_brand_name }}</div>
                                                        </td>
                                                        <td style="text-align: center; {{ $loop->parent->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                            {{ $list->license_plate }}
                                                        </td>
                                                        <td style="text-align: center; {{ $loop->parent->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}"></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @endif

                @if (isset($carInspection[$group]))
                    @foreach ($carInspection[$group] as $carInspectionDesc => $locationLists)
                        <div style="{{$loop->first ? 'margin-top: 20px;' : ''}}"> <strong> กลุ่ม : </strong> {{ $group }} </div>
                        <div> <strong> ประเภทการต่ออายุ : </strong> {{ $carInspectionDesc }} </div>
                        <div class="table-responsive" style="margin-top: 10px; margin-bottom: 20px;">
                            <table class="table table-test">
                                <thead>
                                    <tr style="background-color: #dcdfdb;">
                                        <th style="width: 300px;">
                                            สถานที่ - ยี่ห้อ
                                        </th>
                                        <th style="width: 100px;">
                                            ทะเบียนรถยนต์
                                        </th>
                                        <th>
                                            ระยะเวลาเอาประกัน ตั้งแต่ - สิ้นสุด
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                        $len = count($locationLists);
                                    @endphp
                                    @foreach ($locationLists as $location => $carLists)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $location }}</strong>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @foreach ($carLists as $car => $lists)
                                            <tr>
                                                <td>
                                                    <div style="margin-left: 10px;"><u>{{ $car }}</u></div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @foreach ($lists as $list)
                                                @php
                                                    $cars = carForReport($month, $list, $carInspectionDesc);
                                                    $countCar = count($cars);
                                                @endphp
                                                @if ($cars->isNotEmpty())
                                                    @foreach ($cars as $car)
                                                        <tr>
                                                            <td style="{{ $i == $len && $loop->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                                <div style="margin-left: 10px;">{{ $loop->parent->iteration . '. ' . $list->vehicle_brand_name }}</div>
                                                            </td>
                                                            <td style="text-align: center; {{ $i == $len && $loop->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                                {{ $list->license_plate }}
                                                            </td>
                                                            <td style="text-align: center; {{ $i == $len && $loop->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                                {{ date('d', strtotime($car->start_date)) }} {{ $thaimonths[date('m', strtotime($car->start_date))] }} {{ date('Y', strtotime($car->start_date))+543 }} 
                                                                - 
                                                                {{ date('d', strtotime($car->end_date)) }} {{ $thaimonths[date('m', strtotime($car->end_date))] }} {{ date('Y', strtotime($car->end_date))+543 }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td style="{{ $loop->parent->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                            <div style="margin-left: 10px;">{{ $loop->iteration . '. ' . $list->vehicle_brand_name }}</div>
                                                        </td>
                                                        <td style="text-align: center; {{ $loop->parent->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                                            {{ $list->license_plate }}
                                                        </td>
                                                        <td style="text-align: center; {{ $loop->parent->parent->last ? 'border-bottom: 0.5px solid #000' : '' }}"></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
</body>
</html>
