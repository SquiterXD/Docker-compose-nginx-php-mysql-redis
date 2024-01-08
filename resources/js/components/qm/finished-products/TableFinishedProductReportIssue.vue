<template>

    <div class="table-responsive">
        <table class="table table-bordered tw-text-xs" style="min-width: 1400px;">
            <thead>
                <tr>
                    <th class="text-center" style="min-width: 100px; max-width: 100px;"> กระบวนการผลิต </th>
                    <template v-for="(reportQmProcess, indexQMP) in reportQmProcesses">
                        <th :key="indexQMP" class="text-center" :colspan="reportQmProcess.count_check_lists">
                            {{ reportQmProcess.qm_process }}
                        </th>
                    </template>
                    <th class="text-center" style="min-width: 100px; max-width: 100px;" rowspan="2"> รวม </th>
                </tr>
                <tr>
                    <th class="text-center" style="min-width: 100px; max-width: 100px;"> รายการตรวจ / หมายเลขเครื่อง </th>
                    <template v-for="(reportQmProcessCheckList, indexCL) in reportQmProcessCheckLists">
                        <th :key="indexCL" style="min-width: 60px;" class="text-center">
                            {{ reportQmProcessCheckList.check_list }}
                        </th>
                    </template>
                </tr>
            </thead>
            <tbody v-if="reportMachineSets.length > 0">

                <template v-for="(reportMachineSet, indexM) in reportMachineSets">

                    <tr :key="`${indexM}`">

                        <td :key="`${indexM}`" class="text-center"> {{ reportMachineSet.machine_set  }} </td>
                            
                        <template v-for="(reportItem, index) in reportItems">

                            <template v-if="(reportItem.machine_set == reportMachineSet.machine_set)">

                                <template v-if="reportItem.results.length > 0">

                                    <template v-for="(reportQmProcessCheckList, indexCL) in reportQmProcessCheckLists">
                                        <td v-if="getSumResultValue(reportQmProcessCheckList.check_list_code, reportItem.results)" :key="`${indexM}_${index}_${indexCL}`" class="text-center tw-font-bold" style="background-color: #fff0a0;"> 
                                            <a :href="`/qm/finished-products/report-issue-details?${ queryStringSearchInputs }&machine_set=${ reportItem.machine_set }&qm_process_seq=${ reportQmProcessCheckList.qm_process_seq }&check_list_code=${ reportQmProcessCheckList.check_list_code }`" target="_blank">
                                                {{ getSumResultValue(reportQmProcessCheckList.check_list_code, reportItem.results) }}
                                            </a>
                                        </td>
                                        <td v-else :key="`${indexM}_${index}_${indexCL}`" class="text-center"> 
                                            -
                                        </td>
                                    </template>

                                    <td :key="`${indexM}_${index}_total`" class="text-center"> {{ reportItem.total_count_result_value ? reportItem.total_count_result_value : '-' }} </td>
                                
                                </template>
                                <template v-else>

                                    <template v-for="(reportQmProcessCheckList, indexCL) in reportQmProcessCheckLists">
                                        <td :key="`${indexM}_${index}_${indexCL}`" class="text-center"> 
                                            <span> - </span>
                                        </td>
                                    </template>

                                    <td :key="`${indexM}_${index}_total`" class="text-center"> - </td>

                                </template>

                            </template>
                        
                        </template>

                    </tr>

                </template>

                <tr>
                    <td class="text-center tw-font-bold"> รวม </td>

                    <template v-for="(reportQmProcessCheckList, indexSummaryCL) in reportQmProcessCheckLists">
                        <td :key="`${indexSummaryCL}`" class="text-center tw-font-bold"> 
                            {{ reportQmProcessCheckList.total_count_result_value }}
                        </td>
                    </template>

                    <td class="text-center"> {{ getAllTotalSumResultValue(reportQmProcessCheckLists) }} </td>
                    
                </tr>

            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="13">
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

    props: ["queryStringSearchInputs", "reportMachineSets", "reportQmProcesses", "reportQmProcessCheckLists", "reportItems"],

    components: { Loading },
    data() {
        return {
            isLoading: false
        };
    },

    methods: {

        getSumResultValue(checkListCode, reportItemResults) {
            const foundResult = reportItemResults.find(item => item.check_list_code == checkListCode);
            const result = foundResult ? (foundResult.count_result_value ? foundResult.count_result_value : null) : null;
            return result;
        },

        getAllTotalSumResultValue(reportQmProcessCheckLists) {

            const result = reportQmProcessCheckLists.reduce((accA, reportQmProcessCheckList) => {
                return accA + reportQmProcessCheckList.total_count_result_value;
            }, 0);
            return result;

        }
        
    }

};
</script>
