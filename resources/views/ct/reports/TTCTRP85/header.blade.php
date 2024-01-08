<style>
    table, tr, th{
    border:none;
    }
</style>
<table>


        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"colspan=3 >โปรแกรม : TTCTRP85</th>
            <th style="text-align: center; font-weight: bold; width: 400px;"colspan=4>การยาสูบแห่งประเทศไทย(DR Site-TOT)</th>
            <th style="text-align: right; font-weight: bold; width: 300px;"colspan=3>วันที่ : {{$Sysdate}}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"colspan=3>สั่งพิมพ์ : {{ Auth::user()->name }} </th>
            <th style="text-align: center; font-weight: bold; width: 400px;" colspan=4>รายงานสรุปบัตรต้นทุนแยกตามพันธุ์ใบยา (รวมทุกโรงอบ)</th>
            <th style="text-align: right; font-weight: bold; width: 300px;"colspan=3>เวลา : {{$time}}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"colspan=3></th>
            <th style="text-align: center; font-weight: bold;width: 400px;" colspan=4>ประจำวันที่ {{$dateFromTH}} ถึง {{$dateToTH}}</th>
            <th style="text-align: right; font-weight: bold;width: 300px;"colspan=3> </th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"colspan=3></th>
            <th style="text-align: center; font-weight: bold;width: 400px;" colspan=4>ตั้งแต่ศูนย์ต้นทุน : {{$cost_center_from}} ถึง : {{$cost_center_to}}</th>
            <th style="text-align: right; font-weight: bold;width: 300px;"colspan=3></th>
        </tr>

        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"colspan=3></th>
            <th style="text-align: center; font-weight: bold;width: 400px;" colspan=4>ฤดู/ปี การผลิต : {{$crop_year}}</th>
            <th style="text-align: right; font-weight: bold;width: 300px;"colspan=3> </th>
        </tr>

</table>

