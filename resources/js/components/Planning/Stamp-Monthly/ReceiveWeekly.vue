<template>
    <div class="text-right">
        <vue-numeric v-if="approve"
            separator="," 
            v-bind:minus="false"
            class="form-control input-sm text-right"
            v-model="stamp.weekly_receive_qty"
            @change="changeReceiveQty()"
            @blur="changeReceiveQty()"
        ></vue-numeric>
        <!-- v-bind:precision="2"  -->
        <div v-else style="width: 100%;"> {{ decimal(stamp.weekly_receive_qty) }} </div>
    </div>
</template>
<script>
    import moment from "moment";
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
            VueNumeric
        },
        props:['stamp', 'index', 'lineWeeklyQty', 'changeData', 'approve'],
        data() {
            return {
            }
        },
        mounted() {
        },
        watch: {
        },
        methods: {
            decimal(number) {
                return Number(number).toLocaleString(undefined, { minimumFractionDigits: 2 });
            },
            formatNumber(number) {
                return Number(number).toLocaleString(undefined);
            },
            changeReceiveQty(){
                var vm = this;
                // Convert quantity daily
                let result = Number(vm.stamp.weekly_receive_qty) / Number(vm.stamp.stamp_per_roll);
                vm.stamp.receive_roll_qty = Number(result).toFixed(2);
                let receipt_amount = vm.stamp.weekly_receive_qty * Number(vm.stamp.unit_price);
                vm.stamp.receipt_amount = receipt_amount.toFixed(2);
                Vue.set(vm.lineWeeklyQty, vm.stamp.plan_date, Number(vm.stamp.weekly_receive_qty));
                vm.changeInput(vm.index, vm.stamp);
            },
            async changeInput(index, line) {
                let row = Object.keys(this.changeData).length;
                let data = JSON.parse(JSON.stringify(line));
                this.$set(this.changeData, index, data);
            },
        }
    }
</script>