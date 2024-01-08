<template>
    <div class="row" >
        <div class="col-lg-12" v-loading="pageLoading">
            <div class="ibox">
                <!-- <div class="ibox-title">สารปรุง Casing</div> -->
                <div class="ibox-content pb-0" style="border-bottom: 0px;">
                    <div class="row">
                        <div class="col-4">
                            <h3>สารปรุง Casing</h3>
                        </div>
                        <div class="col-8">
                            <div class="float-right mb-3">
                                <button :class="btn.create.class" @click="onClickCreate">
                                    <i :class="btn.create.icon"></i> {{ btn.create.text }}
                                </button>
                                <button :class="btn.search.class" data-toggle="modal" data-target="#searchForm">
                                    <i :class="btn.search.icon"></i> {{ btn.search.text }}
                                </button>
                                <button :class="btn.save.class"  @click="onClickSave">
                                    <i :class="btn.save.icon"></i> {{ btn.save.text }}
                                </button>
                                <button :class="btn.copyFormula.class" :disabled="!header.simu_formula_id" data-toggle="modal" data-target="#copyModal">
                                    <i :class="btn.copyFormula.icon"></i> {{ btn.copyFormula.text }}
                                </button>
                                <button :class="btn.editHistory.class" :disabled="!header.simu_formula_id" data-toggle="modal" data-target="#historyModal">
                                    <i :class="btn.editHistory.icon"></i> {{ btn.editHistory.text }}
                                </button>
                                <button :class="btn.print.class" @click="report()">
                                    <i :class="btn.print.icon"></i> {{ btn.print.text }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content pb-0" style="border-bottom: 0px;">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">สารปรุง Casing No. <span
                                    style="color: red;">*</span></label>
                                <div class="col-lg-8">
                                    <input type="text"
                                           class="form-control"
                                           v-model="header.simu_formula_no"
                                           @change="dataChanged"
                                           :disabled="header.last_update_date !== ''">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">รายละเอียด</label>
                                <div class="col-lg-8">
                                    <input type="text"
                                           class="form-control"
                                           v-model="header.description"
                                           @change="dataChanged">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">หมายเหตุ</label>
                                <div class="col-lg-8">
                                    <textarea-count
                                        :maxlength="240"
                                        v-model="header.remark_formula"
                                        @change="dataChanged"
                                    ></textarea-count>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">วันที่สร้าง</label>
                                <div class="col-lg-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        :disabled="true"
                                        :value="toThDateString(toJSDate(header.creation_date, 'yyyy-MM-dd'))">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">วันที่แก้ไขล่าสุด</label>
                                <div class="col-lg-7">
                                    <input
                                        type="text"
                                        class="form-control"
                                        :disabled="true"
                                        :value="toThDateString(toJSDate(header.last_update_date, 'yyyy-MM-dd'))"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 col-form-label">ผู้บันทึก</label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" v-model="last_updated_by" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="float-right mb-3">
                <button :class="btn.add.class" @click.prevent="addItem('lines')" >
                    <i :class="btn.add.icon"></i> {{ btn.add.text }}
                </button>
                <button :class="btn.deleteList.class" @click.prevent="deleteItem('lines')" >
                    <i :class="btn.deleteList.icon"></i> {{ btn.deleteList.text }}
                </button>
            </div> -->
            <div class="ibox">
                <div class="ibox-content pb-0" style="border-bottom: 0px;">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-right mb-3">
                                <button :class="btn.add.class" @click.prevent="addItem('lines')" >
                                    <i :class="btn.add.icon"></i> {{ btn.add.text }}
                                </button>
                                <button :class="btn.deleteList.class" @click.prevent="deleteItem('lines')" >
                                    <i :class="btn.deleteList.icon"></i> {{ btn.deleteList.text }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" @click="checkedAll('lines')" v-model="isCheckedAll.lines">
                            </th>
                            <th class="text-center">รหัสวัตถุดิบ</th>
                            <th class="text-center">รายละเอียดวัตถุดิบ</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">ราคาต่อหน่วย</th>
                            <th class="text-center">หน่วยในคงคลัง</th>
                            <th class="text-center">ปริมาณที่ใช้</th>
                            <th class="text-center">หน่วย</th>
                            <th class="text-center">ต้นทุนวัตถุดิบที่ใช้</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(line, index) in lines" :key="index">
                            <td>
                                <input type="checkbox" v-model="checkedItem.lines" :value="index"
                                       @change="updateChecked('lines')">
                            </td>
                            <td>
                                <el-select
                                    v-model="line.raw_material_num"
                                    clearable
                                    filterable
                                    remote
                                    reserve-keyword
                                    :remote-method="remoteMethod"
                                    placeholder="ระบุรหัสวัตถุดิบ"
                                    :loading="loading"
                                    @change="onChangeRawMaterialNum(index)">
                                    <el-option
                                        v-for="(option, index) in options"
                                        :key="index"
                                        :label="option.item_code"
                                        v-show="!disabledOption(option.item_code, line.raw_material_num)"
                                        :value="option.item_code">
                                        <span>{{ option.item_code }}</span> : <span>{{ option.description }}</span>
                                    </el-option>
                                </el-select>
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model="line.description" disabled>
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model="line.status" disabled>
                            </td>
                            <td>
                                <vue-numeric
                                    v-if="line.price_per_unit" 
                                    separator="," 
                                    v-model="line.price_per_unit"
                                    :precision="5"
                                    class="form-control text-right"
                                    disabled>
                                </vue-numeric>
                                <vue-numeric 
                                    v-if="!line.price_per_unit" 
                                    separator="," 
                                    v-model="zero"
                                    :precision="5"
                                    class="form-control text-right"
                                    disabled>
                                </vue-numeric>
                                <!-- <input type="text" class="form-control text-right"  v-model="line.price_per_unit" disabled> -->
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model="line.uom_display" disabled>
                            </td>
                            <td>
                                <!-- <vue-numeric
                                    separator="," 
                                    :value="line.actual_qty"
                                    :precision="2"
                                    class="form-control text-right"
                                    :disabled="line.raw_material_num == ''"
                                    :min="0"
                                    @change="onChgUom(index)"
                                    @keypress="(event) => {
                                        NumberFormatThreePrecision(event ,event.target.value)
                                    }"
                                    @input=" (event)=> {
                                        line.actual_qty = event.target.value
                                    }"
                                    >
                                </vue-numeric> -->
                                <!-- xxxxxxx -->
                                <input type="number" class="form-control text-right"
                                       :value="line.actual_qty"
                                       :disabled="line.raw_material_num == ''"
                                       min=0
                                       @change="onChgUom(index)"
                                       @keypress="(event) => {
                                           NumberFormatThreePrecision(event ,event.target.value)
                                       }"
                                       @input=" (event)=> {
                                           line.actual_qty = event.target.value
                                }"/>
                            </td>
                            <td>
                                <el-select
                                    v-model="line.actual_uom"
                                    clearable
                                    filterable
                                    placeholder="ระบุหน่วย"
                                    :loading="loading"
                                    :disabled="line.raw_material_num == ''"
                                    @change="onChgUom(index)">

                                    <el-option
                                        v-for="uom , index in uoms(index)"
                                        :key="index"
                                        :label="uom.uom_display"
                                        :value="uom.uom">
                                    </el-option>
                                </el-select>
                            </td>
                            <td>
                                <vue-numeric 
                                    separator="," 
                                    :value="line.actual_cost"
                                    :precision="5"
                                    class="form-control text-right"
                                    disabled>
                                </vue-numeric>
                                <!-- <vue-numeric 
                                    v-if="!line.actual_cost"
                                    separator="," 
                                    v-model="zero"
                                    :precision="2"
                                    class="form-control text-right"
                                    disabled>
                                </vue-numeric> -->
                                <!-- <input type="text" class="form-control text-right" v-model="line.actual_cost" disabled> -->
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" > <p class="text-right">รวมปริมาณทั้งหมด</p> </td>
                            <td colspan="1"> 
                                <vue-numeric 
                                    separator="," 
                                    :value="summaryActualQty"
                                    :precision="5"
                                    class="form-control text-right"
                                    disabled>
                                </vue-numeric>
                                <!-- <input type="text" class="form-control text-right" v-model="summaryActualQty" disabled>  -->
                            </td>
                            <td colspan="1">
                                <p class="text-right">รวมต้นทุนทั้งหมด</p>
                            </td>
                            <td>
                                <vue-numeric 
                                    separator="," 
                                    :value="updateTotalCost"
                                    :precision="5"
                                    class="form-control text-right"
                                    disabled>
                                </vue-numeric>
                                <!-- <input type="text" class="form-control text-right" v-model="updateTotalCost" disabled> -->
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- <div class="row m-b">
                <div class="col-lg-6">
                    <h3>วิธีผสม</h3>
                </div>
                <div class="col-lg-6">
                    <div class="text-right">
                        <button :class="btn.add.class" @click.prevent="addItem('mixs')" >
                            <i :class="btn.add.icon"></i> {{ btn.add.text }}
                        </button>
                        <button :class="btn.deleteList.class" @click.prevent="deleteItem('mixs')" >
                            <i :class="btn.deleteList.icon"></i> {{ btn.deleteList.text }}
                        </button>
                    </div>
                </div>
            </div> -->
            <div class="ibox">
                <div class="ibox-content pb-0" style="border-bottom: 0px;">
                    <div class="row">
                        <div class="col-lg-6">
                            <h3>วิธีผสม</h3>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-right mb-3">
                                <button :class="btn.add.class" @click.prevent="addItem('mixs')" >
                                    <i :class="btn.add.icon"></i> {{ btn.add.text }}
                                </button>
                                <button :class="btn.deleteList.class" @click.prevent="deleteItem('mixs')" >
                                    <i :class="btn.deleteList.icon"></i> {{ btn.deleteList.text }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" @click="checkedAll('mixs')" v-model="isCheckedAll.mixs">
                            </th>
                            <th>ลำดับ</th>
                            <th width="80%">รายละเอียด</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(mix, index) in mixs" :key="index">
                            <td>
                                <input type="checkbox" v-model="checkedItem.mixs" :value="index"
                                       @change="updateChecked('mixs')">
                            </td>
                            <td>{{ index + 1 }}</td>
                            <td>
                                <!--<input type="text" class="form-control" v-model="mix.mix_desc">-->
                                <input-count
                                    :maxlength="240"
                                    v-model="mix.mix_desc"
                                    @change="dataChanged">
                                </input-count>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- <div class="row m-b">
                <div class="col-lg-6">
                    <h3>วิธีใช้</h3>
                </div>
                <div class="col-lg-6">
                    <div class="text-right">
                        <button :class="btn.add.class" @click.prevent="addItem('instructions')" >
                            <i :class="btn.add.icon"></i> {{ btn.add.text }}
                        </button>
                        <button :class="btn.deleteList.class" @click.prevent="deleteItem('instructions')" >
                            <i :class="btn.deleteList.icon"></i> {{ btn.deleteList.text }}
                        </button>
                    </div>
                </div>
            </div> -->
            <div class="ibox">
                <div class="ibox-content pb-0" style="border-bottom: 0px;">
                    <div class="row">
                        <div class="col-lg-6">
                            <h3>วิธีใช้</h3>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-right mb-3">
                                <button :class="btn.add.class" @click.prevent="addItem('instructions')" >
                                    <i :class="btn.add.icon"></i> {{ btn.add.text }}
                                </button>
                                <button :class="btn.deleteList.class" @click.prevent="deleteItem('instructions')" >
                                    <i :class="btn.deleteList.icon"></i> {{ btn.deleteList.text }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" @click="checkedAll('instructions')"
                                       v-model="isCheckedAll.instructions">
                            </th>
                            <th>ลำดับ</th>
                            <th width="80%">รายละเอียด</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(instruction, index) in instructions" :key="index">
                            <td>
                                <input type="checkbox" v-model="checkedItem.instructions" :value="index"
                                       @change="updateChecked('instructions')">
                            </td>
                            <td>{{ index + 1 }}</td>
                            <td>
                                <!--<input type="text" class="form-control" v-model="instruction.instruction_desc">-->
                                <input-count :maxlength="240"
                                             v-model="instruction.instruction_desc"
                                             @change="dataChanged">
                                </input-count>
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
            <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1230px;  padding-top: 1%;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ค้นหา</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-inline">
                            <label class="col-lg-3 col-form-label">สารปรุง Casing No.</label>
                            <div class="col-lg-3">
                                <!-- <input type="text" class="form-control" v-model="qSimuFormulaNo"> -->
                                <el-select
                                    v-model="qSimuFormulaNo"
                                    clearable
                                    filterable
                                    placeholder="เลือกสารปรุง Casing No"
                                    :loading="loading">
                                    <el-option
                                        v-for="(casingNo, index) in casingNoList"
                                        :key="index"
                                        :label="casingNo.simu_formula_no + ' : ' + casingNo.description"
                                        :value="casingNo.simu_formula_no">
                                        <!-- {{descCasing(casingNo)}} -->
                                    </el-option>
                                </el-select>
                            </div>
                        <!-- </div>
                        <div class="form-group row"> -->
                            <label class="col-lg-2 col-form-label">รายละเอียด</label>
                            <div class="col-lg-4">
                                <!-- <input type="text" class="form-control" v-model="qDesc"> -->
                                <el-select
                                    v-model="qDesc"
                                    clearable
                                    filterable
                                    placeholder="เลือกรายละเอียด"
                                    :loading="loading">
                                    <el-option
                                        v-for="(desc, index) in descList"
                                        :key="index"
                                        :label="desc.description"
                                        :value="desc.description">
                                        </el-option>
                                    </el-select>
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <label class="col-form-label col-lg-9"></label>
                            <div>
                                <button type="button" class="btn btn-warning" @click.prevent="resetSearchForm">
                                    <i :class="btn.reset.icon"></i> {{ btn.reset.text }}
                                </button>
                                <button type="button" :class="btn.search.class" @click.prevent="submitSearchForm">
                                    <i :class="btn.search.icon"></i> {{ btn.search.text }}
                                </button>
                            </div>
                        </div>
                        <div style="height: 300px; overflow: scroll;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Casing No.</th>
                                    <th>รายละเอียด</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="header in headers" :key="header.simu_formula_id" style="cursor: pointer"
                                    @click="onClickHeader(header.simu_formula_id)">
                                    <td>{{ header.simu_formula_no }}</td>
                                    <td>{{ header.description }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คัดลอกสูตร</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="errors.length">
                        <ul>
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">จากสูตร Casing No.</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" v-model="header.simu_formula_no" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">เป็นสูตร Casing No.</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" v-model="new_simu_formula_no">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label"></label>
                            <div class="col-lg-8">
                                <button type="button" :class="btn.ok.class" @click.prevent="onClickCopy">
                                    <i :class="btn.ok.icon"></i> {{ btn.ok.text }}
                                </button>
                                <button type="button" :class="btn.cancel.class" @click.prevent="closeCopyModal">
                                    <i :class="btn.cancel.icon"></i> {{ btn.cancel.text }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1230px;  padding-top: 1%;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ประวัติการแก้ไข Casing No. {{ header.simu_formula_no }}</h5>
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
                                    <th>ส่วนที่แก้ไข</th>
                                    <th>Field แก้ไข</th>
                                    <th>ข้อมูลเดิม</th>
                                    <th>ข้อมูลที่แก้ไข</th>
                                    <th>รหัสวัตถุดิบ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="history in histories" :key="history.id">
                                    <td>{{ history.edit_no }}</td>
                                    <td>{{ history.edit_by }}</td>
                                    <td>{{ history.edit_date }}</td>
                                    <td>{{ historyDescription(history.edit_field) }}</td>
                                    <td>{{ historyFieldDescription(history.edit_field)  }}</td>
                                    <td>{{ history.old_data }}</td>
                                    <td>{{ history.new_data }}</td>
                                    <td>
                                        <span v-if="historyFieldDescription(history.edit_field) != 'รหัสวัตถุดิบ' ">
                                            {{ history.item_code }}
                                        </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <p v-else>Casing No. {{ header.simu_formula_no }} ไม่มีประวัติการแก้ไข</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--        <div class="form-group row">-->
        <!--                                        <pre class="col-lg-4" style="display: block">{{-->
        <!--                                                JSON.stringify({-->
        <!--                                                    header,-->
        <!--                                                    last_updated_by,-->
        <!--                                                }, null, 2)-->
        <!--                                            }}-->
        <!--                                         </pre>-->

        <!--            <pre class="col-lg-4" style="display: block">{{-->
        <!--                    JSON.stringify({-->
        <!--                        lines,-->
        <!--                    }, null, 2)-->
        <!--                }}-->
        <!--                                                    </pre>-->

        <!--            <pre class="col-lg-4" style="display: block">{{-->
        <!--                    JSON.stringify({-->
        <!--                        raw_materials_data,-->
        <!--                        uoms_data,-->
        <!--                    }, null, 2)-->
        <!--                }}-->
        <!--                                                    </pre>-->
        <!--        </div>-->
        <ul>
            <li v-for="(i,k) in uCasingNoList">{{k}}</li>
        </ul>
    </div>
</template>
<script>
import DatePicker from 'vue2-datepicker'
import {
    toJSDate,
    toThDateString,
    jsDateToString,
    isInRange
} from '../../dateUtils'
import {DateTime} from 'luxon'
import {
    showLoadingDialog,
    showValidationFailedDialog,
    showSaveSuccessDialog,
    showRemoveLineConfirmationDialog,
    showSimpleConfirmationDialog,
    showGenericFailureDialog,
} from '../../commonDialogs'
import {preventUnload, cancelPreventUnload} from '../../utils'
import VueNumeric from 'vue-numeric'

export default {
    props: ['btn', 'default_data', 'headers_data', 'raw_materials_data'],
    components: {'ct-datepicker-th': DatePicker,VueNumeric},
    data() {
        return {
            luxon: {DateTime},
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,

            preventUnload,

            user_id: this.default_data.user_id,
            user_name: this.default_data.user_name,
            created_by: '',
            last_updated_by: '',
            header: {
                simu_formula_id: '',
                simu_formula_no: '',
                description: '',
                remark_formula: '',
                creation_date: new Date(),
                created_by: '',
                last_update_date: '',
                last_updated_by: '',
            },
            new_simu_formula_no: '',
            headers: this.headers_data,
            headers_copy: this.headers_data,
            lines: [],
            mixs: [],
            instructions: [],
            isCheckedAll: {
                lines: false,
                mixs: false,
                instructions: false,
            },
            checkedItem: {
                lines: [],
                mixs: [],
                instructions: [],
            },
            totalActualCost: 0,
            qSimuFormulaNo: '',
            qDesc: '',
            loading: false,
            pageLoading: false,
            histories: [],
            errors: [],
            options: this.raw_materials_data,

            hasDataChange: false,

            historyDescriptions: "",

            update_total: 0,
            sum_actual_qty: 0,
            zero: 0,

            uCasingNoList : {},
            uoms_data: [],
            uom_type_normal: [],
        }
    },
    mounted() {

    },
    computed: {
        casingNoList() {
            if(!this.qDesc){
                return   [...new Set(this.headers_copy)].sort()
            } else {
                return   [...new Set(this.headers_copy.filter(header => header.description == this.qDesc))].sort()
            }

        },
        descList() {

            if(!this.qSimuFormulaNo){
                return   [...new Set(this.headers_copy)].sort()
            } else {
                return   [...new Set(this.headers_copy.filter(header => header.simu_formula_no == this.qSimuFormulaNo))].sort()
            }
            // return [...new Set(this.headers_copy.filter(header => header.simu_formula_no == this.qSimuFormulaNo))].sort()
        },
        updateTotalCost() {
            let totalActualCost = 0;

            this.lines.forEach(function (line) {
                if (line.actual_cost > 0) {
                    totalActualCost += parseFloat(line.actual_cost)
                }
            })
            this.update_total = totalActualCost;
            return totalActualCost;
        },

        summaryActualQty() {
            let summaryActualQty = 0;
            this.lines.forEach(function (line) {
                if (line.actual_qty > 0) {
                    summaryActualQty += parseFloat(line.actual_qty)
                }
            })
            this.sum_actual_qty = summaryActualQty;
            return summaryActualQty;
        },

    },
    methods: {
        NumberFormatThreePrecision(event, value) {
            let keyCode = (event.keyCode ? event.keyCode : event.which);

            // only allow number and one dot
            if ((keyCode < 48 || keyCode > 57) && (keyCode !== 46 || value.indexOf('.') != -1)) { // 46 is dot
                event.preventDefault();
            }

            // restrict to 3 decimal places
            if (value != null && value.indexOf(".") > -1 && (value.split('.')[1].length > 4)) {
                event.preventDefault();
            }
        },
        resetSearchForm() {
            this.qSimuFormulaNo = ''
            this.qDesc = ''
            this.headers = this.headers_copy
        },
        submitSearchForm() {
    
            if (this.qSimuFormulaNo !== '') {
                this.headers = this.headers_copy.filter(header => header.simu_formula_no == this.qSimuFormulaNo)
            }else {
                if (this.qSimuFormulaNo !== '' || this.qDesc !== '') {
                    this.headers = this.headers_copy.filter(header => header.simu_formula_no == this.qSimuFormulaNo || header.description == this.qDesc)
                }
            }
            
            // if (this.qSimuFormulaNo !== '' || this.qDesc !== '') {
            //     this.headers = this.headers_copy.filter(header => header.simu_formula_no == this.qSimuFormulaNo || header.description == this.qDesc)
            // }


        },
        async onClickHeader(headerId) {
            if (this.hasDataChange && !await showSimpleConfirmationDialog('มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก ต้องการออกจากหน้านี้?')) return
            showLoadingDialog()
            cancelPreventUnload()
            this.hasDataChange = false

            axios.get('/api/pd/0001/' + headerId).then(response => {
                if (response.status == 200) {
                    swal.close();
                    this.setNewData(response.data);
                    this.uoms_data = response.data.uoms_data;
                    this.uom_type_normal = response.data.uom_type_normal;
                }
            }).catch(error => {
                console.log(error)
            })
            $('#searchForm').modal('hide')
            this.qSimuFormulaNo = ''
            this.qDesc = ''
        },
        filterMethod(query) {
            console.log(query);
            if (query !== '') {
                this.options = this.raw_materials_data.filter(raw_material => {
                    return raw_material.item_code.toLowerCase().indexOf(query.toLowerCase()) > -1 || raw_material.description.toLowerCase().indexOf(query.toLowerCase()) > -1
                })
            } else {
                this.options = this.raw_materials_data
            }
        },

        remoteMethod(query) {
            console.log(query);
            if (query !== '') {
                this.options = this.raw_materials_data.filter(raw_material => {
                    return raw_material.item_code.toLowerCase().indexOf(query.toLowerCase()) > -1 || raw_material.description.toLowerCase().indexOf(query.toLowerCase()) > -1
                })
            } else {
                this.options = this.raw_materials_data;
            }
        },
        uoms(lineIdx) {
            let rawMaterialNum = this.lines[lineIdx].raw_material_num
            let rawMaterial = this.raw_materials_data.filter(raw_material => raw_material.item_code == rawMaterialNum)[0]
            if (rawMaterial) {
                let uoms_data = this.uoms_data.filter(uom => uom.inventory_item_id == rawMaterial.inventory_item_id && uom.organization_id == rawMaterial.organization_id)

                let dataItemLst = [];

                uoms_data.forEach(data_req => {
                    dataItemLst.push({
                        uom: data_req.code,
                        uom_display: data_req.uom_display,
                    })
                })
                if(uoms_data.length == 0){
                    dataItemLst =[];
                    this.uom_type_normal.forEach(data_req => {
                        dataItemLst.push({
                            uom: data_req.code,
                            uom_display: data_req.uom_display,
                        })
                    })

                    return dataItemLst
                }

                return dataItemLst
            }


            return []
        },
        onChgUom(lineIdx) {
            let line = this.lines[lineIdx]
            let rawMaterial = this.raw_materials_data.filter(raw_material => raw_material.item_code == line.raw_material_num)[0]
            let uom = this.uoms_data.filter(uom => uom.inventory_item_id == rawMaterial.inventory_item_id && uom.organization_id == rawMaterial.organization_id && uom.code == line.actual_uom)[0]
            if(uom != undefined){
                this.lines[lineIdx].actual_cost = line.price_per_unit * uom.conversion_rate * line.actual_qty
            }

            uom = this.uoms_data;
            preventUnload()
            this.hasDataChange = true
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
            this.isCheckedAll[itemType] = (this.checkedItem[itemType].length === this[itemType].length)
            this.hasDataChange = true
            preventUnload()
        },
        addItem(itemType) {
            if (itemType === 'lines') {
                this[itemType].push({
                    raw_material_id: '',
                    raw_material_num: '',
                    description: '',
                    status: '',
                    price_per_unit: '',
                    uom: '',
                    actual_qty: 0,
                    actual_uom: '',
                    actual_cost: 0,
                });

                    // let itemInLines = [];

                    // this.lines.forEach(function (line) {
                    //     itemInLines.push(line.raw_material_num);
                    // })

                    // itemInLines.forEach(element => {
                    //     this.options.filter(item => {
                    //         console.log(element);
                    //         // console.log( item.item_code);
                    //         return  item.item_code != element;
                    //     })
                    // });

                    // console.log(itemInLines);

            } else {
                this[itemType].push({
                    desc: ''
                })
            }
        },
        async deleteItem(itemType) {
            let vm = this;
            await showRemoveLineConfirmationDialog(this.checkedItem[itemType].length).then(result => {
                if (result) {
                    let removeId = []
                    let keyName = ''
                    for (var i in this.checkedItem[itemType]) {
                        if (itemType == 'lines') {
                            keyName = 'simu_formula_line_id'
                        }
                        if (itemType == 'mixs') {
                            keyName = 'mix_id'
                        }
                        if (itemType == 'instructions') {
                            keyName = 'instruction_id'
                        }
                        removeId.push(this[itemType][this.checkedItem[itemType][i]][keyName])
                    }
                    // sort value before remove item from array
                    this.checkedItem[itemType].sort(function (a, b) {
                        return b - a
                    })
                    if (removeId.length > 0) {
                        vm.pageLoading = true;
                        axios.delete('/api/pd/0001', {
                            params: {
                                data_type: itemType,
                                id: removeId,
                            }
                        }).then(response => {
                            if (response.status == 200) {
                                showSaveSuccessDialog()
                                console.log(response)
                            }
                            if (response.data.error_message) {
                                showGenericFailureDialog([response.data.error_message])
                            } else {
                                // loop for remove checked from array
                                for (var i in vm.checkedItem[itemType]) {
                                    vm[itemType].splice(vm.checkedItem[itemType][i], 1)
                                }

                                // clear checked
                                this.checkedItem[itemType] = []
                                if (this.isCheckedAll[itemType]) {
                                    this.isCheckedAll[itemType] = !this.isCheckedAll[itemType]
                                }

                            }
                            vm.pageLoading = false;
                        }).catch(error => {
                            vm.pageLoading = false;
                            swal.close()
                            console.log(error)
                        })
                    }

                }
            })
        },
        onChangeRawMaterialNum(index) {
            let itemCode = this.lines[index].raw_material_num
            let raw_material = this.raw_materials_data.filter(raw_material => raw_material.item_code === itemCode)[0]

            if(raw_material == 'undefined' || raw_material == null){
                this.lines[index].raw_material_id = null;
                this.lines[index].description = null
                this.lines[index].status = null
                this.lines[index].price_per_unit = null
                this.lines[index].uom = null
                this.lines[index].uom_display = null
                this.lines[index].actual_uom = null
                this.lines[index].actual_qty = null;
                this.lines[index].actual_cost = 0;

            }else{    
                this.lines[index].raw_material_id = raw_material.inventory_item_id
                this.lines[index].description = raw_material.description
                this.lines[index].status = raw_material.status
                this.lines[index].price_per_unit = raw_material.price_per_unit
                this.lines[index].uom = raw_material.uom
                this.lines[index].uom_display = raw_material.uom_display
                this.lines[index].actual_uom = raw_material.uom
                this.onChgUom(index)

                preventUnload()
                this.hasDataChange = true


                // this.onChgUom(index)

                // preventUnload()
                // this.hasDataChange = true
            }

        },
        async onClickCreate() {
            if (this.hasDataChange && !await showSimpleConfirmationDialog('มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก ต้องการออกจากหน้านี้?')) return
            cancelPreventUnload()
            this.hasDataChange = false

            this.created_by = ''
            this.last_updated_by = ''
            this.header = {
                simu_formula_id: '',
                simu_formula_no: '',
                description: '',
                remark_formula: '',
                creation_date: new Date(),
                created_by: '',
                last_update_date: '',
                last_updated_by: '',
            },
            this.lines = []
            this.mixs = []
            this.instructions = []
            this.isCheckedAll = {
                lines: false,
                mixs: false,
                instructions: false,
            },
                this.checkedItem = {
                    lines: [],
                    mixs: [],
                    instructions: [],
                },
                this.totalActualCost = 0
        },
        validate() {
            let errors = []
            if (!this.header.simu_formula_no) {
                errors.push('สารปรุง Casing No.')
            } else {
                let headers = this.headers_copy.filter(header => header.simu_formula_no.toUpperCase() === this.header.simu_formula_no.toUpperCase())
                if (this.header.simu_formula_id == '' && headers.length > 0) {
                    errors.push('ไม่สามารถบันทึกข้อมูลได้ เนื่องจากชื่อสารปรุง Casing No. ซ้ำ')
                }
            }

            if (this.lines.length > 0) {
                this.lines.forEach(line => {
                    let itemNumber = "";
                    // if(line.raw_material_num){
                    //     itemNumber =  ' (' + line.raw_material_num + ')';
                    // }
                    // console.log(line);
                    if(!line.raw_material_num){
                        errors.push('รหัสวัตถุดิบ');
                    }
                    if (!line.actual_qty) {
                        errors.push('ปริมาณที่ใช้')
                    }
                    if (!line.actual_uom) {
                        errors.push('หน่วย')
                    }


                })
            }

            if (this.mixs.length > 0) {
                this.mixs.forEach(mix => {
                    if (!mix.mix_desc || mix.mix_desc.trim().length == 0) {
                        errors.push('วิธีผสม')
                    }
                })
            }

            if (this.instructions.length > 0) {
                this.instructions.forEach(instruction => {
                    if (!instruction.instruction_desc || instruction.instruction_desc.trim().length == 0) {
                        errors.push('วิธีใช้')
                    }
                })
            }

            // if (this.lines.length > 0) {
            //     this.lines.forEach(line => {
            //         if (!line.actual_qty) {
            //             errors.push('ปริมาณที่ใช้')
            //         }
            //         if (!line.actual_uom) {
            //             errors.push('หน่วย')
            //         }
            //     })
            // }

            // if (this.mixs.length > 0) {
            //     this.mixs.forEach(mix => {
            //         console.log(mix.mix_desc);
            //         console.log(mix.mix_desc.length);
            //         // console.log(mix.mix_desc.trim().length);
            //         // mix.mix_desc.onkeyup = function(e){
            //         //     console.log(e.keyCode);
            //         //     // if(e.keyCode == 32){
            //         //     //     //your code
            //         //     // }
            //         // }
            //         console.log('วิธีผสม');
            //         if (mix.mix_desc.trim().length > 0) {
            //             errors.push('วิธีผสม')
            //         }
            //     })
            // }

            // if (this.instructions.length > 0) {
            //     this.instructions.forEach(instruction => {
            //         if (!instruction.instruction_desc) {
            //             errors.push('วิธีใช้')
            //         }
            //     })
            // }

            if (errors.length > 0) {
                showValidationFailedDialog(errors)
                return false
            }
            return true
        },
        onClickSave() {
            if (!this.validate()) {
                return;
            }

            showLoadingDialog()
            let params = {
                user_id: this.user_id,
                header: this.header,
                lines: this.lines,
                mixs: this.mixs,
                instructions: this.instructions,
            }

            if (this.header.simu_formula_id) {
                // update existing data
                axios.put('/api/pd/0001/' + this.header.simu_formula_id, params).then(response => {
                    if (response.status == 200) {
                        if (response.data.error_message) {
                            showGenericFailureDialog([response.data.error_message])
                        } else {
                            showSaveSuccessDialog()
                            cancelPreventUnload()
                            this.setNewData(response.data)
                        }
                    }
                }).catch(error => {
                    // swal.close()
                    console.log(error)
                })
            } else {
                // create new data
                axios.post('/api/pd/0001', params).then(response => {
                    if (response.status == 200) {
                        if (response.data.error_message) {
                            showValidationFailedDialog([response.data.error_message])
                        } else {
                            showSaveSuccessDialog()
                            cancelPreventUnload()
                            this.setNewData(response.data)
                        }
                    }
                }).catch(error => {
                    swal.close()
                    console.log(error)
                })
            }
        },
        onClickCopy() {
            let errors = []
            if (!this.header.simu_formula_id) {
                errors.push('สารปรุง Casing No.')
            }
            if (!this.new_simu_formula_no) {
                errors.push('คุณยังไม่ได้ระบุสูตรใหม่')
            } else {
                let headers = this.headers_copy.filter(header => header.simu_formula_no === this.new_simu_formula_no)
                if (headers.length > 0) {
                    errors.push('ไม่สามารถบันทึกข้อมูลได้ เนื่องจากชื่อสารปรุง Casing No. ซ้ำ')
                }
            }

            if (errors.length > 0) {
                showValidationFailedDialog(errors)
                return false
            }

            showLoadingDialog()
            let params = {
                simu_formula_id: this.header.simu_formula_id,
                new_simu_formula_no: this.new_simu_formula_no,
                user_id: this.user_id,
            }
            axios.post('/api/pd/0001', params).then(response => {
                if (response.status == 200) {
                    showSaveSuccessDialog()
                    cancelPreventUnload()
                    this.new_simu_formula_no = ''
                    this.setNewData(response.data)
                    $('#copyModal').modal('hide')
                }
            }).catch(error => {
                console.log(error)
            })
        },
        closeCopyModal() {
            $('#copyModal').modal('hide')
        },
        setNewData(newData) {
            if (newData.headers) {
                this.headers = newData.headers
                this.headers_copy = newData.headers
            }
            this.created_by = newData.created_by
            this.last_updated_by = newData.last_updated_by
            this.header = newData.header
            this.header.creation_date = new Date(newData.header.creation_date)
            this.header.last_update_date = new Date(newData.header.last_update_date)
            this.lines = newData.lines
            this.mixs = newData.mixs
            this.instructions = newData.instructions
            this.histories = newData.histories
            this.historyDescriptions = newData.historyDescriptions

            this.hasDataChange = false
        },
        dataChanged(){
            this.hasDataChange = true
            preventUnload()
        },


        historyDescription(uField){

            if(this.historyDescriptions){
                return this.historyDescriptions[uField];
            }
            return "";
        },

        historyFieldDescription(uField){
            if(this.historyDescriptions){
                if (this.historyDescriptions["field_desc"][uField] == "Header") {
                    return  "สารปรุง";
                }
                return this.historyDescriptions["field_desc"][uField];
            }
            return "";
        },

        isInt(n){
            return Number(n) === n && n % 1 === 0;
        },

        disabledOption(itemCode, uItemCode){
            let disabled = false;     
            this.lines.forEach(line => {
                if(line.raw_material_num == itemCode & line.raw_material_num != uItemCode){
                    disabled  = true;
                }
            });  
            
            return disabled;
        },

        descCasing(number){

            const herder =  this.headers.find(d => d.simu_formula_no === number);
            if(herder){
                if(herder.description){
                    return herder.simu_formula_no+ ' : ' + herder.description
                } else {
                    return herder.simu_formula_no
                }
            }

        },

        report(){
            // console.log(this.userProfile);
            // window.location.href = ;
            let header = this.header;
            // /ir/reports/get-param?casing_no_from=101&casing_no_to=101&program_code=PDR0001&function_name=PDR0001&output=pdf
            window.open('/ir/reports/get-param?casing_no_from='
                        +header.simu_formula_no
                        +"&casing_no_to="
                        +header.simu_formula_no
                        +'&program_code=PDR0001'
                        +'&function_name=PDR0001'
                        +'&output=pdf',
                         '_blank');
        },
        
    },
    watch:{

    },
}
</script>

<style scoped>
.mx-datepicker {
    width: inherit !important;
}
.el-input__inner {
    text-align: right;
}
</style>
