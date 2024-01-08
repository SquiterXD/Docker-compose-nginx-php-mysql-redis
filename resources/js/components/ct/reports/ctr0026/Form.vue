<template>

    <div class="row">

        <div class="offset-md-2 col-md-8">

            <div class="row form-group">
                <label class="col-md-4 required"> ปี </label>
                <div class="col-md-8">
                    <qm-el-select name="period_year" id="input_period_year" placeholder="ปี "
                        option-key="period_year_value" option-value="period_year_value" option-label="period_year_label"
                        @onSelected="onPeriodYearChanged($event)"
                        :select-options="periodYears" 
                        :clearable="false" 
                        :filterable="true"
                        :value="periodYear"  />
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-4 required"> ครั้งที่ </label>
                <div class="col-md-8">
                    <qm-el-select name="ct14_version_no" id="input_ct14_version_no" placeholder="ครั้งที่ "
                        option-key="ct14_version_no" option-value="ct14_version_no" option-label="ct14_version_no"
                        @onSelected="onVersionNoChanged($event)"
                        :select-options="versionNoOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="versionNo"  />
                </div>
            </div>

            <div class="row form-group">

                <label class="col-md-4 required"> แผนการผลิตครั้งที่ </label>
                <div class="col-md-8">
                    <qm-el-select name="plan_version_no" id="input_plan_version_no" placeholder="แผนการผลิตครั้งที่ "
                        option-key="plan_version_no" option-value="plan_version_no" option-label="plan_version_no"
                        @onSelected="onPlanVersionNoChanged($event)"
                        :select-options="planVersionNoOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="planVersionNo"  />
                </div>

            </div>

            <div class="row form-group">

                <label class="col-md-4 required"> ศูนย์ต้นทุน </label>
                <div class="col-md-8">
                    <qm-el-select name="cost_code_from" id="input_cost_code_from" placeholder="ศูนย์ต้นทุน "
                        option-key="cost_code_value" option-value="cost_code_value" option-label="cost_code_label"
                        @onSelected="onCostCodeFromChanged($event)"
                        :select-options="costCodeFromOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="costCodeFrom"  />
                </div>
                
            </div>

            <div class="row form-group">

                <label class="col-md-4 required"> ถึงศูนย์ต้นทุน </label>
                <div class="col-md-8">
                    <qm-el-select name="cost_code_to" id="input_cost_code_to" placeholder="ถึงศูนย์ต้นทุน "
                        option-key="cost_code_value" option-value="cost_code_value" option-label="cost_code_label"
                        @onSelected="onCostCodeToChanged($event)"
                        :select-options="costCodeToOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="costCodeTo"  />
                </div>
                
            </div>

            <div class="row form-group">
            
                <label class="col-md-4"> ผลิตภัณฑ์ใหม่ระหว่างปี </label>
                <div class="col-md-8">
                    <el-checkbox name="input_product_of_year" id="input_product_of_year" @change="onProductOfYearChanged($event)">
                    </el-checkbox>
                    <input type="hidden" name="product_of_year" v-model="productOfYear">
                </div>
            
            </div>

        </div>

        <div class="offset-md-2 col-md-8 text-right tw-mt-2 tw-mb-4">

            <button type="submit" class="btn btn-sm btn-primary"
                :disabled="!periodYear || !versionNo || !planVersionNo || !costCodeFrom"
            >
                <i class="fa fa fa-file-excel-o tw-mr-1"></i> พิมพ์รายงาน
            </button>

        </div>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

