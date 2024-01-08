<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงานการแทนเกรด</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew Bold.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        body, td {
            margin: 0;
            font-family: "THSarabunNew" !important;
            font-size: 16px;
            line-height: 1;
            padding: 3px;
        }

        table {
            border-collapse: collapse
        }

        thead{display: table-header-group;}
        tfoot {display: table-row-group;}
        tr {page-break-inside: avoid;}
    </style>

<body>
    <table style="width:100%" border="0">
        <thead>
            <tr>
                <th width="20" style="border-top: 0.4px solid #000000; border-bottom: 0.4px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">ประเภทใบยา</th>
                <th width="20" style="border-top: 0.4px solid #000000; border-bottom: 0.4px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">ชนิดใบยา</th>
                <th width="20" style="border-top: 0.4px solid #000000; border-bottom: 0.4px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">ครั้งที่แทนเกรด</th>
                <th width="20" style="border-top: 0.4px solid #000000; border-bottom: 0.4px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">วันที่อนุมัติ</th>
                <th width="20" style="border-top: 0.4px solid #000000; border-bottom: 0.4px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">วันที่แทนเกรด</th>
                <th width="20" style="border-top: 0.4px solid #000000; border-bottom: 0.4px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">ใบยาเกรดแทน</th>
                <th width="20" style="border-top: 0.4px solid #000000; border-bottom: 0.4px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">รายละเอียด</th>
                <th width="20" style="border-top: 0.4px solid #000000; border-bottom: 0.4px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">Lot</th>
                <th width="20" style="border-top: 0.4px solid #000000; border-bottom: 0.4px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">ปริมาณ(%)</th>
                <th width="20" style="border-top: 0.4px solid #000000; border-bottom: 0.4px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">รวม</th>
                <th width="20" style="border-top: 0.4px solid #000000; border-bottom: 0.4px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">ผู้แทนเกรด</th>
            </tr>
        </thead>
        <tbody id="tbody">
            @foreach ($data->groupBy('medicinal_leaves_type_desc') as $index => $medicinalLeaves)
                @php
                    $count          = 0;
                    $wordDomestic   = $medicinalLeafDomestic['category_desc_1'];
                    $wordExport     = $medicinalLeafExport['category_desc_1'];
                @endphp
                @foreach ($medicinalLeaves->groupBy('medicinal_leaf_group') as $key => $Leaves)
                <tr style="height:40px;">
                    <td style="vertical-align: middle; text-align: center;">
                        {{ $count == 0 ? $index : '' }}
                    </td>
                    <td style="vertical-align: middle; text-align: center;">
                        {{ $key }}
                    </td>
                </tr>
                @php
                    if($index == $wordDomestic){
                        $count += 1;
                    }else{
                        if($index == $wordExport){
                            $count += 1;
                        }
                    }
                @endphp
                    @foreach ($Leaves as $item)
                        <tr>
                            <td></td>
                            <td></td>
                            <td width="25" style="vertical-align: middle; text-align: center;">
                                {{ $item['version_no'] }}
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                {{ $item['approved_date'] }}
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                {{ $item['date_instead_grades'] }}
                            </td>
                            <td style="vertical-align: middle; text-align: left;">
                                {{ $item['h_medicinal_leaf_no'] }}
                            </td>
                            <td width="20%" style="vertical-align: middle; text-align: left;">
                                {{ $item['medicinal_leaf_description'] }}
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                {{ $item['lot_number'] }}
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                {{ $item['quantity_percent'] }}
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                {{ $item['total_quantity_percent'] }}
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                {{ $item['last_updated_name'] }}
                            </td>               
                        </tr>         
                    @endforeach                                        
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
