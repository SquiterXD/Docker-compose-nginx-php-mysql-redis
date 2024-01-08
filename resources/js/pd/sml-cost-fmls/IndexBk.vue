<template>
    <transition
    enter-active-class="animated fadeIn"
    leave-active-class="animated fadeOut">
    <div v-if="!loading.before_mount">
        <!-- <modal-search @selectRow="show" :transDate="transDate"
            :menu="data.menu"
            :header="header"
            :transBtn="transBtn" :url="url"
            :countOpen="countOpenModal" />

        <modal-duplicate @selectRow="show" :data="data" :transDate="transDate"
            :menu="data.menu"
            :header="header"
            :transBtn="transBtn" :url="url"
            :countOpen="countOpenModalDup" /> -->


        <div class="ibox float-e-margins" >
            <div class="ibox-content pb-1" style="border-bottom: 0px;">
                <div class="row">
                    <div class="col-3">
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

                        <button  type="button" :class="transBtn.save.class + ' btn-lg tw-w-25'" @click.prevent="save()">
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>

                        <button :class="transBtn.copy.class + ' btn-lg tw-w-25 mr-2'"
                            :disabled="!header.can.copy_formula"
                            @click.prevent="countOpenModalDup += 1" >
                            <i :class="transBtn.copy.icon"></i>
                            {{ transBtn.copy.text }}สูตร
                        </button>
                        <button class="btn btn-default" data-toggle="modal" data-target="#historyModal"><i class="fa fa-file-text-o"></i> ประวัติแก้ไข</button>
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
                                            style="width: 100%"
                                            placeholder=""
                                            v-model="header.tobacco_type_code"
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

                                <!-- <div class="form-group mb-2 row">
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
                                </div> -->

                                <!-- <transition
                                    enter-active-class="animated fadeIn"
                                    leave-active-class="animated fadeOut">
                                    <div class="form-group mb-2 row">
                                        <label :class="((header.can.is_standart_formula_type)? 'required': '')+' col-5 pl-0 pr-0 font-weight-bold col-form-label  text-right'">
                                            ปีงบประมาณ
                                        </label>
                                        <div class="col-7">
                                            <el-select clearable
                                                style="width: 100%"
                                                placeholder=""
                                                value-key="recipe_fiscal_year"
                                                :disabled="!(header.can.is_standart_formula_type)"
                                                v-model="header.recipe_fiscal_year"
                                                @change="(value)=>{
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
                                            :disabled="!header.can.edit || (header.product_item_id == '')"
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
                                </div> -->
                            </div>
                            <div class="col-4 mb-2 mt-3">
                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label required text-right">
                                        Blend No.
                                    </label>
                                    <div class="col-8">
                                        <!-- <el-input placeholder=""
                                        @input="v => { header.blend_no = v.toUpperCase() }"
                                            :disabled="!header.can.edit || (header.tobacco_type_code == '' ) || (header.formula_type_code == '' ) || header.has_tmp_table"
                                            @change="(value)=>{
                                                getProductItem()
                                                if(value) {
                                                    changeTab(selTabName, selTabName, false);
                                                }
                                            }"
                                            v-model="header.blend_no"></el-input> -->
                                        <el-input
                                            :disabled="!header.can.edit || header.has_tmp_table"
                                            placeholder="" @input="v => { header.blend_no = v.toUpperCase() }"
                                            v-model="header.blend_no">
                                        </el-input>
                                    </div>
                                </div>

                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                        รสชาติ
                                    </label>
                                    <div class="col-8" >
                                        <!-- <el-select
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
                                        </el-select> -->
                                        <el-select
                                            style="width: 100%"
                                            placeholder=""
                                            v-model="header.flavour"
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
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                        รายละเอียด
                                    </label>
                                    <div class="col-8">
                                        <el-input type="textarea" name="note"
                                            :disabled="!header.can.edit"
                                            v-model="header.details" rows="2" maxlength="240" show-word-limit />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 mb-2 mt-3">
                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                        ต้นทุนมวนอ้างอิงรหัสบุหรี่
                                    </label>
                                    <div class="col-8"  v-loading="loading.product_item_id">
                                        <el-select clearable filterable
                                            style="width: 100%"
                                            placeholder=""
                                            :disabled="!header.can.edit || header.has_tmp_table"
                                            :value="header.cigarate_refer_cost_item"
                                            @change="(data) => {
                                                header.cigarate_refer_cost_item = data.value
                                            }"
                                            >
                                            <el-option
                                                v-for="(item, index, key) in data.cigarate_refer_cost_item_list"
                                                :key="(key)"
                                                :label="item.label"
                                                :value="(item)">
                                            </el-option>
                                        </el-select>
                                        <!-- <el-input v-if="header.formula_id"
                                            :disabled="true"
                                            v-model="header.product_item_code">
                                        </el-input> -->

                                        <!-- <el-select v-else
                                            class="required"
                                            style="width: 100%"
                                            placeholder=""
                                            value-key="blend_no"
                                            v-model="header.product_item_id"
                                            :disabled="!header.can.edit || header.blend_no == '' "
                                            @change="(value)=>{
                                                this.sctProduct();
                                                if (!value) {
                                                    header.formula_status = 'Inactive'
                                                    header.recipe_routing_no = ''
                                                }
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
                                        </el-select> -->
                                    </div>
                                </div>

                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        ปริมาณ
                                    </label>
                                    <div class="col-8" >
                                        <div class="input-group ">
                                            <!-- <input class="form-control text-right " type="text"
                                                :value="header.quantity | number2Digit"
                                                @change="(event) => {
                                                    header.quantity = stripNonNumber(event.target.value)
                                                    if (header.quantity < 0) {
                                                        header.quantity = 0
                                                    }
                                                }"
                                            /> -->
                                            <input class="form-control text-right " type="text"
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
                                                    {{ header.uom_name }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        หมายเหตุ
                                    </label>
                                    <div class="col-8" >
                                        <el-input type="textarea" name="note"
                                            :disabled="!header.can.edit"
                                            v-model="header.note" rows="3" maxlength="240" show-word-limit />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 mt-3">
                        <dl class="row mb-2">
                            <div class="col-sm-4 text-sm-right pt-2">
                                <dt title="">ตัวอย่างที่: </dt>
                            </div>
                            <div class="col-sm-7 text-sm-left">
                                <dd class="mb-1">
                                    <el-input v-model="header.example_no" :disabled="true"></el-input>
                                </dd>
                            </div>
                        </dl>

                        <dl class="row mb-2">
                            <div class="col-sm-4 text-sm-right pt-2">
                                <dt title="">ผู้บันทึก: </dt>
                            </div>
                            <div class="col-sm-7 text-sm-left">
                                <dd class="mb-1">
                                    <el-input
                                        :title="header.user_name"
                                        v-model="header.user_name"
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
                                        v-model="header.create_transaction_date_format"
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
                                        v-model="header.last_transaction_date_format"
                                        :disabled="true">
                                    </el-input>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="ibox-content" v-if="false">
                <div class="row">
                    <!-- <div class="col-lg-12">
                        <pre>{{ config }}</pre>
                    </div> -->
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-6 mb-2 mt-3">
                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        รูปแบบราคา
                                    </label>
                                    <div class="col-8">
                                        <template>
                                            <el-radio @change="init()" v-model="header.flag_cost_standard" label="Y">ราคา standard</el-radio>
                                            <el-radio @change="init()" v-model="header.flag_cost_standard" label="N">ราคาตามวันที</el-radio>
                                        </template>
                                    </div>
                                </div>
                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        ราคา ณ วันที่
                                    </label>
                                    <div class="col-8">
                                        <input style="height: 40px;" v-if="config.is_flag_cost_standard" type="text"  disabled="disabled" class="form-control">
                                        <ct-datepicker v-else
                                            class=" form-control form-control col-12"
                                            style="width: 100%;"
                                            placeholder="โปรดเลือกวันที่"
                                            :value="toJSDate(header.cost_date, 'yyyy-MM-dd')"
                                                @change="(date) => {
                                                header.cost_date = jsDateToString(date)
                                            }"
                                            />
                                    </div>
                                </div>


                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        ต้นทุนมวนอ้างอิงรหัสบุหรี่
                                    </label>
                                    <div class="col-8">
                                        <el-select clearable filterable
                                            style="width: 100%"
                                            placeholder=""
                                            :value="header.cigarate_refer_cost_item"
                                            @change="(data) => {
                                                header.cigarate_refer_cost_item = data.value
                                            }"
                                            >
                                            <el-option
                                                v-for="(item, index, key) in data.cigarate_refer_cost_item_list"
                                                :key="(key)"
                                                :label="item.label"
                                                :value="(item)">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        &nbsp;
                                    </label>
                                    <div class="col-8">
                                        <input type="text" readonly="readonly" disabled="disabled" class="form-control"
                                            :value="(()=>{
                                                let vm = this;
                                                if (vm.header.cigarate_refer_cost_item != '' && vm.header.cigarate_refer_cost_item != null) {
                                                    let item = data.cigarate_refer_cost_item_list.findIndex(o => o.value == vm.header.cigarate_refer_cost_item);
                                                        item = vm.data.cigarate_refer_cost_item_list[item];
                                                    return item.item_desc
                                                } else {
                                                    return ''
                                                }
                                               })()"
                                        >
                                    </div>
                                </div>

                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        ต้นทุนซองอ้างอิงรหัสบุหรี่
                                    </label>
                                    <div class="col-8">
                                        <el-select clearable filterable
                                            style="width: 100%"
                                            placeholder=""
                                            :value="header.cigarate_pack_cost_item"
                                            @change="(data) => {
                                                header.cigarate_pack_cost_item = data.value
                                            }"
                                            >
                                            <el-option
                                                v-for="(item, index, key) in data.cigarate_pack_cost_item_list"
                                                :key="(key)"
                                                :label="item.label"
                                                :value="(item)">
                                            </el-option>
                                        </el-select>

                                    </div>
                                </div>
                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        &nbsp;
                                    </label>
                                    <div class="col-8">
                                        <input type="text" readonly="readonly" disabled="disabled" class="form-control"
                                            :value="(()=>{
                                                let vm = this;
                                                if (vm.header.cigarate_pack_cost_item != '' && vm.header.cigarate_pack_cost_item != null) {
                                                    let item = data.cigarate_pack_cost_item_list.findIndex(o => o.value == vm.header.cigarate_pack_cost_item);
                                                        item = vm.data.cigarate_pack_cost_item_list[item];
                                                    return item.item_desc
                                                } else {
                                                    return ''
                                                }
                                               })()"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-2 mt-3">
                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        ประเภทยาเส้น
                                    </label>
                                    <div class="col-8">
                                        <el-select
                                            style="width: 100%"
                                            placeholder=""
                                            v-model="header.tobacco_type_code"
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
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        Blend No.
                                    </label>
                                    <div class="col-8">
                                        <!-- <el-input placeholder=""
                                            @input="v => { header.blend_no = v.toUpperCase() }" v-model="header.blend_no">
                                        </el-input> -->

                                        <el-input placeholder="" @input="v => { header.blend_no = v.toUpperCase() }"
                                            v-model="header.blend_no">
                                        </el-input>
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
                                            v-model="header.flavour"
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
                                        ปริมาณ
                                    </label>
                                    <div class="col-8" >
                                        <div class="input-group ">
                                            <!-- <input class="form-control text-right " type="number" v-model.number="header.quantity" /> -->
                                            <input class="form-control text-right " type="text"
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
                                                    {{ header.uom_name }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                        รายละเอียด
                                    </label>
                                    <div class="col-8">
                                        <el-input type="textarea" name="note"
                                            :disabled="!header.can.edit"
                                            v-model="header.details" rows="2" maxlength="240" show-word-limit />
                                    </div>
                                </div>

                                <div class="form-group mb-2 row">
                                    <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        หมายเหตุ
                                    </label>
                                    <div class="col-8" >
                                        <el-input type="textarea" name="note"
                                            :disabled="!header.can.edit"
                                            v-model="header.note" rows="3" maxlength="240" show-word-limit />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-3">
                        <dl class="row mb-2">
                            <div class="col-sm-4 text-sm-right pt-2">
                                <dt title="">ตัวอย่างที่: </dt>
                            </div>
                            <div class="col-sm-7 text-sm-left">
                                <dd class="mb-1">
                                    <el-input v-model="header.example_no" :disabled="true"></el-input>
                                </dd>
                            </div>
                        </dl>

                        <dl class="row mb-2">
                            <div class="col-sm-4 text-sm-right pt-2">
                                <dt title="">ผู้บันทึก: </dt>
                            </div>
                            <div class="col-sm-7 text-sm-left">
                                <dd class="mb-1">
                                    <el-input
                                        :title="header.user_name"
                                        v-model="header.user_name"
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
                                        v-model="header.create_transaction_date_format"
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
                                        v-model="header.last_transaction_date_format"
                                        :disabled="true">
                                    </el-input>
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
        <div class="ibox float-e-margins"  v-loading="loading.page" >
            <div class="ibox-content">
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



        <transition
            enter-active-class="animated fadeInUp"
            leave-active-class="animated fadeOutDown">
        <div class="ibox float-e-margins" v-if="header.blend_no && false" v-loading="loading.page">
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

import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'

export default {

    components: {
        SearchItem, TabLeafFormula, Casing, Flavor, Cigarette, CigaretteAll, modalSearch, modalDuplicate
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
            config: {},

            isInRange, jsDateToString, toJSDate, toThDateString,

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
            countOpenModalDup: 0,
            selTabName: 'tab5',
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
        console.log('Component mounted.')
        // this.setData();
    },
    methods: {
        async init() {
            let vm = this;
            vm.$set(vm.config, 'is_flag_cost_standard', vm.header.flag_cost_standard.toUpperCase() == 'Y');
        },








        stripNonNumber(text) {
          return parseFloat(text.replace(/,/g, ''));
        },
        async getInfo(blendId = '', blendNo = '', orgId = '') {
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
                blend_id:           blendId,
                blend_no:           blendNo,
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
                // console.log('xx', response);
                vm.data = response.data;
                vm.header = response.header;
                vm.profile = response.profile;
                vm.transBtn = response.transBtn;
                vm.transDate = response.transDate;
                vm.url = response.url;
                // vm.header.blend_no = '369'
                await vm.resetData();
            }

            let init = new Promise(async (resolve, reject) => {
                await this.init();
                await this.changeTab(vm.selTabName, vm.selTabName, false);
                resolve(true)
            });
            await init;
            vm.loading.before_mount = false;

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
            if ((toTab != FromTab && FromTab != 'tab5' && isShowNoti) || !vm.header.formula_id ) {
                let isEqual = await vm.compareData(FromTab);
                if (!isEqual && false) {
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
            let inputCigarettes = JSON.parse(JSON.stringify(vm.cigarettes));
                inputCigarettes.map(function(o) {
                        o.cigar_list = [];
                });

                await axios.post(vm.url.ajax_store, {
                    header: vm.header,
                    leaf_formulas: vm.leafFormulas,
                    casings: vm.casings,
                    flavors: vm.flavors,
                    cigarettes: inputCigarettes,
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
                    // if (!vm.header.blend_no) {
                    //     throw 'โปรดระบุยาเส้นปรุง Blend No.';
                    // }
                    // // ถ้าสูตรมาตรฐานต้องเลือกปีงบ
                    // if (vm.header.can.is_standart_formula_type && vm.header.recipe_fiscal_year == '') {
                    //     throw 'โปรดระบุปีงบประมาณ';
                    // }

                    confirm = await helperAlert.showProgressConfirm('กรุณายืนยันการบันทึก');
                    if (confirm) {
                        let haeder = await this.store(false);
                        await vm.show(haeder)
                    }
                }
            } catch (error) {
                vm.loading.page = false;
                console.error(error) // from creation or business logic
                await helperAlert.showGenericFailureDialog(error, true);
                return;
            }
            vm.loading.page = false;
        },
        async validateTab() {
            let vm = this;
            let confirm = true;
            let valid = true;
            let message = '';
            await this.delay(500);


            let validate = new Promise(async (resolve, reject) => {
            let inputCigarettes = JSON.parse(JSON.stringify(vm.cigarettes));
                inputCigarettes.map(function(o) {
                        o.cigar_list = [];
                });
                await axios.post(vm.url.ajax_store, {
                    action: 'validate',
                    tab: vm.selTabName,
                    header: vm.header,
                    leaf_formulas: vm.leafFormulas,
                    casings: vm.casings,
                    flavors: vm.flavors,
                    cigarettes: inputCigarettes,
                    cigar_dtl: vm.cigarDtl,
                })
                .then(res => {
                    let data = res.data.data;
                    if (!data.valid) {
                        reject(data.err_html)
                    }
                })
                .catch(err => {
                    let data = err.response.data;
                    reject(data.message);
                })
                .then(() => {
                    // vm.loading.page = false;
                });

                // if (vm.selTabName == "tab1") {

                //     await vm.leafFormulas.forEach(async (o, i) => {
                //         if (o.is_deleted == false) {
                //             if (parseFloat(o.leaf_proportion) == 0 || o.leaf_proportion == '') {
                //                 message = `โปรดระบุ สัดส่วน % (Leaf Formula: ${o.leaf_formula} ${o.leaf_formula_desc})`;
                //                 reject(message);
                //                 return;
                //             }
                //         }
                //     });

                //     // validate เสมอ
                //     // if (vm.header.formula_status.toUpperCase() == 'ACTIVE' || true) {
                //     if (vm.leafFormulas.length) {

                //         let totalLeafProp = 0;
                //         let hasData = true;
                //         // vm.leafFormulas.forEach(async (o, i) => {
                //         //     if (o.is_deleted == false) {
                //         //         totalLeafProp = parseFloat(o.leaf_proportion) + parseFloat(totalLeafProp);
                //         //         hasData = true;
                //         //     }
                //         // });
                //         if (hasData) {
                //             // ทำเป็น ทศนิยม 2 ตำแหน่งก่อน
                //             // if ( (parseFloat(totalLeafProp).toFixed(2) * 1) != 100) {
                //             //     message = 'Leaf Formula: ยอดรวมสัดส่วน % มากกว่าหรือน้อยกว่า 100';
                //             //     throw message;
                //             //     return;
                //             // }

                //             // console.log('parseFloat(totalLeafProp)', parseFloat(totalLeafProp), parseFloat(totalLeafProp).toFixed(2) * 1, Math.floor((totalLeafProp * 100) / 100 ));


                //             let hasDataDel = false;
                //             let totalDetail = 0;
                //             let quantityUsed = 0;
                //             await vm.leafFormulas.forEach(async (o, i) => {
                //                 if (o.is_deleted == false) {
                //                     // o.leaf_dtl.forEach((leafDtl) => {
                //                     await o.leaf_dtl.forEach(async (leafDtl, i) => {
                //                         // console.log('leafDtl', leafDtl);
                //                         if (leafDtl.is_deleted == false) {
                //                             hasDataDel = true
                //                             totalDetail = parseFloat(totalDetail) + parseFloat(leafDtl.ingredient_proportions);

                //                             quantityUsed = parseFloat(quantityUsed) + parseFloat(leafDtl.quantity_used);

                //                             // console.log(leafDtl, '----->', parseFloat(totalDetail), 'xxx->', parseFloat(leafDtl.ingredient_proportions));
                //                             if (leafDtl.lot_number == '' && vm.header.can.leaf_formulas.ingredient.add_lot_number && false) {
                //                                 // ยกเลิก เช็คเรื่อง Lot

                //                                 message = 'โปรดระบุ Lot ของวัตถุดิบ ' + leafDtl.item_code + ': ' + leafDtl.item_desc;
                //                                 reject(message);
                //                             }

                //                         }
                //                         // if (leafDtl.leafDtl == false) {
                //                         //     hasDataDel = true
                //                         //     totalDetail = parseFloat(totalDetail) + parseFloat(leafDtl.ingredient_proportions);
                //                         //     console.log(leafDtl, '----->', parseFloat(totalDetail), 'xxx->', parseFloat(leafDtl.ingredient_proportions));
                //                         //     if (leafDtl.lot_number == '') {
                //                         //         message = 'โปรดระบุ Lot ของวัตถุดิบ ' + leafDtl.item_code + ': ' + leafDtl.item_desc;
                //                         //         helperAlert.showGenericFailureDialog(message);
                //                         //         valid = false;
                //                         //         return;
                //                         //     }
                //                         // }
                //                     });
                //                     // console.log('--------------------------', totalDetail);

                //                     // if (hasDataDel && parseFloat(totalDetail) != 100 && parseFloat(totalDetail) != 99.99999) {
                //                     //     console.log(o.leaf_dtl, totalDetail, '---', parseFloat(totalDetail), 'ยอดรวมสัดส่วน x11')
                //                     //     message = 'Leaf Detail: ยอดรวมสัดส่วน % ของวัตถุดิบ มากกว่าหรือน้อยกว่า 100';
                //                     //     throw message;
                //                     //     return;
                //                     // }

                //                 }
                //             });
                //             if (hasDataDel && parseFloat(quantityUsed) != parseFloat(vm.header.quantity)) {
                //                 message = 'xxx Leaf Detail: ยอดรวมปริมาณที่ใช้ (กก.): '+ parseFloat(quantityUsed) +'  ของวัตถุดิบ ไม่เท่ากับปริมาณของสูตร: ' + parseFloat(vm.header.quantity);
                //                 reject(message);
                //             }

                //         }
                //     }
                // }

                // if (vm.selTabName == "tab2") {
                //     vm.casings.forEach(async (o, i) => {
                //         if (o.is_deleted == false) {

                //             if (o.casing_id == '') {
                //                 message = `โปรดระบุ casing (Leaf Formula: ${o.leaf_formula} ${o.leaf_formula_desc})`;
                //                 reject(message);
                //             }
                //         }
                //     });
                // }

                // if (vm.header.product_item_id != '' ) {
                //     if (vm.header.recipe_routing_no =='' || vm.header.recipe_routing_no == null) {
                //         message = 'โปรดระบุขั้นตอนการทำงาน';
                //         reject(message);
                //     }
                // }
                resolve(true);
            });

            let result = await validate; // wait until the promise resolves (*)

            return result;
        },
        async show(header) {
            this.loading.before_mount = false;
            this.getInfo(
                header.blend_id
            );
        },
    }
}
</script>
