<template>

    <div style="position: fixed; z-index: 100;">
        
        <modal
            :name="modalName"
            :width="width"
            :scrollable="true"
            :height="modalHeight"
            :shiftX="0.3"
            :shiftY="0.3"
        >

            <div class="p-4">

                <h4> ค้นหาแผนผลิตสิ่งพิมพ์รายวัน </h4>
                <hr>

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
                            :select-options="periodYearOptions"
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
                            :select-options="periodNameOptions"
                            option-key="period_name_value"
                            option-value="period_name_value" 
                            option-label="period_name_label" 
                            :value="periodName"
                            :filterable="true"
                            @onSelected="onPeriodNameChanged"
                        />

                        
                    </div>

                </div>

                <div class="row form-group">

                    <label class="col-md-4 col-form-label tw-font-bold"> ปักษ์ </label>

                    <div class="col-md-8">

                        <pm-el-select name="biweekly" id="input_biweekly" 
                            :select-options="biweeklyOptions"
                            option-key="biweekly_value"
                            option-value="biweekly_value" 
                            option-label="biweekly_label" 
                            :value="biweekly"
                            :filterable="true"
                            @onSelected="onBiweekOfPlanChanged"
                        />

                        
                    </div>

                </div>

                <!-- <div class="row form-group">

                    <label class="col-md-4 col-form-label tw-font-bold"> ครั้งที่ </label>

                    <div class="col-md-8">

                        <pm-el-select name="source_version" id="source_version" 
                            :select-options="sourceVersionOptions"
                            option-key="source_version"
                            option-value="source_version" 
                            option-label="source_version" 
                            :value="sourceVersion"
                            :filterable="true"
                            @onSelected="onSourceVersionChanged"
                        />

                    </div>

                </div> -->

                <div class="row form-group">

                    <label class="col-md-4 col-form-label tw-font-bold"> สัปดาห์ </label>

                    <div class="col-md-8">

                        <pm-el-select name="weekly" id="input_weekly" 
                            :select-options="weeklyOptions"
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

                        <pm-el-select name="monthly_plan_version" id="input_monthly_plan_version" 
                            :select-options="dailyPlanVersionOptions"
                            option-key="version"
                            option-value="version" 
                            option-label="version" 
                            :value="dailyPlanVersion"
                            :filterable="true"
                            @onSelected="onBiweeklyPlanVersionChanged"
                        />

                    </div>

                </div>

                <div class="text-right tw-mt-8">

                    <button type="button" 
                        @click="onSearchPlanVersion" 
                        class="btn btn-primary tw-w-32" 
                        :disabled="!periodYear || !periodName || !biweekly || !weekly || !dailyPlanVersion"> 
                        เลือก 
                    </button>

                    <button type="button" 
                        @click="$modal.hide(modalName)" 
                        class="btn btn-link"> 
                        ยกเลิก 
                    </button>
                    
                </div>

            </div>

        </modal>

        <loading :active.sync="is_loading" :is-full-page="true"></loading>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {

    props: [
        "modalName", 
        "modalWidth", 
        "modalHeight", 
        "planHeader",
        "periodYears", 
        "periodYearValue", 
        "periodNames", 
        "periodNameValue", 
        "biweeklys", 
        "biweeklyValue", 
        "weeklys", 
        "weeklyValue", 
        "printTypes", 
        "printTypeValue", 
        "saleTypes", 
        "saleTypeValue", 
        "sourceVersions", 
        "sourceVersionValue", 
        "dailyPlanVersions", 
        "dailyPlanVersionValue"
    ],

    components: { Loading },

    watch: {
        planHeader : function (value) {
            this.planHeaderData = value;
        },
        periodYears : function (value) {
            this.periodYearOptions = value;
        },
        periodYearValue : function (value) {
            this.periodYear = this.periodYearValue;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYearOptions, this.periodYear);
        },
        periodNames : function (value) {
            this.periodNameOptions = value;
        },
        periodNameValue : function (value) {
            this.periodName = this.periodNameValue;
            this.periodNameLabel = this.getPeriodNameLabel(this.periodNameOptions, this.periodName);
        },
        biweeklys : function (value) {
            this.biweeklyOptions = value;
        },
        biweeklyValue : function (value) {
            this.biweekly = this.biweeklyValue;
        },
        weeklys : function (value) {
            this.weeklyOptions = value;
        },
        weeklyValue : function (value) {
            this.weekly = this.weeklyValue;
        },
        printTypeValue : function (value) {
            this.printType = value;
        },
        saleTypeValue : function (value) {
            this.saleType = value;
        },
        sourceVersionValue : function (value) {
            this.sourceVersion = value;
        },
        sourceVersions : function (value) {
            this.sourceVersionOptions = value;
        },
        dailyPlanVersionValue : function (value) {
            this.dailyPlanVersion = value;
        },
        dailyPlanVersions : function (value) {
            this.dailyPlanVersionOptions = value;
        },
    },

    data() {
        return {
            is_loading: false,
            width: this.modalWidth,
            planHeaderData: this.planHeader,
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
            periodYearOptions: this.periodYears,
            periodName: this.periodNameValue,
            periodNameOptions: this.periodNames,
            biweekly: this.biweeklyValue,
            biweeklyOptions: this.biweeklys,
            weekly: this.weeklyValue,
            weeklyOptions: this.weeklys,
            printType: this.printTypeValue,
            saleType: this.saleTypeValue,
            sourceVersion: this.sourceVersionValue,
            sourceVersionOptions: this.sourceVersions,
            dailyPlanVersion: this.dailyPlanVersionValue,
            dailyPlanVersionOptions: this.dailyPlanVersions,
        };
    },

    created() {
        this.handleResize();
    },

    methods: {

        handleResize() {
            if (window.innerWidth < 768) {
                // set modal width = 90% when screen width < 769px
                this.width = "90%";
            } else if (window.innerWidth < 992) {
                // set modal width = 80% when screen width < 992px
                this.width = "80%";
            } else {
                this.width = this.modalWidth;
            }
        },

        onYearlyPlanChanged(value) {

            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYearOptions, this.periodYear);
            
            // REFREH DATA
            this.periodName = null;
            this.periodNameLabel = "";
            this.periodNameOptions = [];
            this.biweeklyOptions = [];

            this.sourceVersion = null;
            this.sourceVersions = [];

            this.sourceVersion = null;
            this.sourceVersions = [];

            this.dailyPlanVersion = null;
            this.dailyPlanVersionOptions = [];

            this.getPeriodNames(value);
            
        },

        onPeriodNameChanged(value) {
            
            this.periodName = value;
            this.periodNameLabel = this.getPeriodNameLabel(this.periodNameOptions, this.periodName);
            
            // REFREH DATA
            this.biweeklyOptions = [];
            
            this.sourceVersion = null;
            this.sourceVersions = [];

            this.dailyPlanVersion = null;
            this.dailyPlanVersionOptions = [];

            this.getBiweekOfPlans(this.periodYear, value);

        },

        async onBiweekOfPlanChanged(value) {
            
            this.biweekly = value;

            // REFREH DATA
            this.sourceVersion = null;
            this.sourceVersions = [];

            this.dailyPlanVersion = null;
            this.dailyPlanVersionOptions = [];

            await this.getWeekOfPlans(this.periodYear, this.periodName, this.biweekly);
            this.weekly = this.weeklys.length > 0 ? this.weeklys[0].weekly_value : null;

            if(this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType) {

                await this.getSourceVersions(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType);

                if(this.weekly && this.sourceVersion) {
                    this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
                }

            }

        },

        async onWeekOfPlanChanged(value) {
            
            this.weekly = value;

            if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
                this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        onSourceVersionChanged(value) {
            
            this.sourceVersion = value;

            // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
            //     this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
            // }

        },

        onPrintTypeChanged(value) {
            
            this.printType = value;

            if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
                this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        onSaleTypeChanged(value) {
            
            this.saleType = value;

            if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
                this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        onBiweeklyPlanVersionChanged(value) {
            this.dailyPlanVersion = value;
        },

        getPeriodYearLabel(periodYears, periodYear) {
            const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
            return foundPeriodYear ? foundPeriodYear.period_year_label : "";
        },

        getPeriodNameLabel(periodNames, periodName) {
            const foundPeriodName = periodNames.find(item => item.period_name_value == periodName);
            return foundPeriodName ? foundPeriodName.period_name_label : "";
        },

        async getPeriodNames(periodYear) {

            // show loading
            this.is_loading = true;

            // REFRESH DATA
            this.dailyPlanVersion = null;
            this.dailyPlanVersionOptions = [];
            
            var params = { 
                period_year: periodYear
            };
            
            this.periodNameOptions = await axios.get("/ajax/pm/plans/daily/get-months", { params })
            .then(res => {
                const resData = res.data.data;
                return resData.period_names ? JSON.parse(resData.period_names) : [];
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ปี ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });

            // hide loading
            this.is_loading = false;

        },

        async getBiweekOfPlans(periodYear, periodName) {

            // show loading
            this.is_loading = true;
            
            var params = { 
                period_year: periodYear,
                period_name: periodName
            };
            
            this.biweeklyOptions = await axios.get("/ajax/pm/plans/daily/get-biweeks", { params })
            .then(res => {
                const resData = res.data.data;
                return resData.biweeklys ? JSON.parse(resData.biweeklys) : [];
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });

            // hide loading
            this.is_loading = false;

        },

        async getWeekOfPlans(periodYear, periodName, biweekly) {

            // show loading
            this.is_loading = true;
            
            var params = { 
                period_year: periodYear,
                period_name: periodName,
                biweekly: biweekly,
            };
            
            this.weeklyOptions = await axios.get("/ajax/pm/plans/daily/get-weeks", { params })
            .then(res => {
                const resData = res.data.data;
                return resData.weeklys ? JSON.parse(resData.weeklys) : [];
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });

            // hide loading
            this.is_loading = false;

        },

        async getDailyPlanData(periodYear, periodName, biweekly, weekly, printType, saleType, sourceVersion, version) {

            // show loading
            this.is_loading = true;
            
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
                this.dailyPlanVersionOptions = resData.versions ? JSON.parse(resData.versions) : [];
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `${error.message}`, "error");
                return ;
            });
            this.dailyPlanVersion = this.dailyPlanVersionOptions.length > 0 ? this.dailyPlanVersionOptions[0].version : null;

            // hide loading
            this.is_loading = false;

        },

        async getSourceVersions(periodYear, periodName, biweekly, printType, saleType) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.sourceVersion = null;
            this.sourceVersionOptions = [];
            
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
                    this.sourceVersionOptions = resData.source_versions ? JSON.parse(resData.source_versions) : [];
                    if(this.sourceVersionOptions.length <= 0) {
                        swal("ไม่พบข้อมูล", `ไม่พบข้อมูลแผนรายปักษ์ที่อนุมัติแล้ว`, "error");
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

        onSearchPlanVersion() {
            this.$modal.hide(this.modalName);
            this.$emit("onSearchPlanVersion", {
                period_year: this.periodYear,
                period_name: this.periodName,
                biweekly: this.biweekly,
                weekly: this.weekly,
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                source_versions: this.sourceVersionOptions,
                version: this.dailyPlanVersion
            });
        },


    }
};
</script>

<style scoped>
.v--modal-overlay {
  z-index: 2000;
  padding-top: 3rem;
  padding-bottom: 3rem;
}
</style>
