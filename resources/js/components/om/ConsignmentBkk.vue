<template>
    <div v-loading="loading" class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-md btn-white" type="button" @click="reset"><i class="fa fa-repeat"></i></button>
                </div>
                <div class="col-md-9 text-right">
                    <button class="btn btn-md btn-success" :disabled="disabledCreate" type="button" id="buttonCreate" @click="create"><i class="fa fa-plus"></i> สร้าง</button>
                    <button class="btn btn-md btn-white" :disabled="disabledSearch" type="button" id="buttonSearch" @click="search"><i class="fa fa-search"></i> ค้นหา</button>
                    <button class="btn btn-md btn-info" :disabled="disabledConfirm" type="button" id="buttonConfirm" @click="save"><i class="fa fa-check"></i> ยืนยันข้อมูล</button>
                    <button class="btn btn-md btn-success" :disabled="disabledAttach" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> ไฟล์แนบ</span></button>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
        </div>

        <div class="col-xl-10 m-auto">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="d-block">เลขที่ใบฝากขายสโมสร</label>
                        <div>
                            <el-select 
                                :disabled="disabledConsignment" 
                                @input="findConsignment"
                                v-model="consignment" 
                                name="consignment" 
                                class="w-100" 
                                clearable 
                                filterable
                                remote
                                :remote-method="searchConsignment"
                                :loading="loadingConsignment"
                                placeholder="">
                                <el-option
                                    style="height: auto;"
                                    v-for="item in consignment_lists"
                                    :key="item.consignment_header_id"
                                    :label="item.consignment_no"
                                    :value="item.consignment_header_id">
                                    <div><b>{{ item.consignment_no }}</b></div>
                                    <div>{{ item.consignment_no }} : {{ displayDate(item.consignment_date) }} : {{ item.consignment_status }}</div>
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="d-block">วันที่บันทึก</label>
                        <div>
                            <datepicker-th
                                v-on:dateWasSelected="dateWasSelected"
                                :disabled="disabledDate"
                                :class="disabledDate ? 'w-100 bg-readonly form-control md:tw-mb-0 tw-mb-2' : 'w-100 form-control md:tw-mb-0 tw-mb-2'"
                                :type="'date'"
                                :value="date"
                                v-model="date"
                                name="date"
                                :format="'DD/MM/YYYY'">
                            </datepicker-th>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="d-block">Status</label>
                        <div>
                            <el-select 
                                v-model="status" 
                                name="status"
                                class="w-100" 
                                :disabled="true"
                                placeholder="">
                                <el-option key="" value="" label=""></el-option>
                                <el-option key="Draft" value="Draft" label="Draft"></el-option>
                                <el-option key="Confirm" value="Confirm" label="Confirm"></el-option>
                                <el-option key="Cancelled" value="Cancelled" label="Cancelled"></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label class="d-block">รหัสลูกค้า</label>
                        <div class="row space-5">
                            <div class="col-md-4">
                                <div>
                                    <el-select :disabled="disabledCustomer" v-model="customer" name="customer" 
                                        @input="findCustomer"
                                        class="w-100" 
                                        clearable 
                                        filterable
                                        placeholder="">
                                        <el-option
                                            style="height: auto;"
                                            v-for="item in customerLists"
                                            :key="item.customer_id"
                                            :label="item.customer_number"
                                            :value="item.customer_id">
                                            <div><b>{{ item.customer_number }}</b></div>
                                            <div>{{ item.customer_number }} : {{ item.customer_name }}</div>
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="col-md-8 mt-2 mt-md-0">
                                <input class="form-control" readonly v-model="customer_name">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <hr class="md">

            <div class="table-responsive">
                <table class="table table-bordered text-center table-hover min-1000 f13">
                    <thead>
                        <tr class="align-middle">
                            <th rowspan="2">
                                ลำดับ
                            </th>
                            <th rowspan="2">
                                รหัสผลิตภัณฑ์
                            </th>
                            <th rowspan="2">
                                ชื่อผลิตภัณฑ์
                            </th>
                            <th rowspan="2">
                                จำนวน <br>
                                พันมวน/ซอง
                            </th>
                            <th class="w-160" rowspan="2">
                                มูลค่า (บาท)
                            </th>
                            <th rowspan="2">
                                ยอดขายได้ <br>
                                พันมวน/ซอง
                            </th>
                            <th rowspan="2">
                                คงเหลือขาย <br>
                                พันมวน/ซอง
                            </th>
                            <th class="w-160" colspan="2">
                                บันทึกยอดขาย
                            </th>
                        </tr>
                        <tr class="align-middle">
                            <th class="w-160">
                                พันมวน/ซอง
                            </th>
                            <th class="w-160">
                                ห่อ
                            </th>
                        </tr>
                    </thead>
                    <tbody id="consignmentLines">
                        <tr class="align-middle" :key="index" v-for="(item, index) in sortedTable">
                            <td>
                                {{ index+1 }}
                            </td>
                            <td class="text-left">
                                {{ item.item_code }}
                            </td>
                            <td class="text-left">
                                {{ item.item_description }}
                            </td>
                            <td class="text-right">
                                {{ numberWithCommas(item.qty) }}
                            </td>
                            <td class="text-right">
                                {{ numberWithCommas(item.unit_price) }}
                            </td>
                            <td class="text-right">
                                {{ numberWithCommas(item.sale_qty) }}
                            </td>
                            <td class="text-right">
                                {{ numberWithCommas(item.remain_qty) }}  
                            </td>
                            <td>
                                <vue-numeric 
                                    read-only-class="form-control bg-readonly text-right" 
                                    class="el-input__inner text-right" separator="," 
                                    :precision="2" :read-only="readOnly"
                                    @change="handleChange(index, 'CGK')"
                                    v-model="table_data[index].cgk_qty">
                                </vue-numeric>
                            </td>
                            <td>
                                <vue-numeric 
                                    read-only-class="form-control bg-readonly text-right" 
                                    class="el-input__inner text-right" separator="," 
                                    :precision="2" :read-only="readOnly"
                                    @change="handleChange(index, 'PTN')"
                                    v-model="table_data[index].ptn_qty">
                                </vue-numeric>
                            </td>
                        </tr>
                        <tr class="align-middle">
                            <td class="text-right" colspan="4"><strong>รวมมูลค่า</strong></td>
                            <td>
                                <input type="text" class="form-control text-right" readonly name="" placeholder="" v-model="total_unit_price">
                            </td>
                            <td class="text-right" colspan="2"><strong>รวมยอดขายฝาก</strong></td>
                            <td>
                                <input type="text" class="form-control text-right" readonly name="" placeholder="" v-model="total_cgk_qty">
                            </td>
                            <td>
                                <input type="text" class="form-control text-right" readonly name="" placeholder="" v-model="total_ptn_qty">
                            </td>
                        </tr>
                        <tr class="align-middle">
                            <td class="text-right" colspan="7"><strong>รวมมูลค่าขายฝาก</strong></td>
                            <td colspan="2">
                                <input type="text" class="form-control text-right" readonly name="" placeholder="" v-model="total_actual_amount">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="attachmentModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Upload File</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="attachment-box">
                            <div class="form-group d-flex mb-1">
                                <div class="custom-file" style="width: 70%">
                                    <input ref="file" @input="addFile()" type="file" class="custom-file-input" accept=".jpeg, .jpg, .bmp, .png, .pdf, .doc, .docx, .xls, .xlsx, .rar, .zip, .csv">
                                    <label for="attachment" class="custom-file-label label-attachment">Choose file...</label>
                                </div>
                                <div class="button">
                                    <button class="btn btn-success" type="button" @click="addFileList">Submit</button>
                                    <button class="btn btn-warning" type="button" @click="clearFile">Clear</button>
                                </div>
                            </div>
                            <p><small>Allow type : jpeg, bmp, png, pdf, doc, docx, xls, xlsx, rar, zip, csv and size &lt; 2mb</small></p>
                            <ul class="nav files">
                                <li :key="'attach_files_'+index" v-for="(item, index) in attach_files">
                                    <code><a :href="'/'+item.path_name" target="_blank"><i class="fa fa-file-pdf-o"></i>  {{ item.file_name }}</a></code>
                                    <button class="btn btn-xs btn-remove" @click="removeFileAttachment(index, item.attachment_id)" type="button"><i class="fa fa-times"></i></button>
                                </li>
                                <li :key="'files_'+index" v-for="(item, index) in files">
                                    <code><a :href="getSrc(item)" target="_blank"><i class="fa fa-file-pdf-o"></i>  {{ item.name }}</a></code>
                                    <button class="btn btn-xs btn-remove" @click="removeFileLocal(index)" type="button"><i class="fa fa-times"></i></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer center mt-4">
                        <button class="btn btn-default" type="button" data-dismiss="modal">
                            ปิด
                        </button>
                        <button class="btn btn-primary" v-if="!!consignment" @click="upload" type="submit">
                            ยืนยัน
                        </button>
                        <button class="btn btn-primary" v-else data-dismiss="modal" type="submit">
                            ยืนยัน
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueNumeric from 'vue-numeric'
    import DatepickerTh from "../DatepickerTh";

    export default {

        components: {
            VueNumeric,
            DatepickerTh
        },

        props: ['customerLists', 'convertLists'],

        data() {
            return {
                loading: false,
                loadingConsignment: false,

                date: '',
                status: '',
                consignment: '',
                customer: '',
                customer_name: '',
                table_data: [],
                order_headers: [],
                consignment_lists: [],
                attach_files: [],
                files: [],

                total_unit_price: '0.00',
                total_actual_qty: '0.00',
                total_cgk_qty: '0.00',
                total_ptn_qty: '0.00',
                total_actual_amount: '0.00',

                disabledCreate: false,
                disabledSearch: true,
                disabledConfirm: true,
                disabledAttach: true,
                disabledConsignment: false,
                disabledCustomer: false,
                disabledDate: false,
                readOnly: false,
                state: 'search',
            }
        },

        mounted() {
            let vm = this;
            vm.getConsignments();
        },

        computed: {
            sortedTable: function() {
                function compare(a, b) {
                    if (a.item_code < b.item_code)
                        return -1;
                    if (a.item_code > b.item_code)
                        return 1;
                    return 0;
                }

                return this.table_data.sort(compare);
            },
        },

        methods: {
            reset(){
                let vm = this;
                vm.state = 'search';
                vm.customer_name = vm.customer = vm.status = vm.consignment = vm.date = '';
                vm.order_headers = vm.table_data = [];
                vm.total_unit_price = vm.total_actual_qty = vm.total_cgk_qty = vm.total_ptn_qty = vm.total_actual_amount = '0.00';
                vm.disabledCreate = vm.disabledConsignment = vm.disabledCustomer = vm.disabledDate = vm.readOnly = false;
                vm.disabledSearch = vm.disabledConfirm = vm.disabledAttach = true;
                vm.getConsignments();
            },
            async create(){
                let vm = this;
                vm.state = 'create';
                vm.consignment = '';
                vm.disabledCreate = vm.disabledConsignment = true;
                vm.disabledAttach = false;
                vm.disabledConfirm = false;
                vm.setDate();
                vm.status = 'Draft';
                vm.readOnly = false;
                if(vm.customerLists.length == 1){
                    vm.disabledCustomer = true;
                    vm.customer = vm.customerLists[0].customer_id;
                    vm.findCustomer();
                }else {
                    vm.disabledCustomer = false;
                }
                vm.table_data = [];
                vm.total_unit_price = vm.total_actual_qty = vm.total_cgk_qty = vm.total_ptn_qty = vm.total_actual_amount = '0.00';
            },
            async search(){
                let vm = this;

                let total_unit_price;
                let total_actual_qty;
                let total_cgk_qty;
                let total_ptn_qty;
                let total_actual_amount;

                let find = vm.consignment_lists.find((item) => {
                    return item.consignment_header_id == vm.consignment;
                });

                vm.attach_files = find.attach;
                vm.table_data = [];

                if(find.consignment_status == 'Draft'){
                    await vm.getOrderHeaders();

                    vm.disabledCreate = vm.disabledSearch = vm.disabledConsignment = vm.disabledCustomer = vm.disabledDate = find ? true : false;
                    vm.disabledConfirm =  vm.disabledDate = vm.readOnly = vm.disabledAttach = find ? false : true;

                }else {
                    total_unit_price = 0;
                    total_actual_qty = 0;
                    total_cgk_qty = 0;
                    total_ptn_qty = 0;
                    total_actual_amount = 0;

                    vm.readOnly = vm.disabledCreate = vm.disabledSearch = vm.disabledConfirm = vm.disabledConsignment = vm.disabledCustomer = vm.disabledDate = find ? true : false;
                    vm.disabledAttach = find ? false : true;
                    find.lines.forEach((item) => {
                        let find = vm.table_data.find((i) => {
                            return item.item_code == i.item_code; 
                        });
                        if(find){
                            find.actual_qty += parseFloat(item.actual_quantity);
                            find.cgk_qty += parseFloat(item.actual_quantity);
                            find.ptn_qty += vm.convertUom( item.seq_ecom.product_type_code, parseFloat(item.actual_quantity), 'CGK', 'PTN');
                        }else {
                            vm.table_data.push({
                                'item_id': item.item_id,
                                'item_code': item.item_code,
                                'item_description': item.item_description,
                                'product_type_code': item.seq_ecom.product_type_code,
                                'uom': item.uom.unit_of_measure,
                                'qty': parseFloat(item.quantity),
                                'unit_price': parseFloat(item.order_line.unit_price * item.quantity),
                                'sale_qty': parseFloat(item.previous_quantity),
                                'remain_qty': parseFloat(item.remaining_quantity),
                                'actual_qty': parseFloat(item.actual_quantity),
                                'cgk_qty': parseFloat(item.actual_quantity),
                                'ptn_qty': vm.convertUom( item.seq_ecom.product_type_code, parseFloat(item.actual_quantity), 'CGK', 'PTN'),
                            });
                        }

                        total_unit_price += parseFloat(item.order_line.unit_price * item.quantity);
                        total_actual_qty += parseFloat(item.actual_quantity);
                        total_cgk_qty += parseFloat(item.actual_quantity);
                        total_ptn_qty += vm.convertUom( item.seq_ecom.product_type_code, parseFloat(item.actual_quantity), 'CGK', 'PTN');
                        total_actual_amount += parseFloat(item.order_line.unit_price * item.actual_quantity);
                    });

                    vm.total_unit_price = vm.numberWithCommas(total_unit_price);
                    vm.total_actual_qty = vm.numberWithCommas(total_actual_qty);
                    vm.total_cgk_qty = vm.numberWithCommas(total_cgk_qty);
                    vm.total_ptn_qty = vm.numberWithCommas(total_ptn_qty);
                    vm.total_actual_amount = vm.numberWithCommas(total_actual_amount);
                }
            },
            async save(){
                let vm = this;
                vm.loading = true;

                if(vm.total_actual_qty <= 0){
                    vm.showWarning('กรุณาระบุยอดฝากขาย');
                    vm.loading = false;
                    return;
                }

                swal({
                    title: "แจ้งเตือน",
                    text: "ยืนยันรายการฝากขายสโมสรหรือไม่?",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: 'ยกเลิก',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน'
                },
                async function(confirm) {
                    if (confirm) {

                        let data = vm.composeData();
                        let formData = new FormData();
                        for( var i = 0; i < vm.files.length; i++ ){
                            let file = vm.files[i];
                            formData.append('attachment[' + i + ']', file);
                        }
                        formData.append('consignment', vm.consignment);
                        formData.append('date', vm.date);
                        formData.append('customer_id', vm.customer);
                        formData.append('data', JSON.stringify(data));
                        await axios.post('/om/consignment-bkk',
                            formData,
                            {
                                headers: {
                                'Content-Type': 'multipart/form-data'
                                }
                            }
                        ).then(async function(response){
                            if(response.data.status == 'S'){
                                vm.files = [];
                                vm.consignment = response.data.consignment;
                                await vm.getConsignments();
                                await vm.findConsignment();
                                await vm.search();
                                vm.clearFile();
                                await vm.showSuccess('ยืนยันรายการฝากขายสโมสรเรียบร้อยแล้ว');
                            }else {
                                await vm.showError('ยืนยันใบรายการฝากขายสโมสรไม่ได้');
                            }
                        }).catch(async function(error){
                            console.log(error);
                        }).then(async () => {
                            // always executed
                            vm.loading = false;
                        });
                    } else {
                        vm.loading = false;
                    }
                });
            },
            composeData(){
                let vm = this;
                let data = [];
                vm.table_data.forEach((item) => {
                    if(item.actual_qty > 0){
                        data.push({
                            'item_id': item.item_id,
                            'actual': item.actual_qty,
                        });
                    }
                });
                return data;
            },
            setDate(date = null){
                let vm = this;
                let d = date ? new Date(date) : new Date();
                let year = d.getFullYear()+543;
                let month = d.getMonth()+1;
                let day = d.getDate();
                return vm.date = day+'/'+month+'/'+year;
            },
            dateWasSelected(value){
                let vm = this;
                let year = value.getFullYear();
                let month = value.getMonth()+1;
                let day = value.getDate();
                vm.date = day+'/'+month+'/'+year;
            },
            async findCustomer(){
                let vm = this;
                vm.setCustomerName();
                if(vm.state === 'create'){
                    await vm.getOrderHeaders();
                }
            },
            async setCustomerName(){
                let vm = this;
                let find = vm.customerLists.find((item) => {
                    return item.customer_id == vm.customer;
                });
                vm.customer_name = find ? find.customer_name : '';
            },
            async findConsignment(){
                let vm = this;
                let find = vm.consignment_lists.find((item) => {
                    return item.consignment_header_id == vm.consignment;
                });
                vm.disabledSearch = find ? false : true;
                vm.customer_name = find ? find.customer_name : '';
                vm.date = find ? vm.setDate(find.consignment_date) : '';
                vm.customer = find ? (find.order_header ? find.order_header.customer.customer_id : find.customer.customer_id) : '';
                vm.status = find ? find.consignment_status : '';
                if(vm.customer != ''){
                    vm.setCustomerName();
                }
            },
            async getOrderHeaders(){
                let vm = this;
                vm.table_data = [];
                vm.loading = true;
                await axios.get('/om/consignment-bkk/get-order-header', {
                    params: { 
                        'customer': vm.customer,
                    }
                })
                .then(function(response){
                    vm.order_headers = response.data;
                }).catch(function(error){
                    console.log(error);
                }).then(async () => {
                    // always executed
                    await vm.setCreate();
                    vm.loading = false;
                });
            },
            async getConsignments(){
                let vm = this;
                vm.loading = true;
                vm.consignment_lists = [];
                await axios.get('/om/consignment-bkk/get-consignment', {
                    params: { 
                        'consignment_id': vm.consignment,
                    }
                })
                .then(function(response){
                    vm.consignment_lists = response.data;
                }).catch(function(error){
                    console.log(error);
                }).then(() => {
                    // always executed
                    vm.loading= false;
                });
            },
            async searchConsignment(query){
                let vm = this;
                vm.loadingConsignment = true;
                vm.consignment_lists = [];
                await axios.get('/om/consignment-bkk/get-consignment', {
                    params: { 
                        'consignment_no': query,
                    }
                })
                .then(function(response){
                    vm.consignment_lists = response.data;
                }).catch(function(error){
                    console.log(error);
                }).then(() => {
                    // always executed
                    vm.loadingConsignment= false;
                });
            },
            async setCreate(){
                let vm = this;
                let total_unit_price = 0;
                let total_actual_qty = 0;
                let total_cgk_qty = 0;
                let total_ptn_qty = 0;
                let total_actual_amount = 0;
                vm.order_headers.forEach((item) => {
                    item.lines.forEach((line) => {
                        let sum_actual_quantity = line.approve_quantity - line.consignment_lines.reduce((a, b) => a + parseFloat(b.actual_quantity || 0), 0);
                        if(sum_actual_quantity > 0){
                            let find = vm.table_data.find((i) => {
                                return line.item_code == i.item_code;
                            });
                            if(find){
                                find.qty += parseFloat(line.approve_quantity);
                                find.unit_price += parseFloat(line.unit_price * line.approve_quantity);
                                find.sale_qty += parseFloat(sum_actual_quantity);
                                find.remain_qty += parseFloat(sum_actual_quantity);
                                find.detail.push({
                                    'order': item.order_header_id,
                                    'price': parseFloat(line.unit_price),
                                    'qty': parseFloat(line.approve_quantity),
                                    'remain': parseFloat(sum_actual_quantity),
                                });
                            }else {
                                vm.table_data.push({
                                    'item_id': line.item_id,
                                    'item_code': line.item_code,
                                    'item_description': line.item_description,
                                    'product_type_code': line.seq_ecom.product_type_code,
                                    'uom': line.uom,
                                    'qty': parseFloat(line.approve_quantity),
                                    'unit_price': parseFloat(line.unit_price * line.approve_quantity),
                                    'sale_qty': parseFloat(sum_actual_quantity),
                                    'remain_qty': parseFloat(sum_actual_quantity),
                                    'actual_qty': 0,
                                    'cgk_qty': 0,
                                    'ptn_qty' : 0,
                                    'detail': [{
                                        'order': item.order_header_id,
                                        'price': parseFloat(line.unit_price),
                                        'qty': parseFloat(line.approve_quantity),
                                        'remain': parseFloat(sum_actual_quantity),
                                    }]
                                });
                            }
                            total_unit_price += parseFloat(line.unit_price * line.approve_quantity);
                        }
                    });
                });
                vm.total_unit_price = vm.numberWithCommas(total_unit_price);
                vm.total_actual_qty = vm.numberWithCommas(total_actual_qty);
                vm.total_cgk_qty = vm.numberWithCommas(total_cgk_qty);
                vm.total_ptn_qty = vm.numberWithCommas(total_ptn_qty);
                vm.total_actual_amount = vm.numberWithCommas(total_actual_amount);
            },
            handleChange(index, from_uom){
                let vm = this;
                let actual;
                let cgk = Math.round(vm.table_data[index].cgk_qty * 100) / 100;
                let ptn = Math.round(vm.table_data[index].ptn_qty * 100) / 100;
                let sale_qty = Math.round(vm.table_data[index].sale_qty * 100) / 100;
                let product_type_code = vm.table_data[index].product_type_code;

                if(from_uom == 'CGK'){
                    actual = cgk;
                    ptn = Math.round(vm.convertUom(product_type_code, cgk, 'CGK', 'PTN') * 100) / 100;
                }else {
                    actual = Math.round(vm.convertUom(product_type_code, ptn, 'PTN', 'CGK') * 100) / 100;
                    cgk = actual;
                }

                if(actual > sale_qty){
                    vm.table_data[index].remain_qty = parseFloat(sale_qty);
                    vm.table_data[index].actual_qty = 0;
                    vm.table_data[index].cgk_qty = 0;
                    vm.table_data[index].ptn_qty = 0;
                    vm.showWarning('จำนวนยอดขายที่ระบุมากกว่าจำนวนคงเหลือขาย');
                }else {
                    vm.table_data[index].remain_qty = parseFloat(sale_qty - actual);
                    vm.table_data[index].actual_qty = actual;
                    vm.table_data[index].cgk_qty = cgk;
                    vm.table_data[index].ptn_qty = ptn;
                }
                vm.calTotal();
            },
            calTotal(){
                function compare(a, b) {
                    if (a.order < b.order)
                        return -1;
                    if (a.order > b.order)
                        return 1;
                    return 0;
                }

                let vm = this;
                let total_actual_qty = 0;
                let total_cgk_qty = 0;
                let total_ptn_qty = 0;
                let total_actual_amount = 0;
                vm.table_data.forEach((item) => {
                    let qty = item.actual_qty;
                    total_actual_qty += parseFloat(item.actual_qty);
                    total_cgk_qty += parseFloat(item.cgk_qty);
                    total_ptn_qty += parseFloat(item.ptn_qty);
                    item.detail.sort(compare);
                    item.detail.forEach((detail) => {
                        if(qty > 0){
                            if(qty > detail.remain){
                                total_actual_amount += parseFloat(detail.price * detail.remain);
                                qty = parseFloat(qty - detail.remain);
                            } else {
                                total_actual_amount += parseFloat(detail.price * qty);
                                qty = parseFloat(qty - qty);
                            }
                        }
                    });
                });
                vm.total_actual_qty = vm.numberWithCommas(total_actual_qty);
                vm.total_cgk_qty = vm.numberWithCommas(total_cgk_qty);
                vm.total_ptn_qty = vm.numberWithCommas(total_ptn_qty);
                vm.total_actual_amount = vm.numberWithCommas(total_actual_amount);
            },
            clearFile(){
                this.attach = '';
                this.$refs.file.value = null;
                $('.label-attachment').html('Choose file...');
            },
            addFile(){
                if(this.$refs.file.files.length){
                    $('.label-attachment').html(this.$refs.file.files[0].name);
                }
            },
            addFileList(){
                if(this.$refs.file.files.length){
                    this.files.push( this.$refs.file.files[0] );
                    this.clearFile();
                }
            },
            async upload(){
                let vm = this;
                vm.loading = true;

                $('#attachmentModal').modal('hide');

                let formData = new FormData();
                for( var i = 0; i < vm.files.length; i++ ){
                    let file = vm.files[i];
                    formData.append('attachment[' + i + ']', file);
                }
                for( var i = 0; i < vm.attach_files.length; i++ ){
                    let file = vm.attach_files[i];
                    formData.append('check_attachment[' + i + ']', file.attachment_id);
                }
                formData.append('consignment', vm.consignment);
                await axios.post('/om/consignment-bkk/attach',
                    formData,
                    {
                        headers: {
                        'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(async function(response){
                    if(response.data.status != 'E'){
                        await vm.getConsignments();
                    }
                }).catch(async function(error){
                    console.log(error);
                }).then(async () => {
                    // always executed
                    vm.loading = false;
                    let find = vm.consignment_lists.find((item) => {
                        return item.consignment_header_id == vm.consignment;
                    });
                    vm.attach_files = find.attach;
                    vm.files = [];
                    vm.clearFile();
                });
            },
            removeFileLocal(index){
                this.files.splice(index, 1);
            },
            async removeFileAttachment(index, attach_id){
                this.attach_files.splice(index, 1);
            },
            showSuccess(msg){
                swal('', msg, "success");
            },
            showError(msg){
                swal('', msg, "error");
            },
            showWarning(msg){
                swal('', msg, "warning");
            },
            numberWithCommas(x) {
                return parseFloat(x).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            },
            displayDate(date) {
                let d = new Date(date);
                let year = d.getFullYear();
                let month = d.getMonth();
                let day = d.getDate();
                return day+'/'+(month+1)+'/'+(year+543);
            },
            getSrc(file) {
                const src = URL.createObjectURL(file);
                return src;
            },
            convertUom(product_type_code, qty, from_uom, to_uom) {
                let vm = this;
                const find = vm.convertLists.find((item) => {
                    return item.product_type_code == product_type_code
                        && item.from_uom == from_uom
                        && item.to_uom == to_uom;
                });

                return qty * find.conversion_rate;
            }
        }
    }
</script>
