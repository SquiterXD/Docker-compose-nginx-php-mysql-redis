<template>
    <div v-loading="loading">
        <div class="row mb-3">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Report Name <span class="text-danger">*</span></label>
                        <el-select 
                            v-model="report_name" 
                            filterable 
                            class="w-100" 
                            placeholder="Select" 
                            @focus="getReportsName()" 
                            @input="getDateLists()"
                        >
                            <el-option
                                v-for="(item, key) in reportNameLists"
                                :key="key"
                                :label="item"
                                :value="key">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>วันที่ <span class="text-danger">*</span></label>
                        <el-select 
                            v-model="document_date" 
                            filterable 
                            class="w-100" 
                            placeholder="Select" 
                            @focus="getDateLists()" 
                            @input="getGroupIDLists()" 
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
                        <label>Group ID </label>
                        <el-select v-model="group_id" filterable clearable class="w-100" placeholder="Select" :disabled="disable_params">
                            <el-option
                                v-for="(item, key) in groupIdLists"
                                :key="key"
                                :label="item"
                                :value="key">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button class="btn btn-primary mt-2 mt-md-0" type="button" @click="getReport()"> Report</button>
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
                disable_interface: false,
                reportNameLists: [],
                dateLists: [],
                groupIdLists: [],
                report_name: '',
                document_date: '',
                document_no: '',
                interface_status: '',
                show_group_id: '',
                group_id: '',
            }
        },

        mounted() {
            this.getReportsName();
        },

        methods: {
            getReportsName(){
                let vm = this;

                axios.get('/om/reports/get-reports-name')
                .then(function(response){
                    vm.reportNameLists = response.data;
                }).catch(function(error){
                    // console.log(error);
                    vm.showError(error.message);
                }).then(() => {
                    // always executed
                });
            },
            getDateLists(){
                let vm = this;

                axios.get('/om/reports/get-date-lists')
                .then(function(response){
                    vm.dateLists = response.data;
                }).catch(function(error){
                    // console.log(error);
                    vm.showError(error.message);
                }).then(() => {
                    // always executed
                });
            },
            getGroupIDLists(){
                let vm = this;
                vm.group_id = '';

                axios.get('/om/reports/get-group-id-lists?document_date='+vm.document_date)
                .then(function(response){
                    vm.groupIdLists = response.data;
                }).catch(function(error){
                    // console.log(error);
                    vm.showError(error.message);
                }).then(() => {
                    // always executed
                });
            },
            getReport(){
                let vm = this;
                window.open("/om/close-daily-sale/get-report?group_id="+vm.group_id+"&document_date="+vm.document_date, "_blank");
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
