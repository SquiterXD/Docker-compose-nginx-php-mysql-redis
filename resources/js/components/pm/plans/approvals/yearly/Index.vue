<template>

    <div class="ibox">

        <div class="ibox-content" style="min-height: 600px;">

            <div class="tw-mb-4">

                <div class="text-right tw-mb-2">

                    <button class="btn btn-inline-block btn-sm btn-success tw-w-40"
                        @click="onApprove"
                        :disabled="!isAllowApproval(yearlyPlanHeader, yearlyPlanLines)"
                    > 
                        <i class="fa fa-check tw-mr-1"></i> อนุมัติ 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-danger tw-w-40"
                        @click="onReject"
                        :disabled="!isAllowApproval(yearlyPlanHeader, yearlyPlanLines)"
                    > 
                        <i class="fa fa-times tw-mr-1"></i> ไม่อนุมัติ 
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
                                    @onSelected="onPrintTypeChanged"
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

                            <div class="col-md-3">

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

                            <label class="col-md-2 col-form-label tw-font-bold"> ครั้งที่ </label>

                            <div class="col-md-3">

                                <pm-el-select v-if="isAllowSelectSourceVersion(yearlyPlanHeader, yearlyPlanLines)"
                                    name="source_version" 
                                    id="source_version" 
                                    :select-options="sourceVersions"
                                    option-key="version"
                                    option-value="version" 
                                    option-label="version" 
                                    :value="sourceVersion"
                                    :filterable="true"
                                    @onSelected="onSourceVersionChanged"
                                />
                                <p v-if="!isAllowSelectSourceVersion(yearlyPlanHeader, yearlyPlanLines)" class="col-form-label"> {{ sourceVersion }} </p>

                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> เวอร์ชั่น </label>

                            <div class="col-md-8">

                                <pm-el-select name="yearly_plan_version" id="input_yearly_plan_version" 
                                    :select-options="yearlyPlanVersions"
                                    option-key="version"
                                    option-value="version" 
                                    option-label="version" 
                                    :value="yearlyPlanVersion"
                                    :filterable="true"
                                    @onSelected="onYearlyPlanVersionChanged"
                                />

                            </div>

                        </div>

                        <!-- <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> ประเภทวัตถุดิบ </label>

                            <div class="col-md-8">
                                <p class="col-form-label"> - </p>
                            </div>

                        </div> -->

                    </div>

                    <div class="col-md-6">

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> หน่วยงาน </label>

                            <div class="col-md-8">
                                <p class="col-form-label"> ฝ่ายการพิมพ์ กองพิมพ์ </p>
                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> สถานะ </label>

                            <div class="col-md-8">
                                <p v-if="yearlyPlanHeader" class="col-form-label"> {{ getPlanStatusDesc(yearlyPlanHeader.status) }} </p>
                                <p v-if="!yearlyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <hr v-if="salePlans.length > 0">
            
            <div v-if="salePlans.length > 0" class="tw-m-8">

                <h3> แผนประมาณการจำหน่ายประจำปี (ฝ่ายขาย) </h3>
                <div class="row">

                    <div class="col-12">

                        <table-sale-plans 
                            :sale-plans="salePlans"
                            :sale-plan-summary="salePlanSummary" 
                        />

                    </div>

                </div>

            </div>

            <hr v-if="yearlyPlanLines.length > 0">

            <div v-if="yearlyPlanLines.length > 0" class="tw-m-8">

                <h3> รายการวัตถุดิบ </h3>
                <div class="row">

                    <div class="col-12">

                        <table-plan-lines 
                            :plan-header="yearlyPlanHeader"
                            :plan-lines="yearlyPlanLines" 
                            :plan-months="periodYearMonths" 
                            :uom-codes="uomCodes"
                            :sale-plan-summary="salePlanSummary" 
                            :item-options="itemOptions"
                        />

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

import TableSalePlans from "./TableSalePlans";
import TablePlanLines from "./TablePlanLines";

