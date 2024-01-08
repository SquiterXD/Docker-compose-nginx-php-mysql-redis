<template>

    <div class="row">

        <div class="offset-md-2 col-md-8">

            <div class="row form-group">
                <label class="col-md-4 required"> ปีบัญชีงบประมาณ </label>
                <div class="col-md-8">
                    <qm-el-select name="period_year" id="input_period_year" placeholder="ปีบัญชีงบประมาณ "
                        option-key="period_year_value" option-value="period_year_value" option-label="period_year_label"
                        @onSelected="onPeriodYearChanged($event)"
                        :select-options="periodYears" 
                        :clearable="false" 
                        :filterable="true"
                        :value="periodYear"  />
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

                <label class="col-md-4 required"> วันที่ผลิตตั้งแต่ </label>
                <div class="col-md-8">
                    <qm-datepicker-th
                        class="form-control md:tw-mb-0 tw-mb-2"
                        style="width: 100%;"
                        name="date_from" id="input_date_from" placeholder="วันที่ผลิตตั้งแต่ "
                        :value="dateFrom"
                        @dateWasSelected="dateFromWasSelected"
                    />
                </div>
                
            </div>

            <div class="row form-group">

                <label class="col-md-4 required"> วันที่ผลิตถึง </label>
                <div class="col-md-8">
                    <qm-datepicker-th
                        class="form-control md:tw-mb-0 tw-mb-2"
                        style="width: 100%;"
                        name="date_to" id="input_date_to" placeholder="วันที่ผลิตถึง "
                        :value="dateTo"
                        @dateWasSelected="dateToWasSelected"
                        :disabled-date-to="disabledDateTo"
                    />
                </div>
                
            </div>

            <div class="row form-group">

                <label class="col-md-4"> เลขที่คำสั่งผลิตตั้งแต่ </label>
                <div class="col-md-8">
                    <qm-el-select name="batch_no_from" id="input_batch_no_from" placeholder="เลขที่คำสั่งผลิตตั้งแต่ "
                        option-key="batch_no_value" option-value="batch_no_value" option-label="batch_no_label"
                        @onSelected="onBatchNoFromChanged($event)"
                        :select-options="batchNoFromOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="batchNoFrom"  />
                </div>
                
            </div>

            <div class="row form-group">

                <label class="col-md-4"> เลขที่คำสั่งผลิตถึง </label>
                <div class="col-md-8">
                    <qm-el-select name="batch_no_to" id="input_batch_no_to" placeholder="เลขที่คำสั่งผลิตถึง "
                        option-key="batch_no_value" option-value="batch_no_value" option-label="batch_no_label"
                        @onSelected="onBatchNoToChanged($event)"
                        :select-options="batchNoToOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="batchNoTo"  />
                </div>
                
            </div>

            <div class="row form-group">

                <label class="col-md-4"> เลขที่ผลิตภัณฑ์ตั้งแต่ </label>
                <div class="col-md-8">
                    <qm-el-select name="item_no_from" id="input_item_no_from" placeholder="เลขที่ผลิตภัณฑ์ตั้งแต่ "
                        option-key="item_value" option-value="item_value" option-label="item_label"
                        @onSelected="onItemNoFromChanged($event)"
                        :select-options="itemNoFromOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="itemNoFrom"  />
                </div>
                
            </div>

            <div class="row form-group">

                <label class="col-md-4"> เลขที่ผลิตภัณฑ์ถึง </label>
                <div class="col-md-8">
                    <qm-el-select name="item_no_to" id="input_item_no_to" placeholder="เลขที่ผลิตภัณฑ์ถึง "
                        option-key="item_value" option-value="item_value" option-label="item_label"
                        @onSelected="onItemNoToChanged($event)"
                        :select-options="itemNoToOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="itemNoTo"  />
                </div>
                
            </div>

            <div class="row form-group">

                <label class="col-md-4 required"> ประเภทรายงาน </label>
                <div class="col-md-8">
                    <qm-el-select name="report_type" id="input_report_type" placeholder="ประเภทรายงาน "
                        option-key="value" option-value="value" option-label="label"
                        @onSelected="onReportTypeChanged($event)"
                        :select-options="reportTypeOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="reportType"  />
                </div>
                
            </div>

        </div>

        <div class="offset-md-2 col-md-8 text-right tw-mt-2 tw-mb-4">

            <button type="submit" class="btn btn-sm btn-primary"
                :disabled="!periodYear || !costCode || !dateFrom || !dateTo"
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
        "costCodes",
        "costCodeValue",
        "dateFromValue",
        "dateToValue",
        "batchNos",
        "batchNoFromValue",
        "batchNoToValue",
        "invItems",
        "itemNoFromValue",
        "itemNoToValue",
        "reportTypeValue",
    ],

    components: {
        Loading
    },

    data() {
        return {
            periodYear: this.periodYearValue,
            costCode: this.costCodeValue,
            costCodeOptions: this.costCodes,
            dateFrom: this.dateFromValue,
            dateTo: this.dateToValue,
            disabledDateTo: this.dateFromValue ? this.dateFromValue : null,
            batchNoFrom: this.batchNoFromValue,
            batchNoTo: this.batchNoToValue,
            batchNoFromOptions: [],
            batchNoToOptions: [],
            itemNoFrom: this.itemNoFromValue,
            itemNoTo: this.itemNoToValue,
            itemNoFromOptions: [],
            itemNoToOptions: [],
            reportType: this.reportTypeValue ? this.reportTypeValue : "ITEM",
            reportTypeOptions: [{ value: "ITEM", label: "แยกตามผลิตภัณฑ์" }, { value: "BATCH", label: "แยกตามคำสั่งผลิต" }]
        };
    },

    mounted() {

        if(this.costCodeValue) {

            this.filterBatchNoFromOptions(this.costCodeValue);
            if(this.batchNoFromValue) {
                this.filterBatchNoToOptions(this.costCodeValue, this.batchNoFromValue);
            } else {
                this.filterBatchNoToOptions(this.costCodeValue, null);
            }

            this.filterItemNoFromOptions(this.costCodeValue);
            if(this.itemNoFromValue) {
                this.filterItemNoToOptions(this.costCodeValue, this.itemNoFromValue);
            } else {
                this.filterItemNoToOptions(this.costCodeValue, null);
            }

        }

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("period_year", this.periodYear ? this.periodYear : '');
            queryParams.set("cost_code", this.costCode ? this.costCode : '');
            queryParams.set("date_from", this.dateFrom ? this.dateFrom : '');
            queryParams.set("date_to", this.dateTo ? this.dateTo : '');
            queryParams.set("batch_no_from", this.batchNoFrom ? this.batchNoFrom : '');
            queryParams.set("batch_no_to", this.batchNoTo ? this.batchNoTo : '');
            queryParams.set("item_no_from", this.itemNoFrom ? this.itemNoFrom : '');
            queryParams.set("item_no_to", this.itemNoTo ? this.itemNoTo : '');
            queryParams.set("report_type", this.reportType ? this.reportType : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        onPeriodYearChanged(periodYear){

            this.periodYear = periodYear;

            this.setUrlParams();

        },

        onCostCodeChanged(costCode){

            this.costCode = costCode;
            
            this.filterBatchNoFromOptions(this.costCode);
            if(this.batchNoFromOptions.length > 0) {
                this.batchNoFrom = this.batchNoFromOptions[0].batch_no_value;
                this.filterBatchNoToOptions(this.costCode, this.batchNoFrom);
            } else {
                this.filterBatchNoToOptions(this.costCode, null);
            }
            if(this.batchNoToOptions.length > 0) {
                // this.batchNoTo = this.batchNoToOptions[this.batchNoToOptions.length - 1].batch_no_value;
                this.batchNoTo = this.batchNoToOptions[0].batch_no_value;
            }

            this.filterItemNoFromOptions(this.costCode);
            if(this.itemNoFromOptions.length > 0) {
                this.itemNoFrom = this.itemNoFromOptions[0].item_value;
                this.filterItemNoToOptions(this.costCode, this.itemNoFrom);
            } else {
                this.filterItemNoToOptions(this.costCode, null);
            }
            if(this.itemNoToOptions.length > 0) {
                // this.itemNoTo = this.itemNoToOptions[this.itemNoToOptions.length - 1].item_value;
                this.itemNoTo = this.itemNoToOptions[0].item_value;
            }

            this.setUrlParams();

        },

        dateFromWasSelected(date) {
            // change disabled_date_to of to_date = date
            this.dateFrom = moment(date).format("DD/MM/YYYY");
            this.disabledDateTo = moment(date).format("DD/MM/YYYY");
            this.setUrlParams();
        },

        dateToWasSelected(date) {
            this.dateTo = moment(date).format("DD/MM/YYYY");
            this.setUrlParams();
        },

        onBatchNoFromChanged(batchNo) {
            this.batchNoFrom = batchNo;
            this.filterBatchNoToOptions(this.costCode, this.batchNoFrom);
            if(this.batchNoToOptions.length > 0) {
                // this.batchNoTo = this.batchNoToOptions[this.batchNoToOptions.length - 1].batch_no_value;
                this.batchNoTo = this.batchNoToOptions[0].batch_no_value;
            }
            this.setUrlParams();
        },

        onBatchNoToChanged(batchNo) {
            this.batchNoTo = batchNo;
            this.setUrlParams();
        },

        filterBatchNoFromOptions(costCode) {
            if(costCode){
                this.batchNoFromOptions = [
                    { batch_no_label: "", batch_no_value: "" },
                    ...this.batchNos.filter(item => item.cost_code == costCode)
                ]
            } else {
                this.batchNoFromOptions = [{ batch_no_label: "", batch_no_value: "" }];
            }
        },

        filterBatchNoToOptions(costCode, fromBatchNo) {
            if(costCode){
                if(fromBatchNo) {
                    this.batchNoToOptions = this.batchNos.filter(item => (item.cost_code == costCode && item.batch_no >= fromBatchNo));
                } else {
                    this.batchNoToOptions = this.batchNos.filter(item => item.cost_code == costCode);
                }
                this.batchNoToOptions = [
                    { batch_no_label: "", batch_no_value: "" },
                    ...this.batchNoToOptions
                ]
            } else {
                this.batchNoToOptions = [{ batch_no_label: "", batch_no_value: "" }];
            }
        },

        onItemNoFromChanged(itemNo) {
            this.itemNoFrom = itemNo;
            this.filterItemNoToOptions(this.costCode, this.itemNoFrom);
            if(this.itemNoToOptions.length > 0) {
                // this.itemNoTo = this.itemNoToOptions[this.itemNoToOptions.length - 1].item_value;
                this.itemNoTo = this.itemNoToOptions[0].item_value;
            }
            this.setUrlParams();
        },

        onItemNoToChanged(itemNo) {
            this.itemNoTo = itemNo;
            this.setUrlParams();
        },

        onReportTypeChanged(reportType) {
            this.reportType = reportType;
            this.setUrlParams();
        },

        filterItemNoFromOptions(costCode) {

            if(costCode){

                this.itemNoFromOptions = this.invItems.filter(item => item.cost_code == costCode).map(item => {
                    return {
                        item_value: item.item_value ? item.item_value.trim() : null,
                        item_label: item.item_label ? item.item_label.trim() : null,
                    };
                }).filter((value, index, self) => {
                    return (
                        index === self.findIndex(t => {
                            return t.item_value === value.item_value 
                                && t.item_label === value.item_label
                        })
                    );
                });

                this.itemNoFromOptions = [
                    { item_label: "", item_value: "" },
                    ...this.itemNoFromOptions
                ];

            } else {
                this.itemNoFromOptions = [{ item_label: "", item_value: "" }];
            }

        },

        filterItemNoToOptions(costCode, fromItemNo) {

            if(costCode){

                if(fromItemNo) {

                    this.itemNoToOptions = this.invItems.filter(item => (item.cost_code == costCode && item.batch_no >= fromItemNo)).map(item => {
                        return {
                            item_value: item.item_value ? item.item_value.trim() : null,
                            item_label: item.item_label ? item.item_label.trim() : null,
                        };
                    }).filter((value, index, self) => {
                        return (
                            index === self.findIndex(t => {
                                return t.item_value === value.item_value 
                                    && t.item_label === value.item_label
                            })
                        );
                    })

                } else {

                    this.itemNoToOptions = this.invItems.filter(item => item.cost_code == costCode).map(item => {
                        return {
                            item_value: item.item_value ? item.item_value.trim() : null,
                            item_label: item.item_label ? item.item_label.trim() : null,
                        };
                    }).filter((value, index, self) => {
                        return (
                            index === self.findIndex(t => {
                                return t.item_value === value.item_value 
                                    && t.item_label === value.item_label
                            })
                        );
                    })

                }

                this.itemNoToOptions = [
                    { item_label: "", item_value: "" },
                    ...this.itemNoToOptions
                ];

            } else {
                this.itemNoToOptions = [{ item_label: "", item_value: "" }];
            }

        },

    }

};
</script>
