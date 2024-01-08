<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ \Str::limit($titleReport, 20)}}</title>
    <style>
        @font-face {
           font-family: 'THSarabunNew';
           font-style: normal;
           font-weight: normal;
           src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
       }

       @font-face {
           font-family: 'THSarabunNew';
           font-style: normal;
           font-weight: bold;
           src: url("{{ base_path() }}/public/fonts/THSarabunNew Bold.ttf") format("truetype");
       }

       @font-face {
           font-family: 'THSarabunNew';
           font-style: italic;
           font-weight: normal;
           src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
       }
       
       @font-face {
           font-family: 'THSarabunNew';
           font-style: italic;
           font-weight: bold;
           src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
       }
       body {
           font-family: 'THSarabunNew'
       }
       thead{display: table-header-group;}
       tfoot {display: table-row-group;}
       tr {page-break-inside: avoid;}
       
       .border-tom-bottom {
           border-top: 1px solid #000;
           border-bottom: 1px solid #000;
       }

       table {
           border-collapse: collapse;
       }

       td,
       th {
           padding: 3px;
       }

       div.page {
           page-break-after: always;
           page-break-inside: avoid;
       }
       thead table * {
           padding: 0;
           margin:0;
       }
   </style>
</head>
<body>
    <div class="page">
    </div>
    <table style="width:100%">
        <thead>
            <tr>
                <td>โปรแกรม : {{$program->program_code}} </td>
                <td align="center" colspan="4">การยาสูบแห่งประเทศไทย</td>
                <td>วันที่ : {{ now()->addYears('543')->format('d/m/Y') }}</td>
            </tr>

            <tr>
                <td>สั่งพิมพ์ : {{ auth()->user()->username }}</td>
                <td align="center" colspan="4">{{$titleReport}}</td>
                <td>เวลา : {{ now()->addYears('543')->format('H:i') }}</td>
            </tr>
            <tr>
                <td></td>
                <td align="center" colspan="4">{{$typeName}}</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td align="center" colspan="4">
                    {{$date}}
                </td>
                <td></td>
            </tr>

          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>

            
            <tr>
                <th style="border-top:1px solid #000;border-bottom:1px solid #000;">ตราสินค้า</th>
                <th style="border-top:1px solid #000;border-bottom:1px solid #000;">จำนวน ({{$uom->unit_of_measure}})</th>
                <th style="border-top:1px solid #000;border-bottom:1px solid #000;">ราคา (บาท)</th>
                <th style="border-top:1px solid #000;border-bottom:1px solid #000;">ภาษีมูลค่าเพิ่ม (บาท)</th>
                <th style="border-top:1px solid #000;border-bottom:1px solid #000;">ราคาขายหักภาษีฯ</th>
                <th style="border-top:1px solid #000;border-bottom:1px solid #000;"></th>
            </tr>
        </thead>
        <tbody>
            @php 
                $sumApproveQuanti = 0;
                $sumTotalAmount = 0;
                $sumTaxAmount = 0;
                $sumAmount = 0;
            @endphp
            @foreach($items->groupBy('item_id') as $item)
            @php
                $sumApproveQuanti += $item->sum('approve_quantity');
                $sumTotalAmount += $item->sum('total_amount');
                $sumTaxAmount += $item->sum('tax_amount');
                $sumAmount += $item->sum('amount');
            @endphp
            <tr>
                <td>{{$item->first()->item_description}}</td>
                <td style="text-align:right" data-format="{{getNumberFormatFor0082($item->sum('approve_quantity'), $product_type_code)}}">{{$item->sum('approve_quantity')}}</td>
                <td style="text-align:right">
                    {{number_format($item->sum('total_amount'), 2)}}
                </td>
                <td style="text-align:right">{{number_format($item->sum('tax_amount'), 2)}}</td>
                <td style="text-align:right">{{number_format($item->sum('amount'), 2)}}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align:right">รวม</td>
                <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align:right" data-format="{{getNumberFormatFor0082($item->sum('approve_quantity'), $product_type_code)}}">{{ $sumApproveQuanti }}</td>
                <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align:right">{{ number_format($sumTotalAmount, 2) }}</td>
                <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align:right">{{ number_format($sumTaxAmount, 2) }}</td>
                <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align:right">{{ number_format($sumAmount, 2) }}</td>
                <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align:right"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>