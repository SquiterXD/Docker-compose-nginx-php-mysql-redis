<template>
    <div>
        <span> {{ efficiency | number2Digit }} </span>
    </div>
</template>
<script>
    export default {
        props:['pEfficiencyProducts', 'pLines', 'pPlanDate', 'pMachineGroup', 'pTotalProductArr', 'pMachineMaintenances', 'pMachineDowntimes'],
        data() {
            return {
                efficiency: 0,
                efficiencyProducts: this.pEfficiencyProducts,
                lines: this.pLines,
                planDate: this.pPlanDate,
                machineGroup: this.pMachineGroup,
                productArr: this.pTotalProductArr,
                machineMaintenances: this.pMachineMaintenances,
                machineDowntimes: this.pMachineDowntimes,
            }
        },
        mounted() {
            //
        },
        watch: {
            product: function(newValue) {
                return newValue;
            },
            productToLine: function(newValue) {
                return newValue;
            },
        },
        computed: {
            product: function () {
                var vue = this;
                var result = 0;
                Object.values(vue.lines[vue.machineGroup]).filter(function(line, index){
                    if (vue.machineMaintenances[vue.planDate.res_plan_date_display][line.machine_name]
                        || vue.machineDowntimes[vue.planDate.res_plan_date_display][line.machine_name]
                        || vue.planDate.working_hour == 0) {
                        // vue.planDate.holiday_flag == 'Y'
                       result += 0;
                    }else{
                        result += Number(vue.efficiencyProducts[vue.planDate.res_plan_date_display][line.machine_name]);
                    }
                    return;
                });
                vue.efficiency = Number(result);
            },
            //return ค่าไปยัง line --total all line
            productToLine: function () {
                var vue = this;
                var result = [];
                Object.values(vue.lines[vue.machineGroup]).reduce(function(res, line) {
                    if (!res[vue.machineGroup]) {
                        res[vue.machineGroup] = { total: 0 };
                        result.push(res[vue.machineGroup]);
                    }
                    if (vue.machineMaintenances[vue.planDate.res_plan_date_display][line.machine_name]
                        || vue.machineDowntimes[vue.planDate.res_plan_date_display][line.machine_name]
                        || vue.planDate.working_hour == 0) {
                        // vue.planDate.holiday_flag == 'Y'
                       res[vue.machineGroup].total += 0;
                    }else{
                        res[vue.machineGroup].total += Number(vue.efficiencyProducts[vue.planDate.res_plan_date_display][line.machine_name]);
                    }
                    return res;
                }, {});
                Vue.set(vue.productArr, vue.machineGroup+vue.planDate.res_plan_date_display, result);
            }
        },
    }
</script>