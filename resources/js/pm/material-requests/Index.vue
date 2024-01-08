<template>
    <div>
        <div class="ibox float-e-margins" v-loading="loading.lines">
            <modal-search :transDate="transDate"
                    :header="header"
                    :requestStatusList="data.request_status_list"
                    :transBtn="transBtn" :url="url"
                    :countOpenSearch="countOpenSearch" />


            <div class="ibox-content">
                <div class="row">
                    <div class="col-3">
                        <h3 class="no-margins"> การขอเบิกวัตถุดิบนอกแผน </h3>
                    </div>
                    <div class="col-9 text-right">

                        <button :class="transBtn.search.class + ' btn-lg tw-w-25 '"
                           @click="countOpenSearch += 1" >
                            <i :class="transBtn.search.icon"></i>
                            {{ transBtn.search.text }}
                        </button>
                        <button :class="transBtn.create.class + ' btn-lg tw-w-25 mr-2'"
                            @click.prevent="indexPage" >
                            <i :class="transBtn.create.icon"></i>
                            {{ transBtn.create.text }}
                        </button>

                         <button :class="transBtn.save.class + ' btn-lg tw-w-25'"
                            :disabled="!header.can.save"
                            @click.prevent="save">
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>

                        <button v-if="header.request_number == ''"
                            :class="transBtn.print.class + ' btn-lg tw-w-25'"
                            :disabled="true">
                            <i :class="transBtn.print.icon"></i>
                            {{ transBtn.print.text }}
                        </button>

                        <a :href="url.print_pdf" v-else
                            target="_blank"
                            :class="transBtn.print.class + ' btn-lg tw-w-25'">
                            <i :class="transBtn.print.icon"></i>
                            {{ transBtn.print.text }}
                        </a>
                        <button
                            class="btn btn-w-m btn-danger btn-lg"
                            :disabled="!header.can.cancel_transfer"
                            @click.prevent="setStatus('cancelTransfer')">
                            <i class="fa fa-times"></i> ยกเลิกบันทึกใบเบิก
                        </button>

                        <button
                            class="btn btn-success btn-lg"
                            :disabled="!header.can.transfer"
                            @click.prevent="setStatus('confirmTransfer')">
                            <strong>ยืนยันขอโอนวัตถุดิบ</strong>
                        </button>


                        <!-- <button
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
                        </button> -->
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <!-- <pre>{{ validateFrom }}</pre> -->
                <div class="row">
                    <div class="col-lg-6 b-r">
                        <!-- <h3 class="m-t-none m-b">ข้อมูล</h3> -->
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-1">หน่วยงานที่ขอเบิก: </label>
                            <div class="col-lg-6">
                                <input id="lb-1" type="text" class="form-control" name="department_code"
                                       :disabled="true"
                                       :value="header.organization.display"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-2">เลขที่ใบเบิก: </label>
                            <div class="col-lg-6">
                                <input id="lb-2" type="text" class="form-control" name="request_number"
                                       :value="header.request_number"
                                       :disabled="true"
                                       value=""/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right required" for="lb-3">วันที่ขอเบิก: </label>

                            <div class="col-lg-6">
                                <datepicker-th
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="input_date"
                                    id="input_date"
                                    placeholder="โปรดเลือกวันที่"
                                    :disabled="!header.can.edit"
                                    :value="header.request_date_format"
                                    :format="transDate['js-format']"
                                    @dateWasSelected="setdate(...arguments, 'request_date_format')"
                                    />



                                <!-- <input id="lb-3" type="date" class="form-control" autocomplete="off"
                                       name="request_date_format"
                                       :disabled="!canEditRequestDate"
                                       v-model="headerModel.request_date_format"> -->

                                <div v-if="!validateFrom.request_date_format.is_valid">
                                    <span class="form-text m-b-none text-danger">
                                        {{ validateFrom.request_date_format.message }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label :class="'col-lg-4 font-weight-bold col-form-label text-right '+ labelAttr3Class">
                                ประเภทวัตถุดิบ:
                            </label>
                            <div class="col-lg-6">
                                <template v-if="header.attribute2 == 1">
                                <!-- เบิกวัสดุสินเปลือง -->
                                <el-select
                                    v-if="header.objective_code == 3"
                                    style="width: 100%"
                                    placeholder=""
                                    v-model="header.attribute3"
                                    filterable
                                    :disabled="!header.can.edit || header.program_code == 'PMP0027'"
                                    @change="selectAttribute3"
                                    >
                                    <el-option
                                        v-for="item in data.item_cat_code_list"
                                        :key="JSON.stringify(item.item_cat_code)"
                                        :label="item.item_cat_desc"
                                        :value="item.item_cat_code">
                                    </el-option>
                                </el-select>

                                <!-- เบิกเพื่อทดลอง -->
                                <el-select
                                    v-else-if="header.objective_code == 2"
                                    style="width: 100%"
                                    placeholder=""
                                    v-model="header.attribute3"
                                    filterable
                                    :disabled="!header.can.edit || header.program_code == 'PMP0027'"
                                    @change="selectIngredientGroup"
                                    >
                                    <el-option
                                        v-for="item in data.item_cat_for_prod_list"
                                        :key="JSON.stringify(item.item_cat_code)"
                                        :label="item.item_cat_desc"
                                        :value="item.item_cat_code">
                                    </el-option>
                                </el-select>

                                <!-- เบิกเพื่อผลิต -->
                                <el-select
                                    v-else
                                    style="width: 100%"
                                    placeholder=""
                                    v-model="header.ingredient_group"
                                    filterable
                                    :disabled="!header.can.edit || header.attribute2 == 2 || header.program_code == 'PMP0027'"
                                    @change="selectIngredientGroup"
                                    >
                                    <el-option
                                        v-for="item in data.ingredient_group_list"
                                        :key="JSON.stringify(item)"
                                        :label="item.item_classification"
                                        :value="item.item_classification_code">
                                    </el-option>
                                </el-select>
                                </template>




                                <!-- case: 2 -->
                                <template v-else>
                                <!-- เบิกวัสดุสินเปลือง -->
                                <el-select
                                    v-if="header.objective_code == 3"
                                    style="width: 100%"
                                    placeholder=""
                                    v-model="header.attribute3"
                                    filterable
                                    :disabled="!header.can.edit"
                                    @change="selectAttribute3"
                                    >
                                    <el-option
                                        v-for="item in data.item_cat_code_list"
                                        :key="JSON.stringify(item.item_cat_code)"
                                        :label="item.item_cat_desc"
                                        :value="item.item_cat_code">
                                    </el-option>
                                </el-select>

                                <!-- เบิกเพื่อทดลอง -->
                                <el-select
                                    v-else-if="header.objective_code == 2"
                                    style="width: 100%"
                                    placeholder=""
                                    v-model="header.attribute3"
                                    filterable
                                    :disabled="!header.can.edit"
                                    @change="selectAttribute3"
                                    >
                                    <el-option
                                        v-for="item in data.item_cat_for_prod_list"
                                        :key="JSON.stringify(item.item_cat_code)"
                                        :label="item.item_cat_desc"
                                        :value="item.item_cat_code">
                                    </el-option>
                                </el-select>

                                <!-- เบิกเพื่อผลิต -->
                                <el-select
                                    v-else
                                    style="width: 100%"
                                    placeholder=""
                                    v-model="header.ingredient_group"
                                    filterable
                                    :disabled="!header.can.edit || header.attribute2 == 2"
                                    @change="selectIngredientGroup"
                                    >
                                    <el-option
                                        v-for="item in data.ingredient_group_list"
                                        :key="JSON.stringify(item)"
                                        :label="item.item_classification"
                                        :value="item.item_classification_code">
                                    </el-option>
                                </el-select>
                                </template>

                                <div v-if="!validateFrom.attribute3.is_valid">
                                    <span class="form-text m-b-none text-danger">
                                        {{ validateFrom.attribute3.message }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" v-if="header.attribute2 == 1
                            && header.organization.organization_code != 'M03'
                            && !isFmOtherProgram">
                            <template v-if="header.objective_code == 1">
                                <label class="col-lg-4 font-weight-bold col-form-label text-right required">
                                    Blend No.:
                                </label>
                            </template>
                            <template v-else>
                                <label class="col-lg-4 font-weight-bold col-form-label text-right">
                                    Blend No.:
                                </label>
                            </template>
                            <div class="col-lg-6">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="blend_no"
                                    v-model="header.blend_no"
                                    @change="selectInventoryItem('blend_no')"
                                    :disabled="disabledInput.blend_no || !header.can.edit"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in data.blend_no_list"
                                        :key="JSON.stringify(item)"
                                        :label="item"
                                        :value="item">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <template v-if="header.objective_code == 1">
                                <label :class="'col-lg-4 font-weight-bold col-form-label text-right '+ labelItemClass">สินค้าที่จะผลิต: </label>
                            </template>
                            <template v-else>
                                <label class="col-lg-4 font-weight-bold col-form-label text-right">สินค้าที่จะผลิต: </label>
                            </template>
                            <div class="col-lg-6">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="blend_no"
                                    v-model="header.inventory_item_id"
                                    @change="selectInventoryItem('inventory_item_id')"
                                    :disabled="disabledInput.inventory_item_id
                                        || !header.can.edit
                                        || isFmOtherProgram"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in (data.item_list)"
                                        :key="JSON.stringify(item)"
                                        :label="item.display"
                                        :value="item.inventory_item_id">
                                    </el-option>
                                </el-select>
                                <div v-if="!validateFrom.inventory_item_id.is_valid">
                                    <span class="form-text m-b-none text-danger">
                                        {{ validateFrom.inventory_item_id.message }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <template v-if="header.objective_code == 1">
                                <label :class="'col-lg-4 font-weight-bold col-form-label text-right ' + labelReqQtyClass">จำนวนที่สั่งผลิต: </label>
                            </template>
                            <template v-else>
                                <label class="col-lg-4 font-weight-bold col-form-label text-right">จำนวนที่สั่งผลิต: </label>
                            </template>
                            <div class="col-lg-3">
                                <!-- <input class="form-control text-right" type="text"
                                    oninput="validity.valid||(value='');"
                                    :value="numberFormat(header.request_quantity)"
                                    @input="(event) => {
                                        header.request_quantity = stripNonNumber(event.target.value)
                                        if (this.header.request_quantity < 0) {
                                            this.header.request_quantity = 0
                                        }
                                    }"
                                    :disabled="!header.inventory_item_id || (disabledInput.inventory_item_id || !header.can.edit)"
                                    /> -->

                                <vue-numeric
                                    separator=","
                                    v-bind:precision="4"
                                    v-bind:minus="false"
                                    class="form-control text-right"
                                    v-model="header.request_quantity"
                                    :disabled="!header.inventory_item_id || (disabledInput.inventory_item_id || !header.can.edit)"
                                ></vue-numeric>

                                <!-- <input class="form-control text-right" type="number"
                                    min="0"
                                    oninput="validity.valid||(value='');"
                                    @change="changeRequestQuantity"
                                    v-model.number="header.request_quantity"
                                    :disabled="!header.inventory_item_id || (disabledInput.inventory_item_id || !header.can.edit)"
                                    /> -->
                            </div>
                            <div class="col-lg-3">
                                <el-select
                                    v-if="secondaryUomList.length && selectProdItem"
                                    class="text-right"
                                    placeholder=""
                                    filterable
                                    v-model="header.attribute1"
                                    @change="changeRequestQuantity"
                                    :disabled="!header.inventory_item_id || (disabledInput.inventory_item_id || !header.can.edit)"
                                    >
                                    <el-option
                                        v-for="secUom in secondaryUomList"
                                        :key="JSON.stringify(secUom)"
                                        :label="secUom.from_uom.unit_of_measure"
                                        :value="secUom.from_uom_code">
                                    </el-option>
                                </el-select>

                                <input v-else :title="selectProdItem.primary_uom_code" class="form-control"
                                    disabled :value="selectProdItem.product_unit_of_measure" />
                            </div>

                            <div class="col-lg-6 offset-4" v-if="!validateFrom.request_quantity.is_valid">
                                <span class="form-text m-b-none text-danger">
                                    {{ validateFrom.request_quantity.message }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">ผู้ขอเบิก: </label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" autocomplete="off"
                                       disabled="disabled" :value="user.user_name">
                                <!-- <input type="hidden" class="form-control" autocomplete="off"
                                       disabled="disabled" name="user_id" :value="user.user_id">
                                <input type="text" class="form-control" autocomplete="off"
                                       disabled="disabled" :value="user.name"> -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right required">วัตถุประสงค์ในการเบิก: </label>
                            <div class="col-lg-6">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="objective_code"
                                    v-model="header.objective_code"
                                    :disabled="!header.can.edit"
                                    @change="selectObjectiveCode"
                                    filterable>
                                    <el-option
                                        v-for="item in data.objective_code_list"
                                        :key="JSON.stringify(item)"
                                        :label="item.description"
                                        :value="item.lookup_code">
                                    </el-option>
                                </el-select>
                                <!-- <el-select
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
                                </el-select> -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">สถานะขอเบิก: </label>
                            <div class="col-lg-6">
                                <input type="text" readonly disabled
                                    :value="(()=>{
                                        if(header.request_status){
                                            let result = data.request_status_list.find(o => o.lookup_code == header.request_status)
                                            if(result){
                                                return result.description
                                            }
                                        }
                                        return null
                                    })()"
                                    class="form-control">
                                <!-- <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="request_status"
                                    disabled
                                    v-model="header.request_status"
                                    filterable>
                                    <el-option
                                        v-for="item in data.request_status_list"
                                        :key="JSON.stringify(item)"
                                        :label="item.description"
                                        :value="item.lookup_code">
                                    </el-option>
                                </el-select> -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label required text-right">วันที่นำส่ง ยสท.: </label>
                            <div class="col-lg-6">
                                <datepicker-th
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="input_date"
                                    id="input_date"
                                    :disabled="!header.can.edit"
                                    placeholder="โปรดเลือกวันที่"
                                    :value="header.send_date_format"
                                    :format="transDate['js-format']"
                                    :disabledDateTo="disabledSendDateTo"
                                    @dateWasSelected="setdate(...arguments, 'send_date_format')"
                                    />

                                <div v-if="!validateFrom.send_date_format.is_valid">
                                    <span class="form-text m-b-none text-danger">
                                        {{ validateFrom.send_date_format.message }}
                                    </span>
                                </div>
                                <!-- <input type="date" class="form-control" autocomplete="off" name="send_date"
                                       :min="headerModel.request_date_format"
                                       :disabled="!canEditSendDate"
                                       v-model="headerModel.send_date"/> -->
                            </div>
                        </div>

                        <div class="form-group row" v-if="header.attribute2 == 2 && header.inventory_item_id">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">ขั้นตอนการทำงาน: </label>
                            <div class="col-lg-6">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="blend_no"
                                    v-model="header.work_step"
                                    :disabled="disabledInput.inventory_item_id || !header.can.edit"
                                    @change="selectWorkStep"
                                    clearable
                                    filterable
                                    >
                                    <el-option key="" label="ทุกขั้นตอน" value=""> </el-option>
                                    <el-option
                                        v-for="(workStep) in workStepList" v-if="workStep.oprn_no"
                                        :key="JSON.stringify(workStep.oprn_no)"
                                        :label="workStep.oprn_desc"
                                        :value="workStep.oprn_no">
                                    </el-option>
                                </el-select>

                            </div>
                        </div>

                        <div class="form-group row mt-5">
                            <div class="col-lg-10 text-right">
                                <button :class="transBtn.search.class + ' btn-lg tw-w-25 mr-2'"
                                    :disabled="isFmOtherProgram"
                                    @click.prevent="getLines()" >
                                    <i :class="transBtn.search.icon"></i>
                                    <!-- {{ transBtn.search.text }} -->
                                    แสดงข้อมูล
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <pre>{{ header }}</pre> -->


        <div class="ibox float-e-margins" v-loading="loading.lines">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-10 text-left">
                        <!-- <h1>xxxx {{  header.type_code }}</h1> -->
                        <div class="" v-if="data.type_code_list[header.ingredient_group] &&
                           ( header.attribute2 == 1 && header.objective_code) == 1">
                            <el-radio-group v-model="header.type_code" size="large" @change="selectTypeCode">
                                <el-radio label="selectAll" class="mr-0 mb-1" border>
                                    รายการเลือกเบิกทั้งหมด
                                </el-radio>
                                <template v-for="item in (header.ingredient_group ? data.type_code_list[header.ingredient_group] : [])">
                                    <el-radio :label="item.type_code" class="mr-0 mb-1" border>
                                        {{ item.type_desc }}
                                    </el-radio>
                                </template>
                            </el-radio-group>
                        </div>
                        <div class="" v-else>
                            <el-radio-group v-model="header.type_code" size="large" @change="selectTypeCode">
                                <el-radio label="selectAll" class="mr-0 mb-1" border>
                                    รายการเลือกเบิกทั้งหมด
                                </el-radio>
                                <el-radio v-if="!data.type_code_list[header.ingredient_group]" label="selectItemList" class="mr-0 mb-1" border>
                                    รายการค้นหาทั้งหมด
                                </el-radio>
                            </el-radio-group>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="text-right">
                            <transition
                                enter-active-class="animated fadeInUp"
                                leave-active-class="animated fadeOutDown">
                                <!-- header.attribute2 == 1 -->
                                <button v-if="!header.inventory_item_id" :class="transBtn.create.class + ' btn-lg tw-w-25'"
                                    :disabled="!header.can.edit || isFmOtherProgram"
                                    @click.prevent="addNewLine">
                                    <i :class="transBtn.create.icon"></i>
                                    เพิ่มรายการ
                                </button>
                            </transition>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-content">

                <!-- table-responsive -->
                <!-- text-nowrap -->
                <!-- <div class="table-responsive">
                    <table class="table table-bordered text-nowrap"> -->

                <div class="table-responsive m-t">
                    <table class="table text-nowrap table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="10px;"></th>
                                <th width="150px;">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    รหัสวัตถุดิบ
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </th>
                                <th >รายละเอียด</th>
                                <!-- <th v-if="header.organization.organization_code == 'M02' || header.organization.organization_code == 'M03'" width="70px;" class="text-right">Lot</th> -->
                                <th width="100px;" class="text-center">
                                    ปริมาณที่ใช้
                                    <br>+
                                    <br>สูญเสีย
                                </th>
                                <!-- <th width="100px;" class="text-right">คงคลัง<br>ฝ่ายจัดหา</th>
                                <th width="100px;" class="text-right">คงคลัง<br>ฝ่ายผลิต</th>
                                <th width="100px;" class="text-center">ค่าเฝ้าระวัง<br>ต่ำสุด</th> -->
                                <!-- <th width="100px;" class="text-center">ค่าเฝ้าระวัง<br>สูงสุด</th> -->
                                <th width="100px;" class="text-center">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <br>ปริมาณเบิก<br>หลัก<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </th>
                                <th width="100px;" class="text-center">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <br>หน่วยเบิก<br>หลัก<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </th>
                                <th width="100px;" class="text-right">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    ปริมาณเบิก
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </th>
                                <th class="text-center" style="min-width: 150 px;">
                                    หน่วยเบิก
                                </th>
                                <th class="text-center" style="min-width: 150 px;">
                                    หมายเหตุ
                                </th>
                            </tr>

                            <!-- <tr>
                                <th ></th>
                                <th >รหัสวัตถุดิบ</th>
                                <th >รายละเอียด</th>
                                <th  class="text-right">Lot</th>
                                <th  class="text-right">คงคลัง<br>ฝ่ายจัดหา</th>
                                <th  class="text-right">ปริมาณเบิก</th>
                                <th  class="text-right">หน่วยเบิก</th>
                                <th  class="text-right">ปริมาณเบิก</th>
                                <th  class="text-right">หน่วยเบิก</th>
                                <th>หมายเหตุ</th>
                                <th>หมายเหตุ</th>
                                <th>หมายเหตุ</th>
                                <th>หมายเหตุ</th>
                            </tr> -->
                        </thead>
                        <tbody>
                            <tr v-for="(line, i) in lines" v-if="lines.length">
                                <td :date="i" class="align-middle text-center">
                                    <input type="checkbox"
                                        :disabled="!header.can.edit"
                                        v-model="line.is_selected"
                                        @click="selectLine(i, line)">
                                </td>
                                <td>
                                    <template v-if="header.inventory_item_id">
                                        {{ line.item_number }}
                                    </template>
                                    <template v-else>
                                        <div style="display: flex;">
                                            <template v-if="line.is_edit_item && header.can.edit">
                                                <search-item
                                                    :pHeader="pHeader"
                                                    :inventoryItemId="line.inventory_item_id"
                                                    @itemWasSelected="itemWasSelected(...arguments, line)"
                                                    :url="url" />
                                            </template>
                                            <template v-else>
                                                {{ line.item_number }}
                                            </template>

                                            <!-- <template v-if="!line.is_edit_item || !header.can.edit">
                                                <el-input
                                                  placeholder="Please input"
                                                  v-model="line.item_number"
                                                  :disabled="true">
                                                </el-input>

                                                <button v-if="header.can.edit && line.request_line_id"
                                                    type="button"
                                                    @click.prevent="line.is_edit_item = true"
                                                    class="btn btn-outline btn-xs mb-0"
                                                    title="แก้ไข">
                                                        <i :class="transBtn.edit.icon"></i>
                                                </button>
                                            </template>
                                            <template v-if="line.is_edit_item">
                                                <search-item
                                                    :pHeader="pHeader"
                                                    :inventoryItemId="line.inventory_item_id"
                                                    @itemWasSelected="itemWasSelected(...arguments, line)"
                                                    :url="url" />
                                                <button v-if="header.can.edit && line.request_line_id"
                                                    type="button"
                                                    @click.prevent="line.is_edit_item = false"
                                                    class="btn btn-outline btn-xs mb-0"
                                                    title="ยกเลิกแก้ไข" >
                                                        <i class="fa fa-refresh"></i>
                                                </button>
                                            </template> -->
                                        </div>
                                    </template>
                                </td>
                                <td>{{ line.item_desc }}</td>
                                <!-- <td v-if="header.organization.organization_code == 'M02' || header.organization.organization_code == 'M03'" class="text-right">{{ line.lot_number }}</td> -->
                                <td class="text-right">
                                    <!-- {{ line.use_lose_qty }} -->
                                    <strong>
                                        <template v-if="header.attribute2 == 1">
                                            {{ Number(line.use_lose_qty ? parseFloat(line.use_lose_qty) : 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
                                        </template>
                                        <template v-if="header.attribute2 == 2">
                                            {{ Number(line.use_lose_qty ? parseFloat(line.use_lose_qty) : 0).toLocaleString(undefined, { minimumFractionDigits: 5, maximumFractionDigits: 5 }) }}
                                        </template>
                                    </strong>
                                </td>
                                <!-- <td class="text-right">{{ line.sourcing_onhand }}</td>
                                <td class="text-center">{{ line.production_onhand }}</td>
                                <td class="text-center">0</td> -->
                                <!-- <td class="text-center">0</td> -->
                                <td>
                                    <input class="form-control text-right"
                                        type="number"
                                        min="0"
                                        oninput="validity.valid||(value='');"
                                        v-model.number="line.transaction_quantity"
                                        :disabled="!header.can.edit || !line.inventory_item_id || true"
                                        @change="changeQty(i, line, 'transaction_quantity')"
                                        />
                                    <!-- <input
                                        type="number"
                                        v-model.number="line.primaryQty"
                                        @input="
                                            line.isSelected = true
                                            line.secondaryQty = +($event.target.value) / +lodash.get(line, 'item_conv_uom_v.conversion_rate')
                                            hasLinesModified = true
                                        "/> -->
                                </td>
                                <td class="text-right" :title="line.transaction_uom">
                                    {{ line.transaction_uom_desc }}
                                </td>

                                <td>
                                    <input class="form-control text-right" type="number" step="any"
                                        min="0"
                                        oninput="validity.valid||(value='');"
                                        :disabled="!header.can.edit || !line.secondary_uom_list.length"
                                        v-model.number="line.secondary_qty"
                                        @change="changeQty(i, line, 'secondary_qty')"
                                        />

                                    <!-- <input
                                        type="number"
                                        v-model.number="line.secondaryQty"
                                        @input="
                                            line.isSelected = true
                                            line.primaryQty = +($event.target.value) * +lodash.get(line, 'item_conv_uom_v.conversion_rate')
                                            hasLinesModified = true
                                        "/> -->
                                </td>
                                <td :title="line.secondary_uom">
                                    <el-select
                                        class="text-right"
                                        placeholder=""
                                        filterable
                                        v-model="line.secondary_uom"
                                        :disabled="!header.can.edit || !line.secondary_uom_list.length"
                                        @change="changeQty(i, line, 'secondary_uom')"
                                        >
                                        <el-option
                                            v-for="secUom in line.secondary_uom_list"
                                            :key="JSON.stringify(secUom)"
                                            :label="secUom.from_uom.unit_of_measure"
                                            :value="secUom.from_uom_code">
                                        </el-option>
                                    </el-select>

                                    <!-- <el-select
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
                                    </el-select> -->
                                </td>
                                <td>
                                    <el-input
                                        type="textarea"
                                        name="description"
                                        v-model="line.remark_msg"
                                        :disabled="!header.can.edit"
                                        rows="1"
                                        maxlength="240"
                                        show-word-limit
                                        >
                                    </el-input>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center" v-if="lines.length === 0">
                    <span class="lead">No Data.</span>
                </div>
            </div>
        </div>
    </div>
</template>
<!-- url -->
<script>
// import _get from 'lodash/get'
// import _set from 'lodash/set'

import {
    showLoadingDialog,
    showProgressWithUnsavedChangesWarningDialog,
    showValidationFailedDialog,
} from "../../commonDialogs"

import VueNumeric from 'vue-numeric'

import moment from "moment";
import SearchItem from './SearchItem';
import modalSearch from './ModalSearch.vue';

export default {

    components: {
        SearchItem, modalSearch, VueNumeric
    },
    props:[
        "pHeader", "data", 'oldIput', 'transDate', "pRequest",
        "url", "transBtn", "profile"
    ],
    computed: {
        labelAttr3Class() {
            let vm = this;
            let classValue = 'required';
            if (vm.header.case == 2) {
                if (vm.header.objective_code == 1) {
                    if (vm.header.organization.organization_code == 'M12' ||
                        vm.header.organization.organization_code == 'M05' ||
                        vm.header.organization.organization_code == 'MG6' ) {
                        classValue = '';
                    }
                }
            }

            return classValue;
        },
        labelItemClass() {
            let vm = this;
            let classValue = 'required';
            if (vm.header.case == 2) {
                if (vm.header.objective_code == 1) {
                    // if (vm.header.organization.organization_code == 'A12') {
                    //     classValue = '';
                    // }
                }
            }

            if (vm.header.case == 1) {
                if (vm.isFmOtherProgram) {
                    classValue = '';
                }
            }

            return classValue;
        },
        labelReqQtyClass() {
            let vm = this;
            let classValue = 'required';
            if (vm.header.case == 2) {
                if (vm.header.objective_code == 1) {
                    // if (vm.header.organization.organization_code == 'A12') {
                    //     classValue = '';
                    // }
                }
            }

            if (vm.header.case == 1) {
                if (vm.isFmOtherProgram) {
                    classValue = '';
                }
            }


            return classValue;
        },
        secondaryUomList() {
            let vm = this;
            if (vm.header.inventory_item_id) {
                let item = vm.data.item_list.filter(o => o.inventory_item_id == vm.header.inventory_item_id);
                if (item.length) {
                    if (!vm.header.attribute1) {
                        vm.header.attribute1 = item[0].primary_uom_code;
                    }

                    return item[0].secondary_uom_list;
                }
            }
            return [];
        },
        workStepList() {
            let vm = this;
            if (vm.header.inventory_item_id) {
                let item = vm.data.item_list.filter(o => o.inventory_item_id == vm.header.inventory_item_id);
                if (item.length) {
                    console.log('workStepList', item[0]);
                    if (!vm.header.work_step && !vm.header.request_header_id) {
                        vm.header.work_step = '';
                        // Default Value
                        // if (vm.header.work_step = item[0]['work_step_list'].length) {
                        //     vm.header.work_step = item[0]['work_step_list'][0]['oprn_no'];
                        // }
                    }
                    return item[0].work_step_list;
                }
            }
            return [];

        }
        // ingredient_group() {
        //     return this.header.ingredient_group;
        // },
        // type_code() {
        //     return this.header.type_code;
        // },
        // objective_code() {
        //     return this.header.objective_code;
        // },
    },
    watch:{
        // ingredient_group(newValue, oldValue) {
        //     console.log('ingredient_group', ingredient_group);
        // },
        // type_code(newValue, oldValue) {
        //     // this.getLines();
        // },
        // objective_code(newValue, oldValue) {
        //     if (newValue == 3) {}
        // }
    },
    data() {
        return {
            header: this.pHeader,
            user: this.profile,
            countOpenSearch: 0,
            selectProdItem: {},
            lines: [],
            lineAll: [],
            loading: {
                lines: false,
            },
            disabledInput: {
                blend_no: false,
                inventory_item_id: false,
            },
            firstLoad: true,
            linesTh: {},
            updateInput: {},
            validateFrom: {
                request_date_format: { is_valid: true, message: ''},
                attribute3: { is_valid: true, message: ''},
                inventory_item_id: { is_valid: true, message: ''},
                request_quantity: { is_valid: true, message: ''},
                send_date_format: { is_valid: true, message: ''},
            },
            searchParam: {},
            isFmOtherProgram: false,
            disabledSendDateTo: this.pHeader.sysdate,


            // lodash: {
            //     get: _get,
            //     set: _set,
            // },
        }
    },
    beforeMount() {
        console.log('beforeMount');
    },
    mounted() {
        console.log('Component mounted.')
        this.setData();
        this.resetValidate();
    },
    methods: {
        async setData() {
            let vm = this;
            vm.selectObjectiveCode(vm.header.objective_code);
            // vm.selectInventoryItem('blend_no');
            vm.selectInventoryItem('inventory_item_id');
            if ((vm.header.request_header_id != undefined && vm.header.request_header_id != '')) {

                // // setTimeout( vm.getLines(false, 'show'), 5000);
                // setTimeout(await function(){ vm.getLines(false, 'show'); }, 3000);
                vm.getLines(false, 'show');
            }
            vm.firstLoad = false;

            vm.isFmOtherProgram = (vm.header.program_code != '' && vm.header.program_code != 'PMP0005' ) && (vm.header.program_code != '' && vm.header.program_code != 'PMP0032' );
        },
        indexPage() {
            // material_requests_index
            location.href = this.url.material_requests_index;
        },
        async itemWasSelected(item, line) {
            line.inventory_item_id          = item.inventory_item_id;
            line.item_classification_code   = item.item_classification_code;
            line.item_desc                  = item.item_desc;
            line.item_number                = item.item_number;
            line.organization_id            = item.organization_id;
            line.secondary_qty              = item.secondary_qty;
            line.secondary_uom              = item.secondary_uom;
            line.secondary_uom_list         = item.secondary_uom_list;
            line.tobacco_group_code         = item.tobacco_group_code;
            line.tobacco_type_code          = item.tobacco_type_code;
            line.transaction_quantity       = item.transaction_quantity;
            line.transaction_uom            = item.transaction_uom;
            line.transaction_uom_desc       = item.transaction_uom_desc;
            console.log('itemWasSelected(item, line)', item, line);
        },
        async setdate(date, key) {
            let vm = this;
            vm.resetValidate(key)

            let dateValue = await moment(date).format(vm.transDate['js-format']);
            if (dateValue == 'Invalid date') {
                dateValue = '';
            }
            vm.header[key] = dateValue;
            if (key == 'request_date_format') {
                vm.disabledSendDateTo = await moment(date);
                vm.header.send_date_format = dateValue
            }
        },
        async changeRequestQuantity() {

            // changeRequestQuantity
            let vm = this;
            let conversionRate = 0;
            let prodQty = vm.header.inventory_item_id ? vm.header.request_quantity : 0;
            await vm.resetValidate('request_quantity');

            if (vm.header.inventory_item_id) {
                let itemSecUuomList = vm.data.item_list.filter(o => o.inventory_item_id == vm.header.inventory_item_id);
                if (itemSecUuomList.length) {
                    itemSecUuomList = itemSecUuomList[0].secondary_uom_list;
                    itemSecUuomList = itemSecUuomList.filter(o => o.from_uom_code == vm.header.attribute1);
                    if (itemSecUuomList.length) {
                        conversionRate = itemSecUuomList[0].conversion_rate;
                        prodQty = prodQty * conversionRate;
                    } else {
                        prodQty = prodQty * 1;
                    }
                }
            }
            if (vm.lineAll.length) {

                for (let i in vm.lineAll) {
                    // vm.lineAll[i]['use_lose_qty'] = 0;
                    // if (vm.lineAll[i]['is_selected'] == true) {
                        // vm.lineAll[i]['use_lose_qty'] = vm.lineAll[i]['ratio_require_per_unit'] * prodQty;
                    // }

                    if (vm.header.attribute2 == 1) {
                        // if (vm.header.request_quantity) {
                        //     vm.lineAll[i]['use_lose_qty'] = Math.ceil(vm.lineAll[i]['ratio_require_per_unit'] * prodQty);
                        // } else {
                        //     vm.lineAll[i]['use_lose_qty'] = Math.ceil(vm.lineAll[i]['require_qty']);
                        // }
                        // vm.lineAll[i]['use_lose_qty'] = await _.round(Math.round(vm.lineAll[i]['use_lose_qty']), -1);

                        if (vm.header.request_quantity) {
                            vm.lineAll[i]['use_lose_qty'] = (vm.lineAll[i]['ratio_require_per_unit'] * prodQty);
                        } else {
                            vm.lineAll[i]['use_lose_qty'] = (vm.lineAll[i]['require_qty']);
                        }
                        vm.lineAll[i]['use_lose_qty'] = parseFloat(vm.lineAll[i]['use_lose_qty']).toFixed(2);
                    } else {
                        if (vm.header.request_quantity) {
                            vm.lineAll[i]['use_lose_qty'] = vm.lineAll[i]['ratio_require_per_unit'] * prodQty;
                            vm.lineAll[i]['use_lose_qty'] = vm.lineAll[i]['use_lose_qty'].toFixed(5);
                        } else {
                            vm.lineAll[i]['use_lose_qty'] = vm.lineAll[i]['require_qty'];
                        }
                        vm.lineAll[i]['use_lose_qty'] = parseFloat(vm.lineAll[i]['use_lose_qty']).toFixed(5);
                    }
                }
            }

        },
        async selectTypeCode(){
            let vm = this;
            if (vm.lineAll.length) {
                vm.lines = [];
                if (vm.header.type_code == 'selectAll') {
                    vm.lines =  vm.lineAll.filter(o => o.is_selected == true);
                // } else if (vm.header.type_code == 'selectItemList' && vm.header.attribute2 == 2) {
                } else if (vm.header.type_code == 'selectItemList') {
                    vm.lines = vm.lineAll;
                    vm.selectWorkStep();
                } else {

                    if (vm.header.ingredient_group == '02') { // สารปรุงสารหอม
                        vm.lines =  vm.lineAll.filter(o => o.tobacco_ingrident_type == vm.header.type_code);
                    } else {
                        vm.lines =  vm.lineAll.filter(o => o.tobacco_type_code == vm.header.type_code);
                    }
                }
            }
        },
        async selectInventoryItem(inputName) {
            let vm = this;
            let item = false;
            let confirm = await vm.confirmChange(inputName);
            if (!confirm) {
                return;
            }

            await vm.resetValidate('inventory_item_id');


            vm.selectProdItem = {};

            if (inputName == 'blend_no') {
                item = vm.data.item_list.filter(o => o.blend_no == vm.header.blend_no);
                if (item.length) {
                    vm.header.inventory_item_id = item[0]['inventory_item_id'];
                } else {
                    vm.header.blend_no = '';
                    vm.header.inventory_item_id = '';
                }
            }
            if (inputName == 'inventory_item_id') {
                if (vm.header.inventory_item_id) {
                    item = vm.data.item_list.filter(o => o.inventory_item_id == vm.header.inventory_item_id);
                    if (item.length) {
                        vm.header.blend_no = item[0]['blend_no'];
                    }
                } else {
                    vm.header.blend_no = '';
                    vm.header.inventory_item_id = '';
                }
            }

            if (item) {
                vm.selectProdItem = item[0];
            }
            if (!vm.header.blend_no && !vm.header.inventory_item_id) {
                vm.header.request_quantity = '';
            }
        },
        async selectAttribute3() {
            let vm = this;
            if (vm.header.case == 2) {
                if (vm.header.objective_code == 2 || vm.header.objective_code == 3) {
                    if (vm.header.organization.organization_code == 'M05' ||
                        vm.header.organization.organization_code == 'MG6' ) {
                        vm.searchParam = JSON.parse(JSON.stringify(vm.header));
                        return;
                    }
                }
            }
            let confirm = await this.confirmChange('attribute3');
            await this.resetValidate('attribute3');
            if (!confirm) {
                return;
            }
            // vm.getLines();
        },
        async selectIngredientGroup() {
            let confirm = await this.confirmChange('ingredient_group');
            if (!confirm) {
                return;
            }
            let vm = this;
            // vm.getLines();
        },
        async changeQty(index, line, inputName) {
            let vm = this;
            if (inputName == 'transaction_quantity') {
                // line.secondary_qty = '';
            }
            console.log('changeQty', index, line, inputName);

            if (inputName == 'secondary_qty' ) {
                line.transaction_quantity = '';
                let item = line.secondary_uom_list.filter(o => o.from_uom_code == line.secondary_uom);
                if (item.length) {
                    line.transaction_quantity = item[0]['conversion_rate'] * line.secondary_qty ;
                }
            }

            if (inputName == 'secondary_uom' ) {
                let item = line.secondary_uom_list.filter(o => o.from_uom_code == line.secondary_uom);
                if (item.length) {
                    if (line.secondary_qty) {
                        line.transaction_quantity = item[0]['conversion_rate'] * line.secondary_qty ;
                    }
                }
            }


            line.is_selected = false;
            if (line.secondary_qty || line.transaction_quantity) {
                line.is_selected = true;
            }
            this.hasUpdateInput(index, line);
        },
        async selectLine(index, line) {
            line.is_selected = !line.is_selected;
            this.hasUpdateInput(index, line);
            // line.
            // if (true) {}
        },
        async hasUpdateInput(index, line) {
            if (line.is_selected) {
                this.$set(this.updateInput, index, index);
            } else {
                this.$delete(this.updateInput, index)
            }
        },
        async selectWorkStep() {
            let vm = this;
            // เบิกเพื่อผลิต
            if (vm.header.objective_code != 1 || vm.header.attribute2 != 2) {
                return;
            }

            if (vm.header.work_step && vm.header.work_step != '') {
                if (vm.lineAll.length) {
                    vm.lines = vm.lineAll.filter(o => o.work_step == vm.header.work_step);
                }
            } else {
                vm.lines = vm.lineAll
            }
        },
        async selectObjectiveCode(objectiveCode) {
            let vm = this;
            let confirm = await vm.confirmChange();
            if (!confirm) {
                return;
            }
            vm.disabledInput.blend_no = false;
            vm.disabledInput.inventory_item_id = false;
            if (objectiveCode == 3) { // อื่นๆ
                vm.header.blend_no              = '';
                vm.header.inventory_item_id     = '';
                vm.header.attribute1            = ''; //product_uom_code
                vm.header.request_quantity      = '';
                vm.header.ingredient_group      = '';

                vm.disabledInput.blend_no = true;
                vm.disabledInput.inventory_item_id = true;
            } else {
                vm.header.attribute3 = vm.header.attribute3 ? vm.header.attribute3 : '';
            }

            // if (objectiveCode == 2) {
            //     vm.header.ingredient_group      = '';
            //     vm.disabledInput.blend_no = true;
            //     vm.disabledInput.inventory_item_id = true;
            // }

            // if (!vm.firstLoad) {
            //     vm.getLines();
            // }
            if (vm.header.attribute2 == 1) {
                if (objectiveCode == 3 || objectiveCode == 2) { // อื่นๆ, ทดลอง
                    vm.header.blend_no              = '';
                    vm.header.inventory_item_id     = '';
                    vm.header.attribute1            = ''; //product_uom_code
                    vm.header.request_quantity      = '';
                    vm.header.ingredient_group      = '';

                    vm.disabledInput.blend_no = true;
                    vm.disabledInput.inventory_item_id = true;
                } else {
                    vm.header.attribute3 = vm.header.attribute3 ? vm.header.attribute3 : '';
                }
            }
        },
        async addNewLine() {
            let vm = this;
            // let row = Object.keys(vm.lineAll).length;
            let row = vm.lineAll.length;
            let newLine = await _.clone(vm.data.new_line);
            if (vm.header.type_code && vm.header.type_code != 'selectAll') {
                newLine.tobacco_type_code = vm.header.type_code;
            }


            vm.$set(vm.lineAll, row, newLine);
            vm.selectTypeCode();
        },
        async getLines(isShowNoti = true, action = 'search') {
            let vm = this;
            let confirm = true;
            vm.header.type_code = 'selectAll';

            if (isShowNoti && false) {
                confirm = await helperAlert.showProgressConfirm('กรุณายืนยันการค้นหารายการเบิก');
            }

            if (isShowNoti) {
                let vaild = await vm.validateHeader(isShowNoti);
                if (!vaild) { return;}
            }

            // // case 1
            // if (vm.header.attribute2 == 1) {
            //     if (isShowNoti && vm.header.objective_code == 1 && (!vm.header.blend_no || !vm.header.inventory_item_id)) {
            //         await helperAlert.showGenericFailureDialog('กรุณากรอกข้อมูล สินค้าที่จะผลิตหรือ Blend No ');
            //         return;
            //     }
            // }

            // // case 2
            // if (vm.header.attribute2 == 2) {
            //     if (isShowNoti && vm.header.objective_code == 1 && !vm.header.inventory_item_id) {
            //         await helperAlert.showGenericFailureDialog('กรุณากรอกข้อมูลสินค้าที่จะผลิต ');
            //         return;
            //     }
            // }
            // alert('Search')
            // return;

            console.log('getLines', isShowNoti, confirm);

            // if (!vm.firstLoad) {
            //     confirm = await helperAlert.showProgressConfirm('กรุณายืนยันการค้นหารายการเบิก');
            // }

            // if (vm.firstLoad && vm.header.request_header_id != undefined ) {
            //     confirm = true
            //     vm.firstLoad = false;
            // }

            if (confirm) {
            // if (true) {

                vm.loading.lines = true;
                vm.lineAll = [];
                vm.lines = [];

                vm.searchParam = JSON.parse(JSON.stringify(vm.header));

                await axios.get(vm.url.ajax_lines, {
                        params: {
                            blend_no: vm.header.blend_no,
                            inventory_item_id: vm.header.inventory_item_id,
                            ingredient_group: vm.header.ingredient_group,
                            type_code: vm.header.type_code,
                            objective_code: vm.header.objective_code,
                            request_header_id: vm.header.request_header_id,
                            action: action,
                            product_uom_code: vm.header.attribute1,
                            case: vm.header.attribute2,
                            item_cat_code:  vm.header.attribute3,
                        }
                    })
                    .then(res => {
                        let data = res.data.data;
                        // console.log('xx', data.lines);
                        vm.lineAll = data.lines;
                        vm.selectTypeCode();
                        vm.changeRequestQuantity();
                        // if (res.data.data.status != 'S') {
                        //     swal({
                        //         title: "Error !",
                        //         text: res.data.data.msg,
                        //         type: "error",
                        //         showConfirmButton: true
                        //     });
                        // }
                    })
                    .catch(err => {
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading.lines = false;

                        // swal.close();
                    });
            }
            return;
        },
        async save() {
            let vm = this;
            let vaildInput = true;

            // VALIDATE LINES
            const hasMissingInventoryItemId = this.lines.filter(o => o.is_selected && !o.inventory_item_id).length > 0;
            const hasMissingTransactionQuantity = this.lines.filter(o => o.is_selected && o.inventory_item_id && !o.transaction_quantity).length > 0;

            if (hasMissingInventoryItemId || hasMissingTransactionQuantity) {
                let errors = []
                if (hasMissingInventoryItemId) { errors.push('รหัสวัตถุดิบ') };
                if (hasMissingTransactionQuantity) { errors.push('  ปริมาณเบิก') };
                return showValidationFailedDialog(errors);
                return;
            }

            vaildInput = await vm.validateHeader();
            if (!vaildInput) {
                await helperAlert.showGenericFailureDialog('กรุณากรอกข้อมูลให้ครบ/ถูกต้อง ก่อนบันทึก ?');
                return;
            }

            vaildInput = await vm.validateInput()
            if (!vaildInput) {
                await helperAlert.showGenericFailureDialog('กรุณากรอกข้อมูลให้ครบ/ถูกต้อง ก่อนบันทึก ?');
                return;
            }

            let confirm = await helperAlert.showProgressConfirm('กรุณายืนยันบันทึก ?');

            if (confirm) {
                vm.loading.lines = true;

                // let lines = _.pick(vm.lines, Object.keys(vm.updateInput) );
                let lines =  vm.lineAll.filter(o => o.is_selected == true);

                await axios.post(vm.url.ajax_store, {
                        header: vm.header,
                        lines: lines
                    })
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            vm.header = data.header;
                            vm.url.print_pdf = data.url_print_pdf;

                            setTimeout(async function(){ await vm.getLines(false, 'show'); }, 500);
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
                    alert(data.message);
                })
                .then(() => {
                    vm.loading.lines = false;
                    // swal.close();
                });

            }
        },
        async setStatus(status) {

            let vm = this;
            let confirm = false;

            let msg = '';
            if (status == 'confirmTransfer') {
                msg = 'กรุณายืนยันโอนวัตถุดิบ';
            }
            if (status == 'cancelTransfer') {
                msg = 'กรุณายืนยันยกเลิกขอโอนวัตถุดิบ';
            }

            confirm = await helperAlert.showProgressConfirm(msg);

            if (confirm) {
                vm.loading.lines = true;
                let url = vm.url.ajax_set_status;
                if (vm.header.request_header_id != '' && vm.header.request_header_id != undefined) {
                    url = url.replace("-1", vm.header.request_header_id)
                }

                await axios.post(url, {
                        status: status
                    })
                    .then(res => {
                        let data = res.data.data;
                        console.log('xxx', data);
                        if (data.status == 'S') {
                            vm.header.request_status = String(data.request_status)
                            vm.header.can = data.can
                        }
                        if (res.data.data.status != 'S') {
                            swal({
                                title: "Error !",
                                text: res.data.data.msg,
                                type: "error",
                                showConfirmButton: true
                            });
                        }
                    })
                    .catch(err => {
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading.lines = false;
                    });

            }
        },
        async validateHeader(isShowNoti = true) {
            let vm = this;
            let vaild = false;
            await vm.resetValidate();

            // request_date_format
            // inventory_item_id
            // request_quantity
            console.log('request_date_format', vm.header.request_date_format)
            if (!vm.header.request_date_format || vm.header.request_date_format == 'Invalid date') {
                vm.$set(vm.validateFrom, 'request_date_format', {
                    is_valid: false,
                    message: 'กรุณากรอกวันที่ขอเบิก',
                });
                await helperAlert.showGenericFailureDialog(vm.validateFrom.request_date_format.message);
                return false;
            }

            // case 1
            if (vm.header.case == 1) {
                if (isShowNoti && vm.header.objective_code == 1 && !vm.isFmOtherProgram) {
                    if ((!vm.header.blend_no || !vm.header.inventory_item_id)) {
                        vm.$set(vm.validateFrom, 'inventory_item_id', {
                            is_valid: false,
                            message: 'กรุณากรอกข้อมูล สินค้าที่จะผลิตหรือ Blend No',
                        });
                        await helperAlert.showGenericFailureDialog(vm.validateFrom.inventory_item_id.message);
                        return false;
                    }

                    if (vm.header.inventory_item_id && (parseFloat(vm.header.request_quantity ? vm.header.request_quantity : 0) == 0) ) {
                        vm.$set(vm.validateFrom, 'request_quantity', {
                            is_valid: false,
                            message: 'กรุณากรอกจำนวนที่สั่งผลิต',
                        });
                        await helperAlert.showGenericFailureDialog(vm.validateFrom.request_quantity.message);
                        return false;
                    }
                }
            }

            // case 2
            if (vm.header.case == 2) {


                // เลิกเพื่อผลิต
                if (vm.header.objective_code == 1 && !vm.isFmOtherProgram) {

                    if (!vm.header.inventory_item_id && vm.header.organization.organization_code != 'M12') {
                        vm.$set(vm.validateFrom, 'inventory_item_id', {
                            is_valid: false,
                            message: 'กรุณากรอกข้อมูลสินค้าที่จะผลิต',
                        });

                        await helperAlert.showGenericFailureDialog(vm.validateFrom.inventory_item_id.message);
                        return false;
                    }

                    if (vm.header.inventory_item_id && !vm.header.request_quantity) {
                        vm.$set(vm.validateFrom, 'request_quantity', {
                            is_valid: false,
                            message: 'กรุณากรอกจำนวนที่สั่งผลิต',
                        });

                        await helperAlert.showGenericFailureDialog(vm.validateFrom.request_quantity.message);
                        return false;
                    }
                }

                // เบิกเผื่อทดลอง
                if (vm.header.objective_code == 2) {
                    if (!vm.header.attribute3) {
                        vm.$set(vm.validateFrom, 'attribute3', {
                            is_valid: false,
                            message: 'กรุณากรอกประเภทวัตถุดิบ',
                        });
                        await helperAlert.showGenericFailureDialog(vm.validateFrom.attribute3.message);
                        return false;
                    }
                }

                // เบิกวัสดุสิ้นเปลือง
                if (vm.header.objective_code == 3) {
                    if (!vm.header.attribute3) {
                        vm.$set(vm.validateFrom, 'attribute3', {
                            is_valid: false,
                            message: 'กรุณากรอกประเภทวัตถุดิบ',
                        });
                        await helperAlert.showGenericFailureDialog(vm.validateFrom.attribute3.message);
                        return false;
                    }
                }
            }

            if (!vm.header.send_date_format) {
                vm.$set(vm.validateFrom, 'send_date_format', {
                    is_valid: false,
                    message: 'กรุณากรอกวันที่นำส่ง ยสท',
                });
                await helperAlert.showGenericFailureDialog(vm.validateFrom.send_date_format.message);
                return false;
            }

            return true;
        },
        async validateInput() {
            let vaild = true;
            let vm = this;

            if (!vm.header.send_date_format) {
                vaild = false;
                vm.validateFrom.send_date_format.is_valid = false;
                vm.validateFrom.send_date_format.message = 'กรุณากรอกวันที่นำส่ง ยสท';
            }


            let lines =  vm.lineAll.filter(o => o.is_selected == true);
            var valueArr = lines.map(function(item){

                let countItem = lines.findIndex(o => o.inventory_item_id == item.inventory_item_id);
                    countItem = lines[countItem];
                console.log('---', countItem)
            });


            var isDuplicate = lines.some(function(item, idx){
                console.log('xx', item, idx);
            });


            if (false) {
                let lines =  vm.lineAll.filter(o => o.is_selected == true);
                var valueArr = lines.map(function(item){ return item.inventory_item_id });




                var isDuplicate = valueArr.some(function(item, idx){
                    console.log('xx', item, idx);
                    return valueArr.indexOf(item) != idx
                });
                if (isDuplicate) {
                    vaild = false;
                }
            }
            console.log('xx', valueArr, isDuplicate);

            return vaild;
        },
        async confirmChange(key = false) {
            let vm = this;
            let confirmed = true;
            if (!vm.header.attribute2 == 1) {
                return confirmed;
            }

            let confirmNoti;

            if (Object.keys(vm.searchParam).length == 0) {
                return confirmed;
            }

            confirmNoti = await helperAlert.showProgressConfirm('กรุณายืนยันเปลี่ยนแปลงการค้นหา');
            if (confirmNoti) {
                vm.lines = [];
                vm.lineAll = [];

                vm.searchParam = JSON.parse(JSON.stringify(vm.header));
            } else {
                confirmed = false;
                vm.header = JSON.parse(JSON.stringify(vm.searchParam));
            }

            return confirmed;
        },
        async resetValidate(inputName = false) {
            let vm = this;
            let value = { is_valid: true, message: ''};

            if (inputName != '') {
                vm.validateFrom[inputName] = value;
            } else {
                vm.validateFrom.send_date_format = value;
                vm.validateFrom.request_date_format = value;
                vm.validateFrom.inventory_item_id = value;
                vm.validateFrom.request_quantity = value;
                vm.validateFrom.attribute3 = value;
            }
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
    }
}
</script>
