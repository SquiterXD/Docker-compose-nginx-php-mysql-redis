<template>

    <div style="position: fixed; z-index: 100;">
        
        <modal
            :name="modalName"
            :width="width"
            :scrollable="true"
            :height="modalHeight"
            :shiftX="0.4"
            :shiftY="0.3"
        >

            <div class="p-4">

                <h4> ค้นหาแผนผลิตสิ่งพิมพ์รายเดือน </h4>
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

                <!-- <div class="row form-group">

                    <label class="col-md-4 col-form-label tw-font-bold"> ครั้งที่ </label>

                    <div class="col-md-8">

                        <pm-el-select name="source_version" id="source_version" 
                            :select-options="sourceVersionOptions"
                            option-key="version"
                            option-value="version" 
                            option-label="version" 
                            :value="sourceVersion"
                            :filterable="true"
                            @onSelected="onSourceVersionChanged"
                        />

                    </div>

                </div> -->

                <div class="row form-group">

                    <label class="col-md-4 col-form-label tw-font-bold"> เวอร์ชั่น </label>

                    <div class="col-md-8">

                        <pm-el-select name="monthly_plan_version" id="input_monthly_plan_version" 
                            :select-options="monthlyPlanVersionOptions"
                            option-key="version"
                            option-value="version" 
                            option-label="version" 
                            :value="monthlyPlanVersion"
                            :filterable="true"
                            @onSelected="onMonthlyPlanVersionChanged"
                        />

                    </div>

                </div>

                <div class="text-right tw-mt-8">

                    <button type="button" 
                        @click="onSearchPlanVersion" 
                        class="btn btn-primary tw-w-32" 
                        :disabled="!periodYear || !periodName || !monthlyPlanVersion"> 
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

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

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
        "printTypes", 
        "printTypeValue", 
        "saleTypes", 
        "saleTypeValue", 
        "sourceVersions", 
        "sourceVersionValue", 
        "monthlyPlanVersions", 
        "monthlyPlanVersionValue"
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
            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYearOptions, value);
        },
        periodNames : function (value) {
            this.periodNameOptions = value;
        },
        periodNameValue : function (value) {
            this.periodName = this.periodNameValue;
            this.periodNameLabel = this.getPeriodNameLabel(this.periodNameOptions, this.periodName);
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
        monthlyPlanVersionValue : function (value) {
            this.monthlyPlanVersion = value;
        },
        monthlyPlanVersions : function (value) {
            this.monthlyPlanVersionOptions = value;
        },
    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            planHeaderData: this.planHeader,
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
            periodYearOptions: this.periodYears,
            periodName: this.periodNameValue,
            periodNameLabel: this.periodNameValue,
            periodNameOptions: this.periodNames,
            printType: this.printTypeValue,
            saleType: this.saleTypeValue,
            sourceVersion: this.sourceVersionValue,
            sourceVersionOptions: this.sourceVersions,
            monthlyPlanVersion: this.monthlyPlanVersionValue,
            monthlyPlanVersionOptions: this.monthlyPlanVersions,
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

            // REFRESH DATA
            this.periodName = null;
            this.periodNameLabel = "";

            this.sourceVersion = null;
            this.sourceVersionOptions = [];

            this.monthlyPlanVersion = null;
            this.monthlyPlanVersionOptions = [];

            this.getPeriodNames(value);
            
        },

        getPeriodYearLabel(periodYears, periodYear) {
            const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
            return foundPeriodYear ? foundPeriodYear.period_year_label : "";
        },

        getPeriodNameLabel(periodNames, periodName) {
            const foundPeriodName = periodNames.find(item => item.period_name_value == periodName);
            return foundPeriodName ? foundPeriodName.period_name_label : "";
        },

        async onPeriodNameChanged(value) {
            
            this.periodName = value;
            this.periodNameLabel = this.getPeriodNameLabel(this.periodNameOptions, this.periodName);

            if(this.periodYear && this.periodName && this.printType && this.saleType) {
                
                await this.getSourceVersions(this.periodYear, this.periodName, this.printType, this.saleType);

                if(this.sourceVersion) {
                    this.getMonthlyPlanData(this.periodYear, this.periodName, this.printType, this.saleType, this.sourceVersion, null);
                }
            }

        },

        onSourceVersionChanged(value) {
            
            this.sourceVersion = value;

            // if(this.periodYear && this.periodName && this.printType && this.saleType && this.sourceVersion) {
            //     this.getMonthlyPlanData(this.periodYear, this.periodName, this.printType, this.saleType, this.sourceVersion, null);
            // }

        },

        onPrintTypeChanged(value) {
            
            this.printType = value;

            if(this.periodYear && this.periodName && this.printType && this.saleType && this.sourceVersion) {
                this.getMonthlyPlanData(this.periodYear, this.periodName, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        onSaleTypeChanged(value) {
            
            this.saleType = value;
            
            if(this.periodYear && this.periodName && this.printType && this.saleType && this.sourceVersion) {
                this.getMonthlyPlanData(this.periodYear, this.periodName, this.printType, this.saleType, this.sourceVersion, null);
            }

        },

        onMonthlyPlanVersionChanged(value) {
            this.monthlyPlanVersion = value;
        },

        async getPeriodNames(periodYear) {

            // show loading
            this.isLoading = true;
            
            var params = { 
                period_year: periodYear
            };

            // REFRESH DATA
            this.periodNameOptions = [];
            
            this.periodNameOptions = await axios.get("/ajax/pm/plans/monthly/get-months", { params })
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

        async getMonthlyPlanData(periodYear, periodName, printType, saleType, sourceVersion, version) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.monthlyPlanVersion = null;
            this.monthlyPlanVersionOptions = [];
            
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
                this.monthlyPlanVersionOptions = resData.versions ? JSON.parse(resData.versions) : [];
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `${error.message}`, "error");
                return ;
            });
            this.monthlyPlanVersion = this.monthlyPlanVersionOptions.length > 0 ? this.monthlyPlanVersionOptions[0].version : null;

            // hide loading
            this.isLoading = false;

        },

        async getSourceVersions(periodYear, periodName, printType, saleType) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.sourceVersion = null;
            this.sourceVersionOptions = [];
            
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
                    this.sourceVersionOptions = resData.source_versions ? JSON.parse(resData.source_versions) : [];
                    if(this.sourceVersionOptions.length <= 0) {
                        swal("ไม่พบข้อมูล", `ไม่พบข้อมูลแผนจากฝ่ายขาย`, "error");
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
                print_type: this.printType,
                sale_type: this.saleType,
                source_version: this.sourceVersion,
                source_versions: this.sourceVersionOptions,
                version: this.monthlyPlanVersion
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
