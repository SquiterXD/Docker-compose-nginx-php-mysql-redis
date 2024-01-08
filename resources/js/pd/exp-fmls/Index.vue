<template>
    <transition
    enter-active-class="animated fadeIn"
    leave-active-class="animated fadeOut">
    <div v-if="!loading.before_mount">
        <modal-search @selectRow="show" :data="data" :transDate="transDate"
            :menu="data.menu"
            :header="header"
            :transBtn="transBtn" :url="url"
            :countOpen="countOpenModal" />

        <modal-history :data="data" :transDate="transDate"
            :menu="data.menu"
            :header="header"
            :transBtn="transBtn" :url="url"
            :countOpen="countOpenHistoryModal" />


        <modal-duplicate @selectRow="show" :data="data" :transDate="transDate"
            :menu="data.menu"
            :header="header"
            :transBtn="transBtn" :url="url"
            :countOpen="countOpenModalDup" />


        <div class="ibox float-e-margins" >
            <div class="ibox-content pb-1" style="border-bottom: 0px;">
                <div class="row">
                    <div class="col-3">
                        <!-- <h3 class="no-margins"> การขอเบิกวัตถุดิบนอกแผน </h3> -->
                    </div>
                    <div class="col-9 text-right">
                        <button :class="transBtn.create.class + ' btn-lg tw-w-25'"
                            @click.prevent="getInfo()" >
                            <i :class="transBtn.create.icon"></i>
                            {{ transBtn.create.text }}
                        </button>

                        <button :class="transBtn.search.class + ' btn-lg tw-w-25 mr-2'"
                            @click.prevent="countOpenModal += 1" >
                            <i :class="transBtn.search.icon"></i>
                            {{ transBtn.search.text }}
                        </button>


                        <button  type="button" :disabled="header.invoice_flag == 'Y'" :class="transBtn.save.class + ' btn-lg tw-w-25'" @click.prevent="save()">
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>

                        <!-- <button  type="button" :class="transBtn.copy.class + ' btn-lg tw-w-25'" >
                            <i :class="transBtn.copy.icon"></i>
                            {{ transBtn.copy.text }}สูตร
                        </button> -->
                        <button :class="transBtn.copy.class + ' btn-lg tw-w-25 mr-2'"
                            :disabled="!header.can.copy_formula"
                            @click.prevent="countOpenModalDup += 1" >
                            <i :class="transBtn.copy.icon"></i>
                            {{ transBtn.copy.text }}สูตร
                        </button>
                        <!-- <button class="btn btn-default" data-toggle="modal" data-target="#historyModal" @click.prevent="countOpenHistoryModal += 1"><i class="fa fa-file-text-o"></i> ประวัติแก้ไข</button> -->
                        <button class="btn btn-default"  @click.prevent="countOpenHistoryModal += 1"><i class="fa fa-file-text-o"></i> ประวัติแก้ไข</button>

                        <!-- <button :class="transBtn.save.class + ' btn-lg tw-w-25'"
                            :disabled="!header.can.save"
                            @click.prevent="save">
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>


                        <button
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
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-4 mb-2 mt-3">
                                <div class="form-group mb-2 row">
                                    <label class="col-5 pl-0 pr-0 font-weight-bold col-form-label required text-right">
                                        ประเภทยาเส้น
                                    </label>
                                    <div class="col-7">
                                        <el-select
                                            class="required"
                                            style="width: 100%"
                                            placeholder=""
                                            :disabled="header.has_tmp_table"
                                            v-model="header.tobacco_type_code"
                                            @change="(value)=>{
                                                getProductItem()
                                            }"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in data.tobacco_type_code_list"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="(item.value)">
                                                <span style="float: left">{{ item.label }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="form-group mb-2 row">
                                    <label class="col-5 pl-0 pr-0 font-weight-bold col-form-label required text-right">
                                        ประเภทสูตร
                                    </label>
                                    <div class="col-7">
                                        <el-select
                                            style="width: 100%"
                                            placeholder=""
                                            value-key="formula_type_code"
                                            :disabled="header.has_tmp_table"
                                            v-model="header.formula_type_code"
                                            @change="(value)=>{
                                                checkFmlType()
                                                getProductItem()
                                                defRecipeFiscalYear();
                                                validateBlendNo();
                                            }"
                                            >
                                            <el-option
                                                v-for="(fmlType, index) in data.formula_type"
                                                :key="(fmlType.lookup_code)"
                                                :label="fmlType.description"
                                                :value="(fmlType.lookup_code)">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <transition
                                    enter-active-class="animated fadeIn"
                                    leave-active-class="animated fadeOut">
                                    <div class="form-group mb-2 row">
                                        <!-- ถ้าสูตรมาตรฐานต้องเลือกปีงบ -->
                                        <label :class="((header.can.is_standart_formula_type)? 'required': '')+' col-5 pl-0 pr-0 font-weight-bold col-form-label  text-right'">
                                            ปีงบประมาณ
                                        </label>
                                        <div class="col-7">
                                            <el-select clearable
                                                style="width: 100%"
                                                placeholder=""
                                                value-key="recipe_fiscal_year"
                                                :disabled="!header.can.edit || !(header.can.is_standart_formula_type) || !header.can.select_product_item_id"
                                                v-model="header.recipe_fiscal_year"
                                                @change="(value)=>{
                                                    validateBlendNo();
                                                }"
                                                >
                                                <template v-if="header.recipe_fiscal_year != '' && header.recipe_fiscal_year != null">
                                                    <el-option
                                                        v-for="(item, index) in data.recipe_fiscal_year_list"
                                                        v-if="item.value >= header.recipe_fiscal_year"
                                                        :key="(item.value)"
                                                        :label="item.value"
                                                        :value="(item.value)">
                                                    </el-option>
                                                </template>
                                                <template v-else>
                                                    <el-option
                                                        v-for="(item, index) in data.recipe_fiscal_year_list"
                                                        :key="(item.value)"
                                                        :label="item.value"
                                                        :value="(item.value)">
                                                    </el-option>
                                                </template>
                                            </el-select>
                                        </div>
                                    </div>
                                </transition>
                                <div class="form-group mb-2 row">
                                    <label class="col-5 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        ขั้นตอนการทำงาน
                                    </label>
                                    <div class="col-7">
                                        <el-select
                                            style="width: 100%"
                                            placeholder=""
                                            value-key="recipe_fiscal_year"
                                            :disabled="(!header.can.edit || (header.product_item_id == '')) || (header.formula_id != '' && header.formula_id != null)"
                                            v-model="header.recipe_routing_no"
                                            @change="(value)=>{
                                            }"
                                            >
                                            <el-option
                                                v-for="(item, index) in data.recipe_routing_no_list"
                                                :key="(item.value)"
                                                :label="item.label"
                                                :value="(item.value)">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 mb-2 mt-3">
                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label required text-right">
                                        Blend No.
                                    </label>
                                    <div class="col-8">
                                            <!-- @input="upper($event)" -->
                                        <el-input placeholder=""
                                        @input="v => { header.blend_no = v.toUpperCase() }"
                                            :disabled="!header.can.edit || (header.tobacco_type_code == '' ) || (header.formula_type_code == '' ) || header.has_tmp_table"
                                            @change="(value)=>{
                                                getProductItem()
                                                validateBlendNo();
                                                if(value) {
                                                    changeTab(selTabName, selTabName, false);
                                                }
                                            }"
                                            v-model="header.blend_no"></el-input>
                                    </div>
                                </div>

                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                        รสชาติ
                                    </label>
                                    <div class="col-8" >
                                        <el-select
                                            style="width: 100%"
                                            placeholder=""
                                            value-key="flavour_code"
                                            v-model="header.flavour_code"
                                            @change="selectFlavour()"
                                            :disabled="!header.can.edit"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in data.flavour_list"
                                                :key="String(item.value)"
                                                :label="item.label"
                                                :value="String(item.value)">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        หมายเหตุ
                                    </label>
                                    <div class="col-8" >
                                        <el-input type="textarea" name="note"
                                            :disabled="!header.can.edit"
                                            v-model="header.comments" rows="4" maxlength="240" show-word-limit />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 mb-2 mt-3">
                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                        รหัสยาเส้น
                                    </label>
                                    <div class="col-8"  v-loading="loading.product_item_id">
                                        <el-input v-if="header.formula_id"
                                            :disabled="true"
                                            v-model="header.product_item_code">
                                        </el-input>

                                        <el-select v-else
                                            class="required"
                                            style="width: 100%"
                                            placeholder=""
                                            value-key="blend_no"
                                            v-model="header.product_item_id"
                                            :disabled="!header.can.edit || header.blend_no == '' || !header.can.select_product_item_id "
                                            @change="(value)=>{
                                                this.sctProduct();
                                                validateBlendNo();
                                            }"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in data.product_item_id_list"
                                                :key="item.value"
                                                :label="item.cust_label"
                                                :value="item.value">
                                                <span style="float: left">{{ item.cust_label }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="form-group mb-2 row">
                                    <!-- <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                        รายละเอียด
                                    </label>
                                    <div class="col-8">
                                        <el-input type="textarea" name="note"
                                            :disabled="!header.can.edit"
                                            v-model="header.description" rows="4" maxlength="240" show-word-limit />
                                    </div> -->

                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                        ชื่อยาเส้น
                                    </label>
                                    <div class="col-8">
                                        <el-input v-model="header.product_item_desc" style="width: 100%" :disabled="true">
                                        </el-input>
                                    </div>
                                </div>

                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        ปริมาณ
                                    </label>
                                    <div class="col-8" >
                                        <div class="input-group ">
                                            <!-- <input class="form-control text-right " type="number" v-model.number="header.quantity" /> -->
                                            <input class="form-control text-right " type="text"
                                                :disabled="!header.can.edit"
                                                :value="header.quantity | number2Digit"
                                                @change="(event) => {
                                                    header.quantity = stripNonNumber(event.target.value)
                                                    if (header.quantity < 0) {
                                                        header.quantity = 0
                                                    }
                                                }"
                                            />
                                            <div class="input-group-append" :title="header.uom">
                                                <span class="input-group-addon" >
                                                    <div v-if="!header.has_tmp_table">
                                                         {{ header.def_uod_desc }}
                                                    </div>
                                                    <div v-else="">
                                                        {{ uomDesc }}
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 mt-3">
                        <dl class="row mb-2">
                            <div class="col-sm-4 text-sm-right pt-2">
                                <dt title="">ผู้บันทึก: </dt>
                            </div>
                            <div class="col-sm-7 text-sm-left">
                                <dd class="mb-1">
                                    <el-input
                                        :title="header.user_name"
                                        v-model="header.web_user_name"
                                        :disabled="true">
                                    </el-input>
                                </dd>
                            </div>
                        </dl>

                        <dl class="row mb-2">
                            <div class="col-sm-4 text-sm-right pt-2">
                                <dt title="">วันที่สร้าง: </dt>
                            </div>
                            <div class="col-sm-7 text-sm-left">
                                <dd class="mb-1">
                                    <el-input
                                        v-model="header.formula_creation_date_format"
                                        :disabled="true">
                                    </el-input>
                                </dd>
                            </div>
                        </dl>

                        <dl class="row mb-2">
                            <div class="col-sm-4 text-sm-right pt-2">
                                <dt title="">วันที่แก้ไขล่าสุด: </dt>
                            </div>
                            <div class="col-sm-7 text-sm-left">
                                <dd class="mb-1">
                                    <el-input
                                        v-model="header.formula_last_update_date_format"
                                        :disabled="true">
                                    </el-input>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-4 mb-2 mt-3">
                                <div class="form-group mb-2 row">
                                    <label class="col-5 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                        สถานะ
                                    </label>
                                    <div class="col-7">
                                        <el-select
                                            style="width: 100%"
                                            placeholder=""
                                            :disabled="(header.blend_no == '' || header.product_item_id == '') && !header.can.is_chnp_formula_type || header.invoice_flag == 'Y'"
                                            value-key="formula_status"
                                            v-model="header.formula_status"
                                            @change="changeStatus"
                                            >
                                            <el-option
                                                v-for="(item, index) in data.status_list"
                                                :key="index"
                                                :label="item"
                                                :value="index">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 mb-2 mt-3">
                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                        วันที่อนุมัติ
                                    </label>
                                    <div class="col-8">
                                        <datepicker-th v-if="header.formula_status.toUpperCase() == 'ACTIVE'"
                                            style="width: 100%"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            placeholder="โปรดเลือกวันที่"
                                            :disabled="!header.can.edit"
                                            :value="header.formula_approval_date_format"
                                            :format="transDate['js-format']"
                                            @dateWasSelected="setdate(...arguments, 'formula_approval_date_format')"
                                            />
                                        <el-input v-else :disabled="true"></el-input>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 mb-2 mt-3">
                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                        วันที่เริ่มใช้
                                    </label>
                                    <div class="col-8">
                                        <datepicker-th v-if="header.formula_status.toUpperCase() == 'ACTIVE'"
                                            style="width: 100%"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            placeholder="โปรดเลือกวันที่"
                                            :disabled="!header.can.edit"
                                            :value="header.formula_start_date_format"
                                            :format="transDate['js-format']"
                                            @dateWasSelected="setdate(...arguments, 'formula_start_date_format')"
                                            />
                                        <el-input v-else :disabled="true"></el-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mt-3">
                        <dl class="row mb-2" v-if="header.can.is_standart_formula_type">
                            <div class="col-sm-4 text-sm-right pt-1">
                                <dt title="">กองบริหารต้นทุนนำไปใช้แล้ว: </dt>
                            </div>
                            <div class="col-sm-7 text-sm-left">
                                <dd class="mb-1 " style="font-size: 1.5em;">
                                    <div class="pt-2 pl-2" v-html="header.invoice_flag_icon_html"></div>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <transition
            enter-active-class="animated fadeInUp"
            leave-active-class="animated fadeOutDown">
        <div class="ibox float-e-margins" v-if="header.blend_no" v-loading="loading.page">
            <div class="ibox-content">
                <!-- <pre>{{ leafFormulas }}</pre> -->
                <!-- <pre>{{ casings }}</pre> -->
                <!-- <pre>{{ selTabName }}</pre> -->
                <!-- <pre>{{ tabs }}</pre> -->
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li>
                            <a :class="(selTabName == 'tab1')? 'nav-link active' : 'nav-link'"  @click="changeTab('tab1', selTabName)">
                                Leaf Formula
                            </a>
                        </li>
                        <li>
                            <a :class="(selTabName == 'tab2')? 'nav-link active' : 'nav-link'"
                                v-if="header.formula_id || true"
                                @click="changeTab('tab2', selTabName)">
                                Casing
                            </a>
                        </li>
                        <li>
                            <a :class="(selTabName == 'tab3')? 'nav-link active' : 'nav-link'"
                                v-if="header.formula_id || true"
                                @click="changeTab('tab3', selTabName)">
                                Flavor
                            </a>
                        </li>
                        <li>
                            <a :class="(selTabName == 'tab4')? 'nav-link active' : 'nav-link'"
                                v-if="header.formula_id || true"
                                @click="changeTab('tab4', selTabName)">
                                บุหรี่
                            </a>
                        </li>
                        <li>
                            <a :class="(selTabName == 'tab5')? 'nav-link active' : 'nav-link'"
                                v-if="header.formula_id || true"
                                @click="changeTab('tab5', selTabName)">
                                ทั้งหมด
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" :class="(selTabName == 'tab1')? 'tab-pane active' : 'tab-pane'">
                            <div class="panel-body pt-3 " v-loading="tabs.leaf_formula_line.loading" >
                                <tab-leaf-formula
                                    v-if="selTabName == 'tab1'"
                                    :header="header"
                                    :url="url"
                                    :transBtn="transBtn"
                                    :transDate="transDate"
                                    :data="data.tabs.leaf_formula_line"
                                    :leafFormulas="leafFormulas"
                                    :pRefresh="tabs.leaf_formula_line.refreshCount"
                                    :tabs="tabs"
                                />
                            </div>
                        </div>
                        <div role="tabpanel" :class="(selTabName == 'tab2')? 'tab-pane active' : 'tab-pane'">
                            <div class="panel-body pt-3" v-loading="tabs.casings.loading">
                                <casing
                                    v-if="selTabName == 'tab2' && (header.formula_id || header.blend_no)"
                                    :header="header"
                                    :url="url"
                                    :transBtn="transBtn"
                                    :transDate="transDate"
                                    :data="data.tabs.casings"
                                    :casings="casings"
                                    :tabs="tabs"
                                />
                            </div>
                        </div>
                        <div role="tabpanel" :class="(selTabName == 'tab3')? 'tab-pane active' : 'tab-pane'">
                            <div class="panel-body pt-3" v-loading="tabs.flavors.loading">
                                <flavor
                                    v-if="selTabName == 'tab3' && header "
                                    :header="header"
                                    :url="url"
                                    :transBtn="transBtn"
                                    :transDate="transDate"
                                    :data="data.tabs.flavors"
                                    :flavors="flavors"
                                    :tabs="tabs"
                                />
                            </div>
                        </div>
                        <div role="tabpanel" :class="(selTabName == 'tab4')? 'tab-pane active' : 'tab-pane'">
                            <div class="panel-body pt-3" v-loading="tabs.cigarettes.loading">
                                <cigarette
                                    v-if="selTabName == 'tab4' && header && (header.formula_id || header.blend_no)"
                                    :header="header"
                                    :url="url"
                                    :transBtn="transBtn"
                                    :transDate="transDate"
                                    :data="data.tabs.cigarettes"
                                    :cigarettes="cigarettes"
                                    :cigarDtl="cigarDtl"
                                    :tabs="tabs"
                                />
                            </div>
                        </div>
                        <div role="tabpanel" :class="(selTabName == 'tab5')? 'tab-pane active' : 'tab-pane'">
                            <div class="panel-body pt-3" v-loading="tabs.cigarette_all.loading">
                                <cigarette-all
                                    v-if="selTabName == 'tab5' && header && (header.formula_id || header.blend_no)"
                                    :transBtn="transBtn"
                                    :transDate="transDate"
                                    :cigaretteAll="cigaretteAll"
                                    :tabs="tabs"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </transition>
    </div>
    </transition>
