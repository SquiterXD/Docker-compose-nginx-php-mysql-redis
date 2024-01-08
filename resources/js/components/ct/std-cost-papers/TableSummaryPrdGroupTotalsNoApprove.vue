<template>

    <div>

        <div class="table-responsive" style="max-height: 300px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="5%" class="text-center tw-text-xs md:tw-table-cell"> กลุ่มผลิตภัณฑ์ </th>
                        <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> ผลิตภัณฑ์ </th>
                        <th width="15%" class="text-center tw-text-xs md:tw-table-cell"> รายละเอียด </th>
                        <!-- <th width="7%" class="text-center tw-text-xs md:tw-table-cell"> Lot Number </th> -->
                        <th width="11%" class="text-right tw-text-xs md:tw-table-cell"> ต้นทุนวัตถุดิบ </th>
                        <th width="11%" class="text-right tw-text-xs md:tw-table-cell"> ค่าแรง </th>
                        <th width="11%" class="text-right tw-text-xs md:tw-table-cell"> ค่าใช้จ่ายผันแปร </th>
                        <th width="11%" class="text-right tw-text-xs md:tw-table-cell"> ค่าใช้จ่ายคงที่ </th>
                        <th width="11%" class="text-right tw-text-xs md:tw-table-cell"> รวม </th>
                        <th width="10%" class="text-right tw-text-xs md:tw-table-cell">  </th>
                        <th width="5%" class="text-center tw-text-xs md:tw-table-cell"> อนุมัติต้นทุนมาตรฐาน </th>
                    </tr>
                </thead>
                <tbody v-if="stdcostPrdGroupTotalsNoApproveItems.length > 0">
                    <template v-for="(stdcostPrdGroupTotalsNoApproveItems, index) in stdcostPrdGroupTotalsNoApproveItems">

                        <tr :key="index" v-if="!stdcostPrdGroupTotalsNoApproveItems.marked_as_deleted">

                            <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdGroupTotalsNoApproveItems.product_group }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdGroupTotalsNoApproveItems.product_item_number }}
                            </td>
                            <td class="text-left md:tw-table-cell">
                                {{ stdcostPrdGroupTotalsNoApproveItems.product_item_desc }}
                            </td>
                            <!-- <td class="text-center md:tw-table-cell">
                                {{ stdcostPrdGroupTotalItem.product_lot_number }}
                            </td> -->
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdGroupTotalsNoApproveItems.cost_raw_mate ? Number(stdcostPrdGroupTotalsNoApproveItems.cost_raw_mate).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }}
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdGroupTotalsNoApproveItems.wage_cost ? Number(stdcostPrdGroupTotalsNoApproveItems.wage_cost).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }}
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdGroupTotalsNoApproveItems.vary_cost ? Number(stdcostPrdGroupTotalsNoApproveItems.vary_cost).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }}
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdGroupTotalsNoApproveItems.fixed_cost ? Number(stdcostPrdGroupTotalsNoApproveItems.fixed_cost).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }}
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostPrdGroupTotalsNoApproveItems.total_cost ? Number(stdcostPrdGroupTotalsNoApproveItems.total_cost).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }}
                            </td>
                            <td class="text-center text-nowrap">
                               <button class="btn btn-inline-block btn-xs btn-white"
                                    @click="onGetStdcostPrdGroupInvItems($event, stdcostPrdGroupTotalsNoApproveItems)"
                                >
                                    <i class="fa fa-list tw-mr-1"></i> เลือก
                                </button>
                            </td>
                            <td class="text-center text-nowrap">
                               <button class="btn btn-inline-block btn-primary tw-w-full"
                                    @click="onGetcostPrdActiveNewItem($event, stdcostPrdGroupTotalsNoApproveItems)">
                                    <i class="fa fa-list tw-mr-1"></i> อนุมัติต้นทุนมาตรฐาน
                                </button>
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

        <hr>

        <div>

            <div v-if="stdcostPrdGroupInvItemsNoApprove.length > 0">

                <table-summary-prd-group-inv-items
                    :period-year-value="periodYear"
                    :stdcost-year="stdcostYearData"
                    :stdcost-prd-group-total="selectedStdcostPrdGroupTotalItem"
                    :stdcost-prd-group-inv-items="stdcostPrdGroupInvItemsNoApprove"
                >
                </table-summary-prd-group-inv-items>

            </div>

        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableSummaryPrdGroupInvItems from "./TableSummaryPrdGroupInvItems";

