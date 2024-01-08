<template>

    <div class="table-responsive">
        <table class="table table-bordered tw-text-xs" style="min-width: 1400px;">
            <thead>
                <tr>
                    <th style="min-width: 70px;" width="10%" class="text-center"> จุดตรวจสอบ </th>
                    <th style="min-width: 200px;" width="20%" class="text-center"> ชื่อจุดตรวจสอบ </th>
                    <th style="min-width: 80px;" width="10%" class="text-center"> กลุ่มงาน </th>
                    <th style="min-width: 80px;" width="10%" class="text-center"> ค่ามาตรฐานความชื้น </th>
                    <th style="min-width: 80px;" width="10%" class="text-center"> วันที่ </th>
                    <th style="min-width: 40px;" width="5%" class="text-center"> เวลา </th>
                    <th style="min-width: 70px;" width="10%" class="text-center"> ตรา/ชุด </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> ค่าความชื้นจากหัววัด </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> ค่าความชื้นจากห้องปฏิบัติการ </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> ค่าความแตกต่าง </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> เปอร์เซนต์ความแตกต่าง </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> ค่าความพอง </th>
                </tr>
            </thead>
            <tbody v-if="reportItems.length > 0">
                <template v-for="(reportItem, index) in reportItems">
                    <tr :key="index" clsss="tw-text-xs">
                        <td class="text-center">
                            {{ reportItem.location_desc }}
                        </td>
                        <td class="text-left">
                            {{ reportItem.locator_desc }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.qm_group }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.moist_sensor_min_value }} - {{ reportItem.moist_sensor_max_value }}
                        </td>
                        <td class="text-center"> 
                            {{ reportItem.date_drawn_formatted }} 
                        </td>
                        <td class="text-center">
                            {{ reportItem.time_drawn_formatted }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.sample_opt }}
                        </td>
                        <td class="text-center" v-bind:style="{ backgroundColor: reportItem.moist_sensor_result_status == 'LOWER' ? '#aaffaa' : (reportItem.moist_sensor_result_status == 'HIGHER' ? '#ffddaa' : '') }"> 
                            {{ reportItem.moist_sensor_result_value }}
                        </td>
                        <td class="text-center" v-bind:style="{ backgroundColor: reportItem.moist_lab_result_status == 'LOWER' ? '#aaffaa' : (reportItem.moist_lab_result_status == 'HIGHER' ? '#ffddaa' : '') }"> 
                            {{ reportItem.moist_lab_result_value }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.moist_diff_value ? `${reportItem.moist_diff_value.toFixed(2)}` : '' }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.moist_diff_percent ? `${reportItem.moist_diff_percent.toFixed(2)}%` : '' }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.expand_result_value }}
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
    props: ["reportItems"],
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
