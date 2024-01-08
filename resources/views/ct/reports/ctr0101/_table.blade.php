<div style="min-height: 640px;">

    <table border="0" width="100%" style="font-size: 12px;">
        <thead>
            <tr style="border-bottom: 1px solid #000; border-top: 1px solid #000;">
                <th width="13%" rowspan="2" class="text-center"> รหัสวัตถุดิบ </th>
                <th width="30%" rowspan="2" class="text-center"> รายละเอียด </th>
                <th width="10%" rowspan="2" class="text-center"> หน่วยนับ </th>
                <th colspan="3" class="text-center"> จริง </th>
                <th width="13%" rowspan="2" class="text-center"> หมายเหตุ </th>
            </tr>
            <tr style="border-bottom: 1px solid #000; border-top: 1px solid #000;">
                <th width="10%" class="text-center"> จำนวน </th>
                <th width="10%" class="text-center"> ราคา </th>
                <th width="15%" class="text-center"> จำนวนเงิน </th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportTrans as $key => $reportTran)
                @foreach($reportTran["transactions"] as $tran)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td width="13%" class="text-center"> {{ $tran['item_no'] }} </td>
                        <td width="30%" class="text-left"> {{ $tran['item_desc'] }} </td>
                        <td width="10%" class="text-center"> {{ $tran['uom_desc'] }} </td>
                        <td width="10%" class="text-right"> {{ number_format($tran['mmt_qty'], 2) }} </td>
                        <td width="10%" class="text-right"> {{ number_format($tran['mmt_unit_price'], 2) }} </td>
                        <td width="15%" class="text-right"> {{ number_format($tran['mmt_amount'], 2) }} </td>
                        <td width="13%" class="text-center"> {{ $tran['comments'] }} </td>
                    </tr>
                @endforeach
                <tr style="border-bottom: 1px solid #000;">
                    <td class="text-left"> &nbsp; </td>
                    <td class="text-left tw-font-bold"> รวม {{ $reportTran['item_cat_segment1_desc'] }} </td>
                    <td class="text-center"> &nbsp; </td>
                    <td class="text-right"> {{ number_format($reportTran['total_mmt_qty'], 2) }} </td>
                    <td colspan="2" class="text-right"> {{ number_format($reportTran['total_mmt_amount'], 2) }} </td>
                    <td class="text-center"> &nbsp; </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>