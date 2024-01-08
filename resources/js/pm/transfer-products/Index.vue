<template>
    <div>
        <div class="ibox float-e-margins" v-loading="loading.page">
            <div class="ibox-content" v-if="!loading.before_mount">
                <div class="row">
                    <!-- <div class="col-3">
                        <h3 class="no-margins"> โอนสินค้าสำเร็จรูป </h3>
                    </div> -->
                    <div class="col-12 text-right">
                        <button :class="transBtn.search.class + ' btn-lg tw-w-40 mr-2'"
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
                            @click.prevent="setStatus('confirmTransfer')">
                            <strong>ยืนยันขอโอนวัตถุดิบ</strong>
                        </button>
                        <button
                            class="btn btn-w-m btn-danger btn-lg"
                            :disabled="!header.can.cancel_transfer"
                            @click.prevent="setStatus('cancelTransfer')">
                            <i class="fa fa-times"></i> ยกเลิกการขอโอนวัตถุดิบ
                        </button>
                    </div>
                </div>
            </div>
            <div class="ibox-content" v-if="!loading.before_mount">
                <modal-search @selectTransferHeader="show" :transDate="transDate"
                    :transBtn="transBtn" :url="url"
                    :countOpen="countOpen" />
                <div class="row">
                    <div class="col-lg-6 b-r">
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-2">ใบส่งเลขที่: </label>
                            <div class="col-lg-7">
                                <input id="lb-2" type="text" class="form-control" name="transfer_number"
                                       :value="header.transfer_number"
                                       :disabled="true"
                                       />
                                <!-- <div class="input-group ">
                                    <input id="lb-2" type="text" class="form-control" name="transfer_number"
                                       :value="header.transfer_number"
                                       :disabled="true"
                                       />
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-default no-margins" @click="countOpen += 1">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div> -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-3">วันที่ได้ผลผลิต <span style="color:red">*</span>: </label>
                            <div class="col-lg-7">
                                <datepicker-th
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="input_date"
                                    id="input_date"
                                    placeholder="โปรดเลือกวันที่"
                                    :disabled="!header.can.edit"
                                    :value="header.product_date_format"
                                    :format="transDate['js-format']"
                                    @dateWasSelected="setdate(...arguments, 'product_date_format')"
                                    />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">วันที่ส่งผลผลิต <span style="color:red">*</span>: </label>
                            <div class="col-lg-7">
                                <datepicker-th
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="input_date"
                                    id="input_date"
                                    :disabled="!header.can.edit"
                                    placeholder="โปรดเลือกวันที่"
                                    :value="header.transfer_date_format"
                                    :format="transDate['js-format']"
                                    @dateWasSelected="setdate(...arguments, 'transfer_date_format')"
                                    />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">วัตถุประสงค์ <span style="color:red">*</span>: </label>
                            <div class="col-lg-7">
                                    <!-- @change="selectObjectiveCode" -->
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="transfer_objective"
                                    v-model="header.transfer_objective"
                                    @change="selectObjectiveCode"
                                    :disabled="!header.can.edit"
                                    filterable>
                                    <el-option
                                        v-for="item in data.objective_code_list"
                                        :key="JSON.stringify(item)"
                                        :label="item.description"
                                        :value="item.lookup_code">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <!-- <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">ผู้ขอเบิก: </label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" autocomplete="off"
                                       disabled="disabled" :value="profile.user_name">
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">สถานะส่งสินค้า: </label>
                            <div class="col-lg-6">
                                <input type="text" readonly disabled class="form-control"
                                    :value="(()=>{
                                        if(header.transfer_status){
                                            let result = data.request_status_list.find(o => o.lookup_code == header.transfer_status)
                                            if(result){
                                                return result.description
                                            }
                                        }
                                        return null
                                    })()">
                            </div>
                        </div>

                         <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">สัปดาห์: </label>
                            <div class="col-lg-6">
                                <input type="text" readonly disabled class="form-control" :value="dateWeekOfYear(header.product_date_format)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">หน่วยงาน  <span style="color:red" v-if="header.transfer_objective == 5">*</span>: </label>
                            <div class="col-lg-7">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="transfer_objective"
                                    v-model="header.attribute2"
                                    :disabled="header.transfer_objective != 5"
                                    filterable>
                                    <el-option
                                        v-for="item in ptpmExCigDepartment"
                                        :key="JSON.stringify(item)"
                                        :label="item.description"
                                        :value="item.description">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ibox float-e-margins" v-if="!loading.before_mount"  v-loading="loading.page">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-12">
                        <div class="text-right">
                            <button  :class="transBtn.create.class + ' btn-lg tw-w-25'"
                                :disabled="!header.can.edit"
                                @click.prevent="addNewLine">
                                <i :class="transBtn.create.icon"></i>
                                เพิ่มรายการ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive m-t">
                    <table class="table text-nowrap table-bordered">
                        <thead>
                            <tr>
                                <th width="10px;"></th>
                                <th width="150px;">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    รหัสสินค้าสำเร็จรูป <span style="color:red">*</span>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </th>
                                <th >รายละเอียด</th>
                                <th width="100px;" class="text-center">
                                    คลังสินค้า
                                </th>
                                <th width="100px;" class="text-center">
                                    คลังสินค้าย่อย
                                </th>
                                <th width="250px;" class="text-center">
                                    จำนวน <span style="color:red">*</span>
                                </th>
                                 <th width="250px;" class="text-center">
                                    หน่วยนับ <span style="color:red">*</span>
                                </th>
                                <!-- <th width="100px;" class="text-center">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    หน่วยนับ
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </th> -->
                                <th width="10px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(line, i) in lines" v-if="lines.length" :date="i">
                                <td :date="i" class="align-middle text-center">
                                    <input type="checkbox"
                                        :disabled="!header.can.edit || line.is_disable"
                                        v-model="line.is_selected"
                                        @click="selectLine(i, line)">
                                </td>
                                <td>
                                    <template v-if="line.transfer_line_id && !header.can.edit">
                                        {{ line.item_number }}
                                    </template>
                                    <template v-else>
                                        <div style="display: flex;">
                                            <template v-if="!line.is_edit_item || !header.can.edit">
                                                <el-input
                                                  placeholder="Please input"
                                                  :value="line.item_number"
                                                  :disabled="true">
                                                </el-input>

                                                <button v-if="(header.can.edit && line.transfer_line_id) && !line.is_disable"
                                                    type="button"
                                                    @click.prevent="line.is_edit_item = true"
                                                    class="btn btn-outline btn-xs mb-0"
                                                    title="แก้ไข">
                                                        <i :class="transBtn.edit.icon"></i>
                                                </button>
                                            </template>
                                            <!-- <template v-if="line.is_edit_item"> -->
                                            <template v-else>
                                                <search-item
                                                    :pHeader="header"
                                                    :inventoryItemId="line.inventory_item_id"
                                                    @getItems="getItems"
                                                    @itemWasSelected="itemWasSelected(...arguments, line)"
                                                    :url="url"/>
                                                <button v-if="header.can.edit && line.request_line_id"
                                                        type="button"
                                                        @click.prevent="line.is_edit_item = false"
                                                        class="btn btn-outline btn-xs mb-0"
                                                        title="ยกเลิกแก้ไข" >
                                                        <i class="fa fa-refresh"></i>
                                                </button>
                                            </template>
                                        </div>
                                    </template>
                                </td>
                                <td class="">
                                    {{ line.item_desc }}
                                    <div v-if="!line.cost_valid" class="text-danger">
                                        <strong>{{ line.cost_validate_msg }}</strong>
                                    </div>
                                </td>
                                <td class="text-center">{{ line.subinventory_from }}</td>
                                <td class="text-center">{{ line.attribute2 }}</td>
                                <td class="text-right">
                                    <div class="input-group ">
                                        <input 
                                            class="form-control text-right"
                                            type="number"
                                            v-model.number="line.web_qty"
                                            style="height: 40px;"
                                            :disabled="!header.can.edit || !line.inventory_item_id || line.is_disable"
                                            />
                                        <!-- <div class="input-group-append" title="line.transaction_uom">
                                            <span class="input-group-addon">{{ line.transaction_uom_desc }}</span>
                                        </div> -->
                                                              
                                    </div>
                                </td>
                                <td>
                                 <div style="padding-left: 5px;">
                                            <el-select  v-model="line.web_uom"                                                                                                     
                                                        placeholder="โปรดเลือกหน่วย"
                                                        :disabled="!line.inventory_item_id || line.is_disable">
                                                <el-option
                                                    v-for="(item,index) in line.uom_list"
                                                    :key="index"
                                                    :label="item.from_unit_of_measure"
                                                    :value="item.from_uom_code">
                                                </el-option>
                                            </el-select>
                                        </div>                 
                                </td>
                                <td class="text-center align-middle" >
                                    <button v-if="!line.transfer_line_id" class="btn btn-danger" @click="removeRow(i)">
                                        <i aria-hidden="true" class="fa fa-times"></i>
                                    </button>
                                </td>
                                <!-- <td :title="line.transaction_uom" class="text-right">
                                    <template v-if="true">
                                        {{ line.transaction_uom_desc }}
                                    </template>

                                    <el-select v-else
                                        class="text-right"
                                        placeholder=""
                                        filterable
                                        v-model="line.transaction_uom"
                                        :disabled="!header.can.edit || !line.secondary_uom_list.length || true"
                                        >
                                        <el-option
                                            v-for="secUom in line.secondary_uom_list"
                                            :key="JSON.stringify(secUom)"
                                            :label="secUom.from_uom.unit_of_measure"
                                            :value="secUom.from_uom_code">
                                        </el-option>
                                    </el-select>
                                </td> -->
                            </tr>
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
<!-- url -->
<script>
// import _get from 'lodash/get'
// import _set from 'lodash/set'

