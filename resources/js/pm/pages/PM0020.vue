<!--suppress ALL -->
<template>
    <form @submit.prevent="onSaveButtonClicked" ref="mainForm">
        <div>
            <!--            <div class="form-group row">-->
            <!--                <pre class="col-lg-6" style="display: block">{{-->
            <!--                    JSON.stringify({-->
            <!--                        ingredientRequest,-->
            <!--                    }, null, 2)-->
            <!--                }}</pre>-->
            <!--                -->
            <!--                <pre class="col-lg-6" style="display: block">{{-->
            <!--                    JSON.stringify({-->
            <!--                        lines,-->
            <!--                    }, null, 2)-->
            <!--                }}</pre>-->
            <!--            </div>-->

            <div class="ibox ">
                <div class="ibox-title">
                    <div class="text-right">
                        <button
                            class="btn btn-primary"
                            @click.prevent="onCreateButtonClicked">
                            <i class="fa fa-plus"></i> สร้าง
                        </button>
                        <button
                            type="submit"
                            class="btn btn-primary">
                            <i class="fa fa-plus"></i> บันทึก
                        </button>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            @click.prevent="onPrintButtonClicked">
                            <i class="fa fa-print" aria-hidden="true"></i>
                            พิมพ์รายงาน
                        </button>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            @click.prevent="onRequestButtonClicked">
                            ส่งใบร้องขอ
                        </button>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6 b-r">
                            <div class="form-group row">
                                <label
                                    class="col-lg-3 col-form-label"
                                    for="input-request-department">
                                    หน่วยงานที่ร้องขอ
                                </label>
                                <div class="col-lg-6">
                                    <input id="input-request-department"
                                           class="form-control"
                                           type="text"
                                           autocomplete="off"
                                           :disabled="true"
                                           :value="ingredientRequest.department_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-lg-3 col-form-label"
                                    for="input-request-num">
                                    เลขที่ใบร้องขอ
                                </label>
                                <div class="col-lg-6">
                                    <input
                                        id="input-request-num"
                                        type="text"
                                        class="form-control"
                                        autocomplete="off"
                                        :disabled="true"
                                        :value="ingredientRequest.request_num">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    class="col-lg-3 col-form-label"
                                    for="lookup-machine-group">
                                    ชุดเครื่องจักร&nbsp;<span style="color:red">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <db-lookup
                                        id="lookup-machine-group"
                                        ref="lookupMachineGroups"
                                        table-name="PtpmMachineGroupsLookup"
                                        key-field="lookup_code"
                                        v-model="ingredientRequest.ptpm_machine_groups"
                                        :label-fields="['lookup_code', 'meaning']"
                                        label-pattern="{$}: {$}"
                                        :initial-object="ingredientRequest.ptpm_machine_groups"
                                        :pre-fetch="true"
                                        :max-results="20"
                                        @change="(item)=>{
                                             ingredientRequest.machine_group = lodash.get(item, 'lookup_code', '');
                                        }">
                                    </db-lookup>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-lg-3 col-form-label"
                                    for="lookup-item">
                                    สินค้าที่จะผลิต&nbsp;<span style="color:red">*</span>
                                </label>
                                <div class="form-inline">
                                    <div class="col-lg-7">
                                        <db-lookup
                                            id="lookup-item"
                                            ref="lookupItemNumber"
                                            table-name="PtpmItemNumberVLookup"
                                            key-field="item_number"
                                            v-model="ingredientRequest.ptpm_item_number_v"
                                            :label-fields="['item_number']"
                                            label-pattern="{$}"
                                            :initial-object="ingredientRequest.ptpm_item_number_v"
                                            :pre-fetch="true"
                                            :max-results="20"
                                            @change="(item)=>{
                                                ingredientRequest.item = lodash.get(item,'item_number','');
                                                ingredientRequest.inventory_item_id = lodash.get(item,'inventory_item_id','');
                                            }">
                                        </db-lookup>
                                    </div>
                                    <div class="col-lg-2">
                                        <input
                                            type="text"
                                            class="form-control"
                                            autocomplete="off"
                                            :value="lodash.get(ingredientRequest.ptpm_item_number_v, 'item_desc')"
                                            :disabled="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label
                                    class="col-lg-3 col-form-label"
                                    for="input-request-user">
                                    ผู้ร้องขอ
                                </label>
                                <div class="col-lg-6">
                                    <input
                                        id="input-request-user"
                                        class="form-control"
                                        type="text" autocomplete="off"
                                        :disabled="true"
                                        :value="ingredientRequest.user_id">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    class="col-lg-3 col-form-label"
                                    for="input-request-date">
                                    วันที่ร้องขอ
                                </label>
                                <div class="col-lg-6">
                                    <input
                                        id="input-request-date"
                                        class="form-control"
                                        type="date"
                                        autocomplete="off"
                                        :disabled="true"
                                        :value="ingredientRequest.request_date">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    class="col-lg-3 col-form-label"
                                    for="input-manufacture-step">
                                    ขั้นตอนการทำงาน&nbsp;<span style="color:red">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <db-lookup
                                        id="lookup-manfacture-step"
                                        ref="lookupManfactureStep"
                                        table-name="PtpmManufactureStepLookup"
                                        key-field="lookup_code"
                                        v-model="ingredientRequest.ptpm_manufacture_step"
                                        :label-fields="['lookup_code']"
                                        label-pattern="{$}"
                                        :initial-object="ingredientRequest.ptpm_manufacture_step"
                                        :pre-fetch="true"
                                        :max-results="20"
                                        @change="(item)=>{
                                             ingredientRequest.manufacture_step = lodash.get(item, 'lookup_code', '');
                                        }">
                                    </db-lookup>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    class="col-lg-3 col-form-label"
                                    for="input-status">
                                    สถานะใบร้องขอ
                                </label>
                                <div class="col-lg-6">
                                    <input
                                        id="input-status"
                                        class="form-control"
                                        type="text"
                                        autocomplete="off"
                                        :disabled="true"
                                        :value="ingredientRequest.status">
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
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h5>รายการวัตถุดิบ</h5>
                                </div>
                                <div class="col-lg-6">
                                    <div class="text-right">
                                        <button class="btn btn-primary" @click.prevent="addNewLine">
                                            <strong><i class="fa fa-plus"></i> เพิ่มรายการ</strong>
                                        </button>
                                        <button class="btn btn-danger" @click.prevent="removeSelectedLines">
                                            <strong><i class="fa fa-times"></i> ลบรายการ</strong>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <table
                                v-if="lines.length > 0"
                                class="table table-bordered">
                                <thead>
                                <tr>
                                    <th/>
                                    <th style="text-align: center;">
                                        รหัสวัตถุดิบ&nbsp;<span style="color:red">*</span>
                                    </th>
                                    <th style="text-align: center;">
                                        รายละเอียด
                                    </th>
                                    <th style="text-align: center;">
                                        ปริมาณจัดเก็บมากสุด
                                    </th>
                                    <th style="text-align: center;">
                                        หน่วยนับ
                                    </th>
                                    <th style="text-align: center;">
                                        ปริมาณที่ขอ&nbsp;<span style="color:red">*</span>
                                    </th>
                                    <th style="text-align: center;">
                                        หน่วยนับ2&nbsp;<span style="color:red">*</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(line, i) in lines"
                                    v-bind:key='line.ingreq_line_id'
                                    :class="{
                                        'row-new-record': line.isNewLine,
                                        'row-selected-record': line.isSelected
                                    }">
                                    <td>
                                        <input
                                            type="checkbox"
                                            v-model="line.isSelected"/>
                                    </td>

                                    <!--รหัสวัตถุดิบ-->
                                    <td>
                                        <db-lookup
                                            id="lookup-line-item-number"
                                            ref="lookupLineItemNumber"
                                            table-name="PtpmItemNumberVLookup"
                                            key-field="item_number"
                                            :label-fields="['item_number']"
                                            label-pattern="{$}"
                                            v-model="line.ptpm_item_number_v"
                                            :initial-object="line.ptpm_item_number_v"
                                            :pre-fetch="false"
                                            :max-results="20"
                                            @change="(item)=>{
                                                line.request_item = lodash.get(item, 'item_number', '');
                                                line.description = lodash.get(item, 'item_desc', '');
                                                line.max_stock = lodash.get(item, 'machine_max', '');
                                                line.primary_uom = lodash.get(item, 'primary_uom_code', '');
                                                line.inventory_item_id = lodash.get(item, 'inventory_item_id', '');
                                            }">
                                        </db-lookup>
                                    </td>

                                    <!--รายละเอียด-->
                                    <td class="col-readonly">
                                        {{ line.description }}
                                    </td>

                                    <!--ปริมาณจัดเก็บมากสุด-->
                                    <td class="col-readonly">
                                        {{ line.max_stock }}
                                    </td>

                                    <!--หน่วยนับ-->
                                    <td class="col-readonly">
                                        {{ line.primary_uom }}
                                    </td>

                                    <!--ปริมาณที่ขอ-->
                                    <td>
                                        <input id="input-request-quantity"
                                               class="form-control"
                                               type="text"
                                               autocomplete="off"
                                               placeholder="จำนวน"
                                               v-model="line.request_qty"/>
                                    </td>

                                    <!--หน่วยนับ2-->
                                    <td>
                                        <db-lookup
                                            id="lookup-line-uom-code"
                                            ref="lookupLineUomCode"
                                            table-name="PtpmItemConvUomVLookup"
                                            key-field="uom_code"
                                            :label-fields="['uom_code']"
                                            label-pattern="{$}"
                                            v-model="line.ptpm_item_conv_uom_v"
                                            :initial-object="line.ptpm_item_conv_uom_v"
                                            :pre-fetch="false"
                                            :max-results="20"
                                            @change="(item)=>{
                                                line.secondary_uom = lodash.get(item, 'uom_code', '');
                                            }">
                                        </db-lookup>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div
                                class="text-center"
                                v-if="lines.length === 0">
                                <span class="lead">ไม่พบข้อมูล</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>

