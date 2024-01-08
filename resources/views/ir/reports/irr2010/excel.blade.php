
<html>
    <style>
        .table>thead>tr>th {
            text-align: center;
            vertical-align: middle;
            border: 1px solid #000000;

        }
        .table>tbody>tr>td {
            border: 1px solid #000000;
            vertical-align: middle;

        }
        .table>tbody>tr>th {
            text-align: center;
            vertical-align: middle;
            border: 1px solid #000000;
        }
        .text-center{
            text-align: center;
        }
        .wrap-text {
            word-wrap: break-word;
        }
    </style>
    <body>
        {{-- @foreach ($ptirStockHeaders as $ptirStockHeader)
            @foreach ($ptirStockHeader as $header) --}}
                @include('ir.reports.irr1010._table')
            {{-- @endforeach --}}
        @endforeach
    </body>
</html>


