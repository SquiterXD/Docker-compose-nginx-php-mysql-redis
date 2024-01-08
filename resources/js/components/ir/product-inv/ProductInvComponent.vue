<template>
    <div>
        <div class="row">
            <div class="col-md" style="margin-left: 5px;">
                <label class="demonstration">
                    กลุ่มสินค้า (Product Group)
                </label>
                <input  type="hidden" name="group_code" v-model="groupCode" >
                <div class="input-group">
                    <el-select  v-model="groupCode" filterable remote clearable reserve-keyword 
                                placeholder="Select" 
                                class="w-100"
                                @change="createLine">
                        <el-option
                            v-for="groupProduct in groupProducts"
                            :key="groupProduct.group_product_id"
                            :label="groupProduct.policy_set_number + ' : ' + groupProduct.asset_group_description + ' : ' + groupProduct.group_product_description"
                            :value="groupProduct.group_product_id">
                        </el-option>
                    </el-select>
                </div>
            </div> 
        </div>
        <div v-if="this.create" class="mt-2">
            <productLine    :group-code         ="groupCode"
                            :back-url           ="url"
                            :oldInput           ="oldInput"
                            :btnTrans           ="btnTrans">
            </productLine>
        </div>
    </div>
</template>

<script>

import productLine from './ProductInvLineComponent.vue'

export default {
    components: { productLine },
    props: ['groupProducts', 'policySets',
            'subInventories', 'departments', 'url', 
            'oldGroupCode', 'data', 'oldInput', 'btnTrans'],

    data() {
        return {
            groupCode: this.oldGroupCode ? this.oldGroupCode : '',
            create: false,
            selectGroup: [],
        }

    },
    mounted() {
        if (this.groupCode) {
            this.createLine();
        }

        if(this.oldInput.length != 0){
            this.groupCode = this.oldInput.group_code;
            this.createLine();
        }

        if (this.data == "DuplicateHeader") {
            swal({
                    title: "warning !",
                    text: "มีข้อมูลซ้ำ ระดับ header",
                    type: "warning",
                    showConfirmButton: true
            });
        }else if (this.data == "DuplicateLine") {
            swal({
                    title: "warning !",
                    text: "มีข้อมูลซ้ำ ระดับ Line",
                    type: "warning",
                    showConfirmButton: true
            });
        }
    },
    methods: {
        createLine(){
            this.create = true;
        },
    },
}
</script>