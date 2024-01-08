<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <title>{{ $programCode_Output }} - {{ $progTitle }}</title> --}}
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        {{-- @include('ir.reports.irr2010.new._style') --}}
        @include('ir.reports._style')
    </head>
    <body>
        @if ($splitCompany || $company)
            @include('ir.reports.irr2010.new.company.index')
        @else
            @foreach ($ptirStockHeaders as $policySetDes =>  $ptirStockHeader)
                @if ($reportType == 'detail')
                    @include('ir.reports.irr2010.new._table', ['policySetDes' => $policySetDes])
                @else
                    @include('ir.reports.irr2010.new._table_sum', ['policySetDes' => $policySetDes])
                @endif
                <div class="page-break"></div>
            @endforeach
        @endif
    </body>
</html>
