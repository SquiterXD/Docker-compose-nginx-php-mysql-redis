<template>

    <div class="ibox">

        <div class="ibox-content tw-pt-8" style="min-height: 600px;">

            <div>

                <div class="row form-group">

                    <div class="col-md-3">

                        <div class="row">

                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ปีบัญชี </label>

                            <div class="col-md-8">

                                <ct-el-select name="period_year" id="input_period_year" 
                                    :select-options="periodYears"
                                    option-key="period_year_value"
                                    option-value="period_year_value" 
                                    option-label="period_year_label" 
                                    :value="paramHeader.period_year"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onPeriodYearChanged"
                                />

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="row">

                            <label class="col-md-4 col-form-label tw-font-bold required"> งวดบัญชี </label>

                            <div class="col-md-8">
                                
                                <ct-el-select name="period_number" id="input_period_number" 
                                    :select-options="periodNumbers"
                                    option-key="period_number_value"
                                    option-value="period_number_value" 
                                    option-label="period_number_full_label" 
                                    :value="paramHeader.period_number"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onPeriodNumberChanged"
                                />

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="row">

                            <label class="col-md-4 col-form-label tw-font-bold required"> ตั้งแต่วันที่ </label>

                            <div class="col-md-8">
                                <p class="col-form-label"> {{ paramHeader.start_date_thai ? paramHeader.start_date_thai : "-" }} </p>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="row">

                            <label class="col-md-4 col-form-label tw-font-bold required"> ถึงวันที่ </label>

                            <div class="col-md-8">
                                <p class="col-form-label"> {{ paramHeader.end_date_thai ? paramHeader.end_date_thai : "-" }} </p>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="row form-group">

                    <div class="col-md-3">

                        <div class="row">

                            <label class="col-md-4 col-form-label tw-font-bold required"> ศูนย์ต้นทุน </label>

                            <div class="col-md-8">

                                <ct-el-select name="cost_code" id="input_cost_code" 
                                    :select-options="costCenters"
                                    option-key="cost_code_value"
                                    option-value="cost_code_value" 
                                    option-label="cost_code_label" 
                                    :value="paramHeader.cost_code"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onCostCenterCodeChanged"
                                />
                                
                            </div>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="row">

                            <label class="col-md-4 col-form-label tw-font-bold"> หน่วยงาน (From) </label>

                            <div class="col-md-8">

                                <ct-el-select name="dept_code_from" id="input_dept_code_from" 
                                    :select-options="ccDepartments"
                                    option-key="department_code"
                                    option-value="department_code" 
                                    option-label="department_code" 
                                    :value="paramHeader.dept_code_from"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onDeptCodeFromChanged"
                                />

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="row">

                            <label class="col-md-4 col-form-label tw-font-bold"> หน่วยงาน (To) </label>

                            <div class="col-md-8">

                                <ct-el-select name="dept_code_to" id="input_dept_code_to" 
                                    :select-options="ccDepartments"
                                    option-key="department_code"
                                    option-value="department_code" 
                                    option-label="department_code" 
                                    :value="paramHeader.dept_code_to"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onDeptCodeToChanged"
                                />

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3">

                    </div>

                </div>

                <div class="row form-group">

                    <div class="col-md-3">

                        <div class="row">

                            <label class="col-md-4 col-form-label tw-font-bold"> เลขที่คำสั่งผลิต (From) </label>

                            <div class="col-md-8">

                                <ct-el-select name="batch_no_from" id="input_batch_no_from" 
                                    :select-options="batchNumbers"
                                    option-key="batch_no"
                                    option-value="batch_no" 
                                    option-label="batch_no" 
                                    :value="paramHeader.batch_no_from"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onBatchNoFromChanged"
                                />

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="row">

                            <label class="col-md-4 col-form-label tw-font-bold"> เลขที่คำสั่งผลิต (To) </label>

                            <div class="col-md-8">
                                
                                <ct-el-select name="batch_no_to" id="input_batch_no_to" 
                                    :select-options="batchNumbers"
                                    option-key="batch_no"
                                    option-value="batch_no" 
                                    option-label="batch_no" 
                                    :value="paramHeader.batch_no_to"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onBatchNoToChanged"
                                />

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="row">

                            <label class="col-md-4 col-form-label tw-font-bold"> สถานะประมวลผล </label>

                            <div class="col-md-8">

                                <ct-el-select name="process_status" id="input_process_status" 
                                    :select-options="processStatuses"
                                    option-key="process_status"
                                    option-value="process_status" 
                                    option-label="description" 
                                    :value="paramHeader.process_status"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onProcessStatusChanged"
                                />

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div v-show="false" class="row">

                            <label class="col-md-4 col-form-label tw-font-bold"> สถานะส่งเข้า GL </label>

                            <div class="col-md-8">

                                <ct-el-select name="posting_status" id="input_posting_status" 
                                    :select-options="postingStatuses"
                                    option-key="posting_status"
                                    option-value="posting_status" 
                                    option-label="description" 
                                    :value="paramHeader.posting_status"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onPostingStatusChanged"
                                />
                                
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <hr>

            <div>

                <div class="text-left tw-mb-2">
                    
                    <button class="btn btn-inline-block btn-sm btn-primary tw-w-40"
                        @click="onQueryWorkorderProcesss"
                        :disabled="!paramHeader.period_year || !paramHeader.period_name || !paramHeader.cost_code"
                    > 
                        <i class="fa fa-search tw-mr-1"></i> แสดงข้อมูล 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-white tw-w-40"
                        @click="onClearParamHeader"
                    >
                        <i class="fa fa-times tw-mr-1"></i> ล้างการค้นหา 
                    </button>

                    <!-- <button class="btn btn-inline-block btn-sm btn-warning tw-w-40"
                        @click="onProcessWorkorderProcesss"
                        :disabled="!paramHeader.period_year || !paramHeader.period_name || !paramHeader.cost_code"
                    > 
                        <i class="fa fa-retweet tw-mr-1"></i> ประมวลผล 
                    </button> -->

                    <button class="btn btn-inline-block btn-sm btn-info tw-w-40"
                        @click="onProcessWorkorderProcesss($event, 'FINAL')"
                        :disabled="!paramHeader.period_year || !paramHeader.period_name || !paramHeader.cost_code"
                    > 
                        <i class="fa fa-retweet tw-mr-1"></i> ส่งข้อมูลเข้า GL
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-danger tw-w-40"
                        @click="onProcessWorkorderProcesss($event, 'CANCEL')"
                        :disabled="!paramHeader.period_year || !paramHeader.period_name || !paramHeader.cost_code"
                    > 
                        <i class="fa fa-retweet tw-mr-1"></i> ยกเลิกข้อมูลเข้า GL
                    </button>

                </div>

            </div>

            <hr>

            <div>

                <div class="text-left tw-mb-2">
                    
                    <button class="btn btn-inline-block btn-sm btn-white tw-w-52"
                        :disabled="true"
                    > 
                        รายงานการบันทึกบัญชี 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-white tw-w-52"
                        :disabled="true"
                    >
                        รายงานรายละเอียดวัตถุดิบที่ใช้ไป
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-white tw-w-52"
                        :disabled="true"
                    > 
                        งานระหว่างผลิตปลายงวด
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-white tw-w-52"
                        :disabled="true"
                    > 
                        รายงานบัตรต้นทุน
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-white tw-w-52"
                        :disabled="true"
                    > 
                        รายงานสรุปต้นทุนผลิต
                    </button>

                </div>

            </div>

            <!-- <hr v-if="workorderProcesses.length > 0">

            <div v-if="workorderProcesses.length > 0" class="tw-m-8"> -->

            <hr>

            <div class="tw-m-8">

                <div class="row tw-mb-5">

                    <div class="col-12">

                        <table-workorder-processes 
                            :param-id-value="paramId"
                            :param-header="paramHeader"
                            :workorder-processes="workorderProcesses" 
                            :uom-codes="uomCodes"
                            @onWorkorderProcessSaved="onWorkorderProcessSaved"
                        >
                        </table-workorder-processes>

                    </div>

                </div>

            </div>
            
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableWorkorderProcesses from "./TableWorkorderProcesses";

