<template>
    <div class="pm0007">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <form class="ibox ">
                        <div class="ibox-title">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h5>บันทึกตัดใช้วัตถุดิบ</h5>
                                </div>
                                <div class="col-lg-6">
                                    <div class="text-right">
                                        <button
                                            @click.prevent="clearForm"
                                            class="btn btn-w-m btn-success"
                                            type="button"><i class="fa fa-plus"></i>
                                            สร้าง
                                        </button>
                                        <button
                                            :disabled="loading"
                                            class="btn btn-w-m btn-primary" type="submit"
                                            @click.prevent="onSave(false)"><i
                                            class="fa fa-save (alias)"></i>
                                            บันทึก
                                        </button>
                                        <button
                                            :disabled="loading || !issueEnable"
                                            class="btn btn-w-m btn-danger" type="button"
                                            @click.prevent="cutIssue">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                            ตัดใช้วัตถุดิบ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-6 b-r">
                                    <form role="form">
                                        <div class="form-group row row">
                                            <label class="col-lg-3 col-form-label"><B>หน่วยงาน</B></label>
                                            <div class="col-lg-6">
                                                <input
                                                    :value="`${coa_dept_code_v.description} (${user.department_code})`"
                                                    type="text" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row row"><label
                                            class="col-lg-3 col-form-label"><B>เลขที่คำสั่งผลิต<span
                                            style="color:red">*</span></B></label>
                                            <div class="col-lg-6">

                                                <el-select
                                                    clearable
                                                    placeholder=""
                                                    value-key="batch_no"
                                                    v-model="header.batch_no"
                                                    filterable
                                                    @change="onFilterHeaderSelected">
                                                    <el-option
                                                        v-for="item in uniqueBy(mesReviewIssueLookupList, it => it.batch_no)"
                                                        :key="JSON.stringify(item)"
                                                        :label="item.batch_no"
                                                        :value="item.batch_no">
                                                    </el-option>
                                                </el-select>

                                            </div>
                                        </div>
                                        <div class="form-group row row" v-if="isView1 || isView2">
                                            <label class="col-lg-3 col-form-label"><B>OPT</B></label>
                                            <div class="col-lg-6">

                                                <el-select
                                                    clearable
                                                    placeholder=""
                                                    value-key="opt"
                                                    v-model="header.opt"
                                                    filterable
                                                    @change="item => {
                                                        header.batch_no = item.batch_no
                                                        header.opt = item.opt
                                                        onFilterHeaderSelected()
                                                    }">
                                                    <el-option
                                                        v-for="item in mesReviewIssueLookupList"
                                                        :key="JSON.stringify(item)"
                                                        :label="item.opt"
                                                        :value="item">
                                                    </el-option>
                                                </el-select>

                                            </div>
                                        </div>
                                        <div class="form-group row row">
                                            <label class="col-lg-3 col-form-label"><B>สินค้าที่จะผลิต</B></label>
                                            <div class="col-lg-6">
                                                <div class="form-row">
                                                    <div class="col-lg-6">
                                                        <input
                                                            :value="lodash.get(header, 'item_number_v.item_number')"
                                                            type="text" class="form-control" disabled>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input
                                                            :value="lodash.get(header, 'item_number_v.item_desc')"
                                                            type="text" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="form-group row row">
                                            <label class="col-lg-3 col-form-label" for="header-ingridient-group-code">
                                                <b>กลุ่มวัตถุดิบ<span style="color:red">*</span></b></label>
                                            <div class="col-lg-6">
                                                <input
                                                    id="header-ingridient-group-code"
                                                    type="text"
                                                    class="form-control"
                                                    :value="item_classification.item_classification"
                                                    disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="form-group row row">
                                            <label class="col-lg-3 col-form-label"><B>จำนวนที่ผลิต</B></label>
                                            <div class="col-lg-6">
                                                <div class="form-row">
                                                    <div class="col-lg-8">
                                                        <input
                                                            :value="lodash.get(header, 'mes_review_job_header.opt_plan_qty')"
                                                            type="text" class="form-control" disabled>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input
                                                            :value="lodash.get(header, 'mes_review_job_header.opt_plan_uom')"
                                                            type="text" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row row">
                                            <label class="col-lg-3 col-form-label"><b>ผลผลิตที่ได้</b></label>
                                            <div class="col-lg-6">
                                                <div class="form-row">
                                                    <div class="col-lg-8">
                                                        <input
                                                            :value="lodash.get(header, 'mes_review_job_lines.confirm_qty')"
                                                            type="text" class="form-control" disabled>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input
                                                            :value="lodash.get(header, 'mes_review_job_header.opt_plan_uom')"
                                                            type="text" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <!--                                    <div class="form-group row row"><label-->
                                    <!--                                        class="col-lg-3 col-form-label"><b>เลขที่ตัดใช้วัตถุดิบ</b></label>-->
                                    <!--                                        <div class="col-lg-6">-->
                                    <!--                                            <input :value="lodash.get(header, 'header.request_number')"-->
                                    <!--                                                   type="text" class="form-control" disabled>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <div class="form-group row row"><label class="col-lg-3 col-form-label"><b>ประเภทคำสั่งผลิต</b></label>
                                        <div class="col-lg-6">
                                            <input
                                                :value="lodash.get(header, 'job_type.description')"
                                                type="text" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row row"><label class="col-lg-3 col-form-label">
                                        <b>Blend No.</b></label>
                                        <div class="col-lg-6">
                                            <input
                                                :value="lodash.get(header, 'item_number_v.blend_no')"
                                                type="text" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row row">
                                        <label class="col-lg-3 col-form-label"><b>ขั้นตอนการทำงาน<span
                                            style="color:red">*</span></b></label>
                                        <div class="col-lg-6">
                                            <div class="form-row">
                                                <div class="col-lg-4">

                                                    <el-select
                                                        clearable
                                                        :disabled="!isView3 && !(lodash.get(header, 'batch_no', null) !== null && lodash.get(header, 'opt') !== null)"
                                                        placeholder=""
                                                        value-key="wip_step"
                                                        v-model="header.wip_step"
                                                        filterable
                                                        @change="onFilterHeaderSelected">
                                                        <el-option
                                                            v-for="item in mesReviewIssueLookupList"
                                                            :key="JSON.stringify(item)"
                                                            :label="item.wip_step"
                                                            :value="item.wip_step">
                                                        </el-option>
                                                    </el-select>

                                                </div>
                                                <div class="col-lg-8">
                                                    <!--                                                :value="lodash.get(header, 'operation_of_batch_v.oprn_desc', getOprnDescFromWip(header.wip_step))"-->
                                                    <input
                                                        :value="getOprnDescFromWip(header.wip_step)"
                                                        type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row row" v-if="isView3">
                                        <label class="col-lg-3 col-form-label"><B>ชุดเครื่องจักร</B></label>
                                        <div class="col-lg-6">
                                            <div class="form-row">
                                                <div class="col-lg-4">

                                                    <el-select
                                                        placeholder=""
                                                        value-key="machine_set"
                                                        :value="header.machine_set"
                                                        filterable
                                                        @change="onSelectMachineSet">
                                                        <el-option
                                                            v-for="item in machineRelationList"
                                                            :key="JSON.stringify(item)"
                                                            :label="item.machine_set"
                                                            :value="item">
                                                        </el-option>
                                                    </el-select>

                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control"
                                                           :value="header.machine_description"
                                                           disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row row"><label class="col-lg-3 col-form-label"><B>วันที่ตัดใช้วัตถุดิบ</B></label>
                                        <div class="col-lg-6">
                                            <!--                                            <input-->
                                            <!--                                                v-model="header.issue_date"-->
                                            <!--                                                :max="toDateFormatString(new Date())"-->
                                            <!--                                                type="date" class="form-control">-->
                                            <ct-datepicker
                                                :enableDate="date => isInRange(date, null, new Date())"
                                                :value="header.issue_date"
                                                @change="date => header.issue_date = jsDateToString(date)"/>
                                        </div>
                                    </div>
                                    <div class="form-group row row"><label class="col-lg-3 col-form-label"><B>วันที่ได้ผลผลิต</B></label>
                                        <div class="col-lg-6">
                                            <input
                                                :value="toThDateString(lodash.get(header, 'mes_review_job_lines.transaction_date'))"
                                                :disabled="true"
                                                type="text"
                                                class="form-control">
                                            <!--                                            <db-lookup-->
                                            <!--                                                table-name="PtpmMesReviewJobLinesLookup"-->
                                            <!--                                                key-field="transaction_date"-->
                                            <!--                                                v-model="header.complete_date"-->
                                            <!--                                                label-pattern="{$}"-->
                                            <!--                                                :label-fields="['transaction_date']"-->
                                            <!--                                                :search-keys="['transaction_date']"-->
                                            <!--                                                :pre-fetch="true"-->
                                            <!--                                                :filterBy="() => ({-->
                                            <!--                                                    review_header_id: lodash.get(header, 'mes_review_job_headers.review_header_id'),-->
                                            <!--                                                })"-->
                                            <!--                                                :remote-data-source="(...args) => defaultRemoteDataSource(...args).then(items => {-->
                                            <!--                                                    return items.map(item => {-->
                                            <!--                                                        return {-->
                                            <!--                                                            ...item,-->
                                            <!--                                                            transaction_date: toDateFormatString(new Date(item.transaction_date)),-->
                                            <!--                                                        }-->
                                            <!--                                                    })-->
                                            <!--                                                })"-->
                                            <!--                                                :max-results="20"-->
                                            <!--                                                @change="onSelectCompleteDate">-->
                                            <!--                                            </db-lookup>-->
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="mt-4 mb-1" v-if="isView2">
                                <button
                                    class="btn btn-w-m"
                                    :class="{
                                        'btn-primary': filterLineController.tab0,
                                        'btn-outline-primary': !filterLineController.tab0,
                                    }"
                                    @click="onFilterLineSelected(0)"
                                    type="button">
                                    สารปรุง
                                </button>
                                <button
                                    class="btn btn-w-m"
                                    :class="{
                                        'btn-primary': filterLineController.tab1,
                                        'btn-outline-primary': !filterLineController.tab1,
                                    }"
                                    @click="onFilterLineSelected(1)"
                                    type="button">
                                    สารหอม
                                </button>
                            </div>

                            <!--                            <div v-for="(group, groupIndex) in lines" v-bind:key="JSON.stringify(group)">-->
                            <!--                                <div-->
                            <!--                                    v-for="(line, i) in group.items"-->
                            <!--                                    @click.prevent="duplicateLine(groupIndex, i)"-->
                            <!--                                    :class="{'tr-line': true, 'new': line.newLine}">-->
                            <!--                                    {{ JSON.stringify(line).length }}-->
                            <!--                                </div>-->
                            <!--                                <hr/>-->
                            <!--                            </div>-->

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>กลุ่มใบยา</th>
                                    <th v-if="filterLineController.tab0">Casing No.</th>
                                    <th v-if="filterLineController.tab1">Flavor No.</th>
                                    <th>รหัสวัตถุดิบ</th>
                                    <th style="min-width: 250px;">รายละเอียด</th>
                                    <th>ปริมาณที่ต้องใช้+สูญเสีย</th>
                                    <th>หน่วยนับ</th>
                                    <th>คลังจัดเก็บ</th>
                                    <th>สถานที่จัดเก็บ</th>
                                    <th>Lot No.</th>
                                    <th v-if="isView1 || isView2">ปริมาณคงคลังโซนผลิต</th>
                                    <th v-if="isView1 || isView2">หน่วยนับ</th>
                                    <th v-if="isView1 || isView2">ปริมาณที่ใช้จริง</th>
                                    <th v-if="isView1 || isView2">หน่วยนับ</th>
                                    <th v-if="isView3">วันหมดอายุ</th>
                                    <th v-if="isView3">คงคลังเช้า</th>
                                    <th v-if="isView3">ปริมาณเบิกทั้งวัน</th>
                                    <th v-if="isView3">คงคลังเย็น</th>
                                    <th v-if="isView3">ปริมาณที่ใช้</th>
                                    <th v-if="isView3">หน่วยนับ2</th>
                                </tr>
                                </thead>
                                <tbody
                                    v-for="(group, gid) in lines" v-bind:key="JSON.stringify(group)">
                                <tr
                                    v-for="(line, i) in group.items" v-bind:key="JSON.stringify({group, line})"
                                    v-if="  (isView1) ||
                                            (isView2 && filterLineController.matchWith.tobacco_ingrident_type === line.tobacco_ingrident_type) ||
                                            (isView3)"
                                    :class="{
                                        'tr-line': true,
                                        'new': line.newLine,
                                        'tr-red': !lodash.get(line, 'onhand_quantities_v.onhand_quantity', false),
                                    }">

                                    <!--กลุ่มใบยา-->
                                    <!--<td class="col-readonly">{{ filterLineController.matchWith.tobacco_ingrident_type }}:{{ line.tobacco_ingrident_type}}                                    </td>-->
                                    <td class="col-readonly">{{
                                            lodash.get(line, 'leaf_fomula')
                                        }}
                                    </td>
                                    <!--Casing No.-->
                                    <td v-if="filterLineController.tab0" class="col-readonly">
                                        {{ line.casting_flavor_name }}
                                    </td>
                                    <!--Flavor No.-->
                                    <td v-if="filterLineController.tab1" class="col-readonly">
                                        {{ line.casting_flavor_name }}
                                    </td>
                                    <!--รหัสวัตถุดิบ-->
                                    <td class="col-readonly">{{ line.item_number }}</td>
                                    <!--รายละเอียด-->
                                    <td class="col-readonly">{{ line.item_desc }}</td>
                                    <!--ปริมาณที่ต้องใช้+สูญเสีย-->
                                    <td class="col-readonly">
                                        {{ line.require_qty_display }}
                                    </td>
                                    <!--หน่วยนับ-->
                                    <td class="col-readonly">{{ line.detail_uom }}</td>
                                    <!--คลังจัดเก็บ-->
                                    <td class="col-readonly">
                                        {{ lodash.get(line, 'setup_mfg_department_v.from_subinventory') }}
                                    </td>
                                    <!--สถานที่จัดเก็บ-->
                                    <td class="col-readonly">
                                        {{ lodash.get(line, 'setup_mfg_department_v.from_location_code') }}
                                    </td>
                                    <!--Lot No.-->
                                    <td class="col-readonly">
                                        <div v-if="isView1">
                                            {{ line.default_lot_no }}
                                        </div>
                                        <div v-if="isView2 || isView3">
                                            <div style="display: none;">({{
                                                    group.items.length
                                                }}/{{ group.onhand_quantities_v_list_src.length }})
                                            </div>
                                            <div style="display: flex">
                                                <el-select
                                                    style="min-width: 150px;"
                                                    v-if="line.onhand_quantities_v_list"
                                                    placeholder=""
                                                    value-key="default_lot_no"
                                                    v-model="line.default_lot_no"
                                                    @change="val => selectLotNumber(gid, i, val)">
                                                    <el-option
                                                        v-for="item in group.onhand_quantities_v_list"
                                                        :key="JSON.stringify(item)"
                                                        :label="item.lot_number"
                                                        :value="item.lot_number">
                                                    </el-option>
                                                </el-select>

                                                <button
                                                    :disabled="group.onhand_quantities_v_list.length === 0 || group.items.length >= group.onhand_quantities_v_list_src.length"
                                                    @click.prevent="duplicateLine(gid, i)"
                                                    class="btn btn-success ml-1"
                                                    type="button"><i class="fa fa-plus"></i>
                                                </button>

                                                <button
                                                    :disabled="line.isFirstRow"
                                                    @click.prevent="removeDuplicateLine(gid, i)"
                                                    class="btn btn-danger ml-1"
                                                    type="button"><i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <!--ปริมาณคงคลังโซนผลิต-->
                                    <td v-if="isView1 || isView2" class="col-readonly">
                                        {{ lodash.get(line, 'onhand_quantities_v.onhand_quantity', null) }}
                                    </td>
                                    <!--หน่วยนับ-->
                                    <td v-if="isView1 || isView2" class="col-readonly">
                                        {{ lodash.get(line, 'onhand_quantities_v.primary_uom_code') }}
                                    </td>
                                    <!--ปริมาณที่ใช้จริง-->
                                    <td v-if="isView1 || isView2" class="col-readonly">
                                        <!--                                        step="any"-->
                                        <!--                                        :min="0"-->
                                        <!--                                        :max="Math.ceil(line.onhand_quantities_v.onhand_quantity)"-->

                                        <input
                                            v-if="!!lodash.get(line, 'onhand_quantities_v.onhand_quantity', null)"
                                            style="min-width: 120px;"
                                            :value="line.line.confirm_qty"
                                            class="form-control"
                                            type="number"
                                            @blur="confirmQtyChange($event.target.value, gid, i)"/>
                                        <input
                                            v-else
                                            style="min-width: 120px;"
                                            :value="line.line.confirm_qty"
                                            class="form-control"
                                            type="number"
                                            :disabled="true"/>
                                    </td>
                                    <!--หน่วยนับ-->
                                    <td v-if="isView1 || isView2" class="col-readonly">{{ line.detail_uom }}</td>


                                    <!--วันหมดอายุ-->
                                    <td v-if="isView3"></td>
                                    <!--คงคลังเช้า-->
                                    <td v-if="isView3">
                                        {{ line.pgk_get_item_onhand }}
                                    </td>
                                    <!--ปริมาณเบิกทั้งวัน-->
                                    <td v-if="isView3">
                                        {{ line.pgk_get_issue_qty }}
                                    </td>
                                    <!--คงคลังเย็น-->
                                    <td v-if="isView3">
                                        <input
                                            style="min-width: 120px;"
                                            :value="line.line.xxx"
                                            class="form-control"
                                            type="number"/>
                                    </td>
                                    <!--ปริมาณที่ใช้-->
                                    <td v-if="isView3">
                                        <input
                                            style="min-width: 120px;"
                                            v-model="line.line.require_qty"
                                            class="form-control"
                                            type="number"/>
                                    </td>
                                    <!--หน่วยนับ2-->
                                    <td v-if="isView3">
                                        <el-select
                                            style="min-width: 100px;"
                                            v-if="line.item_conv_uom_lookup"
                                            placeholder=""
                                            value-key="from_uom_code"
                                            v-model="line.line.from_uom_code"
                                            @change="val => selectLotNumber(gid, i, val)">
                                            <el-option
                                                v-for="item in line.item_conv_uom_lookup"
                                                :key="JSON.stringify(item)"
                                                :label="item.from_uom_code"
                                                :value="item.from_uom_code">
                                            </el-option>
                                        </el-select>
                                        <!--                                        <db-lookup-->
                                        <!--                                            style="min-width: 100px;"-->
                                        <!--                                            placeholder=""-->
                                        <!--                                            table-name="PtpmItemConvUomVLookup"-->
                                        <!--                                            key-field="from_uom_code"-->
                                        <!--                                            :value="lodash.get(line, 'line.from_uom_code')"-->
                                        <!--                                            label-pattern="{$}"-->
                                        <!--                                            :label-fields="['from_uom_code']"-->
                                        <!--                                            :search-keys="['from_uom_code']"-->
                                        <!--                                            :pre-fetch="true"-->
                                        <!--                                            :filterBy="() => ({-->
                                        <!--                                                organization_id: lodash.get(line, 'organization_id'),-->
                                        <!--                                                inventory_item_id: lodash.get(line, 'inventory_item_id'),-->
                                        <!--                                            })"-->
                                        <!--                                            :max-results="20"-->
                                        <!--                                            @change="(item) => lodash.set(line, 'line.from_uom_code', item.from_uom_code)">-->
                                        <!--                                        </db-lookup>-->
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    showLoadingDialog,
    showSaveSuccessDialog,
    showValidationFailedDialog,
    showSaveFailureDialog,
    showGenericFailureDialog,
} from "../../commonDialogs"

