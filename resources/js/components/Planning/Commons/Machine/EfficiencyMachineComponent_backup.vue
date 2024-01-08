<template>
    <div>
        <!-- <el-input placeholder="Performance" v-model="line.machine_eamperformance" size="small"></el-input> -->
        <el-input-number v-model="line.machine_eamperformance" :min="1" :max="99999" size="small">
    </div>
</template>
<script>
    export default {
        props:['pLine', 'pEfficiency', 'pEamperformanceMachines'],
        data() {
            return {
                line: this.pLine,
                eamperformanceMachines: this.pEamperformanceMachines
            }
        },
        mounted() {
        },
        watch: {
            machine_eamperformance: function(newValue) {
                return this.line.machine_eamperformance = newValue;
            },
        },
        computed: {
            machine_eamperformance: function () {
                var vue = this;
                Object.values(vue.eamperformanceMachines).filter(function(eam, index){
                    return  eam[vue.line.machine_description];
                });
            }
        },
    }
</script>