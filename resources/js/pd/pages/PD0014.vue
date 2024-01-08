<template>
    <div>
        <div class="ibox">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <h5>ประมาณการใช้วัตถุดิบในคงคลัง :</h5>
                    </div>
                    <div class="col-lg-9">
                        <div class="text-right">
                            <button class="btn btn-w-m btn-success" 
                                    data-toggle="modal"
                                    data-target="#ModalCreate" 
                                    @click="getYears">
                                <i class="fa fa-plus"></i> สร้าง
                            </button>
                            <button type="submit" 
                                    class="btn btn-w-m btn-default" 
                                    data-toggle="modal"
                                    data-target="#ModalSearch">
                                <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                            </button>
                            <button type="submit" 
                                    class="btn btn-w-m btn-primary" 
                                    @click="save">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก
                            </button>
                            <button type="submit" 
                                    class="btn btn-w-m buttonRetrieveLeaves"
                                    @click="retrieveLeaves"
                                    :disabled="this.isDisabled.retrieveLeaves">
                                ดึงข้อมูล % ใบยาจากสูตร
                            </button>
                            <button class="btn btn-w-m btn-info"
                                    @click="printAction"
                                    :disabled="this.isDisabled.printAction">
                                <i class="fa fa-print"></i> พิมพ์
                            </button>
                        </div>
                    </div>
                    <!-- Modal Create-->
                    <div class="modal fade" id="ModalCreate" tabindex="-1" role="dialog"
                            aria-labelledby="ModalCreateLabel"
                            aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="ModalCreateLabel">
                                        สร้างประมาณการใช้วัตถุดิบตามประมาณยอดจำหน่าย</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">                                    
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12">
                                            <div class="form-group row">                                                
                                                <div class="row col-12 ml-2">
                                                    <div class="form-group pl-2 pr-2 mb-0 col-3 mt-2">
                                                        <label class="text-left tw-font-bold tw-uppercase mb-1"> 
                                                            ปีงบประมาณอนุมัติ:
                                                        </label>
                                                        <div class="input-group">
                                                            <el-select v-model="search.salesFiscalYearNo" 
                                                                clearable 
                                                                placeholder="ปีงบประมาณอนุมัติ" 
                                                                size="small"
                                                                class="mr-2 form-control-file"
                                                                :popper-append-to-body="false"
                                                                @change="getSalesFiscals('get-salesFiscalYearTH')">
                                                                <el-option
                                                                    v-for="sales in salesFiscalYearNoCreateArr"
                                                                    :key="sales.sales_fiscal_year_no"
                                                                    :label="sales.sales_fiscal_year_no"
                                                                    :value="sales.sales_fiscal_year_no"
                                                                    >
                                                                </el-option>
                                                            </el-select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group pl-2 pr-2 mb-0 col-3 mt-2">
                                                        <label class="text-left tw-font-bold tw-uppercase mb-1"> 
                                                            ปีงบประมาณการจำหน่าย(ฝ่ายขาย):
                                                        </label>
                                                        <div class="input-group">
                                                            <el-select v-model="search.year" 
                                                                clearable 
                                                                placeholder="ปีงบประมาณการจำหน่าย(ฝ่ายขาย)" 
                                                                size="small"
                                                                class="mr-2 form-control-file"
                                                                :popper-append-to-body="false"
                                                                @change="getSalesFiscals('get-version')">
                                                                <el-option
                                                                    v-for="sales in salesFiscalYearTHCreateArr"
                                                                    :key="sales.sales_fiscal_year_th"
                                                                    :label="sales.sales_fiscal_year_th"
                                                                    :value="sales.sales_fiscal_year_th"
                                                                    >
                                                                </el-option>
                                                            </el-select>
                                                        </div>
                                                    </div>                                                    
                                                    <div class="form-group mb-0 col-3 mt-2">
                                                        <label class="text-left tw-font-bold tw-uppercase mb-1"> ปรับครั้งที่(ชนป.):</label>
                                                        <div class="input-group">
                                                            <el-select v-model="search.salesFiscalYearRevision" 
                                                                clearable 
                                                                placeholder="ปรับครั้งที่(ชนป.)" 
                                                                size="small"
                                                                class="mr-2 form-control-file"
                                                                :popper-append-to-body="false"
                                                                >
                                                                <el-option
                                                                    v-for="sales in salesFiscalsVersionCreateArr"
                                                                    :key="sales.sales_fiscal_year_revision"
                                                                    :label="sales.sales_fiscal_year_revision"
                                                                    :value="sales.sales_fiscal_year_revision"
                                                                    >
                                                                </el-option>
                                                            </el-select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                                        <div class="input-group" style="padding-top: 25px;">
                                                            <button type="button" 
                                                                    class="btn btn-w-m btn-default" 
                                                                    @click="searchSalesFiscal('search')">
                                                                <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" v-if="salesFiscals.length > 0 & showTable">
                                        <div style="height: 250px; overflow: scroll;">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th style="width:20%">ปีงบประมาณอนุมัติ</th>
                                                    <th style="width:20%">ปีงบประมาณการจำหน่าย(ฝ่ายขาย)</th>                                                    
                                                    <th style="width:20%">วันที่อนุมัติ</th>
                                                    <th style="width:20%">ปรับครั้งที่</th>
                                                    <th style="width:20%">ชื่อผู้สร้าง</th>
                                                    <th style="width:20%"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(salesFiscal, index) in salesFiscals" :key="index">
                                                        <td> {{ salesFiscal.sales_fiscal_year_no }} </td>
                                                        <td> {{ salesFiscal.sales_fiscal_year_th }} </td>
                                                        <td> {{ salesFiscal.approve_date }} </td>
                                                        <td> {{ salesFiscal.sales_fiscal_year_revision }} </td>
                                                        <td> {{ salesFiscal.user_name }} </td>
                                                        <td> 
                                                            <button @click="selectSalesFiscal(index)" 
                                                                    class="btn btn-primary btn-xs">
                                                                    เลือก
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                        <div class="form-group row mt-4">
                                            <div class="col-lg-12 text-center">
                                                <button type="button" class="btn btn-primary col-lg-2 p-2"  
                                                    data-dismiss="modal"
                                                    @click="createLine">
                                                    <i class="fa fa-check"></i>สร้าง
                                                </button>
                                                <button type="button" class="btn btn-danger col-lg-2 p-2"
                                                        data-dismiss="modal">
                                                    <i class="fa fa-times"></i>ยกเลิก
                                                </button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Modal Create -->

                    <!-- Edit Search -->
                    <div    class="modal inmodal fade" 
                            id="ModalSearch" 
                            tabindex="-1" 
                            role="dialog" 
                            style="display: none;" 
                            aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content" >
                                <div class="modal-header">
                                    <button type="button" 
                                            class="close" 
                                            data-dismiss="modal">
                                        <span aria-hidden="true">×</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="modal-title">ประมาณการยอดจำหน่ายประจำปี</h4>
                                </div>
                                <div class="modal-body" v-loading="loading.tempSearch">
                                    <div class="row">
                                        <div class="form-group col-3" style="padding-right: 10px;">
                                            <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณอนุมัติ:</label>
                                            <div class="input-group">
                                                <el-select v-model="salesFiscalYearNo" 
                                                    clearable 
                                                    placeholder="ปีงบประมาณอนุมัติ" 
                                                    style="width: 100%;"
                                                    :popper-append-to-body="false"
                                                    @change="getTempSalesFiscalYearTH(salesFiscalYearNo)">
                                                    <el-option
                                                        v-for="data in salesFiscalYearNoArr"
                                                        :key="data.sales_fiscal_year_no"
                                                        :label="data.sales_fiscal_year_no"
                                                        :value="data.sales_fiscal_year_no"
                                                        >
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div> 
                                        <div class="form-group col-3" style="padding-right: 10px;">
                                            <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณการจำหน่าย(ฝ่ายขาย):</label>
                                            <div class="input-group">
                                                <el-select v-model="year" 
                                                    clearable 
                                                    placeholder="ปีงบประมาณการจำหน่าย(ฝ่ายขาย)" 
                                                    style="width: 100%;"
                                                    :popper-append-to-body="false"
                                                    @change="getTempSalesFiscalYearRevision(year, salesFiscalYearNo)">
                                                    <el-option
                                                        v-for="year in salesFiscalYearTHArr"
                                                        :key="year.sales_fiscal_year_th"
                                                        :label="year.sales_fiscal_year_th"
                                                        :value="year.sales_fiscal_year_th"
                                                        >
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>                                        
                                        <div class="form-group col-3" style="padding-right: 10px;">
                                            <label class="text-left tw-font-bold tw-uppercase mb-1"> ปรับครั้งที่(ชนป.):</label>
                                            <div class="input-group">
                                                <el-select v-model="salesFiscalYearRevision" 
                                                    clearable 
                                                    placeholder="ปรับครั้งที่(ชนป.)" 
                                                    style="width: 100%;"
                                                    :popper-append-to-body="false"
                                                    @change="getTempFiscalYearVision(year, salesFiscalYearNo, salesFiscalYearRevision)"
                                                    >
                                                    <el-option
                                                        v-for="fiscalNo in salesFiscalYearRevisionArr"
                                                        :key="fiscalNo.sales_fiscal_year_revision"
                                                        :label="fiscalNo.sales_fiscal_year_revision"
                                                        :value="fiscalNo.sales_fiscal_year_revision"
                                                        >
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>  
                                        <div class="form-group col-3" style="padding-right: 10px;">
                                            <label class="text-left tw-font-bold tw-uppercase mb-1"> ครั้งที่ตามประมาณการวัตถุดิบ:</label>
                                            <div class="input-group">
                                                <el-select v-model="fiscalYearVision" 
                                                    clearable 
                                                    placeholder="ครั้งที่ตามประประมาณการวัตถุดิบ" 
                                                    style="width: 100%;"
                                                    :popper-append-to-body="false"
                                                    >
                                                    <el-option
                                                        v-for="data in fiscalYearVisionArr"
                                                        :key="data.fiscal_year_vision"
                                                        :label="data.fiscal_year_vision"
                                                        :value="data.fiscal_year_vision"
                                                        >
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>                                       
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-w-m btn-default" @click="searchHeaders">
                                            <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                                        </button>
                                    </div>
                                    <div>
                                        <table class="table mt-2">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle; text-align: center">
                                                        ปีงบประมาณอนุมัติ
                                                    </th>
                                                    <th style="vertical-align: middle; text-align: center">
                                                        ปีงบประมาณการจำหน่าย <br> (ฝ่ายขาย)
                                                    </th>
                                                    <th style="vertical-align: middle; text-align: center">
                                                        ปรับครั้งที่ <br> (ชนป.)
                                                    </th>
                                                    <th style="vertical-align: middle; text-align: center">
                                                        ครั้งที่ตามประมาณ <br> การวัตถุดิบ
                                                    </th>
                                                    <th style="vertical-align: middle; text-align: center">
                                                        ผู้สร้าง
                                                    </th>
                                                    <th style="vertical-align: middle; text-align: center">
                                                        วันที่อนุมัติ
                                                    </th>
                                                    <th style="vertical-align: middle; text-align: center">
                                                        สถานะ
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(header, index) in uHeaders" :key="index" style="cursor: pointer"
                                                    @click="selectHeader(header.web_h_id)" data-dismiss="modal">
                                                    <td style="vertical-align: middle; text-align: center">
                                                        {{ header.sales_fiscal_year_no }}
                                                    </td>
                                                    <td style="vertical-align: middle; text-align: center; background: none;">
                                                        {{ header.fiscal_year_th }}
                                                    </td>                                                    
                                                    <td style="vertical-align: middle; text-align: center">
                                                        {{ header.sales_fiscal_year_revision }}
                                                    </td>
                                                    <td style="vertical-align: middle; text-align: center">
                                                        {{ header.fiscal_year_vision }}
                                                    </td>
                                                    <td style="vertical-align: middle; text-align: center">
                                                        {{ header.user_name ? header.user_name : '' }}
                                                    </td>
                                                    <td style="vertical-align: middle; text-align: center">
                                                        <!-- {{  header.tran_approval_date && header.tran_status != 'INACTIVE' ? 
                                                            formatDate(header.tran_approval_date) : 
                                                            '' }} -->
                                                        {{  header.tran_approval_date ? 
                                                            formatDate(header.tran_approval_date) : 
                                                            '' }}
                                                    </td>
                                                    <td style="vertical-align: middle; text-align: center">
                                                        {{ header.tran_status }}
                                                    </td>
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

            <div class="ibox-content" v-loading="loading.form">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 row">
                        <div class="col-lg-6 col-sm-12 form-inline">
                            <div class="col-lg-3 col-form-label">
                                ปีงบประมาณ
                            </div>
                            <div class="col-lg-3 col-form-label">
                                <input  class="form-control text-center p-0 col-12" 
                                        disabled 
                                        v-model="form.period_year">
                            </div>
                            <div class="col-lg-3 col-form-label">
                                ครั้งที่
                            </div>
                            <div class="col-lg-3 col-form-label">
                                <input  class="form-control text-center p-0 col-12" 
                                        disabled
                                        type="text" 
                                        v-model="form.fiscal_year_vision">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 form-inline">
                            <div class="col-lg-3 col-form-label text-right">
                                วันที่สร้าง
                            </div>
                            <div class="col-lg-3 col-form-label">
                                <span class="remark"> {{ form.date_create }} </span>
                            </div>
                            <div class="col-lg-3 col-form-label text-right">
                                วันที่แก้ไขล่าสุด
                            </div>
                            <div class="col-lg-3 col-form-label">
                                <span class="remark">{{ form.date_updated }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 row">
                        <div class="col-lg-6 col-sm-12 form-inline">
                            <div class="col-lg-3 col-form-label">
                                อ้างอิงค่า LLD ปี <span class="text-danger"> * </span>
                            </div>
                            <div class="col-lg-3 col-form-label">
                                <!-- <input  class="form-control text-center p-0 col-12" 
                                        disabled 
                                        v-model="form.lld_year"> -->
                                <el-select 
                                    v-model="form.lld_year" 
                                    size="small"
                                    placeholder="เลือก" 
                                    :popper-append-to-body="false"
                                    :disabled="this.isDisabled.lldYear"
                                    class="form-group">
                                    <el-option
                                        v-for="(item, index) in LLDYearList"
                                        :key="index"
                                        :label="item.lld_year"
                                        :value="item.lld_year"
                                        >
                                    </el-option>
                                </el-select>       
                            </div>
                            <div class="col-lg-3 col-form-label">
                                ประมาณยอดจำหน่ายปี
                            </div>
                            <div class="col-lg-3 col-form-label">
                                <input  class="form-control text-center p-0 col-12" 
                                        disabled 
                                        type="text" 
                                        v-model="form.planning_year">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 form-inline">
                            <div class="col-lg-3 col-form-label text-right">
                                ครั้งที่
                            </div>
                            <div class="col-lg-3 col-form-label">
                                <input  class="form-control text-center p-0 col-12" 
                                        disabled 
                                        type="text" 
                                        v-model="form.sales_fiscal_year_no">
                            </div>
                            <div class="col-lg-3 col-form-label text-right">
                                ปรับครั้งที่ 
                            </div>
                            <div class="col-lg-3 col-form-label">
                                <input  class="form-control text-center p-0 col-12" 
                                        disabled 
                                        type="text" 
                                        v-model="form.sales_fiscal_year_revision">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 row">
                        <div class="col-lg-6 col-sm-12 form-inline">
                            <div class="col-lg-3 col-form-label">
                                ประเภท <span class="text-danger"> * </span>
                            </div>
                            <div class="col-lg-9 col-form-label">
                                <el-select 
                                    v-model="typeSelected" 
                                    size="small"
                                    clearable 
                                    placeholder="เลือก" 
                                    :popper-append-to-body="false"
                                    @change="getItems('tobacco_type')"
                                    :disabled="this.isDisabled.type"
                                    class="form-group">
                                    <el-option
                                        v-for="uType in types"
                                        :key="uType.ingredien_tobacco_type"
                                        :label="uType.ingredien_tobacco_desc"
                                        :value="uType.ingredien_tobacco_type"
                                        >
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 form-inline">
                            <div class="col-lg-3 col-form-label text-right">
                                ผู้บันทึก
                            </div>
                            <div class="col-lg-9 col-form-label">
                                <input  class="form-control col-12" 
                                        disabled 
                                        type="text" 
                                        :value="userProfile.user_name"
                                        style="width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 row">
                        <div class="col-lg-6 col-sm-12 form-inline">
                            <div class="col-lg-3 col-form-label">
                                กลุ่ม <span class="text-danger"> * </span>
                            </div>
                            <div class="col-lg-9 col-form-label">
                                <el-select v-model="speciesSelected" 
                                    clearable 
                                    size="small"
                                    placeholder="เลือก" 
                                    :popper-append-to-body="false"
                                    @change="getItems('tobacco_group')"
                                    :disabled="typeSelected == '1004' || this.isDisabled.species ? true : false"
                                    class="form-group">
                                    <el-option
                                        v-for="(value, index) in species"
                                        :key="index"
                                        :label="value.tobacco_type_desc"
                                        :value="value.tobacco_type_meaning"
                                        >
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 form-inline">
                            <div class="col-lg-3 col-form-label text-right">
                                วันที่อนุมัติ
                            </div>
                            <div class="col-lg-9 col-form-label">
                                <datepicker-th
                                    style="width: 100%; border-radius:3px;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="input_date"
                                    id="input_date"
                                    :disabled="this.isDisabled.tranApprovalDate"
                                    v-model="header.tran_approval_date"
                                    :format="transDate['js-format']"
                                    @dateWasSelected="updateApprove"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 row">
                        <div class="col-lg-6 col-sm-12 form-inline">
                            <div class="col-lg-3 col-form-label">
                                สถานะ
                            </div>
                            <div class="col-lg-9 col-form-label">
                                <el-select v-model="statusSelect" 
                                    clearable 
                                    size="small"
                                    placeholder="เลือก" 
                                    :popper-append-to-body="false"
                                    @change="checkStatus(statusSelect)"
                                    class="form-group"
                                    :disabled="this.isDisabled.status">
                                    <el-option
                                        v-for="(status, index) in statuses"
                                        :key="index"
                                        :label="status"
                                        :value="index"
                                        >
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 form-inline">
                            <div class="col-lg-3 col-form-label text-right">
                                หมายเหตุ
                            </div>
                            <div class="col-lg-9 col-form-label">
                                <el-input
                                    v-model="form.textarea"
                                    :autosize="{ minRows: 2, maxRows: 4 }"
                                    type="textarea"
                                    :disabled="this.isDisabled.textarea"
                                    maxlength="150"
                                />
                                <span style="color:red">
                                    *ช่องหมายเหตุ ไม่สามารถกรอกได้เกิน 150 ตัวอักษร
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox-title p-4" v-loading="loading.save">
            <div align="center" v-if="showLine & lines.length == 0">
                <h4> Data Not Found. </h4>
            </div>
            <div class="row align-items-center">

                <div style="width: 1920px; overflow: scroll; height: 700px; overflow: scroll;">
                    <table  width="100%" 
                            class="table" 
                            id="tableMainPDP0014" 
                            v-if="showLine && (typeSelected != '1004')">
                        <div v-for="(line, indexLine) in trlines" :key="indexLine">
                            <thead v-if="indexLine==0">
                                <tr class="first">
                                    <th class="w-150 text-center sticky-col" rowspan="3">
                                        <div class="h-150 p-2 tw-bg-gray-400"> ตราบุหรี่ </div>
                                    </th>
                                    <th class="w-200 text-center" rowspan="3">
                                        <div class="h-150 p-2 tw-bg-gray-400">ประมาณการจำหน่ายประจำปี (ล้านมวน) </div>
                                    </th>
                                    <th class="w-150 text-center" rowspan="3">
                                        <div class="h-150 p-2 tw-bg-gray-400">ค่า LLD (ก.ก./พันมวน) </div>
                                    </th>
                                    <th class="w-150 text-center" rowspan="3">
                                        <div class="h-150 p-2 tw-bg-gray-400"> จำนวนที่ใช้ต่อปี (ก.ก.) </div>
                                    </th>
                                    <th class="w-150 text-center" rowspan="3">
                                        <div class="h-150 p-2 tw-bg-gray-400"> จำนวนที่ใช้ต่อเดือน (ก.ก.) </div> 
                                    </th>
                                    <th class="w-20 text-center" :colspan="line.merge_tr*2">
                                        <div class="tw-bg-red-300 p-2"> ใบยา </div>
                                    </th>
                                </tr>
                                <tr class="second">
                                    <th v-for="(medicinalLeave, index) in line.medicinal_leaves" 
                                        :key="index" 
                                        colspan="2" 
                                        class="text-center w-300">
                                        <div class="p-2 tw-bg-green-200">{{ medicinalLeave }}</div>
                                    </th>
                                </tr>
                                <tr class="third">
                                    <th v-for="(mlTr, index) in line.medicinal_leaves_tr" 
                                        :key="index" 
                                        class="text-center">
                                        <div class="tw-bg-gray-400 p-2">
                                            {{  ( index % 2 ) == 0 ?  '%' : 'ก.ก.' }}
                                        </div>
                                    </th>
                                </tr>
                            </thead> 
                            <tbody v-for="(uLine, indexLine) in lines" :key="indexLine">
                                <tr>
                                    <td class="w-150 text-right" 
                                        style="vertical-align: middle;"> 
                                        {{ uLine.item_desc }} 
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine.quantity" 
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="4" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine.qty_lld"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine.year_quantity"  
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine.month_quantity"  
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-50" v-for="(mlTr, index) in uLine.medicinal_leaves_tr" :key="index">
                                        <span v-if="( index % 2 ) == 0">                                      
                                            <div v-if="!formLines[uLine.item_code+mlTr+speciesSelected]">
                                                <input
                                                type="text" 
                                                class="form-control text-right" 
                                                :disabled="true">
                                            </div>
                                            <div v-else>
                                                <vue-numeric 
                                                    separator="," 
                                                    v-bind:precision="3" 
                                                    v-bind:minus="false"
                                                    class="form-control text-right" 
                                                    :disabled="( index % 2 ) == 0 ?  false : true "
                                                    @change="inputData(formLines[uLine.item_code+mlTr+speciesSelected], formLines[uLine.item_code+mlTr+speciesSelected].ingredien_percent_item)"
                                                    v-model="formLines[uLine.item_code+mlTr+speciesSelected].ingredien_percent_item"
                                                    :value="uLine.month_quantity"  
                                                ></vue-numeric>
                                            </div>
                                        </span>
                                        <span v-if="( index % 2 ) != 0">
                                            <div v-if="!formLines[uLine.item_code+mlTr+speciesSelected]">
                                                <input
                                                type="text" 
                                                class="form-control text-right" 
                                                :disabled="true">
                                            </div>
                                            <div v-else>
                                                <vue-numeric 
                                                    separator="," 
                                                    v-bind:precision="3" 
                                                    v-bind:minus="false"
                                                    class="form-control text-right" 
                                                    disabled
                                                    :value="calculateKM(uLine, uLine.item_code, mlTr, speciesSelected, formLines)"
                                                ></vue-numeric>
                                            </div>
                                        </span>
                                    </td>
                                </tr>

                                <!-- Footer Sum -->
                                <tr v-if="totalLines == indexLine">
                                    <td class="w-150 text-right" 
                                        style="font-weight: bolder; backgroundColor: #bdbdbd;"> รวมการใช้ 6 เดือน </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="header.total_sales_qty_use_six_month"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="header.total_lld_qty_use_six_month"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="header.total_qty_year_use_six_month"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="header.total_qty_month_use_six_month"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-50" v-for="(mlTr, index) in uLine.medicinal_leaves_tr" :key="index">
                                        <span v-if="( index % 2 ) == 0">                                
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="sumLinesCasing(mlTr, speciesSelected)/2"
                                                style="font-weight: bolder;"
                                            ></vue-numeric>
                                        </span>
                                    
                                        <span v-if="( index % 2 ) != 0"> 
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="sumKgLinesCasing(mlTr, speciesSelected)/2"
                                                style="font-weight: bolder;"
                                            ></vue-numeric>
                                        </span>
                                    </td>
                                </tr>
                                <tr v-if="totalLines == indexLine">
                                    <td class="w-150 text-right" 
                                        style="font-weight: bolder; backgroundColor: #bdbdbd"> รวมการใช้ทั้งปี</td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="header.total_sales_qty_use_year"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="header.total_lld_qty_use_year"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                       <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="header.total_qty_year_use_year"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="header.total_qty_month_use_year"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-50" v-for="(mlTr, index) in uLine.medicinal_leaves_tr" :key="index">
                                        <span v-if="( index % 2 ) == 0">                                            
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="sumLinesCasing(mlTr, speciesSelected)"
                                                style="font-weight: bolder;"
                                            ></vue-numeric>
                                        </span>
                                    
                                        <span v-if="( index % 2 ) != 0"> 
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="sumKgLinesCasing(mlTr, speciesSelected)"
                                                style="font-weight: bolder;"
                                            ></vue-numeric>
                                        </span>
                                    </td>
                                </tr>
                                <tr v-if="totalLines == indexLine">
                                    <td class="w-150 text-right"
                                        style="font-weight: bolder; backgroundColor: #bdbdbd;"> รวมการใช้ต่อเดือน</td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="header.total_sales_qty_use_month"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="header.total_lld_qty_use_month"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="header.total_qty_year_use_month"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="header.total_qty_month_use_month"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-50" v-for="(mlTr, index) in uLine.medicinal_leaves_tr" :key="index">
                                        <span v-if="( index % 2 ) == 0">                                            
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="sumLinesCasing(mlTr, speciesSelected)/12"
                                                style="font-weight: bolder;"
                                            ></vue-numeric>
                                        </span>
                                    
                                        <span v-if="( index % 2 ) != 0">
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="sumKgLinesCasing(mlTr, speciesSelected)/12"
                                                style="font-weight: bolder;"
                                            ></vue-numeric>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </div>
                    </table>

                    <table  width="100%" 
                            class="table" 
                            id="tableMainPDP0014" 
                            v-if="showLine && (typeSelected == '1004')">
                        <div v-for="(line, indexLine) in trlines" :key="indexLine">
                            <thead v-if="indexLine == 0">
                                <tr class="first">
                                    <th class="w-150 text-center sticky-col" rowspan="3">
                                        <div class="h-150 p-2 tw-bg-gray-400">ตราบุหรี่</div>
                                    </th>
                                    <th class="w-200 text-center" rowspan="3">
                                        <div class="h-150 p-2 tw-bg-gray-400">ประมาณการจำหน่ายประจำปี (ล้านมวน)</div>
                                    </th>
                                    <th class="w-150 text-center" rowspan="3">
                                        <div class="h-150 p-2 tw-bg-gray-400">ค่า LLD (ก.ก./พันมวน)</div>
                                    </th>
                                    <th class="w-150 text-center" rowspan="3">
                                        <div class="h-150 p-2 tw-bg-gray-400">จำนวนที่ใช้ต่อปี (ก.ก.)</div>
                                    </th>
                                    <th class="w-150 text-center" rowspan="3">
                                        <div class="h-150 p-2 tw-bg-gray-400">จำนวนที่ใช้ต่อเดือน (ก.ก.)</div>
                                    </th>
                                    <th class="w-20 text-center" :colspan="line.merge_tr*2">
                                        <div class="tw-bg-red-300 p-2">ใบยา</div>
                                    </th>
                                </tr>
                                <tr class="second">
                                    <th v-for="(medicinalLeave, index) in line.medicinal_leaves" 
                                        :key="index" 
                                        colspan="2" 
                                        class="w-300 text-center">
                                        <div class="p-2 tw-bg-green-200"> {{ medicinalLeave }} </div>
                                    </th>
                                </tr>
                                <tr class="third">
                                    <th v-for="(mlTr, index) in line.medicinal_leaves_tr" 
                                        :key="index" 
                                        class="text-center">
                                        <div class="tw-bg-gray-400 p-2"> 
                                            {{  ( index % 2 ) == 0 ?  'ต่อ 1,000 ก.ก.' : 'ก.ก.' }} 
                                        </div>
                                    </th>
                                </tr>
                            </thead> 
                            <tbody v-for="(uLine, indexLine) in lines" :key="indexLine">
                                <tr>
                                    <td class="w-150 text-right" style="vertical-align: middle;"> 
                                        {{ uLine.item_desc }} 
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine.quantity"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="4" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine.qty_lld"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine.year_quantity"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine.month_quantity"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-50" v-for="(mlTr, index) in uLine.medicinal_leaves_tr" :key="index">
                                        <span v-if="( index % 2 ) == 0">                                             
                                            <vue-numeric 
                                                v-if="formLines[uLine.item_code+mlTr+'all']"
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="formLines[uLine.item_code+mlTr+'all'].sum_ingredien_percent_item"                                            
                                            ></vue-numeric>
                                            <input 
                                                v-if="!formLines[uLine.item_code+mlTr+'all']"
                                                type="text" 
                                                class="form-control text-right" 
                                                :disabled="true"
                                            >
                                        </span>
                                        <span v-if="( index % 2 ) != 0"> 
                                            <vue-numeric 
                                                v-if="formLines[uLine.item_code+mlTr+'all']" 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="formLines[uLine.item_code+mlTr+'all'].cal_leaves_qty_use"
                                            ></vue-numeric>
                                            <input  
                                                v-if="!formLines[uLine.item_code+mlTr+'all']" 
                                                class="form-control text-center" 
                                                disabled 
                                                type="text">
                                        </span>
                                    </td>
                                </tr>

                                <tr v-if="totalLines == indexLine">
                                    <td class="w-150 text-right" 
                                        style="font-weight: bolder; backgroundColor: #bdbdbd;"> รวมการใช้ 6 เดือน </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumMonth('quantity')/2"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="4" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumMonth('qty_lld')/2"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumMonth('year_quantity')/2"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumMonth('month_quantity')/2"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-50" v-for="(mlTr, index) in uLine.medicinal_leaves_tr" :key="index">
                                        <span v-if="( index % 2 ) == 0">                                             
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="sumLines(mlTr)/2"
                                                style="font-weight: bolder;"
                                            ></vue-numeric>
                                        </span>
                                    
                                        <span v-if="( index % 2 ) != 0"> 
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="sumKgLines(mlTr)/2"
                                                style="font-weight: bolder;"
                                            ></vue-numeric>
                                        </span>
                                    </td>
                                </tr>
                                <tr v-if="totalLines == indexLine">
                                    <td class="w-150 text-right"
                                        style="font-weight: bolder; backgroundColor: #bdbdbd;"> รวมการใช้ทั้งปี</td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumMonth('quantity')"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="4" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumMonth('qty_lld')"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumMonth('year_quantity')"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumMonth('month_quantity')"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-50" v-for="(mlTr, index) in uLine.medicinal_leaves_tr" :key="index">
                                        <span v-if="( index % 2 ) == 0">
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="sumLines(mlTr)"
                                                style="font-weight: bolder;"
                                            ></vue-numeric>
                                        </span>
                                    
                                        <span v-if="( index % 2 ) != 0"> 
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="sumKgLines(mlTr)"
                                                style="font-weight: bolder;"
                                            ></vue-numeric>
                                        </span>
                                    </td>
                                </tr>
                                <tr v-if="totalLines == indexLine">
                                    <td class="w-150 text-right"
                                        style="font-weight: bolder; backgroundColor: #bdbdbd;"> รวมการใช้ต่อเดือน</td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumMonth('quantity')/12"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="4" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumMonth('qty_lld')/12"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumMonth('year_quantity')/12"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-150 text-right">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumMonth('month_quantity')/12"
                                            style="font-weight: bolder;"
                                        ></vue-numeric>
                                    </td>
                                    <td class="w-50" v-for="(mlTr, index) in uLine.medicinal_leaves_tr" :key="index">
                                        <span v-if="( index % 2 ) == 0"> 
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="sumLines(mlTr)/12"
                                                style="font-weight: bolder;"
                                            ></vue-numeric>
                                        </span>
                                    
                                        <span v-if="( index % 2 ) != 0"> 
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="3" 
                                                v-bind:minus="false"
                                                class="form-control text-right" 
                                                disabled
                                                :value="sumKgLines(mlTr)/12"
                                                style="font-weight: bolder;"
                                            ></vue-numeric>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </div>
                    </table>
                </div>

            </div>
        </div>
    </div>
</template>

<style>

.modal-body {
    padding: 15px !important;
}

/* modal กลางหน้าจอ */
.modal-dialog {
    height: 80% !important;
    padding-top: 10%;
}

/* end modal กลางหน้าจอ*/


</style>
<script>
import moment from "moment";
import VueNumeric from 'vue-numeric'
export default {
    components: { VueNumeric },
    props: ['user-profile',
            'trans-date',
            'token',
            'trans-btn',
            'types',
            'statuses',
            'headers',
            'formLine',
            'h-years',
            'salesFiscalYearNoCreateArr',
            'salesFiscalYearNoArr',
            'LLDYearList'],

    mounted() {

    },
    data() {
        return {
            years:                          [],
            year:                           "",
            salesFiscal:                    "",
            salesFiscalNumber:              "",
            salesFiscalVersion:             "",
            salesFiscals:                   [],
            salesFiscalsVersionCreateArr:   [],
            dialogTableVisible:             false,
            showTable:                      false,
            showLine:                       false,            
            lines:                          [],
            dLines:                         [],
            trlines:                        [],
            medicinal_leaves:               [],
            species:                        [],
            header:                         [],
            salesFiscalYearRevision:        "",
            salesFiscalYearRevisionArr:     [],
            salesFiscalYearNo:              "",
            fiscalYearVision:               "",
            fiscalYearVisionArr:            [],
            uHeaders:                       [],
            items:                          [],
            typeSelected:                   "",
            statusSelect:                   "INACTIVE",
            speciesSelected:                "",
            formLines:                      [],
            nameUserDefaultLogin:           this.userProfile.user_name,
            salesFiscalYearTHCreateArr:     [],
            salesFiscalYearTHArr:           [],

            form: {
                year:                       '',
                lld_year:                   '',
                planning_year:              '',
                sales_fiscal_year_no:       '',
                sales_fiscal_year_revision: '',
                fiscal_year_vision:         '',
                date_updated:               '',
                status:                     'INACTIVE',
                date_create:                '',
                date_updated:               '',
                textarea:                   ''
            },

            form_update: {
                tran_status:        "",
                lines:              [],
                tran_approval_date: "",
            },
        
            loading: {
                form:       false,
                tempSearch: false,
                create:     false,
                save:       false,
            },

            search: {
                year:                       '',
                salesFiscalYearNo:          '',
                salesFiscalYearRevision:    ''
            },

            isDisabled: {
                species:            true,
                type:               true,
                status:             true,
                tranApprovalDate:   true,
                textarea:           true,
                printAction:        true,
                retrieveLeaves:     true,
                lldYear:            true
            },
        }
    },

    methods: {
        getYears(){
            axios.get('/pd/ajax/pdp0014/get-years').then(response => {
                if (response.status == 200) {
                    this.years =  response.data.years;
                }
            })
            .catch(error => {

            })
        },

        getTempSalesFiscalYearTH(salesFiscalYearNo){
            this.loading.tempSearch         = true;
            this.salesFiscalYearNo          = salesFiscalYearNo ? salesFiscalYearNo : this.salesFiscalYearNo;
            this.salesFiscalYearRevisionArr = [];
            this.fiscalYearVisionArr        = [];
            this.year                       = '';
            this.salesFiscalYearRevision    = '';
            this.fiscalYearVision           = '';

            axios.get('/pd/ajax/pdp0014/get-temp-sales-fiscal-year-TH'+'?salesFiscalYearNo='+this.salesFiscalYearNo)
                .then(response => {
                    if (response.status == 200) {
                        this.salesFiscalYearTHArr = response.data.salesFiscalYearTHArr;
                    }
                    this.loading.tempSearch = false;
                })
                .catch(error => {
                    this.loading.tempSearch = false;
                })
        },

        getTempSalesFiscalYearRevision(fiscalYearTHH, salesFiscalYearNoH){
            this.loading.tempSearch         = true;
            this.salesFiscalYearRevisionArr = [];
            this.salesFiscalYearRevision    = "";
            this.fiscalYearVisionArr        = [];
            this.fiscalYearVision           = '';

            let params = {
                year: fiscalYearTHH ? fiscalYearTHH : this.year,
                salesFiscalYearNo: salesFiscalYearNoH ? salesFiscalYearNoH : this.salesFiscalYearNo
            };
            axios.get( '/pd/ajax/pdp0014/get-temp-sales-fiscal-year-revision',{params})
                .then(response => {
                    if (response.status == 200) {
                        this.salesFiscalYearRevisionArr = response.data.salesFiscalYearRevision;
                    }
                    this.loading.tempSearch = false;
                })
                .catch(error => {
                    this.loading.tempSearch = false;
                })
        },

        getTempFiscalYearVision(fiscalYearTHH, salesFiscalYearNoH, salesFiscalYearRevisionH){
            this.loading.tempSearch = true;
            this.fiscalYearVisionArr = [];
            this.fiscalYearVision    = "";
            let params = {
                year: fiscalYearTHH ? fiscalYearTHH : this.year,
                salesFiscalYearNo: salesFiscalYearNoH ? salesFiscalYearNoH : this.salesFiscalYearNo,
                salesFiscalYearRevision: salesFiscalYearRevisionH ? salesFiscalYearRevisionH : this.salesFiscalYearRevision
            };
            axios.get( '/pd/ajax/pdp0014/get-temp-fiscal-year-vision',{params})
                .then(response => {
                    if (response.status == 200) {
                        this.fiscalYearVisionArr = response.data.fiscalYearVision;
                    }
                    this.loading.tempSearch = false;
                })
                .catch(error => {
                    this.loading.tempSearch = false;
                })
        },

        searchHeaders(){
            this.uHeaders = [];
            this.loading.tempSearch = true;
            let params = {
                year:                       this.year,
                salesFiscalYearNo:          this.salesFiscalYearNo,
                salesFiscalYearRevision:    this.salesFiscalYearRevision,
                fiscalYearVision:           this.fiscalYearVision
            };
            axios.get('/pd/ajax/pdp0014/search-headers',{params}).then(response => {
                if (response.status == 200) {
                    this.uHeaders =  response.data.headers;
                }

                this.loading.tempSearch = false;
            })
            .catch(error => {
                this.loading.tempSearch = false;
            })
        },

        getSalesFiscals(action){
            this.showTable          = true;
            this.dialogTableVisible = true;

            if(action == 'get-salesFiscalYearTH'){
                this.salesFiscalYearTHCreateArr     = [];
                this.search.year                    = '';
                this.salesFiscalsVersionCreateArr   = [];
                this.search.salesFiscalYearRevision = '';
            }

            if(action == 'get-version'){
                this.salesFiscalsVersionCreateArr   = [];
                this.search.salesFiscalYearRevision = '';
            }

            axios.get('/pd/ajax/pdp0014/get-sales-fiscals'
                        +'?action='+action
                        +'&year='+this.search.year 
                        +'&salesFiscalYearNo='+this.search.salesFiscalYearNo 
                        +'&salesFiscalYearRevision='+this.search.salesFiscalYearRevision 
                ).then(response => {
                if (response.status == 200) {
                    if(action == "get-salesFiscalYearTH"){                        
                        this.salesFiscalYearTHCreateArr = response.data.salesFiscalYearTHCreateArr;
                    }

                    if(action == "get-version"){                        
                        this.salesFiscalsVersionCreateArr = response.data.salesFiscalsVersionCreateArr;
                    }
                }
            }).catch(error => {

            }) 
        },

        searchSalesFiscal(action){
            console.log('aa')
            axios.get('/pd/ajax/pdp0014/get-sales-fiscals'
                        +'?action='+action
                        +'&year='+this.search.year 
                        +'&salesFiscalYearNo='+this.search.salesFiscalYearNo
                        +'&salesFiscalYearRevision='+this.search.salesFiscalYearRevision 
                ).then(response => {
                if (response.status == 200) {
                    this.salesFiscals =  response.data.salesFiscals;
                }
            }).catch(error => {

            }) 
        },

        selectSalesFiscal(index){
            this.form.textarea                  = '';
            this.statusSelect                   = '';
            this.header.tran_approval_date      = '';
            this.dialogTableVisible             = false;
            this.showTable                      = false;

            this.search.salesFiscalYearNo       = this.salesFiscals[index].sales_fiscal_year_no;
            this.getSalesFiscals('get-salesFiscalYearTH');
            this.search.year                    = this.salesFiscals[index].sales_fiscal_year_th;
            this.getSalesFiscals('get-version');
            this.search.salesFiscalYearRevision = this.salesFiscals[index].sales_fiscal_year_revision;
        },

        insertHeader(){
            this.form.period_year                   = this.header.sales_fiscal_year_th;
            this.form.lld_year                      = this.header.lld_year ? this.header.lld_year : (new Date().getFullYear() + 543);
            this.form.planning_year                 = this.header.sales_fiscal_year_th;
            this.form.sales_fiscal_year_no          = this.header.sales_fiscal_year_no;
            this.form.sales_fiscal_year_revision    = this.header.sales_fiscal_year_revision;
            this.form.fiscal_year_vision            = this.header.fiscal_year_vision;
            this.form.date_updated                  = this.header.last_update_date;
           
            this.isDisabled.type        = false;
            this.isDisabled.status      = false;
            this.isDisabled.textarea    = false;
            this.isDisabled.lldYear     = false;
        },

        getItems(type){
            if(type == 'tobacco_type'){
                this.showTable = false;
                this.trlines = [];
                axios.get('/pd/ajax/pdp0014/search-species',{
                    params: {
                        tobacco_type_code: this.typeSelected
                    }
                }).then(response => {
                    if(response.data.species.length > 0){
                        this.speciesSelected = '';
                        this.isDisabled.species = false;
                        this.species = response.data.species;

                        if(this.typeSelected == '1004'){
                            this.speciesSelected = 'all';
                            this.isDisabled.species = true;

                            if(this.typeSelected && this.speciesSelected && this.form.fiscal_year_vision){
                                this.isDisabled.printAction = false;
                            }else{
                                this.isDisabled.printAction = true;
                            }
                            return this.getLines(this.header.web_h_id, 'all', this.typeSelected);
                        }          
                    }else{
                        this.isDisabled.species = true;
                        this.speciesSelected = '';
                        this.species = [];
                        this.isDisabled.printAction = true;
                    }                    
                }).catch(error => {
                    
                }) 
            }else{
                if(this.typeSelected && this.speciesSelected && this.form.fiscal_year_vision){
                    if(type == 'tobacco_type'){
                        this.speciesSelected = null;
                    }
                    this.isDisabled.printAction = false;
                    this.getLines(this.header.web_h_id, this.speciesSelected, this.typeSelected);
                }else{
                    this.isDisabled.printAction = true;
                }
            }            
        },

        async createLine(){
            this.loading.form                       = true;
            await this.insertHeader();

            this.form.sales_fiscal_year_no          = this.search.salesFiscalYearNo;
            this.form.sales_fiscal_year_revision    = this.search.salesFiscalYearRevision;
            this.form.year                          = this.search.year;    

            await axios.post('/pd/ajax/pdp0014/create-line', this.form).then(response => {
                if(response.data.result == 'E'){
                    this.form.year                          = '';
                    this.search.year                        = '';
                    this.form.sales_fiscal_year_no          = '';
                    this.search.salesFiscalYearNo           = '';
                    this.form.sales_fiscal_year_revision    = '';
                    this.search.salesFiscalYearRevision     = '';
                    this.userProfile.user_name              = '';

                    return swal({
                        title: `\nเกิดข้อผิดพลาด`, 
                        text: response.data.resultMsg,
                        type: 'error',
                        html: true,
                        showConfirmButton: true,
                        closeOnConfirm: true,
                        confirmButtonText: 'ตกลง',                    
                    });
                }else{
                    this.afterCallHeader(response);
                    this.afterCallLines(response);
                }
                 this.loading.form  = false;
            }).catch(error => {
                this.loading.form  = false;
            }).finally((e) => {
                this.loading.form  = false;
            }) 
        },

        checkStatus(status){
            this.form_update.tran_status                = status;

            if(status == 'APPROVED'){
                this.isDisabled.tranApprovalDate        = false;
            }
            
            if(status == 'INACTIVE' || status === ''){
                this.isDisabled.tranApprovalDate        = true;
                this.header.tran_approval_date          = "";
                this.form_update.tran_approval_date     = "";
                this.form.tran_approval_date            = "";
                this.header.date                        = "";
                this.$children[11].date                 = "";
            }
        },

        inputData(arrItem, value){
            this.form_update.lines.push(arrItem)
        },

        save(){
            let vm = this;
            if(this.statusSelect == 'APPROVED'){
                if(this.$children[11].date == null){
                    return swal({
                        title: `\n เกิดข้อผิดพลาด `,// new line is a workaround for icon cover text
                        text: 'กรุณาเลือก วันที่อนุมัติ',
                        type: 'error',
                        html: true,
                        showConfirmButton: true,
                        closeOnConfirm: true,
                        confirmButtonText: 'ตกลง',
                    });                    
                }
            }

            this.loading.save = true;
            let params = {
                form_update: this.form_update,
                textarea: this.form.textarea
            };
            axios.post('/pd/ajax/pdp0014/update-line/'+this.header.web_h_id, {params})
                 .then(response => {
                if(response.data.result == 'E'){
                    this.loading.save = false;
                    swal({
                        title: `\nเกิดข้อผิดพลาด`,
                        text: response.data.resultMsg,
                        type: 'error',
                        html: true,
                        showConfirmButton: true,
                        closeOnConfirm: true,
                        confirmButtonText: 'ตกลง',
                        cancelButtonText: 'ยกเลิก',
                        showCancelButton: true,
                    },function(isConfirm){
                        if(isConfirm){
                            let params = {
                                tran_approval_date: vm.form_update.tran_approval_date,
                                textarea:           vm.form.textarea
                            };
                            vm.loading.save = true;
                            axios.get('/pd/ajax/pdp0014/get-confirm-approved/'+vm.header.web_h_id, {params})
                                .then(response => {
                                if(response.data.result == 'C'){
                                    vm.alertSucces('สำเร็จ');
                                    vm.selectHeader(vm.header.web_h_id);
                                    vm.searchHeaders();
                                    vm.loading.save = false;
                                }                
                            })
                            .catch(error => {
                                
                            }) 
                        }
                    });
                }else{
                    this.alertSucces('สำเร็จ');
                    this.selectHeader(this.header.web_h_id);
                    this.searchHeaders();
                    this.loading.save = false;
                }
            }).catch(error => {
                this.loading.save = false;
                return swal({
                    title: `\nเกิดข้อผิดพลาด`,
                    text: error,
                    type: 'error',
                    html: true,
                    showConfirmButton: true,
                    closeOnConfirm: true,
                    confirmButtonText: 'ตกลง',
                }, (error) => {
                    resolve(error);
                });
            }).finally((e) => {
                this.loading.save = false;
            }) 
        },

        selectHeader(id){
            console.log('aa')
            axios.get('/pd/ajax/pdp0014/select-header/'+id)
                 .then(response => {
                    let header                      = response.data.header;                    

                    this.form.lld_year              = header.lld_year ? header.lld_year : (new Date().getFullYear() + 543);
                    this.year                       = header.fiscal_year_th;
                    this.header                     = header;    
                    this.form.tran_approval_date    = header.tran_approval_date;
                    this.form.date_create           = header.creation_date;
                    this.form.date_updated          = header.last_update_date;
                    this.statusSelect               = header.tran_status;    
                    this.salesFiscalYearNo          = header.sales_fiscal_year_no;
                    this.salesFiscalYearRevision    = header.sales_fiscal_year_revision;
                    this.fiscalYearVision           = header.fiscal_year_vision;  
                    this.form.textarea              = header.attribute1;
                    this.userProfile.user_name      = header.name_user;
                    this.typeSelected               = '';
                    this.speciesSelected            = '';
                    this.species                    = [];
                    this.lines                      = [];
                    this.trlines                    = [];
                    this.dLines                     = [];
                    this.formLines                  = [];

                    this.isDisabled.species         = true;
                    this.isDisabled.retrieveLeaves  = false;
                    this.showLine                   = false;

                    this.getTempSalesFiscalYearTH(header.sales_fiscal_year_no);
                    this.getTempSalesFiscalYearRevision(header.fiscal_year_th, header.sales_fiscal_year_no);
                    this.getTempFiscalYearVision(header.fiscal_year_th, header.sales_fiscal_year_no, header.sales_fiscal_year_revision);
                    this.checkStatus(header.tran_status);                       
            }).then(() => {
                this.insertHeader();
            })
            .catch(error => {
                
            }) 
        },

        getLines(id, ingredien_species_type, ingredien_tobacco_type){
                this.lines              = [];
                this.trlines            = [];
                this.medicinal_leaves   = [];
                this.dLines             = [];
                this.formLines          = [];
            axios.get('/pd/ajax/pdp0014/get-lines/'+id
                +'?ingredien_species_type='
                +ingredien_species_type
                +'&ingredien_tobacco_type='
                +ingredien_tobacco_type
                ).then(response => {
                    if(response.data.status == 'S'){
                        this.afterCallLines(response)
                        this.showLine = true;
                    } 
                    if(response.data.status == 'E'){
                        this.showLine = true;
                    }
            }).catch(error => {
                this.lines              = [];
                this.trlines            = [];
                this.medicinal_leaves   = [];
                this.dLines             = [];
                this.formLines          = [];
                this.showLine           = false;
                return swal({
                    title: `\n None Found Data `,// new line is a workaround for icon cover text
                    text: error,
                    type: 'error',
                    html: true,
                    showConfirmButton: true,
                    closeOnConfirm: true,
                    confirmButtonText: 'ตกลง',
                });
            }) 
        },

        afterCallHeader(response){
            this.header                             = response.data.header;
            this.header_web_h_id                    = response.data.header.web_h_id;
            this.form.date_create                   = response.data.header.creation_date;
            this.form.date_updated                  = response.data.header.last_update_date;
            this.year                               = response.data.header.year;
            this.form.period_year                   = response.data.header.sales_fiscal_year_th;
            this.form.planning_year                 = response.data.header.sales_fiscal_year_th;
            this.form.lld_year                      = response.data.header.lld_year ? response.data.header.lld_year : (new Date().getFullYear() + 543);
            this.form.sales_fiscal_year_revision    = response.data.header.sales_fiscal_year_revision;     
            this.userProfile.user_name              = this.nameUserDefaultLogin;     
        },

        afterCallLines(response){
            this.lines              = response.data.lines;
            this.trlines            = response.data.header_table;
            this.medicinal_leaves   = response.data.medicinalLeaves;
            this.dLines             = response.data.dLines;
            this.formLines          = response.data.mapLines;
        },

        beforeCallLines(){
            this.lines              = [];
            this.trlines            = [];
            this.medicinal_leaves   = [];
            this.dLines             = [];
            this.formLines          = [];
        },
        alertSucces(msg=null){
            return new Promise((resolve) => {
                swal({
                    title: `\nสำเร็จ`,// new line is a workaround for icon cover text
                    text: msg,
                    type: 'success',
                    dangerMode: false,
                    showConfirmButton: true,
                    closeOnConfirm: true,
                    confirmButtonText: 'ปิด',
                }, (value) => {
                    resolve(value);
                });
            });
        },

        sumLines(mlTr){
            const arr = Object.values(this.dLines).filter(item => {
                return item.medicinal_leaves == mlTr
            })

            return arr.reduce((a, b) =>  a + parseFloat(b.sum_ingredien_percent_item), 0);  
        },

        sumKgLines(mlTr){
            const arr = Object.values(this.dLines).filter(item => {
                return item.medicinal_leaves == mlTr 
            })


            const items = Object.values(this.lines);

            return  arr.reduce((acc, item) => {
                return acc + Number(item.cal_leaves_qty_use);
                // let nItem = items.find(nItem =>{ return  nItem.item_code  == item.item_code});
                // return acc + (item.sum_ingredien_percent_item * nItem.year_quantity);
            }, 0);
        },

        sumLinesCasing(mlTr, speciesSelected){
            let arrX = [];
            let i = 0;
            arrX[mlTr] = [];
            const arr = Object.values(this.dLines).filter(item => {
                return item.medicinal_leaves == mlTr
            })

            arr.forEach(( item, index ) => {
                arrX[mlTr][i] = typeof  this.formLines[item.item_code + item.medicinal_leaves + speciesSelected] != "undefined" ? 
                                        this.formLines[item.item_code + item.medicinal_leaves + speciesSelected].ingredien_percent_item : 0;
                i++;
            });
            
            return arrX[mlTr].reduce((a, b) =>  a + parseFloat(b), 0);       
        },

        sumKgLinesCasing(mlTr, speciesSelected){
            let arrX = [];
            let i = 0;
            arrX[mlTr] = [];
            const arr = Object.values(this.dLines).filter(item => {
                return item.medicinal_leaves == mlTr
            })

            arr.forEach(( item, index ) => {
                arrX[mlTr][i] = typeof  this.formLines[item.item_code + item.medicinal_leaves + speciesSelected] != "undefined" ? 
                                        this.formLines[item.item_code + item.medicinal_leaves + speciesSelected].qty_use_year * 
                                        (this.formLines[item.item_code + item.medicinal_leaves + speciesSelected].ingredien_percent_item * 0.01) : 0;
                i++;
            });
            
            return arrX[mlTr].reduce((a, b) =>  a + parseFloat(b), 0);        
        },

        updateApprove(date){
            this.form_update.tran_approval_date = this.convertDate(this.$emit("dateWasSelected", date).$children[11].date);
        },

        convertDate(inputFormat) {
            const pad = (s) => (s < 10) ? '0' + s : s;
            const d = new Date(inputFormat);
            return [ pad(d.getDate()), pad(d.getMonth() + 1), d.getFullYear() ].join('/');
        },

        calculateKM(uLine, uLineItemCode, mlTr, speciesSelected, formLines){
            return uLine.year_quantity * (  formLines[uLine.item_code+mlTr+speciesSelected] ? 
                                            formLines[uLine.item_code+mlTr+speciesSelected].ingredien_percent_item * 0.01 : 
                                            0);
        },
        
        formatDate(date){
            return moment(date).add(543, "years").format("DD-MM-YYYY");
        },

        sumMonth(f){
            let arrX = [];
            let i = 0;
            const items = Object.values(this.lines);

            if(f == 'quantity'){
                items.forEach(( item, index ) => {
                    arrX[i] = item.quantity;
                    i++;
                });
            }else if(f == 'qty_lld'){
                items.forEach(( item, index ) => {
                    arrX[i] = item.qty_lld;
                    i++;
                });
            }else if(f == 'year_quantity'){
                items.forEach(( item, index ) => {
                    arrX[i] = item.year_quantity;
                    i++;
                });
            }else if(f == 'month_quantity'){
                items.forEach(( item, index ) => {
                    arrX[i] = item.month_quantity;
                    i++;
                });
            }
            
            return arrX.reduce((a, b) =>  a + parseFloat(b), 0);
        },

        printAction() {
            let salesFiscalYearTH           = this.year;
            let salesFiscalYearNo           = this.salesFiscalYearNo;
            let salesFiscalYearRevision     = this.salesFiscalYearRevision;
            let fiscalYearVision            = this.fiscalYearVision;
            let ingredienTobaccoType        = this.typeSelected;
            let ingredienSpeciesType        = this.speciesSelected;
            let id                          = this.header.web_h_id;
            location.href=  '/ir/reports/get-param?salesFiscalYearTH='+ salesFiscalYearTH +
                            '&salesFiscalYearNo='+ salesFiscalYearNo +
                            '&salesFiscalYearRevision='+ salesFiscalYearRevision +
                            '&fiscalYearVision='+ fiscalYearVision +
                            '&ingredienTobaccoType='+ ingredienTobaccoType +
                            '&ingredienSpeciesType='+ ingredienSpeciesType +
                            '&id='+ id +
                            '&program_code=PDR0007&function_name=PDR0007&output=pdf';
        },

        async retrieveLeaves(){
            let vm = this;
            let params = {
                P_LLD_YEAR: vm.form.lld_year,
            };
            swal({
                title: "คุณแน่ใจไหม ?",
                text: "การดึงข้อมูลใหม่ อาจทำให้ข้อมูลที่เคยบันทึกอยู่สูญหาย คุณยืนยันที่จะดำเนินการต่อหรือไม่",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true
            },
            async function(isConfirm) {
                if (isConfirm) {
                    axios.get('/pd/ajax/pdp0014/retrieve-leaves/'+vm.header.web_h_id,{params})
                    .then(response => {
                        if(response.data.result == 'C'){
                            swal({
                                title: `\nสำเร็จ`,// new line is a workaround for icon cover text
                                text: response.data.resultMsg,
                                type: 'success',
                                dangerMode: false,
                                showConfirmButton: true,
                                closeOnConfirm: true,
                                confirmButtonText: 'ปิด'
                            });
                            vm.selectHeader(vm.header.web_h_id);
                        }                        
                    }).catch(error => {
                        
                    })
                }
            });
        }
    },
    computed: {
        totalLines(){
            return  Object.keys(this.lines).length-1;
        },
    },
}
</script>
<style scope>  
    #tableMainPDP0014 {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    #tableMainPDP0014 tbody > tr > td:first-child {
        background: #fff;
        position: sticky;
        left: 0px;
        width: min-content;
        padding: 2px 5px 5px 5px;
        overflow-x: auto;
    }

    #tableMainPDP0014 thead {
        position: sticky;
        top: 0;
        z-index: 1;
        background: #fff;
    }

    #tableMainPDP0014 tr.first {
        top: 0;
        background: white;
    }

    #tableMainPDP0014 tr.second {
        top: 0;
        position: -webkit-sticky;
        background: white;
    }

    #tableMainPDP0014 tr.third {
        top: 0;
        position: -webkit-sticky;
        background: white;
    }

    .sticky-col {
        position: -webkit-sticky;
        position: sticky;
        left: 0;
        background: white;
        z-index: 2;
    }

    .buttonRetrieveLeaves,
    .buttonRetrieveLeaves:hover, 
    .buttonRetrieveLeaves:disabled {
        background-color: #F77D24; /* Green */
        color: white;
    }
</style>
