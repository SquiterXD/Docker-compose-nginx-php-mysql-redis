<template>

    <div class="table-responsive">

        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th width="5%" class="text-center"> หมายเลขเครื่อง </th>
                    <th width="5%" class="text-center">เวลา</th>
                    <template v-for="(reportDateTh, indexDTH) in reportDates">
                        <th :key="indexDTH" width="5%" class="text-center tw-text-xs">
                            {{ reportDateTh.date_drawn_formatted }}
                        </th>
                    </template>
                </tr>
            </thead>
            <tbody>
                
                <template v-for="(reportMachineItem, indexMI) in reportMachineItems">
                    
                    <tr :key="indexMI" clsss="tw-text-xs">

                        <td v-if="reportMachineItem.is_first_row" :rowspan="reportMachineItem.count_time_items" class="text-center" style="vertical-align: top !important;"> 
                            {{ reportMachineItem.machine_set }} 
                        </td>
                        <td class="text-center"> {{ reportMachineItem.time_drawn_formatted }} </td>
                        
                        <template v-for="(reportDateTd, indexMITD) in reportDates">
                            <td :key="indexMITD" class="text-center" style="padding: 0px;">
                                <template v-for="(reportMachineItemResult, indexMIRTD) in reportMachineItem.results">
                                    <div style="padding: 8px;" :key="indexMIRTD" v-if="reportMachineItemResult.date_drawn_formatted == reportDateTd.date_drawn_formatted && reportMachineItemResult.time_drawn_formatted == reportMachineItem.time_drawn_formatted && reportMachineItemResult.result_value">
                                        {{ parseFloat(reportMachineItemResult.result_value) }}
                                    </div>
                                </template>
                            </td>
                        </template>

                    </tr>

                </template>

            </tbody>
        </table>

    </div>

</template>

<script>

// Import loading-overlay component
import Loading from "vue-loading-overlay";

// Import loading-overlay stylesheet
import "vue-loading-overlay/dist/vue-loading.css";

export default {
    props: [
        "taskTypeCode",
        "reportDates", 
        "reportMachineItems", 
        // "reportItems"
    ],

    components: {
        Loading
    },

    data() {
        return {};
    },

    methods: {
        
    }
};
</script>
