<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ct.reports.ctr0101._style')
    </head>

    <body>
    @include('om.reports.omr0065.excel._header')
    <table>
        

            @php
                $contHeader =0;
            @endphp

            @foreach($data as $dataListH=>$dataListHs )
            @php
                //dd($dataListHs->uom_class,$dataListH); 
                if($dataListHs->uom_class=="บุหรี่"){
                    $uom = $cigarette;
                }
                elseif($dataListHs->uom_class=='ทั่วไป'){
                    $uom = $tobacco;
                }elseif($dataListHs->uom_class=='น้ำหนัก'){
                    $uom = $medicinal;
                }
               // dd($dataListHs->uom_class,$cigarette,$tobacco,$medicinal,$dataListHs->uom_class=="บุหรี่"?$cigarette:$dataListHs->uom_class=='ทั่วไป'?$tobacco:$dataListHs->uom_class=='น้ำหนัก'?$medicinal:'');
                $sum01	=0;
                $sum02	=0;
                $sum03	=0;
                $sum04	=0;
                $sum05	=0;
                $sum06	=0;
                $sum07	=0;
                $sum08	=0;
                $sum09	=0;
                $sum10	=0;
                $sum11	=0;
                $sum12	=0;
                $sumM   =0;


            @endphp
            <thead>
                <tr>
                    <th colspan="13"></th>
                    <th >หน่วย : {{$uom}}</th>
                </tr>
            <tr  >
                <th colspan="1"style="border-top: 1px solid #000000;text-align: center; vertical-align: middle;"></th>
                <th colspan="13"style="border-top: 1px solid #000000;text-align: center; vertical-align: middle;">เดือน</th>
            </tr>
            <tr>
                <th style="border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">สินค้า</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">ตุลาคม</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">พฤศจิกายน</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">ธันวาคม</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">มกราคม</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">กุมภาพันธ์</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">มีนาคม</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">เมษายน</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">พฤษภาคม</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">มิถุนายน</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">กรกฏาคม</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">สิงหาคม</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">กันยายน</th>
                <th style=" border-bottom: 1px solid #000000;text-align: left; vertical-align: middle;">รวม</th>


            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>{{$dataListHs->description}}</b></td>
            </tr>
                @foreach($dataL->where('description',$dataListHs->description) as $dataListL)
            @php
                //dd($dataListL->m10);
                $sum01	+=isset($dataListL->m01)?$dataListL->m01:0;
                $sum02	+=isset($dataListL->m02)?$dataListL->m02:0;
                $sum03	+=isset($dataListL->m03)?$dataListL->m03:0;
                $sum04	+=isset($dataListL->m04)?$dataListL->m04:0;
                $sum05	+=isset($dataListL->m05)?$dataListL->m05:0;
                $sum06	+=isset($dataListL->m06)?$dataListL->m06:0;
                $sum07	+=isset($dataListL->m07)?$dataListL->m07:0;
                $sum08	+=isset($dataListL->m08)?$dataListL->m08:0;
                $sum09	+=isset($dataListL->m09)?$dataListL->m09:0;
                $sum10	+=isset($dataListL->m10)?$dataListL->m10:0;
                $sum11	+=isset($dataListL->m11)?$dataListL->m11:0;
                $sum12	+=isset($dataListL->m12)?$dataListL->m12:0;
                $sumM   +=isset($dataListL->sum)?$dataListL->sum:0;              
            @endphp
                    <tr>
                        <td style="text-align: left; vertical-align: middle;">{{$dataListL->ecom_item_description}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->m10)?$dataListL->m10:''}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->m11)?$dataListL->m11:''}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->m12)?$dataListL->m12:''}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->m1)?$dataListL->m1:''}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->m2)?$dataListL->m2:''}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->m3)?$dataListL->m3:''}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->m4)?$dataListL->m4:''}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->m5)?$dataListL->m5:''}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->m6)?$dataListL->m6:''}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->m7)?$dataListL->m7:''}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->m8)?$dataListL->m8:''}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->m9)?$dataListL->m9:''}}</td>
                        <td style="text-align: right; vertical-align: middle;">{{isset($dataListL->sum)?$dataListL->sum:''}}</td>
                    </tr>
                @endforeach
                
                <tr >
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: center;"><b>รวม {{$dataListHs->description}}</b></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sum10==0?'-':$sum10}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sum11==0?'-':$sum11}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sum12==0?'-':$sum12}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sum01==0?'-':$sum01}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sum02==0?'-':$sum02}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sum03==0?'-':$sum03}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sum04==0?'-':$sum04}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sum05==0?'-':$sum05}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sum06==0?'-':$sum06}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sum07==0?'-':$sum07}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sum08==0?'-':$sum08}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sum09==0?'-':$sum09}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$sumM ==0?'-':$sumM }}</td>


                </tr>
                <tr></tr>
                </tbody>
            @endforeach
            <tr>
                <td colspan="2"style="text-align: left;">หมายเหตุ : {{$note}}</td>
            </tr>
    
    </table>
    </body>
</html>
