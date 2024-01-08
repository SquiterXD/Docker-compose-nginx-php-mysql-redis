<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        @include('pd.reports.PDR1130._style')
        <style>
           .table_data{
            border:none;
        border-collapse: collapse;
        height: 20px;
        width:100%;

            } 
        </style>    
    </head>

    <body>
        <!-- header report -->
        @php
            $pageNo = 0;
            $limit = 27 ;
            $DataHead = array_chunk($DataHeads->toArray(), $limit);
            $page = count($DataHead);
        @endphp

        @foreach ($DataHead as $dataH)
        @php
            $cnt_batch = 0;
        @endphp
            @php
                $pageNo++;
            @endphp
            <div style="page-break-after: always;"></div>
            @include('pd.reports.PDR1130.header')
            <table class ="table_data" >
                <thead>
                    <tr >
                        <!-- wip02 -->
                        <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center; width:50px;" rowspan=3 >เลขที่คำสั่งผลิต </th>
                        <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center; width: 3px; " rowspan=3 > รหัสหมวด </th>
                        <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center; " rowspan=3 > รหัสสิ่งพิมพ์ </th>
                        <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center; width:280px;" rowspan=3 > ชื่อสิ่งพิมพ์ </th>
                        <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center; " rowspan=3 > รับจากกองพิมพ์<BR>แผ่น</th>
                        <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center; " rowspan=3 > แผ่นละตัดได้<BR>ชิ้น</th>

                        <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center;  width: 5%" colspan=5> ระหว่างคัดเลือก</th>
                        <th style="border-top: 1px solid #000000; text-align: center;  width: 2px"> </th>
                        <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center; width: 5%" colspan=5> สำเร็จรูป</th>
                        </tr>
                        <tr >
                        <!-- wip03 -->
                        <th style="border-bottom: 1px solid #000000; text-align: center; width: 5%" rowspan=2 > ชิ้น </th>
                        <th style="border-bottom: 1px solid #000000; text-align: center; width: 5%" rowspan=2 > ยอดยกมา<BR>ชิ้น </th>
                        <th style="border-bottom: 1px solid #000000; text-align: center; width: 5%" rowspan=2 > รวม<BR>ชิ้น </th>
                        <th style="border-bottom: 1px solid #000000; text-align: center; width: 5%" rowspan=2 > เสีย<BR>ชิ้น </th>
                        <th style="border-bottom: 1px solid #000000; text-align: center; width: 5%" rowspan=2 > ยอดยกไป<BR>ชิ้น </th>

                        <!-- wip04 -->
                        <th style="border-bottom: 1px solid #000000; text-align: center;  width: 2px" rowspan=2> </th>
                        <th style="border-bottom: 1px solid #000000; text-align: center; width: 5%" rowspan=2 > บรรจุได้<BR>ชิ้น </th>
                        <th style="border-bottom: 1px solid #000000; text-align: center; width: 5%" rowspan=2 > ยอดยกมา<BR>ชิ้น </th>
                        <th style="border-bottom: 1px solid #000000; text-align: center; width: 5%" rowspan=2 > รวม<BR>ชิ้น </th>
                        <th style="border-bottom: 1px solid #000000; text-align: center; width: 5%" rowspan=2 > ส่งฝ่ายจัดหา<BR>ชิ้น </th>
                        <th style="border-bottom: 1px solid #000000; text-align: center; width: 5%" rowspan=2 > ยอดยกไป<BR>ชิ้น </th>
                    </tr>
                </thead>
                <tbody>
             
                @for ($cnt_batch = 0 ; $cnt_batch <= count($dataH)-1 ; $cnt_batch++)
                <tr>
                    <td style=" text-align: left; ">{{$dataH[$cnt_batch]['batch_no']}}</td>
                    <td style=" text-align: center; ">{{$dataH[$cnt_batch]['product_group']}}</td>
                    <td style=" text-align: left; ">{{$dataH[$cnt_batch]['product_code']}}</td>
                    <td style=" text-align: left; ">{{$dataH[$cnt_batch]['product_description']}}</td>
                   
                    <td style=" text-align: right; ">{{isset($productQty02Layout[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                        showNumber($productQty02Layout[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]): '0'}} </td>
                    <td style=" text-align: right; ">{{isset($LayoutQty02[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                        $LayoutQty02[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']] : ( isset($LayoutQty03[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                                                                                                                              $LayoutQty03[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']] : (isset($LayoutQty04[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                                                                                                                                                                                                                                    $LayoutQty04[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']] : '0' 
                                                                                                                                                                                                                                   ) 
                                                                                                                              
                                                                                                                              
                                                                                                                            ) }}  </td>

                    
                    <td style=" text-align: right; ">{{isset($productQty03[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                        showNumber($productQty03[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]): '0'}} </td>
                    <td style=" text-align: right; ">{{isset($rec03Receive[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                        showNumber($rec03Receive[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]): '0'}} </td>
                    
                        @php
                        $v_productQty03 = 0;
                        $v_rec03Receive = 0;
                        $sum03 = 0;

                            $v_productQty03 = isset($productQty03[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                               $productQty03[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]: 0 ;

                            $v_rec03Receive = isset($rec03Receive[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                                $rec03Receive[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']] : 0 ;

                            $sum03 = $v_productQty03 +  $v_rec03Receive ;
                        @endphp
                    
                    <td style=" text-align: right; "> {{ showNumber($sum03)  }}</td>

                    <td style=" text-align: right; "> {{isset($lossQty03[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                        showNumber($lossQty03[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]): '0'}}</td>
                    
                    <td style=" text-align: right; "> {{isset($tran03Tranfer[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                        showNumber($tran03Tranfer[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]): '0'}} </td>

                    <td style=" text-align: center;  width: 2px"></td>
                    <td style=" text-align: right; ">{{isset($productQty04[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                        showNumber($productQty04[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]): '0'}} </td>
                    <td style=" text-align: right; ">{{isset($rec04Receive[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                        showNumber($rec04Receive[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]): '0'}} </td>
                       
                        @php
                        $v_productQty04 = 0;
                        $v_rec04Receive = 0;
                        $sum04 = 0 ;

                            $v_productQty04 = isset($productQty04[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                               $productQty04[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]: 0 ;

                            $v_rec04Receive = isset($rec04Receive[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                                $rec04Receive[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']] : 0 ;

                            $sum04 = $v_productQty04 +  $v_rec04Receive ;
                        @endphp

                        <td style=" text-align: right; "> {{ showNumber($sum04) }}</td>
                        <td style=" text-align: right; ">{{isset($TranferQty04[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                            showNumber($TranferQty04[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]): '0'}} </td>
                        <td style=" text-align: right; ">{{isset($tran04Tranfer[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]) ? 
                            showNumber($tran04Tranfer[$dataH[$cnt_batch]['batch_no']][$dataH[$cnt_batch]['product_code']]): '0'}} </td>
                      
                    
                    
                </tr>
              
                @endfor     
                </tbody>
            </table>
        @endforeach
    </body>
</html>