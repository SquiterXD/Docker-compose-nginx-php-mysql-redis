<template>

    <div class="table-responsive">

        <table class="table table-bordered table-sticky mb-0">
            
            <thead>
                <tr>
                    <th width="7%" class="text-center"> วันที่ </th>
                    <th width="5%" class="text-center"> เวลา </th>
                    <th width="7%" class="text-center"> หมายเลขเครื่อง </th>
                    <th width="10%" class="text-center"> บุหรี่ / ก้นกรอง </th>
                    <th width="10%" class="text-center"> ชื่อการทดสอบ </th>
                    <th width="7%" class="text-center"> ผลการทดสอบ </th>
                    <th width="5%" class="text-center"> หน่วยนับ </th>
                    <th width="7%" class="text-center"> ค่าควบคุม-Min </th>
                    <th width="7%" class="text-center"> ค่าควบคุม-Max </th>
                    <th width="5%" class="text-center"> ผลการตรวจ </th>
                </tr>
            </thead>
            <tbody v-if="reportQuantumNeoItems.length > 0">

                <template v-for="(reportDate, indexD) in reportQuantumNeoItems">

                    <template v-for="(reportDateTime, indexT) in reportDate.report_datetime_items">

                        <template v-for="(reportItem, index) in reportDateTime.report_items">

                            <tr :key="`${indexD}_${indexT}_${index}`"  clsss="tw-text-xs">

                                <td v-if="reportDate.first_sample_no == reportItem.sample_no && reportDate.first_test_code == reportItem.result.test_code" :rowspan="reportDate.count_items" class="text-center" style="vertical-align: top !important;"> 
                                    {{ reportItem.date_drawn_formatted }} 
                                </td>
                                <td v-if="reportDateTime.first_sample_no == reportItem.sample_no && reportDateTime.first_test_code == reportItem.result.test_code" :rowspan="reportDateTime.count_items" class="text-center" style="vertical-align: top !important;">  
                                    {{ reportItem.time_drawn_formatted }} 
                                </td>
                                
                                <td class="text-center"> {{ reportItem.machine_set }} </td>
                                <td class="text-center"> {{ reportItem.brand }} </td>
                                <td class="text-center"> {{ reportItem.result.test_desc }} </td>
                                <td class="text-center"> {{ (reportItem.result.result_value != null) ? parseFloat(reportItem.result.result_value) : '' }} </td>
                                <td class="text-center"> {{ reportItem.result.test_unit }} </td>
                                <td class="text-center"> {{ reportItem.result.min_value ? parseFloat(reportItem.result.min_value) : '' }} </td>
                                <td class="text-center"> {{ reportItem.result.max_value ? parseFloat(reportItem.result.max_value) : '' }} </td>
                                <td class="text-center"> {{ reportItem.result_status_label }}</td>

                            </tr>

                        </template>

                    </template>

                </template>

            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="12">
                        <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                    </td>
                </tr>
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
    props: ["reportDates", "reportDateTimes", "reportItems"],

    components: {
        Loading
    },

    data() {
        return {
            is_loading: false,
            reportQuantumNeoItems: this.reportDates.map(rdItem => {
                const filterDateTimeItems = this.reportDateTimes.filter(rdtItem => rdtItem.date_drawn_formatted == rdItem.date_drawn_formatted);
                const reportDateTimeItems = filterDateTimeItems.map(fdtItem => {
                    const filteredReportItems = this.reportItems.filter(rItem => (rItem.date_drawn_formatted == fdtItem.date_drawn_formatted && rItem.time_drawn_formatted == fdtItem.time_drawn_formatted));
                    return {
                        ...fdtItem,
                        report_items: filteredReportItems
                    };
                });
                return {
                    ...rdItem,
                    report_datetime_items: reportDateTimeItems,
                };
            })
        };
    },

    methods: {
        
    }
};
</script>
