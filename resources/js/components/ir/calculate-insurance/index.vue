<template>
    <div v-loading="loading">
        <div class="row my-3">
            <div class="col-md-4"></div>
            <div class='col-md-4'>
                <label>
                    <strong>บริษัท</strong>
                </label>
                <el-select v-model="company" class="w-100" placeholder="บริษัท" clearable :disabled="disableForm">
                    <el-option v-for="item in companyLists"
                        :key="item.company_number"
                        :label="item.company_name"
                        :value="item.company_number">
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-4"></div>
            <div class='col-md-2'>
                <label>
                    <strong>กรมธรรม์ชุดที่</strong>
                </label>
                <el-select v-model="insuranceNo" class="w-100" placeholder="กรมธรรม์ชุดที่" clearable="" :disabled="disableForm">
                    <el-option v-for="item in policyLists"
                        :key="item.policy_set_header_id"
                        :label="item.policy_set_number+' : '+item.policy_set_description"
                        :value="item.policy_set_header_id">
                    </el-option>
                </el-select>
                <!-- <el-input-number v-model="insuranceNo" class="w-100" :controls="false" @change="handleChange"></el-input-number> -->
            </div>
            <div class='col-md-2'>
                <label>
                    <strong>ปี</strong>
                </label>
                <el-date-picker
                    :picker-options="pickerOptions"
                    class="w-100 text-center"
                    :clearable="false"
                    v-model="year"
                    type="year"
                    placeholder="ปี"
                    :disabled="disableForm"
                    @change="getYear">
                </el-date-picker>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-4"></div>
            <div class='col-md-2'>
                <label>
                    <strong>วันที่คุ้มครอง</strong>
                </label>
                <date-input :attrName='`start_date`'
                            v-model="dateStart"
                            @change-date="getDateStart"
                            :sizeSmall="false"
                            :value="dateStart"
                            :disabled="true"
                            placeholder="วันที่คุ้มครอง" />
            </div>
            
            <div class='col-md-2'>
                <label>
                    <strong>ถึง</strong>
                </label>
                <date-input :attrName='`start_end`'
                            v-model="dateEnd"
                            @change-date="getDateEnd"
                            :sizeSmall="false"
                            :value="dateEnd"
                            :disabled="true"
                            placeholder="ถึง" />
            </div>
        </div>
        <div class="row">
            <div class="col-12 padding_12 text-center">
                <button class='btn btn-info m-1' :disabled="disableReport" @click='callReport()' 
                    ><i class="fa fa-file"></i> Print Report</button>
                <button class='btn m-1' style="color: #fff; background-color: #13abad; border-color: #13abad;" 
                    :disabled="disableInterface" data-toggle="modal" data-target="#modal-interface">
                    <i class="fa fa-exchange"></i> 
                    Interface
                </button>
                <button class='btn btn-danger m-1' @click='clickCancel()'><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div>
        <div id="modal-interface" class="modal fade" aria-hidden="true">
            <div class="modal-dialog pt-0 modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="m-l-xs m-r-lg mm-xs">
                            <div class="row my-3">
                                <label class="col-md-4 col-form-label lable_align">
                                    <strong>วันที่ใบแจ้งหนี้ <span class="text-danger">*</span></strong>
                                </label>
                                <div class="col-md-5">
                                    <span class="text-danger" v-if="invalidInvoiceDate">required</span>
                                    <date-input :attrName='`invoice_date`'
                                        v-model="invoiceDate"
                                        @change-date="getinvoiceDate"
                                        :sizeSmall="false"
                                        :value="invoiceDate"
                                        placeholder="วันที่คุ้มครอง" />
                                </div>
                            </div>
                            <div class="row my-3">
                                <label class="col-md-4 col-form-label lable_align">
                                    <strong>Invoice Batch <span class="text-danger" v-if="amountInReport >= 0">*</span></strong>
                                </label>
                                <div class="col-md-5">
                                    <span class="text-danger" v-if="invalidBatchNo">required</span>
                                    <el-input placeholder="Invoice Batch" :disabled="amountInReport < 0" v-model="batchNo"></el-input>
                                </div>
                            </div>
                            <hr class="m-t-sm m-b-sm">
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click='clickInterface()'>Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import dateInput from '../components/calendar/dateInput'
    import yearInput from '../components/calendar/yearInput'

    export default {
        components: {dateInput, yearInput},

        name: 'ir-calculate-insurance-index',
        
        props: ['policyLists', 'companyLists', 'yearLists', 'effectDateLists'],

        data() {
            return {
                loading: false,
                disableForm: false,
                disableReport: false,
                disableInterface: true,
                amountInReport: 0,
                dateStart: '',
                dateEnd: '',
                invoiceDate: '',
                invalidInvoiceDate: false,
                batchNo: '',
                invalidBatchNo: false,
                year: 0,
                insuranceNo: '',
                company: '',
                pickerOptions: {
                    disabledDate: this.pickerYearOptions,
                },
            };
        },

        created() {
            let currentYear = new Date().getFullYear();
            let cycle = new Date(currentYear, 8, 30); // month start at 0
            let now = new Date();
            let offset = now.getTime() > cycle.getTime() ? 544 : 543;
            this.year = (currentYear + offset).toString();
            this.dateStart = '30/09/'+ (currentYear + offset-1);
            this.dateEnd = '30/09/'+ (currentYear + offset);
        },

        methods: {
            pickerYearOptions(time){
                return !this.yearLists.includes(time.getFullYear());
            },
            callReport(){
                const vm = this;
                vm.loading = true;

                axios.post('/ir/calculate-insurance/check-report', {
                    company: vm.company,
                    insuranceNo: vm.insuranceNo,
                    year: vm.year,
                    dateStart: vm.dateStart,
                    dateEnd: vm.dateEnd,
                })
                .then(function (response) {
                    if(response.data.status == 'C'){
                        vm.amountInReport = response.data.amount;
                        vm.printReport();
                    }else {
                        swal({
                            html: true,
                            title: 'Error',
                            text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px">'+ response.data.msg +'</span></h2>',
                        });
                    }
                })
                .catch(function (error) {
                     
                })
                .then(() => {
                    vm.loading = false;
                });
            },
            printReport() {
                const vm = this;
                let url = "/ir/calculate-insurance/report?company="+vm.company+"&insuranceNo="+vm.insuranceNo+"&year="+vm.year+"&dateStart="+vm.dateStart+"&dateEnd="+vm.dateEnd;
                window.open(url, "_blank");
                vm.disableInterface = false;
                vm.disableForm = vm.disableReport = true;
            },
            clickInterface() {
                const vm = this;
                let check = true;

                vm.invalidBatchNo = false;
                vm.invalidInvoiceDate = false;

                if(vm.amountInReport >= 0){
                    if(!vm.batchNo){
                        vm.invalidBatchNo = true;
                        check = false;
                    }
                }

                if(!vm.invoiceDate){
                    vm.invalidInvoiceDate = true;
                    check = false;
                }

                if(check){
                    vm.loading = true;

                    axios.post('/ir/calculate-insurance/interface', {
                        company: vm.company,
                        insuranceNo: vm.insuranceNo,
                        year: vm.year,
                        dateStart: vm.dateStart,
                        dateEnd: vm.dateEnd,
                        invoiceDate: vm.invoiceDate,
                        invoiceBatch: vm.batchNo,
                    })
                    .then(function (response) {
                        if(response.data.status == 'S'){
                            swal({
                                html: true,
                                title: 'Success',
                                text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px">Interface Complete</span></h2>',
                            });
                            vm.disableInterface = true;
                        }else {
                            swal({
                                html: true,
                                title: 'Error',
                                text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px">'+ response.data.msg +'</span></h2>',
                            });
                        }
                    })
                    .catch(function (error) {
                         
                    })
                    .then(() => {
                        vm.loading = false;
                    });
                }
            },
            clickCancel() {
                const vm = this;
                vm.insuranceNo = '',
                vm.dateStart = '';
                vm.dateEnd = '';
                vm.year = ((new Date().getFullYear()) + 543).toString();
            },
            handleChange() {

            },
            getDateStart(obj) {
                const vm = this;
                vm.dateStart = obj.value;
            },
            getDateEnd(obj) {
                const vm = this;
                vm.dateEnd = obj.value;
            },
            getinvoiceDate(obj) {
                const vm = this;
                vm.invoiceDate = obj.value;
            },
            getYear(obj) {
                const vm = this;

                let y = obj.getFullYear() - 543;
                let efDate = vm.effectDateLists.find(function(date, index) {
                    if(date.lookup_code == y)
                        return true;
                });

                let startDate = new Date(efDate.start_date_active);
                vm.year = obj.getFullYear().toString();
                vm.dateStart = ( ("0"+startDate.getDate()).slice(-2) )+'/'+( ("0" + (startDate.getMonth()+1) ).slice(-2) )+'/'+(startDate.getFullYear()+543);
                vm.dateEnd = ( ("0"+startDate.getDate()).slice(-2) )+'/'+( ("0" + (startDate.getMonth()+1) ).slice(-2) )+'/'+(startDate.getFullYear()+544);
            },
        },
    }
</script>