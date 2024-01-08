<html>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <body style="font-family: 'CordiaUPC'">

        @foreach($reportProductGroupItems as $pgIndex => $reportProductGroupItem)

            <?php 
                
                $filteredReportItems = [];
                foreach($reportItems as $reportItem) {
                    if($reportItem->product_group == $reportProductGroupItem["product_group"] && $reportItem->product_item_number == $reportProductGroupItem["product_item_number"]) {
                        $filteredReportItems[] = $reportItem;
                    }
                }

            ?>

            @include('ct.reports.ctr0024._header')

            @include('ct.reports.ctr0024._table')

        @endforeach
        
        <div class="page-break"></div>

    </body>

</html>
