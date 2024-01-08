<template>
    <div v-loading="loading">
        <div class="row mb-2">
            <div class="col-md-2 text-right">
                เลือกร้านค้า
            </div>
            <div class="col-md-4">
                <el-select v-model="form.customer_id" class="w-100" clearable filterable
                    remote :remote-method="getCustomerLists" :loading="customerLoading" placeholder="Select" 
                    @change="findCustomer()">
                    <el-option
                        v-for="item in customerLists"
                        :key="item.customer_id"
                        :label="item.customer_number+' : '+item.customer_name"
                        :value="item.customer_id"
                    >
                        {{ item.customer_number+' : '+item.customer_name }}
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-1 text-right">
                จังหวัด
            </div>
            <div class="col-md-4">
                <el-input placeholder="" :readonly="true" 
                    v-model="form.province">
                </el-input>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 text-right">
                <button class="btn btn-success" @click="addData()" :disabled="!(form.customer_id)">เพิ่มจังหวัด</button>
                <button class="btn btn-primary" @click="handleStore()" :disabled="!(form.customer_id)">บันทึก</button>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">
                                ลำดับที่
                            </th>
                            <th class="text-center">
                                รหัสร้านค้า
                            </th>
                            <th class="text-center">
                                จังหวัด
                            </th>
                            <th class="text-center">
                                ส่วนแบ่ง %
                            </th>
                            <th width="20px" class="text-center">
                                ลบ
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in dataList" :key="index">
                            <td class="text-center">
                                {{ index+1 }}
                            </td>
                            <td>
                                {{ item.customer_number + ' : ' + item.customer_name }}
                            </td>
                            <td>
                                <el-select v-model="dataList[index].province_code" class="w-100" clearable
                                    filterable placeholder="Select" @change="findProvince(index)">
                                    <el-option
                                        v-for="list in provinceLists"
                                        :key="list.province_code"
                                        :label="list.province_name"
                                        :value="list.province_code"
                                    >
                                        {{ list.province_name }}
                                    </el-option>
                                </el-select>
                            </td>
                            <td class="text-right">
                                <div class="w-100 el-input">
                                    <vue-numeric read-only-class="el-input__inner text-right" 
                                        class="el-input__inner text-right" separator="," :min="0"
                                        :precision="2" v-model="dataList[index].tax_pao_percent">
                                    </vue-numeric>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="#" @click.prevent="removeData(index)"> <i class="fa fa-times text-danger" aria-hidden="true"></i> </a>
                            </td>
                        </tr>
                        <tr v-show="!dataList.length">
                            <td colspan="99" class="text-center">
                                ไม่มีข้อมูล
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import VueNumeric from 'vue-numeric'

    export default {

        components: {
            VueNumeric
        },

        props: [],

        data() {
            return {
                loading: false,
                customerLoading: false,
                customerLists: [],
                provinceLists: [],
                notSelectedProvinceLists: [],
                form: {
                    customer_id: '',
                    customer_number: '',
                    customer_name: '',
                    province: '',
                },
                dataList: [],
            }
        },

        mounted() {
            this.getCustomerLists();
            this.getProvinceLists();
        },

        computed: {
            
        },

        methods: {
            async getCustomerLists(query){
                let vm = this;
                vm.customerLoading = true;
                vm.customerLists = [];
                await axios.get('/om/pao-percent/get-customer-list', {
                    params: { 
                        'search': query
                    }
                })
                .then(function(response){
                    vm.customerLists = response.data;
                }).catch(function(error){
                    vm.showError(error.message);
                }).then(() => {
                    // always executed
                    vm.customerLoading = false;
                });
            },
            async getProvinceLists(){
                let vm = this;
                vm.provinceLists = [];
                await axios.get('/om/pao-percent/get-province-list')
                .then(function(response){
                    vm.provinceLists = response.data;
                }).catch(function(error){
                    vm.showError(error.message);
                }).then(() => {
                    // always executed
                });
            },
            findCustomer(){
                let vm = this;
                vm.loading = true;
                const find = vm.customerLists.find((item) => {
                    return item.customer_id == vm.form.customer_id;
                });
                vm.form.customer_number = find ? find.customer_number : '';
                vm.form.customer_name = find ? find.customer_name : '';
                vm.form.province = find ? find.attribute2 : '';
                vm.getDataCustomer();
            },
            findProvince(index){
                let vm = this;
                const check = vm.dataList.find((item, i) => {
                    return (i != index) 
                        && (item.province_code != '')
                        && (vm.dataList[i].province_code != '')
                        && (item.province_code == vm.dataList[index].province_code);
                });
                if(!!check){
                    vm.dataList[index].province_name = '';
                    vm.dataList[index].province_code = '';
                    swal({
                        title: "แจ้งเตือน",
                        text: "เลือกจังหวัดนี้ไปแล้ว",
                        icon: "warning",
                        confirmButtonText: 'ยืนยัน'
                    });
                }else {
                    const find = vm.provinceLists.find((item) => {
                        return item.province_code == vm.dataList[index].province_code;
                    });
                    vm.dataList[index].province_name = find ? find.province_name : '';
                }
            },
            async getDataCustomer(){
                let vm = this;
                await axios.get('/om/pao-percent/get-data-customer', {
                    params: { 
                        'customer_id' : vm.form.customer_id
                    }
                })
                .then(function(response){
                    vm.setDataList(response.data);
                }).catch(function(error){
                    vm.showError(error.message);
                }).then(() => {
                    // always executed
                    vm.loading = false;
                });
            },
            setDataList(data){
                let vm = this;
                vm.dataList = [];
                data.forEach(item => {
                    vm.dataList.push({
                        pao_percent_id: item.pao_percent_id, 
                        customer_id: item.customer_id, 
                        customer_number: item.customer_number, 
                        customer_name: item.customer ? item.customer.customer_name : '', 
                        province_code: item.province_code, 
                        province_name: item.province_name, 
                        tax_pao_percent: parseFloat(item.tax_pao_percent),
                    });
                });
            },
            addData(){
                let vm = this;
                vm.dataList.push({
                    pao_percent_id: '', 
                    customer_id: vm.form.customer_id, 
                    customer_number: vm.form.customer_number, 
                    customer_name: vm.form.customer_name, 
                    province_code: '', 
                    province_name: '', 
                    tax_pao_percent: 0,
                });
            },
            removeData(index){
                let vm = this;
                swal({
                    title: "แจ้งเตือน",
                    text: "ต้องการจะลบรายการหรือไม่?",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: 'ยกเลิก',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน'
                },
                async function(confirm) {
                    if (confirm) {
                        vm.dataList.splice(index, 1);
                    }
                });
            },
            async handleStore(){
                let vm = this;
                let sum_tax_pao_percent = 0;

                vm.dataList.forEach((item) => {
                    sum_tax_pao_percent += item.tax_pao_percent;
                });

                if(sum_tax_pao_percent != 100){
                    swal({
                        title: "แจ้งเตือน",
                        text: "กรุณาระบุส่วนแบ่งให้ครบ 100%",
                        icon: "warning",
                        confirmButtonText: 'ยืนยัน'
                    });
                }else {
                    await vm.store();
                }
            },
            async store(){
                let vm = this;
                vm.loading = true;

                axios.post('/om/pao-percent',{
                    'customer_id': vm.form.customer_id,
                    'data_list': vm.dataList,
                })
                .then(function(response){
                    if(response.data.status == 'S'){
                        let msg = response.data.msg;
                        vm.showSuccess(msg);
                    }else {
                        vm.showError(response.data.msg);
                    }
                }).catch(function(error){
                    vm.showError(error.message);
                }).then(() => {
                    // always executed
                    vm.getDataCustomer();
                });
            },
            showSuccess(msg){
                swal("Success!", msg, "success");
            },
            showError(msg){
                swal("Error!", msg, "error");
            },
            numberWithCommas(x) {
                return parseFloat(x).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            }
        }        
    }
</script>