import {instance as http} from "../httpClient"
import {defaultRemoteDataSource} from "./../../components/DbLookup"
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'

import {
    $route,
    pm_cutRawMaterial_index,
    api_pm_cutRawMaterial_show,
    api_pm_cutRawMaterial_save,
    api_pm_cutRawMaterial_cutIssue,
} from "../../router"

import _get from 'lodash/get'
import _set from 'lodash/set'
import _deepClone from 'lodash/cloneDeep'
import _isEqual from 'lodash/isEqual'

function _map(object, path, setter = (data) => data, defaultValue = null) {
    let d = _get(object, path, defaultValue)
    _set(object, path, setter(d))
}

function search(query) {
    return http.get($route(api_pm_cutRawMaterial_show), {params: query}).then(({data}) => {
        return data
    })
}

function save(header, lines, item_classification) {
    return http.post($route(api_pm_cutRawMaterial_save), {header, lines, item_classification}).then(({data}) => {
        return data
    })
}

function cutIssue(header, lines, item_classification) {
    return http.post($route(api_pm_cutRawMaterial_cutIssue), {header, lines, item_classification}).then(({data}) => {
        return data
    })
}

function mappingHeader(header) {
    let data = {
        ...header,
        issue_date: _get(header, 'issue_date', false) ?
            header.issue_date : null,
        confirm_uom_code: _get(header, 'detail_uom', false),
        machine_set: _get(header, 'machine_relation[0].machine_set'),
        machine_description: _get(header, 'machine_relation[0].machine_description'),
    }

    // let d = _get(data, 'mes_review_job_lines.transaction_date', null)
    // _set(data, 'mes_review_job_lines.transaction_date', toJSDate(d))
    _map(data, 'mes_review_job_lines.transaction_date', str => new Date(str))

    return data
}

