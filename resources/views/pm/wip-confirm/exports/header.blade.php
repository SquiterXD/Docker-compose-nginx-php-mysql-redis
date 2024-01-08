<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงานผลผลิต</title>
    <style>

        body {
                font-family: 'SarabunSans';
                font-size: 10px;
            }

            .table-content {
                border-collapse: collapse;
                font-size: 10px;
                page-break-inside:auto;
            }

            .table-header {
                text-align: center;
            }

            .table-content tr {
                page-break-inside:avoid;
                page-break-after:auto;
            }

            .text-center {
                text-align: center;
            }

            #PDR1150 .col-1  { width: 40px; }
            #PDR1150 .col-2  { width: 100px; }
            #PDR1150 .col-3  { width: 100px; }
            #PDR1150 .col-4  { width: 100px; }
            #PDR1150 .col-5  { width: 120px; }
            #PDR1150 .col-6  { width: 60px; }
            #PDR1150 .col-7  { width: 60px; }
            #PDR1150 .col-8  { width: 100px; }
            #PDR1150 .col-9  { width: 100px; }
            #PDR1150 .col-10 { width: 100px; }
            #PDR1150 .col-11  { width: 100px; }
            #PDR1150 .col-12  { width: 100px; }
            #PDR1150 .col-13  { width: 40px; }

            #PDR1180 .col-1  { width: 100px; }
            #PDR1180 .col-2  { width: 100px; }
            /*#PDR1180 .col-3  { width: 100px; }*/
            #PDR1180 .col-4  { width: 100px; }
            #PDR1180 .col-5  { width: 150px; }
            #PDR1180 .col-6  { width: 100px; }
            /*#PDR1180 .col-7  { width: 60px; }*/
            #PDR1180 .col-8  { width: 100px; }
            #PDR1180 .col-9  { width: 100px; }
            #PDR1180 .col-10 { width: 100px; }
            #PDR1180 .col-11  { width: 100px; }
            #PDR1180 .col-12  { width: 100px; }
            #PDR1180 .col-13  { width: 100px; }

            #PDR2040 .col-1  { width: 100px; }
            /*#PDR2040 .col-2  { width: 100px; }*/
            /*#PDR2040 .col-3  { width: 100px; }*/
            #PDR2040 .col-4  { width: 100px; }
            #PDR2040 .col-5  { width: 200px; }
            #PDR2040 .col-6  { width: 100px; }
            /*#PDR2040 .col-7  { width: 60px; }*/
            #PDR2040 .col-8  { width: 100px; }
            #PDR2040 .col-9  { width: 100px; }
            #PDR2040 .col-10 { width: 100px; }
            #PDR2040 .col-11  { width: 100px; }
            #PDR2040 .col-12  { width: 100px; }
            #PDR2040 .col-13  { width: 100px; }

            .table-main {
                border-collapse: collapse;
                font-size: 10px;
                page-break-inside:auto;
            }
            .table-main thead tr td {
                text-align: center;
            }
            .table-main tr {
                page-break-inside:avoid;
                page-break-after:auto;
            }

    </style>
    <script>
        function subst() {
            var vars={};
            var x=document.location.search.substring(1).split('&');
            for (var i in x) {var z=x[i].split('=',2);vars[z[0]] = unescape(z[1]);}
            var x=['frompage','topage','page','webpage','section','subsection','subsubsection'];
            for (var i in x) {
                var y = document.getElementsByClassName(x[i]);
                for (var j=0; j<y.length; ++j) y[j].textContent = vars[x[i]];
            }
        }
    </script>
