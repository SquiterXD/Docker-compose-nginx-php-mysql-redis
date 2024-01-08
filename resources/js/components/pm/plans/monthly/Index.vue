<template>

    <div class="ibox">

        <div class="ibox-content" style="min-height: 600px;">

            <div class="tw-mb-4">

                <div class="text-right tw-mb-2">
                    <button class="btn btn-inline-block btn-sm btn-success tw-w-32"
                        @click="onCreateNewMonthlyPlanVersion"
                        :disabled="!isAllowCreateNewPlanVersion(monthlyPlanVersions)"
                    > 
                        <i class="fa fa-plus tw-mr-1"></i> สร้าง 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-primary tw-w-32"
                        @click="onSaveMonthlyPlan"
                        :disabled="!periodYear || !periodName || monthlyPlanLines.length == 0 || (monthlyPlanHeader ? monthlyPlanHeader.status != '1' : true)"
                    > 
                        <i class="fa fa-save tw-mr-1"></i> บันทึก 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-white tw-w-32"
                        @click="$modal.show('modal-search-plan')">
                        <i class="fa fa-search tw-mr-1"></i> ค้นหา 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-warning tw-w-40"
                        @click="onSubmitMonthlyPlan"
                        :disabled="(monthlyPlanHeader ? monthlyPlanHeader.status != '1' : true) || monthlyPlanLines.length == 0 || isNewlyCreate || foundInvalidPlanLine || !isSaved"
                    > 
                        <i class="fa fa-check-square tw-mr-1"></i> ยืนยันแผนรายเดือน 
                    </button>
                    
                </div>
                
                <div class="text-right">
                    
                    <!-- <button class="btn btn-inline-block btn-sm btn-primary tw-w-40"
                        :disabled="monthlyPlanHeader ? monthlyPlanHeader.status == '1' : true"
                    > 
                        <i class="fa fa-print tw-mr-1"></i> พิมพ์รายงาน 
                    </button> -->

                    <button class="btn btn-inline-block btn-sm btn-info tw-w-72"
                        @click="$modal.show('modal-sales-forecast')"
                        :disabled="!periodYear || !periodName || !sourceVersion"
                    > 
                        <i class="fa fa-list tw-mr-1"></i> รายละเอียดแผนรายปักษ์จากฝ่ายขาย
                    </button>

                    <button class="btn btn-inline-block btn-sm hover:tw-text-white tw-text-white tw-bg-purple-500 tw-border-purple-500 tw-w-72"
                        @click="onGetSalePlans"
                        :disabled="!periodYear || !periodName || !sourceVersion || salePlans.length > 0 || monthlyPlanLines.length > 0"
                    > 
                        <i class="fa fa-list tw-mr-1"></i> รายละเอียดแผนประมาณการจำหน่ายรายเดือน 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-info tw-w-52"
                        @click="onGenerateMonthlyPlanLines"
                        :disabled="!periodYear || !periodName || !sourceVersion || salePlans.length <= 0 || (monthlyPlanHeader ? monthlyPlanHeader.status != '1' : false)"
                    > 
                        <i class="fa fa-calculator tw-mr-1"></i> คำนวณปริมาณการผลิต 
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

                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> แผนประมาณการ <br> จำหน่ายประจำเดือน </label>

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

                                <pm-el-select v-if="isAllowSelectSourceVersion(monthlyPlanHeader, monthlyPlanLines)"
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
                                <p v-if="!isAllowSelectSourceVersion(monthlyPlanHeader, monthlyPlanLines)" class="col-form-label"> {{ sourceVersion }} </p>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="row form-group tw-mb-0">

                            <label class="col-md-4 col-form-label tw-font-bold"> เวอร์ชั่น </label>

                            <div class="col-md-8">
                                <p v-if="monthlyPlanHeader" class="col-form-label"> {{ monthlyPlanHeader.version ? monthlyPlanHeader.version : "-" }} </p>
                                <p v-if="!monthlyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                        <div class="row form-group tw-mb-0">

                            <label class="col-md-4 col-form-label tw-font-bold"> สถานะ </label>

                            <div class="col-md-8">
                                <p v-if="monthlyPlanHeader" class="col-form-label"> {{ getPlanStatusDesc(monthlyPlanHeader.status) }} </p>
                                <p v-if="!monthlyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                        <div class="row form-group tw-mb-0">

                            <label class="col-md-4 col-form-label tw-font-bold"> ผู้บันทึก </label>

                            <div class="col-md-8">
                                <p v-if="monthlyPlanHeader" class="col-form-label"> 
                                    {{ monthlyPlanHeader.attribute11 ? monthlyPlanHeader.attribute11 : "-" }}
                                </p>
                                <p v-if="!monthlyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                        <div class="row form-group tw-mb-0">

                            <label class="col-md-4 col-form-label tw-font-bold"> วันที่สร้าง </label>

                            <div class="col-md-8">
                                <p v-if="monthlyPlanHeader" class="col-form-label"> 
                                    {{ monthlyPlanHeader.request_date ? formatDateTh(monthlyPlanHeader.request_date) : "" }}
                                </p>
                                <p v-if="!monthlyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                        <div class="row form-group tw-mb-0">

                            <label class="col-md-4 col-form-label tw-font-bold"> วันที่แก้ไขล่าสุด </label>

                            <div class="col-md-8">
                                <p v-if="monthlyPlanHeader" class="col-form-label"> 
                                    {{ monthlyPlanHeader.last_update_date ? formatDateTh(monthlyPlanHeader.last_update_date) : "" }}
                                </p>
                                <p v-if="!monthlyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                        <div class="row form-group tw-mb-0">

                            <label class="col-md-4 col-form-label tw-font-bold"> วันที่ยืนยันล่าสุด </label>

                            <div class="col-md-8">
                                <p v-if="monthlyPlanHeader" class="col-form-label"> 
                                    {{ monthlyPlanHeader.approved_date ? formatDateTh(monthlyPlanHeader.approved_date) : "" }}
                                </p>
                                <p v-if="!monthlyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <hr v-if="salePlans.length > 0">
            
            <div v-if="salePlans.length > 0" class="tw-m-8">

                <!-- <h3> รายละเอียดแผนบุหรี่จากฝ่ายขาย </h3> -->
                <button type="button" 
                    @click="onToggleShowSalePlan"
                    class="btn btn-lg btn-white btn-outline text-left tw-w-full tw-pt-3 tw-pb-4"> 
                    <span class="tw-text-lg tw-font-bold"> รายละเอียดแผนบุหรี่จากฝ่ายขาย </span>
                    <span v-if="isShowSalePlans" class="fa fa-caret-down fa-2x pull-right"></span>
                    <span v-if="!isShowSalePlans" class="fa fa-caret-left fa-2x pull-right"></span>
                </button>

                <div v-show="isShowSalePlans" class="row">

                    <div class="col-12">

                        <table-sale-plans :sale-plans="salePlans" />

                    </div>

                </div>

            </div>

            <hr v-if="monthlyPlanLines.length > 0">

            <div v-if="monthlyPlanLines.length > 0" class="tw-m-8">

                <h3> รายละเอียดแผนประมาณการจำหน่ายรายเดือน </h3>
                <div class="row">

                    <div class="col-12">

                        <table-plan-lines 
                            :plan-header="monthlyPlanHeader" 
                            :plan-lines="monthlyPlanLines" 
                            :uom-codes="uomCodes"
                            @onPlanLineChanged="onPlanLineChanged"
                        />

                    </div>

                </div>

            </div>
            
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

        <!-- MODAL SALES FORCAST -->
        <modal-sales-forecast 
            modal-name="modal-sales-forecast" 
            modal-width="960" 
            modal-height="auto"
            :period-year-value="periodYear"
            :period-name-value="periodName"
            :print-type-value="printType"
            :sale-type-value="saleType"
            :source-version-value="sourceVersion"
            :monthly-plan-version-value="monthlyPlanVersion"
            :sales-forecasts="salesForecasts"
            :uom-codes="uomCodes"
        />

        <!-- MODAL SEARCH PLAN -->
        <modal-search-plan 
            modal-name="modal-search-plan" 
            modal-width="640" 
            modal-height="auto"
            :period-years="periodYears"
            :period-year-value="periodYear"
            :period-names="periodNames"
            :period-name-value="periodName"
            :print-types="printTypes"
            :print-type-value="printType"
            :sale-types="saleTypes"
            :sale-type-value="saleType"
            :source-versions="sourceVersions"
            :source-version-value="sourceVersion"
            :monthly-plan-version-value="monthlyPlanVersion"
            :monthly-plan-versions="monthlyPlanVersions"
            @onSearchPlanVersion="onSearchPlanVersion"
        />

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableSalePlans from "./TableSalePlans";
import TablePlanLines from "./TablePlanLines";
import ModalSearchPlan from "./ModalSearchPlan";
import ModalSalesForecast from "./ModalSalesForecast";

