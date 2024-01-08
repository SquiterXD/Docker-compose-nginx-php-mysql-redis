<!DOCTYPE html>
<html>
    <head>
    @php
        $tcode = "t".$typecode;
        $num_col=13;
        if($typecode==20){ $programCode.="_1"; }
        $items_s=array();
        foreach($items as $item){
            $items_s[]=array("item_code"=>$item->item_code,"item_title"=>$item->item_title, "creation_date"=>$item->creation_date);
        }

        $count_item = count($items_s);
        $sections = array_chunk($items_s, $num_col);
        $count_section = count($sections);
        $count_s=0;
        $totalAmtGlobal = 0;
        $totalQtyGlobal = 0;
        $totalAllGlobal = 0;
    @endphp
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports._style')
    </head>
    </head>
    <body>

    @foreach ($sections as $section)
        <div class="page-break"></div>
        @php
            $count_s++;
            $col_span=($count_s==$count_section)?3:0;
            $colspan=count($section)+3+$col_span;
            // dd($data->groupBy('zone_name'));
        @endphp
        @php
            $totalQty = 0;
            $totalAmt = 0;
            $totalAll = 0;
            $total["qty"] = 0;
            $total["amt"] = 0;
            foreach($section as $item){
                $qty="qty_".strtotime($item["creation_date"]);
                $amt="amt_".strtotime($item["creation_date"]);
                $total[$qty]=0;
                $total[$amt]=0;
            }
        @endphp
        <table class="table">
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">

                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                                โปรแกรม : {{ $programCode }}<br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->username }}
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
                                หน่วย : &nbsp; &nbsp; &nbsp; พันมวน<br>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:50px;">
                    <th style="width:165px;text-align:left"> ใบกำกับสินค้า<br>เลขที่</th>
                    <th style="min-width:200px;text-align:left;padding-left:5px"> ชื่อ</th>
                    <th style="width:50px;"></th>
                @foreach ($section as $item)
                    <th style="width:110px;text-align:center"> {!! str_replace("90","<br>90",str_replace("(","<br>(",trim($item["item_title"]))) !!}</th>
                @endforeach
                @if($count_s==$count_section)
                <th style="width:150px;text-align:center"> ยอดรวม<br>บุหรี่</th>
                <th style="width:150px;text-align:center"> จำนวนเงิน<br>บุหรี่</th>
                <th style="width:150px;text-align:center"> จำนวนเงิน<br>ทั้งสิ้น</th>
                @endif
                </tr>
            </thead>
            <tbody>

            @foreach ($dataGoupZone[0] as $group => $lines)
                @php
                    $sumQty = 0;
                    $sumAmt = 0;
                    $sumAll =0;
                    $total["sumqty"] = 0;
                    $total["sumamt"] = 0;

                    foreach($section as $item){
                        $qty="qty_".strtotime($item["creation_date"]);
                        $amt="amt_".strtotime($item["creation_date"]);
                        $total["sum_".$qty]=0;
                        $total["sum_".$amt]=0;
                    }
                @endphp
                <tr style="height:20px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
                <tr style="height:20px;">
                    <th style="font-weight:bold;text-align:left;" colspan="{{ $colspan }}" >{{ $group }}</th>
                </tr>
                @foreach ($lines as $line )
                    @php
                        $totalQty += $line->qty;
                        $totalAmt += $line->amt;
                        $totalAll += $line->amt;
                        $sumQty += $line->qty;
                        $sumAmt += $line->amt;
                        $sumAll += $line->amt;

                        foreach($section as $item){
                            $qty="qty_".strtotime($item["creation_date"]);
                            $amt="amt_".strtotime($item["creation_date"]);
                            $total[$qty]+=$line->$qty;
                            $total[$amt]+=$line->$amt;
                            $total["sum_".$qty]+=$line->$qty;
                            $total["sum_".$amt]+=$line->$amt;
                        }
                    @endphp
                    <tr>
                        <td>{{ $line->so_no }}</td>
                        <td style="text-align: left;">{{ $line->cus_name }}</td>
                        <td></td>
                        @foreach ($section as $item)
                            @php
                                $qty="qty_".strtotime($item["creation_date"]);
                                $amt="amt_".strtotime($item["creation_date"]);
                            @endphp
                            <td style="text-align: right;">{{ ($line->$qty<>0)?number_format($line->$qty,2):'' }}</td>
                        @endforeach
                        @if($count_s==$count_section)
                            <td style="text-align: right;">{{ ($line->qty<>0)?number_format($line->qty,2):'' }}</td>
                            <td style="text-align: right;">{{ ($line->amt<>0)?number_format($line->amt,2):'' }}</td>
                            <td style="text-align: right;">{{ ($line->amt<>0)?number_format($line->amt,2):'' }}</td>
                        @endif
                    </tr>
                @endforeach
                    <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                        <td colspan=2 style="text-align: left;">รวมยอดขาย</td>
                        <td></td>
                    @foreach ($section as $item)
                        @php
                            $qty="qty_".strtotime($item["creation_date"]);
                            $amt="amt_".strtotime($item["creation_date"]);
                        @endphp
                        <td style="text-align: right;">{{ ($total["sum_".$qty]<>0)?number_format($total["sum_".$qty],2):'' }}</td>
                    @endforeach
                    @if($count_s==$count_section)
                        @php
                            $totalAmtGlobal = $sumAmt + $totalAmtGlobal;
                            $totalQtyGlobal = $sumQty + $totalQtyGlobal;
                            $totalAllGlobal = $sumAll + $totalAllGlobal;
                        @endphp
                        <td style="text-align: right;">{{ ($sumQty<>0)?number_format($sumQty,2):'' }}</td>
                        <td style="text-align: right;">{{ ($sumAmt<>0)?number_format($sumAmt,2):'' }}</td>
                        <td style="text-align: right;">{{ ($sumAll<>0)?number_format($sumAll,2):'' }}</td>
                    @endif
                    </tr>
            @endforeach
                <tr style="height:20px;">
                        <td colspan="{{ $colspan }}"></td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                    <td colspan=2 style="text-align: left;">รวมยอดขายทั้งสิ้น</td>
                    <td></td>
                @foreach ($section as $item)
                    <td style="text-align: right;">{{ ($total["qty_".strtotime($item["creation_date"])]<>0)?number_format($total["qty_".strtotime($item["creation_date"])],2):'' }}</td>
                @endforeach
                @if($count_s==$count_section)
                    <td style="text-align: right;">{{ ($totalQty<>0)?number_format($totalQtyGlobal,2):'' }}</td>
                    <td style="text-align: right;">{{ ($totalAmt<>0)?number_format($totalAmtGlobal,2):'' }}</td>
                    <td style="text-align: right;">{{ ($totalAll<>0)?number_format($totalAllGlobal,2):'' }}</td>
                @endif
                </tr>
            </tbody>
        </table>
    @endforeach
    <div class="page-break"></div>

    @for ($iPn = 1; $iPn <= $pagenum; $iPn++)

        @php
            $count_s_2=0;
        @endphp

        @foreach ($sections as $section)
            <div class="page-break"></div>
            @php
                $count_s_2++;
                $col_span=($count_s_2==$count_section)?3:0;
                $colspan=count($section)+3+$col_span;
                // dd($data->groupBy('zone_name'));
            @endphp
            @php
                $totalQty = 0;
                $totalAmt = 0;
                $totalAll = 0;
                $total["qty"] = 0;
                $total["amt"] = 0;
                foreach($section as $item){
                    $qty="qty_".strtotime($item["creation_date"]);
                    $amt="amt_".strtotime($item["creation_date"]);
                    $total[$qty]=0;
                    $total[$amt]=0;
                }
            @endphp
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="{{ $colspan }}">

                            <div class="row">
                                <div style="width:20%;text-align:left" class="b">
                                    โปรแกรม : {{ $programCode }}<br>
                                    สั่งพิมพ์ : {{ optional(auth()->user())->username }}
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
                                    หน่วย : &nbsp; &nbsp; &nbsp; พันมวน<br>
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:50px;">
                        <th style="width:165px;text-align:left"> ใบกำกับสินค้า<br>เลขที่</th>
                        <th style="min-width:200px;text-align:left;padding-left:5px"> ชื่อ</th>
                        <th style="width:50px;"></th>
                    @foreach ($section as $item)
                        <th style="width:110px;text-align:center"> {!! str_replace("90","<br>90",str_replace("(","<br>(",trim($item["item_title"]))) !!}</th>
                    @endforeach
                    @if($count_s_2==$count_section)
                        <th style="width:150px;text-align:center"> ยอดรวม<br>บุหรี่</th>
                        <th style="width:150px;text-align:center"> จำนวนเงิน<br>บุหรี่</th>
                        <th style="width:150px;text-align:center"> จำนวนเงิน<br>ทั้งสิ้น</th>
                    @endif
                    </tr>
                </thead>
                <tbody>
                @if(!empty($dataGoupZone[$iPn]))
                @foreach ($dataGoupZone[$iPn] as $group => $lines)
                    @php
                        $sumQty = 0;
                        $sumAmt = 0;
                        $sumAll =0;
                        $total["sumqty"] = 0;
                        $total["sumamt"] = 0;

                        foreach($section as $item){
                            $qty="qty_".strtotime($item["creation_date"]);
                            $amt="amt_".strtotime($item["creation_date"]);
                            $total["sum_".$qty]=0;
                            $total["sum_".$amt]=0;
                        }
                    @endphp
                    <tr style="height:20px;">
                        <td colspan="{{ $colspan }}"></td>
                    </tr>
                    <tr style="height:20px;">
                        <th style="font-weight:bold;text-align:left;" colspan="{{ $colspan }}" >{{ $group }}</th>
                    </tr>
                    @foreach ($lines as $line )
                        @php
                            $totalQty += $line->qty;
                            $totalAmt += $line->amt;
                            $totalAll += $line->amt;
                            $sumQty += $line->qty;
                            $sumAmt += $line->amt;
                            $sumAll += $line->amt;

                            foreach($section as $item){
                                $qty="qty_".strtotime($item["creation_date"]);
                                $amt="amt_".strtotime($item["creation_date"]);
                                $total[$qty]+=$line->$qty;
                                $total[$amt]+=$line->$amt;
                                $total["sum_".$qty]+=$line->$qty;
                                $total["sum_".$amt]+=$line->$amt;
                            }
                        @endphp
                        <tr>
                            <td>{{ $line->so_no }}</td>
                            <td style="text-align: left;">{{ $line->cus_name }}</td>
                            <td></td>
                            @foreach ($section as $item)
                                @php
                                    $qty="qty_".strtotime($item["creation_date"]);
                                    $amt="amt_".strtotime($item["creation_date"]);
                                @endphp
                                <td style="text-align: right;">{{ ($line->$qty<>0)?number_format($line->$qty,2):'' }}</td>
                            @endforeach
                            @if($count_s_2==$count_section)
                                <td style="text-align: right;">{{ ($line->qty<>0)?number_format($line->qty,2):'' }}</td>
                                <td style="text-align: right;">{{ ($line->amt<>0)?number_format($line->amt,2):'' }}</td>
                                <td style="text-align: right;">{{ ($line->amt<>0)?number_format($line->amt,2):'' }}</td>
                            @endif
                        </tr>
                    @endforeach
                        <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                            <td colspan=2 style="text-align: left;">รวมยอดขาย</td>
                            <td></td>
                        @foreach ($section as $item)
                            @php
                                $qty="qty_".strtotime($item["creation_date"]);
                                $amt="amt_".strtotime($item["creation_date"]);
                            @endphp
                            <td style="text-align: right;">{{ ($total["sum_".$qty]<>0)?number_format($total["sum_".$qty],2):'' }}</td>
                        @endforeach
                        @if($count_s_2==$count_section)
                            @php
                                $totalAmtGlobal = $sumAmt + $totalAmtGlobal;
                                $totalQtyGlobal = $sumQty + $totalQtyGlobal;
                                $totalAllGlobal = $sumAll + $totalAllGlobal;
                            @endphp
                            <td style="text-align: right;">{{ ($sumQty<>0)?number_format($sumQty,2):'' }}</td>
                            <td style="text-align: right;">{{ ($sumAmt<>0)?number_format($sumAmt,2):'' }}</td>
                            <td style="text-align: right;">{{ ($sumAll<>0)?number_format($sumAll,2):'' }}</td>
                        @endif
                        </tr>
                @endforeach
                @endif
                    <tr style="height:20px;">
                        <td colspan="{{ $colspan }}"></td>
                    </tr>
                    <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                        <td colspan=2 style="text-align: left;">รวมยอดขายทั้งสิ้น</td>
                        <td></td>
                    @foreach ($section as $item)
                        <td style="text-align: right;">{{ ($total["qty_".strtotime($item["creation_date"])]<>0)?number_format($total["qty_".strtotime($item["creation_date"])],2):'' }}</td>
                    @endforeach
                    @if($count_s_2==$count_section)
                        <td style="text-align: right;">{{ ($totalQty<>0)?number_format($totalQtyGlobal,2):'' }}</td>
                        <td style="text-align: right;">{{ ($totalAmt<>0)?number_format($totalAmtGlobal,2):'' }}</td>
                        <td style="text-align: right;">{{ ($totalAll<>0)?number_format($totalAllGlobal,2):'' }}</td>
                    @endif
                    </tr>
                </tbody>
            </table>
        @endforeach
    @endfor
        <div style="padding-top:10px;">หมายเหตุรายการ : {{ $remark }}</div>
        <div class="row" style="padding-top:10px;text-align:center">จบรายงาน</div>
        <div style="text-align:right; padding-top: 15px;">
            <div>ผู้จัดทำ _________________________________ ผู้ตรวจทาน _________________________________ รับรองถูกต้อง _________________________________</div>
        </div>
    </body>
</html>