function mappingLine(item, header = {}) {
    let newItem = {
        ...item,
        onhand_quantities_v: _get(item, 'onhand_quantities_v'),
        onhand_quantities_v_list: _get(item, 'onhand_quantities_v_list'),
        line: {
            ..._get(item, 'line', {}),
            from_uom_code: _get(item, 'item_conv_uom_lookup[0].from_uom_code'),
            confirm_qty: _get(item, 'line.confirm_qty', null),
            confirm_uom_code: _get(item, 'detail_uom', 0),
        },
    }

    if (!newItem.leaf_fomula) {
        newItem.leaf_fomula = _get(item, 'used_leaf_formula', null)
    }

    newItem.require_qty_display =
        (_get(header, 'mes_review_job_lines.confirm_qty') * item.require_qty) /
        _get(item, 'product_qty')

    newItem.line.require_qty = newItem.require_qty_display
    newItem.line.confirm_qty = newItem.line.confirm_qty ?? newItem.require_qty_display

    if (!newItem.default_lot_no) {
        newItem.default_lot_no = _get(item, 'onhand_quantities_v_list[0].lot_number')
    }

    newItem = {
        items: [
            {
                ...newItem,
                isFirstRow: true,
            }
        ],
        onhand_quantities_v_list: _get(item, 'onhand_quantities_v_list', []),
        onhand_quantities_v_list_src: _get(item, 'onhand_quantities_v_list', []),
    }

    //TODO: this is mock value for test only
    // newItem.line.confirm_qty = Math.min(Math.max(newItem.line.confirm_qty, 0), newItem.onhand_quantities_v.onhand_quantity)
    //if (!newItem.onhand_quantities_v) newItem.onhand_quantities_v = {onhand_quantity: 0}
    // if (!newItem.onhand_quantities_v.onhand_quantity) newItem.onhand_quantities_v.onhand_quantity = _get(item, 'line.confirm_qty', 100)
    // if (!newItem.onhand_quantities_v.subinventory_code) newItem.onhand_quantities_v.subinventory_code = 'test-01'
    // if (!newItem.onhand_quantities_v.locator_id) newItem.onhand_quantities_v.locator_id = 'test-01'

    return newItem
}

