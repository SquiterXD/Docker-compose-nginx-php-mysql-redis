<template>

    <div class="table-responsive">
        <table class="table table-bordered tw-text-xs" style="min-width: 2000px;">
            <thead>
                <tr>
                    <th style="min-width: 50px;" width="5%" class="text-center"> รายการ </th>
                    <th style="min-width: 80px;" width="8%" class="text-center"> วันที่ </th>
                    <th style="min-width: 40px;" width="5%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> เวลา </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> ตราบุหรี่ </th>
                    <th style="min-width: 200px;" width="12%" class="text-center"> ปัญหา/ข้อบกพร่อง </th>
                    <th style="min-width: 60px;" width="7%" class="text-center"> จำนวน </th>
                    <th style="min-width: 60px;" width="5%" class="text-center"> หน่วยนับ </th>
                    <th style="min-width: 120px;" width="10%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> กระบวนการที่พบ </th>
                    <th style="min-width: 60px;" width="7%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> หมายเลขเครื่อง </th>
                    <th style="min-width: 60px;" width="7%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> เขตตรวจคุณภาพ </th>
                    <th style="min-width: 80px;" width="10%" class="text-center"> ระดับความรุนแรงของความผิดปกติ (อาการ) </th>
                    <th style="min-width: 60px;" width="7%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> สาเหตุ </th>
                    <th style="min-width: 80px;" width="10%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> หมายเหตุ </th>
                    <th style="min-width: 220px;" width="15%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> รูปภาพประกอบ </th>
                    <th style="min-width: 200px;" width="10%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> เลขที่การตรวจสอบ </th>
                </tr>
            </thead>
            <tbody v-if="reportItems.length > 0">
                <template v-for="(reportItem, index) in reportItems">
                    <tr :key="index" clsss="tw-text-xs">
                        <td class="text-center"> {{ index+1 }} </td>
                        <td class="text-center"> 
                            {{ reportItem.date_drawn_formatted }} 
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            <!-- {{ reportItem.time_drawn_formatted }} -->
                            {{ reportItem.sample_result_test_time }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.brand_desc }}
                        </td>
                        <td>
                            {{ reportItem.test_desc }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ (reportItem.result_value != null) ? parseFloat(reportItem.result_value) : '' }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ reportItem.test_unit_desc }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ reportItem.qm_process }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ reportItem.machine_set }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ reportItem.qc_area }}
                        </td>
                        <td class="text-center tw-font-bold" v-bind:style="{ backgroundColor: reportItem.test_serverity_code_color }">
                            {{ reportItem.test_serverity_code ? reportItem.test_serverity_code : "-" }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.causes_of_defects ? reportItem.causes_of_defects : "-" }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ reportItem.remark }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            <a v-if="reportItem.image && reportItem.image_base64" class="tw-m-1" style="height: 100px;"
                                :href="`/qm/files/image/qm/finished-products/result-quality-line/${reportItem.image.file_name}`" 
                                target="_blank">
                                <img :src="reportItem.image_base64.encoded" style="height: 100px;">
                            </a>
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ reportItem.sample_no }}
                        </td>
                    </tr>
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
