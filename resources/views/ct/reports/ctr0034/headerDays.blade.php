

            <tr>
                <th style="text-align: left;" colspan =4></th>
                <th style="text-align: left;" colspan =11> </th>
            </tr>
            <tr>
                <th style="text-align: left;" colspan =4>เลขที่คำสั่งผลิต : {{$head->batch_no}}</th>
                <th style="text-align: left;" colspan =11>สถานะ : </th>


            </tr>
            <tr>
                <th style="text-align: left;" colspan =4>รหัสผลิตภัณฑ์ : {{$head->product_item_no}} &nbsp; {{$head->product_item_desc}}</th>
                <th style="text-align: left;" colspan =11>วันที่เริ่มผลิต : {{$head->tran_date}}</th>
            </tr>
            <tr>
                <th style="text-align: left;" colspan =4>ผลผลิตที่ได้ : {{number_format($head->product_qty,2)}}</th>
                <th style="text-align: left;" colspan =11>วันที่ได้ผลผลิต : {{$head->tran_date}}</th>
            </tr>
            <tr>
                <th style="border: 1px solid #000000; text-align: center; width: 200px;" rowspan=4><b>รหัส</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 200px;" rowspan=4><b>รายละเอียด</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 80px;"  rowspan=4><b>หน่วยนับ</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=2 colspan =2><b>มาตราฐาน / 1,000.00 กิโลกรัม</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=2 colspan =2><b>ค่าวัตถุดิบ - มาตราฐาน</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=2 colspan =3><b>ค่าวัตถุดิบ - เบิกใช้จริง </b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 250px;" rowspan=2 ><b>ค่าวัตถุดิบ - คิดเข้างาน</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=2 colspan =3><b>ผลต่างวัตถุดิบ</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=2 ><b>รวมผลต่าง</b></th>
            </tr>
            <tr></tr>
            <tr>

                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=1><b>ปริมาณ</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 130px;" rowspan=1><b>ราคาต่อหน่วย</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=1><b>ปริมาณ</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=1><b>ต้นทุน</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=1><b>ปริมาณ</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=1><b>ราคาต่อหน่วย</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=1><b>ต้นทุน</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 250px;" rowspan=1><b>ต้นทุน</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" colspan=2><b>ผลต่าง - ปริมาณ</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=2 ><b>ผลต่าง - ราคา <br>บาท<br>(B)-(C)</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=2 ><b>บาท<br>(B)-(A)</b></th>
            </tr>
     
            
            <tr>
                
                <th style="border: 1px solid #000000; text-align: center; "  ><b>ก.ก</b></th>
                <th style="border: 1px solid #000000; text-align: center; "  ><b>บาท</b></th>
                <th style="border: 1px solid #000000; text-align: center; "  ><b>ก.ก</b></th>
                <th style="border: 1px solid #000000; text-align: center; "  ><b>บาท(A)</b></th>
                <th style="border: 1px solid #000000; text-align: center; "  ><b>ก.ก</b></th>
                <th style="border: 1px solid #000000; text-align: center; "  ><b>บาท</b></th>
                <th style="border: 1px solid #000000; text-align: center; "  ><b>บาท(B)</b></th>
                <th style="border: 1px solid #000000; text-align: center; "  ><b>บาท(C)</b></th>
                <th style="border: 1px solid #000000; text-align: center; "  ><b>ปริมาณ<br>ก.ก</b></th>
                <th style="border: 1px solid #000000; text-align: center; "  ><b>ต้นทุน<br>บาท<br>(C)-(A)</b></th>  
            </tr>


            <tr>
                <th style="border: 1px solid #000000; text-align:  left; "colspan=2 >{{$TypeProd}}  ฤดู/ปีการผลิต : {{$head->season}}</th>
                <th style="border: 1px solid #000000; text-align: center; "colspan=13></th>
             </tr>
 
       
