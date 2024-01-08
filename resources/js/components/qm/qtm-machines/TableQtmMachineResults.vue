<template>

    <div class="tw-ml-10 tw-mr-20 tw-py-2">
        
        <table class="table table-borderless-horizontal mb-0">
            <thead>
                <tr>
                    <th width="7%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center">
                        ลำดับที่
                    </th>
                    <th width="25%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100">
                        ชื่อการทดสอบ
                    </th>
                    <th width="12%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
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
                    <th width="8%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        อยู่ในเกณฑ์มาตรฐาน
                    </th>
                    <th width="5%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        
                    </th>
                    <th v-if="showType == 'defect'" width="20%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        สาเหตุ
                    </th>
                </tr>
            </thead>
            <tbody v-if="sampleResults.length > 0">
                <template v-for="(sampleResult, index) in sampleResults">
                    <tr v-show="!searchInputs.show_test_id || searchInputs.show_test_id == sampleResult.test_id"
                        :key="index"
                        :class="sampleResult.read_only == 'Y' ? 'tw-bg-gray-100 tw-bg-opacity-60' : ''"
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

                            <div v-if="showType == 'result' && sampleResult.read_only != 'Y' && !sampleData.file_name && isAllowEdit(sampleData, approvalRole)">

                                <template v-if="sampleResult.brand_flag == 'Y'">
                                    <input type="text" v-model="sampleData.brand" class="form-control input-sm text-left" disabled />
                                </template>
                                <template v-else-if="sampleResult.qtm_test_code == 'MAKER'">
                                    <input type="text" v-model="sampleData.maker" class="form-control input-sm text-left" disabled />
                                </template>
                                <template v-else-if="sampleResult.test ? sampleResult.test.time_flag == 'Y' : false">
                                    <!-- RESULT TIME -->
                                    <qm-timepicker 
                                        :id="`input_result_value_${index}`"
                                        :name="`result_value_${index}`"
                                        :value="sampleResult.result_value" 
                                        @change="onSampleResultChanged($event, sampleResult)"
                                    />
                                </template>
                                <template v-else-if="sampleResult.data_type_code == 'N'">
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

                                <template v-if="sampleResult.brand_flag == 'Y'">
                                    {{ sampleData.brand }}
                                </template>
                                <template v-else-if="sampleResult.qtm_test_code == 'MAKER'">
                                    {{ sampleData.maker }}
                                </template>
                                <template v-else-if="sampleResult.test.time_flag == 'Y' || sampleResult.qtm_test_code == 'DATE_TIME'">
                                    {{ sampleResult.result_value }}
                                </template>
                                <template v-else>
                                    {{ (sampleResult.result_value != null) ? (Number.isNaN(sampleResult.result_value) ? sampleResult.result_value : parseFloat(sampleResult.result_value)) : "-" }}
                                </template>

                            </div>

                        </td>
                        <td class="text-center">
                            {{ sampleResult.test_unit ? `${sampleResult.test_unit}` : "" }}
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
                        <td v-if="showType == 'defect'" class="text-left tw-text-xs md:tw-table-cell" style="padding-right: 0px;">
                            <template v-if="sampleResult.result_status == 'FAILED'">
                                <input type="text"
                                    class="form-control input-sm text-left"
                                    v-model="sampleResult.cause_of_defect"
                                    :disabled="!isAllowEdit(sampleData, approvalRole)"
                                    placeholder="ระบุสาเหตุ"
                                />
                            </template>
                            <template v-else>
                                <input type="text" class="form-control input-sm text-left" disabled />
                            </template>
                        </td>
                    </tr>
                </template>
                <tr v-if="sampleData.confirm_code == '3'">
                    <td> </td>
                    <td>เหตุผลการยกเลิก</td>
                    <td colspan="5"> {{ sampleData.reject_reason }} </td>
                </tr>
                <tr v-if="(showType == 'result' || showType == 'defect') && isAllowEdit(sampleData, approvalRole)">
                    
                    <td colspan="8">

                        <div class="row justify-content-center clearfix tw-my-4">
                            <div class="col text-center">

                                <button v-if="showType == 'result' && !sampleData.file_name && sampleData.confirm_code == '1'"
                                    type="button"
                                    class="btn btn-md btn-success tw-w-32 tw-mr-4"
                                    @click="onSubmitSampleResult($event)"
                                >
                                    <i class="fa fa-save"></i> บันทึก
                                </button>

                                <button v-if="showType == 'defect'"
                                    type="button"
                                    class="btn btn-md btn-success tw-w-32 tw-mr-4"
                                    @click="onSubmitCauseOfDefect($event)"
                                >
                                    <i class="fa fa-save"></i> บันทึก
                                </button>
                                
                                <button v-if="showType == 'result'"
                                    type="button"
                                    class="btn btn-md btn-outline btn-success tw-w-32"
                                    :disabled="sampleData.confirm_code == '2'"
                                    @click="onConfirmSampleResult($event)"
                                >
                                    <i class="fa fa-check-square-o"></i> ยืนยันการใช้ข้อมูล
                                </button>
                                <button v-if="showType == 'result'"
                                    type="button"
                                    class="btn btn-md btn-outline btn-danger tw-w-32 tw-ml-2"
                                    @click="onRejectSampleResult($event)"
                                >
                                    <i class="fa fa-times"></i> ยกเลิกการใช้ข้อมูล
                                </button>

                                <button v-if="showType == 'defect' || (!sampleData.file_name && sampleData.confirm_code == '1')"
                                    type="button"
                                    class="btn btn-md btn-danger tw-w-32 tw-ml-4"
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
                    <td colspan="8">
                        <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                    </td>
                </tr>
            </tbody>
        </table>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

