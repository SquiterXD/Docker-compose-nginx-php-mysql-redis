<template>

    <div>

        <div class="table-responsive">

            <table class="table table-bordered table-sticky mb-0" style="min-width: 1400px;">
                <thead>
                    <tr>
                        <th class="freeze-col" style="height: 50px; min-width: 700px;"> 
                            <div class="freeze-col-content" style="padding: 0px;">
                                <div class="text-center tw-inline-block tw-align-top tw-py-4" style="min-width: 140px; max-width: 140px;">
                                    ตราบุหรี่ 
                                </div>
                                <div class="text-center tw-inline-block tw-align-top tw-py-4" style="min-width: 120px; max-width: 120px; border-left: 1px solid #ddd;">
                                    ประเภทสิ่งพิมพ์
                                </div>
                                <div class="text-center tw-inline-block tw-align-top tw-py-4" style="min-width: 120px; max-width: 120px; border-left: 1px solid #ddd;">
                                    รหัสสินค้าสำเร็จรูป
                                </div>
                                <div class="text-center tw-inline-block tw-align-top tw-py-4" style="min-width: 280px; max-width: 280px; border-left: 1px solid #ddd;">
                                    รายละเอียด
                                </div>
                            </div>
                        </th>
                        <th class="text-center" style="height: 50px; min-width: 160px;"> สั่งผลิต(ม้วนใหญ่) </th>
                        <th class="text-center" style="height: 50px; min-width: 130px; max-width: 130px;"> หน่วย (ผลิต) </th>
                        <th class="text-center" style="height: 50px; min-width: 130px; max-width: 130px;"> คำสั่งทั้งเดือน </th>
                        <th class="text-center" style="height: 50px; min-width: 130px; max-width: 130px;"> เหลือที่ต้องผลิต </th>
                        <th class="text-center" style="height: 50px; min-width: 130px; max-width: 130px;"> เลขคำสั่งผลิต </th>
                        <!-- <th class="text-center" style="height: 50px; min-width: 200px; max-width: 200px;"> ประมาณการผลิตจากฝ่ายวางแผน </th> -->
                    </tr>
                </thead>
                <tbody v-if="planLineItems.length > 0">
                    <template v-for="(planLineItem, index) in planLineItems">
                        <tr :key="`${index}`" v-bind:style="{ backgroundColor: parseInt(planLineItem.product_qty) == 0 ? '#FDF5EF': '' }">
                            <td class="freeze-col" style="min-width: 700px;"> 
                                <div class="freeze-col-content" style="padding: 0px;" v-bind:style="{ backgroundColor: parseInt(planLineItem.product_qty) == 0 ? '#FDF5EF': '' }">
                                    <div class="text-center tw-inline-block tw-align-top tw-py-4 tw-pr-2" style="min-width: 140px; max-width: 140px;">
                                        {{ planLineItem.product_item_desc ? planLineItem.product_item_desc : "-" }} 
                                    </div>
                                    <div class="text-center tw-inline-block tw-align-top tw-py-4 tw-px-2" style="min-width: 120px; max-width: 120px; border-left: 1px solid #ddd;">
                                        {{ planLineItem.inv_item_type ? planLineItem.inv_item_type : "-" }}
                                    </div>
                                    <div class="text-center tw-inline-block tw-align-top tw-py-4 tw-px-2" style="min-width: 120px; max-width: 120px; border-left: 1px solid #ddd;">
                                        {{ planLineItem.inv_item_number ? planLineItem.inv_item_number : "-" }}
                                    </div>
                                    <div class="text-left tw-inline-block tw-align-top tw-py-4 tw-px-2" style="min-width: 280px; max-width: 280px; border-left: 1px solid #ddd;">
                                        {{ planLineItem.inv_item_desc ? planLineItem.inv_item_desc : "-" }}
                                    </div>
                                </div>
                                <!-- <div class="tw-mt-2 tw-pt-3 tw-p-2 tw-text-xs" style="min-width: 400px; max-width: 400px; border-top: 1px dashed #f2f2f2;">
                                    <span class="tw-font-bold"> รายละเอียด : </span> {{ planLineItem.inv_item_desc }}
                                </div> -->
                            </td>
                            <td class="text-right" style="min-width: 160px;"> 
                                <div>
                                    {{ planLineItem.product_qty ? Number(planLineItem.product_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }}
                                </div>
                            </td>
                            <td class="text-center" style="min-width: 130px; max-width: 130px;"> {{ planLineItem.uom_desc }} </td>
                            <td class="text-right" style="min-width: 130px; max-width: 130px;"> {{ planLineItem.period_name_request ? Number(planLineItem.period_name_request).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }} </td>
                            <td class="text-right" style="min-width: 130px; max-width: 130px;"> {{ planLineItem.period_name_qty ? Number(planLineItem.period_name_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "" }} </td>
                            <td class="text-center" style="min-width: 130px; max-width: 130px;"> {{ getRequestNumber(planLineItem) }} </td>
                            <!-- <td class="text-right" style="min-width: 200px; max-width: 200px;"> {{ planLineItem.estimate_qty }} </td> -->
                        </tr>
                    </template>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="10">
                            <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                        </td>
                    </tr>
                </tbody>

            </table>

        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {

    components: { 
        Loading,
        VueNumeric 
    },
    
    props: ["planHeader","planLines","uomCodes"],

    watch: {

        planHeader : function (value) {
            this.planHeaderData = value;
        },

        planLines : function (data) {
            this.planLineItems = data.map(item => {
                return {
                    ...item,
                    period_name_qty: item.product_qty ? (parseFloat(item.period_name_request) - parseFloat(item.product_qty)).toFixed(2) : parseFloat(item.period_name_request).toFixed(2),
                    uom_desc : this.getUomCodeDescription(this.uomCodes, item.uom),
                }
            }).sort((a, b) => {
                if(a.inv_item_number < b.inv_item_number) { return -1; }
                if(a.inv_item_number > b.inv_item_number) { return 1; }
                return 0;
            });
        },
    },

    data() {

        return {

            planHeaderData: this.planHeader,
            planLineItems: this.planLines.map(item => {
                return {
                    ...item,
                    period_name_qty: item.product_qty ? (parseFloat(item.period_name_request) - parseFloat(item.product_qty)).toFixed(2) : parseFloat(item.period_name_request).toFixed(2),
                    uom_desc : this.getUomCodeDescription(this.uomCodes, item.uom),
                }
            }).sort((a, b) => {
                if(a.inv_item_number < b.inv_item_number) { return -1; }
                if(a.inv_item_number > b.inv_item_number) { return 1; }
                return 0;
            }),
            isLoading: false

        }

    },

    mounted() {
    },

    computed: {

    },
    methods: {

        getUomCodeDescription(uomCodes, uomCode) {
            const foundUomCode = uomCodes.find(item => item.uom_code == uomCode);
            return foundUomCode ? foundUomCode.unit_of_measure : "";
        },

        onProductQtyValueChanged(planLineItem) {

            if(planLineItem.product_qty) {
                planLineItem.period_name_qty = (parseFloat(planLineItem.period_name_request) - parseFloat(planLineItem.product_qty)).toFixed(2);
            } else {
                planLineItem.period_name_qty = parseFloat(planLineItem.period_name_request).toFixed(2);
            }

        },

        getRequestNumber(planLineItem) {

            let requestNumber = "";
            if(Number(planLineItem.product_qty == 0) && this.isOrderOpened(this.planLineItems)) {
                requestNumber = "ไม่ผลิต"
            } else {
                requestNumber = planLineItem.request_number;
            }
            return requestNumber;
        },

        isOrderOpened(planLineItems) {

            const foundRequestNumber = planLineItems.find(item => {
                return !!item.request_number;
            });
            return !!foundRequestNumber;

        },

    }

}

</script>