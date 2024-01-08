<template>
    <div>
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-6">
                        <label class="w-100 text-left">
                            <strong> รหัสสินค้า </strong>
                        </label>
                        <input  type="hidden" 
                                name="search[inventory_item_id]" 
                                v-model="itemNumber" 
                                autocomplete="off">
                        <el-select  v-model="itemNumber" 
                                    placeholder="โปรดเลือก รหัสสินค้า"
                                    class="w-100"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword>
                            <el-option
                                v-for="(item,index) in itemNumberList"
                                :key="index"
                                :label="item.item_number + ' : ' + item.item_desc"
                                :value="item.inventory_item_id">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-6">
                        <label class="w-100 text-left">
                            <strong> ขนาดบุหรี่ </strong>
                        </label>
                        <input  type="hidden" 
                                name="search[size]" 
                                v-model="size" 
                                autocomplete="off">
                        <el-select  v-model="size" 
                                    placeholder="โปรดเลือก ขนาดบุหรี่"
                                    class="w-100"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword>
                            <el-option
                                v-for="(item,index) in sizeList"
                                :key="index"
                                :label="item.description"
                                :value="item.lookup_code">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="row" style="padding-top: 15px;">
                    <div class="col-4">
                        <label class="w-100 text-left">
                            <strong> Brand </strong>
                        </label>
                        <input  type="hidden" 
                                name="search[brand]" 
                                v-model="brand" 
                                autocomplete="off">
                        <el-select  v-model="brand" 
                                    placeholder="โปรดเลือก Brand"
                                    class="w-100"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword>
                            <el-option
                                v-for="(item,index) in brandList"
                                :key="index"
                                :label="item.brand"
                                :value="item.brand">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-4">
                        <label class="w-100 text-left">
                            <strong> Product </strong>
                        </label>
                        <input  type="hidden" 
                                name="search[product]" 
                                v-model="product" 
                                autocomplete="off">
                        <el-select  v-model="product" 
                                    placeholder="โปรดเลือก Product"
                                    class="w-100"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword>
                            <el-option
                                v-for="(item,index) in productList"
                                :key="index"
                                :label="item.product"
                                :value="item.product">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-4">
                        <label class="w-100 text-left">
                            <strong> ระบบการพิมพ์ </strong>
                        </label>
                        <input  type="hidden" 
                                name="search[printType]" 
                                v-model="printType" 
                                autocomplete="off">
                        <el-select  v-model="printType" 
                                    placeholder="โปรดเลือก ระบบการพิมพ์"
                                    class="w-100"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword>
                            <el-option
                                v-for="(item,index) in printTypeList"
                                :key="index"
                                :label="item.description"
                                :value="item.lookup_code">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="text-right" style="padding-top: 15px;">
                    <button :class="this.btnTrans.search.class">
                        <i :class="this.btnTrans.search.icon" aria-hidden="true"></i> {{ this.btnTrans.search.text }}
                    </button>
                    <a type="button" :href="'/pm/settings/print-item-setup'" :class="this.btnTrans.cancel.class">
                        ล้างค่า
                    </a>
                </div>
            </div>
        </div>

    </div>        

</template>

<script>
export default {
    props: ['itemNumberList', 'btnTrans', 'search', 
            'sizeList', 'brandList', 'productList', 
            'printTypeList'],
    data() {
        return {
            itemNumber: this.search.inventory_item_id != '' ? this.search.inventory_item_id : '',
            size: this.search.size != '' ? this.search.size : '',
            brand: this.search.brand != '' ? this.search.brand : '',
            product: this.search.product != '' ? this.search.product : '',
            printType: this.search.printType != '' ? this.search.printType : ''
        };
    },
    mounted() {
        
    },
    computed:{
        
    },
    methods: {
        
    }
};
</script>
