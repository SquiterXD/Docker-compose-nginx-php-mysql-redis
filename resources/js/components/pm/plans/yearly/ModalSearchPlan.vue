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

                <h4> ค้นหาประมาณการวัตถุดิบประจำปี </h4>
                <hr>

                <div v-if="isAllowSelectPrintType(organizationCode)" class="row form-group">

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

                <div v-if="isAllowSelectSaleType(organizationCode)" class="row form-group">

                    <label class="col-md-4 col-form-label tw-font-bold"> ประเภทแผน </label>

                    <div class="col-md-8">

                        <pm-el-select name="sale_type" id="input_sale_type" 
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

                <div v-if="isAllowSelectIngredientGroup(organizationCode)" class="row form-group">

                    <label class="col-md-4 col-form-label tw-font-bold"> ประเภทวัตถุดิบ </label>

                    <div class="col-md-8">

                        <pm-el-select name="ingredient_group" id="ingredient_group" 
                            :select-options="ingredientGroups"
                            option-key="value"
                            option-value="value" 
                            option-label="description"
                            :value="ingredientGroup"
                            :filterable="true"
                            @onSelected="onIngredientGroupChanged"
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

                        <pm-el-select name="yearly_plan_version" id="input_yearly_plan_version" 
                            :select-options="yearlyPlanVersionOptions"
                            option-key="version"
                            option-value="version" 
                            option-label="version" 
                            :value="yearlyPlanVersion"
                            :filterable="true"
                            @onSelected="onYearlyPlanVersionChanged"
                        />

                    </div>

                </div>

                <div class="text-right tw-mt-8">

                    <button type="button" 
                        @click="onSearchPlanVersion" 
                        class="btn btn-primary tw-w-32"
                        :disabled="!periodYear || !yearlyPlanVersion"> 
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
        "organizationCode", 
        "planHeader",
        "periodYears", 
        "periodYearValue", 
        "printTypes", 
        "printTypeValue", 
        "saleTypes", 
        "saleTypeValue", 
        "ingredientGroups", 
        "ingredientGroupValue", 
        "sourceVersions", 
        "sourceVersionValue", 
        "yearlyPlanVersions", 
        "yearlyPlanVersionValue"
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
        printTypeValue : function (value) {
            this.printType = value;
        },
        saleTypeValue : function (value) {
            this.saleType = value;
        },
        ingredientGroupValue : function (value) {
            this.ingredientGroup = value;
        },
        sourceVersionValue : function (value) {
            this.sourceVersion = value;
        },
        sourceVersions : function (value) {
            this.sourceVersionOptions = value;
        },
        yearlyPlanVersionValue : function (value) {
            this.yearlyPlanVersion = value;
        },
        yearlyPlanVersions : function (value) {
            this.yearlyPlanVersionOptions = value;
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
            printType: this.printTypeValue,
            saleType: this.saleTypeValue,
            ingredientGroup: this.ingredientGroupValue,
            sourceVersion: this.sourceVersionValue,
            sourceVersionOptions: this.sourceVersions,
            yearlyPlanVersion: this.yearlyPlanVersionValue,
            yearlyPlanVersionOptions: this.yearlyPlanVersions,
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

        async onYearlyPlanChanged(value) {

            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYearOptions, this.periodYear);

                
            await this.getSourceVersions(this.periodYear, this.printType, this.saleType);

            if(this.sourceVersion) {
                this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.ingredientGroup, this.sourceVersion, null);
            }

        },

        onPrintTypeChanged(value) {

            this.printType = value;

            this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.ingredientGroup, this.sourceVersion, null);

        },

        onSourceVersionChanged(value) {
            
            this.sourceVersion = value;

        },

        onSaleTypeChanged(value) {
            
            this.saleType = value;

            this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.ingredientGroup, this.sourceVersion, null);

        },

        onIngredientGroupChanged(value) {
            
            this.ingredientGroup = value;

            this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.ingredientGroup, this.sourceVersion, null);

        },

        onYearlyPlanVersionChanged(value) {
            this.yearlyPlanVersion = value;
        },

        getPeriodYearLabel(periodYears, periodYear) {
            const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
            return foundPeriodYear ? foundPeriodYear.period_year_label : "";
        },

        isAllowSelectPrintType(organizationCode) {

            let allowed = false;
            if(organizationCode == "M06") {
                allowed = true;
            }

            return allowed;
        
        },

        isAllowSelectSaleType(organizationCode) {

            let allowed = false;
            if(organizationCode == "M06") {
                allowed = true;
            }

            return allowed;
        
        },

        isAllowSelectIngredientGroup(organizationCode) {

            let allowed = false;
            if(organizationCode == "M02") {
                allowed = true;
            }

            return allowed;
        
        },

        validateBeforeGetHeader(organizationCode, periodYear, printType, saleType, ingredientGroup, sourceVersion) {

            let valid = false;

            if(organizationCode == "M06") {

                if(periodYear && printType && saleType && sourceVersion) {
                    valid = true;
                }

            } else if(organizationCode == "M02") {

                if(periodYear && ingredientGroup && sourceVersion) {
                    valid = true;
                }

            } else {

                if(periodYear && sourceVersion) {
                    valid = true;
                }

            }

            return valid;
        },

        validateBeforeGetSourceVersions(organizationCode, periodYear, printType, saleType, ingredientGroup) {

            let valid = false;

            if(organizationCode == "M06") {

                if(periodYear && printType && saleType) {
                    valid = true;
                }

            } else if(organizationCode == "M02") {

                if(periodYear && ingredientGroup) {
                    valid = true;
                }

            } else {

                if(periodYear) {
                    valid = true;
                }

            }

            return valid;

        },

        async getYearlyPlanData(periodYear, printType, saleType, ingredientGroup, sourceVersion, version) {

            // show loading
            this.is_loading = true;

            // REFRESH DATA
            this.yearlyPlanVersion = null;
            this.yearlyPlanVersionOptions = [];
            
            var params = { 
                period_year: periodYear,
                print_type: printType,
                sale_type: saleType,
                ingredient_group: ingredientGroup,
                source_version: sourceVersion,
                version: version
            };

            // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE
            const isValid = this.validateBeforeGetHeader(this.organizationCode, periodYear, printType, saleType, ingredientGroup, sourceVersion);
            if(isValid) {

                await axios.get("/ajax/pm/plans/yearly/get-info", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ข้อมูลแผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel} ไม่ถูกต้อง | ${resData.message}`, "error");
                    } else {
                        this.yearlyPlanVersionOptions = resData.versions.length > 0 ? JSON.parse(resData.versions) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `${error.message}`, "error");
                    return ;
                });
                this.yearlyPlanVersion = this.yearlyPlanVersionOptions.length > 0 ? this.yearlyPlanVersionOptions[0].version : null;

            }

            // hide loading
            this.is_loading = false;

        },

        async getSourceVersions(periodYear, printType, saleType) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.sourceVersion = null;
            this.sourceVersionOptions = [];
            
            var params = { 
                period_year: periodYear,
                print_type: printType,
                sale_type: saleType,
                ingredient_group: ingredientGroup,
            };

            // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE
            const isValid = this.validateBeforeGetSourceVersions(this.organizationCode, periodYear, printType, saleType, ingredientGroup);
            if(isValid) {

                await axios.get("/ajax/pm/plans/yearly/get-source-versions", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ข้อมูลไม่ถูกต้อง | ${resData.message}`, "error");
                    } else {
                        this.sourceVersion = resData.source_version ? resData.source_version : null;
                        this.sourceVersionOptions = resData.source_versions ? JSON.parse(resData.source_versions) : [];
                        if(this.sourceVersionOptions.length <= 0) {
                            swal("ไม่พบข้อมูล", `ไม่พบข้อมูลแผนประมาณการจำหน่ายประจำปี (ฝ่ายขาย)`, "error");
                        }
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ข้อมูลไม่ถูกต้อง | ${error.message}`, "error");
                    return ;
                });

            }
        
            // hide loading
            this.isLoading = false;

        },

        onSearchPlanVersion() {
            this.$modal.hide(this.modalName);
            this.$emit("onSearchPlanVersion", {
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                ingredient_group: this.ingredientGroup,
                source_version: this.sourceVersion,
                source_versions: this.sourceVersionOptions,
                version: this.yearlyPlanVersion
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
