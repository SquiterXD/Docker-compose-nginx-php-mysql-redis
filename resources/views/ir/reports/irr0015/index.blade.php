<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ir.reports.irr0015._style')
    </head>

    </head>
    <body>

        {{-- @foreach ($ptirStockHeaders as $policySetDes =>  $ptirStockHeader) --}}
            @include('ir.reports.irr0015._header')
            @include('ir.reports.irr0015._table')
            <div class="page-break"></div>
        {{-- @endforeach --}}
    </body>
</html>




{{-- @foreach ($ptirStockHeader as $header) --}}
