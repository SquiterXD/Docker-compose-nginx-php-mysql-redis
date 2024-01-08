<template>
    <div>
        <!-- ค้นหา -->
        <div class="ibox">
            <div class="ibox-content">
                <el-form :model="search" ref="save_data" label-width="120px" class="demo-dynamic form_table_line">
                    <div class="row" v-loading="searchLoading">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 mt-2 text-right">ปีบัญชีงบประมาณ<span class="text-danger">*</span></div>
                                <div class="col-md-6">
                                    <el-form-item :prop="'period_year_th'" :rules="rules.period_year_th">
                                        <el-select
                                            style="width:100%;"
                                            v-model="search.period_year_th"
                                            placeholder="ปีบัญชีงบประมาณ"
                                            filterable
                                            clearable
                                            remote
                                            size="medium"
                                            @change="getPeriodName">
                                            <el-option
                                                v-for="(item, index) in periods"
                                                :key="index"
                                                :label="item.period_year_th"
                                                :value="item.period_year_th"
                                            >
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3 mt-2 text-right">งวดบัญชี<span class="text-danger">*</span></div>
                                <div class="col-md-6">
                                    <el-form-item :prop="'period_name'" :rules="rules.period_name">
                                        <el-select
                                            style="width:100%;"
                                            v-model="search.period_name"
                                            placeholder="งวดบัญชี"
                                            filterable
                                            clearable
                                            remote
                                            size="medium"
                                            :disabled="disablePeriodName">
                                            <el-option
                                                v-for="(item, index) in periodNameList"
                                                :key="index"
                                                :label="item.period_name"
                                                :value="item.period_name"
                                            >
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 mt-2 text-right">รหัสศูนย์ต้นทุน<span class="text-danger">*</span></div>
                                <div class="col-md-6">
                                    <el-form-item :prop="'cost_code'" :rules="rules.cost_code">
                                        <el-select
                                            style="width:100%;"
                                            v-model="search.cost_code"
                                            placeholder="ศูนย์รับผิดชอบ"
                                            filterable
                                            clearable
                                            remote
                                            size="medium">
                                            <el-option
                                                v-for="(item, index) in costs"
                                                :key="index"
                                                :label="item.cost_code + ' : ' + item.description"
                                                :value="item.cost_code"
                                            >
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12  text-right">
                                    <button type="button"  :class="trans_btn.search.class" @click="searchData">
                                        <i :class="trans_btn.search.icon"></i> ค้นหา
                                    </button>
                                    <button type="button"  :class="trans_btn.cancel.class" @click="clearSearch">
                                        ล้าง
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </el-form>
            </div>
        </div>

        <!-- Table -->
        <div class="ibox" v-loading="loading">
            <div class="ibox-content">
                <!-- Header -->
                <div class="table-responsive mt-3" style="max-height: 420px;">
                    <el-table 
                        :data="headerTableItems" 
                        :row-class-name="tableRowClassName" 
                        @row-click="getDataLine" 
                        highlight-current-row
                        height="400">

                        <el-table-column
                            prop="last_transaction_date_s"
                            label="วันที่บันทึกผลผลิตล่าสุด"
                            sortable
                            align="center"
                            width="250px"
                            :sort-method="sortTransactionDate">
                        </el-table-column>

                        <el-table-column
                            prop="last_transaction_date_issue_s"
                            label="วันที่ตัดวัตถุดิบล่าสุด"
                            sortable
                            align="center"
                            width="250px"
                            :sort-method="sortTransactionDateIssue">
                        </el-table-column>

                        <el-table-column
                            prop="batch_no"
                            label="เลขที่คำสั่งผลิต"
                            sortable
                            align="center"
                            width="200px">
                        </el-table-column>
                        <el-table-column
                            prop="item_name"
                            label="ชื่อสินค้า"
                            sortable>
                        </el-table-column>
                    </el-table>



                    <!-- <table class="table table-bordered table-hover mt-3" style="position: sticky;">
                        <thead>
                            <tr>
                                <th class="sticky-col text-center" width="180px;">วันที่บันทึกผลผลิตล่าสุด</th>
                                <th class="sticky-col text-center" width="180px;">วันที่ตัดวัตถุดิบล่าสุด</th>
                                <th class="sticky-col text-center" width="150px;">เลขที่คำสั่งผลิต</th>
                                <th class="sticky-col text-center">ชื่อสินค้า</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-show="headerTable.length > 0"
                                v-for="(header, index) in headerTable"
                                :key="index" class="mouse-over"
                                @click="getDataLine(header, index)"
                                :class="`${index === activeIndex ? 'highlight' : ''}`">
                                <td>{{ formatDate(header.last_transaction_date) }}</td>
                                <td>{{ formatDate(header.last_transaction_date_issue) }}</td>
                                <td>{{ header.batch_no }}</td>
                                <td>{{ header.item_number + ' ' + header.item_desc }}</td>
                            </tr>
                        </tbody>
                    </table> -->
                </div>

                <!-- Line -->
                <div class="table-responsive mt-3" style="max-height: 420px;" v-if="lineTable.length > 0">
                    <table class="table table-hover mt-3" style="position: sticky;">
                        <thead>
                            <tr>
                                <th class="sticky-col text-center">วันที่บันทึกผลผลิต</th>
                                <th class="sticky-col text-center">เลขที่คำสั่งผลิต</th>
                                <th class="sticky-col text-center">ชื่อสินค้า</th>
                                <th class="sticky-col text-center">จำนวน</th>
                                <th class="sticky-col text-center">หน่วยนับ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(line, index) in lineTable" class="mouse-over">
                                <td class="text-center">{{ formatDate(line.transaction_date) }}</td>
                                <td class="text-center">{{ line.batch_no }}</td>
                                <td class="text-right">{{ line.item_number + ' ' + line.item_desc }}</td>
                                <td class="text-right">{{ formatCurrency(line.confirm_qty) }}</td>
                                <td class="text-center">{{ line.plan_uom }}</td>
                            </tr>
                        </tbody>
                        <!-- <tfoot>
                            <tr>
                                <th class="text-right" colspan="4">รวม</th>
                                <th class="text-right">{{ formatCurrency(total) }}</th>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import * as scripts from '../helper/scripts'
