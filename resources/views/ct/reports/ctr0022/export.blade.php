<html>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <body style="font-family: 'CordiaUPC'; font-size: 14px;">

        @foreach($reportCostCodes as $agcIndex => $reportCostCode)

            <?php 

                $filteredRptCostCodeAccTypes = [];
                foreach($reportCostCodeAccTypes as $reportCostCodeAccType) {
                    if($reportCostCodeAccType["cost_code"] == $reportCostCode["cost_code"]) {
                        $filteredRptCostCodeAccTypes[] = $reportCostCodeAccType;
                    }
                }

                $filteredRptAccountCodes = [];
                foreach($reportAccountCodes as $reportAccountCode) {
                    if($reportAccountCode["cost_code"] == $reportCostCode["cost_code"]) {
                        $filteredRptAccountCodes[] = $reportAccountCode;
                    }
                }

                $filteredRptProductGroups = [];
                foreach($reportProductGroups as $reportProductGroup) {
                    if($reportProductGroup["cost_code"] == $reportCostCode["cost_code"]) {
                       $filteredRptProductGroups[] = $reportProductGroup;
                    }
                }

                $filteredReportItems = [];
                foreach($reportItems as $reportItem) {
                    if($reportItem["cost_code"] == $reportCostCode["cost_code"]) {
                        $filteredReportItems[] = $reportItem;
                    }
                }

                $filteredReportAccountItems = [];
                foreach($reportAccountItems as $reportAccountItem) {
                    if($reportAccountItem["cost_code"] == $reportCostCode["cost_code"]) {
                        $filteredReportAccountItems[] = $reportAccountItem;
                    }
                }

            ?>

            @include('ct.reports.ctr0022._header')

            @include('ct.reports.ctr0022._table')

        @endforeach
        
        <div class="page-break"></div>

    </body>

</html>
