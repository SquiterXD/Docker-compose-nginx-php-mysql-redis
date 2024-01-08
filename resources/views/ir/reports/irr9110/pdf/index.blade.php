<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ir.reports._style')
    </head>

    </head>
    <body>
        @foreach ($expenseCarGas->groupBy('period_name') as $element)
            @foreach ($element->groupBy('renew_type') as $renewType)
                @foreach ($renewType->groupBy('group_desc') as $group)
                    @include('ir.reports.irr9110.pdf._header')
                     @include('ir.reports.irr9110.pdf._table', ['expenseCarGas' => $group])
                    <div class="page-break"></div>
                @endforeach
            @endforeach
           
           
            <div class="page-break"></div>
        @endforeach
    </body>
</html>




{{-- @foreach ($ptirStockHeader as $header) --}}
