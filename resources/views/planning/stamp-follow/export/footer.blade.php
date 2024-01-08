<table class="table table-footer" style="margin-top: 16px; font-size: 16px; color: #000;">
    <tbody>
        <tr>
            <td class="text-center stamp-footer">
                <div>
                    <div style="font-size: 16px; margin-bottom: 10px;">
                        (นายประยุทธ์ ศิริยา)
                    </div>
                    <div style="font-size: 16px; margin-bottom: 10px;">
                        หัวหน้ากองวางแผนและบริหารผลิตภัณฑ์
                    </div>
                    <div style="font-size: 16px; margin-bottom: 5px;">
                        {{ convertFormatDateToFullThai($stampFollowMain->as_of_date, 'full_format') }}
                    </div>
                </div>
            </td>
            <td class="text-center stamp-footer">
                <div>
                    <div style="font-size: 16px; margin-bottom: 10px;">
                        (นายบัญชา เสาธงไชย)
                    </div>
                    <div style="font-size: 16px; margin-bottom: 10px;">
                        รองผู้อำนวยการฝ่ายวางแผนการผลิต
                    </div>
                    <div style="font-size: 16px; margin-bottom: 5px;">
                        {{ convertFormatDateToFullThai($stampFollowMain->as_of_date, 'full_format') }}
                    </div>
                </div>
            </td>
            <td class="text-center stamp-footer">
                <div>
                    <div style="font-size: 16px; margin-bottom: 10px;">
                        (นายสมนึก กษิรักษา)
                    </div>
                    <div style="font-size: 16px; margin-bottom: 10px;">
                        ผู้อำนวยการฝ่ายวางแผนการผลิต
                    </div>
                    <div style="font-size: 16px; margin-bottom: 5px;">
                        {{ convertFormatDateToFullThai($stampFollowMain->as_of_date, 'full_format') }}
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<div class="col-12 text-right">
    <span> Update {{ $stampFollowMain->as_of_date_format }} {{ date('H:i', strtotime($stampFollowMain->updated_at)) }}</span>
</div>
