<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDR0006 : รายงานประวัติการแทนเกรด</title>
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
            padding: 3px;
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
        table > tbody > tr{
            page-break-inside: avoid !important;
        }
        thead {
            display: table-header-group !important;
        }
    </style>

<body>
    <table style="width:100%" border="0">
        <tbody id="tbody">

            @foreach ($result->groupBy('head_leaf_group') as $leafGroup => $line)
                @php
                    // $cols   = $line->sortBy('history_id');
                    $cols   = $line->sortBy('history_dis_id');
                    $chunks = $cols->chunk(6);
                @endphp
                @foreach ($chunks as $key => $chunk)
                <tr>
                    @if ($loop->first)
                        <td width="130px;" valign="top" rowspan="{{ count($chunks) }}">
                            {{ $leafGroup }}
                        </td>
                    @endif
                    @foreach ($chunk as $col)
                        @include('pd.reports.PDR0006._detail_td', [
                            'approvedDate'              => $col->approved_date,
                            'lineMedicinalLeafGroup'    => $col->line_medicinal_leaf_group,
                            'yearEdge'                  => $col->year_edge,
                            'lotNumber'                 => $col->lot_number,
                            'quantityPercent'           => $col->quantity_percent,
                        ])
                    @endforeach
                    @if (count($chunk) < 6)
                        @foreach (range(count($chunk), 5) as $value)
                            @include('pd.reports.PDR0006._detail_td', [
                                'approvedDate'              => '',
                                'lineMedicinalLeafGroup'    => '',
                                'yearEdge'                  => '',
                                'lotNumber'                 => '',
                                'quantityPercent'           => '',
                            ])
                        @endforeach
                    @endif
                </tr>
                @endforeach
                <tr>
                    <td colspan="19" style="border-bottom: 1px solid #000; padding:0px;"> </td>
                </tr>
            @endforeach

            {{-- @foreach (range(0,0) as  $value) --}}
            @foreach ([] as  $value)
                @php
                    $cols = collect(range(1,17));
                    $chunks = $cols->chunk(6);
                @endphp
                @foreach ($chunks as $key => $chunk)
                <tr>
                    @if ($loop->first)
                        <td width="130px;" valign="top" rowspan="{{ count($chunks) }}">
                            xxxx{{ $value }}
                        </td>
                    @endif
                    @foreach ($chunk as $col)
                        <td width="90px;">
                            <div style="text-align: right;">
                                <div style='font-size:30px; line-height: 9px; padding-top: 7px;'>&#8594;</div>
                            </div>
                            <div style="text-align: right;">
                                0{{ $key }}/10/2565
                            </div>
                        </td>
                        <td width="90px;">
                            <div style="text-align: left;">
                                BAF{{ $col }}
                            </div>
                            <div style="text-align: left;">
                                65/66-{{ $col }}
                            </div>
                        </td>
                        <td width="90px;" style="text-align: left;">50%</td>
                    @endforeach
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
