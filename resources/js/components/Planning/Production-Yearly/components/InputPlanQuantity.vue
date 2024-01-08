<template>
    <div>
        <!-- planning_qty -->
        <template v-if="!canEdit">
            <span> {{ line.planning_qty | number3Digit }} </span>
        </template>
        <template v-else>
            <vue-numeric
                separator="," 
                v-bind:precision="2"
                :min="0"
                :max="9999999999"
                v-bind:minus="false"
                class="form-control input-sm text-right"
                v-model="line.planning_qty"
                @change="changeTotalQuantity()"
                @blur="changeTotalQuantity()"
            ></vue-numeric>
        </template>
    </div>
</template>
<script>
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
            VueNumeric
        },
        props:['line', 'totalPlanChangeData', 'canEdit', 'estByBrandData', 'periods', 'periodCal'],
        data() {
            return {
                oldTotalQty: this.line.planning_qty,
            }
        },
        mounted() {
        },
        watch: {
            'editFlag': function(newValue) {
                if (newValue == false) {
                    this.line.planning_qty = Number(this.oldTotalQty);
                    this.changeTotalQuantity()
                }
            },
        },
        methods: {
            changeTotalQuantity(){
                var vm = this;
                //calculate update total_qty
                let result = Number(vm.line.planning_qty) / Number(vm.line.define_product_cigaret);
                //result
                vm.line.total_qty = result;
                //Stamp line ที่มีการแก้ไขจำนวน total_qty
                Vue.set(vm.totalPlanChangeData, vm.line.period_no+'|'+vm.line.item_code, Number(vm.line.planning_qty));

                // ----------------------- CAL BAL_ONHAND_QTY -------------------------------
                // Current Input change
                let current_onhand = Number(vm.line.begin_onhand_qty);
                let begin_onhand_first = 0;
                let prev_period = '';
                let i = 0;
                //next period
                Object.keys(vm.periods).filter(function(period, index){
                    i = index-1;
                    prev_period = vm.periodCal[i];
                    // calculate
                    let begin_onhand_next = 0;
                    if (index == 0) {
                        begin_onhand_first = (Number(vm.estByBrandData[period][vm.line.item_code].begin_onhand_qty) + Number(vm.estByBrandData[period][vm.line.item_code].planning_qty)) - Number(vm.line.forcast_qty);
                        vm.estByBrandData[period][vm.line.item_code].bal_onhand_qty = Number(begin_onhand_first);
                    }
                    else{
                        let bal_onhand_qty = vm.estByBrandData[prev_period][vm.line.item_code].bal_onhand_qty? Number(vm.estByBrandData[prev_period][vm.line.item_code].bal_onhand_qty): 0;
                        let planning_qty = vm.estByBrandData[period][vm.line.item_code].planning_qty? Number(vm.estByBrandData[period][vm.line.item_code].planning_qty): 0;
                        let forcast_qty = vm.estByBrandData[period][vm.line.item_code].forcast_qty? Number(vm.estByBrandData[period][vm.line.item_code].forcast_qty): 0;
                            console.log(prev_period); console.log(vm.line.item_code); console.log(bal_onhand_qty);
                            begin_onhand_next = (bal_onhand_qty + planning_qty) - forcast_qty;
                            vm.estByBrandData[period][vm.line.item_code].bal_onhand_qty = Number(begin_onhand_next);
                    }
                });



            },
        }
    }
</script>