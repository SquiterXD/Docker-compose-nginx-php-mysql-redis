<template>
    <div>
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-4">
                        <label class="w-100 text-left">
                            <strong> ประเภทการทำรายการ </strong>
                        </label>
                        <input type="hidden" name="search[wipTransaction]" v-model="wip" autocomplete="off">
                        <el-select  v-model="wip" 
                                    placeholder="โปรดเลือกคลังสำหรับทำรายการ"
                                    class="w-100"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword>
                            <el-option
                                v-for="(wipTran,index) in wipTransaction"
                                :key="index"
                                :label="wipTran.attribute3"
                                :value="wipTran.transaction_type_id">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-4">
                        <label class="w-100 text-left">
                            <strong> ประเภท สินค้า </strong>
                        </label>
                        <input type="hidden" name="search[itemcat]" v-model="itemcat" autocomplete="off">
                        <el-select  v-model="itemcat" 
                                    placeholder="โปรดเลือกประเภท Item"
                                    class="w-100"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword>
                            <el-option
                                v-for="(itemcat, index) in tobaccoItemcats"
                                :key="index"
                                :label="itemcat.meaning + ' : ' + itemcat.group_desc"
                                :value="itemcat.group_code">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-4">
                        <label class="w-100 text-left">
                            <strong> Transaction Type </strong>
                        </label>
                        <input type="hidden" name="search[transaction]" v-model="transaction" autocomplete="off">
                        <input type="hidden" name="search[querySearch]" v-model="querySearch" autocomplete="off">
                        <!-- <el-select  v-model="transaction" 
                                    placeholder="โปรดเลือกประเภทการทำรายการ"
                                    class="w-100"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword>
                            <el-option
                                v-for="(transaction, index) in transactionTypes"
                                :key="index"
                                :label="transaction.transaction_type_name"
                                :value="transaction.transaction_type_id">
                            </el-option>
                        </el-select> -->
                        <el-select
                            v-model="transaction"
                            clearable 
                            filterable
                            remote
                            reserve-keyword
                            placeholder="ประเภทการทำรายการ"
                            :remote-method="remoteMethod"
                            :loading="loading.transactionTypes"
                            class="w-100">
                            <el-option
                                v-for   ="transactionType in transactionTypesList"
                                :key    ="transactionType.transaction_type_id"
                                :label  ="transactionType.transaction_type_name"
                                :value  ="transactionType.transaction_type_id"      >
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="text-right" style="padding-top: 15px;">
                    <button class="btn btn-light" type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i> แสดงข้อมูล
                    </button>
                    <a type="button" :href="'/pm/settings/org-tranfer'" class="btn btn-danger">
                        ล้างค่า
                    </a>
                </div>
            </div>
        </div>

    </div>        

</template>

<script>
export default {
    props: ['wipTransaction', 'transactionTypes', 'tobaccoItemcats', 'search'],
    data() {
        return {
            wip: this.search? this.search['wipTransaction'] : '',
            transaction: this.search? this.search['transaction'] : '',
            itemcat: this.search? this.search['itemcat'] : '',
            transactionTypesList: this.transactionTypes,
            loading:{
                transactionTypes: false,
            },
            querySearch: ''
        };
    },
    mounted() {

    },
    computed:{
        
    },
    methods: {
        remoteMethod(query) {
            if (query !== '') {
                var params = query;
                this.loading.transactionTypes = true;
                this.querySearch = params;
                return axios
                .get('/pm/ajax/org-tranfer/get_transaction_types',{ params })
                .then(res => {
                    this.transactionTypesList = res.data.transactionTypes;
                    this.loading.transactionTypes = false;
                });
            } else {
                this.transactionTypesList = this.transactionTypes;
            }
        }       
    }
};
</script>
