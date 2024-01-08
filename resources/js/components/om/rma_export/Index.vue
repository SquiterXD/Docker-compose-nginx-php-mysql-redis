<template>
    <div class="container-fluid">
        <div class="form-group row">
            <div class="col-lg-12">
                <div class="ibox" v-loading="loading.data">
                    <div class="ibox-title">
                        <h5>คืนสินค้า (RMA)</h5>
                        <div class="form-header-buttons">
                            <div class="d-flex">
                                <button class="btn btn-md btn-white" @click="onClearSearch"><i class="fa fa-repeat"></i>
                                </button>
                            </div>
                            <div class="buttons multiple">
                                <button class="btn btn-md btn-success"
                                        type="button"
                                        @click="onAdd">
                                    <i class="fa fa-plus"></i>
                                    สร้าง
                                </button>
                                <button class="btn btn-md btn-white"
                                        type="button"
                                        @click="onSearch">
                                    <i class="fa fa-search"></i>
                                    ค้นหา
                                </button>
                                <div class="dropdown">
                                    <button class="btn btn-md btn-primary m-0" data-toggle="dropdown" type="button">
                                        ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a @click="onSave" disabled>บันทึก</a></li>
                                        <li><a @click="onConfirm">ยืนยัน</a></li>
                                        <li><a @click="onCancel">ยกเลิก</a></li>
<!--                                        <li><a @click="onTest1">ทดสอบ</a></li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>เลขที่คืนสินค้า</label>
                                    <el-select
                                        class="col-sm-12 px-0"
                                        style="width: 100%"
                                        v-model="numberSelected"
                                        v-loading="loading.data"
                                        filterable
                                        :disabled="dsaNumber"
                                        @change="onNumberChange"
                                        placeholder="กรุณาเลือกเลขที่คืนสินค้า"
                                    >
                                        <el-option v-for="item in this.filterNumber"
                                                   :key="item.rma_number"
                                                   :label="item.rma_number"
                                                   :value="item.rma_number">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label>วันที่คืนสินค้า</label>
                                <input type="text" class="form-control" v-model="selNumber.rma_date" disabled/>
                            </div>
                            <div class="col-sm-4">
                                <label>สถานะ</label>
                                <input type="text" class="form-control" v-model="selNumber.status_rma" disabled/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>อ้างอิง Invoice เลขที่</label>
                                    <el-select
                                        class="col-sm-12 px-0"
                                        style="width: 100%"
                                        v-model="invoiceSelected"
                                        filterable
                                        :disabled="dsaInvoice"
                                        @change="onInvoiceChange"
                                        placeholder="กรุณาเลือกเลขที่ Invoice"
                                    >
                                        <el-option v-for="item in this.filterInvoice"
                                                   :key="item.pick_release_no"
                                                   :label="item.pick_release_no"
                                                   :value="item.pick_release_no"
                                                   :selected="item.pick_release_no == invoiceSelected"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>วันที่ Invoice</label>
                                    <input class="form-control" type="text"
                                           v-model="selInvoice.pick_release_approve_date" disabled/>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>เลขที่ใบลดหนี้</label>
                                    <input class="form-control" type="text"
                                           v-model="selNumber.credit_note_number" disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>รหัสร้านค้า</label>
                                    <el-select
                                        class="col-sm-12 px-0"
                                        style="width: 100%"
                                        v-model="customerSelected"
                                        filterable
                                        :disabled="dsaCustomer"
                                        @change="onCustomerChange"
                                        placeholder="กรุณาเลือกรหัสร้านค้า"
                                    >
                                        <el-option v-for="item in this.filterCustomer"
                                                   :key="item.customer_number"
                                                   :label="item.customer_number + ' : ' + item.customer_name"
                                                   :value="item.customer_number"
                                                   :selected="item.customer_number == customerSelected"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>ชื่อร้านค้า</label>
                                    <input class="form-control" type="text" v-model="selCustomer.customer_name"
                                           disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>สั่งทาง</label>
                                    <input class="form-control" type="text" v-model="selInvoice.source_system" disabled/>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>หมายเหตุสั่งทาง</label>
                                    <input class="form-control" type="text" v-model="selInvoice.remark_source_system"
                                           disabled/>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>สถานที่จัดส่งสินค้า</label>
                                    <input class="form-control" type="text" v-model="selInvoice.ship_to_site_name"
                                           disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>หมายเหตุรายการ</label>
                                    <textarea class="form-control" rows="3"
                                              v-model="selNumber.symptom_description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="col-xl-12">
                            <div v-if="isCigaratte" class="table-responsive">
                                <table class="table table-bordered text-center table-hover f13">
                                    <thead>
                                    <tr class="align-middle">
                                        <th rowspan="2">เลือก</th>
                                        <th rowspan="2">รายการที่</th>
                                        <th rowspan="2">รหัสผลิตภัณฑ์</th>
                                        <th rowspan="2">ชื่อผลิตภัณฑ์</th>
                                        <th colspan="2">จำนวนที่ซื้อ</th>
                                        <th colspan="3">จำนวนที่ขอคืน</th>
                                    </tr>
                                    <tr class="align-middle">
                                        <!--จำนวนที่ซื้อ-->
                                        <th class="w-80">จำนวน</th>
                                        <th class="w-80">หน่วยนับ</th>

                                        <!--จำนวนที่คืน-->
                                        <th class="w-80">หีบ</th>
                                        <th class="w-80">ห่อ</th>
                                        <th class="w-80">ซอง</th>
                                        <!-- <th class="w-120">จำนวน</th> -->
                                    </tr>
                                    </thead>
                                    <tbody v-if="orderLines.length">
                                    <tr v-for="(item,itemIdx) in orderLines" :key="itemIdx">
                                        <td>
                                            <input type="checkbox" v-model="enaRow[itemIdx]" :disabled="selNumber.status_rma == 'Confirm' || selNumber.status_rma == 'Cancelled'">
                                        </td>
                                        <td>{{ itemIdx+1 }}</td>
                                        <td>{{ item.item_code }}</td>
                                        <td>{{ item.item_description }}</td>
                                        <td>{{ item.order_quantity }}</td>
                                        <td>{{ item.uom }}</td>
                                        <td>
                                            <vue-numeric
                                                class="form-control"
                                                separator=","
                                                v-model="item.rma_quantity_cbb"
                                                :disabled="!enaRow[itemIdx]"
                                                style="text-align: right"
                                                @change="rmaQuantityCi(itemIdx)"
                                            ></vue-numeric>
                                        </td>
                                        <td>
                                            <vue-numeric
                                                class="form-control"
                                                separator=","
                                                v-model="item.rma_quantity_carton"
                                                :disabled="!enaRow[itemIdx]"
                                                style="text-align: right"
                                                @change="rmaQuantityCi(itemIdx)"
                                            ></vue-numeric>
                                        </td>
                                        <td>
                                            <vue-numeric
                                                class="form-control"
                                                separator=","
                                                v-model="item.rma_quantity_pack"
                                                :disabled="!enaRow[itemIdx]"
                                                style="text-align: right"
                                                @change="rmaQuantityCi(itemIdx)"
                                            ></vue-numeric>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody v-else>
                                    <tr>
                                        <td colspan="9" style="text-align: center">ไม่พบข้อมูล</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else class="table-responsive">
                                <table class="table table-bordered text-center table-hover f13">
                                    <thead>
                                    <tr class="align-middle">
                                        <th rowspan="2">เลือก</th>
                                        <th rowspan="2">รายการที่</th>
                                        <th rowspan="2">รหัสผลิตภัณฑ์</th>
                                        <th rowspan="2">ชื่อผลิตภัณฑ์</th>
                                        <th colspan="2">จำนวนที่ซื้อ</th>
                                        <th colspan="2">จำนวนที่ขอคืน</th>
                                    </tr>
                                    <tr class="align-middle">
                                        <!--จำนวนที่ซื้อ-->
                                        <th class="w-80">จำนวน</th>
                                        <th class="w-80">หน่วยนับ</th>

                                        <!--จำนวนที่คืน-->
                                        <th class="w-80" style="width:140px">จำนวน</th>
                                        <th class="w-80" style="width: 220px;">หน่วยนับ</th>
                                        <!-- <th class="w-120">จำนวน</th> -->
                                    </tr>
                                    </thead>
                                    <tbody v-if="orderLines.length">
                                    <tr v-for="(item,itemIdx) in orderLines" :key="itemIdx">
                                        <td>
                                            <input type="checkbox" v-model="enaRow[itemIdx]" :disabled="selNumber.status_rma == 'Confirm' || selNumber.status_rma == 'Cancelled'">
                                        </td>
                                        <td>{{ itemIdx+1 }}</td>
                                        <td>{{ item.item_code }}</td>
                                        <td>{{ item.item_description }}</td>
                                        <td>{{ item.order_quantity }}</td>
                                        <td>{{ item.uom }}</td>
                                        <td>
                                            <vue-numeric
                                                class="form-control"
                                                separator=","
                                                v-model="item.enter_rma_quantity"
                                                :disabled="!enaRow[itemIdx]"
                                                style="text-align: right"
                                                :precision="2"
                                                @change="rmaQuantity(itemIdx)"
                                            ></vue-numeric>
                                        </td>
                                        <td>
                                            <el-select
                                                v-model="item.enter_rma_uom"
                                                filterable
                                                :disabled="!enaRow[itemIdx]"
                                                placeholder="กรุณาเลือกหน่วยนับ"
                                                @change="rmaQuantity(itemIdx)"
                                            >
                                                <el-option v-for="ulist in filterUomList"
                                                           :key="ulist.uom_code"
                                                           :label="ulist.unit_of_measure"
                                                           :value="ulist.uom_code">
                                                </el-option>
                                            </el-select>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody v-else>
                                    <tr>
                                        <td colspan="9" style="text-align: center">ไม่พบข้อมูล</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--table-responsive-->
                        </div>
                        <!--col-xl-12-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import InputGroupRepetition from "../../qm/InputGroupRepetition";

