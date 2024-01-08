<template>

    <div class="tw-py-2">
        
        <div class="table-responsive">

            <table class="table table-bordered table-sticky mb-0">
                
                <thead>
                    <tr>
                        <th rowspan="2" width="15%" class="text-center"> หมายเลขเครื่อง </th>
                        <th colspan="2" width="12%" class="text-center"> QTM_Weight </th>
                        <th colspan="2" width="12%" class="text-center"> QTM_SizeL </th>
                        <th colspan="2" width="12%" class="text-center"> QTM_PD Open </th>
                        <th v-if="taskTypeCode == '200'" colspan="2" width="12%" class="text-center"> QTM_Tip Vent </th>
                        <th rowspan="2" width="8%" class="text-center"> จำนวนรวม </th>
                        <th rowspan="2" width="8%" class="text-center"> เปอร์เซ็นต์รวม </th>
                    </tr>
                    <tr>
                        <th width="6%" class="text-center"> จำนวนรายการ </th>
                        <th width="6%" class="text-center"> เปอร์เซ็นต์ </th>
                        <th width="6%" class="text-center"> จำนวนรายการ </th>
                        <th width="6%" class="text-center"> เปอร์เซ็นต์ </th>
                        <th width="6%" class="text-center"> จำนวนรายการ </th>
                        <th width="6%" class="text-center"> เปอร์เซ็นต์ </th>
                        <th v-if="taskTypeCode == '200'" width="6%" class="text-center"> จำนวนรายการ </th>
                        <th v-if="taskTypeCode == '200'" width="6%" class="text-center"> เปอร์เซ็นต์ </th>
                    </tr>
                </thead>
                <tbody v-if="reportItems.length > 0">

                    <template v-for="(reportItem, index) in reportItems">

                        <tr v-if="Number(reportItem.count_items) > 0" :key="`${index}`" clsss="tw-text-xs">

                            <td class="text-center"> {{ reportItem.MACHINE_DATA.machine_set }} </td>

                            <td class="text-center"> {{ reportItem.WEIGHT.count_items }} </td>
                            <td class="text-center"> {{ reportItem.WEIGHT.percent_failed_items ? Number(reportItem.WEIGHT.percent_failed_items).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) + "%" : "0.00%"  }} </td>
                            <td class="text-center"> {{ reportItem.SIZEL.count_items }} </td>
                            <td class="text-center"> {{ reportItem.SIZEL.percent_failed_items ? Number(reportItem.SIZEL.percent_failed_items).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) + "%" : "0.00%"  }} </td>
                            <td class="text-center"> {{ reportItem.PDOPEN.count_items }} </td>
                            <td class="text-center"> {{ reportItem.PDOPEN.percent_failed_items ? Number(reportItem.PDOPEN.percent_failed_items).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) + "%" : "0.00%"  }} </td>
                            <td v-if="taskTypeCode == '200'" class="text-center"> {{ reportItem.TIPVENT.count_items }} </td>
                            <td v-if="taskTypeCode == '200'" class="text-center"> {{ reportItem.TIPVENT.percent_failed_items ? Number(reportItem.TIPVENT.percent_failed_items).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) + "%" : "0.00%"  }} </td>
                            
                            <td class="text-center"> {{ reportItem.count_items }} </td>
                            <td class="text-center"> {{ Number((Number(reportItem.WEIGHT.percent_failed_items) + Number(reportItem.SIZEL.percent_failed_items) + Number(reportItem.PDOPEN.percent_failed_items) + Number(reportItem.TIPVENT.percent_failed_items))).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) + "%" }} </td>

                        </tr>

                    </template>

                    <tr v-if="Number(reportSummarized.count_items) > 0" clsss="tw-text-xs">

                        <td class="text-center"> รวมทั้งหมด </td>

                        <td class="text-center"> {{ reportSummarized.WEIGHT.count_items }} </td>
                        <td class="text-center"> {{ reportSummarized.WEIGHT.percent_failed_items ? Number(reportSummarized.WEIGHT.percent_failed_items).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) + "%" : "0.00%"  }} </td>
                        <td class="text-center"> {{ reportSummarized.SIZEL.count_items }} </td>
                        <td class="text-center"> {{ reportSummarized.SIZEL.percent_failed_items ? Number(reportSummarized.SIZEL.percent_failed_items).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) + "%" : "0.00%"  }} </td>
                        <td class="text-center"> {{ reportSummarized.PDOPEN.count_items }} </td>
                        <td class="text-center"> {{ reportSummarized.PDOPEN.percent_failed_items ? Number(reportSummarized.PDOPEN.percent_failed_items).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) + "%" : "0.00%"  }} </td>
                        <td v-if="taskTypeCode == '200'" class="text-center"> {{ reportSummarized.TIPVENT.count_items }} </td>
                        <td v-if="taskTypeCode == '200'" class="text-center"> {{ reportSummarized.TIPVENT.percent_failed_items ? Number(reportSummarized.TIPVENT.percent_failed_items).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) + "%" : "0.00%"  }} </td>

                        <td class="text-center"> {{ reportSummarized.count_items }} </td>
                        <td class="text-center"> 100.00% </td>

                    </tr>
                    <tr v-else>
                        <td colspan="12">
                            <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                        </td>
                    </tr>
                </tbody>
                <!-- <tbody v-else>
                    <tr>
                        <td colspan="12">
                            <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                        </td>
                    </tr>
                </tbody> -->
            </table>
        </div>
        
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
        "reportItems",
        "reportSummarized"
    ],

    components: {
        Loading
    },

    data() {
        return {
            
        };
    },

    methods: {}
};
</script>
