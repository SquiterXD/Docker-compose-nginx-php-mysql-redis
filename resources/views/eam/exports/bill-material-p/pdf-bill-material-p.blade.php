<html>
    <head>
        <style>
            @font-face{
                font-family: 'SarabunSans';
                font-style: 'normal';
                src: url("file://{!! public_path('/fonts/Sarabun-Regular.ttf') !!}") format('truetype');
            }

            body {
                font-family: 'SarabunSans';
                font-size: 12px;
                margin: 0;
            }
            
            .text-center {
                text-align: center;
            }

            .b-t {
                border-top: 1px inset black;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .b-r {
                border-right: 1px solid #000;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .b-l {
                border-left: 1px solid #000;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .b-b {
                border-bottom: 1px solid #000;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .pt {
                padding-top: 3px;
            }

            .pb {
                padding-bottom: 3px;
            }
            .pl {
                padding-left: 3px;
            }

            .table-content {
                border-collapse: collapse;
                font-size: 10px;
            }

            .table-header {
                text-align: center;
            }

            .table-main thead tr td {
                text-align: center;
            }

            thead {
                display: table-header-group;      
            }

            tfoot {
                display: table-row-group;
            }

            tr {
                page-break-inside:avoid; 
                page-break-after:auto;           
            }
        </style>
    </head>

    <body>
        {{-- <div class="page"> --}}
        @foreach ($requestEquip as $data)   

            <table class="table-content" >
                <thead style="margin: 0px;">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class="b-t b-r b-l b-b">
                        <td class="b-r text-center" rowspan="2" style="width: 70px;">รหัสพัสดุ</td>
                        <td class="b-r text-center" rowspan="2" style="width: 280px;">รายการ</td>
                        <td class="b-r text-center" colspan="2">โอนจาก</td>
                        <td class="b-r text-center" colspan="2">ไปยัง</td>
                        <td class="b-r text-center" rowspan="2" style="width: 55px;">หน่วยนับ<br>(UOM)</td>
                        <td class="b-r text-center" rowspan="2" style="width: 50px;">จำนวน</td>
                        <td class="text-center" rowspan="2" style="width: 200px;">หมายเหตุ</td>
                    </tr>
                    <tr class="b-r b-l b-b">
                        <td class="b-r text-center" style="width: 65px;">คลัง<br>(Subinventory)</td>
                        <td class="b-r text-center" style="width: 65px;">สถานที่เก็บ<br>(Locator)</td>
                        <td class="b-r text-center" style="width: 65px;">คลัง<br>(Subinventory)</td>
                        <td class="text-center" style="width: 65px;">สถานที่เก็บ<br>(Locator)</td>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($data["items"] as $item)
                        @if(isset($item->item_code))
                            <tr class="b-r b-l b-b">
                                <td class="text-center b-r">{{$item->item_code}}</td>
                                <td class="b-r pl">{{$item->item_description}}</td>
                                <td class="b-r text-center"></td>
                                <td class="b-r text-center"></td>
                                <td class="b-r text-center">{{$data["data"]->to_subinventory}}</td>
                                <td class="b-r text-center">{{$data["data"]->to_locator_code}}</td>
                                <td class="b-r text-center">{{$item->item_primary_uom_code}}</td>
                                <td class="b-r text-center">{{$item->required_quantity}}</td>
                                <td class="b-r pl" style="word-break: break-all;">{{$item->remark}}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>  
        @endforeach  
        {{-- </div>             --}}
    </body>
</html>
