<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ir.reports._style')
    </head>

    </head>
    <body>
        @foreach ($vehicles->groupBy('insurance_expire_date') as $dates)
            @foreach ($dates->groupBy('insurance_type_desc') as $insurance)
                @include('ir.reports.irr9040.pdf._header')
                @include('ir.reports.irr9040.pdf._table', ['vehicles' => $insurance])
                <div class="page-break"></div>
            @endforeach
        @endforeach
    </body>
</html>




{{-- @foreach ($ptirStockHeader as $header) --}}
