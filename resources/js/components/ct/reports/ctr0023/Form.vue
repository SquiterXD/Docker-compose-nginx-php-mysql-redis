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
                    <qm-el-select name="version_no" id="input_version_no" placeholder="ครั้งที่ "
                        option-key="version_no" option-value="version_no" option-label="version_no"
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
                    <qm-el-select name="cost_code" id="input_cost_code" placeholder="ศูนย์ต้นทุน "
                        option-key="cost_code_value" option-value="cost_code_value" option-label="cost_code_label"
                        @onSelected="onCostCodeChanged($event)"
                        :select-options="costCodeOptions"
                        :clearable="false"
                        :filterable="true"
                        :value="costCode"  />
                </div>

            </div>

            <div class="row form-group">

                <label class="col-md-4 required"> ผลิตภัณฑ์ </label>
                <div class="col-md-8">
                    <qm-el-select name="product_item_number_from" id="input_product_item_number_from" placeholder="ผลิตภัณฑ์ "
                        option-key="product_item_value" option-value="product_item_value" option-label="product_item_label"
                        @onSelected="onProductItemFromChanged($event)"
                        :select-options="productItemFromOptions"
                        :clearable="false"
                        :filterable="true"
                        :value="productItemNumberFrom"  />
                </div>

            </div>

            <div class="row form-group">

                <label class="col-md-4 required"> ถึงผลิตภัณฑ์ </label>
                <div class="col-md-8">
                    <qm-el-select name="product_item_number_to" id="input_product_item_number_to" placeholder="ถึงผลิตภัณฑ์ "
                        option-key="product_item_value" option-value="product_item_value" option-label="product_item_label"
                        @onSelected="onProductItemToChanged($event)"
                        :select-options="productItemToOptions"
                        :clearable="false"
                        :filterable="true"
                        :value="productItemNumberTo"  />
                </div>

            </div>

            <div class="row form-group">

                <label class="col-md-4"> ไม่รวมรายการวัตถุดิบที่มีปริมาณเป็นศูนย์ </label>
                <div class="col-md-8">
                    <el-checkbox name="input_hide_zero_value" id="input_hide_zero_value" @change="onHideZeroValueChanged($event)"></el-checkbox>
                    <input type="hidden" name="hide_zero_value" v-model="hideZeroValue">
                </div>

            </div>

            <div class="row form-group">
                <label class="col-md-4"> สถานะผลิตภัณฑ์ใหม่ระหว่างปี </label>
                <div class="col-md-8">
                    <el-checkbox name="input_status_product" id="input_status_product" @change="onHideStatusChang($event)"></el-checkbox>
                    <input type="hidden" name="hide_status_product" v-model="hideStatusProValue">
                </div>
            </div>

        </div>

        <div class="offset-md-2 col-md-8 text-right tw-mt-2 tw-mb-4">

            <button type="submit" class="btn btn-sm btn-primary"
                :disabled="!periodYear || !versionNo || !planVersionNo || !productItemNumberFrom"
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
        "costCodeValue",
        "productItems",
        "productItemNumberFromValue",
        "productItemNumberToValue",
    ],

    components: {
        Loading
    },

    data() {
        return {
            periodYear: this.periodYearValue,
            versionNo: this.versionNoValue,
            planVersionNo: this.planVersionNoValue,
            costCode: this.costCodeValue,
            productItemNumberFrom: this.productItemNumberFromValue,
            productItemNumberTo: this.productItemNumberToValue,
            hideZeroValue: false,
            hideStatusProValue: false,
            versionNoOptions: [],
            planVersionNoOptions: [],
            costCodeOptions: [],
            productItemFromOptions: [],
            productItemToOptions: [],
        };
    },

    mounted() {

        if(this.periodYearValue) {

            this.filterVersionOptions(this.periodYearValue);
            this.filterPlanVersionNoOptions(this.periodYearValue);
            this.filterCostCodeOptions(this.periodYearValue);

            if(this.costCodeValue) {
                this.filterProductItemFromOptions(this.periodYearValue, this.costCodeValue);
                if(this.productItemNumberFromValue) {
                    this.filterProductItemToOptions(this.periodYearValue, this.costCodeValue, this.productItemNumberFromValue);
                } else {
                    this.filterProductItemToOptions(this.periodYearValue, this.costCodeValue, null);
                }
            }

        }

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("period_year", this.periodYear ? this.periodYear : '');
            queryParams.set("version_no", this.versionNo ? this.versionNo : '');
            queryParams.set("plan_version_no", this.planVersionNo ? this.planVersionNo : '');
            queryParams.set("cost_code", this.costCode ? this.costCode : '');
            queryParams.set("product_item_number_from", this.productItemNumberFrom ? this.productItemNumberFrom : '');
            queryParams.set("product_item_number_to", this.productItemNumberTo ? this.productItemNumberTo : '');
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

            this.filterCostCodeOptions(this.periodYear);
            if(this.costCodeOptions.length > 0) {
                this.costCode = this.costCodeOptions[0].cost_code_value;
            }

            this.filterProductItemFromOptions(this.periodYear, this.costCode);
            if(this.productItemFromOptions.length > 0) {
                this.productItemNumberFrom = this.productItemFromOptions[0].product_item_value;
                this.filterProductItemToOptions(this.periodYear, this.costCode, this.productItemNumberFrom);
            } else {
                this.filterProductItemToOptions(this.periodYear, this.costCode, null);
            }

            if(this.productItemToOptions.length > 0) {
                this.productItemNumberTo = this.productItemToOptions[(this.productItemToOptions.length-1)].product_item_value;
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

        onCostCodeChanged(costCode) {

            this.costCode = costCode;

            this.filterProductItemFromOptions(this.periodYear, this.costCode);
            if(this.productItemFromOptions.length > 0) {
                this.productItemNumberFrom = this.productItemFromOptions[0].product_item_value;
                this.filterProductItemToOptions(this.periodYear, this.costCode, this.productItemNumberFrom);
            } else {
                this.filterProductItemToOptions(this.periodYear, this.costCode, null);
            }
            if(this.productItemToOptions.length > 0) {
                this.productItemNumberTo = this.productItemToOptions[(this.productItemToOptions.length-1)].product_item_value;
            }

            this.setUrlParams();

        },

        onProductItemFromChanged(productItemNumber) {
            this.productItemNumberFrom = productItemNumber;
            this.filterProductItemToOptions(this.periodYear, this.costCode, this.productItemNumberFrom);
            if(this.productItemToOptions.length > 0) {
                this.productItemNumberTo = this.productItemToOptions[(this.productItemToOptions.length-1)].product_item_value;
            }
            this.setUrlParams();
        },

        onProductItemToChanged(productItemNumber) {
            this.productItemNumberTo = productItemNumber;
            this.setUrlParams();
        },

        onHideZeroValueChanged(value) {
            this.hideZeroValue = value;
        },

        onHideStatusChang(value) {
            this.hideStatusProValue = value;

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

        filterCostCodeOptions(periodYear) {
            if(periodYear){
                this.costCodeOptions = this.costCodes.filter(item => item.period_year == periodYear);
            } else {
                this.costCodeOptions = [];
            }
        },

        filterProductItemFromOptions(periodYear, costCode) {
            if(periodYear && costCode) {
                this.productItemFromOptions = this.productItems.filter(item => (item.period_year == periodYear && item.cost_code == costCode));
            } else {
                this.productItemFromOptions = [];
            }
        },

        filterProductItemToOptions(periodYear, costCode, fromProductItemNumber) {
            if(periodYear && costCode) {
                if(fromProductItemNumber) {
                    this.productItemToOptions = this.productItems.filter(item => ((item.period_year == periodYear && item.cost_code == costCode) && (item.product_item_number >= fromProductItemNumber)));
                } else {
                    this.productItemToOptions = this.productItems.filter(item => (item.period_year == periodYear && item.cost_code == costCode));
                }
            } else {
                this.productItemToOptions = [];
            }
        },

    }

};
</script>
