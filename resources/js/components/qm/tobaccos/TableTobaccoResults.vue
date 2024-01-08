<template>

    <div class="tw-ml-10 tw-mr-10 tw-py-2">

        <table class="table table-borderless-horizontal mb-0">
            <thead>
                <tr>
                    <th width="7%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center">
                        ลำดับที่
                    </th>
                    <th width="25%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100">
                        ชื่อการทดสอบ
                    </th>
                    <th width="15%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        ค่ามาตรฐาน
                    </th>
                    <th width="10%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        ค่าOPTIMAL
                    </th>
                    <th width="12%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center">
                        ผลการทดสอบ
                    </th>
                    <th width="5%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center">
                        หน่วยนับ
                    </th>
                    <th width="6%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center">
                        
                    </th>
                    <th width="8%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        อยู่ในเกณฑ์มาตรฐาน
                    </th>
                    <th width="5%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                    </th>
                    <th width="12%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        หมายเหตุไม่ลงผลการทดสอบ
                    </th>
                </tr>
            </thead>
            <tbody v-if="sampleResults.length > 0">
                <template v-for="(sampleResult, index) in sampleResults">
                    <tr
                        :key="index"
                        :class="
                            sampleResult.read_only == 'Y'
                                ? 'tw-bg-gray-100 tw-bg-opacity-60'
                                : ''
                        "
                    >
                        <td class="text-center">
                            {{ sampleResult.seq }}
                        </td>
                        <td class="">
                            {{ sampleResult.test_desc }}
                            <span v-if="sampleResult.optional_ind != 'Y'" class="tw-text-red-600"> * </span>
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-text-blue-600 tw-font-bold tw-hidden">
                            {{ sampleResult.min_value ? parseFloat(sampleResult.min_value) : '' }} -
                            {{ sampleResult.max_value ? parseFloat(sampleResult.max_value) : '' }}
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-text-green-600 tw-font-bold tw-hidden">
                            {{ sampleResult.optimal_value ? parseFloat(sampleResult.optimal_value) : '' }}
                        </td>
                        <td class="text-center">

                            <div v-if="showType == 'result' && sampleResult.read_only != 'Y' && isAllowEdit(sampleData, approvalRole)">

                                <template v-if="sampleResult.data_type_code == 'N'">
                                    <input
                                        :id="`input_result_value_${index}`"
                                        type="number"
                                        class="form-control input-sm text-center"
                                        :name="`result_value_${index}`"
                                        v-model="sampleResult.result_value"
                                        placeholder=""
                                        @change="calResultStatus(sampleResult)"
                                    />
                                </template>
                                <template v-else>
                                    <input
                                        :id="`input_result_value_${index}`"
                                        type="text"
                                        class="form-control input-sm text-center"
                                        :name="`result_value_${index}`"
                                        v-model="sampleResult.result_value"
                                        placeholder=""
                                        @change="calResultStatus(sampleResult)"
                                    />
                                </template>

                            </div>
                            <div v-else class="tw-px-2">
                                <!-- MES_FLAG = 'Y' && BATCH_ID IS NULL -->
                                <template v-if="showType == 'result' && isAllowEdit(sampleData, approvalRole) && sampleResult.mes_flag == 'Y' && !sampleData.batch_id">
                                    <input
                                        :id="`input_result_value_${index}`"
                                        type="number"
                                        class="form-control input-sm text-center"
                                        :name="`result_value_${index}`"
                                        v-model="sampleResult.result_value"
                                        placeholder=""
                                        @change="calResultStatus(sampleResult)"
                                    />
                                </template>
                                <template v-else>
                                    {{ (sampleResult.result_value != null) ? parseFloat(sampleResult.result_value) : "-" }}
                                </template>
                                
                            </div>

                        </td>
                        <td class="text-center">
                            {{ sampleResult.test_unit ? `${sampleResult.test_unit}` : "" }}
                        </td>
                        <td class="text-center">
                            <button v-if="sampleResult.mes_flag == 'Y' && isAllowEdit(sampleData, approvalRole) " type="button" class="btn btn-xs btn-warning" @click="onShowModalUpdateMesResultValue($event, sampleResult)">
                                แก้ไขผล
                            </button>
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            <span v-if="sampleResult.result_status == 'PASSED'" class="fa fa-2x fa-check-circle tw-text-green-500"></span>
                            <span v-if="sampleResult.result_status == 'FAILED'" class="fa fa-2x fa-times tw-text-red-500"></span>
                            <span v-if="!sampleResult.result_status" class="fa fa-2x fa-minus"></span>
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            <span v-if="sampleResult.failed_status == 'UNDER'" class="fa fa-2x fa-arrow-down tw-text-blue-500"></span>
                            <span v-if="sampleResult.failed_status == 'OVER'" class="fa fa-2x fa-arrow-up tw-text-red-500"></span>
                        </td>
                        <td class="text-center">

                            <div v-if="showType == 'result' && sampleResult.read_only != 'Y' && isAllowEdit(sampleData, approvalRole)">
                                <input
                                    :id="`input_remark_no_result_${index}`"
                                    type="text"
                                    class="form-control input-sm text-center"
                                    :name="`remark_no_result_${index}`"
                                    v-model="sampleResult.remark_no_result"
                                    placeholder=""
                                />
                            </div>

                            <div v-else class="tw-px-2">
                                {{ sampleResult.remark_no_result ? sampleResult.remark_no_result : "-" }}
                            </div>

                        </td>
                    </tr>
                </template>
                <tr v-if="showType == 'result'  && isAllowEdit(sampleData, approvalRole)">
                    <td colspan="7">
                        <div class="row justify-content-center clearfix tw-my-4">
                            <div class="col text-center">
                                <button type="button" class="btn btn-md btn-success tw-w-32" @click="onSubmitSampleResult($event)">
                                    <i class="fa fa-save"></i> บันทึก
                                </button>
                                <button type="button" class="btn btn-md btn-danger tw-w-32 tw-ml-4" @click="onCancelSampleResult">
                                    <i class="fa fa-times"></i> ปิด
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="8">
                        <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                    </td>
                </tr>
            </tbody>
        </table>

        <loading :active.sync="is_loading" :is-full-page="true"></loading>

        <!-- MODAL REVIEW SAMPLE RESULTS -->
        <modal-mes-flag-sample-results
            modal-name="modal-mes-flag-sample-results" 
            modal-width="640" 
            modal-height="440"
            :sample="sampleData"
            :sample-result="selectedMesSampleResult"
            :batch-items="mesBatchItems"
            @onSelectMesBatchItem="onSelectMesBatchItem"
            @onSubmitInputMoistureValue="onSubmitInputMoistureValue"
        />

    </div>

