<template>

    <div style="position: fixed; z-index: 100;">
        
        <modal
            :name="modalName"
            :width="width"
            :scrollable="true"
            :height="modalHeight"
            :shiftX="0.3"
            :shiftY="0.3"
        >

            <div class="p-4">

                <h4> รายละเอียดแผนรายปักษ์จากฝ่ายขาย </h4>
                <hr>

                <div class="table-responsive" style="max-height: 400px;">

                    <table class="table table-bordered mb-0">

                        <thead>
                            <tr>
                                <!-- <th width="10%" class="text-center"> Item ID </th> -->
                                <th width="15%" class="text-center"> รหัสสินค้า </th>
                                <th width="30%" class="text-center"> ตราบุหรี่ </th>
                                <th width="20%" class="text-center"> 
                                    <div v-if="biweeklyInfo.length > 0"> ปักษ์ที่ {{ biweeklyInfo[0].biweekly_no }} </div>
                                    <div v-if="biweeklyInfo.length > 0"> {{ biweeklyInfo[0].start_date }} - {{ biweeklyInfo[0].end_date }} </div>
                                </th>
                                <th width="20%" class="text-center"> 
                                    <div v-if="biweeklyInfo.length > 0"> ปักษ์ที่ {{ biweeklyInfo[1].biweekly_no }} </div>
                                    <div v-if="biweeklyInfo.length > 0"> {{ biweeklyInfo[1].start_date }} - {{ biweeklyInfo[1].end_date }} </div>
                                </th>
                                <th width="10%" class="text-center"> หน่วย </th>
                            </tr>
                        </thead>
                        <tbody v-if="salesForecastItems.length > 0">
                            <template v-for="(salesForecastItem, index) in salesForecastItems">
                                <tr :key="`${index}`">
                                    <!-- <td width="10%" class="text-center">  
                                        {{ salesForecastItem.item_id }}
                                    </td> -->
                                    <td width="15%" class="text-center">  
                                        {{ salesForecastItem.item_code }}
                                    </td>
                                    <td width="30%" class="text-left">  
                                        {{ salesForecastItem.item_description }}
                                    </td>
                                    <td width="20%" class="text-left">  
                                        <div> <span class="pull-right"> {{ Number(salesForecastItem.biweekly_0_quantity).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}) }} </span> </div>
                                    </td>
                                    <td width="20%" class="text-left">  
                                        <div> <span class="pull-right"> {{ Number(salesForecastItem.biweekly_1_quantity).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}) }} </span> </div>
                                    </td>
                                    <td width="10%" class="text-center">  
                                        {{ getUomCodeDescription(uomCodes, salesForecastItem.uom) }}
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="20">
                                    <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>

            </div>

        </modal>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

export default {

    props: [
        "modalName", 
        "modalWidth", 
        "modalHeight", 
        "periodYearValue", 
        "periodNameValue", 
        "printTypeValue", 
        "saleTypeValue", 
        "sourceVersionValue", 
        "monthlyPlanVersionValue",
        "salesForecasts",
        "uomCodes"
    ],

    components: { Loading },

    watch: {
        periodYearValue : function (value) {
            this.periodYear = value;
        },
        periodNameValue : function (value) {
            this.periodName = value;
        },
        printTypeValue : function (value) {
            this.printType = value;
        },
        saleTypeValue : function (value) {
            this.saleType = value;
        },
        sourceVersionValue : function (value) {
            this.sourceVersion = value;
        },
        monthlyPlanVersionValue : function (value) {
            this.monthlyPlanVersion = value;
        },
        salesForecasts : function (value) {
            this.salesForecastItems = value;
            this.biweeklyInfo = this.getBiweeklyInfo(value);
        },
        
    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            periodYear: this.periodYearValue,
            periodName: this.periodNameValue,
            printType: this.printTypeValue,
            saleType: this.saleTypeValue,
            sourceVersion: this.sourceVersionValue,
            monthlyPlanVersion: this.monthlyPlanVersionValue,
            salesForecastItems: this.salesForecasts.length > 0 ? this.salesForecasts : [],
            biweeklyInfo: this.salesForecasts.length > 0 ? this.getBiweeklyInfo(this.salesForecasts) : []
        };
    },

    created() {

        this.handleResize();

    },

    methods: {

        handleResize() {
            if (window.innerWidth < 768) {
                // set modal width = 90% when screen width < 769px
                this.width = "90%";
            } else if (window.innerWidth < 992) {
                // set modal width = 80% when screen width < 992px
                this.width = "80%";
            } else {
                this.width = this.modalWidth;
            }
        },

        getUomCodeDescription(uomCodes, uomCode) {
            const foundUomCode = uomCodes.find(item => item.uom_code == uomCode);
            return foundUomCode ? foundUomCode.unit_of_measure : "";
        },

        getBiweeklyInfo(salesForecasts) {
            let data = [];
            if(salesForecasts.length > 0) {
                data = [
                    {
                        biweekly_no: salesForecasts ? salesForecasts[0].biweekly_0_no : "-",
                        start_date: salesForecasts ? this.formatDateTh(salesForecasts[0].biweekly_0_start_date) : "-",
                        end_date: salesForecasts ? this.formatDateTh(salesForecasts[0].biweekly_0_end_date) : "-",
                    },
                    {
                        biweekly_no: salesForecasts ? salesForecasts[0].biweekly_1_no : "-",
                        start_date: salesForecasts ? this.formatDateTh(salesForecasts[0].biweekly_1_start_date) : "-",
                        end_date: salesForecasts ? this.formatDateTh(salesForecasts[0].biweekly_1_end_date) : "-",
                    }
                ];
            }
            return data;
        },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
        },

    }
};
</script>

<style scoped>
.v--modal-overlay {
  z-index: 2000;
  padding-top: 3rem;
  padding-bottom: 3rem;
}
</style>
