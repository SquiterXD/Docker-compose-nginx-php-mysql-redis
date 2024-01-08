
<table class="table">
    <tbody>
        
            <tr>
              <th>สถานที่ - ยี่ห้อ</th>
              <th>ทะเบียน</th>
              <th>รหัสบัญชี</th>
              <th>ชื่อบัญชี</th>
              <th>ค่าเบี้ยประกัน <br> (บาท) </th>
            </tr>
            <tr>
                <th rowspan="1" style="min-width: 300px">ส่วนการโครงการขยาย รง.ผลิตยาสูบกองบริกร <br>
                รถเก๋ง  <p>1. เชพโรเลท <br>
                         2.เชพโรเลท</p> </th>
                <th rowspan="1" style="min-width: 150px">ญผ-4192</th>
                <th rowspan="1" style="min-width: 350px">01.6.12060100.00.00.000.000000.0.651000.561.0.0</th>
                <th rowspan="8" style="min-width: 350px">กองบริหารทั่วไป สวนงานโครงการย้ายโรงงานผลิตฯ คลอง-ค่าใช้จ่ายในการ</th>
                <th  style="min-width: 125px">910.00 <br> 910.00</th>
            </tr>
            
            
          
      {{-- @foreach ($element->groupBy('sub_inventory_desc')->sortBy('sub_inventory_code') as $subInvDes => $subInvs) --}}
        {{-- @foreach ($subInvs->groupBy('location_desc')->sortBy('location_code') as $locationDesc => $lines) --}}
            {{-- <tr>
                <th colspan="9" align="left"><b> รหัสคลังสินค้า : {{  $subInvDes }}</b> </th>
                <th></th>
            </tr>
            <tr>
                <th colspan="10" align="left" ><b>กลุ่มสินค้าย่อย :{{ $locationDesc }}</b>  </th>
            </tr> --}}
            {{-- <tr>
                <th colspan="10" align="left" style=" border-bottom: 1px solid #464DD5" ></th>
            </tr>
                <tr style="border-top: 1px solid #464DD5; margin: 0px; padding: 0px;">
                    <td align="center" style="min-width: 300px"> สถานที่ - ยี่ห้อ </td>
                    <td align="center" style="min-width: 150px"> ทะเบียน </td>
                    <td align="center" style="min-width: 350px"> รหัสบัญชี </td>
                    <td align="center" style="min-width: 350px"> ชื่อบัญชี</td>
                    <td align="center" style="min-width: 125px"> ค่าเบี้ยประกัน <br> (บาท) </td>
                </tr>
            <tr>
                <th style="border-top: 1px solid #464DD5" colspan="10" ></th>
            </tr> --}}
            {{-- <hr class="p-0 m-0"> --}}
                {{-- @foreach ($lines as $line) --}}
                    {{-- <tr>
                        <td align="center" style="min-width: 300px">ส่วนการโครงการขยาย รง.ผลิตยาสูบกองบริ</td>
                        <td align="center" style="min-width: 150px">ญผ-4192</td>
                        <td align="center" style="min-width: 350px">01.6.12060100.00.00.000.000000.0.651000.561.0.0</td>
                        <td align="center" style="min-width: 350px">กองบริหารทั่วไป สวนงานโครงการย้ายโรงงานผลิตฯ คลอง-ค่าใช้จ่ายในการ</td>
                        <td align="center" style="min-width: 125px">910.00</td>
                    </tr> --}}
                {{-- @endforeach --}}
        {{-- @endforeach --}}

        {{-- <tr style="border-top: 1px solid #464DD5; margin: 0px; padding: 0px">
            <td colspan="5" align="center">รวม กลุ่มสินค้าย่อย :</td>
            <td>test</td>
            <td></td>
            <td>test</td>
            <td>test</td>
        </tr>
        <tr>
            <th style="border-top: 1px solid #464DD5" colspan="10" ></th>
        </tr> --}}
        {{-- @if ($loop->last) --}}
            {{-- <tr style="border-top: 1px solid #464DD5; margin: 0px; padding: 0px">
                <td colspan="5" align="center">รวม คลังสินค้า :test </td>
                <td>test</td>
                <td></td>
                <td>test</td>
                <td>test</td>
            </tr>
            <tr>
                <th style="border-top: 2px solid #464DD5" colspan="10" ></th>
            </tr> --}}
        {{-- @endif
      @endforeach --}}
        </tbody>
    </table>
    <style>
        table, td, th {
            border: 1px solid black;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th {
            height: 50px;
        }
        </style>
