<tr>
    <th colspan="7" style="text-align: center">การยาสูบแห่งประเทศไทย</th>
</tr>
<tr>
    <th colspan="7" style="text-align: center">รายงานบัตรต้นทุนประจำวัน ( 10 ยาเส้น )</th>
</tr>
<tr>
    <th colspan="7" style="text-align: center">ประจำวันที่ </th>
    {{ $dateNowTh }}
</tr>
<tr>
    <td colspan="3" style="text-align: left">
        วันที่เริ่มต้นผลิต:
    </td>
    <td colspan="4" style="text-align: left">
        วันที่ผลิตเสร็จ:
    </td>
</tr>
<tr>
    <td colspan="3" style="text-align: left">
        เลขที่คำสั่งผลิต: {{ $CTBatchNoShow ? $CTBatchNoShow : '' }}
    </td>
    <td colspan="4" style="text-align: left">
        สถานะ: {{ 'ยังไม่เปิดคำสั่งผลิต' }}
    </td>
</tr>
<tr>
    <td colspan="3" style="text-align: left">
        รหัสสินค้า/ชื่อสินค้า:    {{ $CTProductCode ? $CTProductCode : ''  }}
                            {{ $CTProductName ? $CTProductName : '' }}
    </td>
    <td colspan="4" style="text-align: left">
        หน่วยงาน:    {{ $CTDeptCodeShow ? $CTDeptCodeShow : ''  }}
                    {{ $CTDeptNameShow ? $CTDeptNameShow : '' }}
    </td>
</tr>