<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ct.reports.ctr0101._style')
    </head>

    <body>
    <table>
            <thead>
              
            <tr  >
                <th style="text-align: center; vertical-align: middle;">ปี</th>
                <th style="text-align: center; vertical-align: middle;">เดือน</th>
                <th style="text-align: left; vertical-align: middle;">ชื่อสินค้า</th>
                <th style="text-align: left; vertical-align: middle;">จำนวน</th>
            </tr>
        </thead>
        <tbody>
        

        @foreach($data as $dataListH=>$dataListHs )

        @php
                   //dd($dataListH,$dataListHs);         
            @endphp

                <tr >
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$dataListHs->year}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$dataListHs->month}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: lEFT;">{{$dataListHs->description}}</td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;text-align: right;">{{$dataListHs->count}}</td>

                </tr>
                @endforeach
                </tbody>
           

    </table>
    </body>
</html>
