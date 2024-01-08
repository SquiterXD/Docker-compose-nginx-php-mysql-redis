<template>
    <transition
    enter-active-class="animated fadeIn"
    leave-active-class="animated fadeOut">
    <div v-if="!loading.before_mount">
        <!-- <modal-blend-search @selectRow="show" :transDate="transDate"
            :header="header"
            :menu="data.menu"
            :searchInput="data.search_input"
            :transBtn="transBtn" :url="url"
            :countOpen="countOpenBlendModal" />

        <modal-brand-search @selectRow="show" :transDate="transDate"
            :header="header"
            :menu="data.menu"
            :searchInput="data.search_input"
            :transBtn="transBtn" :url="url"
            :countOpen="countOpenBrandModal" /> -->

        <div class="ibox float-e-margins" >
            <div class="ibox-content pb-1" style="border-bottom: 0px;">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9 offset-3 text-right">
                        <button type="button"  @click.prevent="addNewLine()" :class="transBtn.create.class + ' btn-lg tw-w-25'" >
                            <i :class="transBtn.create.icon"></i>
                            เพิ่มรายการ
                        </button>
                        <button  type="button" :class="transBtn.save.class + ' btn-lg tw-w-25'" @click.prevent="save()">
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="ibox-content pb-1" style="border-bottom: 0px;" v-loading="loading.form">
                <div class="table-responsive m-t" v-if="header">
                    <table  class="table text-nowrap table-bordered table-hoverx">
                        <thead>
                            <tr>
                                <th class="text-center align-middle" style="max-width: 120px;">
                                    Item
                                </th>
                                <th rowspan="2" style="max-width: 90px;"></th>
                                <th class="text-center align-middle" style="max-width: 120px;">
                                    คลังทำรายการ
                                </th>
                                <th class="text-center align-middle" style="max-width: 120px;">
                                    คลัง
                                </th>
                                <th class="text-center align-middle">
                                    รายละเอียด Item
                                </th>
                                <th class="text-right align-middle" style="max-width: 120px;">
                                    คงคลัง
                                </th>
                                <th class="text-left align-middle" style="max-width: 95px;">
                                    หน่วยนับ
                                </th>
                                <th class="text-center align-middle" style="max-width: 120px;">
                                    ปริมาณ
                                </th>
                                <th class="text-center align-middle" style="max-width: 95px;">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(line, idx) in header.lines">
                            <tr v-if="line.is_select">
                                <td rowspan="2">
                                    <el-select
                                        class=""
                                        style="width: 100%"
                                        placeholder=""
                                        :disabled="false"
                                        v-model="line.from_inventory_item_id"
                                        @change="(value)=>{
                                            onChgFmInventoryItemId(line, idx)
                                        }"
                                        clearable
                                        filterable
                                        >
                                        <el-option
                                            v-for="item in data.items"
                                            :key="item.value"
                                            :label="item.item_number"
                                            :value="(item.value)">
                                            <span style="float: left">{{ item.label }}</span>
                                        </el-option>
                                    </el-select>
                                </td>
                                <td class="text-right font-weight-bold text-navy" >ต้นทาง</td>
                                <td>
                                    <el-select
                                        class=""
                                        style="width: 100%"
                                        placeholder=""
                                        :disabled="! line.from_inventory_item_id"
                                        v-model="line.from_organization_id"
                                        @change="(value)=>{
                                            onChgFmOrgId(line)
                                        }"
                                        clearable
                                        filterable
                                        >
                                        <el-option
                                            v-for="item in line.fm_org_list"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="(item.value)">
                                            <span style="float: left">{{ item.label }}</span>
                                        </el-option>
                                    </el-select>
                                </td>
                                <td>
                                    <el-select
                                        class=""
                                        style="width: 100%"
                                        placeholder=""
                                        :disabled="! line.from_organization_id"
                                        v-model="line.from_locator_id"
                                        @change="(value)=>{
                                            onChgFmLocatorId(line)
                                        }"
                                        clearable
                                        filterable
                                        >
                                        <el-option
                                            v-for="item in line.fm_locator_list"
                                            :key="item.from_locator_id"
                                            :label="item.from_locator"
                                            :value="(item.from_locator_id)">
                                            <span style="float: left">{{ item.from_locator }}</span>
                                        </el-option>
                                    </el-select>
                                </td>
                                <td>
                                    {{ line.fm_item.from_item_desc }}
                                </td>
                                <td class="text-right">
                                    <div v-if="line.from_inventory_item_id">
                                        {{ line.fm_item.fm_onhand | number2Digit }}
                                    </div>
                                </td>
                                <td class="text-left">
                                    {{ line.fm_item.from_item_uom }}
                                </td>
                                <td class="text-left">
                                    <vue-numeric
                                        :disabled="! line.from_inventory_item_id && ! line.from_locator_id"
                                        placeholder=""
                                        separator=","
                                        v-bind:precision="0"
                                        v-bind:minus="false"
                                        @change="onChgFmTransactionQuantity(line)"
                                        class="form-control w-100 text-right"
                                        v-model="line.fm_transaction_quantity"
                                    ></vue-numeric>
                                </td>
                                <td rowspan="2" class="text-center align-middle">
                                    <button @click.prevent="line.is_select = false" class="btn btn-sm btn-danger">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="line.is_select">
                                <td class="text-right font-weight-bold text-success">ปลายทาง</td>
                                <td>
                                    <el-select
                                        class=""
                                        style="width: 100%"
                                        placeholder=""
                                        :disabled="! line.from_locator_id"
                                        v-model="line.to_organization_id"
                                        @change="(value)=>{
                                            onChgToOrgId(line)
                                        }"
                                        clearable
                                        filterable
                                        >
                                        <el-option
                                            v-for="item in line.to_org_list"
                                            :key="item.to_org_value"
                                            :label="item.to_org_label"
                                            :value="(item.to_org_value)">
                                            <span style="float: left">{{ item.to_org_label }}</span>
                                        </el-option>
                                    </el-select>
                                </td>
                                <td>
                                    <el-select
                                        class=""
                                        style="width: 100%"
                                        placeholder=""
                                        :disabled="!line.to_organization_id"
                                        v-model="line.to_locator_id"
                                        @change="(value)=>{
                                            onChgToLocatorId(line)
                                        }"
                                        clearable
                                        filterable
                                        >
                                        <el-option
                                            v-for="item in line.to_locator_list"
                                            :key="item.to_locator_value"
                                            :label="item.to_locator_label"
                                            :value="(item.to_locator_value)">
                                            <span style="float: left">{{ item.to_locator_label }}</span>
                                        </el-option>
                                    </el-select>
                                </td>
                                <td>
                                    <el-select
                                        class=""
                                        style="width: 100%"
                                        placeholder=""
                                        :disabled="! line.to_locator_id"
                                        v-model="line.to_inventory_item_id"
                                        @change="(value)=>{
                                            onChgToItemId(line)
                                        }"
                                        clearable
                                        filterable
                                        >
                                        <el-option
                                            v-for="item in line.to_item_list"
                                            :key="item.to_item_value"
                                            :label="item.to_item_label"
                                            :value="(item.to_item_value)">
                                            <span style="float: left">{{ item.to_item_label }}</span>
                                        </el-option>
                                    </el-select>
                                </td>
                                <td class="text-right">
                                    <div v-if="line.to_inventory_item_id">
                                        {{ line.fm_item.to_onhand | number2Digit }}
                                    </div>
                                </td>
                                <td class="text-left">
                                    {{ line.to_item.to_item_uom }}
                                </td>
                                <td class="text-left">
                                    <vue-numeric
                                        :disabled="! line.to_inventory_item_id"
                                        placeholder=""
                                        separator=","
                                        v-bind:precision="0"
                                        v-bind:minus="false"
                                        @change="onChgTransactionQuantity(line)"
                                        class="form-control w-100 text-right"
                                        v-model="line.transaction_quantity"
                                    ></vue-numeric>
                                </td>
                            </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </transition>