</template>

<script>

// Import loading-overlay component
import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';
import ModalMesFlagSampleResults from "./ModalMesFlagSampleResults";

export default {

    props: ["authUser", "showType", "approvalData", "approvalRole", "sample", "items", "resultItems"],

    components: { Loading, VueNumeric, ModalMesFlagSampleResults },

    watch : {
        sample : function (data) {
            this.sampleData = data;
            this.getMesBatchItems(this.sampleData);
        },
        items : function (data) {
            this.specifications = data;
        },
        resultItems : function (data) {
            this.sampleResults = data.map(tem => {
                return {
                    ...item,
                    // optimal_value: this.getOptimalValue(this.items, item),
                    result_status: this.calResultStatus({ ...item, result_value: item.result_value }),
                    failed_status: this.calFailedStatus({ ...item, result_value: item.result_value })
                };
            });
        }
    },

    data() {
        return {
            sampleData: this.sample,
            specifications: this.items,
            sampleResults: this.resultItems.map(item => {
                return {
                    ...item,
                    // optimal_value: this.getOptimalValue(this.items, item),
                    result_status: this.calResultStatus({ ...item, result_value: item.result_value }),
                    failed_status: this.calFailedStatus({ ...item, result_value: item.result_value })
                };
            }),
            mesBatchItems: [],
            selectedMesSampleResult: null,
            is_loading: false
        };
    },

    mounted() {
        if(this.sample) {
            this.getMesBatchItems(this.sample);
        }
    },

    methods: {

        // getOptimalValue(specifications, item) {
        //     const foundResultItem = specifications.find(spec => (spec.spec_id == item.spec_id && spec.test_id == item.test_id));
        //     const optimalValue = foundResultItem ? foundResultItem.optimal_value : "";
        //     return optimalValue;
        // },

        getResultValue(item) {

            const foundResultItem = this.resultItems.find(i => i.test_id == item.test_id);
            const resultValue = foundResultItem ? foundResultItem.result_value : "";
            return resultValue;

        },

        async getMesBatchItems(sampleData) {

            var params = {
                sample_no: sampleData.sample_no,
            };
            return axios
            .get("/qm/ajax/tobaccos/get-mes-batch-items", { params })
            .then(res => {
                const resData = res.data.data;
                this.mesBatchItems = resData.batch_items ? JSON.parse(resData.batch_items) : [];
                return resData.batch_items ? JSON.parse(resData.batch_items) : [];
            });

        },

        isAllowEdit(sample, approvalRole) {
            
            let allowed = false;
            if(approvalRole) {
                const approvalLevelCode = approvalRole.level_code;
                if(approvalLevelCode == "1") { // Operator
                    if(sample.approval_status_code == "10") { // Pending : Operator Approval 
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

        onShowModalUpdateMesResultValue(event, sampleResult) {
            this.selectedMesSampleResult = sampleResult;
            window.scrollTo(0,150);
            this.$modal.show('modal-mes-flag-sample-results');
        },
        
        onSelectMesBatchItem(data) {

            const foundSampleResult = this.sampleResults.find(item => item.test_id == data.sample_result.test_id);
            if(foundSampleResult) {
                foundSampleResult.result_value = data.batch_item.moisture_value;
            }
            
        },

        onSubmitInputMoistureValue(data) {

            const foundSampleResult = this.sampleResults.find(item => item.test_id == data.sample_result.test_id);
            if(foundSampleResult) {
                foundSampleResult.result_value = data.moisture_value;
            }
            
        },

        async onSubmitSampleResult(event) {

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
                    remark_no_result: item.remark_no_result ? item.remark_no_result : "",
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
                // batch_id: this.sampleData.batch_id,
                opt: this.sampleData.opt,
                qc_area: this.sampleData.qc_area,
                machine_set: this.sampleData.machine_set,
                program_code: this.sampleData.program_code,
                result_quality_lines: JSON.stringify(resultQualityLines)
            };

            // SHOW LOADING
            this.is_loading = true;

            // VALIDATE BEFORE SUBMIT RESULT
            const resValidate = this.validateBeforeSave(this.sampleData, this.sampleResults);
            if(resValidate.valid) {

                // CALL STORE SAMPLE RESULT
                let resStoreSampleResultStatus = "success";
                let resSampleDisposition = this.sampleData.sample_disposition;
                let resSampleDispositionDesc = this.sampleData.sample_disposition_desc;
                let resSampleOperationStatus = this.sampleData.sample_operation_status;
                let resSampleOperationStatusDesc = this.sampleData.sample_operation_status_desc;
                let resSampleResultStatus = this.sampleData.sample_result_status;
                let resSampleResultStatusDesc = this.sampleData.sample_result_status_desc;
                let resSampleSeverityLevelMinor = this.sampleData.severity_level_minor;
                let resSampleSeverityLevelMajor = this.sampleData.severity_level_major;
                let resSampleSeverityLevelCritical = this.sampleData.severity_level_critical;
                await axios.post(`/qm/ajax/tobaccos/result`, reqBody)
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
                        resSampleSeverityLevelMinor = resSample.severity_level_minor;
                        resSampleSeverityLevelMajor = resSample.severity_level_major;
                        resSampleSeverityLevelCritical = resSample.severity_level_critical;
                    }

                    if(resData.status == "success") {
                        swal("Success", `บันทึกผลการตรวจสอบคุณภาพ กลุ่มผลิตด้านใบยา (จุดตรวจสอบ : "${this.sampleData.location_full_desc}", วัน/เวลา : "${this.sampleData.date_drawn_show} ${this.sampleData.time_drawn_formatted}", เลขที่การตรวจสอบ : "${this.sampleData.sample_no}" )`, "success");
                    }

                    if(resData.status == "error") {
                        swal("Error", `บันทึกผลการตรวจสอบคุณภาพ กลุ่มผลิตด้านใบยา (จุดตรวจสอบ : "${this.sampleData.location_full_desc}", วัน/เวลา : "${this.sampleData.date_drawn_show} ${this.sampleData.time_drawn_formatted}", เลขที่การตรวจสอบ : "${this.sampleData.sample_no}" ) | ${resMsg}`, "error");
                    }
                    
                    return resData;

                })
                .catch((error) => {
                    console.log(error);
                    resStoreSampleResultStatus = "error";
                    swal("Error", `บันทึกผลการตรวจสอบคุณภาพ กลุ่มผลิตด้านใบยา (จุดตรวจสอบ : "${this.sampleData.location_full_desc}", วัน/เวลา : "${this.sampleData.date_drawn_show} ${this.sampleData.time_drawn_formatted}", เลขที่การตรวจสอบ : "${this.sampleData.sample_no}" ) | ${error.message}`, "error");
                });

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
                    severity_level_minor: resSampleSeverityLevelMinor,
                    severity_level_major: resSampleSeverityLevelMajor,
                    severity_level_critical: resSampleSeverityLevelCritical,
                });

            } else {
                swal("เกิดข้อผิดพลาด", `${resValidate.message}`, "error");
            }

            // HIDE LOADING
            this.is_loading = false;

        },

        onCancelSampleResult(e){
            // emit sample result sumitted
            this.$emit("onCancelSampleResult", e);
        },

        validateBeforeSave(sampleData, sampleResults) {

            const result = {
                valid: true,
                message: "",
            };

            // IF THERE SAMPLE_RESULT_LINES : RESULT_VALUE INCOMPLETED
            const incompletedResultValueLines = sampleResults.filter(item => {
                return (item.result_value === "" || item.result_value === null) && !item.remark_no_result && item.read_only != 'Y';
            });

            if(incompletedResultValueLines.length > 0) {
                result.valid = false;
                result.message = `กรุณากรอกข้อมูล "ผลการตรวจสอบ" ให้ครบถ้วน`
            } else {

                // IF THERE SAMPLE_RESULT_LINES : RESULT_VALUE < MIN_VALUE_NUM OR > MAX_VALUE_NUM
                const invalidMinMaxResultValueLines = sampleResults.filter(item => {
                    return item.data_type_code == "N" && ((parseFloat(item.result_value) < parseFloat(item.test_min_value_num)) || (parseFloat(item.result_value) > parseFloat(item.test_max_value_num)));
                });

                if(invalidMinMaxResultValueLines.length > 0) {
                    result.valid = false;
                    result.message = `ผลการตรวจสอบ : "${invalidMinMaxResultValueLines[0].test_desc}" ไม่ถูกต้อง กรุณาตรวจสอบ (ค่าต่ำสุด: ${invalidMinMaxResultValueLines[0].test_min_value_num}, ค่าสูงสุด: ${invalidMinMaxResultValueLines[0].test_max_value_num})`
                }

            }

            return result;

        },

    }
};
</script>
