<style>
table, tr, th{
 border:none;
}
</style>
<table>
        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"> โปรแกรม : PPR0003 </th>
            <th style="text-align: center; font-weight: bold; width: 400px;"> การยาสูบแห่งประเทศไทย </th>
            <th style="text-align: right; font-weight: bold; width: 300px;"> วันที่ : {{ date('d-m-Y') }} </th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"> สั่งพิมพ์ : {{ Auth::user()->name }} </th>
            <th style="text-align: center; font-weight: bold; width: 400px;">  แผนผลิตประจำเดือน </th>
            <th style="text-align: right; font-weight: bold; width: 300px;"> เวลา : {{ date('H:i') }} </th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"></th>
            <th style="text-align: center; font-weight: bold;width: 400px;">
                ปีงบประมาณ : {{optional($headReport)->period_year_thai}}  ปักษ์ : {{optional($headReport)->c_biweekly}}   เดือน : {{optional($headReport)->pp_month}}   ครั้งที่ : {{optional($headReport)->version_no}}
            </th>
            <th style="text-align: right; font-weight: bold;width: 300px;"> หน้า {{ $page_no }}/{{ $page }}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"></th>
            <th style="text-align: center; font-weight: bold;width: 400px;"> ประเภทบุหรี่ {{optional($headReport)->meaning}} ณ วันที่ {{optional($headReport)->as_of_date}}</th>
            <th style="text-align: right; font-weight: bold;width: 300px;"> สถานะ : {{optional($headReport)->approved_status}} </th>
        </tr>
</table>
