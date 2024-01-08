<template>
    <div id="PD0009">
        <div class="row">
            <div class="col-lg-12">
                <p class="text-right">
                    <button class="btn btn-success" @click="resetForm"><i class="fa fa-plus"></i> สร้าง</button>
                    <button class="btn btn-default" data-toggle="modal" data-target="#searchForm"><i
                        class="fa fa-search"></i> ค้นหา
                    </button>
                    <button class="btn btn-primary" @click="saveForm"><i class="fa fa-save"></i> บันทึก</button>
                    <button class="btn btn-default" data-toggle="modal" data-target="#historyModal"><i
                        class="fa fa-file-text-o"></i> ประวัติแก้ไข
                    </button>
                </p>
                <div class="ibox">
                    <div class="ibox-title">ยาเส้นพอง</div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-8 b-r">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label text-right">ผู้บันทึก:</label>
                                    <div class="col-md-4 inline">
                                        <input type="text" class="form-control disabled-white"
                                               v-model="lastUpdatedByName"
                                               disabled>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label text-right">วันที่สร้าง:</label>
                                    <div class="col-md-4 inline">
                                        <input type="text" class="form-control disabled-white"
                                               :value="toThDateString(luxon.DateTime.fromSQL(header.formulaCreationDate).toJSDate())"
                                               disabled>
                                    </div>
                                    <label class="col-md-2 col-form-label text-right">วันที่แก้ไขล่าสุด:</label>
                                    <div class="col-md-4 inline">
                                        <input type="text" class="form-control disabled-white"
                                               :value="toThDateString(luxon.DateTime.fromSQL(header.formulaLastUpdateDate).toJSDate())"
                                               disabled>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label text-right">ยาเส้นพอง
                                        <span
                                            style="color: red;">*</span>
                                    </label>
                                    <div class="col-md-4 inline">
                                        <el-select
                                            v-model="header.inventoryItemCode"
                                            :disabled="saved"
                                            clearable
                                            filterable
                                            :filter-method="filterMethod"
                                            placeholder="กรุณาเลือก ยาเส้นพอง"
                                            @change="onChgItemCode()">
                                            <el-option
                                                v-for="item in itemLst"
                                                :key="item.inventory_item_code"
                                                :label="item.inventory_item_code"
                                                :value="item.inventory_item_code"
                                                @change="(item)=>{
                                                           this.hasDataChange = true
                                                            preventUnload()
                                                }">
                                                <span>{{ item.blend_no }}</span> : <span>{{
                                                    item.inventory_item_code
                                                }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label text-right">ประเภทสูตร
                                        <span
                                            style="color: red;">*</span>
                                    </label>
                                    <div class="col-md-4 inline">
                                        <el-select
                                            placeholder="กรุณาเลือก ประเภทสูตร"
                                            v-model="header.formulaType"
                                            @change="() => {
                                                    preventUnload()
                                                    this.hasDataChange = true
                                        }"
                                        >
                                            <el-option
                                                v-for="item in lovFormulaType"
                                                :key="item.lookup_code"
                                                :label="item.description"
                                                :value="item.lookup_code"
                                            >
                                                <span>{{ item.description }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <label class="col-md-2 col-form-label text-right">ปริมาณ
                                        <span
                                            style="color: red;">*</span>
                                    </label>
                                    <div class="col-md-4 inline">
                                        <div class="input-group m-b">
                                            <input type="text"
                                                   class="form-control text-right"
                                                   autocomplete="off"
                                                   :value="numberFormat(header.quantity)"
                                                   @change="() => {
                                                        preventUnload()
                                                        this.hasDataChange = true
                                                    }"
                                                   @input="(event) => {
                                                    header.quantity = stripNonNumber(event.target.value)
                                                    if (this.header.quantity < 0) {
                                                        this.header.quantity = 0
                                                    }
                                                    this.header = {...header}
                                                }">
                                            <div class="input-group-append">
                                                <span class="input-group-addon">กิโลกรัม</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label text-right">รายละเอียด</label>
                                    <div class="col-md-4 inline">
                                        <textarea class="form-control" rows="2"
                                                  v-model="header.description"
                                                  @change="() => {
                                                        preventUnload()
                                                        this.hasDataChange = true
                                        }"/>
                                    </div>
                                    <label class="col-md-2 col-form-label text-right">หมายเหตุ
                                    </label>
                                    <div class="col-md-4 inline">
                                        <div class="input-group m-b">
