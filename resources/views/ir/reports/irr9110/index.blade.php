{{-- <!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        
    {{-- </head>

    </head>
    <body>

        @foreach ($expenseCarGas as $element)
            @include('ir.reports.irr9110._header')
            @include('ir.reports.irr9110._table')
            <div class="page-break"></div>
        @endforeach --}} 
    {{-- </body>
</html> --}} 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
@include('ir.reports._style')




@foreach ($expenseCarGas as $element)
@include('ir.reports.irr9110._header')
@include('ir.reports.irr9110._table')
<div class="page-break"></div>
@endforeach




{{-- @foreach ($ptirStockHeader as $header) --}}
