<template>
    <div class="text-right">
        <!-- && canEdit -->
        <vue-numeric v-if="editFlag" style="width: 100%"
                name="receive_roll_qty"
                separator="," 
                v-bind:precision="2" 
                v-bind:minus="false"
                :min="0"
                :max="99999999999"
                class="form-control input-sm text-right"
                v-model="line.receive_roll_qty"
                @change="changeReceiveQty()"
                @blur="changeReceiveQty()"
        ></vue-numeric>
        <div v-else style="width: 100%;"> {{ Number(line.receive_roll_qty).toFixed(2) }} </div>
    </div>
</template>
<script>
    import moment from "moment";
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
            VueNumeric
        },
        props:['stamp', 'line', 'editFlag', 'lineRollDailyEdit'],
        data() {
            return {
                oldWeeklyReceiveQty: this.line.weekly_receive_qty,
                oldRollReceiveQty: this.line.receive_roll_qty,
                oldReceiptAmount: this.line.receipt_amount,
                canEdit: false,
            }
        },
        mounted() {
            this.checkCanEdit();
        },
        watch: {
            'editFlag': function(newValue) {
                if (newValue == false) {
                    this.line.weekly_receive_qty = Number(this.oldWeeklyReceiveQty);
                    this.line.receive_roll_qty = Number(this.oldRollReceiveQty);
                    this.line.receipt_amount = Number(this.oldReceiptAmount);
                }
            },
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
                let result = Number(vm.line.receive_roll_qty) * Number(vm.stamp.stamp_per_roll);
                vm.line.weekly_receive_qty = result.toFixed(2);
                let receipt_amount = vm.line.weekly_receive_qty * Number(vm.stamp.unit_price);
                vm.line.receipt_amount = receipt_amount.toFixed(2);
                Vue.set(vm.lineRollDailyEdit, vm.line.follow_date, Number(vm.line.receive_roll_qty));
            },
            checkCanEdit(){
                let follow_date = moment(this.line.follow_date).format('YYYY-MM-DD');
                let curr_date = moment().format('YYYY-MM-DD');
                if (follow_date > curr_date) {
                    this.canEdit = true;
                }
            },
        }
    }
</script>