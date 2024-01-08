<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    </head>

    <body>
    @foreach ($TypeLeaf as $key => $tl)
    @include('ct.Reports.TTCTRP85.header')
    <p><B>ประเภทใบยา</B> : {{$key}}</p>
    <p><B>ศูนย์ต้นทุน</B> : {{$tl[0]->cost_center}}</p>
       
            <table>
                <thead>
                    <tr >
                        <th style="border: 1px solid #000000; text-align: center; width: 230px; " rowspan=2 > <b>ผลิตภัณฑ์ </b></th>
                        <th style="border: 1px solid #000000; text-align: center; width: 50px;" rowspan=2 > <b>เกรด </b></th>
                        <th style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=2 > <b>ปริมาณที่<BR>ผลิตได้ (ก.ก)</b></th>
                        <th style="border: 1px solid #000000; text-align: center; width: 180px;" rowspan=2 > <b>วัตถุดิบที่ใช้ตามมาตราฐาน </b></th>
                        <th style="border: 1px solid #000000; text-align: center; " colspan=6> <b>ต้นทุนผลิต - มาตรฐาน (บาท)</b></th>
                    </tr>
                    <tr >
                        <th style="border: 1px solid #000000; text-align: center; width: 170px;"> <b>ค่าวัตถุดิบ </b></th>
                        <th style="border: 1px solid #000000; text-align: center; width: 170px;"> <b>ค่าแรงงาน </b></th>
                        <th style="border: 1px solid #000000; text-align: center; width: 170px;"> <b>ค่าใช้จ่ายการผลิตผันแปร </b></th>
                        <th style="border: 1px solid #000000; text-align: center; width: 170px;"> <b>ค่าใช้จ่ายการผลิตคงที่ </b></th>
                        <th style="border: 1px solid #000000; text-align: center; width: 170px;"> <b>รวมต้นทุนผลิต </b></th>
                        <th style="border: 1px solid #000000; text-align: center; width: 170px;"> <b>ราคาต่อหน่วย </b></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($ProductType->where('type_product_th', $key)
                                      ->where('cost_center', $tl[0]->cost_center)
                                        as $PDT)

                        @foreach ($Lines->where('type_product_th', $key)
                                        ->where('cost_center', $tl[0]->cost_center)
                                        ->where('product_type', $PDT->product_type)
                                        as $L)
                           
                            <tr>
                                <td style="border-left: 1px solid #000000; text-align: right;">{{$L->product_code}}</td>
                                <td style="border-left: 1px solid #000000; text-align: right;">{{$L->product_name}}</td>
                                <td style="border-left: 1px solid #000000; text-align: right;">{{$L->sum_primary_quantity_line == '0'? number_format(0, 2): number_format($L->sum_primary_quantity_line,2)}}</td>
                                <td style="border-left: 1px solid #000000; text-align: right;">{{$L->sum_quantity_used_line == '0'? number_format(0, 6): number_format($L->sum_quantity_used_line,6)}}</td>
                                <td style="border-left: 1px solid #000000; text-align: right;">{{$L->sum_cost_raw_mate_line == '0'? number_format(0, 2): number_format($L->sum_cost_raw_mate_line,2)}}</td>
                                <td style="border-left: 1px solid #000000; text-align: right;">{{$L->sum_wage_cost_line == '0'? number_format(0, 2): number_format($L->sum_wage_cost_line,2)}}</td>
                                <td style="border-left: 1px solid #000000; text-align: right;">{{$L->sum_vary_cost_line == '0'? number_format(0, 2): number_format($L->sum_vary_cost_line,2)}}</td>
                                <td style="border-left: 1px solid #000000; text-align: right;">{{$L->sum_fixed_cost_line == '0'? number_format(0, 2): number_format($L->sum_fixed_cost_line,2)}}</td>
                                <td style="border-left: 1px solid #000000; text-align: right;">{{$L->sum_total_cost_line == '0'? number_format(0, 2): number_format($L->sum_total_cost_line,2)}}</td>
                                <td style="border-right: 1px solid #000000;border-left: 1px solid #000000; text-align: right;">{{$L->sum_total_cost_per_unit_line == '0'? number_format(0, 9): number_format($L->sum_total_cost_per_unit_line,9)}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style="border: 1px solid #000000; text-align: left;"><b>{{$PDT->product_type == 'LEAF'? 'รวมเนื้อยา' : 'รวมก้าน' }}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$PDT->sum_primary_quantity_type == '0'? number_format(0, 2): number_format($PDT->sum_primary_quantity_type,2)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$PDT->sum_quantity_used_type == '0'? number_format(0, 6): number_format($PDT->sum_quantity_used_type,6)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$PDT->sum_cost_raw_mate_type == '0'? number_format(0, 2): number_format($PDT->sum_cost_raw_mate_type,2)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$PDT->sum_wage_cost_type == '0'? number_format(0, 2): number_format($PDT->sum_wage_cost_type,2)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$PDT->sum_vary_cost_type == '0'? number_format(0, 2): number_format($PDT->sum_vary_cost_type,2)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$PDT->sum_fixed_cost_type == '0'? number_format(0, 2): number_format($PDT->sum_fixed_cost_type,2)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$PDT->sum_total_cost_type == '0'? number_format(0, 2): number_format($PDT->sum_total_cost_type,2)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"></td>
                        </tr> 
                @endforeach
                <tr>
                    <td style="border: 1px solid #000000; border-bottom: 1px double #000000; text-align: left;"><b>รวมตามประเภทใบยา {{$key}} </b></td>
                    <td style="border: 1px solid #000000; border-bottom: 1px double #000000; text-align: right;"></td>
                    <td style="border: 1px solid #000000; border-bottom: 1px double #000000; text-align: right;"><b>{{$tl[0]->sum_primary_quantity_tl == '0'? number_format(0, 2): number_format($tl[0]->sum_primary_quantity_tl,2)}}</b></td>
                    <td style="border: 1px solid #000000; border-bottom: 1px double #000000; text-align: right;"><b>{{$tl[0]->sum_quantity_used_tl == '0'? number_format(0, 6): number_format($tl[0]->sum_quantity_used_tl,6)}}</b></td>
                    <td style="border: 1px solid #000000; border-bottom: 1px double #000000; text-align: right;"><b>{{$tl[0]->sum_cost_raw_mate_tl == '0'? number_format(0, 2): number_format($tl[0]->sum_cost_raw_mate_tl,2)}}</b></td>
                    <td style="border: 1px solid #000000; border-bottom: 1px double #000000; text-align: right;"><b>{{$tl[0]->sum_wage_cost_tl == '0'? number_format(0, 2): number_format($tl[0]->sum_wage_cost_tl,2)}}</b></td>
                    <td style="border: 1px solid #000000; border-bottom: 1px double #000000; text-align: right;"><b>{{$tl[0]->sum_vary_cost_tl == '0'? number_format(0, 2): number_format($tl[0]->sum_vary_cost_tl,2)}}</b></td>
                    <td style="border: 1px solid #000000; border-bottom: 1px double #000000; text-align: right;"><b>{{$tl[0]->sum_fixed_cost_tl == '0'? number_format(0, 2): number_format($tl[0]->sum_fixed_cost_tl,2)}}</b></td>
                    <td style="border: 1px solid #000000; border-bottom: 1px double #000000; text-align: right;"><b>{{$tl[0]->sum_total_cost_tl == '0'? number_format(0, 2): number_format($tl[0]->sum_total_cost_tl,2)}}</b></td>
                    <td style="border: 1px solid #000000; border-bottom: 1px double #000000; text-align: right;"></td>
                </tr>    
                @if($loop->last) 
                    @foreach ($SumFooter as $FT)
                        <tr>
                            <td style="border: 1px solid #000000; text-align: left;"><b>{{$FT->product_type == 'LEAF'? 'รวมเนื้อยา' : 'รวมก้าน' }} - {{$FT->type_product_th}}</b></td>
                            <td style="border: 1px solid #000000; text-align: left;"></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$FT->sum_primary_quantity_ft == '0'? number_format(0, 2): number_format($FT->sum_primary_quantity_ft,2)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$FT->sum_quantity_used_ft == '0'? number_format(0, 6): number_format($FT->sum_quantity_used_ft,6)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$FT->sum_cost_raw_mate_ft == '0'? number_format(0, 2): number_format($FT->sum_cost_raw_mate_ft,2)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$FT->sum_wage_cost_ft == '0'? number_format(0, 2): number_format($FT->sum_wage_cost_ft,2)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$FT->sum_vary_cost_ft == '0'? number_format(0, 2): number_format($FT->sum_vary_cost_ft,2)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$FT->sum_fixed_cost_ft == '0'? number_format(0, 2): number_format($FT->sum_fixed_cost_ft,2)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$FT->sum_total_cost_ft == '0'? number_format(0, 2): number_format($FT->sum_total_cost_ft,2)}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"></td>
                        </tr>
                    @endforeach
                    @foreach ($SumRpt as $RPT)
                        <tr>
                            <td style="border: 1px solid #000000;  border-bottom: 1px double #000000; text-align: left;"><b>รวมทั้งสิ้น</b></td>
                            <td style="border: 1px solid #000000;  border-bottom: 1px double #000000; text-align: left;"></td>
                            <td style="border: 1px solid #000000;  border-bottom: 1px double #000000; text-align: right;"><b>{{$RPT->sum_qty_rpt == '0'? number_format(0, 2): number_format($RPT->sum_qty_rpt,2)}}</b></td>
                            <td style="border: 1px solid #000000;  border-bottom: 1px double #000000; text-align: right;"><b>{{$RPT->sum_qty_use_rpt == '0'? number_format(0, 6): number_format($RPT->sum_qty_use_rpt,6)}}</b></td>
                            <td style="border: 1px solid #000000;  border-bottom: 1px double #000000; text-align: right;"><b>{{$RPT->sum_cost_rawmate_rpt == '0'? number_format(0, 2): number_format($RPT->sum_cost_rawmate_rpt,2)}}</b></td>
                            <td style="border: 1px solid #000000;  border-bottom: 1px double #000000; text-align: right;"><b>{{$RPT->sum_wagecost_rpt == '0'? number_format(0, 2): number_format($RPT->sum_wagecost_rpt,2)}}</b></td>
                            <td style="border: 1px solid #000000;  border-bottom: 1px double #000000; text-align: right;"><b>{{$RPT->sum_varycost_rpt == '0'? number_format(0, 2): number_format($RPT->sum_varycost_rpt,2)}}</b></td>
                            <td style="border: 1px solid #000000;  border-bottom: 1px double #000000; text-align: right;"><b>{{$RPT->sum_fixedcost_rpt == '0'? number_format(0, 2): number_format($RPT->sum_fixedcost_rpt,2)}}</b></td>
                            <td style="border: 1px solid #000000;  border-bottom: 1px double #000000; text-align: right;"><b>{{$RPT->sum_totalcost_rpt == '0'? number_format(0, 2): number_format($RPT->sum_totalcost_rpt,2)}}</b></td>
                            <td style="border: 1px solid #000000;  border-bottom: 1px double #000000; text-align: right;"></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>

    @endforeach
    
</body>