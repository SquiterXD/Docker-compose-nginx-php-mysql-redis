<template>

    <div>

        <div class="table-responsive tw-pl-10" style="max-height: 300px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="5%" style="background-color: #fdf4e0;" class="text-center tw-text-xs md:tw-table-cell"> กลุ่มผลิตภัณฑ์ </th>
                        <th width="10%" style="background-color: #fdf4e0;" class="text-center tw-text-xs md:tw-table-cell"> ผลิตภัณฑ์ </th>
                        <th width="8%" style="background-color: #fdf4e0;" class="text-center tw-text-xs md:tw-table-cell"> รหัสวัตถุดิบ </th>
                        <th width="13%" style="background-color: #fdf4e0;" class="text-center tw-text-xs md:tw-table-cell"> วัตถุดิบ </th>
                        <!-- <th width="8%" style="background-color: #fdf4e0;" class="text-center tw-text-xs md:tw-table-cell"> Lot Number </th> -->
                        <th width="8%" style="background-color: #fdf4e0;" class="text-center tw-text-xs md:tw-table-cell"> ขั้นตอน </th>
                        <th width="8%" style="background-color: #fdf4e0;" class="text-center tw-text-xs md:tw-table-cell"> ประเภท </th>
                        <th width="12%" style="background-color: #fdf4e0;" class="text-right tw-text-xs md:tw-table-cell"> จำนวนรวม </th>
                        <th width="5%" style="background-color: #fdf4e0;" class="text-center tw-text-xs md:tw-table-cell"> หน่วย </th>
                        <th width="12%" style="background-color: #fdf4e0;" class="text-right tw-text-xs md:tw-table-cell"> อัตรามาตรฐาน/หน่วย </th>
                        <th width="12%" style="background-color: #fdf4e0;" class="text-right tw-text-xs md:tw-table-cell"> ต้นทุนวัตถุดิบ </th>
                    </tr>
                </thead>
                <tbody v-if="stdcostPrdGroupInvItemItems.length > 0">
                    <template v-for="(stdcostPrdGroupInvItemItem, index) in stdcostPrdGroupInvItemItems">

                        <tr :key="index" v-if="!stdcostPrdGroupInvItemItem.marked_as_deleted">

                            <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdGroupInvItemItem.product_group }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdGroupInvItemItem.product_item_number }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdGroupInvItemItem.item_number }}
                            </td>
                            <td class="text-left md:tw-table-cell">
                                {{ stdcostPrdGroupInvItemItem.item_desc }}
                            </td>
                            <!-- <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdGroupInvItemItem.lot_number }}
                            </td> -->
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdGroupInvItemItem.wip_step }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdGroupInvItemItem.wip_type }}
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdGroupInvItemItem.quantity_used ? Number(stdcostPrdGroupInvItemItem.quantity_used).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdGroupInvItemItem.uom_code }}
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdGroupInvItemItem.std_cost_rate ? Number(stdcostPrdGroupInvItemItem.std_cost_rate).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }}
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdGroupInvItemItem.std_cost_amount ? Number(stdcostPrdGroupInvItemItem.std_cost_amount).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }}
                            </td>

                        </tr>

                    </template>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="10">
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

    props: ["periodYearValue", "stdcostYear", "stdcostPrdGroup", "stdcostPrdGroupInvTotal", "stdcostPrdGroupInvItems"],

    components: { Loading, VueNumeric },

    watch: {

        periodYearValue : function (value) {
            this.periodYear = value;
        },
        stdcostYear : function (value) {
            this.stdcostYearData = value;
        },
        stdcostPrdGroup : function (value) {
            this.stdcostPrdGroupData = value;
        },
        stdcostPrdGroupInvTotal : function (value) {
            this.stdcostPrdGroupInvTotalData = value;
        },
        stdcostPrdGroupInvItems : function (value) {
            this.stdcostPrdGroupInvItemItems = value;
        },

    },

    data() {

        return {

            periodYear: this.periodYearValue,
            stdcostYearData: this.stdcostYear,
            stdcostPrdGroupData: this.stdcostPrdGroup,
            stdcostPrdGroupInvTotalData: this.stdcostPrdGroupInvTotal,
            stdcostPrdGroupInvItemItems: this.stdcostPrdGroupInvItems,
            isLoading: false

        }

    },

    mounted() {

    },

    computed: {

    },
    methods: {


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
