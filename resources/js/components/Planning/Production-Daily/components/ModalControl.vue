<template>
    <span>
        <button v-if="canEdit && !isControlDisable" 
            type="button" @click="openModal" :class="btnTrans.edit.class + ' btn-lg tw-w-25 mt-3'" >
            <i :class="btnTrans.edit.icon"></i>
            <!-- {{ btnTrans.edit.text }} --> สร้างและแก้ไขแผน
        </button>

        <div class="modal fade" id="modal_control" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg"><!--  style="width: 90%; max-width:950px;" -->
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            แผนการผลิตรายวัน
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" @click.prevent="cancel()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left">
                        <form id="production-plan-control-form">
                            <div class="row col-12 m-0">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> วันที่ :</label>
                                    <div class="input-group">
                                        <datepicker-th
                                            style="width: 100%;"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            name="start_date"
                                            id="start_date"
                                            placeholder="โปรดเลือกวันที่"
                                            :value="input_date_from"
                                            v-model="input_date_from"
                                            format="DD-MMM-YYYY"
                                            :disabled="isDisableSelDate"
                                            @dateWasSelected="dateWasSelectedFrom"
                                        />
                                    </div>
                                    <div id="el_explode_start_date" class="error_msg text-left"></div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> ถึง :</label>
                                    <div class="input-group">
                                        <datepicker-th
                                            style="width: 100%;"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            name="end_date"
                                            id="end_date"
                                            placeholder="โปรดเลือกวันที่"
                                            :value="input_date_to"
                                            v-model="input_date_to"
                                            format="DD-MMM-YYYY"
                                            :disabled="isDisableSelDate"
                                            :disabled-date-to="input_date_from"
                                            @dateWasSelected="dateWasSelectedTo"
                                        />
                                    </div>
                                    <div id="el_explode_end_date" class="error_msg text-left"></div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> ขอบเขตเครื่องจักร :</label>
                                    <div class="input-group">
                                        <el-select v-model="machine_group" size="large" placeholder="ขอบเขตเครื่องจักร" @change="selMachine" clearable filterable style="width: 100%;" ref="machine_group" :popper-append-to-body="false">
                                            <el-option
                                               v-for="(machine, index) in machineLists"
                                                :key="index"
                                                :label="machine.machine_group_description"
                                                :value="machine.machine_group"
                                            >
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_machine_group" class="error_msg text-left"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-12 m-0 mt-1 text-left">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> รายละเอียดเครื่องจักร :</label>
                                    <div class="input-group">
                                        <template v-for="machine in machineDescLists">
                                            <span class="label p-2 mr-2" style="background-color:#f2f3f3;">
                                                {{ machine.machine_description }}
                                            </span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-0 mt-2 text-right">
                                <!-- <div class="col-lg-6"> </div> -->
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-2"> กำลังผลิตสูงสุด (ล้านมวน) :</label>
                                    <div class="text-center">
                                        <span v-if="eff_loading" v-html="html"></span>
                                        <span v-else>
                                            <strong style="font-size: 20px;"> {{ efficiencyProductHeader | number2Digit }} </strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-2"> เหลือกำลังผลิต (ล้านมวน) :</label>
                                    <div class="text-center">
                                        <span v-if="eff_loading" v-html="html"></span>
                                        <span v-else>
                                            <strong style="font-size: 20px;">
                                                {{ balanceEfficient | number2Digit }}
                                            </strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <!-- table add item -->
                            <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"> </th>
                                    <th width="5%" class="text-center"> ลำดับ </th>
                                    <th width="30%" class="text-center"> รหัสบุหรี่ </th>
                                    <!-- <th width="30%"> ตราบุหรี่ </th> -->
                                    <th width="15%" class="text-center"> ปริมาณที่สั่งผลิต (ล้านมวน) </th>
                                    <th width="5%"> </th>
                                </tr>
                            </thead>
                            <!-- <tbody> -->
                                <draggable :list="itemLines" :options="{animation:200, handle:'.my-handle'}" :element="'tbody'">
                                    <ListItem
                                        v-for="(row, index) in itemLines"
                                        :key = "row.id"
                                        :attribute = "row"
                                        :index = "index"
                                        :list-item-cigarettes = "listItemCigarettes"
                                        :listItemLines="itemLines"
                                        @removeRow = "removeLine"
                                    ></ListItem>
                                </draggable>
                                <tr v-if="itemLines.length > 0">
                                    <th colspan="3" style="font-size: 15px; color: #676a6c;" class="text-right">
                                        <span> รวมปริมาณสั่งผลิต </span>
                                    </th>
                                    <th style="font-size: 15px; color: #676a6c;" class="text-right">
                                        <span> {{ totalApplyEfficient | number2Digit }} </span>
                                    </th>
                                    <th></th>
                                </tr>
                            <!-- </tbody> -->
                        </table>
                        <button class="btn btn-sm btn-block btn-primary" type="button" @click="addItemLine">
                            <i class="fa fa-plus-square"></i>&nbsp; เพิ่มรายการ
                        </button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <!-- <button v-if="itemLines" type="button" :class="btnTrans.create.class + ' btn-lg tw-w-25'">
                            ตกลง
                        </button> -->
                        <button type="button" @click.prevent="submit()" :class="btnTrans.create.class + ' btn-lg tw-w-25'">
                            ตกลง
                        </button>
                        <button type="button" class="btn btn-white btn-lg tw-w-25'" data-dismiss="modal" @click.prevent="cancel()"> ยกเลิก </button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script>
    import ListItem from './List.vue';
    import uuidv1 from 'uuid/v1';
    import moment from "moment";
    import draggable from "vuedraggable";
    export default {
        components: {
            ListItem
        },
        props:["machineBiweekly", "productDailyPlan", 'modalControlInput', "dBudgetYear", "dMonth", "dBiWeekly", "productType", "dateFormat", "btnTrans", "url", "itemProductionMain", "isControlDisable"],
        data() {
            return {
                loading: false,
                eff_loading: false,
                // biWeekly Date
                biweekly_date_from: '', biweekly_date_to: '', current_date: '', next_date: '',
                // Input Date
                input_date_from: '', input_date_to: '',
                // Check Date
                checkDate: {
                    biweekly_date_from: '', biweekly_date_to: ''
                    , current_date: '', next_date: ''
                    , input_date_from: '', input_date_to: ''
                },
                machine_group: '',
                efficiencyProductHeader: 0,
                totalApplyEfficient: 0,
                balanceEfficient: 0,
                errors: {
                    budget_year: false,
                    month: false,
                    bi_weekly: false,
                    start_date: false,
                    end_date: false,
                    machine_group: false
                },
                machineLists: this.modalControlInput.machines,
                machineLines: [],
                listItemCigarettes: [], //list item
                itemLines: [], //push arr data item
                removeItemLines: [], //push arr data remove item
                html: '',
                canEdit: true,
                isDisableSelDate: false,
                machineDescLists: [],
                machine_desc:'',
            }
        },
        mounted() {
            this.sortMachine();
            this.selItemCigarette();
            if (this.productDailyPlan != undefined && this.productDailyPlan != '') {
                this.canEdit = this.productDailyPlan.can.edit;
            }
        },
        computed: {
            totalApply() {
                return this.itemLines.reduce((accumulator, line) => {
                    let item_efficiency = line.item_efficiency == '' || line.item_efficiency == null? 0: line.item_efficiency;
                    this.totalApplyEfficient = accumulator + parseFloat(item_efficiency);
                    this.balanceEfficient = Number(this.efficiencyProductHeader) - Number(this.totalApplyEfficient).toFixed(2);
                    if (this.machine_group == '' || this.machine_group == null) {this.balanceEfficient = 0;}
                    return accumulator + parseFloat(item_efficiency);
                }, 0);
            },
            dailyPlan : async function (value, oldValue) {
                if (this.productDailyPlan != undefined && this.productDailyPlan != '') {
                    this.canEdit = this.productDailyPlan.can.edit;
                }else{
                    this.canEdit = true;
                }
            },
        },
        watch:{
            totalApply(newVal) {
                this.totalApplyEfficient = Number(newVal).toFixed(2);
                return newVal;
            },
            productType : async function (value, oldValue) {
                this.sortMachine();
                this.selItemCigarette();
                if (this.productDailyPlan != undefined && this.productDailyPlan != '') {
                    this.canEdit = this.productDailyPlan.can.edit;
                }else{
                    this.canEdit = true;
                }
            },
            dailyPlan(newVal) {
                return newVal;
            },
            errors: {
                handler(val){
                    // val.start_date? this.setError('start_date') : this.resetError('start_date');
                    // val.end_date? this.setError('end_date') : this.resetError('end_date');
                    // val.machine_group? this.setError('machine_group') : this.resetError('machine_group');
                },
                deep: true,
            },
        },
        methods: {
            decimal(number) {
                return Number(number).toLocaleString(undefined, { minimumFractionDigits: 2 });
            },
            openModal() {
                let vm = this;
                let form = $('#plan-daily-form');
                let valid = true;
                let errorMsg = '';
                vm.errors.budget_year = false;
                vm.errors.month = false;
                vm.errors.bi_weekly = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");
                if (vm.dBudgetYear == ''){
                    vm.errors.budget_year = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปีงบประมาณ";
                    $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }
                if (vm.dMonth == ''){
                    vm.errors.month = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกเดือน";
                    $(form).find("div[id='el_explode_month']").html(errorMsg);
                }
                if (vm.dBiWeekly == ''){
                    vm.errors.bi_weekly = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปักษ์";
                    $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
                }
                this.$emit("errorRef", {err: this.errors});
                if (!valid) {
                    return;
                }
                this.getDateByBiWeekly();
                $('#modal_control').modal('show');
            },
            addItemLine() {
                this.itemLines.push({
                    id: uuidv1(),
                    line_number: '',
                    item_id: '',
                    item_code: '',
                    item_description: '',
                    item_efficiency: '',
                    is_enable: false
                });
            },
            sortMachine(){
                this.machineLists = this.modalControlInput.machines.filter(item => {
                    return item.product_type == this.productType;
                });
            },
            selMachine(){
                let form = $('#production-plan-control-form');
                this.itemLines = [];
                this.machineDescLists = [];
                this.efficiencyProductHeader = 0;
                this.totalApplyEfficient = 0;
                this.balanceEfficient = 0;
                this.errors.machine_group = false;
                $(form).find("div[id='el_explode_machine_group']").html("");
                if (this.machine_group == '' || this.machine_group == null) {
                    this.machineDescLists = [];
                    return this.efficiencyProductHeader = 0;
                }
                // New Requirement 231102021 filter machine_desc
                this.machineDescLists = this.modalControlInput.machine_desc.filter(item => {
                    return item.machine_group == this.machine_group;
                });
                // get grp_efficiency_product when choose machine group
                this.grpEfficiencyProduct();
            },
            selItemCigarette(){
                Object.values(this.itemProductionMain).filter(itemMain => {
                    this.modalControlInput.itemCigarette.filter(item => {
                        if (item.item_code == itemMain && item.product_type == this.productType) {
                            this.listItemCigarettes.push(item);
                        }
                    });
                });
            },
            dateWasSelectedFrom(dateFrom){
                let form = $('#production-plan-control-form');
                this.errors.start_date = false;
                $(form).find("div[id='el_explode_start_date']").html("");
                this.machine_group = '';
                this.itemLines = [];
                this.efficiencyProductHeader = 0;
                this.balanceEfficient = 0;
                this.input_date_from = dateFrom? moment(dateFrom).format(this.dateFormat): '';
                let input_date_from = moment(dateFrom).format('YYYY-MM-DD');
                input_date_from = this.changeThToEn(input_date_from);
                this.checkDate.input_date_from = input_date_from;
            },
            dateWasSelectedTo(dateTo){
                let form = $('#production-plan-control-form');
                this.errors.end_date = false;
                $(form).find("div[id='el_explode_end_date']").html("");
                this.machine_group = '';
                this.itemLines = [];
                this.efficiencyProductHeader = 0;
                this.balanceEfficient = 0;
                this.input_date_to = dateTo? moment(dateTo).format(this.dateFormat): '';
                let input_date_to = moment(dateTo).format('YYYY-MM-DD');
                input_date_to = this.changeThToEn(input_date_to);
                this.checkDate.input_date_to = input_date_to;
            },
            removeLine(itemLine) {
                console.log(itemLine);
                this.itemLines = this.itemLines.filter( item => {
                    return item.id != itemLine.id
                });
                // When remove item will minus total
                this.totalApplyEfficient = this.totalApplyEfficient.toFixed(2) - itemLine.item_efficiency;
                this.balanceEfficient = this.balanceEfficient + itemLine.item_efficiency;
                // แสตมป์ข้อมูล Item ที่ลบไป และต้องมีใน Table : machines
                // this.productDailyPlan.machines.filter( item => {
                //     if (item.item_code == itemLine.item_code) {
                        this.removeItemLines.push(itemLine);
                //     }
                // });
            },
            async submit(){
                let vm = this;
                let form = $('#production-plan-control-form');
                var valid = true;
                var msg = '';
                vm.loading = true;
                vm.errors.start_date = false;
                vm.errors.end_date = false;
                vm.errors.machine_group = false;
                $(form).find("div[id='el_explode_start_date']").html("");
                $(form).find("div[id='el_explode_end_date']").html("");
                $(form).find("div[id='el_explode_machine_group']").html("");
                // Validate input
                if (vm.input_date_from == ''){
                    vm.errors.start_date = true;
                    valid = false;
                    vm.loading = false;
                    msg = "กรุณาเลือกวันที่เริ่ม";
                    $(form).find("div[id='el_explode_start_date']").html(msg);
                }
                if (vm.input_date_to == ''){
                    vm.errors.end_date = true;
                    valid = false;
                    vm.loading = false;
                    msg = "กรุณาเลือกวันที่สิ้นสุด";
                    $(form).find("div[id='el_explode_end_date']").html(msg);
                }
                if (vm.machine_group == ''){
                    vm.errors.machine_group = true;
                    valid = false;
                    vm.loading = false;
                    msg = "กรุณาเลือกขอบเขตเครื่องจักร";
                    $(form).find("div[id='el_explode_machine_group']").html(msg);
                }
                if (vm.checkDate.next_date > vm.checkDate.input_date_from
                        || vm.checkDate.next_date > vm.checkDate.input_date_to){
                    msg = 'ไม่สามารถทำการสร้างและปรับข้อมูลแผนการผลิตรายวันได้ <br> เนื่องจากไม่สามารถปรับวันที่ย้อนหลังได้'
                    valid = false;
                    vm.loading = false;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                        type: "error",
                        html: true
                    });
                }
                if (!valid) {
                    return;
                }
                // Validate Data
                if (Number(vm.totalApplyEfficient).toFixed(2) > vm.efficiencyProductHeader) {
                    msg = 'ไม่สามารถทำการสร้างและปรับข้อมูลแผนการผลิตรายวันได้ เนื่องจากปริมาณสั่งผลิตเกินจำนวนที่กำหนดไว้'
                    valid = false;
                    vm.loading = false;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                        type: "error",
                        html: true
                    });
                }else if(vm.checkDate.input_date_from < vm.checkDate.biweekly_date_from
                        || vm.checkDate.input_date_to > vm.checkDate.biweekly_date_to ){
                    msg = 'ช่วงวันที่ที่เลือกไม่อยู่ในช่วงวันที่ของปักษ์ <br> ควรระบุในช่วงวันที่ '+vm.biweekly_date_from+' ถึง '+vm.biweekly_date_to
                    valid = false;
                    vm.loading = false;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                        type: "error",
                        html: true
                    });
                }
                // Validate value: null in array
                if (vm.itemLines.length) {
                    vm.itemLines.filter((item, index) => {
                        if (item.item_code == '' || item.item_code == null) {
                            msg = 'กรุณากรอกข้อมูลรหัสบุหรี่ให้ครบ'
                            valid = false;
                            vm.loading = false;
                            swal({
                                title: 'ตรวจสอบข้อมูล',
                                text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                                type: "warning",
                                html: true
                            });
                        }

                        if(item.item_efficiency == 0){
                            var i = Number(index)+1;
                            msg = 'รายการที่ '+ i + ' จำนวนปริมาณที่สั่งผลิตเป็น 0 กรุณาตรวจสอบ';
                            valid = false;
                            vm.loading = false;
                            swal({
                                title: 'ตรวจสอบข้อมูล',
                                text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                                type: "warning",
                                html: true
                            });
                        }
                    });
                }
                if (!valid) {
                    return;
                }

                let res = await this.create();
                vm.loading = false;
                if(res.status == 'S'){
                    vm.loading = false;
                    vm.removeItemLines = [];
                    vm.loopDataItemLines();
                    swal({
                        title: 'สร้างและปรับแผนการผลิตรายวัน',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างและปรับข้อมูลแผนการผลิตรายวันเรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    vm.$emit("fetchDataP07", true);

                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "error",
                        html: true
                    });
                }
            },
            async create() {
                let vm2 = this;
                let data = {
                    msg: ''
                };
                let params = {
                    budget_year: vm2.dBudgetYear,
                    // month: vm2.dMonth,
                    bi_weekly: vm2.dBiWeekly,
                    product_type: vm2.productType,
                    // product_main: vm2.machineBiweekly,
                    date_from: vm2.input_date_from,
                    date_to: vm2.input_date_to,
                    machine_group: vm2.machine_group,
                    // efficiency_product: Number(vm2.efficiencyProductHeader).toFixed(2),
                    efficiency_product: Number(vm2.efficiencyProductHeader),
                    items: vm2.itemLines,
                    removeItems : vm2.removeItemLines
                };
                await axios
                .post(vm2.url.ajax_submit_production_machine, params)
                .then(res => {
                    data = res.data.data;
                    vm2.redirect_show_page = data.redirect_show_page;
                    vm2.machineLines = res.data.data.machines;
                })
                .catch(err => {
                    let msg = err;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: msg.message,
                        type: "error",
                    });
                })
                .then(() => {
                    vm2.loading = false;
                });
                return data;
            },
            // ดึงข้อมูลเมื่อมีการกด แก้ไข
            async getDateByBiWeekly() {
                var vm = this;
                let date_from = '';
                let date_to = '';
                let curr_date = moment().format('YYYY-MM-DD');
                vm.modalControlInput.bi_weekly.filter(item => {
                    // item.thai_year == vm.dBudgetYear && 
                    if (item.biweekly == vm.dBiWeekly && item.period_num == vm.dMonth) {
                        date_from = item.start_date;
                        date_to = item.end_date;
                    }
                });
                // Date for check condition
                vm.checkDate.biweekly_date_from = moment(date_from).format('YYYY-MM-DD');
                vm.checkDate.biweekly_date_to = moment(date_to).format('YYYY-MM-DD');
                vm.checkDate.current_date = curr_date;
                vm.checkDate.next_date = vm.getNextDate(curr_date);
                vm.checkDate.input_date_from = moment(date_from).format('YYYY-MM-DD');
                vm.checkDate.input_date_to = moment(date_to).format('YYYY-MM-DD');
                // Convert Date
                var currentDate = await helperDate.parseToDateTh(curr_date, 'YYYY-MM-DD');
                var startDate = await helperDate.parseToDateTh(date_from, 'YYYY-MM-DD');
                var endDate = await helperDate.parseToDateTh(date_to, 'YYYY-MM-DD');
                // Biweek date
                vm.current_date = moment(currentDate).format(vm.dateFormat);
                vm.biweekly_date_from = moment(startDate).format(vm.dateFormat);
                vm.biweekly_date_to = moment(endDate).format(vm.dateFormat);
                // Input Date
                if (curr_date >= moment(date_from).format('YYYY-MM-DD') && curr_date >= moment(date_to).format('YYYY-MM-DD')) {
                    vm.input_date_from = moment(startDate).format(vm.dateFormat);
                    vm.checkDate.input_date_from = moment(date_from).format('YYYY-MM-DD');
                }else if(curr_date >= moment(date_from).format('YYYY-MM-DD')){
                    vm.input_date_from = await helperDate.parseToDateTh(vm.getNextDate(curr_date), 'YYYY-MM-DD');
                    vm.checkDate.input_date_from = vm.getNextDate(curr_date);
                }else{
                    vm.input_date_from = moment(startDate).format(vm.dateFormat);
                    vm.checkDate.input_date_from = moment(date_from).format('YYYY-MM-DD');
                }
                vm.input_date_to = moment(endDate).format(vm.dateFormat);
                vm.checkDate.input_date_to = moment(date_to).format('YYYY-MM-DD');
                // Disable date
                if(curr_date >= moment(date_from).format('YYYY-MM-DD') && curr_date >= moment(date_to).format('YYYY-MM-DD')){
                    vm.isDisableSelDate = true;
                }
            },
            getNextDate(currDate){
                const vm = this;
                var currentDate = moment(currDate).format('YYYY-MM-DD hh:mm:ss');
                let addDay = moment(currentDate, "YYYY-MM-DD hh:mm:ss").add(1, "days");
                vm.next_date = moment(addDay).format(vm.dateFormat);
                return moment(addDay).format("YYYY-MM-DD");
            },
            loopDataItemLines(){
                // ดึงขัอมูลจาก Machine
                var vm = this;
                if (vm.productDailyPlan) {
                    vm.itemLines = [];
                    // แก้ใหม่
                    vm.machineLines.filter((line) => {
                        if (line.machine_group == vm.machine_group) {
                            vm.itemLines.push({
                                id: uuidv1(),
                                line_number: line.line_no,
                                item_id: line.item_id,
                                item_code: line.item_code,
                                item_description: line.item_description,
                                // item_efficiency: Number(line.efficiency_product).toFixed(2),
                                item_efficiency: Number(line.efficiency_product),
                                is_enable: true
                            });
                        }
                    });
                }
            },
            async grpEfficiencyProduct() {
                let vm = this;
                let form = $('#production-plan-control-form');
                let valid = true;
                let errorMsg = '';
                vm.errors.start_date = false;
                vm.errors.end_date = false;
                vm.errors.machine_group = false;
                $(form).find("div[id='el_explode_start_date']").html("");
                $(form).find("div[id='el_explode_end_date']").html("");
                $(form).find("div[id='el_explode_machine_group']").html("");
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                // Validate input
                if (vm.input_date_from == ''){
                    vm.errors.start_date = true;
                    valid = false;
                    msg = "กรุณาเลือกวันที่เริ่ม";
                    $(form).find("div[id='el_explode_start_date']").html(msg);
                }
                if (vm.input_date_to == ''){
                    vm.errors.end_date = true;
                    valid = false;
                    msg = "กรุณาเลือกวันที่สิ้นสุด";
                    $(form).find("div[id='el_explode_end_date']").html(msg);
                }
                if (vm.machine_group == ''){
                    vm.errors.machine_group = true;
                    valid = false;
                    msg = "กรุณาเลือกขอบเขตเครื่องจักร";
                    $(form).find("div[id='el_explode_machine_group']").html(msg);
                }
                if (!valid) {
                    return;
                }

                vm.eff_loading = true;
                vm.html = '\ <div class="mt-2">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>';
                let params = {
                    start_date: vm.input_date_from,
                    end_date: vm.input_date_to,
                    biweekly_id: vm.machineBiweekly.biweekly_id,
                    machine_group: vm.machine_group,
                    product_type: vm.productType,
                    daily_id: vm.productDailyPlan != null? vm.productDailyPlan.daily_id: ''
                };
                await axios.get(vm.url.ajax_get_grp_efficiency_product, { params })
                .then(res => {
                    vm.html = '';
                    // vm.efficiencyProductHeader = Number(res.data.data.grp_efficiency_product).toFixed(2);
                    vm.efficiencyProductHeader = Number(res.data.data.grp_efficiency_product);
                    vm.balanceEfficient = Number(res.data.data.grp_efficiency_product);
                    vm.machineLines = res.data.data.machines;
                    // loop item with machine
                    vm.loopDataItemLines();
                })
                .catch(err => {
                    vm.html = '';
                    vm.efficiencyProductHeader = 0;
                })
                .then(() => {
                    vm.html = '';
                    vm.eff_loading = false;
                });
            },
            setError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference 
                        ? this.$refs[ref_name].$refs.reference.$refs.input 
                        : (this.$refs[ref_name].$refs.textarea 
                            ? this.$refs[ref_name].$refs.textarea 
                            : (this.$refs[ref_name].$refs.input.$refs 
                                ? this.$refs[ref_name].$refs.input.$refs.input 
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "border: 1px solid red;";
            },
            resetError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference 
                        ? this.$refs[ref_name].$refs.reference.$refs.input 
                        : (this.$refs[ref_name].$refs.textarea 
                            ? this.$refs[ref_name].$refs.textarea
                            : (this.$refs[ref_name].$refs.input.$refs 
                                ? this.$refs[ref_name].$refs.input.$refs.input 
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "";
            },
            errorRef(res){
                var vm = this;
                vm.errors.start_date = res.err.start_date;
                vm.errors.end_date = res.err.end_date;
                vm.errors.machine_group = res.err.machine_group;
            },
            async cancel(){
                this.machine_group = '';
                this.itemLines = [];
                this.efficiencyProductHeader = 0;
                this.balanceEfficient = 0;
                this.balanceEfficient = 0;
                this.machineDescLists = [];
            },
            changeThToEn(dateTh){
                // เปลี่ยน Format และ เปลี่ยน พศ -> คศ
                const vm = this;
                let date= moment(dateTh, 'YYYY-MM-DD');
                date.subtract(543, 'years');
                return date.format('YYYY-MM-DD');
            },
        }
    }
</script>