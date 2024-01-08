<template>
    <div>
        <template v-if="Object.values(search).length > 0 && otMain">
            <!-- TABLE1 OT PLAN -->
            <template v-if="loadingOTPlan != ''">
                <div v-html="loadingOTPlan"></div>
            </template>
            <template v-else-if="otPlans.length <= 0">
                <div class="col-12 text-center">
                    <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
                </div>
            </template>
            <template v-else>
                <div class="row col-12 mb-3">
                    <div class="col-md-6 p-0">
                        <label class="tw-font-bold tw-uppercase mb-1 ml-1"> หน่วยงาน </label>
                        <div>
                            <el-select v-model="department" placeholder="Department" @change="getOTPlan" size="medium" style="width: 50%;">
                                <el-option
                                    v-for="dept in departments"
                                    :key="dept.department_code"
                                    :label="dept.department_code+': '+dept.department_name"
                                    :value="dept.department_code">
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-md-6  p-0 text-right">
                        <button v-if="!canEdit && !isNotDisableControl" :class="btnTrans.edit.class + ' btn-lg tw-w-25'" style="padding-left: 7px;" @click.prevent="editWorkingHour(canEdit = !canEdit)">
                            <i :class="btnTrans.edit.icon"></i> แก้ไขชั่วโมงการทำงาน
                        </button>
                        <button v-if="canEdit" :class="btnTrans.confirm.class + ' btn-lg tw-w-25'" style="padding-left: 7px;" @click.prevent="updateOTPlan">
                            <i :class="btnTrans.confirm.icon"></i> ยืนยันชั่วโมงการทำงาน
                        </button>
                        <button v-if="canEdit" :class="btnTrans.cancel.class + ' btn-lg tw-w-25'" style="padding-left: 7px;" @click.prevent="editWorkingHour(canEdit = !canEdit)">
                            <i :class="btnTrans.cancel.icon"></i> ยกเลิก
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="width: 50%; max-height: 370px; display: block; overflow: auto; position: sticky;">
                        <thead>
                            <tr style="height: 50px;">
                                <th width="12%" class="text-center" style="vertical-align: middle; min-width: 50px; position: sticky; top: 0; z-index: 9999">
                                    วัน
                                </th>
                                <th width="12%" class="text-center" style="vertical-align: middle; min-width: 50px; position: sticky; top: 0; z-index: 9999">
                                    วันที่
                                </th>
                                <th width="10%" class="text-center" style="vertical-align: middle; min-width: 50px; position: sticky; top: 0; z-index: 9999">
                                    ชั่วโมงการทำงาน
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(plan, index) in otPlans">
                                <td class="text-center"
                                    :style="plan.holiday_flag == 'Y'? 'background-color: #ddd;': plan.holiday_flag == 'P'? 'background-color: #cccccc;': ''">
                                    {{ dateArr[plan.workdy] }}
                                </td>
                                <td class="text-center"
                                    :style="plan.holiday_flag == 'Y'? 'background-color: #ddd;': plan.holiday_flag == 'P'? 'background-color: #cccccc;': ''">
                                    {{ plan.working_date_at_format }}
                                </td>
                                <td class="text-center"
                                    :style="plan.holiday_flag == 'Y'? 'background-color: #ddd;': plan.holiday_flag == 'P'? 'background-color: #cccccc;': ''">
                                    <workingHour
                                        :plan="plan"
                                        :workingHoliday="workingHoliday"
                                        :pWorkingHourEdit="workingHourEdit"
                                        :canEdit="canEdit"
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </template>

            <div class="hr-line-dashed"></div>
            <!-- TABLE2 OT Plan BiWeekly -->
            <template v-if="loadingOTPlan != ''">
                <div> </div>
            </template>
            <template v-else-if="loadingOTPlanBiWeekly != ''">
                <div v-html="loadingOTPlanBiWeekly"></div>
            </template>
            <template v-else>
                <div class="row mr-2 mb-2 pull-right" v-if="Object.values(otPlanBiWeekly).length > 0">
                    <button v-if="!canEdit && !isNotDisableControl" :class="btnTrans.confirm.class + ' btn-lg tw-w-25'" style="padding-left: 7px;" @click.prevent="updateOTPercent">
                        <i :class="btnTrans.confirm.icon"></i> คำนวณค่าใช้จ่ายล่วงเวลา
                    </button>
                </div>
                <!-- <div class="row col-12"> -->
                    <div class="table-responsive m-t">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="15%" class="text-center">
                                        กลุ่ม / กองพนักงาน
                                    </th>
                                    <th rowspan="2" width="12%" class="text-center">
                                        ประเภท
                                    </th>
                                    <th rowspan="2" width="8%" class="text-center">
                                        จำนวน
                                    </th>
                                    <th rowspan="2" width="8%" class="text-center">
                                        ค่าแรง
                                    </th>
                                    <th colspan="2" width="12%" class="text-center">
                                        เสาร์ / อาทิตย์ / นักขัตฤกษ์
                                    </th>
                                    <template v-for="(time, index) in otTimeDesc">
                                        <th colspan="5" width="15%" class="text-center" :style="'background-color: '+ colorCode[index]+'; border-right: 2px solid #646464;'">
                                            {{ time }} น.
                                        </th>
                                    </template>
                                </tr>
                                <tr>
                                    <th width="8%" class="text-center">
                                        ชม. ผลิตเพิ่ม
                                    </th>
                                    <th width="8%" class="text-center">
                                        ค่าล่วงเวลา
                                    </th>
                                    <template v-for="time in otTimeDesc">
                                        <th width="10%" class="text-center">
                                            % ทำงานล่วงเวลา
                                        </th>
                                        <th width="8%" class="text-center">
                                            ค่าแรง OT/ชม.
                                        </th>
                                        <th width="8%" class="text-center">
                                            ชม. ผลิตเพิ่ม
                                        </th>
                                        <th width="8%" class="text-center">
                                            คิด 1.5 เท่า
                                        </th>
                                        <th width="8%" class="text-center" style="border-right: 2px solid #646464">
                                            ค่าล่วงเวลา
                                        </th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="otPlanBiWeekly.length <= 0">
                                    <tr>
                                        <td colspan="21" class="text-center" style="vertical-align: middle;">
                                            <h2> ไม่มีข้อมูลประมาณการคำนวณค่าใช้จ่ายล่วงเวลา </h2>
                                        </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <template v-for="(plans, dept) in otPlanBiWeekly">
                                        <tr>
                                            <td :rowspan="plans.length+1" class="text-left">
                                                <div> {{ getDepartmentGroup(dept) }} </div>
                                            </td>
                                            <tr v-for="plan in plans">
                                                <!-- <td class="text-left">
                                                    {{ plan.department_name }}
                                                </td> -->
                                                <td class="text-center">
                                                    {{ plan.employee_type_name }}
                                                </td>
                                                <td class="text-center">
                                                    {{ plan.employee_qty }}
                                                </td>
                                                <td class="text-right">
                                                    {{ plan.ot_perhour }}
                                                </td>
                                                <td class="text-center">
                                                    {{ plan.ot_hour }}
                                                </td>
                                                <td class="text-right">
                                                    {{ plan.ot_holiday | number2Digit }}
                                                </td>
                                                <template v-for="time in otTimeDesc">
                                                    <td class="text-center">
                                                        <otPercent
                                                            :plan="plan"
                                                            :time="time"
                                                            :otPercent="otPercent"
                                                            :value="otPercent[time][plan.department_code+'|'+plan.employee_type]"
                                                            :pOtPercentEdit="otPercentEdit"
                                                            :canEdit="canEdit || isNotDisableControl"
                                                        > </otPercent>
                                                    </td>
                                                    <td class="text-right">
                                                        {{ hourlyWage[time][plan.department_code+'|'+plan.employee_type] | number2Digit }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ hourIncrease[time][plan.department_code+'|'+plan.employee_type] }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ defaultRate[time][plan.department_code+'|'+plan.employee_type] }}
                                                    </td>
                                                    <td class="text-right" style="border-right: 2px solid #646464">
                                                        {{ otAmount[time][plan.department_code+'|'+plan.employee_type] | number2Digit }}
                                                    </td>
                                                </template>
                                            </tr>
                                        </tr>
                                    </template>
                                    <tr style="background-color: #34d399;">
                                        <th colspan="6" class="text-right">
                                            รวมหน่วยงาน : {{ getDepartment(department) }}
                                        </th>
                                        <template v-for="time in otTimeDesc">
                                            <th class="text-center">
                                                -
                                            </th>
                                            <th class="text-right">
                                                {{ summary[time].hourly_wage | number2Digit }}
                                            </th>
                                            <th class="text-center">
                                                {{ summary[time].hour_increase | number0Digit }}
                                            </th>
                                            <th class="text-center">
                                                -
                                            </th>
                                            <th class="text-right" style="border-right: 2px solid #646464">
                                                {{ summary[time].ot_amount | number2Digit }}
                                            </th>
                                        </template>
                                    </tr>
                                    <tr style="background-color: #34d399;">
                                        <th colspan="6" class="text-right">
                                            รวมทุกหน่วยงาน
                                        </th>
                                        <template v-for="time in otTimeDesc">
                                            <th class="text-center">
                                                -
                                            </th>
                                             <th class="text-right">
                                                {{ summaryAll[time].hourly_wage | number2Digit }}
                                            </th>
                                            <th class="text-center">
                                                {{ summaryAll[time].hour_increase | number0Digit }}
                                            </th>
                                            <th class="text-center">
                                                -
                                            </th>
                                            <th class="text-right" style="border-right: 2px solid #646464">
                                                {{ summaryAll[time].ot_amount | number2Digit }}
                                            </th>
                                        </template>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                <!-- </div> -->
            </template>
        </template>
    </div>
