<template>

    <div class="table-responsive">
        <table class="table table-bordered tw-text-xs" style="min-width: 2000px;">
            <thead>
                <tr>
                    <th style="min-width: 50px;" width="5%" class="text-center"> ลำดับ </th>
                    <th style="min-width: 80px;" width="10%" class="text-center"> วันที่ </th>
                    <th style="min-width: 40px;" width="5%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> เวลา </th>
                    <th style="min-width: 180px;" width="10%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> เลขที่การตรวจสอบ </th>
                    <th style="min-width: 40px;" width="5%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> หมายเลขเครื่อง </th>
                    <th style="min-width: 40px;" width="5%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> เขตตรวจคุณภาพ </th>
                    <th v-if="showInputPerson == 'SHOW'" style="min-width: 80px;" width="5%" class="text-center"> ผู้บันทึก </th>
                    <th style="min-width: 70px;" width="10%" class="text-center"> รหัสตราบุหรี่ </th>
                    <th style="min-width: 120px;" width="10%" class="text-center"> ตราบุหรี่ </th>
                    <th style="min-width: 60px;" width="7%" class="text-center"> จำนวน </th>
                    <th style="min-width: 60px;" width="5%" class="text-center"> หน่วยนับ </th>

                    <template v-for="(qmProcess, qmIndex) in qmProcesses">
                        <th :key="qmIndex" v-if="qmIndex == 0" style="min-width: 200px;" width="12%" class="text-center"> ข้อบกพร่องพบที่เครื่องมวน </th>
                        <th :key="qmIndex" v-if="qmIndex == 1" style="min-width: 200px;" width="12%" class="text-center"> ข้อบกพร่องพบที่เครื่องบรรจุซอง </th>
                        <th :key="qmIndex" v-if="qmIndex == 2" style="min-width: 200px;" width="12%" class="text-center"> ข้อบกพร่องพบที่เครื่องฟิล์มซอง </th>
                        <th :key="qmIndex" v-if="qmIndex == 3" style="min-width: 200px;" width="12%" class="text-center"> ข้อบกพร่องพบที่เครื่องฟิล์มห่อ </th>
                        <th :key="qmIndex" v-if="qmIndex == 4" style="min-width: 200px;" width="12%" class="text-center"> ข้อบกพร่องพบที่เครื่องบรรจุหีบ </th>
                    </template>
                    
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
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ reportItem.sample_no }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ reportItem.machine_set }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ reportItem.qc_area }}
                        </td>
                        <td v-if="showInputPerson == 'SHOW'" class="text-center"> 
                            {{ reportItem.result_created_by_username }} 
                        </td>
                        <td class="text-center">
                            {{ reportItem.brand_item_number }}
                        </td>
                        <td class="text-center">
                            {{ reportItem.brand_desc }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ (reportItem.result.result_value != null) ? parseFloat(reportItem.result.result_value) : '' }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            {{ reportItem.result.test_unit_desc }}
                        </td>

                        <template v-for="(qmProcess, qmdIndex) in qmProcesses">
                            <th :key="`${qmdIndex}`" v-if="qmdIndex == 0">
                                <span v-if="qmProcess.qm_process_seq == reportItem.result.qm_process_seq" style="min-width: 200px;" width="12%" class="text-center"> {{ reportItem.result.test_desc}} </span>
                            </th>
                            <th :key="`${qmdIndex}`" v-if="qmdIndex == 1">
                                <span v-if="qmProcess.qm_process_seq == reportItem.result.qm_process_seq" style="min-width: 200px;" width="12%" class="text-center"> {{ reportItem.result.test_desc}} </span>
                            </th>
                            <th :key="`${qmdIndex}`" v-if="qmdIndex == 2">
                                <span v-if="qmProcess.qm_process_seq == reportItem.result.qm_process_seq" style="min-width: 200px;" width="12%" class="text-center"> {{ reportItem.result.test_desc}} </span>
                            </th>
                            <th :key="`${qmdIndex}`" v-if="qmdIndex == 3">
                                <span v-if="qmProcess.qm_process_seq == reportItem.result.qm_process_seq" style="min-width: 200px;" width="12%" class="text-center"> {{ reportItem.result.test_desc}} </span>
                            </th>
                            <th :key="`${qmdIndex}`" v-if="qmdIndex == 4">
                                <span v-if="qmProcess.qm_process_seq == reportItem.result.qm_process_seq" style="min-width: 200px;" width="12%" class="text-center"> {{ reportItem.result.test_desc}} </span>
                            </th>
                        </template>
                        
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
    props: ["qmProcesses", "reportItems", "showInputPerson"],
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
