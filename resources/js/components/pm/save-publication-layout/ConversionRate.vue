<template>
    <div >
        <div v-if="false">
            <button class="btn btn-sm btn-primary pull-right" type="button" :disabled="convertItems.length > 0" @click="openModal()">
                <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ
            </button>
            <h3 class="font-weight-bold text-success"><strong>รายละเอียดข้าม Item : ปลายทาง</strong></h3>
        </div>

        <div class="table-responsive mt-3" style="max-height: 600px;"  v-loading="loading.convert_items" v-if="false">
            <!-- <table class="table table-bordered table-sticky mb-0" style="min-width: 800px;"> -->
            <table class="table table-bordered table-sticky mb-0" >

                <thead>
                    <tr>
                        <!-- <th style="width: 120px;" class="text-center">สถานะการใช้งาน</th> -->
                        <!-- คลังต้นปลายทาง -->
                        <th  class="text-left align-middle">
                            Item
                        </th>
                        <th style="width: 180px;" class="text-right align-middle">
                            อัตราส่วน
                        </th>
                        <th style="width: 180px;" class="text-left align-middle">
                            หน่วยนับ
                        </th>
                        <th style="width: 280px;" class="text-left align-middle">
                            Organization
                        </th>
                        <th style="width: 20px;"></th>
                    </tr>
                </thead>
                <tbody v-if="convertItems.length > 0">
                    <template v-for="o in convertItems">
                    <tr>
                        <!-- <td class="text-center font-weight-bold">
                            <div v-html="o.enable_icon_html"></div>
                        </td> -->

                        <!-- คลังต้นปลายทาง -->
                        <td class="text-left font-weight-bold">
                            {{ o.to_inventory_item_display }}
                        </td>
                        <td class="text-right ">
                            {{ o.conversion_rate_display }}
                        </td>
                        <td class="text-left ">
                            {{ o.to_uom_display }}
                        </td>
                        <td class="text-left ">
                            {{ o.to_organization_display }}
                        </td>
                        <td style="" class="text-center font-weight-bold">
                            <button @click="openModal(o.convert_item_id)"
                                type="button"
                                class="btn btn-warning"
                                title="แก้ไข">
                                    <i class="fa fa-edit"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- from_organization_display
                    from_subinv_display
                    from_locator_display
                    to_organization_display
                    to_subinv_display
                    to_locator_display
                    transaction_type_display
                    to_inventory_item_display
                    to_uom_display -->
                    </template>
                </tbody>
            </table>
        </div>


        <!-- Modal -->
        <div class="modal fade" :id="modalId" tabindex="-1" role="dialog" data-backdrop="static"  aria-hidden="true" v-loading="!(!loading.form && form != false)">
            <div class="modal-dialog modal-xl" style="width: 90%; max-width:950px; padding-top: 1%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title text-center">กำหนดรายละเอียดข้าม Item</h1>
                        <!-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button> -->
                    </div>
                    <div class="modal-body" v-if="!loading.form && form != false">
                        <div class="row">
                            <div class="col-5 b-r">
                                <div class="text-center font-weight-bold text-navy tw-text-lg">รายละเอียด Item ต้นทาง</div>
                                <dl class="row mb-0 mt-3">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>รหัสสิ่งพิมพ์:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1">{{ item.item_number }}</dd>
                                    </div>
                                </dl>
                                <dl class="row mb-0 mt-1">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>รายละเอียด:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1">{{ item.item_desc }}</dd>
                                    </div>
                                </dl>
                                <!-- <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Organization:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1">{{ item.organization_code }}</dd>
                                    </div>
                                </dl> -->

                                <dl class="row mb-0 mt-1">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>หน่วยนับ:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1">{{ item.primary_unit_of_measure }}</dd>
                                    </div>
                                </dl>


                            </div>
                            <div class="col-7">
                                <div class="text-center font-weight-bold text-success tw-text-lg">รายละเอียด Item ปลายทาง</div>

                                <dl class="row mb-0 mt-3">
                                    <div class="col-sm-3 text-sm-right">
                                        <dt class="mt-2">รหัสสิ่งพิมพ์:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1">
                                            <el-select clearable filterable @change="selectToItemId"
                                            :popper-append-to-body="false" class="" style="width: 100%" placeholder="" v-model="form.to_inventory_item_id_dummy">
                                                <el-option
                                                    v-for="item in inputParams.to_inventory_item_id_list"
                                                    :key="(item.value)"
                                                    :label="item.item_number"
                                                    :value="(item.value)">
                                                    <span style="float: left">{{ item.label }}</span>
                                                    <span style="float: right; color: #8492a6; font-size: 13px">{{ item.organization_code }}</span>
                                                </el-option>
                                            </el-select>
                                            <input type="text" disabled="" :value="selectToItem ? selectToItem.item_desc : '-'" class="form-control mt-2">
                                        </dd>
                                    </div>
                                </dl>

                                <dl class="row mb-0 mt-2">
                                    <div class="col-sm-3 text-sm-right">
                                        <dt class="mt-2">Organization:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1">
                                            <input type="text" disabled="" :value="selectToItem ? selectToItem.organization_code : '-'" class="form-control">
                                        </dd>
                                    </div>
                                </dl>

                                <dl class="row mb-0  mt-2">
                                    <div class="col-sm-3 text-sm-right">
                                        <dt class="mt-2">อัตราส่วน:</dt>
                                    </div>
                                    <div class="col-sm-4 text-sm-left">
                                        <dd class="mb-1">
                                            <vue-numeric
                                                :disabled="! form.to_inventory_item_id_dummy"
                                                placeholder=""
                                                separator=","
                                                v-bind:precision="0"
                                                v-bind:minus="false"
                                                class="form-control w-100 text-right"
                                                v-model="form.conversion_rate"
                                            ></vue-numeric>
                                        </dd>
                                    </div>

                                    <div class="col-sm-4 text-sm-left">
                                        <dd class="mb-1">
                                            <input type="text" disabled="" :value="selectToItem ? selectToItem.primary_unit_of_measure : '-'" class="form-control">
                                        </dd>
                                    </div>
                                </dl>

                                <div class="text-center mt-3">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-success"
                                        v-on:click="save()"
                                    >
                                        <i class="fa fa-plus"></i> บันทึก
                                    </button>
                                    <!-- <button type="button" class="btn btn-white" data-dismiss="modal">ยกเลิก</button> -->
                                    <button type="button" class="btn btn-white" @click="closeModal(modalId)">ยกเลิก</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import uuidv1 from 'uuid/v1';
    import moment from "moment";
    import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../../dateUtils'
    export default {
    props: ["itemNumberList", "url", "item"],
        data() {
            return {
                isInRange, jsDateToString, toJSDate, toThDateString,

                modalId: uuidv1(),
                data: false,
                form: false,
                firstLoad: true,
                convertItems: [],
                selectToItem: false,
                loading: {
                    page: false,
                    convert_items: false,
                    form: false,
                    before_mount: false,
                },
                inputParams: {
                    from_organization_id_list: [],
                    from_subinv_list: [],
                    from_locator_id_list: [],

                    to_organization_id_list: [],
                    to_subinv_list: [],
                    to_locator_id_list: [],
                    to_inventory_item_id_list: [],
                    to_uom_list: [],
                    transaction_type_id_list: [],
                },
            };
        },
        beforeMount() {
            console.log('beforeMount');
            this.getInfo('');
        },
        mounted() {
            this.getConvertItemsInfo();
            // this.openModal()
        },
        computed: {
            // toItemDesc() {
            //     let vm = this;
            //     if ((vm.form.to_inventory_item_id != '' && vm.form.to_inventory_item_id != null) && vm.inputParams.to_inventory_item_id_list.length > 0) {
            //         let item = vm.inputParams.to_inventory_item_id_list.findIndex(o => o.value == vm.form.to_inventory_item_id);
            //         item = vm.inputParams.to_inventory_item_id_list[item];
            //         return item.item_desc
            //     } else {
            //         return '-';
            //     }
            // },
            // toUomDesc() {
            //     let vm = this;
            //     if ((vm.form.to_inventory_item_id != '' && vm.form.to_inventory_item_id != null) && vm.inputParams.to_inventory_item_id_list.length > 0) {
            //         let item = vm.inputParams.to_inventory_item_id_list.findIndex(o => o.value == vm.form.to_inventory_item_id);
            //         item = vm.inputParams.to_inventory_item_id_list[item];
            //         return item.primary_unit_of_measure
            //     } else {
            //         return '-';
            //     }
            // },
        },
        methods: {
            async selectToItemId() {
                let vm = this;

                vm.form.to_organization_id = '';
                vm.form.to_inventory_item_id = '';

                if ((vm.form.to_inventory_item_id_dummy != '' && vm.form.to_inventory_item_id_dummy != null) && vm.inputParams.to_inventory_item_id_list.length > 0) {
                    let item = await vm.inputParams.to_inventory_item_id_list.findIndex(o => o.value == vm.form.to_inventory_item_id_dummy);
                        item = vm.inputParams.to_inventory_item_id_list[item];
                    console.log('selectToItemIdselectToItemId',item, vm.form);
                    vm.selectToItem = item;
                    vm.form.to_organization_id = item.organization_id;
                    vm.form.to_inventory_item_id = item.inventory_item_id;
                } else {
                    vm.selectToItem = false;
                }
            },
            async openModal(convertItemId = '') {
                let vm = this;
                vm.getInfo(convertItemId)
                $('#'+ vm.modalId).modal('show');
            },
            async getConvertItemsInfo() {
                let vm = this;
                let params = {
                    from_inventory_item_id: vm.item.inventory_item_id,
                    action: 'get-convert-items-info',
                };

                let response = false;
                vm.loading.convert_items = true;

                await axios.get(vm.url.ajax_conversion_idx, { params }).then(res => {
                    res = res.data;
                    if (res.status == 'S') {
                        vm.convertItems =  res.data
                        if (vm.convertItems.length) {
                            vm.openModal(vm.convertItems[0].convert_item_id)
                        } else {
                            $('#'+ vm.modalId).modal('show');
                        }
                    }
                    vm.loading.convert_items = false;
                });
            },
            async getInfo(convertItemId = '') {
                let vm = this;

                let params = {
                    convert_item_id: convertItemId,
                    action: 'get-info',
                };

                let response = false;
                vm.loading.form = true;

                await axios.get(vm.url.ajax_conversion_idx, { params }).then(res => {
                    res = res.data;
                    console.log('getInfo', res, res.status, res.data.form);
                    if (res.status == 'S') {
                        vm.form =  res.data.form
                    }
                });


                vm.getParam();
            },
            async getParam(showLoading = true) {
                console.log('----------------->getParam')
                let vm = this;

                vm.item.inventory_item_id

                let response = false;
                let params = {
                    action:                 'search_get_param',
                    from_inventory_item_id: vm.item.inventory_item_id,
                    from_organization_id:   vm.item.organization_id,
                    // from_subinv:            vm.form.from_subinv,
                    // from_locator_id:        vm.form.from_locator_id,
                    to_organization_id:     vm.form.to_organization_id,
                    // to_subinv:              vm.form.to_subinv,
                    // to_locator_id:          vm.form.to_locator_id,
                    to_inventory_item_id:   vm.form.to_inventory_item_id,
                }

                await axios.get(vm.url.ajax_conversion_idx, { params }).then(res => {
                    response = res.data;
                    console.log('getParam', response);
                    if (response.status == 'S') {
                        vm.inputParams.from_organization_id_list    = response.data.from_organization_id_list;
                        vm.inputParams.from_subinv_list             = response.data.from_subinv_list;
                        vm.inputParams.from_locator_id_list         = response.data.from_locator_id_list;
                        vm.inputParams.to_organization_id_list      = response.data.to_organization_id_list;
                        vm.inputParams.to_subinv_list               = response.data.to_subinv_list;
                        vm.inputParams.to_locator_id_list           = response.data.to_locator_id_list;
                        vm.inputParams.to_inventory_item_id_list    = response.data.to_inventory_item_id_list;
                        vm.inputParams.to_uom_list                  = response.data.to_uom_list;
                        vm.inputParams.transaction_type_id_list     = response.data.transaction_type_id_list;
                    }
                    vm.firstLoad = false;
                });
                vm.loading.form = false;
                vm.selectToItemId();
            },
            async save(isShowNoti = true) {
                let vm = this;
                let confirm = true;
                let valid = true;
                let message = '';

                console.log('------------->', confirm)
                // from_organization_id คลังสำหรับทำรายการ
                if (vm.form.start_date == '') {
                    // message = `โปรดระบุ สัดส่วน % (Leaf Formula: ${o.leaf_formula} ${o.leaf_formula_desc})`;
                    // message = `โปรดระบุวันที่เริ่มต้นการใช้งาน`;
                    // await helperAlert.showGenericFailureDialog(message);
                    // valid = false;
                } else if (vm.form.from_organization_id == '') {
                    // message = `โปรดระบุ สัดส่วน % (Leaf Formula: ${o.leaf_formula} ${o.leaf_formula_desc})`;
                    // message = `โปรดระบุคลังสำหรับทำรายการ`;
                    // await helperAlert.showGenericFailureDialog(message);
                    // valid = false;
                } else if (vm.form.from_subinv == '') { // คลังต้นทาง from_subinv
                    // message = `โปรดระบุคลังต้นทาง`;
                    // await helperAlert.showGenericFailureDialog(message);
                    // valid = false;
                } else if (vm.form.from_locator_id == '') { // Locator from_locator_id
                    // message = `โปรดระบุคลังต้นทาง (Locator)`;
                    // await helperAlert.showGenericFailureDialog(message);
                    // valid = false;
                } else if (vm.form.transaction_type_id == '' || vm.form.transaction_type_id == null) { // ประเภทการทำรายการ transaction_type_id
                    // message = `โปรดระบุประเภทการทำรายการ`;
                    // await helperAlert.showGenericFailureDialog(message);
                    // valid = false;
                } else if (vm.form.to_subinv == '') { // คลังปลายทาง to_subinv
                    // message = `โปรดระบุคลังปลายทาง`;
                    // helperAlert.showGenericFailureDialog(message);
                    // valid = false;
                } else if (vm.form.to_locator_id == '') { // คลังปลายทาง to_locator_id
                    // message = `โปรดระบุคลังปลายทาง (Locator)`;
                    // await helperAlert.showGenericFailureDialog(message);
                    // valid = false;
                } else if (vm.form.to_organization_id == '') { // to_organization_id คลังสำหรับทำรายการปลายทาง
                    message = `โปรดระบุคลังสำหรับทำรายการปลายทาง`;
                    await helperAlert.showGenericFailureDialog(message);
                    valid = false;
                } else if (vm.form.to_inventory_item_id == '') { // Item ปลายทาง to_inventory_item_id
                    message = `โปรดระบุ Item ปลายทาง`;
                    await helperAlert.showGenericFailureDialog(message);
                    valid = false;
                } else if (vm.form.conversion_rate == '') { // อัตราส่วน conversion_rate
                    message = `โปรดระบุอัตราส่วน `;
                    await helperAlert.showGenericFailureDialog(message);
                    valid = false;
                }

                if ((parseFloat(vm.form.conversion_rate) <= 0)) { // อัตราส่วน conversion_rate
                    message = `โปรดระบุอัตราส่วน มากกว่าจำนวน 0 `;
                    await helperAlert.showGenericFailureDialog(message);
                    valid = false;
                }

                //  else if (vm.form.conversion_rate == '') { // to_uom
                //     message = `โปรดระบุหน่วยนับ`;
                //     await helperAlert.showGenericFailureDialog(message);
                //     valid = false;
                // }

                if (!valid) {
                    return;
                }

                confirm = await helperAlert.showProgressConfirm('กรุณายืนยันบันทึก');
                if (confirm) {

                    let input = JSON.parse(JSON.stringify(vm.form));
                        input.from_inventory_item_id    = vm.item.inventory_item_id;
                        input.from_uom                  = vm.item.primary_uom_code;
                        input.from_organization_id      = vm.item.organization_id;

                        input.to_inventory_item_number  = vm.selectToItem.item_number;
                        input.to_uom                    = vm.selectToItem.primary_uom_code;

                    await axios.post(vm.url.ajax_conversion_store, input)
                        .then(res => {
                            let data = res.data;
                            if (data.status == 'S') {
                                vm.hasChange = false;
                                swal({
                                    title: '&nbsp;',
                                    text: 'บันทึกข้อมูลสำเร็จ',
                                    type: "success",
                                    html: true
                                });
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
                            // swal.close();
                        });
                    // vm.loading.page = false;

                    // $('#'+ vm.modalId).modal('hide');
                    vm.closeModal(vm.modalId)
                    vm.getConvertItemsInfo();
                }


                return;
            },
            async closeModal(modalId) {
                this.$emit("closwShowRate", true);
                $('#'+ modalId).modal('hide');
            }
        }
    };
</script>