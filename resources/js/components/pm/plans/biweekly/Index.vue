<template>

    <div class="ibox">

        <div class="ibox-content" style="min-height: 600px;">

            <div class="tw-mb-4">

                <div class="text-right tw-mb-2">
                    <button class="btn btn-inline-block btn-sm btn-success tw-w-40"
                        @click="onCreateNewBiweeklyPlanVersion"
                        :disabled="!isAllowCreateNewPlanVersion(biweeklyPlanVersions)"
                    > 
                        <i class="fa fa-plus tw-mr-1"></i> สร้าง 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-primary tw-w-40"
                        @click="onSaveBiweeklyPlan"
                        :disabled="!periodYear || !periodName || !biweekly || biweeklyPlanLines.length == 0 || (biweeklyPlanHeader ? biweeklyPlanHeader.status != '1' : true)"
                    > 
                        <i class="fa fa-save tw-mr-1"></i> บันทึก 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-white tw-w-40"
                        @click="$modal.show('modal-search-plan')">
                        <i class="fa fa-search tw-mr-1"></i> ค้นหา 
                    </button>

                    
                </div>
                
                <div class="text-right">

                    <button class="btn btn-inline-block btn-sm btn-info tw-w-40"
                        @click="onGenerateBiweeklyPlanLines"
                        :disabled="!periodYear || !periodName || !biweekly || (biweeklyPlanHeader ? biweeklyPlanHeader.status != '1' : false)"
                    > 
                        <i class="fa fa-calculator tw-mr-1"></i> เรียกข้อมูลจากแผน 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-warning tw-w-40"
                        @click="onSubmitApprovalBiweeklyPlan"
                        :disabled="(biweeklyPlanHeader ? biweeklyPlanHeader.status != '1' : true) || biweeklyPlanLines.length == 0  || isNewlyCreate"
                    > 
                        <i class="fa fa-check-square tw-mr-1"></i> ส่งอนุมัติ 
                    </button>
                    
                    <button class="btn btn-inline-block btn-sm btn-primary tw-w-40"
                        :disabled="biweeklyPlanHeader ? biweeklyPlanHeader.status == '1' : true"
                    > 
                        <i class="fa fa-print tw-mr-1"></i> พิมพ์รายงาน 
                    </button>

                    
                </div>

            </div>

            <hr>

            <div>

                <div class="row">

                    <div class="col-md-6">

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> ระบบการพิมพ์ </label>

                            <div class="col-md-8">

                                <pm-el-select name="print_type" id="input_print_type" 
                                    :select-options="printTypes"
                                    option-key="print_type_value"
                                    option-value="print_type_value" 
                                    option-label="print_type_label"
                                    :value="printType"
                                    :filterable="true"
                                />

                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> ประเภทแผน </label>

                            <div class="col-md-8">

                                <pm-el-select name="sale_type" id="sale_type" 
                                    :select-options="saleTypes"
                                    option-key="value"
                                    option-value="value" 
                                    option-label="description"
                                    :value="saleType"
                                    :filterable="true"
                                    @onSelected="onSaleTypeChanged"
                                />

                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> แผนประมาณการ <br> จำหน่ายประจำปี </label>

                            <div class="col-md-8">

                                <pm-el-select name="period_year" id="input_period_year" 
                                    :select-options="periodYears"
                                    option-key="period_year_value"
                                    option-value="period_year_value" 
                                    option-label="period_year_label" 
                                    :value="periodYear" 
                                    :filterable="true"
                                    @onSelected="onYearlyPlanChanged"
                                />

                                
                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> ประจำเดือน </label>

                            <div class="col-md-3">

                                <pm-el-select name="period_name" id="input_period_name" 
                                    :select-options="periodNames"
                                    option-key="period_name_value"
                                    option-value="period_name_value" 
                                    option-label="period_name_label" 
                                    :value="periodName" 
                                    :filterable="true"
                                    @onSelected="onPeriodNameChanged"
                                />

                            </div>

                            <label class="col-md-2 col-form-label tw-font-bold"> ครั้งที่ </label>

                            <div class="col-md-3">

                                <pm-el-select v-if="isAllowSelectSourceVersion(biweeklyPlanHeader, biweeklyPlanLines)"
                                    name="source_version" 
                                    id="source_version" 
                                    :select-options="sourceVersions"
                                    option-key="source_version"
                                    option-value="source_version" 
                                    option-label="source_version" 
                                    :value="sourceVersion"
                                    :filterable="true"
                                    @onSelected="onSourceVersionChanged"
                                />
                                <p v-if="!isAllowSelectSourceVersion(biweeklyPlanHeader, biweeklyPlanLines)" class="col-form-label"> {{ sourceVersion }} </p>

                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> ปักษ์ </label>

                            <div class="col-md-8">

                                <pm-el-select name="biweekly" id="input_biweekly" 
                                    :select-options="biweeklys"
                                    option-key="biweekly_value"
                                    option-value="biweekly_value" 
                                    option-label="biweekly_label" 
                                    :value="biweekly" 
                                    :filterable="true"
                                    @onSelected="onBiweekOfPlanChanged"
                                />

                                
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> เวอร์ชั่น </label>

                            <div class="col-md-8">
                                <p v-if="biweeklyPlanHeader" class="col-form-label"> {{ biweeklyPlanHeader.version ? biweeklyPlanHeader.version : "-" }} </p>
                                <p v-if="!biweeklyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> สถานะ </label>

                            <div class="col-md-8">
                                <p v-if="biweeklyPlanHeader" class="col-form-label"> {{ getPlanStatusDesc(biweeklyPlanHeader.status) }} </p>
                                <p v-if="!biweeklyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> ผู้อนุมัติ </label>

                            <div class="col-md-8">
                                <p v-if="biweeklyPlanHeader" class="col-form-label"> {{ biweeklyPlanHeader.attribute12 ? biweeklyPlanHeader.attribute12 : "-" }} </p>
                                <p v-if="!biweeklyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> วันที่อนุมัติ </label>

                            <div class="col-md-8">
                                <p v-if="biweeklyPlanHeader" class="col-form-label"> 
                                    {{ biweeklyPlanHeader.approved_date ? formatDateTh(biweeklyPlanHeader.approved_date) : "" }}
                                </p>
                                <p v-if="!biweeklyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> วันที่แก้ไขล่าสุด </label>

                            <div class="col-md-8">
                                <p v-if="biweeklyPlanHeader" class="col-form-label"> 
                                    {{ biweeklyPlanHeader.last_update_date ? formatDateTh(biweeklyPlanHeader.last_update_date) : "" }}
                                </p>
                                <p v-if="!biweeklyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <hr>

            <div v-if="biweeklyPlanLines.length > 0" class="tw-m-8">

                <div class="row">

                    <div class="col-12">

                        <table-plan-lines 
                            :plan-header="biweeklyPlanHeader" 
                            :plan-lines="biweeklyPlanLines" 
                            :uom-codes="uomCodes"
                            @onPlanLineChanged="onPlanLineChanged"
                        />

                    </div>

                </div>

            </div>
            
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

        <!-- MODAL SEARCH PLAN -->
        <modal-search-plan 
            modal-name="modal-search-plan" 
            modal-width="640" 
            modal-height="auto"
            :period-years="periodYears"
            :period-year-value="periodYear"
            :period-names="periodNames"
            :period-name-value="periodName"
            :biweeklys="biweeklys"
            :biweekly-value="biweekly"
            :print-types="printTypes"
            :print-type-value="printType"
            :sale-types="saleTypes"
            :sale-type-value="saleType"
            :source-versions="sourceVersions"
            :source-version-value="sourceVersion"
            :biweekly-plan-version-value="biweeklyPlanVersion"
            :biweekly-plan-versions="biweeklyPlanVersions"
            @onSearchPlanVersion="onSearchPlanVersion"
        />

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TablePlanLines from "./TablePlanLines";
import ModalSearchPlan from "./ModalSearchPlan";

