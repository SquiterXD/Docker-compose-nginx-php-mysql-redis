<template>

    <div class="ibox">

        <div class="ibox-content" style="min-height: 600px;">

            <div class="tw-mb-4">

                <div class="text-right tw-mb-2">
                    <button class="btn btn-inline-block btn-sm btn-success tw-w-40"
                        @click="onCreateNewDailyPlanVersion"
                        :disabled="!isAllowCreateNewPlanVersion(dailyPlanVersions)"
                    > 
                        <i class="fa fa-plus tw-mr-1"></i> สร้าง 
                    </button>

                    <!-- <button class="btn btn-inline-block btn-sm btn-primary tw-w-40"
                        @click="onSaveDailyPlan"
                        :disabled="!periodYear || !periodName || !biweekly || dailyPlanLines.length == 0 || dailyPlanHeader.status != '1'"
                    > 
                        <i class="fa fa-save tw-mr-1"></i> บันทึก 
                    </button> -->

                    <button class="btn btn-inline-block btn-sm btn-warning tw-w-40"
                        @click="onSubmitDailyPlan"
                        :disabled="(dailyPlanHeader ? dailyPlanHeader.status != '1' : true) || dailyPlanLines.length == 0  || isNewlyCreate"
                    > 
                        <i class="fa fa-check-square tw-mr-1"></i> ยืนยัน 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-info tw-w-40"
                        @click="$modal.show('modal-product-plans')"
                        :disabled="!periodYear || !periodName || !biweekly"
                    > 
                        <i class="fa fa-print tw-mr-1"></i> ดูแผนการผลิตบุหรี่ 
                    </button>
                    
                    <button class="btn btn-inline-block btn-sm btn-primary tw-w-40" v-if="!dailyPlanHeader"
                        :disabled="dailyPlanHeader ? dailyPlanHeader.status == '1' : true"
                    > 
                        <i class="fa fa-print tw-mr-1"></i> พิมพ์รายงาน 
                    </button>
                    <a class="btn btn-inline-block btn-sm btn-primary tw-w-40 text-white" v-else
                        :href="'/pm/plans/daily?print_pdf=1&daily_plan_header_id=' + dailyPlanHeader.daily_plan_header_id"
                        :disabled="dailyPlanHeader ? (dailyPlanHeader.daily_plan_header_id != '' && dailyPlanHeader.daily_plan_header_id != null && dailyPlanHeader.daily_plan_header_id != undefined) : false" target="_blank">
                        <i class="fa fa-print tw-mr-1"></i> พิมพ์รายงาน
                    </a>

                    <button class="btn btn-inline-block btn-sm btn-white tw-w-40"
                        @click="$modal.show('modal-search-plan')">
                        <i class="fa fa-search tw-mr-1"></i> ค้นหา 
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

                            <label class="col-md-4 col-form-label tw-font-bold"> ประจำเดือน </label>

                            <div class="col-md-8">

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

                        </div>

                        
                    </div>

                    <div class="col-md-6">

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> ปักษ์ </label>

                            <div class="col-md-3">

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

                            <label class="col-md-2 col-form-label tw-font-bold"> ครั้งที่ </label>

                            <div class="col-md-3">

                                <pm-el-select v-if="isAllowSelectSourceVersion(dailyPlanHeader, dailyPlanLines)"
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
                                <p v-if="!isAllowSelectSourceVersion(dailyPlanHeader, dailyPlanLines)" class="col-form-label"> {{ sourceVersion }} </p>

                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> สัปดาห์ </label>

                            <div class="col-md-8">

                                <pm-el-select name="weekly" id="input_weekly" 
                                    :select-options="weeklys"
                                    option-key="weekly_value"
                                    option-value="weekly_value" 
                                    option-label="weekly_label" 
                                    :value="weekly" 
                                    :filterable="true"
                                    @onSelected="onWeekOfPlanChanged"
                                />

                                
                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> เวอร์ชั่น </label>

                            <div class="col-md-8">
                                <p v-if="dailyPlanHeader" class="col-form-label"> {{ dailyPlanHeader.version ? dailyPlanHeader.version : "-" }} </p>
                                <p v-if="!dailyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> สถานะ </label>

                            <div class="col-md-8">
                                <p v-if="dailyPlanHeader" class="col-form-label"> {{ getPlanStatusDesc(dailyPlanHeader.status) }} </p>
                                <p v-if="!dailyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <hr>

            <div v-if="dailyPlanLines.length > 0" class="tw-m-8">

                <div class="row">

                    <div class="col-12">

                        <div class="tw-mb-4">
                            <button class="btn btn-inline-block btn-sm btn-success tw-w-52"
                                @click="onAddNewMachineLine"
                                :disabled="!dailyPlanHeader || this.availableMachines.length <= 0"
                            > 
                                <i class="fa fa-plus tw-mr-1"></i> เพิ่มเครื่อง
                            </button>
                        </div>

                        <table-plan-lines 
                            :plan-header="dailyPlanHeader" 
                            :plan-lines="dailyPlanLines" 
                            :weeklys="weeklys"
                            :uom-codes="uomCodes"
                            :machines="machineItems"
                            :available-machines="availableMachines"
                            :machine-powers="machinePowers"
                            :machine-times="machineTimes"
                            :daily-remaining-items="dailyRemainingItems"
                            @onMachineLineItemsChanged="onMachineLineItemsChanged"
                        />

                    </div>

                </div>

            </div>
            
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

        <!-- MODAL SALE PLANS -->
        <modal-product-plans
            modal-name="modal-product-plans" 
            modal-width="960" 
            modal-height="auto"
            :period-year-value="periodYear"
            :period-name-value="periodName"
            :biweekly-value="biweekly"
            :print-type-value="printType"
            :sale-type-value="saleType"
            :product-daily71-dates="productDaily71Dates"
            :product-machine71-groups="productMachine71Groups"
            :product71-plans="product71Plans"
            :product-daily78-dates="productDaily78Dates"
            :product-machine78-groups="productMachine78Groups"
            :product78-plans="product78Plans"
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
            :biweeklys="biweeklys"
            :biweekly-value="biweekly"
            :weeklys="weeklys"
            :weekly-value="weekly"
            :print-types="printTypes"
            :print-type-value="printType"
            :sale-types="saleTypes"
            :sale-type-value="saleType"
            :source-versions="sourceVersions"
            :source-version-value="sourceVersion"
            :daily-plan-version-value="dailyPlanVersion"
            :daily-plan-versions="dailyPlanVersions"
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
import ModalProductPlans from "./ModalProductPlans";

