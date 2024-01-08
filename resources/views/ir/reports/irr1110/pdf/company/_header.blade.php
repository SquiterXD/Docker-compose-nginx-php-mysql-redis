<table width="100%" style="font-size: 16px">
    <tr >
        <td width="20%"> <span class="p-h2">Program Code : {{$program->program_code}} </span>  </td>
        <td width="70%"   align="center"> <span class="p-h2"> การยาสูบแห่งประเทศไทย </span>  </td>
        <td width="10%">   <span class="p-h2"> วันที่ :  {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }} </span> </td>
    </tr>
    <tr>
        <td>  สั่งพิมพ์ : {{  $userProfile->user_name}} </td>
        <td width="65%" align="center"> <span class="p-h2"> ชุดที่ : {{ $reportStocks[0]->policy_set_header_id. ' : '. $reportStocks[0]->policy_set_description}} </span></td>
        <td><span class="p-h2"> เวลา : {{ Carbon\Carbon::now()->format('H:i') }}</span></td>
    </tr>
    <tr>
        <td></td>
        <td width="70%"   align="center"> {{$program->description}}   </td>
        <td> หน้า: <span class="page"></span> / <span class="topage"></span></td>
    </tr>
</table>