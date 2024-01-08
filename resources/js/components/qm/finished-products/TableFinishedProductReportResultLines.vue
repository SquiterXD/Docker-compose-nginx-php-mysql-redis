<template>

    <div class="table-responsive">
        <table class="table table-bordered tw-text-xs" style="min-width: 2400px;">
            <thead>
                <tr>
                    <th style="min-width: 50px;" width="5%" class="text-center"> รายการ </th>
                    <th style="min-width: 180px;" width="10%" class="text-center"> เลขที่การตรวจสอบ </th>
                    <th style="min-width: 80px;" width="10%" class="text-center"> ลำดับ </th>
                    <th style="min-width: 80px;" width="10%" class="text-center"> วันที่ </th>
                    <th style="min-width: 40px;" width="5%" class="text-center"> เวลา </th>
                    <th style="min-width: 40px;" width="5%" class="text-center"> หมายเลขเครื่อง </th>
                    <th style="min-width: 40px;" width="5%" class="text-center"> เขตตรวจคุณภาพ </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> ประเภทเครื่อง </th>
                    <th style="min-width: 70px;" width="5%" class="text-center"> รหัสตราบุหรี่ </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> ตราบุหรี่ </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> รหัสปัญหา </th>
                    <th style="min-width: 200px;" width="12%" class="text-center"> รายละเอียดปัญหา/ข้อบกพร่อง </th>
                    <th style="min-width: 60px;" width="5%" class="text-center"> หน่วยนับ </th>
                    <th style="min-width: 60px;" width="7%" class="text-center"> จำนวน </th>
                    <th style="min-width: 200px;" width="12%" class="text-center"> สถานที่พบ </th>
                    <th style="min-width: 60px;" width="10%" class="text-center"> ความรุนแรง </th>
                    <th style="min-width: 60px;" width="10%" class="text-center"> คลังกระบวนการ </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> กระบวนการตรวจคุณภาพ </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> รายการตรวจคุณภาพ </th>
                    <th style="min-width: 60px;" width="10%" class="text-center"> ขนาดบุหรี่ </th>
                    <th style="min-width: 60px;" width="10%" class="text-center"> ขั้นตอน </th>
                    <th style="min-width: 100px;" width="10%" class="text-center"> เครื่องจักร </th>
                    <th width="5%" style="min-width: 80px;" class="text-center"> ผลการตรวจ </th>
                    <th width="7%" style="min-width: 80px;" class="text-center"> ตามข้อกำหนด </th>
                    <th v-if="showInputPerson == 'SHOW'" width="5%" style="min-width: 80px;" class="text-center"> ผู้บันทึก </th>
                    <th width="7%" style="min-width: 80px;" class="text-center"> สถานะการลงผล </th>
                    <th width="7%" style="min-width: 80px;" class="text-center"> สถานะการทดสอบ </th>
                    <th width="7%" style="min-width: 100px;" class="text-center"> สถานะการอนุมัติ-Operator </th>
                    <th width="7%" style="min-width: 100px;" class="text-center"> สถานะการอนุมัติ-Supervisor </th>
                    <th width="7%" style="min-width: 100px;" class="text-center"> สถานะการอนุมัติ-Leader </th>
                </tr>
            </thead>
            <tbody v-if="reportItems.length > 0">
                <template v-for="(reportItem, index) in reportItems">
                    <tr :key="index" clsss="tw-text-xs">
                        <td class="text-center"> {{ index+1 }} </td>
                        <td class="text-center">
                            {{ reportItem.sample_no }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.result.seq }}
                        </td>
                        <td class="text-center"> 
                            {{ reportItem.date_drawn_formatted }} 
                        </td>
                        <td class="text-center">
                            <!-- {{ reportItem.time_drawn_formatted }} -->
                            {{ reportItem.sample_result_test_time }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.machine_set }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.qc_area }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.qc_process_machine_type_desc }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.brand_item_number }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.brand_desc }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.result.test_code }}
                        </td>
                        <td>
                            {{ reportItem.result.test_desc }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.result.test_unit_desc }}
                        </td>
                        <td class="text-center">
                            {{ (reportItem.result.result_value != null) ? parseFloat(reportItem.result.result_value) : '' }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.locator_desc }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.test_serverity_code ? reportItem.test_serverity_code : "-" }}
                        </td>
                        <td class="text-center"> {{ reportItem.result.qc_production_process }} </td>
                        <td class="text-center"> {{ reportItem.result.qm_process }} </td>
                        <td class="text-center"> {{ reportItem.result.check_list }} </td>
                        <td class="text-center"> {{ reportItem.brand_category_name }} </td>
                        <td class="text-center"> {{ reportItem.operation_class_code }} </td>
                        <td class="text-center"> {{ reportItem.eam_asset_description }} </td>
                        <td class="text-center"> {{ reportItem.result_status_label }} </td>
                        <td class="text-center"> {{ reportItem.quality_status_label }} </td>
                        <td v-if="showInputPerson == 'SHOW'" class="text-center"> {{ reportItem.result_created_by_username }} </td>
                        <td class="text-center"> {{ reportItem.sample_operation_status_desc }} </td>
                        <td class="text-center"> {{ reportItem.sample_result_status_desc }} </td>
                        <td class="text-center"> {{ reportItem.o_approval_status_label ? reportItem.o_approval_status_label : "-" }} </td>
                        <td class="text-center"> {{ reportItem.s_approval_status_label ? reportItem.s_approval_status_label : "-" }} </td>
                        <td class="text-center"> {{ reportItem.l_approval_status_label ? reportItem.l_approval_status_label : "-" }} </td>
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
    props: ["reportItems", "showInputPerson"],
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
