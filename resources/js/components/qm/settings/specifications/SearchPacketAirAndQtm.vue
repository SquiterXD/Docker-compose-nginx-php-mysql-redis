<template>
    <div class="row form-group">
        <input type="hidden" name="test_type" v-model="testType">
        <div class="col-md-6">
            <div class="row">
                <label class="col-md-4 col-form-label"> ตราบุหรี่ </label>
                <div class="col-md-8">
                    <!-- <qm-el-select name="lot_number" id="input_lot_number" option-key="description" option-value="item_no"
                        option-label="description" :select-options="brands"
                        :value="pDefBrands"
                         /> -->
                    <el-select
                        v-model="selected.brand"
                        placeholder=""
                        class="w-100"
                        size="medium"
                        :clearable="true"
                        :filterable="true"
                        @change="showData"
                    >
                        <el-option
                            v-for="(item, index) in brands"
                            :key="index"
                            :label="item.item_number + ' : ' + item.item_desc"
                            :value="item.item_number"
                        >
                        </el-option>
                    </el-select>
                    <input type="hidden" name="lot_number" :value="selected.brand">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <label class="col-md-4 col-form-label"> ขนาดบุหรี่ </label>
                <div class="col-md-8">
                    <el-select
                        v-model="selected.productType"
                        placeholder=""
                        class="w-100"
                        size="medium"
                        :clearable="true"
                        :filterable="true"
                        @change="showData"
                    >
                        <el-option
                            v-for="(item, index) in productType"
                            :key="index"
                            :label="item.meaning"
                            :value="item.lookup_code"
                        >
                        </el-option>
                    </el-select>
                    <input type="hidden" name="product_type_code" :value="selected.productType">
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        props: [
            "pBrands", "pDefBrands", 'pProductType', 'pDefProductType', "pRequest"
        ],
        data() {
            return {
                brands: (this.pBrands != undefined && this.pBrands) ? this.pBrands : [],
                productType: (this.pProductType != undefined && this.pProductType) ? this.pProductType : [],
                selected: {
                    brand: (this.pDefBrands != undefined && this.pDefBrands) ? this.pDefBrands : null,
                    productType: (this.pDefProductType != undefined && this.pDefProductType) ? this.pDefProductType : null,
                },
                testType: this.pRequest.test_type
            };
        },
        watch: {
        },
        mounted() {
            this.showData();
        },
        methods: {
            async showData() {
                let vm = this;

                if (vm.selected.brand == '' || vm.selected.brand == undefined) {
                    vm.brands = (vm.pBrands != undefined && vm.pBrands) ? vm.pBrands : [];
                }

                if (vm.selected.productType == '' || vm.selected.productType == undefined) {
                    vm.productType = (vm.pProductType != undefined && vm.pProductType) ? vm.pProductType : [];
                }

                if (vm.selected.brand) {
                    let selBrand = vm.pBrands.filter(o => {
                        // return o.lot_number == vm.selected.brand;
                        return o.item_number == vm.selected.brand;
                    });
                    
                    if (selBrand.length > 0) {
                        selBrand = selBrand[0];
                        vm.productType = vm.pProductType.filter(o => {
                            // return o.lookup_code == selBrand.attribute1;
                            return o.lookup_code == selBrand.product_type_code;
                        })
                        // vm.selected.productType = selBrand.attribute1;
                        vm.selected.productType = selBrand.product_type_code;
                    }
                }


                if (vm.selected.productType) {
                    let selProductType = vm.pProductType.filter(o => {
                        return o.lookup_code == vm.selected.productType;
                    });

                    if (selProductType.length > 0) {
                        selProductType = selProductType[0];

                        vm.brands = vm.pBrands.filter(o => {
                            // return o.attribute1 == selProductType.lookup_code;
                            return o.product_type_code == selProductType.lookup_code;
                        })
                    }
                }
            },
            async changeDept() {
                let vm = this;
                vm.locator = '';
                vm.showData();
            }
        }
    }
</script>
<style scope>

    tr.duplicate_test_id > td {
        border: 4px solid #ED5565 !important;
    }

</style>