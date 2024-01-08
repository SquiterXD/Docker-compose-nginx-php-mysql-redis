<template>
    <div class="" >
        <div class="ibox float-e-margins mb-2" >
            <div class="col-12 text-right mt-1">
                <button  type="button" :disabled="(header.monthly_id == '' || header.monthly_id == undefined)" :class="btn_trans.copy.class + ' btn-lg tw-w-25'" @click.prevent="duplicate()">
                    <i :class="btn_trans.copy.icon"></i>
                    {{ btn_trans.copy.text }}แผน
                </button>

                <button v-if="canApprove" type="button" :class="btn_trans.approve.class + ' btn-lg tw-w-25'" @click.prevent="checkApprove()">
                    <i :class="btn_trans.approve.icon"></i>
                    {{ btn_trans.approve.text }}
                </button>

                <modal-search
                    :btnTrans="btnTrans"
                    :url="url"
                    :budgetYears="search_input.budget_years"
                    :defPeriodYear="search_input.def_period_year"
                    :monthList="search_input.month_list"
                    :search="[]"
                />

                <modal-create
                    class="pr-2"
                    :btnTrans="btnTrans"
                    :url="url"
                    :createInput="createInput"
                />

                <button  type="button" :class="btn_trans.save.class + ' btn-lg tw-w-25'" @click.prevent="saveChangeInput()">
                    <i :class="btn_trans.save.icon"></i>
                    {{ btn_trans.save.text }}
                </button>


                <!--
                <button v-if="canApprove" type="button" :class="btn_trans.approve.class + ' btn-lg tw-w-25'" @click.prevent="checkApprove()">
                    <i :class="btn_trans.approve.icon"></i>
                    {{ btn_trans.approve.text }}
                </button>

                <button type="button" :class="btn_trans.print.class + ' btn-lg tw-w-25'" >
                    <i :class="btn_trans.print.icon"></i>
                    {{ btn_trans.print.text }}
                </button> -->

            </div>
        </div>

        <div class="card border-primary mb-3 mt-3">
            <div class="card-body">
                <header-detail :header="header" :url="url"/>
            </div>
        </div>

        <div class="tabs-container mb-3" v-loading="loading">
            <ul class="nav nav-tabs" role="tablist">
                <li>
                    <a class="nav-link active" data-toggle="tab" href="#tab1" @click="clickSelTabName = 'tab1'">
                        ประมาณการจัดซื้อแสตมป์รายตรา
                    </a>
                </li>
                <li>
                    <a class="nav-link " data-toggle="tab" href="#tab2" @click="clickSelTabName = 'tab2'">
                        รวมประมาณการจัดซื้อแสตมป์รายตรา
                    </a>
                </li>
                <li>
                    <a class="nav-link " data-toggle="tab" href="#tab3" @click="clickSelTabName = 'tab3'">
                        ประมาณการจัดซื้อแสตมป์ตามกลุ่มราคา
                    </a>
                </li>
            </ul>

            <div class="tab-content" >
                <div role="tabpanel" id="tab1" class="tab-pane active">
                    <div class="panel-body " v-if="header">
                        <div class="row">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> รหัสแสตมป์ :</label>
                                <div class="input-group ">
                                    <el-select style="width: 100%" v-model="tab1Input.stamp_code" size="large" placeholder="รหัสแสตมป์"  clearable filterable>
                                        <el-option
                                           v-for="(item, index) in header.stamp_items_group"
                                            :key="index"
                                            :label="index +': '+ item[0].stamp_description"
                                            :value="index"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-7 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> &nbsp;</label>
                                <div class="input-group ">
                                    <el-input size="large" disabled :readonly="true"
                                        :value="(()=>{
                                            if(!tab1Input.stamp_code) return '';

                                            return header.stamp_items_group[tab1Input.stamp_code][0].stamp_description;
                                        })()"
                                        > </el-input>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> รหัสบุหรี่ :</label>
                                <div class="input-group ">
                                    <el-select style="width: 100%" v-model="tab1Input.cigarettes_code" size="large" placeholder="รหัสบุหรี่"  clearable filterable
                                        @change="getEstData()">
                                        <el-option
                                           v-for="(item, index) in header.stamp_items_group[tab1Input.stamp_code]"
                                            :key="item.cigarettes_code"
                                            :label="item.cigarettes_code +': '+ item.cigarettes_description"
                                            :value="item.cigarettes_code"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ตราบุหรี่</label>
                                <div class="input-group ">
                                    <el-input size="large" disabled :readonly="true"
                                        :value="(()=>{
                                            if(!tab1Input.stamp_code) return '';
                                            if(!tab1Input.cigarettes_code) return '';

                                            let result = header.stamp_items_group[tab1Input.stamp_code].find(item => item.cigarettes_code === tab1Input.cigarettes_code)
                                            if(result){
                                                return result.cigarettes_description
                                            }
                                        })()"
                                        > </el-input>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0  col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ม้วนละ :</label>
                                <div class="input-group ">
                                    <el-input size="large" disabled class="text-right" :readonly="true"
                                        :value="(()=>{
                                            if(!tab1Input.stamp_code) return '';
                                            if(!tab1Input.cigarettes_code) return '';

                                            let result = header.stamp_items_group[tab1Input.stamp_code].find(item => item.cigarettes_code === tab1Input.cigarettes_code)
                                            if(result){
                                                return result.unit_price_per_roll
                                            }
                                        })()"
                                        > </el-input>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ราคาต่อดวง :</label>
                                <div class="input-group ">
                                    <el-input size="large" disabled class="text-right" :readonly="true"
                                        :value="(()=>{
                                            if(!tab1Input.stamp_code) return '';
                                            if(!tab1Input.cigarettes_code) return '';

                                            let result = header.stamp_items_group[tab1Input.stamp_code].find(item => item.cigarettes_code === tab1Input.cigarettes_code)
                                            if(result){
                                                return result.unit_price
                                            }
                                        })()"
                                        > </el-input>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1">&nbsp;</label>
                                <button type="button"
                                    :disabled="!canApprove || (tab1Input.stamp_code == '' || tab1Input.cigarettes_code == '')"
                                    @click="updateEst()" :class="btnTrans.save.class + ' btn-lg tw-w-25 btn-block'" >
                                    <i :class="btnTrans.save.icon"></i>
                                    อัพเดทประมาณการ
                                </button>
                            </div>
                        </div>

                        <div class="hr-line-dashed mt-3"></div>
                        <div class="table-responsive m-t"  >
                            <!-- <h1><pre>{{ Object.keys(changeData).length }}</pre></h1> -->
                        <table  class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th rowspan="2" class="text-center">วันที่</th>
                                <th rowspan="2" class="text-center">คงคลังเช้า (ดวง)</th>
                                <th colspan="3" class="text-center">รับเข้า</th>
                                <th rowspan="2" class="text-center">ประมาณการใช้(ดวง)</th>
                                <th colspan="2" class="text-center">คงคลังเย็น</th>
                                <th rowspan="2" class="text-center">พอใช้(วัน)</th>
                            </tr>
                            <tr>
                                <th class="text-center">ดวง</th>
                                <th class="text-center">ม้วน</th>
                                <th class="text-center">จำนวนเงิน</th>
                                <th class="text-center">ดวง</th>
                                <th class="text-center">ม้วน</th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-for="(item, index) in dailyList">
                                <tr :style="item.holiday_flag == 'P'? 'background-color: '+ publicHolidayColor: (item.holiday_flag == 'Y'? 'background-color: '+ holidayColor: '' )">
                                    <td class="text-center"> {{ item.plan_date_thai }}</td>
                                    <td class="text-right">
                                        <template v-if="onhandQuantity[item.plan_date] && index != 0">
                                            {{ onhandQuantity[item.plan_date] | number0Digit }}
                                        </template>
                                        <template v-else>
                                            {{ item.onhand_qty | number0Digit }}
                                        </template>
                                    </td>
                                    <td class="text-right">
                                        <receive-weekly
                                            style="width: 100%;"
                                            :stamp="item"
                                            :index="index"
                                            :line-weekly-qty="lineWeeklyQty"
                                            :approve="canApprove"
                                            :change-data="changeData"
                                        />
                                    </td>
                                    <td class="text-right" >
                                        <receive-roll
                                            style="width: 100%;"
                                            :stamp="item"
                                            :index="index"
                                            :line-roll-qty="lineRollQty"
                                            :approve="canApprove"
                                            :change-data="changeData"
                                        />
                                    </td>
                                    <td class="text-right">{{ item.receipt_amount | number2Digit }}</td>
                                    <td class="text-right">{{ item.total_daily_qty | number0Digit }}</td>
                                    <td class="text-right">
                                        <template v-if="balanceOnhandWeekly[item.plan_date] < 0">
                                            <span class="text-danger"> {{ balanceOnhandWeekly[item.plan_date] | number0Digit }} </span>
                                        </template>
                                        <template v-else>
                                            {{ balanceOnhandWeekly[item.plan_date] | number0Digit }}
                                        </template>
                                    </td>
                                    <td class="text-right">{{ balanceOnhandRoll[item.plan_date] | number2Digit }}</td>
                                    <td class="text-right">{{ balanceDays[item.plan_date] == NaN? 0: balanceDays[item.plan_date] | number2Digit }}</td>
                                    <!-- <td class="text-right">{{ item.bal_days }}</td> -->
                                </tr>
                            </template>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" id="tab2" class="tab-pane ">
                    <div class="panel-body ">
                        <div class="table-responsive m-t"  >
                            <div v-html="tab2Html"></div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" id="tab3" class="tab-pane ">
                    <div class="panel-body ">
                        <div class="row ">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> รหัสแสตมป์ :</label>
                                <div class="input-group ">
                                    <el-select style="width: 100%" v-model="tab3Input.stamp_code" size="large" placeholder="รหัสแสตมป์"  clearable filterable @change="getEstData()">
                                        <el-option
                                           v-for="(item, index) in header.stamp_summary"
                                            :key="index"
                                            :label="index + ': ' + item[0].stamp_description"
                                            :value="index"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> &nbsp;</label>
                                <div class="input-group ">
                                    <el-input disabled size="large" :readonly="true"
                                        :value="(()=>{
                                            if(!tab3Input.stamp_code) return '';

                                            return header.stamp_summary[tab3Input.stamp_code][0].stamp_description;
                                        })()"
                                        > </el-input>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ม้วนละ :</label>
                                <div class="input-group ">
                                    <el-input size="large" disabled class="text-right" :readonly="true"
                                        :value="(()=>{
                                            if(!tab3Input.stamp_code) return '';

                                            return header.stamp_summary[tab3Input.stamp_code][0].unit_price_per_roll
                                        })()"
                                        > </el-input>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ราคาต่อดวง :</label>
                                <div class="input-group ">
                                    <el-input size="large" disabled class="text-right" :readonly="true"
                                        :value="(()=>{
                                            if(!tab3Input.stamp_code) return '';

                                            return header.stamp_summary[tab3Input.stamp_code][0].unit_price
                                        })()"
                                        > </el-input>
                                </div>
                            </div>

                            <!-- <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1">&nbsp;</label>
                                <button type="button"  :class="btnTrans.search.class + ' btn-lg tw-w-25 btn-block'" >
                                    <i :class="btnTrans.search.icon"></i>
                                    แสดงผล
                                </button>
                            </div> -->
                        </div>

                        <div class="hr-line-dashed mt-5"></div>
                        <div class="table-responsive m-t"  >
                            <div v-html="tab3Html"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import ModalCreate      from './ModalCreate.vue';
    import ModalSearch      from './ModalSearch.vue';
    import HeaderDetail     from './components/HeaderDetail.vue';
    import SearchItem       from './SearchItem';
    import ReceiveWeekly    from './ReceiveWeekly.vue';
    import ReceiveRoll      from './ReceiveRoll.vue';
    import moment           from "moment";
    export default {
        components: {
            // ModalCreate, ModalSearch, HeaderDetail, Tab1, Tab2, Tab3
            ModalCreate, ModalSearch, HeaderDetail, SearchItem, ReceiveWeekly, ReceiveRoll
        },
        props:[
            "header", "btn_trans", "url", "create_input", "search_input",


            "adjustData",
            "modalCreateInput", "modalSearchInput", "colorCode", 'tabs',
            "pDateFormat",
            "productTypes", "ppBiWeekly", "workingHour",
            "omBiweeklyList", "calTypes", "calTypeDefault",
        ],
        data() {
            return {
                btnTrans: this.btn_trans,
                createInput: this.create_input,
                clickSelTabName: 'tab1',
                loading: false,
                tab1Input: {
                    stamp_code: '',
                    cigarettes_code: '',
                },
                tab3Input: {
                    stamp_code: '',
                },
                dailyList: [],
                changeData: {},
                canEdit: true,
                tab2Html: '',
                tab3Html: '',
                holidayColor: '#c0c4cc',
                publicHolidayColor: '#878788',




                // loading: {},
                // defaultInput: (this.pDefaultInput != undefined && this.pDefaultInput != '') ? this.pDefaultInput : null,
                // selTabName: String(Object.keys(this.tabs)[0]),
                // clickSelTabName: 'tab1',
                // productType: String(Object.keys(this.tabs)[0]),
                canApprove: false,

                // adjBiweeklyData:  {},
                // adjSummaryData: {},
                // adjKkTableHtml: {},
                // tab1Html: '',
                // modalTotalWorking: {
                //     title: 'รายละเอียดชั่วโมงการทำงาน',
                //     btn_name: 'รายละเอียดการทำงาน'
                // },
                // showData: false,
                // changeData: {},
                // addLineData: {}

                // Piyawut A. 09022022
                //inbound
                lineRollQty: {},
                lineWeeklyQty : {},
                // onhand
                onhandQuantity: {},
                balanceQuantity: {}, // พอใช้
                // คงคลังเย็น (ดวง-ม้วน)
                balanceOnhandWeekly: {},
                balanceOnhandRoll: {},
                balanceDays: {},
            }
        },
        async mounted() {
            if (this.header != undefined && this.header != '') {
                this.canEdit = this.header.approved_status.toUpperCase() == 'INACTIVE';
                this.canApprove = this.header.approved_status.toUpperCase() == 'INACTIVE';
            }

            // let vm = this;
            // Object.keys(vm.tabs).forEach(async function(tab) {
            //     vm.$set(vm.loading, tab, false);

            //     vm.$set(vm.adjBiweeklyData, tab, false);
            //     vm.$set(vm.adjSummaryData, tab, []);
            //     vm.$set(vm.adjKkTableHtml, tab, '');
            // });


            // vm.getEstData();
        },
        computed: {
            calBalanceStampMonthly() {
                var vm = this;
                //efficiency_product
                vm.dailyList.filter(function(line, index) {
                    let b = 0;
                    console.log(index);
                    let bb = 0;
                    let c = 0;
                    let i = 0; // mean onhand qty (value: คงคลังเช้า)
                    let bal_days = 0;
                    let first_date = moment(line.follow_date).format('YYYY-MM-DD');
                    // calculate
                    b = (Number(line.onhand_qty) + Number(line.weekly_receive_qty)) - Number(line.total_daily_qty);
                    // Vue.set(vm.balanceQuantity, line.plan_date, Number(bal_days));
                    if (index > 0) {
                        let i = 0;
                        // Check Onhand Quantity
                        var onhand = vm.onhandQuantity[vm.dailyList[index-1].plan_date]? vm.onhandQuantity[vm.dailyList[index-1].plan_date]: line.onhand_qty;
                        i = (Number(onhand) + Number(vm.dailyList[index-1].weekly_receive_qty)) - Number(vm.dailyList[index-1].total_daily_qty);
                        // อัพเดตคงคลังเช้าใหม่ (คงคลังเช้า) โดยคำนวณค่าย้อนหลังวันปัจจุบันไปหนึ่งวัน
                        Vue.set(vm.onhandQuantity, line.plan_date, Number(i));
                    }else{
                        Vue.set(vm.onhandQuantity, line.plan_date, Number(b));
                    }
                    // bb = (index == 0)
                    //     ? Number(line.onhand_qty) - Number(vm.dailyList[index+1].total_daily_qty)
                    //     : Number(vm.onhandQuantity[line.plan_date]) - Number(vm.dailyList[index+1].total_daily_qty);
                    // if (bb >= 0) {
                    //     bal_days = index == 0? Number(line.onhand_qty) /Number(vm.dailyList[index+1].total_daily_qty): Number(vm.onhandQuantity[line.plan_date]) /Number(vm.dailyList[index+1].total_daily_qty);
                    //     bal_days = line.total_daily_qty <= 0? 0: Math.floor(bal_days);
                    //     Vue.set(vm.balanceQuantity, line.plan_date, Number(bal_days));
                    // }
                    // if (b >= 0) {
                    //     bal_days = 1;
                    //     Vue.set(vm.balanceQuantity, line.plan_date, Number(bal_days));
                    //     vm.dailyList.filter(function(line2, index2) {
                    //         let last_date = moment(line2.plan_date).format('YYYY-MM-DD');
                    //         if (last_date >= first_date) {
                    //             if (index2+1 < vm.dailyList.length) {
                    //                 if (c == 0) {
                    //                     c = Number(b) - Number(vm.dailyList[index2+1].total_daily_qty);
                    //                 }else{
                    //                     c = Number(c) - Number(vm.dailyList[index2+1].total_daily_qty);
                    //                 }
                    //                 // check count for balance day
                    //                 if (Number(c) >= 0) {
                    //                     bal_days = bal_days+1;
                    //                     Vue.set(vm.balanceQuantity, line.plan_date, Number(bal_days));
                    //                 }
                    //             }
                    //         }
                    //     });
                    // }
                });
            },
            // คงคลังเย็น
            calBalanceOnhand() {
                var vm = this;
                //current date
                var curr_date = moment().format('YYYY-MM-DD');
                vm.dailyList.filter(function(line, index) {
                    let plan_date =  moment(line.plan_date).format('YYYY-MM-DD');
                    // calculate balance onhand weekly-roll
                    var onhandQuantity = 0;
                    var WeeklyQuantity = 0;
                    var balOnhWeekly = 0;
                    var balOnhroll = 0;
                    if (plan_date >= curr_date) {
                        // Weekly
                        onhandQuantity = vm.onhandQuantity[line.plan_date]? vm.onhandQuantity[line.plan_date]: line.onhand_qty;
                        WeeklyQuantity = vm.lineWeeklyQty[line.plan_date]? vm.lineWeeklyQty[line.plan_date]: line.weekly_receive_qty;
                        balOnhWeekly = Number(onhandQuantity) + Number(WeeklyQuantity) - Number(line.total_daily_qty);
                        // Roll
                        balOnhroll = onhandQuantity / line.unit_price_per_roll;
                        balOnhroll = balOnhroll? balOnhroll: 0;
                        // Result
                        Vue.set(vm.balanceOnhandWeekly, line.plan_date, Number(balOnhWeekly));
                        Vue.set(vm.balanceOnhandRoll, line.plan_date, Number(balOnhroll).toFixed(2));
                    }else{
                        // Weekly
                        balOnhWeekly = Number(line.onhand_qty) + Number(line.weekly_receive_qty) - Number(line.total_daily_qty);
                        // Roll
                        balOnhroll = balOnhWeekly / Number(line.unit_price_per_roll);
                        balOnhroll = balOnhroll? balOnhroll: 0;
                        // Result
                        Vue.set(vm.balanceOnhandWeekly, line.plan_date, Number(balOnhWeekly));
                        Vue.set(vm.balanceOnhandRoll, line.plan_date, Number(balOnhroll).toFixed(2));
                    }
                });
            },
            calBalanceDays() {
                var vm = this;
                let bal = 0;
                vm.dailyList.filter(function(line, index) {
                    // calculate
                    let c = 0;
                    let totalDailyReceive = 1;
                    Vue.set(vm.balanceDays, line.plan_date, Number(totalDailyReceive));
                    let first_date = moment(line.plan_date).format('YYYY-MM-DD');
                    if (index == 0) {
                        bal = Number(line.onhand_qty) - Number(line.total_daily_qty);
                        if (bal > 0) {
                            vm.dailyList.filter(function(line2, index2) {
                                let last_date = moment(line2.plan_date).format('YYYY-MM-DD');
                                if (last_date >= first_date) {
                                    if (index2+1 < vm.dailyList.length) {
                                        if (c == 0) {
                                            c = Number(bal) - Number(vm.dailyList[index2+1].total_daily_qty);
                                            totalDailyReceive = totalDailyReceive+1;
                                            Vue.set(vm.balanceDays, line.plan_date, Number(totalDailyReceive));
                                        }else{
                                            c = Number(c) - Number(vm.dailyList[index2+1].total_daily_qty);
                                            totalDailyReceive = totalDailyReceive+1;
                                            Vue.set(vm.balanceDays, line.plan_date, Number(totalDailyReceive));
                                        }
                                    }
                                }
                            });
                        }
                    }else{
                        bal = Number(vm.onhandQuantity[line.plan_date]) - Number(line.total_daily_qty);
                        vm.dailyList.filter(function(line2, index2) {
                            let last_date = moment(line2.plan_date).format('YYYY-MM-DD');
                            if (last_date >= first_date) {
                                if (index2+1 < vm.dailyList.length) {
                                    if (c == 0) {
                                        c = Number(bal) - Number(vm.dailyList[index2+1].total_daily_qty);
                                        totalDailyReceive = totalDailyReceive+1;
                                        Vue.set(vm.balanceDays, line.plan_date, Number(totalDailyReceive));
                                    }else{
                                        c = Number(c) - Number(vm.dailyList[index2+1].total_daily_qty);
                                        totalDailyReceive = totalDailyReceive+1;
                                        Vue.set(vm.balanceDays, line.plan_date, Number(totalDailyReceive));
                                    }
                                }
                            }
                        });
                    }
                });
            },
        },
        watch:{
            clickSelTabName : async function (value, oldValue) {
                await this.getEstData();
            },
            'tab1Input.stamp_code' : async function (value, oldValue) {
                this.tab1Input.cigarettes_code = '';
                this.dailyList = [];
            },
            'tab1Input.cigarettes_code' : async function (value, oldValue) {
                if (value) {
                    // this.getEstData();
                }
            },
            'tab3Input.stamp_code' : async function (value, oldValue) {
                // this.getEstData();
            },
            'dailyList' : async function (value, oldValue) {
                if (value.length > 0) {
                    value.forEach(function (line) {
                        let weeklyReceiveQty = line.weekly_receive_qty ? line.weekly_receive_qty : 0;
                        let receiveRollQty = line.receive_roll_qty ? line.receive_roll_qty : 0;
                        line.weekly_receive_qty = parseFloat(weeklyReceiveQty).toFixed(0)
                        line.receive_roll_qty = parseFloat(receiveRollQty).toFixed(3)
                    });
                }
            },
            // Piyawut A. 27022022
            calBalanceStampMonthly(newValue){
                return newValue;
            },
            // คงคลังเย็น
            calBalanceOnhand(newValue){
                return newValue;
            },calBalanceDays(newValue){
                return newValue;
            },
        },
        methods: {
            async addLine() {
                let vm = this;
                let cloneLine = JSON.parse(JSON.stringify(vm.adjBiweeklyData[vm.productType][vm.adjustData.current_biweekly]));
                let rowLength = Object.keys(cloneLine).length;
                    cloneLine = cloneLine[Object.keys(cloneLine)[0]];
                    cloneLine.is_new_line = true;
                    cloneLine.stamp_desc = '';
                    cloneLine.item_id = '';
                    cloneLine.item_code = '';
                    cloneLine.item_description = '';
                    cloneLine.curr_onhnad_qty = '';
                    cloneLine.def_planning_qty = '';
                    cloneLine.def_bal_sale_day = '';
                    cloneLine.def_forcast_qty = '';
                    cloneLine.def_bal_onhand_qty = '';
                    cloneLine.def_ending_sale_day = '';
                    cloneLine.bal_sale_day = '';
                    cloneLine.forcast_qty = '';
                    cloneLine.bal_onhand_qty = '';
                    cloneLine.ending_sale_day = '';


                this.$set(vm.adjBiweeklyData[vm.productType][vm.adjustData.current_biweekly], 'new-' + rowLength, cloneLine);

                this.remoteMethod(' ', vm.adjBiweeklyData[vm.productType][vm.adjustData.current_biweekly]['new-' + rowLength])
            },
            async changeInput(index, line) {
                line.weekly_receive_qty = parseFloat(line.weekly_receive_qty).toFixed(0);
                line.receive_roll_qty = parseFloat(line.receive_roll_qty).toFixed(3);


                console.log('changeInput', line.weekly_receive_qty, line.receive_roll_qty);

                let row = Object.keys(this.changeData).length;
                let data = JSON.parse(JSON.stringify(line));

                // this.$set(data, 'value', value);
                // console.log('changeInput', index, '---', data);
                this.$set(this.changeData, index, data);
                // console.log('changeInput', data.planning_qty, line.planning_qty);
                // console.log('changeInput', this.changeData['case3-' + data.item_id].value);
                console.log('changeInput', Object.keys(this.changeData).length);
            },
            async getEstData(reload = false) {
                let vm = this;
                // if (Object.keys(vm.lineWeeklyQty).length != 0 || Object.keys(vm.lineRollQty).length != 0) {
                //     vm.clickSelTabName = 'tab1';
                //     swal({
                //         title: 'บันทึกการเปลี่ยนแปลงข้อมูล',
                //         text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                //         type: "warning",
                //         html: true
                //     });
                //     return;
                // }
                vm.dailyList = [];
                // vm.tab3DailyList = [];
                vm.changeData = {};
                if (!reload) {
                    if (!vm.header) {
                        return;
                    }
                }

                // console.log('clickSelTabName', vm.clickSelTabName, 'xxx',vm.tab3Input.stamp_code);

                let stampCode = '';
                if (vm.clickSelTabName == 'tab1') {
                    stampCode = vm.tab1Input.stamp_code;
                    if (!vm.tab1Input.stamp_code && !vm.tab1Input.cigarettes_code) {
                        return;
                    }
                }

                if (vm.clickSelTabName == 'tab3') {
                    stampCode = vm.tab3Input.stamp_code;
                    if (!vm.tab3Input.stamp_code) {
                        return;
                    }
                }

                vm.loading = true;

                let params = {
                    monthly_id: vm.header.monthly_id,
                    stamp_code: stampCode,
                    cigarettes_code: vm.tab1Input.cigarettes_code,
                    tab: vm.clickSelTabName,
                };
                await axios.get(vm.url.ajax_est_data, { params })
                    .then(res => {
                        let data = res.data.data;

                        if (vm.clickSelTabName == 'tab1') {
                            vm.dailyList = data.daily_list;
                        }

                        if (vm.clickSelTabName == 'tab2') {
                            vm.tab2Html = data.tab2_html;
                        }

                        if (vm.clickSelTabName == 'tab3') {
                            vm.tab3Html = data.tab3_html;
                        }
                    })
                    .catch(err => {
                        console.log('error')
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        // vm.loading[vm.productType] = false;
                        vm.loading = false;
                    });
                return;

            },
            async saveChangeInput() {
                let vm = this;
                if (Object.keys(vm.changeData).length == 0) {
                    swal({
                        title: 'อัพเดทแผนการผลิต',
                        text: '<span style="font-size: 16px; text-align: left;"> ไม่พบข้อูลการอัพเดท </span>',
                        type: "warning",
                        html: true
                    });
                    return;
                }
                let swalConfirm = swal({
                    html: true,
                    title: 'อัพเดทแผนการผลิต ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทประมาณการจัดซื้อแสตมป์รายตรา ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btn_trans.ok.text,
                    cancelButtonText: vm.btn_trans.cancel.text,
                    // confirmButtonClass: 'btn btn-danger',
                    // cancelButtonClass: 'btn btn-white',
                    confirmButtonClass: vm.btn_trans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btn_trans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        await axios
                        .patch(vm.url.ajax_update, {
                            lines: vm.changeData
                        })
                        .then(res => {
                            if (res.data.data.status == 'S') {
                                swal({
                                    title: 'อัพเดทแผนการผลิต',
                                    text: '<span style="font-size: 16px; text-align: left;"> อัพเดทแผนประมาณการจัดซื้อแสตมป์รายตราสำเร็จ </span>',
                                    type: "success",
                                    html: true
                                });
                                vm.lineWeeklyQty = {};
                                vm.lineRollQty = {};
                                vm.getEstData(true);

                                // vm.setLastUpdateDateFormat(res.data.data.last_update_date)
                                // vm.changeData = {};
                                // if (vm.selTabName == 'tab2') {
                                //     vm.refreshTab2 = vm.refreshTab2 + 1;
                                // }
                            }

                            if (res.data.data.status != 'S' && false) {
                                swal({
                                    title: "Error !",
                                    text: res.data.data.msg,
                                    type: "error",
                                    showConfirmButton: true
                                });
                            }
                        })
                        .catch(err => {
                            let data = err.response.data;
                            alert(data.message);
                        })
                        .then(() => {
                            // swal.close();
                        });
                    }
                });
            },
            async updateEst() {
                let vm = this;
                let stampId = '';

                let result = vm.header.stamp_items_group[vm.tab1Input.stamp_code].find(o => o.cigarettes_code === vm.tab1Input.cigarettes_code)
                if(result){
                    stampId = result.stamp_id
                }

                let swalConfirm = swal({
                    html: true,
                    title: 'อัพเดทประมาณการ ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทประมาณการ ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btn_trans.ok.text,
                    cancelButtonText: vm.btn_trans.cancel.text,
                    // confirmButtonClass: 'btn btn-danger',
                    // cancelButtonClass: 'btn btn-white',
                    confirmButtonClass: vm.btn_trans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btn_trans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        await axios
                        .patch(vm.url.ajax_update_est, {
                            stamp_id: stampId
                        })
                        .then(res => {
                            if (res.data.data.status == 'S') {
                                swal({
                                    title: 'อัพเดทแผนการผลิต',
                                    text: '<span style="font-size: 16px; text-align: left;"> อัพเดทประมาณการสำเร็จ </span>',
                                    type: "success",
                                    html: true
                                });
                                vm.lineWeeklyQty = {};
                                vm.lineRollQty = {};
                                vm.getEstData(true)
                            }

                            if (res.data.data.status != 'S' && false) {
                                swal({
                                    title: "Error !",
                                    text: res.data.data.msg,
                                    type: "error",
                                    showConfirmButton: true
                                });
                            }
                        })
                        .catch(err => {
                            let data = err.response.data;
                            alert(data.message);
                        })
                        .then(() => {
                            // swal.close();
                        });
                    }
                });
            },
            async duplicate() {
                let vm = this;
                if (Object.keys(vm.lineWeeklyQty).length != 0 || Object.keys(vm.lineRollQty).length != 0) {
                    swal({
                        title: 'บันทึกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    });
                    return;
                }
                let swalConfirm = swal({
                    html: true,
                    title: 'คัดลอกแผน ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการคัดลอกแผน ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btn_trans.ok.text,
                    cancelButtonText: vm.btn_trans.cancel.text,
                    // confirmButtonClass: 'btn btn-danger',
                    // cancelButtonClass: 'btn btn-white',
                    confirmButtonClass: vm.btn_trans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btn_trans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        await axios
                        .patch(vm.url.ajax_duplicate, {})
                        .then(res => {
                            if (res.data.data.status == 'S') {
                                swal({
                                    title: 'อัพเดทแผนการผลิต',
                                    text: '<span style="font-size: 16px; text-align: left;"> คัดลอกแผนสำเร็จ </span>',
                                    type: "success",
                                    html: true
                                });
                                window.location.href = res.data.data.redirect_page;
                                // vm.getEstData(true);

                                // vm.setLastUpdateDateFormat(res.data.data.last_update_date)
                                // vm.changeData = {};
                                // if (vm.selTabName == 'tab2') {
                                //     vm.refreshTab2 = vm.refreshTab2 + 1;
                                // }
                            }

                            if (res.data.data.status != 'S' && false) {
                                swal({
                                    title: "Error !",
                                    text: res.data.data.msg,
                                    type: "error",
                                    showConfirmButton: true
                                });
                            }
                        })
                        .catch(err => {
                            let data = err.response.data;
                            alert(data.message);
                        })
                        .then(() => {
                            // swal.close();
                        });
                    }
                });
            },
            async selectItem(line) {
                let item = line.item_list.findIndex(o => o.inventory_item_id == line.item_id)
                    item = line.item_list[item];

                line.stamp = item.stamp;
                line.stamp_desc = item.stamp_desc;
                line.item_code = item.item_code;
                line.item_description = item.item_description;
                line.organization_id = item.organization_id;
                line.inventory_item_id = item.inventory_item_id;
                // category_concat_segs: "15.01"
                // category_id: "5747"
                // category_segment2: "01"
                // category_set_id: "1100000041"
                // category_set_name: "TOAT_INV_ITEM_CATEGORY_SET"
                // category_setment1: "15"
                // category_type: "IMPORT"
                // inventory_item_id: "147004"
                // item_code: "15012343"
                // item_description: "KRONG THIP 7.1 สีแดง"
                // organization_code: "A01"
                // organization_id: "164"
                // product_type: "71"
                // rn: "2"
                // stamp: null
                // stamp_desc: null
                console.log('selectItem', line.item_list, 'xx1', item, 'xx', line.item_id, line.item_code, line);

                let row = Object.keys(this.addLineData).length;
                let data = JSON.parse(JSON.stringify(line));
                this.$set(this.addLineData, 'add-' + data.item_id, data);
            },
            async remoteMethod(query, line) {
                console.log('remoteMethod');
                let vm = this;
                let params = {
                    number: query,
                    product_main_id: vm.adjustData.product_main_id,
                    product_type: vm.productType
                }
                axios.get(vm.url.ajax_search_item, { params }).then(res => {
                    let response = res.data.data
                    line['item_list'] = response['item_list'];
                });
                // row[inputName] = [];

                // let line = _.clone(row);
                //     line.casing_leaf_formula_list = [];
                //     line.casing_list = [];
                // if (query !== "") {
                //     // this.getData({
                //     //     number: query,
                //     //     header: this.header,
                //     //     line: line,
                //     //     type: inputName
                //     // }, row, inputName);
                // }
            },
            delLine(line, index) {
                let vm = this;
                vm.$delete(vm.adjBiweeklyData[vm.productType][vm.adjustData.current_biweekly], index);

                vm.$delete(vm.changeData, 'case3-' + line.item_id);
                vm.$delete(vm.addLineData, 'add-' + line.item_id );
            },
            async checkApprove() {
                let vm = this;
                if (!vm.canApprove) { return }

                    await axios
                    .get(vm.url.ajax_check_approve)
                    .then(res => {
                        if (res.data.data.status == 'S') {
                            swal({
                                html: true,
                                title: 'อนุมัติประมาณการจัดซื้อแสตมป์รายเดือน',
                                text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอนุมัติประมาณการจัดซื้อแสตมป์รายเดือน ? </span></h2>',
                                showCancelButton: true,
                                confirmButtonText: vm.btn_trans.ok.text,
                                cancelButtonText: vm.btn_trans.cancel.text,
                                // confirmButtonClass: 'btn btn-danger',
                                // cancelButtonClass: 'btn btn-white',
                                confirmButtonClass: vm.btn_trans.ok.class + ' btn-lg tw-w-25',
                                cancelButtonClass: vm.btn_trans.cancel.class + ' btn-lg tw-w-25',
                                closeOnConfirm: false,
                                closeOnCancel: true,
                                showLoaderOnConfirm: true
                            },
                            async function(isConfirm){
                                if (isConfirm) {
                                    vm.approve();
                                }
                            });

                        } else {
                            swal({
                                title: 'อนุมัตปรับประมาณการผลิตประจำปักษ์',
                                text: res.data.data.msg,
                                // type: "warning",
                                html: true,
                                showCancelButton: true,
                                confirmButtonText: vm.btn_trans.ok.text,
                                cancelButtonText: vm.btn_trans.cancel.text,
                                // confirmButtonClass: 'btn btn-danger',
                                // cancelButtonClass: 'btn btn-white',
                                confirmButtonClass: vm.btn_trans.ok.class + ' btn-lg tw-w-25',
                                cancelButtonClass: vm.btn_trans.cancel.class + ' btn-lg tw-w-25',
                                closeOnConfirm: false,
                                closeOnCancel: true,
                                showLoaderOnConfirm: true
                            },async function(isConfirm){
                                if (isConfirm) {
                                    console.log('Approve');
                                    vm.approve();
                                }
                            });
                        }
                    })
                    .catch(err => {
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        // vm.loading.approveProcess = false;
                        // swal.close();
                    });

            },
            async approve() {
                let vm = this;

                await axios
                .patch(vm.url.ajax_approve)
                .then(res => {
                    if (res.data.data.status == 'S') {
                        swal({
                            title: 'อนุมัติประมาณการจัดซื้อแสตมป์รายเดือน',
                            text: '<span style="font-size: 16px; text-align: left;"> อนุมัติประมาณการจัดซื้อแสตมป์รายเดือนเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                        vm.canEdit = false;
                        vm.canApprove = false;

                        vm.header = res.data.data.header;
                        window.location.href = res.data.data.redirect_page;
                    }

                    if (res.data.data.status != 'S') {
                        swal({
                            title: "Error !",
                            text: res.data.data.msg,
                            type: "error",
                            showConfirmButton: true
                        });
                    }
                })
                .catch(err => {
                    let data = err.response.data;
                    alert(data.message);
                })
                .then(() => {
                    // swal.close();
                });
            },
        }
    }
</script>
<style scope>

</style>