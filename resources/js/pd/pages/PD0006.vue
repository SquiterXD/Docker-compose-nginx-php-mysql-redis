<!--suppress JSUnresolvedVariable, JSUndeclaredVariable -->
<template>
    <div>

        <!-- TODO Header -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-2 align-middle">
                                <h5>สูตรทดลองยาเส้นปรุง</h5>
                            </div>

                            <div class="col-sm-12 col-lg-10">
                                <div class="text-right">
                                    <button
                                        type="button"
                                        class="btn btn-w-m btn-success"
                                        @click.prevent="onDebugClicked">
                                        <i class="fa fa-plus"></i>
                                        สร้าง
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-w-m btn-default">
                                        <i class="fa fa-search"></i>
                                        ค้นหา
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-w-m btn-primary"
                                        @click.prevent="onSaveFormulaClicked">

                                        <i class="fa fa-save"></i>
                                        บันทึก
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-w-m btn-warning"
                                        data-toggle="modal"
                                        data-target="#updateButtonModalCenter">
                                        <i class="fa fa-edit"></i>
                                        แก้ไข
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-w-m btn-primary btn-interface"
                                        data-toggle="modal"
                                        data-target="#copyButtonModalCenter">
                                        คัดลอกสูตร
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-w-m btn-primary btn-interface"
                                        data-toggle="modal"
                                        data-target="#copySimulateButtonModalCenter">
                                        คัดลอกเป็นสูตรจำลอง
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-w-m btn-primary btn-interface"
                                        data-toggle="modal"
                                        data-target=".history-update-modal-lg">
                                        ประวัติแก้ไข
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">

                                <!--ยาเส้นปรุงทดลอง-->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label">
                                        ยาเส้นปรุงทดลอง<span style="color: red">*</span>
                                    </label>
                                    <div class="col-lg-9">
                                        <db-lookup
                                            id="lookup-trial-blend-tobacco"
                                            :remote-data-source="lookupMfgFormulae"
                                            key-field="raw_material_id"
                                            :label-fields="['blend_no']"
                                            label-pattern="{$}"
                                            valueField="blend_no"
                                            v-model="headerModel.blend_num"
                                            :pre-populate-text="headerModel.blend_num"
                                            :pre-fetch="true"
                                            :max-results="20"/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label
                                        class="col-lg-3 col-sm-4 col-form-label">
                                        รสชาติ<span style="color: red">*</span>
                                    </label>
                                    <div class="col-lg-9">
                                        <div class="row">

                                            <!--รสชาติ-->
                                            <div class="col-lg-5">
                                                <el-select
                                                    id="select-flavour"
                                                    filterable
                                                    clearable
                                                    placeholder="เลือกรสชาติ"
                                                    :value="headerModel.taste"
                                                    @change="(value)=>{
                                                        headerModel.taste_info = value;
                                                        headerModel.taste = value.meaning;
                                                    }">

                                                    <el-option
                                                        v-for="flavour in lookup_tastes"
                                                        :key="flavour.meaning"
                                                        :label="flavour.meaning"
                                                        :value="flavour">
                                                    </el-option>
                                                </el-select>
                                            </div>

                                            <!--ปริมาณ-->
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-form-label"
                                                        for="input-blend-qty">
                                                        ปริมาณ<span style="color: red">*</span>
                                                    </label>

                                                    <div class="col-lg-8">
                                                        <!--suppress JSUndeclaredVariable -->
                                                        <input
                                                            id="input-blend-qty"
                                                            class="form-control"
                                                            type="number"
                                                            min="0"
                                                            v-model="headerModel.blend_qty"
                                                            @keyup="(event) => {
                                                                if (parseInt(event.target.value) < 0) {
                                                                    headerModel.blend_qty = 0;
                                                                }
                                                            }"
                                                        />
                                                    </div>
                                                    <!--TODO header qty-->
                                                </div>
                                            </div>

                                            <!--หน่วย-->
                                            <div class="col-lg-3">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-form-label"
                                                        for="input-blend-uom">
                                                        หน่วย<span style="color: red">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <input id="input-blend-uom"
                                                               class="form-control"
                                                               type="text"
                                                               disabled="disabled"
                                                               v-model="headerModel.blend_uom">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-lg-3 col-sm-4 col-form-label"
                                        for="input-description">
                                        รายละเอียด
                                    </label>
                                    <div class="col-lg-9">
                                        <input
                                            id="input-description"
                                            class="form-control"
                                            type="text"
                                            v-model="headerModel.description">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-lg-3 col-sm-4 col-form-label"
                                        for="input-remark">
                                        หมายเหตุ
                                    </label>
                                    <div class="col-lg-9">
                                        <input
                                            id="input-remark"
                                            class="form-control"
                                            type="text"
                                            v-model="headerModel.remark">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label"
                                           for="input-creation-date">
                                        วันที่สร้าง
                                    </label>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input
                                                    v-if="!lodash.isNil(headerModel.created_at)"
                                                    id="input-creation-date"
                                                    class="form-control"
                                                    type="date"
                                                    disabled="disabled"
                                                    :value="luxon.DateTime.fromSQL(headerModel.created_at).toISODate()"/>

                                                <!--suppress HtmlFormInputWithoutLabel -->
                                                <input
                                                    v-else
                                                    class="form-control"
                                                    type="text"
                                                    disabled="disabled">

                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group row">
                                                    <label class="col-form-label"
                                                           for="input-last-update-date">
                                                        วันที่แก้ไขล่าสุด
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <input
                                                            v-if="!lodash.isNil(headerModel.updated_at)"
                                                            id="input-last-update-date"
                                                            class="form-control"
                                                            type="date"
                                                            disabled="disabled"
                                                            :value="luxon.DateTime.fromSQL(headerModel.updated_at).toISODate()"/>

                                                        <!--suppress HtmlFormInputWithoutLabel -->
                                                        <input
                                                            v-else
                                                            class="form-control"
                                                            type="text"
                                                            disabled="disabled">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-lg-3 col-sm-4 col-form-label">
                                        สถานะ
                                    </label>

                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <el-select
                                                    id="select-status"
                                                    v-model="headerModel.status">

                                                    <el-option
                                                        v-for="status in lookup_statuses"
                                                        :key="status.code"
                                                        :label="status.description"
                                                        :value="status.code">
                                                    </el-option>
                                                </el-select>
                                            </div>

                                            <div class="col-lg-5">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-form-label"
                                                        for="input-created-by">
                                                        ผู้บันทึก
                                                    </label>
                                                    <div class="col-lg-9">
                                                        <input
                                                            id="input-created-by"
                                                            class="form-control"
                                                            type="text"
                                                            disabled="disabled"
                                                            :value="lodash.get(headerModel, 'updated_by_user.name', '')">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-lg-3 col-sm-4 col-form-label"
                                        for="input-approved-date">
                                        วันที่อนุมัติ
                                    </label>
                                    <div class="col-lg-9">
                                        <input
                                            v-if="lodash.isEqual(headerModel.status, 'Y')"
                                            id="input-approved-date"
                                            class="form-control"
                                            type="date"
                                            :disabled="lodash.isEqual(headerModel.status, 'N')"
                                            :value="luxon.DateTime.fromSQL(headerModel.approved_date).toISODate()"
                                            @change="value => headerModel.approved_date = value">

                                        <!--suppress HtmlFormInputWithoutLabel -->
                                        <input
                                            v-else
                                            class="form-control"
                                            type="text"
                                            disabled="disabled">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-lg-3 col-sm-4 col-form-label"
                                        for="input-start-date">
                                        วันที่เริ่มใช้
                                    </label>
                                    <div class="col-lg-9">
                                        <input
                                            v-if="lodash.isEqual(headerModel.status, 'Y')"
                                            id="input-start-date"
                                            class="form-control"
                                            type="date"
                                            :disabled="lodash.isEqual(headerModel.status, 'N')"
                                            :value="luxon.DateTime.fromSQL(headerModel.start_date).toISODate()"
                                            @change="value => headerModel.start_date = value">

                                        <!--suppress HtmlFormInputWithoutLabel -->
                                        <input
                                            v-else
                                            class="form-control"
                                            type="text"
                                            disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- TODO End Header -->

        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="tabs-container tab-custom">

                            <!-- Tabs -->
                            <ul class="nav nav-tabs">
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Leaf Formula</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2">Casing</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-3">Flavour</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-4">บุหรี่ทดลอง</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-5">ทั้งหมด</a></li>
                            </ul>
                            <!-- End Tabs -->

                            <div class="tab-content in-tab-custom">

                                <!-- TODO Tab: Leaf Formula -->
                                <div id="tab-1" class="tab-pane active">

                                    <div class="panel-body">
                                        <!-- TODO Leaf Formula: Lines -->
                                        <div class="col-sm-12 col-lg-12 pr-0 mb-3">
                                            <div class="text-right">
                                                <div class="text-right">
                                                    <button
                                                        type="button"
                                                        class="btn btn-w-m btn-success"
                                                        @click.prevent="onLeafFormulaAddLineClicked">
                                                        <i class="fa fa-plus"></i>
                                                        เพิ่มรายการ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>เลือก</th>
                                                    <th>Leaf Formula</th>
                                                    <th>รายละเอียด</th>
                                                    <th>สัดส่วน %</th>
                                                    <th>ลบ</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <tr
                                                    v-for="(leafFormulaModel) in leafFormulaeModel"
                                                    v-bind:key="lodash.get(leafFormulaModel, 'extra.uniqueId')">

                                                    <td>
                                                        <!--suppress HtmlFormInputWithoutLabel, JSUndeclaredVariable -->
                                                        <input
                                                            type="radio"
                                                            name="radio-selected-leaf-formula"
                                                            @change="()=>{
                                                                selectedLeafFormula = leafFormulaModel;
                                                            }"/>
                                                    </td>

                                                    <td>
                                                        <el-select
                                                            filterable
                                                            clearable
                                                            placeholder="เลือกสูตรใบยา"
                                                            :value="leafFormulaModel.tab_num"
                                                            @change="(value)=>{
                                                                leafFormulaModel.tab_num = value.lookup_code;
                                                                leafFormulaModel.tab_desc = value.description;
                                                            }">

                                                            <el-option
                                                                v-for="formula in lookup_leaf_formulae"
                                                                :key="formula.lookup_code"
                                                                :label="formula.lookup_code + ': ' + formula.description"
                                                                :value="formula">
                                                            </el-option>
                                                        </el-select>
                                                    </td>

                                                    <td>
                                                        <!--suppress HtmlFormInputWithoutLabel -->
                                                        <input
                                                            class="form-control"
                                                            type="text"
                                                            disabled="disabled"
                                                            v-model="leafFormulaModel.tab_desc">
                                                    </td>

                                                    <td>
                                                        <!--suppress HtmlFormInputWithoutLabel -->
                                                        <input
                                                            class="form-control"
                                                            type="number"
                                                            min="0"
                                                            v-model.number="leafFormulaModel.ratio"
                                                            @keyup="(event) => {
                                                                if (parseInt(event.target.value) < 0) {
                                                                    leafFormulaModel.ratio = 0;
                                                                }
                                                            }"/>
                                                    </td>

                                                    <td>
                                                        <button
                                                            type="button"
                                                            class="btn btn-w-m btn-danger"
                                                            @click.prevent="onLeafFormulaDeleteLineClicked(leafFormulaModel)">

                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td/>
                                                    <td
                                                        colspan="2"
                                                        style="text-align: right">
                                                        <b>รวม</b>
                                                    </td>
                                                    <td>
                                                        {{ leafFormulaePercentageAggregation }}
                                                    </td>
                                                    <td/>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- End Leaf Formula: Lines -->

                                        <!-- Leaf Formula: Details -->
                                        <div v-if="!lodash.isEmpty(selectedLeafFormula)">
                                            <div class="row align-items-center mt-4">
                                                <div class="col-sm-12 col-lg-6 align-middle">
                                                    <div class="form-group row">
                                                        <label
                                                            class="col-lg-3 col-sm-4 col-form-label"
                                                            for="input-selected-leaf-formula">
                                                            Leaf Formula
                                                        </label>

                                                        <div class="col-lg-4">
                                                            <input
                                                                id="input-selected-leaf-formula"
                                                                class="form-control"
                                                                type="text"
                                                                :value="lodash.get(selectedLeafFormula, 'tab_desc', '')"
                                                                disabled/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-lg-6 mb-4">
                                                    <div class="text-right">
                                                        <button
                                                            type="button"
                                                            class="btn btn-w-m btn-success"
                                                            @click.prevent="onLeafFormulaDetailAddClicked">

                                                            <i class="fa fa-plus"></i>&nbsp;เพิ่มรายการ
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="btn btn-w-m btn-danger"
                                                            :disabled="!isLeafFormulaDetailSelected"
                                                            @click.prevent="onLeafFormulaDetailDeleteClicked">

                                                            <i class="fa fa-times"></i>&nbsp;ลบรายการ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>เลือก</th>
                                                        <th>รหัสวัตถุดิบ</th>
                                                        <th>เกรดใบยา</th>
                                                        <th>Lot</th>
                                                        <th>สัดส่วน %</th>
                                                        <th>ปริมาณที่ใช้ (กก.)</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody v-if="!lodash.isNil(selectedLeafFormula)">
                                                    <tr
                                                        v-for="detail in selectedLeafFormula.details"
                                                        v-bind:key="lodash.get(detail, 'extra.uniqueId')">

                                                        <!--เลือก-->
                                                        <td>
                                                            <div class="text-center">
                                                                <label>
                                                                    <input
                                                                        type="checkbox"
                                                                        v-model="detail.extra.isSelected"/>
                                                                </label>
                                                            </div>
                                                        </td>

                                                        <!--รหัสวัตถุดิบ-->
                                                        <td>
                                                            <label class="col-lg-12">
                                                                <db-lookup
                                                                    :remote-data-source="lookupItemNumbers"
                                                                    key-field="inventory_item_id"
                                                                    :label-fields="['item_number']"
                                                                    label-pattern="{$}"
                                                                    :selected-label-fields="['item_number']"
                                                                    selected-label-pattern="{$}"
                                                                    :pre-populate-text="detail.item_number"
                                                                    :pre-fetch="false"
                                                                    :max-results="20"
                                                                    :disabled="lodash.isEmpty(headerModel.taste_info)"
                                                                    @change="(value) => {
                                                                        detail.inventory_item_id = value.inventory_item_id;
                                                                        detail.lot_number = '';
                                                                        detail.item_number = value.item_number;
                                                                        detail.item_desc = value.item_desc;
                                                                        detail.lots = value.lots;

                                                                        detail = {...detail};
                                                                    }"
                                                                />
                                                            </label>
                                                        </td>

                                                        <!--เกรดใบยา-->
                                                        <td>{{ detail.item_desc }}</td>

                                                        <!--Lot-->
                                                        <td>
                                                            <el-select
                                                                filterable
                                                                clearable
                                                                placeholder="Lot"
                                                                :value="detail.lot_number"
                                                                @change="(value)=>{
                                                                    detail.lot_number = value.lot_number;
                                                                }">

                                                                <el-option
                                                                    v-for="lot in detail.lots"
                                                                    :key="lot.lot_number"
                                                                    :label="lot.lot_number"
                                                                    :value="lot">
                                                                </el-option>
                                                            </el-select>
                                                        </td>

                                                        <!--สัดส่วน %-->
                                                        <td>
                                                            <!--suppress HtmlFormInputWithoutLabel -->
                                                            <input
                                                                class="form-control"
                                                                type="number"
                                                                min="0"
                                                                v-model.number="detail.item_ratio"
                                                                @keyup="(event) => {
                                                                if (parseInt(event.target.value) < 0) {
                                                                    detail.item_ratio = 0;
                                                                }
                                                            }"
                                                            />
                                                        </td>

                                                        <!--ปริมาณที่ใช้ (กก.)-->
                                                        <td>
                                                            {{
                                                                leafFormulaDetailUsageAmount(selectedLeafFormula, detail)
                                                            }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="4">
                                                            <span
                                                                style="color: red; float: left"
                                                                v-if="!lodash.isEmpty(selectedLeafFormula) && lodash.isEmpty(headerModel.taste_info)">
                                                                <b>* กรุณาเลือกรสชาติเพื่อแก้ไขรหัสวัตถุดิบ</b>
                                                            </span>

                                                            <span
                                                                style="float: right">
                                                                <b>รวม</b>
                                                            </span>
                                                        </td>

                                                        <!--รวม %-->
                                                        <td>
                                                            {{ leafFormulaDetailPercentAggregation }}
                                                        </td>

                                                        <!--รวม Quantity-->
                                                        <td>
                                                            {{ leafFormulaDetailQuantityAggregation }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- End Leaf Formula Details -->
                                    </div>
                                </div>
                                <!-- End Tab: Leaf Formula -->

                                <!-- TODO Tab: Casing -->
                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row align-items-center mt-4">

                                            <!-- Casing: Control Buttons -->
                                            <div class="col-sm-12 col-lg-12 mb-2">
                                                <div class="text-right">
                                                    <button
                                                        type="button"
                                                        class="btn btn-w-m btn-success"
                                                        @click.prevent="onCasingAddLineClicked">
                                                        <i class="fa fa-plus"></i>&nbsp;เพิ่มรายการ
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="btn btn-w-m btn-danger"
                                                        :disabled="!isCasingSelected"
                                                        @click.prevent="onCasingDeleteLineClicked">
                                                        <i class="fa fa-times"></i>&nbsp;ลบรายการ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Casing: Lines -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>เลือก</th>
                                                    <th>Leaf Formula</th>
                                                    <th>รายละเอียด</th>
                                                    <th>Casing No.</th>
                                                    <th>รายละเอียด</th>
                                                    <th>รายละเอียดเพิ่มเติม</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr
                                                    v-for="casing in casingsModel"
                                                    v-bind:key="lodash.get(casing, 'extra.uniqueId')">

                                                    <td>
                                                        <div class="abc-checkbox text-center">
                                                            <!--suppress HtmlFormInputWithoutLabel -->
                                                            <input
                                                                type="checkbox"
                                                                v-model="casing.extra.isSelected"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!--Casing: Leaf Formula-->
                                                        <label class="col-lg">
                                                            <el-select
                                                                id="select-casing-leaf-formula"
                                                                filterable
                                                                clearable
                                                                :value="casing.leaf_formula_num"
                                                                @change="(value)=>{
                                                                    casing.leaf_formula_num = value.tab_num;
                                                                    casing.leaf_formula_desc = value.tab_desc;

                                                                   casingsModel = [...casingsModel];
                                                                }">

                                                                <el-option
                                                                    v-for="leafFormula in leafFormulaeModel"
                                                                    :key="leafFormula.blend_line_id"
                                                                    :label="leafFormula.tab_num + ': ' + leafFormula.tab_desc"
                                                                    :value="leafFormula">
                                                                </el-option>
                                                            </el-select>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        {{ casing.leaf_formula_desc }}
                                                    </td>

                                                    <td>
                                                        <label class="col-lg-6">
                                                            <db-lookup
                                                                :remote-data-source="lookupCasing"
                                                                key-field="simu_formula_id"
                                                                :label-fields="['simu_formula_no', 'description']"
                                                                label-pattern="{$}: {$}"
                                                                :selected-label-fields="['simu_formula_no']"
                                                                selected-label-pattern="{$}"
                                                                :pre-populate-text="casing.tab_num"
                                                                :pre-fetch="false"
                                                                :max-results="20"
                                                                @change="(value)=>{
                                                                    casing.tab_id = value.simu_formula_id;
                                                                    casing.tab_num = value.simu_formula_no;
                                                                    casing.tab_desc = value.description;

                                                                    casingsModel = [...casingsModel];
                                                                }"/>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        {{ casing.tab_desc }}
                                                    </td>

                                                    <td>
                                                        <button
                                                            type="button"
                                                            class="btn btn-w-m btn-default"
                                                            data-toggle="modal"
                                                            data-target="#modal-raw-materials"
                                                            @click.prevent="onShowCasingRawMaterialsClicked(casing)">

                                                            <i class="fa fa-file-text-o"></i>&nbsp;รายละเอียด
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- End table -->
                                    </div>
                                </div>
                                <!-- End Tab: Casing -->

                                <!-- TODO Tab: Flavour -->
                                <div id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row align-items-center mt-4">
                                            <div class="col-sm-12 col-lg-12 mb-2">

                                                <!-- Flavour: Control Buttons -->
                                                <div class="col-sm-12 col-lg-12 mb-2">
                                                    <div class="text-right">
                                                        <button
                                                            type="button"
                                                            class="btn btn-w-m btn-success"
                                                            @click.prevent="onFlavourAddLineClicked">
                                                            <i class="fa fa-plus"></i>&nbsp;เพิ่มรายการ
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="btn btn-w-m btn-danger"
                                                            :disabled="!isFlavourSelected"
                                                            @click.prevent="onFlavourDeleteLineClicked">
                                                            <i class="fa fa-times"></i>&nbsp;ลบรายการ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>เลือก</th>
                                                        <th>Flavour No.</th>
                                                        <th>รายละเอียด</th>
                                                        <th>รายละเอียดเพิ่มเติม</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr
                                                        v-for="flavour in flavoursModel"
                                                        v-bind:key="lodash.get(flavour, 'extra.uniqueId')">

                                                        <td>
                                                            <div class="text-center">
                                                                <!--suppress HtmlFormInputWithoutLabel -->
                                                                <input
                                                                    type="checkbox"
                                                                    v-model="flavour.extra.isSelected"/>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <db-lookup
                                                                :remote-data-source="lookupFlavour"
                                                                key-field="simu_formula_id"
                                                                :label-fields="['simu_formula_no', 'description']"
                                                                label-pattern="{$}: {$}"
                                                                :selected-label-fields="['simu_formula_no']"
                                                                selected-label-pattern="{$}"
                                                                :pre-populate-text="flavour.tab_num"
                                                                :pre-fetch="false"
                                                                :max-results="20"
                                                                @change="(value)=>{
                                                                    flavour.tab_id = value.simu_formula_id;
                                                                    flavour.tab_num = value.simu_formula_no;
                                                                    flavour.tab_desc = value.description;

                                                                    flavoursModel = [...flavoursModel];
                                                                }"/>
                                                        </td>

                                                        <td>
                                                            {{ flavour.tab_desc }}
                                                        </td>

                                                        <td>
                                                            <button
                                                                type="button"
                                                                class="btn btn-w-m btn-default"
                                                                data-toggle="modal"
                                                                data-target="#modal-raw-materials"
                                                                @click.prevent="onShowFlavourRawMaterialsClicked(flavour)">

                                                                <i class="fa fa-file-text-o"></i>&nbsp;รายละเอียด
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Tab Flavour -->

                                <!-- TODO Tab: Example Cigarettes -->
                                <div id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">

                                            <!-- Table: Example Cigarette -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>รหัสบุหรี่</th>
                                                        <th>รายละเอียด</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <db-lookup
                                                                :remote-data-source="lookupExampleCigarette"
                                                                key-field="inventory_item_id"
                                                                :label-fields="['item_code', 'description']"
                                                                label-pattern="{$}: {$}"
                                                                :selected-label-fields="['item_code']"
                                                                selected-label-pattern="{$}"
                                                                :pre-populate-text="exampleCigaretteModel.tab_num"
                                                                :pre-fetch="false"
                                                                :max-results="20"
                                                                :value="exampleCigaretteModel.tab_num"
                                                                @change="(value)=>{
                                                                    exampleCigaretteModel.tab_num = value.item_code;
                                                                    exampleCigaretteModel.tab_desc = value.description;

                                                                    exampleCigaretteModel = {...exampleCigaretteModel}
                                                                }"/>
                                                        </td>

                                                        <td>
                                                            {{ exampleCigaretteModel.tab_desc }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- End Table: Example Cigarette -->

                                            <div class="row align-items-center mt-4">
                                                <div class="col-sm-12 col-lg-12 mb-2">
                                                    <div class="text-right">
                                                        <button
                                                            type="button"
                                                            class="btn btn-w-m btn-success"
                                                            @click.prevent="onExampleCigaretteAddLineClicked">

                                                            <i class="fa fa-plus"></i>&nbsp;เพิ่มรายการ
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="btn btn-w-m btn-danger"
                                                            :disabled="!isExampleCigaretteSelected"
                                                            @click.prevent="onExampleCigaretteDeleteLineClicked">

                                                            <i class="fa fa-times"></i>&nbsp;ลบรายการ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Table: Example Cigarette Wrap  -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>เลือก</th>
                                                        <th>ลำดับ</th>
                                                        <th>รายละเอียดวัตถุห่อมวน</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <!-- TODO -->
                                                    <tr
                                                        v-for="wrap in exampleCigaretteModel.wraps"
                                                        v-bind:key="lodash.get(wrap, 'extra.uniqueId')">

                                                        <td>
                                                            <div class="text-center">
                                                                <!--suppress HtmlFormInputWithoutLabel -->
                                                                <input
                                                                    type="checkbox"
                                                                    v-model="wrap.extra.isSelected"/>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <!--suppress HtmlFormInputWithoutLabel -->
                                                            <input
                                                                class="form-control"
                                                                type="text"
                                                                disabled="disabled"
                                                                v-model="wrap.wrap_no">
                                                        </td>

                                                        <td>
                                                            <!--suppress HtmlFormInputWithoutLabel -->
                                                            <input
                                                                class="form-control"
                                                                type="text"
                                                                v-model="wrap.description">
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- End Table: Example Cigarette Wrap  -->
                                        </div>
                                    </div>
                                </div>
                                <!-- End Tab: Example Cigarettes -->

                                <!-- TODO Tab: Summaries -->
                                <div id="tab-5" class="tab-pane">
                                    <div class="panel-body">
                                        <!-- table -->
                                        <div class="table-responsive">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>รหัสวัตถุดิบ</th>
                                                        <th>รายละเอียด</th>
                                                        <th>Lot</th>
                                                        <th>ปริมาณที่ใช้</th>
                                                        <th>หน่วย</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="summary in formulaSummaries">
                                                        <td>
                                                            {{ summary.rawMaterialId }}
                                                        </td>

                                                        <td>
                                                            {{ summary.description }}
                                                        </td>

                                                        <td>
                                                            {{ summary.lot }}
                                                        </td>

                                                        <td>
                                                            {{ summary.quantity }}
                                                        </td>

                                                        <td>
                                                            {{ summary.uom }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- End table -->
                                        </div>
                                        <!-- End table -->
                                    </div>
                                </div>
                                <!-- End Tab: Summaries -->
                            </div>
                        </div>

                        <!-- Modal: Raw Materials -->
                        <div class="modal fade modal-raw-materials"
                             id="modal-raw-materials"
                             ref="ref-modal-raw-materials"
                             role="dialog"
                             aria-hidden="true">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5
                                            class="modal-title">
                                            {{ lodash.get(rawMaterialsDialogModel, 'meta.title', '') }}
                                        </h5>

                                        <div class="col-lg-3">
                                            <!--suppress HtmlFormInputWithoutLabel -->
                                            <input
                                                id="input-casing-dialog-no"
                                                type="text"
                                                class="form-control"
                                                :value="lodash.get(rawMaterialsDialogModel, 'meta.tabNum', '')"
                                                disabled>
                                        </div>

                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>

                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-bordered">

                                                        <thead>
                                                        <tr>
                                                            <th>รหัสวัตถุดิบ</th>
                                                            <th>รายละเอียด</th>
                                                            <th>ปริมาณที่ใช้</th>
                                                            <th>หน่วย</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <tr v-for="rawMaterial in rawMaterialsDialogModel.items">

                                                            <td>{{ rawMaterial.raw_material_no }}</td>
                                                            <td>{{ rawMaterial.description }}</td>
                                                            <td>{{ rawMaterial.quantity }}</td>
                                                            <td>{{ rawMaterial.uom }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal btn copy -->
                        <div class="modal fade" id="copyButtonModalCenter" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="copyModalLongTitle">คัดลอกสูตร</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-lg-12 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-sm-8 col-form-label" for="input17">
                                                    จากสูตร Blend No.</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="input17" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="select3">
                                                    เป็นสูตร</label>
                                                <div class="col-lg-10">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control" name="select3"
                                                                    id="select3">
                                                                <option>สูตรมาตรฐาน</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group row">
                                                                <label class="col-form-label"
                                                                       for="input18">
                                                                    Blend No.</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" class="form-control"
                                                                           id="input18">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-w-m btn-primary" data-dismiss="modal"><i
                                            class="fa fa-check-circle-o"></i> ตกลง
                                        </button>
                                        <button type="button" class="btn btn-w-m btn-danger"><i class="fa fa-times"></i>
                                            ยกเลิก
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal btn copySimulate  -->
                        <div class="modal fade" id="copySimulateButtonModalCenter" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="copySimulateModalLongTitle">
                                            คัดลอกสูตรเป็นสูตรจำลอง</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-lg-12 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-sm-8 col-form-label" for="input19">
                                                    จากสูตร Blend No.</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="input19" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-sm-4 col-form-label" for="input20">
                                                    เป็นสูตร Blend No.</label>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" id="input20">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group row">
                                                                <label class="col-form-label"
                                                                       for="input21">
                                                                    ตัวอย่างครั้งที่</label>
                                                                <div class="col-lg-6">
                                                                    <input type="text" class="form-control" id="input21"
                                                                           disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-w-m btn-primary" data-dismiss="modal"><i
                                            class="fa fa-check-circle-o"></i> ตกลง
                                        </button>
                                        <button type="button" class="btn btn-w-m btn-danger"><i class="fa fa-times"></i>
                                            ยกเลิก
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal btn history update  -->
                        <div class="modal fade history-update-modal-lg" tabindex="-1" role="dialog"
                             aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="history-update-modal-lg">ประวัติการแก้ไข Blend
                                            No.</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-lg-12 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-sm-8 col-form-label" for="input22">
                                                    ประวัติการแก้ไข Blend No.</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="input22" disabled>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>ครั้งที่</th>
                                                        <th>ผู้แก้ไข</th>
                                                        <th>วันที่แก้ไข</th>
                                                        <th>Tap</th>
                                                        <th>Field ที่แก้ไข</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>ข้อมูลเดิม</th>
                                                        <th>ข้อมูลที่แก้ไข</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>MCR</td>
                                                        <td>20/6/63</td>
                                                        <td>Casing</td>
                                                        <td>Leaf Formula</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>A</td>
                                                        <td>C</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal btn update  -->
                        <div class="modal fade" id="updateButtonModalCenter" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="updateButton">แก้ไข</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h1 style="text-align: center">เนื่องจากสูตรมีสถานะ Active <br/>
                                            ยืนยันที่จะแก้ไขสูตร</h1>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-w-m btn-primary" data-dismiss="modal"><i
                                            class="fa fa-check-circle-o"></i> ตกลง
                                        </button>
                                        <button type="button" class="btn btn-w-m btn-danger"><i class="fa fa-times"></i>
                                            ยกเลิก
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <pre class="col-lg-4" style="display: block">{{
                    JSON.stringify({
                        headerModel,
                        lookup_leaf_formulae,
                        lookup_statuses,
                        lookup_tastes,

                    }, null, 2)
                }}
            </pre>

            <pre class="col-lg-4" style="display: block">{{
                    JSON.stringify({
                        rawMaterialsDialogModel,
                        rawMaterialsDic,
                        leafFormulaeModel,

                    }, null, 2)
                }}
            </pre>

            <pre class="col-lg-4" style="display: block">{{
                    JSON.stringify({
                        casingsModel,
                        flavoursModel,
                        exampleCigaretteModel,
                    }, null, 2)
                }}
            </pre>
        </div>
    </div>
</template>

<script>

import {instance as http} from "../../pm/httpClient";
import {
    showLoadingDialog,
    showRemoveLineConfirmationDialog,
    showSaveFailureDialog,
    showSaveSuccessDialog,
    showSimpleConfirmationDialog,
} from "../../commonDialogs"

import {
    $route,
    api_pd_createTrialTobaccoFormula_blendFormulae_update,
    api_pd_createTrialTobaccoFormula_lookupCasings_show,
    api_pd_createTrialTobaccoFormula_lookupExampleCigarettes_show,
    api_pd_createTrialTobaccoFormula_lookupFlavours_show,
    api_pd_createTrialTobaccoFormula_lookupItemNumbers_show,
    api_pd_createTrialTobaccoFormula_mfgFormulae_show,
} from "../../router";

import {DateTime} from 'luxon';
import _cloneDeep from "lodash/cloneDeep";
import _countBy from "lodash/countBy";
import _find from "lodash/find";
import _get from "lodash/get";
import _isEqual from "lodash/isEqual";
import _isEmpty from "lodash/isEmpty";
import _flatMap from "lodash/flatMap";
import _isNil from "lodash/isNil";
import _reduce from "lodash/reduce";
import _remove from "lodash/remove";

function updateBlendFormula(blendFormula) {
    console.debug('updateBlendFormula', blendFormula);

    let blendId = _get(blendFormula, 'header.blend_id', '');
    return http.put($route(api_pd_createTrialTobaccoFormula_blendFormulae_update,
        {
            blendId: blendId,
        }),
        {
            ...blendFormula,
        }
    );
}

function getMfgFormulae() {
    return http.get($route(api_pd_createTrialTobaccoFormula_mfgFormulae_show));
}

function getItemNumbers(query, flavourCode, maxResults = 30) {
    return http.get($route(api_pd_createTrialTobaccoFormula_lookupItemNumbers_show), {
        params: {
            'query': query,
            'flavourCode': flavourCode,
            'maxResults': maxResults,
        }
    });
}

function getCasings(query, maxResults = 30) {
    return http.get($route(api_pd_createTrialTobaccoFormula_lookupCasings_show), {
        params: {
            'query': query,
            'maxResults': maxResults,
        }
    });
}

function getFlavours(query, maxResults = 30) {
    return http.get($route(api_pd_createTrialTobaccoFormula_lookupFlavours_show), {
        params: {
            'query': query,
            'maxResults': maxResults,
        }
    });
}

function getExampleCigarettes(query, maxResults = 30) {
    return http.get($route(api_pd_createTrialTobaccoFormula_lookupExampleCigarettes_show), {
        params: {
            'query': query,
            'maxResults': maxResults,
        }
    });
}

let sequenceUniqueId = 0;

function mapLeafFormulaLine(leafFormula) {
    return {
        extra: {
            ..._get(leafFormula, 'extra', {}),
            uniqueId: sequenceUniqueId++,
        },
        ...leafFormula,
        details: [
            ..._get(leafFormula, 'details', []).map(mapLeafFormulaDetail),
        ],
    }
}

function mapLeafFormulaDetail(detail) {
    return {
        extra: {
            //default value should be overwrite by existing value
            isSelected: false,

            ..._get(detail, 'extra', {}),
            uniqueId: sequenceUniqueId++,
        },
        ...detail,
    }
}

function mapCasingLine(casing) {
    return {
        extra: {
            //default value should be overwrite by existing value
            isSelected: false,

            ..._get(casing, 'extra', {}),
            uniqueId: sequenceUniqueId++,
        },
        ...casing,
    }
}

function mapFlavourLine(flavour) {
    return {
        extra: {
            //default value should be overwrite by existing value
            isSelected: false,

            ..._get(flavour, 'extra', {}),
            uniqueId: sequenceUniqueId++,
        },
        ...flavour,
    }
}

function mapExampleCigarette(exampleCigarette) {
    let mappedExampleCigarette = {
        ...exampleCigarette,
        wraps: [
            ..._get(exampleCigarette, 'wraps', []).map(mapExampleCigaretteWrap),
        ],
    };

    mappedExampleCigarette.wraps = mappedExampleCigarette.wraps.map(mapExampleCigaretteWrapIndex);

    return mappedExampleCigarette;
}

function mapExampleCigaretteWrap(wrap) {
    return {
        extra: {
            //default value should be overwrite by existing value
            isSelected: false,

            ..._get(wrap, 'extra', {}),
            uniqueId: sequenceUniqueId++,
        },
        ...wrap,
    }
}

function mapExampleCigaretteWrapIndex(wrap, index) {
    return {
        ...wrap,
        wrap_no: index + 1,
    }
}

export default {
    created() {
        //TODO
    },
    mounted() {

    },
    data() {
        return {
            lodash: {
                cloneDeep: _cloneDeep,
                countBy: _countBy,
                find: _find,
                get: _get,
                isEqual: _isEqual,
                isEmpty: _isEmpty,
                flatMap: _flatMap,
                isNil: _isNil,
                reduce: _reduce,
                remove: _remove,
            },
            luxon: {
                DateTime: DateTime,
            },

            //header
            headerModel: _cloneDeep(this.header),

            //leaf formula
            leafFormulaeModel: _cloneDeep(this.leaf_formulae).map(mapLeafFormulaLine),
            selectedLeafFormula: {},

            //casing
            casingsModel: _cloneDeep(this.casings).map(mapCasingLine),

            //raw materials
            rawMaterialsDic: _cloneDeep(this.raw_materials),
            rawMaterialsDialogModel: {},

            //flavour
            flavoursModel: _cloneDeep(this.flavours).map(mapFlavourLine),

            //example cigarette
            exampleCigaretteModel: mapExampleCigarette(_cloneDeep(this.example_cigarette)),
        }
    },
    props: {
        header: {
            type: Object,
        },
        leaf_formulae: {
            type: Array,
        },
        casings: {
            type: Array,
        },
        flavours: {
            type: Array,
        },
        example_cigarette: {
            type: Object,
        },
        raw_materials: {
            type: Object,
        },

        // look up values
        lookup_leaf_formulae: {
            type: Array,
        },
        lookup_tastes: {
            type: Array,
        },
        lookup_statuses: {
            type: Array,
        },
    },
    methods: {
        onDebugClicked() {
            console.debug(
            );
        },
        onCreateFormulaClicked() {
            console.debug('onCreateFormulaClicked');
            //TODO
        },
        onSearchFormulaClicked() {
            console.debug('onSearchFormulaClicked');
            //TODO
        },
        onSaveFormulaClicked() {
            console.debug('onSaveFormulaClicked');
            // TODO
            // verify uniqueness of leaf formulae

            let blendFormula = {};
            blendFormula.header = this.headerModel;
            blendFormula.leaf_formulae = this.leafFormulaeModel;
            blendFormula.casings = this.casingsModel;
            blendFormula.flavours = this.flavoursModel;
            blendFormula.example_cigarette = this.exampleCigaretteModel;

            showLoadingDialog();
            updateBlendFormula(blendFormula)
                .then((result) => {
                    console.debug('updateBlendFormula success', result);

                    this.headerModel = _cloneDeep(result.data.header);
                    this.leafFormulaeModel = _cloneDeep(result.data.leaf_formulae).map(mapLeafFormulaLine);
                    this.casingsModel = _cloneDeep(result.data.casings).map(mapCasingLine);
                    this.flavoursModel = _cloneDeep(result.data.flavours).map(mapFlavourLine);
                    this.exampleCigaretteModel = mapExampleCigarette(_cloneDeep(result.data.example_cigarette));

                    return showSaveSuccessDialog();
                })
                .catch((err) => {
                    console.debug('updateBlendFormula error', err);
                    return showSaveFailureDialog();
                });
        },
        onEditFormulaClicked() {
            console.debug('onEditFormulaClicked');
            //TODO
        },
        onCopyFormulaClicked() {
            console.debug('onCopyFormulaClicked');
            //TODO
        },
        onCopyToSimulateFormulaClicked() {
            console.debug('onCopyToSimulateFormulaClicked');
            //TODO
        },
        onViewEditHistoryClicked() {
            console.debug('onViewEditHistoryClicked');
            //TODO
        },
        onLeafFormulaAddLineClicked() {
            console.debug('onLeafFormulaAddLineClicked');

            this.leafFormulaeModel = [
                ...this.leafFormulaeModel,
                mapLeafFormulaLine({}),
            ]
        },
        onLeafFormulaDeleteLineClicked(leafFormula) {
            console.debug('onLeafFormulaDeleteLineClicked');

            let confirmationText = `คุณต้องการลบ Leaf Formula ที่ถูกเลือกใช่หรือไม่`;
            showSimpleConfirmationDialog(confirmationText)
                .then((result) => {
                    console.debug('showSimpleConfirmationDialog success', result)
                    if (result) {

                        this.lodash.remove(this.leafFormulaeModel, (item) => {
                            console.debug('compare', item.extra.uniqueId, leafFormula.extra.uniqueId);

                            return item.extra.uniqueId === leafFormula.extra.uniqueId;
                        });

                        this.leafFormulaeModel = [...this.leafFormulaeModel];
                    }
                });
        },
        onLeafFormulaDetailAddClicked() {
            console.debug('onLeafFormulaDetailAddClicked');

            this.selectedLeafFormula.details = [
                ...this.selectedLeafFormula.details,
                mapLeafFormulaDetail({}),
            ]
        },
        onLeafFormulaDetailDeleteClicked() {
            console.debug('onLeafFormulaDetailDeleteClicked', this.selectedLeafFormula);

            let count = this.lodash.countBy(this.selectedLeafFormula.details,
                (value) => {
                    console.debug(this.lodash.get(value, 'extra.isSelected', false));
                    return this.lodash.get(value, 'extra.isSelected', false);
                }).true;

            showRemoveLineConfirmationDialog(count)
                .then((isConfirmed) => {
                    if (isConfirmed) {
                        this.lodash.remove(this.selectedLeafFormula.details, (item) => {
                            return this.lodash.get(item, 'extra.isSelected', false)
                        });

                        this.selectedLeafFormula.details = [...this.selectedLeafFormula.details]
                    }
                });
        },
        onCasingAddLineClicked() {
            console.debug('onCasingAddLineClicked');

            this.casingsModel = [
                ...this.casingsModel,
                mapCasingLine({}),
            ]
        },
        onCasingDeleteLineClicked() {
            console.debug('onCasingDeleteLineClicked');

            let count = this.lodash.countBy(this.casingsModel,
                (value) => {
                    console.debug(this.lodash.get(value, 'extra.isSelected', false));
                    return this.lodash.get(value, 'extra.isSelected', false);
                }).true;

            showRemoveLineConfirmationDialog(count)
                .then((isConfirmed) => {
                    if (isConfirmed) {
                        this.lodash.remove(this.casingsModel, (item) => {
                            return this.lodash.get(item, 'extra.isSelected', false)
                        });

                        this.casingsModel = [...this.casingsModel]
                    }
                });
        },
        onShowCasingRawMaterialsClicked(casing) {
            console.debug('onShowCasingRawMaterialsClicked', casing);
            this.showRawMaterialsDialog(casing, "Casing No.");
        },
        onFlavourAddLineClicked() {
            console.debug('onFlavourAddLineClicked');

            this.flavoursModel = [
                ...this.flavoursModel,
                mapFlavourLine({}),
            ]
        },
        onFlavourDeleteLineClicked() {
            console.debug('onFlavourDeleteLineClicked');

            let count = this.lodash.countBy(this.flavoursModel,
                (value) => {
                    console.debug(this.lodash.get(value, 'extra.isSelected', false));
                    return this.lodash.get(value, 'extra.isSelected', false);
                }).true;

            showRemoveLineConfirmationDialog(count)
                .then((isConfirmed) => {
                    if (isConfirmed) {
                        this.lodash.remove(this.flavoursModel, (item) => {
                            return this.lodash.get(item, 'extra.isSelected', false)
                        });

                        this.flavoursModel = [...this.flavoursModel]
                    }
                });
        },
        onShowFlavourRawMaterialsClicked(flavour) {
            console.debug('onShowFlavourRawMaterialsClicked', flavour);
            this.showRawMaterialsDialog(flavour, "Flavour No.");
        },
        onExampleCigaretteAddLineClicked() {
            console.debug('onExampleCigaretteAddLineClicked');

            this.exampleCigaretteModel.wraps = [
                ...this.exampleCigaretteModel.wraps,
                mapExampleCigaretteWrap({}),
            ];

            this.exampleCigaretteModel.wraps =
                this.exampleCigaretteModel.wraps.map(mapExampleCigaretteWrapIndex);
        },
        onExampleCigaretteDeleteLineClicked() {
            console.debug('onExampleCigaretteDeleteLineClicked');

            let count = this.lodash.countBy(this.exampleCigaretteModel.wraps,
                (value) => {
                    console.debug(this.lodash.get(value, 'extra.isSelected', false));
                    return this.lodash.get(value, 'extra.isSelected', false);
                }).true;

            showRemoveLineConfirmationDialog(count)
                .then((isConfirmed) => {
                    if (isConfirmed) {
                        this.lodash.remove(this.exampleCigaretteModel.wraps, (item) => {
                            return this.lodash.get(item, 'extra.isSelected', false)
                        });

                        this.exampleCigaretteModel.wraps =
                            this.exampleCigaretteModel.wraps.map(mapExampleCigaretteWrapIndex);

                        this.exampleCigaretteModel.wraps = [...this.exampleCigaretteModel.wraps]
                    }
                });
        },
        async showRawMaterialsDialog(line, title) {
            console.debug('showRawMaterialsDialog', line);

            this.rawMaterialsDialogModel.meta = {
                title: title,
                tabId: line.tab_id,
                tabNum: line.tab_num,
            };
            this.rawMaterialsDialogModel.items = _get(this.rawMaterialsDic, line.tab_id, []);
            this.rawMaterialsDialogModel = {...this.rawMaterialsDialogModel};
        },
        async lookupMfgFormulae() {
            console.debug('lookupMfgFormulae');

            return await getMfgFormulae()
                .then((result) => {
                    console.debug('getMfgFormulae success', result);
                    return result.data.mfg_formulae;

                })
                .catch((err) => {
                    console.debug('getMfgFormulae error', err);
                    return [];
                });
        },
        async lookupItemNumbers(_, __, query, maxResults) {
            console.debug('lookupItemNumbers', query, maxResults);

            let flavourLookupCode = this.lodash.get(this.header, 'flavour.lookup_code');
            if (this.lodash.isEmpty(flavourLookupCode)) {
                return [];
            }
            return await getItemNumbers(query, flavourLookupCode, maxResults)
                .then((result) => {
                    console.debug('getItemNumbers success', result);
                    return result.data.item_numbers;

                })
                .catch((err) => {
                    console.debug('getItemNumbers error', err);
                    return [];
                });
        },
        async lookupCasing(_, __, query, maxResults) {
            console.debug('lookupCasing', query, maxResults);

            return await getCasings(query, maxResults)
                .then((result) => {
                    console.debug('getCasings success', result);
                    return result.data.casings;

                })
                .catch((err) => {
                    console.debug('getCasings error', err);
                    return [];
                });
        },
        async lookupFlavour(_, __, query, maxResults) {
            console.debug('lookupFlavour', query, maxResults);

            return await getFlavours(query, maxResults)
                .then((result) => {
                    console.debug('getFlavours success', result);
                    return result.data.flavours;

                })
                .catch((err) => {
                    console.debug('getFlavours error', err);
                    return [];
                });
        },
        async lookupExampleCigarette(_, __, query, maxResults) {
            console.debug('lookupExampleCigarette', query, maxResults);

            return await getExampleCigarettes(query, maxResults)
                .then((result) => {
                    console.debug('getExampleCigarettes success', result);
                    return result.data.example_cigarettes;

                })
                .catch((err) => {
                    console.debug('getExampleCigarettes error', err);
                    return [];
                });
        },
        leafFormulaDetailUsageAmount(leafFormula, detail) {
            // console.debug('leafFormulaDetailUsageAmount', detail);

            let totalQty = this.headerModel.blend_qty;
            if (this.lodash.isNil(totalQty) || totalQty === 0) {
                return null;
            }

            let formulaDetailQty = totalQty * (leafFormula.ratio / 100) * (detail.item_ratio / 100);
            return (Math.round(formulaDetailQty * 100) / 100).toFixed(2);
        },
    },
    computed: {
        formulaSummaries() {
            console.debug('formulaSummaries');

            // leaf formulae
            let leafFormulaSummaries = _flatMap(this.leafFormulaeModel, leafFormula => {
                return leafFormula.details.map(detail => {
                    let usageAmount = this.leafFormulaDetailUsageAmount(leafFormula, detail)

                    return {
                        rawMaterialId: detail.item_number,
                        description: detail.item_desc,
                        lot: detail.lot_number,
                        quantity: usageAmount,
                        uom: 'KG',
                    };
                });
            });

            let mapTabLine = (line) => {
                let rawMaterials = _get(this.rawMaterialsDic, line.tab_id, []);
                console.debug(rawMaterials, this.rawMaterialsDic)
                return rawMaterials.map((rawMaterial) => {
                    return {
                        rawMaterialId: line.tab_id,
                        description: line.tab_desc,
                        lot: null,
                        quantity: rawMaterial.quantity,
                        uom: rawMaterial.uom,
                    };
                });
            }

            let casingSummaries = _flatMap(this.casingsModel, mapTabLine);
            let flavourSummaries = _flatMap(this.flavoursModel, mapTabLine);

            let summaries = [];
            summaries = summaries.concat(leafFormulaSummaries, casingSummaries, flavourSummaries);

            return summaries;
        },
        isLeafFormulaDetailSelected() {
            if (this.lodash.isNil(this.selectedLeafFormula)) {
                return false;
            }

            let isSelected = false;
            this.selectedLeafFormula.details.forEach(detail => {
                if (detail.extra.isSelected) {
                    isSelected = true;
                }
            });
            return isSelected;
        },
        isCasingSelected() {
            let isSelected = false;
            this.casingsModel.forEach(casing => {
                if (casing.extra.isSelected) {
                    isSelected = true;
                }
            });
            return isSelected;
        },
        isFlavourSelected() {
            let isSelected = false;
            this.flavoursModel.forEach(flavour => {
                if (flavour.extra.isSelected) {
                    isSelected = true;
                }
            });
            return isSelected;
        },
        isExampleCigaretteSelected() {
            console.debug('isExampleCigaretteSelected', this.exampleCigaretteModel, this.exampleCigaretteModel)
            let isSelected = false;
            this.exampleCigaretteModel.wraps.forEach(wrap => {
                if (wrap.extra.isSelected) {
                    isSelected = true;
                }
            });
            return isSelected;
        },
        leafFormulaePercentageAggregation() {
            // console.debug('leafFormulaePercentageAggregation');

            let totalPercentage = this.lodash.reduce(this.leafFormulaeModel, function (result, item) {
                return result + (!isNaN(item.ratio) ? Number(item.ratio) : 0);
            }, 0);

            return (Math.round(totalPercentage * 100) / 100).toFixed(2);
        },
        leafFormulaDetailPercentAggregation() {
            // console.debug('leafFormulaDetailPercentAggregation', this.selectedLeafFormula);

            if (this.lodash.isEmpty(this.selectedLeafFormula)) {
                return 0;
            }

            let totalLeafFormulaPercentage = this.lodash.reduce(this.selectedLeafFormula.details, (result, item) => {
                let itemRatio = !isNaN(item.item_ratio) ? Number(item.item_ratio) : 0;
                return result + itemRatio;
            }, 0);

            return (Math.round(totalLeafFormulaPercentage * 100) / 100).toFixed(2);
        },
        leafFormulaDetailQuantityAggregation() {
            // console.debug('leafFormulaDetailQuantityAggregation', this.selectedLeafFormula);

            if (this.lodash.isEmpty(this.selectedLeafFormula) || this.lodash.isNil(this.headerModel.blend_qty)) {
                return 0;
            }

            let totalQty = parseInt(this.headerModel.blend_qty);
            if (this.lodash.isNil(totalQty) || totalQty === 0) {
                return 0;
            }

            let leafFormulaQuantity = totalQty * (this.selectedLeafFormula.ratio / 100);
            let totalLeafFormulaDetailQty = this.lodash.reduce(this.selectedLeafFormula.details, (result, item) => {
                let itemRatio = !isNaN(item.item_ratio) ? Number(item.item_ratio) : 0;
                return result + ((itemRatio / 100) * leafFormulaQuantity);
            }, 0);

            return (Math.round(totalLeafFormulaDetailQty * 100) / 100).toFixed(2);
        },
    },
}

</script>

<style scoped>
.btn-interface {
    color: white;
    background-color: #00c2c2;
    border-color: #00c2c2;

}

.sale-date input {
    height: 35px !important;
}

.tab-custom ul.nav.nav-tabs li {
    width: 20%;
    text-align: center;
}

.tabs-container.tab-custom .panel-body {
    border: 1px solid #ffffff !important;
    border-radius: 2px !important;
    padding: 20px 0 !important;
}

.tab-custom .nav-tabs .nav-item.show .nav-link,
.tab-custom .nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #19b394;
    border-color: #19b394 #19b394 #fff;
    padding-top: 15px !important;
    padding-bottom: 15px !important;
}

.tab-custom .nav-tabs .nav-link {
    border: 1px solid transparent !important;
    padding-top: 15px !important;
    padding-bottom: 15px !important;
}

.tabs-container .tab-content. .in-tab-custom .panel-body {
    border: 0 !important;
    padding: 20px 0 !important;
}

/* modal กลางหน้าจอ */
.history-update-modal-lg {
    height: 80% !important;
    padding-top: 10%;
}

#modal-raw-materials {
    padding-top: 10%;
}

/* modal กลางหน้าจอ */


</style>
