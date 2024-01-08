<template>
    <transition
    enter-active-class="animated fadeIn"
    leave-active-class="animated fadeOut">
    <div v-if="!loading.before_mount" v-loading="loading.search">
        <modal-blend-search @selectRow="show" :transDate="transDate"
            :header="header"
            :menu="data.menu"
            :searchInput="data.search_input"
            :transBtn="transBtn" :url="url"
            :countOpen="countOpenBlendModal" />

        <modal-brand-search @selectRow="show" :transDate="transDate"
            :header="header"
            :menu="data.menu"
            :searchInput="data.search_input"
            :transBtn="transBtn" :url="url"
            :countOpen="countOpenBrandModal" />


        <div class="ibox float-e-margins" >
            <div class="ibox-content pb-1" style="border-bottom: 0px;">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9 offset-3 text-right">
                        <button :class="transBtn.search.class + ' btn-lg tw-w-25 mr-2'"
                            @click.prevent="countOpenBlendModal += 1" >
                            <i :class="transBtn.search.icon"></i>
                            ค้นหา Blend No.
                        </button>
                        <button :class="transBtn.search.class + ' btn-lg tw-w-25 mr-2'"
                            @click.prevent="countOpenBrandModal += 1" >
                            <i :class="transBtn.search.icon"></i>
                            ค้นหา ตราบุหรี
                        </button>

                    </div>
                </div>
            </div>
            <div class="ibox-content pb-1" style="border-bottom: 0px;">
                <div class="row" >
                    <div class="col-5 mb-2 mt-3 ">
                        <div class="form-group mb-2 row">
                            <div class="offset-4 col-7 pl-0 pr-0 font-weight-bold col-form-label  text-center">
                                <h2 class="text-navy">ใบยาที่ต้องการแทน</h2>
                            </div>
                        </div>
                        <div class="form-group mb-2 row">
                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                ประเภทยาเส้น <span class="text-danger">*</span>
                            </label>
                            <div class="col-7">
                                <el-select
                                    class=""
                                    style="width: 100%"
                                    placeholder=""
                                    v-model="form.tobacco_type_desc"
                                    @change="(value)=>{
                                        if (!value) {
                                            this.form.category_code_1 = ''
                                            this.form.category_code_2 = ''
                                            this.form.item_id = ''
                                            this.form.lot_number = ''
                                        }
                                        getParam()
                                    }"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in inputParams.tobacco_type_desc_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="(item.value)">
                                        <span style="float: left">{{ item.label }}</span>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group mb-2 row">
                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                ประเภทใบยา <span class="text-danger">*</span>
                            </label>
                            <div class="col-7">
                                <el-select
                                    class=""
                                    style="width: 100%"
                                    placeholder=""
                                    :disabled="!form.tobacco_type_desc"
                                    v-model="form.category_code_1"
                                    @change="(value)=>{
                                        if (!value) {
                                            this.form.category_code_2 = ''
                                            this.form.item_id = ''
                                            this.form.lot_number = ''
                                        }
                                        getParam()
                                    }"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in inputParams.category_code_1_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="(item.value)">
                                        <span style="float: left">{{ item.label }}</span>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group mb-2 row">
                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                ชนิดใบยา <span class="text-danger">*</span>
                            </label>
                            <div class="col-7">
                                <el-select
                                    class=""
                                    style="width: 100%"
                                    placeholder=""
                                    :disabled="!form.category_code_1"
                                    v-model="form.category_code_2"
                                    @change="(value)=>{
                                        if (!value) {
                                            this.form.item_id = ''
                                            this.form.lot_number = ''
                                        }
                                        getParam()
                                    }"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in inputParams.category_code_2_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="(item.value)">
                                        <span style="float: left">{{ item.label }}</span>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group mb-2 row">
                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                รหัสใบยา
                            </label>
                            <div class="col-7">
                                <el-select
                                    class=""
                                    style="width: 100%"
                                    placeholder=""
                                    :disabled="!form.category_code_2"
                                    v-model="form.item_id"
                                    @change="(value)=>{
                                        if (!value) {
                                            this.form.lot_number = ''
                                        }
                                        getParam()
                                        inputParams.lot_number = ''
                                    }"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in inputParams.item_id_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="(item.value)">
                                        <span style="float: left">{{ item.label }}</span>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group mb-2 row">
                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                รายละเอียดใบยา
                            </label>
                            <div class="col-7">
                                <el-input
                                  placeholder=""
                                  :value="(()=>{
                                    let vm = this;
                                    if ((vm.form.item_id != '' && vm.form.item_id != null) && vm.inputParams.item_id_list.length > 0 ) {
                                        let item = vm.inputParams.item_id_list.findIndex(o => o.value == vm.form.item_id);
                                            item = vm.inputParams.item_id_list[item];
                                        return item.item_desc
                                    } else {
                                        return ''
                                    }
                                   })()"
                                  :disabled="true">
                                </el-input>
                            </div>
                        </div>

                        <div class="form-group mb-2 row">
                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                เลข Lot Number
                            </label>
                            <div class="col-7">
                                <el-select
                                    class=""
                                    style="width: 100%"
                                    placeholder=""
                                    :disabled="!form.item_id"
                                    v-model="form.lot_number"
                                    @change="(value)=>{
                                        getParam()
                                    }"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in inputParams.lot_number_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="(item.value)">
                                        <span style="float: left">{{ item.label }}</span>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>

                        <div class="form-group mb-2 row">
                            <div class="col-11 text-right">
                                <!-- <button :class="transBtn.search.class + ' btn-lg tw-w-25 mr-2'"
                                    @click.prevent="reset()" >
                                    <i class="fa fa-undo"></i>
                                    ล้างค่า
                                </button> -->
                                <a :href="url.index" :class="transBtn.search.class + ' btn-lg tw-w-25 mr-2'">
                                    <i class="fa fa-undo"></i>
                                    ล้างค่า
                                </a>

                                <button :class="transBtn.search.class + ' btn-lg tw-w-25 mr-2'"
                                    @click.prevent="search(true)" >
                                    <i :class="transBtn.search.icon"></i>
                                    {{ transBtn.search.text }}
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="col-2 mb-2 mt-3 text-center align-middle">
                        <!-- <i class="fa fa-random fa-5x text-muted mt-5 pt-5"></i> -->
                        <span class="fa-stack fa-lgtext-muted mt-5 fa-5x" style="opacity: 0.4;">
                          <i class="fa fa-circle fa-stack-2x "></i>
                          <i class="fa fa-random fa-stack-1x fa-inverse"></i>
                        </span>
                    </div>
                    <div class="col-5 mb-2 mt-3">
                        <div class="form-group mb-2 row">
                            <div class="offset-3 col-7 pl-0 pr-0 font-weight-bold col-form-label  text-center">
                                <h2 class="text-danger">ใบยาที่จะแทนเกรด</h2>
                            </div>
                        </div>
                        <div class="form-group mb-2 row">
                            <label class="col-3 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                ประเภทยาเส้น <span class="text-danger">*</span>
                            </label>
                            <div class="col-7">
                                <el-select
                                    class=""
                                    style="width: 100%"
                                    placeholder=""
                                    v-model="form.instead_tobacco_type_desc"
                                    @change="(value)=>{
                                        if (!value) {
                                            this.form.instead_category_code_1 = ''
                                            this.form.instead_category_code_2 = ''
                                            this.form.instead_item_id = ''
                                            form.instead_lot_number = ''
                                        }
                                        getDataInstea({})
                                    }"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in inputParams.instead_tobacco_type_desc_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="(item.value)">
                                        <span style="float: left">{{ item.label }}</span>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group mb-2 row">
                            <label class="col-3 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                ประเภทใบยา <span class="text-danger">*</span>
                            </label>
                            <div class="col-7">
                                <el-select
                                    class=""
                                    style="width: 100%"
                                    placeholder=""
                                    :disabled="!form.instead_tobacco_type_desc"
                                    v-model="form.instead_category_code_1"
                                    @change="(value)=>{
                                        if (!value) {
                                            this.form.instead_category_code_2 = ''
                                            this.form.instead_item_id = ''
                                            form.instead_lot_number = ''
                                        }
                                        getDataInstea({})
                                    }"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in inputParams.instead_category_code_1_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="(item.value)">
                                        <span style="float: left">{{ item.label }}</span>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group mb-2 row">
                            <label class="col-3 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                ชนิดใบยา <span class="text-danger">*</span>
                            </label>
                            <div class="col-7">
                                <el-select
                                    class=""
                                    style="width: 100%"
                                    placeholder=""
                                    :disabled="!form.instead_category_code_1"
                                    v-model="form.instead_category_code_2"
                                    @change="(value)=>{
                                        if (!value) {
                                            this.form.instead_item_id = ''
                                            form.instead_lot_number = ''
                                        }
                                        getDataInstea({})
                                    }"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in inputParams.instead_category_code_2_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="(item.value)">
                                        <span style="float: left">{{ item.label }}</span>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>


                        <div class="form-group mb-2 row">
                            <label class="col-3 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                แทนด้วยรหัสใบยา <span class="text-danger">*</span>
                            </label>
                            <div class="col-7">
                                <el-select
                                    class=""
                                    style="width: 100%"
                                    placeholder=""
                                    :disabled="header.has_tmp_table || !form.instead_category_code_2"
                                    v-model="form.instead_item_id"
                                    @change="changeInsteadItem()"
                                    clearable
                                    filterable
                                    remote
                                    :remote-method="data => remoteMethodInstea(data)"
                                    >
                                    <el-option
                                        v-for="item in inputParams.instead_item_id_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="(item.value)">
                                        <span style="float: left">{{ item.label }}</span>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group mb-2 row">
                            <label class="col-3 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                รายละเอียดใบยาใหม่
                            </label>
                            <div class="col-7">
                                <el-input
                                  placeholder=""
                                  :value="(()=>{
                                    let vm = this;
                                    if ((vm.form.instead_item_id != '' && vm.form.instead_item_id != null) && vm.inputParams.instead_item_id_list.length > 0 ) {
                                        let item = vm.inputParams.instead_item_id_list.findIndex(o => o.value == vm.form.instead_item_id);
                                            item = vm.inputParams.instead_item_id_list[item];
                                        return item.item_desc
                                    } else {
                                        return ''
                                    }
                                   })()"
                                  :disabled="true">
                                </el-input>
                            </div>
                        </div>
                        <div class="form-group mb-2 row">
                            <label class="col-3 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                Lot
                            </label>
                            <div class="col-7">
                                <el-select
                                    class=""
                                    style="width: 100%"
                                    placeholder=""
                                    :disabled="header.has_tmp_table || !form.instead_item_id"
                                    v-model="form.instead_lot_number"
                                    @change="changeInsteadLot()"
                                    clearable
                                    filterable
                                    >
                                    <el-option v-if="inputParams.instead_lot_number_list.length > 0"
                                        v-for="item in inputParams.instead_lot_number_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="(item.value)">
                                        <span style="float: left">{{ item.label }}</span>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>

                        <div class="form-group mb-2 row">
                            <label class="col-3 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                จำนวนและหน่วย
                            </label>
                            <div class="col-7">
                                <div class="form-row" style="display: flex; flex-wrap: nowrap;">
                                    <template v-if="Object.keys(inputParams.instead_onhand_list).length > 0 && form.instead_lot_number != ''">
                                        <div class="col-sm-6">
                                            <input v-model="Number(inputParams.instead_onhand_list['lot-' + form.instead_lot_number].onhand_quantity).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2})"
                                                disabled class="form-control  text-right " style="height: 40px;">
                                        </div>
                                        <div class="col-sm-6">
                                            <input v-model="inputParams.instead_onhand_list['lot-' + form.instead_lot_number].primary_unit_of_measure"
                                                disabled class="form-control  text-right " style="height: 40px;">
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="col-sm-6">
                                            <input disabled class="form-control  text-right " style="height: 40px;">
                                        </div>
                                        <div class="col-sm-6">
                                            <input disabled class="form-control  text-right " style="height: 40px;">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2 row">
                            <label class="col-3 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                อนุมัติใช้วันที่
                            </label>
                            <div class="col-7">
                                <ct-datepicker
                                    style="width: 100%;"
                                    class="my-1 col-sm-12 form-control"
                                    :disabled="true && false"
                                    placeholder="โปรดเลือกวันที่"
                                    :value="toJSDate(form.approved_date, 'yyyy-MM-dd')"
                                    @change="(date) => {
                                        if(date){
                                            let requestDate = luxon.DateTime.fromJSDate(date).startOf('day')
                                            form.approved_date = requestDate.toFormat('yyyy-MM-dd')
                                            form = {...form}
                                        }else{
                                            form.approved_date = null
                                        }
                                    }"
                                />
                            </div>
                        </div>

                        <div class="form-group mb-2 row">
                            <div class="col-10 text-right">
                                <button  type="button" :class="transBtn.delete.class + ' btn-lg tw-w-40'"
                                    :disabled="!hasSelectDelLine" @click.prevent="save()">
                                    <i :class="transBtn.delete.icon"></i>
                                    ลบรายการ
                                </button>

                                <button  type="button" :class="transBtn.save.class + ' btn-lg tw-w-40'"
                                    :disabled="!header.can.edit && header.h_adj_sale_for_id  && !hasSelectDelLine"
                                    @click.prevent="save()">
                                    <i :class="transBtn.save.icon"></i>
                                    บันทึกแทนเกรด
                                </button>

                                <!-- <button  type="button" :class="'btn btn-info btn-lg tw-w-40'"
                                    :disabled="!header.can.edit && header.h_adj_sale_for_id"
                                    @click.prevent="save()">
                                    <i class="fa fa-info"></i>
                                    ประวัติแทนเกรดใบยา
                                </button> -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="ibox-content"  v-loading="loading.lines">

                <div class="table-responsive m-t" v-if="header">
                    <table  class="table text-nowrap table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5px;"></th>
                                <th width="100px;">Blend No.</th>
                                <th width="100px;" class="text-center">สถานะสูตร</th>
                                <th width="100px;" class="text-center">Leaf Formula</th>
                                <th class="text-center">สัดส่วนในสูตร (%)</th>
                                <th>รหัสใบยา</th>
                                <th>รายละเอียดใบยา</th>
                                <th>Lot</th>
                                <th class="text-center">สถานะคงคลัง</th>
                                <th>สัดส่วนเดิม (%)</th>
                                <th>แทนด้วยรหัสใบยา</th>
                                <th>รายละเอียดใบยาใหม่</th>
                                <th>Lot</th>
                                <th>สัดส่วนใหม่ (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(line, idx) in header.lines">
                                <td>
                                    <div class="check-center">
                                        <label class="label-input">
                                            <input class="align-middle" type="checkbox"
                                                :disabled="line.is_disabled"
                                                v-model="line.is_select"
                                                @change="changeSelect(line, idx)">
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">{{ line.blend_no }}</td>
                                <td class="text-center">{{ line.formula_status }}</td>
                                <td class="text-center">{{ line.leaf_formula }}</td>
                                <td class="text-center">{{ line.ingredient_proportions }}</td>
                                <td >{{ line.item_code }}</td>
                                <td>{{ line.item_desc }}</td>
                                <td>{{ line.lot_number }}</td>
                                <td class="text-center">
                                    <div :title="line.onhand_quantity_format" data-toggle="tooltip" data-placement="top" data-container="body">
                                        <span v-if="line.onhand_quantity == '0' || line.onhand_quantity == '' || line.onhand_quantity == null"
                                        class="text-danger">
                                            <strong>ไม่มีคงคลัง</strong>
                                        </span>
                                        <span v-else  class="text-success">
                                            <strong>มีคงคลัง</strong>
                                        </span>
                                    </div>
                                </td>
                                <template v-if="line.for_delete">
                                    <td class="text-right">
                                        <input type="number" class="form-control" disabled >
                                    </td>
                                    <td class="text-right">
                                        <input type="number" class="form-control" disabled >
                                    </td>
                                    <td class="text-right">
                                        <input type="number" class="form-control" disabled >
                                    </td>
                                    <td class="text-right">
                                        <input type="number" class="form-control" disabled >
                                    </td>
                                    <td class="text-right">
                                        <input type="number" class="form-control" disabled >
                                    </td>
                                </template>
                                <template v-else>
                                    <td class="text-right">
                                        <!-- <input type="number" v-if="header.can.edit"
                                            class="form-control text-right"
                                            oninput="validity.valid || (value='');"
                                            @change=""
                                            v-model.number="line.old_ingredient_proportions"> -->
                                        <vue-numeric v-if="header.can.edit && !line.is_disabled"
                                            separator=","
                                            v-bind:precision="2"
                                            v-bind:minus="false"
                                            class="form-control text-right font-weight-bold "
                                            v-model.number="line.old_ingredient_proportions"
                                            @change="changeOldIngProp(line)"
                                            ></vue-numeric>
                                        <div v-else>
                                            {{ line.old_ingredient_proportions | number2Digit }}
                                        </div>
                                    </td>
                                    <td>{{ line.instead_item_code }}</td>
                                    <td>{{ line.instead_item_desc }}</td>
                                    <td class="text-right">
                                        <el-select
                                            v-if="header.can.edit && (form.instead_item_id != '' && form.instead_item_id != null) && !line.is_disabled"
                                            class=""
                                            style="width: 100%"
                                            placeholder=""
                                            :disabled="header.has_tmp_table"
                                            v-model="line.instead_lot_number"
                                            @change="(value)=>{
                                            }"
                                            clearable
                                            filterable
                                            >
                                            <el-option
                                                v-for="item in line.instead_lot_number_list"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="(item.value)">
                                                <span style="float: left">{{ item.label }}</span>
                                            </el-option>
                                        </el-select>
                                        <div v-else>
                                            <input type="text" class="form-control text-right" disabled >
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <!-- <input type="number"
                                             v-if="header.can.edit && (form.instead_item_id != '' && form.instead_item_id != null)"
                                            class="form-control text-right"
                                            oninput="validity.valid || (value='');"
                                            @change=""
                                            v-model.number="line.instead_ingredient_proportions"> -->
                                        <vue-numeric v-if="header.can.edit && (form.instead_item_id != '' && form.instead_item_id != null) && !line.is_disabled"
                                            separator=","
                                            v-bind:precision="2"
                                            v-bind:minus="false"
                                            v-bind:read-only="true"
                                            class="form-control text-right font-weight-bold "
                                            v-model.number="line.instead_ingredient_proportions"
                                            ></vue-numeric>
                                        <div v-else>
                                            <input type="text" class="form-control text-right" disabled >
                                        </div>
                                    </td>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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