</template>

<script>
    import moment from "moment";
    import uuidv1 from 'uuid/v1';
    import VueNumeric from 'vue-numeric';
    import workingHour from './WorkingHourComponent.vue';
    import otPercent from './OTPercentComponent.vue';
    export default {
        components: {
            workingHour, otPercent, VueNumeric
        },
        props:['departments', 'url', 'workingHoliday', 'btnTrans', 'dateArr', 'defaultInput', 'search', 'otMain', 'colorCode'],
        data() {
            return {
                otPlans: [],
                otPlanBiWeekly: [],
                otPercent: [],
                hourlyWage: [],
                hourIncrease: [],
                defaultRate: [],
                otAmount: [],
                otTimeDesc: [],
                department: this.defaultInput.department,
                workingHourEdit: {},
                otPercentEdit: {},
                valid_action: false,
                canEdit: false,
                loadingOTPlan: '',
                loadingOTPlanBiWeekly: '',
                checkDate: {
                    current_date: '',
                    start_date: '',
                    end_date: '',
                },
                isNotDisableControl: false,
                summary: [],
                summaryAll: [],
            }
        },
        mounted() {
            if (Object.values(this.search).length > 0 && this.otMain) {
                this.getOTPlan();
                this.getDateByBiWeekly();
            }
        },
        computed: {
            //
        },
        watch:{
            //
        },
        methods: {
            async getOTPlan(){
                let vm = this;
                vm.$emit("department", vm.department);
                if(vm.valid_action){
                    swal({
                        title: 'เปลี่ยนแปลงข้อมูลชั่วโมงการทำงาน',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                vm.otPlans = [];
                vm.loadingOTPlan = '\ <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>';

                let params = {
                    department: vm.department,
                };
                await axios.post(vm.url.ajax_get_ot_plan, {params})
                .then(res => {
                    console.log(res.data);
                    if (res.data.status == 'S') {
                        vm.otPlans = res.data.otPlans;
                        vm.otPlanBiWeekly = res.data.otPlanBiWeekly;
                        vm.otPercent = res.data.otPercent;
                        vm.hourlyWage = res.data.hourlyWage;
                        vm.hourIncrease = res.data.hourIncrease;
                        vm.defaultRate = res.data.defaultRate;
                        vm.otAmount = res.data.otAmount;
                        vm.otTimeDesc = res.data.otTimeDesc;
                        vm.summary = res.data.summary;
                        vm.summaryAll = res.data.summaryAll;
                        vm.otPercentEdit = {};
                        vm.workingHourEdit = {};
                        vm.valid_action = false;
                    }
                })
                .catch(err => {
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+err.message+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loadingOTPlan = '';
                });
            },
            async updateOTPlan(){
                let vm = this;
                if(Object.values(vm.workingHourEdit).length <= 0){
                    swal({
                        title: 'เปลี่ยนแปลงข้อมูลชั่วโมงการทำงาน',
                        text: '<span style="font-size: 16px; text-align: left;"> ไม่มีการเปลี่ยนแปลงข้อมูลชั่วโมงการทำงาน </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                vm.canEdit = false;
                vm.otPlanBiWeekly = [];
                vm.otPercent = [];
                vm.hourlyWage = [];
                vm.hourIncrease = [];
                vm.defaultRate = [];
                vm.otAmount = [];
                vm.otTimeDesc = [];
                // = vm.loadingOTPlanBiWeekly
                vm.loadingOTPlan = '\ <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>';
                let params = {
                    department: vm.department,
                    workingHour: vm.workingHourEdit
                };
                await axios.post(vm.url.ajax_update_ot_plan, {params})
                .then(res => {
                    console.log(res.data);
                    if (res.data.status == 'S') {
                        vm.otPlanBiWeekly = res.data.otPlanBiWeekly;
                        vm.otPercent = res.data.otPercent;
                        vm.hourlyWage = res.data.hourlyWage;
                        vm.hourIncrease = res.data.hourIncrease;
                        vm.defaultRate = res.data.defaultRate;
                        vm.otAmount = res.data.otAmount;
                        vm.otTimeDesc = res.data.otTimeDesc;
                        vm.summary = res.data.summary;
                        vm.summaryAll = res.data.summaryAll;
                        vm.workingHourEdit = {};
                        vm.valid_action = false;
                    }else{
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }
                })
                .catch(err => {
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+err.message+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loadingOTPlan = '';
                    // vm.loadingOTPlanBiWeekly = '';
                });
            },
            async updateOTPercent(){
                let vm = this;
                if(Object.values(vm.otPercentEdit).length <= 0){
                    swal({
                        title: 'เปลี่ยนแปลงข้อมูล OT Percent',
                        text: '<span style="font-size: 16px; text-align: left;"> ไม่มีการเปลี่ยนแปลงข้อมูล OT Percent </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                vm.otPlanBiWeekly = [];
                vm.otPercent = [];
                vm.hourlyWage = [];
                vm.hourIncrease = [];
                vm.defaultRate = [];
                vm.otAmount = [];
                vm.otTimeDesc = [];
                vm.loadingOTPlanBiWeekly = '\ <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>';
                let params = {
                    department: vm.department,
                    otPercent: vm.otPercentEdit
                };
                await axios.post(vm.url.ajax_update_ot_percent, {params})
                .then(res => {
                    console.log(res.data);
                    if (res.data.status == 'S') {
                        vm.otPlanBiWeekly = res.data.otPlanBiWeekly;
                        vm.otPercent = res.data.otPercent;
                        vm.hourlyWage = res.data.hourlyWage;
                        vm.hourIncrease = res.data.hourIncrease;
                        vm.defaultRate = res.data.defaultRate;
                        vm.otAmount = res.data.otAmount;
                        vm.otTimeDesc = res.data.otTimeDesc;
                        vm.summary = res.data.summary;
                        vm.summaryAll = res.data.summaryAll;
                        vm.otPercentEdit = {};
                        vm.valid_action = false;
                    }else{
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }
                })
                .catch(err => {
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+err.message+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loadingOTPlanBiWeekly = '';
                });
            },
            editWorkingHour(flag){
                var vm = this;
                vm.valid_action = flag;
                vm.canEdit = flag;
            },
            getDateByBiWeekly() {
                var vm = this;
                let date_from = vm.otMain.pp_bi_weekly.start_date;
                let date_to = vm.otMain.pp_bi_weekly.end_date;
                let curr_date = moment().format('YYYY-MM-DD');
                // วันที่ที่ใช้ในการเช็คเงื่อนไข
                vm.checkDate.current_date = curr_date;
                vm.checkDate.start_date = moment(date_from).format('YYYY-MM-DD');
                vm.checkDate.end_date = moment(date_to).format('YYYY-MM-DD');
                // check current biweekly
                if(vm.checkDate.current_date > vm.checkDate.start_date && vm.checkDate.current_date > vm.checkDate.end_date){
                    vm.isNotDisableControl = true;
                }
            },
            getDepartment(dept){
                let vm = this;
                let val = '';
                vm.departments.filter(function(value){
                    if (dept == value.department_code) {
                        val = value.department_name;
                    }
                });
                return val;
            },
            getDepartmentGroup(dept){
                let split_dept = dept.split('  ');
                let result = split_dept[1] == ''? dept: split_dept[1];

                return result;
            }
        }
    }
</script>
<style scope>
    .sticky-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 9999;
    }

    .first-col {
        width: 150px;
        min-width: 100px;
        max-width: 150px;
        left: 0px;
    }

    .second-col {
        width: 150px;
        min-width: 150px;
        max-width: 150px;
        left: 116px;
        /*left: 150px;*/
    }

    .th-col {
        width: 250px;
        min-width: 150px;
        max-width: 250px;
        left: 266px;
        /*left: 250px;*/
    }

    .fo-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 416px;
        /*left: 400px;*/
    }

    .fi-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 566px;
        /*left: 550px;*/
    }

    .t1-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 0px;
    }

    .t2-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 566px;
    }
</style>