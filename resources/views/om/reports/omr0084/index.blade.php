<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

<title>OMR0084 การบันทึกเจ้าหนี้ค่าบุหรี่ สโมสร (เงินสด)</title>
@include('ct.reports.ctr0101._style')

    </head>
    <body>
        <style>
      


            table, tr, td, th, tbody, thead, tfoot {
                page-break-inside: avoid !important;
            }
        
       
        
        </style>
        @php 
        $count = 1;
        @endphp
        <!-- style="page-break-after:always; " -->
        <table  width="100%"  >
            <thead >
                    <tr>
                        <th></th>
                    </tr>
                    <tr style ="border-top: .5px solid; border-bottom: 0.5px solid;">
                    <th width="5%"  style="text-align: center; vertical-align: middle;">รหัสสินค้า</th>
                    <th  style="text-align: center; vertical-align: middle;">ชื่อร้านค้า</th>
                    <th  style="text-align: center; vertical-align: middle;">ดุลลูกหนี้เงินสด<br>ยกมา</th>
                    <th  style="text-align: center; vertical-align: middle;">ดุลเจ้าหนี้เงินสด<br>ยกมา</th>
                    <th  style="text-align: center; vertical-align: middle;">วันที่</th>
                    <th  style="text-align: center; vertical-align: middle;">เลขที่</th>
                    <th  style="text-align: center; vertical-align: middle;">ชนิด</th>
                    <th  style="text-align: center; vertical-align: middle;">จำนวนเงินสด</th>
                    <th  style="text-align: center; vertical-align: middle;">ดุลลูกหนี้เงินสด<br>ยกไป</th>
                    <th  style="text-align: center; vertical-align: middle;">ดุลเจ้าหนี้เงินสด<br>ยกไป</th>

                </tr>
            </thead>
            <tbody>
                @php
                    $cntLine =0;
                    $sumOutStand =0;
                    $SUMDeptA   =0;
                    $SumCreA     =0;
                @endphp
                @foreach($dataLists as $dataListH)
                @php
                    $outstanding= $DebtDomV->where('customer_number', $dataListH->customer_number)->first();
                    if(!!$outstanding){
                        if($outstanding['outstanding_debt']>0){
                            $DebtDomVs=$outstanding;
                        }elseif($outstanding['outstanding_debt']<0){
                            $credit=$outstanding;
                        }else{
                            $DebtDomVs['outstanding_debt'] =0;
                            $credit['outstanding_debt'] =0;
                        }
                    }else{
                        $DebtDomVs['outstanding_debt'] =0;
                        $credit['outstanding_debt'] =0;

                    }
                    //$DebtDomVs = $DebtDomV->where('customer_number', $dataListH->customer_number)->first(); 
                    //dd($DebtDomVs);
                    $cntLine =0;
                    $SUMDept =0;
                    $SUMCre =0;
                    if(isset($DebtDomVs['outstanding_debt'])){
                        $sumOutStand += $DebtDomVs['outstanding_debt'];
                    }  
                @endphp

           
                    @foreach($dataListLs->where('customer_number',$dataListH->customer_number)  as $dataListL)
                        @php
                            $cntLine +=1;  
                            $count = count($dataListLs->where('customer_number',$dataListH->customer_number));
                            if($dataListL->type_num=='2'or $dataListL->type_num=='4'){
                                $SUMDept+=$dataListL->amount;
                                $SUMCre-=$dataListL->amount;
                            }else{
                                $SUMDept-=$dataListL->amount;
                                $SUMCre+=$dataListL->amount;
                            }
                        $lineCustomerNumber=    $dataListH['customer_number'] ;    
                        @endphp

                    <tr>
                    @if ($cntLine == 1)
                    <td rowspan={{$count}} 
                        style=" text-align: center ;  vertical-align: text-top;">
                        {{ $dataListH['customer_number'] }} 
                    </td>
                    <td rowspan={{$count}} 
                        style=" text-align: LEFT ;  vertical-align: text-top;">
                        {{ $dataListH['customer_name'] }} 
                    </td>
                    <td rowspan={{$count}} 
                        style=" text-align: center ;  vertical-align: text-top;">

                    </td>                   
                    @endif
                      
                        <td style="text-align: right; vertical-align: middle;"></td>
                        <td style="text-align: right; vertical-align: middle;">{{parseTODateTH($dataListL['para_date'])}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{$dataListL->inumber}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{$dataListL->type}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{$dataListL->type=="ใบกำกับสินค้า"?"(".number_format($dataListL->amount,2,".",",").")":number_format($dataListL->amount,2,".",",")}}</td>
                        <td style="text-align: right; vertical-align: middle;"></td>
                        <td style="text-align: right; vertical-align: middle;"></td>
                      
                
                    </tr>

                    @endforeach
                    @php
                     $SUMDept +=(isset($DebtDomVs['outstanding_debt']) ? $DebtDomVs['outstanding_debt'] :0)-(isset($credit['outstanding_debt']) ? $credit['outstanding_debt'] :0);
                     $SUMCre  -=isset($DebtDomVs['outstanding_debt']) ? $DebtDomVs['outstanding_debt'] :0+(isset($credit['outstanding_debt']) ? $credit['outstanding_debt'] :0);
                     if($SUMDept<0){
                        $SUMDept =0;    
                     }
                    if($SUMCre<0){
                        $SUMCre=0;
                    }

                    $SUMDeptA    +=$SUMDept;
                    $SumCreA     +=$SUMCre;

                        @endphp
                        @if (@$lineCustomerNumber!=$dataListH->customer_number)
                        <tr>
                        <td rowspan={{$count}} 
                        style=" text-align: center ;  vertical-align: text-top;">
                        {{ $dataListH->customer_number }} 
                    </td>
                    <td rowspan={{$count}} 
                        style=" text-align: LEFT ;  vertical-align: text-top;">
                        {{ $dataListH->customer_name }} 
                    </td>
                    <td rowspan={{$count}} 
                        style=" text-align: center ;  vertical-align: text-top;">

                    </td>    
                    <td style="text-align: right; vertical-align: middle;"></td>
                    <td style="text-align: right; vertical-align: middle;"></td>
                    <td style="text-align: right; vertical-align: middle;"></td>
                    <td style="text-align: right; vertical-align: middle;"></td>
                    <td style="text-align: right; vertical-align: middle;"></td>
                    <td style="text-align: right; vertical-align: middle;"></td>
                    <td style="text-align: right; vertical-align: middle;"></td>

                        </tr>
                        @endif

                    <tr>

                    
                        <td style="text-align: center; vertical-align: middle;"></td>
                        <td style="text-align: right; margin-left: 2 px;vertical-align: middle;">{{isset($outstanding['approve_date']) ? (isset($outstanding['outstanding_debt']) ? $outstanding['outstanding_debt'] : 'xx')==0?'':parseTODateTH($outstanding['approve_date'] ): ''}}</td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;">{{isset($DebtDomVs['outstanding_debt']) ? number_format($DebtDomVs['outstanding_debt'],2,".",",") : number_format(0,2,".",",")}}</td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;">{{isset($credit['outstanding_debt']) ? number_format($credit['outstanding_debt'],2,".",",") : number_format(0,2,".",",")}}</td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: center; vertical-align: middle;"></td>

                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;"></td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;"></td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;"></td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;">{{number_format($SUMDept,2,".",",")}}</td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;">{{number_format($SUMCre,2,".",",")}}</td>
                
                    </tr>
                @endforeach
                <tr >
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: center; vertical-align: middle;"></td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;"></td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;">{{number_format($sumOutStand,2,".",",")}}</td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;">0.00</td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: center; vertical-align: middle;"></td>

                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;"></td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;"></td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;"></td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;">{{number_format($SUMDeptA,2,".",",")}}</td>
                        <td style="border-top: 0.5px solid; border-bottom: 0.5px solid;text-align: right; vertical-align: middle;">{{number_format($SumCreA,2,".",",")}}</td>
                
                    </tr>
                
                <tr>
                    <td colspan="10" style="text-align: LEFT; vertical-align: middle;">             {{$TEXT}}</td>
                </tr>
              
            </tbody>
        
        </table>
        <table width="100%">
                <tr >
                    <td width="50%"style="text-align: left; vertical-align: middle;"> </td>
                    <td width="20%"style="text-align: left; vertical-align: middle;"> ใบกำกับสินค้า</td>
                    <td style="text-align: RIGHT; vertical-align: middle;"> {{number_format(0,2,".",",")}}</td>
                    <td width="20%" ></td>
                </tr>
                <tr>
                    <td width="50%" style="text-align: center; vertical-align: middle;"> </td>
                    <td style="text-align: left; vertical-align: middle;"> ยอดขายสโมสร</td>
                    <td style="text-align: RIGHT; vertical-align: middle;"> {{number_format($debt,2,".",",")}}</td>

                </tr>
                <tr>
                    <td width="50%" style="text-align: center; vertical-align: middle;"> </td>
                    <td style="text-align: left; vertical-align: middle;"> ใบลดหนี้</td>
                    <td style="text-align: RIGHT; vertical-align: middle;"> {{number_format($cre,2,".",",")}}</td>
                </tr>
                <tr>
                    <td width="50%" style="text-align: center; vertical-align: middle;"> </td>
                    <td style="text-align: left; vertical-align: middle;"> ใบเสร็จรับเงิน</td>
                    <td style="text-align: RIGHT; vertical-align: middle;"> {{number_format($payment,2,".",",")}}</td>
                </tr>
                <tr>
                    <td width="50%" style="text-align: center; vertical-align: middle;"> </td>
                    <td style="text-align: left; vertical-align: middle;"> ใบเพิ่มหนี้</td>
                    <td style="text-align: RIGHT; vertical-align: middle;"> {{number_format($debit,2,".",",")}}</td>
                </tr> 
        </table>
       
    </body>
</html>