export default {
    
    components: { Loading, TableSalePlans, TablePlanLines },

    props: [ "defaultData", "periodYears", "periodYearValue", "itemOptions", "planStatuses", "printTypes", "printTypeValue", "saleTypes", "saleTypeValue", "sourceVersionValue", "yearlyPlanVersionValue", "uomCodes" ],

    mounted() {
        
        if (this.periodYearValue && this.printTypeValue && this.saleTypeValue && this.sourceVersionValue) {
            this.getSourceVersions(this.periodYearValue, this.printTypeValue, this.saleTypeValue).then((value) => {
                this.getYearlyPlanData(this.periodYearValue, this.printTypeValue, this.saleTypeValue, this.sourceVersionValue, this.yearlyPlanVersionValue);
            });
        }
    },

    data() {
        return {
            organizationId: this.defaultData ? JSON.parse(this.defaultData).organization_id : null,
            organizationCode: this.defaultData ? JSON.parse(this.defaultData).organization_code : null,
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
            printType: this.printTypeValue ? this.printTypeValue : (this.printTypes.length > 0 ? this.printTypes[0].print_type_value : null),
            printTypeLabel: this.printTypeValue ? this.getPrintTypeLabel(this.printTypes, this.printTypeValue) : (this.printTypes.length > 0 ? this.printTypes[0].print_type_label : null),
            saleType: this.saleTypeValue ? this.saleTypeValue : (this.saleTypes.length > 0 ? this.saleTypes[0].value : null),
            saleTypeLabel: this.saleTypeValue ? this.getPrintTypeLabel(this.saleTypes, this.saleTypeValue) : (this.saleTypes.length > 0 ? this.saleTypes[0].description : null),
            sourceVersion: this.sourceVersionValue ? this.sourceVersionValue : null,
            sourceVersions: [],
            yearlyPlanHeader: null,
            yearlyPlanVersion: null,
            salePlans: [],
            salePlanSummary: null,
            yearlyPlanLines: [],
            periodYearMonths: [],
            yearlyPlanVersions: [],
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
            queryParams.set("print_type", this.printType ? this.printType : '');
            queryParams.set("sale_type", this.saleType ? this.saleType : '');
            queryParams.set("source_version", this.sourceVersion ? this.sourceVersion : '');
            queryParams.set("yearly_plan_version", this.yearlyPlanVersion ? this.yearlyPlanVersion : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        async onYearlyPlanChanged(value) {
            
            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);
            this.setUrlParams();

            if(this.periodYear && this.printType && this.saleType) {

                await this.getSourceVersions(this.periodYear, this.printType, this.saleType);

                if(this.sourceVersion) {
                    this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.sourceVersion, this.yearlyPlanVersion);
                }
            }

        },

        onSourceVersionChanged(value) {
            
            this.sourceVersion = value;
            this.setUrlParams();

            // CLEAR DATA
            if(this.yearlyPlanLines.length == 0) {
                this.salePlans = [];
                this.salePlanSummary = null;
            }

            // if(this.periodYear && this.printType && this.saleType && this.sourceVersion) {
            //     this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.sourceVersion, this.yearlyPlanVersion);
            // }

        },

        onPrintTypeChanged(value) {

            this.printType = value;
            this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);
            this.setUrlParams();

            if(this.periodYear && this.printType && this.saleType && this.sourceVersion) {
                this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.sourceVersion, this.yearlyPlanVersion);
            }

        },

        onSaleTypeChanged(value) {
            
            this.saleType = value;
            this.saleTypeLabel = this.getSaleTypeLabel(this.saleTypes, this.saleType);
            this.setUrlParams();

            if(this.periodYear && this.printType && this.saleType && this.sourceVersion) {
                this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.sourceVersion, this.yearlyPlanVersion);
            }

        },
        
        onYearlyPlanVersionChanged(value) {

            this.yearlyPlanVersion = value;
            this.setUrlParams();

            if(this.periodYear && this.printType && this.saleType && this.sourceVersion) {
                this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.sourceVersion, this.yearlyPlanVersion);
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

        async getYearlyPlanData(periodYear, printType, saleType, sourceVersion, version) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.yearlyPlanHeader = null;
            this.yearlyPlanLines = [];
            this.yearlyPlanVersion = version;
            this.yearlyPlanVersions = [];
            this.salePlans = [];
            this.salePlanSummary = null;
            
            var params = { 
                period_year: periodYear,
                print_type: printType,
                sale_type: saleType,
                source_version: sourceVersion,
                version: version
            };

            await axios.get("/ajax/pm/plans/yearly/get-info", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ข้อมูลแผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} ไม่ถูกต้อง | ${resData.message}`, "error");
                } else {
                    this.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                }
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ข้อมูลแผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });
            
            if(this.yearlyPlanHeader) {
                // FOUND PLAN
                this.yearlyPlanVersion = this.yearlyPlanHeader.version;
                if(this.sourceVersions.length > 0) {
                    const foundSourceVersion = this.sourceVersions.find(item => item.version == this.yearlyPlanHeader.source_version);
                    this.sourceVersion = foundSourceVersion ? foundSourceVersion.version : this.sourceVersions[0].version;
                    await this.onGetSalePlans();
                    await this.onGetYearlyPlanLines();
                    this.setUrlParams();
                }
            } else {
                this.yearlyPlanVersion = null;
            }

            // hide loading
            this.isLoading = false;

        },

        async getSourceVersions(periodYear, printType, saleType) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.sourceVersion = null;
            this.sourceVersions = [];
            
            var params = { 
                period_year: periodYear,
                print_type: printType,
                sale_type: saleType,
            };

            await axios.get("/ajax/pm/plans/yearly/get-source-versions", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ข้อมูลไม่ถูกต้อง | ${resData.message}`, "error");
                } else {
                    this.sourceVersion = resData.source_version ? resData.source_version : null;
                    this.sourceVersions = resData.source_versions ? JSON.parse(resData.source_versions) : [];
                    if(this.sourceVersions.length <= 0) {
                        swal("ไม่พบข้อมูล", `ไม่พบข้อมูลแผนประมาณการจำหน่ายประจำปี (ฝ่ายขาย)`, "error");
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

        async onGetSalePlans() {

            // show loading
            this.isLoading = true;

            var params = { 
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
            };
            await axios.get("/ajax/pm/plans/yearly/get-sale-plans", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลแผนประมาณการจำหน่ายประจำปี (ฝ่ายขาย) ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resData.message}`, "error");
                } else {
                    if(resData.sale_plans) {
                        const resSalePlans = JSON.parse(resData.sale_plans);
                        if(resSalePlans.length <= 0 ){
                            swal("ไม่พบข้อมูล", `ไม่พบข้อมูลแผนประมาณการจำหน่ายประจำปี (ฝ่ายขาย) ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resData.message}`, "info");
                        } else {
                            this.salePlans = resSalePlans.map(item => {
                                return { ...item, total: this.getTotalSalePlanPerItem(item) }
                            });
                            this.salePlanSummary = this.getSumAllSalePlanItem(resSalePlans);
                        }
                    }
                }
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลแผนประมาณการจำหน่ายประจำปี (ฝ่ายขาย) ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        getTotalSalePlanPerItem(item) {

            let total = 0;

            const octValue = !isNaN(parseFloat(item.oct)) ? parseFloat(item.oct) : 0;
            const novValue = !isNaN(parseFloat(item.nov)) ? parseFloat(item.nov) : 0;
            const decValue = !isNaN(parseFloat(item.dec)) ? parseFloat(item.dec) : 0;
            const janValue = !isNaN(parseFloat(item.jan)) ? parseFloat(item.jan) : 0;
            const febValue = !isNaN(parseFloat(item.feb)) ? parseFloat(item.feb) : 0;
            const marValue = !isNaN(parseFloat(item.mar)) ? parseFloat(item.mar) : 0;
            const aprValue = !isNaN(parseFloat(item.apr)) ? parseFloat(item.apr) : 0;
            const mayValue = !isNaN(parseFloat(item.may)) ? parseFloat(item.may) : 0;
            const junValue = !isNaN(parseFloat(item.jun)) ? parseFloat(item.jun) : 0;
            const julValue = !isNaN(parseFloat(item.jul)) ? parseFloat(item.jul) : 0;
            const augValue = !isNaN(parseFloat(item.aug)) ? parseFloat(item.aug) : 0;
            const sepValue = !isNaN(parseFloat(item.sep)) ? parseFloat(item.sep) : 0;

            total = octValue + novValue + decValue + janValue + febValue + marValue + aprValue + mayValue + junValue + julValue + augValue + sepValue;

            return total;

        },

        getSumAllSalePlanItem(salePlans) {

            let sumAllItem = { oct: 0, nov: 0, dec: 0, jan: 0, feb: 0, mar: 0, apr: 0, may: 0, jun: 0, jul: 0, aug: 0, sep: 0, total: 0 };

            const octValues = salePlans.map(item => !isNaN(parseFloat(item.oct)) ? parseFloat(item.oct) : 0 );
            sumAllItem.oct = octValues.reduce((acc, currValue) => acc + currValue, 0);

            const novValues = salePlans.map(item => !isNaN(parseFloat(item.nov)) ? parseFloat(item.nov) : 0 );
            sumAllItem.nov = novValues.reduce((acc, currValue) => acc + currValue, 0);

            const decValues = salePlans.map(item => !isNaN(parseFloat(item.dec)) ? parseFloat(item.dec) : 0 );
            sumAllItem.dec = decValues.reduce((acc, currValue) => acc + currValue, 0);

            const janValues = salePlans.map(item => !isNaN(parseFloat(item.jan)) ? parseFloat(item.jan) : 0 );
            sumAllItem.jan = janValues.reduce((acc, currValue) => acc + currValue, 0);

            const febValues = salePlans.map(item => !isNaN(parseFloat(item.feb)) ? parseFloat(item.feb) : 0 );
            sumAllItem.feb = febValues.reduce((acc, currValue) => acc + currValue, 0);

            const marValues = salePlans.map(item => !isNaN(parseFloat(item.mar)) ? parseFloat(item.mar) : 0 );
            sumAllItem.mar = marValues.reduce((acc, currValue) => acc + currValue, 0);

            const aprValues = salePlans.map(item => !isNaN(parseFloat(item.apr)) ? parseFloat(item.apr) : 0 );
            sumAllItem.apr = aprValues.reduce((acc, currValue) => acc + currValue, 0);
            
            const mayValues = salePlans.map(item => !isNaN(parseFloat(item.may)) ? parseFloat(item.may) : 0 );
            sumAllItem.may = mayValues.reduce((acc, currValue) => acc + currValue, 0);

            const junValues = salePlans.map(item => !isNaN(parseFloat(item.jun)) ? parseFloat(item.jun) : 0 );
            sumAllItem.jun = junValues.reduce((acc, currValue) => acc + currValue, 0);

            const julValues = salePlans.map(item => !isNaN(parseFloat(item.jul)) ? parseFloat(item.jul) : 0 );
            sumAllItem.jul = julValues.reduce((acc, currValue) => acc + currValue, 0);

            const augValues = salePlans.map(item => !isNaN(parseFloat(item.aug)) ? parseFloat(item.aug) : 0 );
            sumAllItem.aug = augValues.reduce((acc, currValue) => acc + currValue, 0);

            const sepValues = salePlans.map(item => !isNaN(parseFloat(item.sep)) ? parseFloat(item.sep) : 0 );
            sumAllItem.sep = sepValues.reduce((acc, currValue) => acc + currValue, 0);

            sumAllItem.total = sumAllItem.oct + sumAllItem.nov +sumAllItem.dec +sumAllItem.jan +sumAllItem.feb +sumAllItem.mar +sumAllItem.apr +sumAllItem.may +sumAllItem.jun +sumAllItem.jul +sumAllItem.aug + sumAllItem.sep;

            return sumAllItem;

        },

        async onGetYearlyPlanLines() {

            // show loading
            this.isLoading = true;

            var params = { 
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.yearlyPlanVersion
            };
            await axios.get(`/ajax/pm/plans/yearly/get-lines`, { params })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    this.yearlyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    this.yearlyPlanVersion = this.yearlyPlanHeader.version;
                    this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];

                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลประมาณการผลิตของ แผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resData.message}`, "error");                    
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลประมาณการผลิตของ แผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel}  | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        async onGenerateYearlyPlanLines() {

            // show loading
            this.isLoading = true;

            var reqBody = { 
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.yearlyPlanVersion
            };
            await axios.post(`/ajax/pm/plans/yearly/generate-lines`, reqBody)
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    this.yearlyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    this.yearlyPlanVersion = this.yearlyPlanHeader.version;
                    this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    this.isNewlyCreate = resData.is_newly_create;

                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลประมาณการผลิตของ แผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resData.message}`, "error");                    
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลประมาณการผลิตของ แผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel}  | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        onPlanLineChanged(data) {
            this.yearlyPlanLines = data.planLineItems;
        },

        isAllowApproval(planHeader, planLines) {

            let allowed = false;
            
            if(planHeader){
                // ALLOW WHEN STATUS == 2 (WAIT_FOR_APPROVAL)
                if(planHeader.status == '2') {
                    allowed = true;
                }
            }

            return allowed;

        },

        validateBeforeApproval(planHeader, planLines) {

            const result = {
                valid: true,
                message: "",
            };

            // // IF NEW LINE ISN'T COMPLETED
            // const incompletedLines = planLines.filter(item => {
            //     return item.is_new_line && (
            //         !item.item_code ||
            //         !item.user_gain_loss_qty ||
            //         !item.oct_buy_qty ||
            //         !item.nov_buy_qty ||
            //         !item.dec_buy_qty ||
            //         !item.jan_buy_qty ||
            //         !item.feb_buy_qty ||
            //         !item.mar_buy_qty ||
            //         !item.apr_buy_qty ||
            //         !item.may_buy_qty ||
            //         !item.jun_buy_qty ||
            //         !item.jul_buy_qty ||
            //         !item.aug_buy_qty ||
            //         !item.sep_buy_qty ||
            //         !item.percent
            //     ) && item.marked_as_deleted == false;
            // });

            // if(incompletedLines.length > 0) {
            //     result.valid = false;
            //     result.message = `กรอกข้อมูลรายการประมาณการวัตถุดิบประจำปีไม่ครบถ้วน กรุณาตรวจสอบ`
            // }

            return result;

        },

        async onApprove() {

            const reqBody = {
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.yearlyPlanVersion,
                plan_header: JSON.stringify(this.yearlyPlanHeader),
                plan_lines: JSON.stringify(this.yearlyPlanLines)
            };

            // show loading
            this.isLoading = true;

            const resValidate = this.validateBeforeApproval(this.yearlyPlanHeader, this.yearlyPlanLines);

            if(resValidate.valid) {

                // call store sample result
                await axios.post(`/ajax/pm/plans/yearly/approve`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;
                    const resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;

                    if(resData.status == "success") {
                        this.yearlyPlanHeader = resPlanHeader;
                        this.yearlyPlanVersion = resPlanHeader.version;
                        this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                        this.isNewlyCreate = false;
                        swal("Success", `อนุมัติ ประมาณการใช้ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} version : ${this.yearlyPlanVersion} )`, "success");
                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `อนุมัติ ประมาณการใช้ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `อนุมัติ ประมาณการใช้ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
                });

            } else {
                swal("เกิดข้อผิดพลาด", `อนุมัติ ประมาณการใช้ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resValidate.message}`, "error");
            }

            // hide loading
            this.isLoading = false;

        },

        async onReject() {

            const reqBody = {
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.yearlyPlanVersion,
                plan_header: JSON.stringify(this.yearlyPlanHeader),
                plan_lines: JSON.stringify(this.yearlyPlanLines)
            };

            // show loading
            this.isLoading = true;

            const resValidate = this.validateBeforeApproval(this.yearlyPlanHeader, this.yearlyPlanLines);

            if(resValidate.valid) {

                // call store sample result
                await axios.post(`/ajax/pm/plans/yearly/reject`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;
                    const resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;

                    if(resData.status == "success") {
                        this.yearlyPlanHeader = resPlanHeader;
                        this.yearlyPlanVersion = resPlanHeader.version;
                        this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                        this.isNewlyCreate = false;
                        swal("Success", `ไม่อนุมัติ ประมาณการใช้ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} version : ${this.yearlyPlanVersion} )`, "success");
                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่อนุมัติ ประมาณการใช้ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่อนุมัติ ประมาณการใช้ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
                });

            } else {
                swal("เกิดข้อผิดพลาด", `ไม่อนุมัติ ประมาณการใช้ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resValidate.message}`, "error");
            }

            // hide loading
            this.isLoading = false;

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

        

    }

}

</script>