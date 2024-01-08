@foreach($headersRpt as $h)
<style>
table, tr, th{
 border:none;
}
</style>
<table>
        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"colspan=5 >โปรแกรม : PPR0008</th>
            <th style="text-align: center; font-weight: bold; width: 400px;"colspan=6>การยาสูบแห่งประเทศไทย</th>
            <th style="text-align: right; font-weight: bold; width: 300px;"colspan=5>วันที่ : {{$Sysdate}}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"colspan=5>สั่งพิมพ์ : {{ Auth::user()->name }} </th>
            <th style="text-align: center; font-weight: bold; width: 400px;" colspan=6>มูลค่าคงคลังแสตมป์เช้า ณ วันที่ {{$planDateTH}}</th>
            <th style="text-align: right; font-weight: bold; width: 300px;"colspan=5>เวลา : {{$time}}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"colspan=5></th>
            <th style="text-align: center; font-weight: bold;width: 400px;" colspan=6>ปีงบประมาณ : {{optional($h)->period_year_thai}} เดือน : {{optional($h)->thai_month}} ครั้งที่ : {{$version}}</th>
            <th style="text-align: right; font-weight: bold;width: 300px;"colspan=5> {{$pageNo}} / {{$page}} </th>
        </tr>
 
</table>
@endforeach
