<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    </head>

    <body>
    @include('ct.Reports.TTCTRP72.header')
    
        <table>
            <thead>
                <tr >
                    <th style="border: 1px solid #000000; text-align: center; width: 200px; " rowspan=2 > <b>รหัส </b></th>
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
                    @foreach ($QueryLevelOrg as $key => $org)
                        @foreach ($QueryLevelMachine->where('organization_code', $org['organization_code'])
                                 as $Machine)
                            <tr> 
                                <td style="border-left: 1px solid #000000;text-align: center;"><b>{{$Machine->machine_line}}</b></td> 
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;text-align: center;"></td>
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;text-align: center;"></td>
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;border-right: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-right: 1px solid #000000;" ></td>
                            </tr>  
                            <tr> 
                                <td style="border-left: 1px solid #000000;text-align: center;"><b>{{$org['type_product_th']}} ฤดู {{$Machine->crop_year}}</b></td>
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;text-align: center;"></td>
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;text-align: center;"></td>
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;border-right: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-right: 1px solid #000000;" ></td>  </tr>   
                            @foreach ($QueryLevelProductType->where('organization_code', $org['organization_code'])
                                                                ->where('machine_line', $Machine['machine_line'])
                                                                as $ProductType)
                            <tr>
                                <td style="border-left: 1px solid #000000;text-align: center;"><b></b></td>
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-left: 1px solid #000000;text-align: center;"></td>
                                <td style="border-left: 1px solid #000000;text-align: right;"><b>@</b><b>{{number_format($ProductType->sum_wagecost_producttype/$ProductType->sum_qty_producttype,9)}}</b></td> 
                                <td style="border-left: 1px solid #000000;text-align: right;"><b>@</b><b>{{number_format($ProductType->sum_varycost_producttype/$ProductType->sum_qty_producttype,9)}}</b></td>
                                <td style="border-left: 1px solid #000000;text-align: right;"><b>@</b><b>{{number_format($ProductType->sum_fixedcost_producttype/$ProductType->sum_qty_producttype,9)}}</b></td> 
                                <td style="border-left: 1px solid #000000;border-right: 1px solid #000000;text-align: center;"></td> 
                                <td style="border-right: 1px solid #000000;" ></td>  
                            </tr>   
                                @foreach ($QueryLevelItemHead->where('organization_code', $org['organization_code'])
                                                                ->where('machine_line', $Machine['machine_line'])
                                                                ->where('product_type', $ProductType['product_type'])
                                                                as $H)
                                <tr>
                                    <td style="border-left: 1px solid #000000; text-align: left;">{{$H->product_code}}</td>
                                    <td style="border-left: 1px solid #000000; text-align: center;">{{$H->product_name}}</td>
                                    <td style="border: 1px solid #000000; text-align: right;">{{$H->sum_qty_item}}</td>
                                    <td style="border: 1px solid #000000; text-align: right;">{{$H->sum_qty_use_item}}</td>
                                    <td style="border: 1px solid #000000; text-align: right;">{{$H->sum_cost_rawmate_item}}</td>
                                    <td style="border: 1px solid #000000; text-align: right;">{{$H->sum_wagecost_item}}</td>
                                    <td style="border: 1px solid #000000; text-align: right;">{{$H->sum_varycost_item}}</td>
                                    <td style="border: 1px solid #000000; text-align: right;">{{$H->sum_fixedcost_item}}</td>
                                    <td style="border: 1px solid #000000; text-align: right;">{{$H->sum_totalcost_item}}</td>
                                    <td style="border: 1px solid #000000; text-align: right;">{{$H->sum_costunit_item}}</td>
                                </tr>
                                   

                                @endforeach
                             <tr>
                                <td style="border: 1px solid #000000; text-align: left;"><b>{{$ProductType->product_type == 'LEAF'? 'รวมเนื้อยา' : 'รวมก้าน' }}</b></td>
                                <td style="border: 1px solid #000000; text-align: right;"><b></b></td>
                                <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductType->sum_qty_producttype}}</b></td>
                                <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductType->sum_qty_use_producttype}}</b></td>
                                <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductType->sum_cost_rawmate_producttype}}</b></td>
                                <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductType->sum_wagecost_producttype}}</b></td>
                                <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductType->sum_varycost_producttype}}</b></td>
                                <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductType->sum_fixedcost_producttype}}</b></td>
                                <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductType->sum_totalcost_producttype}}</b></td>
                                <td style="border: 1px solid #000000; text-align: right;"><b></b></td>
                            </tr>

                            @if($loop->last) 
                                <tr>
                                    <td style="border: 1px solid #000000; text-align: center;"><b>รวม{{$org['type_product_th']}} {{$org['organization_code'] == 'DN1'? '(เนื้อยา+ก้าน)' : '(เนื้อยา)' }}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_qty_machine}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_qty_use_machine}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_cost_rawmate_machine}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_wagecost_machine}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_varycost_machine}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_fixedcost_machine}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_totalcost_machine}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b></b></td>
                                </tr> 
                                @foreach ($QueryLevelProductType->where('organization_code', $org['organization_code'])
                                                                ->where('machine_line', $Machine['machine_line'])
                                                                as $ProductTypeSpe)
                                <tr>
                                    <td style="border: 1px solid #000000; text-align: left;"><b>{{$ProductTypeSpe->product_type == 'LEAF'? 'รวมเนื้อยา' : 'รวมก้าน' }} - {{$org['type_product_th']}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductTypeSpe->sum_qty_producttype}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductTypeSpe->sum_qty_use_producttype}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductTypeSpe->sum_cost_rawmate_producttype}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductTypeSpe->sum_wagecost_producttype}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductTypeSpe->sum_varycost_producttype}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductTypeSpe->sum_fixedcost_producttype}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductTypeSpe->sum_totalcost_producttype}}</b></td>
                                    <td style="border: 1px solid #000000; text-align: right;"><b>{{$ProductTypeSpe->sum_costunit_producttype}}</b></td>
                                </tr>
                                @endforeach
                            @endif
                            @endforeach
                          
                           
                        <tr>
                            <td style="border: 1px solid #000000; text-align: center;"><b>รวม{{$Machine->machine_line}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_qty_machine}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_qty_use_machine}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_cost_rawmate_machine}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_wagecost_machine}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_varycost_machine }}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_fixedcost_machine}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"><b>{{$Machine->sum_totalcost_machine}}</b></td>
                            <td style="border: 1px solid #000000; text-align: right;"></td>
                        </tr>
                        @endforeach
                
                    @foreach ($QueryLevelOrgLeaf->where('organization_code', $org['organization_code'])
                                 as $orgLeaf)
                    <tr>
                        <td style="border: 1px solid #000000; text-align: left;"><b>{{$orgLeaf->product_type == 'LEAF'? 'รวมเนื้อยา' : 'รวมก้าน' }} - {{$org['type_product_th']}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$orgLeaf->sum_qty_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$orgLeaf->sum_qty_use_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$orgLeaf->sum_cost_rawmate_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$orgLeaf->sum_wagecost_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$orgLeaf->sum_varycost_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$orgLeaf->sum_fixedcost_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$orgLeaf->sum_totalcost_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$orgLeaf->sum_costunit_org}}</b></td>
                    </tr>

                    @endforeach
                    <tr>
                        <td style="border: 1px solid #000000; text-align: center;"><b>{{$org->machine_name}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$org->sum_qty_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$org->sum_qty_use_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$org->sum_cost_rawmate_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$org->sum_wagecost_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$org->sum_varycost_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$org->sum_fixedcost_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$org->sum_totalcost_org}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"></td>
                    </tr>
                    @endforeach

                    @foreach ($QueryLevelRptByType as $sumRptType)
                    <tr>
                        <td style="border: 1px solid #000000; text-align: left;"><b>{{$sumRptType->product_type == 'LEAF'? 'รวมเนื้อยา' : 'รวมก้าน' }} - {{$sumRptType->type_product_th}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRptType->sum_qty_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRptType->sum_qty_use_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRptType->sum_cost_rawmate_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRptType->sum_wagecost_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRptType->sum_varycost_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRptType->sum_fixedcost_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRptType->sum_totalcost_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRptType->sum_costunit_rpt}}</b></td>

                    </tr>
                    @endforeach
                    @foreach ($QueryLevelRpt as $sumRpt)
                    <tr>
                        <td style="border: 1px solid #000000; text-align: center;"><b>รวมทั้งสิ้นทุกโรงผลิต</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRpt->sum_qty_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRpt->sum_qty_use_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRpt->sum_cost_rawmate_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRpt->sum_wagecost_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRpt->sum_varycost_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRpt->sum_fixedcost_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRpt->sum_totalcost_rpt}}</b></td>
                        <td style="border: 1px solid #000000; text-align: right;"><b>{{$sumRpt->sum_costunit_rpt}}</b></td>

                    </tr>
                    @endforeach

            </tbody>
        </table>
    </body>
</html>