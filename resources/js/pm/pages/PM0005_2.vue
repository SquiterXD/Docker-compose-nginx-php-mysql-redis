<template>
    <div ref="mainForm">
        <!--        <pre style="display: none">{{ JSON.stringify({header, lines, user}, null, 2) }}</pre>-->
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h5>Request Header <small>การขอเบิกวัตถุดิบนอกแผน</small></h5>
                                </div>
                                <div class="col-lg-6">
                                    <div class="text-right">
                                        <button class="btn btn-w-m btn-success"
                                                @click.prevent="createNew">
                                            <i class="fa fa-plus"></i> สร้าง
                                        </button>
                                        <button
                                            type="submit" class="btn btn-primary"
                                            :disabled="!canSave"
                                            @click.prevent="save">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก
                                        </button>
                                        <button type="submit" class="btn btn-w-m btn-info">
                                            <i class="fa fa-print" aria-hidden="true"></i> พิมพ์รายงาน
                                        </button>
                                        <button
                                            type="submit" class="btn btn-primary"
                                            :disabled="!canTransfer"
                                            @click.prevent="confirmTransfer">
                                            <strong>ยืนยันขอโอนวัตถุดิบ</strong>
                                        </button>
                                        <button
                                            type="submit" class="btn btn-w-m btn-danger"
                                            :disabled="!canCancelTransfer"
                                            @click.prevent="">
                                            <i class="fa fa-times"></i> ยกเลิกการขอโอนวัตถุดิบ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-6 b-r">
                                    <h3 class="m-t-none m-b">ข้อมูล</h3>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label" for="lb-1">หน่วยงานที่ขอเบิก</label>
                                        <div class="col-lg-6">
                                            <input id="lb-1" type="text" class="form-control" name="department_code"
                                                   :disabled="true"
                                                   :value="user.department_code"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label" for="lb-2">เลขที่ใบเบิก</label>
                                        <div class="col-lg-6">
                                            <input id="lb-2" type="text" class="form-control" name="request_number"
                                                   :disabled="true"
                                                   :value="lodash.get(header, 'request_number')"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label" for="lb-3">วันที่ขอเบิก</label>
                                        <div class="col-lg-6">
                                            <input id="lb-3" type="date" class="form-control" autocomplete="off"
                                                   name="request_date"
                                                   :disabled="!canEditRequestDate"
                                                   v-model="headerModel.request_date">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Blend No.</label>
                                        <div class="col-lg-6">
                                            <el-select
                                                :disabled="!canEditItemNumberV"
                                                placeholder=""
                                                value-key="blend_no"
                                                :value="headerModel.inventory_item_id"
                                                filterable
                                                @change="selectInventoryItem">
                                                <el-option
                                                    v-for="item in header.item_number_v_list"
                                                    :key="JSON.stringify(item)"
                                                    :label="item.blend_no"
                                                    :value="item.inventory_item_id">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">สินค้าที่จะผลิต</label>
                                        <div class="col-lg-6">
                                            <el-select
                                                :disabled="!canEditItemNumberV"
                                                placeholder=""
                                                value-key="blend_no"
                                                :value="headerModel.inventory_item_id"
                                                filterable
                                                @change="selectInventoryItem">
                                                <el-option
                                                    v-for="item in header.item_number_v_list"
                                                    :key="JSON.stringify(item)"
                                                    :label="item.item_desc"
                                                    :value="item.inventory_item_id">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">ประเภทวัตถุดิบ</label>
                                        <div class="col-lg-6">
                                            <el-select
                                                :disabled="!canEditIngredientGroup"
                                                placeholder=""
                                                value-key="ingredient_group"
                                                filterable
                                                :value="headerModel.ingredient_group"
                                                @change="onSelectItemClassificationCode">
                                                <el-option
                                                    v-for="item in header.item_classification_list"
                                                    :key="JSON.stringify(item)"
                                                    :label="item.item_classification"
                                                    :value="item.item_classification_code">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">ผู้ขอเบิก</label>
                                        <div class="col-lg-6">
                                            <input type="hidden" class="form-control" autocomplete="off"
                                                   disabled="disabled" name="user_id" :value="user.user_id">
                                            <input type="text" class="form-control" autocomplete="off"
                                                   disabled="disabled" :value="user.name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">วัตถุประสงค์ในการเบิก</label>
                                        <div class="col-lg-6">
                                            <el-select
                                                :disabled="!canEditObjectiveCode"
                                                placeholder=""
                                                value-key="objective_code"
                                                v-model="headerModel.objective_code"
                                                filterable>
                                                <el-option
                                                    v-for="item in header.objective_request_list"
                                                    :key="JSON.stringify(item)"
                                                    :label="item.description"
                                                    :value="item.lookup_code">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">สถานะขอเบิก</label>
                                        <div class="col-lg-6">
                                            <input
                                                v-if="!hasHeader"
                                                type="text" class="form-control" autocomplete="off" :disabled="true">
                                            <el-select
                                                v-else
                                                :disabled="!canEditRequestStatus"
                                                placeholder=""
                                                value-key="request_status"
                                                v-model="headerModel.request_status"
                                                filterable>
                                                <el-option
                                                    v-for="item in header.request_transfer_status_list"
                                                    :key="JSON.stringify(item)"
                                                    :label="item.description"
                                                    :value="item.lookup_code">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">วันที่นำส่ง ยสท.</label>
                                        <div class="col-lg-6">
                                            <input type="date" class="form-control" autocomplete="off" name="send_date"
                                                   :min="headerModel.request_date"
                                                   :disabled="!canEditSendDate"
                                                   v-model="headerModel.send_date"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <div class="text-right">
                                <button
                                    class="btn btn-w-m btn-success"
                                    @click.prevent="addNewLine"
                                    :disabled="!canAddLine">
                                    <i class="fa fa-plus"></i><strong> เพิ่มรายการ</strong>
                                </button>
                                <button class="btn btn-danger"
                                        @click.prevent="removeSelectedLines"
                                        :disabled="!canDeleteLines">
                                    <strong><i class="fa fa-times"></i> ลบรายการ</strong>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox">
                                    <div
                                        v-if="headerModel.ingredient_group === '01'"
                                        class="ibox-title">
                                        <div class="">
                                            <button
                                                v-for="item in tag_list"
                                                type="submit"
                                                :class="'btn btn-sm m-t-n-xs mr-1 ' + (tag === item.type_code ? 'btn-primary' : 'btn-outline-primary')"
                                                @click="onTagSelect(item.type_code)">
                                                {{ item.type_desc }}
                                            </button>
                                        </div>
                                    </div>

                                    <!--                                    <ul><li>***</li>-->
                                    <!--                                    <li v-for="(line, i) in lineModels" v-bind:key="line.rnd">-->
                                    <!--                                        {{ line.rnd }}-->
                                    <!--                                    </li>-->
                                    <!--                                    </ul>-->
                                    <!--                                    {{ lineModels.length }}-->
                                    <!--                                    {{ lineModels.length > 0 }}-->

                                    <div class="ibox-content">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="">
                                                <th>
                                                    <input
                                                        :disabled="lineModels.length === 0 || hasInventoryItemId"
                                                        type="checkbox"
                                                        :value="lineSelectAll"
                                                        @change="() => {
                                                                lineSelectAll = !lineSelectAll
                                                                lineModels = lineModels.map(it => ({
                                                                    ...it,
                                                                    isSelected: lineSelectAll,
                                                                }))
                                                            }"/>
                                                </th>
                                                <!--<th>#</th>-->
                                                <th class="" v-for="(header, i) in linesHeader" v-bind:key="i">
                                                    <!--                                                    <div><small>{{ i + 1 }}</small></div>-->
                                                    <div>{{ header }}</div>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody v-if="lineModels.length > 0">
                                            <tr v-for="(line, i) in lineModels"
                                                :class="{'row-new-record': line.newRecord, 'row-selected-record': line.isSelected}"
                                                v-bind:key="line.rnd">
                                                <td>
                                                    <input type="checkbox"
                                                           :disabled="hasInventoryItemId"
                                                           v-model="line.isSelected"/>
                                                </td>

                                                <!-- 1 itemNumber-->
                                                <!--รหัสวัตถุดิบ-->
                                                <td class="col-readonly" v-if="inventory_item_id">
                                                    {{ line.itemNumber }}
                                                </td>
                                                <td v-else>
                                                    <el-select
                                                        placeholder=""
                                                        filterable
                                                        v-model="line.itemNumber"
                                                        @change="(item) => onSelectItemLine(i, item)">
                                                        <el-option
                                                            v-for="item in linesSrc"
                                                            :key="JSON.stringify(item)"
                                                            :label="item.itemNumber"
                                                            :value="item">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <!-- 2 itemDesc-->
                                                <!--รายละเอียด-->
                                                <td class="col-readonly">
                                                    {{ line.itemDesc }}
                                                </td>
                                                <!-- 3 lotNumbeer -->
                                                <!-- Lot -->
                                                <td class="col-readonly">
                                                    {{ line.lotNumber }}
                                                </td>


                                                <!-- 4 onhandQty -->
                                                <!-- คงคลังฝ่ายจัดหา -->
                                                <td class="col-readonly">
                                                    {{ line.onhandQty }}
                                                </td>
                                                <!-- 5 primaryQty -->
                                                <!-- ปริมาณเบิก -->
                                                <td class="input-text">
                                                    <input
                                                        type="number"
                                                        v-model.number="line.primaryQty"
                                                        @input="
                                                            line.isSelected = true
                                                            line.secondaryQty = +($event.target.value) / +lodash.get(line, 'item_conv_uom_v.conversion_rate')
                                                            hasLinesModified = true
                                                        "/>
                                                </td>
                                                <!-- 6 primaryUom -->
                                                <!-- หน่วยเบิก -->
                                                <td>
                                                    {{ line.primaryUom }}
                                                </td>
                                                <!-- 7 secondaryQty -->
                                                <!-- ปริมาณเบิก2 -->
                                                <td class="input-text">
                                                    <input
                                                        type="number"
                                                        v-model.number="line.secondaryQty"
                                                        @input="
                                                            line.isSelected = true
                                                            line.primaryQty = +($event.target.value) * +lodash.get(line, 'item_conv_uom_v.conversion_rate')
                                                            hasLinesModified = true
                                                        "/>
                                                </td>
                                                <!-- 8 secondaryUom -->
                                                <!-- หน่วยเบิก2 -->
                                                <td>
                                                    <el-select
                                                        placeholder=""
                                                        filterable
                                                        :value="line.secondaryUom"
                                                        @change="(item) => lineUomChange(i, item)">
                                                        <el-option
                                                            v-for="item in line.item_conv_uom_v_list"
                                                            :key="JSON.stringify(item)"
                                                            :label="item.from_uom_code"
                                                            :value="item.from_uom_code">
                                                        </el-option>
                                                    </el-select>
                                                </td>

                                                <!-- 9 remarkMsg -->
                                                <!-- หมายเหตุ -->
                                                <td>
                                                    <button
                                                        type="button"
                                                        data-toggle="modal"
                                                        :data-target="`#remark-msg-${i}`"
                                                        class="btn btn-info">
                                                        หมายเหตุ
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" :id="`remark-msg-${i}`" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">หมายเหตุ</h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div>
                                                                        <textarea
                                                                            style="width: 100%;"
                                                                            class="form-control"
                                                                            v-model="line.remarkMsg"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-center" v-if="lineModels.length === 0">
                                            <span class="lead">No Data.</span>
                                        </div>
                                    </div>
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
import {instance as http} from "../httpClient"

