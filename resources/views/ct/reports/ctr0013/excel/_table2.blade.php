<div style="min-height: 640px;">

    <table border="0" width="100%" style="border: 1px solid #000000; font-size: 12px;">
        <thead>
            <tr>
                <td rowspan="3" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    รหัส 
                </td>
                <td rowspan="3" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    รายละเอียด 
                </td>
               
                <td rowspan="3" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    หน่วยนับ 
                </td>
                <td colspan="8" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    ค่าวัตถุดิบ - คิดเข้างาน
                </td>
                <td rowspan="3" 
                    class="text-center"  
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    ค่าแรง
                </td>
                <td rowspan="3" 
                    class="text-center"  
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    ค่าใช้จ่ายการผลิตผันแปร
                </td>
                <td rowspan="3" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    ค่าใช้จ่ายการผลิตคงที่
                </td>
                <td rowspan="3" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    รวมต้นทุนการผลิต 
                </td>
                
            </tr>
            <tr>
                <td colspan='2'
                class="text-center" 
                style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                สินค้ากึ่งสำเร็จรูป	
                </td>
                <td colspan='2'
                
                style="text-align: center; border: 1px solid #000000;   ">
                บวก งานระหว่างผลิต-ปลายงวด
                </td>
                <td colspan='2'
                
                style="text-align: center; border: 1px solid #000000;   ">
                หัก งานระหว่างผลิต-ต้นงวด
                </td>
                <td colspan='2'
                class="text-center" 
                style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                รวมทั้งสิ้น    
                </td>
            </tr>
            <tr>
                <td style="text-align: center; border: 1px solid #000000;">
                ปริมาณ

                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    ต้นทุน
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                ปริมาณ

                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    ต้นทุน
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    ปริมาณ

                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    ต้นทุน
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                ปริมาณ(AQ)

                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                ต้นทุน(AQ*SP)
                </td>
            </tr>
            <tr >
                <td style="text-align: center; border-right: 1px solid #000000; border-left: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000; vertical-align: middle;">
                ศูนย์ต้นทุน  {{$dataList[0]->cost_code.' - '.$dataList[0]->cost_code_desc}}
                </td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center;  border-right: 1px solid #000000;vertical-align: middle;">บาท</td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000; vertical-align: middle;">บาท</td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000; vertical-align: middle;">บาท</td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000; vertical-align: middle;">บาท</td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
            </tr>
            @php 
            $wage_cost      = 0;
            $vary_cost      = 0;
            $fixed_cost     = 0;
            $sum            =0;
            @endphp
            @foreach($dataListH as $product_item_numbers )

                <tr >
                <td style="text-align: left; font-weight: bold; border-right: 1px solid #000000; border-left: 1px solid #000000;">{{$product_item_numbers->product_item_number}}</td>
                <td style="text-align: left;font-weight: bold; border-right: 1px solid #000000;">{{$product_item_numbers->product_item_desc}}</td>
                <!-- <td style="text-align: center; font-weight: bold;border-right: 1px solid #000000;">{{$product_item_numbers->batch_no}}</td> -->
                <td style="text-align: center; font-weight: bold; border-right: 1px solid #000000;">{{$product_item_numbers->product_unit_of_measure}}</td>
                <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;">{{$product_item_numbers->qty}}</td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;">{{$product_item_numbers->ending_qty}}</td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;">{{$product_item_numbers->beginning_qty}}</td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;">{{$product_item_numbers->qty+$product_item_numbers->ending_qty+$product_item_numbers->beginning_qty+$product_item_numbers->beginning_qty}}</td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                </tr>
                @foreach($dataListL->where('product_item_number',$product_item_numbers->product_item_number)
                ->where('batch_no',$product_item_numbers->batch_no)
                ->whereNotNull('cost_org') as $cost_org )
                  <tr>
                    <td style="text-align: center; border-right: 1px solid #000000; border-left: 1px solid #000000;">{{$cost_org->cost_org}}</td>
                    <td style="text-align: left; border-right: 1px solid #000000; ">{{$cost_org->organization_name}}</td>
                    <!-- <td style="text-align: left; border-right: 1px solid #000000; "></td> -->
                    <td style="text-align: left; border-right: 1px solid #000000; "></td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$cost_org->transaction_quantity}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$cost_org->transaction_cost}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$cost_org->ct_cs_wip_end}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$cost_org->cost_wip_end}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$cost_org->ct_cs_wip_begin}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$cost_org->cost_wip_begin}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$cost_org->transaction_quantity+$cost_org->ct_cs_wip_end+$cost_org->ct_cs_wip_begin}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$cost_org->transaction_cost+$cost_org->cost_wip_end+$cost_org->cost_wip_begin}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>

                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>




                </tr>                          
                @endforeach
                @php 
                    $sum_cost=$product_item_numbers->wage_cost+$product_item_numbers->vary_cost+$product_item_numbers->fixed_cost+($product_item_numbers->transaction_cost+$product_item_numbers->sumCost_wip_end+$product_item_numbers->cost_wip_begin);
                    if ($sum_cost == 0) {
                        $sum_cost = '';
                    }
                    $SUM_product_cost=$product_item_numbers->transaction_cost+$product_item_numbers->sumCost_wip_end+$product_item_numbers->cost_wip_begin;
                    if ($SUM_product_cost == 0) {
                        $SUM_product_cost = '';
                    }
                @endphp
                <tr >
                <td style="text-align: left; font-weight: bold; border-right: 1px solid #000000; border-left: 1px solid #000000;"></td>
                <td style="text-align: right;font-weight: bold; border-right: 1px solid #000000;">รวมตามผลิตภัณฑ์ {{$product_item_numbers->product_item_number}}</td>
                <!-- <td style="text-align: center; font-weight: bold;border-right: 1px solid #000000;"></td> -->
                <td style="text-align: center; font-weight: bold; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; font-weight: bold; border: 1px solid #000000;"></td>
                <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">{{$product_item_numbers->transaction_cost}}</td>
                <td style="text-align: center; border: 1px solid #000000;"></td>
                <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">{{$product_item_numbers->sumCost_wip_end}}</td>
                <td style="text-align: center; border: 1px solid #000000;"></td>
                <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">{{$product_item_numbers->cost_wip_begin}}</td>
                <td style="text-align: center; border: 1px solid #000000;"></td>
                <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">{{$SUM_product_cost}}</td>
                <td style="text-align: right; border: 1px solid #000000;">{{$product_item_numbers->wage_cost}}</td>
                <td style="text-align: right; border: 1px solid #000000;">{{$product_item_numbers->vary_cost}}</td>
                <td style="text-align: right; border: 1px solid #000000;">{{$product_item_numbers->fixed_cost}}</td>
                
                <td style="text-align: right; border: 1px solid #000000;">
                    {{$sum_cost}}</td>
                </tr>

                @php 
      
                $wage_cost      = $wage_cost+($product_item_numbers->wage_cost);
                $vary_cost      = $vary_cost+($product_item_numbers->vary_cost);
                $fixed_cost     = $fixed_cost+($product_item_numbers->fixed_cost);
                $sum            = $sum+($product_item_numbers->wage_cost+$product_item_numbers->vary_cost+$product_item_numbers->fixed_cost)+($product_item_numbers->transaction_cost+$product_item_numbers->sumCost_wip_end+$product_item_numbers->cost_wip_begin);
                if ($sum == 0) {
                        $sum = '';
                    }
                @endphp
                
            @endforeach
            <tr>
                <td style="text-align: center; font-weight: bold;border-left: 1px solid #000000; border-right: 1px solid #000000;">สรุปตาม Org.ของวัตถุดิบ</td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <!-- <td style="text-align: right; border-right: 1px solid #000000;"></td> -->
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>
                <td style="text-align: right; border-right: 1px solid #000000;"></td>

            </tr>
            @foreach($dataListOrg->whereNotNull('cost_org')  as $dataListOrgs )
                  <tr>
                    <td style="text-align: center; border-right: 1px solid #000000; border-left: 1px solid #000000;">{{$dataListOrgs->cost_org}}</td>
                    <td style="text-align: left; border-right: 1px solid #000000; ">{{$dataListOrgs->organization_name}}</td>
                    <!-- <td style="text-align: left; border-right: 1px solid #000000; "></td> -->
                    <td style="text-align: left; border-right: 1px solid #000000; "></td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$dataListOrgs->transaction_quantity}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$dataListOrgs->transaction_cost}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$dataListOrgs->ct_cs_wip_end}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$dataListOrgs->cost_wip_end}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$dataListOrgs->ct_cs_wip_begin}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$dataListOrgs->cost_wip_begin}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$dataListOrgs->transaction_quantity+$dataListOrgs->ct_cs_wip_end+$dataListOrgs->ct_cs_wip_begin}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;">{{$dataListOrgs->transaction_cost+$dataListOrgs->cost_wip_end+$dataListOrgs->cost_wip_begin}}</td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>

                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>

                </tr>                          
                @endforeach

                <tr>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold; border-right: 1px solid #000000; border-bottom: 1px solid #000000; ">รวมตามศูนย์ต้นทุน</td>
                    <!-- <td style="text-align: center; font-weight: bold; border-right: 1px solid #000000; border-bottom: 1px solid #000000; "></td> -->
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid #000000; border-bottom: 1px solid #000000; "></td>
                    <td style="text-align: right;  font-weight: bold; border-right: 1px solid #000000; border-bottom: 1px solid #000000;border-top: 1px solid #000000;">{{$dataListSum[0]->transaction_quantity}}</td>
                    <td style="text-align: right;  font-weight: bold; border-right: 1px solid #000000; border-bottom: 1px solid #000000;border-top: 1px solid #000000;">{{$dataListSum[0]->transaction_cost}}</td>
                    <td style="text-align: right;  font-weight: bold; border-right: 1px solid #000000; border-bottom: 1px solid #000000;border-top: 1px solid #000000;">{{$dataListSum[0]->ct_cs_wip_end}}</td>
                    <td style="text-align: right;  font-weight: bold; border-right: 1px solid #000000; border-bottom: 1px solid #000000;border-top: 1px solid #000000;">{{$dataListSum[0]->cost_wip_end}}</td>
                    <td style="text-align: right;  font-weight: bold; border-right: 1px solid #000000; border-bottom: 1px solid #000000;border-top: 1px solid #000000;">{{$dataListSum[0]->ct_cs_wip_begin}}</td>
                    <td style="text-align: right;  font-weight: bold; border-right: 1px solid #000000; border-bottom: 1px solid #000000;border-top: 1px solid #000000;">{{$dataListSum[0]->cost_wip_begin}}</td>
                    <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000; border-bottom: 1px solid #000000;border-top: 1px solid #000000;">{{$dataListSum[0]->transaction_quantity+$dataListSum[0]->ct_cs_wip_end+$dataListSum[0]->ct_cs_wip_begin}}</td>
                    <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;border-bottom: 1px solid #000000; border-top: 1px solid #000000;">{{$dataListSum[0]->transaction_cost+$dataListSum[0]->cost_wip_end+$dataListSum[0]->cost_wip_begin}}</td>
                    <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;border-bottom: 1px solid #000000; border-top: 1px solid #000000;">{{$wage_cost}}</td>
                    <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;border-bottom: 1px solid #000000; border-top: 1px solid #000000;">{{$vary_cost}}</td>     
                    <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;border-bottom: 1px solid #000000; border-top: 1px solid #000000;">{{$fixed_cost}}</td>    
                    <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;border-bottom: 1px solid #000000; border-top: 1px solid #000000;">{{$sum}}</td>                      
                </tr> 
        </thead>
        
    </table>

</div>