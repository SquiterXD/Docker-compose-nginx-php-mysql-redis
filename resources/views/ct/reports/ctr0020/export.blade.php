<html>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <body style="font-family: 'CordiaUPC'">

        @foreach($allocateGroupCodes as $agcIndex => $allocateGroupCode)

            <?php 
                $filteredTargetCodes = [];
                foreach($agcTargetCodes as $agcTargetCode) {
                    if($agcTargetCode["allocate_group_code"] == $allocateGroupCode["allocate_group_code"]) {
                        $filteredTargetCodes[] = $agcTargetCode;
                    }
                }

                $filteredAgcAccountTypes = [];
                foreach($agcAccountTypes as $agcAccountType) {
                    if($agcAccountType["allocate_group_code"] == $allocateGroupCode["allocate_group_code"]) {
                        $filteredAgcAccountTypes[] = $agcAccountType;
                    }
                }

                $filteredReportItems = [];
                foreach($reportItems as $reportItem) {
                    if($reportItem["allocate_group_code"] == $allocateGroupCode["allocate_group_code"]) {
                        $filteredReportItems[] = $reportItem;
                    }
                }

                $filteredTargetAccountCodes = [];
                foreach($agcTargetAccountCodes as $agcTargetAccountCode) {
                    if($agcTargetAccountCode["allocate_group_code"] == $allocateGroupCode["allocate_group_code"]) {
                        $filteredTargetAccountCodes[] = $agcTargetAccountCode;
                    }
                }

                $filteredReportAccountItems = [];
                foreach($reportAccountItems as $reportAccountItem) {
                    if($reportAccountItem["allocate_group_code"] == $allocateGroupCode["allocate_group_code"]) {
                        $filteredReportAccountItems[] = $reportAccountItem;
                    }
                }

            ?>

            @include('ct.reports.ctr0020._header')

            @include('ct.reports.ctr0020._table')

        @endforeach
        
        <div class="page-break"></div>

    </body>

</html>
