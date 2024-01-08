<template>
    <div>
        <template v-if="!canEdit">
            <span> {{ line.begin_onhand_qty | number3Digit }} </span>
        </template>
        <template v-else>
            <!-- <el-input-number v-model="line.begin_onhand_qty" :min="0" :max="9999999999" size="small" @change="changeOnhandQuantity()" @blur="changeOnhandQuantity()">
            </el-input-number> -->
            <vue-numeric
                separator="," 
                v-bind:precision="2"
                :min="0"
                :max="9999999999"
                v-bind:minus="false"
                class="form-control input-sm text-right"
                v-model="line.begin_onhand_qty"
                @change="changeOnhandQuantity()"
                @blur="changeOnhandQuantity()"
            ></vue-numeric>
        </template>
    </div>
</template>
<script>
    import VueNumeric from 'vue-numeric';
    export default {
        components: { VueNumeric },
        props:['line', 'estByBrandData', 'beginOnhandQtyChangeData', 'periods', 'periodCal', 'canEdit'],
        data() {
            return {
                oldBeginOnhandQty: this.line.begin_onhand_qty,
            }
        },
        mounted() {
            // this.changeOnhandQuantity();
        },
        watch: {
            'editFlag': function(newValue) {
                if (newValue == false) {
                    this.line.begin_onhand_qty = Number(this.oldBeginOnhandQty);
                    this.changeOnhandQuantity()
                }
            },
        },
        methods: {
            changeOnhandQuantity(){
                var vm = this;
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
                    vm.estByBrandData[period][vm.line.item_code].begin_onhand_qty = Number(current_onhand);
                    if (index == 0) {
                        begin_onhand_first = (current_onhand + Number(vm.estByBrandData[period][vm.line.item_code].planning_qty)) - Number(vm.line.forcast_qty);
                        vm.estByBrandData[period][vm.line.item_code].bal_onhand_qty = Number(begin_onhand_first);
                    }
                    else{
                        let bal_onhand_qty = vm.estByBrandData[prev_period][vm.line.item_code].bal_onhand_qty? Number(vm.estByBrandData[prev_period][vm.line.item_code].bal_onhand_qty): 0;
                        let planning_qty = vm.estByBrandData[period][vm.line.item_code].planning_qty? Number(vm.estByBrandData[period][vm.line.item_code].planning_qty): 0;
                        let forcast_qty = vm.estByBrandData[period][vm.line.item_code].forcast_qty? Number(vm.estByBrandData[period][vm.line.item_code].forcast_qty): 0;
                            console.log(bal_onhand_qty); console.log(planning_qty); console.log(forcast_qty);
                            begin_onhand_next = (bal_onhand_qty + planning_qty) - forcast_qty;
                            vm.estByBrandData[period][vm.line.item_code].bal_onhand_qty = Number(begin_onhand_next);
                    }
                });

                //Stamp line ที่มีการแก้ไขจำนวน Onhand
                Vue.set(vm.beginOnhandQtyChangeData, vm.line.item_code, Number(vm.line.begin_onhand_qty));
            },
        }
    }
</script>