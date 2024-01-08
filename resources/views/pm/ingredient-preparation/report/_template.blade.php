{{-- {{dd($data, $planDate)}} --}}

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('pm.ingredient-preparation.report._style')
    </head>

    <body>

        <div class="text-center">
            <h2>
                <div style="margin-bottom: 10px">
                    รายการจัดเตรียมวัตถุดิบ
                </div>
            </h2>
        </div>

        @if ($type == 'summary')
            @include('pm.ingredient-preparation.report._summary')
            <div class="page-break"></div>

            @foreach ($dataLists as $index => $datas)
                @foreach ($datas as $list)
                    <div>
                        @include('pm.ingredient-preparation.report._detail')
                    </div>

                    @if (!$loop->last)
                        <div class="page-break"></div>
                    @endif
                @endforeach
            @endforeach
            
        @endif

        @if ($type == 'detail')
            <div>
                @include('pm.ingredient-preparation.report._detail')
            </div>
        @endif
        
        <script type="text/php">
            if (isset($pdf)) {
                $text = "page {PAGE_NUM} / {PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("Verdana");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width) / 2;
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
        </script>

    </body>
</html>