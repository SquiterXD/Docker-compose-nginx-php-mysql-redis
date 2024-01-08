<template>
    
        <tr v-loading="loading">
            <td class="text-center">
                <button type="button" class="btn btn-light btn-sm" >
                    <i class="fa fa-arrows-v my-handle fa-2x"></i>
                </button>
            </td>
            <td class="text-center"> {{ index + 1 }} </td>
            <td width="100px" style="padding-bottom: 2px;">
                <div>
                    <el-select class="w-100" name="item[]" v-model="selectedItem" @change="selItem" size="medium" placeholder="รหัสบุหรี่" clearable filterable remote ref="item_code" :disabled="enable" :popper-append-to-body="false">
                        <el-option
                            v-for="item in orderedItem"
                            :key="item.item_code"
                            :label="item.item_code+' : '+item.item_description"
                            :value="item.item_code"
                        >
                        </el-option>
                    </el-select>
                </div>
                <div :id="'el_explode_item_code'+index" class="error_msg text-left"></div>
            </td>
            <!-- <td>
                <div>
                    <el-input placeholder="ตราบุหรี่" v-model="description" style="width:100%;" size="medium" disabled></el-input>
                </div>
            </td> -->
            <td class="text-right">
                <!-- <el-input-number name="item_efficiency[]" v-model="itemLine.item_efficiency" :min="0.000" :max="99999" style="width:100%;" size="small" :disabled="!valid" @change="addItemEfficiency" @blur="addItemEfficiency()" ref="item_efficiency" onkeydown="return event.key != 'Enter';">
                </el-input-number> -->

                <vue-numeric :style="'width: 100%; ' + (errors.item_efficiency? 'border: 1px solid red;' : '')"
                    name="item_efficiency[]"
                    v-bind:minus="false"
                    v-bind:precision="2"
                    :min="0"
                    :max="999999999"
                    class="form-control input-sm text-right"
                    v-model="itemLine.item_efficiency"
                    :disabled="!valid"
                    autocomplete="off"
                    @change="addItemEfficiency"
                    @blur="addItemEfficiency()"
                ></vue-numeric>
                <!-- onkeydown="return event.key != 'Enter';" -->
                <span :id="'el_explode_item_efficiency'+index" class="error_msg text-center"></span>
            </td>
            <td style="text-align: center;">
                <button class="btn btn-md btn-danger" onkeydown="return event.key != 'Enter';" @click="remove(itemLine)">
                    <i class="fa fa-trash-o"></i>
                </button>
            </td>
        </tr>
    <!-- </draggable> -->
</template>

<script>
import uuidv1 from 'uuid/v1';
import VueNumeric from 'vue-numeric';
export default {
    props: ["index", "attribute", "listItemCigarettes", "listItemLines", "pValid"],
    components: {
            VueNumeric
        },
    data() {
        return {
            loading: false,
            valid: true,
            errors: {
                item_code: false,
                item_efficiency: false
            },
            itemLine: this.attribute,
            items: this.listItemCigarettes,
            selectedItem: this.attribute.item_code,
            description: this.attribute.item_description,
            enable: this.attribute.is_enable,
        };
    },
    mounted() {
        // this.addItemEfficiency();
    },
    computed: {
        orderedItem: function () {
            return _.orderBy(this.listItemCigarettes, ['item_code']);
        }
    },
    watch: {
        errors: {
            handler(val){
                val.item_code? this.setError('item_code') : this.resetError('item_code');
                // val.item_efficiency? this.setError('item_efficiency') : this.resetError('item_efficiency');
            },
            deep: true,
        },
    },
    methods: {
        decimal(number) {
            return Number(number).toLocaleString(undefined, { minimumFractionDigits: 2 });
        },
        selItem(){
            var vm = this;
            var form = $('#plan-daily-form');
            vm.valid = true;
            let errorMsg = '';
            if (!vm.valid) {
                return;
            }
            vm.addItemEfficiency();
            if (vm.selectedItem == '' || vm.selectedItem == null) {
                vm.itemLine.item_efficiency = 0;
                vm.itemLine.item_id = '';
                vm.itemLine.item_code = vm.itemLine.description = vm.description = '';
                return ;
            }
            vm.itemLine.item_code = vm.selectedItem;
            vm.items.filter(item => {
                if (item.item_code == vm.selectedItem) { 
                    vm.itemLine.item_id = item.inventory_item_id;
                    vm.itemLine.item_description = vm.description = item.item_description;
                    return ;
                }
            });
        },
        addItemEfficiency(){
            var vm = this;
            var form = $('#plan-daily-form');
            let errorMsg = '';
            vm.errors.item_efficiency = false;
            $(form).find("span[id='el_explode_item_efficiency"+vm.index+"']").html("");
            if (vm.selectedItem) {
                vm.listItemLines.filter(item => {
                    if (item.item_efficiency == 0) {
                        vm.errors.item_efficiency = true;
                        errorMsg = "ระบุปริมาณสั่งผลิตมากกว่า 0";
                        $(form).find("span[id='el_explode_item_efficiency"+vm.index+"']").html(errorMsg);
                    }
                });
            }
            // this.itemLine.item_efficiency = Math.floor(Number(this.itemLine.item_efficiency) * 100) / 100; 
        },
        setError(ref_name){
            let ref = this.$refs[ref_name].$refs.reference 
                    ? this.$refs[ref_name].$refs.reference.$refs.input 
                    : (this.$refs[ref_name].$refs.textarea 
                        ? this.$refs[ref_name].$refs.textarea 
                        : (this.$refs[ref_name].$refs.input.$refs 
                            ? this.$refs[ref_name].$refs.input.$refs.input 
                            : this.$refs[ref_name].$refs.input ));
            ref.style = "border: 1px solid red;";
        },
        resetError(ref_name){
            let ref = this.$refs[ref_name].$refs.reference 
                    ? this.$refs[ref_name].$refs.reference.$refs.input 
                    : (this.$refs[ref_name].$refs.textarea 
                        ? this.$refs[ref_name].$refs.textarea
                        : (this.$refs[ref_name].$refs.input.$refs 
                            ? this.$refs[ref_name].$refs.input.$refs.input 
                            : this.$refs[ref_name].$refs.input ));
            ref.style = "";
        },
        remove(itemLine) {
            this.$emit("removeRow", itemLine);
        },

    },
}
</script>
<style type="text/css" media="screen">
    div.el-dialog__body{
        padding-left: 50px;
        padding-right: 50px;
        padding-top: 5px;
        padding-bottom: 5px;
        color: #000;
        font-size: 15px;
    }
</style>