import {setAllObjectKeys, warningBeforeUnload} from "../helpers"
import {
    showProgressWithUnsavedChangesWarningDialog,
    showSaveSuccessDialog,
    showSaveFailureDialog,
    showRemoveLineConfirmationDialog,
    showValidationFailedDialog, showLoadingDialog
} from "../../commonDialogs"

import {instance as http} from "../httpClient";
import {$route} from "../../router";
import {DateTime} from 'luxon';
import _get from 'lodash/get';
import _isEqual from 'lodash/isEqual';
import _cloneDeep from 'lodash/cloneDeep';
import * as Validator from 'validatorjs';
import {buildValidatingEntry, validateDataAgainstRules} from "../../validatorUtils"

function gotoCreateNew() {
    window.location = $route('pm.machine-ingredient-requests.index');
}

function gotoItemId(id) {
    window.location = $route('pm.machine-ingredient-requests.show', {
        id: id
    })
}

function createItem(header, lines) {
    return http.post($route('api.pm.machine-ingredient-requests.store'), {header, lines})
}

function update(header, lines) {
    let headerId = header.ingreq_header_id
    return http.put($route('api.pm.machine-ingredient-requests.update', {
            id: headerId
        }),
        {
            header,
            lines
        })
}

function deleteLines(lineIds) {
    return http.delete($route('api.pm.machine-ingredient-requests.lines'), {
        params: {
            ids: lineIds
        }
    })
}

