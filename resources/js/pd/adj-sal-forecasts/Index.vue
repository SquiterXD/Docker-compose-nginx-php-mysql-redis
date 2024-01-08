<template>
    <transition
    enter-active-class="animated fadeIn"
    leave-active-class="animated fadeOut">
    <div v-if="!loading.before_mount">
        <modal-search @selectRow="show" :transDate="transDate"
            :header="header"
            :menu="data.menu"
            :searchInput="data.search_input"
            :transBtn="transBtn" :url="url"
            :countOpen="countOpenModal" />


        <div class="ibox float-e-margins" >
            <div class="ibox-content pb-1" style="border-bottom: 0px;">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9 offset-3 text-right">
                        <modal-create v-if="data" @selectRow="show"
                            class="pr-2"
                            :btnTrans="transBtn"
                            :menu="data.menu"
                            :url="url"
                            :createInput="data.create_input"
                         />

                        <button :class="transBtn.search.class + ' btn-lg tw-w-25 mr-2'"
                            @click.prevent="countOpenModal += 1" >
                            <i :class="transBtn.search.icon"></i>
                            {{ transBtn.search.text }}
                        </button>

                        <button  type="button"  :class="transBtn.save.class + ' btn-lg tw-w-25'"
                            :disabled="!header.can.edit || (header.h_adj_sale_for_id == '' || header.h_adj_sale_for_id == undefined)"
                            @click.prevent="save()">
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>
                        <button :class="transBtn.copy.class + ' btn-lg tw-w-25 mr-2'"
                            :disabled="(header.h_adj_sale_for_id == '' || header.h_adj_sale_for_id == undefined)"
                            @click.prevent="duplicateAdj()" >
                            <i :class="transBtn.copy.icon"></i>
                            {{ transBtn.copy.text }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="ibox-content" >
                <div class="row">
                    <div class="col-5">
                        <!-- <dl class="row mb-1">
                            <div class="col-sm-2 col-form-label text-sm-right">
                                <dt>ปีงบประมาณอนุมัติ:</dt>
                            </div>
                            <div class="col-sm-1 col-form-label text-sm-left">
                                <dd class="mb-1">
                                    <div v-if="header">{{ header.budget_year_version }}</div>
                                </dd>
                            </div>
                            <div class="col-sm-5 pl-0 col-form-label text-sm-right">
                                <dt>ปีงบประมาณการจำหน่าย(ฝ่ายขาย):</dt>
                            </div>
                            <div class="col-sm-1 col-form-label text-sm-left">
                                <dd class="mb-1">
                                    <div v-if="header && parseInt(header.budget_year)">{{ parseInt(header.budget_year) + 543 }}</div>
                                </dd>
                            </div>

                            <div class="col-sm-2 pl-0 col-form-label text-sm-right">
                                <dt>ปรับครั้งที่:</dt>
                            </div>
                            <div class="col-sm-1 col-form-label text-sm-left">
                                <dd class="mb-1">
                                    <div v-if="header">{{ header.version_no }}</div>
                                </dd>
                            </div>
                        </dl> -->
                        <dl class="row mb-1">
                            <div class="col-sm-5 col-form-label text-sm-right">
                                <dt>ปีงบประมาณอนุมัติ:</dt>
                            </div>
                            <div class="col-sm-2 col-form-label text-sm-left">
                                <dd class="mb-1">
                                    <div v-if="header">{{ header.budget_year_version }}</div>
                                </dd>
                            </div>

                            <div class="col-sm-3 pl-0 col-form-label text-sm-right">
                                <dt>ปรับครั้งที่:</dt>
                            </div>
                            <div class="col-sm-2 col-form-label text-sm-left">
                                <dd class="mb-1">
                                    <div v-if="header">{{ header.version_no }}</div>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-1">
                            <div class="col-sm-5 pl-0 col-form-label text-sm-right">
                                <dt>ปีงบประมาณการจำหน่าย(ฝ่ายขาย):</dt>
                            </div>
                            <div class="col-sm-2 col-form-label text-sm-left">
                                <dd class="mb-1">
                                    <div v-if="header && parseInt(header.budget_year)">{{ parseInt(header.budget_year) + 543 }}</div>
                                </dd>
                            </div>
                        </dl>
                    </div>
                    <div class="col-7">
                        <dl class="row mb-1">
                            <div class="col-sm-2 pl-0 col-form-label text-sm-right">
                                <dt>ปรับเปลี่ยน:</dt>
                            </div>
                            <div class="col-sm-3 text-sm-left">
                                <dd class="mb-1">
                                    <div class="input-group m-b">
                                    <input v-if="header"
                                        :disabled="!header.can.edit || header.h_adj_sale_for_id == undefined"
                                        @change="changeAdjustQuantity()"
                                        max="100" min="0" type="number"
                                        class="form-control text-right"
                                        v-model="header.adjust_percent">
                                    <input v-else type="text" disabled class="form-control" >
                                    <div class="input-group-append">
                                        <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                </dd>
                            </div>
                            <div class="col-sm-2 pl-0 col-form-label text-sm-right">
                                <dt>ปรับยอดรวม:</dt>
                            </div>
                            <div class="col-sm-3 text-sm-left">
                                <dd class="mb-1">
                                    <div class="input-group m-b">
                                    <input v-if="header"
                                        :disabled="!header.can.edit || header.h_adj_sale_for_id == undefined"
                                        @change="changeAdjustTotalQuantity()"
                                        max="100" min="0" type="number"
                                        class="form-control text-right"
                                        v-model="header.total_adjust_quantity">
                                    <input v-else type="text" disabled class="form-control" >
                                    <div class="input-group-append">
                                        <span class="input-group-addon">ล้านมวน</span>
                                        </div>
                                    </div>
                                </dd>
                            </div>

                            <div class="col-sm-2 align-middle">
                                <button class="btn btn-success btn-block btn-sm  btn-outline"
                                    :disabled="!header.can.edit || header.h_adj_sale_for_id == undefined"
                                    @click="addNewLine()" style="margin-top: 2px;">
                                    <i class="fa fa-plus"></i>
                                    เพิ่มรายการ
                                </button>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="table-responsive m-t" >
                    <table  class="table text-nowrap table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="200px;" class="text-center">รหัสบุหรี่</th>
                                <th>ตราบุหรี่</th>
                                <th width="300px;" class="text-center">ประมาณการจำหน่าย<br>ทั้งปีงบประมาณ(ล้านมวน)</th>
                                <th width="300px;" class="text-center">ประมาณการจำหน่าย<br>หลังปรับเปลี่ยน(ล้านมวน)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(line, i) in header.lines" v-if="header.lines.length > 0">
                                <td>
                                    <div v-if="line.l_adj_sale_for_id">
                                        {{ line.item_code }}
                                    </div>
                                    <el-select v-else :ref="'input-item-'+i"
                                        style="width:100%"
                                        v-model="line.item_id"
                                        clearable
                                        filterable
                                        placeholder="รหัสบุหรี่"
                                        @change="selectItemId(line, i)"
                                    >
                                        <el-option
                                            v-for="(lot, index) in line.item_list"
                                            :key="lot.value"
                                            :label="lot.label"
                                            :value="lot.value"
                                        ></el-option>
                                    </el-select>
                                </td>
                                <td>{{ line.item_description }}</td>
                                <td class="text-right">{{ line.quantity | number3Digit }}</td>
                                <td class="text-right">
                                    <!-- <input type="number" v-if="header.can.edit"
                                        class="form-control text-right"
                                        oninput="validity.valid||(value='');"
                                        @change="changeAdjustQuantity(line)"
                                        v-model.number="line.adjust_quantity"> -->

                                        <vue-numeric v-if="header.can.edit"
                                            separator=","
                                            v-bind:precision="3"
                                            v-bind:minus="false"
                                            class="form-control input-sm text-right"
                                            v-model="line.adjust_quantity"
                                            ></vue-numeric>
                                    <div v-else>
                                        {{ line.adjust_quantity | number3Digit }}
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="header.lines.length == 0">
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr >
                                <th colspan="2" class="text-right">
                                    <strong>รวม</strong>
                                </th>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    <!-- {{ totalQuantity | number3Digit }} -->
                                    {{ header.sum_quantity | number3Digit }}

                                </th>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    {{ parseFloat(totalAdjustQuantity) | number3Digit }}
                                </th>
                            </tr>
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


import VueNumeric from 'vue-numeric'
import moment from "moment";
import modalCreate from './ModalCreate.vue';
import modalSearch from './ModalSearch.vue';


export default {

    components: {
        modalCreate, modalSearch
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
            url: this.pUrl,
            data: false,
            header: false,
            profile: false,
            transBtn: {},
            transDate: {},
            loading: {
                page: false,
                before_mount: false,
            },
            countOpenModal: 0,
        }
    },
    beforeMount() {
        console.log('beforeMount');
        this.getInfo();
    },
    mounted() {
        console.log('Component mounted.')
        // this.setData();
        // this.getInfo(196);
    },
    methods: {

        // adjust_quantity:88.55000000000001
        // h_adj_sale_for_id:"126"
        // item_code:"15012352"
        // item_description:"KRONG THIP 7.1 S (ซองแดง)"
        // l_adj_sale_for_id:12675
        // quantity:"80.5"
        async addNewLine() {
            let vm = this;
            let row = vm.header.lines.length;
            let newLine =  {
                adjust_quantity: 0,
                h_adj_sale_for_id: vm.header.h_adj_sale_for_id,
                item_id: '',
                item_code: '',
                item_description: '',
                l_adj_sale_for_id: '',
                quantity: 0,
                org_id: '',
                item_list: JSON.parse(JSON.stringify(vm.data.item_list)),
            }
            await vm.$set(vm.header.lines, row, newLine);

            // this.$nextTick(() => {
            //     const input = this.$refs['input-item-'+row][0];
            //     input.focus();
            // });
        },
        async selectItemId(line, index) {
            let vm = this;
            let selectItem = line.item_list.findIndex(o => o.value == line.item_id);
                selectItem = line.item_list[selectItem];

            // console.log('selectItem ', selectItem);
            let checkDup = await vm.header.lines.filter(function(o, idx) {
                return idx != index && o.item_code == selectItem.inventory_item_code;
            });

            // console.log('checkDup', checkDup);
            if (checkDup.length) {
                swal({
                    title: "แจ้งเตือน",
                    text: 'ไม่สามารถเลือก รหัสบุหรี่: '+  selectItem.inventory_item_code + ' ซ้ำได้',
                    type: "warning",
                    showConfirmButton: true
                });
                line.org_id =  '';
                line.item_id =  '';
                line.item_code =  '';
                line.item_description =  '';
                return;
            }

            line.org_id = selectItem.organization_id;
            line.item_code = selectItem.inventory_item_code;
            line.item_description = selectItem.description;
        },
        async show(header) {
            console.log('show header', header);
            this.loading.before_mount = false;
            this.getInfo(header.h_adj_sale_for_id);
        },
        async setdate(date, key) {
            let vm = this;
            vm.header[key] = await moment(date).format(vm.transDate['js-format']);
            vm.getLines();
        },
        async changeAdjustQuantity(line = false) {
            let vm = this;
            let adjustPercent = parseFloat(vm.header.adjust_percent);
            vm.header.total_adjust_quantity = '';
            if (adjustPercent > 100 || adjustPercent < 0 || (vm.header.adjust_percent == '' || vm.header.adjust_percent == null )) {
                vm.header.adjust_percent = ''
                for (let i in vm.header.lines) {
                    vm.header.lines[i]['adjust_quantity'] = parseFloat(vm.header.lines[i]['quantity']);
                }
                return;
            }

            if (line) {

            } else {
                for (let i in vm.header.lines) {
                    if (parseFloat(adjustPercent)) {
                        let calQuantity = parseFloat(vm.header.lines[i]['quantity']) * ((100 + parseFloat(adjustPercent)) / 100 );
                        vm.header.lines[i]['adjust_quantity'] = calQuantity;
                    } else {
                        vm.header.lines[i]['adjust_quantity'] = 0;
                    }
                }
            }
        },
        async changeAdjustTotalQuantity() {
            let vm = this;
            let sumQuantity = parseFloat(vm.header.sum_quantity);
            let totalAdjustQuantity = parseFloat(vm.header.total_adjust_quantity);
            vm.header.adjust_percent = '';
            for (let i in vm.header.lines) {
                if (vm.header.lines[i].l_adj_sale_for_id != '') {
                    let qty = parseFloat(vm.header.lines[i].quantity);
                    if (vm.header.total_adjust_quantity == '' || vm.header.total_adjust_quantity == null) {
                        vm.header.lines[i]['adjust_quantity'] = qty;
                    } else {
                        if (sumQuantity && qty) {
                            let proportion = qty / sumQuantity;
                            let calQuantity = proportion * parseFloat(vm.header.total_adjust_quantity);
                            vm.header.lines[i]['adjust_quantity'] = calQuantity;
                        }
                    }
                }
            }
            return;
        },
        async changeStatus() {
            // if (this.header.formula_status.toUpperCase() == 'INACTIVE') {
            //     this.isActive = true;
            // } else {
            //     this.isActive = false;
            // }

            // this.header.can.edit = (this.isActive == true);
            // this.header.can.edit = true;
        },
        async getInfo(hWebId = '') {
            let vm = this;

            let params = {
                h_adj_sale_for_id: hWebId,
            };

            let response = false;
            vm.loading.page = true;
            vm.loading.before_mount = true;
            // vm.selTabName = 'tab1';
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
                vm.url = response.url;
                // vm.header.blend_no = '369'
                vm.header.total_adjust_quantity = '';
            }

            vm.loading.before_mount = false;
        },
        async save(isShowNoti = true) {
            let vm = this;
            let confirm = true;
            let valid = true;
            let message = '';



            confirm = await helperAlert.showProgressConfirm('กรุณายืนยันปรับประมาณการจำหน่าย');

            if (confirm) {
                vm.loading.page = true;
                // let lines =  vm.lines;
                // let lines =  vm.lines.filter(o => o.is_selected == true);
                await axios.post(vm.url.ajax_update, {
                        header: vm.header
                    })
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
                            setTimeout(async function(){ await vm.getInfo(data.header.h_adj_sale_for_id); }, 500);
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
                    // alert(data.message);
                    swal({
                        title: "Error !",
                        text: data.message,
                        type: "error",
                        showConfirmButton: true
                    });
                })
                .then(() => {
                    vm.loading.page = false;
                    // swal.close();
                });

            }
        },
        async duplicateAdj() {
            let vm = this;
            let confirm = true;
            let valid = true;
            let message = '';
            confirm = await helperAlert.showProgressConfirm('กรุณายืนยันคัดลอกปรับประมาณการจำหน่าย');

            if (confirm) {
                await axios.post(vm.url.ajax_duplicate, {
                        header: vm.header
                    })
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            vm.hasChange = false;
                            // vm.header = data.header;
                            swal({
                                title: '&nbsp;',
                                text: 'คัดลอกมูลสำเร็จ',
                                type: "success",
                                html: true
                            });
                            setTimeout(async function(){ await vm.getInfo(data.header.h_adj_sale_for_id); }, 500);
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
                    // alert(data.message);
                    swal({
                        title: "Error !",
                        text: data.message,
                        type: "error",
                        showConfirmButton: true
                    });
                })
                .then(() => {
                    vm.loading.page = false;
                    // swal.close();
                });

            }
        }

    }
}
</script>
