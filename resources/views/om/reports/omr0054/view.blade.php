<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports._style')
    <style>
        .page-break { page-break-after: always; }
    </style>
    </head>
    <body>

    @php $count = 0;@endphp
    @foreach ($datas as $dd)
        @php $count++ @endphp
        <div class="container {{ (count($datas)-1 >= $count) ? 'page-break' : '' }}">
            @component('om.reports.omr0054.pdf.index',$dd)
            @endcomponent
        </div>
    @endforeach

    </body>
</html>
