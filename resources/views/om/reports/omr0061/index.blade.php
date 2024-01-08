<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<table>
    <thead>
        <tr>
            <th style="text-align:left;">โปรแกรม : {{ $programCode }}</th>
            <th colspan=4 style="text-align:center;">การยาสูบแห่งประเทศไทย</th>
            <th style="text-align:right;"> วันที่ : {{ parseToDateTh(now()) }}</th>
        </tr>
        <tr>
            <th style="text-align:left;">สั่งพิมพ์ : {{ optional(auth()->user())->username }}</th>
            <th colspan=4 style="text-align:center;">{{ $progTitle }}</th>
            <th style="text-align:right;">เวลา : {{ date('H:i', strtotime(now())) }}</th>
        </tr>
        <tr>
            <th style="text-align:left;"></th>
            <th colspan=4 style="text-align:center;">{{ $progPara }}</th>
            <th style="text-align:right;">  หน้า : <span class="pagenum">1</span></th>
        </tr>
        <tr>
            <th></th>
            <th colspan={{ $colspan }} style="text-align:center;"></th>
            <th style="text-align:right;"></th>
        </tr>
        <tr>
            <th style="width:200px;text-align:left;"> รายการบุหรี่</th>
            <th style="width:100px;text-align:right"> จำนวน (พันมวน)</th>
            <th style="width:150px;text-align:right"> ราคาขายปลีก</th>
            <th style="width:150px;text-align:right"> ภาษีมูลค่าเพิ่ม</th>
            <th style="width:150px;text-align:right"> มูลค่าสินค้า</th>
            <th style="width:150px;text-align:right"> มูลค่าขาย</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($data as $line)
        <tr>
            <td>{{ $line->item_description }}</td>
            <td style="text-align: right;">{{ ($line->qty<>0)?$line->qty:'' }}</td>
            <td style="text-align: right;">{{ ($line->sale_amt<>0)?$line->sale_amt:'' }}</td>
            <td style="text-align: right;">{{ ($line->sale_amt<>0)?$line->sale_amt*7/107:'' }}</td>
            <td style="text-align: right;">{{ ($line->sale_amt<>0)?$line->sale_amt-($line->sale_amt*7/107):'' }}</td>
            <td style="text-align: right;">{{ ($line->amt<>0)?$line->amt:'' }}</td>
        </tr>
    @endforeach
        <tr>
            <td style="text-align: right;">รวม</td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan=6></td>
        </tr>
        <tr>
            <td colspan=6>หมายเหตุรายการ {{ $remark }}<</td>
        </tr>
    </tbody>
</table>
