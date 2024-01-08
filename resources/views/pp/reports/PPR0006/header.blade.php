<table>
    <tr>
        <th style="text-align: left; font-weight: bold; width: 300px; border: 1px solid #FFF;"> โปรแกรม : {{ $programCode }} </th>
        <th style="text-align: center; font-weight: bold; width: 400px; border: 1px solid #FFF;"> การยาสูบแห่งประเทศไทย </th>
        <th style="text-align: right; font-weight: bold; width: 300px; border: 1px solid #FFF;"> วันที่ : {{ date('d-m-Y') }} </th>
    </tr>
    <tr>
        <th style="text-align: left; font-weight: bold; width: 300px; border: 1px solid #FFF;"> สั่งพิมพ์ : {{ Auth::user()->name }} </th>
        <th style="text-align: center; font-weight: bold; width: 400px; border: 1px solid #FFF;"> ประมาณการซื้อแสตมป์ยาสูบประจำเดือนแยกตามกลุ่มราคา </th>
        <th style="text-align: right; font-weight: bold; width: 300px; border: 1px solid #FFF;"> เวลา : {{ date('H:i:s') }} </th>
    </tr>
    <tr>
        <th style="text-align: left; font-weight: bold;width: 300px; border: 1px solid #FFF;"> </th>
        <th style="text-align: center; font-weight: bold;width: 400px; border: 1px solid #FFF;">
            ปีงบประมาณ : {{ $biweekly->period_year_thai }} เดือน : {{ $biweekly->thai_month }} ครั้งที่ : {{ $stampMonthly->version_no }}
        </th>
        <th style="text-align: right; font-weight: bold;width: 300px; border: 1px solid #FFF;">หน้า : 1 / 1 </th>
    </tr>
    <tr>
        <th style="text-align: left; font-weight: bold;width: 300px; border: 1px solid #FFF;"> </th>
        <th style="text-align: center; font-weight: bold; width: 700px; border: 1px solid #FFF;"> </th>
        <th style="text-align: right; font-weight: bold;width: 300px; border: 1px solid #FFF;">สถานะ : {{ $stampMonthly->approved_status == 'Inactive'? 'ยังไม่อนุมัติ': 'อนุมัติ' }} </th>
    </tr>
</table>