</template>
<!-- url -->
<script>

import {
    showLoadingDialog,
    showProgressWithUnsavedChangesWarningDialog,
    showValidationFailedDialog,
} from "../../commonDialogs"

import moment from "moment";
import SearchItem from './SearchItem';
import TabLeafFormula from './tabs/LeafFormula';
import Casing from './tabs/Casing';
import Flavor from './tabs/Flavor';
import Cigarette from './tabs/Cigarette';
import CigaretteAll from './tabs/CigaretteAll';
import modalSearch from './ModalSearch.vue';
import modalDuplicate from './ModalDuplicate.vue';
import modalHistory from './ModalHistory.vue';


export default {

    components: {
        SearchItem, TabLeafFormula, Casing, Flavor, Cigarette, CigaretteAll, modalSearch, modalDuplicate, modalHistory
    },
    props:["pUrl", "pMenu"],
    computed: {
        // ingredient_group() {
        //     return this.header.ingredient_group;
        // },
    },
    watch:{
        // selTabName : async function (val, oldVal) {
        //     console.log('selTabName', val, oldVal);

        //     this.changeTab(val, oldVal);

    },
    data() {
        return {
            url: this.pUrl,
            menu: this.pMenu,
            data: false,
            header: false,
            profile: false,
            uomDesc: '',
            transBtn: {},
            transDate: {},
            isActive: false,
            lines: [],

            originalData: [],
            originalDtlData: [],
            leafFormulas: [],
            casings: [],
            flavors: [],
            cigarettes: [],
            cigarDtl: [],
            cigaretteAll: [],

            leafFormulaHasChange: false,

            loading: {
                page: false,
                before_mount: false,
                product_item_id: false,
            },
            firstLoad: true,
            countOpenModal: 0,
            countOpenHistoryModal: 0,
            countOpenModalDup: 0,
            selTabName: 'tab1',
            tabs: {
                leaf_formula_line: {
                    loading: false,
                    refreshCount: 1,
                    has_change: false,
                },
                casings: {
                    loading: false,
                    refreshCount: 1,
                    has_change: false,
                },
                flavors: {
                    loading: false,
                    refreshCount: 1,
                    has_change: false,
                },
                cigarettes: {
                    loading: false,
                    refreshCount: 1,
                    has_change: false,
                },
                cigarette_all: {
                    loading: false,
                    refreshCount: 1,
                    has_change: false,
                },
            },
            rules: {
              name: [
                { required: true, message: 'Please input Activity name', trigger: 'blur' },
                { min: 3, max: 5, message: 'Length should be 3 to 5', trigger: 'blur' }
              ],
            },
            ruleForm: {
              name: '',
            },
        }
    },
    beforeMount() {
        console.log('beforeMount');
        this.getInfo();
    },
    mounted() {
        console.log('Component mounted. PDP0008')
        const urlParams = new URLSearchParams(window.location.search);
        const blendNo = urlParams.get('blend_no');
        if (blendNo) {
            this.getInfo('', blendNo, '', '');
        }
        // this.setData();
    },
    methods: {
        stripNonNumber(text) {
          return parseFloat(text.replace(/,/g, ''));
        },
        upper(e) {
            e.target.value = e.target.value.toUpperCase()
        },
        async getProductItem(isCreation = 1) {
            let vm = this;
            // reset data
            vm.data.blend_no_list = [];
            vm.data.product_item_id_list = [];
            vm.header.product_item_id = '';

            // if (vm.header.tobacco_type_code != '' && !(vm.header.can.is_standart_formula_type)) {
            if (vm.header.tobacco_type_code != '' && vm.header.can.select_product_item_id) {
                let params = {
                    blend_no:           vm.header.blend_no,
                    recipe_fiscal_year: vm.header.recipe_fiscal_year,
                    tobacco_type_code:  vm.header.tobacco_type_code,
                    formula_type_code:  vm.header.formula_type_code,
                    is_creation:        isCreation,
                    action:             'get-blend-no',
                };

                vm.loading.product_item_id = true;
                await axios.get(vm.url.index, { params }).then(res => {
                    let response = res.data.data
                    if (response.status == 'S') {
                        vm.data.product_item_id_list = response.product_item_id_list
                    }

                    if (response.status == 'E') {
                        swal({
                            title: "Error !",
                            text: response.msg,
                            type: "error",
                            showConfirmButton: true
                        });
                        vm.header.blend_no = '';
                    }
                    vm.loading.product_item_id = false;
                });
            }
        },
        async validateBlendNo() {
            let vm = this;
            let headerData = JSON.parse(JSON.stringify(vm.header));

            // if (vm.header.tobacco_type_code != '' && !(vm.header.can.is_standart_formula_type)) {
            let params = {
                header: headerData,
                action: 'validate-blend-no',
            };
            await axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data

                if (!response.result.check_blend_no) {
                    swal({
                        title: "Error !",
                        text: response.result.check_blend_no_msg,
                        type: "error",
                        showConfirmButton: true
                    });
                    if (!vm.header.blend_id) {
                        vm.header.blend_no = '';
                    }  else {
                        vm.header.recipe_fiscal_year = '';
                    }
                }

                vm.header.check_match_blend_no = response.result.check_match_blend_no;
                vm.header.check_match_blend_no_msg = response.result.check_match_blend_no_msg;

                // await helperAlert.showGenericFailureDialog(error);
                // if (response.status == 'S') {
                //     vm.data.product_item_id_list = response.product_item_id_list
                // }

                // if (response.status == 'E') {
                //     swal({
                //         title: "Error !",
                //         text: response.msg,
                //         type: "error",
                //         showConfirmButton: true
                //     });
                //     vm.header.blend_no = '';
                // }
                // vm.loading.product_item_id = false;
            });
        },
        async show(header) {
            this.loading.before_mount = false;
            this.getInfo(
                header.formula_id,
                header.blend_no,
                header.tobacco_organization_id,
                header.formula_no
            );
        },
        async setdate(date, key) {
            let vm = this;
            vm.header[key] = await moment(date).format(vm.transDate['js-format']);
            vm.getLines();
        },
        async changeStatus() {
            // if (this.header.formula_status.toUpperCase() == 'INACTIVE') {
            //     this.isActive = true;
            // } else {
            //     this.isActive = false;
            // }

            // this.header.can.edit = (this.isActive == true);
            // this.header.can.edit = true;
        },
        async getInfo(formulaId = '', blendNo = '', orgId = '', formulaNo = '') {
            let vm = this;
            // let param = window.location.search;
            // let param = '';

            // if (formulaId) {
            //     if (param == '' || true) {
            //         param = '?formula_id='+ formulaId;
            //     } else {
            //         param = param + '&formula_id='+ formulaId;
            //     }
            // }
            // let param = '?formula_id='+ formulaId;
            let params = {
                lookup_code:        vm.header.lookup_code,
                formula_id:         formulaId,
                blend_no:           blendNo,
                formula_no:         formulaNo,
                tobacco_organization_id: orgId,
            };

            let response = false;
            vm.loading.page = true;
            vm.loading.before_mount = true;
            // vm.selTabName = 'tab1';
            await axios.get(vm.url.index, { params }).then(res => {
                response = res.data.data
                if (response.status == 'S') {
                    response = response.info
                }
                vm.loading.page = false;
            });

            if (response) {
                console.log('xx', response);
                vm.data = response.data;
                vm.header = response.header;
                vm.profile = response.profile;
                vm.transBtn = response.transBtn;
                vm.transDate = response.transDate;
                vm.url = response.url;
                // vm.header.blend_no = '369'

                if (vm.header.formula_id) {
                    vm.uomDesc = vm.header.uom_name;
                }
                await vm.resetData();
            }

            vm.loading.before_mount = false;
            // vm.getLines(false, 'show');
            if (vm.header.formula_id == '' || vm.header.formula_id == null) {
                vm.getProductItem(0);
            }
            vm.changeTab(vm.selTabName, vm.selTabName, false);
            vm.changeStatus();
            vm.defRecipeFiscalYear();

            vm.checkFmlType();
        },
        async getLines(isShowNoti = true, action = 'search') {
            return;
            let vm = this;
            let confirm = true;

            if (isShowNoti) {
                confirm = await helperAlert.showProgressConfirm('กรุณายืนยันการค้นหารายการเบิก');
            }
        },
        async delay(item) {
            if (item == 3000) {
                throw 'Error ' + item;
            }
            let promise = new Promise((resolve, reject) => {
                setTimeout(() => resolve("done!" + item), item)
            });

            let result = await promise; // wait until the promise resolves (*)
            console.log(result); // "done!"
        },
        async changeTab(toTab, FromTab, isShowNoti = true) {
            let vm = this;
            let confirm = true;

            let type = '';
            if (toTab == 'tab1') {
                type = 'leaf_formula_line'
            } else if(toTab == 'tab2') {
                type = 'casings'
            } else if(toTab == 'tab3') {
                type = 'flavors'
            } else if(toTab == 'tab4') {
                type = 'cigarettes'
            } else if(toTab == 'tab5') {
                type = 'cigarette_all'
            }

            let mustBeConfirmed = false
            if ((toTab != FromTab && FromTab != 'tab5' && isShowNoti) || !vm.header.formula_id) {
                let isEqual = await vm.compareData(FromTab);
                if (!isEqual) {
                    confirm = await helperAlert.showProgressConfirm('ต้องการบันทึกข้อมูลที่แก้ไขหรือไม่ ?');
                    if (confirm) {
                        let err = '';

                        try {
                            vm.loading.page = true;
                            let valid = await this.validateTab();
                            let haeder = await this.store(false);
                            await vm.show(haeder)
                        } catch (error) {
                            vm.loading.page = false;
                            console.log('catch error', error)
                            await helperAlert.showGenericFailureDialog(error);
                            return;
                        }
                        vm.loading.page = false;
                    }
                }
            }

            vm.selTabName = toTab;
            await vm.resetData();
            let params = {
                header: vm.header,
                type: type
            }

            vm.tabs[type].loading = true;
            vm.tabs[type].has_change = false;

            axios.get(vm.url.ajax_get_data, { params }).then(res => {
                let response = res.data.data;

                if (type == 'leaf_formula_line') {
                    vm.originalData = JSON.parse(JSON.stringify(response.leaf_formula_lines));
                    vm.leafFormulas = response.leaf_formula_lines;
                }

                if (type == 'casings') {
                    vm.originalData = JSON.parse(JSON.stringify(response.casings));
                    vm.casings = response.casings
                }

                if (type == 'flavors') {
                    vm.originalData = JSON.parse(JSON.stringify(response.flavors));
                    vm.flavors = response.flavors
                }

                if (type == 'cigarettes') {
                    vm.originalData = JSON.parse(JSON.stringify(response.cigarettes));
                    vm.originalDtlData = JSON.parse(JSON.stringify(response.cigar_dtl));
                    vm.cigarettes = response.cigarettes;
                    vm.cigarDtl = response.cigar_dtl;
                }

                if (type == 'cigarette_all') {
                    vm.cigaretteAll = response[type];
                }
                vm.tabs[type].loading = false;
            });
        },
        async resetData() {
            let vm = this;
            vm.originalData = [];
            vm.originalDtlData = [];
            vm.leafFormulas = [];
            vm.casings = [];
            vm.flavors = [];
            vm.cigarettes = [];
            vm.cigarDtl = [];
            vm.cigaretteAll = [];
        },
        async compareData(fromTab) {
            let vm = this;
            let isEqual = false;


            let type = '';
            if (fromTab == 'tab1') {
                type = 'leaf_formula_line'
            } else if(fromTab == 'tab2') {
                type = 'casings'
            } else if(fromTab == 'tab3') {
                type = 'flavors'
            } else if(fromTab == 'tab4') {
                type = 'cigarettes'
            } else if(fromTab == 'tab5') {
                type = 'cigarette_all'
            }

            await axios.post(vm.url.ajax_compare_data,
                {
                    header: vm.header,
                    original_data: vm.originalData,
                    original_dtl_data: vm.originalDtlData,
                    type: type,
                    leaf_formulas: vm.leafFormulas,
                    casings: vm.casings,
                    flavors: vm.flavors,
                    cigarettes: vm.cigarettes,
                    cigar_dtl: vm.cigarDtl,
                })
                .then(res => {
                    let data = res.data.data;


                    isEqual = data.is_equal;
                    // if (data.status == 'S') {
                    //     vm.hasChange = false;
                    //     vm.header = data.header;
                    //     swal({
                    //         title: 'บันทึกข้อมูลสำเร็จ',
                    //         type: "success",
                    //         html: true
                    //     });

                    //     setTimeout(async function(){ await vm.getInfo(header.formula_id); }, 500);
                    // }

                    // if (data.status != 'S') {
                    //     swal({
                    //         title: "Error !",
                    //         text: data.msg,
                    //         type: "error",
                    //         showConfirmButton: true
                    //     });
                    // }
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
                    vm.loading.page = false;
                    // swal.close();
                });
            console.log('compareData')
            return isEqual;
        },
        async store(isShowNoti = true) {
            let vm = this;
            let confirm = true;
            let valid = true;
            let message = '';
            vm.loading.page = true;
            let storePromise = new Promise(async (resolve, reject) => {
                await axios.post(vm.url.ajax_store, {
                    header: vm.header,
                    leaf_formulas: vm.leafFormulas,
                    casings: vm.casings,
                    flavors: vm.flavors,
                    cigarettes: vm.cigarettes,
                    cigar_dtl: vm.cigarDtl,
                })
                .then(res => {
                    let data = res.data.data;
                    if (data.status == 'S') {
                        vm.hasChange = false;
                        // vm.header = data.header;
                        swal({
                            title: '&nbsp;',
                            text: 'บันทึกข้อมูลสำเร็จ',
                            type: "success",
                            html: true
                        });
                        resolve(data.header);
                    }

                    if (data.status != 'S') {
                        reject(data.msg);
                    }
                })
                .catch(err => {
                    let data = err.response.data;
                    reject(data.message);
                })
                .then(() => {
                    vm.loading.page = false;
                });
            });
            let result = await storePromise; // wait until the promise resolves (*)
            return result;
        },
        async save(isShowNoti = true) {
            let vm = this;
            let confirm = true;
            let valid = true;


            try {
                 vm.loading.page = true;
                await vm.validateTab();
                if (isShowNoti) {
                    if (!vm.header.blend_no) {
                        throw 'โปรดระบุยาเส้นปรุง Blend No.';
                    }
                    // ถ้าสูตรมาตรฐานต้องเลือกปีงบ
                    if (vm.header.can.is_standart_formula_type && vm.header.recipe_fiscal_year == '') {
                        throw 'โปรดระบุปีงบประมาณ';
                    }

                    if (vm.selTabName == "tab1" && vm.header.product_item_id != '') {
                        if (vm.leafFormulas.filter(o => o.is_deleted == false).length == 0) {
                            throw `โปรดเพิ่ม Leaf Formula อย่างน้อง 1 รายการ`;
                        }
                    }

                    // if (vm.header.product_item_id != '' && (vm.header.comments == '' || vm.header.comments == null || vm.header.comments == undefined)) {
                    //     throw `กรณีเลือกรหัสยาเส้น โปรดระบุหมายเหตุ`;
                    // }

                    let msg = 'กรุณายืนยัน บันทึกสูตรผลิต';
                    if (!vm.header.check_match_blend_no) {
                        msg = vm.header.check_match_blend_no_msg;
                    }
                    confirm = await helperAlert.showProgressConfirm(msg);
                    if (confirm) {
                        let haeder = await this.store(false);
                        await vm.show(haeder)
                    }
                }
            } catch (error) {
                vm.loading.page = false;
                console.error(error) // from creation or business logic
                await helperAlert.showGenericFailureDialog(error);
                return;
            }
            vm.loading.page = false;
        },
        async sctProduct() {
            let vm = this;
            vm.uomDesc = '';
            vm.header.description = '';
            // vm.header.formula_no = '';
            vm.header.product_item_code = '';
            vm.header.uom_name = '';
            vm.header.uom = '';
            // vm.header.quantity = '';

            let itemProduct = vm.data.product_item_id_list.findIndex(o => o.value == vm.header.product_item_id);
                itemProduct = vm.data.product_item_id_list[itemProduct];
                // console.log('sctProduct', itemProduct);
            if (itemProduct) {
                let confirm = true;
                if (itemProduct.check_match_blend_no == '0') {
                    confirm = await helperAlert.showProgressConfirm(itemProduct.check_match_blend_no_msg);
                }

                if (confirm) {
                    // vm.header.description       = itemProduct.description;
                    vm.header.description       = '';
                    // vm.header.formula_no        = itemProduct.formula_no;
                    vm.header.product_item_code = itemProduct.product_item_code;
                    vm.header.uom               = itemProduct.uom;
                    vm.header.uom_name          = itemProduct.uom_name;
                    // vm.header.quantity          = itemProduct.quantity;
                    vm.uomDesc                  = itemProduct.uom;
                    vm.header.product_item_desc = itemProduct.description;

                    if(vm.data.recipe_routing_no_list.length > 0 && (!vm.header.recipe_routing_no)) {
                        vm.header.recipe_routing_no = vm.data.recipe_routing_no_list[0].value;
                    }
                } else {
                    vm.header.product_item_id = '';
                }
            } else {
            }

            if (!vm.header.product_item_id) {
                vm.header.formula_status = 'Inactive'
                vm.header.recipe_routing_no = ''
            }

            // if (vm.header.blend_no) {
            //     vm.changeTab('tab1', 'tab1', false);
            // }
        },
        async selectFlavour() {
            let vm = this;
            // vm.header.flavour

            vm.header.flavour = '';
            vm.header.formula_organization_code = '';
            vm.header.organization_code = '';
            vm.header.department = '';

            let flavour = vm.data.flavour_list.findIndex(o => o.value == vm.header.flavour_code);
                flavour = vm.data.flavour_list[flavour];

            if (flavour) {
                vm.header.flavour = flavour.flavour;
                vm.header.formula_organization_code = flavour.formula_organization_code;
                vm.header.organization_code = flavour.organization_code;
                vm.header.department = flavour.department;
            }
        },
        async checkFmlType() {
            let vm = this;
            let chkFormulaType = vm.data.formula_type.findIndex(o => o.lookup_code == vm.header.formula_type_code);
                chkFormulaType = vm.data.formula_type[chkFormulaType];
                chkFormulaType.description != 'สูตรชนป.'

            vm.header.can.leaf_formulas.ingredient.add_lot_number = chkFormulaType.description != 'สูตรชนป.';

            vm.header.can.is_standart_formula_type = (chkFormulaType.lookup_code == 'S'); // 'สูตรมาตรฐาน'
            vm.header.can.is_actual_formula_type = (chkFormulaType.lookup_code == 'A');
            vm.header.can.is_chnp_formula_type = (chkFormulaType.lookup_code == 'P'); // สูตร ชนป
        },
        async defRecipeFiscalYear() {
            let vm = this;

            // if (!vm.header.has_tmp_table) {
            //     return;
            // }
            let chkFormulaType = vm.data.formula_type.findIndex(o => o.lookup_code == vm.header.formula_type_code);
                chkFormulaType = vm.data.formula_type[chkFormulaType];


            if (vm.header.has_tmp_table) {
                if (chkFormulaType.description == 'สูตรมาตรฐาน') {
                    vm.header.recipe_fiscal_year = vm.header.recipe_fiscal_year ? vm.header.recipe_fiscal_year : vm.header.def_recipe_fiscal_year;
                } else {
                    vm.header.recipe_fiscal_year = vm.header.recipe_fiscal_year ? vm.header.recipe_fiscal_year : '';
                }
            } else {
                if (chkFormulaType.description == 'สูตรมาตรฐาน') {
                    vm.header.recipe_fiscal_year = vm.header.recipe_fiscal_year ? vm.header.recipe_fiscal_year : vm.header.def_recipe_fiscal_year;
                } else {
                    vm.header.recipe_fiscal_year = '';
                }
            }

        },
        async validateTab() {
            let vm = this;
            let confirm = true;
            let valid = true;
            let message = '';
            await this.delay(500);

            let validate = new Promise(async (resolve, reject) => {
                if (vm.selTabName == "tab1") {

                    await vm.leafFormulas.forEach(async (o, i) => {
                        if (o.is_deleted == false) {
                            if (parseFloat(o.leaf_proportion) == 0 || o.leaf_proportion == '') {
                                message = `โปรดระบุ สัดส่วน % (Leaf Formula: ${o.leaf_formula} ${o.leaf_formula_desc})`;
                                reject(message);
                                return;
                            }
                        }
                    });

                    // validate เสมอ
                    // if (vm.header.formula_status.toUpperCase() == 'ACTIVE' || true) {
                    if (vm.leafFormulas.length) {

                        let totalLeafProp = 0;
                        let hasData = true;
                        // vm.leafFormulas.forEach(async (o, i) => {
                        //     if (o.is_deleted == false) {
                        //         totalLeafProp = parseFloat(o.leaf_proportion) + parseFloat(totalLeafProp);
                        //         hasData = true;
                        //     }
                        // });
                        if (hasData) {
                            // ทำเป็น ทศนิยม 2 ตำแหน่งก่อน
                            // if ( (parseFloat(totalLeafProp).toFixed(2) * 1) != 100) {
                            //     message = 'Leaf Formula: ยอดรวมสัดส่วน % มากกว่าหรือน้อยกว่า 100';
                            //     throw message;
                            //     return;
                            // }

                            // console.log('parseFloat(totalLeafProp)', parseFloat(totalLeafProp), parseFloat(totalLeafProp).toFixed(2) * 1, Math.floor((totalLeafProp * 100) / 100 ));


                            let hasDataDel = false;
                            let totalDetail = 0;
                            let quantityUsed = 0;
                            await vm.leafFormulas.forEach(async (o, i) => {
                                if (o.is_deleted == false) {
                                    // o.leaf_dtl.forEach((leafDtl) => {
                                    await o.leaf_dtl.forEach(async (leafDtl, i) => {
                                        // console.log('leafDtl', leafDtl);
                                        if (leafDtl.is_deleted == false) {
                                            hasDataDel = true
                                            totalDetail = parseFloat(totalDetail) + parseFloat(leafDtl.ingredient_proportions);

                                            quantityUsed = parseFloat(quantityUsed) + parseFloat(leafDtl.quantity_used);

                                            // console.log(leafDtl, '----->', parseFloat(totalDetail), 'xxx->', parseFloat(leafDtl.ingredient_proportions));
                                            if (leafDtl.lot_number == '' && vm.header.can.leaf_formulas.ingredient.add_lot_number && false) {
                                                // ยกเลิก เช็คเรื่อง Lot

                                                message = 'โปรดระบุ Lot ของวัตถุดิบ ' + leafDtl.item_code + ': ' + leafDtl.item_desc;
                                                reject(message);
                                            }
                                            if ((leafDtl.lot_number == '' || leafDtl.lot_number == null) && vm.header.can.is_actual_formula_type && leafDtl.validate_lot == 'Y') {
                                                message = 'โปรดระบุ Lot ของวัตถุดิบ ' + leafDtl.item_code + ': ' + leafDtl.item_desc;
                                                reject(message);
                                            }

                                        }
                                        // if (leafDtl.leafDtl == false) {
                                        //     hasDataDel = true
                                        //     totalDetail = parseFloat(totalDetail) + parseFloat(leafDtl.ingredient_proportions);
                                        //     console.log(leafDtl, '----->', parseFloat(totalDetail), 'xxx->', parseFloat(leafDtl.ingredient_proportions));
                                        //     if (leafDtl.lot_number == '') {
                                        //         message = 'โปรดระบุ Lot ของวัตถุดิบ ' + leafDtl.item_code + ': ' + leafDtl.item_desc;
                                        //         helperAlert.showGenericFailureDialog(message);
                                        //         valid = false;
                                        //         return;
                                        //     }
                                        // }
                                    });
                                    // console.log('--------------------------', totalDetail);

                                    // if (hasDataDel && parseFloat(totalDetail) != 100 && parseFloat(totalDetail) != 99.99999) {
                                    //     console.log(o.leaf_dtl, totalDetail, '---', parseFloat(totalDetail), 'ยอดรวมสัดส่วน x11')
                                    //     message = 'Leaf Detail: ยอดรวมสัดส่วน % ของวัตถุดิบ มากกว่าหรือน้อยกว่า 100';
                                    //     throw message;
                                    //     return;
                                    // }

                                }
                            });
                            if (hasDataDel && parseFloat(quantityUsed).toFixed(3) != parseFloat(vm.header.quantity).toFixed(3)) {
                                message = 'Leaf Detail: ยอดรวมปริมาณที่ใช้ (กก.): '+ parseFloat(quantityUsed) +'  ของวัตถุดิบ ไม่เท่ากับปริมาณของสูตร: ' + parseFloat(vm.header.quantity);
                                reject(message);
                            }

                        }
                    }
                }

                if (vm.selTabName == "tab2") {
                    vm.casings.forEach(async (o, i) => {
                        if (o.is_deleted == false) {

                            if (o.casing_id == '') {
                                message = `โปรดระบุ casing (Leaf Formula: ${o.leaf_formula} ${o.leaf_formula_desc})`;
                                reject(message);
                            }
                        }
                    });
                }

                if (vm.header.product_item_id != '' ) {
                    if (vm.header.recipe_routing_no =='' || vm.header.recipe_routing_no == null) {
                        message = 'โปรดระบุขั้นตอนการทำงาน';
                        reject(message);
                    }
                }
                resolve(true);
            });

            let result = await validate; // wait until the promise resolves (*)

            return result;
        }
    }
}
</script>
