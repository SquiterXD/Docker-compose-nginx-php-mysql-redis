<template>

    <div>

        <div class="ibox float-e-margins">
            <div class="ibox-content">

                <div class="row tw-mb-2">

                    <div class="col-12 text-right">

                        <button 
                            type="button"
                            :class="transBtn.search.class + ' btn-lg tw-w-40 mr-2'"
                            @click="$modal.show('modal-search-header')">
                            <i :class="transBtn.search.icon"></i> 
                            {{ transBtn.search.text }}
                        </button>

                        <button 
                            type="button"
                            :class="transBtn.create.class + ' btn-lg tw-w-25 mr-2'"
                            :disabled="!isAllowCreateNewTransfer(transferHeader)"
                            @click="onCreateNew" >
                            <i :class="transBtn.create.icon"></i>
                            {{ transBtn.create.text }}
                        </button>

                         <button 
                            type="button"
                            :class="transBtn.save.class + ' btn-lg tw-w-25 mr-2'"
                            :disabled="!isAllowUpdateTransfer(transferHeader)"
                            @click="onSave">
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>

                        <button
                            type="button"
                            class="btn btn-primary btn-lg tw-w-48 mr-2"
                            :disabled="!isAllowConfirmTransfer(transferHeader)"
                            @click="confirmRequest">
                            <i class="fa fa-check"></i> 
                            <strong> ยืนยันส่งสินค้าสำเร็จรูป </strong>
                        </button>

                        <button
                            type="button"
                            class="btn btn-w-m btn-danger btn-lg tw-w-48 mr-2"
                            :disabled="!isAllowDiscardTransfer(transferHeader)"
                            @click="discardConfirmedRequest">
                            <i class="fa fa-times"></i> ยกเลิกส่งสินค้าสำเร็จรูป
                        </button>

                        <button
                            type="button"
                            class="btn btn-w-m btn-danger btn-lg tw-w-32"
                            :disabled="!isAllowCancelTransfer(transferHeader)"
                            @click="cancelRequest">
                            <i class="fa fa-times"></i> ยกเลิกใบส่ง
                        </button>

                    </div>

                </div>

            </div>

            <div class="ibox-content">
                
                <div class="row">

                    <div class="col-lg-6 b-r">

                        <div class="form-group row">

                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-2">ใบส่งเลขที่: </label>
                            
                            <div class="col-lg-7">

                                <input id="lb-2" type="text" class="form-control" name="transfer_number"
                                   :value="transferNumber"
                                   :disabled="true"
                                   />

                            </div>
                            
                        </div>

                        <div class="form-group row">

                            <label class="col-lg-4 font-weight-bold col-form-label text-right">วันที่ส่งผลผลิต: </label>

                            <div class="col-lg-7">

                                <div v-if="isAllowUpdateTransfer(transferHeader)"> 

                                    <datepicker-th
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="transfer_date"
                                        id="input_transfer_date"
                                        placeholder="โปรดเลือกวันที่"
                                        format="DD/MM/YYYY"
                                        :value="transferDate"
                                        :disabled="!isAllowUpdateTransfer(transferHeader)"
                                        @dateWasSelected="onTransferDateWasSelected"
                                    />

                                </div>
                                <div v-else> 
                                    <input id="lb-2" type="text" class="form-control" name="transfer_date"
                                        :value="transferDateFormatted"
                                        :disabled="true"
                                    />
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="form-group row">

                            <label class="col-lg-5 font-weight-bold col-form-label text-right"> สถานะส่งสินค้าสำเร็จรูป : </label>
                            
                            <div class="col-lg-6">

                                <input type="text" readonly disabled
                                    :value="getTransferStatusDesc(transferHeader)"
                                    class="form-control">

                            </div>
                        </div>

                        <!-- <div v-show="false" class="form-group row"> -->
                        <div class="form-group row">

                            <label class="col-lg-5 font-weight-bold col-form-label text-right"> Transaction Objective : </label>
                            
                            <div class="col-lg-6">

                                <div v-if="isAllowUpdateTransfer(transferHeader)"> 
                                    <pm-el-select name="transfer_objective" id="transfer_objective" 
                                        :select-options="transferObjectives"
                                        option-key="lookup_code"
                                        option-value="lookup_code" 
                                        option-label="description"
                                        :value="transferObjective"
                                        :filterable="true"
                                        :disabled="!isAllowUpdateTransfer(transferHeader)"
                                        @onSelected="onTransObjectiveWasChanged"
                                    />
                                </div>
                                <div v-else> 
                                    <input id="lb-2" type="text" class="form-control" name="transfer_objective"
                                        :value="transferObjective"
                                        :disabled="true"
                                    />
                                </div>

                            </div>

                        </div>

                        <div class="form-group row">

                            <label class="col-lg-5 font-weight-bold col-form-label text-right required"> สถานที่จัดเก็บปลายทาง : </label>
                            
                            <div class="col-lg-6">

                                <div v-if="isAllowUpdateTransfer(transferHeader)"> 
                                    <pm-el-select name="to_locator_id" id="input_to_locator_id" 
                                        :select-options="inputToLocators"
                                        option-key="locator_id"
                                        option-value="locator_id" 
                                        option-label="locator_full_desc"
                                        :value="toLocatorId"
                                        :filterable="true"
                                        @onSelected="onToLocatorWasChanged"
                                    />
                                </div>
                                <div v-else> 
                                    <input id="lb-2" type="text" class="form-control" name="locator_id"
                                        :value="toLocatorDesc"
                                        :disabled="true"
                                    />
                                </div>

                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-11 text-right">

                                <button :class="transBtn.search.class + ' btn-lg tw-w-32'"
                                    :disabled="!isAllowGetConfirmItems(transferHeader)"
                                    @click="onGetConfirmItems" >
                                    <i :class="transBtn.search.icon"></i>
                                    แสดงข้อมูล
                                </button>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="ibox float-e-margins">

            <div class="ibox-content">

                <div class="text-right tw-mb-2">
                    <button class="btn btn-inline-block btn-sm btn-success tw-w-32"
                        @click="onAddNewLine"
                        :disabled="!isAllowAddNewLine(transferHeader)"
                    > 
                        <i class="fa fa-plus tw-mr-1"></i> เพิ่มรายการ 
                    </button>
                </div>

                <div class="table-responsive" style="max-height: 600px;">

                    <table class="table table-bordered table-sticky">

                        <thead>
                            <tr>
                                <th width="30px;" class="text-center"></th>
                                <th width="170px;" class="text-center">
                                    รหัสสินค้าสำเร็จรูป
                                </th>
                                <th class="text-center"> 
                                    รายละเอียด 
                                </th>
                                <th width="200px;" class="text-center">
                                    Lot No.
                                </th>
                                <th width="140px;" class="text-center">
                                    จำนวน lot
                                </th>
                                <th width="200px;" class="text-center">
                                    จำนวนส่งเข้าคลัง
                                </th>
                                <th width="100px;" class="text-center">
                                    หน่วยนับ
                                </th>
                                <th width="30px;" class="text-center" v-if="isAllowDeleteLine(transferHeader)"></th>
                            </tr>
                        </thead>
                        <tbody v-if="transferInvItemLines.length > 0">
                            <template v-for="(transferInvItemLine, index) in transferInvItemLines">
                                <tr :key="`${index}`">
                                    <td class="align-middle text-center"> {{ index+1 }} </td>
                                    <td class="align-middle text-center">
                                        <template v-if="isAllowUpdateTransfer(transferHeader)">
                                            <pm-el-select :name="`item_number_${index}`" 
                                                :id="`input_item_number_${index}`" 
                                                :select-options="invItems"
                                                option-key="inventory_item_id"
                                                option-value="inventory_item_id" 
                                                option-label="item_number" 
                                                :value="transferInvItemLine.inventory_item_id"
                                                :filterable="true"
                                                @onSelected="onTransferInvItemChanged($event, transferInvItemLine, index)"
                                            />
                                        </template>
                                        <template v-else>
                                            {{ transferInvItemLine.item_number }}
                                        </template>
                                    </td>
                                    <td class="align-middle text-left">
                                        {{ transferInvItemLine.item_desc }}
                                    </td>
                                    <td class="align-middle text-center">
                                        <template v-if="isAllowUpdateTransfer(transferHeader)">
                                            <pm-el-select :name="`lot_number_${index}`" 
                                                :id="`input_lot_number_${index}`" 
                                                :select-options="transferInvItemLine.lot_number_items"
                                                option-key="lot_number"
                                                option-value="lot_number" 
                                                option-label="lot_number" 
                                                :value="transferInvItemLine.lot_number"
                                                :filterable="true"
                                                @onSelected="onTransferLotNumberChanged($event, transferInvItemLine, index)"
                                            />
                                        </template>
                                        <template v-else>
                                            {{ transferInvItemLine.lot_number }}
                                        </template>
                                    </td>
                                    <td class="align-middle text-right">
                                        {{ Number(transferInvItemLine.onhand_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}
                                    </td>
                                    <td class="align-middle text-right">
                                        <template v-if="isAllowInputTransactionQty(transferHeader)">
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="2" 
                                                v-bind:minus="false"
                                                :id="`input_transaction_qty_${index}`"
                                                style="min-width: 120px;"
                                                class="form-control input-sm text-right"
                                                :name="`transaction_qty_${index}`"
                                                v-model="transferInvItemLine.transaction_qty"
                                                @change="onTransactionQtyChanged(transferInvItemLine)"
                                            ></vue-numeric>
                                        </template>
                                        <template v-else>
                                            {{ Number(transferInvItemLine.transaction_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}
                                        </template>
                                    </td>
                                    <td class="align-middle text-center" :title="transferInvItemLine.unit_of_measure">
                                        {{ transferInvItemLine.unit_of_measure }}
                                    </td>
                                    <td v-if="isAllowDeleteLine(transferHeader)">
                                        <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            @click="onDeleteLine(transferInvItemLines, transferInvItemLine, index)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="11">
                                    <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <modal-search-header 
            modal-name="modal-search-header" 
            modal-width="1000" 
            modal-height="auto"
            :trans-btn="transBtn"
            @onSearchRequestHeader="onSearchRequestHeader"
        />

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

import VueNumeric from 'vue-numeric'

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import ModalSearchHeader from './ModalSearchHeader.vue';
import DatepickerTh from "../../DatepickerTh";

export default {

    components: { 
        Loading, 
        ModalSearchHeader, 
        DatepickerTh,
        VueNumeric
    },

    props:[ 
        "pUrl", 
        "organizationCode", 
        "transferNumberValue",
        "transferDateValue", 
        "profile", 
        "transBtn", 
        "transferObjectives", 
        "transferObjectiveValue", 
        "locators", 
        "toLocatorIdValue", 
        "deptCodes", 
        "requestStatuses"
    ],

    computed: {

    },

    watch:{
        transferInvItemLines : function (val, oldVal) {
            // this.checkConversItem();
        }

    },

    data() {

        return {
            isLoading: false,
            transferNumber: this.transferNumberValue ? this.transferNumberValue : '',
            transferDate: this.transferDateValue ? moment(this.transferDateValue, 'DD/MM/YYYY').toDate() : moment().add(543, 'years').toDate(),
            transferDateFormatted: this.transferDateValue ? this.transferDateValue : this.getDateFormatted(moment().add(543, 'years').toDate()),
            transferObjective: this.transferObjectiveValue ? this.transferObjectiveValue : this.transferObjectives[0].lookup_code,
            transferObjectiveLabel: this.getTransObjectiveLabel(this.transferObjectives, this.transferObjectiveValue ? this.transferObjectiveValue : this.transferObjectives[0].lookup_code),

            inputToLocators: this.locators,
            toLocatorId: this.toLocatorIdValue ? this.toLocatorIdValue : null,
            toLocatorDesc: this.toLocatorIdValue ? this.getLocatorDesc(this.locators, this.toLocatorIdValue) : '',
            invItems: [],
            availableInvItems: [],
            transferHeader: null,
            transferInvItemLines: [],
            confirmInvItems: [],
            transactionItems: [],
            availableTransactionItems: [],
        }
        
    },

    beforeMount() {

    },

    async mounted() {
        
        // FIND HEADER DATA
        // await this.findHeader();

        // GET COMFIRMED ITEMS
        if(this.transferNumber) {

            await this.findHeader();
            if(this.transferHeader) {
                await this.getLines();
                await this.getConfirmItems(false);
                // await this.checkConversItem();
            } else {
                swal({
                    title: "ไม่พบข้อมูล",
                    type: "warning",
                    text: `ใบส่งเลขที่ : ${this.transferNumber}`,
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "รับทราบ",
                    showCancelButton: false,
                    closeOnConfirm: true
                }, () => {
                    const rootUrl = this.pUrl.index.substr(0, this.pUrl.index.lastIndexOf("?"));
                    location.href = rootUrl;
                });
                
            }
        }

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("transfer_number", this.transferNumber ? this.transferNumber : '');
            queryParams.set("transfer_date", this.transferDateFormatted ? this.transferDateFormatted : '');
            queryParams.set("to_locator_id", this.toLocatorId ? this.toLocatorId : '');
            queryParams.set("transfer_objective", this.transferObjective ? this.transferObjective : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        // ############################
        // ON EVENT HAPPENED

        async onSearchRequestHeader(data) {

            this.transferHeader = data.transferHeader;
            if(data.transferHeader) {

                this.transferNumber = this.transferHeader.transfer_number;
                this.toLocatorId = this.transferHeader ? this.transferHeader.attribute11 : this.toLocatorId;
                this.transferObjective = this.transferHeader.transaction_type;
                this.transferDate = moment(this.transferHeader.transfer_date).add(543, 'years').toDate();
                this.transferDateFormatted = this.getDateFormatted(this.transferDate);

                // GET HEADER
                // if(this.productDate) {
                await this.findHeader();
                await this.getLines();
                await this.getConfirmItems();
                // }

                this.setUrlParams();

            }

        },

        onTransferInvItemChanged(inventoryItemId, transferInvItemLine, index) {

            const previousInventoryItemId = transferInvItemLine.inventory_item_id;

            // VALIDATE BEFORE CHANGED

            // ## CASE : M06

            const foundInvItem = this.invItems.find(invItem => inventoryItemId == invItem.inventory_item_id);
            const foundTransactionItem = this.availableTransactionItems.find(item => item.inventory_item_id == foundInvItem.inventory_item_id);

            transferInvItemLine.inventory_item_id = inventoryItemId;

            if(!foundTransactionItem) {
                swal("เกิดข้อผิดพลาด", ` รหัสสินค้าสำเร็จรูป : ${foundInvItem.item_number} ถูกเลือกใช้งานครบทุก Lot No. แล้ว`, "error");
                this.$nextTick(() => {
                    transferInvItemLine.inventory_item_id = previousInventoryItemId == null ? "" : (previousInventoryItemId == "" ? null : previousInventoryItemId);
                });
            } else {

                const defaultTransactionQty = 0;
                // const defaultTransactionQty = this.calDefaultTransactionQty(foundInvItem, foundTransactionItem);

                this.$nextTick(() => {

                    // console.log("onTransferInvItemChanged ---------->", foundInvItem)

                    transferInvItemLine.item_number                 = foundInvItem.item_number;
                    transferInvItemLine.item_desc                   = foundInvItem.item_desc;
                    transferInvItemLine.organization_id             = foundInvItem.organization_id;
                    transferInvItemLine.organization_id_from        = foundInvItem.organization_id_from;
                    transferInvItemLine.transaction_uom             = foundInvItem.transaction_uom;
                    transferInvItemLine.uom_code                    = foundInvItem.uom_code;
                    transferInvItemLine.unit_of_measure             = foundInvItem.unit_of_measure;

                    transferInvItemLine.convert_flag                = foundInvItem.convert_flag;
                    transferInvItemLine.destination_organization_id = foundInvItem.destination_organization_id;
                    transferInvItemLine.destination_locator_id      = foundInvItem.destination_locator_id;
                    transferInvItemLine.locators                    = foundInvItem.locators;
                    
                    transferInvItemLine.lot_number_items            = this.transactionItems.filter(item => item.inventory_item_id == inventoryItemId);
                    transferInvItemLine.lot_number                  = foundTransactionItem.lot_number;
                    transferInvItemLine.onhand_qty                  = foundTransactionItem.transaction_qty;
                    // transferInvItemLine.transaction_qty             = foundInvItem.transaction_qty;
                    transferInvItemLine.transaction_qty             = defaultTransactionQty;
                    
                    // this.checkConversItem();

                    this.availableTransactionItems = this.getAvailableTransactionItems(this.transactionItems, this.transferInvItemLines);
                    this.availableInvItems = this.getAvailableInvItems(this.invItems, this.availableTransactionItems);

                });

            }
            
        },
        
        onTransferLotNumberChanged(lotNumber, transferInvItemLine, index) {

            const previousLotNumber = transferInvItemLine.lot_number;

            // console.log(" onTransferLotNumberChanged(lotNumber, transferInvItemLine, index) : ");
            // console.log(lotNumber, previousLotNumber, transferInvItemLine);

            // VALIDATE BEFORE CHANGED

            // ## CASE : M06

            const foundInvItem = this.invItems.find(invItem => transferInvItemLine.inventory_item_id == invItem.inventory_item_id);
            const foundTransactionItem = this.transactionItems.find(item => (item.inventory_item_id == foundInvItem.inventory_item_id && item.lot_number == lotNumber));
            const foundTransferInvItemLine = this.transferInvItemLines.find(item => (item.inventory_item_id == transferInvItemLine.inventory_item_id && item.lot_number == lotNumber));

            transferInvItemLine.lot_number = lotNumber;

            if(foundTransferInvItemLine) {
                swal("เกิดข้อผิดพลาด", ` รหัสสินค้าสำเร็จรูป : ${foundTransferInvItemLine.item_number}, Lot No. : ${lotNumber} ถูกเลือกใช้งานแล้ว`, "error");
                this.$nextTick(() => {
                    transferInvItemLine.lot_number = previousLotNumber;
                });
            } else {

                const defaultTransactionQty = 0;
                // const defaultTransactionQty = this.calDefaultTransactionQty(foundInvItem, foundTransactionItem);

                this.$nextTick(() => {

                    // console.log("onTransferInvItemChanged ---------->", foundInvItem)

                    transferInvItemLine.item_number                 = foundInvItem.item_number;
                    transferInvItemLine.item_desc                   = foundInvItem.item_desc;
                    transferInvItemLine.organization_id             = foundInvItem.organization_id;
                    transferInvItemLine.organization_id_from        = foundInvItem.organization_id_from;
                    transferInvItemLine.transaction_uom             = foundInvItem.transaction_uom;
                    transferInvItemLine.uom_code                    = foundInvItem.uom_code;
                    transferInvItemLine.unit_of_measure             = foundInvItem.unit_of_measure;

                    transferInvItemLine.convert_flag                = foundInvItem.convert_flag;
                    transferInvItemLine.destination_organization_id = foundInvItem.destination_organization_id;
                    transferInvItemLine.destination_locator_id      = foundInvItem.destination_locator_id;
                    transferInvItemLine.locators                    = foundInvItem.locators;
                    
                    transferInvItemLine.lot_number                  = foundTransactionItem.lot_number;
                    transferInvItemLine.onhand_qty                  = foundTransactionItem.transaction_qty;
                    // transferInvItemLine.transaction_qty             = foundInvItem.transaction_qty;
                    transferInvItemLine.transaction_qty             = defaultTransactionQty;
                    
                    // this.checkConversItem();

                    this.availableTransactionItems = this.getAvailableTransactionItems(this.transactionItems, this.transferInvItemLines);
                    this.availableInvItems = this.getAvailableInvItems(this.invItems, this.availableTransactionItems);

                });

            }
            
        },

        onTransactionQtyChanged(transferInvItemLine) {

            const foundInvItem = this.invItems.find(invItem => invItem.inventory_item_id == transferInvItemLine.inventory_item_id);
            const foundTranItem = this.transactionItems.find(item => (item.inventory_item_id == transferInvItemLine.inventory_item_id && item.lot_number == transferInvItemLine.lot_number));
            const defaultTransactionQty = 0;
            // const defaultTransactionQty = this.calDefaultTransactionQty(foundInvItem, foundTranItem);

            if(this.validateOnhandQty(transferInvItemLine)) {
                // VALIDATE => PASSED
            } else {
                // VALIDATE => FAILED
                swal("เกิดข้อผิดพลาด", `รหัสสินค้าสำเร็จรูป : ${foundInvItem.item_number}, Lot No. : ${foundTranItem.lot_number}, ไม่สามารถกรอกผลรวม "จำนวนส่งเข้าคลัง" ได้เกินกว่า ${foundTranItem.transaction_qty}`, "error");
                this.$nextTick(() => {
                    transferInvItemLine.transaction_qty = defaultTransactionQty;
                });
            }

        },

        validateOnhandQty(transferInvItemLine){
            let valid = true;
            const foundTranItem = this.transactionItems.find(item => (item.inventory_item_id == transferInvItemLine.inventory_item_id && item.lot_number == transferInvItemLine.lot_number));
            if(foundTranItem) {
                const onhandQty = parseFloat(foundTranItem.transaction_qty);
                const transactionQty = parseFloat(transferInvItemLine.transaction_qty);
                if(transactionQty > onhandQty) {
                    valid = false;
                }
            }
            return valid;
        },

        async onAddNewLine() {

            const newtransferInvItemLine = this.availableInvItems.length > 0 ? this.availableInvItems[0] : null;
            if(newtransferInvItemLine) {

                // ## CASE : M06
                const newtransferTransactionItemLine = this.availableTransactionItems.length > 0 ? this.availableTransactionItems.find(item => item.inventory_item_id == newtransferInvItemLine.inventory_item_id) : null;
                const defaultTransactionQty = 0;
                // const defaultTransactionQty = this.calDefaultTransactionQty(newtransferInvItemLine, newtransferTransactionItemLine);

                this.transferInvItemLines = [
                    ...this.transferInvItemLines,
                    {
                        ...newtransferInvItemLine,
                        lot_number_items: this.transactionItems.length > 0 ? this.transactionItems.filter(item => item.inventory_item_id == newtransferInvItemLine.inventory_item_id) : [],
                        lot_number: newtransferTransactionItemLine ? newtransferTransactionItemLine.lot_number : null,
                        onhand_qty: newtransferTransactionItemLine ? newtransferTransactionItemLine.transaction_qty : 0,
                        // transaction_qty: newtransferTransactionItemLine ? newtransferTransactionItemLine.transaction_qty : 0
                        transaction_qty: defaultTransactionQty
                    }
                ];

            }

            // SHOW LOADING
            this.isLoading = true;

            this.availableTransactionItems = this.getAvailableTransactionItems(this.transactionItems, this.transferInvItemLines);
            this.availableInvItems = this.getAvailableInvItems(this.invItems, this.availableTransactionItems);

            // HIDE LOADING
            this.isLoading = false;

        },

        calDefaultTransactionQty(invItemLine, transactionItemLine) {

            const invTranQty = parseFloat(invItemLine.transaction_qty);
            const defaultTranQty = parseFloat(transactionItemLine.transaction_qty);
            
            const filteredTransferItems = this.transferInvItemLines.filter(item => {
                return item.inventory_item_id == transactionItemLine.inventory_item_id && item.lot_number != transactionItemLine.lot_number
            });
            const totalCurrentTranQty = filteredTransferItems.reduce((acc, currValue) => acc + currValue.transaction_qty, 0);

            let result = defaultTranQty;
            if((totalCurrentTranQty + defaultTranQty) > invTranQty) {
                if((invTranQty - totalCurrentTranQty) >= 0) {
                    result = invTranQty - totalCurrentTranQty;
                } else {
                    result = 0;
                }
            }

            return result;
            
        },

        async onDeleteLine(transferInvItemLines, transferInvItemLine, index) {

            swal({
                title: "",
                text: `ต้องการลบรายการ ${transferInvItemLine.item_desc ? transferInvItemLine.item_desc : ""} ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "ลบ",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true
            }, (isConfirm) => {
                if (isConfirm) {

                    // transferInvItemLine.marked_as_deleted = true;

                    const foundIndex = this.transferInvItemLines.findIndex((item) => {
                        return item == transferInvItemLine;
                    });
                    this.transferInvItemLines.splice(foundIndex, 1);

                    this.availableTransactionItems = this.getAvailableTransactionItems(this.transactionItems, this.transferInvItemLines);
                    this.availableInvItems = this.getAvailableInvItems(this.invItems, this.availableTransactionItems);

                }
            });

        },

        onTransObjectiveWasChanged(value) {
            
            this.transferObjective = value;
            this.transferObjectiveLabel = this.getTransObjectiveLabel(this.transferObjectives, this.transferObjective);
            this.setUrlParams();

        },

        onToLocatorWasChanged(value) {
            
            this.toLocatorId = value;
            this.toLocatorDesc = this.getLocatorDesc(this.locators, value);
            
            this.setUrlParams();

        },


        async onTransferDateWasSelected(value) {
            
            this.transferDate = value;
            this.transferDateFormatted = this.getDateFormatted(this.transferDate);

            // this.transferNumber = null
            // this.transferHeader = null;
            this.confirmInvItems = [];
            this.transactionItems = [];

            this.invItems = [];
            this.availableInvItems = [];

            this.availableTransactionItems = [];

            this.transferInvItemLines = [];

            this.setUrlParams();

        },

        onCreateNew() {
        
            const rootUrl = this.pUrl.index.substr(0, this.pUrl.index.lastIndexOf("?"));
            location.href = rootUrl;

        },

        async onGetConfirmItems() {

            await this.getConfirmItems();

            // AUTO RECONCILE LINE ITEMS
            if(this.transferInvItemLines.length > 0) {
                
                this.$nextTick(() => {

                    this.transferInvItemLines.map(transferInvItemLine => {
                        const foundConfirmInvItem = this.confirmInvItems.find(citem => citem.inventory_item_id == transferInvItemLine.inventory_item_id);
                        transferInvItemLine.transaction_qty = foundConfirmInvItem.transaction_qty;
                        return transferInvItemLine;
                    });

                });

            }

        },

        getDateFormatted(date) {
            return moment(date).format("DD/MM/YYYY");
        },


        async onSave() {

            await this.saveHeader();
            await this.saveLines();

        },

        async findHeader() {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                transfer_number: this.transferNumber
            };
            await axios.get(`/ajax/pm/products/transfer-split-lots/find-header`, { params })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {
                    this.transferNumber = this.transferHeader ? this.transferHeader.transfer_number : this.transferNumber;
                    this.transferHeader = resData.transfer_header ? JSON.parse(resData.transfer_header) : this.transferHeader;
                    // this.toDepartmentCode = this.transferHeader ? this.transferHeader.attribute10 : this.toDepartmentCode;
                    this.toLocatorId = this.transferHeader ? this.transferHeader.attribute11 : this.toLocatorId;
                    this.transferObjective = this.transferHeader ? this.transferHeader.attribute15 : this.transferObjective;
                } else {
                    swal("เกิดข้อผิดพลาด", `${resData.message}`, "error");                    
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

            // if(this.transferHeader) {
                // IF FOUND HEADER
                // => GET LINES
                // await this.getLines();
            // }

        },

        validateBeforeSaveHeader(transferHeader) {

            const result = {
                valid: true,
                message: "",
            };

            return result;

        },

        async saveHeader() {

            const reqBody = {
                transfer_number: this.transferNumber,
                // product_date: this.productDateFormatted,
                transfer_date: this.transferDateFormatted,
                transfer_objective: this.transferObjective,
                to_locator_id: this.toLocatorId,
                // to_department_code: this.toDepartmentCode,
                transfer_header: JSON.stringify(this.transferHeader),
            };

            // SHOW LOADING
            this.isLoading = true;

            const resValidate = this.validateBeforeSaveHeader(this.transferHeader);

            if(resValidate.valid) {

                // call store sample result
                await axios.post(`/ajax/pm/products/transfer-split-lots/store-header`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    if(resData.status == "success") {
                        this.isNewlyCreate = false;
                        this.transferHeader = resData.transfer_header ? JSON.parse(resData.transfer_header) : this.transferHeader;
                        this.transferNumber = this.transferHeader ? this.transferHeader.transfer_number : this.transferNumber;
                        // this.toDepartmentCode = this.transferHeader ? this.transferHeader.attribute10 : this.toDepartmentCode;
                        this.toLocatorId = this.transferHeader ? this.transferHeader.attribute11 : this.toLocatorId;
                        if(this.transferNumber) {
                            this.setUrlParams();
                        }
                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `${error.message}`, "error");
                });

            } else {
                swal("เกิดข้อผิดพลาด", `${resValidate.message}`, "error");
            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async validateBeforeSaveLines(transferHeader, transferInvItemLines) {

            const result = {
                valid: true,
                message: "",
            };

            // // IF NEW LINE ISN'T COMPLETED
            // const incompletedLines = transferInvItemLines.filter(item => {
            //     return item.is_new_line && (
            //         !item.inventory_item_id ||
            //         !item.transaction_qty
            //     ) && item.marked_as_deleted == false;
            // });

            // if(incompletedLines.length > 0) {
            //     result.valid = false;
            //     result.message = `กรอกข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักรไม่ครบถ้วน กรุณาตรวจสอบ`
            // }

            return result;

        },

        async saveLines() {

            const reqBody = {
                transfer_number: this.transferNumber,
                // product_date: this.productDateFormatted,
                transfer_date: this.transferDateFormatted,
                transfer_objective: this.transferObjective,
                to_locator_id: this.toLocatorId,
                // to_department_code: this.toDepartmentCode,
                transfer_header: JSON.stringify(this.transferHeader),
                transfer_inv_item_lines: JSON.stringify(this.transferInvItemLines)
            };

            // SHOW LOADING
            this.isLoading = true;

            const resValidate = await this.validateBeforeSaveLines(this.transferHeader, this.transferInvItemLines);

            if(resValidate.valid) {

                // call store sample result
                await axios.post(`/ajax/pm/products/transfer-split-lots/store-lines`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    if(resData.status == "success") {
                        this.isNewlyCreate = false;
                        this.transferInvItemLines = resData.transfer_inv_item_lines ? JSON.parse(resData.transfer_inv_item_lines) : [];
                        swal("Success", `บันทึกข้อมูล เลขที่ใบส่ง : ${this.transferNumber} `, "success");
                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `เลขที่ใบส่ง : ${this.transferNumber} | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `เลขที่ใบส่ง : ${this.transferNumber} | ${error.message}`, "error");
                });

            } else {
                swal("เกิดข้อผิดพลาด", `เลขที่ใบส่ง : ${this.transferNumber} | ${resValidate.message}`, "error");
            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async confirmRequest() {

            const reqBody = {
                transfer_header: JSON.stringify(this.transferHeader),
            };

            // SHOW LOADING
            this.isLoading = true;

            // const resValidate = await this.validateBeforeConfirmRequest(this.transferHeader, this.transferInvItemLines);
            // if(resValidate.valid) {

            await axios.post(`/ajax/pm/products/transfer-split-lots/confirm-request`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    
                    this.isNewlyCreate = false;
                    this.transferHeader = resData.transfer_header ? JSON.parse(resData.transfer_header) : this.transferHeader;
                    this.transferNumber = this.transferHeader ? this.transferHeader.transfer_number : this.transferNumber;
                    // this.toDepartmentCode = this.transferHeader ? this.transferHeader.attribute10 : this.toDepartmentCode;
                    this.toLocatorId = this.transferHeader ? this.transferHeader.attribute11 : this.toLocatorId;

                    swal("Success", `ยืนยันส่งสินค้าสำเร็จรูป เลขที่ใบส่ง : ${this.transferNumber} `, "success");

                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถยืนยันส่งสินค้าสำเร็จรูป เลขที่ใบส่ง : ${this.transferNumber} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถยืนยันส่งสินค้าสำเร็จรูป เลขที่ใบส่ง : ${this.transferNumber} | ${error.message}`, "error");
            });

            // } else {
            //     swal("เกิดข้อผิดพลาด", `ไม่สามารถยืนยันส่งสินค้าสำเร็จรูป เลขที่ใบส่ง : ${this.transferNumber} | ${resValidate.message}`, "error");
            // }

            // HIDE LOADING
            this.isLoading = false;

        },

        async discardConfirmedRequest() {

            const reqBody = {
                transfer_number: this.transferNumber,
                transfer_header: JSON.stringify(this.transferHeader),
            };

            // SHOW LOADING
            this.isLoading = true;

            await axios.post(`/ajax/pm/products/transfer-split-lots/discard-confirmed-request`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    this.isNewlyCreate = false;
                    this.transferHeader = resData.transfer_header ? JSON.parse(resData.transfer_header) : this.transferHeader;
                    this.transferNumber = this.transferHeader ? this.transferHeader.transfer_number : this.transferNumber;
                    // this.toDepartmentCode = this.transferHeader ? this.transferHeader.attribute10 : this.toDepartmentCode;
                    this.toLocatorId = this.transferHeader ? this.transferHeader.attribute11 : this.toLocatorId;
                    swal("Success", `ยกเลิก เลขที่ใบส่ง : ${this.transferNumber} `, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถยกเลิก เลขที่ใบส่ง : ${this.transferNumber} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถยกเลิก เลขที่ใบส่ง : ${this.transferNumber} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async cancelRequest() {

            const reqBody = {
                transfer_number: this.transferNumber,
                transfer_header: JSON.stringify(this.transferHeader),
            };

            // SHOW LOADING
            this.isLoading = true;

            await axios.post(`/ajax/pm/products/transfer-split-lots/cancel-request`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    this.isNewlyCreate = false;
                    this.transferHeader = resData.transfer_header ? JSON.parse(resData.transfer_header) : this.transferHeader;
                    this.transferNumber = this.transferHeader ? this.transferHeader.transfer_number : this.transferNumber;
                    // this.toDepartmentCode = this.transferHeader ? this.transferHeader.attribute10 : this.toDepartmentCode;
                    this.toLocatorId = this.transferHeader ? this.transferHeader.attribute11 : this.toLocatorId;
                    swal("Success", `ยกเลิกข้อมูล เลขที่ใบส่ง : ${this.transferNumber} `, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ยกเลิกข้อมูล เลขที่ใบส่ง : ${this.transferNumber} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ยกเลิกข้อมูล เลขที่ใบส่ง : ${this.transferNumber} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async getConfirmItems(showAlert = true) {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                transfer_date: this.transferDateFormatted,
            };
            await axios.get(`/ajax/pm/products/transfer-split-lots/get-confirm-items`, { params })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.confirmInvItems = resData.confirm_inv_items ? JSON.parse(resData.confirm_inv_items) : [];
                    this.transactionItems = resData.transaction_items ? JSON.parse(resData.transaction_items) : [];

                    this.invItems = this.confirmInvItems.filter(invItem => {
                        const foundTransactionItem = this.transactionItems.find(item => invItem.inventory_item_id == item.inventory_item_id);
                        return !!foundTransactionItem;
                    });
                    
                    this.availableTransactionItems = this.getAvailableTransactionItems(this.transactionItems, this.transferInvItemLines);
                    this.availableInvItems = this.getAvailableInvItems(this.invItems, this.availableTransactionItems);

                    if(this.confirmInvItems.length <= 0) {
                        if(showAlert) {
                            swal("ไม่พบข้อมูล", `ไม่พบข้อมูลสินค้าสำเร็จรูป วันที่ส่งผลผลิต ${this.transferDateFormatted}`, "info");
                        }
                    }

                } else {
                    swal("เกิดข้อผิดพลาด", `${resData.message}`, "error");                    
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async getLines() {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                transfer_number: this.transferNumber,
            };
            await axios.get(`/ajax/pm/products/transfer-split-lots/get-lines`, { params })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.transferInvItemLines = resData.transfer_inv_item_lines ? JSON.parse(resData.transfer_inv_item_lines) : [];

                } else {
                    swal("เกิดข้อผิดพลาด", `${resData.message}`, "error");                    
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        getAvailableInvItems(invItems, availableTransactionItems) {

            let availableInvItems = [];

            // ## CASE : M06
            availableInvItems = invItems.filter(invItem => {
                const foundTransItem = availableTransactionItems.find(transactionItem => {
                    return invItem.inventory_item_id == transactionItem.inventory_item_id;
                });
                return foundTransItem;
            });

            return availableInvItems;

        },

        getAvailableTransactionItems(transactionItems, transferInvItemLines) {

            let availableTransactionItems = [];

            // ## CASE : M06
            availableTransactionItems = transactionItems.filter(transactionItem => {
                const foundInvItem = transferInvItemLines.find(transferInvItemLine => {
                    return transactionItem.inventory_item_id == transferInvItemLine.inventory_item_id && transactionItem.lot_number == transferInvItemLine.lot_number;
                });
                return !foundInvItem;
            });

            return availableTransactionItems;

        },

        // ############################
        // GET DESCRIPTION

        getTransObjectiveLabel(transferObjectives, transferObjective) {
            const foundTransObjective = transferObjectives.find(item => item.lookup_code == transferObjective);
            return foundTransObjective ? foundTransObjective.description : "";
        },

        getLocatorDesc(locators, locatorId) {
            const foundLocator = locators.find(item => item.locator_id == locatorId);
            return foundLocator ? foundLocator.locator_full_desc : "";
        },

        getDepartmentDesc(deptCodes, departmentCode) {
            const foundDept = deptCodes.find(item => item.department_code == departmentCode);
            return foundDept ? foundDept.department_desc : "";
        },

        getTransferStatusDesc(transferHeader) {

            let statusDesc = "";
            const requestStatus = transferHeader ? transferHeader.transfer_status : "";
            if(requestStatus) {
                const foundTransferStatus = this.requestStatuses.find(item => item.lookup_code == requestStatus);
                if(foundTransferStatus){
                    statusDesc = foundTransferStatus.description
                }
            }
            return statusDesc;
        },

        // ############################
        // PERMISSION DEFINED FUNTIONS

        isAllowAddNewLine(transferHeader) {

            let allowed = true;

            // ## CASE : M06

            if(!transferHeader) {
                
                if(this.availableInvItems.length <= 0 || this.availableTransactionItems.length <= 0){
                    allowed = false;
                }
                
            } else {
            
                if(transferHeader.transfer_status != "1") {
                    allowed = false;
                }

                if(this.availableInvItems.length <= 0 || this.availableTransactionItems.length <= 0){
                    allowed = false;
                }

            }

            return allowed;
        },

        isAllowDeleteLine(transferHeader) {

            let allowed = true;

            if(transferHeader) {
            
                if(transferHeader.transfer_status != "1") {
                    allowed = false;
                }

            }

            return allowed;
        },

        isAllowCreateNewTransfer(transferHeader) {

            let allowed = true;

            // if(!transferHeader) {
            //     allowed = true;
            // } else {

            //     // IF HEADER STATUS == 1 (NEW)
            //     if(transferHeader.transfer_status == "1") {
            //         allowed = true;
            //     }else{
            //         allowed = true;
            //     }
                
            // }

            return allowed;

        },

        isAllowGetConfirmItems(transferHeader) {

            let allowed = true;

            if(!transferHeader) {
                allowed = true;
            } else {

                // IF HEADER STATUS == 1 (NEW)
                if(transferHeader.transfer_status == "1") {
                    allowed = true;
                } else {
                    allowed = false;
                }

            }

            return allowed;

        },

        isAllowUpdateTransfer(transferHeader) {

            let allowed = true;

            if(!transferHeader) {
                allowed = true;
            } else {

                // IF HEADER STATUS == 1 (NEW)
                if(transferHeader.transfer_status == "1") {
                    allowed = true;
                } else {
                    allowed = false;
                }

            }

            return allowed;

        },

        isAllowConfirmTransfer(transferHeader) {

            let allowed = true;

            if(!transferHeader) {
                allowed = false;
            } else {

                // IF HEADER STATUS == 1 (NEW)
                if(transferHeader.transfer_status == "1") {
                    allowed = true;
                } else {
                    allowed = false;
                }

            }

            return allowed;

        },

        isAllowDiscardTransfer(transferHeader) {

            let allowed = true;

            if(!transferHeader) {
                allowed = false;
            } else {

                // IF HEADER STATUS == 1 (NEW)
                if(transferHeader.transfer_status == "1") {
                    allowed = false;
                }

                // IF HEADER STATUS == 2 (COMFIRMED)
                if(transferHeader.transfer_status == "2") {
                    allowed = true;
                }

                // IF HEADER STATUS == 3 (WMS COMFIRMED)
                if(transferHeader.transfer_status == "3") {
                    allowed = false;
                }

                // IF HEADER STATUS == 4 (CANCELLED)
                if(transferHeader.transfer_status == "4") {
                    allowed = false;
                }

            }

            return allowed;

        },

        isAllowCancelTransfer(transferHeader) {

            let allowed = true;

            if(!transferHeader) {
                allowed = false;
            } else {

                // IF HEADER STATUS == 1 (NEW)
                if(transferHeader.transfer_status == "1") {
                    allowed = true;
                }

                // IF HEADER STATUS == 2 (COMFIRMED)
                if(transferHeader.transfer_status == "2") {
                    allowed = true;
                }

                // IF HEADER STATUS == 3 (WMS COMFIRMED)
                if(transferHeader.transfer_status == "3") {
                    allowed = false;
                }

                // IF HEADER STATUS == 4 (CANCELLED)
                if(transferHeader.transfer_status == "4") {
                    allowed = false;
                }

            }

            return allowed;

        },

        isAllowInputTransactionQty(transferHeader) {

            let allowed = true;

            // ## CASE : M06

            if(!transferHeader) {
                allowed = true;
            } else {
                // IF HEADER STATUS == 1 (NEW)
                if(transferHeader.transfer_status == "1") {
                    allowed = true;
                } else {
                    allowed = false;
                }
            }

            return allowed;

        },

        async checkConversItem() {

            let vm = this;
            let firstLine = vm.transferInvItemLines[0];

            // ## CASE : M06
            // DO NOTHING

        }

    }
}
</script>
