<style>
    table, tr, th{
        border:none;
    }
</style>
<table>
    <tr>
        <th style="text-align: left; font-weight: bold; width: 300px;"> โปรแกรม : PPR0011 </th>
        <th style="text-align: center; font-weight: bold; width: 400px;"> การยาสูบแห่งประเทศไทย </th>
        <th style="text-align: right; font-weight: bold; width: 300px;"> วันที่ : {{ date('d-m-Y') }} </th>
    </tr>
    <tr>
        <th style="text-align: left; font-weight: bold; width: 300px;"> สั่งพิมพ์ : {{ Auth::user()->name }} </th>
        <th style="text-align: center; font-weight: bold; width: 400px;">  รายงานปรับคำสั่งผลิต </th>
        <th style="text-align: right; font-weight: bold; width: 300px;"> เวลา : {{ date('H:i') }} </th>
    </tr>
    <tr>
        <th style="text-align: left; font-weight: bold;width: 300px;"></th>
        <th style="text-align: center; font-weight: bold;width: 400px;">
            ปีงบประมาณ : {{$headerReport->period_year_thai}} ครั้งที่ :  {{$headerReport->version_no}}
        </th>
        <th style="text-align: right; font-weight: bold;width: 300px;"> หน้า {{ $page_no }}/{{ $page }} </th>
    </tr>
    <tr>
        <th style="text-align: left; font-weight: bold;width: 300px;"></th>
        <th style="text-align: center; font-weight: bold;width: 400px;"> </th>
        <th style="text-align: right; font-weight: bold;width: 300px;"> สถานะ : {{ $headerReport->approved_status ?? 'Inactive'}} </th>
    </tr>
</table>
