<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports._style')
    </head>
    <body>
        @php
        $Grand_total = 0;
    @endphp
    @for($count_s=0;$count_s < count($data); $count_s++)
    @php
        $colspan=(count($items[$count_s])*2)+1;
        $rma = @$rmaByCusType[$custype[$count_s]['customer_type_id']];
    @endphp
        <div class="page-break"></div>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">

                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                                โปรแกรม : {{ $programCode }}<br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->username }}<br>
                                <br>

                            </div>
                            <div style="width:60%;text-align:center" class="b">
                                การยาสูบแห่งประเทศไทย<br>
                                {{ $progTitle }}<br>
                                @php
                                    foreach($progPara[$count_s] as $para){
                                        echo $para."<br>";
                                    }
                                @endphp
                            </div>
                            <div style="width:20%;text-align:right;" class="b">
                                วันที่ : {{ parseToDateTh(now()) }}<br>
                                เวลา :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                                <br>
                                หน่วย : บุหรี่/พันมวน ยาเส้น/หีบ<br>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;height:14px;">
                    <th rowspan=2 style="min-width:140px;text-align:left">ตรา</th>
                @foreach ($items[$count_s] as $item)
                    <th colspan=2 style="text-align:center;">{{ $item }}</th>
                @endforeach
                </tr>
                <tr style="border-bottom: 1px solid #000;height:14px;">
                @foreach ($items[$count_s] as $item)
                    <th style="text-align:right">{{ $unit[$count_s] }}</th>
                    <th style="text-align:right">บาท</th>
                @endforeach
                </tr>
            </thead>
            <tbody>
            @php
                $sum=array();
                $sum["qty"] = 0;
                $sum["total"] = 0;
                $i=0;
                foreach ($items[$count_s] as $item){
                    $sum["qty_$i"]=0;
                    $sum["total_$i"]=0;

                    $sum["grand_qty_$i"]=0;
                    $sum["grand_total_$i"]=0;
                    $i++;
                }
            @endphp

            @foreach ($data[$count_s] as $line)
                @php
                    $i=0; $j=0; $row=0;
                    foreach ($items[$count_s] as $item){
                        $aa="qty_".$j;
                        $q=$line->$aa;
                        $row+=$q;
                        $j++;
                    }
                @endphp
                <tr style="height:12px;">
                    <td>{{ $line->item_title }}</td>
                    @foreach ($items[$count_s] as $item)
                    @php
                        
                        $aa="qty_".$i;
                        $bb="price_".$i;
                        $qty=$line->$aa;
                        $price_target=$line->$bb;
                        $row+=$qty;
                        $total=$price_target;
                        if($count_s == 5) {
                            if($i== 2) {
                                $total = $line->new_qty;
                            }
                        }
                        $sum["qty_$i"]+=$qty;
                        $sum["total_$i"]+=$total;

                        $sum["qty"]+=$qty;
                        $sum["total"]+=$total;

                        if($count_s>4){
                            $sum["grand_qty_$i"]+=$qty;
                            $sum["grand_total_$i"]+=$total;
                        }
                        $i++;
                    @endphp
                    <td style="text-align: right;">{{ ($qty<>0)?number_format($qty,2):'' }}</td>
                    <td style="text-align: right;">{{ ($total<>0)?number_format($total,2):'' }} 
                        {{-- / {{$line->price}} / {{$qty}} --}}
                        @if($count_s == 5)
                            @if($i== 3)
                            {{-- {{$line->new_qty}} /{{$line->price}}  --}}
                            @endif
                        @endif
                    </td>

                    @endforeach
                    @php
                        $count_colum = count($items[$count_s]);
                        if($count_s == 5 || $count_s == 7 || $count_s == 8 || $count_s == 9){
                            $Grand_total += $total;
                        }
                    @endphp
                </tr>
            @endforeach
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:14px;">
                    <td style="text-align: left;">รวม</td>
                    @for($i=0;$i < count($items[$count_s]);$i++)
                    <td style="text-align: right;">{{ ($sum["qty_$i"]<>0)?number_format($sum["qty_$i"],2):'' }}</td>
                    <td style="text-align: right;">{{ ($sum["total_$i"]<>0)?number_format($sum["total_$i"],2):'' }}</td>
                    @endfor
                </tr>
            @include('om.reports.omr0056.pdf.layouts.rma')
                @if($count_s == 7 || $count_s == 9)
                <tr style="height:5px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:16px;">
                    <td style="text-align: left;">รวม(บุหรี่ + ยาเส้น) {{ ($count_s == 9)? 'ไม่คิดมูลค่า':'' }}</td>
                    @for($i=0;$i < count($items[$count_s]);$i++)
                    {{-- <td style="text-align: right;">{{ ($sum["grand_qty_$i"]<>0)?number_format($sum["grand_qty_$i"],2):'' }}</td> --}}
                        @if ($i == (count($items[$count_s])-1))
                            <td></td>
                            <td style="text-align: right;">{{ ($Grand_total<>0)?number_format($Grand_total,2):'' }}</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif

                    @endfor
                </tr>
                @endif
            </tbody>
        </table>
        @php
        if($count_s == 7){
            $Grand_total = 0;
        }
        @endphp
    @endfor
    </div>
    <div style="padding-top:1px;text-align:left">หมายเหตุรายการ : 
        {{ $rmaRemark }}
        {{ $remark }}</div>
    <div style="padding-top:1px;text-align:center">จบรายงาน</div>

    <div style="padding-top:1px;text-align:right">
            <div>ผู้จัดทำ _____________________________ หัวหน้าส่วนงาน _____________________________ <br><br>
             หัวหน้ากองบริหารขาย _____________________________</div>
    </div>
    </body>
</html>
