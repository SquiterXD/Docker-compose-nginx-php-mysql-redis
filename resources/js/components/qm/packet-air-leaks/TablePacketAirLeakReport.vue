<template>

    <div class="table-responsive">

        <table class="table table-bordered" style="min-width: 2400px;">
            <thead>
                <tr>
                    <th width="9%" class="text-center"> เลขที่การตรวจสอบ </th>
                    <th width="4%" class="text-center"> วันที่บันทึก </th>
                    <th width="2%" class="text-center"> เวลา </th>
                    <th width="4%" class="text-center"> หมายเลขเครื่อง </th>
                    <th width="5%" class="text-center"> ประเภทเครื่อง </th>
                    <th width="3%" class="text-center"> รหัสตราบุหรี่ </th>
                    <th width="5%" class="text-center"> ตราบุหรี่ </th>
                    <th width="3%" class="text-center"> หน่วยวัด </th>
                    <th width="5%" class="text-center"> อัตราลมรั่ว </th>
                    <th width="3%" class="text-center"> ซองที่ </th>
                    <th width="5%" class="text-center"> ตำแหน่งที่รั่ว </th>
                    <th width="3%" class="text-center"> ตัวย่อ </th>
                    <th width="5%" class="text-center"> ขนาดบุหรี่ </th>
                    <th width="6%" class="text-center"> เครื่องจักร </th>
                    <th width="3%" class="text-center"> เขตตรวจคุณภาพ </th>
                    <th width="5%" class="text-center"> ผลการตรวจ </th>
                    <th width="7%" class="text-center"> ตามข้อกำหนด </th>
                    <!-- <th width="9%" style="min-width: 200px;" class="text-center"> สถานะการตรวจสอบ </th> -->
                    <th width="7%" style="min-width: 100px;" class="text-center"> สถานะการลงผล </th>
                    <th width="7%" style="min-width: 100px;" class="text-center"> สถานะการทดสอบ </th>
                    <th width="7%" style="min-width: 100px;" class="text-center"> สถานะการอนุมัติ-Operator </th>
                    <th width="7%" style="min-width: 100px;" class="text-center"> สถานะการอนุมัติ-Supervisor </th>
                    <th width="7%" style="min-width: 100px;" class="text-center"> สถานะการอนุมัติ-Leader </th>
                </tr>
            </thead>

            <tbody v-if="reportItems.length > 0">

                <template v-for="(reportItem, index) in reportItems">

                    <tr :key="`${index}`">

                        <td class="text-left"> {{ reportItem.sample_no }} </td>
                        <td class="text-center" v-bind:style="{ backgroundColor: reportItem.result_status == 'FAILED' ? '#fff0a0' : '' }"> 
                            {{ reportItem.date_drawn_formatted ? reportItem.date_drawn_formatted : "-" }} 
                        </td>
                        <td class="text-center"> {{ reportItem.time_drawn_formatted ? reportItem.time_drawn_formatted : "-" }} </td>
                        <td class="text-center"> {{ reportItem.machine_set ? reportItem.machine_set : "-" }} </td>
                        <td class="text-center"> {{ reportItem.machine_type_desc ? reportItem.machine_type_desc : "-" }} </td>
                        <td class="text-center"> {{ reportItem.brand_item_number ? reportItem.brand_item_number : "-" }} </td>
                        <td class="text-center"> {{ reportItem.brand_desc ? reportItem.brand_desc : "-" }} </td>
                        <td class="text-center"> {{ reportItem.test_unit ? reportItem.test_unit : "-" }} </td>
                        <td class="text-right"> {{ reportItem.result_value ? reportItem.result_value : "-" }} </td>
                        <td class="text-center"> {{ reportItem.group_no ? reportItem.group_no : "-" }} </td>
                        <td class="text-center"> {{ reportItem.position_leak_desc ? reportItem.position_leak_desc : "-" }} </td>
                        <td class="text-center"> {{ reportItem.position_leak_short_desc ? reportItem.position_leak_short_desc : "-" }} </td>
                        <td class="text-center"> {{ reportItem.brand_category_name ? reportItem.brand_category_name : "-" }} </td>
                        <td class="text-center"> {{ reportItem.eam_asset_description ? reportItem.eam_asset_description : "-" }} </td>
                        <td class="text-center"> {{ reportItem.qc_area }} </td>
                        <td class="text-center"> {{ reportItem.result_status_label }} </td>
                        <td class="text-center"> {{ reportItem.quality_status_label }} </td>
                        <!-- <td class="text-center"> {{ reportItem.sample_disposition_desc }} </td> -->
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
                    <td colspan="21">
                        <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                    </td>
                </tr>
            </tbody>

        </table>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

// Import loading-overlay component
import Loading from "vue-loading-overlay";

export default {
    props: ["reportItems", "reportItemByDates"],
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
