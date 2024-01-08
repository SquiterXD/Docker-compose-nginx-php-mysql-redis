<template>

    <div class="tw-ml-10 tw-mr-20 tw-py-2">

        <table class="table table-borderless-horizontal mb-0">
            <thead>
                <tr>
                    <th width="20%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100">
                        ชื่อการทดสอบ
                    </th>
                    <th width="10%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        ค่าควบคุม
                    </th>
                    <th width="7%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        ค่าOPTIMAL
                    </th>
                    <th width="10%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center">
                        ผลการทดสอบ
                    </th>
                    <th width="5%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center">
                        หน่วยนับ
                    </th>
                    <th width="10%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        อยู่ในเกณฑ์มาตรฐาน
                    </th>
                    <th width="8%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        
                    </th>
                    <th width="20%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        วิธีป้องกันและกำจัดมอดยาสูบ
                    </th>
                </tr>
            </thead>
            <tbody v-if="sampleResults.length > 0">
                <template v-for="(sampleResult, index) in sampleResults">
                    <tr :key="index" :class="sampleResult.read_only == 'Y' ? 'tw-bg-gray-100 tw-bg-opacity-60' : ''">
                        <td class="">
                            {{ sampleResult.test_desc }}
                            <span v-if="sampleResult.optional_ind != 'Y'" class="tw-text-red-600"> * </span>
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-text-blue-600 tw-font-bold tw-hidden">
                            {{ sampleResult.min_value ? parseFloat(sampleResult.min_value) : '' }} -
                            {{ sampleResult.max_value ? parseFloat(sampleResult.max_value) : '' }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-text-green-600 tw-font-bold tw-hidden">
                            {{ sampleResult.optimal_value }}
                        </td>
                        <td class="text-center">
                            {{ sampleResult.result_value ? parseFloat(sampleResult.result_value) : "-" }}
                        </td>
                        <td class="text-center">
                            {{ sampleResult.test_unit ? `${sampleResult.test_unit}` : "" }}
                        </td>
                        <td
                            class="text-center tw-text-xs md:tw-table-cell tw-hidden"
                        >
                            <span v-if="sampleResult.result_status == 'PASSED'" class="fa fa-2x fa-check-circle tw-text-green-500"></span>
                            <span v-if="sampleResult.result_status == 'FAILED'" class="fa fa-2x fa-times tw-text-red-500"></span>
                            <span v-if="!sampleResult.result_status" class="fa fa-2x fa-minus"></span>
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            <span v-if="sampleResult.failed_status == 'UNDER'" class="fa fa-2x fa-arrow-down tw-text-blue-500"></span>
                            <span v-if="sampleResult.failed_status == 'OVER'" class="fa fa-2x fa-arrow-up tw-text-red-500"></span>
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            <div v-if="showType == 'result' && isAllowEdit(sampleData, approvalRole)">
                                <input type="text"
                                    :disabled="sampleResult.result_status == 'PASSED'"
                                    class="form-control input-sm tw-text-xs text-left"
                                    v-model="sampleResult.cause_of_defect"
                                    placeholder="วิธีป้องกันและกำจัดมอดยาสูบ"
                                />
                            </div>
                            <div v-else class="tw-py-2">
                                <span v-if="sampleResult.result_status != 'PASSED'">
                                    {{ sampleResult.cause_of_defect }}
                                </span>
                            </div>
                        </td>
                    </tr>
                </template>
                <tr v-if="showType == 'result' && isAllowEdit(sampleData, approvalRole)">
                    <td colspan="7">
                        <div class="row justify-content-center clearfix tw-my-4">
                            <div class="col text-center">
                                <button type="button" class="btn btn-md btn-success tw-w-32"
                                    @click="onSubmitSampleResult($event)"
                                >
                                    <i class="fa fa-save"></i> บันทึก
                                </button>
                                <button type="button" class="btn btn-md btn-danger tw-w-32 tw-ml-4"
                                    @click="onCancelSampleResult"
                                >
                                    <i class="fa fa-times"></i> ปิด
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="7">
                        <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                    </td>
                </tr>
            </tbody>
        </table>

        <loading :active.sync="is_loading" :is-full-page="true"></loading>

    </div>

</template>

<script>

// Import loading-overlay component
import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

export default {
    props: ["authUser", "showType", "approvalData", "approvalRole", "sample", "items", "resultItems"],
    components: { Loading, VueNumeric },
    data() {
        return {
            sampleData: this.sample,
            specifications: this.items,
            sampleResults: this.resultItems.map(item => {
                return {
                    ...item,
                    // optimal_value: this.getOptimalValue(this.items, item),
                    result_status: this.calResultStatus({ ...item, result_value: item.result_value }),
                    failed_status: this.calFailedStatus({ ...item, result_value: item.result_value }),
                    cause_of_defect: item.cause_of_defect
                };
            }),
            is_loading: false
        };
    },

    methods: {

        getOptimalValue(specifications, item) {
            const foundResultItem = specifications.find(spec => spec.spec_id == item.spec_id && spec.test_id == item.test_id);
            const optimalValue = foundResultItem ? foundResultItem.optimal_value : "";
            return optimalValue;
        },

        getResultValue(item) {

            const foundResultItem = this.resultItems.find(i => i.test_id == item.test_id);
            const resultValue = foundResultItem ? foundResultItem.result_value : "";
            return resultValue;
            
        },

        isAllowEdit(sample, approvalRole) {
            
            let allowed = false;
            if(approvalRole) {
                const approvalLevelCode = approvalRole.level_code;
                if(approvalLevelCode == "1") { // OPERATOR
                    if(sample.approval_status_code == "10") { // Pending : Supervisor Approval 
                        allowed = true;
                    }
                }
            }
            return allowed;
            
        },

        calResultStatus(item) {
            
            let resultStatus = "";
            if(item.min_value && item.max_value && (item.result_value !== "" && item.result_value !== null)) {
                if(parseFloat(item.result_value) >= parseFloat(item.min_value) 
                && parseFloat(item.result_value) <= parseFloat(item.max_value)) {
                    resultStatus = "PASSED";
                } else {
                    resultStatus = "FAILED";
                }
                this.calFailedStatus(item);
            }
            item.result_status = resultStatus;
            return resultStatus;
        },

        calFailedStatus(item) {
            let failedStatus = "";
            if(item.min_value && item.max_value && (item.result_value !== "" && item.result_value !== null)) {
                if(parseFloat(item.result_value) < parseFloat(item.min_value)) {
                    failedStatus = "UNDER";
                }
                if(parseFloat(item.result_value) > parseFloat(item.max_value)) {
                    failedStatus = "OVER";
                }
            }
            item.failed_status = failedStatus;
            return failedStatus;
        },

        async onSubmitSampleResult(event) {

            // const sample = this.sample;
            const resultQualityLines = this.sampleResults.map((item) => {
                return {
                    result_id: item.result_id,
                    test_id: item.test_id,
                    test_code: item.test_code,
                    test_desc: item.test_desc,
                    optimal_value: item.optimal_value,
                    min_value: item.min_value,
                    max_value: item.max_value,
                    result_value: item.result_value,
                    cause_of_defect: item.cause_of_defect ? item.cause_of_defect : "",
                }
            });
            const reqBody = {
                organization_code: this.sampleData.organization_code,
                oracle_sample_id: this.sampleData.oracle_sample_id,
                sample_no: this.sampleData.sample_no,
                sample_desc: this.sampleData.sample_desc,
                inventory_item_id: this.sampleData.inventory_item_id,
                item_number: this.sampleData.item_number,
                item_desc: this.sampleData.item_desc,
                date_drawn: this.sampleData.date_drawn,
                sample_disposition: this.sampleData.sample_disposition,
                sample_disposition_desc: this.sampleData.sample_disposition_desc,
                sample_operation_status: this.sampleData.sample_operation_status,
                sample_result_status: this.sampleData.sample_result_status,
                sample_id: this.sampleData.sample_id,
                department_code: this.sampleData.department_code,
                qm_group: this.sampleData.qm_group,
                organization_id: this.sampleData.organization_id,
                subinventory_code: this.sampleData.subinventory_code,
                locator_id: this.sampleData.locator_id,
                sample_date: this.sampleData.sample_date,
                batch_id: this.sampleData.batch_id,
                // opt: this.sampleData.opt,
                qc_area: this.sampleData.qc_area,
                machine_set: this.sampleData.machine_set,
                program_code: this.sampleData.program_code,
                result_quality_lines: JSON.stringify(resultQualityLines)
            };

            // SHOW LOADING
            this.is_loading = true;

            // CALL STORE SAMPLE RESULT
            let resStoreSampleResultStatus = "success";
            let resSampleDisposition = this.sampleData.sample_disposition;
            let resSampleDispositionDesc = this.sampleData.sample_disposition_desc;
            let resSampleOperationStatus = this.sampleData.sample_operation_status;
            let resSampleOperationStatusDesc = this.sampleData.sample_operation_status_desc;
            let resSampleResultStatus = this.sampleData.sample_result_status;
            let resSampleResultStatusDesc = this.sampleData.sample_result_status_desc;
            await axios.post(`/qm/ajax/moth-outbreaks/result`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resSample = resData.sample ? JSON.parse(resData.sample) : null;
                resStoreSampleResultStatus = resData.status;
                if(resSample){ 
                    resSampleDisposition = resSample.sample_disposition; 
                    resSampleDispositionDesc = resSample.sample_disposition_desc; 
                    resSampleOperationStatus = resSample.sample_operation_status; 
                    resSampleOperationStatusDesc = resSample.sample_operation_status_desc; 
                    resSampleResultStatus = resSample.sample_result_status; 
                    resSampleResultStatusDesc = resSample.sample_result_status_desc; 
                }

                if(resData.status == "success") {
                    swal("Success", `บันทึกลงผลการการระบาดของมอดยาสูบ (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no} )`, "success");
                }

                if(resData.status == "error") {
                    swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no}) | ${resMsg}`, "error");
                }
                
                return resData;

            })
            .catch((error) => {
                console.log(error);
                resStoreSampleResultStatus = "error";
                swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no}) | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.is_loading = false;

            // emit sample result sumitted
            this.$emit("onSampleResultSubmitted", {
                status: resStoreSampleResultStatus,
                sample_no: this.sampleData.sample_no,
                sample_disposition: resSampleDisposition,
                sample_disposition_desc: resSampleDispositionDesc,
                sample_operation_status: resSampleOperationStatus,
                sample_operation_status_desc: resSampleOperationStatusDesc,
                sample_result_status: resSampleResultStatus,
                sample_result_status_desc: resSampleResultStatusDesc,
            });

        },

        onCancelSampleResult(e){
            // emit sample result sumitted
            this.$emit("onCancelSampleResult", e);
        }

    }
};
</script>
