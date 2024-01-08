<template>
    <div>
        <el-select v-if="!pEditFlag" v-model="hour" placeholder="Hour" @change="changeHour" size="small" disabled>
            <el-option
                v-for="hour in orderedWorkingHour"
                :key="hour.attribute1"
                :label="hour.attribute1"
                :value="hour.attribute1">
            </el-option>
        </el-select>
        <template v-if="pEditFlag">
            <el-select v-model="hour" placeholder="Hour" @change="changeHour" size="small" :disabled="pCheckDate.current_date >= planDateFormat">
                <el-option
                    v-for="hour in orderedWorkingHour"
                    :key="hour.attribute1"
                    :label="hour.attribute1"
                    :value="hour.attribute1">
                </el-option>
            </el-select>
        </template>
    </div>
</template>
<script>
    import moment from "moment";
    export default {
        props:['pPlanDate', 'pWorkingHour', 'pWorkingHourEdit', 'pEditFlag', 'pCheckDate'],
        data() {
            return {
                planDate: this.pPlanDate,
                hour: Number(this.pPlanDate.working_hour),
                workingHour: [],
                workingHourEdit: this.pWorkingHourEdit,
                oldWkh: this.pPlanDate.working_hour,
                planDateFormat: moment(this.pPlanDate.res_plan_date, 'DD-MM-YYYY').format('YYYY-MM-DD'),
            }
        },
        mounted() {
        },
        watch: {
            'planDate.working_hour': function(newValue) {
                return this.planDate.working_hour = this.planDate['holiday_flag'] == null || this.planDate['eam_pm_flag'] == null || this.planDate['eam_dt_flag'] == null ? newValue: 0;
            },
            'pEditFlag': function(newValue) {
                if (newValue == false) {
                    this.hour = this.oldWkh;
                    this.planDate.working_hour = this.oldWkh;
                    // Vue.set(this.workingHourEdit, this.planDate.res_plan_date, Number(this.oldWkh));
                }
            },
        },
        methods: {
            changeHour(){
                var vue = this;
                console.log( vue.planDate.working_hour);
                vue.oldWkh = vue.planDate.working_hour;
                vue.planDate.working_hour = vue.hour;
                //Stamp ที่มีการแก้ไข resPlanDate
                Vue.set(vue.workingHourEdit, vue.planDate.res_plan_date, Number(vue.hour));
            }
        },
        computed: {
            orderedWorkingHour: function () {
                return _.orderBy(this.pWorkingHour, ['attribute1'])
            },
        },
    }
</script>