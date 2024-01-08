<template>
    <div class="text-right">
        <vue-numeric v-if="editFlag" style="width: 100%"
            v-bind:precision="7" 
            v-bind:minus="false"
            :min="0"
            :max="999999999999999"
            class="form-control input-sm text-right"
            v-model="line.unit_price"
            @change="inputUnitPrice()"
            @blur="inputUnitPrice()"
        ></vue-numeric>
        <div v-else style="width: 100%;"> {{ Number(line.unit_price).toFixed(7) }} </div>
    </div>
</template>
<script>
    import moment from "moment";
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
            VueNumeric
        },
        props:['line', 'editFlag', 'linePriceEdit'],
        data() {
            return {
                oldUnitPrice: this.line.unit_price,
            }
        },
        mounted() {
            //
        },
        watch: {
            'editFlag': function(newValue) {
                if (newValue == false) {
                    this.line.unit_price = Number(this.oldUnitPrice);
                }
            },
        },
        methods: {
            inputUnitPrice(){
                var vm = this;
                Vue.set(vm.linePriceEdit, vm.line.item_code+'|'+vm.line.item_description, Number(vm.line.unit_price));
            },
        }
    }
</script>