<template>
    <div v-loading="loading">
        <div class="row mb-3">
            <div class="col-md-12 text-right">
                <button typ="button" class="btn btn-sm btn-warning" @click="reset">
                    รีเซ็ต
                </button>
                <button type="button" class="btn btn-sm btn-default" :disabled="state === 'create'" @click="setInvoiceData">
                    <i class="fa fa-search"></i> ค้นหา
                </button>
                <button type="button" class="btn btn-sm btn-success" @click="setCreate">
                    สร้าง
                </button>
                <button type="button" class="btn btn-sm btn-primary" :disabled="state === 'search'" @click="confirm">
                    ยืนยันการตัด stock
                </button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <el-form :model="form">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="">เลขที่ Invoice / เลขที่ใบเคลม / เลขที่ RMA <span class="text-danger">*</span></label>
                            <el-select v-if="state === 'create'"
                                class="w-100" 
                                v-model="form.invoice_number"
                                :remote-method="getInvoiceList"
                                :loading="loadingInvoiceFetch"
                                remote
                                clearable
                                filterable
                                placeholder=""
                                @change="setInvoiceData()">
                                <el-option
                                    v-for="item in invoiceList"
                                    :key="item.key"
                                    :label="item.label"
                                    :value="item.value">
                                    {{ item.show }}
                                </el-option>
                            </el-select>
                            <el-select v-else
                                class="w-100" 
                                v-model="form.invoice_number"
                                :remote-method="getInvoiceList"
                                :loading="loadingInvoiceFetch"
                                remote
                                clearable
                                filterable
                                placeholder="">
                                <el-option
                                    v-for="item in invoiceList"
                                    :key="item.key"
                                    :label="item.label"
                                    :value="item.value">
                                    {{ item.show }}
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-md-3">
                            <label for="">วันที่ Invoice / วันที่เคลม / วันที่ RMA </label>
                            <el-input class="w-100" v-model="form.invoice_date" disabled>
                            </el-input>
                        </div>
                        <div class="col-md-3">
                            <label for="">ลูกค้า</label>
                            <el-input class="w-100" v-model="form.customer" disabled>
                            </el-input>
                        </div>
                        <div class="col-md-3">
                            <label for="">ประเภทการขาย</label>
                            <el-input class="w-100" v-model="form.sale_class" disabled>
                            </el-input>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="">เลขที่ PI/ใบเตรียมขาย</label>
                            <el-input class="w-100" v-model="form.sale_number" disabled>
                            </el-input>
                        </div>
                        <div class="col-md-3">
                            <label for="">วันที่ส่ง</label>
                            <el-input class="w-100" v-model="form.ship_date" disabled>
                            </el-input>
                        </div>
                        <div class="col-md-3" v-if="state === 'create' && selectedInvoice.invoice_id">
                            <label for="">Transaction Type <span class="text-danger">*</span></label>
                            <el-select
                                class="w-100" 
                                v-model="form.transaction_type"
                                remote
                                clearable
                                filterable
                                placeholder="">
                                <el-option
                                    v-for="item in transactionTypesAll"
                                    :key="item.transaction_type_id"
                                    :label="item.transaction_type_name+' ('+item.transaction_type_id+')'"
                                    :value="item.transaction_type_id">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-md-3" v-else>
                            <label for="">Transaction Type</label>
                            <el-input class="w-100" v-model="form.transaction_type" disabled>
                            </el-input>
                        </div>
                        <div class="col-md-3">
                            <label for="">Transaction Date <span class="text-danger">*</span></label>
                            <ct-datepicker 
                                style="width: 100%;"
                                class="el-input__inner"
                                :name="`transaction_date`"
                                placeholder=""
                                :value="form.transaction_date"
                                @change="getValueTransactionDate"
                                :disabled="state == 'search'"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="">Order Type</label>
                            <el-input class="w-100" v-model="form.order_type" disabled>
                            </el-input>
                        </div>
                        <div class="col-md-3">
                            <label for="">EBS Order Number</label>
                            <el-input class="w-100" v-model="form.ebs_number" disabled>
                            </el-input>
                        </div>
                        <div class="col-md-3">
                            <label for="">หมายเหตุ</label>
                            <el-input class="w-100" v-model="form.remark" maxlength="255"
                                :disabled="state == 'search'">
                            </el-input>
                        </div>
                        <div class="col-md-3">
                            <label for="">สถานะ</label>
                            <el-input class="w-100" v-model="form.status" disabled>
                            </el-input>
                        </div>
                    </div>
                
                    
                </el-form>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="overflow: auto; max-height: 500px" >
                        <thead>
                            <tr>
                                <th>
                                    รหัสผลิตภัณฑ์
                                </th>
                                <th>
                                    ชื่อผลิตภัณฑ์
                                </th>
                                <th>
                                    จำนวนที่สั่งซื้อ / ขอเคลม
                                </th>
                                <th class="text-center">
                                    หน่วยนับ
                                </th>
                                <th>
                                    ลงบัญชี <span class="text-danger">*</span>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item,index) in tableLineData" :key="index">
                                <td>
                                    {{ item.item_code }}
                                </td>
                                <td>
                                    {{ item.item_description }}
                                </td>
                                <td class="text-right">
                                    {{ numberWithCommas(item.remain_quantity) }}
                                </td>
                                <td class="text-center">
                                    {{ item.uom_code+' : '+item.uom }}
                                </td>
                                <td>
                                    {{ item.account_code }}
                                </td>
                                <td class="text-right">
                                    <button type="button" class="btn btn-sm btn-default" @click="showAccountMadal(index)"><i class="fa fa-search"></i></button>
                                    <button type="button" class="btn btn-sm btn-secondary" @click="showLotMadal(index)">เลือก Lot</button>
                                </td>
                            </tr>
                            <tr v-if="tableLineData.length === 0">
                                <td colspan="99" class="text-center">
                                    ไม่มีข้อมูล
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Lot -->
        <div class="modal inmodal fade" id="accountModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="padding-top: 0px">
                <div class="modal-content" v-loading="loadingModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" @click="resetAccountForm()">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4>กรุณาเลือกบัญชี</h4>
                    </div>
                    <div class="modal-body" style="padding: 20px;">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Company Code
                            </div>
                            <div class="col-md-8">
                                <el-select 
                                    v-model="modalAccountForm.segment1" 
                                    class="w-100"
                                    filterable
                                    :disabled="state == 'search'"
                                    :popper-append-to-body="false">
                                    <el-option v-for="(item, index) in modalAccountForm.segment1Lists" 
                                        :key="index"
                                        :label="item.meaning+' : '+item.description"
                                        :value="item.meaning">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                EVM
                            </div>
                            <div class="col-md-8">
                                <el-select 
                                    v-model="modalAccountForm.segment2" 
                                    class="w-100"
                                    filterable 
                                    :disabled="state == 'search'"
                                    :popper-append-to-body="false">
                                    <el-option v-for="(item, index) in modalAccountForm.segment2Lists" 
                                        :key="index"
                                        :label="item.meaning+' : '+item.description"
                                        :value="item.meaning">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Department Code
                            </div>
                            <div class="col-md-8">
                                <el-select 
                                    v-model="modalAccountForm.segment3" 
                                    class="w-100"
                                    filterable 
                                    :disabled="state == 'search'"
                                    :popper-append-to-body="false"
                                    @change="setAccountList">
                                    <el-option v-for="(item, index) in modalAccountForm.segment3Lists" 
                                        :key="index"
                                        :label="item.meaning+' : '+item.description"
                                        :value="item.meaning">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Cost Center
                            </div>
                            <div class="col-md-8">
                                <el-select 
                                    v-model="modalAccountForm.segment4" 
                                    class="w-100"
                                    filterable 
                                    :disabled="state == 'search'"
                                    :popper-append-to-body="false">
                                    <el-option v-for="(item, index) in modalAccountForm.segment4Lists" 
                                        :key="index"
                                        :label="item.meaning+' : '+item.description"
                                        :value="item.meaning">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Budget Year
                            </div>
                            <div class="col-md-8">
                                <el-select 
                                    v-model="modalAccountForm.segment5" 
                                    class="w-100"
                                    filterable 
                                    :disabled="state == 'search'"
                                    :popper-append-to-body="false">
                                    <el-option v-for="(item, index) in modalAccountForm.segment5Lists" 
                                        :key="index"
                                        :label="item.meaning+' : '+item.description"
                                        :value="item.meaning">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Budget Type
                            </div>
                            <div class="col-md-8">
                                <el-select 
                                    v-model="modalAccountForm.segment6" 
                                    class="w-100"
                                    filterable 
                                    :disabled="state == 'search'"
                                    :popper-append-to-body="false"
                                    @change="setAccountList">
                                    <el-option v-for="(item, index) in modalAccountForm.segment6Lists" 
                                        :key="index"
                                        :label="item.meaning+' : '+item.description"
                                        :value="item.meaning">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Budget Detail
                            </div>
                            <div class="col-md-8">
                                <el-select 
                                    v-model="modalAccountForm.segment7" 
                                    class="w-100"
                                    filterable 
                                    :disabled="state == 'search'"
                                    :popper-append-to-body="false">
                                    <el-option v-for="(item, index) in modalAccountForm.segment7Lists" 
                                        :key="index"
                                        :label="item.meaning+' : '+item.description"
                                        :value="item.meaning">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Budget Reason
                            </div>
                            <div class="col-md-8">
                                <el-select 
                                    v-model="modalAccountForm.segment8" 
                                    class="w-100"
                                    filterable 
                                    :disabled="state == 'search'"
                                    :popper-append-to-body="false">
                                    <el-option v-for="(item, index) in modalAccountForm.segment8Lists" 
                                        :key="index"
                                        :label="item.meaning+' : '+item.description"
                                        :value="item.meaning">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Main Account
                            </div>
                            <div class="col-md-8">
                                <el-select 
                                    v-model="modalAccountForm.segment9" 
                                    class="w-100"
                                    filterable 
                                    :disabled="state == 'search'"
                                    :popper-append-to-body="false"
                                    @change="setAccountList">
                                    <el-option v-for="(item, index) in modalAccountForm.segment9Lists" 
                                        :key="index"
                                        :label="item.meaning+' : '+item.description"
                                        :value="item.meaning">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Sub Account
                            </div>
                            <div class="col-md-8">
                                <el-select 
                                    v-model="modalAccountForm.segment10" 
                                    class="w-100"
                                    filterable 
                                    :disabled="state == 'search'"
                                    :popper-append-to-body="false">
                                    <el-option v-for="(item, index) in modalAccountForm.segment10Lists" 
                                        :key="index"
                                        :label="item.meaning+' : '+item.description"
                                        :value="item.meaning">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Reserved1
                            </div>
                            <div class="col-md-8">
                                <el-select 
                                    v-model="modalAccountForm.segment11" 
                                    class="w-100"
                                    filterable 
                                    :disabled="state == 'search'"
                                    :popper-append-to-body="false">
                                    <el-option v-for="(item, index) in modalAccountForm.segment11Lists" 
                                        :key="index"
                                        :label="item.meaning+' : '+item.description"
                                        :value="item.meaning">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Reserved2
                            </div>
                            <div class="col-md-8">
                                <el-select 
                                    v-model="modalAccountForm.segment12" 
                                    class="w-100"
                                    filterable 
                                    :disabled="state == 'search'"
                                    :popper-append-to-body="false">
                                    <el-option v-for="(item, index) in modalAccountForm.segment12Lists" 
                                        :key="index"
                                        :label="item.meaning+' : '+item.description"
                                        :value="item.meaning">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" v-if="state != 'search'">
                        <button type="button" class="btn btn-danger" @click="resetAccountForm()" data-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="updateAccount(modalAccountForm.index)">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Account Combine -->
        <div class="modal inmodal fade" id="lotModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" style="padding-top: 0px">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" @click="backToNeedQty()">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 15px;">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">
                                    <b>
                                        ผลิตภัณฑ์ : {{ '('+modalLotForm.item.item_code+') '+modalLotForm.item.item_description }}
                                    </b>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label for="">
                                    <b>
                                        จำนวนที่สั่งซื้อ {{ (modalLotForm.item.remain_quantity)+' '+(modalLotForm.item.uom_code+' : '+modalLotForm.item.uom) }}
                                    </b>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" style="overflow: auto; max-height: 500px" >
                                        <thead>
                                            <tr>
                                                <th>
                                                    Inventory Organization
                                                </th>
                                                <th>
                                                    Subinventory
                                                </th>
                                                <th>
                                                    Locator
                                                </th>
                                                <th>
                                                    Lot Number
                                                </th>
                                                <th class="text-right">
                                                    จำนวน Onhand ที่มี
                                                </th>
                                                <th class="text-right">
                                                    จำนวนที่ต้องการ
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,index) in modalLotForm.tableLotData" :key="index">
                                                <td>
                                                    {{ (item.organization_code || item.inv_org_code)+' : '+(item.organization_name || item. inv_org_name) }}
                                                </td>
                                                <td>
                                                    {{ item.subinventory_code }} : {{ item.subinventory_name }}
                                                </td>
                                                <td >
                                                    {{ item.locator }} : {{ item.locator_name }}
                                                </td>
                                                <td>
                                                    {{ item.lot_number }}
                                                </td>
                                                <td class="text-right">
                                                    {{ numberWithCommas(item.convert_qty) }}
                                                </td>
                                                <td v-if="state != 'search' && form.invoice_type == 'rma'">
                                                    <vue-numeric read-only-class="el-input__inner text-right" 
                                                        class="el-input__inner w-100 text-right" separator="," 
                                                        :precision="2"
                                                        v-model="item.input_qty">
                                                    </vue-numeric>
                                                </td>
                                                <td v-else-if="state != 'search'">
                                                    <vue-numeric read-only-class="el-input__inner text-right" 
                                                        class="el-input__inner w-100 text-right" separator="," 
                                                        :precision="2" :max="parseFloat(item.convert_qty)"
                                                        v-model="item.input_qty">
                                                    </vue-numeric>
                                                </td>
                                                <td class="text-right" v-else>
                                                    {{ numberWithCommas(item.input_qty) }}
                                                </td>
                                            </tr>
                                            <tr v-if="modalLotForm.tableLotData.length !== 0">
                                                <td class="text-right" colspan="4">
                                                    รวม
                                                </td>
                                                <td class="text-right">
                                                    {{ numberWithCommas(onhandAmount) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ numberWithCommas(inputAmount) }}
                                                </td>
                                            </tr>
                                            <tr v-if="modalLotForm.tableLotData.length === 0">
                                                <td colspan="99" class="text-center">
                                                    ไม่มีข้อมูล
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" v-if="state != 'search'">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="backToNeedQty()">ยกเลิก</button>
                        <button type="button" class="btn btn-primary" @click="updateNeedQty()">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueNumeric from 'vue-numeric';
    import {toJSDate} from '../../dateUtils';
    export default {

        components: {
            VueNumeric,
        },

        props: [
            'segment',
            'transactionTypesAll'
        ],

        data() {
            return {
                toJSDate,
                loading: false,
                loadingModal: false,
                loadingFetch: false,
                loadingInvoiceFetch: false,
                state: 'search',
                form: {
                    invoice_id: '',
                    invoice_type: '',
                    invoice_number: '',
                    invoice_date: '',
                    customer: '',
                    sale_class: '',
                    sale_number: '',
                    ship_date: '',
                    transaction_type: '',
                    transaction_date: '',
                    class_sale_type: '',
                    order_type: '',
                    ebs_number: '',
                    remark: '',
                    status: '',
                },
                selectedInvoice: {},
                invoiceList: [],
                tableLineData: [],
                modalAccountForm: {
                    index: '',
                    segment1Lists: [],
                    segment1: '',
                    segment2Lists: [],
                    segment2: '',
                    segment3Lists: [],
                    segment3: '',
                    segment4Lists: [],
                    segment4: '',
                    segment5Lists: [],
                    segment5: '',
                    segment6Lists: [],
                    segment6: '',
                    segment7Lists: [],
                    segment7: '',
                    segment8Lists: [],
                    segment8: '',
                    segment9Lists: [],
                    segment9: '',
                    segment10Lists: [],
                    segment10: '',
                    segment11Lists: [],
                    segment11: '',
                    segment12Lists: [],
                    segment12: '',
                },
                modalLotForm: {
                    item: {},
                    tableLotData: [],
                },
                setData: false
            }
        },

        mounted() {
            this.getInvoiceList();
        },

        computed: {
            onhandAmount(){
                return this.modalLotForm.tableLotData.reduce((a, b) => {
                    return a + parseFloat(b.convert_qty);
                }, 0);
            },
            inputAmount(){
                return this.modalLotForm.tableLotData.reduce((a, b) => {
                    return a + parseFloat(b.input_qty);
                }, 0);
            },
            checkDisabled(){
                return this.state === 'search' && this.form.status.toUpperCase() == 'CONFIRM';
            },
        },

        methods: {
            async clear(){
                let _this = this;
                _this.form.invoice_id = '';
                _this.form.invoice_type = '';
                _this.form.invoice_number = '';
                _this.form.invoice_date = '';
                _this.form.customer = '';
                _this.form.sale_class = '';
                _this.form.sale_number = '';
                _this.form.ship_date = '';
                _this.form.transaction_type = '';
                _this.form.transaction_date = '';
                _this.form.class_sale_type = '';
                _this.form.order_type = '';
                _this.form.ebs_number = '';
                _this.form.remark = '';
                _this.form.status = '';
                _this.invoiceList = [];
                _this.tableLineData = [];
            },
            async reset(){
                let _this = this;
                _this.clear();
                _this.state = 'search';
                await _this.getInvoiceList();
            },
            async setCreate(){
                let _this = this;
                _this.clear();
                _this.state = 'create';
                await _this.getInvoiceList();
            },
            async getInvoiceList(query){
                let _this = this;
                _this.loadingInvoiceFetch = true;
                let params = {
                    'keyword': query == '' ? '' : query,
                    'state': _this.state,
                }
                axios.get('/om/cut-stock-inventory/get-invoice-list', { params })
                .then(function(response){
                    _this.loadingInvoiceFetch = false;
                    _this.invoiceList = response.data;
                }).catch(function(error){
                    // console.log(error);
                    _this.loadingInvoiceFetch = false;
                    _this.showError(error.message);
                }).then(() => {
                    // always executed
                    if(_this.setData){
                        _this.setData = false;
                        _this.setInvoiceData();
                    }
                });
            },
            async setInvoiceData(){
                let _this = this;
                let find = _this.invoiceList.find((item)=>{
                    return item.value == _this.form.invoice_number;
                });
                if (find) {
                    _this.selectedInvoice = find;
                    _this.form.invoice_id = find.invoice_id;
                    _this.form.invoice_type = find.invoice_type;
                    _this.form.invoice_date = find.invoice_date;
                    _this.form.customer = find.customer;
                    _this.form.sale_class = find.sale_class;
                    _this.form.sale_number = find.sale_number;
                    _this.form.ship_date = find.ship_date;
                    _this.form.transaction_type = find.transaction_type;
                    _this.form.class_sale_type = find.class_sale_type;
                    _this.form.order_type = find.order_type;
                    _this.form.ebs_number = find.ebs_number;
                    _this.form.transaction_date = find.transaction_date ? new Date(find.transaction_date) : '';
                    _this.form.remark = find.remark ? find.remark : '';
                    _this.form.status = _this.state === 'create' ? 'Draft' : (find.invoice_type == 'issue' ? find.status : 'Draft');
                    await _this.getInvoiceLine();
                }
            },
            async getInvoiceLine() {
                let _this = this;
                _this.loading = true;
                let params = {
                    'invoice_id': _this.form.invoice_id,
                    'invoice_type': _this.form.invoice_type,
                    'class_sale_type': _this.form.class_sale_type,
                }
                axios.get('/om/cut-stock-inventory/get-invoice-lines', { params })
                .then(function(response){
                    _this.loading = false;
                    _this.tableLineData = response.data;
                }).catch(function(error){
                    _this.loading = false;
                    _this.showError(error.message);
                }).then(() => {
                    // always executed
                });
            },
            async showAccountMadal(index){
                let _this = this;
                let item = _this.tableLineData[index];
                _this.modalAccountForm.index = index;
                _this.modalAccountForm.segment1 = item.segment1;
                _this.modalAccountForm.segment2 = item.segment2;
                _this.modalAccountForm.segment3 = item.segment3;
                _this.modalAccountForm.segment4 = item.segment4;
                _this.modalAccountForm.segment5 = item.segment5;
                _this.modalAccountForm.segment6 = item.segment6;
                _this.modalAccountForm.segment7 = item.segment7;
                _this.modalAccountForm.segment8 = item.segment8;
                _this.modalAccountForm.segment9 = item.segment9;
                _this.modalAccountForm.segment10 = item.segment10;
                _this.modalAccountForm.segment11 = item.segment11;
                _this.modalAccountForm.segment12 = item.segment12;
                await _this.setAccountList();
                await $("#accountModal").modal({backdrop: 'static', keyboard: false}).modal('show');
            },
            updateAccount(index){
                let _this = this;
                _this.tableLineData[index].segment1 = _this.modalAccountForm.segment1;
                _this.tableLineData[index].segment2 = _this.modalAccountForm.segment2;
                _this.tableLineData[index].segment3 = _this.modalAccountForm.segment3;
                _this.tableLineData[index].segment4 = _this.modalAccountForm.segment4;
                _this.tableLineData[index].segment5 = _this.modalAccountForm.segment5;
                _this.tableLineData[index].segment6 = _this.modalAccountForm.segment6;
                _this.tableLineData[index].segment7 = _this.modalAccountForm.segment7;
                _this.tableLineData[index].segment8 = _this.modalAccountForm.segment8;
                _this.tableLineData[index].segment9 = _this.modalAccountForm.segment9;
                _this.tableLineData[index].segment10 = _this.modalAccountForm.segment10;
                _this.tableLineData[index].segment11 = _this.modalAccountForm.segment11;
                _this.tableLineData[index].segment12 = _this.modalAccountForm.segment12;
                _this.tableLineData[index].account_code = _this.combineAccount();
                _this.resetAccountForm();
            },
            combineAccount(){
                let _this = this;
                return _this.modalAccountForm.segment1+'.'+_this.modalAccountForm.segment2+'.'+_this.modalAccountForm.segment3
                +'.'+_this.modalAccountForm.segment4+'.'+_this.modalAccountForm.segment5+'.'+_this.modalAccountForm.segment6
                +'.'+_this.modalAccountForm.segment7+'.'+_this.modalAccountForm.segment8+'.'+_this.modalAccountForm.segment9
                +'.'+_this.modalAccountForm.segment10+'.'+_this.modalAccountForm.segment11+'.'+_this.modalAccountForm.segment12;
            },
            async setAccountList(){
                let _this = this;
                _this.modalAccountForm.segment1Lists = _this.segment.company;
                _this.modalAccountForm.segment2Lists = _this.segment.evm;
                _this.modalAccountForm.segment3Lists = _this.segment.dept;
                // _this.modalAccountForm.segment4Lists = _this.segment.costCenter.filter((item) => {
                //     return item.department_code === _this.modalAccountForm.segment3;
                // });
                await _this.getAccountList(null, 4, null, _this.modalAccountForm.segment3);
                _this.modalAccountForm.segment5Lists = _this.segment.budgetYear;
                _this.modalAccountForm.segment6Lists = _this.segment.budgetType;
                // _this.modalAccountForm.segment7Lists = _this.segment.budgetDetail.filter((item) => {
                //     return item.budget_type === _this.modalAccountForm.segment6;
                // });
                await _this.getAccountList(null, 7, null, _this.modalAccountForm.segment6);
                _this.modalAccountForm.segment8Lists = _this.segment.budgetReason;
                _this.modalAccountForm.segment9Lists = _this.segment.mainAccount;
                // _this.modalAccountForm.segment10Lists = _this.segment.subAccount.filter((item) => {
                //     return item.main_account === _this.modalAccountForm.segment9;
                // });
                await _this.getAccountList(null, 10, null, _this.modalAccountForm.segment9);
                _this.modalAccountForm.segment11Lists = _this.segment.reserved1;
                _this.modalAccountForm.segment12Lists = _this.segment.reserved2;
            },
            async updateDefaultAccount(){
                let _this = this;
                let find4 = _this.modalAccountForm.segment4Lists.find((item) => {
                    return item.meaning == _this.modalAccountForm.segment4;
                });
                if(!find4){
                    if(_this.modalAccountForm.segment4Lists.length){
                    _this.modalAccountForm.segment4 = _this.modalAccountForm.segment4Lists[0].meaning;
                    }
                }
                let find7 = _this.modalAccountForm.segment7Lists.find((item) => {
                    return item.meaning == _this.modalAccountForm.segment7;
                });
                if(!find7){
                    if(_this.modalAccountForm.segment7Lists.length){
                        _this.modalAccountForm.segment7 = _this.modalAccountForm.segment7Lists[0].meaning;
                    }
                }
                let find10 = _this.modalAccountForm.segment10Lists.find((item) => {
                    return item.meaning == _this.modalAccountForm.segment10;
                });
                if(!find10){
                    if(_this.modalAccountForm.segment10Lists.length){
                        _this.modalAccountForm.segment10 = _this.modalAccountForm.segment10Lists[0].meaning;
                    }
                }
                _this.$forceUpdate();
            },
            async showLotMadal(index){
                let _this = this;
                let item = _this.tableLineData[index];
                await _this.setOnHands(item);
                await $("#lotModal").modal({backdrop: 'static', keyboard: false}).modal('show');
            },
            async setOnHands(item){
                let _this = this;
                _this.modalLotForm.item = item;
                _this.modalLotForm.tableLotData = item.data_on_hands;
            },
            async updateNeedQty(){
                let _this = this;
                let qty = _this.modalLotForm.item.approve_quantity ?? _this.modalLotForm.item.rma_quantity;
                if(_this.inputAmount > qty){
                    swal({
                        title: "แจ้งเตือน",
                        text: "รวมจำนวนที่ต้องการมากกว่าจำนวนสั่งซื้อ ต้องการบันทึกข้อมูลใช่หรือไม่?",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: 'ยกเลิก',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน'
                    },
                    async function(confirm) {
                        if (confirm) {
                            _this.modalLotForm.tableLotData.forEach((item)=> {
                                item.need_qty = item.input_qty;
                            });
                            $("#lotModal").modal('hide');
                        } 
                    });
                }else {
                    _this.modalLotForm.tableLotData.forEach((item)=> {
                        item.need_qty = item.input_qty;
                    });
                    $("#lotModal").modal('hide');
                }
            },
            async backToNeedQty(){
                let _this = this;
                _this.modalLotForm.tableLotData.forEach((item)=> {
                    item.input_qty = item.need_qty;
                });
            },
            showSuccess(msg){
                swal("Success!", msg, "success");
            },
            showError(msg){
                swal("Error!", msg, "error");
            },
            getValueTransactionDate(date){
                let _this = this;
                _this.form.transaction_date = date;
            },
            numberWithCommas(x) {
                return parseFloat(x).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            },
            async confirm(){
                let _this = this;
                let msg = '';
                let error_flag = false;
    
                if(!_this.form.invoice_number){
                    msg += 'กรุณาระบุเลขที่ Invoice / เลขที่ใบเคลม <br>';
                    error_flag = true;
                }

                if(!_this.form.transaction_date){
                    msg += 'กรุณาระบุ Transaction Date <br>';
                    error_flag = true;
                }

                if(_this.state === 'create' && _this.selectedInvoice.invoice_id && !_this.selectedInvoice.transaction_type) {
                    if(!_this.form.transaction_type){
                        msg += 'กรุณาระบุ Transaction Type <br>';
                        error_flag = true;
                    }
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

                let line_data = await _this.composeLineData();
                if(!line_data.length){
                    swal({
                        html: true,
                        title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
                        text: 'กรุณาระบุ Lot',
                        type: 'error',
                    });
                    return false;
                }

                _this.loading = true;
                await _this.store(line_data);
            },
            async composeLineData(){
                let _this = this;

                let data = _this.tableLineData.filter((item) => {
                    return item.data_on_hands.some((onhand) => {
                        return onhand.need_qty != 0;
                    });
                });
                data.forEach((item)=>{
                    item.data_on_hands = item.data_on_hands.filter((onhand) => {
                        return onhand.need_qty != 0;
                    });
                });

                return data;
            },
            async store(line_data){
                let _this = this;
                let params = {
                    'invoice_data': _this.form,
                    'line_data': line_data,
                }
                let invoice_no = _this.form.invoice_number;
                axios.post('/om/cut-stock-inventory', params)
                .then(async function(response){
                    if(response.data.status == 'S'){
                        // _this.group_id = response.data.group_id;
                        // let msg = 'group id : '+_this.group_id;
                        _this.state = 'search';
                        _this.setData = true;
                        await _this.clear();
                        _this.form.invoice_number = response.data.issue_header_id;
                        await _this.getInvoiceList(invoice_no);
                        await _this.showSuccess(response.data.msg);
                    }else {
                        await _this.showError(response.data.msg);
                    }
                }).catch(function(error){
                    // console.log(error);
                    _this.showError(error.message);
                }).then(() => {
                    // always executed
                    _this.loading = false;
                });
            },
            async getAccountList(query, segment, value, parent_value){
                let _this = this;
                let params = {
                    'keyword': query == '' ? '' : query,
                    'segment': segment,
                    'value': value,
                    'parent_value': parent_value,
                }
                axios.get('/om/cut-stock-inventory/get-account-list', { params })
                .then(function(response){
                    _this.setList(segment, response.data);
                }).catch(function(error){
                    // console.log(error);
                    _this.showError(error.message);
                }).then(() => {
                    // always execute
                    _this.updateDefaultAccount();
                });
                return ;
            },
            setList(segment, data){
                let _this = this;
                if(segment == 4){
                    _this.modalAccountForm.segment4Lists = data;
                }
                if(segment == 7){
                    _this.modalAccountForm.segment7Lists = data;
                }
                if(segment == 10){
                    _this.modalAccountForm.segment10Lists = data;
                }
            },
            resetAccountForm(){
                this.modalAccountForm = {
                    index: '',
                    segment1Lists: [],
                    segment1: '',
                    segment2Lists: [],
                    segment2: '',
                    segment3Lists: [],
                    segment3: '',
                    segment4Lists: [],
                    segment4: '',
                    segment5Lists: [],
                    segment5: '',
                    segment6Lists: [],
                    segment6: '',
                    segment7Lists: [],
                    segment7: '',
                    segment8Lists: [],
                    segment8: '',
                    segment9Lists: [],
                    segment9: '',
                    segment10Lists: [],
                    segment10: '',
                    segment11Lists: [],
                    segment11: '',
                    segment12Lists: [],
                    segment12: '',
                };
            },
        },
    }
</script>

<style scoped>
  th, td {
    padding: 0.25rem;
  }
  th {
    background: white;
    position: sticky;
    top: 0; /* Don't forget this, required for the stickiness */
  }
</style>