import {
    showLoadingDialog,
    showProgressWithUnsavedChangesWarningDialog,
    showValidationFailedDialog,
} from "../../commonDialogs"

import {$route, api_pm_0005_confirmTransfer, api_pm_0005_save, pm_0005_index,} from '../../router'

import _get from 'lodash/get'
import _set from 'lodash/set'
import _clone from 'lodash/cloneDeep'

function mappingHeader(header) {
    return {
        ...header,
        item_number_v: {
            blend_no: null,
            inventory_item_id: null,
            item_desc: null,
            item_number: null,
        },
    }
}

function mappingLine(line) {
    return {
        rnd: _get(line, 'rnd', Math.random()),
        isSelected: false,
        itemNumber: _get(line, 'itemNumber', null),
        itemDesc: _get(line, 'itemDesc', null),
        lotNumber: _get(line, 'lotNumber', null),
        onhandQty: _get(line, 'onhandQty', null),
        primaryQty: _get(line, 'primaryQty', null),
        primaryUom: _get(line, 'primaryUom', null),
        secondaryQty: _get(line, 'secondaryQty', null),
        secondaryUom: _get(line, 'secondaryUom', null),
        remarkMsg: _get(line, 'remarkMsg', null),
        item_conv_uom_v: _get(line, 'item_conv_uom_v', null),
        item_conv_uom_v_list: _get(line, 'item_conv_uom_v_list', null),
    }
}

