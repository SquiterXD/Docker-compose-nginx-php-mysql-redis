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
            @foreach($G2->where('dept_code', $G1_H->dept_code) as $G2s)
            @foreach($G3->where('cat_segment1', $G2s->cat_segment1) as $G3s)
            <tr>
                <td  style="width: 20%" align="center">{{$G3s->item_no}}</td>
                <td  style="width: 20%" >{{$G3s->item_description}}</td>
                <td  style="width: 10%" align="center">ม้วน</td>
                <td  style="width: 10%" align="right">{{$G3s->mmt_qty}}</td>
                <td  style="width: 10%" align="right">{{$G3s->mmt_unit_price}}</td>
                <td  style="width: 10%" align="right">{{$G3s->mmt_amount}}</td>
                <td  style="width: 20%" align="center"></td>
            </tr>
            <tr>
                <th style="border-bottom: 1px solid #928f94;margin: 0px; padding: 0px;" colspan="7" ></th>
            </tr>
            @endforeach
            <tr >
                <td  style="width: 20%" align="center"></td>
                <td  style="width: 30%"  colspan="2"><b> รวม  {{$G2s->cat_name}} </b></td>
                <td  style="width: 10%" align="right">{{ number_format($G3->where('cat_segment1', $G2s->cat_segment1)->sum('mmt_qty'))  }}</td>
                <td  style="width: 10%" align="center"></td>
                <td  style="width: 10%" align="right">{{ number_format($G3->where('cat_segment1', $G2s->cat_segment1)->sum('mmt_amount'), 2)  }}</td>
                <td  style="width: 20%" align="center"></td>
            </tr>
            
            <tr>
                <th style="border-top: 1px solid black; margin: 0px; padding: 0px;" colspan="7" ></th>
            </tr>
            
            @endforeach
</table>
<table class="table2">
    
<tr>
        <td  style="width: 10%" align="center"><b>รวม</b></td>
        <td  style="width: 10%" align="right">{{ number_format($G2->where('dept_code',$G1_H->dept_code)->sum('mmt_qty'))  }}</td>
        <td  style="width: 10%" align="center"></td>
                <td  style="width: 10%" align="right">{{ number_format($G2->where('dept_code',$G1_H->dept_code)->sum('mmt_amount'), 2)  }}</td>
                <td  style="width: 20%" align="center"></td>
    </tr>
</table>

<table class="table">
<tr>
        <th style="border-top: 1px solid black; margin: 0px; padding: 0px;" colspan="7" ></th>
    </tr>
</table>