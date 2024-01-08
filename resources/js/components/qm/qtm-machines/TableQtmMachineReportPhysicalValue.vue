<template>

    <div class="tw-py-2">
        
        <div class="table-responsive">

            <table class="table table-bordered table-sticky mb-0">
                
                <thead>
                    <tr>
                        <th width="10%" class="text-center"> หมายเลขเครื่อง </th>
                        <th width="10%" class="text-center"> ตรวจสอบทั้งหมด (รายการ) </th>
                        <th width="10%" class="text-center"> อยู่ในเกณฑ์ (รายการ) </th>
                        <th width="10%" class="text-center"> อยู่ในเกณฑ์ (%) </th>
                        <th width="10%" class="text-center"> ต่ำกว่าเกณฑ์ (รายการ) </th>
                        <th width="10%" class="text-center"> สูงกว่าเกณฑ์ (รายการ) </th>
                        <th width="10%" class="text-center"> ค่าเฉลี่ย </th>
                        <th width="10%" class="text-center"> ค่ามัธยฐาน </th>
                        <th width="10%" class="text-center"> ค่าเบี่ยงเบนมาตรฐาน </th>
                        <th width="10%" class="text-center"> ค่าความแปรปรวน </th>
                    </tr>
                </thead>
                <tbody v-if="reportItems.length > 0">

                    <template v-for="(reportItem, index) in reportItems">

                        <tr :key="`${index}`" clsss="tw-text-xs">

                            <td class="text-center"> {{ reportItem.machine_set }} </td>
                            <td class="text-center"> {{ reportItem.count_items }} </td>
                            <td class="text-center"> {{ reportItem.count_normal_items }} </td>
                            <td class="text-center"> {{ reportItem.percent_normal_items ? Number(reportItem.percent_normal_items).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) + "%" : "0%"  }} </td>
                            <td class="text-center"> {{ reportItem.count_lower_items }} </td>
                            <td class="text-center"> {{ reportItem.count_higher_items }} </td>
                            <td v-if="reportType == 'WEIGHT'" class="text-right"> {{ reportItem.avg_result_value ? Number(reportItem.avg_result_value).toLocaleString(undefined, {minimumFractionDigits: 4,maximumFractionDigits: 4}) : (reportItem.count_items > 0 ? "0.0000" : "-")  }} </td>
                            <td v-else class="text-right"> {{ reportItem.avg_result_value ? Number(reportItem.avg_result_value).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : (reportItem.count_items > 0 ? "0.00" : "-")  }} </td>
                            <td v-if="reportType == 'WEIGHT'" class="text-right"> {{ reportItem.median_result_value ? Number(reportItem.median_result_value).toLocaleString(undefined, {minimumFractionDigits: 4,maximumFractionDigits: 4}) : (reportItem.count_items > 0 ? "0.0000" : "-")  }} </td>
                            <td v-else class="text-right"> {{ reportItem.median_result_value ? Number(reportItem.median_result_value).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : (reportItem.count_items > 0 ? "0.00" : "-")  }} </td>
                            <td class="text-right"> {{ reportItem.sd_result_value ? Number(reportItem.sd_result_value).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}) : (reportItem.count_items > 0 ? "0.000" : "-")  }} </td>
                            <td class="text-right"> {{ reportItem.variance_result_value ? Number(reportItem.variance_result_value).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}) : (reportItem.count_items > 0 ? "0.000" : "-")  }} </td>

                        </tr>

                    </template>

                    <tr clsss="tw-text-xs">

                        <td class="text-center"> รวมทั้งหมด </td>
                        <td class="text-center"> {{ reportSummary.count_items }} </td>
                        <td class="text-center"> {{ reportSummary.count_normal_items }} </td>
                        <td class="text-center"> {{ reportSummary.percent_normal_items ? Number(reportSummary.percent_normal_items).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) + "%" : "0%"  }} </td>
                        <td class="text-center"> {{ reportSummary.count_lower_items }} </td>
                        <td class="text-center"> {{ reportSummary.count_higher_items }} </td>
                        <td v-if="reportType == 'WEIGHT'" class="text-right"> {{ reportSummary.avg_result_value ? Number(reportSummary.avg_result_value).toLocaleString(undefined, {minimumFractionDigits: 4,maximumFractionDigits: 4}) : (reportSummary.count_items > 0 ? "0.0000" : "-")  }} </td>
                        <td v-else class="text-right"> {{ reportSummary.avg_result_value ? Number(reportSummary.avg_result_value).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : (reportSummary.count_items > 0 ? "0.00" : "-")  }} </td>
                        <td v-if="reportType == 'WEIGHT'" class="text-right"> {{ reportSummary.median_result_value ? Number(reportSummary.median_result_value).toLocaleString(undefined, {minimumFractionDigits: 4,maximumFractionDigits: 4}) : (reportSummary.count_items > 0 ? "0.0000" : "-")  }} </td>
                        <td v-else class="text-right"> {{ reportSummary.median_result_value ? Number(reportSummary.median_result_value).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : (reportSummary.count_items > 0 ? "0.00" : "-")  }} </td>
                        <td class="text-right"> {{ reportSummary.sd_result_value ? Number(reportSummary.sd_result_value).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}) : (reportSummary.count_items > 0 ? "0.000" : "-")  }} </td>
                        <td class="text-right"> {{ reportSummary.variance_result_value ? Number(reportSummary.variance_result_value).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}) : (reportSummary.count_items > 0 ? "0.000" : "-")  }} </td>

                    </tr>

                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="10">
                            <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                        </td>
                    </tr>
                </tbody>
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
        "reportType",
        "reportItems",
        "reportSummary"
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
