<template>
    <div v-loading="loading">
        <div class="row mb-3">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>วันที่ <span class="text-danger">*</span></label>
                        <el-select 
                            v-model="close_date" 
                            filterable class="w-100" placeholder="Select"
                            @focus="getDateLists()" @change="resetButton()"
                            :disabled="disable_params" :loading="dateLoading">
                            <el-option
                                v-for="(item, key) in dateLists"
                                :key="key"
                                :label="item"
                                :value="key">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Group ID</label>
                        <el-input v-model="group_id" class="w-100" placeholder="" :disabled="true"></el-input>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>หมายเหตุ</label>
                        <el-input v-model="interface_status" class="w-100" placeholder="" :disabled="true"></el-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button class="btn btn-primary mt-2 mt-md-0" type="button" @click="callValidate('report')" :disabled="disable_report"> ประมวลผล</button>
                        <button class="btn btn-primary mt-2 mt-md-0" type="button" @click="callValidate('interface')" :disabled="disable_interface"> Interface</button>
                    </div>
                </div>
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

        props: ['saleClass'],

        data() {
            return {
                dateLoading: false,
                loading: false,
                disable_params: false,
                disable_report: false,
                disable_interface: true,
                dateLists: [],
                documentNoLists: [],
                close_date: '',
                interface_status: '',
                group_id: '',
            }
        },

        mounted() {
            // this.getDateLists();
        },

        methods: {
            getDateLists(){
                let vm = this;
                vm.dateLoading = true;
                
                axios.post('/om/close-daily-payoff/'+vm.saleClass+'/date-lists',{
                    'sale_class' : vm.saleClass,
                })
                .then(function(response){

                    vm.dateLists = response.data;
                }).catch(function(error){

                    vm.dateLoading = false;
                    vm.showError(error.message);
                }).then(() => {
                    // always executed
                    vm.dateLoading = false;
                });
            },
            resetButton(){
                let vm = this;
                vm.disable_report = false;
                vm.disable_interface = true;
            },
            callValidate(type){

                let vm = this;
                let msg = '';
                let error_flag = false;
    
                if(!vm.close_date){
                    msg += 'กรุณาระบุวันที่ <br>';
                    error_flag = true;
                }

                if(error_flag){
                    swal({
                        html: true,
                        title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
                        text: msg,
                        type: 'error',
                    });
                    return false;
                }

                vm.loading = true;

                axios.post('/om/close-daily-payoff/'+vm.saleClass+'/validate-data',{
                    'close_date' : vm.close_date,
                    'sale_class' : vm.saleClass,
                })
                .then(function(response){

                    if(response.data.status == 'S'){
                        if(type == 'report'){
                            vm.callReport();
                        }else if(type == 'interface'){
                            vm.callInterface();
                        }else {
                            
                        }
                    }else {
                        vm.loading = false;
                        if(type == 'report'){
                            // swal({
                            //     title: "Warning!",
                            //     text: response.data.msg,
                            //     type: "warning",
                            //     showCancelButton: false,
                            //     closeOnConfirm: true
                            // },
                            // function (isConfirm) {
                            //     if (isConfirm) {
                            //         vm.callReport();
                            //     }
                            // });
                            vm.showError(response.data.msg);
                        }else if(type == 'interface'){
                            vm.showError(response.data.msg);
                        }else {
                            
                        }
                    }

                }).catch(function(error){
                    // console.log(error);
                    vm.showError(error.message);
                }).then(() => {
                    // always executed
                });
            },
            callInterface(){
                let vm = this;
                vm.loading = vm.disable_interface = true;
                axios.post('/om/close-daily-payoff/'+vm.saleClass+'/interface',{
                    'close_date' : vm.close_date,
                    'sale_class' : vm.saleClass,
                    'group_id' : vm.group_id,
                })
                .then(function(response){
                    vm.interface_status = response.data.status;
                    if(response.data.status == 'S'){
                        vm.getDateLists();
                        vm.showSuccess(response.data.msg);
                        vm.close_date = '';
                        vm.group_id = response.data.group_id;
                    }else {
                        vm.showError(response.data.msg);
                        vm.disable_interface = false;
                    }
                }).catch(function(error){
                    // console.log(error.message);
                    vm.showError(error.message);
                    vm.disable_interface = false;
                }).then(() => {
                    // always executed
                    vm.loading = false;
                });
            },
            showSuccess(msg){
                swal("Success!", msg, "success");
            },
            showError(msg){
                swal("Error!", msg, "error");
            },
            callReport(){
                let vm = this;

                vm.loading = vm.disable_report = true;

                axios.post('/om/close-daily-payoff/'+vm.saleClass+'/call-report',{
                    'close_date' : vm.close_date,
                    'sale_class' : vm.saleClass,
                })
                .then(function(response){
                    if(response.data.status == 'S'){
                        /// call show report
                        vm.group_id = response.data.group_id;
                        vm.showSuccess(response.data.msg);
                        vm.getReport(vm.saleClass);
                        vm.disable_interface = false;
                    }else {
                        vm.group_id = '';
                        vm.showError(response.data.msg);
                        vm.disable_report = false;
                    }
                }).catch(function(error){
                    // console.log(error);
                    vm.showError(error.message);
                    vm.disable_report = false;
                }).then(() => {
                    // always executed
                    vm.loading = false;
                });
            },
            getReport(saleClass){
                let vm = this;
                if(saleClass === 'export'){
                    window.open("/ir/reports/get-param?group_id="+vm.group_id+"&document_date="+vm.close_date+"&program_code=OMR0112&function_name=OMR0112&output=pdf", "_blank");
                }else {
                    window.open("/ir/reports/get-param?group_id="+vm.group_id+"&document_date="+vm.close_date+"&program_code=OMR0064&function_name=OMR0064&output=pdf", "_blank");
                }
            },
            showSuccess(msg){
                swal("Success!", msg, "success");
            },
            showError(msg){
                swal("Error!", msg, "error");
            },
        }        
    }
</script>
