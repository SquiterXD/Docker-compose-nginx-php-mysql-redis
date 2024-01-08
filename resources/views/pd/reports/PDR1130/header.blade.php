<style>
table, tr, th{
 border:none;
}
</style>
<table>
        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"colspan=5 >โปรแกรม : PDR1130</th>
            <th style="text-align: center; font-weight: bold; width: 400px;"colspan=6>การยาสูบแห่งประเทศไทย</th>
            <th style="text-align: right; font-weight: bold; width: 300px;"colspan=5>วันที่ : {{ date('d-m-Y') }}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"colspan=5>สั่งพิมพ์ : {{ Auth::user()->username }} </th>
            <th style="text-align: center; font-weight: bold; width: 400px;" colspan=6>รายงานการตัดและบรรจุ ฝ่ายการพิมพ์ กองพิมพ์</th>
            <th style="text-align: right; font-weight: bold; width: 300px;"colspan=5>เวลา : {{ date('H:i') }}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"colspan=5>เรียงลำดับข้อมูล : {{$orderHeader}}</th>
            <th style="text-align: center; font-weight: bold;width: 400px;" colspan=6>ประจำวันที่ {{$dateFromTH}} ถึง {{$dateToTH}}</th>
            <th style="text-align: right; font-weight: bold;width: 300px;"colspan=5> {{$pageNo}} / {{$page}} </th>
        </tr>
 
</table>
