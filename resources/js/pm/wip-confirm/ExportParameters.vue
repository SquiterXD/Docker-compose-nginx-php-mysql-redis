<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h3 v-if="reportCode == 'PDR1150'">รายงานผลผลิตประจำวันแยกตามคำสั่งการผลิต</h3>
                        <h3 v-if="reportCode == 'PDR1180'">รายงานผลผลิตประจำวันแยกตามวันที่ผลิต</h3>
                        <h3 v-if="reportCode == 'PDR2040'">รายงานผลผลิตประจำวันยอดรวม</h3>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 font-weight-bold col-form-label pt-2 text-right">วันที่ได้ผลผลิต:</label>
                                    <div class="col-lg-3">
                                        <input type="hidden" name="date_from" v-model="search.from_date">
                                        <ct-datepicker
                                            class="form-control my-1"
                                            style="width: 250px;"
                                            placeholder="โปรดเลือกวันที่"
                                            :enableDate="date => isInRange(date, null, toJSDate(search.to_date), true)"
                                            :value="toJSDate(search.from_date, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                                search.from_date = jsDateToString(date)
                                                search = {...search}
                                            }"
                                        />
                                    </div>
                                    <label class="col-lg-1 font-weight-bold col-form-label pt-2 text-right">ถึง:</label>
                                    <div class="col-lg-3">
                                        <input type="hidden" name="date_to" v-model="search.to_date">
                                        <ct-datepicker
                                            class="form-control my-1"
                                            style="width: 250px;"
                                            placeholder="โปรดเลือกวันที่"
                                            :enableDate="date => isInRange(date, toJSDate(search.from_date), null, true)"
                                            :value="toJSDate(search.to_date, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                                search.to_date = jsDateToString(date)
                                                search = {...search}
                                            }"
                                        />
                                    </div>
                                </div>
                                <div class="form-group row" v-if="reportCode == 'PDR1150'">
                                    <label class="col-lg-3 font-weight-bold col-form-label pt-2 text-right">เลขที่คำสั่งผลิต:</label>
                                    <div class="col-lg-3">
                                        <input type="hidden" name="batch_no_from" v-model="selectedBatchNoFrom">
                                        <input type="hidden" name="batch_no_from2" v-model="selectedBatchNoFrom2">
                                        <el-select
                                            style="width: 100%"
                                            placeholder="โปรดเลือก"
                                            filterable
                                            clearable
                                            v-model="selectedBatchNoFrom">
                                            <el-option v-if="isHasBatchNoFrom" value="ALL">ALL</el-option>
                                            <el-option
                                                v-for="(batchNo, index) in batchNumbers"
                                                :key="index"
                                                :label="index"
                                                :value="index">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <label class="col-lg-1 font-weight-bold col-form-label pt-2 text-right">ถึง:</label>
                                    <div class="col-lg-3">
                                        <input type="hidden" name="batch_no_to" v-model="selectedBatchNoTo">
                                        <input type="hidden" name="batch_no_to2" v-model="selectedBatchNoTo2">
                                        <el-select
                                            style="width: 100%"
                                            placeholder="โปรดเลือก"
                                            filterable
                                            clearable
                                            v-model="selectedBatchNoTo">
                                            <el-option v-if="isHasBatchNoTo" value="ALL">ALL</el-option>
                                            <el-option
                                                v-for="(batchNo, index) in batchNumbers"
                                                :key="index"
                                                :label="index"
                                                :value="index">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 font-weight-bold col-form-label pt-2 text-right">ขั้นตอนการทำงาน:</label>
                                    <div class="col-lg-3">
                                        <input type="hidden" name="wip_step_from" v-model="selectedWipStepFrom">
                                        <input type="hidden" name="wip_step_from2" v-model="selectedWipStepFrom2">
                                        <el-select
                                            style="width: 100%"
                                            placeholder="โปรดเลือก"
                                            filterable
                                            clearable
                                            v-model="selectedWipStepFrom">
                                            <el-option v-if="isHasWipStepFrom" value="ALL">ALL</el-option>
                                            <el-option
                                                v-for="(wipStep, index) in wipSteps"
                                                :key="index"
                                                :label="index"
                                                :value="index">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <label class="col-lg-1 font-weight-bold col-form-label pt-2 text-right">ถึง:</label>
                                    <div class="col-lg-3">
                                        <input type="hidden" name="wip_step_to" v-model="selectedWipStepTo">
                                        <input type="hidden" name="wip_step_to2" v-model="selectedWipStepTo2">
                                        <el-select
                                            style="width: 100%"
                                            placeholder="โปรดเลือก"
                                            filterable
                                            clearable
                                            v-model="selectedWipStepTo">
                                            <el-option v-if="isHasWipStepTo" value="ALL">ALL</el-option>
                                            <el-option
                                                v-for="(wipStep, index) in wipSteps"
                                                :key="index"
                                                :label="index"
                                                :value="index">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 font-weight-bold col-form-label pt-2 text-right">รหัสสินค้าสำเร็จรูป:</label>
                                    <div class="col-lg-3">
                                        <input type="hidden" name="item_number" v-model="selectedItemNumber">
                                        <el-select
                                            style="width: 100%"
                                            placeholder="โปรดเลือก"
                                            filterable
                                            clearable
                                            v-model="selectedItemNumber">
                                            <el-option v-if="isHasItemNumer" value="ALL">ALL</el-option>
                                            <el-option
                                                v-for="(data, index) in itemNumbers"
                                                :key="data[0].item_number"
                                                :label="data[0].item_number+' - '+data[0].item_desc"
                                                :value="data[0].item_number">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row" v-if="reportCode == 'PDR1150' && (pProfile.organization_code =='M02' || pProfile.organization_code =='M03')">
                                    <label class="col-lg-3 font-weight-bold col-form-label pt-2 text-right">ประเภทรายงาน:</label>
                                    <div class="col-lg-3">
                                        <input type="hidden" name="report_type" v-model="selectedReportType">
                                        <el-select
                                            style="width: 100%"
                                            placeholder="โปรดเลือก"
                                            filterable
                                            clearable
                                            v-model="selectedReportType">
                                            <el-option value="group_by_opt" label="แยกตาม OPT"></el-option>
                                            <el-option value="group_by_WIP" label="แยกตาม WIP"></el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12 text-center">
                                        <button 
                                            type="submit" 
                                            onclick="$('form').attr('target', '_blank');"
                                            class="btn btn-primary btn-outline">
                                            Export
                                        </button>
                                        <button 
                                            type="button" 
                                            @click.prevent="onClearButtonClicked()" 
                                            class="btn btn-danger btn-outline">
                                            Clear
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils';

