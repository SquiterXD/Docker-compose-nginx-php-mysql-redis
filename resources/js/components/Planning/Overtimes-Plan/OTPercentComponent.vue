<template>
    <div>
        <vue-numeric
            v-bind:precision="2" 
            v-bind:minus="false"
            :min="0"
            :max="100"
            class="form-control input-sm text-right"
            v-model="percent"
            :disabled="canEdit"
            @change="changeOTPercent()"
            @blur="changeOTPercent()"
        ></vue-numeric>
    </div>
</template>
<script>
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
           VueNumeric
        },
        props:['plan', 'time', 'otPercent', 'value', 'pOtPercentEdit', 'canEdit'],
        data() {
            return {
                percent: this.value,
                otPercentEdit: this.pOtPercentEdit,
                oldPercent: this.value,
            }
        },
        mounted() {
        },
        methods: {
            changeOTPercent(){
                var vm = this;
                vm.oldPercent = vm.value;
                vm.otPercent[vm.time][vm.plan.ot_plan_id] = vm.percent;
                // Stamp ที่มีการแก้ไข OT Percent
                Vue.set(vm.otPercentEdit, vm.time+'|'+vm.plan.department_code+'|'+vm.plan.employee_type, vm.percent);
            }
        },
    }
</script>