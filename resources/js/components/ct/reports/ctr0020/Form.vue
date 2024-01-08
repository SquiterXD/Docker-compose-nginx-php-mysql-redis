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
                    <qm-el-select name="plan_version_no" id="input_plan_version_no" placeholder="ครั้งที่กระดาษทำการ "
                        option-key="plan_version_no" option-value="plan_version_no" option-label="plan_version_no"
                        @onSelected="onPlanVersionNoChanged($event)"
                        :select-options="planVersionNoOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="planVersionNo"  />
                </div>

            </div>

            <div class="row form-group">

                <label class="col-md-4 required"> เปรียบเทียบค่าใช้จ่ายจริงจาก </label>
                <div class="col-md-8">
                    <qm-el-select name="period_name_from" id="input_period_name_from" placeholder="เปรียบเทียบค่าใช้จ่ายจริงจาก "
                        option-key="period_name_value" option-value="period_name_value" option-label="period_name_label"
                        @onSelected="onPeriodNameFromChanged($event)"
                        :select-options="periodNameFromOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="periodNameFrom"  />
                </div>
                
            </div>

            <div class="row form-group">

                <label class="col-md-4 required"> เปรียบเทียบค่าใช้จ่ายจริงถึง </label>
                <div class="col-md-8">
                    <qm-el-select name="period_name_to" id="input_period_name_to" placeholder="เปรียบเทียบค่าใช้จ่ายจริงถึง "
                        option-key="period_name_value" option-value="period_name_value" option-label="period_name_label"
                        @onSelected="onPeriodNameToChanged($event)"
                        :select-options="periodNameToOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="periodNameTo"  />
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
                :disabled="!periodYear || !versionNo || !planVersionNo || !periodNameFrom || !periodNameTo"
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
        "periodNameFroms",
        "periodNameFromValue",
        "periodNameTos",
        "periodNameToValue",
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
            planVersionNo: this.planVersionNoValue,
            periodNameFrom: this.periodNameFromValue,
            periodNameTo: this.periodNameToValue,
            accountType: this.accountTypeValue,
            versionNoOptions: [],
            planVersionNoOptions: [],
            periodNameFromOptions: [],
            periodNameToOptions: [],
            accountTypeOptions: this.accountTypes,
        };
    },

    mounted() {

        if(this.periodYearValue) {

            this.filterVersionOptions(this.periodYearValue);
            this.filterPlanVersionNoOptions(this.periodYearValue);
            this.filterPeriodNameFromOptions(this.periodYearValue);
            this.filterPeriodNameToOptions(this.periodYearValue);
            // this.filterAccountTypeOptions(this.periodYearValue);

        }

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("period_year", this.periodYear ? this.periodYear : '');
            queryParams.set("version_no", this.versionNo ? this.versionNo : '');
            queryParams.set("plan_version_no", this.planVersionNo ? this.planVersionNo : '');
            queryParams.set("period_name_from", this.periodNameFrom ? this.periodNameFrom : '');
            queryParams.set("period_name_to", this.periodNameTo ? this.periodNameTo : '');
            queryParams.set("account_type", this.accountType ? this.accountType : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        onPeriodYearChanged(periodYear){

            this.periodYear = periodYear;

            this.filterVersionOptions(this.periodYear);
            if(this.versionNoOptions.length > 0) {
                this.versionNo = this.versionNoOptions[0].version_no;
            }

            this.filterPlanVersionNoOptions(this.periodYear);
            if(this.planVersionNoOptions.length > 0) {
                this.planVersionNo = this.planVersionNoOptions[0].plan_version_no;
            }

            this.filterPeriodNameFromOptions(this.periodYear);
            if(this.periodNameFromOptions.length > 0) {
                this.periodNameFrom = this.periodNameFromOptions[0].period_name_value;
            }

            this.filterPeriodNameToOptions(this.periodYear);
            if(this.periodNameToOptions.length > 0) {
                this.periodNameTo = this.periodNameToOptions[(this.periodNameToOptions.length-1)].period_name_value;
            }

            // this.filterAccountTypeOptions(this.periodYear);
            // if(this.accountTypeOptions.length > 0) {
            //     this.accountType = this.accountTypeOptions[(this.accountTypeOptions.length-1)].account_type;
            // }

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

        onPeriodNameFromChanged(periodNameFrom) {
            this.periodNameFrom = periodNameFrom;
            this.setUrlParams();
        },

        onPeriodNameToChanged(periodNameTo) {
            this.periodNameTo = periodNameTo;
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

        filterPlanVersionNoOptions(periodYear) {
            if(periodYear){
                this.planVersionNoOptions = this.planVersionNos.filter(item => item.period_year == periodYear);
            } else {
                this.planVersionNoOptions = [];
            }
        },

        filterPeriodNameFromOptions(periodYear) {
            if(periodYear){
                this.periodNameFromOptions = this.periodNameFroms.filter(item => item.period_year == periodYear);
            } else {
                this.periodNameFromOptions = [];
            }
        },

        filterPeriodNameToOptions(periodYear) {
            if(periodYear){
                this.periodNameToOptions = this.periodNameTos.filter(item => item.period_year == periodYear);
            } else {
                this.periodNameToOptions = [];
            }
        },

        // filterAccountTypeOptions(periodYear) {
        //     if(periodYear){
        //         this.accountTypeOptions = this.accountTypes.filter(item => item.period_year == periodYear);
        //     } else {
        //         this.accountTypeOptions = [];
        //     }
        // },

    }

};
</script>
