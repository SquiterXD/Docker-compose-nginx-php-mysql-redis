<table class="table table-footer" style="margin-top: 16px; font-size: 16px; color: #000;">
    <tbody>
        <tr style="border: 0.5px solid #fff;">
            <td>
                <div>
                    <div style="font-size: 16px; margin-bottom: 10px;">
                        ผู้ขอใช้งบประมาณ
                    </div>
                    <div class="text-center" style="font-size: 16px; margin-bottom: 10px;">
                        ( {{ getUserDetail($header->head_attribute7)['name'] }} )
                    </div>
                    <div class="text-center" style="font-size: 16px; margin-bottom: 10px;">
                       ตำแหน่ง {{ getUserDetail($header->head_attribute7)['position'] }}
                    </div>
                    <div class="text-center" style="font-size: 16px; margin-bottom: 5px;">
                        วันที่ &nbsp; (............/............/...........)
                    </div>
                </div>
            </td>
            <td>
                <div>
                    <div style="font-size: 16px; margin-bottom: 10px;">
                        ผู้ตรวจสอบ
                    </div>
                    <div class="text-center" style="font-size: 16px; margin-bottom: 10px;">
                        ( {{ getUserDetail($header->head_attribute8)['name'] }} )
                    </div>
                    <div class="text-center" style="font-size: 16px; margin-bottom: 10px;">
                        ตำแหน่ง {{ getUserDetail($header->head_attribute8)['position'] }}
                    </div>
                    <div class="text-center" style="font-size: 16px; margin-bottom: 5px;">
                        วันที่ &nbsp; (............/............/...........)
                    </div>
                </div>
            </td>
            <td>
                <div>
                    <div style="font-size: 16px; margin-bottom: 10px;">
                        ผู้อนุมัติ
                    </div>
                    <div class="text-center" style="font-size: 16px; margin-bottom: 10px;">
                        ( {{ getUserDetail($header->head_attribute9)['name'] }} )
                    </div>
                    <div class="text-center" style="font-size: 16px; margin-bottom: 10px;">
                        ตำแหน่ง {{ getUserDetail($header->head_attribute9)['position'] }}
                    </div>
                    <div class="text-center" style="font-size: 16px; margin-bottom: 5px;">
                        วันที่ &nbsp; (............/............/...........)
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
