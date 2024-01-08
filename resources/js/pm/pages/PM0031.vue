<template>
    <div class="row">

        <div class="col-lg-12">

            <div class="ibox">

                <div class="ibox-title tw-p-4">
                    
                    <div class="row">

                        <div class="col-lg-6">
                            <span class="tw-text-lg tw-font-bold"> บันทึกผลผลิต </span>
                        </div>
                        <div class="col-lg-6">

                            <div class="text-right">
                                <button type="button" data-toggle="modal" data-target="#searchModal" class="btn btn-default tw-w-32 tw-ml-1">
                                    <span class="fa fa-search"></span> ค้นหา
                                </button>
                                <button type="button" @click.prevent="onClear" class="btn btn-success tw-w-32">
                                    <span class="fa fa-plus"></span> สร้าง
                                </button>
                                <button type="button" @click.prevent="onSave" class="btn btn-primary tw-w-32 tw-ml-2" :disabled="linesModel.length === 0">
                                    <span class="fa fa-save"></span> บันทึก
                                </button>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="ibox-content">

                    <div class="row">

                        <div class="col-lg-6 col-sm-12">

                            <div class="form-group row">

                                <label class="col-lg-3 col-form-label"> วันที่ได้ผลผลิต <span style="color: #F00;">*</span> : </label>

                                <div class="col-lg-9">

                                    <datepicker-th  v-if="defaultdata.organization_code == 'M06' || defaultdata.organization_code == 'M12' || defaultdata.organization_code == 'MPG' || defaultdata.organization_code == 'MP2'"
                                        style="width: 100%" 
                                        class="form-control md:tw-mb-0 tw-mb-2" 
                                        name="product_date" 
                                        id="input_product_date" 
                                        placeholder="โปรดเลือกวันที่"
                                        :value="productDate"
                                        format="DD/MM/YYYY"
                                        :not-before-date="min_max_date_period.mindate"
                                        :not-after-date="toDayFormatted"
                                        @dateWasSelected="onProductDateWasChanged" 
                                    />
                                    <datepicker-th  v-else
                                        style="width: 100%" 
                                        class="form-control md:tw-mb-0 tw-mb-2" 
                                        name="product_date" 
                                        id="input_product_date" 
                                        placeholder="โปรดเลือกวันที่"
                                        :value="productDate"
                                        format="DD/MM/YYYY"
                                        :not-before-date="biweeklyStartDateFormatted"
                                        :not-after-date="toDayFormatted"
                                        @dateWasSelected="onProductDateWasChanged" 
                                    />

                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-lg-3 col-form-label"> เลขที่คำสั่งผลิต <span style="color: #F00;">*</span> : </label>

                                <div class="col-lg-9">

                                    <div v-if="productDate">

                                        <pm-el-select name="batch_id" id="input_batch_id" 
                                            :select-options="batchHeaders"
                                            option-key="batch_id"
                                            option-value="batch_id" 
                                            option-label="batch_full_desc" 
                                            :value="batchId" 
                                            :filterable="true"
                                            @onSelected="onBatchNoWasChanged"
                                        />

                                    </div>
                                    <div v-else> 
                                        <div class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                            -
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-lg-3 col-form-label"> สินค้าที่จะผลิต : </label>

                                <div class="col-lg-9">
                                    <div class="tw-pb-2">
                                        <div class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                            {{ headerModel ? (headerModel.item_no ? headerModel.item_no : "-") : "-" }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100" style="overflow-wrap: break-word;">
                                            {{ headerModel ? (headerModel.item_desc ? headerModel.item_desc : "-") : "-" }}
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">

                                <label class="col-3 col-form-label"> ขั้นตอนการทำงาน <span style="color: #F00;">*</span> : </label>

                                <div class="col-9">

                                    <div class="row">

                                        <div class="col-lg-4">

                                            <div v-if="headerModel"> 

                                                <!-- <pm-el-select name="wip_step" id="input_wip_step" 
                                                    :select-options="jobWipSteps"
                                                    option-key="wip_step"
                                                    option-value="wip_step" 
                                                    option-label="label" 
                                                    :value="wipStep" 
                                                    :filterable="true"
                                                    @onSelected="onWipStepWasChanged"
                                                /> -->

                                                <el-select @change="onWipStepWasChanged" filterable name="wip_step" id="input_wip_step" v-model="wipStep" placeholder="Select">
                                                    <el-option
                                                      v-for="item in jobWipSteps"
                                                      :key="item.wip_step"
                                                      :label="item.wip_step"
                                                      :value="item.wip_step">
                                                      <span style="float: left">{{ item.label }}</span>
                                                    </el-option>
                                                </el-select>

                                            </div>
                                            <div v-else> 
                                                <div class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                                    -
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-8">
                                            <div class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                                {{ wipStepDesc ? wipStepDesc : "-" }}
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6 col-sm-12">


                            <div class="form-group row" v-if="defaultdata.organization_code != 'M06' && defaultdata.organization_code != 'M12'">

                                <label class="col-lg-3 col-form-label"> Blend No. : </label>
                                <div class="col-lg-9">
                                    <div class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                        {{ headerModel ? (headerModel.blend_no ? headerModel.blend_no : "-") : "-" }}
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-lg-3 col-form-label"> วันที่เริ่มผลิต : </label>
                                <div class="col-lg-4">

                                    <div v-if="headerModel" class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                        {{ headerStartDateFormatted ? headerStartDateFormatted : "-" }}
                                    </div>
                                    <div v-else class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                        -
                                    </div>

                                </div>

                                <label class="col-lg-1 col-form-label" style="padding-top: calc(.375rem + 1px);"> ถึง </label>
                                <div class="col-lg-4">

                                    <div v-if="headerModel" class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                        {{ headerEndDateFormatted ? headerEndDateFormatted : "-" }}
                                    </div>
                                    <div v-else class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                        -
                                    </div>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-lg-3 col-form-label"> จำนวนที่สั่งผลิต : </label>

                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                                {{ headerModel ? (headerModel.request_qty ? Number(headerModel.request_qty).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : "-") : "-" }}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                                {{ headerModel ? getUomCodeDescription(uomCodes, headerModel.uom) : "-" }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- <div class="form-group row">

                                <label class="col-lg-3 col-form-label"> ผลผลิตที่ได้ : </label>

                                <div class="col-lg-9">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                                {{ headerModel ? (headerModel.product_qty ? Number(headerModel.product_qty).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : "-") : "-" }}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="tw-py-2 tw-px-4 tw-border tw-border-solid tw-border-gray-200 tw-bg-gray-100">
                                                {{ headerModel ? getUomCodeDescription(uomCodes, headerModel.uom) : "-" }}
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div> -->

                        </div>

                    </div>

                </div>

            </div>

            <div class="ibox">

                <div class="ibox-title">
                    <span class="tw-text-lg tw-font-bold"> บันทึกผลผลิตรายวัน </span>
                </div>

                <div class="ibox-content">

                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <thead>

                                <tr>
                                    <!-- <th class="text-center"> </th> -->
                                    <th class="text-center" style="width: 130px;"> วันที่ได้ผลผลิต  </th>
                                    <th class="text-center" > คงคลังเช้า </th>
                                    <th class="text-right" style="width: 270px;"> 
                                        <div class="tw-pr-4"> ผลผลิตที่ได้ <span style="color: #F00;">*</span> </div>
                                    </th>
                                    <th class="text-right" style="width: 270px;"> 
                                        <div class="tw-pr-4"> สูญเสีย  </div> 
                                    </th>
                                    <th class="text-right" style="width: 270px;"> 
                                        <div class="tw-pr-4"> จ่ายออก <span style="color: #F00;">*</span> </div>
                                    </th>
                                    <th class="text-center" style="width: 270px;">
                                        <div v-if="organizationCode == 'M06'" title="คงคลังเย็น = (คงคลังเช้า + ผลผลิตที่ได้) - (สูญเสีย+จ่ายออก)">คงคลังเย็น (WIP)</div>
                                        <div v-else title="คงคลังเย็น = (คงคลังเช้า + ผลผลิตที่ได้) - (จ่ายออก)">คงคลังเย็น (WIP)</div>
                                    </th>
                                    <th class="text-center" style="width: 130px;"> หน่วยนับ </th>
                                </tr>

                            </thead>
                            <tbody v-if="linesModel.length > 0">

                                <template v-for="(line, i) in linesModel">
                                <tr v-if="(defaultdata.organization_code == 'M06') && wipStep == 'WIP01' && line.is_convers_set_layout && !line.set_layout">
                                    <td colspan="7" class="text-center">
                                        <h3 class="no-margins text-danger">
                                            ไม่พบข้อมูลการแปลงหน่วย : PMS0023: บันทึก Layout สิ่งพิมพ์
                                        </h3>
                                    </td>
                                </tr>
                                <tr v-else  :key="i">
                                    <td class="text-center"> 
                                        <!-- {{ productDateFormatted }}  -->
                                        {{ line.product_date_formatted }}
                                    </td>

                                    <td class="text-right"> 
                                        {{ line.receive_wip ? (line.receive_wip ? Number(line.receive_wip).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : "-") : "-" }}
                                    </td>

                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="2" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            v-model="line.product_qty"
                                            :disabled="lineDisable || lodash.get(line, 'init_transaction_flag')"
                                            @change="lineProductQtyWasChanged($event, line)"
                                            ></vue-numeric>
                                    </td>
                                    <td class="text-right">

                                        <div v-if="organizationCode == 'M12' || organizationCode == 'M06'"> 

                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="2" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                v-model="line.loss_qty"
                                                :disabled="lineDisable || lodash.get(line, 'init_transaction_flag')"
                                                @change="lineLossQtyWasChanged($event, line)"
                                            ></vue-numeric>

                                        </div>
                                        <div v-else>
                                            {{ line.loss_qty ? (line.loss_qty ? Number(line.loss_qty).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : "0.00") : "0.00" }}
                                        </div>

                                    </td>
                                    
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="2" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            v-model="line.transfer_qty"
                                            :disabled="lineDisable || lodash.get(line, 'init_transaction_flag')"
                                            @change="lineTransferQtyWasChanged($event, line)"
                                        ></vue-numeric>
                                    </td>

                                    <td class="text-right"> 
                                        <!-- {{ line.transfer_wip }}  -->
                                        {{ line.transfer_wip ? (line.transfer_wip ? Number(line.transfer_wip).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : "0.00") : "0.00" }}
                                    </td>

                                    <td class="text-center"> 

                                        <div v-if="line.is_convers_set_layout">
                                            {{ line.set_layout.custom_uom_name }}
                                        </div>
                                        <div v-show="!line.is_convers_set_layout">
                                            {{ uomCodes.find(o => { return o.uom_code == line.uom; }).unit_of_measure }}
                                        </div>

                                        <!-- {{ line.uom }}  -->
                                        <!-- <pm-el-select v-show="!line.is_convers_set_layout" name="uom_code" id="input_uom_code" 
                                            :select-options="uomCodes"
                                            option-key="uom_code"
                                            option-value="uom_code" 
                                            option-label="unit_of_measure" 
                                            :value="line.uom" 
                                            :filterable="true"
                                            @onSelected="onLineUomWasChanged($event, line)"
                                        /> -->
                                        
                                    </td>

                                </tr>
                                </template>

                            </tbody>

                            <tbody v-else>
                                <tr>
                                    <td colspan="8">
                                        <h2 class="tw-text-gray-400 text-center tw-py-4">ไม่พบข้อมูล</h2>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        
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

                            <div class="clearfix tw-pt-6 tw-pb-10">

                                <form @submit.prevent="search">

                                    <div class="form-group row">

                                        <label class="col-lg-2 col-form-label text-right" for="input_search_product_date_from"> วันที่ได้ผลผลิต : </label>

                                        <div class="col-lg-2 tw-px-0">

                                            <datepicker-th 
                                                style="width: 100%" 
                                                class="form-control md:tw-mb-0 tw-mb-2" 
                                                name="search_product_date_from" 
                                                id="input_search_product_date_from" 
                                                placeholder="โปรดเลือกวันที่"
                                                :value="searchModel.product_date_from"
                                                format="DD/MM/YYYY"
                                                @dateWasSelected="onSearchProductDateFromWasChanged" 
                                            />

                                        </div>

                                        <label class="col-lg-2 col-form-label text-right" for="input_search_product_date_to"> ถึง : </label>

                                        <div class="col-lg-2 tw-px-0">

                                            <datepicker-th 
                                                style="width: 100%" 
                                                class="form-control md:tw-mb-0 tw-mb-2" 
                                                name="search_product_date_to" 
                                                id="input_search_product_date_to" 
                                                placeholder="โปรดเลือกวันที่"
                                                :value="searchModel.product_date_to"
                                                format="DD/MM/YYYY"
                                                :disabled-date-to="searchModel.product_date_from_formatted"
                                                @dateWasSelected="onSearchProductDateToWasChanged" 
                                            />

                                        </div>
                                        
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-lg-2 col-form-label text-right" for="search_batch_id"> เลขที่คำสั่งผลิต : </label>

                                        <div class="col-lg-2 tw-px-0">

                                            <pm-el-select name="search_batch_no" id="input_search_batch_no" 
                                                :select-options="batch_header_list"
                                                option-key="batch_no"
                                                option-value="batch_no" 
                                                option-label="batch_full_desc" 
                                                :value="searchModel.batch_no" 
                                                :filterable="true"
                                                @onSelected="onSearchBatchNoWasChanged"
                                            />

                                        </div>

                                        <label class="col-lg-2 col-form-label text-right"> สินค้าที่ผลิต : </label>

                                        <div class="col-lg-2 tw-px-0">

                                            <pm-el-select name="search_item_no" id="input_search_item_no" 
                                                :select-options="invItems"
                                                option-key="item_no"
                                                option-value="item_no" 
                                                option-label="item_full_desc" 
                                                :value="searchModel.item_no" 
                                                :filterable="true"
                                                @onSelected="onSearchItemCodeWasChanged"
                                            />

                                        </div>

                                        <!-- <label class="col-lg-2 col-form-label text-right"> สถานะ : </label>

                                        <div class="col-lg-2 tw-pl-0">

                                            <pm-el-select name="search_product_status_qty" id="input_search_product_status_qty" 
                                                :select-options="[{label: 'ทั้งหมด', val: null},{label: 'บันทึกผลผลิตแล้ว', val: 'isnotnull'},{label: 'ยังไม่บันทึกผลผลิต', val: 'isnull'}]"
                                                option-key="val"
                                                option-value="val" 
                                                option-label="label" 
                                                :value="searchModel.product_status_qty" 
                                                :filterable="true"
                                                @onSelected="onSearchProductStatusQtyWasChanged"
                                            />

                                        </div> -->

                                    </div>

                                    <div class="form-group row">

                                        <label class="col-lg-2 col-form-label text-right" for="search_batch_id"> ขั้นตอนการทำงาน : </label>

                                        <div class="col-lg-2 tw-px-0">

                                            <pm-el-select name="search_wip_step" id="input_search_wip_step" 
                                                :select-options="wip_list"
                                                option-key="value"
                                                option-value="label" 
                                                option-label="label" 
                                                :value="searchModel.wip_step" 
                                                :filterable="true"
                                                @onSelected="onSearchWipStepWasChanged"
                                            />

                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label v-if="false" class="col-lg-2 col-form-label text-right" for="input_search_start_date_from"> วันที่เริ่มผลิต : </label>

                                        <div v-if="false" class="col-lg-2 tw-px-0">

                                            <datepicker-th 
                                                style="width: 100%" 
                                                class="form-control md:tw-mb-0 tw-mb-2" 
                                                name="search_start_date_from" 
                                                id="input_search_start_date_from" 
                                                placeholder="โปรดเลือกวันที่"
                                                :value="searchModel.start_date_from"
                                                format="DD/MM/YYYY"
                                                @dateWasSelected="onSearchStartDateFromWasChanged" 
                                            />

                                        </div>

                                        <label v-if="false" class="col-lg-2 col-form-label text-right" for="input_search_start_date_to"> ถึง : </label>

                                        <div v-if="false" class="col-lg-2 tw-px-0">

                                            <datepicker-th 
                                                style="width: 100%" 
                                                class="form-control md:tw-mb-0 tw-mb-2" 
                                                name="search_start_date_to" 
                                                id="input_search_start_date_to" 
                                                placeholder="โปรดเลือกวันที่"
                                                :value="searchModel.start_date_to"
                                                format="DD/MM/YYYY"
                                                :disabled-date-to="searchModel.start_date_from_formatted"
                                                @dateWasSelected="onSearchStartDateToWasChanged" 
                                            />

                                        </div>

                                        <div class="col-lg-12 text-right">

                                            <button
                                                :disabled="searching"
                                                type="button"
                                                class="btn btn-default tw-ml-2"
                                                @click="()=>{
                                                    searchModel.batch_no = null
                                                    searchModel.item_no = null
                                                    searchModel.start_date_from = null
                                                    searchModel.start_date_from_formatted = null
                                                    searchModel.start_date_to = null
                                                    searchModel.start_date_to_formatted = null
                                                    searchModel.end_date_from = null
                                                    searchModel.end_date_from_formatted = null
                                                    searchModel.end_date_to = null
                                                    searchModel.end_date_to_formatted = null
                                                    searchModel.wip_step = null
                                                }">
                                                <i class="fa fa-times"></i> ล้างค่า
                                            </button>

                                            <button
                                                :disabled="searching"
                                                type="submit"
                                                class="btn btn-default tw-ml-2 tw-w-40">
                                                <i class="fa fa-search"></i> ค้นหา
                                            </button>

                                            
                                        </div>

                                    </div>

                                </form>

                                <hr>

                                <div v-if="searching" class="lead tw-pt-10 text-center">
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
                                            <th class="text-center" scope="col">วันที่ได้ผลผลิต</th>
                                            <th class="text-center" scope="col">เลขที่คำสั่งผลิต</th>
                                            <th class="text-center" scope="col">สินค้าที่ผลิต</th>
                                            <th scope="col">รายละเอียด</th>
                                            <th class="text-center" scope="col"> ขั้นตอนการทำงาน </th>
                                            <th class="text-center" scope="col">ผลผลิตที่ได้</th>
                                            <th class="text-center" scope="col">หน่วยนับ</th>
                                            <!-- <th class="text-center" scope="col">วันที่เริ่มผลิต</th> -->
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(row,i) in searchHeaderList"
                                            :key="JSON.stringify(row)"
                                            @click="showHeader(i)"
                                            style="cursor: pointer"
                                            class="hover:tw-bg-blue-100"
                                            >
                                            <td class="text-center"> {{ toThDateString(luxon.DateTime.fromSQL(row.product_date).toJSDate()) }} </td>
                                            <td class="text-center"> {{ row.batch_no }} </td>
                                            <td class="text-center"> {{ row.item_no }} </td>
                                            <td> {{ row.item_desc }} </td>
                                            <td class="text-center"> {{ row.wip_step }} </td>
                                            <td class="text-right"> 
                                                {{ row.product_qty ? Number(row.product_qty).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : "-" }}
                                            </td>
                                            <td class="text-center">
                                                <!-- {{ getUomCodeDescription(uomCodes, row.uom) }} -->
                                                {{ row.uom_desc }}
                                            </td>
                                            <!-- <td class="text-center"> {{ toThDateString(luxon.DateTime.fromSQL(row.start_date).toJSDate()) }} </td> -->
                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</template>

<script>

import moment from "moment";
import VueNumeric from 'vue-numeric'

import {
    showLoadingDialog,
    showProgressWithUnsavedChangesWarningDialog,
    showSaveSuccessDialog,
    showSaveFailureDialog,
    showRemoveLineConfirmationDialog,
    showValidationFailedDialog,
    showGenericFailureDialog,
} from "../../commonDialogs"

import {instance as http} from "../httpClient"
import {defaultRemoteDataSource} from "./../../components/DbLookup"
import {customSelectDropDownLabelDecorator} from '../../elementUiDecorator'

import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'


import {
    $route,
    pm_0031_index,
    api_pm_0031_index,
    api_pm_0031_getBatches,
    api_pm_0031_getListBatchHeaders,
    api_pm_0031_getWipSteps,
    api_pm_0031_search,
    api_pm_0031_save,
} from "../../router"

import _get from 'lodash/get'
import _set from 'lodash/set'
import _deepClone from 'lodash/cloneDeep'
import _isEqual from 'lodash/isEqual'
import _clone from 'lodash/cloneDeep'
import { DateTime } from "luxon";

export default {

    props: {
        user: {type: Object},
        defaultdata: {type: Object},
        biweekly_start_date: {type: String},
        product_date: {type: String},
        batch_id : {type: String},
        wip_step : {type: String},
        job_wip_steps: {type: Array},
        batch_header: {type: Object},
        batch_lines: {type: Array},
        batch_header_list: {type: Array},
        wip_list: {type: Array},
        inv_item_list: {type: Array},
        uom_codes: {type: Array},
        header: {type: Object},
        receive_wip_header: {type: Object},
        previous_wip_header: {type: Object},
        lines: {type: Array},
        receive_wip_lines: {type: Array},
        previous_wip_lines: {type: Array},
        min_max_date_period: {type: Object},
    },

    components: {
        VueNumeric
    },

    data() {

        return {

            labelDecorator(...args) {
                customSelectDropDownLabelDecorator.apply(this, args)
            },

            lodash: {
                get: _get,
            },
            luxon: {
                DateTime: DateTime,
            },
            isInRange, jsDateToString, toJSDate, toThDateString,

            organizationCode: this.defaultdata ? this.defaultdata.organization_code : null,

            toDayFormatted: moment().add(543, 'years').format("DD/MM/YYYY"),
            biweeklyStartDate: this.biweekly_start_date ? moment(this.biweekly_start_date, "DD/MM/YYYY").toDate() : "",
            biweeklyStartDateFormatted: this.biweekly_start_date ? this.biweekly_start_date : "",
            
            productDate: this.product_date ? moment(this.product_date, "DD/MM/YYYY").toDate() : "",
            productDateFormatted: this.product_date ? this.product_date : "",

            batchId: this.batch_id ? this.batch_id : "",
            
            invItems: this.inv_item_list,
            uomCodes: this.uom_codes,
            batchHeaders : this.batch_header_list,

            batchHeaderModel: this.batch_header ? this.batch_header : null,
            batchLinesModel: this.batch_lines ? this.batch_lines : null,

            receiveHeaderModel: this.receive_wip_header,
            previousWipHeaderModel: this.previous_wip_header,
            // headerModel: this.mappingHeader(
            //     this.product_date ? moment(this.product_date, "DD/MM/YYYY").toDate() : null, 
            //     this.batch_id,
            //     this.job_wip_steps.length > 0 ? this.job_wip_steps[0].wip_step : null,
            //     this.header, 
            //     this.batch_header
            // ),
            headerModel: {},

            // headerStartDateFormatted: this.header ? moment(this.header.start_date).format("DD/MM/YYYY") : ( this.batch_header ? moment(this.batch_header.start_date).format("DD/MM/YYYY") : null),
            // headerEndDateFormatted: this.header ? moment(this.header.end_date).format("DD/MM/YYYY") : ( this.batch_header ? moment(this.batch_header.end_date).format("DD/MM/YYYY") : null),

            headerStartDateFormatted: this.header ? this.header.start_date_formatted : null,
            headerEndDateFormatted: this.header ? this.header.end_date_formatted : null,

            receiveWipLinesModel: this.receive_wip_lines,
            previousWipLinesModel: this.previous_wip_lines,
            linesModel: [],
            // linesModel: this.mappingLines(
            //     this.product_date ? moment(this.product_date, "DD/MM/YYYY").toDate() : null, 
            //     this.batch_id,
            //     this.job_wip_steps.length > 0 ? this.job_wip_steps[0].wip_step : null,
            //     this.header ? this.header : this.batch_header, 
            //     this.lines, 
            //     this.batch_lines, 
            //     this.receive_wip_lines, 
            //     this.previous_wip_lines
            // ),

            jobWipSteps: this.job_wip_steps,
            wipStep: this.getWipStepFromList(this.job_wip_steps, this.wip_step),
            wipStepDesc: this.getWipStepDesc(this.job_wip_steps, this.wip_step),
            
            searchModel: { 
                batch_no: null,
                wip_step: null,
                item_no: null,
                product_date_from: null,
                product_date_from_formatted: null,
                product_date_to: null,
                product_date_to_formatted: null,
                start_date_from: null,
                start_date_from_formatted: null,
                start_date_to: null,
                start_date_to_formatted: null,
                end_date_from: null,
                end_date_from_formatted: null,
                end_date_to: null,
                end_date_to_formatted: null,
            },
            searching: false,
            searchHeaderList: [],

            lineDisable: this.header ? `${_get(this.header, 'request_summary_v.s2', '')}` === '1' : false,

        }
    },

    mounted() {
        this.initData();
    },

    methods: {
        async initData() {
            let vm = this;
            let data = new Promise(async (resolve, reject) => {

                vm.batchHeaders = await vm.filterBatch();
                if (vm.batchHeaders.length == 0) {
                    vm.onBatchNoWasChanged('');
                    return;
                }
                vm.headerModel = vm.mappingHeader(
                    vm.product_date ? moment(vm.product_date, "DD/MM/YYYY").toDate() : null,
                    vm.batch_id,
                    vm.job_wip_steps.length > 0 ? vm.job_wip_steps[0].wip_step : null,
                    vm.header,
                    vm.batch_header
                );

                vm.linesModel = vm.mappingLines(
                    vm.product_date ? moment(vm.product_date, "DD/MM/YYYY").toDate() : null,
                    vm.batch_id,
                    vm.job_wip_steps.length > 0 ? vm.job_wip_steps[0].wip_step : null,
                    vm.header ? vm.header : vm.batch_header,
                    vm.lines,
                    vm.batch_lines,
                    vm.receive_wip_lines,
                    vm.previous_wip_lines
                );
                if (vm.productDate && vm.wipStep && vm.batchId) {
                    // this.onWipStepWasChanged(this.wipStep);
                    vm.onBatchNoWasChanged(vm.batchId)
                }
                resolve('');
            });
            return await data;
        },

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("product_date", this.productDateFormatted);
            queryParams.set("batch_id", this.batchId);
            queryParams.set("wip_step", this.wipStep);
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        getWipStepFromList(jobWipSteps, wipStep) {
            let result = "";
            if(jobWipSteps.length > 0 && wipStep) {
                const foundWipStep = jobWipSteps.find(item => item.wip_step == wipStep);
                result = foundWipStep ? foundWipStep.wip_step : "";
            }
            return result;
        },

        getWipStepDesc(jobWipSteps, wipStep) {
            let result = "";
            if(jobWipSteps.length > 0 && wipStep) {
                const foundWipStep = jobWipSteps.find(item => item.wip_step == wipStep);
                result = foundWipStep ? foundWipStep.wip_step_desc : "";
            }
            return result;
        },

        mappingHeader(productDate, batchId, wipStep, header, batchHeader) {

            let mappedHeader = null;
            if(header) {

                mappedHeader = {
                    ...header,
                    product_header_id: header.product_header_id ? header.product_header_id : null,
                    plan_qty: batchHeader.plan_qty,
                    request_qty: header.request_qty ? header.request_qty : batchHeader.plan_qty,
                    uom: header.uom ? header.uom : batchHeader.dtl_um,
                    product_date: productDate,
                    product_date_formatted: moment(productDate).format("DD/MM/YYYY"),
                    start_date: batchHeader.start_date,
                    // start_date_formatted: moment(batchHeader.start_date).format("DD/MM/YYYY"),
                    start_date_formatted: batchHeader.start_date_formatted,
                    end_date: batchHeader.end_date,
                    // end_date_formatted: moment(batchHeader.end_date).format("DD/MM/YYYY"),
                    end_date_formatted: batchHeader.end_date_formatted,
                    product_qty: header.product_qty ? header.product_qty : 0,

                }

            } else {

                if(batchHeader) {
                    
                    mappedHeader = {
                        ...batchHeader,
                        product_header_id: null,
                        plan_qty: batchHeader.plan_qty,
                        request_qty: batchHeader.plan_qty,
                        uom: batchHeader.uom ? batchHeader.uom : batchHeader.dtl_um,
                        product_date: productDate,
                        product_date_formatted: moment(productDate).format("DD/MM/YYYY"),
                        start_date: batchHeader.start_date,
                        // start_date_formatted: moment(batchHeader.start_date).format("DD/MM/YYYY"),
                        start_date_formatted: batchHeader.start_date_formatted,
                        end_date: batchHeader.end_date,
                        // end_date_formatted: moment(batchHeader.end_date).format("DD/MM/YYYY"),
                        end_date_formatted: batchHeader.end_date_formatted,
                        product_qty: 0,
                    }

                }

            }

            return mappedHeader;

        },

        mappingLines(productDate, batchId, wipStep, header, lines, batchLines, receiveWipLines, previousWipLines, setLayout = false) {

            let mappedLines = [];

            if(productDate && batchId && wipStep) {

                let preMappedLines = [];
                if(lines.length > 0) {
                    console.log('lines');
                    preMappedLines = lines.map((line, index) => {
                        return line
                    });
                } else {
                    preMappedLines = batchLines.map((line, index) => {
                        return {
                            ...line,
                            uom: line.dtl_um
                        }
                    });
                    console.log('batchLines', preMappedLines);
                }

                mappedLines = preMappedLines.map((line, index) => {
                    console.log('--->>', line, line.product_qty ? line.product_qty : 0);

                    const receiveWipLine = receiveWipLines.find(receiveLine => {
                        return receiveLine.inventory_item_id == line.inventory_item_id; 
                    });

                    const previousWipLine = previousWipLines.find(previousLine => {
                        return previousLine.inventory_item_id == line.inventory_item_id; 
                    });

                    return {
                        
                        ...line,

                        product_line_id: line.product_line_id ? line.product_line_id : null,
                        batch_id: header.batch_id,
                        product_date: productDate,
                        product_date_formatted: moment(productDate).format("DD/MM/YYYY"),
                        
                        product_qty: line.product_qty ? line.product_qty : 0,
                        loss_qty: line.loss_qty ? line.loss_qty : 0,
                        transfer_qty: line.transfer_qty ? line.transfer_qty : 0,
                        transfer_wip: line.transfer_wip ? line.transfer_wip : 0,

                        receive_wip: receiveWipLine ? receiveWipLine.transfer_wip : 0,
                        previous_transfer_qty: previousWipLine ? previousWipLine.transfer_qty : 0,

                        uom: line.uom ? line.uom : header.uom,

                        init_transaction_flag: line.transaction_flag,

                        is_convers_set_layout: setLayout ? setLayout.is_convers_set_layout : false,
                        set_layout: setLayout ? setLayout.data : [],

                    }

                });


                console.log('End --->>', mappedLines)

            }

            return mappedLines;

        },

        async getProductInfo() {
            let vm = this;

            this.searching = true

            const params = {
                product_date: this.productDateFormatted,
                batch_id: this.batchId,
                wip_step: this.wipStep
            };

            return await http.get($route(api_pm_0031_index), { params })
            .then(({data}) => {

                this.searching = false;

                this.receiveWipHeaderModel = data.receive_wip_header;
                this.previousWipHeaderModel = data.previous_wip_header;
                console.log('xxx1111', this.headerStartDateFormatted);
                this.headerModel = this.mappingHeader(
                    this.productDate, 
                    this.batchId,
                    this.wipStep, 
                    data.header, 
                    this.batchHeaderModel
                );
                // this.headerStartDateFormatted = this.headerModel ? moment(this.headerModel.start_date).format("DD/MM/YYYY") : moment(this.batchHeaderModel.start_date).format("DD/MM/YYYY");
                // this.headerEndDateFormatted = this.headerModel ? moment(this.headerModel.end_date).format("DD/MM/YYYY") : moment(this.batchHeaderModel.end_date).format("DD/MM/YYYY");

                this.headerStartDateFormatted = this.headerModel ? this.headerModel.start_date_formatted : null;
                this.headerEndDateFormatted = this.headerModel ? this.headerModel.end_date_formatted : null;

                this.receiveWipLinesModel = data.receive_wip_lines;
                this.previousWipLinesModel = data.previous_wip_lines; 
                this.linesModel = this.mappingLines(
                    this.productDate, 
                    this.batchId,
                    this.wipStep, 
                    this.headerModel, 
                    data.lines, 
                    this.batchLinesModel, 
                    this.receiveWipLinesModel, 
                    this.previousWipLinesModel,
                    data.setup_layout
                );
                vm.defProductQty();

            }).catch(err => {
                this.searching = false;
            })
        },

        async getBatches() {

            this.searching = true

            const params = {
                batch_id: this.batchId
            };

            return await http.get($route(api_pm_0031_getBatches), { params })
            .then(({data}) => {

                this.searching = false;

                this.batchHeaderModel = data.batch_header ? data.batch_header : null;
                this.headerModel = this.mappingHeader(
                    this.productDate, 
                    this.batchId,
                    this.wipStep, 
                    null, 
                    this.batchHeaderModel
                );

                this.batchLinesModel = data.batch_lines ? data.batch_lines : [];

            }).catch(err => {
                this.searching = false;
            })
        },

        
        async getWipSteps() {

            this.searching = true

            const params = {
                batch_id: this.batchId
            };

            return await http.get($route(api_pm_0031_getWipSteps), { params })
            .then(({data}) => {

                this.searching = false;
                this.jobWipSteps = data.job_wip_steps ? data.job_wip_steps : [];
                if(this.jobWipSteps.length > 0) {
                    this.wipStep = this.getWipStepFromList(this.jobWipSteps, this.wipStep);
                    this.wipStepDesc = this.getWipStepDesc(this.jobWipSteps, this.wipStep);
                } else {
                    this.wipStep = "";
                    this.wipStepDesc = "";
                }

            }).catch(err => {
                this.searching = false;
            })
        },

        async getListBatchHeaders() {

            this.searching = true

            const params = {
                product_date: this.productDateFormatted,
            };

            return await http.get($route(api_pm_0031_getListBatchHeaders), { params })
            .then(({data}) => {

                this.searching = false;
                this.batchHeaders = data.batch_header_list ? data.batch_header_list : [];
                this.batch_header_list = this.batchHeaders;

            }).catch(err => {
                this.searching = false;
            })
        },

        search() {

            console.log({s: this.searchModel})

            this.searching = true

            http.get($route(api_pm_0031_search), { params: this.searchModel })
            .then(({data}) => {

                this.searching = false;
                console.log('data', data)

                this.searchHeaderList = data.headers.map(item => {
                    return {
                        ...item,
                    };
                });

            }).catch(err => {
                this.searching = false;
            })
        },

        async onProductDateWasChanged(date) {

            this.productDate = date;
            this.productDateFormatted = moment(date).format("DD/MM/YYYY");

            this.batchHeaders = await this.filterBatch();
            // REFRESH DATA
            this.receiveWipHeaderModel = null;
            this.previousWipHeaderModel = null;
            this.headerModel = null;
            
            this.receiveWipLinesModel = [];
            this.previousWipLinesModel = [];
            this.linesModel = [];

            if(this.batchId) {
                // await this.getBatches();
                // await this.getWipSteps();
                // if(this.productDate && this.wipStep) {
                //     await this.getProductInfo();
                // }
                await this.onBatchNoWasChanged(this.batchId)
            }

            this.setUrlParams();

        },
        async filterBatch() {
            let vm = this;
            if (vm.productDate == '' || vm.productDate == null || vm.productDate == undefined) {
                return;
            }
            let data = new Promise(async (resolve, reject) => {
                var year  = new Date(vm.productDate).getFullYear();
                var month = new Date(vm.productDate).getMonth();
                var day   = new Date(vm.productDate).getDate();
                var transDate  = new Date(year - 543, month, day);
                    transDate  = Date.parse(transDate);
                var batchs = await vm.batch_header_list.filter( function(item) {
                    return transDate >= Date.parse(item.actual_start_date)
                });
                resolve(batchs)
            });
            return await data;
        },

        async onBatchNoWasChanged(value) {

            this.batchId = value;

            // REFRESH DATA
            this.receiveWipHeaderModel = null;
            this.previousWipHeaderModel = null;
            this.headerModel = null;
            
            this.receiveWipLinesModel = [];
            this.previousWipLinesModel = [];
            this.linesModel = [];

                console.log('onBatchNoWasChanged 0');
            if(this.batchId) {
                await this.getBatches();
                await this.getWipSteps();
                console.log('onBatchNoWasChanged 1');

                if (this.productDate) {
                console.log('onBatchNoWasChanged 2');
                    let toFormat = 'yyyyMMDD';
                    let fromFormat = 'yyyy-MM-DD ';
                    let productDate = JSON.parse(JSON.stringify(this.productDateFormatted));
                    let splitProductDate = productDate.split("/");
                    let oldYery = splitProductDate[2];
                    let newYery = parseFloat(oldYery) - 543;
                        productDate = productDate.replace(oldYery, newYery)
                        productDate = moment(productDate, 'DD/MM/yyyy').format(toFormat);
                    let actualStartDate = JSON.parse(JSON.stringify(this.batchHeaderModel.actual_start_date));
                        actualStartDate = moment(actualStartDate).format(toFormat);

                    // console.log('getProductInfo oldYery', oldYery);
                    // console.log('getProductInfo newYery', newYery);
                    // console.log('getProductInfo splitProductDate', splitProductDate);
                    // console.log('getProductInfo productDate', productDate);
                    // console.log('getProductInfo actualStartDate', actualStartDate);
                    // console.log('getProductInfo', moment(this.batchHeaderModel.actual_start_date).format(toFormat), this.batchHeaderModel);

                    if (parseFloat(productDate) < parseFloat(actualStartDate)) {
                        swal({
                            title: `\nเกิดข้อผิดพลาด`, // new line is a workaround for icon cover text
                            text: `ไม่สามารถทำรายการได้<br>เนื่องจาก วันที่บันทึกผลผลิต เกิดก่อนเปิดคำสั่งผลิต<br>"กรุณาตรวจสอบวันที่เปิดคำสั่งผลิต ก่อนทำรายการ`,
                            html: true,
                            type: 'error',
                            showConfirmButton: true,
                            closeOnConfirm: true,
                            confirmButtonText: 'ปิด',
                        }, (value) => {
                        });

                        this.onBatchNoWasChanged('');
                        return;
                    }
                }

                if(this.productDate && this.wipStep) {
                    await this.getProductInfo();
                }
            }

            this.setUrlParams();

        },

        async onWipStepWasChanged(wipStep) {

            this.wipStep = wipStep;
            this.wipStepDesc = this.getWipStepDesc(this.jobWipSteps, wipStep);

            // REFRESH DATA
            this.receiveWipHeaderModel = null;
            this.previousWipHeaderModel = null;
            this.headerModel = null;
            
            this.receiveWipLinesModel = [];
            this.previousWipLinesModel = [];
            this.linesModel = [];

            if(this.batchId) {
                // await this.getWipSteps();
                // await this.getBatches();
                if(this.productDate && this.wipStep) {
                    console.log('onWipStepWasChanged');
                    await this.getProductInfo();
                }
            }

            this.setUrlParams();

        },

        async onSearchBatchNoWasChanged(value) {
            this.searchModel.batch_no = value;
        },

        async onSearchItemCodeWasChanged(value) {
            this.searchModel.item_no = value;
        },
        async onSearchWipStepWasChanged(value) {
            this.searchModel.wip_step = value;
        },

        async onSearchProductDateFromWasChanged(value) {
            this.searchModel.product_date_from = value;
            this.searchModel.product_date_from_formatted = moment(value).format("DD/MM/YYYY");
        },

        async onSearchProductDateToWasChanged(value) {
            this.searchModel.product_date_to = value;
            this.searchModel.product_date_to_formatted = moment(value).format("DD/MM/YYYY");
        },

        async onSearchStartDateFromWasChanged(value) {
            this.searchModel.start_date_from = value;
            this.searchModel.start_date_from_formatted = moment(value).format("DD/MM/YYYY");
        },

        async onSearchStartDateToWasChanged(value) {
            this.searchModel.start_date_to = value;
            this.searchModel.start_date_to_formatted = moment(value).format("DD/MM/YYYY");
        },

        // async onSearchProductStatusQtyWasChanged(value) {
        //     this.searchModel.product_status_qty = value;
        // },

        showHeader(i) {

            $('#searchModal').modal('hide')

            let selectedHeader = this.searchHeaderList[i]

            showLoadingDialog();

            let params = {
                product_date: _get(selectedHeader, 'product_date_formatted', ''),
                batch_id: _get(selectedHeader, 'batch_id', ''),
                wip_step: _get(selectedHeader, 'wip_step', ''),
            }

            window.location = $route(pm_0031_index) + '?' + (new URLSearchParams(params).toString())

        },

        async lineProductQtyWasChanged(e, line) {

            const receiveWipLine = this.receiveWipLinesModel.find(receiveLine => {
                return receiveLine.inventory_item_id == line.inventory_item_id; 
            });

            const previousWipLine = this.previousWipLinesModel.find(previousLine => {
                return previousLine.inventory_item_id == line.inventory_item_id; 
            });

            let productQty = e.target.value ? e.target.value : 0;
            let transferQty = line.transfer_qty ? line.transfer_qty : 0;
            let receiveWipQty = receiveWipLine ? receiveWipLine.transfer_wip : 0;
            let previousTransferQty = previousWipLine ? previousWipLine.transfer_qty : 0;

            // if(parseFloat(transferQty) > (parseFloat(receiveWipQty) + parseFloat(productQty))) {
            //     transferQty = parseFloat(receiveWipQty) + parseFloat(productQty);
            //     Vue.nextTick(() => {
            //         line.transfer_qty = transferQty;
            //     });
            // }
            console.log('lineProductQtyWasChanged', e, e.target.value, receiveWipLine);

            line.transfer_qty = await this.calTransferQty(transferQty, receiveWipQty, productQty, line);
            line.loss_qty =  await this.calLossQty(productQty, previousTransferQty, receiveWipQty, line, 'product_qty');
            line.transfer_wip =  await this.calTransferWip(receiveWipQty, productQty, transferQty, line);

            this.headerModel.product_qty = productQty;

        },

        async lineLossQtyWasChanged(e, line) {
            const receiveWipLine = await this.receiveWipLinesModel.find(receiveLine => {
                return receiveLine.inventory_item_id == line.inventory_item_id;
            });

            let transferQty = line.transfer_qty ? line.transfer_qty : 0;
            let productQty = line.product_qty ? line.product_qty : 0;
            let receiveWipQty = receiveWipLine ? receiveWipLine.transfer_wip : 0;

            // if(parseFloat(transferQty) > (parseFloat(receiveWipQty) + parseFloat(productQty))) {
            //     transferQty = parseFloat(receiveWipQty) + parseFloat(productQty);
            //     Vue.nextTick(() => {
            //         line.transfer_qty = transferQty;
            //     });
            // }
            line.transfer_qty = await this.calTransferQty(transferQty, receiveWipQty, productQty, line);
            line.loss_qty = await this.calLossQty(productQty, '', receiveWipQty, line, 'loss_qty');
            line.transfer_wip = await this.calTransferWip(receiveWipQty, productQty, transferQty, line);
        },

        async lineTransferQtyWasChanged(e, line) {

            
            const receiveWipLine = this.receiveWipLinesModel.find(receiveLine => {
                return receiveLine.inventory_item_id == line.inventory_item_id; 
            });

            let transferQty = e.target.value ? e.target.value : 0;
            let productQty = line.product_qty ? line.product_qty : 0;
            let receiveWipQty = receiveWipLine ? receiveWipLine.transfer_wip : 0;

            // if(parseFloat(transferQty) > (parseFloat(receiveWipQty) + parseFloat(productQty))) {
            //     transferQty = parseFloat(receiveWipQty) + parseFloat(productQty);
            //     Vue.nextTick(() => {
            //         line.transfer_qty = transferQty;
            //     });
            // }
            console.log('lineTransferQtyWasChanged', line);
            line.transfer_qty = await this.calTransferQty(transferQty, receiveWipQty, productQty, line);
            line.loss_qty = await this.calLossQty(productQty, '', receiveWipQty, line, 'transfer_qty');
            line.transfer_wip = await this.calTransferWip(receiveWipQty, productQty, transferQty, line);
        },

        calTranferQty(productQty, lossQty) {
            if(parseFloat(productQty) > parseFloat(lossQty)) {
                return parseFloat(productQty) - parseFloat(lossQty);
            } else {
                return 0;
            }
        },

        calLossQty(productQty, previousTransferQty, receiveWipQty, line, changeInputName) {
            let vm = this;
            if (vm.organizationCode == 'M06' || vm.organizationCode == 'M12') {
                let qty = 0;
                let lossQty = parseFloat(line.loss_qty ? line.loss_qty : 0);
                let sumReceiveWipProductQty = (parseFloat(receiveWipQty) + parseFloat(productQty));
                // console.log(
                //     '-------------------->'
                //     , changeInputName
                //     , 'parseFloat(receiveWipQty) ->', receiveWipQty, parseFloat(receiveWipQty)
                //     , 'parseFloat(productQty) ->', parseFloat(productQty)
                //     , sumReceiveWipProductQty
                // )
                if (changeInputName == 'product_qty') { // ผลผลิตที่ได้
                    if ( parseFloat(line.loss_qty) > sumReceiveWipProductQty ) {
                        line.loss_qty = sumReceiveWipProductQty;
                    }
                }

                if (changeInputName == 'loss_qty') { // สูญเสีย
                    if ( parseFloat(line.loss_qty) > sumReceiveWipProductQty ) {
                        line.loss_qty = sumReceiveWipProductQty;
                    }
                }

                if (changeInputName == 'transfer_qty') { // จ่ายออก
                    if ( parseFloat(line.loss_qty) > sumReceiveWipProductQty ) {
                        line.loss_qty = sumReceiveWipProductQty;
                    }
                }

                return line.loss_qty;
            }

            if(parseFloat(previousTransferQty) > parseFloat(productQty)) {
                return parseFloat(previousTransferQty) - parseFloat(productQty) ;
            } else {
                return 0;
            }
        },

        calTransferQty(transferQty, receiveWipQty, productQty, line) {
            console.log("calTransferQty ->>>>>", transferQty, receiveWipQty, productQty, line)
            let vm = this;
            let newTransferQty = parseFloat(line.transfer_qty ? line.transfer_qty : 0);
            if (vm.organizationCode == 'M06' || vm.organizationCode == 'M12') {
                const lossQty = parseFloat(line.loss_qty ? line.loss_qty : 0);
                const sumReceiveWipProductQty = (parseFloat(receiveWipQty) + parseFloat(productQty) - lossQty)
                if(parseFloat(transferQty) > sumReceiveWipProductQty) {
                    newTransferQty = sumReceiveWipProductQty;
                    console.log('1 calTransferQty newTransferQty ', newTransferQty);
                    Vue.nextTick(() => {
                        line.transfer_qty = newTransferQty;
                    });
                }
            } else {
                if(parseFloat(transferQty) > (parseFloat(receiveWipQty) + parseFloat(productQty))) {
                    newTransferQty = parseFloat(receiveWipQty) + parseFloat(productQty);
                    console.log('2 calTransferQty newTransferQty ', newTransferQty);
                    Vue.nextTick(() => {
                        line.transfer_qty = newTransferQty;
                    });
                }
            }

            return newTransferQty;
        },

        calTransferWip(receiveWipQty, productQty, transferQty, line) {
            let vm = this;
            if (vm.organizationCode == 'M06' || vm.organizationCode == 'M12') {
                // คงคลังเย็น = (คงคลังเช้า + ผลผลิตที่ได้) - (สูญเสีย+จ่ายออก)
                const lossQty = parseFloat(line.loss_qty ? line.loss_qty : 0);
                const sumReceiveWipProductQty = (parseFloat(receiveWipQty) + parseFloat(productQty) - lossQty)
                // console.log('calTransferWip----------------> '
                //     , receiveWipQty, productQty, transferQty, lossQty
                // );

                if(parseFloat(sumReceiveWipProductQty) > parseFloat(transferQty)) {
                    return parseFloat(sumReceiveWipProductQty) - parseFloat(transferQty);
                } else {
                    return 0;
                }

            } else {
                const sumReceiveWipProductQty = parseFloat(receiveWipQty) + parseFloat(productQty)
                if(parseFloat(sumReceiveWipProductQty) > parseFloat(transferQty)) {
                    return parseFloat(sumReceiveWipProductQty) - parseFloat(transferQty);
                } else {
                    return 0;
                }
            }
        },

        getUomCodeDescription(uomCodes, uomCode) {
            if(!uomCode) {
                return "";
            }
            const foundUomCode = uomCodes.find(item => item.uom_code == uomCode);
            return foundUomCode ? foundUomCode.unit_of_measure : "";
        },

        onClear() {
            window.location = $route(pm_0031_index)
        },

        async onSave() {
            let vm = this;

            // function isUnique(arr) {
            //     console.log('isUnique', arr)
            //     return arr.length === new Set(arr).size
            // }

            // VALIDATE LINES
            const hasMissingProductDate = this.linesModel.filter(it => !it.product_date).length > 0;
            const hasMissingProductQty = this.linesModel.filter(it => !it.product_qty && !it.receive_wip).length > 0;
            const invalidLossQty = this.linesModel.filter(item => (parseFloat(item.product_qty) + parseFloat(item.receive_wip)) < parseFloat(item.loss_qty) ).length > 0;
            const cancelLien = this.linesModel.filter( function(item) {
                return (parseFloat(item.product_qty) == 0 || item.product_qty == null || item.product_qty == undefined) &&
                        (parseFloat(item.loss_qty) == 0 || item.loss_qty == null || item.loss_qty == undefined) &&
                        (parseFloat(item.transfer_qty) == 0 || item.transfer_qty == null || item.transfer_qty == undefined)
            }).length > 0; // อนุญาติให้คีย์ เป็น 0 ได้ กรณีที่ user คียผิด


            if ((hasMissingProductDate || hasMissingProductQty || invalidLossQty) && !cancelLien) {
                let errors = []
                if (hasMissingProductDate) { errors.push('วันที่ได้ผลผลิต') };
                if (hasMissingProductQty) { errors.push('ผลผลิตที่ได้') };
                if (invalidLossQty) { errors.push('ไม่สามารกรอกข้อมูล จำนวนสูญเสีย มากกว่า จำนวนผลผลิตที่ได้') } ;
                return showValidationFailedDialog(errors);
            }

            // showLoadingDialog();

            await http.post($route(api_pm_0031_save), {
                header: this.headerModel,
                lines: this.linesModel,
                wip_step: this.wipStep,
            }).then(async ({data}) => {

                await showSaveSuccessDialog();
                // await showLoadingDialog();
                await vm.onWipStepWasChanged(vm.wipStep);

            }).catch(err => {

                console.log('err', {...err})

                swal({
                    title: `\nเกิดข้อผิดพลาด`, // new line is a workaround for icon cover text
                    text: `<pre style="max-height: 500px;"> ${_get(err, 'response.data.message')} </pre>`,
                    html: true,
                    type: 'error',
                    showConfirmButton: true,
                    closeOnConfirm: true,
                    confirmButtonText: 'ปิด',
                }, (value) => {
                    console.log(value)
                });

            });

            // await this.getBatches();
            // await this.getWipSteps();
            // await this.getProductInfo();


        },
        async defProductQty() {
            let vm = this;
            if (vm.wipStep != 'WIP01' && (vm.organizationCode == 'M12' || vm.organizationCode == 'M06')) {
                // vm.linesModel[0].product_qty = 2000;
                // console.log('mappingLines1', vm.linesModel);
                vm.linesModel.forEach(async function(line) {
                    const previousWipLine = vm.previousWipLinesModel.find(previousLine => {
                        return previousLine.inventory_item_id == line.inventory_item_id;
                    });
                    let input = {
                        target: {
                            value: 0
                        }
                    };

                    if (previousWipLine) {
                        input.target.value = (parseFloat(line.product_qty) != 0 ) ? line.product_qty : previousWipLine.transfer_qty;
                        line.product_qty = input.target.value;
                        vm.lineProductQtyWasChanged(input, line)
                    }
                });
            }

        }

    },
}
</script>

