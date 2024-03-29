<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ir.reports._style')
    </head>

    </head>
    <body>

        @foreach ($ptirStockHeaders as $policySetDes =>  $ptirStockHeader)
            @foreach ($ptirPolicyGroupDists->groupBy('company_id') as $companyId => $ptirPolicyGroupDist)
                {{-- @include('ir.reports.irr2010.pdf.company._header') --}}
                @if ($reportType == 'detail')
                    @include('ir.reports.irr2010.pdf.company._table', ['policySetDes' => $policySetDes])
                @else
                    @include('ir.reports.irr2010.pdf.company._table_sum', ['policySetDes' => $policySetDes])
                @endif
                {{-- @include('ir.reports.irr2010.pdf.company._table', ['policySetDes' => $policySetDes]) --}}
                <div class="page-break"></div>
            @endforeach
        @endforeach
    </body>
</html>




{{-- @foreach ($ptirStockHeader as $header) --}}