export default {
    props: [
        "periodYears",
        "periodYearValue",
        "versionNos", 
        "cigVersions",
        "filterVersions",
        "versionNoValue", 
        "planVersionNos", 
        "planVersionNoValue", 
        "costCodes",
        "costCodeFromValue",
        "costCodeToValue",
    ],

    components: {
        Loading
    },

    data() {
        return {
            periodYear: this.periodYearValue,
            versionNo: this.versionNoValue,
            planVersionNo: this.planVersionNoValue,
            costCodeFrom: this.costCodeFromValue,
            costCodeTo: this.costCodeToValue,
            versionNoOptions: [],
            planVersionNoOptions: [],
            costCodeFromOptions: [],
            costCodeToOptions: [],
            productOfYear: false,
        };
    },

    mounted() {

        if(this.periodYearValue) {

            this.filterVersionOptions(this.periodYearValue);
            this.filterPlanVersionNoOptions(this.periodYearValue);
            this.filterCostCodeFromOptions(this.periodYearValue);
            if(this.costCodeFromValue) {
                this.filterCostCodeToOptions(this.periodYearValue, this.costCodeFromValue);
            } else {
                this.filterCostCodeToOptions(this.periodYearValue, null);
            }

        }

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("period_year", this.periodYear ? this.periodYear : '');
            queryParams.set("ct14_version_no", this.versionNo ? this.versionNo : '');
            queryParams.set("plan_version_no", this.planVersionNo ? this.planVersionNo : '');
            queryParams.set("cost_code_from", this.costCodeFrom ? this.costCodeFrom : '');
            queryParams.set("cost_code_to", this.costCodeTo ? this.costCodeTo : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        onPeriodYearChanged(periodYear){

            this.periodYear = periodYear;

            this.filterVersionOptions(this.periodYear);
            if(this.versionNoOptions.length > 0) {
                this.versionNo = this.versionNoOptions[0].ct14_version_no;
            }

            this.filterPlanVersionNoOptions(this.periodYear);
            if(this.planVersionNoOptions.length > 0) {
                this.planVersionNo = this.planVersionNoOptions[0].plan_version_no;
            }

            this.filterCostCodeFromOptions(this.periodYear);
            if(this.costCodeFromOptions.length > 0) {
                this.costCodeFrom = this.costCodeFromOptions[0].cost_code_value;
                this.filterCostCodeToOptions(this.periodYear, this.costCodeFrom);
            } else {
                this.filterCostCodeToOptions(this.periodYear, null);
            }
            if(this.costCodeToOptions.length > 0) {
                this.costCodeTo = this.costCodeToOptions[0].cost_code_value;
            }

            this.setUrlParams();

        },

        onVersionNoChanged(versionNo) {
            this.versionNo = versionNo;
            this.setUrlParams();
        },

        onPlanVersionNoChanged(planVersionNo) {
            this.planVersionNo = planVersionNo;
            this.setUrlParams();
        },

        onCostCodeFromChanged(costCode) {
            this.costCodeFrom = costCode;
            this.filterCostCodeToOptions(this.periodYear, this.costCodeFrom);
            if(this.costCodeToOptions.length > 0) {
                this.costCodeTo = this.costCodeToOptions[0].cost_code_value;
            }
            this.setUrlParams();
        },

        onCostCodeToChanged(costCode) {
            this.costCodeTo = costCode;
            this.setUrlParams();
        },

        filterVersionOptions(periodYear) {
            if(periodYear){
                this.versionNoOptions = this.versionNos.filter(item => item.period_year == periodYear);
            } else {
                this.versionNoOptions = [];
            }
        },

        filterPlanVersionNoOptions(periodYear) {
            if(periodYear){
                this.planVersionNoOptions = this.planVersionNos.filter(item => item.period_year == periodYear);
            } else {
                this.planVersionNoOptions = [];
            }
        },

        filterCostCodeFromOptions(periodYear) {
            if(periodYear){
                this.costCodeFromOptions = this.costCodes.filter(item => item.period_year == periodYear);
            } else {
                this.costCodeFromOptions = [];
            }
        },

        filterCostCodeToOptions(periodYear, fromCostCode) {
            if(periodYear){
                if(fromCostCode) {
                    this.costCodeToOptions = this.costCodes.filter(item => (item.period_year == periodYear && parseInt(item.cost_code) >= parseInt(fromCostCode)));
                } else {
                    this.costCodeToOptions = this.costCodes.filter(item => item.period_year == periodYear);
                }
            } else {
                this.costCodeToOptions = [];
            }
        },

        onProductOfYearChanged(value) {
            this.productOfYear = value;
        },

    }

};
</script>
