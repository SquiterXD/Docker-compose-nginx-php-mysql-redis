<style>
table, tr, th{
 border:none;
}
</style>
<table>
        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"> โปรแกรม : PPR0002 </th>
            <th style="text-align: center; font-weight: bold; width: 400px;"> การยาสูบแห่งประเทศไทย </th>
            <th style="text-align: right; font-weight: bold; width: 300px;"> วันที่ : {{ date('d-m-Y') }} </th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"> สั่งพิมพ์ : {{ Auth::user()->name }} </th>
            <th style="text-align: center; font-weight: bold; width: 400px;">  ประมาณการผลิตประจำปี </th>
            <th style="text-align: right; font-weight: bold; width: 300px;"> เวลา : {{ date('H:i') }} </th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"></th>
            <th style="text-align: center; font-weight: bold;width: 400px;">
                ปีงบประมาณ : {{$main[0]->budget_year}} ครั้งที่ : {{$main[0]->version_no}}
            </th>
            <th style="text-align: right; font-weight: bold;width: 300px;"> หน้า : {{ $page_no}} / {{ $page }}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"></th>
            <th style="text-align: center; font-weight: bold;width: 400px;"> </th>
            <th style="text-align: right; font-weight: bold;width: 300px;"> สถานะ : {{$main[0]->approved_status}} </th>
        </tr>
</table>
