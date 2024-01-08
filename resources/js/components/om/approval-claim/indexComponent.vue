<template>
    <div class="row col-md-12" v-loading="loading">
        <div class="col-xl-6 m-auto">     
            <h3 class="black mb-3">ค้นหารายการที่ต้องการ</h3>
            <div class="form-group"> 
                <label class="d-block">รหัสร้านค้า</label>
                <el-select  v-model="form_search.customerNumber" 
                                    placeholder="รหัสร้านค้า"
                                    class="w-100"
                                    clearable
                                    @change="getCustomerCompany(form_search.customerNumber)"
                                    filterable
                                    remote
                                    :remote-method="remoteMethod"
                                    :loading="loading">
                    <el-option
                        v-for="(customer,index) in customersList"
                        :key="index"
                        :label="customer.customer_number"
                        :value="customer.customer_id"
                        style="height: 60px;">
                        <span style="float: left">{{ customer.customer_number }}</span><br>
                        <span style="float: left; color: #8492a6; font-size: 14px;">{{ customer.customer_name }}</span>
                    </el-option>
                </el-select>
            </div> 

            <div class="form-group"> 
                <label class="d-block">ชื่อร้านค้า</label>
                    <el-select  v-model="form_search.customerCompany" 
                            placeholder="ชื่อร้านค้า"
                            class="w-100"
                            disabled>
                    <el-option
                        v-for="(customer,index) in customerList"
                        :key="index"
                        :label="customer.customer_name"
                        :value="customer.customer_id">
                    </el-option>
                </el-select>             
            </div> 

            <div class="form-group"> 
                <label class="d-block">เลขที่ใบแจ้งเคลมสินค้า</label>
                <!-- <el-input placeholder="เลขที่ใบแจ้งเคลมสินค้า" v-model="form_search.claimNumber"></el-input> -->
                <el-select  v-model="form_search.claimNumber" 
                                    placeholder="เลขที่ใบแจ้งเคลมสินค้า"
                                    class="w-100"
                                    clearable
                                    filterable>
                    <el-option
                        v-for="(header,index) in headersList"
                        :key="index"
                        :label="header.claim_number"
                        :value="header.claim_number">
                    </el-option>
                </el-select>
            </div> 

            <div class="form-group"> 
                <label class="d-block">วันที่แจ้งเคลมสินค้า</label>
                <datepicker-th
                    class="w-100 form-control md:tw-mb-0 tw-mb-2" 
                    placeholder="วันที่แจ้งเคลมสินค้า"
                    format="DD/MM/YYYY"
                    v-model="form_search.claimDate"
                    @dateWasSelected="onDateFromWasSelected"
                />
            </div> 

            <div class="form-group">
                <label class="d-block">สถานะ</label>
                <el-select v-model="form_search.statusClaim" placeholder="สถานะ" class="w-100" clearable>
                    <el-option
                        v-for="(statu,index) in claimStatusList"
                        :key="index"
                        :label="statu.meaning"
                        :value="statu.lookup_code">
                    </el-option>
                </el-select>
            </div>

            <div class="form-buttons no-border" style="text-align: center;">  
                <button :class="btnTrans.search.class" 
                        type="button" 
                        style="height: 52px;width: 222px;" 
                        v-on:click="getSearch()">
                        <i :class="btnTrans.search.icon"></i>
                    {{ btnTrans.search.text }}
                </button>
            </div>
        </div>
    
        <approval-claim-table   :lineList = "lineList"
                                :checkStatus = "disenable.checkStatusDisenable"
                                :checkStatusEnable = "disenable.checkStatusEnable"
                                :btnTrans = "btnTrans">        
        </approval-claim-table>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        props: [
            'claimStatusList',
            'headersList',
            'customerList',
            'btnTrans'
        ],
        mounted() {
            this.datatable = $("#datatable").dataTable({
                                    searching: false,
                                    ordering: false,
                                    responsive: true
                                });
        },
        data() {
          return {
            form_search:{
                customerNumber: '',
                customerCompany: '',
                claimNumber: '',
                claimDate: '',
                statusClaim: '',
                headerList: [],
            },
            lineList:[],
            loading: false,
            table: false,
            disenable: {
                checkStatusDisenable: '',
                checkStatusEnable: ''            
            },
            loading: false,
            customersList: this.customerList,
            datatable: '',
          }
        },
        methods: {
            getCustomerCompany(customerId){
                let vm = this;
                this.customerList.forEach(element => {
                    if(element.customer_id == customerId){
                        vm.form_search.customerCompany = element.customer_id ? element.customer_id : ''; 
                    }

                    if(!customerId){
                        vm.form_search.customerCompany = '';
                    }
                });
            },
            async getSearch(){
                let vm = this;
                vm.datatable.fnDestroy();
                this.loading = true;
                // console.log(vm.form_search)
                await axios
                    .post('ajax/approval-claim/get-search', {
                        ...vm.form_search,
                    })
                    .then(res => {
                        this.lineList = res.data.headerList;
                    })
                    vm.datatable = $("#datatable").dataTable({
                                        searching: false,
                                        ordering: false,
                                        responsive: true
                                    });
                vm.loading = false;
            },
            getDateFormatted(date) {
                return moment(date).format("DD/MM/YYYY");
            },
            async onDateFromWasSelected(value) {
                let vm = this;
                vm.form_search.claimDate = this.getDateFormatted(value);
            },
            remoteMethod(query) {
                if (query !== '') {
                this.loading = true;
                setTimeout(() => {
                    this.loading = false;
                    this.customersList = this.customerList.filter(item => {
                        return  item.customer_name.toLowerCase()
                                .indexOf(query.toLowerCase()) > -1 
                                || 
                                item.customer_number.toLowerCase()
                                .indexOf(query.toLowerCase()) > -1;
                    });
                }, 200);
                } else {
                this.customersList = this.customerList;
                }
            }
            
        }
    }
</script>
