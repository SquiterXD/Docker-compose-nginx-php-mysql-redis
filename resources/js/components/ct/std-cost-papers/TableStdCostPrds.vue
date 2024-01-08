<template>

    <div>

        <div class="table-responsive" style="max-height: 300px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="12%" class="text-center tw-text-xs md:tw-table-cell"> กลุ่มผลิตภัณฑ์ </th>
                        <th width="12%" class="text-center tw-text-xs md:tw-table-cell"> ผลิตภัณฑ์ </th>
                        <th width="20%" class="text-center tw-text-xs md:tw-table-cell"> ชื่อผลิตภัณฑ์ </th>
                        <!-- <th width="8%" class="text-center tw-text-xs md:tw-table-cell"> Lot Number </th> -->
                        <th width="18%" class="text-right tw-text-xs md:tw-table-cell"> ต้นทุนวัตถุดิบรวม(บาท) </th>
                        <th width="18%" class="text-right tw-text-xs md:tw-table-cell"> ต้นทุนวัตถุดิบมาตรฐานต่อ 1 หน่วย </th>
                        <th width="13%" class="text-center tw-text-xs md:tw-table-cell"> </th>
                    </tr>
                </thead>
                <tbody v-if="stdcostPrdItems.length > 0">
                    <template v-for="(stdcostPrdItem, index) in stdcostPrdItems">

                        <tr :key="index">

                            <td class="text-left md:tw-table-cell">
                                {{ stdcostPrdItem.product_group }} : {{ stdcostPrdItem.product_group_name }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdItem.product_item_number }}
                            </td>
                            <td class="text-left md:tw-table-cell">
                                {{ stdcostPrdItem.product_item_desc }}
                            </td>
                            <!-- <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdItem.product_lot_number }}
                            </td> -->
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdItem.cost_raw_mate ? Number(stdcostPrdItem.cost_raw_mate).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdItem.unit_cost_raw_mate ? Number(stdcostPrdItem.unit_cost_raw_mate).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                            </td>

                            <td class="text-center md:tw-table-cell">

                                <button class="btn btn-xs btn-inline-block btn-primary tw-w-full"
                                    @click="showStdcostMaterialItems(stdcostPrdItem)">
                                    <i class="fa fa-arrow-down"></i> รายละเอียดวัตถุดิบ
                                </button>
                                
                            </td>

                        </tr>

                    </template>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="7">
                            <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div v-if="selectedStdCostPrdItem" class="row tw-my-5">
        
            <div class="col-12">

                <table-std-cost-items 
                    :period-year-value="periodYear"
                    :allocate-types="allocateTypes"
                    :stdcost-head="stdcostHead"
                    :stdcost-prd-item="selectedStdCostPrdItem"
                    :stdcost-materials="selectedStdcostMaterialItems" 
                >
                </table-std-cost-items>

            </div>

        </div>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableStdCostItems from "./TableStdCostItems";

export default {
    
    props: ["periodYearValue", "stdcostHead", "stdcostPrds", "stdcostMaterials", "allocateTypes"],

    components: { Loading, VueNumeric, TableStdCostItems },

    watch: {
        periodYearValue : function (value) {
            this.periodYear = value;
        },
        stdcostHead : function (value) {
            this.stdcostHeadData = value;
        },
        stdcostPrds : function (data) {
            this.stdcostPrdItems = data.map(item => {
                return {
                    ...item
                }
            });
        },
        stdcostMaterials : function (data) {
            this.stdcostMaterialItems = data.map(item => {
                return {
                    ...item
                }
            });
        },
    },

    data() {

        return {

            periodYear: this.periodYearValue,
            stdcostHeadData: this.stdcostHead,
            stdcostPrdItems: this.stdcostPrds.map(item => {
                return {
                    ...item,
                    allocate_type_label: this.getAllocateTypeLabel(this.allocateTypes, item.allocate_type)
                }
            }),
            stdcostMaterialItems: this.stdcostMaterials.map(item => {
                return {
                    ...item,
                }
            }),
            selectedStdCostPrdItem: null,
            selectedStdcostMaterialItems: [],
            isLoading: false

        }

    },

    mounted() {

    },

    computed: {

    },
    methods: {


        getAllocateTypeLabel(listAllocateTypes, allocateTypeValue) {
            let result = "";
            if(listAllocateTypes.length > 0 && allocateTypeValue) {
                const foundAllocateType = listAllocateTypes.find(item => item.allocate_type_value == allocateTypeValue);
                result = foundAllocateType ? foundAllocateType.allocate_type_label : "";
            }
            return result
        },

        showStdcostMaterialItems(stdcostPrdItem) {

            this.selectedStdCostPrdItem = stdcostPrdItem;
            this.selectedStdcostMaterialItems = this.stdcostMaterialItems.filter(item => {
                return item.product_group == stdcostPrdItem.product_group && item.product_item_number == stdcostPrdItem.product_item_number && item.product_lot_number == stdcostPrdItem.product_lot_number;
            });

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