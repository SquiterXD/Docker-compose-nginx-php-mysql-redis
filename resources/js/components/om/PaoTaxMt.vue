<template>
    <div v-loading="loading">
        <div class="row" style="margin-bottom: 1rem;" v-show="showRequires">
            <div class="col-md-12">
                <ul class="text-danger">
                    <li v-for="(msg, index) in requireLists" :key="index">
                        {{ msg }}
                    </li>
                </ul>
            </div>
        </div>
        <div class="row" style="margin-bottom: 1rem;">
            <div class="col-md-12 text-right">
                <button class="btn btn-light" @click="handleSearch">
                    <i class="fa fa-search"></i> Search
                </button>
                <button class="btn btn-primary" @click="handlePrintEx">
                    <i class="fa fa-print"></i> พิมพ์ตัวอย่าง
                </button>
                <button class="btn btn-light" @click="validateData">
                    <i class="fa fa-upload"></i> นำเข้าข้อมูล
                </button>
                <button class="btn btn-info" data-toggle="modal" data-target="#bankModal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-exchange"></i> ส่งรายการ Interface
                </button>
                <button class="btn btn-warning" @click="handleGl">
                    <i class="fa fa-exchange"></i> ส่งรายการปรับรายได้ GL
                </button>
                <button class="btn btn-danger" @click="handleDeleteData" :disabled="bdLists.length == 0">
                    <i class="fa fa-trash"></i> ลบรายการ
                </button>
            </div>
        </div>
        <div class="row" style="margin-bottom: 1rem;">
            <div class="col-md-2 text-right">
                <label for="year" style="padding-top: 10px;">ปี พ.ศ.</label>
            </div>
            <div class="col-md-3">
                <el-date-picker
                    :clearable="false"
                    class="w-100"
                    id="year"
                    v-model="year"
                    type="year"
                    placeholder="ปี พ.ศ."
                    format="yyyy"
                    value-format="yyyy"
                    :default-value="defaultYear">
                </el-date-picker>
            </div>
            <div class="col-md-4 text-right">
                <label for="batch_ap" style="padding-top: 10px;">Batch AP</label>
            </div>
            <div class="col-md-3">
                <el-input
                    class="w-100"
                    placeholder=""
                    v-model="batch_ap"
                    :disabled="true">
                </el-input>
            </div>
        </div>
        <div class="row" style="margin-bottom: 1rem;">
            <div class="col-md-2 text-right">
                <label for="month" style="padding-top: 10px;">ประจำเดือน</label>
            </div>
            <div class="col-md-3">
                <el-select v-model="month" filterable class="w-100" placeholder="Select">
                    <el-option
                        v-for="item in month_options"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4 text-right">
                <label for="batch_gl" style="padding-top: 10px;">Batch GL</label>
            </div>
            <div class="col-md-3">
                <el-input
                    class="w-100"
                    placeholder=""
                    v-model="batch_gl"
                    :disabled="true">
                </el-input>
            </div>
        </div>
        <div class="row" style="margin-bottom: 1rem;">
            <div class="col-md-2 text-right">
                <label for="customer_number" style="padding-top: 10px;">รหัสร้านค้า</label>
            </div>
            <div class="col-md-3">
                <el-select v-model="customer_number" class="w-100" placeholder="Select" filterable @change="findCustomer" clearable>
                    <el-option
                        v-for="item in customerLists"
                        :key="item.customer_id"
                        :label="item.customer_number"
                        :value="item.customer_number"
                        >
                        {{ item.customer_number+' : '+item.customer_name }}
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-3">
                <el-input
                    class="w-100"
                    placeholder=""
                    v-model="customer_name"
                    :disabled="true">
                </el-input>
            </div>
        </div>
        <div class="row" style="margin-bottom: 1rem;">
            <div class="col-md-2 text-right">
                <label for="file" style="padding-top: 10px;">ไฟล์ Excel</label>
            </div>
            <div class="col-md-6">
                <input type="file" id="file" ref="file" 
                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" 
                    v-on:change="handleFileUpload()">
            </div>
        </div>
        <div class="row" style="margin-bottom: 1rem;">
            <div class="col-md-2 text-right">
                <label for="display_sum" style="padding-top: 10px;">รวมค่าภาษีอบจ.ทั้งสิ้น</label>
            </div>
            <div class="col-md-6">
                <div class="w-100 el-input">
                    <vue-numeric read-only-class="el-input__inner text-right" 
                        class="el-input__inner text-right" separator="," 
                        :precision="2" :read-only="true" 
                        v-model="display_sum">
                    </vue-numeric>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12 text-right">
                <button class="btn btn-primary" @click="handleSaveData">
                    <i class="fa fa-floppy-o"></i> บันทึก
                </button>
            </div>
        </div>
        <el-tabs type="card" @tab-click="handleClickTab">
            <el-tab-pane label="แยกรายจังหวัด">
                <div class="row" style="margin-bottom: 1rem;">
                    <div class="col-md-12 table-responsive">
                        <table class="table" id="province_table">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        รหัสร้านค้า
                                    </th>
                                    <th class="text-center">
                                        ชื่อร้านค้า
                                    </th>
                                    <th class="text-center">
                                        จังหวัด
                                    </th>
                                    <th class="text-center">
                                        จำนวน
                                    </th>
                                    <th class="text-center">
                                        หน่วยนับ
                                    </th>
                                    <th class="text-center">
                                        ค่าภาษีอบจ.
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in pvLists" :key="index">
                                    <td class="text-center">
                                        {{ item.customer_number }}
                                    </td>
                                    <td>
                                        {{ item.customer_name }}
                                    </td>
                                    <td>
                                        {{ item.province_name }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberWithCommas(item.quantity) }}
                                    </td>
                                    <td class="text-center">
                                        {{ item.uom }}
                                    </td>
                                    <td class="text-right">
                                        <div class="w-100 el-input">
                                            <vue-numeric read-only-class="el-input__inner text-right" 
                                                class="el-input__inner text-right" separator="," 
                                                :precision="2" :read-only="true" 
                                                :value="item.pv_pao_tax">
                                            </vue-numeric>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </el-tab-pane>
            <el-tab-pane label="แยกรายตรา รายจังหวัด">
                <div class="row" style="margin-bottom: 1rem;">
                    <div class="col-md-12 table-responsive">
                        <table class="table" id="band_table">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        รหัสร้านค้า
                                    </th>
                                    <th class="text-center">
                                        ชื่อร้านค้า
                                    </th>
                                    <th class="text-center">
                                        จังหวัด
                                    </th>
                                    <th class="text-center">
                                        รหัสสินค้า
                                    </th>
                                    <th class="text-center">
                                        ชื่อตราสินค้า
                                    </th>
                                    <th class="text-center">
                                        จำนวน
                                    </th>
                                    <th class="text-center">
                                        หน่วยนับ
                                    </th>
                                    <th class="text-center">
                                        ค่าภาษีอบจ.
                                    </th>
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in bdLists" :key="item.pao_tax_mt_id">
                                    <td class="text-center">
                                        {{ item.customer ? item.customer.customer_number : '' }}
                                    </td>
                                    <td>
                                        {{ item.customer ? item.customer.customer_name : '' }}
                                    </td>
                                    <td>
                                        {{ item.province_name}}
                                    </td>
                                    <td>
                                        {{ item.item_code}}
                                    </td>
                                    <td>
                                        {{ item.item ? item.item.item_description : '' }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberWithCommas(item.quantity_cg) }}
                                    </td>
                                    <td class="text-center">
                                        {{ item.uom_v ? item.uom_v.unit_of_measure : item.uom_code }}
                                    </td>
                                    <td class="text-right">
                                        <div class="w-100 el-input">
                                            <vue-numeric
                                                class="el-input__inner text-right" 
                                                @change="handleChange(item.pao_tax_mt_id, $event)" 
                                                separator="," :precision="2"
                                                :value="item.adjust_amount">
                                            </vue-numeric>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" @click.prevent="removeData(item, $event)"> <i class="fa fa-times text-danger" aria-hidden="true"></i> </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </el-tab-pane>
        </el-tabs>
        <div class="modal inmodal fade" id="warningModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" @click="loading=false">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4>ดำเนินการต่อ ?</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px;">
                        <div v-for="(items, key) in warningLists" :key="key">
                            <ul>
                                <li v-for="(item, index) in items" :key="index">
                                    {{ item }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="loading=false">ยกเลิก</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="handleStore">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal inmodal fade" id="bankModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body" style="padding: 15px;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4>โปรดเลือก รหัสเจ้าหนี้ หรือธนาคาร ?</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <el-select v-model="bank" filterable class="w-100" placeholder="Select" 
                                    :popper-append-to-body="false"
                                    >
                                    <el-option
                                        v-for="(item, key) in bankLists"
                                        :key="key"
                                        :label="item.vendor_code+' : '+item.vendor_name+' : '+item.vendor_site_code"
                                        :value="item.vendor_code+' : '+item.vendor_name+' : '+item.vendor_site_code">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="handleInterface">ตกลง</button>
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

        props: ['customerLists', 'bankLists', 'defaultBank'],

        data() {
            return {
                loading: false,
                showRequires: false,
                saveable: false,
                defaultYear: '',
                year: '',
                month: '',
                month_options: [{
                    value: '1',
                    label: 'มกราคม'
                }, {
                    value: '2',
                    label: 'กุมภาพันธ์'
                }, {
                    value: '3',
                    label: 'มีนาคม'
                }, {
                    value: '4',
                    label: 'เมษายน'
                }, {
                    value: '5',
                    label: 'พฤษภาคม'
                }, {
                    value: '6',
                    label: 'มิถุนายน'
                }, {
                    value: '7',
                    label: 'กรกฎาคม'
                }, {
                    value: '8',
                    label: 'สิงหาคม'
                }, {
                    value: '9',
                    label: 'กันยายน'
                }, {
                    value: '10',
                    label: 'ตุลาคม'
                }, {
                    value: '11',
                    label: 'พฤศจิกายน'
                }, {
                    value: '12',
                    label: 'ธันวาคม'
                }],
                customer_number: '',
                customer_name: '',
                file: '',
                display_sum: '0.00',
                pvLists: [],
                bdLists: [],
                warningLists: {},
                requireLists: {},
                adjustLists: {},
                removeLists: {},
                bank: this.defaultBank,
                batch_ap: '',
                batch_gl: '',
            }
        },

        mounted() {
            let d = new Date();
            let year = d.getFullYear();
            let month = d.getMonth();
            let day = d.getDate();
            this.defaultYear = new Date(year + 543, month, day);

            $("#band_table, #province_table").DataTable({
                destroy : true,
            });
        },

        methods: {
            findCustomer(){
                let find = this.customerLists.find((item) => {
                    return item.customer_number == this.customer_number;
                });
                this.customer_name = find ? find.customer_name : '';
            },

            handleDeleteData() {
                let vm = this;
                this.$confirm('ต้องการทำรายการลบข้อมูลหรือไม่ ?', 'แจ้งเตือน', {
                    confirmButtonText: 'ตกลง',
                    cancelButtonText: 'ยกเลิก',
                    type: 'warning',
                    iconClass: 'fa fa-trash'
                }).then(() => {

                    axios.post('/om/pao-tax-mt/delete', {
                        year: vm.year,
                        month: vm.month,
                        customer_number: vm.customer_number,
                    })
                    .then(() => {
                        this.$message({
                            type: 'success',
                            message: 'ทำรายการเรียบร้อย'
                        });
                        window.location.reload()
                    })
                    .catch(() => {
                       this.$message({
                            type: 'info',
                            message: 'ไม่สามารถทำรายการได้'
                        });       
                    })

                    
                }).catch(() => {
                    // this.$message({
                    //     type: 'info',
                    //     message: 'Delete canceled'
                    // });          
                });
            },
            handleFileUpload(){
                this.file = this.$refs.file.files.length ? this.$refs.file.files[0] : '';
            },
            handleSearch(){
                let vm = this;
                vm.showRequires = false;
                vm.requireLists = {};

                if(!vm.year) {
                    vm.showRequires = true;
                    vm.requireLists['year'] = 'โปรดเลือกปี';
                }

                if(!vm.showRequires){

                    vm.bank = vm.defaultBank;
                    vm.batch_ap = '';
                    vm.batch_gl = '';
                    
                    vm.loading = true;
                    $("#band_table, #province_table").DataTable().destroy();
                    axios.get('/om/pao-tax-mt/search', {
                        params: {
                            year: vm.year,
                            month: vm.month,
                            customer_number: vm.customer_number,
                        }
                    }).then(function (response) {
                        vm.bdLists = response.data.result;
                    }).catch(function (error) {
                        console.log(error);
                    }).then(() => {
                        // always executed
                        vm.composePvTable();
                        vm.updateTotalPaotax();
                    }).then(() => {
                        // always executed
                        $("#band_table, #province_table").DataTable({
                            columnDefs: [
                                { targets: 'no-sort', orderable: false }
                            ],
                            pageLength: 10,
                            responsive: true,
                            destroy : true,
                        });
                        vm.loading = false;
                        vm.showSuccess();
                    });
                }
            },
            handlePrintEx(){
                let vm = this;
                var url = '/om/pao-tax-mt/ex-report?'+'year='+vm.year+'&month='+vm.month+'&customer_number='+vm.customer_number
                window.open(url, '_blank');
            },
            handleStore(){
                let vm = this;
                vm.loading = true;

                let formData = new FormData();
                formData.append('year', vm.year);
                formData.append('month', vm.month);
                formData.append('customer_number', vm.customer_number);
                formData.append('file', vm.file);
                axios.post('/om/pao-tax-mt/store',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function(response){
                    vm.$refs.file.value = '';
                    vm.file = '';
                }).catch(function(error){
                    console.log(error);
                }).then(() => {
                    // always executed
                    vm.handleSearch();
                });
            },
            handleChange(id, event){
                let vm = this;
                let change = vm.bdLists.find((item) => {
                    return item.pao_tax_mt_id == id;
                });

                change.adjust_amount = event.target.value;
                vm.saveable = true;
                vm.composePvTable();
                vm.updateTotalPaotax();

                vm.adjustLists[change.pao_tax_mt_id] = change.adjust_amount;
            },
            async removeData(item, event){
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

                        let index = vm.bdLists.indexOf(item);
                        vm.loading = true;

                        axios.post('/om/pao-tax-mt/remove',
                            {
                                'pao_tax_id': item.pao_tax_mt_id,
                            }
                        ).then(async function(response){
                            if(response.data.status == 'E'){
                                vm.showError(response.data.msg);
                            }else {

                                vm.bdLists.splice(index, 1);

                                await $("#band_table, #province_table").DataTable().destroy();

                                await $("#band_table, #province_table").DataTable({
                                    columnDefs: [
                                        { targets: 'no-sort', orderable: false }
                                    ],
                                    pageLength: 10,
                                    responsive: true,
                                    destroy : true,
                                });

                                vm.saveable = true;
                                await vm.composePvTable();
                                await vm.updateTotalPaotax();
                                await vm.showSuccess(response.data.msg);
                                
                            }
                        }).catch(function(error){
                            console.log(error);
                        }).then(async () => {
                            // always executed
                            vm.loading = false;
                        });
                    }
                });
            },
            handleSaveData(){
                let vm = this;
                vm.loading = true;

                axios.patch('/om/pao-tax-mt/update',
                    {
                       'adjust_lists': vm.adjustLists,
                    },
                ).then(function(response){
                    // console.log(response);
                }).catch(function(error){
                    console.log(error);
                }).then(() => {
                    // always executed
                    vm.loading = false;
                    vm.saveable = false;
                    vm.showSuccess();
                });
            },
            validateData(){
                let vm = this;
                vm.showRequires = false;
                vm.requireLists = {};

                if(!vm.year) {
                    vm.showRequires = true;
                    vm.requireLists['year'] = 'โปรดเลือกปี';
                }
                if(!vm.month) {
                    vm.showRequires = true;
                    vm.requireLists['month'] = 'โปรดเลือกเดือน';
                }
                if(!vm.file) {
                    vm.showRequires = true;
                    vm.requireLists['file'] = 'โปรดเลือกไฟล์';
                }

                if(!vm.showRequires){
                    vm.loading = true;

                    let formData = new FormData();
                    formData.append('year', vm.year);
                    formData.append('month', vm.month);
                    formData.append('customer_number', vm.customer_number);
                    formData.append('file', vm.file);
                    axios.post('/om/pao-tax-mt/validate',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function(response){
                        if(response.data.status == 'E'){
                            vm.loading = false;
                            vm.showError(response.data.msg);
                        }else if(response.data.status == 'W'){
                            vm.warningLists = response.data.errors;
                            $('#warningModal').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                        } else {
                            vm.handleStore();
                        }
                    }).catch(function(error){
                        console.log(error);
                    }).then(() => {
                        // always executed
                    });
                }
            },
            handleInterface(){
                let vm = this;
                vm.showRequires = false;
                vm.requireLists = {};

                if(!vm.year) {
                    vm.showRequires = true;
                    vm.requireLists['year'] = 'โปรดเลือกปี';
                }
                if(!vm.month) {
                    vm.showRequires = true;
                    vm.requireLists['month'] = 'โปรดเลือกเดือน';
                }
                if(!vm.bank) {
                    vm.showRequires = true;
                    vm.requireLists['bank'] = 'โปรดเลือกธนาคาร';
                }

                if(!vm.showRequires){
                    vm.loading = true;

                    let formData = new FormData();
                    formData.append('year', vm.year);
                    formData.append('month', vm.month);
                    formData.append('customer_number', vm.customer_number);
                    formData.append('bank', vm.bank);
                    axios.post('/om/pao-tax-mt/interface',
                        formData,
                    ).then(function(response){
                        if(response.data.status == 'S'){
                            let msg = 'group id : '+response.data.group_id;
                            vm.showSuccess(msg);
                            vm.batch_ap = response.data.group_id;
                            vm.bank = '';
                        }else {
                            vm.showError(response.data.msg);
                        }
                    }).catch(function(error){
                        console.log(error);
                    }).then(() => {
                        // always executed
                        vm.loading = false;
                    });
                }
            },
            async handleGl(){
                let vm = this;
                vm.showRequires = false;
                vm.requireLists = {};

                if(!vm.year) {
                    vm.showRequires = true;
                    vm.requireLists['year'] = 'โปรดเลือกปี';
                }
                if(!vm.month) {
                    vm.showRequires = true;
                    vm.requireLists['month'] = 'โปรดเลือกเดือน';
                }

                if(!vm.showRequires){
                    vm.loading = true;

                    swal({
                        title: "แจ้งเตือน",
                        text: "ส่งรายการปรับรายได้ GL?",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: 'ยกเลิก',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน'
                    },
                    async function(confirm) {
                        if (confirm) {
                            let formData = new FormData();
                            formData.append('year', vm.year);
                            formData.append('month', vm.month);
                            formData.append('customer_number', vm.customer_number);
                            axios.post('/om/pao-tax-mt/send-gl',
                                formData,
                            ).then(function(response){
                                if(response.data.status == 'S'){
                                    let msg = 'group id : '+response.data.group_id;
                                    vm.showSuccess(msg);
                                    vm.batch_gl = response.data.group_id;
                                    vm.bank = '';
                                }else {
                                    vm.showError(response.data.msg);
                                }
                            }).catch(function(error){
                                console.log(error);
                            }).then(() => {
                                // always executed
                                vm.loading = false;
                            });
                        }else {
                            vm.loading = false;
                        }
                    });
                }
            },
            handleClickTab(tab, event) {
                // console.log(tab, event);
            },
            async updateTotalPaotax(){
                let vm = this;
                let pao_tax_sum = 0;
                vm.bdLists.forEach((item) => {
                    pao_tax_sum += parseFloat(item.adjust_amount);
                });
                vm.display_sum = pao_tax_sum;
            },
            async composePvTable(){
                let vm = this;
                let lists = [];

                vm.bdLists.forEach((i) => {
                    let customer = i.customer;
                    let province = i.province;
                    let item = i.item;
                    let find = lists.find((element) => {
                        return element.province_name == province.province_thai && element.customer_number == customer.customer_number;
                    });
                    if(find){
                        lists.forEach((j) => {
                            if(j.province_name == province.province_thai && j.customer_number == customer.customer_number){
                                j.quantity += parseFloat(i.quantity_cg);
                                j.pv_pao_tax += parseFloat(i.adjust_amount);
                                j.items.push(i);
                            }
                        });
                    }else {
                        lists.push({
                            'province_name' : province.province_thai,
                            'customer_number' : customer.customer_number,
                            'customer_name' : customer.customer_name,
                            'quantity' : parseFloat(i.quantity_cg),
                            'uom' : i.uom_v ? i.uom_v.unit_of_measure : i.uom_code,
                            'pv_pao_tax' : parseFloat(i.adjust_amount),
                            'items' : [i],
                        });
                    }
                });
                vm.pvLists = lists;
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