function setQueryParams(params) {
    const s = new URLSearchParams(location.search)
    for (let key in params) {
        if (!params[key]) continue
        s.set(key, params[key])
    }
    window.history.replaceState({}, '', `${location.pathname}?${s.toString()}`)
}

function insertAt(arr, i, element, mutableInsert = false) {
    let output = mutableInsert ? arr : [...arr]
    output.splice(i, 0, element)
    return output
}

function uniqueBy(arr, mapper = null) {
    if (typeof mapper !== 'function') {
        mapper = item => JSON.stringify(item)
    }

    let o = {}
    for (let item of arr) {
        let key = mapper(item)
        if (typeof o[key] === 'undefined') {
            o[key] = item
        }
    }

    return Object.values(o)
}

export default {
    created() {
        this.onFilterLineSelected(0)
    },
    props: {
        dateOld: {},
        dateTrans: {},
        v: {type: String},
        user: {type: Object},
        coa_dept_code_v: {type: Object},
        department_code: {type: String},
        init_header: {type: Object},
        init_lines: {type: Array},
        mes_review_issue_lookup_list: {type: Array},
        item_classification: {type: Object},
        item_classification_list: {type: Array},
        machine_relation_list: {type: Array},
        debugs: {type: Array},
    },
    computed: {
        isView1() {
            return this.v === '01'
        },
        isView2() {
            return this.v === '02'
        },
        isView3() {
            return this.v === '03'
        },
        issueEnable() {
            return _get(this.header, 'issue_header_id', false) !== null
        },
        machineRelationList() {
            // let wip_step = _get(this.mes_review_issue_lookup_list.filter(item => item.wip_step === this.header.wip_step), '[0]', null)
            // console.log(
            //     'computed.machineRelationList()',
            //     this.mes_review_issue_lookup_list,
            //     this.header.wip_step,
            //     {wip_step},
            // )
            return this.header.machine_relation
        },
        mesReviewIssueLookupList() {
            let list = this.mes_review_issue_lookup_list
            if (this.header.batch_no) list = list.filter(it => it.batch_no === this.header.batch_no)
            if (this.header.opt) list = list.filter(it => it.opt === this.header.opt)
            if (this.header.wip_step) list = list.filter(it => it.wip_step === this.header.wip_step)
            return list
        },
    },
    data() {
        return {
            console,
            defaultRemoteDataSource,
            uniqueBy,
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,
            lodash: {
                get: _get,
                set: _set,
            },

            //header
            filterList: {
                batch_no: uniqueBy(this.mes_review_issue_lookup_list, it => it.batch_no),
                opt: uniqueBy(this.mes_review_issue_lookup_list, it => it.opt),
                wip_step: uniqueBy(this.mes_review_issue_lookup_list, it => it.wip_step),
            },
            //line
            filterLineController: {
                tab0: true,
                tab1: true,
                matchWith: {},
            },
            loading: false,

            //data

            header: mappingHeader(this.init_header),
            lines: this.init_lines.map(line => mappingLine(line, this.init_header)),
        }
    },
    methods: {

        getOprnDescFromWip(wip) {
            return _get(this.item_classification_list.filter(it => it.oprn_class_desc === wip), '[0].oprn_desc', null)
        },

        clearForm() {
            window.location = $route(pm_cutRawMaterial_index)
        },

        //filter header
        onFilterHeaderSelected() {
            console.log('Filter1 onSelectFilterBatchNo()')
            if (!this.isView3 && this.header.batch_no && this.header.opt) {
                this.header.wip_step = _get(this.mesReviewIssueLookupList, '[0].wip_step')
            }
            this.fetchFilterHeader()
        },
        fetchFilterHeader() {
            let params = {
                batch_no: this.header.batch_no,
                opt: this.header.opt,
                wip_step: this.header.wip_step,
                v: this.v,
                department_code: this.department_code,
            }

            if (this.isView1 && !(params.batch_no && params.opt && params.wip_step)) return
            if (this.isView2 && !(params.batch_no && params.opt && params.wip_step)) return
            if (this.isView3 && !(params.batch_no && params.opt)) return

            this.loading = true
            showLoadingDialog()
            setQueryParams(params)
            search(params).then(({header, lines}) => {
                console.log('search 1: ', {header, lines: lines.map(line => mappingLine(line))})
                this.loading = false
                swal.close()

                if (header) this.header = mappingHeader(header)
                if (lines) this.lines = lines.map(line => mappingLine(line, header))

                if (!_get(this.header, 'issue_date', null)) {
                    this.header.issue_date = new Date()
                }

                console.log('search 2: ', {header: this.header, lines: this.lines})
            }).catch(err => {
                console.error(err)
                this.loading = false
                //showGenericFailureDialog('ไม่พบข้อมูล')
            })
        },


        onSelectCompleteDate() {
            this.header.complete_date = this.header.complete_date.transaction_date
        },

        onSelectMachineSet(item) {
            console.log('onSelectMachineSet', item)
            let {machine_set, machine_description} = item
            this.header = {
                ...this.header,
                machine_set,
                machine_description,
            }
        },


        onFilterLineSelected(tab) {
            this.filterLineController.tab0 = false
            this.filterLineController.tab1 = false
            this.filterLineController.matchWith = {}
            switch (tab) {
                case 0:
                    this.filterLineController.matchWith.tobacco_ingrident_type = 'CASING'
                    this.filterLineController.tab0 = true
                    break
                case 1:
                    this.filterLineController.matchWith.tobacco_ingrident_type = 'FLAVOR'
                    this.filterLineController.tab1 = true
                    break
            }
            console.log('LINE::TAB this.filterLineController', {...this.filterLineController})
        },

        confirmQtyChange(confirm_qty, gid, i) {
            console.log(`confirmQtyChange(confirm_qty=${confirm_qty}, gid=${gid}, i=${i})`)
            this.lines[gid].items[i].line.confirm_qty = confirm_qty

            let onhand_quantity = _get(this.lines[gid].items[i], 'onhand_quantities_v.onhand_quantity', 0)
            console.log('confirmQtyChange()', confirm_qty, onhand_quantity, this.lines[gid].items[i].line.confirm_qty)
            if (!(0 <= +confirm_qty && +confirm_qty <= +onhand_quantity)) {
                _set(this.lines[gid].items[i], 'line.confirm_qty', onhand_quantity)
            }
            // this.lines[gid].items[i].confirm_qty = Math.max(0, confirm_qty)
            this.lines = [...this.lines]
        },

        cutIssue() {
            this.onSave(true)
        },
        onSave(isCutIssue = false) {

            console.log('form.submit', 'isCutIssue', isCutIssue)
            console.log('form.submit', 'header', this.header)
            console.log('form.submit', 'lines', this.lines)
            //return
            showLoadingDialog()

            let lines = this.lines.filter(line => {
                return (this.isView1) ||
                    (this.isView2 && this.filterLineController.matchWith.tobacco_ingrident_type === line.tobacco_ingrident_type) ||
                    (this.isView3)
            })

            let notEnoughOnHands = []
            for (let line1 of lines) {
                for (let line2 of line1.items) {
                    if (!_get(line2, 'onhand_quantities_v.onhand_quantity', false)) {
                        notEnoughOnHands.push(line2)
                    }
                }
            }

            if (notEnoughOnHands.length > 0) {
                showValidationFailedDialog(notEnoughOnHands.map(it => `รายการวัตถุดิบ ${it.item_number} มีปริมาณคงคลังไม่พอสำหรับการตัดใช้วัตถุดิบ`))
                return
            }

            let request
            if (isCutIssue) {

                request = cutIssue(
                    this.header,
                    this.lines,
                    this.item_classification,
                )
            } else {
                request = save(
                    this.header,
                    this.lines,
                    this.item_classification,
                )
            }

            request.then(async (res) => {
                await showSaveSuccessDialog()
                console.log('onSave success', res)

                if (!res.status) {
                    swal({
                        title: `\nเกิดข้อผิดพลาด`,
                        text: `<pre>${res.err_msg}</pre>\n`,
                        html: true,
                        type: 'error',
                        showConfirmButton: true,
                        closeOnConfirm: true,
                        confirmButtonText: 'ปิด',
                    }, (value) => {
                    });
                }

                setTimeout(() => {
                    showLoadingDialog()
                }, 500)
                window.location.reload(false)

            }).catch(err => {
                console.error('onSave', err.response)
                let msg = _get(err, 'response.data.message', '')
                swal({
                    title: `\nเกิดข้อผิดพลาด`,
                    text: `<pre>${msg}</pre>\n`,
                    html: true,
                    type: 'error',
                    showConfirmButton: true,
                    closeOnConfirm: true,
                    confirmButtonText: 'ปิด',
                }, (value) => {
                });
            })
        },

        selectLotNumber(gid, i, val) {
            console.log('selectLotNumber(gid, i, val)', gid, i, val)

            this.lines[gid].items[i].default_lot_no = val

            this.adjustLotNumberSelector(gid)
        },
        adjustLotNumberSelector(gid) {
            console.log(`adjustLotNumberSelector(gid=${gid})`)
            let usedLotNumbers = this.lines[gid].items.map(item => {
                return item.default_lot_no
            })

            let onhandQuantitiesVList = this.lines[gid].onhand_quantities_v_list_src.filter(onhand => {
                return usedLotNumbers.indexOf(onhand.lot_number) === -1
            })
            console.log('onhandQuantitiesVList', usedLotNumbers, onhandQuantitiesVList.map(onhand => onhand.lot_number))

            this.lines[gid].onhand_quantities_v_list = onhandQuantitiesVList

            this.lines = [..._deepClone(this.lines)]
            this.$forceUpdate()
        },
        duplicateLine(gid, i) {
            console.log(`duplicateLine(gid=${gid}, i=${i})`)
            let group = {...this.lines[gid]}

            let line = {
                ..._deepClone(group.items[i]),
                default_lot_no: null,
                isFirstRow: false,
            }

            group.items.push(line)

            this.lines = [..._deepClone(this.lines)]
            this.$forceUpdate()
        },
        removeDuplicateLine(gid, i) {
            console.log(`removeDuplicateLine(gid=${gid}, i=${i})`)
            this.lines[gid].items.splice(i, 1)
            this.adjustLotNumberSelector(gid)
        },
    },
}
</script>

<style scoped>
.ibox-title {
    padding: 15px 20px 15px 20px;
}

.el-select {
    width: 100%;
}

tr.tr-line {
    background-color: #FFFFFF;
    transition: color-me-in 1s;
}

.tr-red {
    color: red;
}

@keyframes color-me-in {
    0% {
        background-color: #FFF;
    }
    50% {
        background-color: #FFE;
    }
    100% {
        background-color: #FFF;
    }
}

</style>

