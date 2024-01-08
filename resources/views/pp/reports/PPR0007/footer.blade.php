<div class="row col-12">
    <div clsas="text-left" style="margin-top: 10px; font-size: 18px;">
        ข้าพเจ้าขอรับรองว่ารายการข้างต้นนี้ถูกต้องเป็นจริงทุกประการ
    </div>
</div>
<table class="table table-footer" style="font-size: 16px; color: #000;">
    <tbody>
        <tr>
            <td class="text-center stamp-footer">
                <div>
                    <div style="font-size: 18px; margin-bottom: 12px;">
                        ลายมือชื่อ.........................................................ผลิตยาสูบ/ผู้แทน
                    </div>
                    <div style="font-size: 18px; margin-bottom: 12px;">
                        (.......................{{ $sign ?? 'ผู้ผลิตยาสูบ/ผู้แทน' }}.......................)
                    </div>
                    <div style="font-size: 18px;">
                        วันที่............เดือน.....{{ $nextMonth }}.....พ.ศ.....{{ thainumDigit($year) }}.....
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
