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
                <label class="col-md-4 required"> ครั้งที่กระดาษปันส่วน </label>
                <div class="col-md-8">
                    <qm-el-select name="version_no" id="input_version_no" placeholder="ครั้งที่กระดาษปันส่วน "
                        option-key="version_no" option-value="version_no" option-label="version_no"
                        @onSelected="onVersionNoChanged($event)"
                        :select-options="versionNoOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="versionNo"  />
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-4 required"> ครั้งที่กระดาษทำการ </label>
                <div class="col-md-8">
                    <qm-el-select name="ct14_version_no" id="input_ct14_version_no" placeholder="ครั้งที่กระดาษทำการ "
                        option-key="ct14_version_no" option-value="ct14_version_no" option-label="ct14_version_no"
                        @onSelected="onCt14VersionNoChanged($event)"
                        :select-options="ct14VersionNoOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="ct14VersionNo"  />
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

                <label class="col-md-4 required"> ประเภทบัญชี </label>
                <div class="col-md-8">
                    <qm-el-select name="account_type" id="input_account_type" placeholder="ประเภทบัญชี "
                        option-key="account_type" option-value="account_type" option-label="description"
                        @onSelected="onAccountTypeChanged($event)"
                        :select-options="accountTypeOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="accountType"  />
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
        "ct14VersionNos", 
        "cigVersions",
        "filterVersions",
        "versionNoValue", 
        "ct14VersionNoValue",
        "planVersionNos", 
        "planVersionNoValue", 
        "costCodes",
        "costCodeFromValue",
        "costCodeToValue",
        "accountTypes",
        "accountTypeValue"
    ],

    components: {
        Loading
    },

    data() {
        return {
            periodYear: this.periodYearValue,
            versionNo: this.versionNoValue,
            ct14VersionNo: this.ct14VersionNoValue,
            planVersionNo: this.planVersionNoValue,
            costCodeFrom: this.costCodeFromValue,
            costCodeTo: this.costCodeToValue,
            accountType: this.accountTypeValue,
            versionNoOptions: [],
            ct14VersionNoOptions: [],
            planVersionNoOptions: [],
            costCodeFromOptions: [],
            costCodeToOptions: [],
            accountTypeOptions: this.accountTypes,
        };
    },

    mounted() {

        if(this.periodYearValue) {

            this.filterVersionOptions(this.periodYearValue);
            this.filterCt14VersionOptions(this.periodYearValue);
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
            queryParams.set("version_no", this.versionNo ? this.versionNo : '');
            queryParams.set("ct14_version_no", this.ct14VersionNo ? this.ct14VersionNo : '');
            queryParams.set("plan_version_no", this.planVersionNo ? this.planVersionNo : '');
            queryParams.set("cost_code_from", this.costCodeFrom ? this.costCodeFrom : '');
            queryParams.set("cost_code_to", this.costCodeTo ? this.costCodeTo : '');
            queryParams.set("account_type", this.accountType ? this.accountType : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        onPeriodYearChanged(periodYear){

            this.periodYear = periodYear;

            this.filterVersionOptions(this.periodYear);
            if(this.versionNoOptions.length > 0) {
                this.versionNo = this.versionNoOptions[0].version_no;
            }

            this.filterCt14VersionOptions(this.periodYear);
            if(this.ct14VersionNoOptions.length > 0) {
                this.ct14VersionNo = this.ct14VersionNoOptions[0].ct14_version_no;
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

        onCt14VersionNoChanged(ct14VersionNo) {
            this.ct14VersionNo = ct14VersionNo;
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

        onAccountTypeChanged(accountType) {
            this.accountType = accountType;
            this.setUrlParams();
        },

        filterVersionOptions(periodYear) {
            if(periodYear){
                this.versionNoOptions = this.versionNos.filter(item => item.period_year == periodYear);
            } else {
                this.versionNoOptions = [];
            }
        },

        filterCt14VersionOptions(periodYear) {
            if(periodYear){
                this.ct14VersionNoOptions = this.ct14VersionNos.filter(item => item.period_year == periodYear);
            } else {
                this.ct14VersionNoOptions = [];
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

    }

};
</script>
