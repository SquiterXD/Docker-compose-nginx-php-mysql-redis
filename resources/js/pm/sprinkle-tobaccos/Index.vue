<template>
    <div>
        <div class="ibox float-e-margins" v-loading="loading.page">
            <div class="ibox-content" v-if="!loading.before_mount" style="border-bottom: 0px;">
                <div class="row">
                    <!-- <div class="col-3">
                        <h3 class="no-margins"> โอนสินค้าสำเร็จรูป </h3>
                    </div> -->
                    <div class="col-12 text-right">
                        <button :class="transBtn.search.class + ' btn-lg tw-w-25 '"
                           @click="countOpen += 1" >
                            <i :class="transBtn.search.icon"></i>
                            {{ transBtn.search.text }} เลขที่เอกสาร
                        </button>

                        <button :class="transBtn.create.class + ' btn-lg tw-w-25 mr-2'"
                            @click.prevent="getInfo()" >
                            <i :class="transBtn.create.icon"></i>
                            {{ transBtn.create.text }}
                        </button>

                        <button :class="transBtn.save.class + ' btn-lg tw-w-25'"
                                :disabled="!header.can.save"
                                @click.prevent="save">
                                <i :class="transBtn.save.icon"></i>
                                {{ transBtn.save.text }}
                        </button>
                        <button
                            class="btn btn-primary btn-lg"
                            :disabled="!header.can.transfer"
                            @click.prevent="setStatus('confirmTransfer')">
                            <strong>ยืนยันการโรยยาเส้น</strong>
                        </button>
                        <button
                            class="btn btn-w-m btn-danger btn-lg"
                            :disabled="!header.can.cancel_transfer"
                            @click.prevent="cancel()">
                            <i class="fa fa-times"></i> ยกเลิกการโรยยาเส้น
                        </button>

                        <!-- <button
                            class="btn btn-primary btn-lg"
                            :disabled="!header.can.transfer"
                            @click.prevent="setStatus('infWipCompleted')">
                            <strong>ยืนยันบันทึกเข้าคลัง</strong>
                        </button>

                        <button
                            class="btn btn-w-m btn-danger btn-lg"
                            :disabled="!header.can.cancel_transfer"
                            @click.prevent="setStatus('infWipCompletedReturn')">
                            <i class="fa fa-times"></i> ยกเลิกบันทึกเข้าคลัง
                        </button>
                        <button
                            class="btn btn-w-m btn-danger btn-lg"
                            :disabled="!header.can.edit"
                            @click.prevent="setStatus('cancelTransfer')">
                            <i class="fa fa-times"></i> ยกเลิกเอกสาร
                        </button> -->
                    </div>
                </div>
            </div>
            <div  class="ibox-content" v-if="!loading.before_mount">
                <modal-search @selectWipRequestHeader="show" :transDate="transDate"
                    :transBtn="transBtn" :url="url"
                    :countOpen="countOpen" />
                <div class="row">
                    <div class="col-lg-6 b-r">
                        <div class="form-group row">
                            <div class="col-lg-4 font-weight-bold col-form-label text-right require" >วันที่: </div>
                            <div class="col-lg-7">
                                <datepicker-th
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="input_date"
                                    id="input_date"
                                    :not-before-date="data.preiod_min_max.min_date_th"
                                    :not-after-date="data.preiod_min_max.max_date_th"
                                    :disabled="header.sprinkle_header_id != ''"
                                    placeholder="โปรดเลือกวันที่"
                                    :value="header.transaction_date_format"
                                    :format="transDate['js-format']"
                                    @dateWasSelected="setdate(...arguments, 'transaction_date_format')"
                                    />
                                <div v-if="!validateFrom.transaction_date_format.is_valid">
                                    <span class="form-text m-b-none text-danger">
                                        {{ validateFrom.transaction_date_format.message }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-4 font-weight-bold col-form-label text-right require">Blend no.: </div>
                            <div class="col-lg-3">
                                <input class="form-control" type="text"
                                    v-if="header.sprinkle_header_id"
                                    disabled style="height: 40px;"
                                    v-model="header.blend_no"/>
                                <el-select
                                    v-else
                                    style="width: 100%"
                                    v-model="header.blend_no"
                                    filterable
                                    clearable
                                    placeholder="">
                                    <el-option v-if="header.transaction_date_format"
                                        v-for="(item, idx) in blendNoList"
                                        :key="idx"
                                        :label="idx"
                                        :value="idx"
                                    ></el-option>
                                </el-select>

                                <div v-if="!validateFrom.blend_no.is_valid">
                                    <span class="form-text m-b-none text-danger">
                                        {{ validateFrom.blend_no.message }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-lg-1 font-weight-bold col-form-label text-right require">OPT: </div>
                            <div class="col-lg-3">
                                <input class="form-control" type="text"
                                    v-if="header.sprinkle_header_id"
                                    disabled style="height: 40px;"
                                    v-model="header.opt"/>
                                <el-select
                                    v-else
                                    style="width: 100%"
                                    v-model="header.opt"
                                    filterable
                                    clearable
                                    placeholder="">
                                    <el-option v-if="header.transaction_date_format"
                                        v-for="(item, idx) in blendNoList[header.blend_no]"
                                        :key="item.opt"
                                        :label="item.opt"
                                        :value="item.opt"
                                    ></el-option>
                                </el-select>
                                <div v-if="!validateFrom.opt.is_valid">
                                    <span class="form-text m-b-none text-danger">
                                        {{ validateFrom.opt.message }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-4 font-weight-bold col-form-label text-right require">จำนวนที่ต้องการ: </div>
                            <div class="col-lg-4">
                                <input class="form-control text-right" type="text"
                                    v-if="header.sprinkle_header_id"
                                    disabled style="height: 40px;"
                                    v-model="header.receipt_quantity"/>

                                <input class="form-control text-right" type="number" style="height: 40px;"
                                    v-else
                                    min="0"
                                    oninput="validity.valid||(value='');"
                                    v-model.number="header.receipt_quantity"
                                    @change="changeReceiptquantity()"
                                    :disabled="false"
                                    />
                                <div v-if="!validateFrom.receipt_quantity.is_valid">
                                    <span class="form-text m-b-none text-danger">
                                        {{ validateFrom.receipt_quantity.message }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <input class="form-control" type="text"
                                    v-if="header.sprinkle_header_id"
                                    disabled style="height: 40px;"
                                    v-model="header.uom_desc"/>
                                <el-select
                                    v-else
                                    style="width: 100%"
                                    v-model="header.receipt_uom_code"
                                    filterable
                                    clearable
                                    placeholder="">
                                    <template v-if="header.blend_no && Object.keys(itemList[header.blend_no]['secondary_uom_list']).length">
                                        <el-option
                                            v-for="(item, idx) in itemList[header.blend_no]['secondary_uom_list']"
                                            :key="idx"
                                            :label="item.from_uom.unit_of_measure"
                                            :value="idx"
                                        ></el-option>
                                    </template>
                                </el-select>
                                <div v-if="!validateFrom.receipt_uom_code.is_valid">
                                    <span class="form-text m-b-none text-danger">
                                        {{ validateFrom.receipt_uom_code.message }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-4 font-weight-bold col-form-label text-right require">เลขที่เอกสาร: </div>
                            <div class="col-lg-7">
                                <input class="form-control"
                                    type="text" style="height: 40px;"
                                    :disabled="header.sprinkle_header_id != ''"
                                    v-model="header.sprinkle_no"/>
                                <div v-if="!validateFrom.sprinkle_no.is_valid">
                                    <span class="form-text m-b-none text-danger">
                                        {{ validateFrom.sprinkle_no.message }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">
                        <!-- <div class="form-group row">
                            <div class="col-lg-4 font-weight-bold col-form-label text-right require" >&nbsp;</div>
                            <div class="col-lg-7">
                                <div class="pt-2" v-html="header.status_lable_html"></div>
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <div class="col-lg-3 font-weight-bold col-form-label text-right require" >สถานะขอเบิก: </div>
                            <div class="col-lg-7">
                                <input  type="text" readonly 
                                        disabled 
                                        class="form-control"
                                        :value="(()=>{
                                            if(header.transfer_status){
                                                let result = header.request_status_list.find(o => o.lookup_code == header.transfer_status)
                                                if(result){
                                                    return result.description
                                                }
                                            }
                                            return null
                                        })()">
                            </div>                            
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3 font-weight-bold col-form-label text-right require" >รหัสสินค้าสำเร็จรูป: </div>
                            <div class="col-lg-7">
                                <input class="form-control" type="text"
                                        v-if="header.sprinkle_header_id"
                                        disabled style="height: 40px;"
                                        :value="header.item_no +': '+ header.item_desc"/>
                                <input type="text"
                                    v-else
                                    readonly disabled style="height: 40px;"
                                    :value="(()=>{
                                        if(header.blend_no){
                                            let item = blendNoList[parseInt(header.blend_no)][0];
                                            return item.item_no  + ': ' + item.item_desc
                                        }
                                        return null
                                    })()"
                                    class="form-control">
                            </div>
                        </div>

                         <div class="form-group row">
                            <div class="col-lg-3 font-weight-bold col-form-label text-right require">คลังจัดเก็บ: </div>
                            <div class="col-lg-7">
                                <input class="form-control" type="text" readonly disabled style="height: 40px;"
                                    v-model="header.to_subinventory"/>
                                <div v-if="!validateFrom.to_subinventory.is_valid">
                                    <span class="form-text m-b-none text-danger">
                                        {{ validateFrom.to_subinventory.message }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3 font-weight-bold col-form-label text-right require">สถานที่จัดเก็บ: </div>
                            <div class="col-lg-7">
                                <input class="form-control" type="text" readonly disabled style="height: 40px;"
                                    v-model="header.to_locator_code"/>
                                <div v-if="!validateFrom.to_locator_code.is_valid">
                                    <span class="form-text m-b-none text-danger">
                                        {{ validateFrom.to_locator_code.message }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 offset-6" v-if="!header.sprinkle_header_id">
                        <div class=" row">
                            <div class="col-lg-11 text-right">
                                <button :class="transBtn.search.class + ' btn-lg tw-w-25 mr-2'"
                                    @click.prevent="getLines(true, 'show')" >
                                    <i :class="transBtn.search.icon"></i>
                                    แสดงข้อมูล
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div  class="ibox-content" v-if="!loading.before_mount" style="border-top: 0px;" >
                 <div class="table-responsive m-t">
                    <table class="table text-nowrap  table-bordered" v-if="searchTransactionDateFormat == header.transaction_date_format || header.sprinkle_header_id">
                        <thead>
                            <tr>
                                <th width="10px;" class="text-center">
                                </th>
                                <th width="130px;">
                                    Blend No.
                                </th>
                                <th width="150px;">
                                    รหัสสินค้าสำเร็จรูป
                                </th>
                                <th >รายละเอียด</th>
                                <th width="100px;" class="text-right">
                                    ปริมาณคงคลัง
                                </th>
                                <th width="100px;" class="text-center">
                                    หน่วยนับ
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(item, i) in onhandList" v-if="onhandList.length">
                                <tr>
                                    <td :date="i" class="align-middle text-center">
                                        <!-- <pre>{{ item.is_disable }} {{ item.is_selected }}</pre> -->
                                        <input :disabled="item.is_disable || !item.can_misc_receipt"
                                            type="checkbox" v-model="item.is_selected"  @change="selectedItem(item)">
                                    </td>
                                    <td :date="i" class="align-middle text-left">
                                        <strong>{{ item.blend_no }}</strong>
                                    </td>
                                    <td>
                                        {{ item.item_number }}
                                    </td>
                                    <td>
                                        {{ item.item_desc }}
                                    </td>
                                    <td class="text-right">
                                        {{ item.total_onhand_quantity }}
                                    </td>
                                    <td class="text-center" :title="item.issue_uom_code">
                                        {{ item.issue_unit_of_measure }}
                                    </td>
                                </tr>
                                <transition
                                    enter-active-class="animated fadeIn"
                                    leave-active-class="animated fadeOut">
                                    <tr v-if="item.is_selected && item.can_misc_receipt || header.sprinkle_header_id">
                                        <td colspan="6">
                                            <div class=" mb-0 col-lg-8 col-md-6 col-sm-6 col-xs-6 offset-md-2 mt-2">
                                                <table class="table text-nowrap table-bordered table-hover" >
                                                    <thead>
                                                        <tr>
                                                            <th width="130px;" >
                                                                LOT No.
                                                            </th>
                                                            <th width="100px;" class="text-right">
                                                                ปริมาณคงคลัง
                                                            </th>
                                                            <th width="100px;" class="text-right">
                                                                ปริมาณที่นำไปโรย
                                                            </th>
                                                            <th width="100px;" class="text-center">
                                                                หน่วยนับ
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(lot, i) in item.lot_list" v-if="item.lot_list.length" :title="lot.origination_date">
                                                            <td>{{ lot.lot_number }}</td>
                                                            <td class="text-right">{{ lot.onhand_quantity }}</td>
                                                            <td class="text-right">
                                                                <div v-if="header.sprinkle_header_id">
                                                                    {{ lot.issue_quantity }}
                                                                </div>
                                                                <input class="form-control text-right"
                                                                    v-else
                                                                    type="number"
                                                                    min="0" :max="lot.onhand_quantity"
                                                                    oninput="validity.valid||(value='');"
                                                                    v-model.number="lot.issue_quantity"/>
                                                            </td>
                                                            <td class="text-center">{{ lot.issue_unit_of_measure }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </transition>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import {
    showLoadingDialog,
    showProgressWithUnsavedChangesWarningDialog,
    showValidationFailedDialog,
} from "../../commonDialogs"

import moment from "moment";
// import searchItem from './SearchItem';
import modalSearch from './ModalSearch.vue';

export default {

    components: {
        modalSearch
    },
    props:["url"],
    computed: {
        secondaryUomList() {
            // let vm = this;
            // if (vm.header.inventory_item_id) {
            //     let item = vm.data.item_list.filter(o => o.inventory_item_id == vm.header.inventory_item_id);
            //     if (item.length) {
            //         if (!vm.header.attribute1) {
            //             vm.header.attribute1 = item[0].primary_uom_code;
            //         }

            //         return item[0].secondary_uom_list;
            //     }
            // }
            // return [];
        },
    },
     watch: {
        'header.transaction_date_format': function (val) {
            if (this.header.sprinkle_header_id) {
                return;
            }
            // console.log('transaction_date_format', val)
            if (val == '' || val == 'Invalid date') {
                this.header.blend_no = '';
                this.header.opt = '';
            }
            this.getBlendDetail()
        },
        'header.blend_no': function (val) {
            if (this.header.sprinkle_header_id) {
                return;
            }
            this.header.opt                 = '';
            this.header.batch_id            = '';
            this.header.product_item_id     = '';
            this.header.receipt_uom_code    = '';
            this.header.receipt_quantity    = '';
            this.header.to_locator_code     = '';
            this.header.to_locator_id       = '';
            this.header.to_organization_id  = '';
            this.header.to_subinventory     = '';
            this.header.transfer_status     = '';
            if (val) {
                this.header.batch_id            = this.itemList[val]['batch_id'];
                this.header.product_item_id     = this.itemList[val]['product_item_id'];
                this.header.receipt_uom_code    = this.itemList[val]['uom_code']
                this.header.to_locator_code     = this.itemList[val]['to_locator_code'];
                this.header.to_locator_id       = this.itemList[val]['to_locator_id'];
                this.header.to_organization_id  = this.itemList[val]['to_organization_id'];
                this.header.to_subinventory     = this.itemList[val]['to_subinventory'];
                this.header.transfer_status     = this.itemList[val]['transfer_status'] ?? 1;
            }
        },
    },
    data() {
        return {
            data: false,
            header: false,
            profile: false,
            searchTransactionDateFormat: '',
            transBtn: {},
            transDate: {},
            lines: [],
            blendNoList: [],
            itemList: {},
            onhandList: [],
            checkedAll: false,
            loading: {
                page: false,
                before_mount: false,
                blend_no: false,
            },
            firstLoad: true,
            countOpen: 0,
            validateFrom: {
                blend_no:           { is_valid: true, message: ''},
                opt:                { is_valid: true, message: ''},
                receipt_quantity:   { is_valid: true, message: ''},
                receipt_uom_code:   { is_valid: true, message: ''},
                sprinkle_no:        { is_valid: true, message: ''},
                to_organization_id: { is_valid: true, message: ''},
                to_subinventory:    { is_valid: true, message: ''},
                to_locator_id:      { is_valid: true, message: ''},
                to_locator_code:    { is_valid: true, message: ''},
                transaction_date_format: { is_valid: true, message: ''},
            },
        }
    },
    beforeMount() {
        // console.log('beforeMount');
        this.getInfo();
    },
    mounted() {
        // console.log('wip-requests: Component mounted.');
    },
    methods: {
        async show(header) {
            console.log('show header', header);
            this.getInfo(header.sprinkle_header_id)
        },
        async changeReceiptquantity() {
            let vm = this;
            await vm.assingLot();
        },
        async assingLot() {
            let vm = this;
            let receiptQty = parseInt(vm.header.receipt_quantity ? vm.header.receipt_quantity : 0)

            vm.onhandList.forEach(async function(o) {
                if (parseInt(o.total_onhand_quantity) > receiptQty) {
                    o.can_misc_receipt = true;
                    let remainQty = receiptQty;
                    o.lot_list.forEach(async function(lot) {
                        if (remainQty > 0) {
                            if (remainQty > parseInt(lot.onhand_quantity) || parseInt(lot.onhand_quantity) == remainQty) {
                                lot.issue_quantity = parseInt(lot.onhand_quantity);
                                remainQty = remainQty - lot.issue_quantity;
                            } else if (remainQty < parseInt(lot.onhand_quantity)) {
                                lot.issue_quantity = remainQty;
                                remainQty = 0;
                            }
                        } else {
                            lot.issue_quantity = '';
                        }
                    });
                } else {
                    o.can_misc_receipt = false
                }
            });
        },
        async selectedItem(item) {
            let vm = this;
            let isSelected = item.is_selected;

            vm.onhandList.forEach(async function(o) {
                if (isSelected) {
                    if (item.inventory_item_id == o.inventory_item_id) {
                        o.is_disable = false;
                        o.is_selected = true;
                    } else {
                        o.is_disable = true;
                        o.is_selected = false;
                    }
                } else {
                    o.is_disable = false
                    o.is_selected = false
                }
            })
        },
        async getBlendDetail() {
            let vm = this;
            let response = false;
            // let param = ;

            vm.loading.blend_no = true;
            vm.blendNoList = [];
            vm.itemList = {};

            await axios.get(vm.url.index, {
                    params: {
                        action: 'get-blend-detail',
                        transaction_date_format: vm.header.transaction_date_format
                    }
                }).then(res => {
                response = res.data.data
                vm.blendNoList      = response.data.blend_no_list
                vm.itemList         = response.data.item_list
                vm.loading.blend_no = false;
            });

        },
        async getInfo(sprinkleHeaderId = '') {
            let vm = this;
            let params = {
                sprinkle_header_id: sprinkleHeaderId,
            };
            let response = false;

            vm.loading.page = true;
            vm.loading.before_mount = true;
            vm.lines = [];
            vm.onhandList = [];
            await axios.get(vm.url.index, { params }).then(res => {
                response = res.data.data
                if (response.status == 'S') {
                    response = response.info
                }
                vm.loading.page = false;
            });

            if (response) {
                vm.data = response.data;
                vm.header = response.header;
                vm.profile = response.profile;
                vm.transBtn = response.transBtn;
                vm.transDate = response.transDate;
            }

            vm.loading.before_mount = false;
            // console.log('info success');
            // vm.getLines(false, 'show');

            if (vm.header.sprinkle_header_id) {
                vm.onhandList = _.sortBy(vm.header.lines, function(o) { return o.blend_no; });
            }
        },
        async setdate(date, key) {
            let vm = this;
            vm.header[key] = await moment(date).format(vm.transDate['js-format']);
            // vm.getLines();
        },
        async cancel() {
            let vm = this;

            if (vm.onhandList.length == 0) {
                await helperAlert.showGenericFailureDialog('ไม่พบปริมาณคงคลัง');
                return;
            }
            let confirm = await helperAlert.showProgressConfirm('กรุณายืนยัน ยกเลิกการโรยยาเส้น');

            if (confirm) {
                vm.loading.page = true;
                let lines =  vm.lines;
                await axios.post(vm.url.ajax_cancel, {
                        header: vm.header
                    })
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            setTimeout(async function(){ await vm.getInfo(data.header.sprinkle_header_id); }, 500);
                        }

                        if (data.status != 'S') {
                            swal({
                                title: "Error !",
                                text: data.msg,
                                type: "error",
                                showConfirmButton: true
                            });
                        }
                })
                .catch(err => {
                    let data = err.response.data;
                    alert(data.message);
                })
                .then(() => {
                    vm.loading.page = false;
                });

            }
        },
        async save() {
            let vm = this;

            if (vm.onhandList.length == 0) {
                await helperAlert.showGenericFailureDialog('ไม่พบปริมาณคงคลัง');
                return;
            }

            if (vm.searchTransactionDateFormat != vm.header.transaction_date_format) {
                await helperAlert.showGenericFailureDialog('ข้อมูลการค้นหาไม่ตรงกัน\nกรุณากดแสดผลไหม่');
                return;
            }

            let vaild = await this.validateHeader(true);
            if (!vaild) { return;}

            let receiptQty = parseInt(vm.header.receipt_quantity ? vm.header.receipt_quantity : 0)
            let totalIssue = 0;
            let selectOnhand = [];
            vm.onhandList.forEach(async function(o) {
                if (o.is_selected && !o.is_disable && o.can_misc_receipt) {
                    selectOnhand = o;
                    o.lot_list.forEach(async function(lot) {
                        totalIssue = parseInt(totalIssue) + parseInt(lot.issue_quantity ? lot.issue_quantity : 0);
                    });
                }
            });

            if (receiptQty != totalIssue || receiptQty == 0) {
                // console.log('receiptQty != totalIssue || receiptQty == 0', receiptQty, totalIssue)
                await helperAlert.showGenericFailureDialog('จำนวนที่ต้องการและปริมาณที่นำไปโรยไม่ตรงกัน');
                return;
            }

            let confirm = await helperAlert.showProgressConfirm('กรุณายืนยัน บันทึกใช้ยาเส้น ZoneC48');

            if (confirm) {
                vm.loading.page = true;
                let lines =  vm.lines;
                await axios.post(vm.url.ajax_store, {
                        header: vm.header,
                        select_onhand: selectOnhand
                    })
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            setTimeout(async function(){ await vm.getInfo(data.header.sprinkle_header_id); }, 500);
                        }

                        if (data.status != 'S') {
                            swal({
                                title: "Error !",
                                text: data.msg,
                                type: "error",
                                showConfirmButton: true
                            });
                        }
                })
                .catch(err => {
                    let data = err.response.data;
                    alert(data.message);
                })
                .then(() => {
                    vm.loading.page = false;
                    // swal.close();
                });

            }
        },
        async setData() {
            let vm = this;
            if ((vm.header.transfer_header_id != undefined && vm.header.transfer_header_id != '')) {
                vm.getLines(false, 'show');
            }
            vm.firstLoad = false;
        },
        indexPage() {
            // this.loading.page = true;
            // location.href = this.url.index;
            this.getInfo();
        },
        async getLines(isShowNoti = true, action = 'search') {
            let vm = this;
            let confirm = true;

            // if (isShowNoti) {
            //     confirm = await helperAlert.showProgressConfirm('ค้นหารายการใช้ยาเส้น ZoneC48');
            // }

            if (isShowNoti) {
                let vaild = await this.validateHeader(isShowNoti);
                if (!vaild) { return;}
            }

            if (confirm) {

                vm.loading.page = true;
                vm.searchTransactionDateFormat = vm.header.transaction_date_format;
                vm.lines = [];
                vm.onhandList = {};

                await axios.get(vm.url.ajax_get_lines, {
                        params: {
                            header: vm.header,
                            action: action,
                        }
                    })
                    .then(res => {
                        let data = res.data.data;
                        // console.log('xx', data.lines);
                        // vm.lines = data.lines;
                        vm.onhandList = _.sortBy(data.onhand_list, function(o) { return o.blend_no; })
                        vm.assingLot();
                        // _.sortBy(this.items, function(o) { return o.item_display_name; })
                        // if (res.data.data.status != 'S') {
                        //     swal({
                        //         title: "Error !",
                        //         text: res.data.data.msg,
                        //         type: "error",
                        //         showConfirmButton: true
                        //     });
                        // }
                    })
                    .catch(err => {
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading.page = false;
                    });
            }
            return;
        },
        async validateHeader(isShowNoti = true) {
            let vm = this;
            let vaild = true;
            let message = '';
            await vm.resetValidate();

            if (!vm.header.transaction_date_format || vm.header.transaction_date_format == 'Invalid date') {
                vm.$set(vm.validateFrom, 'transaction_date_format', {
                    is_valid: false,
                    message: 'กรุณากรอกวันที่',
                });
                message = message + '\n' + vm.validateFrom.transaction_date_format.message;
                // await helperAlert.showGenericFailureDialog(vm.validateFrom.transaction_date_format.message);
                vaild = false;
            }

            if (!vm.header.blend_no) {
                vm.$set(vm.validateFrom, 'blend_no', {
                    is_valid: false,
                    message: 'กรุณากรอก Blend No',
                });
                message = message + '\n' + vm.validateFrom.blend_no.message;
                // await helperAlert.showGenericFailureDialog(vm.validateFrom.blend_no.message);
                vaild = false;
            }

            if (!vm.header.opt) {
                vm.$set(vm.validateFrom, 'opt', {
                    is_valid: false,
                    message: 'กรุณากรอก OPT',
                });
                message = message + '\n' + vm.validateFrom.opt.message;
                // await helperAlert.showGenericFailureDialog(vm.validateFrom.opt.message);
                vaild = false;
            }

            if (!vm.header.receipt_quantity) {
                vm.$set(vm.validateFrom, 'receipt_quantity', {
                    is_valid: false,
                    message: 'กรุณากรอก จำนวนที่ต้องการ',
                });
                message = message + '\n' + vm.validateFrom.receipt_quantity.message;
                // await helperAlert.showGenericFailureDialog(vm.validateFrom.receipt_quantity.message);
                vaild = false;
            }

            if (!vm.header.receipt_uom_code) {
                vm.$set(vm.validateFrom, 'receipt_uom_code', {
                    is_valid: false,
                    message: 'กรุณากรอก หน่วยนับ',
                });
                message = message + '\n' + vm.validateFrom.receipt_uom_code.message;
                // await helperAlert.showGenericFailureDialog(vm.validateFrom.receipt_uom_code.message);
                vaild = false;
            }

            if (!vm.header.sprinkle_no) {
                vm.$set(vm.validateFrom, 'sprinkle_no', {
                    is_valid: false,
                    message: 'กรุณากรอก เลขที่เอกสาร',
                });
                message = message + '\n' + vm.validateFrom.sprinkle_no.message;
                // await helperAlert.showGenericFailureDialog(vm.validateFrom.sprinkle_no.message);
                vaild = false;
            }

            if (!vm.header.to_subinventory) {
                vm.$set(vm.validateFrom, 'to_subinventory', {
                    is_valid: false,
                    message: 'กรุณากรอก คลังจัดเก็บ',
                });
                message = message + '\n' + vm.validateFrom.to_subinventory.message;
                // await helperAlert.showGenericFailureDialog(vm.validateFrom.to_subinventory.message);
                vaild = false;
            }

            if (!vm.header.to_locator_id) {
                vm.$set(vm.validateFrom, 'to_locator_code', {
                    is_valid: false,
                    message: 'กรุณากรอก สถานที่จัดเก็บ',
                });
                message = message + '\n' + vm.validateFrom.to_locator_code.message;
                // await helperAlert.showGenericFailureDialog(vm.validateFrom.to_locator_code.message);
                vaild = false;
            }

            if (!vaild) {
                await helperAlert.showGenericFailureDialog(message);
            }

            return vaild;
        },
        async resetValidate(inputName = false) {
            let vm = this;
            let value = { is_valid: true, message: ''};

            if (inputName != '') {
                vm.validateFrom[inputName] = value;
            } else {
                vm.validateFrom.transaction_date_format = value;
                vm.validateFrom.blend_no = value;
                vm.validateFrom.opt = value;
                vm.validateFrom.receipt_quantity = value;
                vm.validateFrom.receipt_uom_code = value;
                vm.validateFrom.sprinkle_no = value;
                vm.validateFrom.to_subinventory = value;
                vm.validateFrom.to_locator_code = value;
            }

            return;
        },
        async setStatus(status) {
            let vm = this;
            let confirm = false;

            let msg = '';
            if (status == 'confirmTransfer') {
                msg = 'กรุณายืนยันการโรยยาเส้น';
            }

            confirm = await helperAlert.showProgressConfirm(msg);

            if (confirm) {
                vm.loading.page = true;
                let url = vm.url.ajax_set_status;
                if (vm.header.sprinkle_header_id != '' && vm.header.sprinkle_header_id != undefined) {
                    url = url.replace("-999", vm.header.sprinkle_header_id)
                }

                await axios.post(url, {
                        sprinkle_header_id: vm.header.sprinkle_header_id
                    })
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            setTimeout(async function(){ await vm.getInfo(data.header.sprinkle_header_id); }, 500);
                        }
                        if (res.data.data.status != 'S') {
                            swal({
                                title: "Error !",
                                text: res.data.data.msg,
                                type: "error",
                                showConfirmButton: true
                            });
                        }
                    })
                    .catch(err => {
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading.page = false;
                    });

            }
        },
    }
}
</script>
