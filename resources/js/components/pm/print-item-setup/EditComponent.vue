<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <input type="hidden" name="pm_print_set_id" v-model="pmPrintSetId">
                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>รหัสสินค้า</label><span class="text-danger"> *</span>
                        <input type="hidden" name="inventory_item_id" v-model="itemInventory">
                        <el-select  v-model="itemInventory" clearable filterable 
                                    placeholder="รหัสสินค้า" 
                                    class="w-100"
                                    disabled>
                            <el-option
                                v-for   ="itemNumber in itemNumberList"
                                :key    ="itemNumber.inventory_item_id"
                                :label  ="itemNumber.item_number + ' : ' + itemNumber.item_desc"
                                :value  ="itemNumber.inventory_item_id">
                            </el-option>
                        </el-select>
                    </div>
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>ขนาดบุหรี่</label>
                        <input type="hidden" name="tobacco_size" v-model="tobaccoSize">
                        <el-select  v-model="tobaccoSize" clearable filterable 
                                    placeholder="ขนาดบุหรี่" 
                                    class="w-100"
                                    disabled>
                            <el-option
                                v-for   ="(size,index) in sizeList"
                                :key    ="index"
                                :label  ="size.meaning"
                                :value  ="size.lookup_code">
                            </el-option>
                        </el-select>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>Brand</label><span class="text-danger"> *</span>
                        <input type="hidden" name="brand" v-model="brand">
                        <el-input placeholder="โปรดกรอก Brand" v-model="brand"></el-input>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>Brand Color</label><span class="text-danger"> *</span>
                        <input type="color" class="form-control col-12" name="brand_colors" :value="this.printItemSetup.brand_colors">
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>Product</label><span class="text-danger"> *</span>
                        <input type="hidden" name="product" v-model="product">
                        <el-input placeholder="โปรดกรอก Product" v-model="product"></el-input>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>Product Color</label><span class="text-danger"> *</span>
                        <input type="color" class="form-control col-12" name="product_colors" :value="this.printItemSetup.product_colors">
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>ระบบการพิมพ์</label>
                        <input type="hidden" name="print_type" v-model="printType">
                        <el-select  v-model="printType" clearable filterable 
                                    placeholder="Print Type" 
                                    class="w-100">
                            <el-option
                                v-for   ="(printType,index) in printTypeList"
                                :key    ="index"
                                :label  ="printType.description"
                                :value  ="printType.lookup_code">
                            </el-option>
                        </el-select>
                    </div>                        
                </div>

                <div class="row" style="margin-left: 110px; margin-right: 110px; padding-top: 15px;">
                    <div class="col">
                        <label>เปิดการใช้งาน</label>
                        <input type="hidden" name="enabled_flag" v-model="enabledFlag">
                        <el-checkbox    v-model="enabledFlag" 
                                        class="w-100"></el-checkbox>
                    </div>                                          
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            "printItemSetup",
            "itemNumberList",
            "sizeList",
            "printTypeList"
        ],

        mounted() {
            
        },

        data() {
            return {
                enabledFlag: this.printItemSetup.enable_flag == 'Y' ? true : false,
                itemInventory: this.printItemSetup ? this.printItemSetup.inventory_item_id : '',
                tobaccoSize: this.printItemSetup ? this.printItemSetup.tobacco_size : '',
                brand: this.printItemSetup ? this.printItemSetup.brand : '',
                product: this.printItemSetup ? this.printItemSetup.product : '',
                pmPrintSetId: this.printItemSetup.pm_print_set_id,
                printType: this.printItemSetup.print_type ? this.printItemSetup.print_type: ''
            };
        },

        methods: {
           
        }
    }
</script>