export default {
    
    components: { Loading, TableWorkorderProcesses },

    props: [ "defaultData", "paramIdValue", "processStepValue", "periodYearValue", "periodNameValue", "processStatusValue", "postingStatusValue", "costCodeValue", "deptCodeFromValue" , "deptCodeToValue", "batchNoFromValue" , "batchNoToValue","processSteps", "periodYears", "processStatuses", "postingStatuses", "costCenters", "uomCodes" ],

    mounted() {
    
        if (this.periodYearValue) {
            // GET PERIOD NUMBERS
            this.getListPeriodNumbers(this.periodYearValue).then((value) => {
                if(this.periodNameValue) {
                    this.paramHeader.period_number = this.getPeriodNumber(this.periodNumbers, this.periodNameValue);
                    this.paramHeader.start_date = this.getPeriodStartDate(this.periodNumbers, this.periodNameValue, "EN");
                    this.paramHeader.end_date = this.getPeriodEndDate(this.periodNumbers, this.periodNameValue, "EN");
                    this.paramHeader.start_date_thai = this.getPeriodStartDate(this.periodNumbers, this.periodNameValue, "TH");
                    this.paramHeader.end_date_thai = this.getPeriodEndDate(this.periodNumbers, this.periodNameValue, "TH");
                }
            });
        }

        if (this.paramIdValue) {
            this.onGetWorkorderProcesss(this.paramIdValue);
        }

        if (this.costCodeValue) {
            this.getListCostDepartment(this.costCodeValue);
            this.getBatchNumbers(this.costCodeValue);
        }

    },

    data() {
        return {
            organizationId: this.defaultData ? JSON.parse(this.defaultData).organization_id : null,
            organizationCode: this.defaultData ? JSON.parse(this.defaultData).organization_code : null,
            department: this.defaultData ? JSON.parse(this.defaultData).department : null,
            paramId: this.paramIdValue,
            paramHeader: {
                period_year: this.periodYearValue,
                period_year_label: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
                period_name: this.periodNameValue,
                period_number: '',
                start_date: '',
                end_date: '',
                start_date_thai: '',
                end_date_thai: '',
                cost_code: this.costCodeValue,
                dept_code_from: this.deptCodeFromValue,
                dept_code_to: this.deptCodeToValue,
                batch_no_from: this.batchNoFromValue,
                batch_no_to: this.batchNoToValue,
                process_status: this.processStatusValue, 
                posting_status: this.postingStatusValue,
            },
            batchNumbers: [],
            periodNumbers: [],
            ccDepartments: [],
            workorderProcesses: [],
            workorderImportFileList: [],
            isVerified: false,
            isLoading: false
        }
    },

    computed: {

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("param_id", this.paramId);
            queryParams.set("period_year", this.paramHeader.period_year);
            queryParams.set("period_name", this.paramHeader.period_name);
            queryParams.set("process_status", this.paramHeader.process_status);
            queryParams.set("posting_status", this.paramHeader.posting_status);
            queryParams.set("cost_code", this.paramHeader.cost_code);
            queryParams.set("dept_code_from", this.paramHeader.dept_code_from);
            queryParams.set("dept_code_to", this.paramHeader.dept_code_to);
            queryParams.set("batch_no_from", this.paramHeader.batch_no_from);
            queryParams.set("batch_no_to", this.paramHeader.batch_no_to);
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        async getListPeriodNumbers(periodYear) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.periodNumbers = [];
            
            var params = { 
                period_year: periodYear
            };
            
            this.periodNumbers = await axios.get("/ajax/ct/workorders/processes/get-period-numbers", { params })
            .then(res => {
                const resData = res.data.data;
                return resData.period_numbers ? JSON.parse(resData.period_numbers) : [];
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ข้อมูลปี ${this.paramHeader.period_year_label} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });

            // hide loading
            this.isLoading = false;

        },

        async getListCostDepartment(costCode) {

            // show loading
            this.isLoading = true;
            
            var params = { 
                cost_code: costCode
            };
            
            this.ccDepartments = await axios.get("/ajax/ct/workorders/processes/get-cost-departments", { params })
            .then(res => {
                const resData = res.data.data;
                return resData.departments ? JSON.parse(resData.departments) : [];
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูล หน่วยงาน จากศูนย์ต้นทุน ${costCode} | ${error.message}`, "error");
                return ;
            });

            // hide loading
            this.isLoading = false;

        },

        async getBatchNumbers(costCode) {

            // show loading
            this.isLoading = true;
            
            var params = { 
                cost_code: costCode
            };
            
            this.batchNumbers = await axios.get("/ajax/ct/workorders/processes/get-batch-numbers", { params })
            .then(res => {
                const resData = res.data.data;
                return resData.batch_numbers ? JSON.parse(resData.batch_numbers) : [];
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูล เลขที่คำสั่งผลิต จากศูนย์ต้นทุน ${costCode} | ${error.message}`, "error");
                return ;
            });

            // hide loading
            this.isLoading = false;

        },

        async onPeriodYearChanged(value) {
            
            this.paramHeader.period_year = value;
            this.paramHeader.period_year_label = this.getPeriodYearLabel(this.periodYears, value);

            this.paramHeader.period_name = '';
            this.paramHeader.period_number = '';
            this.paramHeader.start_date = '';
            this.paramHeader.end_date = '';
            this.paramHeader.start_date_thai = '';
            this.paramHeader.end_date_thai = '';

            this.getListPeriodNumbers(this.paramHeader.period_year);

            this.setUrlParams();
            
        },

        async onCostCenterCodeChanged(value) {
            
            this.paramHeader.cost_code = value;

            this.getBatchNumbers(this.paramHeader.cost_code);
            this.getBatchNumbers(this.paramHeader.cost_code);

            this.setUrlParams();
            
        },

        async onPeriodNumberChanged(value) {
            
            this.paramHeader.period_name = value;
            this.paramHeader.period_number = this.getPeriodNumber(this.periodNumbers, value);
            this.paramHeader.start_date = this.getPeriodStartDate(this.periodNumbers, value, "EN");
            this.paramHeader.end_date = this.getPeriodEndDate(this.periodNumbers, value, "EN");
            this.paramHeader.start_date_thai = this.getPeriodStartDate(this.periodNumbers, value, "TH");
            this.paramHeader.end_date_thai = this.getPeriodEndDate(this.periodNumbers, value, "TH");

            this.setUrlParams();
            
        },

        async onDeptCodeFromChanged(value) {
            
            this.paramHeader.dept_code_from = value;
            this.setUrlParams();
            
        },

        async onDeptCodeToChanged(value) {
            
            this.paramHeader.dept_code_to = value;
            this.setUrlParams();
            
        },

        async onBatchNoFromChanged(value) {
            
            this.paramHeader.batch_no_from = value;
            this.setUrlParams();
            
        },

        async onBatchNoToChanged(value) {
            
            this.paramHeader.batch_no_to = value;
            this.setUrlParams();
            
        },

        async onProcessStatusChanged(value) {
            
            this.paramHeader.process_status = value;
            this.setUrlParams();
            
        },

        async onPostingStatusChanged(value) {
            
            this.paramHeader.posting_status = value;
            this.setUrlParams();
            
        },

        getProcessStepLabel(processSteps, stepCode) {
            const foundStep = processSteps.find(item => item.step_code == stepCode);
            return foundStep ? foundStep.description : "";
        },

        getPeriodYearLabel(periodYears, periodYear) {
            const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
            return foundPeriodYear ? foundPeriodYear.period_year_label : "";
        },

        getPeriodNumber(periodNumbers, periodName) {
            const foundPeriodNumber = periodNumbers.find(item => item.period_number_value == periodName);
            return foundPeriodNumber ? foundPeriodNumber.period_number_label : "";
        },

        getPeriodStartDate(periodNumbers, periodName, dateType) {
            
            let result = null;
            const foundPeriodNumber = periodNumbers.find(item => item.period_number_value == periodName);
            
            result = foundPeriodNumber ? foundPeriodNumber.start_date : "";
            if(dateType == "TH") {
                result = foundPeriodNumber ? foundPeriodNumber.start_date_thai : "";
            }
            return result;

        },

        getPeriodEndDate(periodNumbers, periodName, dateType) {

            let result = null;

            const foundPeriodNumber = periodNumbers.find(item => item.period_number_value == periodName);

            result = foundPeriodNumber ? foundPeriodNumber.end_date : "";
            if(dateType == "TH") {
                result = foundPeriodNumber ? foundPeriodNumber.end_date_thai : "";
            }
            return result;

        },

        getProcessStatusDesc(status) {
            let statusDesc = "-";
            if(status) {
                const foundStatus = this.processStatuses.find(item => item.process_status == status);
                statusDesc = foundStatus ? foundStatus.description : "-"; 
            }
            return statusDesc;
        },

        getPostingStatusDesc(status) {
            let statusDesc = "-";
            if(status) {
                const foundStatus = this.postingStatuses.find(item => item.posting_status == status);
                statusDesc = foundStatus ? foundStatus.description : "-"; 
            }
            return statusDesc;
        },

        async onClearParamHeader() {

            this.paramHeader.period_year = '';
            this.paramHeader.period_year_label = '';
            this.paramHeader.period_name = '';
            this.paramHeader.period_number = '';
            this.paramHeader.start_date = '';
            this.paramHeader.end_date = '';
            this.paramHeader.start_date_thai = '';
            this.paramHeader.end_date_thai = '';
            this.paramHeader.cost_code = '';
            this.paramHeader.dept_code_from = '';
            this.paramHeader.dept_code_to = '';
            this.paramHeader.batch_no_from = '';
            this.paramHeader.batch_no_to = '';
            this.paramHeader.process_status = '';
            this.paramHeader.posting_status = '';

            this.periodNumbers = [];
            this.ccDepartments = [];

            this.setUrlParams();

        },

        async onQueryWorkorderProcesss() {

            await this.queryWorkorderProcess(true);
            this.setUrlParams();

        },

        async queryWorkorderProcess(showAlert) {

            // SHOW LOADING
            this.isLoading = true;

            const resValidate = this.validateBeforeQuery(this.paramHeader);
            if(resValidate.valid) {

                // GENERATE TRANSACTIONS
                const reqBody = {
                    process_step: "SELECT",
                    period_year: this.paramHeader.period_year,
                    period_year_label: this.paramHeader.period_year_label,
                    period_name: this.paramHeader.period_name,
                    period_number: this.paramHeader.period_number,
                    start_date: this.paramHeader.start_date,
                    end_date: this.paramHeader.end_date,
                    start_date_thai: this.paramHeader.start_date_thai,
                    end_date_thai: this.paramHeader.end_date_thai,
                    cost_code: this.paramHeader.cost_code,
                    dept_code_from: this.paramHeader.dept_code_from,
                    dept_code_to: this.paramHeader.dept_code_to,
                    batch_no_from: this.paramHeader.batch_no_from,
                    batch_no_to: this.paramHeader.batch_no_to,
                    process_status: this.paramHeader.process_status,
                    posting_status: this.paramHeader.posting_status,
                };

                await axios.post(`/ajax/ct/workorders/processes/query-trans`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    // if(resData.status == "success") {

                    this.paramId = resData.param_id ? resData.param_id : null;
                    if(this.paramId) {
                        // GET WORKER PROESS
                        this.onGetWorkorderProcesss(this.paramId);
                        if(showAlert) {
                            swal("Success", `แสดงข้อมูลคำสั่งผลิต`, "success");
                        }
                    } else {
                        // swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูลคำสั่งผลิต | ${resData.message}`, "error");
                    }

                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถแสดงข้อมูลคำสั่งผลิต  | ${error.message}`, "error");
                });

            } else {
                swal("เกิดข้อผิดพลาด", `ไม่สามารถแสดงข้อมูลคำสั่งผลิต | ${resValidate.message}`, "error");
            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async onProcessWorkorderProcesss(e, processStep) {

            // show loading
            this.isLoading = true;

            const processStepLabel = processStep == "FINAL" ? "ส่งข้อมูลเข้า GL" : "ยกเลิกข้อมูลเข้า GL";

            const resValidate = this.validateBeforeProcess(this.paramHeader);
            if(resValidate.valid) {

                // GENERATE TRANSACTIONS
                const reqBody = {
                    process_step: processStep,
                    period_year: this.paramHeader.period_year,
                    period_year_label: this.paramHeader.period_year_label,
                    period_name: this.paramHeader.period_name,
                    period_number: this.paramHeader.period_number,
                    start_date: this.paramHeader.start_date,
                    end_date: this.paramHeader.end_date,
                    start_date_thai: this.paramHeader.start_date_thai,
                    end_date_thai: this.paramHeader.end_date_thai,
                    cost_code: this.paramHeader.cost_code,
                    dept_code_from: this.paramHeader.dept_code_from,
                    dept_code_to: this.paramHeader.dept_code_to,
                    batch_no_from: this.paramHeader.batch_no_from,
                    batch_no_to: this.paramHeader.batch_no_to,
                    process_status: this.paramHeader.process_status,
                    posting_status: this.paramHeader.posting_status,
                };

                await axios.post(`/ajax/ct/workorders/processes/process-trans`, reqBody)
                .then(res => {

                    const resData = res.data.data;

                    if(resData.status == "success") {
                        this.paramId = resData.param_id ? resData.param_id : null;
                        if(this.paramId) {
                            // GET WORKER PROESS
                            this.onGetWorkorderProcesss(this.paramId);
                            swal("Success", `${processStepLabel} สำเร็จ`, "success");
                        } else {
                            swal("เกิดข้อผิดพลาด", `ไม่สามารถ ${processStepLabel} ( param_id is null ) | ${resData.message}`, "error");
                        }
                    } else {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถ ${processStepLabel} | ${resData.message}`, "error");
                    }

                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถ ${processStepLabel} | ${error.message}`, "error");
                });

            } else {
                swal("เกิดข้อผิดพลาด", `ไม่สามารถ ${processStepLabel} | ${resValidate.message}`, "error");
            }

            // hide loading
            this.isLoading = false;

            this.setUrlParams();

        },

        async onGetWorkorderProcesss(paramId) {

            // show loading
            this.isLoading = true;

            // GET DAILY TRANSACTIONS
            var getParams = { 
                param_id: paramId,
            };
            await axios.get(`/ajax/ct/workorders/processes/get-trans`, { params: getParams })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.workorderProcesses = resData.transactions ? JSON.parse(resData.transactions) : [];

                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถแสดงข้อมูลคำสั่งผลิต | ${resData.message}`, "error");                    
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถแสดงข้อมูลคำสั่งผลิต  | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        async onWorkorderProcessSaved(data) {
            
            await this.queryWorkorderProcess(false);
            this.setUrlParams();

        },

        validateBeforeGenerate(paramHeader) {

            const result = {
                valid: true,
                message: "",
            };

            if(!paramHeader.period_year){
                result.valid = false;
                result.message = `กรุณาเลือกข้อมูลปีบัญชี`
            }
            if(!paramHeader.period_number){
                result.valid = false;
                result.message = `กรุณาเลือกข้อมูลงวดบัญชี`
            }
            if(!paramHeader.cost_code){
                result.valid = false;
                result.message = `กรุณากรอกข้อมูลศูนย์ต้นทุน`
            }

            return result;

        },

        validateBeforeQuery(paramHeader) {

            const result = {
                valid: true,
                message: "",
            };

            if(!paramHeader.period_year){
                result.valid = false;
                result.message = `กรุณาเลือกข้อมูลปีบัญชี`
            }
            if(!paramHeader.period_number){
                result.valid = false;
                result.message = `กรุณาเลือกข้อมูลงวดบัญชี`
            }
            if(!paramHeader.cost_code){
                result.valid = false;
                result.message = `กรุณากรอกข้อมูลศูนย์ต้นทุน`
            }

            return result;

        },

        validateBeforeProcess(paramHeader) {

            const result = {
                valid: true,
                message: "",
            };

            if(!paramHeader.period_year){
                result.valid = false;
                result.message = `กรุณาเลือกข้อมูลปีบัญชี`
            }
            if(!paramHeader.period_number){
                result.valid = false;
                result.message = `กรุณาเลือกข้อมูลงวดบัญชี`
            }
            if(!paramHeader.cost_code){
                result.valid = false;
                result.message = `กรุณากรอกข้อมูลศูนย์ต้นทุน`
            }

            return result;

        },
        
        validateBeforeSave(paramHeader, workorderProcesses) {

            const result = {
                valid: true,
                message: "",
            };

            // IF NEW LINE ISN'T COMPLETED
            // const incompletedProcesses = workorderProcesses.filter(item => {
            //     return item.is_new_line && (
            //         !item.level ||
            //         !item.ratio
            //     ) && item.marked_as_deleted == false;
            // });

            // if(incompletedProcesses.length > 0) {
            //     result.valid = false;
            //     result.message = `กรอกข้อมูลรายการคำสั่งผลิตไม่ครบถ้วน กรุณาตรวจสอบ`
            // }

            return result;

        },

        // async onSaveWorkorderProcess() {

        //     const reqBody = {
        //         period_year: this.paramHeader.period_year,
        //         param_header: JSON.stringify(this.paramHeader),
        //         workorder_processes: JSON.stringify(this.workorderProcesses)
        //     };

        //     // show loading
        //     this.isLoading = true;

        //     const resValidate = this.validateBeforeSave(this.paramHeader, this.workorderProcesses);

        //     if(resValidate.valid) {

        //         // call store sample result
        //         await axios.post(`/ajax/ct/workorders/processes/store-processes`, reqBody)
        //         .then(res => {

        //             const resData = res.data.data;
        //             const resMsg = resData.message;
        //             const resPlanHeader = resData.param_header ? resData.param_header : null;

        //             if(resData.status == "success") {
        //                 this.paramHeader = resPlanHeader;
        //             }

        //             if(resData.status == "error") {
        //                 swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลประมวลผลคำสั่งผลิต : ${this.paramHeader.period_year_label} | ${resMsg}`, "error");
        //             }
                    
        //             return resData;

        //         }).catch((error) => {
        //             console.log(error);
        //             swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลประมวลผลคำสั่งผลิต : ${this.paramHeader.period_year_label} | ${error.message}`, "error");
        //         });

        //     } else {
        //         swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลประมวลผลคำสั่งผลิต : ${this.paramHeader.period_year_label} | ${resValidate.message}`, "error");
        //     }

        //     // hide loading
        //     this.isLoading = false;

        // },

    }

}

</script>