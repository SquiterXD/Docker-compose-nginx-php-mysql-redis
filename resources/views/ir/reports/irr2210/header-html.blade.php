<table style="width:100%">
    <tbody>
        <tr>
          <td align="left" colspan="3"><b>รหัสโปรแกรม : IRR2210</b></td>
          <td align="center" colspan="24"><b>การยาสูบแห่งประเทศไทย</b></td>
          <td align="right" colspan="3"><b> วันที่ : </b> <b>{{ date('d/m/Y', strtotime(now())) }}</b></td>
        </tr>
        <tr>
          <td align="left" colspan="3"><b>สั่งพิมพ์ : {{ \Auth::user()->name }}</b></td>
          <td align="center" colspan="24"><b>รายงานดุลค่าเบี้ยประกัน ประจำเดือน {{$ParamMont}}</b></td>
          <td align="right" colspan="3"><b>เวลา : </b> <b>{{ date('H:i', strtotime(now())) }}</b></td>
        </tr>
        <tr>
          <td align="left"  colspan="3"><b> ชุดที่ {{ $policy }} : {{ policySetHead($policy) }} </b></td>
          <td align="center" colspan="24"></td>
          <td align="right" colspan="3"><b>หน้า : {{ $page_no }} / {{ $page }}</td>
        </tr>
    </tbody>
</table>