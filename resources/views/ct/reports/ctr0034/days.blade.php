<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      @include('ct.Reports.ctr0034._style')

 
    </head>
    <body>
    <table >
   
        <thead> 
        @include('ct.Reports.ctr0034.header')
           
        </thead>
        <tbody>
        @php
                $rpt1 = 0;
                $rpt2 = 0;
                $rpt3 = 0;
                $rpt4 = 0;
        @endphp
        @foreach ($headerDatas as $key => $head)
        @php
                $header1 = 0;
                $header2 = 0;
                $header3 = 0;
                $header4 = 0;
        @endphp
        <table> 
           @include('ct.Reports.ctr0034.headerDays')
            @foreach ($datas -> where('batch_no', $head->batch_no) 
                             -> where('transaction_date', $head->transaction_date) 
                      as $da)
            @php
                $a = 0;
                $b = 0;
                $c = 0;
                $d = 0;
            @endphp
                <tr>
                    <th style="border: 1px solid #000000; text-align: left;">{{$da->item_no}}</th>
                    <th style="border: 1px solid #000000; text-align: left;">{{$da->item_desc }}</th>
                    <th style="border: 1px solid #000000; text-align: center;">{{$da->transaction_uom }}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$da->std_qty_used == '0'? number_format(0,2): $da->std_qty_used}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$da->std_cost_rate == '0'? number_format(0,2): $da->std_cost_rate}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$da->iss_std_qty == '0'? number_format(0,2): $da->iss_std_qty}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$da->iss_std_cost == '0'? number_format(0,2): $da->iss_std_cost}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$da->transaction_quantity == '0'? number_format(0,2): $da->transaction_quantity}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$da->transaction_value/($da->transaction_quantity == '0'? number_format(1,2): $da->transaction_quantity) == '0'? 
                                                                              number_format(0,2) : $da->transaction_value/($da->transaction_quantity == '0'? number_format(1,2): $da->transaction_quantity)}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$da->transaction_value == '0'? number_format(0,2): $da->transaction_value}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$da->absorbtion_amount == '0'? number_format(0,2): $da->absorbtion_amount}}</th>
                    @php
                        $a = ($da->iss_std_qty - $da->transaction_quantity) == '0'? number_format(0,2) :($da->iss_std_qty - $da->transaction_quantity);
                        $b = ($da->absorbtion_amount - $da->iss_std_cost ) == '0'? number_format(0,2): ($da->absorbtion_amount - $da->iss_std_cost );
                        $c = ($da->transaction_value - $da->absorbtion_amount ) == '0'? number_format(0,2): ($da->transaction_value - $da->absorbtion_amount);
                        $d = ($da->transaction_value - $da->iss_std_cost ) == '0'? number_format(0,2): ($da->transaction_value - $da->iss_std_cost );
                    @endphp
                    <th style="border: 1px solid #000000; text-align: right;">{{$a < 0 ? '(' . number_format($a*-1,6) . ')' :$a}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$b < 0 ? '(' . number_format($b*-1,2) . ')' :$b}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$c < 0 ? '(' . number_format($c*-1,2) . ')' :$c}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$d < 0 ? '(' . number_format($d*-1,2) . ')' :$d}}</th>
                    
                </tr>
            @endforeach 
           
                <tr>
                    <th style="border: 1px solid #000000; text-align: left;"colspan=3><b>รวม {{$TypeProd}}</b></th>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$head->std_qty_used}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$head->std_cost_rate}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$head->iss_std_qty}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$head->iss_std_cost}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$head->transaction_quantity}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$head->value_quantity }}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$head->transaction_value}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$head->absorbtion_amount  == '0'? number_format(0,2): $head->absorbtion_amount }}</b></td>
                    @php
                            $header1 = ($head->iss_std_qty - $head->transaction_quantity ) == '0'? number_format(0,2): ($head->iss_std_qty - $head->transaction_quantity);
                            $header2 = ($head->absorbtion_amount - $head->iss_std_cost ) == '0'? number_format(0,2): ($head->absorbtion_amount - $head->iss_std_cost );
                            $header3 = ($head->transaction_value - $head->absorbtion_amount ) == '0'? number_format(0,2): ($head->transaction_value - $head->absorbtion_amount);
                            $header4 = ($head->transaction_value - $head->iss_std_cost ) == '0'? number_format(0,2): ($head->transaction_value - $head->iss_std_cost );
                    @endphp
                    <th style="border: 1px solid #000000; text-align: right;">{{$header1 < 0 ? '(' . number_format($header1*-1,6) . ')' :$header1}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$header2 < 0 ? '(' . number_format($header2*-1,2) . ')' :$header2}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$header3 < 0 ? '(' . number_format($header3*-1,2) . ')' :$header3}}</th>
                    <th style="border: 1px solid #000000; text-align: right;">{{$header4 < 0 ? '(' . number_format($header4*-1,2) . ')' :$header4}}</th>
                </tr>  
                @if($loop->last) 
                    @foreach ($sumRpt as $rpt)
                    <tr>
                            <td style=" border: 1px solid #000000;text-align: left; " colspan = 3><b>รวมทั้งสิ้น</b></td>
                            <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->std_qty_used}}</b></td>
                            <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->std_cost_rate}}</b></td>
                            <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->iss_std_qty}}</b></td>
                            <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->iss_std_cost}}</b></td>
                            <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->transaction_quantity}}</b></td>
                            <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->value_quantity }}</b></td>
                            <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->transaction_value}}</b></td>
                            <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$head->absorbtion_amount  == '0'? number_format(0,2): $head->absorbtion_amount }}</b></td>
                            @php
                                    $rpt1 = ($rpt->iss_std_qty - $rpt->transaction_quantity ) == '0'? number_format(0,2): ($rpt->iss_std_qty - $rpt->transaction_quantity);
                                    $rpt2 = ($rpt->absorbtion_amount - $rpt->iss_std_cost ) == '0'? number_format(0,2): ($rpt->absorbtion_amount - $rpt->iss_std_cost );
                                    $rpt3 = ($rpt->transaction_value - $rpt->absorbtion_amount ) == '0'? number_format(0,2): ($rpt->transaction_value - $rpt->absorbtion_amount);
                                    $rpt4 = ($rpt->transaction_value - $rpt->iss_std_cost ) == '0'? number_format(0,2): ($rpt->transaction_value - $rpt->iss_std_cost );
                            @endphp
                            <th style="border: 1px solid #000000; text-align: right;">{{$rpt1 < 0 ? '(' . number_format($rpt1*-1,6) . ')' :$rpt1}}</th>
                            <th style="border: 1px solid #000000; text-align: right;">{{$rpt2 < 0 ? '(' . number_format($rpt2*-1,2) . ')' :$rpt2}}</th>
                            <th style="border: 1px solid #000000; text-align: right;">{{$rpt3 < 0 ? '(' . number_format($rpt3*-1,2) . ')' :$rpt3}}</th>
                            <th style="border: 1px solid #000000; text-align: right;">{{$rpt4 < 0 ? '(' . number_format($rpt4*-1,2) . ')' :$rpt4}}</th>
                    @endforeach
                @endif
        </table> 
        @endforeach 
        </tbody>


  

    </table>
       
    </body>
</html>