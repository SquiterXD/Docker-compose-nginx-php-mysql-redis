<template>

    <div class="table-responsive" style="max-height: 800px;">

        <template v-if="reportDates.length > 0">
            <table class="table table-bordered table-sticky mb-0" :style="{ minWidth: ((reportDates.length * 200) + 550 + 280) + 'px' }">
                <thead>
                    <tr>
                        <th class="text-right" style="min-width: 350px; max-width: 350px; width: 350px;"> วันที่เก็บตัวอย่าง </th>
                        <template v-for="(reportDateTh, indexDTH) in reportDates">
                            <th :key="indexDTH" colspan="3" class="text-center tw-text-xs" style="min-width: 180px;">
                                {{ reportDateTh.date_drawn_formatted }}
                            </th>
                        </template>
                        <th colspan="3" class="text-center tw-text-xs" style="min-width: 180px;">
                            ทั้งหมด
                        </th>
                    </tr>
                    <tr>
                        <th class="text-left" style="min-width: 350px; max-width: 350px; width: 350px; top: 34px;"> อาคาร / โซน </th>
                        <template v-for="(reportDateTh, indexDTH) in reportDates">
                            <th :key="`${indexDTH}_r`" class="text-center tw-text-xs" style="min-width: 60px; top: 34px;">
                                จำนวนรายการ
                            </th>
                            <th :key="`${indexDTH}_s`" class="text-center tw-text-xs" style="min-width: 60px; top: 34px;">
                                ผลรวม (ตัว)
                            </th>
                            <th :key="`${indexDTH}_a`" class="text-center tw-text-xs" style="min-width: 60px; top: 34px;">
                                ค่าเฉลี่ย (ตัว)
                            </th>
                        </template>
                        <th class="text-center tw-text-xs" style="min-width: 60px; top: 34px;">
                            จำนวนรายการ
                        </th>
                        <th class="text-center tw-text-xs" style="min-width: 60px; top: 34px;">
                            ผลรวม (ตัว)
                        </th>
                        <th class="text-center tw-text-xs" style="min-width: 60px; top: 34px;">
                            ค่าเฉลี่ย (ตัว)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                    <template v-for="(reportBuildNameItem, indexBN) in reportBuildNameItems">
                        
                        <tr :key="indexBN" clsss="tw-text-xs">

                            <td class="text-left"> {{ reportBuildNameItem.build_name }} </td>
                            
                            <template v-for="(reportDateTd, indexBNTD) in reportDates">
                                <td :key="`${indexBNTD}_r`" class="text-right" style="padding: 4px;">
                                    <template v-for="(reportBuildNameItemResult, indexBNRTD) in reportBuildNameItem.results">
                                        <span :key="`${indexBNTD}_${indexBNRTD}_r`" v-if="reportBuildNameItemResult.date_drawn_formatted == reportDateTd.date_drawn_formatted"> 
                                            {{ reportBuildNameItemResult.record_count ? reportBuildNameItemResult.record_count : "0" }} 
                                        </span>
                                    </template>
                                </td>
                                <td :key="`${indexBNTD}_s`" class="text-right" style="padding: 4px;">
                                    <template v-for="(reportBuildNameItemResult, indexBNRTD) in reportBuildNameItem.results">
                                        <span :key="`${indexBNTD}_${indexBNRTD}_s`" v-if="reportBuildNameItemResult.date_drawn_formatted == reportDateTd.date_drawn_formatted"> 
                                            {{ reportBuildNameItemResult.sum_result_value ? reportBuildNameItemResult.sum_result_value : "0" }} 
                                        </span>
                                    </template>
                                </td>
                                <td :key="`${indexBNTD}_a`" class="text-right" style="padding: 4px;">
                                    <template v-for="(reportBuildNameItemResult, indexBNRTD) in reportBuildNameItem.results">
                                        <span :key="`${indexBNTD}_${indexBNRTD}_a`" v-if="reportBuildNameItemResult.date_drawn_formatted == reportDateTd.date_drawn_formatted"> 
                                            {{ reportBuildNameItemResult.avg_result_value ? reportBuildNameItemResult.avg_result_value : "0" }} 
                                        </span>
                                    </template>
                                </td>
                            </template>

                            <td class="text-right" style="padding: 4px;">
                                <template v-for="(reportSummaryBuildNameItem, indexSBNRTD) in reportSummaryBuildNameItems">
                                    <span :key="`${indexBNTD}_${indexSBNRTD}_summary_r`" v-if="reportSummaryBuildNameItem.build_name == reportBuildNameItem.build_name"> 
                                        {{ reportSummaryBuildNameItem.record_count ? reportSummaryBuildNameItem.record_count : "0" }} 
                                    </span>
                                </template>
                            </td>
                            <td class="text-right" style="padding: 4px;">
                                <template v-for="(reportSummaryBuildNameItem, indexSBNRTD) in reportSummaryBuildNameItems">
                                    <span :key="`${indexBNTD}_${indexSBNRTD}_summary_s`" v-if="reportSummaryBuildNameItem.build_name == reportBuildNameItem.build_name"> 
                                        {{ reportSummaryBuildNameItem.sum_result_value ? reportSummaryBuildNameItem.sum_result_value : "0" }} 
                                    </span>
                                </template>
                            </td>
                            <td class="text-right" style="padding: 4px;">
                                <template v-for="(reportSummaryBuildNameItem, indexSBNRTD) in reportSummaryBuildNameItems">
                                    <span :key="`${indexBNTD}_${indexSBNRTD}_summary_a`" v-if="reportSummaryBuildNameItem.build_name == reportBuildNameItem.build_name"> 
                                        {{ reportSummaryBuildNameItem.avg_result_value ? reportSummaryBuildNameItem.avg_result_value : "0" }} 
                                    </span>
                                </template>
                            </td>

                        </tr>

                        <template v-for="(reportDepartmentNameItem, indexDPN) in reportDepartmentNameItems">

                            <tr :key="`${indexBN}_${indexDPN}`" v-if="reportBuildNameItem.build_name == reportDepartmentNameItem.build_name" clsss="tw-text-xs">
                                
                                <td class="text-left"> <span class="tw-ml-4"> {{ reportDepartmentNameItem.department_name }} </span> </td>
                            
                                <template v-for="(reportDateTd, indexDPNTD) in reportDates">
                                    <td :key="`${indexDPNTD}_r`" class="text-right" style="padding: 4px;">
                                        <template v-for="(reportDepartmentNameItemResult, indexDPNRTD) in reportDepartmentNameItem.results">
                                            <span :key="`${indexDPNTD}_${indexDPNRTD}_r`" v-if="reportDepartmentNameItemResult.date_drawn_formatted == reportDateTd.date_drawn_formatted"> 
                                                {{ reportDepartmentNameItemResult.record_count ? reportDepartmentNameItemResult.record_count : "0" }} 
                                            </span>
                                        </template>
                                    </td>
                                    <td :key="`${indexDPNTD}_s`" class="text-right" style="padding: 4px;">
                                        <template v-for="(reportDepartmentNameItemResult, indexDPNRTD) in reportDepartmentNameItem.results">
                                            <span :key="`${indexDPNTD}_${indexDPNRTD}_s`" v-if="reportDepartmentNameItemResult.date_drawn_formatted == reportDateTd.date_drawn_formatted"> 
                                                {{ reportDepartmentNameItemResult.sum_result_value ? reportDepartmentNameItemResult.sum_result_value : "0" }} 
                                            </span>
                                        </template>
                                    </td>
                                    <td :key="`${indexDPNTD}_a`" class="text-right" style="padding: 4px;">
                                        <template v-for="(reportDepartmentNameItemResult, indexDPNRTD) in reportDepartmentNameItem.results">
                                            <span :key="`${indexDPNTD}_${indexDPNRTD}_a`" v-if="reportDepartmentNameItemResult.date_drawn_formatted == reportDateTd.date_drawn_formatted"> 
                                                {{ reportDepartmentNameItemResult.avg_result_value ? reportDepartmentNameItemResult.avg_result_value : "0" }} 
                                            </span>
                                        </template>
                                    </td>
                                </template>

                                <td class="text-right" style="padding: 4px;">
                                    <template v-for="(reportSummaryDepartmentNameItem, indexSDPNRTD) in reportSummaryDepartmentNameItems">
                                        <span :key="`${indexDPNTD}_${indexSDPNRTD}_summary_r`" v-if="reportSummaryDepartmentNameItem.build_name == reportDepartmentNameItem.build_name && reportSummaryDepartmentNameItem.department_name == reportDepartmentNameItem.department_name"> 
                                            {{ reportSummaryDepartmentNameItem.record_count ? reportSummaryDepartmentNameItem.record_count : "0" }} 
                                        </span>
                                    </template>
                                </td>
                                <td class="text-right" style="padding: 4px;">
                                    <template v-for="(reportSummaryDepartmentNameItem, indexSDPNRTD) in reportSummaryDepartmentNameItems">
                                        <span :key="`${indexDPNTD}_${indexSDPNRTD}_summary_s`" v-if="reportSummaryDepartmentNameItem.build_name == reportDepartmentNameItem.build_name && reportSummaryDepartmentNameItem.department_name == reportDepartmentNameItem.department_name"> 
                                            {{ reportSummaryDepartmentNameItem.sum_result_value ? reportSummaryDepartmentNameItem.sum_result_value : "0" }} 
                                        </span>
                                    </template>
                                </td>
                                <td class="text-right" style="padding: 4px;">
                                    <template v-for="(reportSummaryDepartmentNameItem, indexSDPNRTD) in reportSummaryDepartmentNameItems">
                                        <span :key="`${indexDPNTD}_${indexSDPNRTD}_summary_a`" v-if="reportSummaryDepartmentNameItem.build_name == reportDepartmentNameItem.build_name && reportSummaryDepartmentNameItem.department_name == reportDepartmentNameItem.department_name"> 
                                            {{ reportSummaryDepartmentNameItem.avg_result_value ? reportSummaryDepartmentNameItem.avg_result_value : "0" }} 
                                        </span>
                                    </template>
                                </td>

                            </tr>

                        </template>

                    </template>

                </tbody>
            </table>
        </template>
        <template v-else>
            <h2 class="p-5 text-center text-muted tw-bg-gray-100"> ไม่พบข้อมูล </h2>
        </template>

    </div>

</template>

<script>

// Import loading-overlay component
import Loading from "vue-loading-overlay";

export default {
    props: ["reportItems", "reportDates", "reportBuildNameItems", "reportDepartmentNameItems", "reportSummaryBuildNameItems", "reportSummaryDepartmentNameItems"],
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
