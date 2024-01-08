<template>
    <div v-loading="loading">

        <div class="form-group row">
            <label class="col-lg-1 col-form-label text-right"> ปักษ์ที่</label>
            <div class="col-lg-3">
                <el-select v-model="defaultInput.bi_weekly" style="width: 100%" size="large" placeholder="ปักษ์" @change="getProductPlanMachine" filterable>
                   <el-option
                        v-for="(biweekly, index) in ppBiWeekly"
                        :key="index"
                        :label="biweekly.biweekly"
                        :value="biweekly.biweekly_id"
                    >
                    </el-option>
                </el-select>
            </div>

            <label class="col-lg-2 col-form-label text-left">
                สั่งผลิต(%) &nbsp;&nbsp;
                <span v-if="plan">
                    {{ p03EfficiencyProduct }}
                </span>
            </label>
        </div>


        <div v-html="html"></div>
        <hr>


        <table class="table table-bordered" v-if="false">
            <thead>
                <tr>
                    <th colspan="13" class="text-center"> ประมาณกำลังการผลิตเครื่องจักร </th>
                </tr>
                <tr>
                    <th rowspan="3" style="width: 8%; vertical-align: middle;" class="text-center">
                       <div> ขอบเขตเครื่องจักร </div>
                    </th>
                    <th colspan="3" style="width: 10%;" class="text-center">
                       <div> กำลังการผลิต (ล้าน{{ productType == 'KK'? 'ชิ้น':'มวน' }}) </div>
                    </th>
                    <th colspan="3" style="width: 10%;" class="text-center">
                        <div> สั่งผลิต (ล้าน{{ productType == 'KK'? 'ชิ้น':'มวน' }}) </div>
                    </th>
                    <th colspan="3" style="width: 10%;" class="text-center">
                        <div> จำนวนวันทำงาน (วัน) </div>
                    </th>
                    <th rowspan="3" style="width: 7%; vertical-align: middle;" class="text-center">
                        <div> ยอดผลผลิตช่วง PM <small>(ล้าน{{ productType == 'KK'? 'ชิ้น':'มวน' }})</small>
                        </div>
                    </th>
                    <th rowspan="3" style="width: 7%; vertical-align: middle;" class="text-center">
                        <div> ยอดผลผลิตช่วงลดกำลังผลิต
                            <br> <small>(ล้าน{{ productType == 'KK'? 'ชิ้น':'มวน' }})</small>
                        </div>
                    </th>
                    <th rowspan="3" style="width: 5%; vertical-align: middle;" class="text-center">
                        <div> รวมสั่งผลิต
                            <br> <small>(ล้าน{{ productType == 'KK'? 'ชิ้น':'มวน' }})</small>
                        </div>
                    </th>
                </tr>
                <tr>
                    <template v-for="hour in workingHour">
                        <th class="text-center" >
                            <div> {{ hour.lookup_code }} ชั่วโมง </div>
                        </th>
                    </template>
                    <template v-for="hour in workingHour">
                        <th class="text-center" >
                            <div> {{ hour.lookup_code }} ชั่วโมง </div>
                        </th>
                    </template>
                    <template v-for="hour in workingHour">
                        <th class="text-center" >
                            <div> {{ hour.lookup_code }} ชั่วโมง </div>
                        </th>
                    </template>
                </tr>
            </thead>
            <tbody>

                <template v-for="(machine, group_name) in planMachine">
                   <tr>
                        <td class="text-left">
                            {{ covertName(group_name) }}
                        </td>
                        <template v-for="(machine, index) in machines">
                            <template v-if="index == group_name">
                                <template v-for="hour in workingHour">
                                    <td class="text-center" >
                                        {{ machine[hour.lookup_code] }}
                                    </td>
                                </template>
                            </template>
                        </template>
                        <template v-for="(efficiency, index) in efficiencies">
                            <template v-if="index == group_name">
                                <template v-for="hour in workingHour">
                                    <td class="text-center" >
                                        {{ efficiency[hour.lookup_code] }}
                                    </td>
                                </template>
                            </template>
                        </template>
                        <template v-for="(day, index) in days">
                            <template v-if="index == group_name">
                                <template v-for="hour in workingHour">
                                    <td class="text-center" >
                                        {{ day[hour.lookup_code] }}
                                    </td>
                                </template>
                            </template>
                        </template>
                        <template v-for="(machine, index) in totalMachine">
                            <template v-if="index == group_name">
                                <td class="text-center" >
                                    {{ machine[prodBiweeklyMain.product_main_id] ?  machine[prodBiweeklyMain.product_main_id] : 0 }}
                                </td>
                            </template>
                        </template>
                        <template v-for="(efficiency, index) in totalEfficiency">
                            <template v-if="index == group_name">
                                <td class="text-center" >
                                    {{ efficiency[prodBiweeklyMain.product_main_id] ? efficiency[prodBiweeklyMain.product_main_id] : 0 }}
                                </td>
                            </template>
                        </template>
                        <template v-for="(day, index) in totalDays">
                            <template v-if="index == group_name">
                                <td class="text-center" >
                                    {{ day[prodBiweeklyMain.product_main_id] ? day[prodBiweeklyMain.product_main_id] : 0 }}
                                </td>
                            </template>
                        </template>
                    </tr>
                </template>
                <tr style="background-color: #7bcc7b;">
                    <td class="text-right tw-font-bold tw-uppercase"> รวมกำลังการผลิต </td>
                    <template v-for="machine in summaryMachine">
                        <template v-for="hour in workingHour">
                            <td class="text-center" v-if="machine.working_hour == hour.lookup_code">
                                {{ machine.total | number2Digit }}
                            </td>
                        </template>
                    </template>

                    <template v-for="machine in summaryEfficiency">
                        <template v-for="hour in workingHour">
                            <td class="text-center" v-if="machine.working_hour == hour.lookup_code">
                                {{ machine.total | number2Digit }}
                            </td>
                        </template>
                    </template>

                    <template v-for="machine in summaryDay">
                        <template v-for="hour in workingHour">
                            <td class="text-center" v-if="machine.working_hour == hour.lookup_code">
                                {{ machine.total | number2Digit }}
                            </td>
                        </template>
                    </template>

                    <template v-for="totalMachine in summaryTotalMachine">
                        <td class="text-center" v-if="totalMachine.plan_id == prodBiweeklyMain.product_main_id">
                            {{ totalMachine.total | number2Digit }}
                        </td>
                    </template>

                    <template v-for="totalEfficiency in summaryTotalEfficiency">
                        <td class="text-center" v-if="totalEfficiency.plan_id == prodBiweeklyMain.product_main_id">
                            {{ totalEfficiency.total | number2Digit }}
                        </td>
                    </template>

                    <template v-for="totalDay in summaryTotalDay">
                        <td class="text-center" v-if="totalDay.plan_id == prodBiweeklyMain.product_main_id">
                            {{ totalDay.total | number2Digit }}
                        </td>
                    </template>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

    export default {
        props:[
            "pDateFormat", "machineEfficiencyProd",
            "prodBiweeklyMain", "ppBiWeekly", "productType", "url", "workingHour", "defaultBiWeekly", "selTabName", "pRefresh"
        ],
        data() {
            return {
                defaultInput: {
                    bi_weekly: (this.defaultBiWeekly != undefined && this.defaultBiWeekly != '') ? this.defaultBiWeekly : null,
                },
                loading: false,
                html: '',

                planMachine: [],
                machines: [],
                efficiencies: [],
                days: [],
                totalMachine: [],
                totalEfficiency: [],
                totalDays: [],

                summaryMachine: [],
                summaryEfficiency: [],
                summaryDay: [],
                summaryTotalMachine: [],
                summaryTotalEfficiency: [],
                summaryTotalDay: [],
                plan: false,

            }
        },
        mounted() {
            this.getProductPlanMachine();
        },
         methods: {
            covertName(machineGroup){
                return this.planMachine[machineGroup][0].machine_group_desc
            },
            getProductPlanMachine(){
                let vm = this;
                if ( !vm.defaultInput.bi_weekly || !vm.productType || vm.selTabName != 'tab1') {
                    return;
                }

                vm.loading = true;
                vm.planMachine = [];
                vm.machines = [];
                vm.efficiencies = [];
                vm.days = [];
                vm.totalMachine = [];
                vm.totalEfficiency = [];
                vm.totalDays = [];

                vm.summaryMachine = [];
                vm.summaryEfficiency = [];
                vm.summaryDay = [];
                vm.summaryTotalMachine = [];
                vm.summaryTotalEfficiency = [];
                vm.summaryTotalDay = [];
                vm.plan = false;

                let params = {
                    product_main_id: vm.prodBiweeklyMain.product_main_id,
                    product_type: vm.productType,
                    bi_weekly_id: vm.defaultInput.bi_weekly
                }

                // vm.html = '';

                axios.get(vm.url.ajax_get_plan_machine, { params })
                .then(res => {
                    let data = res.data.data;
                    vm.planMachine = data.planMachine;
                    vm.machines = data.machines;
                    vm.efficiencies = data.efficiencies;
                    vm.days = data.days;
                    vm.totalMachine = data.totalMachine;
                    vm.totalEfficiency = data.totalEfficiency;
                    vm.totalDays = data.totalDays;
                    vm.plan = data.plan;
                    vm.html = data.html;
                })
                .catch(err => {
                    let msg = err.response.data;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: msg.message,
                        type: "error",
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
        },
        watch:{
            productType() {
                this.getProductPlanMachine();
            },
            pRefresh : async function (value, oldValue) {
                this.getProductPlanMachine();
            },
            summaryMachineC(newValue){
                return newValue;
            },
            summaryEfficiencyC(newValue){
                return newValue;
            },
            summaryDayC(newValue){
                return newValue;
            },
            summaryTotalMachineC(newValue){
                return newValue;
            },
            summaryTotalEfficiencyC(newValue){
                return newValue;
            },
            summaryTotalDayC(newValue){
                return newValue;
            },
        },
        computed: {
            p03EfficiencyProduct() {
                let vm = this;
                let p03EffiProd = '-';
                if (vm.defaultInput.bi_weekly) {
                    let biweekly = vm.machineEfficiencyProd.filter(o => o.machine_biweekly_id == vm.defaultInput.bi_weekly);

                    if (biweekly.length) {
                        biweekly = biweekly.filter(o => o.product_type == vm.productType);

                        if (biweekly.length) {
                            p03EffiProd = biweekly[0]['machine_efficiency_product']
                        }

                    }
                }

                return p03EffiProd;
            },
            summaryMachineC(){
                var result = [];
                var vue = this;
                Object.values(this.machines).reduce(function(res, value) {
                    vue.workingHour.filter(function(val) {
                        if (!res[val.lookup_code]) {
                            res[val.lookup_code] = { working_hour: val.lookup_code, total: 0 };
                            result.push(res[val.lookup_code]);
                        }
                        res[val.lookup_code].total += Number(value[val.lookup_code]);
                    });
                    return res;
                }, {});
                this.summaryMachine = result;
            },
            summaryEfficiencyC(){
                var result = [];
                var vue = this;
                Object.values(this.efficiencies).reduce(function(res, value) {
                    vue.workingHour.filter(function(val) {
                        if (!res[val.lookup_code]) {
                            res[val.lookup_code] = { working_hour: val.lookup_code, total: 0 };
                            result.push(res[val.lookup_code]);
                        }
                        res[val.lookup_code].total += Number(value[val.lookup_code]);
                    });
                    return res;
                }, {});
                this.summaryEfficiency = result;
            },
            summaryDayC(){
                var result = [];
                var vue = this;
                Object.values(this.days).reduce(function(res, value) {
                    vue.workingHour.filter(function(val) {
                        if (!res[val.lookup_code]) {
                            res[val.lookup_code] = { working_hour: val.lookup_code, total: 0 };
                            result.push(res[val.lookup_code]);
                        }
                        res[val.lookup_code].total += Number(value[val.lookup_code]);
                    });
                    return res;
                }, {});
                this.summaryDay = result;
            },
            summaryTotalMachineC(){
                var result = [];
                var vue = this;
                Object.values(vue.totalMachine).reduce(function(res, value) {
                    if (!res[vue.prodBiweeklyMain.product_main_id]) {
                        res[vue.prodBiweeklyMain.product_main_id] = { plan_id: vue.prodBiweeklyMain.product_main_id, total: 0 };
                        result.push(res[vue.prodBiweeklyMain.product_main_id]);
                    }
                    res[vue.prodBiweeklyMain.product_main_id].total += Number(value[vue.prodBiweeklyMain.product_main_id]);
                    return res;
                }, {});
                this.summaryTotalMachine = result;
            },
            summaryTotalEfficiencyC(){
                var result = [];
                var vue = this;
                Object.values(vue.totalEfficiency).reduce(function(res, value) {
                    if (!res[vue.prodBiweeklyMain.product_main_id]) {
                        res[vue.prodBiweeklyMain.product_main_id] = { plan_id: vue.prodBiweeklyMain.product_main_id, total: 0 };
                        result.push(res[vue.prodBiweeklyMain.product_main_id]);
                    }
                    res[vue.prodBiweeklyMain.product_main_id].total += Number(value[vue.prodBiweeklyMain.product_main_id] ?? 0);
                    return res;
                }, {});
                this.summaryTotalEfficiency = result;
            },
            summaryTotalDayC(){
                var result = [];
                var vue = this;
                Object.values(vue.totalDays).reduce(function(res, value) {
                    if (!res[vue.prodBiweeklyMain.product_main_id]) {
                        res[vue.prodBiweeklyMain.product_main_id] = { plan_id: vue.prodBiweeklyMain.product_main_id, total: 0 };
                        result.push(res[vue.prodBiweeklyMain.product_main_id]);
                    }
                    res[vue.prodBiweeklyMain.product_main_id].total += Number(value[vue.prodBiweeklyMain.product_main_id]);
                    return res;
                }, {});
                this.summaryTotalDay = result;
            },
        },
    }
</script>