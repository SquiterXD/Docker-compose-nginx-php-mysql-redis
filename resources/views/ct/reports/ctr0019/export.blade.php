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

                $filteredReportItems = [];
                foreach($reportItems as $reportItem) {
                    if($reportItem["allocate_group_code"] == $allocateGroupCode["allocate_group_code"]) {
                        $filteredReportItems[] = $reportItem;
                    }
                }
            ?>

            @include('ct.reports.ctr0019._header')

            @include('ct.reports.ctr0019._table')

        @endforeach
        
        <div class="page-break"></div>

    </body>

</html>
