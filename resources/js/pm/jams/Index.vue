<template>
    <div>
        <div class="ibox float-e-margins" v-loading="loading.page">
            <div class="ibox-content" v-if="!loading.before_mount">
                <div class="row">
                    <div class="col-lg-7 offset-1">
                        <div class="form-group row">
                            <label class="col-lg-6 font-weight-bold col-form-label text-right">วันที่เรียกใบยา :</label>
                            <div class="col-lg-6">
                                <!-- @change="selectObjectiveCode" -->
                                <datepicker-th
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="input_date"
                                    :disabled="false"
                                    id="input_date"
                                    placeholder="โปรดเลือกวันที่"
                                    :value="header.transaction_date_format"
                                    :format="transDate['js-format']"
                                    @dateWasSelected="setdate(...arguments, 'transaction_date_format')"
                                    />
                            </div>
                        </div>

                        <div class="form-group row" >
                            <label class="col-lg-6 font-weight-bold col-form-label text-right">Blend No.: </label>
                            <div class="col-lg-6">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="blend_no"
                                    v-model="header.blend_no"
                                    @change="selectInventoryItem('blend_no')"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in data.blend_no_list"
                                        :key="JSON.stringify(item)"
                                        :label="item"
                                        :value="item">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-6 font-weight-bold col-form-label text-right">สินค้าที่จะผลิต: </label>
                            <div class="col-lg-6">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="blend_no"
                                    v-model="header.inventory_item_id"
                                    @change="selectInventoryItem('inventory_item_id')"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in (data.item_list)"
                                        :key="JSON.stringify(item)"
                                        :label="item.display"
                                        :value="item.inventory_item_id">
                                    </el-option>
                                </el-select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-6 font-weight-bold col-form-label text-right require">ประเภทใบยาที่ต้องการเรียก *: </label>
                            <div class="col-lg-6">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="blend_no"
                                    v-model="header.tobacco_type_code"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in (data.tobacco_type_list)"
                                        :key="JSON.stringify(item)"
                                        :label="item.tobacco_type_code + ' : ' + item.tobacco_type"
                                        :value="item.tobacco_type_code">
                                    </el-option>
                                </el-select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-6 font-weight-bold col-form-label text-right">จำนวนที่สั่งผลิต: </label>
                            <div class="col-lg-3">
                                <input class="form-control text-right" type="number"
                                    @change="changeRequestQuantity"
                                    v-model.number="header.request_quantity"
                                    :disabled="!header.inventory_item_id"
                                    />
                            </div>
                            <div class="col-lg-3">

                                <input  :title="header.primary_uom_code" class="form-control"
                                    disabled :value="header.product_unit_of_measure" />
                            </div>
                        </div>

                        <div class="form-group row mb-0" >
                            <div class="col-lg-12 text-right">
                                <button :class="transBtn.search.class + ' btn-lg tw-w-25'"
                                    @click.prevent="getLines(false)" >
                                    <i :class="transBtn.search.icon"></i>
                                    {{ transBtn.search.text }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ibox float-e-margins" v-if="!loading.before_mount" v-loading="loading.page">
            <!-- <div class="ibox-content">
                <div class="row">
                    <div class="col-12">
                        <div class="text-right">
                            <button  :class="transBtn.create.class + ' btn-lg tw-w-25'"
                                @click.prevent="addNewLine">
                                <i :class="transBtn.create.icon"></i>
                                เพิ่มรายการ
                            </button>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="ibox-content">
                <div class="row">
                    <div class="col-12">
                        ค้นหาข้อมูลปักษ์ที่ : <span v-if="biweekly"> {{ biweekly.biweekly }} </span>
                    </div>
                </div>
                <div class="table-responsive m-t">
                    <table class="table text-nowrap table-bordered">
                        <thead>
                            <tr>
                                <th width="10px;"></th>
                                <th width="50px;" class="text-center">
                                    กลุ่มใบยา
                                </th>
                                <th width="150px;">
                                    รหัสวัตถุดิบ
                                </th>
                                <th >รายละเอียด</th>
                                <!-- <th width="100px;" class="text-right">Lot</th> -->
                                <th width="200px;" class="text-center">
                                    ปริมาณที่ใช้
                                </th>
                                <th width="200px;" class="text-center">
                                    ปริมาณเบิก
                                </th>
                                <th width="400px;" class="text-center">
                                    ปริมาณ<br>
                                    ที่ต้องการเบิก<br>
                                    FULL/ASRS
                                </th>
                                <th width="400px;" class="text-center">
                                    ปริมาณ<br>
                                    ที่ต้องการเบิก<br>
                                    Quarter/RGV
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(line, i) in lines" v-if="lines.length">
                                <td :date="i" class="align-middle text-center">
                                    <input type="checkbox"
                                        v-model="line.is_selected">
                                </td>
                                <td class="text-center">
                                    {{ line.leaf_fomula }}
                                </td>
                                <td>
                                    {{ line.item_number }}
                                </td>
                                <td>
                                    {{ line.item_desc }}
                                    <!-- <div>
                                        <span class="text-muted">วัตถุดิบ: </span> {{ line.item_number }}
                                    </div>
                                    <div>
                                        <span class="text-muted">รายละเอียด: </span> {{ line.item_desc }}
                                    </div> -->
                                </td>
                                <!-- <td class="text-right">{{ line.default_lot_no }}</td> -->
                                <td class="text-right" :title="line.require_qty">
                                    <!-- <span v-if="header.request_quantity">
                                        {{ line.require_qty * header.request_quantity }}
                                    </span>
                                    <span v-else>{{ line.require_qty }}</span> -->
                                    <!-- {{ Math.ceil(line.require_qty * header.request_quantity) }} -->
                                    {{ Math.ceil(line.ratio_require_per_unit * header.request_quantity) }}
                                    {{ line.uom.unit_of_measure }}
                                </td>
                                <td class="text-right">
                                    <span v-if="line.transaction_qty != NaN">
                                        {{ line.transaction_qty }}
                                    </span>
                                    {{ line.uom.unit_of_measure }}
                                </td>
                                <td class="text-center">
                                    <div class="input-group ">
                                        <input class="form-control text-right" @change="adjQty(line, false)"
                                        type="number"  v-model.number="line.ca_qty"
                                        />
                                        <div class="input-group-append" title="line.transaction_uom">
                                            <span class="input-group-addon">หีบ</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="input-group ">
                                        <input class="form-control text-right" @change="adjQty(line, false)"
                                        type="number"  v-model.number="line.a3_qty"
                                        />
                                        <div class="input-group-append" title="line.transaction_uom">
                                            <span class="input-group-addon">ลูก</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center" v-if="lines.length === 0">
                    <span class="lead">No Data.</span>
                </div>
                <transition
                    enter-active-class="animated fadeInUp"
                    leave-active-class="animated fadeOutDown">
                    <div class="text-center" v-if="lines.length > 0 && !loading.before_mount">

                        <button :class="transBtn.save.class + ' btn-lg tw-w-25'"
                            @click.prevent="save">
                            <i :class="transBtn.save.icon"></i>
                            <!-- {{ transBtn.save.text }} -->
                            ยืนยันเรียกใบยา
                        </button>
                    </div>
                </transition>
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

export default {

    // components: {
    //     modalSearch, searchItem
    // },
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
        // lines: {
        //     transaction_qty(newValue, oldValue){
        //         console.log('watch: transaction_qty', newValue, oldValue);
        //     },
        //     deep: true,
        // },
        // lines: {
        //     handler(val){
        //         console.log('watch lines', val)
        //     },
        //     deep: true,
        // },

        // lines: {
        //     handler(val){
        //         let vm = this;
        //         val.forEach(async function(line, index) {
        //             await vm.adjQty(line);
        //         })
        //     },
        // }

        // lines.transaction_qty: {
        //     handler(val){
        //         console.log('watch lines', val)
        //     },
        //     deep: true,
        // }

    },
    computed: {
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
        console.log('Component mounted.');
    },
    methods: {
        async setdate(date, key) {
            let vm = this;
            // console.log('setdate', date, key, vm.transDate['js-format']);
            vm.header[key] = await moment(date).format(vm.transDate['js-format']);
            if (vm.header[key]) {
                this.getInfo();
            }
        },
        async show(header) {
            console.log('show header', header);
            this.header = header;
            this.getLines(false, 'show');
        },
        async adjQty(line, resetData = true) {
            let vm = this;
            if (resetData) {
                line.transaction_qty = Math.ceil(parseFloat(line.ratio_require_per_unit) * parseFloat(vm.header.request_quantity));

                line.ca_qty = Math.trunc(parseFloat(line.transaction_qty) / parseFloat(line.ca_convert_rate));
                // line.a3_qty = (parseFloat(line.transaction_qty) % parseFloat(line.ca_convert_rate)) / 10;
                // line.a3_qty = Math.trunc(line.a3_qty * parseFloat(line.ca_convert_rate));
                // line.a3_qty = Math.trunc(line.a3_qty / parseFloat(line.a3_convert_rate));

                let a3 = (parseFloat(line.transaction_qty) / parseFloat(line.ca_convert_rate)) - line.ca_qty;
                    a3 = Math.ceil((a3 * line.ca_convert_rate)) / line.a3_convert_rate;
                // line.a3_qty = Math.round(a3);
                line.a3_qty = a3;
            }
            line.transaction_qty = (line.ca_qty * line.ca_convert_rate) + (line.a3_qty * line.a3_convert_rate);
            line.transaction_qty = Math.ceil(line.transaction_qty);
            if (line.transaction_qty <= 0) {
                line.is_selected = false;
            } else {
                line.is_selected = true;
            }
        },
        async resetQty() {
            let vm = this;
            this.lines.forEach(async function(line, index) {
                await vm.adjQty(line);
            })
        },
        async getInfo() {
            let vm = this;
            let transactionDate = vm.header.transaction_date_format;
            if (transactionDate == '' || transactionDate == undefined || transactionDate == null) {
                transactionDate = '';
            }
            let param = window.location.search;
            let response = false;

            vm.loading.page = true;
            vm.loading.before_mount = true;
            vm.lines = [];
            // await axios.get(vm.url.index + param).then(res => {
            await axios.get(vm.url.index_ony + "?transaction_date_format='"+ transactionDate + "'").then(res => {
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
        },
        async selectInventoryItem(inputName) {
            let vm = this;
            if (inputName == 'blend_no') {
                vm.header.inventory_item_id = '';
                vm.header.product_unit_of_measure = '';
                if (vm.header.blend_no) {
                    let item = vm.data.item_list.filter(o => o.blend_no == vm.header.blend_no);
                    if (item.length) {
                        vm.header.inventory_item_id = item[0]['inventory_item_id'];
                        vm.header.product_unit_of_measure = item[0]['product_unit_of_measure'];
                    }
                }
            }
            if (inputName == 'inventory_item_id') {
                vm.header.blend_no = '';
                vm.header.product_unit_of_measure = '';
                if (vm.header.inventory_item_id) {
                    let item = vm.data.item_list.filter(o => o.inventory_item_id == vm.header.inventory_item_id);
                    vm.selectProdItem = {};
                    if (item.length) {
                        vm.header.blend_no = item[0]['blend_no'];
                        vm.selectProdItem = item[0];
                         vm.header.product_unit_of_measure = item[0]['product_unit_of_measure'];
                    }
                }
            }

            vm.data.tobacco_type_list = [];
            vm.header.tobacco_type_code = '';
            if (vm.header.inventory_item_id) {
                let idx = vm.data.item_list.findIndex(o => o.inventory_item_id == vm.header.inventory_item_id);
                vm.data.tobacco_type_list = vm.data.item_list[idx].tobacco_type_list;

                vm.header.tobacco_type_code = vm.data.tobacco_type_list[0].tobacco_type_code
            }

            // if (!vm.firstLoad) {
            //     vm.getLines();
            // }
        },
        async changeRequestQuantity() {
            this.resetQty();
            return;
        },
        async addNewLine() {
            let vm = this;
            // let row = Object.keys(vm.lineAll).length;
            let row = vm.lines.length;
            let newLine = await _.clone(vm.data.new_line);
            vm.$set(vm.lines, row, newLine);
        },
        async itemWasSelected(item, line) {

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

            let confirm = await helperAlert.showProgressConfirm('กรุณายืนยัน บันทึกเรียกใบยา');

            if (confirm) {
                vm.loading.page = true;
                // let lines =  vm.lines;
                let lines =  vm.lines.filter(o => o.is_selected == true);
                await axios.post(vm.url.ajax_store, {
                        header: vm.header,
                        lines: lines
                    })
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            // vm.header = data.header;
                            swal({
                                title: "Success",
                                text: 'ยืนยันเรียกใบยาสำเร็จ',
                                type: "success",
                                showConfirmButton: true
                            });
                            setTimeout(async function(){ await vm.getInfo(); }, 500);
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
                            vm.header.request_status = String(data.request_status)
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

            if (isShowNoti) {
                confirm = await helperAlert.showProgressConfirm('ต้องการเปลี่ยนแปลงค้นหาเรียกใบยา ?');
            }
            console.log('getLines', isShowNoti, confirm);

            if (confirm) {

                vm.loading.page = true;
                // vm.searchTransactionDateFormat = vm.header.transaction_date_format;
                // vm.biweekly = {};
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
                        vm.resetQty()
                        // vm.biweekly = data.biweekly;

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
                line.cgk_quantity = parseFloat(cgcQty) * parseFloat(vm.data.convert_rate);
            } else if(inputName == 'cgk_quantity') {
                let cgkQty = (line.cgk_quantity != '' && line.cgk_quantity != undefined) ? line.cgk_quantity : 0;
                line.cgc_quantity = '';
                line.cgc_quantity = parseFloat(cgkQty) / parseFloat(vm.data.convert_rate);
            }
        }
    }
}
</script>