<!--                                            <textarea class="form-control" rows="2"-->
<!--                                                      v-model="header.remark"-->
<!--                                                      @change="() => {-->
<!--                                                            preventUnload()-->
<!--                                                            this.hasDataChange = true-->
<!--                                        }"/>-->
                                            <textarea-count
                                                :maxlength="240"
                                                class="textarea-count-width-100"
                                                v-model="header.remark"
                                                @change="dataChanged"
                                            ></textarea-count>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">สถานะ</label>
                                    <div class="col-md-9 inline">
                                        <el-select
                                            v-model="header.formulaStatus"
                                            @change="() => {
                                                    preventUnload()
                                                    this.hasDataChange = true
                                        }"
                                        >
                                            <el-option
                                                v-for="item in lovStatus"
                                                :key="item.formula_status"
                                                :label="item.formula_status"
                                                :value="item.formula_status"
                                            >
                                                <span>{{ item.formula_status }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">วันที่อนุมัติ</label>
                                    <div class="col-md-9 inline">
                                        <input
                                            class="form-control input-field disabled-white"
                                            :disabled="true"
                                            :value="toThDateString(luxon.DateTime.fromSQL(header.formulaApprovalDate).toJSDate())"
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">วันที่เริ่มใช้</label>
                                    <div class="col-md-9 inline">
                                        <ct-datepicker
                                            v-if="(() => {
                                                return header.formulaStatus === 'Active'

                                            })()"
                                            class="input-field form-control"
                                            placeholder="โปรดเลือกวันที่"
                                            :enableDate="date => isInRange(date, luxon.DateTime.now(), null, true)"
                                            :value="luxon.DateTime.fromSQL(header.formulaStartDate).toJSDate()"
                                            :clearable="false"
                                            @change="(date) => {
                                                    if(date){
                                                        header.formulaStartDate = jsDateToString(date)
                                                    }
                                                }"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-right">
                    <button class="btn btn-success" @click.prevent="addItem('lines')">เพิ่มรายการ</button>
                    <button class="btn btn-danger" @click.prevent="deleteItem('lines')">ลบรายการ</button>
                </p>
                <div class="ibox">
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" @click="checkedAll('lines')" v-model="isCheckedAll.lines">
                                </th>
                                <th>รหัสวัตถุดิบ</th>
                                <th>รายละเอียด</th>
                                <!--                            <th>Lot</th>-->
                                <th>สัดส่วน (%)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(line, lineIdx) in lines" :key="lineIdx">
                                <td>
                                    <input type="checkbox" v-model="checkedItem.lines" :value="lineIdx"
                                           @change="updateChecked('lines')">
                                </td>
                                <td>
                                    <el-select
                                        v-model="line.inventory_item_code"
                                        filterable
                                        remote
                                        placeholder="ระบุรหัสวัตถุสินค้า"
                                        :loading="false"
                                        @visible-change="v => labelDecorator(v,
                                            item => `${item.inventory_item_code}`,
                                            item => `${item.inventory_item_code}: ${item.description}`,
                                            'lookupLines',
                                            `lines[${lineIdx}].inventory_item_code`,
                                            'myLabel'
                                         )"
                                        @change="(inventory_item_code) => {
                                        preventUnload()
                                        hasDataChange = true
                                        let lline = lookupLines.filter(it => it.inventory_item_code === inventory_item_code)[0]
                                        line.inventory_item_id = lodash.get(lline, 'inventory_item_id', null)
                                        line.description = lodash.get(lline, 'description', null)
                                        // line.lot_number_list = lodash.get(lline, 'lot_number_list', [])
                                        // line.lot_number = lodash.get(lline, 'lot_number_list[0].lot_number', null)
                                        //onChangeLookupLines(lineIdx)
                                    }">
                                        <el-option
                                            v-for="(lookupLine, i) in lookupLines"
                                            :key="lookupLine.inventory_item_code"
                                            :label="lookupLine.myLabel"
                                            :value="lookupLine.inventory_item_code">
                                        </el-option>
                                    </el-select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" v-model="line.description" disabled>
                                </td>
                                <!--                            <td>-->
                                <!--                                <el-select-->
                                <!--                                    v-model="line.lot_number"-->
                                <!--                                    filterable-->
                                <!--                                    remote-->
                                <!--                                    placeholder="ระบุ Lot Number"-->
                                <!--                                    :loading="false"-->
                                <!--                                    :disabled="line.inventory_item_code == ''"-->
                                <!--                                    @change="() => {-->
                                <!--                                        preventUnload()-->
                                <!--                                        hasDataChange = true-->
                                <!--                                    }">-->
                                <!--                                    &lt;!&ndash;v-for="lookupLotNumber in filterLotNumber(line.inventory_item_code)"&ndash;&gt;-->
                                <!--                                    <el-option-->
                                <!--                                        v-for="item in line.lot_number_list"-->
                                <!--                                        :key="item.lot_number"-->
                                <!--                                        :label="item.lot_number"-->
                                <!--                                        :value="item.lot_number">-->
                                <!--                                    </el-option>-->
                                <!--                                </el-select>-->
                                <!--                            </td>-->
                                <td>
                                    <input
                                        style="text-align: right;"
                                        type="number"
                                        class="form-control"
                                        v-model="line.item_ratio" min="1"
                                        @change="() => {
                                        preventUnload()
                                        hasDataChange = true
                                    }">
                                </td>
                            </tr>
                            <tr v-if="lines.length > 0">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right; padding-right: 32px;">{{
                                        totalItemRatio ? totalItemRatio : ''
                                    }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="searchForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ค้นหา</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group row">
                                    <label
                                        class="col-md-3 col-form-label">
                                        ประเภทสูตร
                                    </label>
                                    <div class="col-md-9">
                                        <el-select
                                            id="search_raw_material_type"
                                            placeholder="กรุณาเลือกประเภทสูตร"
                                            class="col-md-12"
                                            value-key="description"
                                            :value="searchModel.formulaType"
                                            filterable
                                            @change="(item)=>{
                                                      console.debug(item, item.description)
                                                      this.searchModel.formulaTypeCode = item.lookup_code
                                                      this.searchModel.formulaType = item.description
                                                      onSelectedFormulaType()
                                            }">
                                            <el-option
                                                v-for="item in lovFormulaType"
                                                :key="item.lookup_code"
                                                :label="item.description"
                                                :value="item">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-md-3 col-form-label">
                                        ยาเส้นพอง
                                    </label>
                                    <div class="col-md-9">
                                        <el-select
                                            class="col-md-12"
                                            v-model="searchModel.expandedTobacco"
                                            clearable
                                            filterable
                                            placeholder="ยาเส้นพอง">
                                            <el-option
                                                v-for="item in this.expandedTobaccoList"
                                                :key="item.expanded_tobacco"
                                                :label="item.inventory_item_code"
                                                :value="item.expanded_tobacco"></el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-md-3 col-form-label">
                                        รายละเอียด
                                    </label>
                                    <div class="col-md-9">
                                        <el-select
                                            class="col-md-12"
                                            v-model="searchModel.description"
                                            clearable
                                            filterable
                                            placeholder="เลือกรายละเอียด">
                                            <el-option
                                                v-for="item in this.descList"
                                                :key="item.description"
                                                :label="item.description"
                                                :value="item.description"></el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="float-right pr-3">
                                            <!--ปุ่มล้างค่า-->
                                            <button type="button"
                                                    :class="btn_trans.reset.class"
                                                    @click.prevent="resetSearchForm()">
                                                <i :class="btn_trans.reset.icon"></i>
                                                {{ btn_trans.reset.text }}
                                            </button>
                                            <!--ปุ่มค้นหา-->
                                            <button type="button"
                                                    :class="btn_trans.search.class"
                                                    @click.prevent="submitSearchForm()">
                                                <i :class="btn_trans.search.icon"></i>
                                                {{ btn_trans.search.text }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <div>
                                            <div class="ibox-content">
                                                <div style="height: 300px; overflow-y: scroll;">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>ยาเส้นพอง</th>
                                                            <th>รายละเอียด</th>
                                                            <th>ประเภทสูตร</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="item in searchResultItems"
                                                            :key="item.exp_tobacco_id"
                                                            style="cursor: pointer"
                                                            @click="() => {
                                                            saved = true
                                                            selectHeader(item.exp_tobacco_id)
                                                            }">
                                                            <td>{{ item.inventory_item_code }}</td>
                                                            <td>{{ item.description }}</td>
                                                            <td>{{
                                                                    getFormulaDescription(item.folmula_type)[0].description
                                                                }}
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ประวัติการแก้ไขยาเส้นพอง {{ header.inventoryItemCode }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="height: 300px; overflow: scroll;">
                                <table class="table" v-if="histories.length">
                                    <thead>
                                    <tr>
                                        <th>ครั้งที่</th>
                                        <th>ผู้แก้ไข</th>
                                        <th>วันที่แก้ไข</th>
                                        <th>Field แก้ไข</th>
                                        <th>ข้อมูลเดิม</th>
                                        <th>ข้อมูลที่แก้ไข</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="history in histories" :key="history.id">
                                        <td>{{ history.edit_no }}</td>
                                        <td>{{ history.edit_by }}</td>
                                        <td>{{ history.edit_date }}</td>
                                        <td>{{ history.edit_field }}</td>
                                        <td>{{ history.old_data }}</td>
                                        <td>{{ history.new_data }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <p v-else>ยาเส้นพอง {{ header.inventoryItemCode }} ไม่มีประวัติการแก้ไข</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--        <div class="form-group row">-->
        <!--                        <pre class="col-lg-4" style="display: block">{{-->
        <!--                                JSON.stringify({-->
        <!--                                    expandedTobaccoList,-->
        <!--                                    dataExpandedTobaccoList,-->
        <!--                                    isCreate,-->
        <!--                                    expandedTobaccoList,-->
        <!--                                    descList,-->
        <!--                                    headers,-->
        <!--                                    itemLst,-->
        <!--                                    defaultData,-->
        <!--                                }, null, 2)-->
        <!--                            }}-->
        <!--                        </pre>-->
        <!--            <pre class="col-lg-4" style="display: block">{{-->
        <!--                    JSON.stringify({-->
        <!--                        header,-->
        <!--                        existedItems,-->
        <!--                        lovFormulaType,-->
        <!--                        lovStatus,-->
        <!--                    }, null, 2)-->
        <!--                }}-->
        <!--                        </pre>-->

        <!--            <pre class="col-lg-4" style="display: block">{{-->
        <!--                    JSON.stringify({-->
        <!--                        lastUpdatedByName,-->
        <!--                        formulaTypeDesc,-->
        <!--                        lookupHeaders,-->
        <!--                        lookupLines,-->

        <!--                    }, null, 2)-->
        <!--                }}-->
        <!--                        </pre>-->
        <!--        </div>-->
    </div>
</template>
<script>
import {
    showValidationFailedDialog,
    showLoadingDialog,
    showSimpleConfirmationDialog, showSaveSuccessDialog, showSaveFailureDialog,
    showGenericFailureDialog,
} from "../../commonDialogs"
import * as Validator from 'validatorjs';
import {buildValidatingEntry, validateDataAgainstRules} from "../../validatorUtils"
import {customSelectDropDownLabelDecorator} from '../../elementUiDecorator'
import {preventUnload, cancelPreventUnload} from '../../utils'

import _get from 'lodash/get'
import _equals from 'lodash/_equalObjects'
import {$route, api_pd_0009_search, pd_0009_index} from '../../router'
import _cloneDeep from "lodash/cloneDeep"

import {
    isInRange,
    jsDateToString,
    toJSDate,
    toThDateString
} from '../../dateUtils'

import {DateTime} from 'luxon';

export default {
    props: [
        'data',
        'init_header',
        'init_lines',
        'init_histories',
        'btn_trans',
        'default_data',
        'existed_items',
        'last_updated_by_name',
    ],
    data() {
        return {
            lodash: {
                get: _get,
                cloneDeep: _cloneDeep,
            },
            swal,

            //luxon
            console,

            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,

            luxon: {
                DateTime,
            },
            preventUnload,

            headers: this.data.headers,
            header: {
                id: _get(this.init_header, 'exp_tobacco_id', ''),
                expandedTobacco: _get(this.init_header, 'expanded_tobacco', ''),
                description: _get(this.init_header, 'description', ''),
                inventoryItemCode: _get(this.init_header, 'inventory_item_code', ''),
                inventoryItemId: _get(this.init_header, 'inventory_item_id', ''),
                formulaType: _get(this.init_header, 'folmula_type', ''),
                quantity: _get(this.init_header, 'quantity', ''),
                uom: _get(this.init_header, 'uom', ''),
                formulaStatus: _get(this.init_header, 'formula_status', ''),
                remark: _get(this.init_header, 'remark', ''),
                formulaStartDate: _get(this.init_header, 'formula_start_date', ''),
                formulaApprovalDate: _get(this.init_header, 'formula_approval_date', ''),
                createdAt: this.data.createdAt,
                formulaCreationDate: _get(this.init_header, 'formula_creation_date', ''),
                formulaLastUpdateDate: _get(this.init_header, 'formula_last_update_date', ''),
                createdBy: _get(this.init_header, 'created_by', ''),
                updatedAt: _get(this.init_header, 'updated_at', ''),
                lastUpdatedBy: _get(this.init_header, 'last_updated_by', ''),
            },
            lines: this.init_lines,
            histories: [...this.init_histories],
            defaultData: _cloneDeep(this.default_data),
            existedItems: _cloneDeep(this.existed_items),
            lastUpdatedByName: _cloneDeep(this.last_updated_by_name),

            searchModel: {
                expandedTobacco: '',
                description: '',
                formulaType: '',
                formulaTypeCode: '',
            },

            searchResultItems: this.existed_items,
            dataExpandedTobaccoList: [],
            dataDescList: [],
            expandedTobaccoList: [],
            descList: [],

            // checked
            checkedItem: {
                lines: [],
            },
            isCheckedAll: {
                lines: false,
            },
            //searchForm
            qCode: '',
            qDesc: '',
            //lookup
            lookupHeaders: this.data.lookupHeaders,
            lookupLines: this.data.lookupLines,
            lovStatus: this.data.lovStatus,
            lovFormulaType: this.data.lovFormulaType,

            saved: !!_get(this.init_header, 'exp_tobacco_id', false),
            toDeleteLineIdList: [],
            hasDataChange: false,

            isCreate: true,
            dataItemLst: [],
            itemLst: [],

            formulaTypeDesc: '',
            lastUpdatedBy: '',
        }
    },
    mounted() {
        if (this.header.id !== null && this.header.id !== '') {
            this.isCreate = false;
        }
        if (this.isCreate) {
            this.header.formulaCreationDate = DateTime.now().toFormat('yyyy-MM-dd HH:mm:ss')
            this.header.formulaStatus = "Inactive"
            this.header.uom = "KG"
            this.header.createdBy = this.defaultData.user_id
            this.header.lastUpdatedBy = this.defaultData.user_id
            this.lastUpdatedBy = this.defaultData.user_name
        } else {
            if (this.header.formulaCreationDate === null) {
                this.header.formulaCreationDate = DateTime.now().toFormat('yyyy-MM-dd HH:mm:ss')
            }
            this.header.formulaStatus = this.init_header.formula_status
            this.lastUpdatedBy = this.lastUpdatedByName[0].name
        }

        if (this.header.formulaStatus === "Inactive") {
            this.header.formulaApprovalDate = ""
            this.header.formulaStartDate = ""
        }

        this.lookupHeaders.forEach(data_req => {
            let isExists = this.dataItemLst.some(item => item.inventory_item_code === data_req.inventory_item_code)
            if (!isExists) {
                this.dataItemLst.push({
                    blend_no: data_req.blend_no,
                    inventory_item_code: data_req.inventory_item_code,
                    inventory_item_id: data_req.inventory_item_id,
                })
            }
        })
        this.itemLst = this.dataItemLst

        this.existedItems.forEach(existedItem => {
            let isExistsExpandedTobaccoList = this.dataExpandedTobaccoList.some(item => item.expanded_tobacco === existedItem.expanded_tobacco)
            if (!isExistsExpandedTobaccoList) {
                this.dataExpandedTobaccoList.push({
                    expanded_tobacco: existedItem.expanded_tobacco,
                    inventory_item_code: existedItem.inventory_item_code,
                    formula_type: existedItem.folmula_type,
                })
            }

            let isExistsDescList = this.dataDescList.some(item => item.description === existedItem.description)
            if (!isExistsDescList) {
                this.dataDescList.push({
                    formula_type: existedItem.folmula_type,
                    description: existedItem.description,
                })
            }
        })
        this.expandedTobaccoList = this.dataExpandedTobaccoList.sort()
        this.descList = this.dataDescList.sort()
    },
    watch: {
        'header.formulaStatus': function (status) {

            if (this.isCreate) {
                if (status === 'Active') {
                    this.header.formulaApprovalDate = DateTime.now().toFormat('yyyy-MM-dd HH:mm:ss')
                    this.header.formulaStartDate = DateTime.now().toFormat('yyyy-MM-dd HH:mm:ss')
                }
                if (status === 'Inactive') {
                    this.header.formulaApprovalDate = ""
                    this.header.formulaStartDate = ""
                }
            } else {
                if (status === 'Active') {
                    this.header.formulaApprovalDate = this.init_header.formula_approval_date === null ? DateTime.now().toFormat('yyyy-MM-dd HH:mm:ss') : this.init_header.formula_approval_date
                    this.header.formulaStartDate = this.init_header.formula_start_date === null ? DateTime.now().toFormat('yyyy-MM-dd HH:mm:ss') : this.init_header.formula_start_date

                    //DateTime.fromSQL(expiredItem.origination_date).toJSDate()
                }
                if (status === 'Inactive') {
                    this.header.formulaApprovalDate = ""
                    this.header.formulaStartDate = ""
                }
            }
        },
    },
    computed: {
        filterHeaders() {
            return this.headers
        },
        totalItemRatio() {
            const floatOrZero = (number) => !number || isNaN(number) ? 0 : parseFloat(number)
            return this.lines.reduce((acc, line) => acc + floatOrZero(line.item_ratio), 0)
        },
    },
    methods: {
        onSelectedFormulaType() {
            console.log('before', this.expandedTobaccoList)

            let selectedFormulaTypeCode = this.searchModel.formulaTypeCode
            console.log(selectedFormulaTypeCode)

            this.expandedTobaccoList = this.dataExpandedTobaccoList
            this.descList = this.dataDescList

            //filter expand tobacco list in search modal
            this.expandedTobaccoList =
                this.existedItems.filter(item => item.folmula_type === selectedFormulaTypeCode.toString())
            //filter description list in search modal
            this.descList =
                this.existedItems.filter(item => item.folmula_type === selectedFormulaTypeCode.toString())

            console.log('after', this.expandedTobaccoList)
        },
        resetSearchForm() {
            this.searchModel.expandedTobacco = ''
            this.searchModel.description = ''
            this.searchModel.formulaType = ''
            this.searchModel.formulaTypeCode = ''
            this.existedItems = this.existed_items
            this.searchResultItems = this.existedItems
            this.expandedTobaccoList = this.dataExpandedTobaccoList
            this.descList = this.dataDescList
        },
        submitSearchForm() {
            console.log('submitSearchForm', this.searchModel)

            this.searchResultItems = this.filterByFormulaType(this.filterByExpandedTobacco(this.filterByDescription((this.existedItems))))

            console.log('searchResultItemAfter', this.searchResultItems)
        },
        filterByFormulaType(existedItems) {
            if (!this.searchModel.formulaTypeCode && this.searchModel.formulaTypeCode === '') return existedItems
            return existedItems.filter(item => item.folmula_type === this.searchModel.formulaTypeCode.toString())
        },
        filterByExpandedTobacco(existedItems) {
            if (!this.searchModel.expandedTobacco && this.searchModel.expandedTobacco === '') return existedItems
            return existedItems.filter(item => item.expanded_tobacco === this.searchModel.expandedTobacco)
        },
        filterByDescription(existedItems) {
            if (!this.searchModel.description && this.searchModel.description === '') return existedItems
            return existedItems.filter(item => item.description === this.searchModel.description)
        },

        labelDecorator(...args) {
            customSelectDropDownLabelDecorator.apply(this, args)
        },
        searchHeader() {
            showLoadingDialog()
            axios.get($route(api_pd_0009_search), {
                params: {
                    inventory_item_code: this.qCode,
                    description: this.qDesc,
                }
            }).then(({data}) => data).then(({headers}) => {
                swal.close()
                this.headers = headers
            }).catch(error => {
                console.log(error)
            })
        },
        filterMethod(query) {

            if (query !== '') {
                this.itemLst = this.dataItemLst.filter(dataItem => {
                    return dataItem.blend_no.toLowerCase().indexOf(query.toLowerCase()) > -1 || dataItem.inventory_item_code.toLowerCase().indexOf(query.toLowerCase()) > -1
                })
            } else {
                this.itemLst = this.dataItemLst
            }
        },
        // async onClickItem(rawMaterialId) {
        //     if (this.hasDataChange && !await showSimpleConfirmationDialog('มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก ต้องการออกจากหน้านี้?')) return
        //
        //     showLoadingDialog()
        //     cancelPreventUnload()
        //
        //     redirectTo(rawMaterialId);
        // },
        onChgItemCode() {
            preventUnload()
            this.hasDataChange = true

            let item = this.itemLst.filter(item => item.inventory_item_code === this.header.inventoryItemCode)[0]
            console.log(item)
            this.header.inventoryItemCode = item.inventory_item_code
            this.header.inventoryItemId = item.inventory_item_id
            this.header.expandedTobacco = item.blend_no
        },
        filterHeadersByDesc(headers) {
            if (!this.qDesc) return headers
            // return headers.filter(header => header.description.indexOf(this.qDesc) >= 0)
            return headers.filter(header => header.description.includes(this.qDesc))
        },
        filterHeadersByNo(headers) {
            if (!this.qCode) return headers
            return headers.filter(header => header.inventory_item_code.includes(this.qCode))
        },
        filterLotNumber(itemCode) {
            return this.lookupLines.filter(lookup => lookup.inventory_item_code.includes(itemCode))
        },
        setterData(data) {
            this.hasDataChange = true
            preventUnload()
            // console.log('header => ' + data.header)
            this.header = {
                id: data.header.exp_tobacco_id,
                description: data.header.description,
                inventoryItemCode: data.header.inventory_item_code,
                inventoryItemId: data.header.inventory_item_id,
                remark: data.header.remark,
                createdAt: data.header.created_at,
                createdBy: data.header.created_by,
                updatedAt: data.header.updated_at,
            }
            if (data.headers) {
                this.headers = data.headers
            }
            // console.log('lines => ' + data.lines)
            this.lines = data.lines
            // console.log('histories => ' + data.histories)
            this.histories = data.histories
        },
        checkedAll(itemType) {
            this.checkedItem[itemType] = []
            if (!this.isCheckedAll[itemType]) {
                for (var i in this[itemType]) {
                    this.checkedItem[itemType].push(parseInt(i))
                }
            }
        },
        updateChecked(itemType) {
            this.isCheckedAll[itemType] = this.checkedItem[itemType].length === this[itemType].length
        },
        addItem(itemType) {
            this.hasDataChange = true
            preventUnload()
            this[itemType].push({
                exp_tobacco_line_id: '',
                inventory_item_code: '',
                inventory_item_id: '',
                description: '',
                item_ratio: '',
                //lot_number: '',
            })
        },
        async deleteItem(itemType) {

            let confirmToDelete = await showSimpleConfirmationDialog('คุณต้องการลบรายการที่คุณเลือก')
            if (confirmToDelete) {
                this.hasDataChange = true
                preventUnload()
                // sort value before remove item from array
                this.checkedItem[itemType].sort(function (a, b) {
                    return b - a
                })
                let deleteLines = []

                for (var i in this.checkedItem[itemType]) {
                    if (this[itemType][i].exp_tobacco_line_id != '') {
                        // console.log('exp_tobacco_line_id => ' + this[itemType][i].exp_tobacco_line_id)
                        deleteLines.push(this[itemType][i].exp_tobacco_line_id)
                    }
                }

                // loop for remove checked from array
                for (var i in this.checkedItem[itemType]) {
                    this[itemType].splice(this.checkedItem[itemType][i], 1)
                }

                // CHANGE REQUEST:
                // before: when select line to delete, call api to delete immediately
                // after: store delete ids until save then delete after save api (but line will disappear from ui)
                //
                // showLoadingDialog()
                // if (deleteLines.length > 0) {
                //     axios.delete('/api/pd/expanded-tobacco/' + this.header.id, {
                //         data: {
                //             lines: deleteLines
                //         }
                //     }).then(response => {
                //         if (response.status == 200) {
                //             console.log(response)
                //             // showLoadingDialog()
                //             // window.location = $route(pd_0009_index, {id: this.header.id})
                //         }
                //     }).catch(error => {
                //         console.log(error)
                //     })
                // }
                this.toDeleteLineIdList = [
                    ...this.toDeleteLineIdList,
                    ...deleteLines,
                ]

                // clear checked
                this.checkedItem[itemType] = []
                if (this.isCheckedAll[itemType]) {
                    this.isCheckedAll[itemType] = !this.isCheckedAll[itemType]
                }
            }
        },
        async selectHeader(headerId) {
            console.log('selectHeader | simuFormulaId => ' + headerId)
            if (this.hasDataChange && !await showSimpleConfirmationDialog('มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก ต้องการออกจากหน้านี้?')) return

            showLoadingDialog()
            cancelPreventUnload()
            window.location = $route(pd_0009_index, {id: headerId})

            axios.get('/api/pd/expanded-tobacco/' + headerId).then(response => {
                if (response.status == 200) {
                    console.log(response.data)
                    this.setterData(response.data)
                }
            }).catch(error => {
                console.log(error)
            })
            // close modal && clear query
            $('#searchForm').modal('hide')
            this.qCode = ''
            this.qDesc = ''
        },
        headerValidation() {
            return {
                inventoryItemCode: 'required',
            }
        },
        lineValidationRule() {
            return {
                inventory_item_code: 'required',
                //lot_number: 'required',
                item_ratio: 'required',
            }
        },
        validate() {
            let errors = []

            if (this.header.expandedTobacco === "" || this.header.expandedTobacco === null) {
                errors.push('ยาเส้นพอง')
            }

            let items = this.existedItems.filter(item =>
                item.expanded_tobacco === this.header.expandedTobacco)

            if (items.length > 0) {
                if (this.isCreate) {
                    let itemSelectedType = items.filter(item => item.folmula_type === this.header.formulaType)
                    if (itemSelectedType.length > 0) {
                        let formulaTypeDesc = this.getFormulaDescription(this.header.formulaType)[0].description
                        errors.push('ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมี' + formulaTypeDesc + 'แล้ว')
                    }
                } else {
                    if (this.header.formulaType !== this.init_header.folmula_type) {
                        let itemSelectedType = items.filter(item => item.folmula_type === this.header.formulaType)
                        if (itemSelectedType.length > 0) {
                            let formulaTypeDesc = this.getFormulaDescription(this.header.formulaType)[0].description
                            errors.push('ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมี' + formulaTypeDesc + 'แล้ว')
                        }
                    }
                }
            }

            if (this.header.formulaType === "" || this.header.formulaType === null) {
                errors.push('ประเภทสูตร')
            }

            if (this.header.quantity === "" || this.header.quantity === null) {
                errors.push('ปริมาณ')
            }

            if (this.header.formulaStatus === "Active" && this.header.formulaStartDate === "") {
                errors.push('วันที่เริ่มใช้')
            }

            if (this.lines.filter(it => !it.item_ratio).length > 0) {
                errors.push('ต้องระบุ สัดส่วน')
            }

            if (this.totalItemRatio !== 100) {
                errors.push('ระบุสัดส่วนไม่ถูกต้อง')
            }

            if (this.lines.length === 0) {
                errors.push('ข้อมูลระดับ line')
            }

            if (errors.length > 0) {
                showValidationFailedDialog(errors)
                return false
            }

            return true
        },
        async resetForm() {
            if (this.hasDataChange && !await showSimpleConfirmationDialog('มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก ต้องการออกจากหน้านี้?')) return

            cancelPreventUnload()
            showLoadingDialog()

            //window.location.reload(false)
            cancelPreventUnload()
            window.location = $route(pd_0009_index)

        },
        async saveForm() {
            if (!this.validate()) {
                return;
            }
            let params = {
                //new
                expandedTobacco: this.header.expandedTobacco,
                description: this.header.description,
                inventoryItemCode: this.header.inventoryItemCode,
                inventoryItemId: this.header.inventoryItemId,
                formulaType: this.header.formulaType,
                quantity: this.header.quantity,
                uom: this.header.uom,
                formulaStatus: this.header.formulaStatus,
                remark: this.header.remark,
                formulaStartDate: this.header.formulaStartDate,
                formulaApprovalDate: this.header.formulaApprovalDate,
                // lines: this.lines.map(it => {
                //     return {
                //         ...it,
                //         lot_number: _get(it, 'lot_number.lot_number', it.lot_number),
                //     }
                // }),
                lines: this.lines.map(it => {
                    return {
                        ...it,
                    }
                }),
                deleted_line_ids: [...this.toDeleteLineIdList],
            }
            console.log(params.formulaStatus)

            showLoadingDialog()

            //if there are line to delete, call delete api first
            if (this.header.id) {
                for (let id of this.toDeleteLineIdList) {
                    try {
                        let response = await axios.delete('/api/pd/expanded-tobacco/' + this.header.id, {
                            data: {
                                lines: [id],
                            }
                        })
                        console.log(response)
                    } catch (e) {
                        console.error(error)
                        return await showSaveFailureDialog()
                    }
                }
            }

            if (this.header.id) {
                // console.log('Call API Put')
                axios.put('/api/pd/expanded-tobacco/' + this.header.id, params).then(async (response) => {

                    if (response.status == 200) {

                        this.isCreate = false
                        cancelPreventUnload()
                        //this.setterData(response.data)
                        console.log(response.data)
                        this.saved = true

                        if (response.data.packageResponse.V_STATUS !== 'E') {
                            await showSaveSuccessDialog()
                            showLoadingDialog()

                            console.log(response.data)

                            window.location = $route(pd_0009_index, {id: response.data.header.exp_tobacco_id})

                        } else {
                            showGenericFailureDialog(response.data.packageResponse.V_MSG).then(isOk => {
                                if (isOk) {
                                    window.location = $route(pd_0009_index, {id: response.data.header.exp_tobacco_id})
                                }
                            })
                        }

                    }
                }).catch(error => {
                    swal.close()
                    console.log(error)
                })
            } else {
                // console.log('Call API Post')
                axios.post('/api/pd/expanded-tobacco', params).then(async (response) => {

                    if (response.status == 200) {

                        this.isCreate = false
                        cancelPreventUnload()
                        //this.setterData(response.data)
                        console.log(response.data)
                        this.saved = true

                        if (response.data.packageResponse.V_STATUS !== 'E') {
                            await showSaveSuccessDialog()
                            showLoadingDialog()
                            console.log(response.data)

                            window.location = $route(pd_0009_index, {id: response.data.header.exp_tobacco_id})

                        } else {
                            showGenericFailureDialog(response.data.packageResponse.V_MSG).then(isOk => {
                                if (isOk) {
                                    window.location = $route(pd_0009_index, {id: response.data.header.exp_tobacco_id})
                                }
                            })
                        }
                    }
                }).catch(error => {
                    swal.close()
                    console.log(error)
                })
            }
        },
        onChangeLookupHeaders() {
            this.hasDataChange = true
            preventUnload()
            let idx = this.lookupHeaders.findIndex(arr => arr.inventory_item_code == this.header.inventoryItemCode)
            this.header.inventoryItemId = this.lookupHeaders[idx].inventory_item_id
            this.header.description = this.lookupHeaders[idx].description
        },
        onChangeLookupLines(lineIdx) {
            this.hasDataChange = true
            preventUnload()
            let idx = this.lookupLines.findIndex(arr => arr.inventory_item_code == this.lines[lineIdx].inventory_item_code)
            this.lines[lineIdx].inventory_item_id = this.lookupLines[idx].inventory_item_id
            this.lines[lineIdx].description = this.lookupLines[idx].description
        },
        stripNonNumber(text) {
            let charArr = [...text];
            let numArr = [];
            for (let i = 0; i < charArr.length; i++) {
                if (isNaN(charArr[i]) === false) {
                    numArr.push(charArr[i]);
                }
            }
            return Number(numArr.join(''));
        },
        numberFormat(n) {
            return `${n}`.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        getFormulaDescription(formulaType) {
            return this.lovFormulaType.filter(type => type.lookup_code == formulaType)
        },
        dataChanged(){
            this.hasDataChange = true
            preventUnload()
        }
    },
}
</script>

<style>
#PD0009 input.disabled-white {
    background-color: #FFFFFF;
    border: none;
}

#PD0009 .col-form-label {
    font-weight: bold;
}

#PD0009 .mx-datepicker {
    width: 100%;
}

#PD0009 .el-select {
    width: 100%;
}

</style>
