<template>

    <div>

        <div class="table-responsive" style="max-height: 300px;">
            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> กลุ่มผลิตภัณฑ์ </th>
                        <th width="15%" class="text-center tw-text-xs md:tw-table-cell"> รายละเอียด </th>
                        <th width="12%" class="text-right tw-text-xs md:tw-table-cell"> แสดงค่าหน่วยนับต่อศูนย์ต้นทุน </th>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell"> หน่วยนับ </th>
                        <th width="15%" class="text-right tw-text-xs md:tw-table-cell"> ค่าแรง </th>
                        <th width="15%" class="text-right tw-text-xs md:tw-table-cell"> ค่าใช้จ่ายผันแปร </th>
                        <th width="15%" class="text-right tw-text-xs md:tw-table-cell"> ค่าใช้จ่ายคงที่ </th>
                    </tr>
                </thead>
                <tbody v-if="stdcostPrdGroupItems.length > 0">
                    <template v-for="(stdcostPrdGroupItem, index) in stdcostPrdGroupItems">

                        <tr :key="index" v-if="!stdcostPrdGroupItem.marked_as_deleted">

                            <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdGroupItem.product_group }}
                            </td>
                            <td class="text-left md:tw-table-cell">
                                {{ stdcostPrdGroupItem.product_group_desc }}
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdGroupItem.cost_quantity ? Number(stdcostPrdGroupItem.cost_quantity).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdGroupItem.cost_uom_code_desc }}
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdGroupItem.wage_cost ? Number(stdcostPrdGroupItem.wage_cost).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdGroupItem.vary_cost ? Number(stdcostPrdGroupItem.vary_cost).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdGroupItem.fixed_cost ? Number(stdcostPrdGroupItem.fixed_cost).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
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

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

export default {
    
    props: ["uomCodes", "periodYearValue", "stdcostYear", "stdcostPrdGroups", "allocateTypes"],

    components: { Loading, VueNumeric },

    watch: {

        periodYearValue : function (value) {
            this.periodYear = value;
        },
        stdcostYear : function (value) {
            this.stdcostYearData = value;
        },
        stdcostPrdGroups : function (value) {
            this.stdcostPrdGroupItems = value.map(item => {
                return {
                    ...item,
                    cost_uom_code_desc: this.getUomCodeDesc(this.uomCodes, item.cost_uom_code),
                    marked_as_deleted: false,
                }
            });
        },

    },

    data() {

        return {

            periodYear: this.periodYearValue,
            stdcostYearData: this.stdcostYear,
            selectedStdcostPrdGroupItem: null,
            stdcostPrdGroupItems: this.stdcostPrdGroups.map(item => {
                return {
                    ...item,
                    cost_uom_code_desc: this.getUomCodeDesc(this.uomCodes, item.cost_uom_code),
                    allocate_type_label: this.getAllocateTypeLabel(this.allocateTypes, item.allocate_type),
                    marked_as_deleted: false,
                }
            }),
            stdcostPrdGroupTotals: [],
            totalEstimateExpenseAmount: this.stdcostPrdGroups.reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0),
            isLoading: false

        }

    },

    mounted() {

    },

    computed: {

    },
    methods: {

        getUomCodeDesc(uomCodes, uomCode) {
            let result = "";
            if(uomCodes.length > 0 && uomCode) {
                const foundUomCode = uomCodes.find(item => item.uom_code == uomCode);
                result = foundUomCode ? foundUomCode.unit_of_measure : "";
            }
            return result
        },

        getAllocateTypeLabel(listAllocateTypes, allocateTypeValue) {
            let result = "";
            if(listAllocateTypes.length > 0 && allocateTypeValue) {
                const foundAllocateType = listAllocateTypes.find(item => item.allocate_type_value == allocateTypeValue);
                result = foundAllocateType ? foundAllocateType.allocate_type_label : "";
            }
            return result
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