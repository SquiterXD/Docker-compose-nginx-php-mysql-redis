<html>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <thead>
            <tr>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    รายการ 
                </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    วันที่ 
                </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                    เวลา
                </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    เลขที่การตรวจสอบ 
                </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    ตราบุหรี่ 
                </th>
                <th width="30" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    ปัญหา/ข้อบกพร่อง 
                </th>
                <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    จำนวน 
                </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    หน่วยนับ 
                </th>
                <th width="30" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                    สถานที่พบ
                </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    ระดับความรุนแรง 
                </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                    หมายเหตุ
                </th>
                <th width="30" colspan="5" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                    รูปภาพประกอบ
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportItems as $index => $reportItem)
                <tr>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                        {{ $index+1 }} 
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                        {{ $reportItem->date_drawn_formatted }} 
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                        {{ $reportItem->time_drawn_formatted }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                        {{ $reportItem->sample_no }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                        {{ $reportItem->brand_desc }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: left;">
                        {{ $reportItem->test_desc }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                        {{ $reportItem->result_value }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                        {{ $reportItem->test_unit_desc }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                        {{ $reportItem->locator_desc }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                        {{ $reportItem->severity_level ? $reportItem->severity_level : "-" }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: left;">
                        {{ $reportItem->remark }}
                    </td>
                    @for ($i = 0; $i < 5; $i++)
                        <td style="border: 1px solid #000000; {{ $i > 0 ? 'border-left: 1px solid #FFFFFF;' : '' }} vertical-align: top; text-align: center;">
                            @if(isset($reportItem->attachments[$i]))
                                @if(Storage::disk('public')->exists("qm/finished-products/result-quality-line/images/".$reportItem->attachments[$i]->file_name))
                                    <img src="storage/qm/finished-products/result-quality-line/images/{{{ $reportItem->attachments[$i]->file_name }}}" height="120" width="120">
                                @endif
                            @endif
                        </td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

</html>