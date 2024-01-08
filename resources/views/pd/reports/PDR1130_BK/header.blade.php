<style>
table, tr, th{
 border:none;
}
</style>
<table>
        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"colspan=5 >โปรแกรม : PDR1130</th>
            <th style="text-align: center; font-weight: bold; width: 400px;"colspan=6>การยาสูบแห่งประเทศไทย</th>
            <th style="text-align: right; font-weight: bold; width: 300px;"colspan=5>วันที่ : {{$Sysdate}}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"colspan=5>สั่งพิมพ์ : {{ Auth::user()->name }} </th>
            <th style="text-align: center; font-weight: bold; width: 400px;" colspan=6>รายงานการตัดและบรรจุการพิมพ์ กองพิมพ์</th>
            <th style="text-align: right; font-weight: bold; width: 300px;"colspan=5>เวลา : {{$time}}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"colspan=5>เรียงลำดับข้อมูล : ตามระบบต้นทุน</th>
            <th style="text-align: center; font-weight: bold;width: 400px;" colspan=6>ประจำวันที่ {{$dateFromTH}} ถึง {{$dateToTH}}</th>
            <th style="text-align: right; font-weight: bold;width: 300px;"colspan=5> {{$pageNo}} / {{$page}} </th>
        </tr>
 
</table>
