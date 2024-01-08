<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ir.reports._style')
    </head>

    </head>
    <body>

        @foreach ($summaries as $index =>  $summary)
            @include('ir.reports.irr1001.pdf._header')
            <div class="page-break"></div>
        @endforeach
    </body>
</html>




{{-- @foreach ($ptirStockHeader as $header) --}}