import {
    showLoadingDialog,
    showProgressWithUnsavedChangesWarningDialog,
    showValidationFailedDialog,
} from "../../commonDialogs"

import moment from "moment";
import searchItem from './SearchItem';
import modalSearch from './ModalSearch.vue';

export default {

    components: {
        searchItem, modalSearch
    },
    props:["pUrl", 'weekOfYear', 'ptpmExCigDepartment'],
    computed: {
        // secondaryUomList() {
        //     let vm = this;
        //     if (vm.header.inventory_item_id) {
        //         let item = vm.data.item_list.filter(o => o.inventory_item_id == vm.header.inventory_item_id);
        //         if (item.length) {
        //             if (!vm.header.attribute1) {
        //                 vm.header.attribute1 = item[0].primary_uom_code;
        //             }

        //             return item[0].secondary_uom_list;
        //         }
        //     }
        //     return [];
        // },
    },
    watch:{
        'header.transfer_objective' (newValue) {
            if(newValue != 5) {
                Vue.set(this.header,'attribute2', '');
            }
            // console.log({newValue}, this.header)
        }
        // ingredient_group(newValue, oldValue) {
        //     console.log('ingredient_group', ingredient_group);
        // },
        // type_code(newValue, oldValue) {
        //     // this.getLines();
        // },
        // objective_code(newValue, oldValue) {
        //     if (newValue == 3) {}
        // }
    },
    data() {
        return {
            url: this.pUrl,
            data: false,
            header: false,
            profile: false,
            master_uom: null,
            transBtn: {},
            transDate: {},
            lines: [],
            loading: {
                page: false,
                before_mount: false,
            },
            firstLoad: true,
            countOpen: 0,
            options: '',
            uWeekOfYear: this.weekOfYear,
            header_can_transfer_old: false,
        }
    },
    beforeMount() {
        // console.log('beforeMount');
        this.getInfo();
    },
    mounted() {
        // console.log('Component mounted.');
    },
    methods: {
        async getItems(parm) {
            this.master_uom = parm.uom_master
        },
        async show(header) {
            this.header = header;
            this.header_can_transfer_old = this.header.can.transfer;
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
                vm.data         = response.data;
                vm.header       = response.header;
                vm.profile      = response.profile;
                vm.transBtn     = response.transBtn;
                vm.transDate    = response.transDate;
                vm.url          = response.url;
                vm.header.transfer_objective = null
                console.log(vm.weekOfYear)
            }

            vm.loading.before_mount = false;
            // console.log('info success');
            vm.getLines(false, 'show');
        },
        async setdate(date, key) {
            let vm = this;

            if(date){
                vm.header[key] = await moment(date).format(vm.transDate['js-format']);
            }
        },
        async addNewLine() {
            let vm = this;
            // let row = Object.keys(vm.lineAll).length;
            let row = vm.lines.length;
            let newLine = await _.clone(vm.data.new_line);
            vm.$set(vm.lines, row, newLine);
        },
        removeRow: function(idx) {
            this.lines.splice(idx, 1);
        },
        async itemWasSelected(item, line) {
            let vm = this;

            line.inventory_item_id          = item.inventory_item_id;
            line.item_classification_code   = item.item_classification_code;
            line.item_desc                  = item.item_desc;
            line.item_number                = item.item_number;
            line.organization_id            = item.organization_id;
            // line.secondary_uom_list         = item.secondary_uom_list;
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

            line.biweekly                   = item.biweekly;
            line.batch_id                   = item.batch_id;

            var params = { 
                inventoryItemId: line.inventory_item_id
            };

            axios
                .get(vm.url.ajax_get_uom, { params })
                .then(res => {                
                    line.uom_list = res.data.UomList;
                    line.web_uom = vm.master_uom
                });
        },
        async save() {
            let vm = this;
            Vue.set(vm.header, 'attribute1', vm.uWeekOfYear)
            let confirm = await helperAlert.showProgressConfirm('กรุณายืนยันโอนสินค้าสำเร็จรูป');
            if(vm.header.transfer_objective == '5'){
                if(vm.header.attribute2 == ''  || typeof vm.header.transfer_objective == 'undefined'){
                    this.$message({message:'กรุณาเลือกหน่วยงาน', 'type' : 'error'})
                    return false;
                }
            }
            if(vm.lines.length > 0) {
                let fCheckQty = _.filter(vm.lines, function(line) {
                    if(!(line.web_qty > 0)) {
                            return true
                    }
                })
                if(fCheckQty.length > 0){
                    this.$message({message:'กรุณากรอกข้อมูลจำนวนในตารางให้ครบถ้วน', 'type' : 'error'})
                    return false;
                }

                let fCheckUom = _.filter(vm.lines, function(line) {
                    if(line.web_uom == null) {
                            return true
                    }
                })
                if(fCheckUom.length > 0){
                    this.$message({message:'กรุณากรอกข้อมูลหน่วยนับในตารางให้ครบถ้วน', 'type' : 'error'})
                    return false;
                }
            }
            if(vm.header.transfer_objective == '' || typeof vm.header.transfer_objective == 'undefined'){
                this.$message({message:'กรุณาเลือกวัตถุประสงค์', 'type' : 'error'})
                return false;
            }


            if (confirm) {
                vm.loading.page = true;
                let lines =  vm.lines.filter(o => o.is_selected == true);

                console.log(lines);

                await axios.post(vm.url.ajax_store, {
                        header: vm.header,
                        lines: lines
                    })
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            vm.header = data.header;
                            vm.header_can_transfer_old = vm.header.can.transfer;

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
                });

            }
        },
        async setStatus(status) {

            let vm = this;
            let confirm = false;

            let msg = '';
            if (status == 'confirmTransfer') {
                msg = 'กรุณายืนยันโอนวัถุดิบ';
            }
            if (status == 'cancelTransfer') {
                msg = 'กรุณายืนยันยกเลิกโอน';
            }

            confirm = await helperAlert.showProgressConfirm(msg);

            if (confirm) {
                vm.loading.page = true;
                let url = vm.url.ajax_set_status;
                if (vm.header.transfer_header_id != '' && vm.header.transfer_header_id != undefined) {
                    url = url.replace("-999", vm.header.transfer_header_id)
                }

                await axios.post(url, {
                        status: status
                    })
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            vm.header.transfer_status = Number(data.transfer_status)
                            vm.header.can = data.can
                        }
                        if (res.data.data.status != 'S') {
                            if(res.data.data.status == 'E' && res.data.data.msg === "Trying to get property 'wip_step' of non-object") {
                                swal({
                                    title: "แจ้งเตือน !",
                                    text: 'ไม่สามารถทำรายการได้ เนื่องจากยังไม่มีการส่งผลผลิตมาจากหน้าเครื่องจักร',
                                    type: "error",
                                    showConfirmButton: true
                                });
                            } else {
                                swal({
                                    title: "Error !",
                                    text: res.data.data.msg,
                                    type: "error",
                                    showConfirmButton: true
                                });
                            }
                            
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
            vm.header.can.transfer = vm.header_can_transfer_old;
            let confirm = true;

            // if (isShowNoti) {
            //     confirm = await helperAlert.showProgressConfirm('กรุณายืนยันการค้นหารายการเบิก');
            // }
            // console.log('getLines', isShowNoti, confirm);

            // if (confirm) {
            if (true) {
                vm.loading.page = true;
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
                        vm.lines = data.lines;
                        // if (res.data.data.status != 'S') {
                        //     swal({
                        //         title: "Error !",
                        //         text: res.data.data.msg,
                        //         type: "error",
                        //         showConfirmButton: true
                        //     });
                        // }
                        if (vm.lines.filter(o => (o.is_disable && !o.cost_valid) ).length > 0) {
                            vm.header.can.transfer = false;
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
            return;
        },
        async selectObjectiveCode(objectiveCode) {
            let vm = this;
            vm.getLines();
        },

        dateWeekOfYear(date){
            let number = moment(date, "DD/MM/YYYY").isoWeek()

            if(number<10){
                number =  '0'+moment(date, "DD/MM/YYYY").isoWeek()
            }else{
                number =  moment(date, "DD/MM/YYYY").isoWeek()
            }

            let vm =this
            vm.uWeekOfYear=number
            return number
        }
    }
}
</script>
