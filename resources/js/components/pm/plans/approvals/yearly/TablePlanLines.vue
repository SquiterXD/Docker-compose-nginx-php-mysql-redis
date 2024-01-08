<template>

    <div>

        <div class="table-responsive" style="max-height: 400px;">

            <table class="table table-bordered table-sticky mb-0" style="min-width: 4100px;">
                <thead>
                    <tr>
                        <th rowspan="2" class="freeze-col" style="min-width: 480px;"> 
                            <div class="freeze-col-content" style="padding: 0px;">
                                <div class="text-center tw-inline-block tw-align-top tw-py-4" style="min-width: 120px; max-width: 120px;">
                                    รหัสวัตถุดิบ 
                                </div>
                                <div class="text-center tw-inline-block tw-align-top tw-py-4" style="min-height: 30px; min-width: 320px; max-width: 320px; border-left: 1px solid #ddd;">
                                    รายละเอียด 
                                </div>
                            </div>
                        </th>
                        <th rowspan="2" class="text-center" style="min-width: 140px;"> ระบบคำนวน </th>
                        <th rowspan="2" class="text-center" style="min-width: 152px;"> ปริมาณที่ต้องใช้ + สูญเสีย / ล้านมวน </th>
                        <th rowspan="2" class="text-center" style="min-width: 120px;"> หน่วยนับ </th>
                        <th rowspan="2" class="text-center" style="min-width: 100px;"> % การใข้งาน </th>
                        <th colspan="2" class="text-center" style="min-width: 280px;"> ตุลาคม </th>
                        <th colspan="2" class="text-center" style="min-width: 280px;"> พฤศจิกายน </th>
                        <th colspan="2" class="text-center" style="min-width: 280px;"> ธันวาคม </th>
                        <th colspan="2" class="text-center" style="min-width: 280px;"> มกราคม </th>
                        <th colspan="2" class="text-center" style="min-width: 280px;"> กุมภาพันธ์ </th>
                        <th colspan="2" class="text-center" style="min-width: 280px;"> มีนาคม </th>
                        <th colspan="2" class="text-center" style="min-width: 280px;"> เมษายน </th>
                        <th colspan="2" class="text-center" style="min-width: 280px;"> พฤษภาคม </th>
                        <th colspan="2" class="text-center" style="min-width: 280px;"> มิถุนายน </th>
                        <th colspan="2" class="text-center" style="min-width: 280px;"> กรกฎาคม </th>
                        <th colspan="2" class="text-center" style="min-width: 280px;"> สิงหาคม </th>
                        <th colspan="2" class="text-center" style="min-width: 280px;"> กันยายน </th>
                        <th rowspan="2" class="text-center" style="min-width: 200px;"> รวม </th>
                        <th rowspan="2" class="text-center" style="min-width: 60px;"> </th>
                    </tr>
                    <tr>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ระบบคำนวน </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ประมาณการใช้ </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ระบบคำนวน </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ประมาณการใช้ </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ระบบคำนวน </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ประมาณการใช้ </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ระบบคำนวน </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ประมาณการใช้ </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ระบบคำนวน </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ประมาณการใช้ </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ระบบคำนวน </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ประมาณการใช้ </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ระบบคำนวน </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ประมาณการใช้ </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ระบบคำนวน </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ประมาณการใช้ </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ระบบคำนวน </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ประมาณการใช้ </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ระบบคำนวน </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ประมาณการใช้ </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ระบบคำนวน </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ประมาณการใช้ </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ระบบคำนวน </th>
                        <th class="text-center" style="min-width: 140px; top: 34px;"> ประมาณการใช้ </th>
                    </tr>
                </thead>
                <tbody class="yearly-lines" v-if="planLineItems.length > 0">
                    <template v-for="(planLineItem, index) in planLineItems">
                        <tr :key="`${index}`" v-if="!planLineItem.marked_as_deleted">
                            
                            <td class="freeze-col" style="min-width: 480px;"> 
                                <div class="freeze-col-content" style="padding: 0px;">
                                    <div class="tw-inline-block tw-align-top tw-py-4 tw-pr-2" style="min-width: 120px; max-width: 120px; vertical-align: top;">
                                        <div class="text-center">
                                            {{ planLineItem.item_code }} 
                                        </div>    
                                    </div>
                                    <div class="tw-inline-block tw-align-top tw-py-4 tw-pl-4" style="min-height: 30px; min-width: 320px; max-width: 320px; border-left: 1px solid #ddd;">
                                        {{ planLineItem.description }}
                                    </div>
                                </div>
                            </td>

                            <td style="min-width: 140px;" class="text-right scroll-col"> 
                                {{ planLineItem.gain_loss_qty ? Number(planLineItem.gain_loss_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 152px;" class="text-right scroll-col"> 
                                <div>
                                    {{ planLineItem.user_gain_loss_qty ? Number(planLineItem.user_gain_loss_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>
                            <td style="min-width: 120px;" class="scroll-col text-center"> {{ planLineItem.uom_desc }} </td>
                            <td style="min-width: 100px;" class="scroll-col text-center">  
                                <div>
                                    {{ planLineItem.percent }}
                                </div>
                            </td>

                            <!-- OCT -->
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                {{ planLineItem.oct_req_qty ? Number(planLineItem.oct_req_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                <div>
                                    {{ planLineItem.oct_buy_qty ? Number(planLineItem.oct_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>

                            <!-- NOV -->
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                {{ planLineItem.nov_req_qty ? Number(planLineItem.nov_req_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                <div>
                                    {{ planLineItem.nov_buy_qty ? Number(planLineItem.nov_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>

                            <!-- DEC -->
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                {{ planLineItem.dec_req_qty ? Number(planLineItem.dec_req_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                <div>
                                    {{ planLineItem.dec_buy_qty ? Number(planLineItem.dec_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>

                            <!-- JAN -->
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                {{ planLineItem.jan_req_qty ? Number(planLineItem.jan_req_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                <div>
                                    {{ planLineItem.jan_buy_qty ? Number(planLineItem.jan_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>

                            <!-- FEB -->
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                {{ planLineItem.feb_req_qty ? Number(planLineItem.feb_req_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                <div>
                                    {{ planLineItem.feb_buy_qty ? Number(planLineItem.feb_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>

                            <!-- MAR -->
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                {{ planLineItem.mar_req_qty ? Number(planLineItem.mar_req_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                <div>
                                    {{ planLineItem.mar_buy_qty ? Number(planLineItem.mar_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>

                            <!-- APR -->
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                {{ planLineItem.apr_req_qty ? Number(planLineItem.apr_req_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                <div>
                                    {{ planLineItem.apr_buy_qty ? Number(planLineItem.apr_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>

                            <!-- MAY -->
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                {{ planLineItem.may_req_qty ? Number(planLineItem.may_req_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                <div>
                                    {{ planLineItem.may_buy_qty ? Number(planLineItem.may_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>

                            <!-- JUN -->
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                {{ planLineItem.jun_req_qty ? Number(planLineItem.jun_req_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                <div>
                                    {{ planLineItem.jun_buy_qty ? Number(planLineItem.jun_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>

                            <!-- JUL -->
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                {{ planLineItem.jul_req_qty ? Number(planLineItem.jul_req_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                <div>
                                    {{ planLineItem.jul_buy_qty ? Number(planLineItem.jul_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>

                            <!-- AUG -->
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                {{ planLineItem.aug_req_qty ? Number(planLineItem.aug_req_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                <div>
                                    {{ planLineItem.aug_buy_qty ? Number(planLineItem.aug_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>

                            <!-- SEP -->
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                {{ planLineItem.sep_req_qty ? Number(planLineItem.sep_req_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                            </td>
                            <td style="min-width: 140px;" class="scroll-col text-right"> 
                                <div>
                                    {{ planLineItem.sep_buy_qty ? Number(planLineItem.sep_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>

                            <td style="min-width: 200px;" class="scroll-col text-right"> {{ planLineItem.total_buy_qty ? Number(planLineItem.total_buy_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }} </td>
                            
                            <td style="min-width: 60px;" class="scroll-col text-center"> 
                                
                            </td>

                        </tr>
                    </template>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="9">
                            <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                        </td>
                    </tr>
                </tbody>

            </table>

    
    
        </div>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'

export default {
    
    props: ["planHeader", "planMonths", "planLines", "salePlanSummary", "itemOptions", "uomCodes"],

    components: {
        VueNumeric
    },

    watch: {
        planHeader : function (value) {
            this.planHeaderData = value;
        },
    },

    data() {

        return {

            planHeaderData: this.planHeader,
            planLineItems: this.planLines.map(item => {
                return {
                    ...item,
                    uom_desc : this.getUomCodeDescription(this.uomCodes, item.uom),
                    // gain_loss_qty_m: (parseFloat(item.gain_loss_qty) / 1000000).toFixed(2),
                    user_gain_loss_qty: item.attribute11 ? Number(item.attribute11).toFixed(2) : Number(item.gain_loss_qty).toFixed(2), // attribute11 == user_gain_loss_qty
                    user_oct_req_qty: item.oct_req_qty ? item.oct_req_qty : 0,
                    user_nov_req_qty: item.nov_req_qty ? item.nov_req_qty : 0,
                    user_dec_req_qty: item.dec_req_qty ? item.dec_req_qty : 0,
                    user_jan_req_qty: item.jan_req_qty ? item.jan_req_qty : 0,
                    user_feb_req_qty: item.feb_req_qty ? item.feb_req_qty : 0,
                    user_mar_req_qty: item.mar_req_qty ? item.mar_req_qty : 0,
                    user_apr_req_qty: item.apr_req_qty ? item.apr_req_qty : 0,
                    user_may_req_qty: item.may_req_qty ? item.may_req_qty : 0,
                    user_jun_req_qty: item.jun_req_qty ? item.jun_req_qty : 0,
                    user_jul_req_qty: item.jul_req_qty ? item.jul_req_qty : 0,
                    user_aug_req_qty: item.aug_req_qty ? item.aug_req_qty : 0,
                    user_sep_req_qty: item.sep_req_qty ? item.sep_req_qty : 0,
                    oct_buy_qty: item.oct_buy_qty ? Number(item.oct_buy_qty).toFixed(2) : null,
                    nov_buy_qty: item.nov_buy_qty ? Number(item.nov_buy_qty).toFixed(2) : null,
                    dec_buy_qty: item.dec_buy_qty ? Number(item.dec_buy_qty).toFixed(2) : null,
                    jan_buy_qty: item.jan_buy_qty ? Number(item.jan_buy_qty).toFixed(2) : null,
                    feb_buy_qty: item.feb_buy_qty ? Number(item.feb_buy_qty).toFixed(2) : null,
                    mar_buy_qty: item.mar_buy_qty ? Number(item.mar_buy_qty).toFixed(2) : null,
                    apr_buy_qty: item.apr_buy_qty ? Number(item.apr_buy_qty).toFixed(2) : null,
                    may_buy_qty: item.may_buy_qty ? Number(item.may_buy_qty).toFixed(2) : null,
                    jun_buy_qty: item.jun_buy_qty ? Number(item.jun_buy_qty).toFixed(2) : null,
                    jul_buy_qty: item.jul_buy_qty ? Number(item.jul_buy_qty).toFixed(2) : null,
                    aug_buy_qty: item.aug_buy_qty ? Number(item.aug_buy_qty).toFixed(2) : null,
                    sep_buy_qty: item.sep_buy_qty ? Number(item.sep_buy_qty).toFixed(2) : null,
                    percent: item.percent ? item.percent : 100,
                    total_req_qty: this.calTotalReqQty(item),
                    total_buy_qty: this.calTotalBuyQty(item),
                    is_new_line: item.attribute10 == "Y" ? true : false, // attribute10 == 'Y' => is_new_line == true
                    marked_as_deleted: false,
                }
            }).filter((value, index, self) => {
                return (
                    index === self.findIndex(t => t.item_code === value.item_code)
                );
            }),

            planMonthItems: this.planMonths ? this.planMonths : [],

        }

    },

    mounted() {

        // EMIT UPDATE PARENT PLAN LINES

        this.planLineItems.forEach((planLineItem) => {
        
            const userGainLossQty = parseFloat(planLineItem.user_gain_loss_qty);
            if(!isNaN(userGainLossQty)) {
            
                this.autoCalculateUserReqQty(userGainLossQty, planLineItem); 

                if(!planLineItem.oct_buy_qty && !planLineItem.nov_buy_qty &&
                !planLineItem.dec_buy_qty && !planLineItem.jan_buy_qty && 
                !planLineItem.feb_buy_qty && !planLineItem.mar_buy_qty &&
                !planLineItem.apr_buy_qty && !planLineItem.may_buy_qty &&
                !planLineItem.jun_buy_qty && !planLineItem.jul_buy_qty &&
                !planLineItem.aug_buy_qty && !planLineItem.sep_buy_qty) {

                    // DEFAULT BUY QTY (FOR FIRST COMING LINES)
                    this.autoCalculateBuyQty(planLineItem); 

                }
                
            }

        });
        

    },

    computed: {

    },
    methods: {

        onUserGainLossQtyChanged(planLineItem) {

            const userGainLossQty = parseFloat(planLineItem.user_gain_loss_qty);

            if(!isNaN(userGainLossQty)) {

                this.autoCalculateUserReqQty(userGainLossQty, planLineItem);
                
                this.autoCalculateBuyQty(planLineItem);

            }

        },

        calUserReqQty(total, reqQty, gainLossQty) {
            return parseFloat(total) > 0 ? gainLossQty * parseFloat(reqQty) / parseFloat(total) : 0;
        },

        autoCalculateUserReqQty(userGainLossQty, planLineItem) {

            planLineItem.user_oct_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.oct, userGainLossQty);
            planLineItem.user_nov_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.nov, userGainLossQty);
            planLineItem.user_dec_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.dec, userGainLossQty);
            planLineItem.user_jan_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.jan, userGainLossQty);
            planLineItem.user_feb_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.feb, userGainLossQty);
            planLineItem.user_mar_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.mar, userGainLossQty);
            planLineItem.user_apr_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.apr, userGainLossQty);
            planLineItem.user_may_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.may, userGainLossQty);
            planLineItem.user_jun_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.jun, userGainLossQty);
            planLineItem.user_jul_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.jul, userGainLossQty);
            planLineItem.user_aug_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.aug, userGainLossQty);
            planLineItem.user_sep_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.sep, userGainLossQty);

            if(planLineItem.is_new_line) {

                planLineItem.gain_loss_qty = parseFloat(planLineItem.user_gain_loss_qty);

                planLineItem.oct_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.oct, userGainLossQty);
                planLineItem.nov_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.nov, userGainLossQty);
                planLineItem.dec_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.dec, userGainLossQty);
                planLineItem.jan_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.jan, userGainLossQty);
                planLineItem.feb_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.feb, userGainLossQty);
                planLineItem.mar_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.mar, userGainLossQty);
                planLineItem.apr_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.apr, userGainLossQty);
                planLineItem.may_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.may, userGainLossQty);
                planLineItem.jun_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.jun, userGainLossQty);
                planLineItem.jul_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.jul, userGainLossQty);
                planLineItem.aug_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.aug, userGainLossQty);
                planLineItem.sep_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.sep, userGainLossQty);

            }

        },

        calBuyQtyByPercent(userReqQty, percent) {
            return userReqQty ? Number(parseFloat(userReqQty) * percent / 100).toFixed(2) : Number(0).toFixed(2);
        },

        onPercentChanged(planLineItem) {
            if(planLineItem.percent < 0){ planLineItem.percent = 0; }
            if(planLineItem.percent > 100){ planLineItem.percent = 100; }
            this.autoCalculateBuyQty(planLineItem);
        },

        autoCalculateBuyQty(planLineItem) {
            
            const percent = !isNaN(parseFloat(planLineItem.percent)) ? parseFloat(planLineItem.percent) : 100;
        
            planLineItem.oct_buy_qty = this.calBuyQtyByPercent(planLineItem.user_oct_req_qty, percent);
            planLineItem.nov_buy_qty = this.calBuyQtyByPercent(planLineItem.user_nov_req_qty, percent);
            planLineItem.dec_buy_qty = this.calBuyQtyByPercent(planLineItem.user_dec_req_qty, percent);
            planLineItem.jan_buy_qty = this.calBuyQtyByPercent(planLineItem.user_jan_req_qty, percent);
            planLineItem.feb_buy_qty = this.calBuyQtyByPercent(planLineItem.user_feb_req_qty, percent);
            planLineItem.mar_buy_qty = this.calBuyQtyByPercent(planLineItem.user_mar_req_qty, percent);
            planLineItem.apr_buy_qty = this.calBuyQtyByPercent(planLineItem.user_apr_req_qty, percent);
            planLineItem.may_buy_qty = this.calBuyQtyByPercent(planLineItem.user_may_req_qty, percent);
            planLineItem.jun_buy_qty = this.calBuyQtyByPercent(planLineItem.user_jun_req_qty, percent);
            planLineItem.jul_buy_qty = this.calBuyQtyByPercent(planLineItem.user_jul_req_qty, percent);
            planLineItem.aug_buy_qty = this.calBuyQtyByPercent(planLineItem.user_aug_req_qty, percent);
            planLineItem.sep_buy_qty = this.calBuyQtyByPercent(planLineItem.user_sep_req_qty, percent);

            planLineItem.total_buy_qty = this.calTotalBuyQty(planLineItem);

            

        },

        onBuyQtyChanged(planLineItem) {

            // formatNumber(value);
            planLineItem.total_buy_qty = this.calTotalBuyQty(planLineItem);

            

        },

        calTotalBuyQty(planLineItem) {
            
            let total = 0;

            const octBuyQty = !isNaN(parseFloat(planLineItem.oct_buy_qty)) ? parseFloat(planLineItem.oct_buy_qty) : 0;
            const novBuyQty = !isNaN(parseFloat(planLineItem.nov_buy_qty)) ? parseFloat(planLineItem.nov_buy_qty) : 0;
            const decBuyQty = !isNaN(parseFloat(planLineItem.dec_buy_qty)) ? parseFloat(planLineItem.dec_buy_qty) : 0;
            const janBuyQty = !isNaN(parseFloat(planLineItem.jan_buy_qty)) ? parseFloat(planLineItem.jan_buy_qty) : 0;
            const febBuyQty = !isNaN(parseFloat(planLineItem.feb_buy_qty)) ? parseFloat(planLineItem.feb_buy_qty) : 0;
            const marBuyQty = !isNaN(parseFloat(planLineItem.mar_buy_qty)) ? parseFloat(planLineItem.mar_buy_qty) : 0;
            const aprBuyQty = !isNaN(parseFloat(planLineItem.apr_buy_qty)) ? parseFloat(planLineItem.apr_buy_qty) : 0;
            const mayBuyQty = !isNaN(parseFloat(planLineItem.may_buy_qty)) ? parseFloat(planLineItem.may_buy_qty) : 0;
            const junBuyQty = !isNaN(parseFloat(planLineItem.jun_buy_qty)) ? parseFloat(planLineItem.jun_buy_qty) : 0;
            const julBuyQty = !isNaN(parseFloat(planLineItem.jul_buy_qty)) ? parseFloat(planLineItem.jul_buy_qty) : 0;
            const augBuyQty = !isNaN(parseFloat(planLineItem.aug_buy_qty)) ? parseFloat(planLineItem.aug_buy_qty) : 0;
            const sepBuyQty = !isNaN(parseFloat(planLineItem.sep_buy_qty)) ? parseFloat(planLineItem.sep_buy_qty) : 0;

            total = octBuyQty + novBuyQty + decBuyQty + janBuyQty + febBuyQty + marBuyQty + aprBuyQty + mayBuyQty + junBuyQty + julBuyQty + augBuyQty + sepBuyQty;

            return total.toFixed(2);

        },

        calTotalReqQty(planLineItem) {
            
            let total = 0;

            const octReqQty = !isNaN(parseFloat(planLineItem.oct_req_qty)) ? parseFloat(planLineItem.oct_req_qty) : 0;
            const novReqQty = !isNaN(parseFloat(planLineItem.nov_req_qty)) ? parseFloat(planLineItem.nov_req_qty) : 0;
            const decReqQty = !isNaN(parseFloat(planLineItem.dec_req_qty)) ? parseFloat(planLineItem.dec_req_qty) : 0;
            const janReqQty = !isNaN(parseFloat(planLineItem.jan_req_qty)) ? parseFloat(planLineItem.jan_req_qty) : 0;
            const febReqQty = !isNaN(parseFloat(planLineItem.feb_req_qty)) ? parseFloat(planLineItem.feb_req_qty) : 0;
            const marReqQty = !isNaN(parseFloat(planLineItem.mar_req_qty)) ? parseFloat(planLineItem.mar_req_qty) : 0;
            const aprReqQty = !isNaN(parseFloat(planLineItem.apr_req_qty)) ? parseFloat(planLineItem.apr_req_qty) : 0;
            const mayReqQty = !isNaN(parseFloat(planLineItem.may_req_qty)) ? parseFloat(planLineItem.may_req_qty) : 0;
            const junReqQty = !isNaN(parseFloat(planLineItem.jun_req_qty)) ? parseFloat(planLineItem.jun_req_qty) : 0;
            const julReqQty = !isNaN(parseFloat(planLineItem.jul_req_qty)) ? parseFloat(planLineItem.jul_req_qty) : 0;
            const augReqQty = !isNaN(parseFloat(planLineItem.aug_req_qty)) ? parseFloat(planLineItem.aug_req_qty) : 0;
            const sepReqQty = !isNaN(parseFloat(planLineItem.sep_req_qty)) ? parseFloat(planLineItem.sep_req_qty) : 0;

            total = octReqQty + novReqQty + decReqQty + janReqQty + febReqQty + marReqQty + aprReqQty + mayReqQty + junReqQty + julReqQty + augReqQty + sepReqQty;

            return total.toFixed(2);

        },

        getUomCodeDescription(uomCodes, uomCode) {
            const foundUomCode = uomCodes.find(item => item.uom_code == uomCode);
            return foundUomCode ? foundUomCode.unit_of_measure : "";
        },

        formatNumber(value) {
            let result = value.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return result;
        },

        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        }

    }

}

</script>