export default {
    
    components: { Loading, TablePlanLines, ModalSearchPlan },

    props: [ "periodYears", "periodYearValue", "periodNameValue", "biweeklyValue", "planStatuses", "printTypes", "printTypeValue", "saleTypes", "saleTypeValue", "sourceVersionValue", "uomCodes" ],

    mounted() {

        if (this.periodYearValue) {
            
            // GET MONTH OF PLANS
            this.getPeriodNames(this.periodYearValue).then((value) => {

                if(this.periodNameValue) {

                    this.periodNameLabel = this.getPeriodNameLabel(this.periodNames, this.periodNameValue);

                    this.getBiweekOfPlans(this.periodYearValue, this.periodNameValue).then((value) => {

                        if(this.biweeklyValue && this.printTypeValue && this.saleTypeValue && this.sourceVersionValue) {
                            // GET HALF-MONTHLY PLAN DATA
                            this.getSourceVersions(this.periodYearValue, this.periodNameValue, this.printTypeValue, this.saleTypeValue).then((value) => {
                                this.getBiweeklyPlanData(this.periodYearValue, this.periodNameValue, this.biweeklyValue, this.printTypeValue, this.saleTypeValue, this.sourceVersionValue, null);
                            });
                        }

                    });

                }

            });

        }
    },

    data() {
        return {
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
            periodName: this.periodNameValue,
            periodNameLabel: "",
            biweekly: this.biweeklyValue,
            printType: this.printTypeValue ? this.printTypeValue : (this.printTypes.length > 0 ? this.printTypes[0].print_type_value : null),
            printTypeLabel: this.printTypeValue ? this.getPrintTypeLabel(this.printTypes, this.printTypeValue) : (this.printTypes.length > 0 ? this.printTypes[0].print_type_label : null),
            saleType: this.saleTypeValue ? this.saleTypeValue : (this.saleTypes.length > 0 ? this.saleTypes[0].value : null),
            saleTypeLabel: this.saleTypeValue ? this.getPrintTypeLabel(this.saleTypes, this.saleTypeValue) : (this.saleTypes.length > 0 ? this.saleTypes[0].description : null),
            sourceVersion: this.sourceVersionValue ? this.sourceVersionValue : null,
            sourceVersions: [],
            periodNames: [],
            biweeklys: [],
            biweeklyPlanHeader: null,
            biweeklyPlanVersion: null,
            biweeklyPlanLines: [],
            biweeklyPlanVersions: [],
            isNewlyCreate: false,
            isLoading: false
        }
    },

    computed: {

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("period_year", this.periodYear ? this.periodYear : '');
            queryParams.set("period_name", this.periodName ? this.periodName : '');
            queryParams.set("biweekly", this.biweekly ? this.biweekly : '');
            queryParams.set("print_type", this.printType ? this.printType : '');
            queryParams.set("sale_type", this.saleType ? this.saleType : '');
            queryParams.set("source_version", this.sourceVersion ? this.sourceVersion : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        onYearlyPlanChanged(value) {
            
            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);
            this.setUrlParams();

            // REFRESH DATA
            this.periodName = null;
            this.periodNameLabel = "";
            this.periodNames = [];

            this.biweekly = null;
            this.biweeklys = [];

            this.sourceVersion = null;
            this.sourceVersions = [];

            this.biweeklyPlanHeader = null;
            this.biweeklyPlanVersion = null;
            this.biweeklyPlanVersions = [];
            this.biweeklyPlanLines = [];
            
            this.getPeriodNames(this.periodYear);
            
        },

        async onPeriodNameChanged(value) {
            
            this.periodName = value;
            this.periodNameLabel = this.getPeriodNameLabel(this.periodNames, this.periodName);
            this.setUrlParams();

            // REFRESH DATA
            this.biweekly = null;
            this.biweeklys = [];

            this.biweeklyPlanHeader = null;
            this.biweeklyPlanVersion = null;
            this.biweeklyPlanVersions = [];
            this.biweeklyPlanLines = [];

            await this.getSourceVersions(this.periodYear, this.periodName, this.printType, this.saleType);

            this.getBiweekOfPlans(this.periodYear, this.periodName)

        },

        async onBiweekOfPlanChanged(value) {
            
            this.biweekly = value;
            this.setUrlParams();

            this.biweeklyPlanVersion = null;
            this.biweeklyPlanVersions = [];

            if(this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
                this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        onSourceVersionChanged(value) {
            
            this.sourceVersion = value;
            this.setUrlParams();

            // if(this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
            //     this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, null);
            // }

        },

        onPrintTypeChanged(value) {
            
            this.printType = value;
            this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);
            this.setUrlParams();

            if(this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
                this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        onSaleTypeChanged(value) {
            
            this.saleType = value;
            this.saleTypeLabel = this.getSaleTypeLabel(this.saleTypes, this.saleType);
            this.setUrlParams();

            if(this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
                this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        onSearchPlanVersion(data) {
            
            this.periodYear = data.period_year;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);

            this.periodName = data.period_name;
            this.periodNameLabel = this.getPeriodNameLabel(this.periodNames, this.periodName);

            this.biweekly = data.biweekly;
            this.biweeklyPlanVersion = data.version;

            this.printType = data.print_type;
            this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);

            this.saleType = data.sale_type;
            this.saleTypeLabel = this.getPrintTypeLabel(this.saleTypes, this.saleType);

            this.sourceVersion = data.source_version;
            this.sourceVersions = data.source_versions;

            this.biweeklyPlanLines = [];

            this.getPeriodNames(this.periodYear);
            this.getBiweekOfPlans(this.periodYear, this.periodName);

            if(this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
                this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, this.biweeklyPlanVersion);
            }

        },

        getPeriodYearLabel(periodYears, periodYear) {
            const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
            return foundPeriodYear ? foundPeriodYear.period_year_label : "";
        },

        getPeriodNameLabel(periodNames, periodName) {
            const foundPeriodName = periodNames.find(item => item.period_name_value == periodName);
            return foundPeriodName ? foundPeriodName.period_name_label : "";
        },

        getPrintTypeLabel(printTypes, printType) {
            const foundPrintType = printTypes.find(item => item.print_type_value == printType);
            return foundPrintType ? foundPrintType.print_type_label : "";
        },

        getSaleTypeLabel(saleTypes, saleType) {
            const foundSaleType = saleTypes.find(item => item.value == saleType);
            return foundSaleType ? foundSaleType.description : "";
        },

        async getPeriodNames(periodYear) {

            // show loading
            this.isLoading = true;
            
            var params = { 
                period_year: periodYear
            };
            
            this.periodNames = await axios.get("/ajax/pm/plans/biweekly/get-months", { params })
            .then(res => {
                const resData = res.data.data;
                return resData.period_names ? JSON.parse(resData.period_names) : [];
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ปี ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });

            // hide loading
            this.isLoading = false;

        },

        async getBiweekOfPlans(periodYear, periodName) {

            // show loading
            this.isLoading = true;

            var params = { 
                period_year: periodYear,
                period_name: periodName
            };
            
            this.biweeklys = await axios.get("/ajax/pm/plans/biweekly/get-biweeks", { params })
            .then(res => {
                const resData = res.data.data;
                return resData.biweeklys ? JSON.parse(resData.biweeklys) : [];
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });

            // hide loading
            this.isLoading = false;

        },

        async getBiweeklyPlanData(periodYear, periodName, biweekly, printType, saleType, sourceVersion, version) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.biweeklyPlanHeader = null;
            this.biweeklyPlanVersion = version;
            this.biweeklyPlanVersions = [];
            this.biweeklyPlanLines = [];
            
            var params = { 
                period_year: periodYear, 
                period_name: periodName,
                biweekly: biweekly,
                print_type: printType,
                sale_type: saleType,
                source_version: sourceVersion,
                version: version
            };
            await axios.get("/ajax/pm/plans/biweekly/get-info", { params })
            .then(res => {
                const resData = res.data.data;
                this.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                this.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });
            if(this.biweeklyPlanHeader) {
                // FOUND PLAN
                this.biweeklyPlanVersion = this.biweeklyPlanHeader.version;
                if(this.sourceVersions.length > 0) {
                    const foundSourceVersion = this.sourceVersions.find(item => item.source_version == this.biweeklyPlanHeader.source_version);
                    this.sourceVersion = foundSourceVersion ? foundSourceVersion.source_version : this.sourceVersions[0].source_version;
                    await this.onGetBiweeklyPlanLines();
                    this.setUrlParams();
                }
            } else {
                this.biweeklyPlanVersion = null;
            }

            // hide loading
            this.isLoading = false;

        },

        async getSourceVersions(periodYear, periodName, printType, saleType) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.sourceVersion = null;
            this.sourceVersions = [];
            
            var params = { 
                period_year: periodYear,
                period_name: periodName,
                print_type: printType,
                sale_type: saleType,
            };

            await axios.get("/ajax/pm/plans/biweekly/get-source-versions", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ข้อมูลไม่ถูกต้อง | ${resData.message}`, "error");
                } else {
                    this.sourceVersion = resData.source_version ? resData.source_version : null;
                    this.sourceVersions = resData.source_versions ? JSON.parse(resData.source_versions) : [];
                    if(this.sourceVersions.length <= 0) {
                        swal("ไม่พบข้อมูล", `ไม่พบข้อมูลแผนรายเดือนที่ยืนยันแล้ว `, "error");
                    }
                }
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ข้อมูลไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });
        
            // hide loading
            this.isLoading = false;

        },

        getPlanStatusDesc(status) {
            let statusDesc = "-";
            if(status) {
                const foundStatus = this.planStatuses.find(item => item.lookup_code == status);
                statusDesc = foundStatus ? foundStatus.description : "-"; 
            }
            return statusDesc;
        },

        async onGetBiweeklyPlanLines() {

            // show loading
            this.isLoading = true;

            var params = { 
                period_year: this.periodYear, 
                period_name: this.periodName,
                biweekly: this.biweekly,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.biweeklyPlanVersion
            };
            await axios.get(`/ajax/pm/plans/biweekly/get-lines`, { params })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    this.biweeklyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    this.biweeklyPlanVersion = this.biweeklyPlanHeader.version;
                    this.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resData.message}`, "error");
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        async onGenerateBiweeklyPlanLines() {

            if(this.biweeklyPlanLines.length > 0) {

                swal({
                    title: "",
                    text: `ต้องการเรียกข้อมูลจากแผน ใหม่อีกครั้ง ?`,
                    showCancelButton: true,
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: true
                }, (isConfirm) => {
                    if (isConfirm) {
                        this.biweeklyPlanLines = [];
                        this.generateBiweeklyPlanLines();
                    }
                });

            } else {
                this.generateBiweeklyPlanLines();
            }

        },

        async generateBiweeklyPlanLines() {

            // show loading
            this.isLoading = true;

            var reqBody = { 
                period_year: this.periodYear, 
                period_name: this.periodName,
                biweekly: this.biweekly,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.biweeklyPlanVersion
            };
            await axios.post(`/ajax/pm/plans/biweekly/generate-lines`, reqBody)
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    this.biweeklyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    this.biweeklyPlanVersion = this.biweeklyPlanHeader.version;
                    this.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    this.isNewlyCreate = resData.is_newly_create;
                    
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resData.message}`, "error");
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        onPlanLineChanged(data) {
            this.biweeklyPlanLines = data.planLineItems;
        },

        async onSaveBiweeklyPlan() {

            const reqBody = {
                period_year: this.periodYear,
                period_name: this.periodName,
                biweekly: this.biweekly,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.biweeklyPlanVersion,
                plan_header: JSON.stringify(this.biweeklyPlanHeader),
                plan_lines: JSON.stringify(this.biweeklyPlanLines)
            };

            // show loading
            this.isLoading = true;

            // CALL SAVE LINES
            await axios.post(`/ajax/pm/plans/biweekly/store-lines`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;

                if(resData.status == "success") {
                    this.biweeklyPlanHeader = resPlanHeader;
                    this.biweeklyPlanVersion = resPlanHeader.version;
                    this.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    this.isNewlyCreate = false;
                    swal("Success", `บันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} version : ${this.biweeklyPlanVersion}`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        async onSubmitApprovalBiweeklyPlan() {

            const reqBody = {
                period_year: this.periodYear,
                period_name: this.periodName,
                biweekly: this.biweekly,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.biweeklyPlanVersion,
                plan_header: JSON.stringify(this.biweeklyPlanHeader),
                plan_lines: JSON.stringify(this.biweeklyPlanLines)
            };

            // show loading
            this.isLoading = true;

            // CALL SAVE BEFORE SUBMIT
            await axios.post(`/ajax/pm/plans/biweekly/store-lines`, reqBody)
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    console.log(resData.message);
                }
                return resData;
            }).catch((error) => {
                console.log(error);
            });

            // CALL SUBMIT PLAN
            await axios.post(`/ajax/pm/plans/biweekly/submit-approval`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    this.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    this.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    swal("Success", `ส่งข้อมูลแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel}`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถส่งข้อมูลแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถส่งข้อมูลแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        async onCreateNewBiweeklyPlanVersion() {

            swal({
                title: "",
                text: `ต้องการสร้าง แผนผลิตสิ่งพิมพ์รายปักษ์ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} เวอร์ชั่นใหม่ ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true
            }, (isConfirm) => {
                if (isConfirm) {
                    this.biweeklyPlanLines = [];
                    this.createNewPlanVersion();
                }
            });

        },

        isAllowSelectSourceVersion(planHeader, planLines) {

            let allowed = false;
            
            if(planHeader){
                // ALLOW WHEN PLAN LINES WERE NOT GENERATED 
                if(planLines.length == 0) {
                    allowed = true;
                }
            } else {
                // ALLOW WHEN PLAN'S NEVER BEEN CREATED
                allowed = true;
            }

            return allowed;

        },

        isAllowCreateNewPlanVersion(versions) {

            let allowed = true;

            // IF THERE IS NO PLAN VERSION
            if(versions.length == 0) {
                allowed = false;
            }

            // IF ALL VERSIONS ARE NOT COMPLETED ( 1 : NEW || 2 : WAITING_FOR_APPROVAL )
            // => NOT ALLOW TO CREATE NEW VERSION
            const inprogressVersions = versions.filter(item => {
                return (item.status == 1 || item.status == 2)
            });

            if(inprogressVersions.length > 0){
                allowed = false;
            }

            return allowed;

        },

        async createNewPlanVersion() {

            const reqBody = {
                period_year: this.periodYear,
                period_name: this.periodName,
                biweekly: this.biweekly,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion
            };

            // show loading
            this.isLoading = true;

            // call store sample result
            await axios.post(`/ajax/pm/plans/biweekly/add-new-header`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    
                    this.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    this.biweeklyPlanVersion = resData.version;
                    this.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];

                    swal("Success", `สร้างข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} version : ${this.biweeklyPlanVersion} )`, "success");

                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `สร้างข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `สร้างข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
        },

    }

}

</script>