<template>
    <div>
        <el-select v-model="hour" placeholder="Hour" @change="changeHour" size="small" :disabled="!canEdit">
            <el-option
                v-for="hour in workingHoliday"
                :key="hour.attribute1"
                :label="hour.attribute1"
                :value="hour.attribute1">
            </el-option>
        </el-select>
    </div>
</template>
<script>
    import moment from "moment";
    export default {
        props:['plan', 'workingHoliday', 'pWorkingHourEdit', 'canEdit'],
        data() {
            return {
                hour: this.plan.working_hour,
                workingHour: [],
                workingHourEdit: this.pWorkingHourEdit,
                oldWkh: this.plan.working_hour,
            }
        },
        mounted() {
        },
        methods: {
            changeHour(){
                var vm = this;
                console.log( vm.plan.working_hour);
                vm.oldWkh = vm.plan.working_hour;
                vm.plan.working_hour = vm.hour;
                // Stamp ที่มีการแก้ไข working hour
                Vue.set(vm.workingHourEdit, vm.plan.biweekly_id+'|'+vm.plan.division_code+'|'+vm.plan.working_date, Number(vm.hour));
            }
        },
        computed: {
            orderedWorkingHour: function () {
                return _.orderBy(this.workingHoliday, ['attribute1'])
            },
        },
        watch: {
            'canEdit': function(newValue) {
                if (newValue == false) {
                    this.plan.working_hour = this.oldWkh;
                    this.hour = this.oldWkh;
                }
            },
        },
    }
</script>