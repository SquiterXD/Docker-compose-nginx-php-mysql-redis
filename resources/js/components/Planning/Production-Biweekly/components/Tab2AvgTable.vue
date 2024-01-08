<template>
    <div v-loading="loading.avgBiweeklyTable">
        <div class="form-group row" v-if="canEdit && productType != 'KK'" >
            <label class="col-lg-1 col-form-label text-right pr-0 pt-2"> <strong class="">เลือกข้อมูล:</strong> </label>
            <div class="col-lg-3">
                <el-select clearable style="width: 100%" @change="changeCalTypeAll" v-model="calType" size="large" placeholder="" filterable >
                   <el-option
                       v-for="(type, index) in calTypes"
                        :key="index"
                        :label="type.calculate_desc"
                        :value="type.calculate_type"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="table-responsive m-t"  >

            <div v-if="productType == 'KK'" v-html="avgKkTableHtml"></div>
            <table v-if="productType != 'KK'" class="table text-nowrap table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="background-color: #ffffff; border: 0px;" class="align-bottom " colspan="5" >
                            <!-- <div class="form-group row" v-if="canEdit">
                                <label class="col-lg-2 col-form-label text-right"> เลือกข้อมูล: </label>
                                <div class="col-lg-3">
                                    <el-select clearable style="width: 100%" @change="changeCalTypeAll" v-model="calType" size="large" placeholder="" filterable >
                                       <el-option
                                           v-for="(type, index) in calTypes"
                                            :key="index"
                                            :label="type.calculate_desc"
                                            :value="type.calculate_type"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div> -->
                        </th>
                        <template v-for="(biweekly, key, index) in avgBiweeklyData">
                        <td style="background-color: #ffffff; border: 0px;" class="text-right" :colspan="(prodBiweeklyMain.biweekly == key) ? 7 : 6">
                            <template v-if="biweekly[Object.keys(biweekly)[0]].current_flag != 'Y'">
                            <modal-html
                                class="text-right"
                                :modalId="key"
                                :html="summaryData[key]['total_working_html']"
                                :modalTitle="modalTotalWorking.title + ' ปักษ์ที่ ' + key"
                                :btnTrans="btnTrans"
                                :btnText="modalTotalWorking.btn_name"
                                />
                            </template>
                        </td>
                        </template>
                    </tr>
                    <tr style="position: sticky;">
                        <th class="align-middle text-center firstP04-col" rowspan="2">ลำดับ</th>
                        <th class="align-middle text-center secondP04-col" rowspan="2">รหัสบุหรี่</th>
                        <th class="align-middle text-center thP04-col" rowspan="2">ตราบุหรี่</th>
                        <th class="align-middle text-center foP04-col" rowspan="2">ผลิต/BATCH<br>(ล้านมวน)</th>
                        <th class="align-middle text-center" rowspan="2">ปริมาณใช้ใบยาต่อ<br>1 ล้านมวน (กก.)</th>

                        <template v-for="(biweekly, key, index) in avgBiweeklyData">
                            <template v-if="biweekly[Object.keys(biweekly)[0]].current_flag == 'Y'">
                                <th class="text-center text-white" :style="'background-color: '+ biweeklyColorCode[index]" :colspan="(prodBiweeklyMain.biweekly == key) ? 7 : 6">
                                    ปักษ์ที่ {{ key }} (ปักษ์ปัจจุบัน)
                                    <br>
                                    ({{ prodBiweeklyMain.creation_day + '-' + biweekly[Object.keys(biweekly)[0]].pp_bi_weekly.thai_combine_date.substring(3) }})
                                </th>
                            </template>
                            <template v-else>
                                <th class="text-center text-white" :style="'background-color: '+ biweeklyColorCode[index]" :colspan="(prodBiweeklyMain.biweekly == key) ? 7 : 6">
                                    ปักษ์ที่ {{ key }}
                                    <br>({{ biweekly[Object.keys(biweekly)[0]].pp_bi_weekly.thai_combine_date }})
                                </th>
                            </template>
                        </template>
                    </tr>
                    <tr>
                        <template v-for="(biweekly, thBwIdx) in avgBiweeklyData">
                            <template v-if="biweekly[Object.keys(biweekly)[0]].current_flag == 'Y'">
                                <template v-if="thBwIdx == prodBiweeklyMain.biweekly">
                                    <th class="align-middle text-center" rowspan="2">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        ข้อมูลที่ใช้
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </th>
                                </template>
                                <th class="text-center" >
                                    <el-tooltip class="item" effect="dark" :content="prodBiweeklyMain.creation_date_format" placement="top">
                                      <div>คงคลังปัจจุบัน<br>(ล้านมวน)</div>
                                    </el-tooltip>
                                </th>
                                <th class="text-center" >ประมาณการผลิต<br>(ล้านมวน)</th>
                                <th class="text-center" >เหลือวันขาย<br>(วัน)</th>
                            </template>
                            <template v-else>
                                <template v-if="thBwIdx == prodBiweeklyMain.biweekly">
                                    <th class="align-middle text-center" rowspan="2">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        ข้อมูลที่ใช้
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </th>
                                </template>
                                <th class="text-center" >
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    จำนวนชุด
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <br>(ชุด)
                                </th>
                                <th class="text-center" >ประมาณการผลิต<br>(ล้านมวน)</th>
                                <th class="text-center" >ปริมาณใบยาที่ใช้<br>(กก.)</th>
                            </template>
                            <th class="text-center"
                                :title="biweekly[Object.keys(biweekly)[0]].current_flag == 'Y'? 'ค่าเฉลี่ยขายย้อนหลัง 10 วัน * จำนวนเหลือวันขาย': ''">
                                ประมาณการขาย<br>(ล้านมวน)
                            </th>
                            <th class="text-center"
                                :title="biweekly[Object.keys(biweekly)[0]].current_flag == 'Y'? '(คงคลังปัจจุบัน + ประมาณการผลิต) - ประมาณการขาย': ''">
                                คงคลังสิ้นปักษ์<br>(ล้านมวน)
                            </th>
                            <th class="text-center"
                                :title="biweekly[Object.keys(biweekly)[0]].current_flag == 'Y'? 'คงคลังสิ้นปักษ์ / ค่าเฉลี่ยขายย้อนหลัง 10 วัน': ''">
                                จำนวนวันพอจำหน่าย<br>(วัน)
                            </th>
                        </template>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(item, key, index) in avgBiweeklyData[Object.keys(avgBiweeklyData)[0]]">
                        <tr>
                            <td class="firstP04-col">{{ index += 1 }}</td>
                            <!-- <td class="">
                                {{ item.stamp_desc }}
                            </td> -->
                            <td class="secondP04-col">{{ item.item_code }}</td>
                            <td class="thP04-col">{{ item.item_description }}</td>
                            <td class="text-center foP04-col">{{ item.define_product_cigaret }}</td>
                            <td class="text-right">{{ item.formula_qty | number2Digit }}</td>
                            <!-- <template v-for="(biweekly) in avgBiweeklyData">
                                <template v-if="biweekly[item.item_code].current_flag == 'Y'">
                                    <td>
                                        <el-select style="width: 100%"
                                            :disabled="!canEdit"
                                            v-model="biweekly[item.item_code].calculate_type"
                                            size="large" placeholder=""
                                            @change="changeCalType(biweekly[item.item_code])" filterable >
                                            <el-option label="" :value=null></el-option>
                                            <el-option
                                               v-for="(type, index) in calTypes"
                                                :key="index"
                                                :label="type.calculate_desc"
                                                :value="type.calculate_type"
                                            >
                                            </el-option>
                                        </el-select>
                                    </td>
                                </template>
                            </template> -->

                            <template v-for="(biweekly, bwIdx) in avgBiweeklyData">
                                <template v-if="bwIdx == prodBiweeklyMain.biweekly">
                                    <td>
                                        <el-select style="width: 100%"
                                            :disabled="!canEdit"
                                            v-model="biweekly[item.item_code].calculate_type"
                                            size="large" placeholder=""
                                            @change="changeCalType(biweekly[item.item_code])" filterable >
                                            <el-option
                                               v-for="(type, index) in calTypes"
                                                :key="index"
                                                :label="type.calculate_desc"
                                                :value="type.calculate_type"
                                            >
                                            </el-option>
                                        </el-select>
                                    </td>
                                </template>

                                <template v-if="biweekly[item.item_code].current_flag == 'Y'">
                                    <td class="text-right" >
                                        {{ biweekly[item.item_code].curr_onhnad_qty | number2Digit }}
                                    </td>
                                    <td class="text-right" >
                                        {{ biweekly[item.item_code].planning_qty | number2Digit }}
                                    </td>
                                    <td class="text-right" >
                                        {{ biweekly[item.item_code].bal_sale_day | number2Digit}}
                                    </td>
                                </template>
                                <template v-else>
                                    <td class="text-right" >
                                        <template v-if="canEdit && false">
                                            <input type="number"
                                                @change="changeNextOnhandQty(biweekly[item.item_code])"
                                                v-model="biweekly[item.item_code].next_onhand_qty"
                                                class="form-control text-right">
                                        </template>
                                        <template v-else>
                                            {{ biweekly[item.item_code].next_onhand_qty | number2Digit }}
                                        </template>
                                    </td>
                                    <td class="text-right" >
                                        {{ biweekly[item.item_code].planning_qty | number2Digit }}
                                    </td>
                                    <td class="text-right" >
                                        {{ biweekly[item.item_code].used_qty | number2Digit }}
                                    </td>
                                </template>

                                <td class="text-right" >
                                    {{ biweekly[item.item_code].forcast_qty | number2Digit }}
                                </td>
                                <td class="text-right" >
                                    {{ biweekly[item.item_code].bal_onhand_qty | number2Digit }}
                                </td>
                                <td class="text-right" >
                                    {{ biweekly[item.item_code].bal_sale_day | number2Digit }}
                                </td>
                            </template>
                        </tr>
                    </template>
                    <tr>
                        <th colspan="4" class="text-right to-col">รวม</th>
                        <th class="text-right" style="background-color: #34d399;"></th>
                        <template v-for="(biweekly, index) in avgBiweeklyData">
                            <template v-if="biweekly[Object.keys(biweekly)[0]].current_flag == 'Y'">
                                <template v-if="index == prodBiweeklyMain.biweekly">
                                    <th style="background-color: #34d399;" class="text-right text-white">
                                        
                                    </th>
                                </template>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    {{ summaryData[index]['curr_onhnad_qty'] }}
                                </th>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    {{ summaryData[index]['planning_qty'] }}
                                </th>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    {{ summaryData[index]['bal_sale_day'] }}
                                </th>
                            </template>
                            <template v-else>
                                <template v-if="index == prodBiweeklyMain.biweekly">
                                    <th style="background-color: #34d399;" class="text-right text-white">
                                        
                                    </th>
                                </template>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    {{ summaryData[index]['next_onhand_qty'] }}
                                </th>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    {{ summaryData[index]['planning_qty'] }}
                                </th>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    {{ summaryData[index]['used_qty'] }}
                                </th>

                            </template>
                            <th style="background-color: #34d399;" class="text-right text-white">
                                {{ summaryData[index]['forcast_qty'] }}
                            </th>
                            <th style="background-color: #34d399;" class="text-right text-white">
                                {{ summaryData[index]['bal_onhand_qty'] }}
                            </th>
                            <th style="background-color: #34d399;" class="text-right text-white">
                                {{ summaryData[index]['bal_sale_day'] }}
                            </th>
                        </template>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>

    export default {
        props:[
            'url', "prodBiweeklyMain", "productType", "btnTrans", "biweeklyColorCode",
            'calTypeDefault', 'calTypes', "canEdit",


            'pRefresh',
            'omBiweeklyDetail', 'productPlanId',
            'pWorkingHour'
        ],
        data() {
            return {
                loading: {
                    avgBiweeklyTable: false
                },
                calType:  (this.calTypeDefault != undefined && this.calTypeDefault != '') ? this.calTypeDefault : null,
                clonCalType: (this.calTypeDefault != undefined && this.calTypeDefault != '') ? this.calTypeDefault : null,
                refresh: (this.pRefresh != undefined && this.pRefresh != '') ? this.pRefresh : false,
                avgBiweeklyData: false,
                summaryData: [],
                avgKkTableHtml: '',

                modalTotalWorking: {
                    title: 'รายละเอียดชั่วโมงการทำงาน',
                    btn_name: 'รายละเอียดการทำงาน'
                }
            }
        },
        mounted() {
            // this.getAvgDataTable();

        },
        computed: {
        },
        methods: {
            async changeCalTypeAll() {
                let vm = this;
                if (!vm.canEdit || !vm.calType) {
                    return;
                }
                let biweeklyNo = false;

                Object.values(vm.avgBiweeklyData).forEach(async function(biweekly) {
                    let firstLine = biweekly[Object.keys(biweekly)[0]];
                    if (firstLine.wk_weekly == vm.prodBiweeklyMain.biweekly) {
                        biweeklyNo = firstLine.pp_bi_weekly.biweekly;
                    }
                });

                swal({
                    html: true,
                    title: 'แก้ไขข้อมูลที่ใช้',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการแก้ไขข้อมูลที่ใช้ ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        vm.clonCalType = JSON.parse(JSON.stringify(vm.calType));
                        let items = vm.avgBiweeklyData[biweeklyNo];
                        Object.values(items).forEach(async function(item) {
                            item.calculate_type = vm.calType
                            vm.changeCalType(item)
                        });
                    } else {
                        vm.calType = JSON.parse(JSON.stringify(vm.clonCalType));
                    }
                });
            },
            async changeCalType(line) {
                console.log('xx', line);
                // update plan case: 2
                this.$emit("tab2AvgChange", {
                    case: 2,
                    product_main_id: line.product_main_id,
                    item_id: line.item_id,
                    d1_calculate_type: null,
                    d5_calculate_type: line.calculate_type,
                    d12_next_onhand_qty: null,
                    d12_old_next_onhand_qty: line.next_onhand_qty,
                    d7_planning_qty: null,
                    biweekly_id: line.pp_biweekly_id,

                    pp_biweekly_id: line.pp_biweekly_id,
                    product_plan_id: line.product_plan_id,
                });
            },
            async changeNextOnhandQty(line) {
                console.log('xx', line);
                // update plan case: 3
                this.$emit("tab2AvgChange", {
                    case: 3,
                    product_main_id: line.product_main_id,
                    item_id: line.item_id,
                    d1_calculate_type: null,
                    d5_calculate_type: line.calculate_type,
                    d12_next_onhand_qty: line.next_onhand_qty,
                    d12_old_next_onhand_qty: line.next_onhand_qty,
                    d7_planning_qty: null,
                    biweekly_id: line.pp_biweekly_id,

                    pp_biweekly_id: line.pp_biweekly_id,
                    product_plan_id: line.product_plan_id,
                });
            },
            async getAvgDataTable() {
                let vm = this;
                if (!vm.refresh) {
                    return;
                }

                vm.loading.avgBiweeklyTable = true;
                vm.avgBiweeklyData = false
                vm.avgKkTableHtml = false;
                vm.summaryData = [];
                let params = {
                    product_main_id: vm.prodBiweeklyMain.product_main_id,
                    om_biweekly_id: vm.omBiweeklyDetail.om_biweekly_id,
                    product_type: vm.productType,
                };
                await axios.get(vm.url.ajax_get_avg_data, { params })
                    .then(res => {
                        // vm.avgBiweeklyTable = res.data.data.html
                        vm.avgBiweeklyData = res.data.data.avg_biweekly;
                        vm.avgKkTableHtml = res.data.data.avg_kk_table_html;
                        vm.summaryData = res.data.data.summary;

                        let avgBiweekly = res.data.data.avg_biweekly;
                        avgBiweekly = _.sortBy(avgBiweekly, function(o, z) {
                            return o[Object.keys(o)[0]].current_flag;
                        });

                        console.log('C', avgBiweekly, typeof avgBiweekly);
                        // avgBiweekly = _.mapKeys(avgBiweekly, function(value, key) {
                        //     console.log('key', value[Object.keys(value)[0]].pp_bi_weekly.biweekly);
                        //     if (value[Object.keys(value)[0]].pp_bi_weekly.biweekly == 15) {
                        //         return 1;
                        //     }
                        //     return value[Object.keys(value)[0]].pp_bi_weekly.biweekly;
                        // });

                        // Object.keys(state.employees).map((key) => {
                        //     return {
                        //       key,
                        //       ...state.employees[key]
                        //     }
                        // });

                        avgBiweekly = Object.keys(avgBiweekly).map((key) => {
                            return key
                            console.log('ss', key);
                            return {
                              key,
                              ...avgBiweekly[key]
                            }
                        });


                        console.log('C', avgBiweekly, typeof avgBiweekly);
                        // _.sortBy(this.items, function(o) { return o.item_display_name; });
                        // .sort((a, b) => new Date(a.created) - new Date(b.created)
                        // avgBiweekly._.sortBy(function(a, b) {
                        //     console.log('aaa', a, b);
                        //     // return a.position - b.position;
                        // });
                    })
                    .catch(err => {
                        console.log('error')
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading.avgBiweeklyTable = false;
                    });
                vm.refresh = false;
            }
        },
        watch: {
            pRefresh : async function (value, oldValue) {
                this.refresh = true;
                this.getAvgDataTable();
            },
        },
        computed: {

            // om_day_for_sale
            // total_wk8_day
            // total_wk9_day
            // total_wk13_day
            // max_planning_qty
            // summaryMachineC(){
            // }
        }
    }
</script>

<style scope>
    .el-input--medium .el-input__inner {
        height: 30px !important;
        line-height: 36px;
    }
    .el-input--medium .el-input__icon {
        line-height: 30px;
    }

    .nav .label, .ibox .label {
        font-size: 12px;
    }

    .sticky-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 2040;
    }

    .firstP04-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 2040;
        width: 100px;
        min-width: 90px;
        max-width: 100px;
        left: 0px;
    }

    .secondP04-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 2040;
        width: 150px;
        min-width: 120px;
        max-width: 150px;
        left: 88px;
    }

    .thP04-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 2040;
        width: 120px;
        min-width: 120px;
        max-width: 250px;
        left: 206px;
    }

    .foP04-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 2040;
        width: 100px;
        min-width: 100px;
        max-width: 200px;
        left: 358px;
    }

    .fiP04-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 2040;
        width: 100px;
        min-width: 100px;
        max-width: 200px;
        left: 457px;
    }

    .to-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 2040;
        width: 100px;
        min-width: 100px;
        max-width: 100px;
        left: -6px;
    }
</style>