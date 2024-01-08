<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
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

        body,
        td {
            margin: 0;
            font-family: "THSarabunNew" !important;
            font-size: 16px;
            line-height: 1;
            padding: 0;
        }
        table {
            border-collapse: collapse
        }
        #theader th {
            border-top: 0.4px solid #000;
            border-bottom: 0.4px solid #000;
            /* padding: 15px 0px; */
        }
        #tbody td {
            /* padding: 6px 3px; */
        }
    </style>

<body>
    <table style="width:100%">
        <thead id="theader">
           
            <tr>
                <th>Blend No.</th>
                <th>รหัสตราบุหรี่</th>
                <th>ตราบุหรี</th>
                <th>ลำดับ</th>
                <th>รายละเอียดวัตถุห่อมวน</th>
            </tr>
           
        </thead>
        <tbody id="tbody">
            @foreach ($result->groupBy('blend_no') as $k => $itemGroup)
            
                @foreach ($itemGroup as $item)
                    <tr>
                        <td style="font-weight: bold">
                            @if ($loop->first)
                                {{ $k }}
                            @endif
                        </td>
                        <td>{{ $item->cigar_item_code }}</td>
                        <td>{{ $item->cigar_item_desc }}</td>
                        <td>{{ $item->wrapped_line_no }}</td>
                        <td>{{ $item->wrapped_description }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
