<html>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <body style="font-family: 'CordiaUPC'">

        @foreach($reportProductGroupItems as $pgIndex => $reportProductGroupItem)

            <?php 

                $filteredRptProductGroupItemWipSteps = [];
                foreach($reportProductGroupItemWipSteps as $reportProductGroupItemWipStep) {
                    if($reportProductGroupItemWipStep["product_group"] == $reportProductGroupItem["product_group"] && $reportProductGroupItemWipStep["product_item_number"] == $reportProductGroupItem["product_item_number"]) {
                        $filteredRptProductGroupItemWipSteps[] = $reportProductGroupItemWipStep;
                    }
                }

                $filteredRptProductGroupItemCategories = [];
                foreach($reportProductGroupItemCategories as $reportProductGroupItemCategory) {
                    if($reportProductGroupItemCategory["product_group"] == $reportProductGroupItem["product_group"] && $reportProductGroupItemCategory["product_item_number"] == $reportProductGroupItem["product_item_number"]) {
                        $filteredRptProductGroupItemCategories[] = $reportProductGroupItemCategory;
                    }
                }
                
                $filteredReportItems = [];
                foreach($reportItems as $reportItem) {
                    if($reportItem["product_group"] == $reportProductGroupItem["product_group"] && $reportItem["product_item_number"] == $reportProductGroupItem["product_item_number"]) {
                        $filteredReportItems[] = $reportItem;
                    }
                }

            ?>

            @include('ct.reports.ctr0023._header')

            @include('ct.reports.ctr0023._table')

        @endforeach
        
        <div class="page-break"></div>

    </body>

</html>