export default {
    props: ["authUser", "showType", "searchInputs", "sample", "items", "resultItems", "listBrands", "listMakers", "approvalData", "approvalRole"],
    components: { Loading, VueNumeric },
    data() {
        return {
            sampleData: this.sample,
            specifications: this.items,
            sampleResults: this.resultItems.map(item => {
                let overriddenResultValue = item.result_value;
                if(item.qtm_test_code == 'BRAND' && !item.result_value) { overriddenResultValue = this.sample.brand; }
                if(item.qtm_test_code == 'MAKER' && !item.result_value) { overriddenResultValue = this.sample.maker; }
                return {
                    ...item,
                    result_value: overriddenResultValue,
                    // optimal_value: this.getOptimalValue(this.items, item),
                    result_status: this.calResultStatus({ ...item, result_value: item.result_value }),
                    failed_status: this.calFailedStatus({ ...item, result_value: item.result_value }),
                    cause_of_defect: item.cause_of_defect ? item.cause_of_defect : "",
                };
            }),
            isLoading: false
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
                if(approvalLevelCode == "1") { // Operator
                    if(sample.approval_status_code == "10") { // Pending : Operator Approval 
                        allowed = true;
                    }
                }
            }
            return allowed;
            
        },

        onSampleResultChanged(resultValue, sampleResult){
            sampleResult.result_value = resultValue;
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

            // const sampleData = this.sample;

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
            this.isLoading = true;

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
                // let resSampleMachineDescription = this.sampleData.machine_description;
                let resSampleResultBrand = this.sampleData.brand;
                let resSampleResultMaker = this.sampleData.maker;
                let resSampleResultTestTime = this.sampleData.test_time;

                await axios.post(`/qm/ajax/qtm-machines/result`, reqBody)
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
                        // resSampleMachineDescription = resSample.machine_description;
                        resSampleResultBrand = resSample.brand;
                        resSampleResultMaker = resSample.maker;
                        resSampleResultTestTime = resSample.test_time;
                    }

                    if(resData.status == "success") {
                        swal("Success", `บันทึกลงผลการตรวจสอบด้วยเครื่อง QTM (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no} )`, "success");
                    }

                    if(resData.status == "error") {
                        swal("Error", `บันทึกลงผลการตรวจสอบด้วยเครื่อง QTM (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no}) | ${resMsg}`, "error");
                    }
                    
                    return resData;

                })
                .catch((error) => {
                    console.log(error);
                    resStoreSampleResultStatus = "error";
                    swal("Error", `บันทึกลงผลการตรวจสอบด้วยเครื่อง QTM (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no})  | ${error.message}`, "error");
                });


                // emit sample result sumitted
                this.$emit("onSampleResultSubmitted", {
                    status: resStoreSampleResultStatus,
                    sample_no: this.sampleData.sample_no,
                    // machine_description: resSampleMachineDescription,
                    brand: resSampleResultBrand,
                    maker: resSampleResultMaker,
                    test_time: resSampleResultTestTime,
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
            this.isLoading = false;
                
        },

        async onSubmitCauseOfDefect(event) {

            // const sampleData = this.sample;

            const resultQualityLines = this.sampleResults.map((item) => {
                return {
                    result_id: item.result_id,
                    test_id: item.test_id,
                    test_code: item.test_code,
                    test_desc: item.test_desc,
                    cause_of_defect: item.cause_of_defect ? item.cause_of_defect : "",
                }
            });

            const reqBody = {
                organization_code: this.sampleData.organization_code,
                oracle_sample_id: this.sampleData.oracle_sample_id,
                sample_no: this.sampleData.sample_no,
                result_quality_lines: JSON.stringify(resultQualityLines)
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store cause of defect
            let resStoreCauseOfDefectStatus = "success";
            await axios.post(`/qm/ajax/qtm-machines/defect`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resSample = resData.sample ? JSON.parse(resData.sample) : null;
                
                resStoreCauseOfDefectStatus = resData.status;

                if(resSample) {
                    this.sampleData.sample_operation_status = resSample.sample_operation_status;
                    this.sampleData.sample_operation_status_desc = resSample.sample_operation_status_desc;
                    this.sampleData.sample_result_status = resSample.sample_result_status;
                    this.sampleData.sample_result_status_desc = resSample.sample_result_status_desc;
                }

                if(resData.status == "success") {
                    swal("Success", `บันทึกสาเหตุความผิดปกติการตรวจสอบด้วยเครื่อง QTM (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no} )`, "success");
                }

                if(resData.status == "error") {
                    swal("Error", `บันทึกสาเหตุความผิดปกติการตรวจสอบด้วยเครื่อง QTM (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no}) | ${resMsg}`, "error");
                }
                
                return resData;

            })
            .catch((error) => {
                console.log(error);
                resStoreCauseOfDefectStatus = "error";
                swal("Error", `บันทึกสาเหตุความผิดปกติการตรวจสอบด้วยเครื่อง QTM (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no})  | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

            // // emit cause of defect sumitted
            // this.$emit("onCauseOfDefectSubmitted", {
            //     status: resStoreCauseOfDefectStatus,
            //     sample_no: this.sampleData.sample_no,
            // });
                
        },

        onConfirmSampleResult(e) {

            swal({
                title: "",
                text: "ต้องการ ยืนยันการใช้ข้อมูล ?",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ปิด",
                closeOnConfirm: false
            }, async (isConfirm) => {
                if (isConfirm) {
                    const resData = await this.confirmSampleResult();
                    this.$emit("onConfirmSampleResult", {
                        sample_no: this.sampleData.sample_no,
                        sample_operation_status: this.sampleData.sample_operation_status,
                        sample_operation_status_desc: this.sampleData.sample_operation_status_desc,
                        sample_result_status: this.sampleData.sample_result_status,
                        sample_result_status_desc: this.sampleData.sample_result_status_desc,
                        confirm_code: resData.confirm_code
                    });
                }
            });
        },

        async confirmSampleResult() {

            const reqBody = {
                sample_no: this.sampleData.sample_no,
            };

            // SHOW LOADING
            this.isLoading = true;

            // CALL STORE SAMPLE RESULT
            const resData = await axios.post(`/qm/ajax/qtm-machines/confirm`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resSample = resData.sample ? JSON.parse(resData.sample) : null;
                
                if(resSample) {
                    this.sampleData.sample_operation_status = resSample.sample_operation_status;
                    this.sampleData.sample_operation_status_desc = resSample.sample_operation_status_desc;
                    this.sampleData.sample_result_status = resSample.sample_result_status;
                    this.sampleData.sample_result_status_desc = resSample.sample_result_status_desc;
                }

                if(resData.status == "success") {
                    swal("Success", `ยืนยันผลการตรวจสอบด้วยเครื่อง QTM (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no} )`, "success");
                }

                if(resData.status == "error") {
                    swal("Error", `ยืนยันผลการตรวจสอบด้วยเครื่อง QTM (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no}) | ${resMsg}`, "error");
                }
                
                return resData;

            })
            .catch((error) => {
                console.log(error);
                swal("Error", `บันทึกลงผลการตรวจสอบด้วยเครื่อง QTM (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no})  | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;
            return resData;

        },

        onRejectSampleResult(e) {

            swal({
                title: "ต้องการ ยกเลิกการใช้ข้อมูล ?",
                type: "input",
                text: "กรุณากรอกเหตุผลการยกเลิก",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "ยกเลิกการใช้ข้อมูล",
                cancelButtonText: "ปิด",
                closeOnConfirm: false
            }, async (inputValue) => {

                if (inputValue === false || inputValue === "") {
                    swal.showInputError("กรุณากรอกเหตุผลการยกเลิก ! ");
                    return false;
                }

                const rejectReason = inputValue;
                const resData = await this.rejectSampleResult(rejectReason);

                this.$emit("onRejectSampleResult", {
                    sample_no: this.sampleData.sample_no,
                    sample_operation_status: this.sampleData.sample_operation_status,
                    sample_operation_status_desc: this.sampleData.sample_operation_status_desc,
                    sample_result_status: this.sampleData.sample_result_status,
                    sample_result_status_desc: this.sampleData.sample_result_status_desc,
                    confirm_code: resData.confirm_code,
                    reject_reason: rejectReason
                });

            });

        },

        async rejectSampleResult(rejectReason) {

            const reqBody = {
                sample_no: this.sampleData.sample_no,
                reject_reason: rejectReason,
            };

            // SHOW LOADING
            this.isLoading = true;

            // CALL STORE SAMPLE RESULT
            const resData = await axios.post(`/qm/ajax/qtm-machines/reject`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resSample = resData.sample ? JSON.parse(resData.sample) : null;
                
                if(resSample) {
                    this.sampleData.sample_operation_status = resSample.sample_operation_status;
                    this.sampleData.sample_operation_status_desc = resSample.sample_operation_status_desc;
                    this.sampleData.sample_result_status = resSample.sample_result_status;
                    this.sampleData.sample_result_status_desc = resSample.sample_result_status_desc;
                }

                if(resData.status == "success") {
                    swal("Success", `ยกเลิกการใช้ข้อมูลผลการตรวจสอบด้วยเครื่อง QTM (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no} )`, "success");
                }

                if(resData.status == "error") {
                    swal("Error", `ยกเลิกการใช้ข้อมูลผลการตรวจสอบด้วยเครื่อง QTM (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no}) | ${resMsg}`, "error");
                }
                
                return resData;

            })
            .catch((error) => {
                console.log(error);
                swal("Error", `บันทึกลงผลการตรวจสอบด้วยเครื่อง QTM (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no})  | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;
            return resData;

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
                return (item.result_value === "" || item.result_value === null) && item.read_only != 'Y';
            });

            if(incompletedResultValueLines.length > 0) {
                result.valid = false;
                result.message = `กรุณากรอกข้อมูล "ผลการตรวจสอบ" ให้ครบถ้วน`
                return result;
            }

            // VALIDATE SAMPLE_RESULT : TEST_TIME
            const sampleResultTestTime = sampleResults.find(item => item.test.time_flag == 'Y');
            if(sampleResultTestTime) {
                if(!sampleResultTestTime.result_value) {
                    result.valid = false;
                    result.message = `กรุณากรอกข้อมูล "${sampleResultTestTime.test.test_desc}"`
                    return result;
                } else {
                    if(!moment(sampleResultTestTime.result_value, "HH:mm", true).isValid()) {
                        result.valid = false;
                        result.message = `ข้อมูล "${sampleResultTestTime.test.test_desc}" ไม่ถูกต้อง กรุณาตรวจสอบ`
                        return result;
                    }
                }

            }

            return result;

        },

    }
};
</script>
