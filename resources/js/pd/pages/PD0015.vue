<template>
    <div>
        <div class="ibox">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <h5>ประมาณการใช้วัตถุดิบในคงคลัง :</h5>
                    </div>
                    <div class="col-lg-8">
                        <div class="text-right">
                            <button type="submit" 
                                    class="btn btn-w-m btn-default" 
                                    data-toggle="modal"
                                    data-target="#ModalSearch">
                                <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                            </button>
                            <button class="btn btn-w-m btn-info"
                                    @click="printAction">
                                <i class="fa fa-print"></i> พิมพ์
                            </button>
                        </div>
                    </div>

                    <!-- Edit Search -->
                    <div    class="modal inmodal fade" 
                            id="ModalSearch" 
                            tabindex="-1" 
                            role="dialog" 
                            style="display: none;" 
                            aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content" v-loading="loading.search">
                                <div class="modal-header">
                                    <button type="button" 
                                            class="close" 
                                            data-dismiss="modal">
                                        <span aria-hidden="true">×</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="modal-title">ประมาณการยอดจำหน่ายประจำปี</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-3" style="padding-right: 10px;">
                                            <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณอนุมัติ:</label>
                                            <div class="input-group">
                                                <el-select v-model="search.salesFiscalYearNo" 
                                                    clearable 
                                                    placeholder="ปีงบประมาณอนุมัติ" 
                                                    style="width: 100%;"
                                                    :popper-append-to-body="false"
                                                    @change="getTempSalesFiscalYearTH">
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
                                                <el-select v-model="search.year" 
                                                    clearable 
                                                    placeholder="ปีงบประมาณการจำหน่าย(ฝ่ายขาย)" 
                                                    style="width: 100%;"
                                                    :popper-append-to-body="false"
                                                    @change="getTempSalesFiscalYearRevision">
                                                    <el-option
                                                        v-for="year in yearHeaders"
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
                                                <el-select v-model="search.salesFiscalYearRevision" 
                                                    clearable 
                                                    placeholder="ปรับครั้งที่(ชนป.)" 
                                                    style="width: 100%;"
                                                    :popper-append-to-body="false"
                                                    @change="getTempFiscalYearVision"
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
                                                <el-select v-model="search.fiscalYearVision" 
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
                                        <button type="button" class="btn btn-w-m btn-default" @click="getHeader()">
                                            <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                                        </button>
                                    </div>      
                                </div>
                                <div class="modal-footer">
                                    <div style="height: 100%; width: 100%; overflow: scroll;">
                                        <table class="table">
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
                                                <tr v-for="(header, index) in headers" :key="index" style="cursor: pointer"
                                                    @click="selectHeader(header.web_h_id)" data-dismiss="modal">
                                                    <td style="vertical-align: middle; text-align: center">
                                                        {{ header.sales_fiscal_year_no }}
                                                    </td>
                                                    <td style="vertical-align: middle; text-align: center">
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
                                                        {{ header.tran_approval_date ? formatDate(header.tran_approval_date) : '' }}
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
                                        v-model="form.period_year_no">
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
                                ประเภท <span class="text-danger"> * </span>
                            </div>
                            <div class="col-lg-9 col-form-label">
                                <el-select 
                                    v-model="typeSelected" 
                                    size="small"
                                    clearable 
                                    placeholder="Select" 
                                    :popper-append-to-body="false"
                                    @change="checkCall"
                                    class="form-group"
                                    :disabled="this.isDisabled.type">
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
                                <el-select 
                                    v-model="speciesSelected" 
                                    clearable 
                                    size="small"
                                    placeholder="Select" 
                                    :popper-append-to-body="false"
                                    @change="getItems"
                                    :disabled="typeSelected == '1004' || this.isDisabled.species ? true : false"
                                    class="form-group">
                                    <el-option
                                        v-for="(value, index) in uSpecies"
                                        :key="index"
                                        :label="value.tobacco_type_desc"
                                        :value="value.tobacco_type_meaning"
                                        >
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox-title p-4">
            <div class="row align-items-center" v-if="items.length > 0">
                <div style="width: 1920px; overflow: scroll; height: 500px; overflow: scroll;">
                    <table width="100%" id="tableMainPDP0015" class="table table-bordered table-hover" >
                        <div v-if="typeSelected == '1001'">
                            <thead>
                                <tr class="first">
                                    <th class="w-300 text-center sticky-col"
                                        style="background: white; vertical-align: middle;" 
                                        rowspan="3"> 
                                        <h5>กลุ่มใบยา</h5>
                                    </th>
                                    <th class="w-150 text-center" 
                                        rowspan="3"> 
                                        <h5>อัตราการใช้ต่อเดือน (ก.ก./เดือน)</h5>
                                    </th>
                                    <th class="text-center tw-bg-red-300" 
                                        :colspan="Object.keys(medicinal_leaves_cl).length">
                                        <h5>คงคลัง</h5>
                                    </th>
                                    <th class="w-150 text-center" 
                                        rowspan="3"> 
                                        <h5>รวมทั้งหมด </h5>
                                    </th>
                                    <th class="w-150 text-center" 
                                        rowspan="3"> 
                                        <h5>เหลือคงใช้ (เดือน) </h5>
                                    </th>
                                </tr>
                                <tr class="second">
                                    <th v-for="(col, indexCol) in medicinalLeaves_tr_subInv" 
                                        :key="indexCol" 
                                        :colspan="col['colspan_shot_sub_inv']" 
                                        class="w-150 text-center tw-bg-green-300">
                                        {{ col.name }}
                                    </th>
                                </tr>
                                <tr class="third">
                                    <th v-for="(cl, index) in medicinal_leaves_cl" 
                                        :key="index" 
                                        class="w-150 text-center tw-bg-yellow-100">
                                        {{ cl[0].lot_number }}
                                    </th>
                                </tr>
                            </thead> 
                            
                            <tbody  v-for="(uLine, indexLine) in medicinal_leaves" 
                                    :key="indexLine">
                                <tr>
                                    <td style="vertical-align: middle;"> {{ indexLine }}  </td>
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine[0].sum_qty_use_month ? Number(uLine[0].sum_qty_use_month) : 0"
                                        ></vue-numeric>
                                    </td>
                                    <td v-for="(cl, index) in medicinal_leaves_cl" :key="index" class="w-150 text-center">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="linesMap[indexLine+''+index] ? linesMap[indexLine+''+index]['sum_qty'] : 0"
                                        ></vue-numeric>
                                    </td>
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="calculateSumQTY(indexLine)"
                                        ></vue-numeric>
                                    </td>
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="calculate(  uLine[0].sum_qty_use_month ? 
                                                                Number(uLine[0].sum_qty_use_month) : 1, 
                                                                indexLine                                   )"
                                        ></vue-numeric>
                                    </td>
                                </tr>
                                <tr v-if="uLine[0].seq == uLine[0].total_raw">
                                    <td style="vertical-align: middle;"> รวมทั้งหมด </td>
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="calculateSumRow()"
                                        ></vue-numeric>
                                    </td>
                                    <td v-for="(cl, index) in medicinal_leaves_cl" :key="index" class="w-150 text-center">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumQty(index)"
                                        ></vue-numeric>
                                    </td>
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="calculateSumTotalRow()"
                                        ></vue-numeric>
                                    </td>
                                    <td> 
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="calculateSumRemainingRow()"
                                        ></vue-numeric>
                                    </td>
                                </tr>
                            </tbody>
                        </div>

                        <div v-if="typeSelected == '1002'">
                            <thead>
                                <tr>
                                    <th class="w-300 text-center sticky-col" 
                                        style="background: white; vertical-align: middle;"
                                        rowspan="2">ใบยา
                                    </th>
                                    <th class="w-150 text-center" 
                                        rowspan="2">อัตราการใช้ใบยา ต่อเดือน 
                                    </th>
                                    <th class="text-center tw-bg-red-300" 
                                        :colspan="Object.keys(medicinal_leaves_cl).length"> คงคลัง ใบยาต่างประเทศ
                                    </th>
                                    <th class="w-150 text-center" 
                                        rowspan="2"> รวมทั้งหมด 
                                    </th>
                                    <th class="w-150 text-center" 
                                        rowspan="2">เหลือคงใช้ (เดือน) 
                                    </th>
                                </tr>
                                <tr>
                                    <th v-for="(cl, index) in medicinal_leaves_cl" 
                                        :key="index" 
                                        class="w-150 text-center tw-bg-yellow-100">
                                        {{ index }}
                                    </th>
                                </tr>                                
                            </thead> 
                            <tbody v-for="(uLine, indexLine) in medicinal_leaves" :key="indexLine">
                                <tr>
                                    <td style="vertical-align: middle;"> {{ indexLine }}  </td>
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine[0].qty_use_month ? uLine[0].qty_use_month : 0"
                                        ></vue-numeric>
                                    </td>
                                    <td v-for="(cl, index) in medicinal_leaves_cl" :key="index" class="w-150 text-center">                                    
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="linesMap[indexLine+''+index] ? 
                                                    linesMap[indexLine+''+index].onhand_quantity : 0"
                                        ></vue-numeric>
                                    </td>
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine[0].sum_qty"
                                        ></vue-numeric>
                                    </td>
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine[0].avaliable_qty"
                                        ></vue-numeric>
                                    </td>
                                </tr>
                                <tr v-if="uLine[0].seq == uLine[0].total_raw">
                                    <td> รวมทั้งหมด </td>
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sum_medicinal_leaves"
                                        ></vue-numeric>
                                    </td>
                                    <td v-for="(cl, index) in medicinal_leaves_cl" :key="index" class="w-150 text-center">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="sumQty(index)"
                                        ></vue-numeric>
                                    </td>
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="total.onhand"
                                        ></vue-numeric>
                                    </td>
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="total.avaliable"
                                        ></vue-numeric>
                                    </td>
                                </tr>
                            </tbody>
                        </div>

                        <div v-if="typeSelected == '1004'">
                            <thead>
                                <tr>
                                    <th class="w-300 text-center sticky-col" 
                                        style="background: white; vertical-align: middle;"
                                        rowspan="2">เครื่องปรุงบุหรี่
                                    </th>
                                    <th class="w-150 text-center" 
                                        rowspan="2">อัตราการใช้ต่อเดือน (ก.ก./เดือน)
                                    </th>
                                    <th class="text-center tw-bg-red-300" 
                                        :colspan="Object.keys(medicinal_leaves_cl).length"> คลัง 
                                    </th>
                                    <th class="w-150 text-center" 
                                        rowspan="2"> รวมทั้งหมด 
                                    </th>
                                    <th class="w-150 text-center" 
                                        rowspan="2">เหลือคงใช้ (เดือน) 
                                    </th>
                                </tr>
                                <tr>
                                    <th v-for="(cl, index) in medicinal_leaves_cl" :key="index" class="w-150 text-center tw-bg-yellow-100">
                                        {{ index }}
                                    </th>
                                </tr>
                                
                            </thead> 
                            <tbody v-for="(uLine, indexLine) in medicinal_leaves" :key="indexLine">
                                <tr>
                                    <td style="vertical-align: middle;"> {{ indexLine }}  </td>
                                    <td>
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine[0].qty_use_month ? Number(uLine[0].qty_use_month) : 0"
                                        ></vue-numeric>
                                    </td>
                                    <td v-for="(cl, index) in medicinal_leaves_cl" :key="index" class="w-150 text-center">
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="linesMap[indexLine+''+index]  ? linesMap[indexLine+''+index].onhand_quantity : 0"
                                        ></vue-numeric>
                                    </td>
                                    <td> 
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="uLine[0].sum_qty"
                                        ></vue-numeric>
                                    </td>
                                    <td> 
                                        <vue-numeric 
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            disabled
                                            :value="calculate(uLine[0].qty_use_month ? Number(uLine[0].qty_use_month) : 1, indexLine)"
                                        ></vue-numeric>
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
import VueNumeric from 'vue-numeric'
import moment from "moment";
export default {
    components: { VueNumeric },
    props: ['user-profile',
            'trans-date',
            'token',
            'trans-btn',
            'types',
            'statuses',
            'species',
            'formLine',
            'salesFiscalYearNoArr'],

    mounted() {

    },

    data() {
        return {
            batchNo:                    "",
            years:                      [],
            year:                       "",
            salesFiscal:                "",
            salesFiscalNumber:          "",
            salesFiscalVersion:         "",
            salesFiscals:               [],
            dialogTableVisible:         false,
            dialogFormVisible:          false,
            yearNumber:                 "",
            showTable:                  false,
            showLine:                   false,
            header:                     "",
            lines:                      [],
            dLines:                     [],
            trlines:                    [],
            medicinal_leaves:           [],
            medicinal_leaves_cl:        [],
            medicinalLeaves_tr_org:     [],
            items:                      [],
            typeSelected:               "",
            statusSelect:               "INACTIVE",
            speciesSelected:            "",
            form_input:                 {},
            formLines:                  [],
            numRaw:                     0,
            year_no:                    "",
            linesMap:                   [],
            headers:                    [],
            uSpecies:                   this.species ? this.species : [],
            sum_medicinal_leaves:       0,
            avaliableQty:               [],
            salesFiscalYearRevisionArr: [],
            fiscalYearVisionArr:        [],
            yearHeaders:                [],
            total:                      [],

            form:{
                header_id:              "",
                period_year:            "",
                period_year_no:         "",
                date_create:            "",
                date_updated:           "",
                lld_year:               "",
                planning_year:          "",
                planning_no:            "",
                planning_updated:       "",
                planning_version:       "",
                sales_fiscal_version:   "",
                sales_fiscal_no:        "",
                lines:                  [],
                type:                   "",
                status:                 "INACTIVE",
                tran_approve_date:      "",
            },

            form_update:{
                header_id:              "",
                lines:                  [],
                tran_approve_date:      "",
                
            },
            
            loading:{
                form:                   false,
                search:                 false
            },

            search: {
                year:                       "",
                salesFiscalYearNo:          "",
                salesFiscalYearRevision:    "",
                fiscalYearVision:           ""
            },

            isDisabled:{
                type:                   true,
                species:                true
            },
        }
    },

    methods: {
        getHeader(){
            this.loading.search = true;
            let params = {
                year: this.search.year,
                salesFiscalYearNo: this.search.salesFiscalYearNo,
                salesFiscalYearRevision: this.search.salesFiscalYearRevision,
                fiscalYearVision: this.search.fiscalYearVision
            };
            axios.get('/pd/ajax/pdp0015/get-headers',{params})
                .then(response => {
                if (response.status == 200) {
                    this.headers =  response.data.headers;
                }
                this.loading.search = false;
            })
            .catch(error => {
                this.loading.search = false;
            })
        },

        getSalesFiscals(){
            this.showTable = true;
            this.dialogTableVisible = true;
            axios.get('/pd/ajax/pdp0014/get-sales-fiscals').then(response => {
                if (response.status == 200) {
                    this.salesFiscals =  response.data.salesFiscals;
                }
            }).catch(error => {

            }) 
        },

        insertHeader(){
            this.form.period_year       = this.year;
            this.form.period_year_no    = this.yearNumber;
            this.form.lld_year          = 2563;
            this.form.planning_year     = this.salesFiscal;
            this.form.planning_no       = this.salesFiscalNumber;
            this.form.planning_version  = this.salesFiscalVersion;

            this.isDisabled.type        = false;
        },
        
        checkCall(){
            if(this.typeSelected == '1004'){
                this.speciesSelected        = "ALL";
                this.medicinalLeaves_tr_org = [];
                this.medicinal_leaves       = [];
                this.getItems();
            } else {
                if(this.typeSelected == ''){
                    this.isDisabled.species = true;
                    this.speciesSelected    = '';
                }else{
                    this.medicinalLeaves_tr_org = [];
                    this.medicinal_leaves       = [];
                    this.speciesSelected        = "";
                    var request = {
                        params: {
                            type: this.typeSelected,
                        }
                    }
                    axios.get('/pd/ajax/pdp0015/get-species', request).then(response => {
                        this.uSpecies = response.data.species;
                        this.isDisabled.species = false;
                    }).catch(error => {
                        this.isDisabled.species = true;
                    }) 
                }                
            }
        },

        createLine(){
            this.form.type  = this.typeSelected;
            this.form.status = this.statusSelect;
            this.loading.form  = true;
            this.insertHeader();

            axios.post('/pd/ajax/pdp0014/create-line', this.form).then(response => {
                if(response.data.result == 'E'){
                    return swal({
                        title: `\nเกิดข้อผิดพลาด`, 
                        text: response.data.e,
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

        getItems(){
            var request = {
                params: {
                    type:           this.typeSelected,
                    batch_no:       this.batchNo,
                    species_type:  this.speciesSelected
                }
            }
            this.items = [];
            axios.get('/pd/ajax/pdp0015/get-items', request).then(response => {
                this.batchNo                = response.data.batchNo;
                this.items                  = response.data.data.items;
                this.medicinal_leaves       = response.data.data.medicinal_leaves;
                this.medicinal_leaves_cl    = response.data.data.medicinal_leaves_tr;
                this.linesMap               = response.data.data.mapLines;
                this.medicinalLeaves_tr_org = response.data.data.medicinalLeaves_tr_org;
                this.sum_medicinal_leaves   = response.data.data.sum_medicinal_leaves;
                this.total                  = response.data.data.total;

                this.isDisabled.species     = false;
            }).catch(error => {
                this.isDisabled.species     = true;
            }) 
        },

        selectHeader(id){
            axios.get('/pd/ajax/pdp0015/select-header/'+id).then(response => {
                let header                  = response.data.header;
                this.form.lld_year          = header.sales_fiscal_year_no;
                this.year                   = header.fiscal_year_th;
                this.yearNumber             = header.fiscal_year_vision;
                this.salesFiscal            = header.sales_fiscal_year_th;
                this.salesFiscalNumber      = header.sales_fiscal_year_no;
                this.salesFiscalVersion     = header.sales_fiscal_year_revision;
                this.header                 = header;    
                this.form.tran_approve_date = moment(header.tran_approval_date)
                                                .add(543, "years")
                                                .format("YYYY-MM-DD"); 
                this.form.date_create       = moment(header.creation_date)
                                                .add(543, "years")
                                                .format("YYYY-MM-DD");
                this.form.date_updated      = moment(header.last_update_date)
                                                .add(543, "years")
                                                .format("YYYY-MM-DD");
                this.batchNo                = response.data.batchNo;
            }).then(() => {
                this.insertHeader();
            })
            .catch(error => {

            }).finally(() => {
                this.loading.form == false;
            }) 

        },

        printAction() {
            let salesFiscalYearTH           = this.search.year;
            let salesFiscalYearNo           = this.search.salesFiscalYearNo;
            let salesFiscalYearRevision     = this.search.salesFiscalYearRevision;
            let fiscalYearVision            = this.search.fiscalYearVision;
            let ingredienTobaccoType        = this.typeSelected;
            let ingredienSpeciesType        = this.speciesSelected;
            let id                          = this.header.web_h_id;
            location.href       = '/ir/reports/get-param?salesFiscalYearTH='+ salesFiscalYearTH +
                                  '&salesFiscalYearNo='+ salesFiscalYearNo +
                                  '&salesFiscalYearRevision='+ salesFiscalYearRevision +
                                  '&fiscalYearVision='+ fiscalYearVision +
                                  '&ingredienTobaccoType='+ ingredienTobaccoType +
                                  '&ingredienSpeciesType='+ ingredienSpeciesType +
                                  '&id='+ id +
                                  '&program_code=PDR0008&function_name=PDR0008&output=pdf';
        },

        afterCallHeader(response){
            this.header             = response.data.header;
            this.header_web_h_id    = response.data.header.web_h_id;
            this.form.date_create   = moment(response.data.header.creation_date)
                                        .add(543, "years")
                                        .format("YYYY-MM-DD");
            this.form.date_updated  = moment(response.data.header.last_update_date)
                                        .add(543, "years")
                                        .format("YYYY-MM-DD");

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

        formatDate(date){
            return moment(date).add(543, "years").format("DD-MM-YYYY");
        },

        sumQty(key){
            let arr = this.medicinal_leaves_cl[key];
            let sum = arr.reduce((acc, item) => {
                return acc + (item.onhand_quantity ? Number(item.onhand_quantity) : 0);
            }, 0);
            return sum;
        },

        calculate(uesMonth, indexLine){
            let sum = [];
            let total = 0;
            let i = 0;
            sum[indexLine] = [];
            $.each(this.linesMap, function( index, item ) {
                if(indexLine == item.medicinal_leaves){                    
                    total = typeof item.sum_qty === "undefined" ? 0 : Number(item.sum_qty);
                    sum[indexLine][i] = total;
                    i++;
                }
            });

            return sum[indexLine][0] / Number(uesMonth)
        },

        calculateSumQTY(indexLine){
            let sum     = [];
            let i       = 0;
            sum[indexLine] = [];
            $.each(this.linesMap, function( index, item ) {
                if(indexLine == item.medicinal_leaves){ 
                    sum[indexLine][i] = typeof item.sum_qty === "undefined" ? 0 : Number(item.sum_qty);
                    i++;
                }
            });

            return sum[indexLine].reduce((a, b) => a + b, 0);
        },

        calculateSumRow(){
            let sum = [];
            let i = 0;
            $.each(this.medicinal_leaves, function( index, item ) {
                sum[i] = Number(item[0].sum_qty_use_month);
                i++;
            });

            return sum.reduce((a, b) => a + b, 0);
        },

        calculateSumTotalRow(){
            let sum = [];
            let i = 0;
            let total = 0;
            $.each(this.linesMap, function( index, item ) {
                total = typeof item.sum_qty === "undefined" ? 0 : Number(item.sum_qty);
                sum[i] = total;
                i++;
            });
            return sum.reduce((a, b) => a + b, 0);
        },

        calculateSumRemainingRow(){
            let sum_qty     = [];
            let i           = 0;
            let uesMonth    = 0;
            let sum         = [];
            let j           = 0; 
            let total       = 0;
            let totalSum    = 0;
            let totalQTY    = 0;
            $.each(this.medicinal_leaves, function( index, item ) {                
                $.each(item, function( key, data ) {
                    if(key == 0){
                        totalQTY = typeof data.sum_qty_use_month === "undefined" ? 0 : Number(data.sum_qty_use_month);
                        sum_qty[i] = totalQTY
                        i++;
                    }
                });
            });

            uesMonth = sum_qty.reduce((a, b) => a + b, 0)

            $.each(this.linesMap, function( index, item ) {
                total = typeof item.sum_qty === "undefined" ? 0 : Number(item.sum_qty);
                sum[j] = total;
                j++;
            });
            totalSum = sum.reduce((a, b) => a + b, 0)

            return totalSum / uesMonth
        },

        getTempSalesFiscalYearTH(){
            this.loading.tempSearch                 = true;
            this.yearHeaders                        = [];
            this.search.year                        = "";
            this.salesFiscalYearRevisionArr         = [];
            this.search.salesFiscalYearRevision     = "";
            this.fiscalYearVisionArr                = [];
            this.search.fiscalYearVision            = "";

            axios.get('/pd/ajax/pdp0015/get-temp-sales-fiscal-year-TH'+'?salesFiscalYearNo='+this.search.salesFiscalYearNo)
                .then(response => {
                    if (response.status == 200) {
                        this.yearHeaders = response.data.salesFiscalYearTHArr;
                    }
                    this.loading.tempSearch = false;
                })
                .catch(error => {
                    this.loading.tempSearch = false;
                })
        },

        getTempSalesFiscalYearRevision(){
            this.loading.tempSearch                 = true;
            this.salesFiscalYearRevisionArr         = [];
            this.search.salesFiscalYearRevision     = "";
            this.fiscalYearVisionArr                = [];
            this.search.fiscalYearVision            = "";
            let params = {
                year: this.search.year,
                salesFiscalYearNo: this.search.salesFiscalYearNo
            };
            axios.get( '/pd/ajax/pdp0015/get-temp-sales-fiscal-year-revision',{params})
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

        getTempFiscalYearVision(){
            this.loading.tempSearch         = true;
            this.fiscalYearVisionArr        = [];
            this.search.fiscalYearVision    = "";
            let params = {
                year: this.search.year,
                salesFiscalYearNo: this.search.salesFiscalYearNo,
                salesFiscalYearRevision: this.search.salesFiscalYearRevision
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
    },
    computed: {
        totalLines(){
            return  Object.keys(this.lines).length-1;
        },

        medicinalLeaves_tr_subInv: function () {
            return _.orderBy(this.medicinalLeaves_tr_org, 'name')
        }
    },
}
</script>

<style scope>
    #tableMainPDP0015 {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    #tableMainPDP0015 tbody > tr > td:first-child {
        background: #fff;
        position: sticky;
        left: 0px;
        width: min-content;
        padding: 2px 5px 5px 5px;
        overflow-x: auto;
    }

    #tableMainPDP0015 thead {
        position: sticky;
        top: 0;
        z-index: 1;
        background: #fff;
    }

    #tableMainPDP0015 tr.first {
        padding: 3px;
        background: white;
    }

    #tableMainPDP0015 tr.second {
        padding: 3px;
        position: -webkit-sticky;
        background: white;
    }

    #tableMainPDP0015 tr.third {
        padding: 3px;
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
</style>
