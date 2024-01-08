<html>
<head>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            background: rgb(204,204,204);
            font-size:14px;
        }
        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        page[size="A4"] {
            width: 21cm;
            height: 29.7cm;
        }
        @media print {
            body, page[size="A4"] {
                margin: 0;
                box-shadow: 0;
            }
        }
        table{
            width: 100%;
        }
        .pull-left{
            text-align: left;
        }
        .pull-right{
            text-align: right;
        }
    </style>
</head>
<body onload="window.print()">
@foreach($invoices as $key => $invoice)
    <page size="A4" class="print" >
        <div style="padding:20px; padding-top: 50px" >
            <table>
                <tr>
                    <td colspan="6" class="pull-left">
                        {{$invoice->name}}
                    </td>
                </tr>
                <tr>
                    <td >{{$invoice->phone??'-'}}</td>
                    <td colspan="5" class="pull-left">{{$invoice->name}}</td>
                </tr>
                <tr>
                    <td rowspan="3"><div style="max-width: 200px;display: -webkit-box;-webkit-line-clamp: 3;"></div>{{$invoice->address}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    {{--<td>ต.บางบัวทอง อ.บางบัวทอง</td>--}}
                    <td></td>
                    <td>{{\Carbon\Carbon::parse($invoice->delivery_date)->format('d/m/Y')}}</td>
                    <td>E-commerce</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    {{--<td>นนทบุรี</td>--}}
                    <td></td>
                    <td>23022564</td>
                    <td>{{\Carbon\Carbon::parse($invoice->delivery_date)->format('d/m/Y')}}</td>
                    <td>{{$invoice->name}}</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <table>
                <?php $tests = [1,2,3,4,5,6,6,7,8,8]?>
                @foreach($tests as $k => $test)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>1</td>
                        <td>10</td>
                        <td>wonder red</td>
                        <td>2,740,000</td>
                        <td>2,740,000</td>
                        <td>3,740,000</td>
                        <td>3,740,000</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td>รวมพันมวน</td>
                    <td>50</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>156,847.20</td>
                    <td></td>
                    <td>172,897.20</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>ภาษีมูลค่าเพิ่มร้อยละ</td>
                    <td>7</td>
                    <td>12,123.89</td>
                    <td></td>
                    <td>12,323,232</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>มูลค่าสินค้ารวมภาษี</td>
                    <td></td>
                    <td>12,123.89</td>
                    <td></td>
                    <td>12,323,232</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>มูลค่าสินค้ารวมภาษี</td>
                    <td></td>
                    <td>12,123.89</td>
                    <td></td>
                    <td>12,323,232</td>
                </tr>
                <tr>
                    <td></td>
                    <td>จำนวนที่ชำระเป็นเงินสด</td>
                    <td></td>
                    <td>12,123.89</td>
                    <td></td>
                    <td>12,323,232</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <br>
            <br>
            <table>
                <?php $rolls =[1,2,3,4] ?>
                @foreach($rolls as $roll)
                    <tr>
                        <td colspan="3" class="pull-right">อบจ. นนทบุรี</td>
                        <td colspan="2" class="pu;;-right">50.00</td>
                        <td>พันมวน</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </page>
@endforeach
</body>
</html>