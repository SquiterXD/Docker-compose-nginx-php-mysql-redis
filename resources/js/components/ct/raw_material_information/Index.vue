<template>
    <div>
        <div class="ibox">
            <div class="ibox-content">
                <el-form :model="search" ref="save_data" label-width="120px" class="demo-dynamic form_table_line">
                    <div class="row" v-loading="searchLoading">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 mt-2 text-right">รหัสศูนย์รับผิดชอบ<span class="text-danger">*</span></div>
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
                                <div class="col-md-4 mt-2 text-right">สรุปรายการเบิกประจำวันที่<span class="text-danger">*</span></div>
                                <div class="col-md-6">
                                    <el-form-item :prop="'transaction_date'" :rules="rules.transaction_date">
                                        <el-date-picker 
                                            v-model="search.transaction_date"
                                            style="width: 100%;"
                                            type="date"
                                            placeholder="วันที่"
                                            name="transaction_date"
                                            format="dd-MM-yyyy"
                                            >
                                        </el-date-picker>
                                    </el-form-item>
                                </div>
                                <!-- <div class="col-md-3 mt-2 text-right">รหัสหน่วยงาน<span class="text-danger">*</span></div>
                                <div class="col-md-6">
                                    <el-form-item :prop="'dept_code'" :rules="rules.dept_code">
                                        <el-select
                                            style="width:100%;"
                                            v-model="search.dept_code"
                                            placeholder="หน่วยงาน"
                                            filterable
                                            clearable
                                            remote
                                            size="medium">
                                            <el-option
                                                v-for="(item, index) in departments"
                                                :key="index"
                                                :label="item.dept_code + ' : ' + item.dept_desc"
                                                :value="item.dept_code"
                                            >
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <!-- <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 mt-2 text-right">สรุปรายการเบิกประจำวันที่<span class="text-danger">*</span></div>
                                <div class="col-md-6">
                                    <el-form-item :prop="'transaction_date'" :rules="rules.transaction_date">
                                        <el-date-picker 
                                            v-model="search.transaction_date"
                                            style="width: 100%;"
                                            type="date"
                                            placeholder="วันที่"
                                            name="transaction_date"
                                            format="dd-MM-yyyy"
                                            >
                                        </el-date-picker>
                                    </el-form-item>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="col-md-6">
                            <div class="row"> -->
                                <div class="col-md-12  text-right">
                                    <button type="button"  :class="trans_btn.search.class" @click="searchData">
                                        <i :class="trans_btn.search.icon"></i> ค้นหา
                                    </button>
                                    <button type="button"  :class="trans_btn.cancel.class" @click="clearSearch">
                                        ล้าง
                                    </button>
                                </div>
                            <!-- </div>
                        </div> -->
                    </div>
                </el-form>
            </div>
        </div>
        <div class="ibox" v-loading="loading">
            <div class="ibox-content" v-loading="headerLoading">
                <div class="table-responsive mt-3" style="max-height: 420px;">
                    <table class="table table-bordered table-hover mt-3" style="position: sticky;">
                        <thead>
                            <tr>
                                <th class="sticky-col text-center" width="150px;">เลขที่คำสั่งผลิต</th>
                                <th class="sticky-col text-center">ชื่อสินค้า</th>
                                <th class="sticky-col text-center" width="150px;">เลขที่ใบเบิก</th>
                                <th class="sticky-col text-center" width="100px;">ขั้นตอน</th>
                                <th class="sticky-col text-center" width="150px;">จำนวน</th>
                                <th class="sticky-col text-center" width="100px;">UOM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-show="headerTable.length > 0"
                                v-for="(header, index) in headerTable"
                                :key="index" class="mouse-over"
                                @click="getDataLine(header, index)"
                                :class="`${index === activeIndex ? 'highlight' : ''}`">
                            <!-- <tr v-for="(header, index) in headerTable" v-if="headerTable.length > 0" @click="getDataLine(header, index)" class="mouse-over"> -->
                                <td>{{ header.batch_no }}</td>
                                <td>{{ header.item_no + ' ' + header.item_desc }}</td>
                                <td>{{ header.request_number }}</td>
                                <td>{{ header.wip_step }}</td>
                                <td class="text-right">{{ currencyDecimal(header.quantity, 6) }}</td>
                                <td class="text-center">{{ header.uom_code }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Line -->
                <div class="table-responsive mt-3" style="max-height: 420px;" v-if="lineTable.length > 0">
                    <table class="table table-bordered table-hover text-nowrap mt-3" style="position: sticky;">
                        <thead>
                            <tr>
                                <th class="sticky-col text-center">รหัสวัตถุดิบ</th>
                                <th class="sticky-col text-center">รายละเอียด</th>
                                <th class="sticky-col text-center">วัตถุดิบที่เบิก</th>
                                <th class="sticky-col text-center">UOM</th>
                                <th class="sticky-col text-center">% สูญเสีย</th>
                                <th class="sticky-col text-center">ราคา</th>
                                <th class="sticky-col text-center">จำนวนเงิน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(line, index) in lineTable" class="mouse-over">
                                <td>{{ line.item_no }}</td>
                                <td>{{ line.item_desc }}</td>
                                <td class="text-right">{{ currencyDecimal(line.quantity, 6) }}</td>
                                <td class="text-center">{{ line.uom_code }}</td>
                                <td></td>
                                <td class="text-right">{{ currencyDecimal(line.actual_cost, 9) }}</td>
                                <td class="text-right">{{ formatCurrency(line.actual_cost * line.quantity) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" colspan="6">รวม</th>
                                <th class="text-right">{{ formatCurrency(total) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import * as scripts from '../helper/scripts'

export default {
    props: ['trans_btn', 'costs', 'departments'],
    data() {
        return {
            // funcs: scripts.funcs,
            formatCurrency: scripts.funcs.formatCurrency,
            currencyDecimal: scripts.funcs.currencyDecimal,

            loading: false,
            searchLoading: false,
            headerLoading: false,
            lineLoading:   false,
            search:{
                cost_code:        '',
                // dept_code:        '',
                transaction_date: ''
            },

            headerTable: [],
            lineTable: [],

            rules: {
                cost_code: [
                    { required: true, message: 'กรุณาเลือก ศูนย์รับผิดชอบ', trigger: "change"}
                ],
                // dept_code: [
                //     { required: true, message: 'กรุณาเลือก หน่วยงาน', trigger: "change"}
                // ],
                transaction_date: [
                    { required: true, message: 'กรุณาเลือก สรุปรายการเบิกประจำวันที่', trigger: "blur"}
                ],
            },

            activeIndex: '',
        }
    },
    methods:{
        searchData(){
            console.log('search');
            let vm = this;

            this.$refs.save_data.validate((valid) => {
                if (valid) {
                    vm.loading = true;
                    axios.get("/ct/ajax/raw_material_information/", {
                        params: {
                            cost_code:        vm.search.cost_code,
                            // dept_code:        vm.search.dept_code,
                            transaction_date: vm.search.transaction_date,
                        }
                    }).then(res => {

                        this.headerTable = res.data;
                        
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
                }
            })
        },
        clearSearch(){
            console.log('clearSearch');

            this.searchLoading           = true;

            this.search.cost_code        = '';
            // this.search.dept_code        = '';
            this.search.transaction_date = '';

            this.searchLoading           = false;
        },
        getDataLine(header, index){
            let vm = this;
            vm.loading = true;

            vm.activeIndex = index;

            axios.get("/ct/ajax/raw_material_information/get-lines", {
                params: {
                    cost_code:        header.cost_code,
                    // dept_code:        header.dept_code,
                    batch_no:         header.batch_no,
                    request_number:   header.request_number,
                    transaction_date: header.transaction_date,
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
    },
    computed: {
        total() {
            let data = 0
            this.lineTable.filter(row => {
                data += row.actual_cost * row.quantity
            })
            return data;
        },
    },
}
</script>

<style scope>
    .sticky-col {
        position: sticky;
        background-color: #b7b9b6;
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