export default {
    props:[
        "pFromDate", "pToDate", 
        "pBatchNoLists", 
        // "pWipStepLists", 
        // "pItemNumberLists", 
        "transDate", "transBtn", "url",
        "pReportCode",
        "pProfile"
    ],
    created() {
        Vue.nextTick(() => {
            this.setDefaultValue();
        });
    },
    mounted() {
    },
    data() {
        return {
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,
            search: {
                from_date: null,
                to_date: null,
            },
            selectedBatchNoFrom2: null,
            selectedBatchNoTo2: null,
            selectedWipStepFrom2: null,
            selectedWipStepTo2: null,
            selectedBatchNoFrom: this.selectedBatchNoFrom ?? '',
            selectedBatchNoTo: this.selectedBatchNoTo ?? '',
            selectedWipStepFrom: this.selectedWipStepFrom ?? '',
            selectedWipStepTo: this.selectedWipStepTo ?? '',
            selectedItemNumber: this.selectedItemNumber ?? '',
            batchNoLists: this.pBatchNoLists,
            selectedReportType: this.selectedReportType ?? 'group_by_opt',
            reportCode: this.pReportCode,
            batchNumbers: {},
            wipSteps: {},
            itemNumbers: {},
            isHasBatchNoFrom: false,
            isHasBatchNoTo: false,
            isHasWipStepFrom: false,
            isHasWipStepTo: false,
            isHasItemNumer: false,
        }
    },
    methods: {
        setDefaultValue() {
            this.search.from_date = this.pFromDate;
            this.search.to_date = this.pToDate;
            if (this.search.from_date || this.search.to_date) {
                this.onSearchDateChanged();
            }
        },
        onSearchDateChanged() {
            this.filterBatchNo(this.search.from_date,this.search.to_date);
        },
        filterBatchNo(searchFromDate,searchToDate) {
            this.batchNumbers = this.batchNoLists.filter(batchNoList => {
                return searchFromDate <= batchNoList.transaction_date && batchNoList.transaction_date <= searchToDate;
            });
            this.batchNumbers = _.groupBy(this.batchNumbers, 'batch_no');
            if (Object.keys(this.batchNumbers).length > 0) {
                // this.selectedBatchNoFrom = Object.keys(this.batchNumbers)[0];
                // this.selectedBatchNoTo = Object.keys(this.batchNumbers)[Object.keys(this.batchNumbers).length-1];
                // this.filterWipStep(this.search.from_date,this.search.to_date,this.selectedBatchNoFrom,this.selectedBatchNoTo);
                this.isHasBatchNoFrom = true;
                this.isHasBatchNoTo = true;
                this.selectedBatchNoFrom = 'ALL';
                this.selectedBatchNoTo = 'ALL';
                this.selectedBatchNoFrom2 = Object.keys(this.batchNumbers)[0];
                this.selectedBatchNoTo2 = Object.keys(this.batchNumbers)[Object.keys(this.batchNumbers).length-1];
                this.filterWipStep(this.search.from_date,this.search.to_date,this.selectedBatchNoFrom2,this.selectedBatchNoTo2);
            } else {
                this.isHasBatchNoFrom = false;
                this.isHasBatchNoTo = false;
                this.selectedBatchNoFrom = '';
                this.selectedBatchNoTo = '';
                this.selectedBatchNoFrom2 = '';
                this.selectedBatchNoTo2 = '';
                this.batchNumbers = {};
            }
        },
        filterWipStep(searchFromDate,searchToDate,batchNoFrom,batchNoTo) {
            this.wipSteps = this.batchNoLists.filter(batchNoList => {
                return searchFromDate <= batchNoList.transaction_date && 
                    batchNoList.transaction_date <= searchToDate &&
                    batchNoFrom <= batchNoList.batch_no &&
                    batchNoList.batch_no <= batchNoTo;
            });
            this.wipSteps = _.orderBy(this.wipSteps, 'wip_step');
            this.wipSteps = _.groupBy(this.wipSteps, 'wip_step');
            if (Object.keys(this.wipSteps).length > 0) {
                // this.selectedWipStepFrom = Object.keys(this.wipSteps)[0];
                // this.selectedWipStepTo = Object.keys(this.wipSteps)[Object.keys(this.wipSteps).length-1];
                // this.filterItemNumber(this.search.from_date,this.search.to_date,this.selectedBatchNoFrom,this.selectedBatchNoTo,this.selectedWipStepFrom,this.selectedWipStepTo);
                this.isHasWipStepFrom = true;
                this.isHasWipStepTo = true;
                this.selectedWipStepFrom = 'ALL';
                this.selectedWipStepTo = 'ALL';
                this.selectedWipStepFrom2 = Object.keys(this.wipSteps)[0];
                this.selectedWipStepTo2 = Object.keys(this.wipSteps)[Object.keys(this.wipSteps).length-1];
                this.filterItemNumber(this.search.from_date,this.search.to_date,this.selectedBatchNoFrom2,this.selectedBatchNoTo2,this.selectedWipStepFrom2,this.selectedWipStepTo2);
            } else {
                this.isHasWipStepFrom = false;
                this.isHasWipStepTo = false;
                this.selectedWipStepFrom = '';
                this.selectedWipStepTo = '';
                this.selectedWipStepFrom2 = '';
                this.selectedWipStepTo2 = '';
                this.wipSteps = {};
            }
        },
        filterItemNumber(searchFromDate,searchToDate,batchNoFrom,batchNoTo,wipStepFrom,wipStepTo) {
            this.itemNumbers = this.batchNoLists.filter(batchNoList => {
                return searchFromDate <= batchNoList.transaction_date && 
                    batchNoList.transaction_date <= searchToDate &&
                    batchNoFrom <= batchNoList.batch_no &&
                    batchNoList.batch_no <= batchNoTo &&
                    wipStepFrom <= batchNoList.wip_step &&
                    batchNoList.wip_step <= wipStepTo;
            });
            this.itemNumbers = _.orderBy(this.itemNumbers, 'item_number');
            this.itemNumbers = _.groupBy(this.itemNumbers, 'item_number');
            if (Object.keys(this.itemNumbers).length > 0) {
                this.isHasItemNumer = true;
                this.selectedItemNumber = 'ALL';
            } else {
                this.isHasItemNumer = false;
                this.selectedItemNumber = '';
                this.itemNumbers = {};
            }
        },
        onClearButtonClicked() {
            window.location = this.url.wip_export_pdf_parameters;
        },
    },
    watch:{
        search: function (val) {
            this.onSearchDateChanged();
        },
    },
}

</script>
