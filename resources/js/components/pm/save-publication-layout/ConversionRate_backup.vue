<template>
    <div>
        <div>
            <button class="btn btn-sm btn-primary pull-right" type="button" @click="openModal()">
                <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ
            </button>
            <h3><strong>รายละเอียดข้าม Item</strong></h3>
        </div>

        <div class="table-responsive mt-3" style="max-height: 600px;"  v-loading="loading.convert_items">
            <!-- <table class="table table-bordered table-sticky mb-0" style="min-width: 800px;"> -->
            <table class="table table-bordered table-sticky mb-0" >

                <thead>
                    <tr>
                        <th colspan="2"  class="text-center align-middle">
                            วันที่
                        </th>
                        <th colspan="2"  class="text-center align-middle">
                            คลังต้นทาง
                        </th>
                        <th width="50px;" rowspan="2"></th>
                        <th colspan="6"  class="text-center align-middle">
                            คลังปลายทาง
                        </th>
                        <th rowspan="2"  class="text-center align-middle">
                        </th>
                    </tr>
                    <tr>
                        <th style="min-width: 120px;"  class="text-left align-middle">
                            เริ่มต้นการใช้งาน
                        </th>
                        <th style="min-width: 120px;" class="text-left align-middle">
                            เลิกใช้งาน
                        </th>

                        <!-- คลังต้นทาง -->
                        <th style="min-width: 120px;"  class="text-left align-middle">
                            คลังทำรายการ
                        </th>
                        <th style="min-width: 120px;" class="text-left align-middle">
                            คลัง
                        </th>


                        <!-- คลังต้นปลายทาง -->
                        <th style="min-width: 120px;" class="text-left align-middle">
                            คลังทำรายการ
                        </th>
                        <th style="min-width: 120px;" class="text-left align-middle">
                            คลัง
                        </th>
                        <th  class="text-left align-middle">
                            ประเภทการทำรายการ
                        </th>
                        <th  class="text-left align-middle">
                            Item
                        </th>
                        <th  class="text-right align-middle">
                            อัตราส่วน
                        </th>
                        <th  class="text-left align-middle">
                            หน่วยนับ
                        </th>
                    </tr>
                </thead>
                <tbody v-if="convertItems.length > 0">
                    <template v-for="o in convertItems">
                    <tr>
                        <td class="text-left">
                            {{ o.start_date_display }}
                        </td>
                        <td class="text-left">
                            {{ o.end_date_display }}
                        </td>


                        <td class="text-left font-weight-bold text-navy">
                            {{ o.from_organization_display }}
                        </td>
                        <td class="text-left font-weight-bold text-navy" :title="o.from_subinv_display">
                            {{ o.from_locator_display }}
                        </td>

                        <td class="font-weight-bold text-success text-center align-middle">
                            <i class="fa fa-arrow-circle-o-right fa-2x"></i>
                        </td>

                        <!-- คลังต้นปลายทาง -->
                        <td class="text-left font-weight-bold text-success">
                            {{ o.to_organization_display }}
                        </td>
                        <td class="text-left font-weight-bold text-success" :title="o.to_subinv_display">
                            {{ o.to_locator_display }}
                        </td>
                        <td class="text-left">
                            {{ o.transaction_type_display }}
                        </td>
                        <td class="text-left">
                            {{ o.to_inventory_item_display }}
                        </td>
                        <td class="text-right font-weight-bold">
                            {{ o.conversion_rate_display }}
                        </td>
                        <td class="text-left font-weight-bold">
                            {{ o.to_uom_display }}
                        </td>
                        <td style="min-width: 90px;" class="text-center font-weight-bold">
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
        <div class="modal fade" :id="modalId" aria-hidden="true" >
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title text-center">รายละเอียดข้าม Item</h1>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body" v-if="!loading.form && form != false">
                        <div class="row">
                            <div class="form-group pl-12 pr-2 mb-0 col-10 offset-1 mt-2">
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="control-label mb-2"><strong>วันที่เริ่มต้นการใช้งาน </strong> <span class="text-danger">*</span></div>

                                        <ct-datepicker
                                            class="my-1 form-control form-control col-12"
                                            style="width: 100%;"
                                            placeholder="โปรดเลือกวันที่"
                                            :value="toJSDate(form.start_date, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                            form.start_date = jsDateToString(date)
                                        }"
                                        />
                                    </div>
                                    <div class="col-6">
                                        <div class="control-label mb-2"><strong>วันที่เลิกใช้งาน </strong> </div>
                                        <ct-datepicker
                                            class="my-1 form-control form-control col-12"
                                            style="width: 100%;"
                                            placeholder="โปรดเลือกวันที่"
                                            :enableDate="date => isInRange(date, form.start_date, null, true)"
                                            :value="toJSDate(form.end_date, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                            form.end_date = jsDateToString(date)
                                        }"
                                        />
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <h1 class="font-weight-bold text-navy text-center">คลังต้นทาง</h1>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-label mb-2"><strong> คลังสำหรับทำรายการ </strong> <span class="text-danger">*</span></div>
                                        <el-select :popper-append-to-body="false"
                                            class=""
                                            style="width: 100%"
                                            placeholder=""
                                            v-model="form.from_organization_id"
                                            @change="(value)=>{
                                                getParam()
                                                if (value) {
                                                } else {
                                                    form.from_subinv = ''
                                                    form.from_locator_id = ''
                                                }
                                            }"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in inputParams.from_organization_id_list"
                                                :key="Number(item.value)"
                                                :label="item.label"
                                                :value="Number(item.value)">
                                                <span style="float: left">{{ item.label }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row mt-2" v-if="form.from_subinv != undefined">
                                    <div class="col-6">
                                        <div class="control-label mb-2"><strong> คลังต้นทาง </strong> <span class="text-danger">*</span></div>
                                        <el-select :popper-append-to-body="false"
                                            class=""
                                            style="width: 100%"
                                            placeholder=""
                                            v-model="form.from_subinv"
                                            :disabled="! form.from_organization_id"
                                            @change="(value)=>{
                                                getParam()
                                                if (value ) {
                                                } else {
                                                    form.from_locator_id = ''
                                                }
                                            }"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in inputParams.from_subinv_list"
                                                :key="(item.value)"
                                                :label="item.label"
                                                :value="(item.value)">
                                                <span style="float: left">{{ item.label }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="col-6" v-if="form.from_locator_id != undefined">
                                        <div class="control-label mb-2">&nbsp;</div>
                                        <el-select :popper-append-to-body="false"
                                            class=""
                                            style="width: 100%"
                                            placeholder=""
                                            v-model="form.from_locator_id"
                                            :disabled="! form.from_organization_id"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in inputParams.from_locator_id_list"
                                                :key="(item.value)"
                                                :label="item.label"
                                                :value="(item.value)">
                                                <span style="float: left">{{ item.label }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <h1 class="font-weight-bold text-success text-center">คลังปลายทาง</h1>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-label mb-2"><strong> คลังสำหรับทำรายการปลายทาง </strong> <span class="text-danger">*</span></div>
                                        <el-select :popper-append-to-body="false"
                                            class=""
                                            style="width: 100%"
                                            placeholder=""
                                            v-model="form.to_organization_id"
                                            @change="(value)=>{
                                                getParam()
                                                if (value) {
                                                } else {
                                                    form.to_subinv = ''
                                                    form.to_locator_id = ''
                                                }
                                            }"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in inputParams.to_organization_id_list"
                                                :key="Number(item.value)"
                                                :label="item.label"
                                                :value="Number(item.value)">
                                                <span style="float: left">{{ item.label }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="control-label mb-2"><strong> คลังปลายทาง </strong> <span class="text-danger">*</span></div>
                                        <el-select :popper-append-to-body="false"
                                            class=""
                                            style="width: 100%"
                                            placeholder=""
                                            v-model="form.to_subinv"
                                            :disabled="! form.to_organization_id"
                                            @change="(value)=>{
                                                getParam()
                                                if (value) {
                                                } else {
                                                    form.to_locator_id = ''
                                                }
                                            }"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in inputParams.to_subinv_list"
                                                :key="(item.value)"
                                                :label="item.label"
                                                :value="(item.value)">
                                                <span style="float: left">{{ item.label }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-label mb-2">&nbsp;</div>
                                        <el-select :popper-append-to-body="false"
                                            class=""
                                            style="width: 100%"
                                            placeholder=""
                                            v-model="form.to_locator_id"
                                            :disabled="! form.to_organization_id"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in inputParams.to_locator_id_list"
                                                :key="(item.value)"
                                                :label="item.label"
                                                :value="(item.value)">
                                                <span style="float: left">{{ item.label }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="control-label mb-2"><strong> ประเภทการทำรายการ </strong> <span class="text-danger">*</span></div>
                                        <el-select :popper-append-to-body="false"
                                            class=""
                                            style="width: 100%"
                                            placeholder=""
                                            v-model="form.transaction_type_id"
                                            :disabled="! form.to_organization_id"
                                            @change="(value)=>{
                                                getParam()
                                                if (value) {
                                                } else {
                                                    form.to_uom = ''
                                                }
                                            }"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in inputParams.transaction_type_id_list"
                                                :key="(item.value)"
                                                :label="item.label"
                                                :value="(item.value)">
                                                <span style="float: left">{{ item.label }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-label mb-2">&nbsp;</div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="control-label mb-2"><strong> Item ปลายทาง </strong> <span class="text-danger">*</span></div>
                                        <el-select :popper-append-to-body="false"
                                            class=""
                                            style="width: 100%"
                                            placeholder=""
                                            v-model="form.to_inventory_item_id"
                                            :disabled="! form.to_organization_id"
                                            @change="(value)=>{
                                                getParam()
                                                if (value) {
                                                } else {
                                                    form.to_uom = ''
                                                }
                                            }"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in inputParams.to_inventory_item_id_list"
                                                :key="(item.value)"
                                                :label="item.item_number"
                                                :value="(item.value)">
                                                <span style="float: left">{{ item.label }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-label mb-2">&nbsp;</div>
                                        <el-input style="width: 100%" disabled
                                            :value="(()=>{
                                            let vm = this;
                                            if ((vm.form.to_inventory_item_id != '' && vm.form.to_inventory_item_id != null) && vm.inputParams.to_inventory_item_id_list.length > 0 ) {
                                                let item = vm.inputParams.to_inventory_item_id_list.findIndex(o => o.value == vm.form.to_inventory_item_id);
                                                    item = vm.inputParams.to_inventory_item_id_list[item];
                                                return item.item_desc
                                            } else {
                                                return ''
                                            }
                                           })()"
                                        ></el-input>
                                    </div>
                                </div>

                                <!-- to_inventory_item_id -->
                                <div class="row mt-2" v-if="form.to_uom != undefined">
                                    <div class="col-6">
                                        <div class="control-label mb-2"><strong>อัตราส่วน </strong> <span class="text-danger">*</span></div>
                                        <vue-numeric
                                            :disabled="! form.to_inventory_item_id"
                                            placeholder=""
                                            separator=","
                                            v-bind:precision="0"
                                            v-bind:minus="false"
                                            class="form-control w-100 text-right"
                                            v-model="form.conversion_rate"
                                        ></vue-numeric>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-label mb-2">&nbsp;</div>
                                        <el-select :popper-append-to-body="false"
                                            class=""
                                            style="width: 100%"
                                            placeholder=""
                                            v-model="form.to_uom"
                                            :disabled="! form.to_inventory_item_id"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in inputParams.to_uom_list"
                                                :key="(item.value)"
                                                :label="item.label"
                                                :value="(item.value)">
                                                <span style="float: left">{{ item.label }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="text-center mt-3">
                            <button
                                type="button"
                                class="btn btn-sm btn-success"
                                v-on:click="save()"
                            >
                                <i class="fa fa-plus"></i> บันทึก
                            </button>
                            <button type="button" class="btn btn-white" data-dismiss="modal">ยกเลิก</button>
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
        },
        methods: {
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

                let response = false;
                let params = {
                    action:                 'search_get_param',
                    from_organization_id:   vm.form.from_organization_id,
                    from_subinv:            vm.form.from_subinv,
                    from_locator_id:        vm.form.from_locator_id,
                    to_organization_id:     vm.form.to_organization_id,
                    to_subinv:              vm.form.to_subinv,
                    to_locator_id:          vm.form.to_locator_id,
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
                    message = `โปรดระบุวันที่เริ่มต้นการใช้งาน`;
                    await helperAlert.showGenericFailureDialog(message);
                    valid = false;
                } else if (vm.form.from_organization_id == '') {
                    // message = `โปรดระบุ สัดส่วน % (Leaf Formula: ${o.leaf_formula} ${o.leaf_formula_desc})`;
                    message = `โปรดระบุคลังสำหรับทำรายการ`;
                    await helperAlert.showGenericFailureDialog(message);
                    valid = false;
                } else if (vm.form.from_subinv == '') { // คลังต้นทาง from_subinv
                    message = `โปรดระบุคลังต้นทาง`;
                    await helperAlert.showGenericFailureDialog(message);
                    valid = false;
                } else if (vm.form.from_locator_id == '') { // Locator from_locator_id
                    message = `โปรดระบุคลังต้นทาง (Locator)`;
                    await helperAlert.showGenericFailureDialog(message);
                    valid = false;
                } else if (vm.form.transaction_type_id == '' || vm.form.transaction_type_id == null) { // ประเภทการทำรายการ transaction_type_id
                    message = `โปรดระบุประเภทการทำรายการ`;
                    await helperAlert.showGenericFailureDialog(message);
                    valid = false;
                } else if (vm.form.to_subinv == '') { // คลังปลายทาง to_subinv
                    message = `โปรดระบุคลังปลายทาง`;
                    helperAlert.showGenericFailureDialog(message);
                    valid = false;
                } else if (vm.form.to_locator_id == '') { // คลังปลายทาง to_locator_id
                    message = `โปรดระบุคลังปลายทาง (Locator)`;
                    await helperAlert.showGenericFailureDialog(message);
                    valid = false;
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
                } else if (vm.form.conversion_rate == '') { // to_uom
                    message = `โปรดระบุหน่วยนับ`;
                    await helperAlert.showGenericFailureDialog(message);
                    valid = false;
                }

                console.log('xx', message);

                if (!valid) {
                    return;
                }

                confirm = await helperAlert.showProgressConfirm('กรุณายืนยันบันทึก');
                if (confirm) {

                    let input = JSON.parse(JSON.stringify(vm.form));
                        input.from_inventory_item_id = vm.item.inventory_item_id;
                        input.from_uom = vm.item.primary_uom_code;

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

                    $('#'+ vm.modalId).modal('hide');
                    vm.getConvertItemsInfo();
                }


                return;
            },
        }
    };
</script>