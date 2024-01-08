<html>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <body style="font-family: 'CordiaUPC'">

        @foreach($reportProductGroups as $pgIndex => $reportProductGroup)

            <?php 

                $filteredReportItems = [];
                foreach($reportItems as $reportItem) {
                    if($reportItem->cost_code == $reportProductGroup["cost_code"] && $reportItem->product_group == $reportProductGroup["product_group"]) {
                        $filteredReportItems[] = $reportItem;
                    }
                }

            ?>

            @include('ct.reports.ctr0026._header')

            @include('ct.reports.ctr0026._table')

        @endforeach
        
        <div class="page-break"></div>

    </body>

</html>
