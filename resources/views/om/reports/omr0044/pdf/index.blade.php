<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $programCode }} - {{ $progTitle }}</title>
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
    @include('om.reports._style')
</head>
<body>
    @php
        $colspan = 6;
        $count=count($data);

    @endphp
    @if($count>0)
        @foreach ($data->groupBy('cs_customer') as $comp_id => $company)
            @include('om.reports.omr0044.pdf.view')
        @endforeach
    @else
        @php $company=$data; @endphp
        @include('om.reports.omr0044.pdf.view')
    @endif
</body>
</html>

