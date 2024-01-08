<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}

        <title>รายงานอัตรามาตรฐานค่าแรงและค่าใช้จ่าย</title>
        @include('ct.reports.ctr0101._style')
    </head>

    <body>
        
        @foreach($dataListHeader as $dataListH)
        @include('ct.reports.ctr0015.pdf._header')
        @include('ct.reports.ctr0015.pdf._table',['dataListH' => $dataListH])
        <div style='page-break-after: always'></div>

        @endforeach
       
    </body>
</html>
