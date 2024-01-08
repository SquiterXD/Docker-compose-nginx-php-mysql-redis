<template>
    <div class="" v-loading="loading.approveProcess">

        <div class="ibox float-e-margins mb-2" >
            <div class="col-12 text-right mt-1">
                <modal-search
                    :btnTrans="btnTrans"
                    :url="url"
                    :budgetYears="modalSearchInput.budget_years"
                    :monthList="modalSearchInput.month_list"
                    :canEdit="canEdit"
                    :search="[]" />

                <modal-create
                    class="pr-2"
                    :btnTrans="btnTrans"
                    :url="url"
                    :modalCreateInput="modalCreateInput" />


                <button v-if="canEdit" type="button" :class="btnTrans.save.class + ' btn-lg tw-w-25'" @click.prevent="saveChangeInput()">
                    <i :class="btnTrans.save.icon"></i>
                    {{ btnTrans.save.text }}
                </button>

                <button v-if="canApprove" type="button" :class="btnTrans.approve.class + ' btn-lg tw-w-25'" @click.prevent="checkApprove()">
                    <i :class="btnTrans.approve.icon"></i>
                    {{ btnTrans.approve.text }}
                </button>

                <button type="button" :class="btnTrans.print.class + ' btn-lg tw-w-25'" >
                    <i :class="btnTrans.print.icon"></i>
                    {{ btnTrans.print.text }}
                </button>

            </div>
        </div>


        <div class="card border-primary mb-3 mt-3">
            <div class="card-body">
                <header-detail :url="url" :canEdit="canEdit" :btnTrans="btnTrans" :adjustData="adjustData" />
                <div class="row">
                    <div class="col-8 b-r">
                        <div class="row">
                            <div class="col-lg-12">
                                <dl class="row mb-0 mt-3">
                                    <div class="col-sm-2 pl-0 text-sm-right">
                                        <dt>ประมาณการผลิต:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <div>
                                            <!-- <el-radio-group v-model="selTabName" size="small"> -->
                                            <el-radio-group v-model="productType" size="small">
                                                <template v-for="(product, index) in productTypes">
                                                <el-radio :label="product.lookup_code" class="mr-1 mb-1" border>
                                                    {{ product.meaning }}
                                                </el-radio>
                                                </template>
                                            </el-radio-group>
                                        </div>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabs-container mb-3">
            <ul class="nav nav-tabs" role="tablist">
                <li>
                    <a class="nav-link active" data-toggle="tab" href="#tab1" @click="clickSelTabName = 'tab1'">
                        ประมาณกำลังการผลิต
                    </a>
                </li>
                <li>
                    <a class="nav-link " data-toggle="tab" href="#tab2" @click="clickSelTabName = 'tab2'">
                        ประมาณการผลิตแยกรายตรา
                    </a>
                </li>
            </ul>
            <div class="tab-content" v-loading="loading2">
                <div role="tabpanel" id="tab1" class="tab-pane active">
                    <div class="panel-body ">
                        <div v-html="tab1Html"></div>
                    </div>
                </div>
                <div role="tabpanel" id="tab2" class="tab-pane ">
                    <div class="panel-body ">
                        <div v-if="productType == 'KK'" v-html="adjKkTableHtml[productType]"></div>
                        <div v-else class="">

                            <!-- <div class="col-md-7 offset-md-5  mt-3">
                                <template v-for="(summary, sumKey, sumIndex) in adjSummaryData[key]">
                                    <div v-html="summary['total_working_html']"></div>
                                </template>
                                &nbsp;
                            </div> -->
                            <div class="col-lg-12 text-right " v-if="showData && false">
                                <template v-for="(summary, sumKey, sumIndex) in adjSummaryData[productType]">
                                    <!-- <div v-html="summary['total_working_html']"></div> -->
                                    <modal-html
                                        class="text-right"
                                        :modalId="sumKey"
                                        :html="summary['total_working_html']"
                                        :modalTitle="modalTotalWorking.title + ' ปักษ์ที่ ' + sumKey"
                                        :btnTrans="btnTrans"
                                        :btnText="modalTotalWorking.btn_name"
                                        />
                                </template>

                                <button type="button" :disabled="!canEdit" :class="btnTrans.create.class + ' btn-lg tw-w-25'" @click="addLine()" >
                                    <i :class="btnTrans.create.icon"></i>
                                    เพิ่มตราบุหรี่
                                </button>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="table-responsive m-t mb-3">
                            <table class="table-freeze table text-nowrap table-bordered" v-if="adjBiweeklyData[productType]">
                                <thead>
                                    <tr>
                                        <th class="align-middle text-center" rowspan="2">ลำดับ</th>
                                        <th class="align-middle text-center" rowspan="2">ตรา</th>
                                        <th class="align-middle text-center" rowspan="2">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <br>รหัสบุหรี่<br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </th>
                                        <th class="align-middle text-center" rowspan="2">ตราบุหรี่</th>
                                        <template v-for="(biweekly, keyBiweekly, index) in adjBiweeklyData[productType]">
                                            <th class="text-center text-white" :style="'background-color: '+ colorCode.biweekly[index]" colspan="7">
                                                ปักษ์ที่ {{ keyBiweekly }}
                                            </th>
                                        </template>
                                        <template v-for="(biweekly, keyBiweekly, index) in adjBiweeklyData[productType]">
                                            <th class="text-center text-white" :style="'background-color: '+ colorCode.adj_biweekly[index]" colspan="6">
                                                ปักษ์ที่ {{ keyBiweekly }} (ปรับ)
                                            </th>
                                        </template>
                                    </tr>
                                    <tr>
                                        <!-- pp04 -->
                                        <th class="align-middle text-center">
                                            <el-tooltip class="item" effect="dark" :content="adjustData.as_of_date_format" placement="top">
                                                <div>คงคลังปัจจุบัน<br>(ล้านมวน)</div>
                                            </el-tooltip>
                                        </th>
                                        <th class="align-middle text-center">เฉลี่ยขายย้อนหลัง<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">ประมาณการผลิต<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">เหลือวันขาย<br>(วัน)</th>
                                        <th class="align-middle text-center">ประมาณการขาย<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">คงคลังสิ้นปักษ์<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">จำนวนวันพอจำหน่าย<br>(วัน)</th>

                                        <!-- Adj -->
                                        <th class="align-middle text-center">เฉลี่ยขายย้อนหลัง<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">ประมาณการผลิต<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">เหลือวันขาย<br>(วัน)</th>
                                        <th class="align-middle text-center">ประมาณการขาย<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">คงคลังสิ้นปักษ์<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">จำนวนวันพอจำหน่าย<br>(วัน)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(item, itemKey, itemIndex) in adjBiweeklyData[productType][Object.keys(adjBiweeklyData[productType])[0]]">
                                        <tr>
                                            <td class="text-center">{{ itemIndex += 1 }}</td>
                                            <td class="">
                                                {{ item.stamp_desc }}
                                            </td>
                                            <td>
                                                <template v-if="item.is_new_line">
                                                    <div style="display: flex;">
                                                    <el-select
                                                        v-model="item.item_id"
                                                        filterable
                                                        remote
                                                        placeholder=""
                                                        :remote-method="data => remoteMethod(data, item)"
                                                        @change="selectItem(item)"
                                                        :disabled="false"
                                                        >
                                                        <el-option
                                                            v-for="(item, index) in item.item_list"
                                                            :key="item.inventory_item_id"
                                                            :label="item.item_code +': '+ item.item_description"
                                                            :value="String(item.inventory_item_id)"
                                                        ></el-option>
                                                    </el-select>
                                                    <button type="button" @click.prevent="delLine(item, itemKey)" class="btn btn-outline btn-danger ml-2" title="ลบรายการ" >
                                                        <i :class="btnTrans.delete.icon"></i>
                                                    </button>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    {{ item.item_code }}
                                                </template>
                                            </td>
                                            <td>{{ item.item_description }}</td>
                                            <td class="text-right" >
                                                {{ item.curr_onhnad_qty | number3Digit }}
                                            </td>
                                            <td class="text-right " >
                                                {{ item.dff_actual_forecast_qty | number3Digit }}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.def_planning_qty | number3Digit }}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.def_bal_sale_day | number2Digit}}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.def_forcast_qty | number3Digit }}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.def_bal_onhand_qty | number3Digit }}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.def_ending_sale_day | number2Digit }}
                                            </td>



                                            <td class="text-right" >
                                                {{ item.actual_forecase_qty | number2Digit}}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.planning_qty | number2Digit}}
                                                <!-- <input type="number"
                                                    :disabled="!item.item_id || !canEdit"
                                                    v-model="item.planning_qty"
                                                    @change="changeInput(item)"
                                                    class="form-control text-right "> -->
                                            </td>
                                            <td class="text-right" >
                                                {{ item.bal_sale_day | number2Digit}}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.forcast_qty | number3Digit }}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.bal_onhand_qty | number3Digit }}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.ending_sale_day | number2Digit }}
                                            </td>


                                            <template v-for="biweekly in adjBiweeklyData[productType]" v-if="false">
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].curr_onhnad_qty | number3Digit }}
                                                </td>
                                                <td class="text-right text-danger" >
                                                    0
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].def_planning_qty | number3Digit }}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].def_bal_sale_day | number2Digit}}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].def_forcast_qty | number3Digit }}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].def_bal_onhand_qty | number3Digit }}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].def_ending_sale_day | number2Digit }}
                                                </td>
                                            </template>
                                            <template v-for="biweekly in adjBiweeklyData[productType]" v-if="false">
                                                <td class="text-right" >
                                                    <input type="number"
                                                        v-model="biweekly[item.inventory_item_id].planning_qty"
                                                        @change="changeInput(biweekly[item.inventory_item_id], $event.target.value)"
                                                        class="form-control text-right text-danger">
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].bal_sale_day | number2Digit}}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].forcast_qty | number3Digit }}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].bal_onhand_qty | number3Digit }}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].ending_sale_day | number2Digit }}
                                                </td>
                                            </template>
                                        </tr>
                                    </template>
                                    <tr>
                                        <th colspan="4" class="text-right">รวม</th>
                                        <template v-for="(biweekly, index) in adjBiweeklyData[productType]">
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['curr_onhnad_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['dff_actual_forecast_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['def_planning_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['def_bal_sale_days'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['def_forcast_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['def_bal_onhand_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['def_ending_sale_day'] }}
                                            </th>
                                        </template>
                                        <template v-for="(biweekly, index) in adjBiweeklyData[productType]">
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['actual_forecase_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['planning_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['bal_sale_days'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['forcast_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['bal_onhand_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[productType][index]['ending_sale_day'] }}
                                            </th>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="tabs-container" v-if="false">
            <ul class="nav nav-tabs" role="tablist">
                <!-- <li v-for="(tab, key, index)  in tabs">
                    <a :class="'nav-link ' + (index == 0 ? 'active':'')" data-toggle="tab" :href="'#tab-'+ key" @click="selTabName = key">
                        {{ tab }}
                    </a>
                </li> -->
            </ul>
            <div class="tab-content">
                <div v-for="(tab, key, index)  in tabs" role="tabpanel" :id="'tab-' + key"
                    :class="'tab-pane ' + (key == selTabName ? 'active':'')">
                    <div class="panel-body " v-loading="loading[key]">

                        <div v-if="key == 'KK'" v-html="adjKkTableHtml[key]"></div>
                        <div v-else class="">

                            <!-- <div class="col-md-7 offset-md-5  mt-3">
                                <template v-for="(summary, sumKey, sumIndex) in adjSummaryData[key]">
                                    <div v-html="summary['total_working_html']"></div>
                                </template>
                                &nbsp;
                            </div> -->
                            <div class="col-lg-12 text-right " v-if="showData && false">
                                <template v-for="(summary, sumKey, sumIndex) in adjSummaryData[key]">
                                    <!-- <div v-html="summary['total_working_html']"></div> -->
                                    <modal-html
                                        class="text-right"
                                        :modalId="sumKey"
                                        :html="summary['total_working_html']"
                                        :modalTitle="modalTotalWorking.title + ' ปักษ์ที่ ' + sumKey"
                                        :btnTrans="btnTrans"
                                        :btnText="modalTotalWorking.btn_name"
                                        />
                                </template>

                                <button type="button" :disabled="!canEdit" :class="btnTrans.create.class + ' btn-lg tw-w-25'" @click="addLine()" >
                                    <i :class="btnTrans.create.icon"></i>
                                    เพิ่มตราบุหรี่
                                </button>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="table-responsive m-t mb-3">
                            <table class="table-freeze table text-nowrap table-bordered" v-if="adjBiweeklyData[key]">
                                <thead>
                                    <tr>
                                        <th class="align-middle text-center" rowspan="2">ลำดับ</th>
                                        <th class="align-middle text-center" rowspan="2">ตรา</th>
                                        <th class="align-middle text-center" rowspan="2">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <br>รหัสบุหรี่<br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </th>
                                        <th class="align-middle text-center" rowspan="2">ตราบุหรี่</th>
                                        <template v-for="(biweekly, keyBiweekly, index) in adjBiweeklyData[key]">
                                            <th class="text-center text-white" :style="'background-color: '+ colorCode.biweekly[index]" colspan="7">
                                                ปักษ์ที่ {{ keyBiweekly }}
                                            </th>
                                        </template>
                                        <template v-for="(biweekly, keyBiweekly, index) in adjBiweeklyData[key]">
                                            <th class="text-center text-white" :style="'background-color: '+ colorCode.adj_biweekly[index]" colspan="5">
                                                ปักษ์ที่ {{ keyBiweekly }} (ปรับ)
                                            </th>
                                        </template>
                                    </tr>
                                    <tr>
                                        <!-- pp04 -->
                                        <th class="align-middle text-center">คงคลังปัจจุบัน<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">เฉลี่ยขายย้อนหลัง<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">ประมาณการผลิต<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">เหลือวันขาย<br>(วัน)</th>
                                        <th class="align-middle text-center">ประมาณการขาย<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">คงคลังสิ้นปักษ์<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">จำนวนวันพอจำหน่าย<br>(วัน)</th>

                                        <!-- Adj -->
                                        <th class="align-middle text-center">ประมาณการผลิต<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">เหลือวันขาย<br>(วัน)</th>
                                        <th class="align-middle text-center">ประมาณการขาย<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">คงคลังสิ้นปักษ์<br>(ล้านมวน)</th>
                                        <th class="align-middle text-center">จำนวนวันพอจำหน่าย<br>(วัน)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(item, itemKey, itemIndex) in adjBiweeklyData[key][Object.keys(adjBiweeklyData[key])[0]]">
                                        <tr>
                                            <td class="text-center">{{ itemIndex += 1 }}</td>
                                            <td class="">
                                                {{ item.stamp_desc }}
                                            </td>
                                            <td>
                                                <template v-if="item.is_new_line">
                                                    <div style="display: flex;">
                                                    <el-select
                                                        v-model="item.item_id"
                                                        filterable
                                                        remote
                                                        placeholder=""
                                                        :remote-method="data => remoteMethod(data, item)"
                                                        @change="selectItem(item)"
                                                        :disabled="false"
                                                        >
                                                        <el-option
                                                            v-for="(item, index) in item.item_list"
                                                            :key="item.inventory_item_id"
                                                            :label="item.item_code +': '+ item.item_description"
                                                            :value="String(item.inventory_item_id)"
                                                        ></el-option>
                                                    </el-select>
                                                    <button type="button" @click.prevent="delLine(item, itemKey)" class="btn btn-outline btn-danger ml-2" title="ลบรายการ" >
                                                        <i :class="btnTrans.delete.icon"></i>
                                                    </button>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    {{ item.item_code }}
                                                </template>
                                            </td>
                                            <td>{{ item.item_description }}</td>
                                            <td class="text-right" >
                                                {{ item.curr_onhnad_qty | number3Digit }}
                                            </td>
                                            <td class="text-right text-danger" >
                                                0
                                            </td>
                                            <td class="text-right" >
                                                {{ item.def_planning_qty | number3Digit }}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.def_bal_sale_day | number2Digit}}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.def_forcast_qty | number3Digit }}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.def_bal_onhand_qty | number3Digit }}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.def_ending_sale_day | number2Digit }}
                                            </td>


                                            <td class="text-right" >
                                                <input type="number"
                                                    :disabled="!item.item_id || !canEdit"
                                                    v-model="item.planning_qty"
                                                    @change="changeInput(item)"
                                                    class="form-control text-right ">
                                            </td>
                                            <td class="text-right" >
                                                {{ item.bal_sale_day | number2Digit}}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.forcast_qty | number3Digit }}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.bal_onhand_qty | number3Digit }}
                                            </td>
                                            <td class="text-right" >
                                                {{ item.ending_sale_day | number2Digit }}
                                            </td>


                                            <template v-for="biweekly in adjBiweeklyData[key]" v-if="false">
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].curr_onhnad_qty | number3Digit }}
                                                </td>
                                                <td class="text-right text-danger" >
                                                    0
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].def_planning_qty | number3Digit }}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].def_bal_sale_day | number2Digit}}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].def_forcast_qty | number3Digit }}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].def_bal_onhand_qty | number3Digit }}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].def_ending_sale_day | number2Digit }}
                                                </td>
                                            </template>
                                            <template v-for="biweekly in adjBiweeklyData[key]" v-if="false">
                                                <td class="text-right" >
                                                    <input type="number"
                                                        v-model="biweekly[item.inventory_item_id].planning_qty"
                                                        @change="changeInput(biweekly[item.inventory_item_id], $event.target.value)"
                                                        class="form-control text-right text-danger">
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].bal_sale_day | number2Digit}}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].forcast_qty | number3Digit }}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].bal_onhand_qty | number3Digit }}
                                                </td>
                                                <td class="text-right" >
                                                    {{ biweekly[item.inventory_item_id].ending_sale_day | number2Digit }}
                                                </td>
                                            </template>
                                        </tr>
                                    </template>
                                    <tr>
                                        <th colspan="4" class="text-right">รวม</th>
                                        <template v-for="(biweekly, index) in adjBiweeklyData[key]">
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[key][index]['curr_onhnad_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                0
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[key][index]['def_planning_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[key][index]['def_bal_sale_days'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[key][index]['def_forcast_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[key][index]['def_bal_onhand_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[key][index]['def_ending_sale_day'] }}
                                            </th>
                                        </template>
                                        <template v-for="(biweekly, index) in adjBiweeklyData[key]">
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[key][index]['planning_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[key][index]['bal_sale_days'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[key][index]['forcast_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[key][index]['bal_onhand_qty'] }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ adjSummaryData[key][index]['ending_sale_day'] }}
                                            </th>
                                        </template>
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


    import ModalCreate      from './ModalCreate.vue';
    import ModalSearch      from './ModalSearch.vue';
    import HeaderDetail     from './components/HeaderDetail.vue';
    import SearchItem       from './SearchItem';
    export default {
        components: {
            // ModalCreate, ModalSearch, HeaderDetail, Tab1, Tab2, Tab3
            ModalCreate, ModalSearch, HeaderDetail, SearchItem
        },
        props:[
            "adjustData",
            "modalCreateInput", "modalSearchInput", "colorCode", 'tabs',
            "pDateFormat",
            "productTypes", "ppBiWeekly", "workingHour",
            "omBiweeklyList", "calTypes", "calTypeDefault",
            "btnTrans", "url"
        ],
        data() {
            return {
                loading2: false,
                loading: {},
                defaultInput: (this.pDefaultInput != undefined && this.pDefaultInput != '') ? this.pDefaultInput : null,
                selTabName: String(Object.keys(this.tabs)[0]),
                clickSelTabName: 'tab1',
                productType: String(Object.keys(this.tabs)[0]),
                canEdit: false,
                canApprove: false,

                adjBiweeklyData:  {},
                adjSummaryData: {},
                adjKkTableHtml: {},
                tab1Html: '',
                modalTotalWorking: {
                    title: 'รายละเอียดชั่วโมงการทำงาน',
                    btn_name: 'รายละเอียดการทำงาน'
                },
                showData: false,
                changeData: {},
                addLineData: {}
            }
        },
        async mounted() {
            if (this.adjustData != undefined && this.adjustData != '') {
                // this.canEdit = this.adjustData.approved_status.toUpperCase() == 'INACTIVE' && this.adjustData.approved_date == null;
                this.canEdit = this.adjustData.approved_status.toUpperCase() == 'INACTIVE';
                // this.canApprove = this.adjustData.approved_status.toUpperCase() == 'INACTIVE' && this.adjustData.approved_date == null;
                this.canApprove = this.adjustData.approved_status.toUpperCase() == 'INACTIVE';
            }

            let vm = this;
            Object.keys(vm.tabs).forEach(async function(tab) {
                vm.$set(vm.loading, tab, false);

                vm.$set(vm.adjBiweeklyData, tab, false);
                vm.$set(vm.adjSummaryData, tab, []);
                vm.$set(vm.adjKkTableHtml, tab, '');
            });


            vm.getAdjData();
        },
        computed: {
        },
        watch:{
            selTabName : async function (value, oldValue) {
                this.showData = false;
                this.getAdjData();
            },
            clickSelTabName : async function (value, oldValue) {
                this.showData = false;
                this.getAdjData();
            },
            productType : async function (value, oldValue) {
                this.showData = false;
                this.getAdjData();
            },
        },
        methods: {
            async addLine() {
                let vm = this;
                let cloneLine = JSON.parse(JSON.stringify(vm.adjBiweeklyData[vm.productType][vm.adjustData.current_biweekly]));
                let rowLength = Object.keys(cloneLine).length;
                    cloneLine = cloneLine[Object.keys(cloneLine)[0]];
                    cloneLine.is_new_line = true;
                    cloneLine.stamp_desc = '';
                    cloneLine.item_id = '';
                    cloneLine.item_code = '';
                    cloneLine.item_description = '';
                    cloneLine.curr_onhnad_qty = '';
                    cloneLine.def_planning_qty = '';
                    cloneLine.def_bal_sale_day = '';
                    cloneLine.def_forcast_qty = '';
                    cloneLine.def_bal_onhand_qty = '';
                    cloneLine.def_ending_sale_day = '';
                    cloneLine.bal_sale_day = '';
                    cloneLine.forcast_qty = '';
                    cloneLine.bal_onhand_qty = '';
                    cloneLine.ending_sale_day = '';


                this.$set(vm.adjBiweeklyData[vm.productType][vm.adjustData.current_biweekly], 'new-' + rowLength, cloneLine);

                this.remoteMethod(' ', vm.adjBiweeklyData[vm.productType][vm.adjustData.current_biweekly]['new-' + rowLength])
            },
            async changeInput(line) {
                let row = Object.keys(this.changeData).length;
                let data = JSON.parse(JSON.stringify(line));
                    data['value'] = data.planning_qty;


                // this.$set(data, 'value', value);
                this.$set(this.changeData, 'case3-' + data.item_id, data);
                console.log('changeInput', data.planning_qty, line.planning_qty);
                console.log('changeInput', this.changeData['case3-' + data.item_id].value);
            },
            async getAdjData(reload = false) {
                let vm = this;
                if (!reload) {
                    if (vm.productType == undefined || vm.productType == '' || Object.keys(vm.tabs).length == 0) {
                        return;
                    }
                    if (!vm.adjustData || !vm.productType || vm.loading[vm.productType]) {
                        return;
                    }
                }


                vm.changeData = {};
                vm.addLineData = {};


                vm.loading2 = true;


                vm.loading[vm.productType] = true;
                vm.adjBiweeklyData[vm.productType] = false
                vm.adjKkTableHtml[vm.productType] = '';
                vm.adjSummaryData[vm.productType] = [];
                let params = {
                    product_main_id: vm.adjustData.product_main_id,
                    product_type: vm.productType,
                };
                await axios.get(vm.url.ajax_get_adj_data, { params })
                    .then(res => {
                        let data = res.data.data;
                        vm.adjBiweeklyData[vm.productType] = data.adj_biweekly;
                        vm.adjKkTableHtml[vm.productType] = data.adj_kk_table_html;
                        vm.adjSummaryData[vm.productType] = data.adj_summary;
                        vm.tab1Html = data.tab1_html;
                        vm.showData = true;
                    })
                    .catch(err => {
                        console.log('error')
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading[vm.productType] = false;
                        vm.loading2 = false;
                    });
            },

            async saveChangeInput() {
                let vm = this;
                if (!vm.canEdit) {return}
                if (Object.keys(vm.changeData).length == 0 && Object.keys(vm.addLineData).length == 0) {
                    swal({
                        title: 'อัพเดทแผนการผลิต',
                        text: '<span style="font-size: 16px; text-align: left;"> ไม่พบข้อูลการอัพเดท </span>',
                        type: "warning",
                        html: true
                    });
                    return;
                }
                let swalConfirm = swal({
                    html: true,
                    title: 'อัพเดทแผนการผลิต ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทแผนการผลิต ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    // confirmButtonClass: 'btn btn-danger',
                    // cancelButtonClass: 'btn btn-white',
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        await axios
                        .patch(vm.url.ajax_adjusts_update, {
                            lines: vm.changeData,
                            new_lines: vm.addLineData
                        })
                        .then(res => {
                            if (res.data.data.status == 'S') {
                                swal({
                                    title: 'อัพเดทแผนการผลิต',
                                    text: '<span style="font-size: 16px; text-align: left;"> อัพเดทแผนการผลิตสำเร็จ </span>',
                                    type: "success",
                                    html: true
                                });

                                vm.getAdjData(true);

                                // vm.setLastUpdateDateFormat(res.data.data.last_update_date)
                                // vm.changeData = {};
                                // if (vm.selTabName == 'tab2') {
                                //     vm.refreshTab2 = vm.refreshTab2 + 1;
                                // }
                            }

                            if (res.data.data.status != 'S' && false) {
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
                            // swal.close();
                        });
                    }
                });
            },
            async selectItem(line) {
                let item = line.item_list.findIndex(o => o.inventory_item_id == line.item_id)
                    item = line.item_list[item];

                line.stamp = item.stamp;
                line.stamp_desc = item.stamp_desc;
                line.item_code = item.item_code;
                line.item_description = item.item_description;
                line.organization_id = item.organization_id;
                line.inventory_item_id = item.inventory_item_id;
                // category_concat_segs: "15.01"
                // category_id: "5747"
                // category_segment2: "01"
                // category_set_id: "1100000041"
                // category_set_name: "TOAT_INV_ITEM_CATEGORY_SET"
                // category_setment1: "15"
                // category_type: "IMPORT"
                // inventory_item_id: "147004"
                // item_code: "15012343"
                // item_description: "KRONG THIP 7.1 สีแดง"
                // organization_code: "A01"
                // organization_id: "164"
                // product_type: "71"
                // rn: "2"
                // stamp: null
                // stamp_desc: null
                console.log('selectItem', line.item_list, 'xx1', item, 'xx', line.item_id, line.item_code, line);

                let row = Object.keys(this.addLineData).length;
                let data = JSON.parse(JSON.stringify(line));
                this.$set(this.addLineData, 'add-' + data.item_id, data);
            },
            async remoteMethod(query, line) {
                console.log('remoteMethod');
                let vm = this;
                let params = {
                    number: query,
                    product_main_id: vm.adjustData.product_main_id,
                    product_type: vm.productType
                }
                axios.get(vm.url.ajax_search_item, { params }).then(res => {
                    let response = res.data.data
                    line['item_list'] = response['item_list'];
                });
                // row[inputName] = [];

                // let line = _.clone(row);
                //     line.casing_leaf_formula_list = [];
                //     line.casing_list = [];
                // if (query !== "") {
                //     // this.getData({
                //     //     number: query,
                //     //     header: this.header,
                //     //     line: line,
                //     //     type: inputName
                //     // }, row, inputName);
                // }
            },
            delLine(line, index) {
                let vm = this;
                vm.$delete(vm.adjBiweeklyData[vm.productType][vm.adjustData.current_biweekly], index);

                vm.$delete(vm.changeData, 'case3-' + line.item_id);
                vm.$delete(vm.addLineData, 'add-' + line.item_id );
            },
            async checkApprove() {
                let vm = this;
                if (!vm.canApprove) { return }

                    vm.loading.approveProcess = true;
                    await axios
                    .get(vm.url.ajax_check_approve)
                    .then(res => {
                        if (res.data.data.status == 'S') {
                            swal({
                                html: true,
                                title: 'อนุมัตปรับประมาณการผลิตประจำปักษ์',
                                text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอนุมัตปรับประมาณการผลิตประจำปักษ์ ? </span></h2>',
                                showCancelButton: true,
                                confirmButtonText: vm.btnTrans.ok.text,
                                cancelButtonText: vm.btnTrans.cancel.text,
                                // confirmButtonClass: 'btn btn-danger',
                                // cancelButtonClass: 'btn btn-white',
                                confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                                cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                                closeOnConfirm: false,
                                closeOnCancel: true,
                                showLoaderOnConfirm: true
                            },
                            async function(isConfirm){
                                if (isConfirm) {
                                    vm.approve();
                                }
                            });

                        } else {
                            swal({
                                title: 'อนุมัตปรับประมาณการผลิตประจำปักษ์',
                                text: res.data.data.msg,
                                // type: "warning",
                                html: true,
                                showCancelButton: true,
                                confirmButtonText: vm.btnTrans.ok.text,
                                cancelButtonText: vm.btnTrans.cancel.text,
                                // confirmButtonClass: 'btn btn-danger',
                                // cancelButtonClass: 'btn btn-white',
                                confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                                cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                                closeOnConfirm: false,
                                closeOnCancel: true,
                                showLoaderOnConfirm: true
                            },async function(isConfirm){
                                if (isConfirm) {
                                    console.log('Approve');
                                    vm.approve();
                                }
                            });
                        }
                    })
                    .catch(err => {
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading.approveProcess = false;
                        // swal.close();
                    });

            },
            async approve() {
                let vm = this;

                await axios
                .patch(vm.url.ajax_approve)
                .then(res => {
                    if (res.data.data.status == 'S') {
                        swal({
                            title: 'อนุมัตปรับประมาณการผลิตประจำปักษ์',
                            text: '<span style="font-size: 16px; text-align: left;"> อนุมัตปรับประมาณการผลิตประจำปักษ์เรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                        vm.tab2AvgChangeData = {};
                        if (vm.productType == 'tab2') {
                            vm.refreshTab2 = vm.refreshTab2 + 1;
                        }
                        vm.canEdit = false;
                        vm.canApprove = false;

                        vm.adjustData = res.data.data.prod_biweekly_main;
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
                    // swal.close();
                });
            },
        }
    }
</script>
<style scope>

</style>