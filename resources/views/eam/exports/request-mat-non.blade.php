<html>
    <head>
        <title>ใบเบิกวัสดุ (Non Stock)</title>
        <style type="text/css">
            @font-face{
                font-family: 'SarabunSans';
                font-style: 'normal';
                src: url("file://{!! public_path('/fonts/Sarabun-Regular.ttf') !!}") format('truetype');
            }

            body {
                font-family: 'SarabunSans';
                font-size: 10px;
            }

            .page {
                overflow: hidden;
                /* page-break-after: always; */
                position: relative;
                min-height: 725px;
            }

            .table-content, .table-top {
                border-collapse: collapse;
                font-size: 10px;
                page-break-inside:auto;
                width: 100%;
            }

            .table-header {
                text-align: center;
            }

            .table-content tr {
                page-break-inside:avoid;
                page-break-after:auto;
            }

            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }

            .table-content tbody {
                vertical-align: text-top;
            }

            .col-1  { min-width: 50px; }
            .col-2  { min-width: 160px; }
            .col-3  { min-width: 80px; }
            .col-4  { min-width: 60px; }
            .col-5  { min-width: 60px; }
            .col-6  { min-width: 100px; }
            .col-7  { min-width: 100px; }
            .col-8  { min-width: 80px; }
            .col-9  { min-width: 80px; }
            .col-10  { min-width: 110px; }
            .col-11  { min-width: 100px; }


            .table-main {
                border-collapse: collapse;
                font-size: 10px;
                page-break-inside:auto;
            }
            .table-main thead tr td {
                text-align: center;
            }
            .table-main tr {
                page-break-inside:avoid;
                page-break-after:auto;
            }

            .table-footer {
                margin-top: 15px;
                margin-left: auto;
                margin-right: auto;
                font-family: 'SarabunSans';
                font-size: 10px;
            }

        </style>
    </head>
    <body>
        @foreach ($data as $page)
        @php
            $headerDetail = $page->rows[0];
        @endphp
        <div class="page">
            @for ($i = 0; $i < 1; $i++)
            <div @if ($i==1)
                style="margin-top: 20px;"
            @endif>
                <table class="table-top" style="">
                    <thead>
                        <tr style="text-align: right;">
                            <td style="padding-right: 427px;" colspan="10">ใบเบิกวัสดุ</td>
                            <td colspan="1">ยสท.1</td>
                        </tr>
                        <tr>
                            <td colspan="11" style="padding-top: 10px; text-align: center;"></td>
                        </tr>
                        <tr style="text-align: right;">
                            <td colspan="11">เลขที่</td>
                        </tr>
                        <tr style="text-align: right;">
                            <td colspan="11">วันที่ {{Str::upper($headerDetail->current_date->format('d-M-y'))}}</td>
                        </tr>
                        <tr>
                            <td colspan="11">
                                <span>หน่วยงาน</span>
                                <span style="padding-left: 15px">{{$headerDetail->department_code}}: {{$headerDetail->department_desc}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11">
                                <span>ต้องการสิ่งของดังรายการต่อไปนี้ สำหรับใช้งาน</span>
                                <span style="padding-left: 15px">{{$headerDetail->asset_number}}: {{$headerDetail->asset_desc}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11">
                                <span>ตามใบรับงาน</span>
                                <span style="padding-left: 15px">{{$headerDetail->wip_entity_name}}</span>
                                <span style="padding-left: 30px">ลงวันที่</span>
                                <span style="padding-left: 15px">{{Str::upper($headerDetail->create_date->format('d-M-y'))}}</span>
                                <span style="padding-left: 30px">ของ</span>
                                <span style="padding-left: 15px">{{$headerDetail->owning_department_code}}: {{$headerDetail->owning_department_desc}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11">
                                <span>ตามใบขอซื้อ</span>
                                <span style="padding-left: 15px">{{$headerDetail->pr_number}}</span>
                            </td>
                        </tr>
                    </thead>
                </table>
                <table class="table-content" style="margin-top: 15px;">
                    <thead>
                        <tr class="table-header">
                            <td class="col-1">ลำดับที่</td>
                            <td class="col-2">รายการสิ่งของ</td>
                            <td class="col-3">Item Type</td>
                            <td class="col-4">จำนวน</td>
                            <td class="col-5">หน่วย</td>
                            <td class="col-6">สถานที่จัดเก็บ</td>
                            <td class="col-7">Lot No./Serial</td>
                            <td class="col-8">หน่วยละ</td>
                            <td class="col-9">รวมเงิน</td>
                            <td class="col-10">สั่งจาก</td>
                            <td class="col-11">หมายเหตุ</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($page->rows ?? '' as $row => $dataRow)
                                                                                                            
                        <tr>
                            <td class="text-center">{{$row+1}}</td>
                            <td class="">{{$dataRow->item_code}}: {{$dataRow->item_desc}}</td>
                            <td class="text-center">{{$dataRow->item_type}}</td>
                            <td class="text-center">{{$dataRow->quantity}}</td>
                            <td class="text-center">{{$dataRow->uom}}</td>
                            <td class="">{{$dataRow->subinventory}}@if ($dataRow->locator)  : {{$dataRow->locator}} @endif</td>
                            <td class="">{{$dataRow->lot_no}}@if ($dataRow->serial)  : {{$dataRow->serial}} @endif</td>
                            <td class="text-right">{{number_format($dataRow->unit_price, 4)}}</td>
                            <td class="text-right">{{number_format($dataRow->total_price, 4)}}</td>
                            <td class="">{{$dataRow->order_from}}</td>
                            <td class="">{{$dataRow->comments}}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
                <table class="table-top" style="width: 100%; margin-top: 0px;">
                    <thead>																															
                        <tr style="">
                            <td style="width: 80%; padding-left: 150px;">รับรองว่าวัสดุตามรายการและจำนวนที่เบิกมานี้ จะนำไปใช้งานของโรงงานยาสูบ</td>
                            <td style="width: 20%;" class="text-center" >งบประมาณ ( <span style="color: white;">________________________________________</span> )</td>
                        </tr>
                        <tr style="text-align: right;">
                            <td style="width: 80%;"></td>
                            <td style="width: 20%;" class="text-center" >ประเภท ________________________________________ </td>
                        </tr>
                        <tr style="">
                            <td>ผู้เบิก ________________________________________ นายช่าง/ผู้ควบคุม ________________________________________ ดำเนินการได้ ________________________________________ หน่วย ____________________	</td>
                        </tr>
                        <tr style="">
                            <td style="width: 80%;"></td>
                            <td style="width: 20%;" class="text-center" >หมวด ________________________________________ </td>
                        </tr>
                        <tr>
                            <td style="width: 80%; padding-left: 250px">ได้รับของไปถูกต้องแล้ว</td>
                            <td style="width: 20%;" class="text-center" >ลำดับ ________________________________________ </td>
                        </tr>
                        <tr>
                            <td style="padding-left: 230px">________________________________________ ผู้รับของ</td>
                        </tr>
                    </thead>
                </table>
            </div>  
            @endfor
        </div>
        @endforeach
    </body>     
    </html>
