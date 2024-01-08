
<table class="table">
    <thead>
    <tr>
        <th colspan="10" align="left" style=" border-bottom: 1px solid #464DD5" ></th>
        </tr>
            <tr style="border-top: 1px solid #464DD5; margin: 0px; padding: 0px">
                <td align="center"> สถานที่ - ยี่ห้อ</td>
                <td align="center"> ทะเบียน</td>
                <td align="center"> รหัสบัญชี</td>
                <td align="center"> ชื่อบัญชี</td>
                <td align="center"> ค่าเบี้ยประกัน(บาท)</td>
            </tr>
        <tr>
            <th style="border-top: 1px solid #464DD5" colspan="10" ></th>
        </tr>
    <hr class="p-0 m-0">
      @foreach ($expenseCarGas->groupBy('department_name') as $departments)
            @foreach ($departments as $item)
                <tr>
                    <td>{{$item->department_name }}</td>
                </tr> 
                @break
            @endforeach
            @foreach ($departments->groupBy('vehicle_type_name') as $vehicleTypeName)
                <?php $netAmount = 0 ?>
                @foreach ($vehicleTypeName as $item) 
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$item->vehicle_type_name}}</td>
                    </tr>
                @break
                @endforeach

                @foreach ($vehicleTypeName as $item)
                    <tr>
                         <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $item->vehicle_brand_name }}</td>
                         <td align="center">{{ $item->license_plate }}</td>
                         <td align="center">{{ $item->expense_account }}</td>
                         <td align="center">{{ $item->expense_account_desc }}</td>
                         <td style="text-align: right;">{{ $item->net_amount }}</td>
                    </tr>
                    <?php $netAmount += $item->net_amount ?>
                @endforeach
                <tr>
                    <td>รวม</td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td  style="text-align: right;">{{$netAmount}}</td>
                </tr>
            @endforeach
      @endforeach
    </tbody>
    </table>