export default {
    
    components: { Loading, TableSalePlans, TablePlanLines, ModalSearchPlan, ModalSalesForecast },

    props: [ "periodYears", "periodYearValue", "periodNameValue", "invItems", "planStatuses", "printTypes", "printTypeValue", "saleTypes", "saleTypeValue", "sourceVersionValue", "uomCodes" ],

    mounted() {

        if (this.periodYearValue) {

            // GET MONTH OF PLANS
            this.getPeriodNames(this.periodYearValue).then((value) => {

                if(this.periodNameValue && this.printTypeValue && this.saleTypeValue && this.sourceVersionValue) {

                    this.getSalesForecasts(this.periodYearValue, this.periodNameValue, this.printTypeValue, this.saleTypeValue, this.sourceVersionValue);

                    this.periodNameLabel = this.getPeriodNameLabel(this.periodNames, this.periodNameValue);
                    
                    // GET MONTHLY PLAN DATA
                    this.getSourceVersions(this.periodYearValue, this.periodNameValue, this.printTypeValue, this.saleTypeValue).then((value) => {
                        this.getMonthlyPlanData(this.periodYearValue, this.periodNameValue, this.printTypeValue, this.saleTypeValue, this.sourceVersionValue, null);
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
            printType: this.printTypeValue ? this.printTypeValue : (this.printTypes.length > 0 ? this.printTypes[0].print_type_value : null),
            printTypeLabel: this.printTypeValue ? this.getPrintTypeLabel(this.printTypes, this.printTypeValue) : (this.printTypes.length > 0 ? this.printTypes[0].print_type_label : null),
            saleType: this.saleTypeValue ? this.saleTypeValue : (this.saleTypes.length > 0 ? this.saleTypes[0].value : null),
            saleTypeLabel: this.saleTypeValue ? this.getSaleTypeLabel(this.saleTypes, this.saleTypeValue) : (this.saleTypes.length > 0 ? this.saleTypes[0].description : null),
            sourceVersion: this.sourceVersionValue ? this.sourceVersionValue : null,
            sourceVersions: [],
            periodNames: [],
            monthlyPlanHeader: null,
            monthlyPlanVersion: null,
            monthlyPlanLines: [],
            monthlyPlanVersions: [],
            salePlans: [],
            salesForecasts: [],
            isNewlyCreate: false,
            foundInvalidPlanLine: false,
            isShowSalePlans: true,
            isSaved: false,
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
            queryParams.set("print_type", this.printType ? this.printType : '');
            queryParams.set("sale_type", this.saleType ? this.saleType : '');
            queryParams.set("source_version", this.sourceVersion ? this.sourceVersion : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        onToggleShowSalePlan() {
            this.isShowSalePlans = !this.isShowSalePlans;
        },

        onYearlyPlanChanged(value) {
            
            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);
            this.setUrlParams();

            // REFRESH DATA
            this.periodName = null;
            this.periodNameLabel = "";
            this.periodNames = [];

            this.sourceVersion = null;
            this.sourceVersions = [];

            this.monthlyPlanHeader = null;
            this.monthlyPlanVersion = null;
            this.monthlyPlanVersions = [];
            this.monthlyPlanLines = [];
            
            this.salePlans = [];

            this.getPeriodNames(value);
            
        },

        async onPeriodNameChanged(value) {
            
            this.periodName = value;
            this.periodNameLabel = this.getPeriodNameLabel(this.periodNames, this.periodName);
            this.setUrlParams();

            if(this.periodYear && this.periodName && this.printType && this.saleType) {

                await this.getSourceVersions(this.periodYear, this.periodName, this.printType, this.saleType);

                if(this.sourceVersion) {
                    this.getMonthlyPlanData(this.periodYear, this.periodName, this.printType, this.saleType, this.sourceVersion, null);
                }
            
            }

            this.getSalesForecasts(this.periodYear, this.periodName, this.printType, this.saleType, this.sourceVersion);

        },

        onSourceVersionChanged(value) {
            
            this.sourceVersion = value;
            this.setUrlParams();

            // CLEAR DATA
            if(this.monthlyPlanLines.length == 0){
                this.salePlans = [];
            }

            // if(this.periodYear && this.periodName && this.printType && this.saleType && this.sourceVersion) {
            //     this.getMonthlyPlanData(this.periodYear, this.periodName, this.printType, this.saleType, this.sourceVersion, null);
            // }

        },

        onPrintTypeChanged(value) {
            
            this.printType = value;
            this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);
            this.setUrlParams();

            if(this.periodYear && this.periodName && this.printType && this.saleType && this.sourceVersion) {
                this.getMonthlyPlanData(this.periodYear, this.periodName, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        onSaleTypeChanged(value) {
            
            this.saleType = value;
            this.saleTypeLabel = this.getSaleTypeLabel(this.saleTypes, this.saleType);
            this.setUrlParams();

            if(this.periodYear && this.periodName && this.printType && this.saleType && this.sourceVersion) {
                this.getMonthlyPlanData(this.periodYear, this.periodName, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        onSearchPlanVersion(data) {

            this.periodYear = data.period_year;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);

            this.periodName = data.period_name;
            this.periodNameLabel = this.getPeriodNameLabel(this.periodNames, this.periodName);

            this.printType = data.print_type;
            this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);

            this.saleType = data.sale_type;
            this.saleTypeLabel = this.getPrintTypeLabel(this.saleTypes, this.saleType);

            this.sourceVersion = data.source_version;
            this.sourceVersions = data.source_versions;

            this.getPeriodNames(this.periodYear);
            if(this.periodYear && this.periodName && this.printType && this.saleType && this.sourceVersion) {
                this.getMonthlyPlanData(this.periodYear, this.periodName, this.printType, this.saleType, this.sourceVersion, data.version);
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

            // SHOW LOADING
            this.isLoading = true;
            
            var params = { 
                period_year: periodYear
            };
            
            this.periodNames = await axios.get("/ajax/pm/plans/monthly/get-months", { params })
            .then(res => {
                const resData = res.data.data;
                return resData.period_names ? JSON.parse(resData.period_names) : [];
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ข้อมูลปี ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async getMonthlyPlanData(periodYear, periodName, printType, saleType, sourceVersion, version) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.monthlyPlanHeader = null;
            this.monthlyPlanVersion = version;

            this.monthlyPlanVersions = [];
            this.monthlyPlanLines = [];
            
            this.salePlans = [];
            
            var params = { 
                period_year: periodYear, 
                period_name: periodName,
                print_type: printType,
                sale_type: saleType,
                source_version: sourceVersion,
                version: version
            };
            await axios.get("/ajax/pm/plans/monthly/get-info", { params })
            .then(res => {
                const resData = res.data.data;
                this.monthlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                this.monthlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ข้อมูลการวางแผนผลิตสิ่งพิมพ์รายเดือน ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });
            if(this.monthlyPlanHeader) {
                // FOUND PLAN
                this.monthlyPlanVersion = this.monthlyPlanHeader.version;
                if(this.sourceVersions.length > 0) {
                    const foundSourceVersion = this.sourceVersions.find(item => item.version == this.monthlyPlanHeader.source_version);
                    this.sourceVersion = foundSourceVersion ? foundSourceVersion.version : this.sourceVersions[0].version;
                    await this.onGetSalePlans();
                    await this.onGetMonthlyPlanLines();
                    this.setUrlParams();
                }
            } else {
                this.monthlyPlanVersion = null;
            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async getSourceVersions(periodYear, periodName, printType, saleType) {

            // SHOW LOADING
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

            await axios.get("/ajax/pm/plans/monthly/get-source-versions", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ข้อมูลไม่ถูกต้อง | ${resData.message}`, "error");
                } else {
                    this.sourceVersion = resData.source_version ? resData.source_version : null;
                    this.sourceVersions = resData.source_versions ? JSON.parse(resData.source_versions) : [];
                    if(this.sourceVersions.length <= 0) {
                        swal("ไม่พบข้อมูล", `ไม่พบข้อมูลรายละเอียดแผนบุหรี่จากฝ่ายขาย`, "error");
                        this.salePlans = [];
                        this.monthlyPlanLines = [];
                    }
                }
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ข้อมูลไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });
        
            // HIDE LOADING
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

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
        },

        async onGetSalePlans() {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                period_year: this.periodYear,
                period_name: this.periodName,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
            };
            await axios.get("/ajax/pm/plans/monthly/get-sale-plans", { params })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    if(resData.sale_plans) {
                        const resSalePlans = JSON.parse(resData.sale_plans);
                        if(resSalePlans.length <= 0 ){
                            swal("ไม่พบข้อมูล", `ไม่พบข้อมูลรายละเอียดแผนบุหรี่จากฝ่ายขาย ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resData.message}`, "info");
                        } else {
                            this.salePlans = resSalePlans;
                        }
                    }
                    
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลรายละเอียดแผนบุหรี่จากฝ่ายขาย ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resData.message}`, "error");
                }

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ข้อมูลรายละเอียดแผนบุหรี่จากฝ่ายขาย ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

            // SHOW TABLE SALE-PLANS
            this.isShowSalePlans = true;

        },

        async getSalesForecasts(periodYear, periodName, printType, saleType, sourceVersion) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.salesItems = [];
            this.salesForecasts = [];
            
            var params = { 
                period_year: periodYear,
                period_name: periodName,
                print_type: printType,
                sale_type: saleType,
                source_version: sourceVersion,
            };

            await axios.get("/ajax/pm/plans/monthly/get-sales-forecasts", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ข้อมูลไม่ถูกต้อง | ${resData.message}`, "error");
                } else {
                    this.salesForecasts = resData.sales_forecasts ? JSON.parse(resData.sales_forecasts) : [];
                }
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ข้อมูลไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });
        
            // HIDE LOADING
            this.isLoading = false;

        },

        async onGetMonthlyPlanLines() {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                period_year: this.periodYear, 
                period_name: this.periodName,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.monthlyPlanVersion
            };
            await axios.get(`/ajax/pm/plans/monthly/get-lines`, { params })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.monthlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    this.monthlyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    this.monthlyPlanVersion = this.monthlyPlanHeader.version;
                    this.monthlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];

                    if(this.monthlyPlanLines.length > 0) {
                        this.foundInvalidPlanLine = !!this.monthlyPlanLines.find(item => !item.ingredient_request_uom);
                        const invalidPlanLines = this.monthlyPlanLines.filter(item => !item.ingredient_request_uom);
                        const invalidPlanLineItemCodes = invalidPlanLines.map(item => item.inv_item_number);
                        if(this.foundInvalidPlanLine) {
                            swal("เกิดข้อผิดพลาด", `ตรวจพบรายการที่มีข้อมูลไม่สมบูรณ์ [ รหัสสินค้าสำเร็จรูป : ${invalidPlanLineItemCodes.join()} ]`, "error");
                        }
                    }

                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล รายละเอียดแผนประมาณการจำหน่ายรายเดือน ${this.periodYearLabel} | ${resData.message}`, "error");
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล รายละเอียดแผนประมาณการจำหน่ายรายเดือน ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async onGenerateMonthlyPlanLines() {

            if(this.monthlyPlanLines.length > 0) {

                swal({
                    title: "",
                    text: `ต้องการคำนวณปริมาณการผลิต ใหม่อีกครั้ง ?`,
                    showCancelButton: true,
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: true
                }, (isConfirm) => {
                    if (isConfirm) {
                        this.monthlyPlanLines = [];
                        this.generateMonthlyPlanLines();
                    }
                });

            } else {
                this.generateMonthlyPlanLines();
            }

        },

        async generateMonthlyPlanLines() {

            // SHOW LOADING
            this.isLoading = true;

            var reqBody = { 
                period_year: this.periodYear, 
                period_name: this.periodName,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.monthlyPlanVersion
            };
            await axios.post(`/ajax/pm/plans/monthly/generate-lines`, reqBody)
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.monthlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    this.monthlyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    this.monthlyPlanVersion = this.monthlyPlanHeader.version;
                    this.monthlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    this.isNewlyCreate = resData.is_newly_create;

                    if(this.monthlyPlanLines.length > 0) {
                        this.foundInvalidPlanLine = !!this.monthlyPlanLines.find(item => !item.ingredient_request_uom);
                        const invalidPlanLines = this.monthlyPlanLines.filter(item => !item.ingredient_request_uom);
                        const invalidPlanLineItemCodes = invalidPlanLines.map(item => item.inv_item_number);
                        if(this.foundInvalidPlanLine) {
                            swal("เกิดข้อผิดพลาด", `ตรวจพบรายการที่มีข้อมูลไม่สมบูรณ์ [ รหัสสินค้าสำเร็จรูป : ${invalidPlanLineItemCodes.join()} ]`, "error");
                        }
                    }

                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล รายละเอียดแผนประมาณการจำหน่ายรายเดือน ${this.periodYearLabel} | ${resData.message}`, "error");
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล รายละเอียดแผนประมาณการจำหน่ายรายเดือน ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        onPlanLineChanged(data) {
            this.monthlyPlanLines = data.planLineItems;
        },

        async onSaveMonthlyPlan() {

            const reqBody = {
                period_year: this.periodYear,
                period_name: this.periodName,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.monthlyPlanVersion,
                plan_header: JSON.stringify(this.monthlyPlanHeader),
                plan_lines: JSON.stringify(this.monthlyPlanLines)
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store
            await axios.post(`/ajax/pm/plans/monthly/store-lines`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;

                if(resData.status == "success") {
                    this.monthlyPlanHeader = resPlanHeader;
                    this.monthlyPlanVersion = resPlanHeader.version;
                    this.monthlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    this.isNewlyCreate = false;
                    this.isSaved = true;
                    swal("Success", `บันทึก ข้อมูลวางแผนผลิตสิ่งพิมพ์รายเดือน : ${this.periodNameLabel} ปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} version : ${this.monthlyPlanVersion}`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึก ข้อมูลวางแผนผลิตสิ่งพิมพ์รายเดือน : ${this.periodNameLabel} ปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึก ข้อมูลวางแผนผลิตสิ่งพิมพ์รายเดือน : ${this.periodNameLabel} ปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;
            
        },

        async onSubmitMonthlyPlan() {

            const reqBody = {
                period_year: this.periodYear,
                period_name: this.periodName,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.monthlyPlanVersion,
                plan_header: JSON.stringify(this.monthlyPlanHeader),
                plan_lines: JSON.stringify(this.monthlyPlanLines)
            };

            // SHOW LOADING
            this.isLoading = true;

            // CALL SAVE BEFORE SUBMIT
            await axios.post(`/ajax/pm/plans/monthly/store-lines`, reqBody)
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    console.log(resData.message);
                }
                return resData;
            }).catch((error) => {
                console.log(error);
            });

            // CALL SUBMIT
            await axios.post(`/ajax/pm/plans/monthly/submit-plan`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    this.monthlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    this.monthlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    swal("Success", `ยืนยันแผนรายเดือน : ${this.periodNameLabel} ปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel}`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถยืนยันแผนรายเดือน : ${this.periodNameLabel} ปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถยืนยันแผนรายเดือน : ${this.periodNameLabel} ปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async onCreateNewMonthlyPlanVersion() {

            swal({
                title: "",
                text: `ต้องการสร้าง แผนผลิตสิ่งพิมพ์รายเดือน : ${this.periodNameLabel} ปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} เวอร์ชั่นใหม่ ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true
            }, (isConfirm) => {
                if (isConfirm) {
                    this.salePlans = [];
                    this.monthlyPlanLines = [];
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

            // IF ALL VERSIONS ARE NOT COMPLETED ( 1 : NOT_COMFIRMED )
            // => NOT ALLOW TO CREATE NEW VERSION
            const inprogressVersions = versions.filter(item => {
                return item.status == 1
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
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store sample result
            await axios.post(`/ajax/pm/plans/monthly/add-new-header`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    
                    this.monthlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    this.monthlyPlanVersion = resData.version;
                    this.monthlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];

                    swal("Success", `สร้างข้อมูลวางแผนผลิตสิ่งพิมพ์รายเดือน : ${this.periodNameLabel} ปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} version : ${this.monthlyPlanVersion} )`, "success");

                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `สร้างข้อมูลวางแผนผลิตสิ่งพิมพ์รายเดือน : ${this.periodNameLabel} ปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `สร้างข้อมูลวางแผนผลิตสิ่งพิมพ์รายเดือน : ${this.periodNameLabel} ปี : ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        }

    }

}

</script>