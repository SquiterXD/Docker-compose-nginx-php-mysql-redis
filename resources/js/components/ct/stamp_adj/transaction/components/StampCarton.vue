<template>
    <div class="text-right">
        <vue-numeric v-if="editFlag" style="width: 100%"
            separator="," 
            v-bind:precision="2" 
            v-bind:minus="false"
            :min="0"
            :max="99999999999"
            class="form-control input-sm text-right"
            v-model="line.order_quantity_carton"
            @change="inputStampCarton()"
            @blur="inputStampCarton()"
        ></vue-numeric>
        <div v-else style="width: 100%;"> {{ line.order_quantity_carton | number2Digit }} </div>
    </div>
</template>
<script>
    import moment from "moment";
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
            VueNumeric
        },
        props:['line', 'editFlag', 'lineStampEdit'],
        data() {
            return {
                oldCartonQty: this.line.order_quantity_carton,
            }
        },
        mounted() {
            //
        },
        watch: {
            'editFlag': function(newValue) {
                if (newValue == false) {
                    this.line.order_quantity_carton = Number(this.oldCartonQty);
                }
            },
        },
        methods: {
            inputStampCarton(){
                var vm = this;
                Vue.set(vm.lineStampEdit, vm.line.item_code+'|'+vm.line.item_description, Number(vm.line.order_quantity_carton));
            },
        }
    }
</script>