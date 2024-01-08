<table class="table">
   

            <tr style="border-bottom: 1px solid #464DD5; margin: 0px; padding: 0px;">
                    <td style="width: 20%" align="center" > <b>รหัสวัตถุดิบ</b></td>
                    <td style="width: 20%" align="center"> <b>รายละเอียด</b></td>
                    <td style="width: 10%" align="center"> <b>หน่วยนับ</b></td>
                    <td style="width: 30%; border-bottom: 1px solid  #928f94;" align="center" colspan="3"> <b>จริง</b></td>
                    <td style="width: 20%" align="center"> <b>หมายเหตุ</b></td>
            </tr>
            <tr>
                <td  style="width: 20%"align="center"></td>
                <td  style="width: 20%"align="center"></td>
                <td  style="width: 10%"align="center"></td>
                <td  style="width: 10%"align="center"><b>จำนวน</b></td>
                <td  style="width: 10%"align="center"><b>ราคา</b></td>
                <td  style="width: 10%"align="center"><b>จำนวนเงิน</b></td>
                <td  style="width: 20%"align="center"></td>
            </tr>
           <tr>
                <th style="border-bottom: 1px solid #928f94; margin: 0px; padding: 0px;" colspan="7" ></th>
            </tr> 

            @foreach($ListData_Ls->where('dept_code', $ListData_H->dept_code) as $ListData_L)
            @foreach($ListData_Ds->where('cat_segment1', $ListData_L->cat_segment1) as $ListData_D)
            <!-- <tr>
                <th style="border-bottom: 1px solid #928f94;margin: 0px; padding: 0px;" colspan="7" ></th>
            </tr> -->
            <tr>
                <td  style="width: 20%" align="center">{{$ListData_D->item_no}}</td>
                <td  style="width: 20%" >{{$ListData_D->item_description}}</td>
                <td  style="width: 10%" align="center">ม้วน</td>
                <td  style="width: 10%" align="right">{{$ListData_D->mmt_qty}}</td>
                <td  style="width: 10%" align="right">{{$ListData_D->mmt_unit_price}}</td>
                <td  style="width: 10%" align="right">{{$ListData_D->mmt_amount}}</td>
                <td  style="width: 20%" align="center"></td>
            </tr>
            <tr>
                <th style="border-bottom: 1px solid #928f94;margin: 0px; padding: 0px;" colspan="7" ></th>
            </tr>
            
            @endforeach
            <!-- <tr>
                <th style="border-top: 1px solid #928f94; margin: 0px; padding: 0px;" colspan="7" ></th>
            </tr> -->
            <tr >
              
                <td  style="width: 20%" align="center"></td>
                <td  style="width: 30%"  colspan="2"><b> รวม  {{$ListData_L->cat_name}} </b></td>
                <td  style="width: 10%" align="right">{{ number_format($ListData_Ds->where('cat_segment1', $ListData_L->cat_segment1)->sum('mmt_qty'))  }}</td>
                <td  style="width: 10%" align="center"></td>
                <td  style="width: 10%" align="right">{{ number_format($ListData_Ds->where('cat_segment1', $ListData_L->cat_segment1)->sum('mmt_amount'), 2)  }}</td>
                <td  style="width: 20%" align="center"></td>
            </tr>

            <tr>
                <th style="border-top: 1px solid black; margin: 0px; padding: 0px;" colspan="7" ></th>
            </tr>
            
            @endforeach
            
            <tr >
                <td  style="width: 40%" colspan="2" align="center"></td>
                <td  style="width: 10%" align="center" >รวม</td>
                <td  style="width: 10%" align="right">{{ number_format($ListData_Ls->sum('mmt_qty'))  }}</td>
                <td  style="width: 10%" align="right"></td>
                <td  style="width: 10%" align="right">{{ number_format($ListData_Ls->sum('mmt_amount'))  }}</td>
                <td  style="width: 20%" align="center"></td>
            </tr>

            <tr>
                <th style="border-top: 1px solid black; margin: 0px; padding: 0px;" colspan="7" ></th>
            </tr>

</table>