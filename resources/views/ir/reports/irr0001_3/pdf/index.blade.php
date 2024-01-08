<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode_Output }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ir.reports.irr0001_3._style')
    </head>
    <body>

  @if(count($data) > 0)
    @php $colspan=2; @endphp
    @foreach ($data->groupBy('company_title') as $company_name => $company)
        @php
            $row=$company->first();
            $comp_percent = $row->company_percent;
            $revenu_stamp =  $row->revenue_stamp;
            $tax =  $row->tax;
        @endphp
    @foreach ($company->groupBy('type_title') as $type => $types)
    @foreach ($company->groupBy('department_code') as $department => $departments)
    @php
        $headLeft = array();
        $headLeft[0]  ='<span class="b">ผู้รับประกันภัย</span> : '.$row->company_title ;
        $headLeft[1]  ='<span class="b">เลขที่กรมธรรม์</span> : '.$row->policy_no ;
        $headLeft[2]  ='<span class="b">เลขที่สลักหลัง</span> : '.$row->comments ;
        $headLeft[3]  ='<span class="b">หน่วยงาน</span> : '.$department.' : '.$departments[0]->department_description;
        $headLeft[4]  ='<span class="b">ประเภท</span> : '.$row->type_title;
        $decrease_tax = 0;
        $decrease_duty = 0;
    @endphp
    <div class="page-break">
        <div class="page-break"></div>
        <table class="table">
            <thead>
                <tr>
                    <td colspan="{{ $colspan }}">
                        <div class="row">
                            <div style="width:20%;text-align:left">
                                <span class="b">โปรแกรม</span> : {{ $programCode_Output }}<br>
                                <span class="b">สั่งพิมพ์</span> : {{ optional(auth()->user())->username }}<br>
                                <br>
                            </div>
                            <div style="width:60%;text-align:center; font-size: 28;" class="b">
                                    การยาสูบแห่งประเทศไทย<br>
                                    {{ $progTitle }}
                                    @php
                                        foreach($progPara as $para){
                                            echo "<br>".$para;
                                        }
                                    @endphp
                            </div>
                            <div style="width:20%;text-align:right;">
                                <span class="b">วันที่</span> : {{ parseToDateTh(now()) }}<br>
                                <span class="b">เวลา</span> :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                <span class="b">หน้า</span> : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                            </div>
                        </div>

                        <div class="row">
                            <div style="width:60%;text-align:left">
                                @php
                                    foreach($headLeft as $title){
                                        echo $title ."<br>";
                                    }
                                @endphp
                            </div>
                            {{-- <div style="width:30%;text-align:right;">
                                <br>
                                <br>
                                <br>
                                <div style="position: relative;bottom: 0;right: 0;"><span class="b">หน่วยงาน</span> : {{ $department }} : {{ $departments[0]->department_description }} </span></span></div>
                            </div> --}}
                            
                        </div>
                    </td>
                </tr>
                <tr style="border-top: 0.5px solid #000;border-bottom: 0.5px solid #000;height:30px; background-color: #c4c4c4 ;" class="w900">
                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center" class="b">รายงาน<br></td>
                    <td style="border-right:0.5px solid #000;width:150px;text-align:center;" class="b">ค่าเบี้ยประกันภัย (บาท) {{ $comp_percent }}%</td>
                </tr>
            </thead>
            <tbody>
            @php  
                $i            = 0;  
                $total_insure = 0;
                
                $groupFirst   = $departments->first();
                $subTitle     = $groupFirst ? $groupFirst->group_title : '';
            @endphp
            @foreach ($departments->groupBy('group_title') as $group => $lines)

                @php
                    $i++;
                    $ii=0;
                    $amt_insure = 0;
                    $separate = "";
                    $diff = 0;
                    if($is_separate_company){
                        $separate = "separate";
                        $amt_insure_all = $lines->sum('amt_insure_all');
                        $amt_insure =round($amt_insure_all * $comp_percent/100,2);
                    }else{
                        $amt_insure_all = $lines->sum('amt_insure');
                        $amt_insure = $lines->sum('amt_insure');
                    }  
                       
                @endphp
                <tr>
                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;font-weight:900;text-align:left;padding-left:5px;">{{ $i }}. <b>{{ $lines[0]->group_title }} </b><br></td>
                    <th style="border-right:0.5px solid #000;width:150px;text-align:right"></th>
                </tr>
                @foreach ($lines as $line)
                    @php 
                    $ii++;  

                    if(isset($line->diff)){
                        $diff = $line->diff;
                    }
                    if(isset($line->decrease_tax)){
                        $decrease_tax = $line->decrease_tax;
                        echo $line->item_title;
                    }
                    if(isset($line->decrease_duty)){
                        $decrease_duty = $line->decrease_duty;
                        echo $line->decrease_duty;
                    }
                    @endphp
                <tr>
                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:left;padding-left:25px;">{{ $i }}.{{ $ii }} {{ $line->item_title }}</td>
                    <td style="border-right:0.5px solid #000;text-align: right;">{{ number_format($line->amt_insure,2)  }}</td>
                </tr>
                @endforeach
                <tr style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;">
                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center;padding-right:5px;" class="b">รวม : {{ $subTitle }}</td>
                    <td style="border-right:0.5px solid #000;text-align: right;border-top:0.5px solid #000;border-bottom: 0.5px solid #000; background-color: #f1f0f0;" class="b">{{ number_format($amt_insure + $diff ,2) }}</td>
                </tr>
             @endforeach
                @php
                 $total_insure = $departments->sum('amt_insure');
                 $amt_duty =  $total_insure * round($revenu_stamp,2);
                 $amt_tax = round($tax/100,2) ;
                 if($is_separate_company){
                    $total_insure_all = $array_sum_department[$department] ;
                    $total_insure = round($array_sum_department[$department] * $comp_percent/100,2); 
                    $amt_duty_all = $total_insure_all * round($revenu_stamp,2);
                    $amt_duty =  round(($amt_duty_all * $comp_percent/100) - $decrease_duty,2);
                    $amt_tax_all = round(($total_insure_all  + $amt_duty_all) * round($tax/100,2),2);
                    $amt_tax = round(($amt_tax_all*$comp_percent/100) - $decrease_tax,2);
                  }else{
                    $amt_tax = round(($total_insure  + $amt_duty) * round($tax/100,2),2);
                  }
                
                @endphp
               

                <tr style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;background-color: #dfdfdf;">
                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center;padding-right:5px;" class="b">รวม {{ $type }}</td>
                    <td style="border-right:0.5px solid #000;text-align:right;" class="b">{{ number_format($total_insure,2) }}</td>
                </tr>
                <tr style="" ><td colspan="2" height="40px"></td></tr>
                <tr style="border-bottom: 0.5px solid #000;">
                    <td style="border-top:0px;border-right:0px;border-left:0px;text-align:left;padding-right:5px;" colspan="2"><span class="b"> ประเภท </span> : อาการแสตมป์</td>
                </tr>
                <tr style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;background-color:#c4c4c4;">
                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center;padding-right:5px;">รายการ</td>
                    <td style="border-right:0.5px solid #000;text-align:center;">อากรแสตมป์ (บาท) {{ $comp_percent }}%</td>
                </tr>
                <tr style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;">
                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center;padding-right:5px;">อากรแสตมป์</td>
                    <td style="border-right:0.5px solid #000;text-align:right;">{{ number_format($amt_duty,2) }}</td>
                </tr>
                <tr style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;background-color: #dfdfdf;">
                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center;padding-right:5px;" class="b">รวม : อากรแสตมป์</td>
                    <td style="border-right:0.5px solid #000;text-align:right;" class="b">{{ number_format($amt_duty,2) }}</td>
                </tr>
                <tr style="" ><td colspan="2" height="40px"></td></tr>
                <tr style="border-bottom: 0.5px solid #000;">
                    <td style="border-top:0px;border-right:0px;border-left:0px;text-align:left;padding-right:5px;" colspan="2"><span class="b">ประเภท </span> : ภาษีซื้อไม่ถึงกำหนด</td>
                </tr>
                <tr style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;background-color: #c4c4c4;">
                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center;padding-right:5px;">รายการ </td>
                    <td style="border-right:0.5px solid #000;text-align:center;">ภาษีซื้อไม่ถึงกำหนด (บาท) {{ $comp_percent }}%</td>
                </tr>
                <tr style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;">
                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center;padding-right:5px;">ภาษีซื้อไม่ถึงกำหนด</td>
                    <td style="border-right:0.5px solid #000;text-align:right;"> {{ number_format($amt_tax,2) }}</td>
                </tr>

                <tr style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;background-color: #dfdfdf;">
                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center;padding-right:5px;" class="b">รวม : ภาษีซื้อไม่ถึงกำหนด</td>
                    <td style="border-right:0.5px solid #000;text-align:right;" class="b">{{ number_format($amt_tax,2) }}</td>
                </tr>
                  <tr style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;background-color: #dfdfdf;">
                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center;padding-right:5px;" class="b">รวมทั้งสิน</td>
                    <td style="border-right:0.5px solid #000;text-align:right;" class="b">{{ number_format(($total_insure + $amt_duty + $amt_tax),2) }}</td>
                </tr>
                <tr>
                    <th colspan=2 style="text-align:left;height:30px;"></th>
                </tr>
            </tbody>
        </table>
          @endforeach
         @endforeach
     </div>
    @endforeach
    @else
    @php
     $headLeft[0] = "";
     $colspan=2;
     @endphp
     <div class="page-break">
        <div class="page-break"></div>
        <table class="table">
            <thead>
                <tr>
                    <td colspan="{{ $colspan }}">
                        <div class="row">
                            <div style="width:20%;text-align:left">
                                <span class="b">โปรแกรม</span> : {{ $programCode_Output }}<br>
                                <span class="b">สั่งพิมพ์</span> : {{ optional(auth()->user())->username }}<br>
                                <br>
                            </div>
                            <div style="width:60%;text-align:center; font-size: 28;" class="b">
                                    การยาสูบแห่งประเทศไทย<br>
                                    {{ $progTitle }}
                                    @php
                                        foreach($progPara as $para){
                                            echo "<br>".$para;
                                        }
                                    @endphp
                            </div>
                            <div style="width:20%;text-align:right;">
                                <span class="b">วันที่</span> : {{ parseToDateTh(now()) }}<br>
                                <span class="b">เวลา</span> :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                <span class="b">หน้า</span> : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                            </div>
                        </div>

                        <div class="row">
                            <div style="width:100%;text-align:left">
                                @php
                                    foreach($headLeft as $title){
                                        echo $title ."<br>";
                                    }
                                @endphp
                            </div>
                        </div>
                    </td>
                </tr>
            </thead>
             <tbody>
               <tr style="height:100px;">
                 <td colspan="{{ $colspan }}" style="text-align:center;font-weight:bold;">ไม่มีข้อมูลตามเงื่อนไขที่ท่านเลือก </td>
              </tr>   
             </tbody>
     </table>
    <div>
    @endif
    </body>
</html>
