<template>

    <div class="table-responsive">
        <table class="table table-bordered tw-text-xs" style="min-width: 1400px;">
            <thead>
                <tr>
                    <th rowspan="3" style="min-width: 80px;" width="10%" class="text-center"> วันที่ </th>
                    <th rowspan="3" style="min-width: 40px;" width="5%" class="text-center"> เวลา </th>
                    <th rowspan="3" style="min-width: 100px;" width="10%" class="text-center"> จุดตรวจสอบ </th>
                    <th rowspan="3" style="min-width: 100px;" width="10%" class="text-center"> ตรา/ชุด </th>
                    <th colspan="2" width="10%" class="text-center"> ค่ามาตรฐาน {{ reportHeaderItem.MOIST_SILO_SENSOR.min_value }} - {{ reportHeaderItem.MOIST_SILO_SENSOR.max_value }} % </th>
                    <th width="10%" class="text-center"> ค่ามาตรฐาน </th>
                    <th width="10%" class="text-center"> </th>
                    <th colspan="2" width="10%" class="text-center"> ค่ามาตรฐาน {{ reportHeaderItem.MOIST_CIG_LAB.min_value }} - {{ reportHeaderItem.MOIST_CIG_LAB.max_value }} % </th>
                </tr>
                <tr>
                    <th colspan="2" width="10%" class="text-center"> SPL {{ (reportHeaderItem.MOIST_SILO_SENSOR.spl_min_value) }} - {{ (reportHeaderItem.MOIST_SILO_SENSOR.spl_max_value) }} % </th>
                    <th width="10%" class="text-center"> > {{ reportHeaderItem.EXPAND.min_value }} cc/g </th>
                    <th width="10%" class="text-center"> </th>
                    <th colspan="2" width="10%" class="text-center"> SPL {{ reportHeaderItem.MOIST_CIG_LAB.spl_min_value }} - {{ reportHeaderItem.MOIST_CIG_LAB.spl_max_value }} % </th>
                </tr>
                <tr>
                    <th style="min-width: 100px;" width="10%" class="text-center"> ค่าความชื้นในไซโล </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> ค่าความชื้นจ่ายเครื่องมวน </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> ค่าความพอง </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> หมายเลขเครื่องมวน </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> ค่าความชื้นในมวนบุหรี่ </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> ค่าความชื้นที่จอแสดงผล </th>
                </tr>
            </thead>
            <tbody v-if="reportItems.length > 0">
                <template v-for="(reportItem, index) in reportItems">
                    <tr :key="index" clsss="tw-text-xs">
                        <td class="text-center"> 
                            {{ reportItem.date_drawn_formatted }} 
                        </td>
                        <td class="text-center">
                            {{ reportItem.time_drawn_formatted }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.location_desc }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.sample_opt }}
                        </td>
                        <td class="text-center" v-bind:style="{ backgroundColor: reportItem.moist_silo_sensor_result_status == 'LOWER' ? '#aaffaa' : (reportItem.moist_silo_sensor_result_status == 'HIGHER' ? '#ffddaa' : '') }"> 
                            {{ reportItem.moist_silo_sensor_result_value }}
                        </td>
                        <td class="text-center" v-bind:style="{ backgroundColor: reportItem.moist_silo_lab_result_status == 'LOWER' ? '#aaffaa' : (reportItem.moist_silo_lab_result_status == 'HIGHER' ? '#ffddaa' : '') }"> 
                            {{ reportItem.moist_silo_lab_result_value }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.expand_result_value }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.roll_mc_result_value }}
                        </td>
                        <td class="text-center" v-bind:style="{ backgroundColor: reportItem.moist_cig_lab_result_status == 'LOWER' ? '#aaffaa' : (reportItem.moist_cig_lab_result_status == 'HIGHER' ? '#ffddaa' : '') }"> 
                            {{ reportItem.moist_cig_lab_result_value }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.moist_roll_mc_display_result_value }}
                        </td>
                    </tr>
                </template>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="16">
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

export default {
    props: ["reportItems", "reportHeaderItem"],
    components: { Loading },
    data() {
        return {
            isLoading: false
        };
    },

    methods: {
        
    }

};
</script>
