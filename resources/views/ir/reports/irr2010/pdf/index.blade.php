<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ir.reports._style')
        {{-- <link rel="stylesheet" href="{{ asset('css/report.css') }}"> --}}
    </head>

    </head>
    <body>
        @if ($splitCompany || $company)
            @include('ir.reports.irr2010.pdf.company.index')
        @else
            @foreach ($ptirStockHeaders as $policySetDes =>  $ptirStockHeader)
            {{-- {{dd($reportType , $policySetDes) }} --}}
                {{-- @include('ir.reports.irr2010.pdf._header') --}}
                @if ($reportType == 'detail')
                    @include('ir.reports.irr2010.pdf._table', ['policySetDes' => $policySetDes])
                @else
                    @include('ir.reports.irr2010.pdf._table_sum', ['policySetDes' => $policySetDes])
                @endif
                <div class="page-break"></div>

            @endforeach
        @endif
    </body>
</html>



