<!DOCTYPE html>
<html>
    <head>
    @php
        $tcode = "t".$typecode;
        $num_col=6;
        if($typecode==20){ $programCode.="_1"; $unit="หีบ";}else{ $unit="พันมวน";}
        $items_s=array();
        foreach($items as $item){
            $items_s[]=array("cus_id"=>$item->cus_id,"cus_name"=>$item->cus_name);
        }

        $count_item = count($items_s);
        $sections = array_chunk($items_s, $num_col);
        $count_section = count($sections);
        $count_s=0;

    @endphp
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports._style')
    </head>
    </head>
    <body>

     @foreach ($sections as $section)
        @php
            $count_s++;
            $col_span=($count_s==$count_section)?2:0;
            $colspan=(count($section)*2)+1+$col_span;
        @endphp
        <div class="page-break"></div>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">

                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                                โปรแกรม : {{ $programCode }}<br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->name }}
                            </div>
                            <div style="width:60%;text-align:center" class="b">
                                การยาสูบแห่งประเทศไทย<br>
                                {{ $progTitle }}<br>
                                @php
                                    foreach($progPara as $para){
                                        echo $para."<br>";
                                    }
                                @endphp
                            </div>
                            <div style="width:20%;text-align:right;" class="b">
                                วันที่ : {{ parseToDateTh(now()) }}<br>
                                เวลา :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                                หน่วย : บุหรี่/พันมวน ยาเส้น/หีบ<br>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;height:28px;">
                    <th rowspan=2 style="min-width:150px;text-align:left"> ตรา </th>
                @foreach ($section as $item)
                    <th colspan=2 style="text-align:center;vertical-align:bottom"> {{ $item["cus_name"] }}</th>
                @endforeach
                @if($count_s==$count_section)
                    <th colspan=2 style="text-align:center"> รวมทั้งสิ้น</th>
                @endif
                </tr>
                <tr style="border-bottom: 1px solid #000;height:28px;">
                @foreach ($section as $item)
                    <th style="width:100px;text-align:right">จำนวน</th>
                    <th style="width:120px;text-align:right">{{ $unit }}/บาท</th>
                @endforeach
                @if($count_s==$count_section)
                    <th style="width:100px;text-align:right"> รวม{{ $unit }}</th>
                    <th style="width:150px;text-align:right"> รวมเงินทั้งสิ้น</th>
                @endif
                </tr>
                <tr style="height:10px;">
                    <th colspan="{{ $colspan }}"></th>
                </tr>
            </thead>
            <tbody>
            @php
                $total["qty"] = 0;
                $total["amt"] = 0;
                foreach($section as $item){
                    $qty="qty_".$item["cus_id"];
                    $amt="amt_".$item["cus_id"];
                    $total[$qty]=0;
                    $total[$amt]=0;
                }
            @endphp

            @foreach ($data as $line )
                @php
                    foreach($section as $item){
                        $qty="qty_".$item["cus_id"];
                        $amt="amt_".$item["cus_id"];
                        $total[$qty]+=$line->$qty;
                        $total[$amt]+=$line->$amt;
                    }
                    $total["qty"]+=$line->qty;
                    $total["amt"]+=$line->amt;
                @endphp
                <tr style="height:20px;">
                    <td style="text-align: left;">{{ $line->item_title }}</td>
                @foreach ($section as $item)
                    @php
                        $qty="qty_".$item["cus_id"];
                        $amt="amt_".$item["cus_id"];
                    @endphp
                    <td style="text-align: right;">{{ ($line->$qty<>0)?number_format($line->$qty,2):'' }}</td>
                    <td style="text-align: right;">{{ ($line->$amt<>0)?number_format($line->$amt,2):'' }}</td>
                @endforeach
                @if($count_s==$count_section)
                    <td style="text-align: right;">{{ ($line->qty<>0)?number_format($line->qty,2):'' }}</td>
                    <td style="text-align: right;">{{ ($line->amt<>0)?number_format($line->amt,2):'' }}</td>
                @endif
                </tr>
            @endforeach
                <tr style="height:10px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:30px;">
                    <td style="text-align: left;">รวมยอดขาย</td>
                @foreach ($section as $item)
                    @php
                        $qty="qty_".$item["cus_id"];
                        $amt="amt_".$item["cus_id"];
                    @endphp
                    <td style="text-align: right;">{{ ($total[$qty]<>0)?number_format($total[$qty],2):'' }}</td>
                    <td style="text-align: right;">{{ ($total[$amt]<>0)?number_format($total[$amt],2):'' }}</td>
                @endforeach
                @if($count_s==$count_section)
                    <td style="text-align: right;">{{ ($total["qty"]<>0)?number_format($total["qty"],2):'' }}</td>
                    <td style="text-align: right;">{{ ($total["amt"]<>0)?number_format($total["amt"],2):'' }}</td>
                @endif
                </tr>
            </tbody>

        </table>
        @endforeach
        <div style="padding-top:10px;">หมายเหตุรายการ : {{ $remark }}</div>
     </div>
    </body>
</html>