function save(header, lines) {
    return http.post($route(api_pm_0005_save), {header, lines}).then(({data}) => {
        return data
    })
}

function confirmTransfer(header, lines) {
    return http.post($route(api_pm_0005_confirmTransfer), {header, lines}).then(({data}) => {
        return data
    })
}


export default {
    created: function () {
        console.log('!! created !!')
    },
    mounted() {
        console.log('!! mounted !!')
        let inventory_item_id = _get(this.headerModel, 'inventory_item_id')
        this.headerModel.item_number_v = _get(this.header.item_number_v_list.filter(it => it.inventory_item_id === inventory_item_id), '[0]')

        if (isNaN(this.headerModel.request_status)) {
            this.headerModel.request_status = _get(this.header.request_transfer_status_list.filter(it => it.description === this.headerModel.request_status), '[0].lookup_code')
        }

        this.headerModel.ingredient_group = _get(this.header, 'item_classification.item_classification_code')
        this.headerModel.objective_code = _get(this.header, 'objective_request.lookup_code')
        this.headerModel.request_status = _get(this.header, 'request_transfer_status.lookup_code')

        if (this.hasInventoryItemId) {
            this.lineModels = this.lineModels.map(it => {
                return {
                    ...it,
                    isSelected: true,
                }
            })
        }

        // this.updateFilterLines()
        //
        // this.lineModels = this.lineModels.filter(it => {
        //     if (!_get(this.headerModel, 'request_header_id')) return it
        //     return it.transaction_quantity && it.secondary_qty
        // })
    },
    props: {
        inventory_item_id: {default: null},
        user: {type: Object},
        header: {type: Object},
        lines: {type: Array},
        // mfg_formula_v_list: {type: Array},
        // item_number_v_list: {type: Array},
        // item_classification_list: {type: Array},
        tag_list: {type: Array},
        // objective_request_list: {type: Array},
        // request_transfer_status_list: {type: Array},

        lines_src: {type: Array},
    },
    data() {
        return {

            lodash: {
                get: _get,
                set: _set,
            },

            dialog: {
                showProgressWithUnsavedChangesWarningDialog,
            },

            linesHeader: [
                "รหัสวัตถุดิบ", "รายละเอียด", "Lot",
                "คงคลังฝ่ายจัดหา", "ปริมาณเบิก", "หน่วยเบิก",
                "ปริมาณเบิก", "หน่วยเบิก",
                "หมายเหตุ",
            ],

            headerModel: {
                ...mappingHeader(this.header),
                ingredient_group: _get(this.header, 'ingredient_group', _get(this.item_classification_list, '[0].item_classification_code')),
                objective_code: _get(this.header, 'objective_code', '3'),
                request_status: _get(this.header, 'request_transfer_status', '1'),
            },
            lineModels: [
                //mappingLine({}),
                ...this.lines
            ],
            tag: _get(this.tag_list, '[0].type_code'),

            lineSelectAll: false,
            hasLinesModified: false,
        }
    },
    computed: {
        hasHeader() {
            return !!_get(this.header, 'request_header_id', false)
        },
        hasInventoryItemId() {
            return !!this.inventory_item_id
        },
        linesSrc() {

            let inventory_item_id = _get(this.headerModel, 'inventory_item_id', null)
            let item_classification_code = _get(this.headerModel, 'ingredient_group', null)
            let tobacco_type_code = this.tag

            console.log('linesSrc', {
                inventory_item_id,
                item_classification_code,
                tobacco_type_code,
            })

            let newLineList = this.lines_src
                .filter(it => {
                    //console.log('f--> ', it.productItemId, it.itemClassificationCode, it.tobaccoTypeCode)
                    if (inventory_item_id && inventory_item_id !== it.productItemId) return false
                    if (item_classification_code && item_classification_code !== it.itemClassificationCode) return false
                    if (tobacco_type_code && tobacco_type_code !== it.tobaccoTypeCode) return false
                    return true
                })

            console.log('newLineList', newLineList.length, newLineList)

            return newLineList
        },
        isRequestStatusEquals_1() {
            return +(this.headerModel.request_status) === 1 || this.headerModel.request_status === 'ยังไม่ส่งข้อมูล'
        },
        canSave() {
            return this.isRequestStatusEquals_1 && this.lineModels.filter(line => line.isSelected).length > 0
        },
        canTransfer() {
            return !_get(this.headerModel, 'request_header_id', false) && !this.hasLinesModified
        },
        canCancelTransfer() {
            return +(_get(this.headerModel, 'request_status')) !== 1
        },
        canEditRequestDate() {
            return this.isRequestStatusEquals_1
        },
        canEditItemNumberV() {
            return this.isRequestStatusEquals_1
        },
        canEditIngredientGroup() {
            return this.isRequestStatusEquals_1
        },
        canEditObjectiveCode() {
            return this.isRequestStatusEquals_1
        },
        canEditRequestStatus() {
            return this.isRequestStatusEquals_1
        },
        canEditSendDate() {
            return this.isRequestStatusEquals_1
        },
        canAddLine() {
            return !this.hasHeader && !this.hasInventoryItemId
        },
        canDeleteLines() {
            return !this.hasHeader && !this.hasInventoryItemId
        },
    },
    methods: {
        createNew() {
            window.location = $route(pm_0005_index)
        },

        save() {

            let header = {
                ..._clone(this.headerModel),
            }

            let lines = _clone(this.lineModels)
                .filter(it => it.isSelected)
                .map(it => {
                    return {...it,}
                })

            console.log('$save', header, lines)

            if (lines.length > 0 && lines.filter(it => !(it.primaryQty > 0 && it.secondaryQty > 0)).length > 0) {
                return showValidationFailedDialog(['ต้องกรอกจำนวนปริมาณเบิกที่เลือก'])
            }

            showLoadingDialog();

            save(header, lines)
                .then(async ({header, lines}) => {

                    this.headerModel = {
                        ...this.headerModel,
                        ...mappingHeader(header),
                    }

                    this.hasLinesModified = false

                    await swal({
                        title: "สำเร็จ",
                        text: "บันทึกข้อมูลเรียบร้อย",
                        icon: "success",
                        button: "ตกลง",
                    })

                    //window.location = $route(pm_0005_index, {id: header.request_header_id})
                })
                .catch(async (err) => {
                    console.error(err)
                    await swal({
                        title: "มีข้อผิดพลาด",
                        text: err.toString(),
                        icon: "error",
                        button: "ตกลง",
                    })
                })
        },

        async confirmTransfer() {
            if (this.hasLinesModified && !(await showValidationFailedDialog(['ต้องบันทึกข้อมูลก่อนโอนวัตถุดิบ']))) return

            await showLoadingDialog();
            confirmTransfer(this.headerModel, this.lineModels)
                .then(async ({header}) => {

                    this.headerModel = {
                        ...this.headerModel,
                        ...header,
                    }

                    await swal({
                        title: "สำเร็จ",
                        text: "บันทึกข้อมูลเรียบร้อย",
                        icon: "success",
                        button: "ตกลง",
                    })
                })
                .catch(async (err) => {
                    console.error(err)
                    await swal({
                        title: "มีข้อผิดพลาด",
                        text: err.toString(),
                        icon: "error",
                        button: "ตกลง",
                    })
                })
        },


        async selectInventoryItem(inventory_item_id) {
            if (this.hasLinesModified && !(await showProgressWithUnsavedChangesWarningDialog())) return

            this.headerModel.item_number_v = _get(this.header.item_number_v_list.filter(it => it.inventory_item_id === inventory_item_id), '[0]')
            let params = {
                inventory_item_id: inventory_item_id,
            }
            showLoadingDialog()
            window.location = $route(pm_0005_index) + '?' + (new URLSearchParams(params).toString())

            // this.headerModel = {
            //     ...this.headerModel,
            //     item_number_v: item,
            //     inventory_item_id: item.inventory_item_id,
            // }
            //
            // await this.updateFilterLines()
        },
        async onSelectItemClassificationCode(item_classification_code) {
            let item_classification = _get(this.header.item_classification_list.filter(it => it.item_classification_code === item_classification_code), '[0]')
            console.log('onSelectItemClassificationCode', item_classification)

            if (this.hasLinesModified && !(await showProgressWithUnsavedChangesWarningDialog())) return

            this.headerModel.item_classification = item_classification
            this.headerModel.ingredient_group = _get(item_classification, 'item_classification_code')

            if (this.headerModel.ingredient_group !== '01') {
                this.tag = null
            } else {
                this.tag = _get(this.tag_list, '[0].type_code')
            }

            if (!this.hasInventoryItemId) {
                this.lineModels = []
                return
            }
            await this.updateFilterLines()
        },
        async onTagSelect(type_code) {

            if (this.hasLinesModified && !(await showProgressWithUnsavedChangesWarningDialog())) return

            if (this.headerModel.ingredient_group === '01') {
                this.tag = type_code
            } else {
                this.tag = null
            }
            await this.updateFilterLines()
        },
        async updateFilterLines() {

            let inventory_item_id = _get(this.headerModel, 'inventory_item_id', null)
            let item_classification_code = _get(this.headerModel, 'ingredient_group', null)
            let tobacco_type_code = this.tag

            console.log('updateFilterLines', {
                inventory_item_id,
                item_classification_code,
                tobacco_type_code,
            })

            let newLineList = this.lines_src
                .filter(it => {
                    if (inventory_item_id && inventory_item_id !== it.productItemId) return false
                    if (item_classification_code && item_classification_code !== it.itemClassificationCode) return false
                    if (tobacco_type_code && tobacco_type_code !== it.tobaccoTypeCode) return false
                    return true
                })

            console.log('newLineList', newLineList.length, newLineList)

            this.lineModels = newLineList
        },

        onSelectItemLine(i, item) {
            console.log('onSelectItemLine', i, item)
            this.lineModels[i] = {
                ...this.lineModels[i],
                ...item,
            }
        },

        addNewLine() {
            this.lineModels.push(mappingLine({}))
            this.lineModels = _clone(this.lineModels)

            this.hasLinesModified = true
        },
        removeSelectedLines() {
            this.lineModels = this.lineModels.filter(it => !it.isSelected)
        },

        lineUomChange(i, from_uom_code) {
            let item_conv_uom_v_list = _clone(this.lineModels[i].item_conv_uom_v_list)
            let item_conv_uom_v = _clone(this.lineModels[i].item_conv_uom_v_list.filter(it => it.from_uom_code === from_uom_code)[0])
            console.log('lineUomChange1', {
                from_uom_code,
                item_conv_uom_v_list,
                item_conv_uom_v,
            })
            this.lineModels[i] = {
                ...this.lineModels[i],
                item_conv_uom_v,
                item_conv_uom_v_list,
                secondaryQty: this.lineModels[i].primaryQty / item_conv_uom_v.conversion_rate,
                secondaryUom: item_conv_uom_v.from_uom_code,
            }
            console.log('lineUomChange2', this.lineModels[i])
            this.lineModels = [...this.lineModels]
        },
    },
}

</script>

<style scoped>

td.input-text {
    padding: 0;
    margin: 0;
}

td.input-text input {
    margin: 1px;
    border: none;
    width: 100%;
    min-height: 48px;
}

.col-readonly {
    background: #f5f5f5;
}

.row-new-record {
    background: #fffbeb;
}

.row-new-record .col-readonly {
    background: #f3efe0;
}

.row-selected-record {
    background: #dbdbdb;
}

.ibox-title {
    padding: 15px 20px 15px 20px;
}

.el-select {
    width: 100%;
}

</style>