export default {
    name: "Index",
    components: {InputGroupRepetition},
    props: ["numbers", "invoices", "customers", "url","uomlist"],

    data() {
        return {
            orderLines:[],
            claimLines: [],
            result:[],
            filterNumber: this.numbers,
            filterInvoice: this.invoices,
            filterCustomer: this.customers,
            filterUomList: this.uomlist,
            loading: {
                data: false
            },
            selNumber: [],
            numberSelected:'',
            dsaNumber: false,
            selInvoice: [],
            invoiceSelected:'',
            dsaInvoice: false,
            selCustomer: [],
            customerSelected:'',
            dsaCustomer: false,
            firstSearch: true,
            enaSearch: true,
            enaRow: [],
            curRmaQty: [],
            prvRmaQty: [],
            rmaQtyMessage:[],
            enaConfirmRma: true,
            procAdding: false,
            isCigaratte: false,
            isNewRma: false,
            curRma: '',
            kilometers : 0,
            meters:0,
            cgc:0,
            cg2:0,
            cgp:0,
            cgk:0
        };
    },

    mounted() {
        console.log("Rma export mounted...");
    },

    methods: {
        onClearSearch() {
            location.reload();
        },

        onAdd() {
            let vm = this;
            vm.dsaNumber = true;
            vm.selNumber.rma_date = moment().format("DD/MM/YYYY");
            vm.selNumber.status_rma = 'Draft';
            vm.procAdding = true;
        },

        onSearch() {
            let vm = this;
            if (vm.selInvoice.product_type_code == '10'){
                vm.isCigaratte = true;
            }
            Swal.fire({
                 title: 'กรุณารอสักครู่',
            });
            Swal.showLoading();
            axios.get(vm.url.ajax_get_lines, {
                params: {
                    claim_header_id: vm.selNumber.claim_header_id,
                },
            })
            .then((respons) => {
                vm.orderLines = respons.data.lines
                Swal.close();
            })
            .catch((error) => {
                // Error 😨
                Swal.close();
                if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                } else if (error.request) {
                    console.log(error.request);
                } else {
                    console.log('Error', error.message);
                }
                console.log(error.config);
            });
        },

        async onNumberChange() {
            let vm = this;
            let nIdx = await vm.filterNumber.findIndex(o => o.rma_number == vm.numberSelected );
            vm.selNumber = vm.filterNumber[nIdx];
            vm.selNumber.rma_date = moment(vm.selNumber.rma_date)
                // .add(543, "years")
                .format("DD/MM/YYYY");
            if (vm.firstSearch) {
                vm.firstSearch = false;
                const cIdx = await vm.filterCustomer.findIndex(o => o.customer_id == vm.selNumber.customer_id);
                vm.selCustomer = vm.filterCustomer[cIdx];
                vm.customerSelected = vm.selCustomer.customer_number;
                const iIdx = await vm.filterInvoice.findIndex(o => o.pi_header_id == vm.selNumber.invoice_id);
                vm.selInvoice = vm.filterInvoice[iIdx];
                vm.selInvoice.pick_release_approve_date = moment(vm.selInvoice.pick_release_approve_date)
                    // .add(543, "years")
                    .format("DD/MM/YYYY");
                vm.invoiceSelected = vm.selInvoice.pick_release_no;
                vm.dsaNumber = true;
                vm.dsaCustomer = true;
                vm.dsaInvoice = true;
            } else {
                if (vm.invoiceSelected == ''){
                    const iIdx = await vm.filterInvoice.findIndex(o => o.pi_header_id == vm.selNumber.invoice_id);
                    vm.selInvoice = vm.filterInvoice[iIdx];
                    vm.selInvoice.pick_release_approve_date = moment(vm.selInvoice.pick_release_approve_date)
                        //.add(543, "years")
                        .format("DD/MM/YYYY");
                    vm.invoiceSelected = vm.selInvoice.pick_release_no;
                }
                vm.dsaNumber = true;
                vm.dsaInvoice = true;
            }
        },

        async onInvoiceChange() {
            let vm = this;
            if(vm.procAdding){
                // Process adding true

                // Filter customer & invoice
                const iIdx = await vm.filterInvoice.findIndex(o => o.pick_release_no == vm.invoiceSelected);
                vm.selInvoice = vm.filterInvoice[iIdx];
                vm.selInvoice.pick_release_approve_date = moment(vm.selInvoice.pick_release_approve_date)
                    //.add(543, "years")
                    .format("DD/MM/YYYY");
                vm.dsaInvoice = true;
                const cIdx = await vm.filterCustomer.findIndex(o => o.customer_id == vm.selInvoice.customer_id);
                vm.selCustomer = vm.filterCustomer[cIdx];
                vm.customerSelected = vm.selCustomer.customer_number;
                vm.dsaCustomer = true;

                //Query lines
                if (vm.selInvoice.product_type_code == '10'){
                    vm.isCigaratte = true;
                }
                Swal.fire({
                    title: 'กรุณารอสักครู่',
                });
                Swal.showLoading();
                await axios.get(vm.url.ajax_get_invoice_lines, {
                    params: {
                        pi_header_id: vm.selInvoice.pi_header_id,
                    },
                })
                .then((respons) => {
                    vm.orderLines = respons.data.lines
                    Swal.close()
                })
                .catch((error) => {
                    // Error 😨
                    Swal.close();
                    if (error.response) {
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                    console.log(error.config);
                });
            } else if (vm.firstSearch) {
                // firstSearch = true
                vm.firstSearch = false;

                // Filter customer & invoice

                const iIdx = await vm.filterInvoice.findIndex(o => o.pick_release_no == vm.invoiceSelected);
                vm.selInvoice = vm.filterInvoice[iIdx];
                vm.selInvoice.pick_release_approve_date = moment(vm.selInvoice.pick_release_approve_date)
                    //.add(543, "years")
                    .format("DD/MM/YYYY");
                vm.dsaInvoice = true;
                const cIdx = await vm.filterCustomer.findIndex(o => o.customer_id == vm.selInvoice.customer_id);
                vm.selCustomer = vm.filterCustomer[cIdx];
                vm.customerSelected = vm.selCustomer.customer_number;
                vm.dsaCustomer = true;

                // Query rma_number related to invoice
                vm.filterNumber = [];
                Swal.fire({
                    title: 'กรุณารอสักครู่',
                });
                Swal.showLoading();
                await axios.get(vm.url.ajax_get_by_invoice, {
                    params: {
                        pick_release_no: vm.invoiceSelected
                    },
                })
                    .then((respons) => {
                        vm.filterNumber = respons.data.numbers;
                        vm.selCustomer = respons.data.customer;
                        Swal.close();
                    })
                    .catch((error) => {
                        // Error 😨
                        Swal.close();
                        if (error.response) {
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error, ajax_get_by_invoice', error.message);
                        }
                        console.log(error.config);
                    });
            } else {
                // Process adding = false & firstSearch = false

                // Filter invoice
                const iIdx = await vm.filterInvoice.findIndex(o => o.pick_release_no == vm.invoiceSelected);
                vm.selInvoice = vm.filterInvoice[iIdx];
                vm.selInvoice.pick_release_approve_date = moment(vm.selInvoice.pick_release_approve_date)
                    //.add(543, "years")
                    .format("DD/MM/YYYY");
                vm.dsaInvoice = true;
            }
        },

        async onCustomerChange() {
            let vm = this;
            if (vm.procAdding){
                // Adding process true
                // vm.procAdding = false;
                const idx = await vm.filterCustomer.findIndex(o => o.customer_number == vm.customerSelected);
                vm.selCustomer = vm.filterCustomer[idx];
                vm.filterInvoice = [];
                Swal.fire({
                    title: 'กรุณารอสักครู่',
                });
                Swal.showLoading();
                await axios.get(vm.url.ajax_get_by_customer, {
                    params: {
                        customer_id: vm.selCustomer.customer_id,
                    },
                })
                .then((respons) => {
                    vm.filterInvoice = respons.data.invoices;
                    Swal.close();
                })
                .catch((error) => {
                    // Error 😨
                    Swal.close();
                    if (error.response) {
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                    console.log(error.config);
                });
            } else {
                vm.firstSearch = false;
                const idx = await vm.filterCustomer.findIndex(o => o.customer_number == vm.customerSelected);
                vm.selCustomer = vm.filterCustomer[idx];
                vm.filterNumber = [];
                vm.filterInvoice = [];
                Swal.fire({
                    title: 'กรุณารอสักครู่',
                });
                Swal.showLoading();
                await axios.get(vm.url.ajax_get_by_customer, {
                    params: {
                            customer_id: vm.selCustomer.customer_id,
                        },
                    })
                    .then((respons) => {
                        vm.filterNumber = respons.data.numbers;
                        vm.filterInvoice = respons.data.invoices;
                        Swal.close();
                    })
                    .catch((error) => {
                        // Error 😨
                        Swal.close();
                        if (error.response) {
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                        console.log(error.config);
                    });
            }
            vm.dsaCustomer = true;
        },

        onSave() {
            let vm = this;
            if (vm.selNumber.status_rma != "Draft") {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถบันทึกได้',
                    text: 'เนื่องสถานะไม่ใช่ Draft !',
                    footer: 'สถานะ : ' + vm.selNumber.status_rma
                });
            } else {
                if (vm.orderLines.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ไม่สามารถบันทึกข้อมูล',
                        text: 'เนื่องจากไม่มีรายการผลิตภัณฑ์ !'
                    });
                } else {
                    Swal.fire({
                        title: 'กำลังบันทึกข้อมูล',
                    });
                    Swal.showLoading();
                    if (vm.orderLines.length) {
                        let lineNo = 0;
                        for (let i = 0; i < vm.orderLines.length; i++) {
                            if (vm.enaRow[i] == true) {
                                lineNo += 1;
                                vm.claimLines.push({
                                    claim_line_id: vm.orderLines[i]['claim_line_id'],
                                    item_id: vm.orderLines[i]['item_id'],
                                    item_code: vm.orderLines[i]['item_code'],
                                    item_description: vm.orderLines[i]['item_description'],
                                    order_quantity: vm.orderLines[i]['approve_quantity'],
                                    order_line_id: vm.orderLines[i]['pi_line_id'],
                                    uom_code: vm.orderLines[i]['uom_code'],
                                    unit_price: vm.orderLines[i]['unit_price'],
                                    rma_quantity: vm.orderLines[i]['rma_quantity'] == null ? null : vm.orderLines[i]['rma_quantity'],
                                    rma_uom_code: vm.orderLines[i]['uom_code'],
                                    rma_quantity_cbb: vm.orderLines[i]['rma_quantity_cbb'] == null ? null : vm.orderLines[i]['rma_quantity_cbb'],
                                    rma_quantity_carton: vm.orderLines[i]['rma_quantity_carton'] == null ? null : vm.orderLines[i]['rma_quantity_carton'],
                                    rma_quantity_pack: vm.orderLines[i]['rma_quantity_pack'] == null ? null : vm.orderLines[i]['rma_quantity_pack'],
                                    enter_rma_quantity: vm.orderLines[i]['enter_rma_quantity'] == null ? null : vm.orderLines[i]['enter_rma_quantity'],
                                    enter_rma_uom: vm.orderLines[i]['enter_rma_uom'] == null ? null : vm.orderLines[i]['enter_rma_uom'],
                                    rma_line_no: lineNo,
                                })
                            }
                        }
                    }
                    if (vm.procAdding) {
                        axios.patch(vm.url.ajax_create_rma, {
                            invoice: vm.selInvoice,
                            lines: vm.claimLines,
                            rma_date: vm.selNumber.rma_date,
                            status_rma: vm.selNumber.status_rma,
                            symptom_description: vm.selNumber.symptom_description
                        })
                            .then(async response => {
                                if (response.data.result['status'] == "S") {
                                    let lastHeader = response.data.latestHeader;
                                    await axios.get(vm.url.ajax_get_new_number) // Get new rma number list after create new one
                                        .then((response) => {
                                            vm.filterNumber = response.data.newNumbers;
                                        })
                                        .catch((error) => {
                                            // Error 😨
                                            Swal.close();
                                            if (error.response) {
                                                console.log(error.response.data);
                                                console.log(error.response.status);
                                                console.log(error.response.headers);
                                            } else if (error.request) {
                                                console.log(error.request);
                                            } else {
                                                console.log('Error ajax_get_new_number', error.message);
                                            }
                                            console.log(error.config);
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'เกิดข้อผิดพลาด!',
                                                footer: error.message
                                            });
                                        });
                                    vm.selNumber = lastHeader;
                                    vm.numberSelected = response.data.result['doc_sequence_number'];
                                    vm.selNumber.rma_date = moment(vm.selNumber.rma_date).format("DD/MM/YYYY");
                                    vm.procAdding = false;
                                    const iIdx = await vm.filterInvoice.findIndex(o => o.pi_header_id == vm.selNumber.invoice_id);
                                    vm.selInvoice = vm.filterInvoice[iIdx];
                                    vm.selNumber.province_name = vm.selInvoice.province_name;
                                    await axios.get(vm.url.ajax_get_lines, {
                                        params: {
                                            claim_header_id: vm.selNumber.claim_header_id,
                                        },
                                    })
                                        .then((respons) => {
                                            vm.orderLines = respons.data.lines
                                            vm.prvRmaQty = respons.data.prvRmaQuantity
                                        })
                                        .catch((error) => {
                                            // Error 😨
                                            Swal.close();
                                            if (error.response) {
                                                console.log(error.response.data);
                                                console.log(error.response.status);
                                                console.log(error.response.headers);
                                            } else if (error.request) {
                                                console.log(error.request);
                                            } else {
                                                console.log('Error, ajax_get_lines', error.message);
                                            }
                                            console.log(error.config);
                                        });
                                        swal.close();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'บันทึกข้อมูลสำเร็จ',
                                            footer: response.data.result['message']
                                        });
                                } else {
                                    swal.close();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'บันทึกข้อมูลไม่สำเร็จ!',
                                        footer: response.data.result['message']
                                    });
                                }
                                vm.procAdding = false;
                                vm.enaRow = [];
                            })
                            .catch((error) => {
                                // Error 😨
                                Swal.close();
                                if (error.response) {
                                    console.log(error.response.data);
                                    console.log(error.response.status);
                                    console.log(error.response.headers);
                                } else if (error.request) {
                                    console.log(error.request);
                                } else {
                                    console.log('Error', error.message);
                                }
                                console.log(error.config);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'เกิดข้อผิดพลาด!',
                                    footer: error.message
                                });
                            });
                    } else {
                        axios.patch(vm.url.ajax_update_rma, {
                            claim_header_id: vm.selNumber.claim_header_id,
                            symptom_description: vm.selNumber.symptom_description,
                            claim_lines: vm.claimLines
                        })
                            .then((response) => {
                                swal.close();
                                if (response.data.result['status'] == "S") {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'บันทึกข้อมูลสำเร็จ',
                                        footer: response.data.result['message']
                                    });
                                    // location.reload();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'บันทึกข้อมูลไม่สำเร็จ!',
                                        footer: response.data.result['message']
                                    });
                                }
                            })
                            .catch((error) => {
                                // Error 😨
                                Swal.close();
                                if (error.response) {
                                    console.log(error.response.data);
                                    console.log(error.response.status);
                                    console.log(error.response.headers);
                                } else if (error.request) {
                                    console.log(error.request);
                                } else {
                                    console.log('Error', error.message);
                                }
                                console.log(error.config);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error,ajax_update_rma: ',
                                    text: 'เกิดข้อผิดพลาด!',
                                    footer: error.message
                                });
                            });
                        vm.enaRow = [];
                    }
                }
            }
        },

        onConfirm() {
            let vm = this;
            let previousRma = []
            let errorRma = []
            // Check rma quantity
            if (vm.selNumber.status_rma != "Draft"){
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถยืนยันได้',
                    text: 'เนื่องสถานะไม่ใช่ Draft !',
                    footer: 'สถานะ : ' + vm.selNumber.status_rma
                });
            } else {
                if (vm.orderLines.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ไม่สามารถบันทึกข้อมูล',
                        text: 'เนื่องจากไม่มีรายการผลิตภัณฑ์ !'
                    });
                } else {
                    Swal.fire({
                        title: 'ต้องการยืนยันการคืนสินค้าหรือไม่',
                        text: "โดยหากกดปุ่มยืนยันแล้วระบบจะส่งข้อมูลให้ WMS ทำการคืนของเข้าระบบ และออกใบลดหนี้",
                        icon: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก'
                    }).then(async result => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'กรุณารอสักครู่',
                            });
                            Swal.showLoading();
                            await axios.get(vm.url.ajax_get_previous_rma,{ // Check previous rma quantity
                                params: {
                                    invoiceNo: vm.selInvoice.pick_release_no,
                                },
                            })
                                .then((respons) => {
                                    vm.previousRma = respons.data.previousRma
                                    // console.clear()
                                    // console.log('orderLines =>')
                                    // console.log(vm.orderLines)
                                    // console.log('previousRma =>')
                                    // console.log(vm.previousRma)
                                    // console.log('isCigaratte => ' + vm.isCigaratte)
                                    // Swal.close()
                                })
                                .catch((error) => {
                                    // Error 😨
                                    Swal.close();
                                    if (error.response) {
                                        console.log(error.response.data);
                                        console.log(error.response.status);
                                        console.log(error.response.headers);
                                    } else if (error.request) {
                                        console.log(error.request);
                                    } else {
                                        console.log('Error ajax_get_previous_rma', error.message);
                                    }
                                    console.log(error.config);
                                });
                            if (vm.previousRma.length){
                                let errMessage = '';
                                let overOccured = false;
                                for (let i = 0; i < vm.orderLines.length; i++) {
                                    for (let j = 0; j < vm.previousRma.length; j++) {
                                        if (vm.previousRma[j]['line_number'] == vm.orderLines[i]['line_number']) {
                                            console.log('item_code =>' + vm.previousRma[j]['item_code'] + ' previousRma =>' + vm.previousRma[j]['prvRmaQty'])
                                            console.log('canReturn => ' + vm.previousRma[j]['canReturn'] + ' returnRequest =>' + vm.orderLines[i]['rma_quantity'])
                                            if (vm.orderLines[i]['rma_quantity'] > vm.previousRma[j]['canReturn'] || vm.orderLines[i]['rma_quantity'] < 0) { // check over rma or not related uom code
                                                overOccured = true
                                                errMessage += vm.orderLines[i]['item_code'] + '/' + vm.orderLines[i]['item_description'] + ', '
                                            }
                                        }
                                    }
                                }
                                if (overOccured == true){
                                    Swal.close()
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'ไม่สามารถยืนยันได้',
                                        text: 'เนื่องจากขอคืนเกินจำนวนหรือเลือกหน่วยนับไม่ถูกต้อง',
                                        footer: 'กรุณาตรวจสอบรหัสผลิตภัณฑ์ : ' + errMessage,
                                    });
                                    overOccured = false
                                    return
                                }
                                console.log('Continue rma process...')
                                // Swal.fire({
                                //     title: 'กรุณารอสักครู่',
                                // });
                                // Swal.showLoading();
                                if (vm.procAdding) {
                                    console.log('Start create rma number ...');
                                    if (vm.orderLines.length) {
                                        let lineNo = 0;
                                        for (let i = 0; i < vm.orderLines.length; i++) { // Data for claim_lines
                                            if (vm.enaRow[i] == true){
                                                lineNo += 1;
                                                vm.claimLines.push({
                                                    // claim_line_id: vm.orderLines[i]['claim_line_id'],
                                                    item_id: vm.orderLines[i]['item_id'],
                                                    item_code: vm.orderLines[i]['item_code'],
                                                    item_description: vm.orderLines[i]['item_description'],
                                                    order_quantity: vm.orderLines[i]['approve_quantity'],
                                                    order_line_id: vm.orderLines[i]['pi_line_id'],
                                                    uom_code: vm.orderLines[i]['uom_code'],
                                                    unit_price: vm.orderLines[i]['unit_price'],
                                                    rma_quantity: vm.orderLines[i]['rma_quantity'] == null ? null : vm.orderLines[i]['rma_quantity'],
                                                    rma_uom_code: vm.orderLines[i]['uom_code'],
                                                    rma_quantity_cbb: vm.orderLines[i]['rma_quantity_cbb'] == null ? null : vm.orderLines[i]['rma_quantity_cbb'],
                                                    rma_quantity_carton: vm.orderLines[i]['rma_quantity_carton'] == null ? null : vm.orderLines[i]['rma_quantity_carton'],
                                                    rma_quantity_pack: vm.orderLines[i]['rma_quantity_pack'] == null ? null : vm.orderLines[i]['rma_quantity_pack'],
                                                    enter_rma_quantity: vm.orderLines[i]['enter_rma_quantity'] == null ? null : vm.orderLines[i]['enter_rma_quantity'],
                                                    enter_rma_uom: vm.orderLines[i]['enter_rma_uom'] == null ? null : vm.orderLines[i]['enter_rma_uom'],
                                                    rma_line_no: lineNo,
                                                })
                                            }
                                        }
                                    }
                                    // console.log('orderLines')
                                    // console.log(vm.orderLines)
                                    // console.log('claimLines')
                                    // console.log(vm.claimLines)
                                    // console.log('selInvoice')
                                    // console.log(vm.selInvoice)
                                    // console.log('rma_date:' + vm.selNumber.rma_date)
                                    // console.log('status_rma:'  + vm.selNumber.status_rma)
                                    await axios.patch(vm.url.ajax_create_rma, {
                                        invoice: vm.selInvoice,
                                        lines: vm.claimLines,
                                        rma_date: vm.selNumber.rma_date,
                                        status_rma: vm.selNumber.status_rma,
                                        symptom_description: vm.selNumber.symptom_description
                                    })
                                        .then(async response => {
                                            let lastHeader = response.data.latestHeader;
                                            await axios.get(vm.url.ajax_get_new_number) // Get new rma number list after create new one
                                                .then((response) => {
                                                    vm.filterNumber = response.data.newNumbers;
                                                })
                                                .catch((error) => {
                                                    // Error 😨
                                                    Swal.close();
                                                    if (error.response) {
                                                        console.log(error.response.data);
                                                        console.log(error.response.status);
                                                        console.log(error.response.headers);
                                                    } else if (error.request) {
                                                        console.log(error.request);
                                                    } else {
                                                        console.log('Error ajax_get_new_number', error.message);
                                                    }
                                                    console.log(error.config);
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'เกิดข้อผิดพลาด!',
                                                        footer: error.message
                                                    });
                                                });
                                            vm.selNumber = lastHeader;
                                            vm.numberSelected = response.data.result['doc_sequence_number'];
                                            vm.selNumber.rma_date = moment(vm.selNumber.rma_date).format("DD/MM/YYYY");
                                            console.log('Create rma success ...');
                                        })
                                        .catch((error) => {
                                            // Error 😨
                                            Swal.close();
                                            if (error.response) {
                                                console.log(error.response.data);
                                                console.log(error.response.status);
                                                console.log(error.response.headers);
                                            } else if (error.request) {
                                                console.log(error.request);
                                            } else {
                                                console.log('Error', error.message);
                                            }
                                            console.log(error.config);
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'เกิดข้อผิดพลาด!',
                                                footer: error.message
                                            });
                                        });

                                    vm.procAdding = false;
                                    const iIdx = await vm.filterInvoice.findIndex(o => o.pi_header_id == vm.selNumber.invoice_id);
                                    vm.selInvoice = vm.filterInvoice[iIdx];
                                    vm.selNumber.province_name = vm.selInvoice.province_name;
                                    console.log('claim_header_id :' + vm.selNumber.claim_header_id)
                                    await axios.get(vm.url.ajax_get_lines, { //Get new claim_lines rows
                                        params: {
                                            claim_header_id: vm.selNumber.claim_header_id,
                                        },
                                    })
                                        .then((respons) => {
                                            vm.orderLines = respons.data.lines;
                                        })
                                        .catch((error) => {
                                            // Error 😨
                                            Swal.close();
                                            if (error.response) {
                                                console.log(error.response.data);
                                                console.log(error.response.status);
                                                console.log(error.response.headers);
                                            } else if (error.request) {
                                                console.log(error.request);
                                            } else {
                                                console.log('Error', error.message);
                                            }
                                            console.log(error.config);
                                        });
                                }
                                console.log('Start confirm rma...');
                                // console.log('claimHeader :')
                                // console.log(vm.selNumber)
                                // console.log('claimLines :')
                                // console.log(vm.orderLines)
                                // console.log('orderHeader :')
                                // console.log(vm.selInvoice)
                                let params = {
                                    claimHeader: vm.selNumber,
                                    claimLines: vm.orderLines,
                                    orderHeader: vm.selInvoice
                                }
                                await axios.patch(vm.url.ajax_confirm_rma, params)
                                .then((response) => {
                                    if (response.data.result['status'] == "S") {
                                        vm.selNumber.status_rma = 'Confirm'
                                        vm.selNumber.credit_note_number = response.data.result['cnNumber']
                                        console.log(vm.selNumber.status_rma)
                                        console.log(vm.selNumber.credit_note_number)
                                        vm.procAdding = false;
                                        vm.enaRow = [];
                                        swal.close();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: 'บันทึกข้อมูลสำเร็จ',
                                            footer: response.data.result['message']
                                        });
                                        // location.reload();
                                    } else {
                                        swal.close();
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'บันทึกข้อมูลไม่สำเร็จ!',
                                            footer: response.data.result['message']
                                        });
                                    }
                                })
                                .catch((error) => {
                                    // Error 😨
                                    Swal.close();
                                    if (error.response) {
                                        console.log(error.response.data);
                                        console.log(error.response.status);
                                        console.log(error.response.headers);
                                    } else if (error.request) {
                                        console.log(error.request);
                                    } else {
                                        console.log('Error', error.message);
                                    }
                                    console.log(error.config);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'เกิดข้อผิดพลาด!',
                                        footer: error.message
                                    });
                                });
                            }
                        }
                    });
                }
            }
        },

        onCancel() {
            let vm = this;
            if (vm.selNumber.status_rma == 'Cancelled'){
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถยกเลิกได้',
                    text: 'เนื่องสถานะไม่ใช่ Confirm หรือ Draft !',
                    footer: 'สถานะ : ' + vm.selNumber.status_rma
                });
            } else {
                Swal.fire({
                    title: 'โปรดระบุเหตุผลที่ต้องการยกเลิก',
                    input: 'textarea',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก',
                    preConfirm: (reason) => {
                        if (reason.length == 0 || reason == null){
                            console.log('Text box is empty.')
                            Swal.fire({
                                icon: 'error',
                                title: 'ไม่สามารถยกเลิกได้',
                                text: 'เนื่องจากไม่ระบุเหตุผล!'
                            });
                            return
                        }
                        Swal.fire({
                            title: 'กรุณารอสักครู่',
                        });
                        Swal.showLoading();
                        axios.get(vm.url.ajax_cancel_rma, {
                            params: {
                                rma_number: vm.selNumber.rma_number,
                                cn_number: vm.selNumber.credit_note_number == null? 'null':vm.selNumber.credit_note_number,
                                rma_status: vm.selNumber.status_rma,
                                pick_release_no: vm.selInvoice.pick_release_no,
                                rma_cancel_reason: reason
                            },
                        })
                        .then(response => {
                            Swal.close();
                            console.log(response.data.result);
                            if (response.data.result['status'] == "S") {
                                vm.selNumber.status_rma = 'Cancelled'
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ยกเลิกสำเร็จ',
                                    footer: response.data.result['message']
                                });
                                // location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ยกเลิกไม่สำเร็จ!',
                                    footer: response.data.result['message']
                                });
                            }
                        })
                        .catch((error) => {
                            // Error 😨
                            Swal.close();
                            if (error.response) {
                                console.log(error.response.data);
                                console.log(error.response.status);
                                console.log(error.response.headers);
                            } else if (error.request) {
                                console.log(error.request);
                            } else {
                                console.log('Error, ajax_cancel_rma', error.message);
                            }
                            console.log(error.config);
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                footer: error.message
                            });
                        });
                    }
                });
            }
        },

        onTest() {
            Swal.fire({
                icon: 'success',
                title: 'Hello',
                text: 'This is test',
            });
            let vm = this;
            if (vm.selInvoice.product_type_code == '10'){
                vm.isCigaratte = true;
            }
            Swal.fire({
                title: 'กรุณารอสักครู่',
            });
            Swal.showLoading();
            axios.get(vm.url.ajax_get_lines, {
                params: {
                    claim_header_id: vm.selNumber.claim_header_id,
                },
            })
            .then((respons) => {
                vm.orderLines = respons.data.lines;
                console.log('return from ajax_get_line');
                console.log(vm.orderLines);
                Swal.close();
            })
            .catch((error) => {
                // Error 😨
                Swal.close();
                if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                } else if (error.request) {
                    console.log(error.request);
                } else {
                    console.log('Error', error.message);
                }
                console.log(error.config);
            });
        },

        onTest1(){
            let vm = this
            Swal.fire({
                title: 'Please wait ...',
            })
            Swal.showLoading()
            axios.get(vm.url.ajax_get_new_number)
                .then(response => {
                    console.log(response.data.newNumbers)
                    Swal.close();
                })
                .catch((error) => {
                    // Error 😨
                    Swal.close();
                    if (error.response) {
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error ajax_get_new_number ', error.message);
                    }
                    console.log(error.config);
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        footer: error.message
                    });
                });
        },

        sumCgkO(idx){
            let totalOrder = 0;
            let cgc = 0;
            let cg2 = 0;
            cgc = this.orderLines[idx].cgc_cgk * this.orderLines[idx].approve_cardboardbox;
            cg2 = this.orderLines[idx].cg2_cgk * this.orderLines[idx].approve_carton;
            totalOrder = cgc + cg2;

            return totalOrder;
        },

        sumCgkR(idx){
            let totalCgk = 0;
            let prvRma = 0;
            let cgc = 0;
            let cg2 = 0;
            let cgp = 0;
            // console.log('cgc_cgk :  ' + this.orderLines[idx].cgc_cgk + 'rma_quantity_cbb  :  ' + this.orderLines[idx].rma_quantity_cbb);
            // console.log('cg2_cgk  :  ' + this.orderLines[idx].cg2_cgk + 'rma_quantity_carton  :  ' + this.orderLines[idx].rma_quantity_carton);
            if (typeof (this.orderLines[idx].rma_quantity_cbb) == "undefined"){
                cgc = 0;
            } else {
                cgc = this.orderLines[idx].cgc_cgk * this.orderLines[idx].rma_quantity_cbb;
            }

            if (typeof (this.orderLines[idx].rma_quantity_carton) == "undefined") {
                cg2 = 0;
            } else {
                cg2 = this.orderLines[idx].cg2_cgk * this.orderLines[idx].rma_quantity_carton;
            }

            if (typeof (this.orderLines[idx].rma_quantity_pack) == "undefined") {
                cgp = 0;
            } else {
                cgp = this.orderLines[idx].cgp_cgk * this.orderLines[idx].rma_quantity_pack;
            }

            totalCgk = cgc + cg2 + cgp;
            this.orderLines[idx].rma_quantity = totalCgk;
            this.curRmaQty[idx] = totalCgk;
            if (typeof (this.prvRmaQty[idx]) == "undefined"){
                prvRma = 0;
            } else {
                prvRma = this.prvRmaQty[idx];
            }

            // console.log('totalCgk :  ' + totalCgk + '  =>  ' + this.orderLines[idx].rma_quantity);
            // console.log('idx : ', idx);
            console.log(idx + '  Item : ' + '=>' +  prvRma + '/' + totalCgk);
            return totalCgk;
        },

        async rmaQuantity(idx){ //Calculate rma_quantity for non cigaratte
            // switch (this.orderLines[idx].enter_rma_uom) {
            //     case 'CG': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].cg
            //         break;
            //     case 'CG2': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].cg2
            //         break;
            //     case 'CGC': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].cgc
            //         break;
            //     case 'CGK': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].cgk
            //         break;
            //     case 'CGP': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].cgp
            //         break;
            //     case 'CL1': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].cl1
            //         break;
            //     case 'CS1': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].cs1
            //         break;
            //     case 'E00': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].e00
            //         break;
            //     case 'KG': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].kg
            //         break;
            //     case 'CS2': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].cs2
            //         break;
            //     case 'E18': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].e18
            //         break;
            //     case 'CA2': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].ca2
            //         break;
            //     case 'CA3': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].ca3
            //         break;
            //     case 'CA4': this.orderLines[idx].rma_quantity = this.orderLines[idx].enter_rma_quantity * this.orderLines[idx].ca4
            //         break;
            //     default: this.orderLines[idx].rma_quantity = 0

            await axios.get(this.url.ajax_convert_unit,{
                params:{
                    orgId: this.selInvoice.org_id
                    ,itemId: this.orderLines[idx].item_id
                    ,qty: this.orderLines[idx].enter_rma_quantity
                    ,fromUnit: this.orderLines[idx].enter_rma_uom
                    ,toUnit: this.orderLines[idx].uom_code
                },
            })
                .then(response =>{
                    this.orderLines[idx].rma_quantity = response.data.convertResult
                })
                .catch((error) => {
                    // Error 😨
                    Swal.close();
                    if (error.response) {
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error, ajax_convert_unit', error.message);
                    }
                    console.log(error.config);
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        footer: error.message
                    });
                });

            console.log('orgId : ' + this.selInvoice.org_id)
            console.log('itemId : ' + this.orderLines[idx].item_id)
            console.log('qty : ' + this.orderLines[idx].enter_rma_quantity)
            console.log('fromUnit :' + this.orderLines[idx].enter_rma_uom)
            console.log('toUnit :'+ this.orderLines[idx].uom_code)
            console.log('result :' + this.orderLines[idx].rma_quantity)
        },

        async rmaQuantityCi(idx){
            let totalCgk = 0
            let cgc = 0
            let cg2 = 0
            let cgp = 0
            if (typeof (this.orderLines[idx].rma_quantity_cbb) == "undefined"){
                cgc = 0
            } else {
                // cgc = this.orderLines[idx].cgc * this.orderLines[idx].rma_quantity_cbb
                await axios.get(this.url.ajax_convert_unit,{
                    params:{
                        orgId: this.selInvoice.org_id
                        ,itemId: this.orderLines[idx].item_id
                        ,qty: this.orderLines[idx].rma_quantity_cbb
                        ,fromUnit: 'CGC'
                        ,toUnit: this.orderLines[idx].uom_code
                    },
                })
                    .then(response =>{
                        cgc = response.data.convertResult
                        console.log('orgId : ' + this.selInvoice.org_id)
                        console.log('itemId : ' + this.orderLines[idx].item_id)
                        console.log('qty : ' + this.orderLines[idx].enter_rma_quantity)
                        console.log('fromUnit :' + 'CGC')
                        console.log('toUnit :'+ this.orderLines[idx].uom_code)
                        console.log('result :' + cgc)
                    })
                    .catch((error) => {
                        // Error 😨
                        Swal.close();
                        if (error.response) {
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error, ajax_convert_unit', error.message);
                        }
                        console.log(error.config);
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            footer: error.message
                        });
                    });
            }

            if (typeof (this.orderLines[idx].rma_quantity_carton) == "undefined") {
                cg2 = 0
            } else {
                // cg2 = this.orderLines[idx].cg2 * this.orderLines[idx].rma_quantity_carton
                await axios.get(this.url.ajax_convert_unit,{
                    params:{
                        orgId: this.selInvoice.org_id
                        ,itemId: this.orderLines[idx].item_id
                        ,qty: this.orderLines[idx].rma_quantity_carton
                        ,fromUnit: 'CG2'
                        ,toUnit: this.orderLines[idx].uom_code
                    },
                })
                    .then(response =>{
                        cg2 = response.data.convertResult
                        console.log('orgId : ' + this.selInvoice.org_id)
                        console.log('itemId : ' + this.orderLines[idx].item_id)
                        console.log('qty : ' + this.orderLines[idx].enter_rma_quantity)
                        console.log('fromUnit :' + 'CG2')
                        console.log('toUnit :'+ this.orderLines[idx].uom_code)
                        console.log('result :' + cg2)
                    })
                    .catch((error) => {
                        // Error 😨
                        Swal.close();
                        if (error.response) {
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error, ajax_convert_unit', error.message);
                        }
                        console.log(error.config);
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            footer: error.message
                        });
                    });
            }

            if (typeof (this.orderLines[idx].rma_quantity_pack) == "undefined") {
                cgp = 0
            } else {
                // cgp = this.orderLines[idx].cgp * this.orderLines[idx].rma_quantity_pack
                await axios.get(this.url.ajax_convert_unit,{
                    params:{
                        orgId: this.selInvoice.org_id
                        ,itemId: this.orderLines[idx].item_id
                        ,qty: this.orderLines[idx].rma_quantity_pack
                        ,fromUnit: 'CGP'
                        ,toUnit: this.orderLines[idx].uom_code
                    },
                })
                    .then(response =>{
                        cgp = response.data.convertResult
                        console.log('orgId : ' + this.selInvoice.org_id)
                        console.log('itemId : ' + this.orderLines[idx].item_id)
                        console.log('qty : ' + this.orderLines[idx].enter_rma_quantity)
                        console.log('fromUnit :' + 'CGP')
                        console.log('toUnit :'+ this.orderLines[idx].uom_code)
                        console.log('result :' + cgp)
                    })
                    .catch((error) => {
                        // Error 😨
                        Swal.close();
                        if (error.response) {
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error, ajax_convert_unit', error.message);
                        }
                        console.log(error.config);
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            footer: error.message
                        });
                    });
            }
            totalCgk = parseFloat(cgc) + parseFloat(cg2) + parseFloat(cgp)
            this.orderLines[idx].rma_quantity = parseFloat(totalCgk)
            console.log('itemIdx => ' + idx)
            console.log('rma_quantity_cbb => ' + this.orderLines[idx].rma_quantity_cbb)
            console.log('rma_quantity_carton => ' + this.orderLines[idx].rma_quantity_carton)
            console.log('rma_quantity_pack => ' + this.orderLines[idx].rma_quantity_pack)
            console.log('rma_quantity => ' + this.orderLines[idx].rma_quantity)
        },
    },

    computed:{
        // totalRmaQuantity() {
        //     let vm = this;
        //     let totalCgk = 0;
        //     let cgc = 0;
        //     let cg2 = 0;
        //     let cgp = 0;
        //     if (vm.orderLines.length){
        //         for (let i = 0; i < vm.orderLines.length; i++) {
        //             cgc = vm.orderLines[i]['cgc_cgk'] * vm.orderLines['rma_quantity_cbb'];
        //             cg2 = vm.orderLines[i]['cg2_cgk'] * vm.orderLines['rma_quantity_carton'];
        //             cgp = vm.orderLines[i]['cgp_cgk'] * vm.orderLines['rma_quantity_pack'];
        //         }
        //     }
        // },
    },

    watch : {
        kilometers:function(val) {
            this.kilometers = val;
            this.meters = val * 1000;
        },
        meters : function (val) {
            this.kilometers = val/ 1000;
            this.meters = val;
        },
        cgc: function (val){
            this.cgc = val;
            this.cg2 = val * 50;
            this.cgp = val * 500;
            this.cgk = val * 10;
        },
        cg2: function (val){
            this.cg2 = val;
            this.cgc = val * 0.02;
            this.cgp = val * 10;
            this.cgk = val * 0.2;
        },
        cgp: function (val){
            this.cgp = val;
            this.cgc = val * 0.002;
            this.cg2 = val * 0.1;
            this.cgk = val * 0.02;
        },
        cgk: function (val){
            this.cgk = val;
            // this.cgc = val * 0.01;
            // this.cg2 = val * 5;
            // this.cgp = val * 50;
        },
    }
};
</script>

<style scoped>
</style>
