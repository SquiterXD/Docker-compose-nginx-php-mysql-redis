<template>
    <form
        id="app"
        @submit="checkForm"
        action="/pm/settings/print-conversion"
        method="get"
    >
    <div class="ibox">
        <div class="ibox-content">
            <div class="text-right" style="padding-bottom: 15px;">
                <button class="btn btn-light" id="searchBtn">
                    <i class="fa fa-search" aria-hidden="true"></i> ค้นหา 
                </button>
                <a type="button" :href="'/pm/settings/print-conversion'" class="btn btn-danger">
                    ล้างค่า
                </a>
            </div>
            <div class="row">
                <div class="col-4">
                    <label class="w-100 text-left">
                        <strong> ระบบการพิมพ์ <span class="text-danger">*</span></strong>
                    </label>
                    <input type="hidden" name="search[printItemCat]" v-model="printItemCat" autocomplete="off">
                    <el-select  v-model="printItemCat" 
                                placeholder="โปรดเลือกระบบการพิมพ์"
                                class="w-100"
                                clearable 
                                filterable
                                remote 
                                reserve-keyword
                                @change="getPrintType(printItemCat)">
                        <el-option
                            v-for="(itemcat,index) in printItemCatList"
                            :key="index"
                            :label="itemcat.cost_description"
                            :value="itemcat.cost_segment1">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-4">
                    <label class="w-100 text-left">
                        <strong> ประเภทสิ่งพิมพ์ <span class="text-danger">*</span></strong>
                    </label>
                    <input type="hidden" name="search[category]" v-model="category" autocomplete="off">
                    <el-select  v-model="category" 
                                placeholder="โปรดเลือก ประเภทสิ่งพิมพ์"
                                class="w-100"
                                clearable 
                                filterable
                                remote 
                                reserve-keyword
                                v-loading="loading.category"
                                :disabled="disabled.category">
                        <el-option
                            v-for="(category,index) in categoryList"
                            :key="index"
                            :label="category.toat_description"
                            :value="category.toat_segment1 + '.' + category.toat_segment2">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-4">
                    <label class="w-100 text-left">
                        <strong> ขนาดบุหรี่ <span class="text-danger">*</span></strong>
                    </label>
                    <input type="hidden" name="search[tobaccoSize]" v-model="tobaccoSize" autocomplete="off">
                    <el-select  v-model="tobaccoSize" 
                                placeholder="โปรดเลือกขนาดบุหรี่"
                                class="w-100"
                                filterable
                                clearable 
                                remote 
                                reserve-keyword>
                        <el-option
                            v-for="(lookupValue,index) in lookupValues"
                            :key="index"
                            :label="lookupValue.meaning"
                            :value="lookupValue.lookup_code">
                        </el-option>
                    </el-select>
                </div>
            </div>
        </div>
    </div>
    </form>
</template>

<script>
export default {
    props: ['printItemCatList', 'lookupValues', 'search', 'defaultPrintItemCat'],
    data() {
        return {
            printItemCat: this.search ? this.search.printItemCat : this.defaultPrintItemCat,
            tobaccoSize: this.search ? this.search.tobaccoSize : '',
            category: this.search ? this.search.category : '',
            categoryList: [],
            options: [{
                value: 'Y',
                label: 'Active'
            },{
                value: 'N',
                label: 'Inactive'
            }],
            loading:{
                category : false
            },
            disabled: {
                category : true
            }
        };
    },
    mounted() {
        if(this.search && this.search.printItemCat){
            this.getPrintType(this.search.printItemCat)
        }
        // else{
        //     document.getElementById("searchBtn").click();           
        // }
    },
    computed:{
        
    },
    methods: {
        async getPrintType(printItemCat) {
            if(this.search && this.search.category){
                this.category = this.search.category;
            }else{
                this.category = '';
            }
            this.loading.category = true;
            var params = {
                printItemCat: printItemCat ? printItemCat : this.defaultPrintItemCat,
            };
            return await axios
                .get('/pm/ajax/print-conversion/get-printType',{ params })
                .then(res => {                    
                    if(res.data.printTypeList.length != 0){
                        this.categoryList = res.data.printTypeList;
                        this.loading.category = false;
                        this.disabled.category = false;
                    }else{
                        this.categoryList = [];
                        this.loading.category = false;
                        this.disabled.category = true;
                    }
                });
                
        }, 
        checkForm: function (e) {} 
    }
};
</script>
