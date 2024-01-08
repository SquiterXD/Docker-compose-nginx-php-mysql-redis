<template>
    <div>
        <!-- planning_qty -->
        <template v-if="!canEdit">
            <span> {{ line.total_qty | number3Digit }} </span>
        </template>
        <template v-else>
            <!-- <el-input-number v-model="line.total_qty" :min="0" :max="9999999999" size="small" @change="changeTotalQuantity()" @blur="changeTotalQuantity()">
            </el-input-number> -->
            <vue-numeric
                separator="," 
                :min="0"
                v-bind:precision="2"
                :max="9999999999"
                v-bind:minus="false"
                class="form-control input-sm text-right"
                v-model="line.total_qty"
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
        props:['line', 'totalQtyChangeData', 'canEdit'],
        data() {
            return {
                oldTotalQty: this.line.total_qty,
            }
        },
        mounted() {
        },
        watch: {
            'editFlag': function(newValue) {
                if (newValue == false) {
                    this.line.total_qty = Number(this.oldTotalQty);
                    this.changeTotalQuantity()
                }
            },
        },
        methods: {
            changeTotalQuantity(){
                var vm = this;
                //calculate
                let result = Number(vm.line.total_qty) * Number(vm.line.define_product_cigaret);
                //result
                vm.line.planning_qty = result;
                //Stamp line ที่มีการแก้ไขจำนวน total_qty
                Vue.set(vm.totalQtyChangeData, vm.line.period_no+'|'+vm.line.item_code, Number(vm.line.total_qty));
            },
        }
    }
</script>