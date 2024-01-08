<template>
    <div>
        <vue-numeric
            v-bind:precision="2" 
            v-bind:minus="false"
            :min="0"
            :max="9999999999"
            class="form-control input-sm text-right"
            v-model="amount"
            @change="changeInputAmount()"
            @blur="changeInputAmount()"
        ></vue-numeric>
    </div>
</template>
<script>
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
           VueNumeric
        },
        props:['department', 'pBudgetBiWeekly'],
        data() {
            return {
                amount: 0,
                budgetBiWeekly: this.pBudgetBiWeekly,
            }
        },
        mounted() {
            this.changeInputAmount();
        },
        methods: {
            changeInputAmount(){
                var vm = this;
                // Stamp ที่มีการระบุ amount
                Vue.set(vm.budgetBiWeekly, vm.department.department_code+'|'+vm.department.employee_type+'|budget', vm.amount);
            }
        },
    }
</script>