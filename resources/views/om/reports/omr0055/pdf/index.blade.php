<!DOCTYPE html>
<html>
    <head>
    @php
        $num_col=9;
        $items_s=array();
        foreach($items as $item){
            $items_s[]=array("item_code"=>$item->item_code,"item_title"=>$item->item_title,"creation_date"=>$item->creation_date);
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
            $col_span = ($count_s==$count_section)?5:0;
            $colspan = count($section)+3+$col_span;
        @endphp
        <div class="page-break"></div>
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
                                เวลา : &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                หน้า :  <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                                หน่วย : บุหรี่/พันมวน ยาเส้น/หีบ<br>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:50px;">
                    <th style="width:135px;text-align:left"> ใบกำกับสินค้า<br>เลขที่</th>
                    <th style="min-width:200px;text-align:left;padding-left:5px"> ชื่อ</th>
                    <th style="width:50px;"></th>
                @foreach ($section as $item)
                    <th style="width:100px;text-align:right"> {!! str_replace("("," <br>(",$item["item_title"]) !!}</th>
                @endforeach
                @if($count_s==$count_section)
                    <th style="width:100px;text-align:right"> ยอดรวม<br>บุหรี่</th>
                    <th style="width:150px;text-align:right"> จำนวนเงิน<br>บุหรี่</th>
                    <th style="width:100px;text-align:right"> ยอดรวม<br>ยาเส้น</th>
                    <th style="width:150px;text-align:right"> จำนวนเงิน<br>ยาเส้น</th>
                    <th style="width:150px;text-align:right"> จำนวนเงิน<br>ทั้งสิ้น</th>
                @endif
                </tr>
                <tr style="height:20px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>

            </thead>
            <tbody>
            @foreach ($data->groupBy('g1') as $group => $groups)
                <tr style="height:20px;">
                    <th style="font-weight:bold;text-align:left;" colspan="{{ $colspan }}" >*** {{ $group }} ***</th>
                </tr>
                @foreach ($groups->groupBy('g2') as $group2 => $lines)
                    <tr style="height:20px;">
                        <th style="font-weight:bold;text-align:left;" colspan="{{ $colspan }}" >** {{ $group2 }} **</th>
                    </tr>
                    @foreach ($lines as $line )
                    <tr>
                        <td style="text-align: left;vertical-align:top;">{{ $line->so_no }}</td>
                        <td style="text-align: left;vertical-align:top;">{{ $line->cus_name }}</td>
                        <td><div style="height:16px">ส่ง</div><div style="height:16px">สั่ง</div></td>
                    @foreach ($section as $item)
                        @php
                            $qty1="qty1_".strtotime($item["creation_date"]);
                            $qty2="qty2_".strtotime($item["creation_date"]);
                        @endphp
                        <td style="text-align: right;"><div style="height:16px"> {{ ($line->$qty1<>0)?number_format($line->$qty1,2):' ' }}</div><div style="height:16px">{{ ($line->$qty2<>0)?number_format($line->$qty2,2):' ' }}</div></td>
                    @endforeach
                    @if($count_s==$count_section)
                        <td style="text-align: right;"><div style="height:16px"> {{ ($line->qty1_10<>0)?number_format($line->qty1_10,2):' ' }}</div><div style="height:16px">{{ ($line->qty2_10<>0)?number_format($line->qty2_10,2):' ' }}</div></td>
                        <td style="text-align: right;"><div style="height:16px"> {{ ($line->amt1_10=0)?number_format($line->amt1_10,2):' ' }}</div><div style="height:16px">{{ ($line->amt2_10<>0)?number_format($line->amt2_10,2):' ' }}</div></td>
                        <td style="text-align: right;"><div style="height:16px"> {{ ($line->qty1_20<>0)?number_format($line->qty1_20,2):' ' }}</div><div style="height:16px">{{ ($line->qty2_20<>0)?number_format($line->qty2_20,2):' ' }}</div></td>
                        <td style="text-align: right;"><div style="height:16px"> {{ ($line->amt1_20=0)?number_format($line->amt1_20,2):' ' }}</div><div style="height:16px">{{ ($line->amt2_20<>0)?number_format($line->amt2_20,2):' ' }}</div></td>
                        <td style="text-align: right;"><div style="height:16px"> {{ ($line->amt1=0)?number_format($line->amt1,2):' ' }}</div><div style="height:16px">{{ ($line->amt2<>0)?number_format($line->amt2,2):' ' }}</div></td>
                    @endif
                    </tr>
                    @endforeach

                    <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                        <td colspan=2 style="text-align: left;">รวม ** {{ $group2 }} ** </td>
                        <td><div style="height:16px">ส่ง</div><div style="height:16px">สั่ง</div></td>
                        @foreach ($section as $item)
                            @php
                                $qty1="qty1_".strtotime($item["creation_date"]);
                                $qty2="qty2_".strtotime($item["creation_date"]);
                            @endphp
                            <td style="text-align: right;"><div style="height:16px"> {{ ($lines->sum($qty1)<>0)?number_format($lines->sum($qty1),2):' ' }}</div><div style="height:16px">{{ ($lines->sum($qty2)<>0)?number_format($lines->sum($qty2),2):' ' }}</div></td>
                        @endforeach
                        @if($count_s==$count_section)
                            <td style="text-align: right;"><div style="height:16px"> {{ ($lines->sum('qty1_10')<>0)?number_format($lines->sum('qty1_10'),2):' ' }}</div><div style="height:16px">{{ ($lines->sum('qty2_10')<>0)?number_format($lines->sum('qty2_10'),2):' ' }}</div></td>
                            <td style="text-align: right;"><div style="height:16px"> {{ ($lines->sum(' ')<>0)?number_format($lines->sum('amt1_10'),2):' ' }}</div><div style="height:16px">{{ ($lines->sum('amt2_10')<>0)?number_format($lines->sum('amt2_10'),2):' ' }}</div></td>
                            <td style="text-align: right;"><div style="height:16px"> {{ ($lines->sum('qty1_20')<>0)?number_format($lines->sum('qty1_20'),2):' ' }}</div><div style="height:16px">{{ ($lines->sum('qty2_20')<>0)?number_format($lines->sum('qty2_20'),2):' ' }}</div></td>
                            <td style="text-align: right;"><div style="height:16px"> {{ ($lines->sum(' ')<>0)?number_format($lines->sum('amt1_20'),2):' ' }}</div><div style="height:16px">{{ ($lines->sum('amt2_20')<>0)?number_format($lines->sum('amt2_20'),2):' ' }}</div></td>
                            <td style="text-align: right;"><div style="height:16px"> {{ ($lines->sum(' ')<>0)?number_format($lines->sum('amt1'),2):' ' }}</div><div style="height:16px">{{ ($lines->sum('amt2')<>0)?number_format($lines->sum('amt2'),2):' ' }}</div></td>
                        @endif
                    </tr>
                @endforeach
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                    <td colspan=2 style="text-align: left;">รวม *** {{ $group }} ***</td>
                    <td><div style="height:16px">ส่ง</div><div style="height:16px">สั่ง</div></td>
                    @foreach ($section as $item)
                        @php
                            $qty1="qty1_".strtotime($item["creation_date"]);
                            $qty2="qty2_".strtotime($item["creation_date"]);
                        @endphp
                        <td style="text-align: right;"><div style="height:16px"> {{ ($groups->sum($qty1)<>0)?number_format($groups->sum($qty1),2):' ' }}</div><div style="height:16px">{{ ($groups->sum($qty2)<>0)?number_format($groups->sum($qty2),2):' ' }}</div></td>
                    @endforeach
                    @if($count_s==$count_section)
                        <td style="text-align: right;"><div style="height:16px"> {{ ($groups->sum('qty1_10')<>0)?number_format($groups->sum('qty1_10'),2):' ' }}</div><div style="height:16px">{{ ($groups->sum('qty2_10')<>0)?number_format($groups->sum('qty2_10'),2):' ' }}</div></td>
                        <td style="text-align: right;"><div style="height:16px"> {{ ($groups->sum(' ')<>0)?number_format($groups->sum('amt1_10'),2):' ' }}</div><div style="height:16px">{{ ($groups->sum('amt2_10')<>0)?number_format($groups->sum('amt2_10'),2):' ' }}</div></td>
                        <td style="text-align: right;"><div style="height:16px"> {{ ($groups->sum('qty1_20')<>0)?number_format($groups->sum('qty1_20'),2):' ' }}</div><div style="height:16px">{{ ($groups->sum('qty2_20')<>0)?number_format($groups->sum('qty2_20'),2):' ' }}</div></td>
                        <td style="text-align: right;"><div style="height:16px"> {{ ($groups->sum(' ')<>0)?number_format($groups->sum('amt1_20'),2):' ' }}</div><div style="height:16px">{{ ($groups->sum('amt2_20')<>0)?number_format($groups->sum('amt2_20'),2):' ' }}</div></td>
                        <td style="text-align: right;"><div style="height:16px"> {{ ($groups->sum(' ')<>0)?number_format($groups->sum('amt1'),2):' ' }}</div><div style="height:16px">{{ ($groups->sum('amt2')<>0)?number_format($groups->sum('amt2'),2):' ' }}</div></td>
                    @endif
                </tr>

            @endforeach
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                    <td colspan=2 style="text-align: left;">รวมยอดขาย<br>อบจ.และไม่อบจ.</td>
                    <td><div style="height:16px">ส่ง</div><div style="height:16px">สั่ง</div></td>
                    @foreach ($section as $item)
                        @php
                            $qty1="qty1_".strtotime($item["creation_date"]);
                            $qty2="qty2_".strtotime($item["creation_date"]);
                        @endphp
                        <td style="text-align: right;"><div style="height:16px"> {{ ($data->sum($qty1)<>0)?number_format($data->sum($qty1),2):' ' }}</div><div style="height:16px">{{ ($data->sum($qty2)<>0)?number_format($data->sum($qty2),2):' ' }}</div></td>
                    @endforeach
                    @if($count_s==$count_section)
                        <td style="text-align: right;"><div style="height:16px"> {{ ($data->sum('qty1_10')<>0)?number_format($data->sum('qty1_10'),2):' ' }}</div><div style="height:16px">{{ ($data->sum('qty2_10')<>0)?number_format($data->sum('qty2_10'),2):' ' }}</div></td>
                        <td style="text-align: right;"><div style="height:16px"> {{ ($data->sum(' ')<>0)?number_format($data->sum('amt1_10'),2):' ' }}</div><div style="height:16px">{{ ($data->sum('amt2_10')<>0)?number_format($data->sum('amt2_10'),2):' ' }}</div></td>
                        <td style="text-align: right;"><div style="height:16px"> {{ ($data->sum('qty1_20')<>0)?number_format($data->sum('qty1_20'),2):' ' }}</div><div style="height:16px">{{ ($data->sum('qty2_20')<>0)?number_format($data->sum('qty2_20'),2):' ' }}</div></td>
                        <td style="text-align: right;"><div style="height:16px"> {{ ($data->sum(' ')<>0)?number_format($data->sum('amt1_20'),2):' ' }}</div><div style="height:16px">{{ ($data->sum('amt2_20')<>0)?number_format($data->sum('amt2_20'),2):' ' }}</div></td>
                        <td style="text-align: right;"><div style="height:16px"> {{ ($data->sum(' ')<>0)?number_format($data->sum('amt1'),2):' ' }}</div><div style="height:16px">{{ ($data->sum('amt2')<>0)?number_format($data->sum('amt2'),2):' ' }}</div></td>
                    @endif
                </tr>
            </tbody>

        </table>
        @endforeach
        <div class="row" style="padding-top:10px;text-align:center">จบรายงาน</div>

        <div style="text-align:right">
                <div>ผู้จัดทำ _________________________________ หัวหน้าส่วนงาน _________________________________ หัวหน้ากองบริหารขาย _________________________________</div>
        </div>

     </div>
    </body>
</html>

