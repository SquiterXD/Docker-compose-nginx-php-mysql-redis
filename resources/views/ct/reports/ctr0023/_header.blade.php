<table>
    <thead>
        {{-- <tr>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">

            </th>
            <th colspan="4" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; vertical-align: middle; text-align: center;">
                <p> การยาสูบแห่งประเทศไทย </p>
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;">

            </th>
        </tr> --}}

        @if($pgIndex == 0)

        <tr>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                <p> รหัสโปรแกรม : {{ $programCode }} </p>
            </th>
            <th colspan="4" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 15px; vertical-align: middle; text-align: center;">
                <p> รายงานกระดาษทำการต้นทุนวัตถุดิบมาตรฐาน {{ $productOfYear=='Y'? "(เพิ่มผลิตภัณฑ์ใหม่)" : '' }}</p>
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;">
                {{-- <p> วันที่พิมพ์ : {{ $reportDate }} {{ $reportTime }} </p> --}}
            </th>
        </tr>

        <tr>

            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                <p> ปีบัญชีงบประมาณ : {{ $periodYearTh }} </p>
            </th>

            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                ครั้งที่ : {{ $reportHeaderItem['version_no'] }}
            </th>

            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                แผนผลิตครั้งที่ : {{ $reportHeaderItem['plan_version_no'] }}
            </th>

            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                วันที่เริ่มใช้  : {{ $reportHeaderItem['start_date_thai'] }}
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                ถึง : {{ $reportHeaderItem['end_date_thai'] }}
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                สถานะ  : {{ $reportProductGroupItem['approved_desc'] }}
            </th>

        </tr>

        @endif

        <tr>

            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                <p> ศูนย์ต้นทุน : {{ $reportHeaderItem['cost_code'] }} {{ $reportHeaderItem['cost_desc'] }} </p>
            </th>

            <th colspan="3" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                <p> ปริมาณ : {{ number_format($reportProductGroupItem['cost_quantity'], 2) }} หน่วย : {{ $reportProductGroupItem['uom_desc'] }} </p>
            </th>

            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;">

            </th>

        </tr>

        <tr>

            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                <p> กลุ่มผลิตภัณฑ์ : {{ $reportProductGroupItem['product_group'] }} </p>
            </th>

            <th colspan="4" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                <p> {{ $reportProductGroupItem['product_group_desc'] }} </p>
            </th>

            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;">

            </th>

        </tr>

        <tr>

            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                <p> รหัสสินค้า : {{ $reportProductGroupItem['product_item_number'] }}
            </th>

            <th colspan="3" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;">
                <p> ชื่อสินค้า : {{ $reportProductGroupItem['product_item_desc'] }}
            </th>

            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;">

            </th>

        </tr>

    </thead>

</table>
