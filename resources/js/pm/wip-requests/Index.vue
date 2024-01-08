<template>
    <div>
        <div class="ibox float-e-margins" v-loading="loading.page">
            <div class="ibox-content" v-if="!loading.before_mount" >
                <div class="row">
                    <!-- <div class="col-3">
                        <h3 class="no-margins"> โอนสินค้าสำเร็จรูป </h3>
                    </div> -->
                    <div class="col-12 text-right">
                        <button :class="transBtn.search.class + ' btn-lg tw-w-25 '"
                           @click="countOpen += 1" >
                            <i :class="transBtn.search.icon"></i>
                            {{ transBtn.search.text }}
                        </button>

                        <button :class="transBtn.create.class + ' btn-lg tw-w-25 mr-2'"
                            @click.prevent="indexPage" >
                            <i :class="transBtn.create.icon"></i>
                            {{ transBtn.create.text }}
                        </button>
                         <button :class="transBtn.save.class + ' btn-lg tw-w-25'"
                            :disabled="!header.can.edit"
                            @click.prevent="save">
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>
                        <button
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
                            :disabled="!header.can.cancel_doc"
                            @click.prevent="setStatus('cancelTransfer')">
                            <i class="fa fa-times"></i> ยกเลิกเอกสาร
                        </button>
                    </div>
                </div>
            </div>
            <div class="ibox-content" v-if="!loading.before_mount" style="border-top: 0px;">
                <modal-search @selectWipRequestHeader="show" :transDate="transDate"
                    :transBtn="transBtn" :url="url"
                    :countOpen="countOpen" />
                <div class="form-group mb-0">
                    <div class="row m-2">
                        <div class="col-lg-2">หน่วยงาน</div>
                        <div class="col-lg-4">
                            <el-input
                                class="w-100"
                                disabled
                                :value="(()=>{
                                    if(profile.department){
                                        return profile.department.description
                                    }
                                    return null
                                })()"
                            ></el-input>
                        </div>
                        <div class="col-lg-2">เลขที่เอกสาร</div>
                        <div class="col-lg-4">
                            <el-input
                                class="w-100"
                                :value="header.wip_request_no"
                                disabled
                            ></el-input>
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="col-lg-2">วันที่ได้ผลผลิต</div>
                        <div class="col-lg-4">
                            <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="input_date"
                                id="input_date"
                                :disabled="!header.can.edit"
                                placeholder="โปรดเลือกวันที่"
                                :value="header.transaction_date_format"
                                :format="transDate['js-format']"
                                @dateWasSelected="setdate(...arguments, 'transaction_date_format')"
                                />
                        </div>
                        <div class="col-lg-2">สถานะบันทึกผลผลิตเข้าคลัง</div>
                        <div class="col-lg-4">
                            <el-input
                                class="w-100"
                                disabled
                                :value="(()=>{
                                    if(header.wip_request_status && header.wip_req_header_id){
                                        let result = data.request_status_list.find(o => o.lookup_code == header.wip_request_status)
                                        if(result){
                                            return result.description
                                        }
                                    }
                                    return null
                                })()"
                            ></el-input>
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="col-lg-12 text-right">
                            <button :class="transBtn.search.class + ' btn-lg tw-w-25'"
                                @click.prevent="getLines(false, 'show')" >
                                <i :class="transBtn.search.icon"></i>
                                แสดงข้อมูล
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ibox float-e-margins"
            v-if="!loading.before_mount"
            v-loading="loading.page">
            <div class="ibox-content" v-if="searchTransactionDateFormat != ''">
                <!-- <div class="row">
                    <div class="col-12">
                        วันที่ค้นหาเลขที่คำสั่งผลิต: {{ searchTransactionDateFormat }}
                    </div>
                </div> -->

                <div class="table-responsive m-t">
                    <table class="table text-nowrap-x table-hoverx table-bordered" v-if="searchTransactionDateFormat == header.transaction_date_format">
                        <thead>
                            <tr>
                                <th width="10px;" class="text-center">
                                    เลือกทั้งหมด<br>
                                    <input :disabled="lines.length && lines[0].is_disable" type="checkbox" v-model="checkedAll">
                                </th>
                                <th width="130px;">
                                    เลขที่คำสั่งผลิต
                                </th>
                                <th width="150px;">
                                    รหัสสินค้าสำเร็จรูป
                                </th>
                                <th >รายละเอียด</th>
                                <th width="100px;" class="text-center">
                                    OPT
                                </th>
                                <th width="100px;" class="text-right">
                                    คลังสินค้า
                                </th>
                                <th width="100px;" class="text-right">
                                    สถานที่จัดเก็บ
                                </th>
                                <th width="100px;" class="text-right">
                                    Lot No.
                                </th>
                                <!-- <th width="130px;" class="text-center">
                                    จำนวนผลผลิต
                                </th> -->
                                <!-- <th width="130px;" class="text-center">
                                    จำนวนที่<br>ส่งผลผลิตไปแล้ว
                                </th> -->
                                <th width="230px;" class="text-center">
                                    จำนวนส่งเข้าคลัง
                                </th>
                                <th width="100px;" class="text-center">
                                    หน่วยนับ
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(line, i) in lines" v-if="lines.length">
                                <tr>
                                    <td :date="i" class="align-middle text-center">
                                        <i class="fa fa-warning fa-2x text-warning" v-if="!line.cost_valid" ></i>
                                        <input v-else :disabled="line.is_disable"
                                        type="checkbox" v-model="line.is_selected">
                                    </td>
                                    <td :date="i" class="align-middle text-left">
                                        <strong>{{ line.batch_no }}</strong>
                                    </td>
                                    <td  class="align-middle">
                                        {{ line.item_number }}
                                    </td>
                                    <td class="align-middle">
                                        {{ line.item_desc }}
                                        <div v-if="!line.cost_valid" class="text-danger">
                                            <strong>{{ line.cost_validate_msg }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ line.opt }}
                                    </td>
                                    <td class="text-right align-middle">
                                        {{ line.subinventory_from }}
                                    </td>
                                    <td class="text-right align-middle" :title="line.locator_code_from">
                                        {{ line.location_code_from }}
                                    </td>
                                    <td class="text-right align-middle">
                                        {{ line.lot_number }}
                                    </td>
                                    <!-- <td class="text-right">
                                        {{ line.wip_completed_qty }}
                                    </td> -->
                                    <!-- <td class="text-right">
                                        {{ line.confirm_qty }}
                                    </td> -->
                                    <td class="text-right align-middle">
                                         <input class="form-control text-right align-middle"
                                            type="text"
                                            :value="line.transaction_quantity | number2Digit"
                                            :disabled="true"
                                            />
                                            <!-- v-model.number=" " -->

                                        <!-- <input class="form-control text-right"
                                            type="number"
                                            min="0"
                                            :max="line.confirm_qty - line.wip_completed_qty"
                                            v-model.number="line.transaction_quantity"
                                            :disabled="true || !header.can.edit || (line.confirm_qty == line.wip_completed_qty)"
                                            /> -->
                                    </td>
                                    <td class="text-center align-middle" :title="line.transaction_uom">
                                        {{ line.primary_unit_of_measure }}
                                    </td>
                                </tr>
                                <tr v-if="line.is_selected && line.is_convert_flag">
                                    <td colspan="10">
                                        <h3 v-if="!line.convert_info.valid" class="no-margins text-danger text-center">
                                            {{ line.item_number }} : {{ line.convert_info.msg }}
                                            <div></div>
                                        </h3>
                                        <div v-else class=" mb-0 col-lg-8 col-md-6 col-sm-6 col-xs-6 offset-md-2 mt-2">
                                            <table class="table text-nowrapx table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Item ปลายทาง</th>
                                                        <th style="width: 130px;" class="text-right">แปลงหน่วย</th>
                                                        <th style="width: 130px;" class="text-center">หน่วนนับ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(convert, i) in line.convert_info.lines">
                                                        <td class="align-middle">
                                                            <i class="fa fa-warning fa-2x text-warning" v-if="!convert.cost_valid" ></i>
                                                            {{ convert.to_inventory_item_display }}
                                                            <div v-if="!convert.cost_valid" class="text-danger">
                                                                <strong>{{ convert.cost_validate_msg }}</strong>
                                                            </div>
                                                        </td>
                                                        <td class="text-right align-middle">
                                                            {{ convert.transaction_quantity_format }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <div :title="'conversion_rate :' + convert.conversion_rate">
                                                                {{ convert.to_uom_display }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="text-center" v-if="lines.length === 0">
                    <span class="lead">No Data.</span>
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
    props:["pUrl"],
    computed: {
        secondaryUomList() {
            let vm = this;
            if (vm.header.inventory_item_id) {
                let item = vm.data.item_list.filter(o => o.inventory_item_id == vm.header.inventory_item_id);
                if (item.length) {
                    if (!vm.header.attribute1) {
                        vm.header.attribute1 = item[0].primary_uom_code;
                    }

                    return item[0].secondary_uom_list;
                }
            }
            return [];
        },
    },
    watch:{
        // ingredient_group(newValue, oldValue) {
        //     console.log('ingredient_group', ingredient_group);
        // },
        checkedAll(newValue) {
            this.lines.forEach(async function(line) {
                if (!line.is_disable && line.cost_valid) {
                    line.is_selected = newValue
                }
            })
        }
    },
    data() {
        return {
            url: this.pUrl,
            data: false,
            header: false,
            profile: false,
            searchTransactionDateFormat: '',
            transBtn: {},
            transDate: {},
            lines: [],
            checkedAll: false,
            loading: {
                page: false,
                before_mount: false,
            },
            firstLoad: true,
            countOpen: 0,
        }
    },
    beforeMount() {
        console.log('beforeMount');
        this.getInfo();
    },
    mounted() {
        console.log('wip-requests: Component mounted.');
    },
    methods: {
        async show(header) {
            console.log('show header', header);
            this.header = header;
            this.getLines(false, 'show');
        },
        async getInfo() {
            let vm = this;
            let param = window.location.search;
            let response = false;

            vm.loading.page = true;
            vm.loading.before_mount = true;
            vm.lines = [];
            await axios.get(vm.url.index + param).then(res => {
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
            }

            vm.loading.before_mount = false;
            // console.log('info success');
            // vm.getLines(false, 'show');
        },
        async setdate(date, key) {
            let vm = this;
            vm.header[key] = await moment(date).format(vm.transDate['js-format']);
            // vm.getLines();
        },
        async addNewLine() {
            let vm = this;
            // let row = Object.keys(vm.lineAll).length;
            let row = vm.lines.length;
            let newLine = await _.clone(vm.data.new_line);
            vm.$set(vm.lines, row, newLine);
        },
        async itemWasSelected(item, line) {

            line.inventory_item_id          = item.inventory_item_id;
            line.item_classification_code   = item.item_classification_code;
            line.item_desc                  = item.item_desc;
            line.item_number                = item.item_number;
            line.organization_id            = item.organization_id;
            line.secondary_uom_list         = item.secondary_uom_list;
            line.transaction_uom            = item.transaction_uom;
            line.transaction_uom_desc       = item.transaction_uom_desc;

            line.transaction_type_id_from   = item.transaction_type_id_from
            line.organization_id_from       = item.organization_id_from
            line.subinventory_from          = item.subinventory_from
            line.locator_id_from            = item.locator_id_from
            line.locator_code_from          = item.locator_code_from

            line.transaction_type_id_to     = item.transaction_type_id_to;
            line.organization_id_to         = item.organization_id_to;
            line.subinventory_to            = item.subinventory_to;
            line.locator_id_to              = item.locator_id_to;
            line.locator_code_to            = item.locator_code_to;

            console.log('itemWasSelected(item, line)', item, line);
        },
        async save() {
            let vm = this;

            if (vm.lines.length == 0) {
                await helperAlert.showGenericFailureDialog('ไม่พบรายการ เลขที่คำสั่งผลิต');
                return;
            }

            if (vm.searchTransactionDateFormat != vm.header.transaction_date_format) {
                await helperAlert.showGenericFailureDialog('วันที่ส่งผลผลิต และวันที่เลขที่คำสั่งผลิตไม่ตรงกัน');
                return;
            }

            let confirm = await helperAlert.showProgressConfirm('กรุณายืนยัน บันทึกส่งสินค้าเข้าคลัง');

            if (confirm) {
                vm.loading.page = true;
                let lines =  vm.lines;
                await axios.post(vm.url.ajax_store, {
                        header: vm.header,
                        lines: lines
                    })
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            vm.header = data.header;

                            setTimeout(async function(){ await vm.getLines(false, 'show'); }, 500);
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
        async setStatus(status) {

            let vm = this;
            let confirm = false;

            let msg = '';
            if (status == 'infWipCompleted') {
                msg = 'ยืนยันบันทึกเข้าคลัง';
            }
            if (status == 'infWipCompletedReturn') {
                msg = 'ยกเลิกบันทึกเข้าคลัง';
            }

            if (status == 'cancelTransfer') {
                msg = 'ยกเลิกใบส่ง';
            }

            confirm = await helperAlert.showProgressConfirm(msg);

            if (confirm) {
                vm.loading.page = true;
                let url = vm.url.ajax_set_status;
                if (vm.header.wip_req_header_id != '' && vm.header.wip_req_header_id != undefined) {
                    url = url.replace("-999", vm.header.wip_req_header_id)
                }

                await axios.post(url, {
                        status: status,
                        lines: vm.lines
                    })
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            vm.header.wip_request_status = String(data.wip_request_status)
                            vm.header.can = data.can
                            vm.getLines(false, 'show');
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

            if (isShowNoti) {
                confirm = await helperAlert.showProgressConfirm('ค้นหารายการส่งสินค้าเข้าคลัง ?');
            }
            console.log('getLines', isShowNoti, confirm);

            if (confirm) {

                vm.loading.page = true;
                vm.searchTransactionDateFormat = vm.header.transaction_date_format;
                vm.lines = [];


                // let params = {
                //     number: query,
                //     action: action
                // }


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
                        vm.lines = _.sortBy(data.lines, function(o) { return o.batch_no; })
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
        async selectObjectiveCode(objectiveCode) {
            let vm = this;
            vm.getLines();
        },
    }
}
</script>
