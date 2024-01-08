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
                
                <div>
                    <div class="tw-inline-block tw-px-4"> แผนการผลิตบุหรี่ : </div>
                    <div class="tw-inline-block btn-group" role="group">
                        <button type="button" @click="toggleProductType('71')" class="btn" v-bind:class="[isProduct71Active ? 'btn-primary' : 'btn-white']"> 7.1 </button>
                        <button type="button" @click="toggleProductType('78')" class="btn" v-bind:class="[isProduct78Active ? 'btn-primary' : 'btn-white']"> 7.8 </button>
                    </div>
                </div>

                <hr>

                <div v-if="isProduct71Active" class="table-responsive" style="max-height: 400px;">

                    <table class="table table-bordered table-sticky mb-0" style="min-width: 800px;">

                        <thead>
                            <tr>
                                <th class="text-center freeze-col" style="min-width: 220px;">
                                    <div class="freeze-col-content" style="padding: 0px;">
                                        <div class="text-center tw-inline-block tw-align-top tw-py-4 tw-py-5" style="min-width: 50px; max-width: 50px;">
                                            ลำดับ  
                                        </div>
                                        <div class="text-center tw-inline-block tw-align-top tw-py-4 tw-py-5" style="min-width: 140px; max-width: 140px; border-left: 1px solid #ddd;">
                                            ขอบเขตเครื่องจักร
                                        </div>
                                    </div>
                                </th>
                                <template v-for="(productDaily71Date, pdhIndex) in productDaily71Dates">
                                    <th :key="`pdh_${pdhIndex}`" style="min-width: 140px;" class="text-center"> 
                                        <div> {{ getDayOfWeekTh(productDaily71Date.daily_date) }} </div>
                                        <div> {{ formatDateTh(productDaily71Date.daily_date) }} </div>
                                        <div class="tw-text-xs"> WH : 
                                            <span v-if="!productDaily71Date.working_hour" class="badge badge-default"> - </span> 
                                            <span v-if="parseFloat(productDaily71Date.working_hour) < 10" class="badge badge-warning"> {{ productDaily71Date.working_hour }} </span> 
                                            <span v-if="parseFloat(productDaily71Date.working_hour) >= 10" class="badge badge-danger"> {{ productDaily71Date.working_hour }} </span> 
                                        </div>
                                    </th>
                                </template>
                            </tr>
                        </thead>
                        <tbody v-if="productMachine71GroupItems.length > 0">
                            <template v-for="(productMachine71GroupItem, index) in productMachine71GroupItems">
                                <tr :key="`1_${index}`">
                                    <td rowspan="2" class="freeze-col text-center" style="min-width: 220px;">
                                        <div class="freeze-col-content" style="padding: 0px;">
                                            <div class="text-center tw-inline-block tw-align-top tw-py-5 tw-pr-2" style="min-width: 50px; max-width: 50px;">
                                                {{ index+1 }}
                                            </div>
                                            <div class="text-center tw-inline-block tw-align-top tw-py-5 tw-px-2" style="min-width: 140px; max-width: 140px; border-left: 1px solid #ddd;">
                                                {{ productMachine71GroupItem.machine_group_desc }}
                                            </div>
                                        </div>
                                    </td>
                                    <template v-for="(productDaily71Date, pddfIndex) in productDaily71Dates">
                                        <td :key="`pddf_${pddfIndex}`" style="min-width: 140px; border-bottom-color: #f5f5f5;" class="text-center"> 
                                            <div v-if="product71PlanItems.find(item => (item.daily_date == productDaily71Date.daily_date && item.machine_group == productMachine71GroupItem.machine_group))">
                                                {{ (product71PlanItems.find(item => (item.daily_date == productDaily71Date.daily_date && item.machine_group == productMachine71GroupItem.machine_group))).item_description }}
                                            </div>
                                        </td>
                                    </template>
                                </tr>
                                <tr :key="`2_${index}`">
                                    <template v-for="(productDaily71Date, pddsIndex) in productDaily71Dates">
                                        <td :key="`pdds_${pddsIndex}`" style="border-top-color: #f5f5f5;" class="text-center"> 
                                            <div v-if="product71PlanItems.find(item => (item.daily_date == productDaily71Date.daily_date && item.machine_group == productMachine71GroupItem.machine_group))">
                                                {{ Number((product71PlanItems.find(item => (item.daily_date == productDaily71Date.daily_date && item.machine_group == productMachine71GroupItem.machine_group))).date_efficiency_product).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}) }}
                                            </div>
                                            <div v-else> 0.000 </div>
                                        </td>
                                    </template>
                                </tr>
                            </template>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="4">
                                    <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>

                <div v-if="isProduct78Active" class="table-responsive" style="max-height: 400px;">

                    <table class="table table-bordered table-sticky mb-0" style="min-width: 800px;">

                        <thead>
                            <tr>
                                <th class="text-center freeze-col" style="min-width: 220px;">
                                    <div class="freeze-col-content" style="padding: 0px;">
                                        <div class="text-center tw-inline-block tw-align-top tw-py-5" style="min-width: 50px; max-width: 50px;">
                                            ลำดับ  
                                        </div>
                                        <div class="text-center tw-inline-block tw-align-top tw-py-5" style="min-width: 140px; max-width: 140px; border-left: 1px solid #ddd;">
                                            ขอบเขตเครื่องจักร
                                        </div>
                                    </div>
                                </th>
                                <template v-for="(productDaily78Date, pdhIndex) in productDaily78Dates">
                                    <th :key="`pdh_${pdhIndex}`" style="min-width: 140px;" class="text-center"> 
                                        <div> {{ getDayOfWeekTh(productDaily78Date.daily_date) }} </div>
                                        <div> {{ formatDateTh(productDaily78Date.daily_date) }} </div>
                                        <div class="tw-text-xs"> WH : 
                                            <span v-if="!productDaily78Date.working_hour" class="badge badge-default"> - </span> 
                                            <span v-if="parseFloat(productDaily78Date.working_hour) < 10" class="badge badge-warning"> {{ productDaily78Date.working_hour }} </span> 
                                            <span v-if="parseFloat(productDaily78Date.working_hour) >= 10" class="badge badge-danger"> {{ productDaily78Date.working_hour }} </span> 
                                        </div>
                                    </th>
                                </template>
                            </tr>
                        </thead>
                        <tbody v-if="productMachine78GroupItems.length > 0">
                            <template v-for="(productMachine78GroupItem, index) in productMachine78GroupItems">
                                <tr :key="`1_${index}`">
                                    <td rowspan="2" class="freeze-col text-center" style="min-width: 220px;">
                                        <div class="freeze-col-content" style="padding: 0px;">
                                            <div class="text-center tw-inline-block tw-align-top tw-py-5 tw-pr-2" style="min-width: 50px; max-width: 50px;">
                                                {{ index+1 }}
                                            </div>
                                            <div class="text-center tw-inline-block tw-align-top tw-py-5 tw-px-2" style="min-width: 140px; max-width: 140px; border-left: 1px solid #ddd;">
                                                {{ productMachine78GroupItem.machine_group_desc }}
                                            </div>
                                        </div>
                                    </td>
                                    <template v-for="(productDaily78Date, pddfIndex) in productDaily78Dates">
                                        <td :key="`pddf_${pddfIndex}`" style="min-width: 140px; border-bottom-color: #f5f5f5;" class="text-center"> 
                                            <div v-if="product78PlanItems.find(item => (item.daily_date == productDaily78Date.daily_date && item.machine_group == productMachine78GroupItem.machine_group))">
                                                {{ (product78PlanItems.find(item => (item.daily_date == productDaily78Date.daily_date && item.machine_group == productMachine78GroupItem.machine_group))).item_description }}
                                            </div>
                                        </td>
                                    </template>
                                </tr>
                                <tr :key="`2_${index}`">
                                    <template v-for="(productDaily78Date, pddsIndex) in productDaily78Dates">
                                        <td :key="`pdds_${pddsIndex}`" style="border-top-color: #f5f5f5;" class="text-center"> 
                                            <div v-if="product78PlanItems.find(item => (item.daily_date == productDaily78Date.daily_date && item.machine_group == productMachine78GroupItem.machine_group))">
                                                {{ Number((product78PlanItems.find(item => (item.daily_date == productDaily78Date.daily_date && item.machine_group == productMachine78GroupItem.machine_group))).date_efficiency_product).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}) }}
                                            </div>
                                            <div v-else> 0.000 </div>
                                        </td>
                                    </template>
                                </tr>
                            </template>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="4">
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
        "biweeklyValue", 
        "printTypeValue", 
        "saleTypeValue", 
        "productDaily71Dates",
        "productMachine71Groups",
        "product71Plans",
        "productDaily78Dates",
        "productMachine78Groups",
        "product78Plans",
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
        biweeklyValue : function (value) {
            this.biweekly = value;
        },
        printTypeValue : function (value) {
            this.printType = value;
        },
        saleTypeValue : function (value) {
            this.saleType = value;
        },
        productDaily71Dates : function (value) {
            this.productDaily71DateItems = value;
        },
        productMachine71Groups : function (value) {
            this.productMachine71GroupItems = value;
        },
        product71Plans : function (value) {
            this.product71PlanItems = value;
        },
        productDaily78Dates : function (value) {
            this.productDaily78DateItems = value;
        },
        productMachine78Groups : function (value) {
            this.productMachine78GroupItems = value;
        },
        product78Plans : function (value) {
            this.product78PlanItems = value;
        },
        
    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            periodYear: this.periodYearValue,
            periodName: this.periodNameValue,
            biweekly: this.biweeklyValue,
            printType: this.printTypeValue,
            saleType: this.saleTypeValue,
            isProduct71Active: true,
            isProduct78Active: false,
            productDaily71DateItems: this.productDaily71Dates.length > 0 ? this.productDaily71Dates : [],
            productMachine71GroupItems: this.productMachine71Groups.length > 0 ? this.productMachine71Groups : [],
            product71PlanItems: this.product71Plans.length > 0 ? this.product71Plans : [],
            productDaily78DateItems: this.productDaily78Dates.length > 0 ? this.productDaily78Dates : [],
            productMachine78GroupItems: this.productMachine78Groups.length > 0 ? this.productMachine78Groups : [],
            product78PlanItems: this.product78Plans.length > 0 ? this.product78Plans : [],
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

        toggleProductType(productType) {

            this.isProduct71Active = false;
            this.isProduct78Active = false;

            this.$nextTick(() => {
                if(productType == '71'){ this.isProduct71Active = true; }
                if(productType == '78'){ this.isProduct78Active = true; }
            });

        },


        getUomCodeDescription(uomCodes, uomCode) {
            const foundUomCode = uomCodes.find(item => item.uom_code == uomCode);
            return foundUomCode ? foundUomCode.unit_of_measure : "";
        },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
        },

        getDayOfWeekTh(date) {
            
            let result = "-";
            const dayNumber = date ? moment(date).day() : 0;
            
            switch(dayNumber) {
                case 0:
                    result = "อาทิตย์"
                    break;
                case 1:
                    result = "จันทร์"
                    break;
                case 2:
                    result = "อังคาร"
                    break;
                case 3:
                    result = "พุธ"
                    break;
                case 4:
                    result = "พฤหัสบดี"
                    break;
                case 5:
                    result = "ศุกร์"
                    break;
                case 6:
                    result = "เสาร์"
                    break;
                default:
                    result = "-"
            }

            return result;

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
