<template>
    <tr v-loading="loading">
        <td class="text-center"> {{ index + 1 }} </td>
        <td width="100px" style="padding-bottom: 2px;">
            <div>
                <el-select class="w-100" name="item[]" v-model="selectedItem" @change="selItem" size="medium" placeholder="รหัสบุหรี่/ยาเส้น" clearable filterable remote ref="item_code" :popper-append-to-body="false" :disabled="enable">
                    <el-option
                        v-for="item in items"
                        :key="item.item_code+' : '+item.item_description"
                        :label="item.item_code+' : '+item.item_description"
                        :value="item.item_code"
                    >
                    </el-option>
                </el-select>
            </div>
            <span :id="'el_explode_item_code'+index" class="error_msg text-left"></span>
        </td>
        <td width="100px" style="padding-bottom: 2px;">
            <div>
                <el-input size="medium" ref="item_desc"
                    v-model="itemLine.item_description" :disabled="enable"
                > </el-input>
            </div>
            <span :id="'el_explode_item_desc'+index" class="error_msg text-left"></span>
        </td>
        <td class="text-right">
            <vue-numeric style="width: 100%;"
                name="item_quantity[]"
                v-bind:minus="false"
                v-bind:precision="2"
                :min="0"
                :max="999999999"
                class="form-control input-sm text-right"
                v-model="itemLine.item_quantity"
                autocomplete="off"
                :disabled="enable"
            ></vue-numeric>
            <span :id="'el_explode_item_quantity'+index" class="error_msg text-center"></span>
        </td>
        <td class="text-right">
            <vue-numeric style="width: 100%;"
                name="item_price[]"
                v-bind:minus="false"
                v-bind:precision="7"
                :min="0"
                :max="999999999"
                class="form-control input-sm text-right"
                v-model="itemLine.item_price"
                autocomplete="off"
                :disabled="enable"
            ></vue-numeric>
            <span :id="'el_explode_item_price'+index" class="error_msg text-center"></span>
        </td>
        <td style="text-align: center;">
            <button type="button" class="btn btn-md btn-danger" onkeydown="return event.key != 'Enter';" @click="remove(itemLine)">
                <i class="fa fa-trash-o"></i>
            </button>
        </td>
    </tr>
</template>

<script>
import uuidv1 from 'uuid/v1';
import VueNumeric from 'vue-numeric';
export default {
    props: ["index", "attribute", 'listStamp', "listItemLines"],
    components: {
            VueNumeric
        },
    data() {
        return {
            loading: false,
            valid: true,
            errors: {
                item_code: false,
                item_desc: false,
            },
            itemLine: this.attribute,
            items: this.listStamp,
            selectedItem: this.attribute.item_code,
            description: this.attribute.item_description,
            enable: this.attribute.enable,
        };
    },
    mounted() {
        //
    },
    watch: {
        errors: {
            handler(val){
                val.item_code? this.setError('item_code') : this.resetError('item_code');
                val.item_desc? this.setError('item_desc') : this.resetError('item_desc');
            },
            deep: true,
        },
    },
    methods: {
        selItem(){
            var vm = this;
            var form = $('#add-stamp-form');
            let errorMsg = '';
            vm.errors.item_code = false;
            vm.errors.item_desc = false;

            vm.items.filter(item => {
                if (vm.selectedItem != '' && item.item_code == vm.selectedItem) {
                    vm.itemLine.item_code = item.item_code;
                    vm.itemLine.item_description = vm.description = item.item_description;
                    vm.itemLine.item_quantity = 0;
                    vm.itemLine.item_price = 0;
                }
            });

            if (vm.description != '' || vm.description != null) {
                vm.listItemLines.filter(item2 => {
                    if (item2.id != vm.attribute.id && item2.item_description == vm.description) {
                        // Msg
                        vm.errors.item_desc = true;
                        errorMsg = "ไม่สามารถระบุรายละเอียดซ้ำได้";
                        $(form).find("span[id='el_explode_item_desc"+vm.index+"']").html(errorMsg);
                    }
                });
            }
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
