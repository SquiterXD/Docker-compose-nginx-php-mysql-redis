<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
    <style>
        <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew Bold.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        thead{display: table-header-group;}
        tfoot {display: table-row-group;}
        tr {page-break-inside: avoid;}

        body {
            font-family: "THSarabunNew" !important;
        }
        table {
            width:100%;
            border-collapse: collapse;
        }
        td {
            /*border:none !important;*/
            border: 1px solid black !important;
        }
        div.page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }
        .border {
            border-top:1px solid #000 !important;
            border-bottom:1px solid #000 !important;
        }

        table > tbody > tr{
            /*border: 1px red !important;*/
            page-break-inside: avoid !important;
            /*background-color: salmon !important;*/
        }
        thead {
            display: table-header-group !important;
            /*background-color:#edf2f7 !important;*/
        }

    </style>
</head>

<body>
    @php
        $styleTh = 'border:  1px solid black; line-height: 100px';
        $styleFont16 = 'border:  1px solid black; font-size: 16px';
        $styleFont14 = 'border:  1px solid black; font-size: 14px';
        $font18 = 'font-size: 18px; ';
        $font16 = 'font-size: 16px; ';
        $font14 = 'font-size: 14px; ';
        $styleBorderLRFont14 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 14px';
        $styleBorderLRFTont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 14px';
        $styleBorderLRBTFont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 14px';
        $styleBorderLRFont16 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 16px';
        $styleBorderLRFTont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 16px';
        $styleBorderLRBTFont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 16px';
        $styleBorderTBFont16 = 'border-top:  1px solid black; border-bottom:  1px solid black; font-size: 16px';
        $styleBorderAll = 'border: 1px solid black !important;';
        $styleBorderB = 'border-bottom: 1px solid black !important;';
        $styleBorderLR = 'border-left:  1px solid black !important; border-right:  1px solid black !important;';
        $uData = [];
        // dd('xxxxxxxxxxxxxxxxxxxxxxxxx');
    @endphp

    <table>
        <thead>
            <tr>
                <td colspan="12" style="border-top: 0px !important; border-left: 0px !important; border-right: 0px !important; border-bottom: 0px !important;"></td>
            </tr>
            <tr>
                <td rowspan="2" style="{{ $styleBorderAll }}"><b>หน่วยงาน</b></td>
                <td rowspan="2" style="{{ $styleBorderAll }}"><b>รายละเอียดต้นทุนการผลิต</b></td>
                <td align="center" colspan="2"><b>ยอดเดือน</b></td>
                <td align="center" colspan="2" style="{{ $styleBorderAll }}"><b>เพิ่ม/(ลด)</b></td>
                <td align="center" colspan="2" style="{{ $styleBorderAll }}"><b>ยอดสะสม</b></td>
                <td align="center" colspan="2" style="{{ $styleBorderAll }}"><b>เพิ่ม/(ลด)</b></td>
            </tr>
            <tr>
                <td align="center" style="{{ $styleBorderAll }}" ><b>เดือนนี้</b></td>
                <td align="center" style="{{ $styleBorderAll }}" ><b>เดือนก่อน</b></td>
                <td align="center" style="{{ $styleBorderAll }}" ><b>จำนวนเงิน</b></td>
                <td align="center" style="{{ $styleBorderAll }}" ><b>%</b></td>
                <td align="center" style="{{ $styleBorderAll }}" ><b>ปีนี้</b></td>
                <td align="center" style="{{ $styleBorderAll }}" ><b>ปีก่อน</b></td>
                <td align="center" style="{{ $styleBorderAll }}" ><b>จำนวนเงิน</b></td>
                <td align="center" style="{{ $styleBorderAll }}" ><b>%</b></td>
            </tr>
        </thead>
        <tbody style="">
        @foreach ($data as $deptList)
            @foreach ($deptList as $line)
            <tr>
                @if($loop->first)
                    <td rowspan="{{ count($deptList) }}" valign="top" style="{{ $styleBorderAll }}">{{ data_get($line, 'dept_desc', '-') }}({{ data_get($line, 'cost_desc', '-') }})</td>
                @endif
                <td style="{{ data_get($line, 'style', '') }} {{ $loop->last ? $styleBorderB : '' }}">{{ data_get($line, 'cost_desc_display', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.ptd_amount', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.previous_ptd_amount', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.month_amount', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.month_percent', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.ytd_amount', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.previous_ytd_amount', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.sum_amount', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.sum_percent', '-') }}</td>
            </tr>
            @endforeach
        @endforeach
        @foreach ($summary as $costList)
            @foreach ($costList as $line)
            @if($loop->first)
                <tr>
                    {{-- <td colspan="10" style="{{ $styleBorderLR }}"><b><u>สรุปต้นทุนการผลิตศูนย์{{ data_get($line, 'cost_desc', '-') }}</u></b></td> --}}
                    <td colspan="10" style="{{ $styleBorderLR }}"><b><u>สรุปต้นทุนการผลิตศูนย์{{ str_replace("กอง","", data_get($line, 'dept_desc', '-')) }}</u></b></td>
                </tr>
            @endif
            <tr>
                @if($loop->first)
                    <td rowspan="{{ count($costList) }}" style="{{ $styleBorderAll }}"></td>
                @endif
                <td style="{{ data_get($line, 'style', '') }} {{ $loop->last ? $styleBorderB : '' }}">{{ data_get($line, 'cost_desc_display', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.ptd_amount', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.previous_ptd_amount', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.month_amount', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.month_percent', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.ytd_amount', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.previous_ytd_amount', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.sum_amount', '-') }}</td>
                <td align="right" style="{{ $styleBorderAll }} ">{{ data_get($line, 'format.sum_percent', '-') }}</td>
            </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
</body>

</html>