import moment from 'moment'

export default {
    props: ['trans_btn', 'periods', 'costs'],
    data() {
        return {
            func: scripts.funcs,
            formatCurrency: scripts.funcs.formatCurrency,
            vars: scripts.vars,

            loading:       false,
            searchLoading: false,
            headerLoading: false,
            lineLoading:   false,

            disablePeriodName:   true,

            search:{
                period_year_th: '',
                cost_code:      '',
                period_name:    ''
            },
            periodNameList:  [],
            headerTable:     [],
            lineTable:       [],

            rules: {
                period_year_th: [
                    { required: true, message: 'กรุณาเลือก ปีบัญชีงบประมาณ', trigger: "change"}
                ],
                period_name: [
                    { required: true, message: 'กรุณาเลือก งวดบัญชี', trigger: "change"}
                ],
                cost_code: [
                    { required: true, message: 'กรุณาเลือก รหัสศูนย์ต้นทุน', trigger: "change"}
                ],
            },

            activeIndex: '',
            headerTableItems: [],
        }
    },
    methods:{
        tableRowClassName(row, rowIndex){
            return row.index = rowIndex;
            // console.log('tableRowClassName row <--> ', row);
            // console.log('tableRowClassName rowIndex <--> ', rowIndex);
        },
        searchData(){
            console.log('search');
            let vm = this;

            this.$refs.save_data.validate((valid) => {
                if (valid) {
                    vm.loading = true;
                    axios.get("/ct/ajax/inquire_production/", {
                        params: {
                            period_year_th:   vm.search.period_year_th,
                            period_name:      vm.search.period_name,
                            cost_code:        vm.search.cost_code,
                        }
                    }).then(res => {

                        this.headerTable = res.data;
                        // console.log('x <--> ', res.data);
                        if (res.data) {
                            this.headerTableItems = res.data.map(item => {
                                // console.log('item x <--> ', item);
                                    return {
                                        ...item,
                                        last_transaction_date_s:       item.last_transaction_date       ? moment(item.last_transaction_date).format("DD/MM/YYYY")       : "-",
                                        last_transaction_date_issue_s: item.last_transaction_date_issue ? moment(item.last_transaction_date_issue).format("DD/MM/YYYY") : "-",
                                        item_name:                     item.item_number                 ? item.item_number + ' ' + item.item_desc                       : '',
                                        last_transaction_date:         item.last_transaction_date       ? moment(item.last_transaction_date)                            : '',
                                        last_transaction_date_issue:   item.last_transaction_date_issue ? moment(item.last_transaction_date_issue)                      : '',
                                    };
                            })
                        }

                        // if (this.headerTable.length > 0) {
                        //     this.headerTableItems = this.headerTable.map(item => {
                        //         return {
                        //             ...item,
                        //             last_transaction_date:       item.last_transaction_date       ? formatDate(item.last_transaction_date)       : '',
                        //             last_transaction_date_issue: item.last_transaction_date_issue ? formatDate(item.last_transaction_date_issue) : '',
                        //             item_name:                   item.item_number                 ? item.item_number + ' ' + item.item_desc      : '',

                        //             // selected: item.freeze_flag == 'Y' ? true : false,
                        //             // uom_code_desc: this.getUomCodeDescription(this.uomCodes, item.uom_code),
                        //             // complete_date_ts: item.complete_date ? moment(item.complete_date) : null,
                        //             // complete_date_thai: item.complete_date ? moment(item.complete_date).add(543, "year").format("DD/MM/YYYY") : "-",
                        //             // closed_date_thai: item.closed_date ? moment(item.closed_date).add(543, "year").format("DD/MM/YYYY") : "-",
                        //         }
                        //     });
                        // }
                        
                    })
                    .catch(err => {
                        swal({
                            title: "Warning",
                            text: err,
                            type: "warning",
                            showCancelButton: false,
                        });
                    })
                    .then(() => {
                        vm.loading = false;
                    });
                }
            })
        },
        clearSearch(){
            this.searchLoading           = true;

            this.periodNameList          = [];
            this.disablePeriodName       = true

            this.search.period_year_th   = '';
            this.search.cost_code        = '';
            this.search.period_name      = '';

            this.searchLoading           = false;
        },
        getPeriodName(period){
            this.loading = true;
            this.periodNameList = [];

            if (this.search.period_year_th) {

                axios.get("/ct/ajax/inquire_production/get-period-name", {
                    params: {
                        period: period,
                    }
                }).then(res => {

                    this.periodNameList    = res.data;
                    this.disablePeriodName = false;
                    
                })
                .catch(err => {
                    swal({
                        title: "Warning",
                        text: "มีข้อผิดพลาด",
                        type: "warning",
                        showCancelButton: false,
                    });
                })
                .then(() => {
                    this.loading = false;
                });
            } else {
                this.disablePeriodName = true;
                this.loading = false;
            }
        },
        getDataLine(header){
            let vm = this;
            vm.loading = true;

            // vm.activeIndex = index;

            axios.get("/ct/ajax/inquire_production/get-lines", {
                params: {
                    period_name:      header.from_period_name,
                    cost_code:        header.cost_code,
                    batch_no:         header.batch_no,
                }
            }).then(res => {

                this.lineTable = res.data;
                
            })
            .catch(err => {
                swal({
                    title: "Warning",
                    text: "มีข้อผิดพลาด",
                    type: "warning",
                    showCancelButton: false,
                });
            })
            .then(() => {
                vm.loading = false;
            });
        },
        formatDate(date){
            return moment(date).format(this.vars.formatDate)
        },
        sortTransactionDate(a, b) {
            return moment(a.last_transaction_date) - moment(b.last_transaction_date);
        },
        sortTransactionDateIssue(a, b) {
            return moment(a.last_transaction_date_issue) - moment(b.last_transaction_date_issue);            
        },
    },
    computed: {
        total() {
            let data = 0
            this.lineTable.filter(row => {
                data += row.confirm_qty
            })
            return data;
        },
    },
}
</script>
<style scope>
    .sticky-col {
        position: sticky;
        background-color: #ffffff;
        z-index: 9999;
        top: 0;
    }

    .mouse-over:hover {
      background-color: #d4edda!important;
    }

    .highlight{
        background-color: #d4edda!important;
    }
</style>
<style>
  .el-form-item__content{
    line-height: 40px;
    position: relative;
    font-size: 14px;
    margin-left: 0px !important;
  }
  .el-form-item__error {
    color: #F56C6C;
    font-size: 12px;
    line-height: 1;
    padding-top: 4px;
    position: relative;
    top: 100%;
    left: 0;
  }
</style>