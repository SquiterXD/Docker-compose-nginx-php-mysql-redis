<template>
    <div v-loading="loading">
        <div class="row mb-3">
            <div class="col-md-12 text-right">
                <button typ="button" class="btn btn-sm btn-warning" @click="reset">
                    รีเซ็ต
                </button>
                <button type="button" class="btn btn-sm btn-default" :disabled="state === 'create'" @click="setRMAData">
                    <i class="fa fa-search"></i> ค้นหา
                </button>
                <button type="button" class="btn btn-sm btn-success" @click="setCreate">
                    สร้าง
                </button>
                <button type="button" class="btn btn-sm btn-primary" :disabled="state === 'search'" @click="confirm">
                    ยืนยันการรับสินค้า
                </button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <el-form :model="form">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="">เลขที่ใบ RMA / เลขที่ใบเคลม <span class="text-danger">*</span></label>
                            <el-select v-if="state === 'create'"
                                class="w-100" 
                                v-model="form.rma_number"
                                :remote-method="getRMAList"
                                :loading="loadingRMAFetch"
                                remote
                                clearable
                                filterable
                                placeholder=""
                                @change="setRMAData()">
                                <el-option
                                    v-for="item in RMAList"
                                    :key="item.key"
                                    :label="item.label"
                                    :value="item.value">
                                    {{ item.show }}
                                </el-option>
                            </el-select>
                            <el-select v-else
                                class="w-100" 
                                v-model="form.rma_number"
                                :remote-method="getRMAList"
                                :loading="loadingRMAFetch"
                                remote
                                clearable
                                filterable
                                placeholder="">
                                <el-option
                                    v-for="item in RMAList"
                                    :key="item.key"
                                    :label="item.label"
                                    :value="item.value">
                                    {{ item.show }}
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-md-3">
                            <label for="">วันที่ใบ RMA / วันที่เคลม</label>
                            <el-input class="w-100" v-model="form.rma_date" disabled>
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
                            <label for="">เลขที่ Invoice</label>
                            <el-input class="w-100" v-model="form.invoice_number" disabled>
                            </el-input>
                        </div>
                        <div class="col-md-3">
                            <label for="">วันที่ Invoice</label>
                            <el-input class="w-100" v-model="form.invoice_date" disabled>
                            </el-input>
                        </div>
                        <div class="col-md-3">
                            <label for="">เลขที่ใบลดหนี้</label>
                            <el-input class="w-100" v-model="form.cn_number" disabled>
                            </el-input>
                        </div>
                        <div class="col-md-3">
                            <label for="">วันที่ใบลดหนี้</label>
                            <el-input class="w-100" v-model="form.cn_date" disabled>
                            </el-input>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="">RMA Order Type</label>
                            <el-input class="w-100" v-model="form.rma_order_type" disabled>
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
                    <div class="row mb-3">
                        <div class="col-md-3" v-if="state === 'create' && selectedRMA.rma_id && !selectedRMA.transaction_type">
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
                            <label for="">Transaction Type <span class="text-danger">*</span></label>
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
                                <th class="text-right">
                                    จำนวนที่รับคืน
                                </th>
                                <th class="text-center">
                                    หน่วยนับ
                                </th>
                                <th width="35%">
                                    ลงบัญชี <span class="text-danger">*</span>
                                </th>
                                <th width="125px"></th>
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
            <div class="modal-dialog">
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
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" @click="backToPickQty()">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 15px;">
                        <div class="row m-b-1">
                            <div class="col-md-6">
                                <label for="">
                                    <b>
                                        ผลิตภัณฑ์ : {{ '('+modalLotForm.item.item_code+') '+modalLotForm.item.item_description }}
                                    </b>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label for="">
                                    <b>
                                        จำนวนที่รับคืน {{ (modalLotForm.item.remain_quantity)+' '+(modalLotForm.item.uom_code+' : '+modalLotForm.item.uom) }}
                                    </b>
                                </label>
                            </div>
                            <div class="col-md-2 text-right" v-if="state === 'create'">
                                <button class="btn btn-xs btn-success mb-2" @click="createLot()">เพิ่ม</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" style="overflow: auto; max-height: 500px" >
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    Inventory Organization <br>
                                                    ที่ต้องการรับของ <span class="text-danger">*</span>
                                                </th>
                                                <th class="text-center">
                                                    Subinventory <br>
                                                    ที่ต้องการรับของ <span class="text-danger">*</span>
                                                </th>
                                                <th class="text-center">
                                                    Locator Segment1 <br>
                                                    ที่ต้องการรับของ <span class="text-danger">*</span>
                                                </th>
                                                <th class="text-center">
                                                    Locator Segment2 <br>
                                                    ที่ต้องการรับของ <span class="text-danger">*</span>
                                                </th>
                                                <th class="text-center">
                                                    Lot Number <span class="text-danger">*</span>
                                                </th>
                                                <th class="text-right">
                                                    จำนวนที่ต้องการรับของ <span class="text-danger">*</span>
                                                </th>
                                                <th v-if="state != 'search'">
                                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <modal-lot-line
                                                v-for="(item,index) in modalLotForm.tableLotData" 
                                                :key="index"
                                                :lotData="modalLotForm.tableLotData"
                                                :state="state"
                                                :remain="modalLotForm.item.remain_quantity"
                                                :item="item"
                                                :item-id="modalLotForm.item.item_id"
                                                :index="index"
                                                ref="lotLine"
                                                @remove-lot="removeLot(index)"
                                            >
                                            </modal-lot-line>
                                            <tr v-if="modalLotForm.tableLotData.length !== 0">
                                                <td class="text-right" colspan="5">
                                                    รวม
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="backToPickQty()">ยกเลิก</button>
                        <button type="button" class="btn btn-primary" @click="updateNeedQty()">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueNumeric from 'vue-numeric';
    import {toJSDate} from '../../../dateUtils';
    import ModalLotLine from './ModalLotLine.vue';
    export default {

        components: {
            VueNumeric,
            ModalLotLine,
        },

        props: [
            'segment',
            'transactionTypesAll',
        ],

        data() {
            return {
                toJSDate,
                loading: false,
                loadingModal: false,
                loadingFetch: false,
                loadingRMAFetch: false,
                state: 'search',
                form: {
                    rma_id: '',
                    rma_type: '',
                    rma_number: '',
                    rma_date: '',
                    customer: '',
                    sale_class: '',
                    invoice_number: '',
                    invoice_date: '',
                    cn_number: '',
                    cn_date: '',
                    class_sale_type: '',
                    rma_order_type: '',
                    ebs_number: '',
                    remark: '',
                    status: '',
                    transaction_type: '',
                    transaction_date: '',
                },
                selectedRMA: {},
                RMAList: [],
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
                }
            }
        },

        mounted() {
            this.getRMAList();
        },

        computed: {
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
                _this.form.rma_id = '';
                _this.form.rma_type = '';
                _this.form.rma_number = '';
                _this.form.rma_date = '';
                _this.form.customer = '';
                _this.form.sale_class = '';
                _this.form.invoice_number = '';
                _this.form.invoice_date = '';
                _this.form.cn_number = '';
                _this.form.cn_date = '';
                _this.form.class_sale_type = '';
                _this.form.rma_order_type = '';
                _this.form.ebs_number = '';
                _this.form.remark = '';
                _this.form.status = '';
                _this.form.transaction_type = '';
                _this.form.transaction_date = '';
                _this.RMAList = [];
                _this.tableLineData = [];
            },
            async reset(){
                let _this = this;
                _this.clear();
                _this.state = 'search';
                await _this.getRMAList();
            },
            async setCreate(){
                let _this = this;
                _this.clear();
                _this.state = 'create';
                await _this.getRMAList();
            },
            async getRMAList(query){
                let _this = this;
                _this.loadingRMAFetch = true;
                let params = {
                    'keyword': query == '' ? '' : query,
                    'state': _this.state,
                }
                axios.get('/om/product-return/get-rma-list', { params })
                .then(function(response){
                    _this.loadingRMAFetch = false;
                    _this.RMAList = response.data;
                }).catch(function(error){
                    // console.log(error);
                    _this.loadingRMAFetch = false;
                    _this.showError(error.message);
                }).then(() => {
                    // always executed
                });
            },
            async setRMAData(){
                let _this = this;
                let find = _this.RMAList.find((item)=>{
                    return item.value == _this.form.rma_number;
                });
                if (find) {
                    _this.selectedRMA = find;
                    _this.form.rma_id = find.rma_id;
                    _this.form.rma_type = find.rma_type;
                    _this.form.rma_date = find.invoice_date;
                    _this.form.customer = find.customer;
                    _this.form.sale_class = find.sale_class;
                    _this.form.invoice_number = find.invoice_number;
                    _this.form.invoice_date = find.invoice_date;
                    _this.form.cn_number = find.cn_number;
                    _this.form.cn_date = find.cn_date;
                    _this.form.transaction_type = find.transaction_type;
                    _this.form.class_sale_type = find.class_sale_type;
                    _this.form.rma_order_type = find.rma_order_type;
                    _this.form.ebs_number = find.ebs_number;
                    _this.form.transaction_date = find.transaction_date ? new Date(find.transaction_date) : '';
                    _this.form.remark = find.remark ? find.remark : '';
                    _this.form.status = _this.state === 'create' ? 'Draft' : (find.rma_type == 'receipt' ? find.status : 'Draft');
                    await _this.getRMALine();
                }
            },
            async getRMALine() {
                let _this = this;
                _this.loading = true;
                let params = {
                    'rma_id': _this.form.rma_id,
                    'rma_type': _this.form.rma_type,
                    'class_sale_type': _this.form.class_sale_type,
                }
                axios.get('/om/product-return/get-rma-lines', { params })
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
                await _this.setLots(item);
                await $("#lotModal").modal({backdrop: 'static', keyboard: false}).modal('show');
            },
            async createLot(){
                let _this = this;
                _this.modalLotForm.tableLotData.push({
                    'inv' : null,
                    'sub_inv' : null,
                    'locator_segment1' : null,
                    'locator_segment2' : null,
                    'lot_number' : null,
                    'pick_quantity' : 0,
                    'input_qty': 0,
                });
            },
            removeLot(index){
                let _this = this;
                _this.modalLotForm.tableLotData.splice(index, 1);
            },
            async setLots(item){
                let _this = this;
                _this.modalLotForm.item = item;
                _this.modalLotForm.tableLotData = item.lots.length ? item.lots : [];
            },
            async updateNeedQty(){
                let _this = this;

                let error_flag = _this.validateLineData();
                if(error_flag){
                    swal({
                        html: true,
                        title: 'แจ้งเตือน',
                        text: 'กรุณาระบุข้อมูลให้ครบถ้วน',
                        type: 'error',
                    });
                    return;
                }

                let qty = _this.modalLotForm.item.remain_quantity;
                if(_this.inputAmount < qty && !!_this.modalLotForm.tableLotData.length){
                    swal({
                        html: true,
                        title: "แจ้งเตือน",
                        text: "รวมจำนวนที่ต้องการรับของน้อยกว่าจำนวนที่รับคืน",
                        icon: "error",
                    });
                    return;
                }else {
                    _this.modalLotForm.tableLotData.forEach((item)=> {
                        item.pick_quantity = item.input_qty;
                    });
                    _this.modalLotForm.item.lots = _this.modalLotForm.tableLotData;
                    $("#lotModal").modal('hide');
                }
            },
            async backToPickQty(){
                let _this = this;
                _this.modalLotForm.tableLotData.forEach((item)=> {
                    item.input_qty = item.pick_quantity;
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
                let valid = {};
                let msg = '';
                let error_flag = false;
    
                valid = _this.validateData();

                if(valid.error_flag){
                    swal({
                        html: true,
                        title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
                        text: valid.msg,
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
                }else {
                    error_flag = line_data.some((item)=>{
                        return item.account_code == null 
                            || item.segment1 == null
                            || item.segment2 == null
                            || item.segment3 == null
                            || item.segment4 == null
                            || item.segment5 == null
                            || item.segment6 == null
                            || item.segment7 == null
                            || item.segment8 == null
                            || item.segment9 == null
                            || item.segment10 == null
                            || item.segment11 == null
                            || item.segment12 == null;
                    });

                    if(error_flag){
                        swal({
                            html: true,
                            title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
                            text: 'กรุณาระบุบัญชีให้ครบถ้วน',
                            type: 'error',
                        });
                        return false;
                    }
                }

                _this.loading = true;
                await _this.store(line_data);
            },
            validateData(){
                let _this = this;
                let msg = '';
                let error_flag = false;
    
                if(!_this.form.rma_number){
                    msg += 'กรุณาระบุเลขที่ Invoice / เลขที่ใบเคลม <br>';
                    error_flag = true;
                }

                if(!_this.form.transaction_date){
                    msg += 'กรุณาระบุ Transaction Date <br>';
                    error_flag = true;
                }

                if(_this.state === 'create' && _this.selectedRMA.rma_id && !_this.selectedRMA.transaction_type) {
                    if(!_this.form.transaction_type){
                        msg += 'กรุณาระบุ Transaction Type <br>';
                        error_flag = true;
                    }
                }

                return {
                    'msg': msg,
                    'error_flag': error_flag
                };
            },
            validateLineData(){
                let _this = this;
                
                let error_flag = _this.modalLotForm.tableLotData.some((item, index) => {
                    return item.inv == null 
                        || (item.sub_inv == null && !!_this.$refs.lotLine[index].subInvList.length)
                        || (item.locator_segment1 == null && !!_this.$refs.lotLine[index].locateSeg1List.length)
                        || (item.locator_segment2 == null && !!_this.$refs.lotLine[index].locateSeg2List.length)
                        || item.lot_number == null;
                });

                return error_flag;
            },
            async composeLineData(){
                let _this = this;

                let data = _this.tableLineData.filter((item) => {
                    return item.lots.some((onhand) => {
                        return onhand.pick_quantity != 0;
                    });
                });
                data.forEach((item)=>{
                    item.lots = item.lots.filter((onhand) => {
                        return onhand.pick_quantity != 0;
                    });
                });

                return data;
            },
            async store(line_data){
                let _this = this;
                let params = {
                    'rma_data': _this.form,
                    'line_data': line_data,
                }
                axios.post('/om/product-return', params)
                .then(async function(response){
                    if(response.data.status == 'S'){
                        // _this.group_id = response.data.group_id;
                        // let msg = 'group id : '+_this.group_id;
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
                axios.get('/om/product-return/get-account-list', { params })
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