export default {

    props: ["periodYearValue", "stdcostYear", "stdcostPrdGroup", "stdcostPrdGroupTotalsNoApprove"],

        components: { Loading, VueNumeric, TableSummaryPrdGroupInvItems },

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
        stdcostPrdGroupTotalsNoApprove : function (value) {
            this.stdcostPrdGroupTotalsNoApproveItems = value;
        },

    },

    data() {

        return {

            periodYear: this.periodYearValue,
            stdcostYearData: this.stdcostYear,
            stdcostPrdGroupData: this.stdcostPrdGroup,
            selectedStdcostPrdGroupTotalItem: null,
            stdcostPrdGroupTotalsNoApproveItems: this.stdcostPrdGroupTotalsNoApprove,
            stdcostPrdGroupInvItemsNoApprove: [],
            isLoading: false,
            productItemNumber: this.productItemNumber,
            ct14VersionNo: this.ct14VersionNo,

        }

    },

    mounted() {

    },

    computed: {

    },
    methods: {

        async onGetStdcostPrdGroupInvItems(e, stdcostPrdGroupTotalsNoApproveItems) {

            this.stdcostPrdGroupInvItemsNoApprove = [];

            this.selectedStdcostPrdGroupTotalItem = stdcostPrdGroupTotalsNoApproveItems;
            this.productItemNumber = this.selectedStdcostPrdGroupTotalItem['product_item_number'];
            this.ct14VersionNo = this.selectedStdcostPrdGroupTotalItem['ct14_version_no']

            await this.getStdcostPrdGroupInvItems(this.stdcostYearData, stdcostPrdGroupTotalsNoApproveItems);

        },

        async getStdcostPrdGroupInvItems(stdcostYearData, stdcostPrdGroupTotalsNoApproveItems) {

            // show loading
            this.isLoading = true;

            var params = {
                product_item_number: this.productItemNumber,
                ct14_allocate_year_id: this.ct14VersionNo,
                period_year: this.periodYear,
                stdcost_year: JSON.stringify(stdcostYearData),
                stdcost_prd_group_total: JSON.stringify(stdcostPrdGroupTotalsNoApproveItems),
            };

            await axios.get(`/ajax/ct/std-cost-papers/summary-prd-group-inv-items`, { params })
                .then(res => {

                    const resData = res.data.data;
                    if (resData.status == "success") {

                        this.stdcostPrdGroupInvItemsNoApprove = resData.stdcost_prd_group_inv_items ? JSON.parse(resData.stdcost_prd_group_inv_items) : [];
                        if (this.stdcostPrdGroupInvItemsNoApprove.length <= 0) {
                            swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูล กลุ่มผลิตภัณฑ์: ${stdcostPrdGroupTotalsNoApproveItems.product_group}, ผลิตภัณฑ์: ${stdcostPrdGroupTotalsNoApproveItems.product_item_number} ${stdcostPrdGroupTotalsNoApproveItems.product_item_desc}`, "error");
                        }

                    } else {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล | ${resData.message}`, "error");
                    }

                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล | ${error.message}`, "error");
                });

            // hide loading
            this.isLoading = false;

        },

        async onGetcostPrdActiveNewItem(e, stdcostPrdGroupTotalsNoApproveItems) {

            this.stdcostPrdGroupInvItemsNoApprove = [];

            this.selectedStdcostPrdGroupTotalItem = stdcostPrdGroupTotalsNoApproveItems;

            await this.getStdcostPrdActiveNewItem();

        },

        async getStdcostPrdActiveNewItem() {

            // show loading
            this.isLoading = true;

            const reqBody = {
                period_year: this.selectedStdcostPrdGroupTotalItem.period_year,
                prdgrp_year_id: this.selectedStdcostPrdGroupTotalItem.prdgrp_year_id,
                allocate_year_id: this.selectedStdcostPrdGroupTotalItem.allocate_year_id,
                cost_code: this.selectedStdcostPrdGroupTotalItem.cost_code,
                plan_version_no: this.selectedStdcostPrdGroupTotalItem.plan_version_no,
                version_no: this.selectedStdcostPrdGroupTotalItem.version_no,
                ct14_version_no: this.selectedStdcostPrdGroupTotalItem.ct14_version_no,
                ct14_allocate_year_id: this.selectedStdcostPrdGroupTotalItem.ct14_allocate_year_id,
                product_inventory_item_id: this.selectedStdcostPrdGroupTotalItem.product_inventory_item_id,
            };

            await axios.post(`/ajax/ct/std-cost-papers/active-new-item`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;
                    const resYearControl = resData.year_control ? JSON.parse(resData.year_control) : null;
                    if (resData.status == "success") {
                        if (resYearControl) {
                            this.selectedStdcostPrdGroupTotalItem.product_inventory_item_id = resYearControl.product_inventory_item_id;
                        }
                    }

                    if (resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลสถานะไม่สำเร็จ | ${resMsg}`, "error");
                    }
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลสถานะไม่สำเร็จ | ${error.message}`, "error");
                });

            // hide loading
            this.isLoading = false;

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
