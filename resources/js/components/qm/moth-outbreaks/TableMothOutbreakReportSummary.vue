<template>

    <div class="table-responsive" style="max-height: 800px;">

        <table class="table table-bordered table-sticky mb-0" style="min-width: 2200px;">
            <thead>
                <tr>
                    <th width="5%" class="text-center"> 
                        ลำดับ 
                    </th>
                    <th width="10%" class="text-center"> 
                        เลขที่การตรวจสอบ 
                    </th>
                    <th width="5%" class="text-center"> 
                        วันที่เก็บตัวอย่าง 
                    </th>
                    <th width="5%" class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                        อาคาร
                    </th>
                    <th width="10%" class="text-center">
                        โซน
                    </th>
                    <th width="5%" class="text-center">
                        จุดตรวจสอบ
                    </th>
                    <th width="10%" class="text-center">
                        รายละเอียดจุดตรวจสอบ
                    </th>
                    <th width="5%" class="text-center">
                        รหัสการทดสอบ
                    </th>
                    <th width="10%" class="text-center">
                        ชื่อการทดสอบ
                    </th>
                    <th width="5%" class="text-center">
                        หน่วยทดสอบ
                    </th>
                    <th width="5%" class="text-center">
                        ผลการทดสอบ
                    </th>
                    <th width="5%" class="text-center">
                        ค่าควบคุม-Min
                    </th>
                    <th width="5%" class="text-center">
                        ค่าควบคุม-Max
                    </th>
                    <th width="13%" class="text-center">
                        สถานะการตรวจสอบ
                    </th>
                    <th width="12%" class="text-center">
                        สถานะการอนุมัติ-Supervisor
                    </th>
                    <th width="12%" class="text-center">
                        สถานะการอนุมัติ-Leader
                    </th>
                </tr>
            </thead>
            <tbody v-if="reportItems.length > 0">
                <template v-for="(reportItem, index) in reportItems">
                    <tr :key="index" clsss="tw-text-xs">
                        <td class="text-center"> 
                            {{ index+1 }} 
                        </td>
                        <td class="text-center"> 
                            {{ reportItem.sample_no }} 
                        </td>
                        <td class="text-center">
                            {{ reportItem.date_drawn_formatted }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ reportItem.build_name }} 
                        </td>
                        <td class="text-center">
                            {{ reportItem.department_name }} 
                        </td>
                        <td class="text-center">
                            {{ reportItem.location_desc }} 
                        </td>
                        <td class="text-center">
                            {{ reportItem.locator_desc }} 
                        </td>
                        <td class="text-center">
                            {{ reportItem.result.test_code }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.result.test_desc }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.result.test_unit }}
                        </td>
                        <td class="text-center">
                            {{ (reportItem.result.result_value != null) ? parseFloat(reportItem.result.result_value) : '' }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.result.min_value ? parseFloat(reportItem.result.min_value) : '' }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.result.max_value ? parseFloat(reportItem.result.max_value) : '' }}
                        </td>
                        <td class="text-center">
                            <!-- {{ reportItem.result_status_label }} -->
                            {{ reportItem.sample_operation_status_desc }} {{ reportItem.sample_result_status_desc }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.s_approval_status_label }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.l_approval_status_label }}
                        </td>
                    </tr>
                </template>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="15">
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
            is_loading: false
        };
    },

    methods: {
        
    }

};
</script>
