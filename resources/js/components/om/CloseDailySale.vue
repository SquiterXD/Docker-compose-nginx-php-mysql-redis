<template>
    <div v-loading="loading">
        <div class="row mb-3">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>วันที่ <span class="text-danger">*</span></label>
                        <el-select 
                            v-model="document_date" 
                            filterable 
                            class="w-100" 
                            placeholder="Select" 
                            @focus="getDateLists()" 
                            @input="getDocumentNoLists()" 
                            :disabled="disable_params">
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
                        <label>เลขที่เอกสาร </label>
                        <el-select v-model="document_no" 
                            filterable 
                            clearable 
                            class="w-100" 
                            placeholder="Select" 
                            :disabled="disable_params"
                            @change="resetButton()">
                            <el-option
                                v-for="(item, key) in documentNoLists"
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

        props: [],

        data() {
            return {
                loading: false,
                disable_params: false,
                disable_report: false,
                disable_interface: true,
                dateLists: [],
                documentNoLists: [],
                document_date: '',
                document_no: '',
                interface_status: '',
                group_id: '',
                check: {
                    Cons: {
                        send: false,
                        done: false,
                        pass: true,
                        msg: '',
                    },
                    SO: {
                        send: false,
                        done: false,
                        pass: true,
                        msg: '',
                    },
                    RMA: {
                        send: false,
                        done: false,
                        pass: true,
                        msg: '',
                    },
                    INV: {
                        send: false,
                        done: false,
                        pass: true,
                        msg: '',
                    },
                    GL: {
                        send: false,
                        done: false,
                        pass: true,
                        msg: '',
                    },
                },
            }
        },

        mounted() {
            this.getDateLists();
        },

        methods: {
            getDateLists(){
                let vm = this;
                vm.documentNoLists = [];

                axios.get('/om/close-daily-sale/date-lists')
                .then(function(response){
                    vm.dateLists = response.data;
                }).catch(function(error){
                    // console.log(error);
                    vm.showError(error.message);
                }).then(() => {
                    // always executed
                });
            },
            getDocumentNoLists(){
                let vm = this;
                vm.document_no = '';
                vm.documentNoLists = [];
                vm.disable_report = false;
                vm.disable_interface = true;

                axios.get('/om/close-daily-sale/document-no-lists?document_date='+vm.document_date)
                .then(function(response){
                    vm.documentNoLists = response.data;
                }).catch(function(error){
                    // console.log(error);
                    vm.showError(error.message);
                }).then(() => {
                    // always executed
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
    
                if(!vm.document_date){
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

                axios.post('/om/close-daily-sale/validate-data',{
                    'document_date' : vm.document_date,
                    'document_no' : vm.document_no,
                })
                .then(function(response){

                    if(response.data.status == 'S'){
                        if(type == 'report'){
                            vm.callReport();
                        }else if(type == 'interface'){
                            vm.callSO();
                        }else {
                            
                        }
                    }else {
                        vm.loading = false;
                        if(type == 'report'){
                            vm.showError(response.data.msg);
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
            callSO(){
                let vm = this;

                vm.loading = vm.disable_interface = true;

                vm.check.Cons.send = true;
                // vm.check.SO.send = true;
                // vm.check.RMA.send = true;

                vm.callInterface('Sale-Order-Consignment');
                // vm.callInterface('Sale-Order');
                // vm.callInterface('Sale-Order-RMA');
            },
            callInterface(type){
                let vm = this;
                let group = '';

                vm.loading = vm.disable_interface = true;

                let url = '';
                if(type == 'Sale-Order-Consignment'){
                    url = '/om/close-daily-sale/interface/process-cons';
                }else if(type == 'Sale-Order'){
                    url = '/om/close-daily-sale/interface/process-so';
                }else if(type == 'Sale-Order-RMA'){
                    url = '/om/close-daily-sale/interface/process-rma';
                }else if(type == 'Invoice'){
                    url = '/om/close-daily-sale/interface/process-invoice';
                }else if(type == 'GL'){
                    url = '/om/close-daily-sale/interface/process-gl';
                }

                axios.post(url, {
                    'document_date' : vm.document_date,
                    'document_no' : vm.document_no,
                    'group_id' : vm.group_id,
                    'type' : type,
                })
                .then(function(response){
                    if(response.data.status == 'S'){

                        if(type == 'Sale-Order-Consignment'){
                            vm.check.Cons.done = true;
                        }else if(type == 'Sale-Order'){
                            vm.check.SO.done = true;
                        }else if(type == 'Sale-Order-RMA'){
                            vm.check.RMA.done = true;
                        }else if(type == 'Invoice'){
                            group = response.data.group_id;
                            vm.check.INV.done = true;
                        }else if(type == 'GL'){
                            group = response.data.group_id;
                            vm.check.GL.done = true;
                        }
                    }else {
                        if(type == 'Sale-Order-Consignment'){
                            vm.check.Cons.pass = false;
                            vm.check.Cons.msg = response.data.msg;
                            vm.check.Cons.done = true;
                        }else if(type == 'Sale-Order'){
                            vm.check.SO.pass = false;
                            vm.check.SO.msg = response.data.msg;
                            vm.check.SO.done = true;
                        }else if(type == 'Sale-Order-RMA'){
                            vm.check.RMA.pass = false;
                            vm.check.RMA.msg = response.data.msg;
                            vm.check.RMA.done = true;
                        }else if(type == 'Invoice'){
                            vm.check.INV.pass = false;
                            vm.check.INV.msg = response.data.msg;
                            vm.check.INV.done = true;
                        }else if(type == 'GL'){
                            vm.check.GL.pass = false;
                            vm.check.GL.msg = response.data.msg;
                            vm.check.GL.done = true;
                        }
                    }
                }).catch(function(error){
                    if(type == 'Sale-Order-Consignment'){
                        vm.check.Cons.pass = false;
                        vm.check.Cons.msg = error.message;
                        vm.check.Cons.done = true;
                    }else if(type == 'Sale-Order'){
                        vm.check.SO.pass = false;
                        vm.check.SO.msg = error.message;
                        vm.check.SO.done = true;
                    }else if(type == 'Sale-Order-RMA'){
                        vm.check.RMA.pass = false;
                        vm.check.RMA.msg = error.message;
                        vm.check.RMA.done = true;
                    }else if(type == 'Invoice'){
                        vm.check.INV.pass = false;
                        vm.check.INV.msg = error.message;
                        vm.check.INV.done = true;
                    }else if(type == 'GL'){
                        vm.check.GL.pass = false;
                        vm.check.GL.msg = error.message;
                        vm.check.GL.done = true;
                    }
                }).then(() => {
                    // always executed
                    if(type == 'GL'){
                        if(vm.check.GL.pass){
                            vm.group_id = group;
                            vm.showSuccess('ดำเนินการปิดการขายประจำวันเรียบร้อยแล้ว Group ID : '+vm.group_id);
                            vm.document_date = '';
                            vm.document_no = '';
                            vm.getDateLists();
                            vm.resetSOCheck();
                            vm.resetInvGlCheck();
                            vm.interface_status = 'S';
                            vm.loading = vm.disable_report = false;
                            vm.disable_interface = true;
                        }else {
                            vm.showInvGlError();
                            vm.loading = vm.disable_interface = false;
                        }
                    }else if(type == 'Sale-Order-Consignment'){
                        if(vm.check.Cons.pass){
                            vm.callInterface('Sale-Order');
                        }else {
                            vm.showSOError();
                            vm.loading = vm.disable_interface = false;
                        }
                    }else if(type == 'Sale-Order'){
                        if(vm.check.SO.pass){
                            vm.callInterface('Sale-Order-RMA');
                        }else {
                            vm.showSOError();
                            vm.loading = vm.disable_interface = false;
                        }
                    }else if(type == 'Sale-Order-RMA'){
                        if(vm.check.RMA.pass){
                            vm.callInterface('Invoice');
                        }else {
                            vm.showSOError();
                            vm.loading = vm.disable_interface = false;
                        }
                    }else if(type == 'Invoice'){
                        if(vm.check.INV.pass){
                            vm.callInterface('GL');
                        }else {
                            vm.showInvGlError();
                            vm.loading = vm.disable_interface = false;
                        }
                    }
                });
            },
            callReport(){
                let vm = this;

                vm.loading = vm.disable_report = true;

                axios.post('/om/close-daily-sale/call-report',{
                    'document_date' : vm.document_date,
                    'document_no' : vm.document_no,
                })
                .then(function(response){
                    if(response.data.status == 'S'){
                        /// call show report
                        vm.group_id = response.data.group_id;
                        vm.showSuccess(response.data.msg);
                        vm.getReport();
                    }else {
                        vm.group_id = '';
                        vm.showError(response.data.msg);
                    }
                }).catch(function(error){
                    // console.log(error);
                    vm.showError(error.message);
                }).then(() => {
                    // always executed
                    vm.loading = vm.disable_interface = false;
                });
            },
            getReport(){
                let vm = this;
                window.open("/ir/reports/get-param?group_id="+vm.group_id+"&document_date="+vm.document_date+"&program_code=OMR0035&function_name=OMR0035&output=pdf", "_blank");
                window.open("/ir/reports/get-param?group_id="+vm.group_id+"&document_date="+vm.document_date+"&program_code=OMR0064&function_name=OMR0064&output=pdf", "_blank");
            },
            showSuccess(msg){
                swal({
                    title: 'Success',
                    text: msg, 
                    icon: "success",
                    showConfirmButton: true,
                    showCancelButton: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
            },
            showError(msg){
                swal({
                    title: 'Error',
                    text: msg, 
                    icon: "error",
                    showConfirmButton: true,
                    showCancelButton: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
            },
            showSOError()
            {
                let vm = this;
                let msg = '';
                if(!vm.check.Cons.pass){
                    msg += 'Consignment Error : '+vm.check.Cons.msg
                }
                if(!vm.check.SO.pass){
                    msg += ' SO Error : '+vm.check.SO.msg
                }
                if(!vm.check.RMA.pass){
                    msg += ' RMA Error : '+vm.check.RMA.msg;
                }
                swal({
                    title: 'Error',
                    text: msg, 
                    icon: "error",
                    showConfirmButton: true,
                    showCancelButton: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
                vm.interface_status = msg;
                vm.resetInvGlCheck();
            },
            resetSOCheck()
            {
                let vm = this;
                vm.check.Cons.send = false;
                vm.check.Cons.done = false;
                vm.check.Cons.pass = true;
                vm.check.Cons.msg = '';
                vm.check.SO.send = false;
                vm.check.SO.done = false;
                vm.check.SO.pass = true;
                vm.check.SO.msg = '';
                vm.check.RMA.send = false;
                vm.check.RMA.done = false;
                vm.check.RMA.pass = true;
                vm.check.RMA.msg = '';
            },
            showInvGlError()
            {
                let vm = this;
                let msg = '';
                if(!vm.check.INV.pass){
                    msg += 'Invoice Error : '+vm.check.INV.msg
                }
                if(!vm.check.GL.pass){
                    msg += ' GL Error : '+vm.check.GL.msg
                }
                swal({
                    title: 'Error',
                    text: msg, 
                    icon: "error",
                    showConfirmButton: true,
                    showCancelButton: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
                vm.interface_status = msg;
                vm.resetInvGlCheck();
            },
            resetInvGlCheck()
            {
                let vm = this;
                vm.check.INV.send = false;
                vm.check.INV.done = false;
                vm.check.INV.pass = true;
                vm.check.INV.msg = '';
                vm.check.GL.send = false;
                vm.check.GL.done = false;
                vm.check.GL.pass = true;
                vm.check.GL.msg = '';
            }
        }        
    }
</script>
