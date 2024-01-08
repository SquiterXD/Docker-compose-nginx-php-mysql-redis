<template>
    <div>
        <!-- <el-input-number v-if="!editFlag" v-model="line.machine_eamperformance" :min="0" :max="100" size="small" disabled>
        </el-input-number>
        <el-input-number v-else v-model="line.machine_eamperformance" :min="0" :max="100" size="small" @change="changeEfficiencyMachineByLine()" @blur="changeEfficiencyMachineByLine()">
        </el-input-number> -->

        <vue-numeric v-if="!editFlag"
            separator="," 
            v-bind:precision="2" 
            v-bind:minus="false"
            class="form-control input-sm text-right"
            v-model="line.machine_eamperformance"
            disabled
        ></vue-numeric>
        <vue-numeric v-else
            separator="," 
            v-bind:precision="2" 
            v-bind:minus="false"
            :min="0"
            :max="100"
            class="form-control input-sm text-right"
            v-model="line.machine_eamperformance"
            @change="changeEfficiencyMachineByLine()"
            @blur="changeEfficiencyMachineByLine()"
        ></vue-numeric>
    </div>
</template>
<script>
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
            VueNumeric
        },
        props:['editFlag', 'line', 'lineMachineEdit'],
        data() {
            return {
                oldEamMachine: this.line.machine_eamperformance ?? 0,
            }
        },
        mounted() {
        },
        watch: {
            'editFlag': function(newValue) {
                if (newValue == false) {
                    this.line.machine_eamperformance = Number(this.oldEamMachine);
                    // this.changeEfficiencyMachineByLine()
                }
            },
        },
        // computed: {
        //     machine_eamperformance: function () {
        //         var vue = this;
        //         Object.values(vue.eamperformanceMachines).filter(function(eam, index){
        //             return  eam[vue.line.machine_description];
        //         });
        //     }
        // },
        methods: {
            changeEfficiencyMachineByLine(){
                var vue = this;
                //efficiency_machine_per_min
                let d = Number(vue.line.machine_speed) * (Number(vue.line.machine_eamperformance) / 100);
                //efficiency_product
                // vue.resPlanDate.filter(function(planDate){
                //     let f = (Number(d) * (Number(planDate.working_hour)-1)*60) ;
                //     let r = (Number(f)*(Number(vue.efficiency_product)/100))/1000000;
                //     // this.result = Number(r.toFixed(3));
                //     Object.values(vue.efficiencyProducts[planDate.res_plan_date_display]).filter(function(res, value) {
                //         vue.efficiencyProducts[planDate.res_plan_date_display][vue.line[machineGroup][index].machine_description] = Number(r.toFixed(3));
                //     });
                // });
                //result
                vue.line.efficiency_machine_per_min = d;
                //Stamp line ที่มีการแก้ไขจำนวน Efficiency
                Vue.set(vue.lineMachineEdit, vue.line.machine_name, Number(vue.line.machine_eamperformance));
            },
        }
    }
</script>