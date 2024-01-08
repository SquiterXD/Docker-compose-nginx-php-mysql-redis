<template>
    <div>
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-4">
                <label> ประเภทการขาย : </label>
                <input type="hidden" name="sales_type"  :value="sales_type" autocomplete="off">
                <el-select  v-model="sales_type"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" @change="getSelectesalesType(); getItems();">              
                    <el-option  v-for="type in salesTypes"
                                :key="type.value"
                                :label="type.description"
                                :value="type.value">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> ชนิดผลิตภัณฑ์ : </label>
                <input type="hidden" name="product_type"  :value="product_type" autocomplete="off">
                <el-select  v-model="product_type"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" :disabled="this.productTypeLoading"
                                @change="getItems()">              
                    <el-option  v-for="productType in productTypes"
                                :key="productType.lookup_code"
                                :label="productType.description"
                                :value="productType.lookup_code">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-2">
                <label> สถานะการใช้งาน : </label>
                <input type="hidden" name="status"  :value="status" autocomplete="off">
                <el-select  v-model="status"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100">              
                    <el-option  v-for="statusOption in statusOptions"
                                :key="statusOption.value"
                                :label="statusOption.label"
                                :value="statusOption.value">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-4">
                <label> ชื่อตราผลิตภัณฑ์ : </label>
                <input type="hidden" name="item_id"  :value="item_id" autocomplete="off">
                <el-select  v-model="item_id"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100">              
                    <el-option  v-for="(data, index) in itemLists"
                                :key="index"
                                :label="data.item_code + ' : ' + data.item_description"
                                :value="data.item_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> ชื่อที่ปรากฏในหน้าจอ E-Commerce : </label>
                <input type="hidden" name="ecom_item"  :value="ecom_item" autocomplete="off">
                <el-select  v-model="ecom_item"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100">              
                    <el-option  v-for="(data, index) in itemLists"
                                :key="index"
                                :label="data.item_code + ' : ' + data.item_description"
                                :value="data.item_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-2">
               <label class=" tw-font-bold tw-uppercase mb-0" >&nbsp;</label>
                <div class="text-right">
                    <button type="submit" class="btn btn-light btn-sm">
                        <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                    </button>
                    <a :href="this.actionUrl" class="btn btn-warning btn-sm"><i class="fa fa-undo"></i> รีเซต</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['sequenceEcoms', 'salesTypes', 'productTypeDomestics', 'productTypeExports', 'searchData', 'actionUrl'],
    data() {
        return {

            item_id:      '',
            ecom_item:    '',
            sales_type:   '',
            status:       '',
            product_type: '',

            itemLoading: false,

            productTypes: [],
            itemLists:    [],

            productTypeLoading: true,
            
            statusOptions : [
                {   
                    value: 'Active',
                    label: 'Active'
                },
                {
                    value: 'Inactive',
                    label: 'Inactive'
                },
            ],
        }
    },
    mounted(){
        this.getItems();
        if (this.searchData) {
            this.item_id      = this.searchData.item_id      ? this.searchData.item_id      : '';
            this.ecom_item    = this.searchData.ecom_item    ? this.searchData.ecom_item    : '';
            this.sales_type   = this.searchData.sales_type   ? this.searchData.sales_type   : '';
            this.status       = this.searchData.status       ? this.searchData.status       : '';
            this.product_type = this.searchData.product_type ? this.searchData.product_type : '';

            // console.log('searchData <---> ' + this.searchData.product_type);
        }

        if (this.sales_type) {
            this.getSelectesalesType();
        }
    },
    methods: {
        getSelectesalesType() {

            this.productTypeLoading = true;

            if (this.sales_type) {
                if (this.sales_type == 'DOMESTIC') {
                    this.productTypes = this.productTypeDomestics;

                    if (this.searchData.product_type) {

                        this.selectedData = this.productTypes.find( i => {
                            return i.lookup_code == this.searchData.product_type;
                        });

                        this.product_type  = this.selectedData.lookup_code;
                    }
                } else {
                    this.productTypes = this.productTypeExports;

                    if (this.searchData.product_type) {

                        this.selectedData = this.productTypes.find( i => {
                            return i.lookup_code == this.searchData.product_type;
                        });
                        
                        this.product_type  = this.selectedData.lookup_code;
                    }
                }
                
                this.productTypeLoading = false;
            }  else {
                this.product_type = "";
            }

            
        },

        async getItems(){

                this.itemLoading = true;
                this.itemLists = [];

                await axios.get("/om/ajax/get-item-search", {
                    params: {
                        sales_type:   this.sales_type,
                        product_type: this.product_type,
                    }
                })
                .then(res => {
                    this.itemLoading = false;
                    this.itemLists = res.data;
                })
                .catch(err => {
                    console.log(err)
                });
        },
    }
}
</script>