import VueNumeric from 'vue-numeric';
import moment from "moment";
import modalCreate from './ModalCreate.vue';
import modalBlendSearch from './ModalBlendSearch.vue';
import modalBrandSearch from './ModalBrandSearch.vue';

import {DateTime} from 'luxon';
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'

export default {

    components: {
        modalCreate, modalBlendSearch, modalBrandSearch
    },
    props:["pUrl"],
    computed: {
        totalQuantity() {
            if (this.header) {
                let sum =  _.sumBy(this.header.lines, function(o) { return parseFloat(o.quantity); });
                return sum
            } else {
                return 0;
            }
        },
        totalAdjustQuantity() {
            if (this.header) {
                let sum =  _.sumBy(this.header.lines, function(o) { return parseFloat(o.adjust_quantity); });
                return sum
            } else {
                return 0;
            }
        }
    },
    watch:{
        // selTabName : async function (val, oldVal) {
        //     console.log('selTabName', val, oldVal);

        //     this.changeTab(val, oldVal);

    },
    data() {
        return {
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,
            luxon: {
                DateTime,
            },
            hasSelectDelLine: false,

            url: this.pUrl,
            data: false,
            header: false,
            profile: false,
            transBtn: {},
            transDate: {},
            loading: {
                page: false,
                before_mount: false,
                search: false,
                lines: false,
            },
            countOpenBlendModal: 0,
            countOpenBrandModal: 0,
            inputParams: {
                tobacco_type_desc_list: [],
                category_code_1_list: [],
                category_code_2_list: [],
                item_id_list: [],
                lot_number_list: [],

                instead_tobacco_type_desc_list: [],
                instead_category_code_1_list: [],
                instead_category_code_2_list: [],
                instead_item_id_list: [],
                instead_lot_number_list: [],
                instead_onhand_list: [],
                lines_list: [],
            },
            form: {
                tobacco_type_desc: null,
                category_code_1: null,
                category_code_2: null,
                item_id: null,
                lot_number: '',

                instead_tobacco_type_desc: null,
                instead_category_code_1: null,
                instead_category_code_2: null,
                instead_item_id: null,
                instead_lot_number: '',
                approved_date: null,
                instead_select: {},
            },
        }
    },
    beforeMount() {
        console.log('beforeMount');
        this.getInfo(false);
    },
    mounted() {
        console.log('Component mounted.')

        // this.setData();
    },
    methods: {
        async show(header) {
            console.log('show header', header);
            this.loading.before_mount = false;
            this.getInfo(header.h_adj_sale_for_id);
        },
        async setdate(date, key) {
            let vm = this;
            vm.header[key] = await moment(date).format(vm.transDate['js-format']);
            vm.getLines();
        },
        async changeAdjustQuantity(line = false) {
            let vm = this;
            let adjustPercent = parseInt(vm.header.adjust_percent);

            if (adjustPercent > 100 || adjustPercent < 0) {
                vm.header.adjust_percent = ''
                for (let i in vm.header.lines) {
                    vm.header.lines[i]['adjust_quantity'] = parseInt(vm.header.lines[i]['quantity']);
                }
                return;
            }

            if (line) {

            } else {
                for (let i in vm.header.lines) {
                    if (adjustPercent) {
                        vm.header.lines[i]['adjust_quantity'] = parseInt(vm.header.lines[i]['quantity']) * ((100 + adjustPercent) / 100 )
                    } else {
                        vm.header.lines[i]['adjust_quantity'] = 0;
                    }
                }
            }
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
        async getInfo(hWebId = '') {
            let vm = this;

            let params = {
                h_adj_sale_for_id: hWebId,
            };

            let response = false;
            vm.loading.page = true;
            vm.loading.before_mount = true;
            // vm.selTabName = 'tab1';
            await axios.get(vm.url.index, { params }).then(res => {
                response = res.data.data
                console.log('getInfo', response);
                if (response.status == 'S') {
                    response = response.info
                }
                vm.loading.page = false;
            });

            if (response) {
                vm.data = response.data;
                vm.header = response.header;
                vm.profile = response.profile;
                vm.transBtn = response.transBtn;
                vm.transDate = response.transDate;
                vm.url = response.url;
                // vm.header.blend_no = '369'
            }

            vm.loading.before_mount = false;
            vm.getParam();
            this.getDataInstea({
                action: 'search_instead_item',
                number: '',
            });
        },
        async save(isShowNoti = true) {
            let vm = this;
            let confirm = true;
            let valid = true;
            let message = '';


            let errors = [];
            if (vm.form.tobacco_type_desc == null || vm.form.tobacco_type_desc == '') {
                errors.push('โปรดระบุประเภทยาเส้น')
            }
            if (vm.form.category_code_1 == null || vm.form.category_code_1 == '') {
                errors.push('โปรดระบุประเภทใบยา')
            }
            if (vm.form.category_code_2 == null || vm.form.category_code_2 == '') {
                errors.push('โปรดระบุชนิดใบยา')
            }

            if (vm.form.instead_tobacco_type_desc == null || vm.form.instead_tobacco_type_desc == '') {
                errors.push('โปรดระบุแทนประเภทยาเส้น')
            }
            if (vm.form.instead_category_code_1 == null || vm.form.instead_category_code_1 == '') {
                errors.push('โปรดระบุแทนประเภทใบยา')
            }
            if (vm.form.instead_category_code_2 == null || vm.form.instead_category_code_2 == '') {
                errors.push('โปรดระบุแทนชนิดใบยา')
            }
            if (vm.form.instead_item_id == null || vm.form.instead_item_id == '') {
                errors.push('โปรดระบุแทนด้วยรหัสใบยา')
            }

            let checkListDup = vm.header.lines.filter(o => o.is_select == true && o.item_id == o.instead_item_id && o.lot_number == o.instead_lot_number);
            if (checkListDup.length > 0) {
                errors.push('เนื่องจากผู้ใช้งานเลือกใบยาเดิม และใบยาใหม่เดียวกัน')
            }

            if (errors.length > 0 && !vm.hasSelectDelLine) {
                return showValidationFailedDialog(errors);
                return;
            }

            let confirmMsg = 'กรุณายืนยันบันทึกแทนเกรดใบยา';
            if (vm.hasSelectDelLine) {
                confirmMsg = 'กรุณายืนยันลบรายการใบยาที่ต้องการนำออก';
            }

            confirm = await helperAlert.showProgressConfirm(confirmMsg);
            if (confirm) {
                // vm.loading.page = true;
                // let lines =  vm.lines;
                // let lines =  vm.lines.filter(o => o.is_selected == true);
                vm.loading.search = true;
                await axios.post(vm.url.ajax_store, {
                        form: vm.form,
                        header: vm.header
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

                            setTimeout(async function(){ await vm.search(true); }, 500);
                        }

                        if (data.status != 'S') {
                            swal({
                                title: "Error !",
                                text: data.msg,
                                type: "error",
                                showConfirmButton: true
                            });
                        }
                        vm.loading.search = false;
                })
                .catch(err => {
                    vm.loading.search = false;
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

            }
        },
        async getParam(showLoading = true, clickSearchBtn = false) {
            let vm = this;
            if (showLoading) {
                vm.loading.search = true;
            }
            vm.header.lines = [];

            let params = {
                action:            'search_get_param',
                tobacco_type_desc:  vm.form.tobacco_type_desc,
                category_code_1:    vm.form.category_code_1,
                category_code_2:    vm.form.category_code_2,
                item_id:            vm.form.item_id,
                lot_number:         vm.form.lot_number,
                click_search_btn:   clickSearchBtn,
                // instead_item_id:    vm.form.instead_item_id,
                // instead_lot_number: vm.form.instead_lot_number,
            }

            await axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data.data;
                vm.loading.search = false;
                vm.inputParams.tobacco_type_desc_list   = response.tobacco_type_desc_list;
                vm.inputParams.category_code_1_list     = response.category_code_1_list;
                vm.inputParams.category_code_2_list     = response.category_code_2_list;
                vm.inputParams.item_id_list             = response.item_id_list;
                vm.inputParams.lot_number_list          = response.lot_number_list;
                // vm.inputParams.instead_item_id_list     = response.instead_item_id_list;
                // vm.inputParams.instead_lot_number_list  = response.instead_lot_number_list;
                vm.inputParams.lines_list               = response.lines_list;

                vm.header.lines = vm.inputParams.lines_list;
            });
        },

        async remoteMethodInstea(query) {
            let vm = this;

            vm.form.instead_item_id = '';
            vm.form.instead_lot_number = '';
            vm.inputParams.instead_item_id_list = [];

            if (query !== "") {
                this.getDataInstea({
                    action: 'search_instead_item',
                    number: query,
                });
            }
        },
        async getDataInstea(params) {
            let vm = this;
            params.action = 'search_instead_item';
            params.instead_tobacco_type_desc =  vm.form.instead_tobacco_type_desc;
            params.instead_category_code_1 =    vm.form.instead_category_code_1;
            params.instead_category_code_2 =    vm.form.instead_category_code_2;
            // vm.loading = true;
            vm.loading.search = true;
            await axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data.data

                vm.inputParams.instead_tobacco_type_desc_list   = response.instead_tobacco_type_desc_list;
                vm.inputParams.instead_category_code_1_list     = response.instead_category_code_1_list;
                vm.inputParams.instead_category_code_2_list     = response.instead_category_code_2_list;
                vm.inputParams.instead_item_id_list     = response.instead_item_id_list;
                vm.loading.search = false;
            });
        },
        async changeSelect(line, idx) {
            let vm = this;
            vm.hasSelectDelLine = false;
            if (vm.header.lines.length > 0) {
                let checkList = vm.header.lines.filter(o => o.is_select == true);
                if (checkList.length == 1) {
                    vm.hasSelectDelLine = line.for_delete;
                    if (line.for_delete) {
                        // ให้เลือกได้เฉพาะที่ onhand = 0 และ สัดส่วนในสูตร (%) = 0
                        vm.header.lines.forEach(async function(o, index) {
                            if (o.is_inactive) {
                                o = await vm.assignInput(o);
                                o.is_disabled = !(o.for_delete);
                            }
                        });
                    } else {
                        vm.header.lines.forEach(async function(o, index) {
                            if (o.is_inactive) {
                                o = await vm.assignInput(o);
                                o.is_disabled = o.for_delete;
                            }
                        });
                    }
                } else if (checkList.length > 1) {
                    vm.header.lines.forEach(async function(o, index) {
                        if (o.is_inactive) {
                            o = await vm.assignInput(o);
                        }
                    });
                } else if (checkList.length == 0) {
                    vm.header.lines.forEach(async function(o, index) {
                        if (o.is_inactive) {
                            o = await vm.assignInput(o);
                            o.is_disabled = false;
                        }
                    });
                }
            }
        },
        async assignInput(line) {
            let vm = this;
            line.instead_item_id = '';
            line.instead_item_code = '';
            line.instead_item_desc = '';
            line.instead_lot_number = '';
            line.instead_lot_number_list = [];
            line.instead_onhand_list = [];
            if ( vm.form.instead_item_id != '' && line.is_select ) {
                line.instead_item_id = vm.form.instead_select.instead_item_id;
                line.instead_item_code = vm.form.instead_select.instead_item_code;
                line.instead_item_desc = vm.form.instead_select.instead_item_desc;
                line.instead_lot_number = vm.form.instead_lot_number ? vm.form.instead_lot_number : vm.form.instead_select.instead_lot_number;
                line.instead_lot_number_list = vm.form.instead_select.instead_lot_number_list;
                line.instead_onhand_list = vm.form.instead_select.instead_onhand_list;
            }
            return line;
        },
        async search(clickSearchBtn = false) {
            let vm = this;
            let errors = [];
            if (vm.form.tobacco_type_desc == null || vm.form.tobacco_type_desc == '') {
                errors.push('โปรดระบุประเภทยาเส้น')
            }
            if (vm.form.category_code_1 == null || vm.form.category_code_1 == '') {
                errors.push('โปรดระบุประเภทใบยา')
            }
            if (vm.form.category_code_2 == null || vm.form.category_code_2 == '') {
                errors.push('โปรดระบุชนิดใบยา')
            }

            if (errors.length > 0) {
                return showValidationFailedDialog(errors);
                return;
            }

            await vm.getParam(true, clickSearchBtn)
            $(function () {
              $('[data-toggle="tooltip"]').tooltip({ placement: 'top', container: "body" });
            })
        },
        async changeInsteadItem() {
            let vm = this;
            vm.form.instead_lot_number = '';
            vm.inputParams.instead_lot_number_list = [];
            vm.inputParams.instead_onhand_list = [];
            vm.form.instead_select = {};

            let data = {
                instead_item_id: '',
                instead_item_code: '',
                instead_item_desc: '',
                instead_lot_number: '',
                instead_lot_number_list: [],
                instead_onhand_list: [],
            }
            if (vm.form.instead_item_id) {
                let item = vm.inputParams.instead_item_id_list.findIndex(o => o.value == vm.form.instead_item_id);
                    item = vm.inputParams.instead_item_id_list[item];
                vm.inputParams.instead_lot_number_list = item.lot_list;
                vm.inputParams.instead_onhand_list = item.onhand_list;
                data.instead_item_id           = item.value;
                data.instead_item_code         = item.item_number;
                data.instead_item_desc         = item.item_desc;
                data.instead_lot_number        = '';
                data.instead_lot_number_list   = item.lot_list;
                data.instead_onhand_list       = item.onhand_list;
            }

            vm.form.instead_select = data;

            if (vm.header.lines.length > 0) {
                vm.header.lines.forEach(async function(o, index) {
                    if (o.is_select) {
                        o.instead_item_id           = data.instead_item_id;
                        o.instead_item_code         = data.instead_item_code;
                        o.instead_item_desc         = data.instead_item_desc;
                        o.instead_lot_number        = data.instead_lot_number;
                        o.instead_lot_number_list   = data.instead_lot_number_list;
                        o.instead_onhand_list       = data.instead_onhand_list;
                    }
                })
            }

        },
        async changeInsteadLot() {
            let vm = this;
            if (vm.header.lines.length > 0) {
                vm.header.lines.forEach(async function(o, index) {
                    if (o.is_select) {
                        o.instead_lot_number = vm.form.instead_lot_number;
                    }
                })
            }

        },
        async reset() {
            let vm = this;
            vm.form.tobacco_type_desc =  null;
            vm.form.category_code_1 =  null;
            vm.form.category_code_2 =  null;
            vm.form.item_id =  null;
            vm.form.lot_number =  null;
            vm.form.instead_item_id =  null;
            vm.form.instead_lot_number =  null;
            vm.form.instead_select = {};
            vm.approved_date = null;
            vm.getParam();
        },
        changeOldIngProp(line) {
            let ingredientProp          = parseFloat(line.ingredient_proportions ? line.ingredient_proportions : 0);
            if (parseFloat(line.old_ingredient_proportions ? line.old_ingredient_proportions : 0) > ingredientProp) {
                line.old_ingredient_proportions = ingredientProp
            }

            let oldIngredientProp       = parseFloat(line.old_ingredient_proportions ? line.old_ingredient_proportions : 0);
            let insteadIngProp          = ingredientProp - oldIngredientProp;
                insteadIngProp          = parseFloat(insteadIngProp ? insteadIngProp : 0 ).toFixed(2) * 1;

            line.instead_ingredient_proportions = insteadIngProp;
        }
    }
}
</script>