export default {
    created() {
        this.saveDataStage();
    },
    mounted() {
        this.setWarningBeforeUnload();
    },
    data() {
        return {
            lodash: {
                get: _get,
                isEqual: _isEqual,
                cloneDeep: _cloneDeep,
            },
            isCreateNew: this.is_create_new,
            ingredientRequest: {
                ...this.init_ingredient_request,
            },
            lines: this.init_lines.map(line => ({
                ...line,
                isNewLine: false,
                isSelected: false
            })),
            // use for detect and alert unsaved data
            dataStage: {},
        }
    },
    props: {
        is_create_new: false,
        init_ingredient_request: {
            type: Object,
        },
        init_lines: {
            type: Array,
            default: []
        },
        user: {
            type: Object,
        }
    },
    methods: {
        headerValidationRuleOnCreate() {
            return {
                department_name: 'required',
                machine_group: 'required',
                item: 'required',
                user_id: 'required',
                request_date: 'required',
                manufacture_step: 'required',
            }
        },
        headerValidationRuleOnUpdate() {
            return {
                department_name: 'required',
                request_num: 'required',
                machine_group: 'required',
                item: 'required',
                user_id: 'required',
                request_date: 'required',
                manufacture_step: 'required',
            }
        },
        lineValidationRule() {
            return {
                request_item: 'required',
                request_qty: 'required',
                secondary_uom: 'required',
            }
        },
        validate(headerValidationRules) {
            console.debug('validating...');

            let headerAttributesNames = {
                department_name: 'หน่วยงานที่ร้องขอ',
                request_num: 'เลขที่ใบร้องขอ',
                machine_group: 'ชุดเครื่องจักร',
                item: 'สินค้าที่จะผลิต',
                user_id: 'ผู้ร้องขอ',
                request_date: 'วันที่ร้องขอ',
                manufacture_step: 'ขั้นตอนการทำงาน',
            };
            let lineAttributesNames = {
                request_item: 'รหัสวัตถุดิบ',
                request_qty: 'หน่วยนับ',
                secondary_uom: 'หน่วยนับ2',
            };

            let validatingEntries = [];
            validatingEntries.push(
                buildValidatingEntry(this.ingredientRequest, headerValidationRules, headerAttributesNames));
            this.lines.forEach(line => {
                validatingEntries.push(
                    buildValidatingEntry(line, this.lineValidationRule(), lineAttributesNames));
            });

            console.debug(validatingEntries);

            let validatingResult = validateDataAgainstRules(validatingEntries);
            if (validatingResult.status) {
                return true;
            }

            showValidationFailedDialog(validatingResult.errorMessages);
            return false;
        },
        async onCreateButtonClicked() {
            console.debug('onCreateButtonClicked');

            if (this.isDataStageChange() === true) {
                showProgressWithUnsavedChangesWarningDialog()
                    .then((result) => {
                        if (result) {
                            gotoCreateNew();
                        }
                    });
            } else {
                gotoCreateNew();
            }
        },
        onSaveButtonClicked() {
            console.debug('onSaveButtonClicked');

            let header = {...this.ingredientRequest};
            let lines = {...this.lines};

            if (this.isCreateNew === true) {
                this.create(header, lines)
            } else {
                this.update(header, lines)
            }
        },
        onPrintButtonClicked() {
            console.debug('onPrintButtonClicked');
            //no implementation
        },
        onRequestButtonClicked() {
            console.debug('onRequestButtonClicked');
            //no implementation
        },
        saveDataStage() {
            this.dataStage.ingredientRequest = this.lodash.cloneDeep(this.ingredientRequest);
            this.dataStage.lines = this.lodash.cloneDeep(this.lines);
        },
        isDataStageChange() {
            console.debug('isDataStageChange', this.dataStage.lines, this.lines);

            let isHeadEqual = this.lodash.isEqual(this.dataStage.ingredientRequest, this.ingredientRequest);
            let isLinesEqual = this.lodash.isEqual(this.dataStage.lines, this.lines);
            console.debug(isHeadEqual, isLinesEqual);

            //warning user if there is unsaved data
            return !isHeadEqual || !isLinesEqual;
        },
        addNewLine() {
            this.lines.push({
                isNewLine: true,
                isSelected: false,
            })
        },
        async create(header, lines) {
            console.debug('create', header, lines);

            let validateResult = this.validate(this.headerValidationRuleOnCreate());
            console.debug('validateResult', validateResult);
            if (!validateResult) {
                return;
            }

            showLoadingDialog();
            createItem(header, lines)
                .then(async ({data}) => {
                    console.debug('created', data);

                    this.ingredientRequest = data.header;
                    this.lines = data.lines;
                    this.saveDataStage();

                    return showSaveSuccessDialog();
                })
                .then((result) => {
                    gotoItemId(this.ingredientRequest.ingreq_header_id);
                })
                .catch(async (err) => {
                    console.error(err);
                    return showSaveFailureDialog();
                })
        },
        async update(header, lines) {
            console.debug('update', header, lines);

            let validateResult = this.validate(this.headerValidationRuleOnCreate());
            console.debug('validateResult', validateResult);
            if (!validateResult) {
                return;
            }

            showLoadingDialog();
            update(header, lines)
                .then(async ({data}) => {
                    console.debug('updated');

                    this.ingredientRequest = data.header;
                    this.lines = data.lines;
                    this.isCreateNew = false;
                    this.saveDataStage();

                    return showSaveSuccessDialog();
                })
                .catch(async (err) => {
                    console.error(err)
                    return showSaveFailureDialog();
                })
        },
        async removeSelectedLines() {
            console.debug('removeSelectedLines');

            let selectedIndexes = this.lines
                .map((line, i) => line.isSelected ? i : null)
                .filter(line => line != null);


            let isConfirmed = await showRemoveLineConfirmationDialog(selectedIndexes.length);
            if (!isConfirmed) {
                console.debug('removeSelectedLines: cancelled');
                return;
            }
            console.debug('removeSelectedLines: confirmed');

            function removeIndexes(arr, indexes) {
                let newArr = [];
                for (let i = 0; i < arr.length; i++) {
                    if (indexes.indexOf(i) === -1) newArr.push(arr[i]);
                }
                return newArr;
            }

            let idsToRemove = this.lines
                .filter(line => line.isSelected && !line.isNewLine)
                .map(line => line.ingreq_line_id);

            if (idsToRemove.length > 0) {
                deleteLines(idsToRemove)
                    .then(async ({data}) => {
                        this.lines = removeIndexes(this.lines, selectedIndexes);
                        this.saveDataStage();
                        showSaveSuccessDialog();

                    }).catch(async (err) => {
                    console.error(err)
                    showSaveFailureDialog();
                })
            } else {
                this.lines = removeIndexes(this.lines, selectedIndexes);
            }

            this.saveDataStage();
        },
        setWarningBeforeUnload() {
            warningBeforeUnload(() => {
                if (this.isCreateNew) {
                    return false;
                }
                return this.isDataStageChange();
            });
        },
        // clearWarningBeforeUnload() {
        //     window.onbeforeunload = null;
        // },
    }
}


</script>

<style scoped>

table td {
    position: relative;
}

table td input {
    position: absolute;
    display: block;
    top: 0;
    left: 0;
    margin: 0;
    height: 100%;
    width: 100%;
    border: none;
    padding: 10px;
    box-sizing: border-box;
}

table td db-lookup {
    position: absolute;
    display: block;
    top: 0;
    left: 0;
    margin: 0;
    height: 100%;
    width: 100%;
    border: none;
    padding: 10px;
    box-sizing: border-box;
}


.ibox-title {
    padding: 15px 20px 15px 20px;
}

.el-select {
    width: 100%;
}

</style>