export default {
    
    components: { Loading, TablePlanLines, ModalSearchPlan, ModalProductPlans },

    props: [ 
        "periodYears", 
        "periodYearValue", 
        "periodNameValue", 
        "biweeklyValue", 
        "weeklyValue", 
        "planStatuses", 
        "printTypes", 
        "printTypeValue", 
        "saleTypes", 
        "saleTypeValue", 
        "sourceVersionValue", 
        "uomCodes", 
        "machines", 
        "machinePowers", 
        "machineTimes", 
        "assets" 
    ],

    async mounted() {

        if (this.periodYearValue) {

            // GET MONTH OF PLANS
            await this.getPeriodNames(this.periodYearValue);

            if(this.periodNameValue) {

                this.periodNameLabel = this.getPeriodNameLabel(this.periodNames, this.periodNameValue);

                await this.getBiweekOfPlans(this.periodYearValue, this.periodNameValue);

                if(this.biweeklyValue) {

                    await this.getProductPlans(this.periodYearValue, this.periodNameValue, this.biweeklyValue);
                    await this.getWeekOfPlans(this.periodYearValue, this.periodNameValue, this.biweeklyValue);

                    if(this.printTypeValue) {

                        this.machineItems = this.filterMachineItems(this.machines, this.printTypeValue);

                        if(this.saleTypeValue){
                            await this.getSourceVersions(this.periodYearValue, this.periodNameValue, this.biweeklyValue, this.printTypeValue, this.saleTypeValue);
                            // if(this.sourceVersionValue && this.weeklyValue) {
                            if(this.weeklyValue) {
                                await this.getDailyPlanData(this.periodYearValue, this.periodNameValue, this.biweeklyValue, this.weeklyValue, this.printTypeValue, this.saleTypeValue, this.sourceVersionValue, null);
                            }
                        }
                    }

                }

            }

        }
        
    },

    data() {
        return {
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
            periodName: this.periodNameValue,
            periodNameLabel: "",
            periodNames: [],
            printType: this.printTypeValue ? this.printTypeValue : (this.printTypes.length > 0 ? this.printTypes[0].print_type_value : null),
            printTypeLabel: this.printTypeValue ? this.getPrintTypeLabel(this.printTypes, this.printTypeValue) : (this.printTypes.length > 0 ? this.printTypes[0].print_type_label : null),
            saleType: this.saleTypeValue ? this.saleTypeValue : (this.saleTypes.length > 0 ? this.saleTypes[0].value : null),
            saleTypeLabel: this.saleTypeValue ? this.getPrintTypeLabel(this.saleTypes, this.saleTypeValue) : (this.saleTypes.length > 0 ? this.saleTypes[0].description : null),
            sourceVersion: this.sourceVersionValue ? this.sourceVersionValue : null,
            sourceVersions: [],
            biweekly: this.biweeklyValue,
            biweeklys: [],
            weekly: this.weeklyValue,
            weeklys: [],
            dailyPlanHeader: null,
            dailyPlanVersion: null,
            dailyPlanLines: [],
            dailyPlanVersions: [],
            dailyRemainingItems: [],
            productDaily71Dates: [],
            productMachine71Groups: [],
            product71Plans: [],
            productDaily78Dates: [],
            productMachine78Groups: [],
            product78Plans: [],
            machineItems: this.filterMachineItems(this.machines, this.printTypeValue),
            availableMachines: [],
            machineEamSchedules: this.assets.map(item => {
                return {
                    machine_id: item.asset_id,
                    asset_id: item.asset_id,
                    asset_number: item.asset_number,
                    resource_code: item.resource_code,
                    resource_description: item.resource_description,
                    eam_schedules: item.eam_plan_lines ? item.eam_plan_lines.map(eam => {
                        return {
                            scheduled_start_date: eam.scheduled_start_date,
                            scheduled_completion_date: eam.scheduled_completion_date
                        }
                    }) : []
                }
            }),
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
            queryParams.set("weekly", this.weekly ? this.weekly : '');
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

            this.weekly = null;
            this.weeklys = [];

            this.sourceVersion = null;
            this.sourceVersions = [];

            this.dailyPlanHeader = null;
            this.dailyPlanVersion = null;
            this.dailyPlanLines = [];
            this.dailyPlanVersions = [];
            this.dailyRemainingItems = [];
            
            this.getPeriodNames(this.periodYear);

            this.availableMachines = this.getAvailableMachines(this.machineItems, this.dailyPlanLines);
            
        },

        onPeriodNameChanged(value) {
            
            this.periodName = value;
            this.periodNameLabel = this.getPeriodNameLabel(this.periodNames, this.periodName);
            this.setUrlParams();

            // REFRESH DATA
            this.biweekly = null;
            this.biweeklys = [];

            this.weekly = null;
            this.weeklys = [];

            this.sourceVersion = null;
            this.sourceVersions = [];

            this.dailyPlanHeader = null;
            this.dailyPlanVersion = null;
            this.dailyPlanLines = [];
            this.dailyPlanVersions = [];
            this.dailyRemainingItems = [];

            this.getBiweekOfPlans(this.periodYear, this.periodName);

            this.availableMachines = this.getAvailableMachines(this.machineItems, this.dailyPlanLines);

        },

        async onBiweekOfPlanChanged(value) {
            
            this.biweekly = value;
            this.setUrlParams();

            // REFRESH DATA
            this.weekly = null;
            this.weeklys = [];

            this.sourceVersion = null;
            this.sourceVersions = [];

            this.dailyPlanHeader = null;
            this.dailyPlanVersion = null;
            this.dailyPlanLines = [];
            this.dailyPlanVersions = [];
            this.dailyRemainingItems = [];

            this.availableMachines = this.getAvailableMachines(this.machineItems, this.dailyPlanLines);

            await this.getWeekOfPlans(this.periodYear, this.periodName, this.biweekly);
            await this.getProductPlans(this.periodYear, this.periodName, this.biweekly);

            if(this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType) {

                await this.getSourceVersions(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType);

                // if(this.weekly && this.sourceVersion) {
                if(this.weekly) {
                    this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
                }
            }

        },

        onWeekOfPlanChanged(value) {
            
            this.weekly = value;
            this.setUrlParams();

            // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
            if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType) {
                this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        onSourceVersionChanged(value) {
            
            this.sourceVersion = value;
            this.setUrlParams();

            //// if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
            // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType) {
            //     this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
            // }

        },

        async onPrintTypeChanged(value) {
            
            this.printType = value;
            this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);
            this.setUrlParams();

            this.machineItems = this.filterMachineItems(this.machines, this.printType);

            await this.getSourceVersions(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType);
            
            // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
            if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType) {
                await this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        onSaleTypeChanged(value) {
            
            this.saleType = value;
            this.saleTypeLabel = this.getSaleTypeLabel(this.saleTypes, this.saleType);
            this.setUrlParams();

            // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
            if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType) {
                this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        async onSearchPlanVersion(data) {
            
            this.periodYear = data.period_year;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);

            this.periodName = data.period_name;
            this.periodNameLabel = this.getPeriodNameLabel(this.periodNames, this.periodName);

            this.biweekly = data.biweekly;

            this.weekly = data.weekly;
            
            this.dailyPlanVersion = data.version;

            this.printType = data.print_type;
            this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);

            this.saleType = data.sale_type;
            this.saleTypeLabel = this.getPrintTypeLabel(this.saleTypes, this.saleType);

            this.sourceVersion = data.source_version;
            this.sourceVersions = data.source_versions;

            this.dailyPlanLines = [];

            this.availableMachines = this.getAvailableMachines(this.machineItems, this.dailyPlanLines);

            await this.getPeriodNames(this.periodYear);
            await this.getBiweekOfPlans(this.periodYear, this.periodName);
            await this.getWeekOfPlans(this.periodYear, this.periodName, this.biweekly);
            await this.getProductPlans(this.periodYear, this.periodName, this.biweekly);

            // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
            if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType) {
                this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, this.dailyPlanVersion);
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
            
            this.periodNames = await axios.get("/ajax/pm/plans/daily/get-months", { params })
            .then(res => {
                const resData = res.data.data;
                return resData.period_names ? JSON.parse(resData.period_names) : [];
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ปี ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async getBiweekOfPlans(periodYear, periodName) {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                period_year: periodYear,
                period_name: periodName
            };
            
            this.biweeklys = await axios.get("/ajax/pm/plans/daily/get-biweeks", { params })
            .then(res => {
                const resData = res.data.data;
                return resData.biweeklys ? JSON.parse(resData.biweeklys) : [];
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async getWeekOfPlans(periodYear, periodName, biweekly) {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                period_year: periodYear,
                period_name: periodName,
                biweekly: biweekly,
            };
            
            this.weeklys = await axios.get("/ajax/pm/plans/daily/get-weeks", { params })
            .then(res => {
                const resData = res.data.data;
                return resData.weeklys ? JSON.parse(resData.weeklys) : [];
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async getDailyPlanData(periodYear, periodName, biweekly, weekly, printType, saleType, sourceVersion, version) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.dailyPlanHeader = null;
            this.dailyPlanVersion = version;
            this.dailyPlanLines = [];
            this.dailyPlanVersions = [];
            this.dailyRemainingItems = [];
            
            var params = { 
                period_year: periodYear, 
                period_name: periodName,
                biweekly: biweekly,
                weekly: weekly,
                print_type: printType,
                sale_type: saleType,
                source_version: sourceVersion,
                version: version
            };
            await axios.get("/ajax/pm/plans/daily/get-info", { params })
            .then(res => {
                const resData = res.data.data;
                this.dailyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                this.dailyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });

            
            if(!this.dailyPlanHeader) {
                // CREATE NEW HEADER (FIRSTLY CREATE)
                await this.createNewPlanVersion();
            }

            // GET PLAN LINES
            await this.onGetRemainingItems();
            await this.onGetDailyPlanLines();

            if(this.dailyPlanLines.length == 0) {
                // await this.onGenerateDailyPlanLines();
                await this.onAddNewMachineLine();
            }
            
            this.setUrlParams();

            // HIDE LOADING
            this.isLoading = false;

        },

        async getProductPlans(periodYear, periodName, biweekly) {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                period_year: periodYear,
                period_name: periodName,
                biweekly: biweekly
            };
            await axios.get("/ajax/pm/plans/daily/get-product-plans", { params })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    const resDaily71Dates = JSON.parse(resData.daily_71_dates);
                    const resMachine71Groups = JSON.parse(resData.machine_71_groups);
                    const resProduct71Plans = JSON.parse(resData.product_71_plans);
                    
                    const resDaily78Dates = JSON.parse(resData.daily_78_dates);
                    const resMachine78Groups = JSON.parse(resData.machine_78_groups);
                    const resProduct78Plans = JSON.parse(resData.product_78_plans);

                    this.productDaily71Dates = resDaily71Dates;
                    this.productMachine71Groups = resMachine71Groups;
                    this.product71Plans = resProduct71Plans;

                    this.productDaily78Dates = resDaily78Dates;
                    this.productMachine78Groups = resMachine78Groups;
                    this.product78Plans = resProduct78Plans;
                    
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลแผนการผลิตบุหรี่ | ${resData.message}`, "error");
                }

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลแผนการผลิตบุหรี่ | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async getSourceVersions(periodYear, periodName, biweekly, printType, saleType) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.sourceVersion = null;
            this.sourceVersions = [];
            
            var params = { 
                period_year: periodYear,
                period_name: periodName,
                biweekly: biweekly,
                print_type: printType,
                sale_type: saleType,
            };

            await axios.get("/ajax/pm/plans/daily/get-source-versions", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ข้อมูลไม่ถูกต้อง | ${resData.message}`, "error");
                } else {
                    this.sourceVersion = resData.source_version ? resData.source_version : null;
                    this.sourceVersions = resData.source_versions ? JSON.parse(resData.source_versions) : [];
                    if(this.sourceVersions.length <= 0) {
                        // MOCKUP PREVENT CHECK ON OFFSET
                        if(printType == "52") {
                            swal("ไม่พบข้อมูล", `ไม่พบข้อมูลแผนรายปักษ์ที่อนุมัติแล้ว`, "error");
                        }
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

        filterMachineItems(machines, printTypeValue) {

            const printType = printTypeValue ? printTypeValue : this.printTypes[0].print_type_value;

            const filteredMachines = machines.filter(machine => {
                return printType == machine.print_type
            });

            return filteredMachines;

        },

        getAvailableMachines(machineItems, planLines) {

            const availableMachines = machineItems.filter(machine => {
                const foundMachine = planLines.find(planLine => {
                    return machine.machine_name == planLine.machine_name;
                });
                return !foundMachine;
            });

            return availableMachines;

        },

        async onGetDailyPlanLines() {

            // SHOW LOADING
            this.isLoading = true;

            // const foundWeekly = this.weeklys.find(item => {
            //     return item.weekly_value == this.weekly;
            // });
            // const weekDates = foundWeekly ? foundWeekly.dates : [];

            const params = {
                period_year: this.periodYear, 
                period_name: this.periodName,
                biweekly: this.biweekly,
                weekly: this.weekly,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.dailyPlanVersion,
            };
            await axios.get(`/ajax/pm/plans/daily/get-lines`, { params })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.dailyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    this.dailyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    if(this.dailyPlanHeader) {
                        if(this.sourceVersions.length > 0) {
                            const foundSourceVersion = this.sourceVersions.find(item => item.source_version == this.dailyPlanHeader.source_version);
                            this.sourceVersion = foundSourceVersion ? foundSourceVersion.source_version : this.sourceVersions[0].source_version;
                        } else {
                            this.sourceVersion = null;
                        }
                        this.dailyPlanVersion = this.dailyPlanHeader.version;
                    }
                    this.dailyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    this.availableMachines = this.getAvailableMachines(this.machineItems, this.dailyPlanLines);
                    
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resData.message}`, "error");
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async onAddNewMachineLine() {

            // SHOW LOADING
            this.isLoading = true;

            const foundWeekly = this.weeklys.find(item => {
                return item.weekly_value == this.weekly;
            });
            const weekDates = foundWeekly ? foundWeekly.dates : [];

            const reqBody = {
                period_year: this.periodYear, 
                period_name: this.periodName,
                biweekly: this.biweekly,
                weekly: this.weekly,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.dailyPlanVersion,
                week_dates: JSON.stringify(weekDates),
                machines: JSON.stringify(this.availableMachines),
                plan_header: JSON.stringify(this.dailyPlanHeader)
            };
            await axios.post(`/ajax/pm/plans/daily/add-new-machine-line`, reqBody)
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.dailyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    this.availableMachines = this.getAvailableMachines(this.machineItems, this.dailyPlanLines);
                    
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถสร้างรายการ วางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resData.message}`, "error");
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถสร้างรายการ วางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async onGenerateDailyPlanLines() {

            // SHOW LOADING
            this.isLoading = true;

            const foundWeekly = this.weeklys.find(item => {
                return item.weekly_value == this.weekly;
            });
            const weekDates = foundWeekly ? foundWeekly.dates : [];

            const reqBody = {
                period_year: this.periodYear, 
                period_name: this.periodName,
                biweekly: this.biweekly,
                weekly: this.weekly,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.dailyPlanVersion,
                week_dates: JSON.stringify(weekDates),
                machines: JSON.stringify(this.machines),
            };
            await axios.post(`/ajax/pm/plans/daily/generate-lines`, reqBody)
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.dailyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    this.dailyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    if(this.dailyPlanHeader) {
                        if(this.sourceVersions.length > 0) {
                            const foundSourceVersion = this.sourceVersions.find(item => item.source_version == this.dailyPlanHeader.source_version);
                            this.sourceVersion = foundSourceVersion ? foundSourceVersion.source_version : this.sourceVersions[0].source_version;
                        } else {
                            this.sourceVersion = null;
                        }
                        this.dailyPlanVersion = this.dailyPlanHeader.version;
                    }
                    this.dailyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    this.isNewlyCreate = resData.is_newly_create;
                    this.availableMachines = this.getAvailableMachines(this.machineItems, this.dailyPlanLines);
                    
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resData.message}`, "error");
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async onGetRemainingItems() {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                period_year: this.periodYear, 
                period_name: this.periodName,
                biweekly: this.biweekly,
                weekly: this.weekly,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.dailyPlanVersion
            };
            await axios.get("/ajax/pm/plans/daily/get-remaining-items", { params })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {
                    this.dailyRemainingItems = resData.items ? JSON.parse(resData.items) : [];                    
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resData.message}`, "error");
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        onMachineLineItemsChanged(data) {
            const machineLineItems = data.machineLineItems;
            this.availableMachines = this.machineItems.filter(machine => {
                const foundMachine = machineLineItems.find(planLine => {
                    return machine.machine_name == planLine.machine_name;
                });
                return !foundMachine;
            });
        },

        // async onSaveDailyPlan() {

        //     const reqBody = {
        //         period_year: this.periodYear,
        //         period_name: this.periodName,
        //         biweekly: this.biweekly,
        //         print_type: this.printType,
        //         sale_type: this.saleType,
        //         source_version: this.sourceVersion,
        //         version: this.dailyPlanVersion,
        //         plan_header: JSON.stringify(this.dailyPlanHeader),
        //         plan_lines: JSON.stringify(this.dailyPlanLines)
        //     };

        //     // SHOW LOADING
        //     this.isLoading = true;

        //     // call api
        //     await axios.post(`/ajax/pm/plans/daily/store-lines`, reqBody)
        //     .then(res => {

        //         const resData = res.data.data;
        //         const resMsg = resData.message;
        //         const resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;

        //         if(resData.status == "success") {
        //             this.dailyPlanHeader = resPlanHeader;
        //             this.dailyPlanVersion = resPlanHeader.version;
        //             this.dailyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
        //             this.isNewlyCreate = false;
        //             swal("Success", `บันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} version : ${this.dailyPlanVersion}`, "success");
        //         }

        //         if(resData.status == "error") {
        //             swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resMsg}`, "error");
        //         }
                
        //         return resData;

        //     }).catch((error) => {
        //         console.log(error);
        //         swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
        //     });

        //     // HIDE LOADING
        //     this.isLoading = false;

        // },

        async onSubmitDailyPlan() {

            const reqBody = {
                period_year: this.periodYear,
                period_name: this.periodName,
                biweekly: this.biweekly,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                version: this.dailyPlanVersion,
                plan_header: JSON.stringify(this.dailyPlanHeader),
                plan_lines: JSON.stringify(this.dailyPlanLines)
            };

            // SHOW LOADING
            this.isLoading = true;

            // call api
            await axios.post(`/ajax/pm/plans/daily/submit-plan`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    this.dailyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    this.dailyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    swal("Success", `ส่งข้อมูลแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel}`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถส่งข้อมูลแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถส่งข้อมูลแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // REFRESH DAILY PLAN DATA
            // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
            if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType) {
                this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async onCreateNewDailyPlanVersion() {

            swal({
                title: "",
                text: `ต้องการสร้าง แผนผลิตสิ่งพิมพ์รายวัน ปักษ์ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} เวอร์ชั่นใหม่ ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true
            }, (isConfirm) => {
                if (isConfirm) {
                    this.dailyPlanLines = [];
                    this.createNewPlanVersion();
                    this.availableMachines = this.getAvailableMachines(this.machineItems, this.dailyPlanLines);
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

            // IF ALL VERSIONS ARE NOT COMPLETED ( 1 : NOT_COMFIRMED  )
            // => NOT ALLOW TO CREATE NEW VERSION
            const inprogressVersions = versions.filter(item => {
                return item.status == 1
            });

            if(inprogressVersions.length > 0){
                allowed = false;
            }

            return allowed;

        },

        async createNewPlanVersion(showAlert = false) {

            const reqBody = {
                period_year: this.periodYear,
                period_name: this.periodName,
                biweekly: this.biweekly,
                weekly: this.weekly,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion
            };

            // SHOW LOADING
            this.isLoading = true;

            // call api
            await axios.post(`/ajax/pm/plans/daily/add-new-header`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    
                    this.dailyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    this.dailyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    this.dailyPlanVersion = resData.version;
                    this.dailyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];

                    if(showAlert) {
                        swal("Success", `สร้างข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} version : ${this.dailyPlanVersion} )`, "success");
                    }

                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `สร้างข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `สร้างข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        }

    }

}

</script>