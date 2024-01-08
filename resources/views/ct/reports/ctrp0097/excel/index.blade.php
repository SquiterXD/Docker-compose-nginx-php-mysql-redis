<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ct.reports.ctrp0097._style')
    </head>
    <body>

        @include('ct.reports.ctrp0097.excel._header')

        @include('ct.reports.ctrp0097.excel._table')
        
        <div class="page-break"></div>

    </body>
</html>
