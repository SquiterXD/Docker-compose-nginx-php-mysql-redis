<table border="1">
    <thead>
      <tr>
        <th colspan="4">โปรแกรม IRR1010</th>
        <th colspan="5">การยาสูบแห่งประเทศทไทย</th>
        <th>วันที่</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="4">สั่งพิมพ์ :</td>
        <td colspan="5">ชุดที่</td>
        <td>เวลา</td>
      </tr>
      <tr>
        <td colspan="4"></td>
        <td colspan="5">รายละเอียดการคำนวณค่าเบี้ยประกันภัยความเสี่ยงภัยทรัพย์สิน</td>
        <td>หน้า</td>
      </tr>
      <tr>
        <td colspan="4">กลุ่มสินค้าย่อย : </td>
        <td colspan="5">เดือน</td>
        <td></td>
      </tr>
      <tr>
        <td>ลำดับ</td>
        <td>รายกสน</td>
        <td>มูลค่าทุนประกัน</td>
        <td>อัตราดอกเบี้ย</td>
        <td>ค่าเบี้ยประกัน 50% (บาท)</td>
        <td>เปิดคำนวณบัญชี</td>
      </tr>
      @foreach ($header->ptirStockLines as $line )
        <tr>
            <td>{{ $line->item_code }}</td>
            <td>{{ $line->item_description }}</td>
            <td>{{'-'}}</td>
            <td>{{'-'}}</td>
            <td>{{ $line->original_qty }}</td>
            <td></td>
        </tr>
      @endforeach
    </tbody>
    </table>
