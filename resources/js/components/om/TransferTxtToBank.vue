<template>
    <div v-loading="loading">
        <div class="row mb-3">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>บัญชีธนาคาร <span class="text-danger">*</span></label>
                        <el-select v-model="bank" filterable class="w-100" placeholder="Select" :disabled="disable_params">
                            <el-option
                                v-for="item in bankLists"
                                :key="item.lookup_code"
                                :label="item.meaning"
                                :value="item.lookup_code">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>ประเภทร้านค้า <span class="text-danger">*</span></label>
                        <el-select v-model="customer_type" filterable class="w-100" placeholder="Select" @input="getCustomerLists()" :disabled="disable_params">
                            <el-option
                                v-for="item in customerTypeLists"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>รหัสร้านค้า</label>
                        <el-select v-model="customer" class="w-100" clearable="true" placeholder="Select" filterable :loading="loading_option" :disabled="disable_params">
                            <el-option
                                v-for="item in customerLists"
                                :key="item.customer_id"
                                :label="item.customer_number + ' - ' + item.customer_name"
                                :value="item.customer_id">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>ระบุวันที่เช็ค <span class="text-danger">*</span></label>
                        <datepicker-th
                            v-on:dateWasSelected="checkdateWasSelected"
                            :disabled="disabledDate"
                            :class="'w-100 form-control md:tw-mb-0 tw-mb-2'"
                            :type="'date'"
                            :value="check_date"
                            v-model="check_date"
                            name="check_date"
                            :format="'DD/MM/YYYY'">
                        </datepicker-th>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label>ตั้งแต่วันที่ <span class="text-danger">*</span></label>
                        <datepicker-th
                            v-on:dateWasSelected="startdateWasSelected"
                            :disabled="disabledDate"
                            :class="'w-100 form-control md:tw-mb-0 tw-mb-2'"
                            :type="'date'"
                            :value="start_date"
                            v-model="start_date"
                            name="start_date"
                            :format="'DD/MM/YYYY'">
                        </datepicker-th>
                    </div>
                     <div class="col-md-6">
                        <label>ถึงวันที่ <span class="text-danger">*</span></label>
                        <datepicker-th
                            v-on:dateWasSelected="enddateWasSelected"
                            :disabled="disabledDate"
                            :class="'w-100 form-control md:tw-mb-0 tw-mb-2'"
                            :type="'date'"
                            :value="end_date"
                            v-model="end_date"
                            name="end_date"
                            :format="'DD/MM/YYYY'">
                        </datepicker-th>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button class="btn btn-info mt-2 mt-md-0" type="button" @click="getPDF()" :disabled="disable_pdf"> พิมพ์รายงานเพื่อตรวจสอบ</button>
                        <button class="btn btn-primary mt-2 mt-md-0" type="button" @click="getTxt()" :disabled="disable_txt"> Generate Text file</button>
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

        props: ['bankLists'],

        data() {
            return {
                loading: false,
                loading_option: false,
                disable_params: false,
                disable_pdf: false,
                disable_txt: true,
                customerTypeLists: [
                    {
                        value: 'p1',
                        label: 'ร้านค้าป.1'
                    },
                    {
                        value: 'mt',
                        label: 'Modern Trade'
                    },
                ],
                customerLists: [],
                defaultDate: '',
                bank: '',
                customer_type: '',
                customer: '',
                check_date: '',
                start_date: '',
                end_date: '',
            }
        },

        mounted() {
            let d = new Date();
            let year = d.getFullYear();
            let month = d.getMonth();
            let day = d.getDate();
            this.defaultDate = new Date(year + 543, month, day);

            if(this.bankLists.length == 1){
                this.bank = this.bankLists[0].lookup_code;
            }
        },

        methods: {
            getCustomerLists(){
                let vm = this;
                vm.loading_option = true;
                vm.customer = '';

                axios.get('/om/transfer-txt-to-bank/customer-list?type='+vm.customer_type)
                .then(function(response){
                    vm.customerLists = response.data;
                }).catch(function(error){
                    console.log(error);
                }).then(() => {
                    // always executed
                    vm.loading_option = false;
                });
            },
            getPDF(){
                let vm = this;
                let msg = '';
                let error_flag = false;
    
                if(!vm.bank){
                    msg += 'กรุณาบัญชีธนาคาร <br>';
                    error_flag = true;
                }
                if(!vm.customer_type){
                    msg += 'กรุณาเลือกประเภทร้านค้า <br>';
                    error_flag = true;
                }
                if(!vm.check_date){
                    msg += 'กรุณาระบุวันที่เช็ค <br>';
                    error_flag = true;
                }
                if(!vm.start_date){
                    msg += 'กรุณาระบุวันที่เริ่ม <br>';
                    error_flag = true;
                }
                if(!vm.end_date){
                    msg += 'กรุณาระบุวันที่สิ้นสุด <br>';
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

                // vm.disable_params = true;
                // vm.disable_pdf = true;
                vm.disable_txt = false;
                var url = '/om/transfer-txt-to-bank/pdf?'
                            +'bank='+vm.bank
                            +'&customer_type='+vm.customer_type
                            +'&customer_id='+vm.customer
                            +'&check_date='+vm.check_date
                            +'&start_date='+vm.start_date
                            +'&end_date='+vm.end_date
                window.open(url, '_blank');
            },
            getTxt(){
                let vm = this;
                let msg = '';
                let error_flag = false;
    
                if(!vm.bank){
                    msg += 'กรุณาบัญชีธนาคาร <br>';
                    error_flag = true;
                }
                if(!vm.customer_type){
                    msg += 'กรุณาเลือกประเภทร้านค้า <br>';
                    error_flag = true;
                }
                if(!vm.check_date){
                    msg += 'กรุณาระบุวันที่เช็ค <br>';
                    error_flag = true;
                }
                if(!vm.start_date){
                    msg += 'กรุณาระบุวันที่เริ่ม <br>';
                    error_flag = true;
                }
                if(!vm.end_date){
                    msg += 'กรุณาระบุวันที่สิ้นสุด <br>';
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

                // vm.disable_txt = true;

                var url = '/om/transfer-txt-to-bank/txt?'
                            +'bank='+vm.bank
                            +'&customer_type='+vm.customer_type
                            +'&customer_id='+vm.customer
                            +'&check_date='+vm.check_date
                            +'&start_date='+vm.start_date
                            +'&end_date='+vm.end_date
                window.open(url, '_blank');
            },
            checkdateWasSelected(value){
                let vm = this;
                let year = value.getFullYear();
                let month = value.getMonth()+1;
                let day = value.getDate();
                vm.check_date = day+'/'+month+'/'+year;
            },
            startdateWasSelected(value){
                let vm = this;
                let year = value.getFullYear();
                let month = value.getMonth()+1;
                let day = value.getDate();
                vm.start_date = day+'/'+month+'/'+year;
            },
            enddateWasSelected(value){
                let vm = this;
                let year = value.getFullYear();
                let month = value.getMonth()+1;
                let day = value.getDate();
                vm.end_date = day+'/'+month+'/'+year;
            },
        }
    }
</script>
