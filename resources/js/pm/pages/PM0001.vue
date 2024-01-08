<!--suppress JSUnresolvedVariable, JSUndeclaredVariable -->
<template>
    <div id="pm0001">
        <!-- <pre>{{ summary_batch }}</pre> -->
        <!-- <pre>{{ form.request_date }}</pre> -->
        <div class="container-fluid">
            <!-- <form @submit.prevent="onSave" @onkeydown.enter.prevent="(e)=>{ return; }"> -->
            <div >
                <!-- <div class="row">
                    <div class="col">
                        <div class="mb-3 float-right">
                            <button type="button" class="btn btn-default btn-lg" @click="openModal">
                                <i class="fa fa-search"></i>&nbsp;ค้นหา
                            </button>
                            <button class="btn btn-success btn-lg"
                                    @click.prevent="clearForm">
                                <i class="fa fa-plus"></i>&nbsp;สร้าง
                            </button>
                            <button type="submit"
                                    class="btn btn-primary btn-lg"
                                    @click.prevent="onSave"
                                    :disabled="relateFieldDataLoading">
                                บันทึก
                            </button>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col">
                        <div class="ibox mb-2">
                            <div class="ibox-title">
                                <h5 class="mb-4">
                                    เปิดคำสั่งการผลิต
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-default btn-lg" @click="openModal">
                                            <i class="fa fa-search"></i>&nbsp;ค้นหา
                                        </button>
                                        <button class="btn btn-success btn-lg mr-5"
                                                @click.prevent="clearForm">
                                            <i class="fa fa-plus"></i>&nbsp;สร้าง
                                        </button>
                                        <button type="submit"
                                                class="btn btn-primary btn-lg"
                                                @click.prevent="onSave"
                                                :disabled="relateFieldDataLoading">
                                            บันทึก
                                        </button>
                                    </div>
                                </h5>
                                <!-- <div class="row">
                                    <div class="col-4">
                                    </div>

                                    <div class="col-8 pull-right">
                                        <button type="button" class="btn btn-default btn-lg" @click="openModal">
                                            <i class="fa fa-search"></i>&nbsp;ค้นหา
                                        </button>
                                        <button class="btn btn-success btn-lg"
                                                @click.prevent="clearForm">
                                            <i class="fa fa-plus"></i>&nbsp;สร้าง
                                        </button>
                                        <button type="submit"
                                                class="btn btn-primary btn-lg"
                                                @click.prevent="onSave"
                                                :disabled="relateFieldDataLoading">
                                            บันทึก
                                        </button>
                                    </div>
                                </div> -->
                            </div>
                            <div class="ibox-content">
                                <div class="form-group row mb-2">
                                    <!-- <label for="department_name" class="col-md-2 col-form-label">หน่วยงาน</label>
                                    <div class="col-sm-4">
                                        <input
                                            id="department_name"
                                            type="text"
                                            :value="user_dept ? user_dept.description : ''"
                                            readonly
                                            :disabled="!isEditableDepartment()"
                                            class="form-control">
                                    </div> -->

                                    <label class="col-md-2 col-form-label">สถานะ</label>
                                    <div class="col-sm-4">
                                        <!--suppress HtmlFormInputWithoutLabel -->
                                        <input
                                            v-if="isCreateMode"
                                            type="text"
                                            :value="defaultRecordType"
                                            readonly
                                            disabled
                                            class="form-control">

                                        <el-select
                                            v-else-if="isEditableStatus()"
                                            placeholder="กรุณาเลือกสถานะ"
                                            filterable
                                            :value="lodash.get(selectedBatchStatusModel, 'description', '')"
                                            value-key="lookup_code"
                                            @change="(value)=>{
                                            console.debug(value, value.lookup_code)
                                            selectedBatchStatusModel = value
                                            form.request_status = value.lookup_code
                                        }">

                                            <el-option
                                                v-for="status in batchStatusList"
                                                :disabled="!isStatusOptionSelectable(status.lookup_code)"
                                                :key="status.lookup_code"
                                                :label="status.description"
                                                :value="status">
                                            </el-option>
                                        </el-select>

                                        <!--suppress HtmlFormInputWithoutLabel -->
                                        <input
                                            v-else
                                            type="text"
                                            :value="lodash.get(selectedBatchStatusModel, 'description', '')"
                                            readonly
                                            disabled
                                            class="form-control">
                                    </div>

                                    <label class="col-sm-2 col-form-label">
                                        วันที่เริ่มแผน <span style="color: red">*</span>
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="col-sm-12 pl-0">
                                            <!-- {{ biweekly_start_date }} -->
                                            <!-- <input disabled type="text" class="form-control" :value="biweekly_start_date"> -->
                                            <ct-datepicker
                                                class="my-1 col-sm-12 form-control"
                                                placeholder="โปรดเลือกวันที่วันที่เริ่มแผน"
                                                :disabled="! isEditableRequestType()"
                                                :enableDate="date => isInRange(date, min_max_date_period.mindate, min_max_date_period.maxdate, true)"
                                                :value="toJSDate(form.start_date, 'yyyy-MM-dd')"
                                                @change="(date) => {
                                                    if(date){
                                                        let requestDate = luxon.DateTime.fromJSDate(date).startOf('day')
                                                        form.start_date = requestDate.toFormat('yyyy-MM-dd')
                                                        form = {...form}
                                                    }else{
                                                        form.start_date = null
                                                        form = {...form}
                                                    }

                                                    this.checkBiweekly(false, true)
                                                }"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">



                                    <label for="batch_no" class="col-md-2 col-form-label">เลขที่คำสั่งผลิต</label>
                                    <div class="col-sm-4">
                                        <input
                                            id="batch_no"
                                            type="text"
                                            v-model="form.batch_no"
                                            readonly
                                            :disabled="!isEditableBatchNo()"
                                            class="form-control">
                                    </div>
                                    <label class="col-sm-2 col-form-label">
                                        วันที่สิ้นสุดแผน <span style="color: red">*</span>
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="col-sm-12 pl-0">
                                            <!-- {{ biweekly_end_date }} -->
                                            <!-- <input disabled type="text" class="form-control" :value="biweekly_end_date"> -->
                                            <ct-datepicker
                                                class="my-1 col-sm-12 form-control"
                                                placeholder="โปรดเลือกวันที่วันที่เริ่มแผน"
                                                :disabled="! isEditableRequestType()"
                                                :enableDate="date => isInRange(date, form.start_date ? form.start_date : min_max_date_period.mindate, min_max_date_period.maxdate, true)"
                                                :value="toJSDate(form.end_date, 'yyyy-MM-dd')"
                                                @change="(date) => {
                                                    if(date){
                                                        let requestDate = luxon.DateTime.fromJSDate(date).startOf('day')
                                                        form.end_date = requestDate.toFormat('yyyy-MM-dd')
                                                        form = {...form}
                                                    }else{
                                                        form.end_date = null
                                                        form = {...form}
                                                    }
                                                }"
                                            />
                                        </div>
                                    </div>










                                    <label class="col-md-2 col-form-label" v-if="false">วันทีสร้างคำสั่งผลิต <span style="color: red">*</span></label>
                                    <div class="col-sm-4" v-if="false">
                                        <!--suppress HtmlFormInputWithoutLabel -->

                                            <!-- :enableDate="date => isInRange(date, luxon.DateTime.now(), null, true)" -->
                                            <!-- :enableDate="date => isInRange(date, min_max_date_period.mindate, min_max_date_period.maxdate, true)" -->
                                            <!-- :enableDate="date => isInRange(date, '2021-07-25', null, true)" -->
                                        <ct-datepicker
                                            v-if="isEditableRequestDate()"
                                            class="my-1 col-sm-12 form-control"
                                            :disabled="true && false"
                                            placeholder="โปรดเลือกวันที่"
                                            :enableDate="date => isInRange(date, min_max_date_period.mindate, min_max_date_period.maxdate, true)"
                                            :value="toJSDate(form.request_date, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                            if(date){
                                                let requestDate = luxon.DateTime.fromJSDate(date).startOf('day')
                                                let todayDate = luxon.DateTime.fromJSDate(min_max_date_period.mindate).startOf('day')
                                                if(requestDate < todayDate){
                                                    requestDate = todayDate
                                                }
                                                form.request_date = requestDate.toFormat('yyyy-MM-dd')
                                                form = {...form}
                                            }else{
                                                form.request_date = null
                                            }
                                            this.checkBiweekly();
                                        }"
                                        />
                                        <input
                                            style="height: 40px;"
                                            v-else
                                            class="form-control"
                                            type="text"
                                            :value="(()=>{
                                            return toThDateString(toJSDate(form.request_date,'yyyy-MM-dd'))
                                            })()"
                                            readonly
                                            disabled>
                                    </div>

                                    <!-- <label class="col-md-2 col-form-label">
                                        ประเภทคำสั่งผลิต&nbsp;
                                    </label>
                                    <div class="col-sm-4">
                                        <el-select
                                            v-if="isEditableRequestType()"
                                            id="request_type"
                                            placeholder=""
                                            value-key="lookup_code"
                                            :value="form.request_type_desc"
                                            filterable
                                            @change="(item)=>{
                                            form.request_type = item.lookup_code
                                            form.request_type_desc = item.description
                                            form = {...form}
                                        }">
                                            <el-option
                                                v-for="item in job_type_list"
                                                :key="JSON.stringify(item)"
                                                :label="item.description"
                                                :value="item">
                                            </el-option>
                                        </el-select>

                                        <input
                                            v-else
                                            type="text"
                                            readonly
                                            disabled
                                            :value="(()=>{
                                            if(form.request_type_desc) return form.request_type_desc

                                            let requestType = lodash.get(form, 'request_type', '')
                                            if(requestType){
                                                let result = job_type_list.find(item => item.lookup_code === form.request_type)
                                                if(result){
                                                    return result.description
                                                }
                                            }
                                            return null
                                        })()"
                                            class="form-control">
                                    </div> -->
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">
                                        สินค้าที่จะผลิต&nbsp;<span style="color: red">*</span>
                                    </label>
                                    <div class="col-sm-4">
                                        <div class="form-row">

                                            <div :class="(organization_code == 'M02' || organization_code == 'MP2')?  'col-sm-6' : 'col-sm-12'">
                                                <el-select
                                                    v-if="isEditableProduct()"
                                                    id="inventory_item_number"
                                                    placeholder=""
                                                    filterable
                                                    clearable
                                                    :value="form.product_item_number"
                                                    @change="(value)=>{
                                                    onSelectInventoryItemId(value.product_item_id)
                                                }">

                                                    <el-option
                                                        v-for="item in product_item_list"
                                                        :key="JSON.stringify(item)"
                                                        :label="`${item.product_item_number}: ${item.product_item_desc}`"
                                                        :value="item">
                                                    </el-option>
                                                </el-select>

                                                <!--suppress HtmlFormInputWithoutLabel -->
                                                <input
                                                    v-else
                                                    type="text"
                                                    :value="form.product_item_number"
                                                    readonly
                                                    disabled
                                                    class="form-control">
                                            </div>
                                            <div v-if="(organization_code == 'M02' || organization_code == 'MP2')" class="col-sm-6">
                                                <el-select
                                                    v-if="isEditableBlendNo()"
                                                    id="product_blend_no"
                                                    placeholder="Blend No"
                                                    v-model="form.blend_no"
                                                    @change="onSelectBlendNo">
                                                    <el-option
                                                        v-for="item in blend_no_list"
                                                        :key="JSON.stringify(item)"
                                                        :label="item.product_blend_no"
                                                        :value="item.product_blend_no">
                                                    </el-option>
                                                </el-select>
                                                <input
                                                    v-else
                                                    type="text"
                                                    v-model="form.blend_no"
                                                    readonly
                                                    disabled
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">รายละเอียด</label>
                                    <div class="col-sm-4">
                                        <!--suppress HtmlFormInputWithoutLabel -->
                                        <input type="text"
                                               v-model="form.product_item_desc"
                                               readonly
                                               disabled
                                               class="form-control">
                                    </div>
                                   
                                </div>
                                <div class="form-group row">
                                    <label for="request_quantity" class="col-md-2 col-form-label">
                                        จำนวนที่สั่งผลิต&nbsp;<span style="color: red">*</span>
                                    </label>
                                    <div class="col-sm-4">
                                        <div class="form-row" style="display: flex; flex-wrap: nowrap;">
                                            <div class="col-sm-6">
                                                <vue-numeric style="height: 40px;"
                                                    :disabled="! isEditableRequestType()"
                                                    placeholder=""
                                                    separator=","
                                                    v-bind:precision="3"
                                                    v-bind:minus="false"
                                                    :class="'form-control  text-right '"
                                                    v-model="form.request_quantity"
                                                ></vue-numeric>
                                                <!-- <input style="height: 40px;"
                                                    id="request_quantity"
                                                    :disabled="!isEditableRequestQuantity()"
                                                    type="text"
                                                    class="form-control text-right"
                                                    autocomplete="off"
                                                    :value="numberFormat(form.request_quantity)"
                                                    @input="(event) => {
                                                    form.request_quantity = stripNonNumber(event.target.value)
                                                    if (this.form.request_quantity < 0) {
                                                        this.form.request_quantity = 0
                                                    }
                                                    form = {...form}
                                                }"> -->
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- @change="(item) => {
                                                    form.request_uom = item.from_uom_code
                                                    form.from_unit_of_measure = item.from_unit_of_measure
                                                    form = {...form}
                                                }" -->

                                                <el-select
                                                    v-if="isEditableRequestUom()"
                                                    filterable
                                                    clearable
                                                    placeholder=""
                                                    :value="form.request_uom"
                                                    :disabled="relateFieldDataLoading || true"
                                                    @change="selectRequestUom()"
                                                    >
                                                        <!-- :label="`${item.from_uom_code}: ${item.from_unit_of_measure}`" -->
                                                    <el-option
                                                        v-for="item in requestUomList"
                                                        :key="item.from_uom_code"
                                                        :label="item.from_unit_of_measure"
                                                        :value="item.from_uom_code">
                                                    </el-option>
                                                </el-select>

                                                <input
                                                    style="height: 40px;"
                                                    v-else
                                                    class="form-control"
                                                    type="text"
                                                    v-model="form.from_unit_of_measure"
                                                    readonly
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <label class="col-sm-2 col-form-label">
                                        หน่วย
                                    </label>

                                    <div class="col-sm-2">
                                        <el-select
                                            v-if="isEditableRequestUom()"
                                            filterable
                                            clearable
                                            placeholder=""
                                            :value="form.request_uom"
                                            :disabled="relateFieldDataLoading"
                                            @change="(item) => {
                                                form.request_uom = item.from_uom_code
                                                form.from_unit_of_measure = item.from_unit_of_measure
                                                form = {...form}
                                            }">

                                            <el-option
                                                v-for="item in requestUomList"
                                                :key="JSON.stringify(item)"
                                                :label="`${item.from_uom_code}: ${item.from_unit_of_measure}`"
                                                :value="item">
                                            </el-option>
                                        </el-select>

                                        <input
                                            v-else
                                            class="form-control"
                                            type="text"
                                            style=""
                                            v-model="form.request_uom"
                                            readonly
                                            disabled>
                                    </div>
                                    <div class="col-sm-2 p-0">
                                        <div class="col-sm-12 pl-0">
                                            <input
                                                :disabled="true"
                                                type="text"
                                                class="form-control"
                                                autocomplete="off"
                                                :value="form.from_unit_of_measure">
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="searchModal" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header" style="display:none;">
                            <h5 class="modal-title"></h5>
                            <button ref="closeModal" type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="searchBatch" v-loading="moduleSearch.loading">
                                <div class="form-inline">
                                    <label class="my-1 m-3" style="width: 100px;">วันที่</label>
                                    <ct-datepicker
                                        class="my-1"
                                        style="width: 200px;"
                                        placeholder="โปรดเลือกวันที่"
                                        :enableDate="date => isInRange(date, null, toJSDate(moduleSearch.plan_start_date_to), true)"
                                        :value="toJSDate(moduleSearch.plan_start_date_from, 'yyyy-MM-dd')"
                                        @change="(date) => {
                                        moduleSearch.plan_start_date_from = jsDateToString(date)
                                        getParam();
                                    }"
                                    />

                                    <label class="my-1 m-3" style="width: 100px;">ถึง</label>
                                    <ct-datepicker
                                        class="my-1"
                                        style="width: 200px;"
                                        placeholder="โปรดเลือกวันที่"
                                        :enableDate="date => isInRange(date, toJSDate(moduleSearch.plan_start_date_from), null, true)"
                                        :value="toJSDate(moduleSearch.plan_start_date_to, 'yyyy-MM-dd')"
                                        @change="(date) => {
                                        moduleSearch.plan_start_date_to = jsDateToString(date)
                                        getParam();
                                    }"
                                    />

                                    <label class="my-1 m-3" style="width: 100px;">สินค้าที่ผลิต</label>
                                    <el-select
                                        style="width: 200px;"
                                        id="inventory_item_id"
                                        placeholder="โปรดเลือกสินค้าที่ผลิต"
                                        clearable
                                        filterable
                                        :value="moduleSearch.inventory_item_id"
                                        @change="(value)=>{
                                        moduleSearch.inventory_item_id = value
                                        getParam();
                                    }">
                                        <el-option
                                            v-for="item in inputParams.inventory_item_id_list"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                        </el-option>
                                    </el-select>

                                </div>
                                <div class="form-inline">
                                    <label class="my-1 m-3" style="width: 100px;">เลขที่คำสั่งผลิต</label>
                                    <el-select
                                        style="width: 200px;"
                                        id="batch_id"
                                        placeholder="โปรดเลือกสินค้าที่ผลิต"
                                        clearable
                                        filterable
                                        :value="moduleSearch.batch_id"
                                        @change="(value)=>{
                                        moduleSearch.batch_id = value
                                        getParam();
                                    }">
                                        <el-option
                                            v-for="item in inputParams.batch_id_list"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                        </el-option>
                                    </el-select>

                                    <label class="my-1 m-3" style="width: 100px;">สถานะ</label>
                                        <el-select
                                            style="width: 200px;"
                                            id="web_batch_status_code"
                                            placeholder="โปรดเลือกสินค้าที่ผลิต"
                                            clearable
                                            filterable
                                            :value="moduleSearch.web_batch_status_code"
                                            @change="(value)=>{
                                            moduleSearch.web_batch_status_code = value
                                            getParam();
                                        }">
                                            <el-option
                                                v-for="item in inputParams.web_batch_status_code_list"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                </div>

                                <div class="col-12">
                                    <div class="text-right m-3">
                                        <button
                                            :disabled="searching"
                                            type="button"
                                            class="btn btn-default ml-4"
                                            @click.prevent="onClearSearchFormClicked">
                                            <i class="fa fa-undo"></i>
                                            ล้างค่า
                                        </button>

                                        <button
                                            :disabled="searching"
                                            type="submit"
                                            class="btn btn-default ml-4">
                                            <i class="fa fa-search"></i>
                                            ค้นหา
                                        </button>
                                    </div>
                                </div>


                                <div class="form-inline" v-if="false">

                                    <label class="my-1 m-3" for="search_batch_no"
                                           style="width: 100px;">เลขที่คำสั่งผลิต</label>

                                    <db-lookup
                                        style="width: 200px;"
                                        id="search_batch_no"
                                        table-name="PtpmSummaryBatchVLookup"
                                        key-field="batch_id"
                                        label-pattern="{$}"
                                        :label-fields="['batch_no']"
                                        selected-label-pattern="{$}"
                                        :selected-label-fields="['batch_no']"
                                        :search-keys="['batch_no']"
                                        :value="search.batch_no"
                                        :max-results="20"
                                        :preFetch="true"
                                        @change="(value)=>{
                                        search.batch_id = value.batch_id
                                        search.batch_no = value.batch_no
                                    }">
                                    </db-lookup>

                                    <label class="my-1 m-3" style="width: 100px;">สินค้าที่ผลิต</label>

                                    <el-select
                                        style="width: 200px;"
                                        id="inventory_item_id"
                                        placeholder="โปรดเลือกสินค้าที่ผลิต"
                                        clearable
                                        filterable
                                        :value="search.product_item_number"
                                        @change="(value)=>{
                                        search.inventory_item_id = value.product_item_id
                                        search.product_item_number = value.product_item_number

                                        onSelectInventoryItemId(value.product_item_id)
                                    }">

                                        <el-option
                                            v-for="item in product_item_list"
                                            :key="JSON.stringify(item)"
                                            :label="`${item.product_item_number}: ${item.product_item_desc}`"
                                            :value="item">
                                        </el-option>
                                    </el-select>

                                    <label class="my-1 m-3"
                                           style="width: 100px;">สถานะ</label>
                                    <el-select
                                        filterable
                                        placeholder="กรุณาเลือกสถานะ"
                                        :value="lodash.get(selectedSearchBatchStatusModel, 'description', '')"
                                        @change="(value)=>{
                                        selectedSearchBatchStatusModel = value
                                        search.web_batch_status_code = value.lookup_code
                                    }">

                                        <el-option
                                            v-for="status in batch_status_list"
                                            :key="status.lookup_code"
                                            :label="status.description"
                                            :value="status">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div class="form-inline" v-if="false">

                                    <label class="my-1 m-3" style="width: 100px;">วันที่</label>

                                    <ct-datepicker
                                        class="my-1"
                                        style="width: 200px;"
                                        placeholder="โปรดเลือกวันที่"
                                        :enableDate="date => isInRange(date, null, toJSDate(search.plan_start_date_to), true)"
                                        :value="toJSDate(search.plan_start_date_from, 'yyyy-MM-dd')"
                                        @change="(date) => {
                                        search.plan_start_date_from = jsDateToString(date)
                                        search = {...search}
                                    }"
                                    />

                                    <label class="my-1 m-3"
                                           style="width: 100px;">ถึง</label>

                                    <ct-datepicker
                                        class="my-1"
                                        style="width: 200px;"
                                        placeholder="โปรดเลือกวันที่"
                                        :enableDate="date => isInRange(date, toJSDate(search.plan_start_date_from), null, true)"
                                        :value="toJSDate(search.plan_start_date_to, 'yyyy-MM-dd')"
                                        @change="(date) => {
                                        search.plan_start_date_to = jsDateToString(date)
                                        search = {...search}
                                    }"
                                    />

                                </div>
                                <div class="col-12" v-if="false">
                                    <div class="text-right m-3">
                                        <button
                                            :disabled="searching"
                                            type="button"
                                            class="btn btn-default ml-4"
                                            @click.prevent="onClearSearchFormClicked">
                                            <i class="fa fa-undo"></i>
                                            ล้างค่า
                                        </button>

                                        <button
                                            :disabled="searching"
                                            type="submit"
                                            class="btn btn-default ml-4">
                                            <i class="fa fa-search"></i>
                                            ค้นหา
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div v-if="searching" class="lead text-center">
                                กำลังค้นหา
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                            <table class="table" v-if="!searching">
                                <thead>
                                <tr>
                                    <th scope="col">เลขที่คำสั่งผลิต</th>
                                    <th scope="col">สินค้าที่ผลิต</th>
                                    <th scope="col">รายละเอียด</th>
                                    <th scope="col">จำนวนที่ผลิต</th>
                                    <th scope="col">หน่วยนับ</th>
                                    <th scope="col">วันที่เริ่มผลิต</th>
                                    <th scope="col">สถานะคำสั่งการผลิต</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(row,i) in summaryBatchVList"
                                    :key="JSON.stringify(row)"
                                    @click="showSummaryBatchV(row)"
                                    style="cursor: pointer">
                                    <td>{{ row.batch_no }}</td>
                                    <td>{{
                                            (function () {
                                                let data = product_item_list.filter(item => item.product_item_id ===
                                                    row.inventory_item_id)
                                                return data.length > 0 ? data[0].product_item_number : row.inventory_item_id
                                            })()
                                        }}
                                    </td>
                                    <td>{{ row.item_desc }}</td>
                                    <td>{{ row.plan_qty }}</td>
                                    <td>{{ row.dtl_um }}</td>
                                    <td>{{
                                            // +row.web_batch_status_code === STATUS_EDITING ?
                                            //     toThDateString(luxon.DateTime.fromSQL(row.plan_start_date).toJSDate(), 'yyyy-MM-dd')
                                            //     :
                                            //     toThDateString(luxon.DateTime.fromSQL(row.actual_start_date).toJSDate(),
                                            //         'yyyy-MM-dd')
                                            toThDateString(luxon.DateTime.fromSQL(row.plan_start_date).toJSDate(),
                                                     'yyyy-MM-dd')
                                        }}
                                    </td>
                                    <td>{{ row.web_batch_status }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!--                <div class="form-group row">-->
            <!--                    <pre class="col-lg-4" style="display: block">{{-->
            <!--                            JSON.stringify({-->
            <!--                                product_item_list,-->
            <!--                                blend_no_list,-->
            <!--                                job_type_list,-->
            <!--                                summaryBatchVList,-->

            <!--                            }, null, 2)-->
            <!--                        }}-->
            <!--                    </pre>-->

            <!--                    <pre class="col-lg-4" style="display: block">{{-->
            <!--                            JSON.stringify({-->
            <!--                                form,-->
            <!--                                search,-->
            <!--                                mfgFormulaV,-->
            <!--                                summary_batch,-->
            <!--                                batch_status_list,-->

            <!--                            }, null, 2)-->
            <!--                        }}-->
            <!--                    </pre>-->

            <!--                    <pre class="col-lg-4" style="display: block">{{-->
            <!--                            JSON.stringify({-->
            <!--                                status: {-->
            <!--                                    isCreateMode,-->
            <!--                                    isEditMode,-->
            <!--                                    isStatus1,-->
            <!--                                    isStatus2,-->
            <!--                                    isStatus3,-->
            <!--                                    isStatus4,-->
            <!--                                    isStatus5,-->
            <!--                                },-->
            <!--                                requestUomList,-->
            <!--                            }, null, 2)-->
            <!--                        }}-->
            <!--                    </pre>-->
            <!--                </div>-->
        </div>
    </div>
</template>
<script>
import VueNumeric from 'vue-numeric';

import {
    showGenericFailureDialog,
    showLoadingDialog,
    showSaveSuccessDialog,
    showValidationFailedDialog,
} from "../../commonDialogs"
import {DateTime} from 'luxon';
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'
import {instance as http} from "../httpClient"

import {
    $route,
    api_pm_productionOrder_search,
    api_pm_productionOrder_store,
    api_pm_productionOrder_uom,
    api_pm_productionOrder_update,
} from "../../router"

import _find from "lodash/find"
import _get from 'lodash/get'
import _isEmpty from 'lodash/isEmpty'
import _cloneDeep from 'lodash/cloneDeep'
import {buildValidatingEntry, validateDataAgainstRules} from "../../validatorUtils";


import moment from "moment";

const MODE_CREATE = 'create'
const MODE_EDIT = 'edit'

const STATUS_EDITING = 1
const STATUS_IN_PRODUCTION = 2
const STATUS_CANCELLED = 3
const STATUS_FINISHED = 4
const STATUS_CLOSED = 5

function searchBatch(query) {
    return http.get($route(api_pm_productionOrder_search), {params: query}).then(({data}) => {
        return data
    })
}

function searchUom(organization_id, inventory_item_id) {
    return http.get($route(api_pm_productionOrder_uom), {
        params: {
            organization_id, inventory_item_id
        }
    }).then(({data}) => {
        return data
    })
}

function createBatch(processRequest) {
    return http.post($route(api_pm_productionOrder_store), {processRequest}).then(({data}) => {
        return data
    })
}

function updateBatch(processRequest) {
    return http.put($route(api_pm_productionOrder_update), {processRequest}).then(({data}) => {
        return data
    })
}

function redirectIndex(batch_no = null) {
    if (batch_no === null) {
        window.location = `/pm/production-order`
    } else {
        window.location = `/pm/production-order/${batch_no}`
    }
}

function toDateFormatString(d) {
    let month = `${d.getMonth() + 1}`
    let date = `${d.getDate()}`
    return `${d.getFullYear()}-${month.padStart(2, '0')}-${date.padStart(2, '0')}`
}

const defaultCreateForm = {
    request_status: '2',
}

export default {
    components: {
       VueNumeric
    },
    mounted() {
        this.checkBiweekly();
        // this.checkBiweekly2();
        if (this.summary_batch) {
            this.setFormData(this.summary_batch)
        }
    },
    watch: {
        "form.request_date": function (newValue) {
            // this.checkBiweekly();
        },
        // "form.biweekly_id": function (newValue) {
        //     this.checkBiweekly2();
        // },
    },
    props: {
        default_data: {type: Object},
        batch_no: {type: String},
        summary_batch: {type: Object},
        job_type_list: {type: Array},
        batch_status_list: {type: Array},
        product_item_list: {type: Array},
        blend_no_list: {type: Array},
        user_dept: {type: Object},
        biweekly: {type: Array},
        default_biweekly: {type: String},
        min_max_date_period: {type: Object},
        organization_code: {type: String},
    },
    data() {
        return {
            firstLoad: true,
            console,

            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,

            luxon: {
                DateTime,
            },

            lodash: {
                get: _get,
                isEmpty: _isEmpty,
            },

            const: {
                STATUS_EDITING,
                STATUS_IN_PRODUCTION,
                STATUS_CANCELLED,
                STATUS_FINISHED,
                STATUS_CLOSED,
            },

            toDateFormatString,
            mode: MODE_CREATE,
            searching: false,
            mfgFormulaV: {
                organization_id: null,
                inventory_item_id: null,
            },
            requestUomList: [],
            form: {
                ...defaultCreateForm,
                request_type: _get(this.summary_batch, 'job_type_code'),
                request_date: _get(this.summary_batch, 'actual_start_date', toDateFormatString(new Date())),
                // request_date: _get(this.summary_batch, 'plan_start_date', toDateFormatString(new Date())),
                request_uom: _get(this.summary_batch, 'dtl_um'),
                biweekly_id: this.default_biweekly,
                start_date: _get(this.summary_batch, 'start_date'),
                end_date: _get(this.summary_batch, 'end_date'),
            },
            search: {
                batch_id: null,
                inventory_item_id: null,
                // actual_start_date_from: null,
                // actual_start_date_to: null,
                plan_start_date_from: null,
                plan_start_date_to: null,
                web_batch_status_code: null,
            },
            batchStatusList: _cloneDeep(this.batch_status_list),
            selectedBatchStatusModel: {},
            selectedSearchBatchStatusModel: {},
            summaryBatchVList: [],
            searchSummaryBatchVList: [],
            relateFieldDataLoading: false,

            biweekly_start_date: '',
            biweekly_end_date: '',

            moduleSearch: {
                loading: false,
                plan_start_date_from: new Date(),
                plan_start_date_to: null,
                inventory_item_id: null,
                web_batch_status_code: null,
                batch_id: null,
            },
            inputParams: {
                inventory_item_id_list: [],
                web_batch_status_code_list: [],
                batch_id_list: [],
            },
            inputForm: {

            }
        }
    },
    computed: {
        formattedRequestNumber() {
            return '123654'
            // return this.numberWithCommas(this.form.request_quantity)
        },
        isCreateMode() {
            return this.mode === MODE_CREATE
        },
        isEditMode() {
            return this.mode === MODE_EDIT
        },
        defaultRecordType() {
            // let first = this.batch_status_list.filter(item => item.lookup_code === '1')[0]
            // console.log('defaultRecordType', first)
            // return _get(first, 'meaning', '')
            // note: MCR ask for remove status text if in create mode (but submit value still the same)
            return ''
        },

        // แก้ไข/ปรับปรุง
        isStatus1() {
            return +this.form.request_status === 1
        },
        isStatusDb1() {
            return +_get(this.summary_batch, 'web_batch_status_code') === 1
        },

        // กำลังผลิต
        isStatus2() {
            return +this.form.request_status === 2
        },
        isStatusDb2() {
            return +_get(this.summary_batch, 'web_batch_status_code') === 2
        },

        // ยกเลิกคำสั่งผลิต
        isStatus3() {
            return +this.form.request_status === 3
        },
        isStatusDb3() {
            return +_get(this.summary_batch, 'web_batch_status_code') === 3
        },

        // ผลิตเสร็จ
        isStatus4() {
            return +this.form.request_status === 4
        },
        isStatusDb4() {
            return +_get(this.summary_batch, 'web_batch_status_code') === 4
        },

        // ปิดคำสั่งการผลิต
        isStatus5() {
            return +this.form.request_status === 5
        },
        isStatusDb5() {
            return +_get(this.summary_batch, 'web_batch_status_code') === 5
        },
    },
    methods: {
        // checkBiweekly2() {
        //     let vm = this;
        //     let data = vm.biweekly.find(item => item.biweekly_id === vm.form.biweekly_id);

        //     vm.biweekly_start_date = '';
        //     vm.biweekly_end_date = '';
        //     vm.form.request_date = '';
        //     if (data) {
        //         vm.biweekly_start_date = data.start_date_format;
        //         vm.biweekly_end_date = data.end_date_format;
        //         vm.form.request_date = data.start_date;
        //     }

        //     return;
        // },
        async checkBiweekly(checkFmDate = true, checkToDate = true ) {
            let fromFormat = 'yyyy-MM-DD';
            let toFormat = 'yyyyMMDD';
            // let requestDate = JSON.parse(JSON.stringify(this.form.request_date));
            let requestDate = this.form.start_date ? this.form.start_date : JSON.parse(JSON.stringify(this.form.request_date));

            requestDate = moment(requestDate, fromFormat).format(toFormat);
            let data = await _.filter(this.biweekly, function(o) {
                let startDate = moment(o.start_date, fromFormat).format(toFormat);
                let endDate = moment(o.end_date, fromFormat).format(toFormat);
                if (requestDate >= startDate && requestDate <= endDate) {
                    return o;
                }
            });

            this.biweekly_start_date = '';
            this.biweekly_end_date = '';
            if (data.length > 0) {
                this.biweekly_start_date = data[0].start_date_us;
                this.biweekly_end_date = data[0].end_date_us;

            }
            // this.form.start_date = this.form.request_date ? this.form.request_date : this.biweekly_start_date;
            if (checkFmDate) {
                this.form.start_date = this.biweekly_start_date;
            }
            if ((this.batch_no == '' || this.batch_no == null)) {
                this.form.end_date = this.biweekly_end_date;
            } else {
                if (this.firstLoad) {
                    this.form.end_date = _get(this.summary_batch, 'end_date');
                    this.form.start_date = _get(this.summary_batch, 'start_date');
                    this.firstLoad = false;
                } else {
                    this.form.end_date = this.biweekly_end_date;
                    if (checkToDate) {
                        this.form.end_date = this.biweekly_end_date;
                    }
                }
            }
        },
        selectRequestUom(){
            let vm = this;

            let data = _.filter(vm.requestUomList, function(o) {
                return o.from_uom_code == vm.form.request_uom;
            });

            if (data.length > 0) {
                vm.form.request_uom = data[0].from_uom_code
                vm.form.from_unit_of_measure = data[0].from_unit_of_measure
            } else {
                vm.form.request_uom = ''
                vm.form.from_unit_of_measure = ''
            }
        },
        isStatusOptionSelectable(status) {
            let isEnabled = true

            // STATUS_EDITING,
            //     STATUS_IN_PRODUCTION,
            //     STATUS_CANCELLED,
            //     STATUS_FINISHED,
            //     STATUS_CLOSED,

            //disabled all options
            if (this.isStatusDb3 || this.isStatusDb5) {
                isEnabled = false
            }

            if (this.isStatusDb1) {
                isEnabled = +status === STATUS_EDITING ||
                    +status === STATUS_IN_PRODUCTION ||
                    +status === STATUS_CANCELLED
            }

            if (this.isStatusDb2) {
                isEnabled = +status === STATUS_EDITING ||
                    +status === STATUS_IN_PRODUCTION ||
                    +status === STATUS_FINISHED
            }

            if (this.isStatusDb4) {
                isEnabled = +status === STATUS_IN_PRODUCTION ||
                    +status === STATUS_FINISHED ||
                    +status === STATUS_CLOSED
            }
            return isEnabled
        },

        isEditableDepartment() {
            return false
        },
        isEditableStatus() {
            if (this.isCreateMode) return false
            if (this.isStatusDb3 || this.isStatusDb5) return false

            // noinspection RedundantIfStatementJS
            if (this.isEditMode) {
                return true
            }
            return false
        },
        isEditableBatchNo() {
            return false
        },
        isEditableRequestType() {
            if (this.isStatusDb3 || this.isStatusDb4 || this.isStatusDb5) return false
            if (this.isCreateMode) return true
            if (this.isEditMode) {
                // return this.isStatus1
                return this.isStatusDb1
            }
            return false
        },
        isEditableProduct() {
            return this.isCreateMode
        },
        isEditableBlendNo() {
            return this.isCreateMode
        },
        isEditableRequestDate() {
            if (this.isStatusDb3 || this.isStatusDb4 || this.isStatusDb5) return false
            if (this.isCreateMode) return true
            if (this.isEditMode) {
                return this.isStatusDb1
                // return this.isStatus1
            }
            return false
        },
        isEditableRequestQuantity() {
            if (this.isStatusDb3 || this.isStatusDb4 || this.isStatusDb5) return false
            if (this.isCreateMode) return true
            if (this.isEditMode) {
                return this.isStatusDb1
                // return this.isStatus1
            }
            return false
        },
        isEditableRequestUom() {
            return this.isEditableRequestQuantity()
        },
        clearForm() {
            this.mode = MODE_CREATE
            this.form = {...defaultCreateForm}
            showLoadingDialog()
            redirectIndex()
        },
        validateData() {
            console.debug('validating...');

            let validationRules = {
                request_status: "required",
                inventory_item_id: 'required',
                // request_type: 'required',
                request_quantity: 'required',
                // request_date: 'required',
                // biweekly_id: 'required',

                start_date: 'required',
                end_date: 'required',
            }

            let attributesNames = {
                request_status: 'สถานะ',
                inventory_item_id: 'รหัสสินค้าที่จะผลิต',
                request_type: 'ประเภทคำสั่งผลิต',
                request_quantity: 'จำนวนที่สั่งผลิต',
                request_date: 'วันที่เริ่มผลิต',
                // biweekly_id: 'ปักษ์ที่',
                start_date: 'วันที่เริ่มแผน',
                end_date: 'วันที่สิ้นสุดแผน',
            };

            let validatingEntry = buildValidatingEntry(this.form, validationRules, attributesNames)
            return validateDataAgainstRules([validatingEntry]);
        },
        onSave() {
            console.debug('onSave')

            showLoadingDialog()

            let validatingResult = this.validateData()
            if (!validatingResult.status) {
                showValidationFailedDialog(validatingResult.errorMessages);
                return
            }

            let processRequest = {...this.form}
            let req
            if (this.isEditMode) {
                req = updateBatch(processRequest)
            } else {
                req = createBatch(processRequest)
            }

            req.then((res) => {
                //swal.close()
                console.log('createBatch', res)
                let batch_no = res.processRequest.request_number

                console.log('createBatch batch_no', batch_no)

                let ok = res.response.v_status === 'S' || res.processRequest.interface_status === 'S'
                if (ok) {
                    showSaveSuccessDialog()
                        .then((res) => {
                            showLoadingDialog()
                            redirectIndex(batch_no)
                        })
                } else {
                    showGenericFailureDialog(res.response.v_err_msg)
                }
            }).catch(async (err) => {
                swal.close()
                console.error('createBatch', err)
                showGenericFailureDialog(err.toString())
            })
        },
        async searchBatch() {
            this.searching = true;
            this.summaryBatchVList = this.searchSummaryBatchVList;
            this.searching = false;
            return;
            this.searching = true
            // searchBatch(this.search).then(result => {
            searchBatch(this.moduleSearch).then(result => {
                this.searching = false
                console.log(result)
                this.summaryBatchVList = result.summaryBatch
            }).catch(err => {
                this.searching = false
            })
        },
        async onClearSearchFormClicked() {
            //clear form
            this.search = {
                batch_id: "",
                inventory_item_id: "",
                // actual_start_date_from: {},
                // actual_start_date_to: {},
                plan_start_date_from: {},
                plan_start_date_to: {},
                web_batch_status_code: "",
            }
            this.search = {...this.search}

            this.selectedSearchBatchStatusModel = {};

            //clear previous results
            this.summaryBatchVList = [];

            this.moduleSearch = {
                loading: false,
                plan_start_date_from: null,
                plan_start_date_to: null,
                inventory_item_id: null,
                web_batch_status_code: null,
                batch_id: null,
            };
            this.getParam();
        },
        showSummaryBatchV(row) {
            console.debug('showSummaryBatchV', row)

            $('#searchModal').modal('hide')
            showLoadingDialog()
            redirectIndex(row.batch_no)
        },
        setFormData(data) {
            this.mode = MODE_EDIT
            let status = _get(data, 'web_batch_status_code', STATUS_IN_PRODUCTION)

            this.form = {
                ...this.form,
                organization_id: data.organization_id,
                batch_no: data.batch_no,
                inventory_item_id: data.inventory_item_id,
                product_item_number: data.product_item_number,
                product_item_desc: data.product_item_desc,
                request_uom: data.dtl_um,
                request_quantity: data.plan_qty,
                from_unit_of_measure: data.from_unit_of_measure,

                request_status: status ? status : STATUS_IN_PRODUCTION,

                request_type_db: data.job_type_code,
                request_type: data.job_type_code,
                request_type_desc: data.job_type,

                blend_no: data.blend_no,
                request_date: data.actual_start_date ? toDateFormatString(new Date(
                    // +data.web_batch_status_code === STATUS_EDITING ?
                    //     data.plan_start_date :
                    //     data.actual_start_date
                    data.actual_start_date
                )) : null,
            }
            this.requestUomList = _get(data, 'uom_list', [])
            this.selectedBatchStatusModel = _find(this.batch_status_list, (status) => {
                return +status.lookup_code === +this.form.request_status
            })

            if (this.form.organization_id && this.form.inventory_item_id) {
                searchUom(this.form.organization_id, this.form.inventory_item_id)
                    .then((result) => {
                        console.debug('searchUom success', result)

                        this.relateFieldDataLoading = false
                        this.requestUomList = result.uom
                        this.setDefaultUom()

                    })
                    .catch(err => {
                        console.debug('searchUom error', err)
                        this.relateFieldDataLoading = false
                    })
            }
        },
        onSelectInventoryItemId(key) {
            console.log('onSelectInventoryItemId', {key})
            // key may be empty when input is cleared
            if (_isEmpty(key)) {
                this.form.inventory_item_id = null

                this.form.product_item_number = null
                this.form.product_item_desc = null
                this.form.organization_id = null
                this.form.blend_no = null
                this.form.request_uom = null
                this.form.request_quantity = null
                this.form.from_unit_of_measure = null
                this.form.request_status = STATUS_IN_PRODUCTION

                this.mfgFormulaV.organization_id = null
                this.mfgFormulaV.inventory_item_id = null
                return
            }

            let row = this.product_item_list.filter(item => item.product_item_id === key)[0]

            this.form.inventory_item_id = row.product_item_id

            this.form.product_item_number = row.product_item_number
            this.form.product_item_desc = row.product_item_desc
            this.form.organization_id = row.organization_id
            this.form.blend_no = row.product_blend_no
            this.form.request_uom = row.product_uom_code
            this.form.request_quantity = null
            this.form.from_unit_of_measure = null

            this.mfgFormulaV.organization_id = null
            this.mfgFormulaV.inventory_item_id = null

            this.mfgFormulaV.organization_id = row.organization_id
            this.mfgFormulaV.inventory_item_id = row.product_item_id

            this.relateFieldDataLoading = true

            searchUom(row.organization_id, row.product_item_id)
                .then((result) => {
                    console.debug('onSelectInventoryItemId searchUom success', result)

                    this.relateFieldDataLoading = false
                    this.requestUomList = result.uom
                    this.setDefaultUom()
                })
                .catch(err => {
                    console.debug('onSelectInventoryItemId searchUom error', err)
                    this.relateFieldDataLoading = false
                })
        },
        setDefaultUom() {
            if (this.requestUomList.length <= 0) return

            let defaultUom = _find(this.requestUomList, (item) => {
                return this.form.request_uom === item.from_uom_code
            })

            if (!defaultUom) {
                defaultUom = this.requestUomList[0]
            }

            this.form.request_uom = defaultUom.from_uom_code
            this.form.from_unit_of_measure = defaultUom.from_unit_of_measure
        },
        onSelectBlendNo(key) {
            console.log('onSelectBlendNo', {key})
            let row = this.blend_no_list.filter(item => item.product_blend_no === key)[0]

            this.form.inventory_item_id = row.product_item_id

            this.form.product_item_number = row.product_item_number
            this.form.product_item_desc = row.product_item_desc
            this.form.request_uom = row.product_uom_code
            this.form.organization_id = row.organization_id

            this.mfgFormulaV.organization_id = row.organization_id
            this.mfgFormulaV.inventory_item_id = row.product_item_id

            this.relateFieldDataLoading = true

            searchUom(row.organization_id, row.product_item_id)
                .then((result) => {
                    console.debug('searchUom success', result)

                    this.relateFieldDataLoading = false
                    this.requestUomList = result.uom
                    this.setDefaultUom()
                })
                .catch(err => {
                    console.debug('searchUom error', err)
                    this.relateFieldDataLoading = false
                })
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
        openModal() {
            $('#searchModal').modal('show');
            this.getParam();
        },
        async getParam() {
            let vm = this;
            vm.moduleSearch.loading = true;
            vm.searchSummaryBatchVList = [];
            vm.summaryBatchVList = [];

            let params = {
                action:                 'search_get_param',
                plan_start_date_from:   vm.moduleSearch.plan_start_date_from,
                plan_start_date_to:     vm.moduleSearch.plan_start_date_to,
                inventory_item_id:      vm.moduleSearch.inventory_item_id,
                web_batch_status_code:  vm.moduleSearch.web_batch_status_code,
                batch_id:               vm.moduleSearch.batch_id,
                // from_transaction_date: vm.transDateFormat.from_date,
                // to_transaction_date: vm.transDateFormat.to_date,
                // request_status: vm.requestStatus,
                // objective_code: vm.objectiveCode,
                // attribute2: vm.header.attribute2,
            }

            let response = await http.get($route(api_pm_productionOrder_search), {params: params}).then(({data}) => {
                vm.moduleSearch.loading = false;
                return data
            });

            response = response.data;
            vm.inputParams.inventory_item_id_list = response.inventory_item_id_list;
            vm.inputParams.web_batch_status_code_list = response.web_batch_status_code_list;
            vm.inputParams.batch_id_list = response.batch_id_list;
            vm.searchSummaryBatchVList = response.summary_batch;
        }
    },
}

</script>
<style>
#pm0001 .el-select {
    display: block;
}

#pm0001 .mx-datepicker  {
    border: 1px solid #e5e6e7;
    height:unset ;
    width: unset;
    display: block;
}

#pm0001 .mx-input {
    display: inline-block;
    width: 100%;
    padding-left: 10px;
    font-size: 14px;
    color: #555;
    border: 0px solid #ccc;
    height: unset;
    box-shadow: unset;
    border-radius: 1px;
}
#pm0001 .mx-datepicker .mx-input-wrapper .mx-icon-calendar{
    right: 10px
}
</style>
