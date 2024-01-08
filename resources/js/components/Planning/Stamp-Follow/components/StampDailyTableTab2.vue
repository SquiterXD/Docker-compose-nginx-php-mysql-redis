<template>
    <div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;">
                           <div> วันที่ </div> 
                        </th>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;">
                           <div> คงคลังเช้า <br> (ดวง) </div>
                        </th>
                        <th colspan="3" class="text-center" style="vertical-align: middle;">
                            <div> รับเข้า </div>
                        </th>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;">
                            <div> รับแสตมป์เคลม </div>
                        </th>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;">
                            <div> ใช้จริง <br> (ดวง) </div>
                        </th>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;">
                            <div> สูญหาย <br> (ดวง) </div>
                        </th>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;">
                            <div> เสียหาย <br> (ดวง) </div>
                        </th>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;">
                            <div> ไม่สมบูรณ์ <br> (ดวง) </div>
                        </th>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;">
                            <div> รวมใช้จริง <br> (ดวง) </div>
                        </th>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;">
                            <div> ประมาณการใช้ <br> (ดวง) </div>
                        </th>
                        <th colspan="2" class="text-center" style="vertical-align: middle;">
                            <div> คงคลัง (ดวง) </div>
                        </th>
                        <th colspan="2" class="text-center" style="vertical-align: middle;">
                            <div> รวมคงคลังเย็น </div>
                        </th>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;">
                            <div> พอใช้ <br> (วัน) </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="text-center" style="vertical-align: middle;">
                            <div> ดวง </div>
                        </th>
                        <th class="text-center" style="vertical-align: middle;">
                            <div> ม้วน </div>
                        </th>
                        <th class="text-center" style="vertical-align: middle;">
                            <div> จำนวนเงิน </div>
                        </th>
                        <th class="text-center" style="vertical-align: middle;">
                            <div> ฝ่ายโรงงาน </div>
                        </th>
                        <th class="text-center" style="vertical-align: middle;">
                            <div> กองคลัง </div>
                        </th>
                        <th class="text-center" style="vertical-align: middle;">
                            <div> ดวง </div>
                        </th>
                        <th class="text-center" style="vertical-align: middle;">
                            <div> ม้วน </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="lines.length <= 0">
                        <tr>
                            <td colspan="17" class="text-center" style="vertical-align: middle;">
                                <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <template v-for="(line, index) in lines">
                            <tr :style="line.holiday_flag == 'Y'? 'background-color: #cccccc;'
                                        : (line.holiday_flag == 'P'? 'background-color: #878788;': '')">
                                <td class="text-center" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 80px;"> {{ line.follow_date_format }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.onhand_qty | number2Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB;' : ''" @click="selDailyDate(line.follow_date_format)">
                                    <!-- <receive-weekly
                                        style="width: 130px;"
                                        :stamp="stamp"
                                        :line="line"
                                        :edit-flag="edit_flag"
                                        :line-weekly-daily-edit="lineWeeklyDailyEdit"
                                    ></receive-weekly> -->
                                    <div style="width: 100px;"> {{ line.weekly_receive_qty | number2Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB;' : ''" @click="selDailyDate(line.follow_date_format)">
                                    <!-- <receive-roll
                                        style="width: 130px;"
                                        :stamp="stamp"
                                        :line="line"
                                        :edit-flag="edit_flag"
                                        :line-roll-daily-edit="lineRollDailyEdit"
                                    ></receive-roll> -->
                                    <div style="width: 100px;"> {{ line.receive_roll_qty | number2Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                   <div style="width: 130px;"> {{ line.receipt_amount | number2Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.claim_receive_qty | number0Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.issue_qty | number0Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.lost_qty | number0Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.damaged_qty | number0Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.incompleted_qty | number0Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.total_issue_qty | number0Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.total_daily_qty | number0Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.factory_bal_onhand_qty | number0Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.inventory_bal_onhand_qty | number0Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.total_bal_onhand_qty | number0Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.bal_onhand_qty | number2Digit }} </div>
                                </td>
                                <td class="text-right" :style="sel_daily == line.follow_date_format? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selDailyDate(line.follow_date_format)">
                                    <div style="width: 100px;"> {{ line.bal_days | number2Digit }} </div>
                                </td>
                            </tr>
                        </template>
                        <tr>
                            <td class="text-right" colspan="2" style="vertical-align: middle;">
                                <strong> รวม </strong>
                            </td>
                            <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ quantity.weekly_receive | number2Digit }}
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ quantity.roll_receive | number2Digit }}
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ quantity.total_receive | number2Digit }}
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ quantity.claim_receive | number0Digit }}
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ quantity.issue_receive | number0Digit }}
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ quantity.lost_receive | number0Digit }}
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ quantity.damaged_receive | number0Digit }}
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ quantity.incompleted_receive | number0Digit }}
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ quantity.total_issue_receive | number0Digit }}
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ quantity.total_daily_receive | number0Digit }}
                                </div>
                            </td>
                            <td class="text-right" colspan="6" style="vertical-align: middle; background-color: #b3b5b4;"> </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import ReceiveWeekly from './ReceiveWeekly.vue';
    import ReceiveRoll from './ReceiveRoll.vue';
    import moment from "moment";
    export default {
        components: {
            ReceiveWeekly, ReceiveRoll
        },
        props:[
            'header', 'stamp', 'btnTrans', 'url', 'summaryData'
        ],
        data() {
            return {
                loading: false,
                lines: this.summaryData,
                edit_flag: false,
                valid: false,
                sel_daily: '',
                lineWeeklyDailyEdit: {},
                lineRollDailyEdit: {},
                onhandQuantity: {},
                balanceQuantity: {}, // พอใช้
                // คงคลังเย็น (ดวง-ม้วน)
                // balanceOnhandWeekly: {},
                // balanceOnhandRoll: {},
                quantity: {
                    weekly_receive: 0,
                    roll_receive: 0,
                    total_receive: 0,
                    claim_receive: 0,
                    issue_receive: 0,
                    lost_receive: 0,
                    damaged_receive: 0,
                    incompleted_receive: 0,
                    total_issue_receive: 0,
                    total_daily_receive: 0,
                    factory_bal_onhand_qty: 0
                },
                canEdit: false,
            }
        },
        mounted() {
            // this.checkCanEdit();
        },
        computed: {
            weeklyReceive() {
                return this.lines.reduce((accumulator, line) => {
                    this.quantity.weekly_receive = accumulator + parseFloat(line.weekly_receive_qty);
                    return accumulator + Number(line.weekly_receive_qty);
                }, 0);
            },
            rollReceive() {
                return this.lines.reduce((accumulator, line) => {
                    this.quantity.roll_receive = accumulator + Number(line.receive_roll_qty);
                    return accumulator + Number(line.receive_roll_qty);
                }, 0);
            },
            totalReceive() {
                return this.lines.reduce((accumulator, line) => {
                    this.quantity.total_receive = accumulator + Number(line.receipt_amount);
                    return accumulator + Number(line.receipt_amount);
                }, 0);
            },
            claimReceive() {
                return this.lines.reduce((accumulator, line) => {
                    this.quantity.claim_receive = accumulator + Number(line.claim_receive_qty);
                    return accumulator + Number(line.claim_receive_qty);
                }, 0);
            },
            issueReceive() {
                return this.lines.reduce((accumulator, line) => {
                    this.quantity.issue_receive = accumulator + Number(line.issue_qty);
                    return accumulator + Number(line.issue_qty);
                }, 0);
            },
            lostReceive() {
                return this.lines.reduce((accumulator, line) => {
                    this.quantity.lost_receive = accumulator + Number(line.lost_qty);
                    return accumulator + Number(line.lost_qty);
                }, 0);
            },
            damagedReceive() {
                return this.lines.reduce((accumulator, line) => {
                    this.quantity.damaged_receive = accumulator + Number(line.damaged_qty);
                    return accumulator + Number(line.damaged_qty);
                }, 0);
            },
            incompletedReceive() {
                return this.lines.reduce((accumulator, line) => {
                    this.quantity.incompleted_receive = accumulator + Number(line.incompleted_qty);
                    return accumulator + Number(line.incompleted_qty);
                }, 0);
            },
            totalIssueReceive() {
                return this.lines.reduce((accumulator, line) => {
                    this.quantity.total_issue_receive = accumulator + Number(line.total_issue_qty);
                    return accumulator + Number(line.total_issue_qty);
                }, 0);
            },
            totalDailyReceive() {
                return this.lines.reduce((accumulator, line) => {
                    this.quantity.total_daily_receive = accumulator + Number(line.total_daily_qty);
                    return accumulator + Number(line.total_daily_qty);
                }, 0);
            },
            totalOnhandFactoryA13() {
                return this.lines.reduce((accumulator, line) => {
                    this.quantity.factory_bal_onhand_qty = accumulator + Number(line.factory_bal_onhand_qty);
                    return accumulator + Number(line.factory_bal_onhand_qty);
                }, 0);
            },
            // -- Calculate when edit roll/weekly quantity
            // calBalanceStampDaily() {
            //     var vm = this;
            //     //efficiency_product
            //     vm.lines.filter(function(line, index) {
            //         let b = 0;
            //         let c = 0;
            //         let i = 0; // mean onhand qty (value: คงคลังเช้า)
            //         let bal_days = 0;
            //         let first_date = moment(line.follow_date).format('YYYY-MM-DD');
            //         // calculate
            //         b = (Number(line.onhand_qty) + Number(line.weekly_receive_qty)) - Number(line.total_daily_qty);
            //         Vue.set(vm.balanceQuantity, line.follow_date, Number(bal_days));
            //         if (index > 0) {
            //             // Check Onhand Quantity
            //             var onhand = vm.onhandQuantity[vm.lines[index-1].follow_date]? vm.onhandQuantity[vm.lines[index-1].follow_date]: line.onhand_qty;
            //             i = (Number(onhand) + Number(vm.lines[index-1].weekly_receive_qty)) - Number(vm.lines[index-1].total_daily_qty);
            //             // i = (Number(vm.lines[index-1].onhand_qty) + Number(vm.lines[index-1].weekly_receive_qty)) - Number(vm.lines[index-1].total_daily_qty);
            //             // อัพเดตคงคลังเช้าใหม่ (คงคลังเช้า) โดยคำนวณค่าย้อนหลังวันปัจจุบันไปหนึ่งวัน
            //             Vue.set(vm.onhandQuantity, line.follow_date, Number(i));
            //         }
            //         if (b >= 0) {
            //             bal_days = 1;
            //             Vue.set(vm.balanceQuantity, line.follow_date, Number(bal_days));
            //             vm.lines.filter(function(line2, index2) {
            //                 let last_date = moment(line2.follow_date).format('YYYY-MM-DD');
            //                 if (last_date >= first_date) {
            //                     if (index2+1 < vm.lines.length) {
            //                         if (c == 0) {
            //                             c = Number(b) - Number(vm.lines[index2+1].total_daily_qty);
            //                         }else{
            //                             c = Number(c) - Number(vm.lines[index2+1].total_daily_qty);
            //                         }
            //                         // check count for balance day
            //                         if (Number(c) >= 0) {
            //                             bal_days = bal_days+1;
            //                             Vue.set(vm.balanceQuantity, line.follow_date, Number(bal_days));
            //                         }
            //                     }
            //                 }
            //             });
            //         }
            //     });
            // },
            // คงคลังเย็น
            // calBalanceOnhand() {
            //     var vm = this;
            //     //current date
            //     var curr_date = moment().format('YYYY-MM-DD');
            //     vm.lines.filter(function(line, index) {
            //         let follow_date =  moment(line.follow_date).format('YYYY-MM-DD');
            //         // calculate balance onhand weekly-roll
            //         var onhandQuantity = 0;
            //         var WeeklyQuantity = 0;
            //         var balOnhWeekly = 0;
            //         var balOnhroll = 0;
            //         if (follow_date >= curr_date) {
            //             // Weekly
            //             onhandQuantity = vm.onhandQuantity[line.follow_date]? vm.onhandQuantity[line.follow_date]: line.onhand_qty;
            //             WeeklyQuantity = vm.lineWeeklyDailyEdit[line.follow_date]? vm.lineWeeklyDailyEdit[line.follow_date]: line.weekly_receive_qty;
            //             // balOnhWeekly = (onhandQuantity + WeeklyQuantity) - line.total_daily_qty;
            //             // Roll
            //             balOnhroll = onhandQuantity / vm.stamp.stamp_per_roll;
            //             balOnhroll = balOnhroll? balOnhroll: 0;
            //             // Result
            //             Vue.set(vm.balanceOnhandWeekly, line.follow_date, Number(onhandQuantity));
            //             Vue.set(vm.balanceOnhandRoll, line.follow_date, Number(balOnhroll).toFixed(2));
            //         }else{
            //             // Weekly
            //             balOnhWeekly = vm.quantity.factory_bal_onhand_qty + line.inventory_bal_onhand_qty;
            //             // Roll
            //             balOnhroll = balOnhWeekly / vm.stamp.unit_price;
            //             balOnhroll = balOnhroll? balOnhroll: 0;
            //             // Result
            //             Vue.set(vm.balanceOnhandWeekly, line.follow_date, Number(balOnhWeekly));
            //             Vue.set(vm.balanceOnhandRoll, line.follow_date, Number(balOnhroll).toFixed(2));
            //         }
            //     });
            // },
        },
        watch: {
            'edit_flag': function(newValue) {
                if (newValue == false) {
                    this.lineWeeklyDailyEdit = {};
                    this.lineRollDailyEdit = {};
                }
            },
            weeklyReceive(newValue){
                return newValue;
            },
            rollReceive(newValue){
                return newValue;
            },
            totalReceive(newValue){
                return newValue;
            },
            claimReceive(newValue){
                return newValue;
            },
            issueReceive(newValue){
                return newValue;
            },
            lostReceive(newValue){
                return newValue;
            },
            damagedReceive(newValue){
                return newValue;
            },
            incompletedReceive(newValue){
                return newValue;
            },
            totalIssueReceive(newValue){
                return newValue;
            },
            totalDailyReceive(newValue){
                return newValue;
            },
            totalOnhandFactoryA13(newValue){
                return newValue;
            },
            calBalanceStampDaily(newValue){
                return newValue;
            },
            // คงคลังเย็น
            calBalanceOnhand(newValue){
                return newValue;
            },
        },
        methods: {
            decimal(number) {
                return Number(number).toLocaleString(undefined, { minimumFractionDigits: 2 });
            },
            formatNumber(number) {
                return Number(number).toLocaleString(undefined);
            },
            selDailyDate(dailyDate){
                this.sel_daily = dailyDate;
            },
            changeStampData(){
                this.valid = this.edit_flag = !this.edit_flag;
                this.$emit("validAction", this.valid);
            },
            async saveChangeInput() {
                let vm = this;
                let urlUpdate = vm.url.ajax_store+'/'+vm.header.follow_stamp_main_id;
                if (Object.keys(vm.lineWeeklyDailyEdit).length == 0 && Object.keys(vm.lineRollDailyEdit).length == 0) {
                    swal({
                        title: 'อัพเดทการติดตามการใช้แสตมป์รายวัน',
                        text: '<span style="font-size: 16px; text-align: left;"> ไม่พบข้อมูลการอัพเดทการติดตามการใช้แสตมป์รายวัน </span>',
                        type: "warning",
                        html: true
                    });
                    return;
                }
                let swalConfirm = swal({
                    html: true,
                    title: 'อัพเดทการติดตามการใช้แสตมป์รายวัน ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทการติดตามการใช้แสตมป์รายวัน ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        vm.loading = true;
                        vm.valid = false;
                        await axios
                        .patch(urlUpdate, {
                            lines: vm.lines,
                            lineWeeklyDaily: vm.lineWeeklyDailyEdit,
                            lineRollDaily: vm.lineRollDailyEdit,
                        })
                        .then(res => {
                            if (res.data.data.status == 'S') {
                                vm.lineWeeklyDailyEdit = {};
                                vm.lineRollDailyEdit = {};
                                // vm.$emit("updateLines", 'S');
                                vm.$emit("updateStamp", {
                                    status: 'S',
                                    stamp_main: res.data.data.header,
                                    valid_action: vm.valid
                                });
                                swal({
                                    title: 'อัพเดทการติดตามการใช้แสตมป์รายวัน',
                                    text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                                    type: "success",
                                    html: true
                                });
                            }else{
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: '<span style="font-size: 15px; text-align: left;">'+res.data.data.msg+'</span>',
                                    type: "warning",
                                    html: true
                                });
                            }
                            // window.setTimeout(function() {
                            //     window.location.href = res.data.data.redirect_page;
                            // }, 500);
                            vm.edit_flag = false;
                        })
                        .catch(err => {
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 15px; text-align: left;">'+err.response+'</span>',
                                type: "warning",
                                html: true
                            });
                        })
                        .then(() => {
                            vm.loading = false;
                        });
                    }
                });
            },
            checkCanEdit(){
                let follow_date = moment(this.lines[this.lines.length -1].follow_date).format('YYYY-MM-DD');
                let curr_date = moment().format('YYYY-MM-DD');
                if (follow_date > curr_date) {
                    this.canEdit = true;
                }
            },
        },
    }
</script>