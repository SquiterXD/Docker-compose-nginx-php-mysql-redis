<template>
    <div>
        <div class="ibox float-e-margins" v-loading="loading.page">
            <div class="ibox-content" v-if="!loading.before_mount">
                <div class="row">
                    <!-- <div class="col-3">
                        <h3 class="no-margins"> โอนสินค้าสำเร็จรูป </h3>
                    </div> -->
                    <div class="col-12 text-right">
                        <button :class="transBtn.create.class + ' btn-lg tw-w-25 mr-2'"
                            @click.prevent="indexPage" >
                            <i :class="transBtn.create.icon"></i>
                            {{ transBtn.create.text }}
                        </button>
                         <button :class="transBtn.save.class + ' btn-lg tw-w-25'"
                            :disabled="!header.can.edit"
                            @click.prevent="save">
                            <i :class="transBtn.save.icon"></i>
                            <!-- {{ transBtn.save.text }} -->
                            ส่งยอดบุหรี่
                        </button>
                        <!-- <button
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
                        </button> -->
                    </div>
                </div>
            </div>
            <div class="ibox-content" v-if="!loading.before_mount">
                <modal-search @selectWipRequestHeader="show"
                    :transBtn="transBtn" :url="url"
                    :countOpen="countOpen" />
                <div class="row">
                    <div class="col-lg-6 b-r">
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-2">เลขที่ใบส่ง: </label>
                            <div class="col-lg-7">
                                <div class="input-group ">
                                    <input id="lb-2" type="text" class="form-control" name="mfg_order_number"
                                       :value="header.mfg_order_number"
                                       :disabled="true"
                                       />
                                    <!-- <span class="input-group-append">
                                        <button type="button" class="btn btn-default no-margins" @click="countOpen += 1">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span> -->
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-2">เลขที่ Lot: </label>
                            <div class="col-lg-7">
                                <div class="input-group ">
                                    <input id="lb-2" type="text" class="form-control" name="lot_number"
                                       :value="header.lot_number"
                                       :disabled="true"
                                       />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">วันที่ส่งผลผลิต: </label>
                            <div class="col-lg-7">
                                <!-- @change="selectObjectiveCode" -->
                                <datepicker-th
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="input_date"
                                    id="input_date"
                                    :disabled="!header.can.edit"
                                    placeholder="โปรดเลือกวันที่"
                                    :value="header.transaction_date_format"
                                    :format="transDate['js-format']"
                                    value-format="dd-mm-yyyy"
                                    @dateWasSelected="setdate(...arguments, 'transaction_date_format')"
                                    />
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">
                        <!-- <div class="form-group row">
                            <label class="col-lg-3 font-weight-bold col-form-label text-right">สถานะขอเบิก: </label>
                            <div class="col-lg-6">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="mfg_status"
                                    disabled
                                    v-model="header.mfg_status"
                                    filterable>
                                    <el-option
                                        v-for="item in data.mfg_status_list"
                                        :key="JSON.stringify(item)"
                                        :label="item.description"
                                        :value="item.lookup_code">
                                    </el-option>
                                </el-select>
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label class="col-lg-3 font-weight-bold col-form-label text-right">หมายเหตุ: </label>
                            <div class="col-lg-6">
                                <el-input :disabled="!header.can.edit"
                                    type="textarea" class="required" name="note"
                                    v-model="header.remark_msg" rows="4" maxlength="240" show-word-limit />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ibox float-e-margins" v-if="!loading.before_mount" v-loading="loading.page">
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
                <div class="row">
                    <div class="col-12">
                        <!-- ค้นหาข้อมูลปักษ์ที่ : <span v-if="biweekly"> {{ biweekly.biweekly }} </span> -->
                    </div>
                </div>

                <div class="table-responsive m-t">
                    <div class="table-responsive m-t">
                    <table class="table text-nowrap table-bordered">
                        <thead>
                            <tr>
                                <th width="10px;"></th>
                                <th width="150px" style="text-align:center">
                                   
                                    รหัสสินค้าสำเร็จรูป
                                    
                                </th>
                                <th style="text-align:center">รายละเอียด</th>
                                <th width="250px" style="text-align:center" class="text-center">
                                    จำนวน(หีบ)
                                </th>
                                <th width="250px" style="text-align:center" class="text-center">
                                    จำนวน(พันมวน)
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(line, i) in lines" v-if="lines.length" :key="i">
                                <td :date="i" class="align-middle text-center">
                                    <input type="checkbox"
                                        :disabled="!header.can.edit"
                                        v-model="line.is_selected"
                                        @click="selectLine(i, line)">
                                </td>
                                <td>
                                    <template v-if="line.storage_line_id && !header.can.edit">
                                        {{ line.segment1 }}
                                    </template>
                                    <template v-else>
                                        <div style="display: flex;">

                                            <template v-if="!line.is_edit_item || !header.can.edit">
                                                <el-input
                                                  placeholder="Please input"
                                                  :value="line.segment1"
                                                  :disabled="true">
                                                </el-input>

                                                <button v-if="header.can.edit && line.storage_line_id"
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
                                                    :i="i"
                                                    :inventoryItemId="line.inventory_item_id"
                                                    :lines="lines"
                                                    @itemWasSelected="itemWasSelected(...arguments, line, i)"
                                                    :url="url" />
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
                                <td class="">{{ line.description }}</td>
                                <td class="text-right">
                                    <div class="input-group ">
                                        <input class="form-control text-right"
                                            type="text"
                                            v-model.number="line.cgc_quantity"
                                            @focus="() => { line.cgc_quantity = line.cgc_quantity.replaceAll(',', '')}"
                                            @focusout="handleFocusoutCgc(line)"
                                            @change="changeQty(line, 'cgc_quantity')"
                                            :disabled="!header.can.edit || !line.inventory_item_id"
                                            />
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="input-group ">
                                        <input class="form-control text-right"
                                            type="text"
                                            v-model.number="line.cgk_quantity"
                                            @focus="() => { line.cgk_quantity = line.cgk_quantity.replaceAll(',', '')}"
                                            @focusout="() => { line.cgk_quantity = numberWithCommas(line.cgk_quantity)}"
                                            @change="changeQty(line, 'cgk_quantity')"
                                            :disabled="!header.can.edit || !line.inventory_item_id"
                                            />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
