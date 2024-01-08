
<html>
    <head>
        <style>
            .table>thead>tr>th {
                text-align: center;
                vertical-align: middle;
                border: 1px solid #000000;
                background: #fff;

            }
            .table>tbody>tr>td {
                border: 1px solid #000000;
                vertical-align: middle;
                background: #fff;

            }
            .table>tbody>tr>th {
                text-align: center;
                vertical-align: middle;
                border: 1px solid #000000;

            }
            .table{
                background: #fff;
            }
            .text-center{
                text-align: center;
            }
            .wrap-text {
                word-wrap: break-word;
            }
        </style>
    </head>
    <body>

        @foreach ($ptirStockHeaders as $policySetDes =>  $ptirStockHeader)
            @include('ir.reports.irr1010e._table', ['policySetDes' => $policySetDes])
        @endforeach
    </body>
</html>




{{-- @foreach ($ptirStockHeader as $header) --}}