</head>
<body onload="subst()" style="margin:0; padding: 0; overflow:hidden;">

    <table class="table-content">
        @if($reportCode == 'PDR1150')
        <thead>
            <tr>
                <td colspan="2" style="text-align: left;">โปรแกรม: {{$reportCode}}</td>
                <td colspan="9" style="text-align: center;">การยาสูบแห่งประเทศไทย</td>
                {{-- <td colspan="2" style="text-align: right;">วันที่: {{Str::upper($dateNow)}}</td> --}}
                {{-- <td colspan="2" style="text-align: right;">วันที่: {{ formatDateTimeThai($dateNow) }}</td> --}}
                <td colspan="2" style="text-align: right;">วันที่: {{ $reportData->date }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;">สั่งพิมพ์: {{$user->username}}</td>
                <td colspan="9" style="text-align: center;">
                    @if($userOrgCode == 'M05')
                        {{ $reportData->name }} ฝ่ายผลิตก้นกรอง {{ $reportData->department_desc }}
                    @elseif($userOrgCode == 'MG6')
                        {{ $reportData->name }} ฝ่ายผลิตสินค้าสำเร็จรูป {{ $reportData->department_desc }}
                    @elseif($userOrgCode == 'M06')
                        {{ $reportData->name }} ฝ่ายการพิมพ์ {{ $reportData->department_desc }}
                    @else
                        {{ $reportData->name }} ฝ่ายผลิตด้านใบยา {{ $reportData->department_desc }}
                    @endif
                </td>
                <td colspan="2" style="text-align: right;">เวลา: {{ $reportData->time }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;"></td>
                {{-- <td colspan="9" style="text-align: center;">ประจำวันที่ {{Str::upper($fromDate)}} ถึงวันที่ {{Str::upper($toDate)}}</td> --}}
                <td colspan="9" style="text-align: center;">ประจำวันที่ {{formatLongDateThai($fromDate)}} ถึงวันที่ {{formatLongDateThai($toDate)}}</td>
                <td colspan="2" style="text-align: right;">หน้า: <span class="page"></span> / <span class="topage"></span></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;"></td>
                <td colspan="9" style="text-align: center;">
                    คำสั่งผลิตเลขที่ {{ $batchNoFrom == 'ALL' ? $batchNoFrom2 : $batchNoFrom }} 
                    ถึง {{ $batchNoTo == 'ALL' ? $batchNoTo2 : $batchNoTo }} 
                    {{-- ขั้นตอนที่ {{ ($wipStepFrom == 'ALL' ? $wipStepFrom2 : $wipStepFrom) == 'WIP01' ? 'ใบยาหมัก' : 'ยาเส้น' }} 
                    ถึง {{ ($wipStepTo == 'ALL' ? $wipStepTo2 : $wipStepTo) == 'WIP01' ? 'ใบยาหมัก' : 'ยาเส้น' }}  --}}
                    ขั้นตอนที่ {{ $wipStepFrom }} ถึง {{ $wipStepTo }}
                </td>
                <td colspan="2" style="text-align: right;"></td>
            </tr>
            <tr class="table-header" id="PDR1150">
                <td class="col-1"></td>
                <td class="col-2"></td>
                <td class="col-3"></td>
                <td class="col-4"></td>
                <td class="col-5"></td>
                <td class="col-6"></td>
                <td class="col-7"></td>
                <td class="col-8"></td>
                <td class="col-9"></td>
                <td class="col-10"></td>
                <td class="col-11"></td>
                <td class="col-12"></td>
                <td class="col-13"></td>
            </tr>
        </thead>
        @endif

        @if($reportCode == 'PDR1180')
        <thead>
            <tr>
                <td colspan="2" style="text-align: left;">โปรแกรม: {{$reportCode}}</td>
                <td colspan="7" style="text-align: center;">การยาสูบแห่งประเทศไทย</td>
                {{-- <td colspan="2" style="text-align: right;">วันที่: {{Str::upper($dateNow)}}</td> --}}
                {{-- <td colspan="2" style="text-align: right;">วันที่: {{ formatDateTimeThai($dateNow) }}</td> --}}
                <td colspan="2" style="text-align: right;">วันที่: {{ $reportData->date }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;">สั่งพิมพ์: {{$user->username}}</td>
                <td colspan="7" style="text-align: center;">
                    @if($userOrgCode == 'M05')
                        {{ $reportData->name }} ฝ่ายผลิตก้นกรอง {{ $reportData->department_desc }}
                    @elseif($userOrgCode == 'MG6')
                        {{ $reportData->name }} ฝ่ายผลิตสินค้าสำเร็จรูป {{ $reportData->department_desc }}
                    @elseif($userOrgCode == 'M06')
                        {{ $reportData->name }} ฝ่ายการพิมพ์ {{ $reportData->department_desc }}
                    @else
                        {{ $reportData->name }} ฝ่ายผลิตด้านใบยา {{ $reportData->department_desc }}
                    @endif
                </td>
                <td colspan="2" style="text-align: right;">เวลา: {{ $reportData->time }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;"></td>
                {{-- <td colspan="7" style="text-align: center;">ประจำวันที่ {{Str::upper($fromDate)}} ถึงวันที่ {{Str::upper($toDate)}}</td> --}}
                <td colspan="7" style="text-align: center;">ประจำวันที่ {{formatLongDateThai($fromDate)}} ถึงวันที่ {{formatLongDateThai($toDate)}}</td>
                <td colspan="2" style="text-align: right;">หน้า: <span class="page"></span> / <span class="topage"></span></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;"></td>
                <td colspan="7" style="text-align: center;">
                    {{-- คำสั่งผลิตเลขที่ {{ $batchNoFrom == 'ALL' ? $batchNoFrom2 : $batchNoFrom }} 
                    ถึง {{ $batchNoTo == 'ALL' ? $batchNoTo2 : $batchNoTo }}  --}}
                    {{-- ขั้นตอนที่ {{ ($wipStepFrom == 'ALL' ? $wipStepFrom2 : $wipStepFrom) == 'WIP01' ? 'ใบยาหมัก' : 'ยาเส้น' }} 
                    ถึง {{ ($wipStepTo == 'ALL' ? $wipStepTo2 : $wipStepTo) == 'WIP01' ? 'ใบยาหมัก' : 'ยาเส้น' }}  --}}
                    ขั้นตอนที่ {{ $wipStepFrom }} ถึง {{ $wipStepTo }}
                </td>
                <td colspan="2" style="text-align: right;"></td>
            </tr>
            <tr class="table-header" id="PDR1180">
                <td class="col-1"></td>
                <td class="col-2"></td>
                {{-- <td class="col-3"></td> --}}
                <td class="col-4"></td>
                <td class="col-5"></td>
                <td class="col-6"></td>
                {{-- <td class="col-7"></td> --}}
                <td class="col-8"></td>
                <td class="col-9"></td>
                <td class="col-10"></td>
                <td class="col-11"></td>
                <td class="col-12"></td>
                <td class="col-13"></td>
            </tr>
        </thead>
        @endif

        @if($reportCode == 'PDR2040')
        <thead>
            <tr>
                <td colspan="2" style="text-align: left;">โปรแกรม: {{$reportCode}}</td>
                <td colspan="6" style="text-align: center;">การยาสูบแห่งประเทศไทย</td>
                {{-- <td colspan="2" style="text-align: right;">วันที่: {{Str::upper($dateNow)}}</td> --}}
                {{-- <td colspan="2" style="text-align: right;">วันที่: {{ formatDateTimeThai($dateNow) }}</td> --}}
                <td colspan="2" style="text-align: right;">วันที่: {{ $reportData->date }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;">สั่งพิมพ์: {{$user->username}}</td>
                <td colspan="6" style="text-align: center;">
                    @if($userOrgCode == 'M05')
                        {{ $reportData->name }} ฝ่ายผลิตก้นกรอง {{ $reportData->department_desc }}
                    @elseif($userOrgCode == 'MG6')
                        {{ $reportData->name }} ฝ่ายผลิตสินค้าสำเร็จรูป {{ $reportData->department_desc }}
                    @elseif($userOrgCode == 'M06')
                        {{ $reportData->name }} ฝ่ายการพิมพ์ {{ $reportData->department_desc }}
                    @else
                        {{ $reportData->name }} ฝ่ายผลิตด้านใบยา {{ $reportData->department_desc }}
                    @endif
                </td>
                <td colspan="2" style="text-align: right;">เวลา: {{ $reportData->time }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;"></td>
                {{-- <td colspan="6" style="text-align: center;">ประจำวันที่ {{Str::upper($fromDate)}} ถึงวันที่ {{Str::upper($toDate)}}</td> --}}
                <td colspan="6" style="text-align: center;">ประจำวันที่ {{formatLongDateThai($fromDate)}} ถึงวันที่ {{formatLongDateThai($toDate)}}</td>
                <td colspan="2" style="text-align: right;">หน้า: <span class="page"></span> / <span class="topage"></span></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;"></td>
                <td colspan="6" style="text-align: center;">
                    {{-- คำสั่งผลิตเลขที่ {{ $batchNoFrom == 'ALL' ? $batchNoFrom2 : $batchNoFrom }} 
                    ถึง {{ $batchNoTo == 'ALL' ? $batchNoTo2 : $batchNoTo }}  --}}
                    {{-- ขั้นตอนที่ {{ ($wipStepFrom == 'ALL' ? $wipStepFrom2 : $wipStepFrom) == 'WIP01' ? 'ใบยาหมัก' : 'ยาเส้น' }} 
                    ถึง {{ ($wipStepTo == 'ALL' ? $wipStepTo2 : $wipStepTo) == 'WIP01' ? 'ใบยาหมัก' : 'ยาเส้น' }} --}} 
                    ขั้นตอนที่ {{ $wipStepFrom }} ถึง {{ $wipStepTo }}
                </td>
                <td colspan="2" style="text-align: right;"></td>
            </tr>
            <tr class="table-header" id="PDR2040">
                <td class="col-1"></td>
                {{-- <td class="col-2"></td> --}}
                {{-- <td class="col-3"></td> --}}
                <td class="col-4"></td>
                <td class="col-5"></td>
                <td class="col-6"></td>
                {{-- <td class="col-7"></td> --}}
                <td class="col-8"></td>
                <td class="col-9"></td>
                <td class="col-10"></td>
                <td class="col-11"></td>
                <td class="col-12"></td>
                <td class="col-13"></td>
            </tr>
        </thead>
        @endif
    </table>
</body>
</html>
