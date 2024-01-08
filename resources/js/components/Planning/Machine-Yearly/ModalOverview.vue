<template>
    <span>
        <button class="btn btn-info btn-md" style="padding-left: 7px;" @click="openModal">
            <i class="fa fa-bar-chart-o"></i> ภาพรวมการผลิตทั้งปีงบประมาณ
        </button>
        <div id="modal-machine-overview" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xl" style="">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h3 style="font-size:24px; font-weight:400;" class="modal-title text-left">
                            คำนวณภาพรวมการผลิตทั้งปีงบประมาณ
                        </h3>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left">
                        <form id="machine-overview-form">
                            <div class="row col-12">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-4 col-xs-4 mt-2">
                                    <label class=" tw-font-bold tw-uppercase mt-2" > สั่งผลิต  : </label> {{ header.efficiency_product }}% 
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-4 col-xs-4 mt-2 text-right">
                                    <label class=" tw-font-bold tw-uppercase mt-2" > คงคลังต้นปีงบประมาณ </label>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-1 col-md-1 col-sm-1 col-xs-1 mt-2">
                                        <vue-numeric style="width: 100%"
                                            name="onhand_year"
                                            v-bind:minus="false"
                                            :min="0"
                                            :max="100"
                                            class="form-control input-sm text-right"
                                            v-model="value"
                                            autocomplete="off"
                                        ></vue-numeric>
                                        <!-- @change="changeDays()"
                                        @blur="changeDays()" -->
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered" style="font-size: 11px;">
                                    <thead>
                                        <tr style="font-size: 11px;">
                                            <th rowspan="2" width="12%" class="text-center"> เดือน </th>
                                            <th :colspan="workingHour.length" width="10%" class="text-center" style="border-right: 3px solid #ddd">
                                                กำลังผลิต (ล้านมวน)
                                            </th>
                                            <th :colspan="workingHour.length" width="10%" class="text-center" style="border-right: 3px solid #ddd">
                                                สั่งผลิต (ล้านมวน)
                                            </th>
                                            <th :colspan="workingHour.length" width="18%" class="text-center" style="border-right: 3px solid #ddd">
                                                จำนวนวันทำงาน (วัน)
                                            </th>
                                            <th rowspan="2" width="10%" class="text-center"> ผลผลิตช่วง PM <br>(ล้านมวน) </th>
                                            <th rowspan="2" width="10%" class="text-center"> ผลผลิตช่วง DT <br>(ล้านมวน) </th>
                                            <th rowspan="2" width="10%" class="text-center"> รวมสั่งผลิต <br>(ล้านมวน) </th>
                                            <th rowspan="2" width="10%" class="text-center"> ประมาณการจำหน่าย <br>(ล้านมวน) </th>
                                            <th rowspan="2" width="12%" class="text-center"> คงคลังสิ้นเดือน <br>(ล้านมวน) </th>
                                        </tr>
                                        <tr style="font-size: 11px;">
                                            <template v-for="(working, index) in workingHour">
                                                <th class="text-center" :style="workingHour.length == index+1? 'border-right: 3px solid #ddd': ''">
                                                    {{ working.meaning }}
                                                </th>
                                            </template>
                                            <template v-for="(working, index) in workingHour">
                                                <th class="text-center" :style="workingHour.length == index+1? 'border-right: 3px solid #ddd': ''">
                                                    {{ working.meaning }}
                                                </th>
                                            </template>
                                            <template v-for="(working, index) in workingHour">
                                                <th class="text-center" :style="workingHour.length == index+1? 'border-right: 3px solid #ddd': ''">
                                                    {{ working.meaning }}
                                                </th>
                                            </template>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(overviews, period) in yearlyOverview">
                                            <tr v-for="overview in overviews" style="font-size: 11px;">
                                                <td class="text-center"> {{ overview.month }} </td>
                                                <template v-for="(working, index) in workingHour">
                                                    <td class="text-right" :style="workingHour.length == index+1? 'border-right: 3px solid #ddd': ''">
                                                        {{ calEffMachine(0, working.attribute1, overview.efficiency_machine_per_min, 100) | number2Digit}}
                                                    </td>
                                                </template>
                                                <template v-for="(working, index) in workingHour">
                                                    <td class="text-right" :style="workingHour.length == index+1? 'border-right: 3px solid #ddd': ''">
                                                        {{ calEffMachine(period, working.attribute1, overview.efficiency_machine_per_min, header.efficiency_product) | number2Digit }}
                                                    </td>
                                                </template>
                                                <template v-for="(working, index) in workingHour">
                                                    <td class="text-right" :style="workingHour.length == index+1? 'border-right: 3px solid #ddd': ''">
                                                        <WorkingDays
                                                            :period="period"
                                                            :workingHour="working.attribute1"
                                                            :pWorkingDays="workingDays"
                                                        />
                                                    </td>
                                                </template>
                                                <td class="text-right"> {{ overview.eam_pm_eff_product | number2Digit}} </td>
                                                <td class="text-right"> {{ overview.eam_dt_eff_product | number2Digit}} </td>
                                                <td class="text-right"> {{ totalEffMachine[period] | number2Digit}} </td>
                                                <td class="text-right"> {{ omSaleForcastOverview[period][0] | number2Digit}} </td>
                                                <td class="text-right"> {{ totalEffByMonth[period] | number2Digit}} </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" :class="btnTrans.create.class + ' btn-lg tw-w-25'" @click.prevent="submit">
                            บันทึก
                        </button>
                        <button type="button" class="btn btn-white btn-lg tw-w-25'" data-dismiss="modal"> ยกเลิก </button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
    import moment from "moment";
    import uuidv1 from 'uuid/v1';
    import WorkingDays  from './WorkingDays.vue';
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
            WorkingDays, VueNumeric
        },
        props:['header', 'yearlyOverview', 'omSaleForcastOverview', 'btnTrans', 'workingHour', 'url', 'onhandYear', 'pWorkingDays'],
        data() {
            return {
                loading: false,
                effMachine: {},
                workingDays: this.pWorkingDays,
                totalEffMachine: {},
                totalEffByMonth: {},
                value: this.onhandYear? this.onhandYear: 100, // default 100
            }
        },
        mounted() {
        },
        watch:{
            calWorkingDays(newValue){
                return newValue;
            },
            calTotalEffMonth(newValue){
                return newValue;
            },
        },
        computed:{
            calWorkingDays() {
                var vm = this;
                // I = [(4*7) + (5*8) + (6*9)] - (J+ H)
                Object.keys(vm.yearlyOverview).filter(function(period) {
                    let i = 0;
                    vm.workingHour.filter(function(hour, index) {
                        let r = vm.workingDays[period+'|'+hour.lookup_code] ?? 0;
                        console.log(r);
                        console.log(vm.effMachine[period+'|'+hour.lookup_code]);
                        i += Number(r) * Number(vm.effMachine[period+'|'+hour.lookup_code]);

                        if (vm.workingHour.length == index+1) {
                            i = i - (Number(vm.omSaleForcastOverview[period][0]) + Number(vm.yearlyOverview[period][0].eam_dt_eff_product));
                            Vue.set(vm.totalEffMachine, period, Number(i).toFixed(2));
                        }
                    });
                });
            },
            calTotalEffMonth() {
                var vm = this;
                //K สิ้นตุลา = B + I ตุลา - J, K สิ้นพย = K สิ้นตุลา + I พย - J
                Object.keys(vm.yearlyOverview).filter(function(period, index) {
                    let k = 0;
                    if (period == 1) {
                        k = vm.value + Number(vm.totalEffMachine[period]) - Number(vm.omSaleForcastOverview[period][0]);
                    }else{
                        k = Number(vm.totalEffByMonth[index]) + Number(vm.totalEffMachine[period]) - Number(vm.omSaleForcastOverview[period][0]);
                    }
                    Vue.set(vm.totalEffByMonth, period, Number(k).toFixed(2));
                });
            },
        },
        methods: {
            openModal() {
                $('#modal-machine-overview').modal('show');
            },
            calEffMachine(period, hour, eff_per_min, percent) {
                var vm = this;
                let result = 0;
                let v_cal = (Number(eff_per_min)*(Number(hour)-1)*60)/1000000;
                result = v_cal*(Number(percent)/100);
                if (period != 0) {
                    Vue.set(vm.effMachine, period+'|'+hour, Number(result).toFixed(2));
                }
                return result;
            },
            async submit(){
                let vm = this;
                let form = $('#machine-overview-form');
                var msg = '';
                vm.loading = true;
                let params = {
                    header: vm.header,
                    onhandYear: vm.value,
                    workingDays: vm.workingDays,
                    totalEffMachine: vm.totalEffMachine,
                    totalEffByMonth: vm.totalEffByMonth
                };
                await axios
                .post(vm.url.machine_overview_p01, params)
                .then(res => {
                    if(res.data.status == 'S'){
                        swal({
                            title: 'ปรับลดกำลังการผลิต',
                            text: '<span style="font-size: 16px; text-align: left;"> ทำการบันทึกการคำนวณภาพรวมการผลิตทั้งปีงบประมาณเรียบร้อยแล้ว </span>',
                            type: "success",
                            html: true
                        });
                    }else{
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                            type: "error",
                            html: true
                        });
                    }
                })
                .catch(err => {
                    let msg = err.response.data.data;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                        type: "error",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
        }
    }
</script>