import searchItem from './SearchItem';
import modalSearch from './ModalSearch.vue';

export default {

    components: {
        modalSearch, searchItem
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
            biweekly: {},
            lines: [],
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
        handleFocusoutCgc(line)
        { 
            line.cgc_quantity = this.numberWithCommas(_.ceil(line.cgc_quantity))
        },
        numberWithCommas(x) {
             var parts = x.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return parts.join(".");
        },
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
            vm.getLines(false, 'show');
        },
        async setdate(date, key) {
            let vm = this;
            vm.header[key] = await moment(date).format(vm.transDate['js-format']);
            vm.getLines();
        },
        async addNewLine() {
            let vm = this;
            // let row = Object.keys(vm.lineAll).length;
            let row = vm.lines.length;
            let newLine = await _.clone(vm.data.new_line);
            vm.$set(vm.lines, row, newLine);
        },
        async itemWasSelected(item, line, i) {
            
            line.segment1                  = item.segment1;
            line.description               = item.description;
            line.inventory_item_id         = item.inventory_item_id;
            line.organization_id           = item.organization_id;
            console.log('itemWasSelected(item, line)', item, line);
        },
        async save() {
            let vm = this;

            // if (vm.lines.length == 0) {
            //     await helperAlert.showGenericFailureDialog('ไม่พบรายการ เลขที่คำสั่งผลิต');
            //     return;
            // }

            // if (vm.searchTransactionDateFormat != vm.header.transaction_date_format) {
            //     await helperAlert.showGenericFailureDialog('วันที่ส่งผลผลิต และวันที่เลขที่คำสั่งผลิตไม่ตรงกัน');
            //     return;
            // }

            let confirm = await helperAlert.showProgressConfirm('กรุณายืนยัน ส่งยอดบุหรี่');

            if (confirm) {
                _.map(vm.lines, (item, i)=> {
                    item.cgc_quantity = item.cgc_quantity.replaceAll(',', '')
                    item.cgk_quantity = item.cgk_quantity.replaceAll(',', '')
                    
                    return item;
                })
                vm.loading.page = true;
                // let lines =  vm.lines;
                let lines =  vm.lines.filter(o => o.is_selected == true);;
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
                if (vm.header.storage_header_id != '' && vm.header.storage_header_id != undefined) {
                    url = url.replace("-999", vm.header.storage_header_id)
                }

                await axios.post(url, {
                        status: status
                    })
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            vm.header.mfg_status = String(data.mfg_status)
                            vm.header.can = data.can
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
            if ((vm.header.storage_header_id != undefined && vm.header.storage_header_id != '')) {
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
            //     confirm = await helperAlert.showProgressConfirm('ต้องการเปลี่ยนแปลงค้นหาการจัดเก็บบุหรี่ ?');
            // }
            console.log('getLines', isShowNoti, confirm);

            if (confirm) {

                vm.loading.page = true;
                vm.searchTransactionDateFormat = vm.header.transaction_date_format;
                vm.biweekly = {};
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

                       
                         
                        _.map(vm.lines, (item, i)=> {
                            item.cgc_quantity = this.numberWithCommas(_.ceil(item.cgc_quantity))
                            item.cgk_quantity = this.numberWithCommas(item.cgk_quantity)
                            
                            return item;
                        })
                        vm.biweekly = data.biweekly;

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
        async changeQty(line, inputName) {
            let vm = this;
            // let cgcQty = (line.cgc_quantity != '' && line.cgc_quantity != undefined) ? line.cgc_quantity : 0;
            // let cgkQty = (line.cgk_quantity != '' && line.cgk_quantity != undefined) ? line.cgk_quantity : 0;
            // console.log('000', cgcQty, '----', cgkQuantity, inputName);
            // console.log('111', cgcQuantity, cgkQuantity, inputName);

            if (inputName == 'cgc_quantity') {
                let cgcQty = (line.cgc_quantity != '' && line.cgc_quantity != undefined) ? line.cgc_quantity : 0;
                line.cgk_quantity = '';
                line.cgk_quantity = this.numberWithCommas(parseFloat(cgcQty) * parseFloat(vm.data.convert_rate));
            } else if(inputName == 'cgk_quantity') {
                let cgkQty = (line.cgk_quantity != '' && line.cgk_quantity != undefined) ? line.cgk_quantity : 0;
                line.cgc_quantity = '';
                line.cgc_quantity = this.numberWithCommas(_.ceil(parseFloat(cgkQty) / parseFloat(vm.data.convert_rate)));
            }
        }
    }
}
</script>
