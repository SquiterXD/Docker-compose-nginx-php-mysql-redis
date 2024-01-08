<template>

    <div>

        <hr>

        <h3> รายละเอียดวัตถุดิบ </h3>

        <div class="row">
            <div class="col-3">
                <p> กลุ่มผลิตภัณฑ์ : {{ stdcostPrdItemData.product_group }} ({{ stdcostPrdItemData.product_group_name }}) </p>
            </div>
            <div class="col-3">
                <p> ผลิตภัณฑ์ : {{ stdcostPrdItemData.product_item_number ? stdcostPrdItemData.product_item_number : "-" }} </p>
            </div>
            <div class="col-3">
                <p> ชื่อผลิตภัณฑ์ : {{ stdcostPrdItemData.product_item_desc ? stdcostPrdItemData.product_item_desc : "-" }} </p>
            </div>
            <!-- <div class="col-3">
                <p> Lot Number : {{ stdcostPrdItemData.product_lot_number ? stdcostPrdItemData.product_lot_number : "-" }} </p>
            </div> -->
        </div>

        <div class="table-responsive" style="max-height: 400px;">

            <table class="table table-bordered table-sticky mb-0" style="min-width: 1600px;">
                <thead>
                    <tr>
                        <th width="6%" class="text-center tw-text-xs md:tw-table-cell"> กลุ่มผลิตภัณฑ์ </th>
                        <th width="8%" class="text-center tw-text-xs md:tw-table-cell"> ผลิตภัณฑ์ </th>
                        <!-- <th width="7%" class="text-center tw-text-xs md:tw-table-cell"> Product Lot Number </th> -->
                        <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> รหัสวัตถุดิบ </th>
                        <th width="12%" class="text-center tw-text-xs md:tw-table-cell"> ชื่อวัตถุดิบ </th>
                        <!-- <th width="7%" class="text-center tw-text-xs md:tw-table-cell"> Lot Number </th> -->
                        <th width="5%" class="text-center tw-text-xs md:tw-table-cell"> หน่วย </th>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell"> ขึ้นตอน </th>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell"> ประเภท </th>
                        <th width="12%" class="text-right tw-text-xs md:tw-table-cell"> จำนวนที่ใช้ </th>
                        <th width="12%" class="text-right tw-text-xs md:tw-table-cell"> จำนวนที่สูญเสีย </th>
                        <th width="12%" class="text-right tw-text-xs md:tw-table-cell"> ราคาซื้อครั้งสุดท้าย </th>
                        <th width="12%" class="text-right tw-text-xs md:tw-table-cell"> จำนวนรวม </th>
                        <th width="12%" class="text-right tw-text-xs md:tw-table-cell"> อัตรามาตรฐาน/หน่วย </th>
                    </tr>
                </thead>
                <tbody v-if="stdcostMaterialItems.length > 0">
                    <template v-for="(stdcostMaterialItem, index) in stdcostMaterialItems">

                        <tr :key="index">

                            <td class="text-center md:tw-table-cell">
                                {{ stdcostMaterialItem.product_group }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostMaterialItem.product_item_number }}
                            </td>
                            <!-- <td class="text-center md:tw-table-cell">
                                {{ stdcostMaterialItem.product_lot_number }}
                            </td> -->
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostMaterialItem.item_number }}
                            </td>
                            <td class="text-left md:tw-table-cell">
                                {{ stdcostMaterialItem.item_desc }}
                            </td>
                            <!-- <td class="text-center md:tw-table-cell">
                                {{ stdcostMaterialItem.lot_number }}
                            </td> -->
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostMaterialItem.uom_code }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostMaterialItem.wip_step }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostMaterialItem.type_name }}
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostMaterialItem.quantity_used ? Number(stdcostMaterialItem.quantity_used).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostMaterialItem.quantity_lost ? Number(stdcostMaterialItem.quantity_lost).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostMaterialItem.last_cost ? Number(stdcostMaterialItem.last_cost).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostMaterialItem.cost_raw_mate ? Number(stdcostMaterialItem.cost_raw_mate).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostMaterialItem.unit_std_cost ? Number(stdcostMaterialItem.unit_std_cost).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                            </td>

                        </tr>

                    </template>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="14">
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
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableStdCostTargets from "./TableStdCostTargets";

export default {
    
    props: ["periodYearValue", "stdcostHead", "stdcostPrdItem", "stdcostMaterials", "allocateTypes"],

    components: { Loading, VueNumeric, TableStdCostTargets },

    watch: {
        periodYearValue : function (value) {
            this.periodYear = value;
        },
        stdcostHead : function (value) {
            this.stdcostHeadData = value;
        },
        stdcostPrdItem : function (value) {
            this.stdcostPrdItemData = value;
        },
        stdcostMaterials : function (value) {
            this.stdcostMaterialItems = value.map(item => {
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
            stdcostPrdItemData: this.stdcostPrdItem,
            stdcostMaterialItems: this.stdcostMaterials.map(item => {
                return {
                    ...item,
                    allocate_type_label: this.getAllocateTypeLabel(this.allocateTypes, item.allocate_type)
                }
            }),
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