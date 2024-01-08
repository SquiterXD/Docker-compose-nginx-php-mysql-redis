<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        @include('ct.reports.ctr0024._style')
    </head>

    <body>

        @foreach($reportProductGroupItems as $pgIndex => $reportProductGroupItem)

            <?php 
                
                $filteredReportItems = [];
                foreach($reportItems as $reportItem) {
                    if($reportItem->product_group == $reportProductGroupItem["product_group"] && $reportItem->product_item_number == $reportProductGroupItem["product_item_number"]) {
                        $filteredReportItems[] = $reportItem;
                    }
                }

            ?>

            @include('ct.reports.ctr0024._header_pdf')

            @include('ct.reports.ctr0024._table_pdf')

            <div class="page-break"></div>

        @endforeach

    </body>

</html>