</template>
<!-- url -->
<script>

import {
    showLoadingDialog,
    showProgressWithUnsavedChangesWarningDialog,
    showValidationFailedDialog,
} from "../../commonDialogs"


import moment from "moment";
import modalCreate from './ModalCreate.vue';
import modalBlendSearch from './ModalBlendSearch.vue';
import modalBrandSearch from './ModalBrandSearch.vue';

import {DateTime} from 'luxon';
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'

export default {

    components: {
        modalCreate, modalBlendSearch, modalBrandSearch
    },
    props:["pUrl"],
    computed: {
        totalQuantity() {
            if (this.header) {
                let sum =  _.sumBy(this.header.lines, function(o) { return parseFloat(o.quantity); });
                return sum
            } else {
                return 0;
            }
        },
        totalAdjustQuantity() {
            if (this.header) {
                let sum =  _.sumBy(this.header.lines, function(o) { return parseFloat(o.adjust_quantity); });
                return sum
            } else {
                return 0;
            }
        }
    },
    watch:{
        // selTabName : async function (val, oldVal) {
        //     console.log('selTabName', val, oldVal);

        //     this.changeTab(val, oldVal);

    },
    data() {
        return {
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,
            luxon: {
                DateTime,
            },

            url: this.pUrl,
            data: false,
            header: false,
            profile: false,
            fmItem: false,




            transBtn: {},
            transDate: {},
            loading: {
                page: false,
                before_mount: false,
                search: false,
                lines: false,
                form: false,
            },
            countOpenBlendModal: 0,
            countOpenBrandModal: 0,
            inputParams: {
                tobacco_type_desc_list: [],
                category_code_1_list: [],
                category_code_2_list: [],
                item_id_list: [],
                lot_number_list: [],
                instead_item_id_list: [],
                instead_lot_number_list: [],
                lines_list: [],
            },
            form: {
                tobacco_type_desc: null,
                category_code_1: null,
                category_code_2: null,
                item_id: null,
                lot_number: null,
                instead_item_id: null,
                instead_lot_number: null,
                approved_date: null,
            },
        }
    },
    beforeMount() {
        console.log('beforeMount');
        this.getInfo(false);
    },
    mounted() {
        console.log('Component mounted.')

        // this.setData();
    },
    methods: {
        async addNewLine() {
            let vm = this;
            let row = vm.header.lines.length;
            let newLine = await _.clone(vm.data.new_line);
            vm.$set(vm.header.lines, row, newLine);
        },
        async onChgFmInventoryItemId(line, idx) {
            let vm = this;
            let fmItem = '';

            let hasDup = false;
            vm.header.lines.forEach(async (o, i)  => {
                if (o.from_inventory_item_id == line.from_inventory_item_id && idx != i) {
                    hasDup = true;
                }
            });

            if (hasDup) {
                await helperAlert.showGenericFailureDialog('ไม่สามารถเลือก Item ซ้ำได้');
                line.from_inventory_item_id = '';
                return;
            }

            line.fm_item = {};
            line.fm_org_selected = {};

            line.fm_org_list = [];
            line.fm_subinv_list = [];
            line.fm_locator_list = [];
            line.to_org_list = [];




            line.from_locator_id_list = [];
            line.to_organization_id_list = [];
            line.to_subinv_list = [];
            line.to_locator_id_list = [];
            line.to_inventory_item_id_list = [];

            if ((line.from_inventory_item_id != '' && line.from_inventory_item_id != null) &&
                vm.data.items.length > 0
            ) {
                let fmItem = vm.data.fm_org.findIndex(o => o.from_inventory_item_id == line.from_inventory_item_id);
                    fmItem = vm.data.fm_org[fmItem];
                line.fm_item = fmItem;


                // ต้นทาง คลังทำรายการ
                // line.fm_org_list = vm.data.fm_org.filter(o => o.from_inventory_item_id == line.from_inventory_item_id);
                line.fm_org_list = vm.data.fm_org.filter((thing, i, arr) => {
                  return arr.indexOf(arr.find(t => t.from_inventory_item_id === thing.from_inventory_item_id)) === i;
                });
                if (line.fm_org_list.length == 1) {
                    line.from_organization_id = line.fm_org_list[0].from_organization_id;
                    vm.onChgFmOrgId(line);
                }
            }


            if(line.from_inventory_item_id == '' || line.from_inventory_item_id == null) {
                line.to_item = {};
                line.from_organization_id = '';
                line.from_subinv = '';
                line.from_locator_id = '';

                line.to_organization_id = '';
                line.to_subinv = '';
                line.to_locator_id = '';
                line.to_inventory_item_id = '';
                line.fm_transaction_quantity = '';
                line.transaction_quantity = '';
            }
        },
        async onChgFmOrgId(line) {
            let vm = this;

            if (line.from_organization_id) {

                // แสดง ต้นทาง Locator
                // line.fm_locator_list = await vm.data.fm_org.filter(function(o) {
                //     return o.from_inventory_item_id == line.from_inventory_item_id &&
                //             o.from_organization_id == line.from_organization_id
                // })
                line.fm_locator_list = vm.data.fm_org.filter((thing, i, arr) => {
                  return arr.indexOf(
                        arr.find(t => t.from_inventory_item_id === thing.from_inventory_item_id &&
                            t.from_organization_id == thing.from_organization_id
                        )
                    ) === i;
                });
                if (line.fm_locator_list.length == 1) {
                    line.from_locator_id = line.fm_locator_list[0].from_locator_id;
                    vm.onChgFmLocatorId(line);
                }
            } else {
                line.to_item = {};

                line.from_subinv = '';
                line.from_locator_id = '';
                line.to_organization_id = '';
                line.to_subinv = '';
                line.to_locator_id = '';
                line.to_inventory_item_id = '';
                line.fm_transaction_quantity = '';
                line.transaction_quantity = '';
            }
        },
        async onChgFmLocatorId(line) {
            let vm = this;

            if (line.from_locator_id) {
                line.to_org_list = await line.fm_locator_list.filter(function(o) {
                    return o.from_locator_id && line.from_locator_id
                })

                // ต้นทาง คลังทำรายการ
                if (line.to_org_list.length == 1) {
                    line.to_organization_id = line.to_org_list[0].to_organization_id;
                    vm.onChgToOrgId(line);
                }
            } else {
                line.to_item = {};
                line.to_organization_id = '';
                line.to_subinv = '';
                line.to_locator_id = '';
                line.to_inventory_item_id = '';
                line.fm_transaction_quantity = '';
                line.transaction_quantity = '';
            }
        },
        async onChgToOrgId(line) { //คลังทำรายการ
            let vm = this;
            if (line.to_organization_id) {

                // ปลายทาง  Locator
                line.to_locator_list = await line.to_org_list.filter(function(o) {
                    return o.to_organization_id && line.to_organization_id
                })
                if (line.to_locator_list.length == 1) {
                    line.to_locator_id = line.to_locator_list[0].to_locator_id;
                    vm.onChgToLocatorId(line);
                }
            } else {
                line.to_item = {};
                line.to_locator_id = '';
                line.to_inventory_item_id = '';
                line.fm_transaction_quantity = '';
                line.transaction_quantity = '';
            }
        },
        async onChgToLocatorId(line) {
            let vm = this;
            if (line.to_locator_id) {

                line.to_item_list = await line.fm_locator_list.filter(function(o) {
                    return o.to_organization_id && line.to_organization_id
                })
                // ปลายทาง Item
                if (line.to_item_list.length == 1) {
                    line.to_inventory_item_id = line.to_item_list[0].to_inventory_item_id;
                    vm.onChgToItemId(line);
                }
            } else {
                line.to_item = {};
                line.to_inventory_item_id = '';
                line.fm_transaction_quantity = '';
                line.transaction_quantity = '';
            }
        },
        async onChgToItemId(line) {
            let vm = this;
            if (line.to_inventory_item_id) {
                let toItem = line.to_item_list.findIndex(o => o.to_inventory_item_id == line.to_inventory_item_id);
                    toItem = line.to_item_list[toItem];
                line.to_item = toItem;
            } else {
                line.to_item = {};
                line.to_inventory_item_id = '';
                line.fm_transaction_quantity = '';
                line.transaction_quantity = '';
            }
        },
        async onChgFmTransactionQuantity(line) {
            let message = '';
            console.log('onChgFmTransactionQuantity ---------->1'
                , parseFloat(line.fm_transaction_quantity) % parseFloat(line.to_item.conversion_rate)
                , parseFloat(line.fm_transaction_quantity),  parseFloat(line.to_item.conversion_rate)
            );

            console.log('onChgFmTransactionQuantity ---------->'
                , parseFloat(line.fm_transaction_quantity).toFixed(0) > parseFloat(line.fm_item.fm_onhand).toFixed(0)
                , parseFloat(line.fm_transaction_quantity).toFixed(0),  parseFloat(line.fm_item.fm_onhand).toFixed(0)
            );

            if (( parseFloat(line.fm_transaction_quantity) % parseFloat(line.to_item.conversion_rate) ) != 0) {
                message = `โปรดระบุปริมาณที่แปลงให้เป็นจำนวนเต็ม`;
                await helperAlert.showGenericFailureDialog(message);
                line.fm_transaction_quantity = '';
                line.transaction_quantity = '';
                return;
            }

            if (parseFloat(line.fm_transaction_quantity).toFixed(0) > parseFloat(line.fm_item.fm_onhand).toFixed(0)) {
                message = `โปรดระบุปริมาณน้อยกว่าจำนวนคงคลัง`;
                await helperAlert.showGenericFailureDialog(message);
                line.fm_transaction_quantity  = parseFloat(line.fm_item.fm_onhand);
                return;
            }
            line.transaction_quantity = parseFloat(line.fm_transaction_quantity) / parseFloat(line.to_item.conversion_rate);
        },
        async onChgTransactionQuantity(line) {
            let message = '';
            line.fm_transaction_quantity = '';
            console.log('onChgTransactionQuantity ---------->1'
                , (parseFloat(line.transaction_quantity) * parseFloat(line.to_item.conversion_rate)) > parseFloat(line.fm_item.fm_onhand)
                , (parseFloat(line.transaction_quantity) * parseFloat(line.to_item.conversion_rate)), parseFloat(line.fm_item.fm_onhand)
            );

            if ((parseFloat(line.transaction_quantity) * parseFloat(line.to_item.conversion_rate)) > parseFloat(line.fm_item.fm_onhand) ) {
                message = `โปรดระบุปริมาณน้อยกว่าจำนวนคงคลัง`;
                await helperAlert.showGenericFailureDialog(message);
                line.transaction_quantity  = '';
                return;
            }
        },

        async save(isShowNoti = true) {
            let vm = this;
            let confirm = true;
            let valid = true;
            let message = '';


            // let lines = vm.header.lines.filter(o => o.is_select == true);
            let lines = JSON.parse(JSON.stringify(vm.header.lines));
                lines = lines.filter(o => o.is_select == true);
            if (lines.length == 0) {
                message = `โปรดเพิ่มรายการ อย่างน้อย 1 รายการ`;
                await helperAlert.showGenericFailureDialog(message);
                return;
            }

            lines.forEach(async (o, i)  => {
                // reset ข้อมูล
                o.fm_item = '';
                o.fm_org_list = '';
                o.fm_locator_list = '';
                o.to_org_list = '';
                o.to_locator_list = '';
                o.to_item_list = '';
            });


            // confirm = await helperAlert.showProgressConfirm('กรุณายืนยันบันทึกแทนเกรดใบยา');
            if (confirm) {
                // vm.loading.page = true;
                // let lines =  vm.lines;
                // let lines =  vm.lines.filter(o => o.is_selected == true);
                vm.loading.form = true;
                await axios.post(vm.pUrl.ajax_store, {lines: lines})
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            vm.hasChange = false;
                            // vm.header = data.header;
                            swal({
                                title: '&nbsp;',
                                text: 'บันทึกข้อมูลสำเร็จ',
                                type: "success",
                                html: true
                            });
                            // setTimeout(async function(){ await vm.getInfo(data.header.h_adj_sale_for_id); }, 500);
                            vm.header.lines = [];
                            location.reload();
                        }

                        if (data.status != 'S') {
                            swal({
                                title: "Error !",
                                text: data.msg,
                                type: "error",
                                showConfirmButton: true
                            });
                        }
                        vm.loading.form = false;
                })
                .catch(err => {
                    let data = err.response.data;
                    // alert(data.message);
                    swal({
                        title: "Error !",
                        text: data.message,
                        type: "error",
                        showConfirmButton: true
                    });
                    vm.loading.form = false;
                })
                .then(() => {
                    // swal.close();
                });
                // vm.loading.page = false;

            }
        },



        // from_organization_id_list
        // from_subinv_list
        // from_locator_id_list
        // to_organization_id_list
        // to_subinv_list
        // to_locator_id_list
        // to_inventory_item_id_list




        async getInfo(hWebId = '') {
            let vm = this;

            let params = {
                // h_adj_sale_for_id: hWebId,
            };

            let response = false;
            vm.loading.page = true;
            vm.loading.before_mount = true;
            // vm.selTabName = 'tab1';
            await axios.get(vm.url.index, { params }).then(res => {
                response = res.data.data
                console.log('getInfo', response);
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
                vm.url = response.url;
                // vm.header.blend_no = '369'
            }

            vm.loading.before_mount = false;
            // vm.getParam();
            vm.addNewLine();
        }
    }
}
</script>
