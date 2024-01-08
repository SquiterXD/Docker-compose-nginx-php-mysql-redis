<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ct.reports.ctr0101._style')
    </head>

    <body>
    @include('ct.reports.ctr0015.excel._header')

    @foreach($dataListHeader as $dataListH)
    <tr>
    <th class="text-right tw-font-bold" colspan="15" 
            style="text-align: right; font-size: 12px;">
            หน่วยนับ : {{ $dataListH->cost_uom_code }}
        </th>
    </tr>
        @include('ct.reports.ctr0015.excel._table')
        
        {{-- <div class="page-break"></div> --}}
        @endforeach
    </body>
</html>
